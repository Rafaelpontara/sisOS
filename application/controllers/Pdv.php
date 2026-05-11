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
        $this->data['view']    = 'pdv/pdv';
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
        $desconto    = floatval(str_replace(['.', ','], ['', '.'], $this->input->post('desconto') ?: '0'));
        $tipoDesc    = $this->input->post('tipo_desconto') ?: null;
        $valorReceb  = floatval(str_replace(['.', ','], ['', '.'], $this->input->post('valor_recebido') ?: '0'));
        $obs         = $this->input->post('observacoes');

        if (empty($itens)) {
            echo json_encode(['result' => false, 'messages' => 'Carrinho vazio.']); return;
        }

        // Calcular total
        $subtotal = 0;
        foreach ($itens as $item) {
            $subtotal += floatval($item['preco']) * floatval($item['qtd']);
        }
        $valorDesconto = 0;
        if ($desconto > 0) {
            $valorDesconto = $tipoDesc === 'percent' ? $subtotal * ($desconto / 100) : $desconto;
        }
        $total = $subtotal - $valorDesconto;

        // Criar venda
        $vendaData = [
            'clientes_id'    => $clienteId,
            'usuarios_id'    => $this->session->userdata('id_admin'),
            'dataVenda'      => date('Y-m-d'),
            'valorTotal'     => $total,
            'desconto'       => $desconto,
            'valor_desconto' => $valorDesconto > 0 ? $total : 0,
            'tipo_desconto'  => $tipoDesc,
            'forma_pgto'     => $formaPgto,
            'status'         => 'Concluída',
            'observacoes'    => $obs ?: 'PDV - ' . date('d/m/Y H:i'),
            'pdv'            => 1,
        ];

        $idVenda = $this->vendas_model->add('vendas', $vendaData, true);
        if (!$idVenda) {
            echo json_encode(['result' => false, 'messages' => 'Erro ao criar venda.']); return;
        }

        // Adicionar itens e baixar estoque
        $this->load->model('estoque_model');
        $modoSemEstoque = (int)($this->data['configuration']['venda_sem_estoque'] ?? 0);

        foreach ($itens as $item) {
            $prodId  = (int)$item['id'];
            $qtd     = floatval($item['qtd']);
            $preco   = floatval($item['preco']);

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
                'descricao'   => $item['descricao'],
                'quantidade'  => $qtd,
                'preco'       => $preco,
                'subTotal'    => $qtd * $preco,
            ];
            $this->vendas_model->add('itens_de_vendas', $itemData);

            // Baixar estoque com movimentação
            if ($this->data['configuration']['control_estoque']) {
                $this->estoque_model->registrar($prodId, 'saida', 'venda', $idVenda, $qtd, 'PDV Venda #' . $idVenda);
            }
        }

        // Troco
        $troco = max(0, $valorReceb - $total);

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
        $this->data['itens']    = $this->db->where('vendas_id', $idVenda)->get('itens_de_vendas')->result();
        $this->data['emitente'] = $this->sisos_model->getEmitente();
        $this->load->view('pdv/cupom', $this->data);
    }

    /** Relatório de vendas do PDV do dia */
    public function relatorio()
    {
        if (!$this->permission->checkPermission($this->session->userdata('permissao'), 'vVenda')) {
            redirect(base_url());
        }
        $data = $this->input->get('data') ?: date('Y-m-d');
        $this->db->where('DATE(dataVenda)', $data)->where('pdv', 1);
        $this->data['vendas']    = $this->db->get('vendas')->result();
        $this->data['data']      = $data;
        $this->data['menuPdv']   = true;
        $this->data['view']      = 'pdv/relatorio';
        return $this->layout();
    }
}
