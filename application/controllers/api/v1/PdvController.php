<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * PdvController — API para o app mobile.
 *
 * Espelha EXATAMENTE a lógica já corrigida e validada em
 * application/controllers/Pdv.php (método finalizar()):
 *   - subtotal bruto, desconto em R$, total = subtotal - desconto
 *   - venda salva com valorTotal=bruto, desconto=valor em R$, valor_desconto=total final
 *   - baixa de estoque respeitando control_estoque / venda_sem_estoque
 *   - lançamento financeiro com valor=total final, desconto=valor em R$, tipo='Receita'
 *
 * Qualquer correção futura no Pdv.php web (ex: outro bug de cálculo) deve
 * ser replicada aqui também — os dois processam a mesma operação de negócio
 * a partir de entradas diferentes (formulário web vs JSON do app).
 */
class PdvController extends REST_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('vendas_model');
        $this->load->model('produtos_model');
    }

    // ══════════════════════════════════════════════════════════════
    // GET /api/v1/pdv/buscar-produto?q=termo
    // ══════════════════════════════════════════════════════════════
    public function buscarProduto_get()
    {
        $this->logged_user();
        $termo = $this->get('q') ?: '';
        if (strlen($termo) < 1) {
            $this->response(['status' => true, 'result' => []], 200);
            return;
        }

        $this->db->select('idProdutos as id, descricao, codDeBarra, precoVenda as preco, estoque, unidade, marca, foto');
        $this->db->group_start();
        $this->db->like('descricao', $termo);
        $this->db->or_like('codDeBarra', $termo);
        $this->db->group_end();
        $this->db->limit(12);
        $produtos = $this->db->get('produtos')->result();

        $this->response(['status' => true, 'result' => $produtos], 200);
    }

    // ══════════════════════════════════════════════════════════════
    // GET /api/v1/pdv/buscar-codigo?codigo=XXXX
    // ══════════════════════════════════════════════════════════════
    public function buscarCodigo_get()
    {
        $this->logged_user();
        $codigo = $this->get('codigo') ?: '';
        if (!$codigo) {
            $this->response(['status' => false, 'message' => 'Código não informado.'], 400);
            return;
        }

        $produto = $this->db
            ->select('idProdutos as id, descricao, codDeBarra, precoVenda as preco, estoque, unidade')
            ->where('codDeBarra', $codigo)
            ->get('produtos')->row();

        if (!$produto) {
            $this->response(['status' => false, 'message' => 'Produto não encontrado.'], 404);
            return;
        }
        $this->response(['status' => true, 'result' => $produto], 200);
    }

    // ══════════════════════════════════════════════════════════════
    // POST /api/v1/pdv/finalizar
    // Body esperado (JSON):
    // {
    //   "itens": [{"id":1,"qtd":2,"preco":29.90}, ...],
    //   "clientes_id": 5 | null,
    //   "forma_pgto": "Dinheiro" | "PIX" | "Débito" | "Crédito",
    //   "desconto": 4.50,
    //   "tipo_desconto": "real" | "percent",
    //   "valor_recebido": 24.50,
    //   "observacoes": "...",
    //   "criar_lancamento": true
    // }
    // ══════════════════════════════════════════════════════════════
    public function finalizar_post()
    {
        $this->logged_user();
        if (!$this->permission->checkPermission($this->logged_user()->level, 'aVenda')) {
            $this->response(['status' => false, 'message' => 'Sem permissão para usar o PDV.'], 403);
            return;
        }

        $_POST = (array) json_decode(file_get_contents('php://input'), true);

        $itens      = $this->post('itens') ?: [];
        $clienteId  = $this->post('clientes_id') ?: null;
        $formaPgto  = $this->post('forma_pgto') ?: '';
        $desconto   = floatval($this->post('desconto') ?: 0);
        $tipoDesc   = $this->post('tipo_desconto') ?: 'real';
        $valorReceb = floatval($this->post('valor_recebido') ?: 0);
        $obs        = $this->post('observacoes') ?: '';
        $criarLanc  = $this->post('criar_lancamento');
        $criarLanc  = $criarLanc === null ? true : (bool)$criarLanc;

        if (empty($itens)) {
            $this->response(['status' => false, 'message' => 'Carrinho vazio.'], 400);
            return;
        }

        // ── Mesma lógica de cálculo do Pdv.php web ──────────────────────
        $subtotal = 0;
        foreach ($itens as $item) {
            $subtotal += floatval($item['preco'] ?? 0) * floatval($item['qtd'] ?? 1);
        }

        $valorDesconto = 0;
        if ($desconto > 0) {
            $valorDesconto = $tipoDesc === 'percent'
                ? $subtotal * ($desconto / 100)
                : $desconto;
            $valorDesconto = min($valorDesconto, $subtotal);
        }
        $total = max(0, $subtotal - $valorDesconto);
        $descontoEmReais = $valorDesconto;

        // ── Resolver cliente (igual ao web: aceita venda sem cliente) ───
        if ($clienteId) {
            $clienteNome = 'Consumidor Final';
            $cli = $this->db->where('idClientes', $clienteId)->get('clientes')->row();
            if ($cli) $clienteNome = $cli->nomeCliente;
        } else {
            $cons = $this->db->where('nomeCliente', 'Consumidor Final')->get('clientes')->row();
            if ($cons) {
                $clienteId   = $cons->idClientes;
                $clienteNome = 'Consumidor Final';
            } else {
                $this->db->insert('clientes', [
                    'nomeCliente'   => 'Consumidor Final',
                    'documento'     => '00000000000',
                    'telefone'      => '00000000000',
                    'email'         => '',
                    'dataCadastro'  => date('Y-m-d'),
                    'senha'         => password_hash('consumidor', PASSWORD_DEFAULT),
                    'pessoa_fisica' => 1,
                    'fornecedor'    => 0,
                    'bloqueado'     => 0,
                ]);
                $clienteId   = $this->db->insert_id();
                $clienteNome = 'Consumidor Final';
            }
        }

        // ── Nomes dos produtos para o resumo da venda ───────────────────
        $nomeProdutos = [];
        foreach ($itens as $itemNome) {
            $prod = $this->db->where('idProdutos', (int)($itemNome['id'] ?? 0))->get('produtos')->row();
            if ($prod) $nomeProdutos[] = $prod->descricao;
        }
        $produtosStr = implode(', ', array_slice($nomeProdutos, 0, 3));
        if (count($nomeProdutos) > 3) $produtosStr .= ' +' . (count($nomeProdutos) - 3);

        // ── Criar venda — mesma convenção de campos do web já corrigida ─
        $vendaData = [
            'clientes_id'    => $clienteId,
            'usuarios_id'    => $this->session->userdata('id_admin') ?: $this->logged_user()->id,
            'dataVenda'      => date('Y-m-d H:i:s'),
            'valorTotal'     => round($subtotal, 2),         // bruto
            'desconto'       => round($descontoEmReais, 2),  // valor descontado em R$
            'valor_desconto' => round($total, 2),             // total final
            'tipo_desconto'  => $tipoDesc,
            'status'         => 'Faturado',
            'faturado'       => 1,
            'observacoes'    => $obs ?: 'PDV App — ' . date('d/m/Y H:i'),
        ];
        try {
            $cols = array_column($this->db->query("SHOW COLUMNS FROM `vendas`")->result_array(), 'Field');
            if (in_array('produtos', $cols)) $vendaData['produtos'] = $produtosStr;
        } catch (Exception $e) {}

        $idVenda = $this->vendas_model->add('vendas', $vendaData, true);
        if (!$idVenda) {
            $dbErr = $this->db->error();
            $this->response(['status' => false, 'message' => 'Erro ao criar venda: ' . ($dbErr['message'] ?? 'desconhecido')], 500);
            return;
        }

        // ── Itens + baixa de estoque (mesma regra do web) ───────────────
        $this->load->model('estoque_model');
        $configCtrlEstoque = $this->db->select('valor')->where('config', 'control_estoque')->get('configuracoes')->row();
        $configSemEstoque  = $this->db->select('valor')->where('config', 'venda_sem_estoque')->get('configuracoes')->row();
        $controlEstoque = $configCtrlEstoque ? (int)$configCtrlEstoque->valor : 1;
        $modoSemEstoque = $configSemEstoque  ? (int)$configSemEstoque->valor  : 0;

        foreach ($itens as $item) {
            $prodId = (int)($item['id'] ?? 0);
            $qtd    = floatval($item['qtd'] ?? 1);
            $preco  = floatval($item['preco'] ?? 0);

            if ($controlEstoque && $modoSemEstoque === 0) {
                $prod = $this->produtos_model->getById($prodId);
                if ($prod && $prod->estoque < $qtd) {
                    // Desfaz a venda criada, igual ao comportamento web
                    $this->db->where('idVendas', $idVenda)->delete('vendas');
                    $this->response([
                        'status'  => false,
                        'message' => "Estoque insuficiente para: {$prod->descricao} (disponível: {$prod->estoque})",
                    ], 400);
                    return;
                }
            }

            $this->vendas_model->add('itens_de_vendas', [
                'vendas_id'   => $idVenda,
                'produtos_id' => $prodId,
                'quantidade'  => (int)$qtd,
                'preco'       => $preco,
                'subTotal'    => round($qtd * $preco, 2),
            ]);

            if ($controlEstoque) {
                if (method_exists($this->estoque_model, 'registrar')) {
                    $this->estoque_model->registrar($prodId, 'saida', 'venda', $idVenda, $qtd, 'PDV App Venda #' . $idVenda);
                } else {
                    $this->db->where('idProdutos', $prodId)
                        ->set('estoque', "estoque - {$qtd}", false)
                        ->update('produtos');
                }
            }
        }

        $troco = max(0, $valorReceb - $total);

        // ── Lançamento financeiro — mesma convenção já corrigida ────────
        if ($criarLanc) {
            $descLanc = 'PDV App Venda #' . $idVenda . ' — ' . $clienteNome;
            if ($descontoEmReais > 0) {
                $descLanc .= ' (Desconto: R$ ' . number_format($descontoEmReais, 2, ',', '.') . ')';
            }

            $this->db->insert('lancamentos', [
                'descricao'          => $descLanc,
                'clientes_id'        => $clienteId,
                'usuarios_id'        => $this->session->userdata('id_admin') ?: $this->logged_user()->id,
                'vendas_id'          => $idVenda,
                'valor'              => abs($total),
                'desconto'           => round($descontoEmReais, 2),
                'tipo'               => 'Receita',
                'forma_pgto'         => $formaPgto ?: 'Dinheiro',
                'data_vencimento'    => date('Y-m-d'),
                'baixado'            => ($valorReceb >= $total) ? 1 : 0,
                'data_pagamento'     => ($valorReceb >= $total) ? date('Y-m-d') : null,
                'cliente_fornecedor' => $clienteNome,
                'observacoes'        => 'PDV App — ' . date('d/m/Y H:i'),
            ]);
        }

        log_info("PDV App: Venda #{$idVenda} finalizada. Total: R$ {$total}. Forma: {$formaPgto}");

        // Notificação push (OneSignal)
        $this->load->helper('onesignal');
        onesignal_nova_venda($idVenda, $total);

        $this->response([
            'status'  => true,
            'message' => 'Venda finalizada com sucesso!',
            'result'  => [
                'idVenda' => $idVenda,
                'total'   => round($total, 2),
                'troco'   => round($troco, 2),
            ],
        ], 200);
    }
}
