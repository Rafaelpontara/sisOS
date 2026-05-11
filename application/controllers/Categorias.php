<?php if (!defined('BASEPATH')) { exit('No direct script access allowed'); }

class Categorias extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('categorias_model');
    }

    /** Retorna todas as categorias de um tipo como JSON (para selects) */
    public function getJson($tipo = null)
    {
        $grupos = $this->categorias_model->getParaSelect($tipo);
        header('Content-Type: application/json');
        echo json_encode($grupos);
    }

    /** CRUD via AJAX para uso na tela de configurações */
    public function adicionar()
    {
        if (!$this->permission->checkPermission($this->session->userdata('permissao'), 'cSistema')) {
            echo json_encode(['result' => false, 'messages' => 'Sem permissão.']); return;
        }
        $data = [
            'categoria' => trim($this->input->post('categoria')),
            'tipo'      => $this->input->post('tipo'),
            'parent_id' => $this->input->post('parent_id') ?: null,
            'status'    => 1,
            'cadastro'  => date('Y-m-d'),
        ];
        if (!$data['categoria'] || !$data['tipo']) {
            echo json_encode(['result' => false, 'messages' => 'Nome e tipo são obrigatórios.']); return;
        }
        $id = $this->categorias_model->add($data);
        echo json_encode(['result' => (bool)$id, 'id' => $id, 'nome' => $data['categoria']]);
    }

    public function editar()
    {
        if (!$this->permission->checkPermission($this->session->userdata('permissao'), 'cSistema')) {
            echo json_encode(['result' => false]); return;
        }
        $id   = $this->input->post('id');
        $nome = trim($this->input->post('categoria'));
        if (!$id || !$nome) { echo json_encode(['result' => false]); return; }

        $this->categorias_model->edit($id, ['categoria' => $nome]);
        echo json_encode(['result' => true, 'nome' => $nome]);
    }

    public function excluir()
    {
        if (!$this->permission->checkPermission($this->session->userdata('permissao'), 'cSistema')) {
            echo json_encode(['result' => false]); return;
        }
        $id = $this->input->post('id');
        $this->categorias_model->delete($id);
        echo json_encode(['result' => true]);
    }
}
