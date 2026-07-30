<?php if (!defined('BASEPATH')) { exit('No direct script access allowed'); }

class Pdv extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('vendas_model');
        $this->load->model('produtos_model');
        $this->load->model('clientes_model');
        $this->load->model('sisos_model');
    }

    /** Tela principal do PDV */
    public function index()
    {
        if (!$this->permission->checkPermission($this->session->userdata('permissao'), 'aVenda')) {
            $this->session->set_flashdata('error', 'Sem permissão para acessar o PDV.');
            redirect(base_url());
        }

        $this->data['menuPdv'] = true;

        // Verificar se controle de caixa está ativo
        if (!empty($this->data['configuration']['pdv_caixa_enabled']) &&
            $this->data['configuration']['pdv_caixa_enabled'] == '1') {
            $sessaoAberta = $this->db
                ->where('status', 'aberto')
                ->where('usuarios_id', $this->session->userdata('id_admin'))
                ->get('caixa_sessoes')->row();
            if (!$sessaoAberta) {
                $this->session->set_flashdata('error', 'Abra o caixa antes de usar o PDV.');
                redirect(site_url('caixa'));
                return;
            }
            $this->data['sessao_caixa'] = $sessaoAberta;
        }

        $this->data['view'] = 'pdv/pdv';
        return $this->layout();
    }

    /** Busca produto por código de barras ou descrição (AJAX) */
    public function buscarProduto()
    {
        $termo = $this->input->get('q');
        if (!$termo) { echo json_encode([]); return; }

        $this->db->select('idProdutos as id, descricao, codDeBarra, precoVenda as preco, estoque, unidade, marca, foto');
        $this->db->group_start();
        $this->db->like('descricao', $termo);
        $this->db->or_like('codDeBarra', $termo);
        $this->db->group_end();
        $this->db->limit(12);
        $produtos = $this->db->get('produtos')->result();

        header('Content-Type: application/json');
        echo json_encode($produtos);
    }

    /** Busca produto por código de barras exato */
    public function buscarCodigo()
    {
        $codigo = $this->input->get('codigo');
        if (!$codigo) { echo json_encode(null); return; }

        $produto = $this->db->where('codDeBarra', $codigo)->get('produtos')->row();
        header('Content-Type: application/json');
        echo json_encode($produto);
    }

    /** Finaliza a venda (AJAX - recebe carrinho JSON) */
    public function finalizar()
    {
        if (!$this->permission->checkPermission($this->session->userdata('permissao'), 'aVenda')) {
            echo json_encode(['result' => false, 'messages' => 'Sem permissão.']); return;
        }

        $itens       = json_decode($this->input->post('itens'), true);
        $clienteId   = $this->input->post('clientes_id') ?: null;
        $formaPgto   = $this->input->post('forma_pgto');
        // Converte valor numérico do JS (ponto decimal) para float sem quebrar
        $desconto   = floatval(str_replace(',', '.', preg_replace('/\.(?=.*\.)/', '', $this->input->post('desconto') ?: '0')));
        $tipoDesc   = $this->input->post('tipo_desconto') ?: null;
        $valorReceb = floatval(str_replace(',', '.', preg_replace('/\.(?=.*\.)/', '', $this->input->post('valor_recebido') ?: '0')));
        $obs         = $this->input->post('observacoes');

        if (empty($itens)) {
            echo json_encode(['result' => false, 'messages' => 'Carrinho vazio.']); return;
        }

        // Calcular total
        $subtotal = 0;
        foreach ($itens as $item) {
            $subtotal += floatval(str_replace(',', '.', $item['preco'])) * floatval(str_replace(',', '.', $item['qtd']));
        }
        $valorDesconto = 0;
        if ($desconto > 0) {
            $valorDesconto = $tipoDesc === 'percent'
                ? $subtotal * ($desconto / 100)
                : $desconto;
            // Garante que o desconto não ultrapassa o subtotal
            $valorDesconto = min($valorDesconto, $subtotal);
        }
        $total = max(0, $subtotal - $valorDesconto);

        // Resolver cliente — clientes_id tem FK NOT NULL no banco
        if ($clienteId) {
            $clienteNome = 'Consumidor Final';
            $cli = $this->db->where('idClientes', $clienteId)->get('clientes')->row();
            if ($cli) $clienteNome = $cli->nomeCliente;
        } else {
            // Busca ou cria Consumidor Final
            $cons = $this->db->where('nomeCliente', 'Consumidor Final')->get('clientes')->row();
            if ($cons) {
                $clienteId   = $cons->idClientes;
                $clienteNome = 'Consumidor Final';
            } else {
                $this->db->insert('clientes', [
                    'nomeCliente'  => 'Consumidor Final',
                    'documento'    => '00000000000',
                    'telefone'     => '00000000000',
                    'email'        => '',
                    'dataCadastro' => date('Y-m-d'),
                    'senha'        => password_hash('consumidor', PASSWORD_DEFAULT),
                    'pessoa_fisica'=> 1,
                    'fornecedor'   => 0,
                    'bloqueado'    => 0,
                ]);
                $clienteId   = $this->db->insert_id();
                $clienteNome = 'Consumidor Final';
            }
        }

        // Montar lista de produtos para exibição na listagem
        $nomeProdutos = [];
        foreach ($itens as $itemNome) {
            $prod = $this->db->where('idProdutos', (int)$itemNome['id'])->get('produtos')->row();
            if ($prod) $nomeProdutos[] = $prod->descricao;
        }
        $produtosStr = implode(', ', array_slice($nomeProdutos, 0, 3));
        if (count($nomeProdutos) > 3) $produtosStr .= ' +' . (count($nomeProdutos) - 3);

        // Criar venda — somente colunas que existem na tabela vendas
        // valor_desconto = total final após desconto (o que a view exibe como Total)
        // desconto = valor do desconto em R$ (para exibir na linha Desconto)
        $descontoEmReais = $valorDesconto; // valor que foi descontado
        $totalFinal      = $total;         // total que o cliente paga

        $vendaData = [
            'clientes_id'    => $clienteId,
            'usuarios_id'    => $this->session->userdata('id_admin'),
            'dataVenda'      => date('Y-m-d H:i:s'), // salvar com horário
            'valorTotal'     => $subtotal,            // subtotal bruto sem desconto
            'desconto'       => round($descontoEmReais, 2), // valor do desconto em R$
            'valor_desconto' => round($totalFinal, 2),      // total final após desconto
            'tipo_desconto'  => $tipoDesc ?? 'real',
            'status'         => 'Faturado',
            'faturado'       => 1,
            'observacoes'    => $obs ?: 'PDV - ' . date('d/m/Y H:i'),
        ];
        // Adicionar colunas opcionais se existirem no banco
        try {
            $cols = array_column($this->db->query("SHOW COLUMNS FROM `vendas`")->result_array(), 'Field');
            if (in_array('produtos', $cols)) $vendaData['produtos'] = $produtosStr;
            if (in_array('tecnico',  $cols)) $vendaData['tecnico']  = $this->session->userdata('nome');
        } catch (Exception $e) {}

        $idVenda = $this->vendas_model->add('vendas', $vendaData, true);
        if (!$idVenda) {
            $dbErr = $this->db->error();
            echo json_encode(['result' => false, 'messages' => 'Erro ao criar venda: ' . ($dbErr['message'] ?? 'desconhecido')]); return;
        }

        // Adicionar itens e baixar estoque
        $this->load->model('estoque_model');
        $modoSemEstoque = (int)($this->data['configuration']['venda_sem_estoque'] ?? 0);

        foreach ($itens as $item) {
            $prodId  = (int)$item['id'];
            $qtd   = floatval(str_replace(',', '.', $item['qtd']));
            $preco = floatval(str_replace(',', '.', $item['preco']));

            // Verificar estoque
            if ($this->data['configuration']['control_estoque'] && $modoSemEstoque === 0) {
                $prod = $this->produtos_model->getById($prodId);
                if ($prod && $prod->estoque < $qtd) {
                    // Desfaz a venda criada
                    $this->db->where('idVendas', $idVenda)->delete('vendas');
                    echo json_encode(['result' => false, 'messages' => "Estoque insuficiente para: {$prod->descricao} (disponível: {$prod->estoque})"]);
                    return;
                }
            }

            $itemData = [
                'vendas_id'   => $idVenda,
                'produtos_id' => $prodId,
                // 'descricao' removido — coluna não existe em itens_de_vendas
                'quantidade'  => (int)$qtd,
                'preco'       => $preco,
                'subTotal'    => round($qtd * $preco, 2),
            ];
            $this->vendas_model->add('itens_de_vendas', $itemData);

            // Baixar estoque com movimentação
            if ($this->data['configuration']['control_estoque']) {
                if (method_exists($this->estoque_model, 'registrar')) {
                    $this->estoque_model->registrar($prodId, 'saida', 'venda', $idVenda, $qtd, 'PDV Venda #' . $idVenda);
                } else {
                    // Fallback: baixa direto no campo estoque
                    $this->db->where('idProdutos', $prodId)
                             ->set('estoque', "estoque - {$qtd}", false)
                             ->update('produtos');
                }
            }
        }

        // Troco
        $troco = max(0, $valorReceb - $total);

        // ── Lançamento Financeiro ───────────────────────────────────
        $criarLanc = $this->input->post('criar_lancamento');
        if ($criarLanc !== '0') {
            $descLanc = 'PDV Venda #' . $idVenda;
            if (isset($clienteNome)) $descLanc .= ' — ' . $clienteNome;
            if ($descontoEmReais > 0) {
                $descLanc .= ' (Desconto: R$ ' . number_format($descontoEmReais, 2, ',', '.') . ')';
            }

            $this->db->insert('lancamentos', [
                'descricao'          => $descLanc,
                'clientes_id'        => $clienteId,
                'usuarios_id'        => $this->session->userdata('id_admin'),
                'vendas_id'          => $idVenda,
                'valor'              => abs($total),
                'desconto'           => round($descontoEmReais, 2),
                'tipo'               => 'Receita',
                'forma_pgto'         => $formaPgto ?: 'Dinheiro',
                'data_vencimento'    => date('Y-m-d'),
                'baixado'            => ($valorReceb >= $total) ? 1 : 0,
                'data_pagamento'     => ($valorReceb >= $total) ? date('Y-m-d') : null,
                'cliente_fornecedor' => $clienteNome ?? 'Consumidor Final',
                'observacoes'        => 'PDV — ' . date('d/m/Y H:i'),
            ]);
        }
        // ── Fim Lançamento ───────────────────────────────────────────

        // Registrar no Caixa se módulo estiver ativo
        if (!empty($this->data['configuration']['pdv_caixa_enabled']) &&
            $this->data['configuration']['pdv_caixa_enabled'] == '1') {
            $sessaoCaixa = $this->db
                ->where('status', 'aberto')
                ->where('usuarios_id', $this->session->userdata('id_admin'))
                ->get('caixa_sessoes')->row();
            if ($sessaoCaixa) {
                $this->db->insert('caixa_movimentos', [
                    'sessao_id'     => $sessaoCaixa->id,
                    'usuarios_id'   => $this->session->userdata('id_admin'),
                    'tipo'          => 'venda',
                    'valor'         => round($total, 2),
                    'descricao'     => 'Venda #' . str_pad($idVenda, 4, '0', STR_PAD_LEFT),
                    'forma_pgto'    => $formaPgto ?: 'Dinheiro',
                    'referencia_id' => $idVenda,
                    'created_at'    => date('Y-m-d H:i:s'),
                ]);
            }
        }

        log_info("PDV: Venda #{$idVenda} finalizada. Total: R$ {$total}. Forma: {$formaPgto}");

        echo json_encode([
            'result'   => true,
            'idVenda'  => $idVenda,
            'total'    => number_format($total, 2, ',', '.'),
            'troco'    => number_format($troco, 2, ',', '.'),
            'mensagem' => 'Venda finalizada com sucesso!',
        ]);
    }

    /** Página de impressão do cupom PDV */
    public function cupom($idVenda = null)
    {
        if (!$idVenda) redirect(site_url('pdv'));

        $this->data['venda']    = $this->vendas_model->getById($idVenda);
        $this->data['emitente'] = $this->sisos_model->getEmitente();

        // Buscar itens COM nome e código de barras do produto
        $this->data['itens'] = $this->db
            ->select('iv.*, p.descricao, p.codDeBarra, p.unidade')
            ->from('itens_de_vendas iv')
            ->join('produtos p', 'p.idProdutos = iv.produtos_id', 'left')
            ->where('iv.vendas_id', $idVenda)
            ->get()->result();

        // Busca forma de pagamento no lançamento vinculado
        $lanc = $this->db->select('forma_pgto, valor, baixado')
                         ->where('vendas_id', $idVenda)
                         ->get('lancamentos')->row();
        $this->data['forma_pgto']    = $lanc ? ($lanc->forma_pgto ?? '—') : '—';
        $this->data['valor_recebido'] = $lanc ? $lanc->valor : 0;

        $this->load->view('pdv/cupom', $this->data);
    }

    /** Relatório de vendas do PDV do dia */
    public function relatorio()
    {
        if (!$this->permission->checkPermission($this->session->userdata('permissao'), 'vVenda')) {
            redirect(base_url());
        }
        $data = $this->input->get('data') ?: date('Y-m-d');

        // Query com JOIN para buscar cliente, vendedor e forma_pgto do lançamento
        $sql = "SELECT
                       v.idVendas, v.clientes_id, v.usuarios_id, v.dataVenda,
                       v.status, v.faturado, v.garantia, v.observacoes,
                       v.forma_pgto, v.desconto, v.tipo_desconto,
                       v.valor_desconto, v.valorTotal, v.lancamentos_id,
                       c.nomeCliente,
                       u.nome AS nomeVendedor,
                       MAX(l.forma_pgto) AS forma_pgto_lancamento,
                       v.dataVenda AS dataVendaCompleta
                FROM vendas v
                LEFT JOIN clientes   c ON c.idClientes  = v.clientes_id
                LEFT JOIN usuarios   u ON u.idUsuarios  = v.usuarios_id
                LEFT JOIN lancamentos l ON l.vendas_id  = v.idVendas
                WHERE DATE(v.dataVenda) = ?
                GROUP BY v.idVendas, v.clientes_id, v.usuarios_id, v.dataVenda,
                         v.status, v.faturado, v.garantia, v.observacoes,
                         v.forma_pgto, v.desconto, v.tipo_desconto,
                         v.valor_desconto, v.valorTotal, v.lancamentos_id,
                         c.nomeCliente, u.nome
                ORDER BY v.idVendas DESC";
        $vendas = $this->db->query($sql, [$data])->result();

        foreach ($vendas as &$v) {

            // ── Vendedor ─────────────────────────────────────────
            $v->nome = $v->nomeVendedor ?? '—';

            // ── Forma de pagamento ────────────────────────────────
            // Prioridade: coluna forma_pgto da venda → lançamento → 'Não informado'
            if (empty($v->forma_pgto)) {
                $v->forma_pgto = $v->forma_pgto_lancamento ?? '';
            }
            if (empty($v->forma_pgto)) {
                $lanc = $this->db->select('forma_pgto')
                    ->where('vendas_id', $v->idVendas)
                    ->get('lancamentos')->row();
                $v->forma_pgto = $lanc->forma_pgto ?? '';
            }
            if (empty($v->forma_pgto)) $v->forma_pgto = 'Não informado';

            // ── Horário ───────────────────────────────────────────
            // Extrair hora de múltiplas fontes
            if (!empty($v->dataVenda) && strlen($v->dataVenda) > 10) {
                $v->horaVenda = date('H:i', strtotime($v->dataVenda));
            } elseif (!empty($v->observacoes) && preg_match('/(\d{2}:\d{2})/', $v->observacoes, $mH)) {
                $v->horaVenda = $mH[1];
            } else {
                $lancObs = $this->db->select('observacoes')
                    ->where('vendas_id', $v->idVendas)
                    ->get('lancamentos')->row();
                if ($lancObs && preg_match('/(\d{2}:\d{2})/', $lancObs->observacoes ?? '', $mL)) {
                    $v->horaVenda = $mL[1];
                } else {
                    $v->horaVenda = '—';
                }
            }

            // ── Produtos ──────────────────────────────────────────
            if (empty($v->produtos)) {
                $itens = $this->db->select('produtos.descricao')
                    ->from('itens_de_vendas')
                    ->join('produtos', 'produtos.idProdutos = itens_de_vendas.produtos_id', 'left')
                    ->where('itens_de_vendas.vendas_id', $v->idVendas)
                    ->limit(3)->get()->result();
                $nomes = array_map(fn($i) => $i->descricao ?? '—', $itens);
                $v->produtos = implode(', ', $nomes) ?: '—';
            }

            // ── Total correto com desconto ────────────────────────
            // Após a correção do salvamento, a tabela `vendas` já guarda:
            //   valorTotal     = subtotal bruto
            //   desconto       = valor descontado em R$
            //   valor_desconto = total final pago
            // Usamos os campos da própria venda; só recorremos aos itens
            // como fallback para vendas antigas, salvas antes da correção.
            $v->totalBruto   = floatval($v->valorTotal ?? 0);
            $v->descontoReal = floatval($v->desconto ?? 0);
            $v->totalFinal   = floatval($v->valor_desconto ?? 0);

            // Fallback robusto para registros antigos/inconsistentes
            if ($v->totalBruto <= 0 && $v->totalFinal <= 0) {
                $tot = $this->db->select_sum('subTotal')
                    ->where('vendas_id', $v->idVendas)
                    ->get('itens_de_vendas')->row();
                $subtotalItens = floatval($tot->subTotal ?? 0);
                $v->totalBruto = $subtotalItens;
                $v->totalFinal = $subtotalItens - $v->descontoReal;
            } elseif ($v->totalFinal <= 0) {
                // Tem bruto mas não tem total final: recalcula
                $v->totalFinal = $v->totalBruto - $v->descontoReal;
            } elseif ($v->totalBruto <= 0) {
                // Tem total final mas não tem bruto: recalcula
                $v->totalBruto = $v->totalFinal + $v->descontoReal;
            }

            // Compatibilidade com a view
            $v->valorTotal     = $v->totalBruto;
            $v->valor_desconto = $v->totalFinal;
            $v->desconto       = $v->descontoReal;
        }
        unset($v);

        $this->data['vendas']  = $vendas;
        $this->data['data']    = $data;
        $this->data['menuPdv'] = true;
        $this->data['view']    = 'pdv/relatorio';
        return $this->layout();
    }
}
