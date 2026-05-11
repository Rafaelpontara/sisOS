<?php if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Notafiscal extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('sisos_model');
        $this->load->model('os_model');
        $this->load->model('vendas_model');
    }

    /**
     * Emite NF-e a partir de uma OS
     * Chamado via POST /notafiscal/emitirOs
     */
    public function emitirOs()
    {
        if (!$this->permission->checkPermission($this->session->userdata('permissao'), 'vOs')) {
            $this->output->set_status_header(403);
            echo json_encode(['sucesso' => false, 'erro' => 'Sem permissão.']);
            return;
        }

        $config = $this->sisos_model->getConfiguracoes();
        if (empty($config['nfe_enabled']) || $config['nfe_enabled'] == '0') {
            echo json_encode(['sucesso' => false, 'erro' => 'Módulo de Nota Fiscal não está ativo. Ative em Configurações > Nota Fiscal.']);
            return;
        }

        $id = $this->input->post('id');
        if (!$id || !is_numeric($id)) {
            echo json_encode(['sucesso' => false, 'erro' => 'ID da OS inválido.']);
            return;
        }

        // Busca OS com dados do cliente
        $os = $this->os_model->getById($id);
        if (!$os) {
            echo json_encode(['sucesso' => false, 'erro' => 'OS não encontrada.']);
            return;
        }

        $this->load->library('FocusNfe');
        $resultado = $this->focusnfe->emitirNfePorOs($os);

        if ($resultado['sucesso']) {
            log_info('Emitiu NF-e para OS #' . $id . '. Ref: ' . ($resultado['dados']['referencia'] ?? ''));
        }

        header('Content-Type: application/json');
        echo json_encode($resultado);
    }

    /**
     * Emite NF-e a partir de uma Venda
     * Chamado via POST /notafiscal/emitirVenda
     */
    public function emitirVenda()
    {
        if (!$this->permission->checkPermission($this->session->userdata('permissao'), 'vVenda')) {
            $this->output->set_status_header(403);
            echo json_encode(['sucesso' => false, 'erro' => 'Sem permissão.']);
            return;
        }

        $config = $this->sisos_model->getConfiguracoes();
        if (empty($config['nfe_enabled']) || $config['nfe_enabled'] == '0') {
            echo json_encode(['sucesso' => false, 'erro' => 'Módulo de Nota Fiscal não está ativo. Ative em Configurações > Nota Fiscal.']);
            return;
        }

        $id = $this->input->post('id');
        if (!$id || !is_numeric($id)) {
            echo json_encode(['sucesso' => false, 'erro' => 'ID da Venda inválido.']);
            return;
        }

        $venda = $this->vendas_model->getById($id);
        if (!$venda) {
            echo json_encode(['sucesso' => false, 'erro' => 'Venda não encontrada.']);
            return;
        }

        $this->load->library('FocusNfe');
        $resultado = $this->focusnfe->emitirNfePorVenda($venda);

        if ($resultado['sucesso']) {
            log_info('Emitiu NF-e para Venda #' . $id . '. Ref: ' . ($resultado['dados']['referencia'] ?? ''));
        }

        header('Content-Type: application/json');
        echo json_encode($resultado);
    }

    /**
     * Consulta status de uma NF-e
     * GET /notafiscal/consultar?referencia=OS00000001
     */
    public function consultar()
    {
        $referencia = $this->input->get('referencia');
        if (!$referencia) {
            echo json_encode(['sucesso' => false, 'erro' => 'Referência não informada.']);
            return;
        }

        $this->load->library('FocusNfe');
        $resultado = $this->focusnfe->consultarNfe($referencia);

        header('Content-Type: application/json');
        echo json_encode($resultado);
    }

    /**
     * Retorna URL do DANFE (PDF)
     * GET /notafiscal/danfe?referencia=OS00000001
     */
    public function danfe()
    {
        $referencia = $this->input->get('referencia');
        if (!$referencia) {
            $this->session->set_flashdata('error', 'Referência não informada.');
            redirect(base_url());
        }

        $this->load->library('FocusNfe');
        redirect($this->focusnfe->urlDanfe($referencia));
    }

    /**
     * Cancela uma NF-e
     * POST /notafiscal/cancelar
     */
    public function cancelar()
    {
        $referencia    = $this->input->post('referencia');
        $justificativa = $this->input->post('justificativa');

        if (!$referencia || !$justificativa) {
            echo json_encode(['sucesso' => false, 'erro' => 'Referência e justificativa são obrigatórias.']);
            return;
        }

        if (strlen($justificativa) < 15) {
            echo json_encode(['sucesso' => false, 'erro' => 'A justificativa deve ter pelo menos 15 caracteres.']);
            return;
        }

        $this->load->library('FocusNfe');
        $resultado = $this->focusnfe->cancelarNfe($referencia, $justificativa);

        if ($resultado['sucesso']) {
            log_info('Cancelou NF-e. Ref: ' . $referencia);
        }

        header('Content-Type: application/json');
        echo json_encode($resultado);
    }

    /**
     * Faz upload de logo/favicon do sistema
     * POST /notafiscal/uploadLogo  ou  /notafiscal/uploadFavicon
     */
    public function uploadLogo()
    {
        $this->_uploadImagem('app_logo', 'logo_sistema');
    }

    public function uploadFavicon()
    {
        $this->_uploadImagem('app_favicon', 'favicon_sistema', 'png|ico');
    }

    private function _uploadImagem($configKey, $prefix, $tipos = 'png|jpg|jpeg|svg|webp')
    {
        if (!$this->permission->checkPermission($this->session->userdata('permissao'), 'cSistema')) {
            $this->session->set_flashdata('error', 'Sem permissão.');
            redirect(site_url('sisos/configurar'));
        }

        $pasta = FCPATH . 'assets/img/sistema/';
        if (!file_exists($pasta)) {
            mkdir($pasta, DIR_WRITE_MODE, true);
        }

        $this->load->library('upload');
        $uploadConfig = [
            'upload_path'   => $pasta,
            'allowed_types' => $tipos,
            'max_size'      => 2048,
            'remove_space'  => true,
            'encrypt_name'  => true,
        ];
        $this->upload->initialize($uploadConfig);

        if (!$this->upload->do_upload('arquivo')) {
            $this->session->set_flashdata('error', $this->upload->display_errors('', ''));
        } else {
            $info = $this->upload->data();
            $url  = base_url('assets/img/sistema/' . $info['file_name']);
            $this->sisos_model->saveConfiguracao([$configKey => $url]);
            $this->session->set_flashdata('success', 'Imagem atualizada com sucesso!');
        }

        redirect(site_url('sisos/configurar') . '#home');
    }
}
