<?php if (!defined('BASEPATH')) { exit('No direct script access allowed'); }

class Estoque extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('estoque_model');
        $this->load->model('produtos_model');
    }

    public function index() { return $this->movimentacoes(); }

    /** Listagem de todas as movimentações */
    public function movimentacoes()
    {
        if (!$this->permission->checkPermission($this->session->userdata('permissao'), 'vCompra')) {
            $this->session->set_flashdata('error', 'Sem permissão.');
            redirect(base_url());
        }

        $this->load->library('pagination');
        $where = [];
        $pesquisa = $this->input->get('pesquisa');
        $tipo     = $this->input->get('tipo');
        $origem   = $this->input->get('origem');
        $de       = $this->input->get('data');
        $ate      = $this->input->get('data2');
        $prodId   = $this->input->get('produto_id');

        if ($pesquisa) $where['pesquisa']    = $pesquisa;
        if ($tipo)     $where['tipo']        = $tipo;
        if ($origem)   $where['origem']      = $origem;
        if ($prodId)   $where['produtos_id'] = $prodId;
        if ($de)  { $p = explode('/', $de);  $where['de']  = count($p)==3 ? "$p[2]-$p[1]-$p[0]" : $de; }
        if ($ate) { $p = explode('/', $ate); $where['ate'] = count($p)==3 ? "$p[2]-$p[1]-$p[0]" : $ate; }

        $perPage = (int)($this->data['configuration']['per_page'] ?? 20);
        $config  = [
            'base_url'   => site_url('estoque/movimentacoes'),
            'total_rows' => $this->estoque_model->countMovimentacoes($where),
            'per_page'   => $perPage,
        ];
        $this->pagination->initialize($config);

        $this->data['results']        = $this->estoque_model->getMovimentacoes($perPage, $this->uri->segment(3), $where);
        $this->data['abaixo_minimo']  = $this->estoque_model->getAbaixoMinimo();
        $this->data['menuEstoque']    = true;
        $this->data['view']           = 'estoque/movimentacoes';
        return $this->layout();
    }

    /** Inventário geral */
    public function inventario()
    {
        if (!$this->permission->checkPermission($this->session->userdata('permissao'), 'vCompra')) {
            redirect(base_url());
        }
        $pesquisa = $this->input->get('pesquisa');
        $this->data['results']     = $this->estoque_model->getResumoEstoque($pesquisa);
        $this->data['abaixo_minimo'] = $this->estoque_model->getAbaixoMinimo();
        $this->data['menuEstoque'] = true;
        $this->data['view']        = 'estoque/inventario';
        return $this->layout();
    }

    /** Ajuste manual de estoque via AJAX */
    public function ajustar()
    {
        if (!$this->permission->checkPermission($this->session->userdata('permissao'), 'aCompra')) {
            echo json_encode(['result' => false, 'messages' => 'Sem permissão.']);
            return;
        }
        $produtoId  = $this->input->post('produtos_id');
        $tipo       = $this->input->post('tipo'); // entrada|saida
        $quantidade = floatval(str_replace(',', '.', $this->input->post('quantidade')));
        $obs        = $this->input->post('observacao');

        if (!$produtoId || !$tipo || $quantidade <= 0) {
            echo json_encode(['result' => false, 'messages' => 'Dados inválidos.']);
            return;
        }

        $novoEstoque = $this->estoque_model->registrar($produtoId, $tipo, 'ajuste', null, $quantidade, $obs);
        echo json_encode(['result' => true, 'estoque' => $novoEstoque]);
    }

    /** Histórico de um produto específico (AJAX) */
    public function historicoProduto()
    {
        $id = $this->input->get('id');
        if (!$id) { echo json_encode([]); return; }
        $movs = $this->estoque_model->getMovimentacoes(50, 0, ['produtos_id' => $id]);
        $out = [];
        foreach ($movs as $m) {
            $out[] = [
                'data'     => date('d/m/Y H:i', strtotime($m->created_at)),
                'tipo'     => $m->tipo,
                'origem'   => $m->origem,
                'qtd'      => $m->quantidade,
                'antes'    => $m->estoque_antes,
                'depois'   => $m->estoque_depois,
                'obs'      => $m->observacao,
                'usuario'  => $m->nomeUsuario,
            ];
        }
        header('Content-Type: application/json');
        echo json_encode($out);
    }

    /** Registrar avaria/perda de produto */
    public function registrarAvaria()
    {
        if (!$this->permission->checkPermission($this->session->userdata('permissao'), 'aCompra')) {
            echo json_encode(['result' => false, 'messages' => 'Sem permissão.']); return;
        }
        $produtoId  = $this->input->post('produtos_id');
        $quantidade = floatval(str_replace(',', '.', $this->input->post('quantidade') ?: 1));
        $motivo     = $this->input->post('motivo');
        $obs        = $this->input->post('observacao');
        $data       = $this->input->post('data') ?: date('Y-m-d');

        if (!$produtoId || $quantidade <= 0) {
            echo json_encode(['result' => false, 'messages' => 'Produto e quantidade são obrigatórios.']); return;
        }

        // Registra na tabela avarias
        $this->db->insert('avarias', [
            'produtos_id' => $produtoId,
            'quantidade'  => $quantidade,
            'motivo'      => $motivo,
            'observacao'  => $obs,
            'usuarios_id' => $this->session->userdata('id_admin'),
            'data'        => implode('-', array_reverse(explode('/', $data))),
        ]);

        // Registra movimentação de saída no estoque
        $novoEstoque = $this->estoque_model->registrar($produtoId, 'saida', 'avaria', $this->db->insert_id(), $quantidade, 'Avaria: ' . $motivo);

        echo json_encode(['result' => true, 'estoque' => $novoEstoque]);
    }

    /** Lista avarias com filtros */
    public function avarias()
    {
        if (!$this->permission->checkPermission($this->session->userdata('permissao'), 'vCompra')) {
            redirect(base_url());
        }
        $this->db->select('avarias.*, produtos.descricao as nomeProduto, usuarios.nome as nomeUsuario');
        $this->db->from('avarias');
        $this->db->join('produtos', 'produtos.idProdutos = avarias.produtos_id', 'left');
        $this->db->join('usuarios', 'usuarios.idUsuarios = avarias.usuarios_id', 'left');
        $this->db->order_by('avarias.created_at', 'DESC');
        $this->data['avarias'] = $this->db->get()->result();
        $this->data['produtos'] = $this->db->order_by('descricao')->get('produtos')->result();
        $this->data['view'] = 'estoque/avarias';
        return $this->layout();
    }
}
