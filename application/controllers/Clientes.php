<?php

if (! defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Clientes extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->load->model('clientes_model');
        $this->data['menuClientes'] = 'clientes';
    }

    public function index()
    {
        $this->gerenciar();
    }

    public function gerenciar()
    {
        if (! $this->permission->checkPermission($this->session->userdata('permissao'), 'vCliente')) {
            $this->session->set_flashdata('error', 'Você não tem permissão para visualizar clientes.');
            redirect(base_url());
        }

        $pesquisa = $this->input->get('pesquisa');
        $perPage  = 24; // tamanho de cada "lote" carregado, tanto no 1º carregamento quanto na rolagem

        // Preferência de visualização (lista/grade) — igual à da tela de OS
        $visualizacaoParam = $this->input->get('visualizacao');
        if (in_array($visualizacaoParam, ['lista', 'grade'], true)) {
            $this->session->set_userdata('clientes_visualizacao', $visualizacaoParam);
        }
        $this->data['visualizacaoAtual'] = $this->session->userdata('clientes_visualizacao') ?: 'grade';

        $this->data['results']  = $this->clientes_model->get('clientes', '*', $pesquisa, $perPage, 0);
        $this->data['perPage']  = $perPage;
        $this->data['pesquisa'] = $pesquisa;

        // Estatísticas do cabeçalho (contagens simples e seguras — sem
        // valores financeiros, pra não arriscar mostrar número errado)
        $this->data['statTotalClientes'] = $this->clientes_model->count('clientes');
        $this->data['statNovosMes'] = $this->db
            ->where('dataCadastro >=', date('Y-m-01'))
            ->count_all_results('clientes');
        $this->data['statFornecedores'] = $this->db
            ->where('fornecedor', 1)
            ->count_all_results('clientes');

        $this->data['view'] = 'clientes/clientes';

        return $this->layout();
    }

    /**
     * Endpoint AJAX chamado pela rolagem infinita da lista de clientes —
     * devolve só o HTML dos próximos cards (sem o layout da página inteira),
     * pra tela de clientes.php ir "grudando" no final da grade.
     */
    public function carregarMais()
    {
        if (! $this->permission->checkPermission($this->session->userdata('permissao'), 'vCliente')) {
            return; // resposta vazia — sem permissão, não carrega mais nada
        }

        $pesquisa = $this->input->get('pesquisa');
        $antesDe  = (int) $this->input->get('antes_de');
        $perPage  = 24;

        $results = $this->clientes_model->get('clientes', '*', $pesquisa, $perPage, 0, false, 'array', $antesDe);

        $modo = $this->input->get('modo') === 'lista' ? 'lista' : 'grade';
        if ($modo === 'lista') {
            echo $this->load->view('clientes/_table_rows_partial', ['results' => $results, 'semResultadosOculto' => true], true);
        } else {
            echo $this->load->view('clientes/_cards_partial', ['results' => $results, 'semResultadosOculto' => true], true);
        }
    }

    public function adicionar()
    {
        if (! $this->permission->checkPermission($this->session->userdata('permissao'), 'aCliente')) {
            $this->session->set_flashdata('error', 'Você não tem permissão para adicionar clientes.');
            redirect(base_url());
        }

        $this->load->library('form_validation');
        $this->data['custom_error'] = '';

        $senhaCliente = $this->input->post('senha') ? $this->input->post('senha') : preg_replace('/[^\p{L}\p{N}\s]/', '', $this->input->post('documento'));

        $cpf_cnpj = preg_replace('/[^\p{L}\p{N}\s]/', '', $this->input->post('documento'));

        if (strlen($cpf_cnpj) == 11) {
            $pessoa_fisica = true;
        } else {
            $pessoa_fisica = false;
        }

        if ($this->form_validation->run('clientes') == false) {
            $this->data['custom_error'] = (validation_errors() ? '<div class="form_error">' . validation_errors() . '</div>' : false);
        } else {
            $email = $this->input->post('email');
            if ($email && $this->clientes_model->emailExists($email)) {
                $this->data['custom_error'] = '<div class="form_error"><p>Este e-mail já está sendo utilizado por outro cliente.</p></div>';
            } else {
                // Data de nascimento vem como DD/MM/AAAA do formulário — converte para
                // o formato do banco (Y-m-d), mesmo padrão usado em outras datas do sistema.
                $dataNascRaw = $this->input->post('dataNascimento');
                $dataNascimento = null;
                if ($dataNascRaw) {
                    $partes = explode('/', $dataNascRaw);
                    if (count($partes) === 3) {
                        $dataNascimento = $partes[2] . '-' . $partes[1] . '-' . $partes[0];
                    }
                }

                $data = [
                'nomeCliente' => $this->input->post('nomeCliente'),
                'contato' => $this->input->post('contato'),
                'pessoa_fisica' => $pessoa_fisica,
                'documento' => $this->input->post('documento'),
                'telefone' => $this->input->post('telefone'),
                'celular' => $this->input->post('celular'),
                'email' => $this->input->post('email'),
                'senha' => password_hash($senhaCliente, PASSWORD_DEFAULT),
                'rua' => $this->input->post('rua'),
                'numero' => $this->input->post('numero'),
                'complemento' => $this->input->post('complemento'),
                'bairro' => $this->input->post('bairro'),
                'cidade' => $this->input->post('cidade'),
                'estado' => $this->input->post('estado'),
                'cep' => $this->input->post('cep'),
                'dataCadastro' => date('Y-m-d'),
                'fornecedor' => $this->input->post('fornecedor') ? 1 : 0,
                'dataNascimento' => $dataNascimento,
                'notif_aniversario' => $this->input->post('notif_aniversario') ? 1 : 0,
            ];

                if ($this->clientes_model->add('clientes', $data) == true) {
                    $this->session->set_flashdata('success', 'Cliente adicionado com sucesso!');
                    log_info('Adicionou um cliente.');
                    redirect(site_url('clientes/'));
                } else {
                    $this->data['custom_error'] = '<div class="form_error"><p>Ocorreu um erro.</p></div>';
                }
            }
        }

        $this->data['view'] = 'clientes/adicionarCliente';

        return $this->layout();
    }

    public function editar()
    {
        if (! $this->uri->segment(3) || ! is_numeric($this->uri->segment(3)) || ! $this->clientes_model->getById($this->uri->segment(3))) {
            $this->session->set_flashdata('error', 'Cliente não encontrado ou parâmetro inválido.');
            redirect('clientes/gerenciar');
        }

        if (! $this->permission->checkPermission($this->session->userdata('permissao'), 'eCliente')) {
            $this->session->set_flashdata('error', 'Você não tem permissão para editar clientes.');
            redirect(base_url());
        }

        $this->load->library('form_validation');
        $this->data['custom_error'] = '';

        if ($this->form_validation->run('clientes') == false) {
            $this->data['custom_error'] = (validation_errors() ? '<div class="form_error">' . validation_errors() . '</div>' : false);
        } else {

            $email = $this->input->post('email');
            $idCliente = $this->input->post('idClientes');
            if ($email && $this->clientes_model->emailExists($email, $idCliente)) {
                $this->data['custom_error'] = '<div class="form_error"><p>Este e-mail já está sendo utilizado por outro cliente.</p></div>';
            } else {
                // Mesma conversão de data usada em adicionar()
                $dataNascRaw = $this->input->post('dataNascimento');
                $dataNascimento = null;
                if ($dataNascRaw) {
                    $partes = explode('/', $dataNascRaw);
                    if (count($partes) === 3) {
                        $dataNascimento = $partes[2] . '-' . $partes[1] . '-' . $partes[0];
                    }
                }

                $senha = $this->input->post('senha');
                if ($senha != null) {
                    $senha = password_hash($senha, PASSWORD_DEFAULT);

                    $data = [
                        'nomeCliente' => $this->input->post('nomeCliente'),
                        'contato' => $this->input->post('contato'),
                        'documento' => $this->input->post('documento'),
                        'telefone' => $this->input->post('telefone'),
                        'celular' => $this->input->post('celular'),
                        'email' => $this->input->post('email'),
                        'senha' => $senha,
                        'rua' => $this->input->post('rua'),
                        'numero' => $this->input->post('numero'),
                        'complemento' => $this->input->post('complemento'),
                        'bairro' => $this->input->post('bairro'),
                        'cidade' => $this->input->post('cidade'),
                        'estado' => $this->input->post('estado'),
                        'cep' => $this->input->post('cep'),
                        'fornecedor' => ($this->input->post('fornecedor') == true ? 1 : 0),
                        'dataNascimento' => $dataNascimento,
                        'notif_aniversario' => $this->input->post('notif_aniversario') ? 1 : 0,
                    ];
                } else {
                    $data = [
                        'nomeCliente' => $this->input->post('nomeCliente'),
                        'contato' => $this->input->post('contato'),
                        'documento' => $this->input->post('documento'),
                        'telefone' => $this->input->post('telefone'),
                        'celular' => $this->input->post('celular'),
                        'email' => $this->input->post('email'),
                        'rua' => $this->input->post('rua'),
                        'numero' => $this->input->post('numero'),
                        'complemento' => $this->input->post('complemento'),
                        'bairro' => $this->input->post('bairro'),
                        'cidade' => $this->input->post('cidade'),
                        'estado' => $this->input->post('estado'),
                        'cep' => $this->input->post('cep'),
                        'fornecedor' => ($this->input->post('fornecedor') == true ? 1 : 0),
                        'dataNascimento' => $dataNascimento,
                        'notif_aniversario' => $this->input->post('notif_aniversario') ? 1 : 0,
                    ];
                }

                if ($this->clientes_model->edit('clientes', $data, 'idClientes', $this->input->post('idClientes')) == true) {
                    $this->session->set_flashdata('success', 'Cliente editado com sucesso!');
                    log_info('Alterou um cliente. ID' . $this->input->post('idClientes'));
                    redirect(site_url('clientes/editar/') . $this->input->post('idClientes'));
                } else {
                    $this->data['custom_error'] = '<div class="form_error"><p>Ocorreu um erro</p></div>';
                }
            }
        }

        $this->data['result'] = $this->clientes_model->getById($this->uri->segment(3));
        $this->data['view'] = 'clientes/editarCliente';

        return $this->layout();
    }

    public function visualizar()
    {
        if (! $this->uri->segment(3) || ! is_numeric($this->uri->segment(3))) {
            $this->session->set_flashdata('error', 'Item não pode ser encontrado, parâmetro não foi passado corretamente.');
            redirect('sisos');
        }

        if (! $this->permission->checkPermission($this->session->userdata('permissao'), 'vCliente')) {
            $this->session->set_flashdata('error', 'Você não tem permissão para visualizar clientes.');
            redirect(base_url());
        }

        $this->data['custom_error'] = '';
        $this->data['result'] = $this->clientes_model->getById($this->uri->segment(3));
        $this->data['results'] = $this->clientes_model->getOsByCliente($this->uri->segment(3));
        $this->data['result_vendas'] = $this->clientes_model->getAllVendasByClient($this->uri->segment(3));
        $this->data['view'] = 'clientes/visualizar';

        return $this->layout();
    }

    public function excluir()
    {
        if (! $this->permission->checkPermission($this->session->userdata('permissao'), 'dCliente')) {
            $this->session->set_flashdata('error', 'Você não tem permissão para excluir clientes.');
            redirect(base_url());
        }

        $id = $this->input->post('id');
        if ($id == null) {
            $this->session->set_flashdata('error', 'Erro ao tentar excluir cliente.');
            redirect(site_url('clientes/gerenciar/'));
        }

        $os = $this->clientes_model->getAllOsByClient($id);
        if ($os != null) {
            $this->clientes_model->removeClientOs($os);
        }

        // excluindo Vendas vinculadas ao cliente
        $vendas = $this->clientes_model->getAllVendasByClient($id);
        if ($vendas != null) {
            $this->clientes_model->removeClientVendas($vendas);
        }

        $this->clientes_model->delete('clientes', 'idClientes', $id);
        log_info('Removeu um cliente. ID' . $id);

        $this->session->set_flashdata('success', 'Cliente excluido com sucesso!');
        redirect(site_url('clientes/gerenciar/'));
    }

    /**
     * Cadastro rápido de cliente via AJAX (modal na OS)
     */
    public function adicionarRapido()
    {
        if (!$this->permission->checkPermission($this->session->userdata('permissao'), 'aCliente')) {
            echo json_encode(['sucesso' => false, 'erro' => 'Sem permissao para cadastrar clientes.']);
            return;
        }

        $nome = trim($this->input->post('nomeCliente'));
        if (!$nome) {
            echo json_encode(['sucesso' => false, 'erro' => 'Nome e obrigatorio.']);
            return;
        }

        // Data de nascimento vem como DD/MM/AAAA do formulário — mesma conversão
        // usada em adicionar()/editar(), pra manter o padrão do sistema.
        $dataNascRaw = $this->input->post('dataNascimento');
        $dataNascimento = null;
        if ($dataNascRaw) {
            $partes = explode('/', $dataNascRaw);
            if (count($partes) === 3) {
                $dataNascimento = $partes[2] . '-' . $partes[1] . '-' . $partes[0];
            }
        }

        $data = [
            'nomeCliente'       => $nome,
            'telefone'          => $this->input->post('telefone') ?: '',
            'celular'           => $this->input->post('telefone') ?: '',
            'documento'         => preg_replace('/\D/', '', $this->input->post('cpf') ?: ''),
            'email'             => '',
            'dataCadastro'      => date('Y-m-d'),
            'senha'             => password_hash(uniqid(), PASSWORD_DEFAULT),
            'dataNascimento'    => $dataNascimento,
            'notif_aniversario' => $this->input->post('notif_aniversario') ? 1 : 0,
        ];

        $this->load->model('clientes_model');
        $id = $this->clientes_model->addReturnId('clientes', $data);

        if ($id) {
            log_info('Cadastro rapido de cliente ID: ' . $id . ' - ' . $nome);
            echo json_encode(['sucesso' => true, 'id' => $id, 'nome' => $nome]);
        } else {
            echo json_encode(['sucesso' => false, 'erro' => 'Erro ao salvar cliente.']);
        }
    }

    /**
     * Autocomplete de clientes para OS/Vendas
     */
    public function autoCompleteCliente()
    {
        $term = $this->input->get('term');
        $this->load->model('clientes_model');
        $clientes = $this->clientes_model->buscarParaAutocomplete($term);
        echo json_encode($clientes);
    }


    public function bloquear()
    {
        if (!$this->permission->checkPermission($this->session->userdata('permissao'), 'eCliente')) {
            echo json_encode(['result' => false, 'erro' => 'Sem permissão.']); return;
        }
        $id     = $this->input->post('id');
        $acao   = $this->input->post('acao');
        $motivo = $this->input->post('motivo');

        $data = $acao === 'bloquear'
            ? ['bloqueado' => 1, 'motivo_bloqueio' => $motivo]
            : ['bloqueado' => 0, 'motivo_bloqueio' => null];

        $this->db->where('idClientes', $id)->update('clientes', $data);
        log_info('Cliente ID ' . $id . ' ' . $acao . 'do. Motivo: ' . $motivo);
        echo json_encode(['result' => true]);
    }

    /** Lista todas as tags disponíveis */
    public function getTags()
    {
        $tags = $this->db->order_by('tag')->get('cliente_tags')->result();
        header('Content-Type: application/json');
        echo json_encode($tags);
    }

    /** Tags de um cliente específico */
    public function getTagsCliente($id)
    {
        $this->db->select('ct.*');
        $this->db->from('cliente_tags ct');
        $this->db->join('clientes_tags clt', 'clt.cliente_tags_id = ct.idTag');
        $this->db->where('clt.clientes_id', $id);
        $tags = $this->db->get()->result();
        header('Content-Type: application/json');
        echo json_encode($tags);
    }

    /** Adicionar/remover tag de um cliente */
    public function toggleTag()
    {
        if (!$this->permission->checkPermission($this->session->userdata('permissao'), 'eCliente')) {
            echo json_encode(['result' => false]); return;
        }
        $clienteId = $this->input->post('clientes_id');
        $tagId     = $this->input->post('cliente_tags_id');
        $acao      = $this->input->post('acao'); // 'add' ou 'remove'

        if ($acao === 'add') {
            $this->db->ignore(true)->insert('clientes_tags', ['clientes_id' => $clienteId, 'cliente_tags_id' => $tagId]);
        } else {
            $this->db->where('clientes_id', $clienteId)->where('cliente_tags_id', $tagId)->delete('clientes_tags');
        }
        echo json_encode(['result' => true]);
    }

    /** Criar nova tag */
    public function criarTag()
    {
        if (!$this->permission->checkPermission($this->session->userdata('permissao'), 'cSistema')) {
            echo json_encode(['result' => false]); return;
        }
        $tag  = trim($this->input->post('tag'));
        $cor  = $this->input->post('cor') ?: '#2980b9';
        $desc = $this->input->post('descricao');
        if (!$tag) { echo json_encode(['result' => false, 'erro' => 'Nome obrigatório']); return; }
        $this->db->insert('cliente_tags', ['tag' => $tag, 'cor' => $cor, 'descricao' => $desc]);
        echo json_encode(['result' => true, 'id' => $this->db->insert_id(), 'tag' => $tag, 'cor' => $cor]);
    }

}
