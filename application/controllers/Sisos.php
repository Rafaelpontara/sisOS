<?php if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}
class Sisos extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('sisos_model');
    }

    public function index()
    {
        $status = ['Em Andamento', 'Aguardando Peças'];
        $this->data['ordens_status'] = $this->sisos_model->getOsStatus($status);
        // Real dashboard stats
        $this->data['os_hoje']        = $this->sisos_model->getOsHoje();
        $this->data['os_vencidas']    = $this->sisos_model->getOsVencidas();
        $this->data['receita_hoje']   = $this->sisos_model->getReceitaHoje();
        $this->data['estoque_baixo']  = $this->sisos_model->getEstoqueBaixo();
        $this->data['os_por_status']  = $this->sisos_model->getOsPorStatus();
        $this->data['os_por_tecnico'] = $this->sisos_model->getOsPorTecnico();
        $this->data['notificacoes']   = $this->sisos_model->getNotificacoes();
        $vstatus = ['Aberto', 'Em Andamento', 'Aguardando Peças', 'Aprovado', 'Orçamento'];
        $this->data['vendasstatus'] = $this->sisos_model->getVendasStatus($vstatus);
        $this->data['lancamentos'] = $this->sisos_model->getLancamentos();
        $this->data['ordens_orcamentos'] = $this->sisos_model->getOsOrcamentos();
        $this->data['ordens_abertas'] = $this->sisos_model->getOsAbertas();
        $this->data['ordens_aprovadas'] = $this->sisos_model->getOsAprovadas();
        $this->data['ordens_finalizadas'] = $this->sisos_model->getOsFinalizadas();
        $this->data['ordens_aguardando'] = $this->sisos_model->getOsAguardandoPecas();
        $this->data['ordens_andamento'] = $this->sisos_model->getOsAndamento();
        $this->data['produtos'] = $this->sisos_model->getProdutosMinimo();
        $this->data['os'] = $this->sisos_model->getOsEstatisticas();
        $this->data['estatisticas_financeiro'] = $this->sisos_model->getEstatisticasFinanceiro();
        $this->data['financeiro_mes_dia'] = $this->sisos_model->getEstatisticasFinanceiroDia($this->input->get('year'));
        $this->data['financeiro_mes'] = $this->sisos_model->getEstatisticasFinanceiroMes($this->input->get('year'));
        $this->data['financeiro_mesinadipl'] = $this->sisos_model->getEstatisticasFinanceiroMesInadimplencia($this->input->get('year'));
        $this->data['menuPainel'] = 'Painel';
        $this->data['view'] = 'sisos/painel';

        return $this->layout();
    }

    public function trocarTema($tema = null)
    {
        $temas_validos = ['white', 'puredark', 'darkviolet', 'darkorange', 'whitegreen', 'whiteblack'];
        if ($tema && in_array($tema, $temas_validos)) {
            $this->load->model('sisos_model');
            $this->sisos_model->saveConfiguracao(['app_theme' => $tema]);
            $this->session->set_flashdata('success', 'Tema alterado com sucesso!');
        }
        redirect(base_url());
    }

    public function getNotificacoes()
    {
        $notifs = $this->sisos_model->getNotificacoes();
        header('Content-Type: application/json');
        echo json_encode(['notifs' => $notifs]);
        exit();
    }

    public function minhaConta()
    {
        $this->data['usuario'] = $this->sisos_model->getById($this->session->userdata('id_admin'));
        $this->data['view'] = 'sisos/minhaConta';

        return $this->layout();
    }

    public function alterarSenha()
    {
        $current_user = $this->sisos_model->getById($this->session->userdata('id_admin'));

        if (!$current_user) {
            $this->session->set_flashdata('error', 'Ocorreu um erro ao pesquisar usuário!');
            redirect(site_url('sisos/minhaConta'));
        }

        $oldSenha = $this->input->post('oldSenha');
        $senha = $this->input->post('novaSenha');

        if (!password_verify($oldSenha, $current_user->senha)) {
            $this->session->set_flashdata('error', 'A senha atual não corresponde com a senha informada.');
            redirect(site_url('sisos/minhaConta'));
        }

        $result = $this->sisos_model->alterarSenha($senha);

        if ($result) {
            $this->session->set_flashdata('success', 'Senha alterada com sucesso!');
            redirect(site_url('sisos/minhaConta'));
        }

        $this->session->set_flashdata('error', 'Ocorreu um erro ao tentar alterar a senha!');
        redirect(site_url('sisos/minhaConta'));
    }

    public function pesquisar()
    {
        $termo = $this->input->get('termo');

        $data['results'] = $this->sisos_model->pesquisar($termo);
        $this->data['produtos'] = $data['results']['produtos'];
        $this->data['servicos'] = $data['results']['servicos'];
        $this->data['os'] = $data['results']['os'];
        $this->data['clientes'] = $data['results']['clientes'];
        $this->data['vendas'] = $data['results']['vendas'] ?? [];
        $this->data['termo'] = $termo;
        $this->data['view'] = 'sisos/pesquisa';

        return $this->layout();
    }

    public function backup()
    {
        if (!$this->permission->checkPermission($this->session->userdata('permissao'), 'cBackup')) {
            $this->session->set_flashdata('error', 'Você não tem permissão para efetuar backup.');
            redirect(base_url());
        }

        $this->load->dbutil();
        $prefs = [
            'format' => 'zip',
            'foreign_key_checks' => false,
            'filename' => 'backup' . date('d-m-Y') . '.sql',
        ];

        $backup = $this->dbutil->backup($prefs);

        $this->load->helper('file');
        write_file(base_url() . 'backup/backup.zip', $backup);

        log_info('Efetuou backup do banco de dados.');

        $this->load->helper('download');
        force_download('backup' . date('d-m-Y H:m:s') . '.zip', $backup);
    }

    public function emitente()
    {
        if (!$this->permission->checkPermission($this->session->userdata('permissao'), 'cEmitente')) {
            $this->session->set_flashdata('error', 'Você não tem permissão para configurar emitente.');
            redirect(base_url());
        }

        $this->data['menuConfiguracoes'] = 'Configuracoes';
        $this->data['dados'] = $this->sisos_model->getEmitente();
        $this->data['view'] = 'sisos/emitente';

        return $this->layout();
    }

    public function do_upload()
    {
        if (!$this->permission->checkPermission($this->session->userdata('permissao'), 'cEmitente')) {
            $this->session->set_flashdata('error', 'Você não tem permissão para configurar emitente.');
            redirect(base_url());
        }

        $this->load->library('upload');

        $image_upload_folder = FCPATH . 'assets/uploads';

        if (!file_exists($image_upload_folder)) {
            mkdir($image_upload_folder, DIR_WRITE_MODE, true);
        }

        $this->upload_config = [
            'upload_path' => $image_upload_folder,
            'allowed_types' => 'png|jpg|jpeg|bmp|svg',
            'max_size' => 2048,
            'remove_space' => true,
            'encrypt_name' => true,
        ];

        $this->upload->initialize($this->upload_config);

        if (!$this->upload->do_upload()) {
            $upload_error = $this->upload->display_errors();
            $this->session->set_flashdata('error', $upload_error);
            redirect(site_url('sisos/configurar'));
        } else {
            $file_info = [$this->upload->data()];

            return $file_info[0]['file_name'];
        }
    }

    public function do_upload_user()
    {
        if (!$this->permission->checkPermission($this->session->userdata('permissao'), 'cEmitente')) {
            $this->session->set_flashdata('error', 'Você não tem permissão para configurar emitente.');
            redirect(base_url());
        }

        $this->load->library('upload');

        $image_upload_folder = FCPATH . 'assets/userImage/';

        if (!file_exists($image_upload_folder)) {
            mkdir($image_upload_folder, DIR_WRITE_MODE, true);
        }

        $this->upload_config = [
            'upload_path' => $image_upload_folder,
            'allowed_types' => 'png|jpg|jpeg|bmp',
            'max_size' => 2048,
            'remove_space' => true,
            'encrypt_name' => true,
        ];

        $this->upload->initialize($this->upload_config);

        if (!$this->upload->do_upload()) {
            $upload_error = $this->upload->display_errors();
            $this->session->set_flashdata('error', $upload_error);
            redirect(site_url('sisos/configurar'));
        } else {
            $file_info = [$this->upload->data()];

            return $file_info[0]['file_name'];
        }
    }

    public function cadastrarEmitente()
    {
        if (!$this->permission->checkPermission($this->session->userdata('permissao'), 'cEmitente')) {
            $this->session->set_flashdata('error', 'Você não tem permissão para configurar emitente.');
            redirect(base_url());
        }

        $this->load->library('form_validation');
        $this->form_validation->set_rules('nome', 'Razão Social', 'required|trim');
        $this->form_validation->set_rules('cnpj', 'CNPJ', 'required|trim');
        $this->form_validation->set_rules('ie', 'IE', 'trim');
        $this->form_validation->set_rules('cep', 'CEP', 'required|trim');
        $this->form_validation->set_rules('logradouro', 'Logradouro', 'required|trim');
        $this->form_validation->set_rules('numero', 'Número', 'required|trim');
        $this->form_validation->set_rules('bairro', 'Bairro', 'required|trim');
        $this->form_validation->set_rules('cidade', 'Cidade', 'required|trim');
        $this->form_validation->set_rules('uf', 'UF', 'required|trim');
        $this->form_validation->set_rules('telefone', 'Telefone', 'required|trim');
        $this->form_validation->set_rules('email', 'E-mail', 'required|trim');

        if ($this->form_validation->run() == false) {
            $this->session->set_flashdata('error', 'Campos obrigatórios não foram preenchidos.');
            redirect(site_url('sisos/emitente'));
        } else {
            $nome = $this->input->post('nome');
            $cnpj = $this->input->post('cnpj');
            $ie = $this->input->post('ie');
            $cep = $this->input->post('cep');
            $logradouro = $this->input->post('logradouro');
            $numero = $this->input->post('numero');
            $bairro = $this->input->post('bairro');
            $cidade = $this->input->post('cidade');
            $uf = $this->input->post('uf');
            $telefone = $this->input->post('telefone');
            $email = $this->input->post('email');
            $image = $this->do_upload();
            $logo = base_url() . 'assets/uploads/' . $image;

            $retorno = $this->sisos_model->addEmitente($nome, $cnpj, $ie, $cep, $logradouro, $numero, $bairro, $cidade, $uf, $telefone, $email, $logo);
            if ($retorno) {
                $this->session->set_flashdata('success', 'As informações foram inseridas com sucesso.');
                log_info('Adicionou informações de emitente.');
            } else {
                $this->session->set_flashdata('error', 'Ocorreu um erro ao tentar inserir as informações.');
            }
            redirect(site_url('sisos/emitente'));
        }
    }

    public function editarEmitente()
    {
        if (!$this->permission->checkPermission($this->session->userdata('permissao'), 'cEmitente')) {
            $this->session->set_flashdata('error', 'Você não tem permissão para configurar emitente.');
            redirect(base_url());
        }

        $this->load->library('form_validation');
        $this->form_validation->set_rules('nome', 'Razão Social', 'required|trim');
        $this->form_validation->set_rules('cnpj', 'CNPJ', 'required|trim');
        $this->form_validation->set_rules('ie', 'IE', 'trim');
        $this->form_validation->set_rules('cep', 'CEP', 'required|trim');
        $this->form_validation->set_rules('logradouro', 'Logradouro', 'required|trim');
        $this->form_validation->set_rules('numero', 'Número', 'required|trim');
        $this->form_validation->set_rules('bairro', 'Bairro', 'required|trim');
        $this->form_validation->set_rules('cidade', 'Cidade', 'required|trim');
        $this->form_validation->set_rules('uf', 'UF', 'required|trim');
        $this->form_validation->set_rules('telefone', 'Telefone', 'required|trim');
        $this->form_validation->set_rules('email', 'E-mail', 'required|trim');

        if ($this->form_validation->run() == false) {
            $this->session->set_flashdata('error', 'Campos obrigatórios não foram preenchidos.');
            redirect(site_url('sisos/emitente'));
        } else {
            $nome = $this->input->post('nome');
            $cnpj = $this->input->post('cnpj');
            $ie = $this->input->post('ie');
            $cep = $this->input->post('cep');
            $logradouro = $this->input->post('logradouro');
            $numero = $this->input->post('numero');
            $bairro = $this->input->post('bairro');
            $cidade = $this->input->post('cidade');
            $uf = $this->input->post('uf');
            $telefone = $this->input->post('telefone');
            $email = $this->input->post('email');
            $id = $this->input->post('id');

            $retorno = $this->sisos_model->editEmitente($id, $nome, $cnpj, $ie, $cep, $logradouro, $numero, $bairro, $cidade, $uf, $telefone, $email);
            if ($retorno) {
                $this->session->set_flashdata('success', 'As informações foram alteradas com sucesso.');
                log_info('Alterou informações de emitente.');
            } else {
                $this->session->set_flashdata('error', 'Ocorreu um erro ao tentar alterar as informações.');
            }
            redirect(site_url('sisos/emitente'));
        }
    }

    public function editarLogo()
    {
        if (!$this->permission->checkPermission($this->session->userdata('permissao'), 'cEmitente')) {
            $this->session->set_flashdata('error', 'Você não tem permissão para configurar emitente.');
            redirect(base_url());
        }

        $id = $this->input->post('id');
        if ($id == null || !is_numeric($id)) {
            $this->session->set_flashdata('error', 'Ocorreu um erro ao tentar alterar a logomarca.');
            redirect(site_url('sisos/emitente'));
        }
        $this->load->helper('file');
        delete_files(FCPATH . 'assets/uploads/');

        $image = $this->do_upload();
        $logo = base_url() . 'assets/uploads/' . $image;

        $retorno = $this->sisos_model->editLogo($id, $logo);
        if ($retorno) {
            $this->session->set_flashdata('success', 'As informações foram alteradas com sucesso.');
            log_info('Alterou a logomarca do emitente.');
        } else {
            $this->session->set_flashdata('error', 'Ocorreu um erro ao tentar alterar as informações.');
        }
        redirect(site_url('sisos/emitente'));
    }

    public function uploadUserImage()
    {
        if (!$this->permission->checkPermission($this->session->userdata('permissao'), 'cUsuario')) {
            $this->session->set_flashdata('error', 'Você não tem permissão para mudar a foto.');
            redirect(base_url());
        }

        $id = $this->session->userdata('id_admin');
        if ($id == null || !is_numeric($id)) {
            $this->session->set_flashdata('error', 'Ocorreu um erro ao tentar alterar sua foto.');
            redirect(site_url('sisos/minhaConta'));
        }

        $usuario = $this->sisos_model->getById($id);

        if (is_file(FCPATH . 'assets/userImage/' . $usuario->url_image_user)) {
            unlink(FCPATH . 'assets/userImage/' . $usuario->url_image_user);
        }

        $image = $this->do_upload_user();
        $imageUserPath = $image;
        $retorno = $this->sisos_model->editImageUser($id, $imageUserPath);

        if ($retorno) {
            $this->session->set_userdata('url_image_user', $imageUserPath);
            $this->session->set_flashdata('success', 'Foto alterada com sucesso.');
            log_info('Alterou a Imagem do Usuario.');
        } else {
            $this->session->set_flashdata('error', 'Ocorreu um erro ao tentar alterar sua foto.');
        }
        redirect(site_url('sisos/minhaConta'));
    }

    public function emails()
    {
        if (!$this->permission->checkPermission($this->session->userdata('permissao'), 'cEmail')) {
            $this->session->set_flashdata('error', 'Você não tem permissão para visualizar fila de e-mails');
            redirect(base_url());
        }

        $this->data['menuConfiguracoes'] = 'Email';

        $this->load->library('pagination');
        $this->load->model('email_model');

        $this->data['configuration']['base_url'] = site_url('sisos/emails/');
        $this->data['configuration']['total_rows'] = $this->email_model->count('email_queue');

        $this->pagination->initialize($this->data['configuration']);

        $this->data['results'] = $this->email_model->get('email_queue', '*', '', $this->data['configuration']['per_page'], $this->uri->segment(3));

        $this->data['view'] = 'emails/emails';

        return $this->layout();
    }

    public function excluirEmail()
    {
        if (!$this->permission->checkPermission($this->session->userdata('permissao'), 'cEmail')) {
            $this->session->set_flashdata('error', 'Você não tem permissão para excluir e-mail da fila.');
            redirect(base_url());
        }

        $id = $this->input->post('id');
        if ($id == null) {
            $this->session->set_flashdata('error', 'Erro ao tentar excluir e-mail da fila.');
            redirect(site_url('sisos/emails/'));
        }

        $this->load->model('email_model');
        $this->email_model->delete('email_queue', 'id', $id);

        log_info('Removeu um e-mail da fila de envio. ID: ' . $id);

        $this->session->set_flashdata('success', 'E-mail removido da fila de envio!');
        redirect(site_url('sisos/emails/'));
    }

    public function configurar()
    {
        if (!$this->permission->checkPermission($this->session->userdata('permissao'), 'cSistema')) {
            $this->session->set_flashdata('error', 'Você não tem permissão para configurar o sistema');
            redirect(base_url());
        }
        $this->data['menuConfiguracoes'] = 'Sistema';

        $this->load->library('form_validation');
        $this->load->model('sisos_model');
        $this->load->model('categorias_model');

        $this->data['custom_error'] = '';

        $this->form_validation->set_rules('app_name', 'Nome do Sistema', 'required|trim');
        $this->form_validation->set_rules('per_page', 'Registros por página', 'required|numeric|trim');
        $this->form_validation->set_rules('app_theme', 'Tema do Sistema', 'required|trim');
        $this->form_validation->set_rules('os_notification', 'Notificação de OS', 'required|trim');
        $this->form_validation->set_rules('email_automatico', 'Enviar Email Automático', 'required|trim');
        $this->form_validation->set_rules('control_estoque', 'Controle de Estoque', 'required|trim');
        $this->form_validation->set_rules('notifica_whats', 'Notificação Whatsapp', 'required|trim');
        $this->form_validation->set_rules('control_baixa', 'Controle de Baixa', 'required|trim');
        $this->form_validation->set_rules('control_editos', 'Controle de Edição de OS', 'required|trim');
        $this->form_validation->set_rules('control_edit_vendas', 'Controle de Edição de Vendas', 'required|trim');
        $this->form_validation->set_rules('control_datatable', 'Controle de Visualização em DataTables', 'required|trim');
        $this->form_validation->set_rules('os_status_list[]', 'Controle de visualização de OS', 'required|trim', ['required' => 'Selecione ao menos uma das opções!']);
        $this->form_validation->set_rules('control_2vias', 'Controle Impressão 2 Vias', 'required|trim');
        $this->form_validation->set_rules('pix_key', 'Chave Pix', 'trim|valid_pix_key', [
            'valid_pix_key' => 'Chave Pix inválida!',
        ]);

        if ($this->form_validation->run() == false) {
            $this->data['custom_error'] = (validation_errors() ? '<div class="alert">' . validation_errors() . '</div>' : false);
        } else {
            // Edição do .env
            $dataDotEnv = [
                'IMPRIMIR_ANEXOS' => $this->input->post('imprmirAnexos'),
                'PAYMENT_GATEWAYS_EFI_PRODUCTION' => $this->input->post('PAYMENT_GATEWAYS_EFI_PRODUCTION'),
                'PAYMENT_GATEWAYS_EFI_CREDENTIAIS_CLIENT_ID' => $this->input->post('PAYMENT_GATEWAYS_EFI_CREDENTIAIS_CLIENT_ID'),
                'PAYMENT_GATEWAYS_EFI_CREDENTIAIS_CLIENT_SECRET' => $this->input->post('PAYMENT_GATEWAYS_EFI_CREDENTIAIS_CLIENT_SECRET'),
                'PAYMENT_GATEWAYS_EFI_BOLETO_EXPIRATION' => $this->input->post('PAYMENT_GATEWAYS_EFI_BOLETO_EXPIRATION'),
                'PAYMENT_GATEWAYS_MERCADO_PAGO_CREDENTIALS_PUBLIC_KEY' => $this->input->post('PAYMENT_GATEWAYS_MERCADO_PAGO_CREDENTIALS_PUBLIC_KEY'),
                'PAYMENT_GATEWAYS_MERCADO_PAGO_CREDENTIALS_ACCESS_TOKEN' => $this->input->post('PAYMENT_GATEWAYS_MERCADO_PAGO_CREDENTIALS_ACCESS_TOKEN'),
                'PAYMENT_GATEWAYS_MERCADO_PAGO_CREDENTIALS_CLIENT_ID' => $this->input->post('PAYMENT_GATEWAYS_MERCADO_PAGO_CREDENTIALS_CLIENT_ID'),
                'PAYMENT_GATEWAYS_MERCADO_PAGO_CREDENTIALS_CLIENT_SECRET' => $this->input->post('PAYMENT_GATEWAYS_MERCADO_PAGO_CREDENTIALS_CLIENT_SECRET'),
                'PAYMENT_GATEWAYS_MERCADO_PAGO_BOLETO_EXPIRATION' => $this->input->post('PAYMENT_GATEWAYS_MERCADO_PAGO_BOLETO_EXPIRATION'),
                'PAYMENT_GATEWAYS_ASAAS_PRODUCTION' => $this->input->post('PAYMENT_GATEWAYS_ASAAS_PRODUCTION'),
                'PAYMENT_GATEWAYS_ASAAS_NOTIFY' => $this->input->post('PAYMENT_GATEWAYS_ASAAS_NOTIFY'),
                'PAYMENT_GATEWAYS_ASAAS_CREDENTIAIS_API_KEY' => $this->input->post('PAYMENT_GATEWAYS_ASAAS_CREDENTIAIS_API_KEY'),
                'PAYMENT_GATEWAYS_ASAAS_BOLETO_EXPIRATION' => $this->input->post('PAYMENT_GATEWAYS_ASAAS_BOLETO_EXPIRATION'),
                'API_ENABLED' => $this->input->post('apiEnabled'),
                'API_TOKEN_EXPIRE_TIME' => $this->input->post('apiExpireTime'),
                'API_JWT_KEY' => $this->input->post('resetJwtToken'),
                'EMAIL_PROTOCOL' => $this->input->post('EMAIL_PROTOCOL'),
                'EMAIL_SMTP_HOST' => $this->input->post('EMAIL_SMTP_HOST'),
                'EMAIL_SMTP_CRYPTO' => $this->input->post('EMAIL_SMTP_CRYPTO'),
                'EMAIL_SMTP_PORT' => $this->input->post('EMAIL_SMTP_PORT'),
                'EMAIL_SMTP_USER' => $this->input->post('EMAIL_SMTP_USER'),
                'EMAIL_SMTP_PASS' => $this->input->post('EMAIL_SMTP_PASS'),
            ];

            if (!$this->editDontEnv($dataDotEnv)) {
                $this->data['custom_error'] = '<div class="alert">Falha ao editar o .env</div>';
            }
            // FIM Edição do .env

            $data = [
                'app_name' => $this->input->post('app_name'),
                'per_page' => $this->input->post('per_page'),
                'app_theme' => $this->input->post('app_theme'),
                'os_notification' => $this->input->post('os_notification'),
                'email_automatico' => $this->input->post('email_automatico'),
                'control_estoque' => $this->input->post('control_estoque'),
                'notifica_whats' => $this->input->post('notifica_whats'),
                'control_baixa' => $this->input->post('control_baixa'),
                'control_editos' => $this->input->post('control_editos'),
                'control_edit_vendas' => $this->input->post('control_edit_vendas'),
                'control_datatable' => $this->input->post('control_datatable'),
                'pix_key' => $this->input->post('pix_key'),
                'mp_access_token' => $this->input->post('mp_access_token') ?? '',
                'app_logo_height'  => (int)($this->input->post('app_logo_height') ?: 50),
                'os_status_list' => json_encode($this->input->post('os_status_list')),
                'control_2vias' => $this->input->post('control_2vias'),
                'venda_sem_estoque' => $this->input->post('venda_sem_estoque'),
                'pdv_enabled' => $this->input->post('pdv_enabled'),
            ];
            if ($this->sisos_model->saveConfiguracao($data) == true) {
                $this->session->set_flashdata('success', 'Configurações do sistema atualizadas com sucesso!');
                redirect(site_url('sisos/configurar'));
            } else {
                $this->data['custom_error'] = '<div class="alert">Ocorreu um errro.</div>';
            }
        }

        $this->data['view'] = 'sisos/configurar';

        return $this->layout();
    }

    public function salvarConfigNfe()
    {
        if (!$this->permission->checkPermission($this->session->userdata('permissao'), 'cSistema')) {
            $this->session->set_flashdata('error', 'Você não tem permissão para configurar o sistema');
            redirect(base_url());
        }

        $data = [
            'nfe_enabled'           => $this->input->post('nfe_enabled'),
            'nfe_ambiente'          => $this->input->post('nfe_ambiente'),
            'nfe_token'             => $this->input->post('nfe_token'),
            'nfe_cnpj_emitente'     => $this->input->post('nfe_cnpj_emitente'),
            'nfe_natureza_operacao' => $this->input->post('nfe_natureza_operacao'),
        ];

        if ($this->sisos_model->saveConfiguracao($data)) {
            $this->session->set_flashdata('success', 'Configurações de Nota Fiscal salvas com sucesso!');
        } else {
            $this->session->set_flashdata('error', 'Ocorreu um erro ao salvar as configurações.');
        }

        redirect(site_url('sisos/configurar') . '#menu8');
    }

    public function atualizarBanco()
    {
        if (!$this->permission->checkPermission($this->session->userdata('permissao'), 'cSistema')) {
            $this->session->set_flashdata('error', 'Você não tem permissão para configurar o sistema');
            redirect(base_url());
        }

        $this->load->library('migration');

        if ($this->migration->latest() === false) {
            $this->session->set_flashdata('error', $this->migration->error_string());
        } else {
            $this->session->set_flashdata('success', 'Banco de dados atualizado com sucesso!');
        }

        return redirect(site_url('sisos/configurar'));
    }

    public function atualizarSisos()
    {
        if (!$this->permission->checkPermission($this->session->userdata('permissao'), 'cSistema')) {
            $this->session->set_flashdata('error', 'Você não tem permissão para configurar o sistema');
            redirect(base_url());
        }

        $this->load->library('github_updater');

        if (!$this->github_updater->has_update()) {
            $this->session->set_flashdata('success', 'Seu sisos já está atualizado!');

            return redirect(site_url('sisos/configurar'));
        }

        $success = $this->github_updater->update();

        if ($success) {
            $this->session->set_flashdata('success', 'Sisos atualizado com sucesso!');
        } else {
            $this->session->set_flashdata('error', 'Erro ao atualizar sisos!');
        }

        return redirect(site_url('sisos/configurar'));
    }

    public function calendario()
    {
        if (!$this->permission->checkPermission($this->session->userdata('permissao'), 'vOs')) {
            $this->session->set_flashdata('error', 'Você não tem permissão para visualizar O.S.');
            redirect(base_url());
        }
        $this->load->model('os_model');
        $status = $this->input->get('status') ?: null;
        $start = $this->input->get('start') ?: null;
        $end = $this->input->get('end') ?: null;

        $allOs = $this->sisos_model->calendario(
            $start,
            $end,
            $status
        );
        $events = array_map(function ($os) {
            switch ($os->status) {
                case 'Aberto':
                    $cor = '#00cd00';
                    break;
                case 'Negociação':
                    $cor = '#AEB404';
                    break;
                case 'Em Andamento':
                    $cor = '#436eee';
                    break;
                case 'Orçamento':
                    $cor = '#CDB380';
                    break;
                case 'Cancelado':
                    $cor = '#CD0000';
                    break;
                case 'Finalizado':
                    $cor = '#256';
                    break;
                case 'Faturado':
                    $cor = '#B266FF';
                    break;
                case 'Aguardando Peças':
                    $cor = '#FF7F00';
                    break;
                case 'Aprovado':
                    $cor = '#808080';
                    break;
                default:
                    $cor = '#E0E4CC';
                    break;
            }

            return [
                'title' => "OS: {$os->idOs}, Cliente: {$os->nomeCliente}",
                'start' => $os->dataFinal,
                'end' => $os->dataFinal,
                'color' => $cor,
                'extendedProps' => [
                    'id' => $os->idOs,
                    'cliente' => '<b>Cliente:</b> ' . $os->nomeCliente,
                    'dataInicial' => '<b>Data Inicial:</b> ' . date('d/m/Y', strtotime($os->dataInicial)),
                    'dataFinal' => '<b>Data Final:</b> ' . date('d/m/Y', strtotime($os->dataFinal)),
                    'garantia' => '<b>Garantia:</b> ' . $os->garantia . ' dias',
                    'status' => '<b>Status da OS:</b> ' . $os->status,
                    'description' => '<b>Descrição/Produto:</b> ' . strip_tags(html_entity_decode($os->descricaoProduto)),
                    'defeito' => '<b>Defeito:</b> ' . strip_tags(html_entity_decode($os->defeito)),
                    'observacoes' => '<b>Observações:</b> ' . strip_tags(html_entity_decode($os->observacoes)),
                    'subtotal' => '<br><b>Subtotal:</b> R$ ' . number_format($os->totalProdutos + $os->totalServicos, 2, ',', '.'),
                    'desconto' => '<b>Desconto:</b> -R$ ' . ($os->desconto > 0 ? number_format(($os->totalProdutos + $os->totalServicos) - $os->valor_desconto, 2, ',', '.') : number_format($os->desconto, 2, ',', '.')),
                    'total' => '<b>Total:</b> R$ ' . ($os->valor_desconto == 0 ? number_format($os->totalProdutos + $os->totalServicos, 2, ',', '.') : number_format($os->valor_desconto, 2, ',', '.')),
                    'faturado' => '<br><b>Faturado:</b> ' . ($os->faturado ? 'SIM' : 'PENDENTE'),
                    'editar' => $this->os_model->isEditable($os->idOs),
                ],
            ];
        }, $allOs);

        return $this->output
            ->set_content_type('application/json')
            ->set_status_header(200)
            ->set_output(json_encode($events));
    }

    /** Salvar configurações da IA */
    public function salvarConfigGemini()
    {
        if (!$this->permission->checkPermission($this->session->userdata('permissao'), 'cSistema')) {
            $this->session->set_flashdata('error', 'Sem permissão.'); redirect(site_url('sisos/configurar')); return;
        }
        $campos = [
            'gemini_enabled','gemini_api_key','gemini_model','gemini_contexto',
            'gemini_feat_diagnostico','gemini_feat_email','gemini_feat_assistente','gemini_feat_relatorio',
            // Multi-IA
            'ia_provedor',
            'openai_api_key','openai_model',
            'claude_api_key','claude_model',
            'perplexity_api_key','perplexity_model',
            'deepseek_api_key','deepseek_model',
            'mistral_api_key','mistral_model',
        ];
        foreach ($campos as $c) {
            $val = $this->input->post($c);
            if ($val === false || $val === null) $val = '0';
            $exists = $this->db->where('config', $c)->count_all_results('configuracoes');
            if ($exists) {
                $this->db->where('config', $c)->update('configuracoes', ['valor' => $val]);
            } else {
                $this->db->insert('configuracoes', ['config' => $c, 'valor' => $val]);
            }
        }
        $this->session->set_flashdata('success', 'Configurações da IA salvas com sucesso!');
        redirect(site_url('sisos/configurar'));
    }

    /** Testar conexão com a IA ativa */
    public function testarGemini()
    {
        header('Content-Type: application/json');
        $provedor = $this->_getIaProvedor();
        $resp = $this->_callIA('Responda apenas: "Sisos IA conectada com sucesso!"');
        if ($resp['ok']) {
            echo json_encode(['ok'=>true,'resposta'=>$resp['text'],'provedor'=>$provedor]);
        } else {
            echo json_encode(['ok'=>false,'erro'=>$resp['error']]);
        }
    }

    /** Chat com IA ativa */
    public function chatGemini()
    {
        header('Content-Type: application/json');
        $mensagem = $this->input->post('mensagem');
        if (!$mensagem) { echo json_encode(['ok'=>false,'erro'=>'Mensagem vazia.']); return; }

        $apiKey = $this->_getIaApiKey();
        if (!$apiKey) {
            echo json_encode(['ok'=>false,'erro'=>'IA não configurada. Acesse Configurações > IA.']); return;
        }

        $ctx = $this->db->where('config','gemini_contexto')->get('configuracoes')->row();
        $contexto = $ctx ? $ctx->valor : '';

        $osAbertas = $this->db->where('status !=','Finalizado')->where('status !=','Cancelado')
            ->count_all_results('os');

        $sistemaCtx = "Você é o assistente inteligente do sistema Sisos, um sistema de gestão para assistências técnicas. "
            . ($contexto ? "Contexto da empresa: $contexto. " : "")
            . "Dados atuais: $osAbertas OS abertas. "
            . "Responda de forma objetiva, prática e em português. Usuário: {$this->session->userdata('nome_admin')}.";

        $resp = $this->_callIA($sistemaCtx . "\n\nPergunta: " . $mensagem);

        if ($resp['ok']) {
            echo json_encode(['ok'=>true,'resposta'=>$resp['text'],'provedor'=>$this->_getIaProvedor()]);
        } else {
            echo json_encode(['ok'=>false,'erro'=>$resp['error']]);
        }
    }

    /** Sugestão de diagnóstico para uma OS */
    public function sugestaoGemini()
    {
        header('Content-Type: application/json');
        $osId = $this->input->post('os_id');
        if (!$osId) { echo json_encode(['ok'=>false,'erro'=>'OS não informada.']); return; }

        $feat = $this->db->where('config','gemini_feat_diagnostico')->get('configuracoes')->row();
        if (!($feat && $feat->valor)) { echo json_encode(['ok'=>false,'erro'=>'Recurso não habilitado.']); return; }

        $os = $this->db->select('os.*, clientes.nomeCliente')->from('os')
            ->join('clientes','clientes.idClientes = os.clientes_id','left')
            ->where('idOs',$osId)->get()->row();
        if (!$os) { echo json_encode(['ok'=>false,'erro'=>'OS não encontrada.']); return; }

        $prompt = "Você é um técnico especialista em assistência técnica de eletrônicos. "
            . "Com base nas informações abaixo, sugira um diagnóstico técnico, possíveis causas e próximos passos.\n\n"
            . "Equipamento: " . ($os->equipamento ?: 'Não informado') . "\n"
            . "Número de série: " . ($os->numeroSerie ?: 'N/A') . "\n"
            . "Defeito relatado: " . strip_tags($os->defeito ?: 'Não informado') . "\n"
            . "Descrição: " . strip_tags($os->descricaoProduto ?: '') . "\n"
            . "Responda de forma clara, técnica e organizada em tópicos.";

        $resp = $this->_callIA($prompt);
        echo json_encode($resp['ok'] ? ['ok'=>true,'resposta'=>$resp['text']] : ['ok'=>false,'erro'=>$resp['error']]);
    }

    // ─── Helpers Multi-IA ────────────────────────────────────────────────────

    /** Retorna o provedor IA ativo */
    private function _getIaProvedor()
    {
        $r = $this->db->where('config','ia_provedor')->get('configuracoes')->row();
        return $r ? ($r->valor ?: 'gemini') : 'gemini';
    }

    /** Retorna a chave API do provedor ativo */
    private function _getIaApiKey()
    {
        $provedor = $this->_getIaProvedor();
        $map = [
            'gemini'     => 'gemini_api_key',
            'openai'     => 'openai_api_key',
            'claude'     => 'claude_api_key',
            'perplexity' => 'perplexity_api_key',
            'deepseek'   => 'deepseek_api_key',
            'mistral'    => 'mistral_api_key',
        ];
        $configKey = $map[$provedor] ?? 'gemini_api_key';
        $r = $this->db->where('config',$configKey)->get('configuracoes')->row();
        return $r ? $r->valor : '';
    }

    /** Dispatcher: chama a API correta conforme provedor ativo */
    private function _callIA($prompt)
    {
        $provedor = $this->_getIaProvedor();
        $apiKey   = $this->_getIaApiKey();
        if (!$apiKey) return ['ok'=>false,'error'=>'Chave API não configurada para o provedor ' . strtoupper($provedor) . '.'];

        switch ($provedor) {
            case 'openai':
                $modelR = $this->db->where('config','openai_model')->get('configuracoes')->row();
                return $this->_callOpenAI($apiKey, $modelR ? ($modelR->valor ?: 'gpt-4o-mini') : 'gpt-4o-mini', $prompt);
            case 'claude':
                $modelR = $this->db->where('config','claude_model')->get('configuracoes')->row();
                return $this->_callClaude($apiKey, $modelR ? ($modelR->valor ?: 'claude-haiku-4-5-20251001') : 'claude-haiku-4-5-20251001', $prompt);
            case 'perplexity':
                $modelR = $this->db->where('config','perplexity_model')->get('configuracoes')->row();
                return $this->_callPerplexity($apiKey, $modelR ? ($modelR->valor ?: 'llama-3.1-sonar-small-128k-online') : 'llama-3.1-sonar-small-128k-online', $prompt);
            case 'deepseek':
                $modelR = $this->db->where('config','deepseek_model')->get('configuracoes')->row();
                return $this->_callDeepSeek($apiKey, $modelR ? ($modelR->valor ?: 'deepseek-chat') : 'deepseek-chat', $prompt);
            case 'mistral':
                $modelR = $this->db->where('config','mistral_model')->get('configuracoes')->row();
                return $this->_callMistral($apiKey, $modelR ? ($modelR->valor ?: 'mistral-small-latest') : 'mistral-small-latest', $prompt);
            default: // gemini
                $modelR = $this->db->where('config','gemini_model')->get('configuracoes')->row();
                return $this->_callGemini($apiKey, $modelR ? ($modelR->valor ?: 'gemini-2.0-flash') : 'gemini-2.0-flash', $prompt);
        }
    }

    /** Google Gemini */
    private function _callGemini($apiKey, $model, $prompt)
    {
        $fallback = ['gemini-2.5-flash-preview-05-20','gemini-2.0-flash','gemini-2.0-flash-lite','gemini-1.5-flash-latest','gemini-1.5-flash','gemini-1.5-flash-8b'];
        $descontinuados = ['gemini-1.5-pro'=>'gemini-2.0-flash','gemini-1.0-pro'=>'gemini-2.0-flash','gemini-pro'=>'gemini-2.0-flash','gemini-1.5-pro-latest'=>'gemini-2.0-flash'];
        if (isset($descontinuados[$model])) $model = $descontinuados[$model];
        $tentativas = array_unique(array_merge([$model], $fallback));
        $body = json_encode(['contents'=>[['parts'=>[['text'=>$prompt]]]],'generationConfig'=>['temperature'=>0.7,'maxOutputTokens'=>1024]]);
        foreach ($tentativas as $m) {
            $url = "https://generativelanguage.googleapis.com/v1beta/models/{$m}:generateContent?key=" . urlencode($apiKey);
            $ch = curl_init($url);
            curl_setopt_array($ch,[CURLOPT_RETURNTRANSFER=>true,CURLOPT_POST=>true,CURLOPT_POSTFIELDS=>$body,CURLOPT_HTTPHEADER=>['Content-Type: application/json'],CURLOPT_TIMEOUT=>30,CURLOPT_SSL_VERIFYPEER=>false]);
            $result = curl_exec($ch); $err = curl_error($ch); curl_close($ch);
            if ($err) return ['ok'=>false,'error'=>'Erro de conexão: '.$err];
            $json = json_decode($result,true);
            if (isset($json['candidates'][0]['content']['parts'][0]['text']))
                return ['ok'=>true,'text'=>$json['candidates'][0]['content']['parts'][0]['text'],'model'=>$m];
            $apiErr = $json['error']['message'] ?? '';
            if (strpos($apiErr,'not found')!==false||strpos($apiErr,'INVALID_ARGUMENT')!==false) continue;
            if (strpos($apiErr,'API_KEY_INVALID')!==false||strpos($apiErr,'API key not valid')!==false) return ['ok'=>false,'error'=>'Chave Gemini inválida.'];
            if (strpos($apiErr,'RESOURCE_EXHAUSTED')!==false) return ['ok'=>false,'error'=>'Cota Gemini esgotada. Tente mais tarde.'];
            return ['ok'=>false,'error'=>$apiErr ?: 'Erro Gemini.'];
        }
        return ['ok'=>false,'error'=>'Nenhum modelo Gemini disponível.'];
    }

    /** OpenAI (ChatGPT) */
    private function _callOpenAI($apiKey, $model, $prompt)
    {
        $body = json_encode(['model'=>$model,'messages'=>[['role'=>'user','content'=>$prompt]],'max_tokens'=>1024,'temperature'=>0.7]);
        $ch = curl_init('https://api.openai.com/v1/chat/completions');
        curl_setopt_array($ch,[CURLOPT_RETURNTRANSFER=>true,CURLOPT_POST=>true,CURLOPT_POSTFIELDS=>$body,CURLOPT_HTTPHEADER=>['Content-Type: application/json','Authorization: Bearer '.$apiKey],CURLOPT_TIMEOUT=>30,CURLOPT_SSL_VERIFYPEER=>false]);
        $result = curl_exec($ch); $err = curl_error($ch); curl_close($ch);
        if ($err) return ['ok'=>false,'error'=>'Erro de conexão: '.$err];
        $json = json_decode($result,true);
        if (isset($json['choices'][0]['message']['content'])) return ['ok'=>true,'text'=>$json['choices'][0]['message']['content'],'model'=>$model];
        $apiErr = $json['error']['message'] ?? 'Erro OpenAI.';
        if (strpos($apiErr,'Incorrect API key')!==false) $apiErr='Chave OpenAI inválida.';
        elseif (strpos($apiErr,'quota')!==false||strpos($apiErr,'billing')!==false) $apiErr='Limite/créditos OpenAI insuficientes.';
        return ['ok'=>false,'error'=>$apiErr];
    }

    /** Anthropic Claude */
    private function _callClaude($apiKey, $model, $prompt)
    {
        $body = json_encode(['model'=>$model,'max_tokens'=>1024,'messages'=>[['role'=>'user','content'=>$prompt]]]);
        $ch = curl_init('https://api.anthropic.com/v1/messages');
        curl_setopt_array($ch,[CURLOPT_RETURNTRANSFER=>true,CURLOPT_POST=>true,CURLOPT_POSTFIELDS=>$body,CURLOPT_HTTPHEADER=>['Content-Type: application/json','x-api-key: '.$apiKey,'anthropic-version: 2023-06-01'],CURLOPT_TIMEOUT=>30,CURLOPT_SSL_VERIFYPEER=>false]);
        $result = curl_exec($ch); $err = curl_error($ch); curl_close($ch);
        if ($err) return ['ok'=>false,'error'=>'Erro de conexão: '.$err];
        $json = json_decode($result,true);
        if (isset($json['content'][0]['text'])) return ['ok'=>true,'text'=>$json['content'][0]['text'],'model'=>$model];
        $apiErr = $json['error']['message'] ?? 'Erro Claude.';
        if (strpos($apiErr,'authentication_error')!==false) $apiErr='Chave Claude inválida.';
        return ['ok'=>false,'error'=>$apiErr];
    }

    /** Perplexity AI */
    private function _callPerplexity($apiKey, $model, $prompt)
    {
        $body = json_encode(['model'=>$model,'messages'=>[['role'=>'user','content'=>$prompt]],'max_tokens'=>1024]);
        $ch = curl_init('https://api.perplexity.ai/chat/completions');
        curl_setopt_array($ch,[CURLOPT_RETURNTRANSFER=>true,CURLOPT_POST=>true,CURLOPT_POSTFIELDS=>$body,CURLOPT_HTTPHEADER=>['Content-Type: application/json','Authorization: Bearer '.$apiKey],CURLOPT_TIMEOUT=>30,CURLOPT_SSL_VERIFYPEER=>false]);
        $result = curl_exec($ch); $err = curl_error($ch); curl_close($ch);
        if ($err) return ['ok'=>false,'error'=>'Erro de conexão: '.$err];
        $json = json_decode($result,true);
        if (isset($json['choices'][0]['message']['content'])) return ['ok'=>true,'text'=>$json['choices'][0]['message']['content'],'model'=>$model];
        return ['ok'=>false,'error'=>$json['error']['message'] ?? 'Erro Perplexity.'];
    }

    /** DeepSeek */
    private function _callDeepSeek($apiKey, $model, $prompt)
    {
        $body = json_encode(['model'=>$model,'messages'=>[['role'=>'user','content'=>$prompt]],'max_tokens'=>1024,'temperature'=>0.7]);
        $ch = curl_init('https://api.deepseek.com/v1/chat/completions');
        curl_setopt_array($ch,[CURLOPT_RETURNTRANSFER=>true,CURLOPT_POST=>true,CURLOPT_POSTFIELDS=>$body,CURLOPT_HTTPHEADER=>['Content-Type: application/json','Authorization: Bearer '.$apiKey],CURLOPT_TIMEOUT=>30,CURLOPT_SSL_VERIFYPEER=>false]);
        $result = curl_exec($ch); $err = curl_error($ch); curl_close($ch);
        if ($err) return ['ok'=>false,'error'=>'Erro de conexão: '.$err];
        $json = json_decode($result,true);
        if (isset($json['choices'][0]['message']['content'])) return ['ok'=>true,'text'=>$json['choices'][0]['message']['content'],'model'=>$model];
        return ['ok'=>false,'error'=>$json['error']['message'] ?? 'Erro DeepSeek.'];
    }

    /** Mistral AI */
    private function _callMistral($apiKey, $model, $prompt)
    {
        $body = json_encode(['model'=>$model,'messages'=>[['role'=>'user','content'=>$prompt]],'max_tokens'=>1024,'temperature'=>0.7]);
        $ch = curl_init('https://api.mistral.ai/v1/chat/completions');
        curl_setopt_array($ch,[CURLOPT_RETURNTRANSFER=>true,CURLOPT_POST=>true,CURLOPT_POSTFIELDS=>$body,CURLOPT_HTTPHEADER=>['Content-Type: application/json','Authorization: Bearer '.$apiKey],CURLOPT_TIMEOUT=>30,CURLOPT_SSL_VERIFYPEER=>false]);
        $result = curl_exec($ch); $err = curl_error($ch); curl_close($ch);
        if ($err) return ['ok'=>false,'error'=>'Erro de conexão: '.$err];
        $json = json_decode($result,true);
        if (isset($json['choices'][0]['message']['content'])) return ['ok'=>true,'text'=>$json['choices'][0]['message']['content'],'model'=>$model];
        return ['ok'=>false,'error'=>$json['error']['message'] ?? 'Erro Mistral.'];
    }


    private function editDontEnv(array $data)
    {
        $env_file_path = dirname(__FILE__, 2) . DIRECTORY_SEPARATOR . '.env';
        $env_file = file_get_contents($env_file_path);

        foreach ($data as $constante => $valor) {
            if ($constante == 'API_JWT_KEY' && $valor == 'sim') {
                $base64 = base64_encode(openssl_random_pseudo_bytes(32));
                $valor = '"' . $base64 . '"';
                $env_file = str_replace("$constante=" . '"' . $_ENV[$constante] . '"', "$constante={$valor}", $env_file);
            } else {
                if (isset($_ENV[$constante])) {
                    $env_file = str_replace("$constante={$_ENV[$constante]}", "$constante={$valor}", $env_file);
                } else {
                    file_put_contents($env_file_path, $env_file . "\n{$constante}={$valor}\n");
                    $env_file = file_get_contents($env_file_path);
                }
            }
        }
        return file_put_contents($env_file_path, $env_file) ? true : false;
    }

    // ── IA — Troca rápida de provedor (AJAX) ─────────────────
    public function trocarProvedor()
    {
        header('Content-Type: application/json');
        $prov = $this->input->post('provedor');
        $allowed = ['gemini','openai','claude','perplexity','deepseek','mistral'];
        if (!in_array($prov, $allowed)) {
            echo json_encode(['ok'=>false,'erro'=>'Provedor inválido.']); return;
        }
        $exists = $this->db->where('config','ia_provedor')->count_all_results('configuracoes');
        if ($exists) {
            $this->db->where('config','ia_provedor')->update('configuracoes',['valor'=>$prov]);
        } else {
            $this->db->insert('configuracoes',['config'=>'ia_provedor','valor'=>$prov]);
        }
        // Check if this provider has an API key configured
        $keyMap = ['gemini'=>'gemini_api_key','openai'=>'openai_api_key','claude'=>'claude_api_key','perplexity'=>'perplexity_api_key','deepseek'=>'deepseek_api_key','mistral'=>'mistral_api_key'];
        $keyR = $this->db->where('config',$keyMap[$prov])->get('configuracoes')->row();
        $hasKey = $keyR && !empty($keyR->valor);
        echo json_encode(['ok'=>true,'provedor'=>$prov,'hasKey'=>$hasKey]);
    }

    // ── IA — Página do Assistente ─────────────────────────
    public function ia()
    {
        if (!$this->permission->checkPermission($this->session->userdata('permissao'), 'vOs')) {
            $this->session->set_flashdata('error', 'Sem permissão.');
            redirect(base_url());
        }
        $geminiEnabled = $this->db->where('config','gemini_enabled')->get('configuracoes')->row();
        if (!$geminiEnabled || $geminiEnabled->valor != '1') {
            $this->session->set_flashdata('error', 'IA não está habilitada. Acesse Configurações > IA / Gemini.');
            redirect(site_url('sisos/configurar'));
        }
        $this->data['menuIa'] = true;
        $this->data['view']   = 'sisos/ia';
        return $this->layout();
    }

    // ── Busca Global (AJAX) ───────────────────────────────
    public function buscaGlobal()
    {
        header('Content-Type: application/json');
        $q = trim($this->input->get('q'));
        if (strlen($q) < 2) { echo json_encode([]); return; }

        $like = '%' . $this->db->escape_like_str($q) . '%';

        $clientes = $this->db
            ->select('idClientes as id, nomeCliente as nome, documento as doc, telefone as tel')
            ->group_start()
                ->like('nomeCliente', $q)
                ->or_like('documento', $q)
                ->or_like('telefone', $q)
                ->or_like('celular', $q)
            ->group_end()
            ->limit(5)->get('clientes')->result();

        $os = $this->db
            ->select('os.idOs as id, os.status, os.equipamento, c.nomeCliente as cliente')
            ->from('os')
            ->join('clientes c', 'c.idClientes = os.clientes_id', 'left')
            ->group_start()
                ->like('os.idOs', $q)
                ->or_like('c.nomeCliente', $q)
                ->or_like('os.equipamento', $q)
                ->or_like('os.defeito', $q)
            ->group_end()
            ->limit(5)->get()->result();

        $produtos = $this->db
            ->select('idProdutos as id, descricao as nome, estoque, precoVenda as preco')
            ->like('descricao', $q)
            ->or_like('codDeBarra', $q)
            ->or_like('marca', $q)
            ->limit(5)->get('produtos')->result();

        echo json_encode([
            'clientes' => $clientes,
            'os'       => $os,
            'produtos' => $produtos,
        ]);
    }

}
