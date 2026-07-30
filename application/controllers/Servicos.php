<?php

if (! defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Servicos extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->load->helper('form');
        $this->load->model('servicos_model');
        $this->data['menuServicos'] = 'Serviços';
    }

    public function index()
    {
        $this->gerenciar();
    }

    public function gerenciar()
    {
        if (! $this->permission->checkPermission($this->session->userdata('permissao'), 'vServico')) {
            $this->session->set_flashdata('error', 'Você não tem permissão para visualizar serviços.');
            redirect(base_url());
        }

        $pesquisa = $this->input->get('pesquisa');
        $perPage = 24;

        $this->_aplicarFiltrosServicos($pesquisa);
        $this->db->order_by('idServicos', 'DESC');
        $this->db->limit($perPage, 0);
        $this->data['results'] = $this->db->get('servicos')->result();

        $this->_aplicarFiltrosServicos($pesquisa);
        $this->data['statTotalFiltrado'] = $this->db->count_all_results('servicos');

        $this->data['perPage'] = $perPage;
        $this->data['pesquisa'] = $pesquisa;
        $this->data['view'] = 'servicos/servicos';

        return $this->layout();
    }

    /**
     * Endpoint AJAX chamado pela rolagem infinita da lista de serviços.
     */
    public function carregarMais()
    {
        if (! $this->permission->checkPermission($this->session->userdata('permissao'), 'vServico')) {
            return;
        }

        $pesquisa = $this->input->get('pesquisa');
        $antesDe = (int) $this->input->get('antes_de');
        $perPage = 24;

        $this->_aplicarFiltrosServicos($pesquisa);
        if ($antesDe > 0) $this->db->where('idServicos <', $antesDe);
        $this->db->order_by('idServicos', 'DESC');
        $this->db->limit($perPage, 0);
        $results = $this->db->get('servicos')->result();

        echo $this->load->view('servicos/_table_rows_partial', ['results' => $results, 'semResultadosOculto' => true], true);
    }

    private function _aplicarFiltrosServicos($pesquisa)
    {
        if ($pesquisa) {
            $this->db->group_start();
            $this->db->like('nome', $pesquisa);
            $this->db->or_like('descricao', $pesquisa);
            $this->db->group_end();
        }
    }

    public function adicionar()
    {
        if (! $this->permission->checkPermission($this->session->userdata('permissao'), 'aServico')) {
            $this->session->set_flashdata('error', 'Você não tem permissão para adicionar serviços.');
            redirect(base_url());
        }

        $this->load->library('form_validation');
        $this->data['custom_error'] = '';

        if ($this->form_validation->run('servicos') == false) {
            $this->data['custom_error'] = (validation_errors() ? '<div class="form_error">' . validation_errors() . '</div>' : false);
        } else {
            $preco = $this->input->post('preco');
            $preco = str_replace(',', '', $preco);

            $data = [
                'nome' => $this->input->post('nome'),
                'descricao' => $this->input->post('descricao'),
                'preco' => $preco,
            ];

            if ($this->servicos_model->add('servicos', $data) == true) {
                $this->session->set_flashdata('success', 'Serviço adicionado com sucesso!');
                log_info('Adicionou um serviço');
                redirect(site_url('servicos/adicionar/'));
            } else {
                $this->data['custom_error'] = '<div class="form_error"><p>Ocorreu um erro.</p></div>';
            }
        }
        $this->data['view'] = 'servicos/adicionarServico';

        return $this->layout();
    }

    public function editar()
    {
        if (! $this->uri->segment(3) || ! is_numeric($this->uri->segment(3)) || ! $this->servicos_model->getById($this->uri->segment(3))) {
            $this->session->set_flashdata('error', 'Serviço não encontrado ou parâmetro inválido.');
            redirect('servicos/gerenciar');
        }

        if (! $this->permission->checkPermission($this->session->userdata('permissao'), 'eServico')) {
            $this->session->set_flashdata('error', 'Você não tem permissão para editar serviços.');
            redirect(base_url());
        }
        $this->load->library('form_validation');
        $this->data['custom_error'] = '';

        if ($this->form_validation->run('servicos') == false) {
            $this->data['custom_error'] = (validation_errors() ? '<div class="form_error">' . validation_errors() . '</div>' : false);
        } else {
            $preco = $this->input->post('preco');
            $preco = str_replace(',', '', $preco);
            $data = [
                'nome' => $this->input->post('nome'),
                'descricao' => $this->input->post('descricao'),
                'preco' => $preco,
            ];

            if ($this->servicos_model->edit('servicos', $data, 'idServicos', $this->input->post('idServicos')) == true) {
                $this->session->set_flashdata('success', 'Serviço editado com sucesso!');
                log_info('Alterou um serviço. ID: ' . $this->input->post('idServicos'));
                redirect(site_url('servicos/editar/') . $this->input->post('idServicos'));
            } else {
                $this->data['custom_error'] = '<div class="form_error"><p>Ocorreu um errro.</p></div>';
            }
        }

        $this->data['result'] = $this->servicos_model->getById($this->uri->segment(3));

        $this->data['view'] = 'servicos/editarServico';

        return $this->layout();
    }

    public function excluir()
    {
        if (! $this->permission->checkPermission($this->session->userdata('permissao'), 'dServico')) {
            $this->session->set_flashdata('error', 'Você não tem permissão para excluir serviços.');
            redirect(base_url());
        }

        $id = $this->input->post('id');
        if ($id == null) {
            $this->session->set_flashdata('error', 'Erro ao tentar excluir serviço.');
            redirect(site_url('servicos/gerenciar/'));
        }

        $this->servicos_model->delete('servicos_os', 'servicos_id', $id);
        $this->servicos_model->delete('servicos', 'idServicos', $id);

        log_info('Removeu um serviço. ID: ' . $id);

        $this->session->set_flashdata('success', 'Serviço excluido com sucesso!');
        redirect(site_url('servicos/gerenciar/'));
    }
}
