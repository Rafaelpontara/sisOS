<?php

if (! defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Vendas extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->load->helper('form');
        $this->load->model('vendas_model');
        $this->data['menuVendas'] = 'Vendas';
    }

    public function index()
    {
        $this->gerenciar();
    }

    public function gerenciar()
    {
        if (!$this->permission->checkPermission($this->session->userdata('permissao'), 'vVenda')) {
            $this->session->set_flashdata('error', 'Você não tem permissão para visualizar vendas.');
            redirect(base_url());
        }

        $where_array = [];

        $pesquisa = $this->input->get('pesquisa');
        $status = $this->input->get('status');
        $de = $this->input->get('data');
        $ate = $this->input->get('data2');

        if ($pesquisa) $where_array['pesquisa'] = $pesquisa;
        if ($status) $where_array['status'] = $status;
        if ($de) $where_array['de'] = $de;
        if ($ate) $where_array['ate'] = $ate;

        $perPage = 24;

        $this->data['statTotalFiltrado'] = $this->_contarVendasFiltradas($where_array);
        $this->data['results'] = $this->vendas_model->get('vendas', '*', $where_array, $perPage, 0);
        $this->_enriquecerVendas($this->data['results']);

        $permissao = $this->session->userdata('permissao');
        $this->data['permissao_aVenda'] = $this->permission->checkPermission($permissao, 'aVenda');
        $this->data['permissao_vVenda'] = $this->permission->checkPermission($permissao, 'vVenda');
        $this->data['permissao_eVenda'] = $this->permission->checkPermission($permissao, 'eVenda');
        $this->data['permissao_dVenda'] = $this->permission->checkPermission($permissao, 'dVenda');

        $this->data['perPage'] = $perPage;
        $this->data['view'] = 'vendas/vendas';

        return $this->layout();
    }

    /**
     * Endpoint AJAX chamado pela rolagem infinita da lista de vendas.
     */
    public function carregarMais()
    {
        if (!$this->permission->checkPermission($this->session->userdata('permissao'), 'vVenda')) {
            return;
        }

        $where_array = [];
        $pesquisa = $this->input->get('pesquisa');
        $status = $this->input->get('status');
        $de = $this->input->get('data');
        $ate = $this->input->get('data2');
        $antesDe = (int) $this->input->get('antes_de');

        if ($pesquisa) $where_array['pesquisa'] = $pesquisa;
        if ($status) $where_array['status'] = $status;
        if ($de) $where_array['de'] = $de;
        if ($ate) $where_array['ate'] = $ate;

        $perPage = 24;

        $results = $this->vendas_model->get('vendas', '*', $where_array, $perPage, 0, false, 'array', $antesDe);
        $this->_enriquecerVendas($results);

        $permissao = $this->session->userdata('permissao');
        echo $this->load->view('vendas/_table_rows_partial', [
            'results' => $results,
            'semResultadosOculto' => true,
            'permissao_vVenda' => $this->permission->checkPermission($permissao, 'vVenda'),
            'permissao_eVenda' => $this->permission->checkPermission($permissao, 'eVenda'),
            'permissao_dVenda' => $this->permission->checkPermission($permissao, 'dVenda'),
        ], true);
    }

    /**
     * Preenche totalProdutos, nomeVendedor e vencGarantia em cada venda —
     * usado tanto no carregamento inicial quanto na rolagem infinita.
     */
    private function _enriquecerVendas(&$vendas)
    {
        foreach ($vendas as $key => $venda) {
            $vendas[$key]->totalProdutos = $this->vendas_model->getTotalVendas($venda->idVendas);

            if (!empty($venda->usuarios_id)) {
                $usuario = $this->db->select('nome')
                    ->where('idUsuarios', $venda->usuarios_id)
                    ->get('usuarios')->row();
                $vendas[$key]->nomeVendedor = $usuario->nome ?? '-';
            } else {
                $vendas[$key]->nomeVendedor = '-';
            }

            if (!empty($venda->garantia) && intval($venda->garantia) > 0 && !empty($venda->dataVenda)) {
                $dataVenda = new DateTime($venda->dataVenda);
                $dataVenda->modify('+' . intval($venda->garantia) . ' days');
                $vendas[$key]->vencGarantia = $dataVenda->format('d/m/Y');
            } else {
                $vendas[$key]->vencGarantia = '-';
            }
        }
    }

    /**
     * Conta o total de vendas respeitando os mesmos filtros — usado pra
     * mostrar "X de Y" e pra rolagem infinita saber quando parar.
     */
    private function _contarVendasFiltradas($where_array)
    {
        if (empty($where_array)) {
            return $this->vendas_model->count('vendas');
        }

        $lista_clientes = [];
        if (array_key_exists('pesquisa', $where_array)) {
            $this->db->select('idClientes');
            $this->db->like('nomeCliente', $where_array['pesquisa']);
            $this->db->limit(25);
            foreach ($this->db->get('clientes')->result() as $c) {
                $lista_clientes[] = $c->idClientes;
            }
        }

        $this->db->from('vendas');
        if (array_key_exists('status', $where_array)) {
            $this->db->where_in('vendas.status', $where_array['status']);
        }
        if (array_key_exists('pesquisa', $where_array) && $lista_clientes) {
            $this->db->where_in('vendas.clientes_id', $lista_clientes);
        }
        if (array_key_exists('de', $where_array)) {
            $this->db->where('vendas.dataVenda >=', $where_array['de']);
        }
        if (array_key_exists('ate', $where_array)) {
            $this->db->where('vendas.dataVenda <=', $where_array['ate']);
        }

        return $this->db->count_all_results();
    }

    public function adicionar()
    {
        if (! $this->permission->checkPermission($this->session->userdata('permissao'), 'aVenda')) {
            $this->session->set_flashdata('error', 'Você não tem permissão para adicionar Vendas.');
            redirect(base_url());
        }

        $this->load->library('form_validation');
        $this->data['custom_error'] = '';

        if ($this->form_validation->run('vendas') == false) {
            $this->data['custom_error'] = (validation_errors() ? true : false);
        } else {
            $dataVenda = $this->input->post('dataVenda');

            try {
                $dataVenda = explode('/', $dataVenda);
                $dataVenda = $dataVenda[2] . '-' . $dataVenda[1] . '-' . $dataVenda[0];
            } catch (Exception $e) {
                $dataVenda = date('Y-m-d');
            }

            $data = [
                'dataVenda' => $dataVenda,
                'observacoes' => $this->input->post('observacoes'),
                'observacoes_cliente' => $this->input->post('observacoes_cliente'),
                'clientes_id' => $this->input->post('clientes_id'),
                'usuarios_id' => $this->input->post('usuarios_id'),
                'faturado' => 0,
                'status' => $this->input->post('status'),
                'garantia' => $this->input->post('garantia')
            ];

            $id = $this->vendas_model->add('vendas', $data, true);

            if (is_numeric($id)) {
                $this->session->set_flashdata('success', 'Venda iniciada com sucesso, adicione os produtos.');
                log_info('Adicionou uma venda. ID: ' . $id);
                redirect(site_url('vendas/editar/') . $id);
            } else {
                $this->data['custom_error'] = '<div class="form_error"><p>Ocorreu um erro.</p></div>';
            }
        }

        $this->data['view'] = 'vendas/adicionarVenda';

        return $this->layout();
    }

    public function editar()
    {
        if (! $this->uri->segment(3) || ! is_numeric($this->uri->segment(3)) || ! $this->vendas_model->getById($this->uri->segment(3))) {
            $this->session->set_flashdata('error', 'Venda não encontrada ou parâmetro inválido.');
            redirect('vendas/gerenciar');
        }

        if (! $this->permission->checkPermission($this->session->userdata('permissao'), 'eVenda')) {
            $this->session->set_flashdata('error', 'Você não tem permissão para editar vendas');
            redirect(base_url());
        }

        $this->load->library('form_validation');
        $this->data['custom_error'] = '';

        $this->data['editavel'] = $this->vendas_model->isEditable($this->input->post('idVendas'));
        if (! $this->data['editavel']) {
            $this->session->set_flashdata('error', 'Essa Venda já tem seu status Faturada e não pode ser alterado e nem suas informações atualizadas. Por favor abrir uma nova Venda.');

            redirect(site_url('vendas'));
        }

        if ($this->form_validation->run('vendas') == false) {
            $this->data['custom_error'] = (validation_errors() ? '<div class="form_error">' . validation_errors() . '</div>' : false);
        } else {
            $dataVenda = $this->input->post('dataVenda');

            try {
                $dataVenda = explode('/', $dataVenda);
                $dataVenda = $dataVenda[2] . '-' . $dataVenda[1] . '-' . $dataVenda[0];
            } catch (Exception $e) {
                $dataVenda = date('Y/m/d');
            }

            $data = [
                'dataVenda' => $dataVenda,
                'observacoes' => $this->input->post('observacoes'),
                'observacoes_cliente' => $this->input->post('observacoes_cliente'),
                'usuarios_id' => $this->input->post('usuarios_id'),
                'clientes_id' => $this->input->post('clientes_id'),
                'status' => $this->input->post('status'),
                'garantia' => $this->input->post('garantia')
            ];

            if ($this->vendas_model->edit('vendas', $data, 'idVendas', $this->input->post('idVendas')) == true) {
                $this->session->set_flashdata('success', 'Venda editada com sucesso!');
                log_info('Alterou uma venda. ID: ' . $this->input->post('idVendas'));
                redirect(site_url('vendas/editar/') . $this->input->post('idVendas'));
            } else {
                $this->data['custom_error'] = '<div class="form_error"><p>Ocorreu um erro</p></div>';
            }
        }

        $this->data['result'] = $this->vendas_model->getById($this->uri->segment(3));
        $this->data['produtos'] = $this->vendas_model->getProdutos($this->uri->segment(3));
        $this->data['view'] = 'vendas/editarVenda';

        return $this->layout();
    }

    public function visualizar()
    {
        if (! $this->uri->segment(3) || ! is_numeric($this->uri->segment(3))) {
            $this->session->set_flashdata('error', 'Item não pode ser encontrado, parâmetro não foi passado corretamente.');
            redirect('sisos');
        }

        if (! $this->permission->checkPermission($this->session->userdata('permissao'), 'vVenda')) {
            $this->session->set_flashdata('error', 'Você não tem permissão para visualizar vendas.');
            redirect(base_url());
        }

        $this->data['custom_error'] = '';
        $this->load->model('sisos_model');
        $idVendaVis = $this->uri->segment(3);
        $this->data['result'] = $this->vendas_model->getById($idVendaVis);
        // JOIN com produtos para ter descricao e codDeBarra
        $this->data['produtos'] = $this->db
            ->select('iv.*, p.descricao, p.codDeBarra, p.unidade')
            ->from('itens_de_vendas iv')
            ->join('produtos p', 'p.idProdutos = iv.produtos_id', 'left')
            ->where('iv.vendas_id', $idVendaVis)
            ->get()->result();
        $this->data['emitente'] = $this->sisos_model->getEmitente();
        $this->data['qrCode'] = $this->vendas_model->getQrCode(
            $this->uri->segment(3),
            $this->data['configuration']['pix_key'],
            $this->data['emitente']
        );
        $this->data['chaveFormatada'] = $this->formatarChave($this->data['configuration']['pix_key']);
        $this->data['modalGerarPagamento'] = $this->load->view(
            'cobrancas/modalGerarPagamento',
            [
                'id' => $this->uri->segment(3),
                'tipo' => 'venda',
            ],
            true
        );

        $clienteId = $this->data['result']->clientes_id;
        $this->load->model('clientes_model');
        $cliente = $this->clientes_model->getById($clienteId);

        $zapnumber = preg_replace('/[^0-9]/', '', $cliente->telefone ?? '');
        $this->data['zapnumber'] = $zapnumber;
        $this->data['view'] = 'vendas/visualizarVenda';

        return $this->layout();
    }

    public function imprimir()
    {
        if (! $this->uri->segment(3) || ! is_numeric($this->uri->segment(3))) {
            $this->session->set_flashdata('error', 'Item não pode ser encontrado, parâmetro não foi passado corretamente.');
            redirect('sisos');
        }

        if (! $this->permission->checkPermission($this->session->userdata('permissao'), 'vVenda')) {
            $this->session->set_flashdata('error', 'Você não tem permissão para visualizar vendas.');
            redirect(base_url());
        }

        $this->data['custom_error'] = '';
        $this->load->model('sisos_model');
        $this->data['result'] = $this->vendas_model->getById($this->uri->segment(3));
        $this->data['produtos'] = $this->vendas_model->getProdutos($this->uri->segment(3));
        $this->data['emitente'] = $this->sisos_model->getEmitente();
        $this->data['qrCode'] = $this->vendas_model->getQrCode(
            $this->uri->segment(3),
            $this->data['configuration']['pix_key'],
            $this->data['emitente']
        );
        $this->data['chaveFormatada'] = $this->formatarChave($this->data['configuration']['pix_key']);

        $this->load->view('vendas/imprimirVenda', $this->data);
    }

    public function imprimirPromissoria()
    {
        if (! $this->uri->segment(3) || ! is_numeric($this->uri->segment(3))) {
            $this->session->set_flashdata('error', 'Parâmetro inválido.');
            redirect('sisos');
        }

        if (! $this->permission->checkPermission($this->session->userdata('permissao'), 'vVenda')) {
            $this->session->set_flashdata('error', 'Você não tem permissão para visualizar vendas.');
            redirect(base_url());
        }

        $this->load->model('sisos_model');
        $this->data['result']   = $this->vendas_model->getById($this->uri->segment(3));
        $this->data['emitente'] = $this->sisos_model->getEmitente();

        // Se já foram geradas/salvas parcelas de promissória pra essa venda
        // (ver gerarPromissorias()), manda também pra view poder imprimir uma
        // nota por parcela em vez de só a nota única de sempre. Se a tabela
        // não existir ainda (SQL não rodado) ou não houver parcelas, fica
        // igual a antes (array vazio — view não precisa mudar nada).
        $this->data['promissorias'] = [];
        if ($this->db->table_exists('vendas_promissorias')) {
            $this->data['promissorias'] = $this->db
                ->where('vendas_id', $this->uri->segment(3))
                ->order_by('numero_parcela', 'asc')
                ->get('vendas_promissorias')
                ->result();
        }

        $this->load->view('vendas/imprimirPromissoria', $this->data);
    }

    /**
     * Gera (ou regenera) as parcelas de promissória de uma venda.
     * Espera via POST: vendas_id, parcelas (int), primeiro_vencimento (dd/mm/yyyy),
     * intervalo_dias (opcional, padrão 30), valor_total (opcional — se não vier,
     * usa o valorTotal já salvo na venda).
     *
     * Autocontido: cria a própria tabela de apoio na hora se ainda não
     * existir (não depende do SQL ter sido rodado antes), mas o ideal é
     * rodar o vendas_promissorias_add_tabela.sql já na entrega.
     */
    public function gerarPromissorias()
    {
        header('Content-Type: application/json');

        if (! $this->permission->checkPermission($this->session->userdata('permissao'), 'eVenda')) {
            echo json_encode(['sucesso' => false, 'erro' => 'Sem permissão.']);
            return;
        }

        $vendaId = (int) $this->input->post('vendas_id');
        $parcelas = max(1, (int) $this->input->post('parcelas'));
        $intervaloDias = (int) $this->input->post('intervalo_dias') ?: 30;
        $primeiroVencimento = $this->input->post('primeiro_vencimento');

        $venda = $this->vendas_model->getById($vendaId);
        if (! $venda) {
            echo json_encode(['sucesso' => false, 'erro' => 'Venda não encontrada.']);
            return;
        }

        $valorTotal = $this->input->post('valor_total');
        $valorTotal = $valorTotal ? getAmount($valorTotal) : (float) ($venda->valorTotal ?: $this->getTotalVendas($vendaId));

        try {
            $dataBase = DateTime::createFromFormat('d/m/Y', $primeiroVencimento) ?: new DateTime();
        } catch (Exception $e) {
            $dataBase = new DateTime();
        }

        if (! $this->db->table_exists('vendas_promissorias')) {
            $this->db->query("CREATE TABLE IF NOT EXISTS `vendas_promissorias` (
                `idPromissoria` INT AUTO_INCREMENT PRIMARY KEY,
                `vendas_id` INT NOT NULL,
                `numero_parcela` INT NOT NULL,
                `total_parcelas` INT NOT NULL,
                `valor` DECIMAL(10,2) NOT NULL,
                `data_vencimento` DATE NOT NULL,
                `pago` TINYINT(1) NOT NULL DEFAULT 0,
                `criado_em` DATETIME NOT NULL,
                INDEX `idx_vendas_id` (`vendas_id`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4");
        }

        $this->db->trans_start();

        // Regenerar do zero pra não duplicar se o usuário gerar de novo
        $this->db->where('vendas_id', $vendaId)->delete('vendas_promissorias');

        $valorParcela = round($valorTotal / $parcelas, 2);
        $somaParcelas = 0;
        for ($i = 1; $i <= $parcelas; $i++) {
            $valor = ($i < $parcelas) ? $valorParcela : round($valorTotal - $somaParcelas, 2); // última parcela ajusta arredondamento
            $somaParcelas += $valor;

            $vencimento = clone $dataBase;
            $vencimento->modify('+' . ($intervaloDias * ($i - 1)) . ' days');

            $this->db->insert('vendas_promissorias', [
                'vendas_id' => $vendaId,
                'numero_parcela' => $i,
                'total_parcelas' => $parcelas,
                'valor' => $valor,
                'data_vencimento' => $vencimento->format('Y-m-d'),
                'pago' => 0,
                'criado_em' => date('Y-m-d H:i:s'),
            ]);
        }

        $this->db->trans_complete();

        if ($this->db->trans_status() === false) {
            echo json_encode(['sucesso' => false, 'erro' => 'Erro ao salvar as parcelas.']);
            return;
        }

        log_info('Gerou ' . $parcelas . ' parcela(s) de promissória pra Venda ID: ' . $vendaId);

        echo json_encode(['sucesso' => true, 'parcelas' => $parcelas]);
    }

    /**
     * Marca/desmarca uma parcela de promissória como paga.
     */
    public function marcarPromissoriaPaga()
    {
        header('Content-Type: application/json');

        if (! $this->permission->checkPermission($this->session->userdata('permissao'), 'eVenda')) {
            echo json_encode(['sucesso' => false, 'erro' => 'Sem permissão.']);
            return;
        }

        $id = (int) $this->input->post('idPromissoria');
        $pago = $this->input->post('pago') == '1' ? 1 : 0;

        if (! $this->db->table_exists('vendas_promissorias')) {
            echo json_encode(['sucesso' => false, 'erro' => 'Tabela de promissórias não existe. Rode o SQL primeiro.']);
            return;
        }

        $this->db->where('idPromissoria', $id)->update('vendas_promissorias', ['pago' => $pago]);

        echo json_encode(['sucesso' => true]);
    }

    /**
     * Lista as parcelas de promissória de uma venda — pra montar telas/relatórios.
     */
    public function listarPromissorias()
    {
        header('Content-Type: application/json');

        $vendaId = (int) $this->input->get('vendas_id');

        if (! $this->db->table_exists('vendas_promissorias')) {
            echo json_encode(['promissorias' => []]);
            return;
        }

        $result = $this->db
            ->where('vendas_id', $vendaId)
            ->order_by('numero_parcela', 'asc')
            ->get('vendas_promissorias')
            ->result();

        echo json_encode(['promissorias' => $result]);
    }

    public function imprimirTermica()
    {
        if (! $this->uri->segment(3) || ! is_numeric($this->uri->segment(3))) {
            $this->session->set_flashdata('error', 'Item não pode ser encontrado, parâmetro não foi passado corretamente.');
            redirect('sisos');
        }

        if (! $this->permission->checkPermission($this->session->userdata('permissao'), 'vVenda')) {
            $this->session->set_flashdata('error', 'Você não tem permissão para visualizar vendas.');
            redirect(base_url());
        }

        $this->data['custom_error'] = '';
        $this->load->model('sisos_model');
        $this->data['result'] = $this->vendas_model->getById($this->uri->segment(3));
        $this->data['produtos'] = $this->vendas_model->getProdutos($this->uri->segment(3));
        $this->data['emitente'] = $this->sisos_model->getEmitente();
        $this->data['qrCode'] = $this->vendas_model->getQrCode(
            $this->uri->segment(3),
            $this->data['configuration']['pix_key'],
            $this->data['emitente']
        );
        
        $this->data['chaveFormatada'] = $this->formatarChave($this->data['configuration']['pix_key']);

        $this->load->view('vendas/imprimirVendaTermica', $this->data);
    }

    public function imprimirVendaOrcamento()
    {
        if (! $this->uri->segment(3) || ! is_numeric($this->uri->segment(3))) {
            $this->session->set_flashdata('error', 'Item não pode ser encontrado, parâmetro não foi passado corretamente.');
            redirect('sisos');
        }

        if (! $this->permission->checkPermission($this->session->userdata('permissao'), 'vVenda')) {
            $this->session->set_flashdata('error', 'Você não tem permissão para visualizar vendas.');
            redirect(base_url());
        }

        $this->data['custom_error'] = '';
        $this->load->model('sisos_model');
        $this->data['result'] = $this->vendas_model->getById($this->uri->segment(3));
        $this->data['produtos'] = $this->vendas_model->getProdutos($this->uri->segment(3));
        $this->data['emitente'] = $this->sisos_model->getEmitente();
        $this->data['qrCode'] = $this->vendas_model->getQrCode(
            $this->uri->segment(3),
            $this->data['configuration']['pix_key'],
            $this->data['emitente']
        );
        
        $this->data['chaveFormatada'] = $this->formatarChave($this->data['configuration']['pix_key']);
        $this->load->view('vendas/imprimirVendaOrcamento', $this->data);
    }

    public function excluir()
    {
        if (! $this->permission->checkPermission($this->session->userdata('permissao'), 'dVenda')) {
            $this->session->set_flashdata('error', 'Você não tem permissão para excluir vendas');
            redirect(base_url());
        }

        $this->load->model('vendas_model');

        $id = $this->input->post('id');

        $editavel = $this->vendas_model->isEditable($id);
        if (! $editavel) {
            $this->session->set_flashdata('error', 'Erro ao tentar excluir. Venda já faturada');
            redirect(site_url('vendas/gerenciar/'));
        }

        $venda = $this->vendas_model->getByIdCobrancas($id);
        if ($venda == null) {
            $venda = $this->vendas_model->getById($id);
            if ($venda == null) {
                $this->session->set_flashdata('error', 'Erro ao tentar excluir venda.');
                redirect(site_url('vendas/gerenciar/'));
            }
        }

        if (isset($venda->idCobranca) != null) {
            if ($venda->status == 'canceled') {
                $this->vendas_model->delete('cobrancas', 'vendas_id', $id);
            } else {
                $this->session->set_flashdata('error', 'Existe uma cobrança associada a esta venda, deve cancelar e/ou excluir a cobrança primeiro!');
                redirect(site_url('vendas/gerenciar/'));
            }
        }

        $this->vendas_model->delete('itens_de_vendas', 'vendas_id', $id);
        $this->vendas_model->delete('vendas', 'idVendas', $id);
        if ((int) $venda->faturado === 1) {
            $this->vendas_model->delete('lancamentos', 'descricao', "Fatura de Venda - #${id}");
        }

        log_info('Removeu uma venda. ID: ' . $id);

        $this->session->set_flashdata('success', 'Venda excluída com sucesso!');
        redirect(site_url('vendas/gerenciar/'));
    }

    public function autoCompleteProduto()
    {
        if (isset($_GET['term'])) {
            $q = strtolower($_GET['term']);
            $this->vendas_model->autoCompleteProduto($q);
        }
    }

    public function buscarPorBarcode()
    {
        $code = $this->input->get('code');
        if ($code) {
            $result = $this->vendas_model->getByBarcode(trim($code));
            header('Content-Type: application/json');
            echo json_encode($result);
        }
    }

    public function autoCompleteCliente()
    {
        if (isset($_GET['term'])) {
            $q = strtolower($_GET['term']);
            $this->vendas_model->autoCompleteCliente($q);
        }
    }

    public function autoCompleteUsuario()
    {
        if (isset($_GET['term'])) {
            $q = strtolower($_GET['term']);
            $this->vendas_model->autoCompleteUsuario($q);
        }
    }

    public function adicionarProduto()
    {
        if (!$this->permission->checkPermission($this->session->userdata('permissao'), 'eVenda')) {
            $this->session->set_flashdata('error', 'Você não tem permissão para editar vendas.');
            redirect(base_url());
        }

        $this->load->library('form_validation');
        $this->form_validation->set_rules('quantidade', 'Quantidade', 'trim|required');
        $this->form_validation->set_rules('idProduto', 'Produto', 'trim|required');
        $this->form_validation->set_rules('idVendasProduto', 'Vendas', 'trim|required');

        $idVenda = $this->input->post('idVendasProduto');
        $editavel = $this->vendas_model->isEditable($idVenda);
        if (!$editavel) {
            return $this->output
                ->set_content_type('application/json')
                ->set_status_header(422)
                ->set_output(json_encode(['result' => false, 'messages' => '<br /><br /> <strong>Motivo:</strong> Venda já faturada']));
        }

        if ($this->form_validation->run() == false) {
            echo json_encode(['result' => false]);
        } else {
            $preco = $this->input->post('preco');
            $quantidade = $this->input->post('quantidade');
            $subtotal = $preco * $quantidade;
            $produto = $this->input->post('idProduto');
            $data = [
                'quantidade' => $quantidade,
                'subTotal' => $subtotal,
                'produtos_id' => $produto,
                'preco' => $preco,
                'vendas_id' => $idVenda,
            ];

            // Verificar estoque antes de vender
            if ($this->data['configuration']['control_estoque']) {
                $this->load->model('produtos_model');
                $produtoInfo = $this->produtos_model->getById($produto);
                $estoqueAtual = $produtoInfo ? (int)$produtoInfo->estoque : 0;
                $modoSemEstoque = (int)($this->data['configuration']['venda_sem_estoque'] ?? 0);

                if ($estoqueAtual < $quantidade && $modoSemEstoque === 0) {
                    echo json_encode([
                        'result'   => false,
                        'messages' => 'Estoque insuficiente! Disponível: ' . $estoqueAtual . ' | Solicitado: ' . $quantidade
                    ]);
                    return;
                }
            }

            if ($this->vendas_model->add('itens_de_vendas', $data) == true) {
                $this->load->model('produtos_model');
                $modoSemEstoque = (int)($this->data['configuration']['venda_sem_estoque'] ?? 0);

                if ($this->data['configuration']['control_estoque']) {
                    $this->produtos_model->updateEstoque($produto, $quantidade, '-');
                }

                // Alerta de estoque negativo (modo 1)
                $avisoEstoqueNegativo = null;
                if ($this->data['configuration']['control_estoque'] && $modoSemEstoque === 1) {
                    $prodAtual = $this->produtos_model->getById($produto);
                    if ($prodAtual && (int)$prodAtual->estoque < 0) {
                        $avisoEstoqueNegativo = 'Atenção: estoque do produto ficou negativo (' . $prodAtual->estoque . '). Lembre de lançar a entrada.';
                    }
                }

                // Atualiza o desconto da venda
                $this->db->set('desconto', 0.00);
                $this->db->set('valor_desconto', 0.00);
                $this->db->set('tipo_desconto', null);
                $this->db->where('idVendas', $idVenda);
                $this->db->update('vendas');

                // Registra a ação nos logs com o ID da venda
                log_info('Adicionou produto à venda com ID: ' . $idVenda);

                echo json_encode(['result' => true, 'aviso_estoque' => $avisoEstoqueNegativo]);
            } else {
                echo json_encode(['result' => false]);
            }
        }
    }

    public function excluirProduto()
    {
        if (!$this->permission->checkPermission($this->session->userdata('permissao'), 'eVenda')) {
            $this->session->set_flashdata('error', 'Você não tem permissão para editar Vendas.');
            redirect(base_url());
        }

        $this->load->library('form_validation');
        $this->form_validation->set_rules('idProduto', 'Produto', 'trim|required');
        $this->form_validation->set_rules('idVendas', 'Venda', 'trim|required');
        $this->form_validation->set_rules('quantidade', 'Quantidade', 'trim|required');
        $this->form_validation->set_rules('produto', 'Produto', 'trim|required');

        if ($this->form_validation->run() == false) {
            echo json_encode(['result' => false, 'messages' => 'Dados inválidos']);
            return;
        }

        $idProduto = $this->input->post('idProduto');
        $idVendas = $this->input->post('idVendas');
        $quantidade = $this->input->post('quantidade');
        $produto = $this->input->post('produto');

        $editavel = $this->vendas_model->isEditable($idVendas);
        if (!$editavel) {
            return $this->output
                ->set_content_type('application/json')
                ->set_status_header(422)
                ->set_output(json_encode(['result' => false, 'messages' => '<br /><br /> <strong>Motivo:</strong> Venda já faturada']));
        }

        $this->db->trans_start();

        $this->vendas_model->delete('itens_de_vendas', 'idItens', $idProduto);

        if ($this->data['configuration']['control_estoque']) {
            $this->load->model('produtos_model');
            $this->produtos_model->updateEstoque($produto, $quantidade, '+');
        }

        $this->db->set('desconto', 0.00);
        $this->db->set('valor_desconto', 0.00);
        $this->db->set('tipo_desconto', null);
        $this->db->where('idVendas', $idVendas);
        $this->db->update('vendas');

        if ($this->db->trans_status() === false) {
            $this->db->trans_rollback();
            echo json_encode(['result' => false, 'messages' => 'Erro ao excluir o produto']);
        } else {
            $this->db->trans_complete();
            log_info('Removeu produto da venda. ID da Venda: ' . $idVendas . ', ID do Produto: ' . $idProduto);
            echo json_encode(['result' => true, 'messages' => 'Produto removido com sucesso']);
        }
    }

    public function adicionarDesconto()
    {
        if ($this->input->post('desconto') == '') {
            return $this->output
                ->set_content_type('application/json')
                ->set_status_header(400)
                ->set_output(json_encode(['messages' => 'Campo desconto vazio']));
        } else {
            $idVendas = $this->input->post('idVendas');
            $data = [
                'desconto' => $this->input->post('desconto'),
                'tipo_desconto' => $this->input->post('tipoDesconto'),
                'valor_desconto' => $this->input->post('resultado'),
            ];
            $editavel = $this->vendas_model->isEditable($idVendas);
            if (! $editavel) {
                return $this->output
                    ->set_content_type('application/json')
                    ->set_status_header(400)
                    ->set_output(json_encode(['result' => false, 'messages', 'Desconto não pode ser adiciona. Venda não ja Faturada/Cancelada']));
            }
            if ($this->vendas_model->edit('vendas', $data, 'idVendas', $idVendas) == true) {
                log_info('Adicionou um desconto na Venda. ID: ' . $idVendas);

                return $this->output
                    ->set_content_type('application/json')
                    ->set_status_header(201)
                    ->set_output(json_encode(['result' => true, 'messages' => 'Desconto adicionado com sucesso!']));
            } else {
                log_info('Ocorreu um erro ao tentar adiciona desconto a Venda: ' . $idVendas);

                return $this->output
                    ->set_content_type('application/json')
                    ->set_status_header(400)
                    ->set_output(json_encode(['result' => false, 'messages', 'Ocorreu um erro ao tentar adiciona desconto a Venda.']));
            }
        }

        return $this->output
            ->set_content_type('application/json')
            ->set_status_header(400)
            ->set_output(json_encode(['result' => false, 'messages', 'Ocorreu um erro ao tentar adiciona desconto a OS.']));
    }

    public function faturar()
    {
        if (!$this->permission->checkPermission($this->session->userdata('permissao'), 'eVenda')) {
            $this->session->set_flashdata('error', 'Você não tem permissão para editar Vendas');
            redirect(base_url());
        }

        $this->load->library('form_validation');
        $this->data['custom_error'] = '';

        if ($this->form_validation->run('receita') == false) {
            $this->data['custom_error'] = (validation_errors() ? '<div class="form_error">' . validation_errors() . '</div>' : false);
        } else {
            $venda_id = $this->input->post('vendas_id');
            $vencimento = $this->input->post('vencimento');
            $recebimento = $this->input->post('recebimento');

            try {
                $vencimento = explode('/', $vencimento);
                $vencimento = $vencimento[2] . '-' . $vencimento[1] . '-' . $vencimento[0];

                if ($recebimento != null) {
                    $recebimento = explode('/', $recebimento);
                    $recebimento = $recebimento[2] . '-' . $recebimento[1] . '-' . $recebimento[0];
                }
            } catch (Exception $e) {
                $vencimento = date('Y-m-d');
            }

            $vendas = $this->vendas_model->getById($venda_id);

            $valorTotal = getAmount($this->input->post('valor'));
            $tipoDesconto = $vendas->tipo_desconto;
            $valorDesconto = $vendas->desconto;

            if ($tipoDesconto == 'percentual') {
                $valorDesconto = $valorTotal * ($valorDesconto / 100);
            } elseif ($tipoDesconto == 'real') {
                $valorDesconto = $valorDesconto;
            } else {
                $valorDesconto = 0;
            }

            $valorDesconto = min($valorTotal, $valorDesconto);
            $valorComDesconto = $valorTotal - $valorDesconto;

            // Pagamento parcial / múltiplas formas de pagamento (opcional) — mesmo
            // mecanismo usado em Os::faturar(). Se 'pagamentos' (JSON:
            // [{forma_pgto,valor}, ...]) vier preenchido, cada item vira um
            // lançamento já baixado; se a soma for menor que o total da venda, o
            // restante vira mais um lançamento em aberto (baixado=0), pendente no
            // financeiro. Sem 'pagamentos', funciona exatamente como antes.
            $pagamentosRaw = json_decode((string) $this->input->post('pagamentos'), true);
            $usarSplit = is_array($pagamentosRaw) && count($pagamentosRaw) > 0;

            $descricao = $this->input->post('descricao');
            $clientesId = $this->input->post('clientes_id');
            $clienteFornecedor = $this->input->post('cliente');
            $usuarioId = $this->session->userdata('id_admin');

            $linhasLancamento = [];

            if ($usarSplit) {
                $somaPagamentos = 0;
                foreach ($pagamentosRaw as $p) {
                    $valorItem = round((float) ($p['valor'] ?? 0), 2);
                    if ($valorItem <= 0) {
                        continue;
                    }
                    $valorItem = min($valorItem, max(0, $valorComDesconto - $somaPagamentos));
                    if ($valorItem <= 0) {
                        continue;
                    }
                    $somaPagamentos += $valorItem;

                    $linhasLancamento[] = [
                        'vendas_id' => $venda_id,
                        'descricao' => $descricao,
                        'valor' => $valorItem,
                        'desconto' => 0,
                        'tipo_desconto' => 'real',
                        'valor_desconto' => $valorItem,
                        'clientes_id' => $clientesId,
                        'data_vencimento' => $vencimento,
                        'data_pagamento' => $recebimento ?: date('Y-m-d'),
                        'baixado' => true,
                        'cliente_fornecedor' => $clienteFornecedor,
                        'forma_pgto' => $p['forma_pgto'] ?? null,
                        'tipo' => 'receita',
                        'usuarios_id' => $usuarioId,
                    ];
                }

                $restante = round($valorComDesconto - $somaPagamentos, 2);
                if ($restante > 0.009) {
                    $linhasLancamento[] = [
                        'vendas_id' => $venda_id,
                        'descricao' => $descricao,
                        'valor' => $restante,
                        'desconto' => 0,
                        'tipo_desconto' => 'real',
                        'valor_desconto' => $restante,
                        'clientes_id' => $clientesId,
                        'data_vencimento' => $vencimento,
                        'data_pagamento' => null,
                        'baixado' => false,
                        'cliente_fornecedor' => $clienteFornecedor,
                        'forma_pgto' => null,
                        'tipo' => 'receita',
                        'usuarios_id' => $usuarioId,
                    ];
                }

                if (empty($linhasLancamento)) {
                    $usarSplit = false;
                }
            }

            if (!$usarSplit) {
                $linhasLancamento = [[
                    'vendas_id' => $venda_id,
                    'descricao' => $descricao,
                    'valor' => $valorTotal,
                    'desconto' => $vendas->desconto,
                    'tipo_desconto' => 'real',
                    'valor_desconto' => $valorComDesconto,
                    'clientes_id' => $clientesId,
                    'data_vencimento' => $vencimento,
                    'data_pagamento' => $recebimento,
                    'baixado' => $this->input->post('recebido') == 1 ? true : false,
                    'cliente_fornecedor' => $clienteFornecedor,
                    'forma_pgto' => $this->input->post('formaPgto'),
                    'tipo' => 'receita',
                    'usuarios_id' => $usuarioId,
                ]];
            }

            $this->db->trans_start();

            $idLancamentos = null;
            $todosInseridos = true;
            foreach ($linhasLancamento as $linha) {
                $this->db->insert('lancamentos', $linha);
                $idInserido = $this->db->insert_id();
                if (!$idInserido) {
                    $todosInseridos = false;
                    break;
                }
                if ($idLancamentos === null) {
                    $idLancamentos = $idInserido;
                }
            }

            if ($todosInseridos && $idLancamentos) {
                $this->db->set('faturado', 1);
                $this->db->set('valorTotal', $valorTotal);
                $this->db->set('desconto', $vendas->desconto);
                $this->db->set('valor_desconto', $valorComDesconto);
                $this->db->set('lancamentos_id', $idLancamentos);
                $this->db->set('status', 'Faturado');
                $this->db->where('idVendas', $venda_id);
                $this->db->update('vendas');

                log_info('Faturou a venda com ID.' . $venda_id);

                $this->db->trans_complete();

                if ($this->db->trans_status() === false) {
                    $this->session->set_flashdata('error', 'Ocorreu um erro ao tentar faturar venda.');
                    $json = ['result' => false];
                } else {
                    $this->session->set_flashdata('success', 'Venda faturada com sucesso!');
                    $json = ['result' => true];
                }
            } else {
                $this->db->trans_rollback();
                $this->session->set_flashdata('error', 'Ocorreu um erro ao tentar faturar venda.');
                $json = ['result' => false];
            }

            echo json_encode($json);
            exit();
        }

        $this->session->set_flashdata('error', 'Ocorreu um erro ao tentar faturar venda.');
        $json = ['result' => false];
        echo json_encode($json);
    }

    public function validarCPF($cpf)
    {
        $cpf = preg_replace('/[^0-9]/', '', $cpf);
        if (strlen($cpf) !== 11 || preg_match('/^(\d)\1+$/', $cpf)) {
            return false;
        }
        $soma1 = 0;
        for ($i = 0; $i < 9; $i++) {
            $soma1 += $cpf[$i] * (10 - $i);
        }
        $resto1 = $soma1 % 11;
        $dv1 = ($resto1 < 2) ? 0 : 11 - $resto1;
        if ($dv1 != $cpf[9]) {
            return false;
        }
        $soma2 = 0;
        for ($i = 0; $i < 10; $i++) {
            $soma2 += $cpf[$i] * (11 - $i);
        }
        $resto2 = $soma2 % 11;
        $dv2 = ($resto2 < 2) ? 0 : 11 - $resto2;
    
        return $dv2 == $cpf[10];
    }
    
    public function validarCNPJ($cnpj)
    {
        $cnpj = preg_replace('/[^0-9]/', '', $cnpj);
        if (strlen($cnpj) !== 14 || preg_match('/^(\d)\1+$/', $cnpj)) {
            return false;
        }
        $soma1 = 0;
        for ($i = 0, $pos = 5; $i < 12; $i++, $pos--) {
            $pos = ($pos < 2) ? 9 : $pos;
            $soma1 += $cnpj[$i] * $pos;
        }
        $dv1 = ($soma1 % 11 < 2) ? 0 : 11 - ($soma1 % 11);
        if ($dv1 != $cnpj[12]) {
            return false;
        }
        $soma2 = 0;
        for ($i = 0, $pos = 6; $i < 13; $i++, $pos--) {
            $pos = ($pos < 2) ? 9 : $pos;
            $soma2 += $cnpj[$i] * $pos;
        }
        $dv2 = ($soma2 % 11 < 2) ? 0 : 11 - ($soma2 % 11);
    
        return $dv2 == $cnpj[13];
    }
    
    public function formatarChave($chave)
    {
        if ($this->validarCPF($chave)) {
            return substr($chave, 0, 3) . '.' . substr($chave, 3, 3) . '.' . substr($chave, 6, 3) . '-' . substr($chave, 9);
        } elseif ($this->validarCNPJ($chave)) {
            return substr($chave, 0, 2) . '.' . substr($chave, 2, 3) . '.' . substr($chave, 5, 3) . '/' . substr($chave, 8, 4) . '-' . substr($chave, 12);
        } elseif (strlen($chave) === 11) {
            return '(' . substr($chave, 0, 2) . ') ' . substr($chave, 2, 5) . '-' . substr($chave, 7);
        }
        return $chave;
    }

    public function visualizarVenda($id)
    {
        $venda = $this->Vendas_model->getById($id);
        $produtos = $this->Vendas_model->getProdutos($id);
        $total = $this->Vendas_model->getTotalVendas($id);
        
        $data['venda'] = $venda;
        $data['produtos'] = $produtos;
        $data['total'] = $total;

        $this->load->view('vendas/vendas', $data);
    }


    /**
     * Cancelar venda faturada — devolve estoque e remove lançamento
     */
    public function cancelar()
    {
        if (!$this->permission->checkPermission($this->session->userdata('permissao'), 'eVenda')) {
            $this->session->set_flashdata('error', 'Você não tem permissão para cancelar vendas.');
            redirect(base_url());
        }

        $id = $this->input->post('id');
        if (!$id || !is_numeric($id)) {
            $this->session->set_flashdata('error', 'Venda inválida.');
            redirect(site_url('vendas/'));
        }

        $venda = $this->vendas_model->getById($id);
        if (!$venda) {
            $this->session->set_flashdata('error', 'Venda não encontrada.');
            redirect(site_url('vendas/'));
        }

        if ($venda->status === 'Cancelado') {
            $this->session->set_flashdata('error', 'Venda já está cancelada.');
            redirect(site_url('vendas/visualizar/' . $id));
        }

        // 1. Devolver estoque
        if ($this->data['configuration']['control_estoque']) {
            $this->load->model('produtos_model');
            $itens = $this->db->where('vendas_id', $id)->get('itens_de_vendas')->result();
            foreach ($itens as $item) {
                if ($item->produtos_id) {
                    $this->produtos_model->updateEstoque($item->produtos_id, $item->quantidade, '+');
                    log_info("ESTOQUE: Produto id {$item->produtos_id} voltou ao estoque. Quantidade: {$item->quantidade}. Motivo: Cancelamento Venda #{$id}");
                }
            }
        }

        // 2. Excluir lançamento financeiro vinculado
        $this->db->where('vendas_id', $id)->delete('lancamentos');

        // 3. Mudar status para Cancelado
        $motivo = $this->input->post('motivo') ?: 'Cancelado manualmente';
        $this->db->where('idVendas', $id)->update('vendas', [
            'status'      => 'Cancelado',
            'faturado'    => 0,
            'observacoes' => trim(($venda->observacoes ?? '') . "
[CANCELADO em " . date('d/m/Y H:i') . " por " . $this->session->userdata('nome') . "] " . $motivo),
        ]);

        log_info("Venda #{$id} cancelada. Motivo: {$motivo}. Estoque devolvido.");
        $this->session->set_flashdata('success', "Venda #{$id} cancelada com sucesso. Estoque devolvido.");
        redirect(site_url('vendas/visualizar/' . $id));
    }

}
