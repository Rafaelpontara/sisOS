<?php if (!defined('BASEPATH')) { exit('No direct script access allowed'); }

class Compras extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('compras_model');
        $this->load->model('produtos_model');
        $this->load->model('sisos_model');
    }

    // ─── Listagem ─────────────────────────────────────────────────────────────

    public function index()
    {
        return $this->gerenciar();
    }

    public function gerenciar()
    {
        if (!$this->permission->checkPermission($this->session->userdata('permissao'), 'vCompra')) {
            $this->session->set_flashdata('error', 'Você não tem permissão para visualizar compras.');
            redirect(base_url());
        }

        $this->load->library('pagination');

        $where = [];
        $pesquisa = $this->input->get('pesquisa');
        $status   = $this->input->get('status');
        $de       = $this->input->get('data');
        $ate      = $this->input->get('data2');

        if ($pesquisa) $where['pesquisa'] = $pesquisa;
        if ($status)   $where['status']   = $status;
        if ($de)  { $p = explode('/', $de);  $where['de']  = $p[2].'-'.$p[1].'-'.$p[0]; }
        if ($ate) { $p = explode('/', $ate); $where['ate'] = $p[2].'-'.$p[1].'-'.$p[0]; }

        $perPage = (int)($this->data['configuration']['per_page'] ?? 20);

        $config = [
            'base_url'  => site_url('compras/gerenciar/'),
            'total_rows' => $this->compras_model->count($where),
            'per_page'  => $perPage,
            'suffix'    => "?pesquisa={$pesquisa}&status={$status}&data={$de}&data2={$ate}",
        ];
        $this->pagination->initialize($config);

        $this->data['results']  = $this->compras_model->getAll($perPage, $this->uri->segment(3), $where);
        $this->data['menuCompras'] = true;
        $this->data['view']     = 'compras/compras';
        return $this->layout();
    }

    // ─── Cadastrar ────────────────────────────────────────────────────────────

    public function adicionar()
    {
        if (!$this->permission->checkPermission($this->session->userdata('permissao'), 'aCompra')) {
            $this->session->set_flashdata('error', 'Você não tem permissão para adicionar compras.');
            redirect(base_url());
        }

        $this->load->library('form_validation');
        $this->data['custom_error'] = '';

        $this->form_validation->set_rules('descricao', 'Descrição', 'required|trim');
        $this->form_validation->set_rules('data_compra', 'Data da Compra', 'required|trim');
        $this->form_validation->set_rules('valor_total', 'Valor Total', 'required|trim');

        if ($this->form_validation->run() == false) {
            $this->data['custom_error'] = validation_errors() ? '<div class="alert alert-danger">'.validation_errors().'</div>' : '';
        } else {
            $dataCompra = $this->input->post('data_compra');
            $partes = explode('/', $dataCompra);
            $dataCompraDb = count($partes) === 3 ? $partes[2].'-'.$partes[1].'-'.$partes[0] : $dataCompra;

            $dataVenc = $this->input->post('data_vencimento');
            $dataVencDb = null;
            if ($dataVenc) {
                $p2 = explode('/', $dataVenc);
                $dataVencDb = count($p2) === 3 ? $p2[2].'-'.$p2[1].'-'.$p2[0] : $dataVenc;
            }

            $valorRaw   = str_replace(['.', ','], ['', '.'], $this->input->post('valor_total'));
            $valorPagoRaw = str_replace(['.', ','], ['', '.'], $this->input->post('valor_pago') ?: '0');

            $clienteId = $this->input->post('clientes_id') ?: null;

            $data = [
                'descricao'       => $this->input->post('descricao'),
                'fornecedor'      => $this->input->post('fornecedor'),
                'clientes_id'     => $clienteId,
                'usuarios_id'     => $this->session->userdata('id_admin'),
                'data_compra'     => $dataCompraDb,
                'data_vencimento' => $dataVencDb,
                'valor_total'     => floatval($valorRaw),
                'valor_pago'      => floatval($valorPagoRaw),
                'forma_pgto'      => $this->input->post('forma_pgto'),
                'status'          => $this->input->post('status') ?: 'pendente',
                'observacoes'     => $this->input->post('observacoes'),
                'nota_fiscal'     => $this->input->post('nota_fiscal'),
            ];

            $id = $this->compras_model->add($data);
            if ($id) {
                log_info('Adicionou compra ID: ' . $id);
                $this->session->set_flashdata('success', 'Compra registrada com sucesso!');
                redirect(site_url('compras/visualizar/' . $id));
            } else {
                $this->data['custom_error'] = '<div class="alert alert-danger">Erro ao salvar compra.</div>';
            }
        }

        $this->data['menuCompras'] = true;
        $this->data['view'] = 'compras/adicionarCompra';
        return $this->layout();
    }

    // ─── Visualizar ───────────────────────────────────────────────────────────

    public function visualizar($id = null)
    {
        if (!$id || !is_numeric($id)) { redirect(site_url('compras')); }

        if (!$this->permission->checkPermission($this->session->userdata('permissao'), 'vCompra')) {
            $this->session->set_flashdata('error', 'Sem permissão.');
            redirect(base_url());
        }

        $this->data['result']   = $this->compras_model->getById($id);
        $this->data['itens']    = $this->compras_model->getItens($id);
        $this->data['menuCompras'] = true;
        $this->data['view']     = 'compras/visualizarCompra';
        return $this->layout();
    }

    // ─── Editar ───────────────────────────────────────────────────────────────

    public function editar($id = null)
    {
        if (!$id || !is_numeric($id)) { redirect(site_url('compras')); }

        if (!$this->permission->checkPermission($this->session->userdata('permissao'), 'eCompra')) {
            $this->session->set_flashdata('error', 'Sem permissão para editar compras.');
            redirect(base_url());
        }

        $this->load->library('form_validation');
        $this->data['custom_error'] = '';
        $this->data['result'] = $this->compras_model->getById($id);

        $this->form_validation->set_rules('descricao', 'Descrição', 'required|trim');

        if ($this->form_validation->run() == false) {
            $this->data['custom_error'] = validation_errors() ? '<div class="alert alert-danger">'.validation_errors().'</div>' : '';
        } else {
            $dataCompra = $this->input->post('data_compra');
            $partes = explode('/', $dataCompra);
            $dataCompraDb = count($partes) === 3 ? $partes[2].'-'.$partes[1].'-'.$partes[0] : $dataCompra;

            $dataVenc = $this->input->post('data_vencimento');
            $dataVencDb = null;
            if ($dataVenc) {
                $p2 = explode('/', $dataVenc);
                $dataVencDb = count($p2) === 3 ? $p2[2].'-'.$p2[1].'-'.$p2[0] : $dataVenc;
            }

            $valorRaw   = str_replace(['.', ','], ['', '.'], $this->input->post('valor_total'));
            $valorPagoRaw = str_replace(['.', ','], ['', '.'], $this->input->post('valor_pago') ?: '0');

            $data = [
                'descricao'       => $this->input->post('descricao'),
                'fornecedor'      => $this->input->post('fornecedor'),
                'data_compra'     => $dataCompraDb,
                'data_vencimento' => $dataVencDb,
                'valor_total'     => floatval($valorRaw),
                'valor_pago'      => floatval($valorPagoRaw),
                'forma_pgto'      => $this->input->post('forma_pgto'),
                'status'          => $this->input->post('status'),
                'observacoes'     => $this->input->post('observacoes'),
                'nota_fiscal'     => $this->input->post('nota_fiscal'),
            ];

            if ($this->compras_model->edit($id, $data)) {
                log_info('Editou compra ID: ' . $id);
                $this->session->set_flashdata('success', 'Compra atualizada!');
                redirect(site_url('compras/visualizar/' . $id));
            } else {
                $this->data['custom_error'] = '<div class="alert alert-danger">Erro ao atualizar.</div>';
            }
        }

        $this->data['menuCompras'] = true;
        $this->data['view'] = 'compras/editarCompra';
        return $this->layout();
    }

    // ─── Excluir ──────────────────────────────────────────────────────────────

    public function excluir()
    {
        if (!$this->permission->checkPermission($this->session->userdata('permissao'), 'dCompra')) {
            echo json_encode(['result' => false, 'messages' => 'Sem permissão.']);
            return;
        }
        $id = $this->input->post('id');
        if (!$id || !is_numeric($id)) {
            echo json_encode(['result' => false, 'messages' => 'ID inválido.']);
            return;
        }
        $this->compras_model->delete($id);
        log_info('Excluiu compra ID: ' . $id);
        echo json_encode(['result' => true]);
    }

    // ─── Itens da compra (AJAX) ───────────────────────────────────────────────

    public function adicionarItem()
    {
        $compraId   = $this->input->post('compras_id');
        $produtoId  = $this->input->post('produtos_id') ?: null;
        $descricao  = $this->input->post('descricao');
        $quantidade = floatval(str_replace(',', '.', $this->input->post('quantidade') ?: 1));
        $preco      = floatval(str_replace(['.', ','], ['', '.'], $this->input->post('preco_unit') ?: 0));

        if (!$compraId || !$descricao) {
            echo json_encode(['result' => false, 'messages' => 'Dados inválidos.']);
            return;
        }

        $data = [
            'compras_id'  => $compraId,
            'produtos_id' => $produtoId,
            'descricao'   => $descricao,
            'quantidade'  => $quantidade,
            'preco_unit'  => $preco,
            'subTotal'    => $quantidade * $preco,
        ];

        $id = $this->compras_model->addItem($data);

        // Atualiza estoque do produto se vinculado
        if ($id && $produtoId && $this->data['configuration']['control_estoque']) {
            $this->produtos_model->updateEstoque($produtoId, $quantidade, '+');
            log_info("ESTOQUE: Produto {$produtoId} entrou {$quantidade} unidades via Compra #{$compraId}");
        }

        echo json_encode(['result' => (bool)$id, 'id' => $id]);
    }

    public function excluirItem()
    {
        $id = $this->input->post('id');
        $this->compras_model->deleteItem($id);
        echo json_encode(['result' => true]);
    }

    // ─── Saídas de estoque ────────────────────────────────────────────────────

    public function saidas()
    {
        if (!$this->permission->checkPermission($this->session->userdata('permissao'), 'vCompra')) {
            $this->session->set_flashdata('error', 'Sem permissão.');
            redirect(base_url());
        }

        $this->load->library('pagination');

        $where = [];
        $pesquisa = $this->input->get('pesquisa');
        $de  = $this->input->get('data');
        $ate = $this->input->get('data2');
        if ($pesquisa) $where['pesquisa'] = $pesquisa;
        if ($de)  { $p = explode('/', $de);  $where['de']  = $p[2].'-'.$p[1].'-'.$p[0]; }
        if ($ate) { $p = explode('/', $ate); $where['ate'] = $p[2].'-'.$p[1].'-'.$p[0]; }

        $perPage = (int)($this->data['configuration']['per_page'] ?? 20);
        $config  = [
            'base_url'   => site_url('compras/saidas/'),
            'total_rows' => $this->compras_model->countSaidas(),
            'per_page'   => $perPage,
        ];
        $this->pagination->initialize($config);

        $this->data['results']     = $this->compras_model->getSaidas($perPage, $this->uri->segment(3), $where);
        $this->data['produtos']    = $this->produtos_model->get('produtos', 'idProdutos, descricao, estoque');
        $this->data['menuCompras'] = true;
        $this->data['view']        = 'compras/saidas';
        return $this->layout();
    }

    public function adicionarSaida()
    {
        if (!$this->permission->checkPermission($this->session->userdata('permissao'), 'aCompra')) {
            echo json_encode(['result' => false, 'messages' => 'Sem permissão.']);
            return;
        }

        $produtoId  = $this->input->post('produtos_id');
        $quantidade = floatval(str_replace(',', '.', $this->input->post('quantidade') ?: 0));
        $motivo     = $this->input->post('motivo');
        $dataSaida  = $this->input->post('data_saida');

        $partes = explode('/', $dataSaida);
        $dataSaidaDb = count($partes) === 3 ? $partes[2].'-'.$partes[1].'-'.$partes[0] : $dataSaida;

        if (!$produtoId || !$quantidade || !$motivo) {
            echo json_encode(['result' => false, 'messages' => 'Preencha todos os campos.']);
            return;
        }

        $data = [
            'produtos_id' => $produtoId,
            'usuarios_id' => $this->session->userdata('id_admin'),
            'quantidade'  => $quantidade,
            'motivo'      => $motivo,
            'observacoes' => $this->input->post('observacoes'),
            'data_saida'  => $dataSaidaDb,
        ];

        $id = $this->compras_model->addSaida($data);

        if ($id && $this->data['configuration']['control_estoque']) {
            $this->produtos_model->updateEstoque($produtoId, $quantidade, '-');
            log_info("ESTOQUE: Produto {$produtoId} saiu {$quantidade} unidades. Motivo: {$motivo}");
        }

        echo json_encode(['result' => (bool)$id]);
    }

    public function excluirSaida()
    {
        $id = $this->input->post('id');
        $this->compras_model->deleteSaida($id);
        echo json_encode(['result' => true]);
    }
}
