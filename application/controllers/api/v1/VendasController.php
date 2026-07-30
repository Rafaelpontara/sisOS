<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class VendasController extends REST_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('vendas_model');
    }

    // ══════════════════════════════════════════════════════════════
    // GET /api/v1/vendas  |  GET /api/v1/vendas/{id}
    // Params: page, perPage, search, status, clientes_id
    // ══════════════════════════════════════════════════════════════
    public function index_get($id = '')
    {
        $this->logged_user();
        if (!$this->permission->checkPermission($this->logged_user()->level, 'vVenda')) {
            $this->response(['status'=>false,'message'=>'Sem permissão.'], 403); return;
        }

        // Detalhe de uma venda
        if ($id) {
            $this->db->select('vendas.*, clientes.nomeCliente, usuarios.nome as nomeVendedor');
            $this->db->from('vendas');
            $this->db->join('clientes', 'clientes.idClientes = vendas.clientes_id', 'left');
            $this->db->join('usuarios', 'usuarios.idUsuarios = vendas.usuarios_id', 'left');
            $this->db->where('vendas.idVendas', $id);
            $venda = $this->db->get()->row();

            if (!$venda) {
                $this->response(['status'=>false,'message'=>'Venda não encontrada.'], 404); return;
            }

            // Itens com nome e código de barras
            $this->db->select('iv.*, p.descricao, p.codDeBarra, p.unidade');
            $this->db->from('itens_de_vendas iv');
            $this->db->join('produtos p', 'p.idProdutos = iv.produtos_id', 'left');
            $this->db->where('iv.vendas_id', $id);
            $venda->itens = $this->db->get()->result();

            // Lançamento vinculado
            $lanc = $this->db->select('idLancamentos, forma_pgto, valor, baixado')
                ->where('vendas_id', $id)->get('lancamentos')->row();
            $venda->lancamento = $lanc;

            $this->response(['status'=>true,'result'=>$venda], 200);
            return;
        }

        // Listagem
        $perPage    = (int)($this->get('perPage') ?: 30);
        $page       = max(1, (int)($this->get('page') ?: 1));
        $search     = $this->get('search')     ?: '';
        $status     = $this->get('status')     ?: '';
        $clienteId  = $this->get('clientes_id') ?: '';
        $start      = ($page - 1) * $perPage;

        $this->db->select('vendas.*, clientes.nomeCliente, usuarios.nome as nomeVendedor');
        $this->db->from('vendas');
        $this->db->join('clientes', 'clientes.idClientes = vendas.clientes_id', 'left');
        $this->db->join('usuarios', 'usuarios.idUsuarios = vendas.usuarios_id', 'left');

        if ($search)    {
            $this->db->group_start();
            $this->db->like('clientes.nomeCliente', $search);
            $this->db->or_like('vendas.observacoes', $search);
            $this->db->group_end();
        }
        if ($status)    $this->db->where('vendas.status', $status);
        if ($clienteId) $this->db->where('vendas.clientes_id', $clienteId);

        $total = $this->db->count_all_results('', false);

        $this->db->order_by('vendas.idVendas', 'DESC');
        $this->db->limit($perPage, $start);
        $result = $this->db->get()->result();

        // Calcular vencimento de garantia e total
        foreach ($result as &$v) {
            $v->totalFinal = floatval($v->valor_desconto ?? $v->valorTotal ?? 0);
            if (!empty($v->garantia) && intval($v->garantia) > 0 && !empty($v->dataVenda)) {
                $dt = new DateTime($v->dataVenda);
                $dt->modify('+' . intval($v->garantia) . ' days');
                $v->vencGarantia = $dt->format('d/m/Y');
            } else {
                $v->vencGarantia = null;
            }
        }
        unset($v);

        $this->response([
            'status'  => true,
            'result'  => $result,
            'total'   => $total,
            'page'    => $page,
            'perPage' => $perPage,
            'pages'   => ceil($total / $perPage),
        ], 200);
    }

    // ══════════════════════════════════════════════════════════════
    // POST /api/v1/vendas
    // ══════════════════════════════════════════════════════════════
    public function index_post()
    {
        $this->logged_user();
        if (!$this->permission->checkPermission($this->logged_user()->level, 'aVenda')) {
            $this->response(['status'=>false,'message'=>'Sem permissão.'], 403); return;
        }

        $_POST = (array) json_decode(file_get_contents('php://input'), true);

        $clienteId = $this->post('clientes_id');
        if (!$clienteId) {
            $this->response(['status'=>false,'message'=>'Cliente obrigatório.'], 400); return;
        }

        $data = [
            'clientes_id' => $clienteId,
            'usuarios_id' => $this->post('usuarios_id') ?: $this->session->userdata('id_admin'),
            'dataVenda'   => $this->post('dataVenda')   ?: date('Y-m-d H:i:s'),
            'status'      => $this->post('status')      ?: 'Aberto',
            'faturado'    => (int)($this->post('faturado') ?: 0),
            'garantia'    => $this->post('garantia')    ?: 0,
            'observacoes' => $this->post('observacoes') ?: '',
            'forma_pgto'  => $this->post('forma_pgto')  ?: '',
            'desconto'    => floatval($this->post('desconto') ?: 0),
        ];

        if ($this->db->insert('vendas', $data)) {
            $idVenda = $this->db->insert_id();

            // Inserir itens se informados
            $itens = $this->post('itens') ?: [];
            foreach ($itens as $item) {
                $preco   = floatval($item['preco'] ?? 0);
                $qtd     = floatval($item['quantidade'] ?? 1);
                $this->db->insert('itens_de_vendas', [
                    'vendas_id'   => $idVenda,
                    'produtos_id' => (int)($item['produtos_id'] ?? 0),
                    'quantidade'  => $qtd,
                    'preco'       => $preco,
                    'subTotal'    => round($preco * $qtd, 2),
                ]);
            }

            $this->response([
                'status'  => true,
                'message' => 'Venda criada com sucesso!',
                'result'  => ['idVendas' => $idVenda],
            ], 200);
        } else {
            $this->response(['status'=>false,'message'=>'Erro ao criar venda.'], 500);
        }
    }

    // ══════════════════════════════════════════════════════════════
    // PUT /api/v1/vendas/{id}
    // ══════════════════════════════════════════════════════════════
    public function index_put($id)
    {
        $this->logged_user();
        if (!$this->permission->checkPermission($this->logged_user()->level, 'eVenda')) {
            $this->response(['status'=>false,'message'=>'Sem permissão.'], 403); return;
        }

        $venda = $this->db->where('idVendas', $id)->get('vendas')->row();
        if (!$venda) {
            $this->response(['status'=>false,'message'=>'Venda não encontrada.'], 404); return;
        }

        $_POST = (array) json_decode(file_get_contents('php://input'), true);

        $data = [];
        $campos = ['clientes_id','usuarios_id','dataVenda','status','faturado',
                   'garantia','observacoes','forma_pgto','desconto','valor_desconto','valorTotal'];
        foreach ($campos as $campo) {
            if (isset($_POST[$campo])) $data[$campo] = $_POST[$campo];
        }

        if (!empty($data)) {
            $this->db->where('idVendas', $id)->update('vendas', $data);
        }

        $this->response([
            'status'  => true,
            'message' => 'Venda atualizada!',
            'result'  => $this->db->where('idVendas', $id)->get('vendas')->row(),
        ], 200);
    }

    // ══════════════════════════════════════════════════════════════
    // DELETE /api/v1/vendas/{id}
    // ══════════════════════════════════════════════════════════════
    public function index_delete($id)
    {
        $this->logged_user();
        if (!$this->permission->checkPermission($this->logged_user()->level, 'dVenda')) {
            $this->response(['status'=>false,'message'=>'Sem permissão.'], 403); return;
        }

        $venda = $this->db->where('idVendas', $id)->get('vendas')->row();
        if (!$venda) {
            $this->response(['status'=>false,'message'=>'Venda não encontrada.'], 404); return;
        }

        $this->db->where('vendas_id', $id)->delete('itens_de_vendas');
        $this->db->where('vendas_id', $id)->delete('lancamentos');
        $this->db->where('idVendas',  $id)->delete('vendas');

        $this->response(['status'=>true,'message'=>'Venda excluída!'], 200);
    }

    // ══════════════════════════════════════════════════════════════
    // POST /api/v1/vendas/{id}/cancelar
    // Espelha EXATAMENTE Vendas::cancelar() do controller web:
    // devolve estoque, exclui lançamento, marca status Cancelado.
    // ══════════════════════════════════════════════════════════════
    public function cancelar_post($id)
    {
        $this->logged_user();
        if (!$this->permission->checkPermission($this->logged_user()->level, 'eVenda')) {
            $this->response(['status'=>false,'message'=>'Sem permissão para cancelar vendas.'], 403); return;
        }

        if (!$id || !is_numeric($id)) {
            $this->response(['status'=>false,'message'=>'Venda inválida.'], 400); return;
        }

        $venda = $this->db->where('idVendas', $id)->get('vendas')->row();
        if (!$venda) {
            $this->response(['status'=>false,'message'=>'Venda não encontrada.'], 404); return;
        }
        if ($venda->status === 'Cancelado') {
            $this->response(['status'=>false,'message'=>'Venda já está cancelada.'], 400); return;
        }

        $_POST = (array) json_decode(file_get_contents('php://input'), true);

        // 1. Devolver estoque
        $configCtrl = $this->db->select('valor')->where('config', 'control_estoque')->get('configuracoes')->row();
        if ($configCtrl && (int)$configCtrl->valor) {
            $this->load->model('produtos_model');
            $itens = $this->db->where('vendas_id', $id)->get('itens_de_vendas')->result();
            foreach ($itens as $item) {
                if ($item->produtos_id) {
                    $this->produtos_model->updateEstoque($item->produtos_id, $item->quantidade, '+');
                    log_info("ESTOQUE: Produto id {$item->produtos_id} voltou ao estoque. Quantidade: {$item->quantidade}. Motivo: Cancelamento Venda #{$id} (App)");
                }
            }
        }

        // 2. Excluir lançamento financeiro vinculado
        $this->db->where('vendas_id', $id)->delete('lancamentos');

        // 3. Mudar status para Cancelado
        $motivo = $this->post('motivo') ?: 'Cancelado manualmente (App)';
        $this->db->where('idVendas', $id)->update('vendas', [
            'status'      => 'Cancelado',
            'faturado'    => 0,
            'observacoes' => trim(($venda->observacoes ?? '') . "\n[CANCELADO em " . date('d/m/Y H:i') . " via App] " . $motivo),
        ]);

        log_info("Venda #{$id} cancelada via App. Motivo: {$motivo}. Estoque devolvido.");
        $this->response(['status'=>true,'message'=>"Venda #{$id} cancelada com sucesso. Estoque devolvido."], 200);
    }
}
