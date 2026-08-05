<?php

if (! defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Produtos extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->load->helper('form');
        $this->load->model('produtos_model');
        $this->data['menuProdutos'] = 'Produtos';
    }

    public function index()
    {
        $this->gerenciar();
    }

    public function gerenciar()
    {
        if (! $this->permission->checkPermission($this->session->userdata('permissao'), 'vProduto')) {
            $this->session->set_flashdata('error', 'Você não tem permissão para visualizar produtos.');
            redirect(base_url());
        }

        $pesquisa = $this->input->get('pesquisa');
        $estoqueBaixo = $this->input->get('estoqueBaixo');
        $perPage = 24;

        $this->_aplicarFiltrosProdutos($pesquisa, $estoqueBaixo);
        $this->db->order_by('idProdutos', 'DESC');
        $this->db->limit($perPage, 0);
        $this->data['results'] = $this->db->get('produtos')->result();

        $this->_aplicarFiltrosProdutos($pesquisa, $estoqueBaixo);
        $this->data['statTotalFiltrado'] = $this->db->count_all_results('produtos');

        $this->data['perPage'] = $perPage;
        $this->data['pesquisa'] = $pesquisa;
        $this->data['estoqueBaixo'] = $estoqueBaixo;
        $this->data['view'] = 'produtos/produtos';

        return $this->layout();
    }

    /**
     * Endpoint AJAX chamado pela rolagem infinita da lista de produtos.
     */
    public function carregarMais()
    {
        if (! $this->permission->checkPermission($this->session->userdata('permissao'), 'vProduto')) {
            return;
        }

        $pesquisa = $this->input->get('pesquisa');
        $estoqueBaixo = $this->input->get('estoqueBaixo');
        $antesDe = (int) $this->input->get('antes_de');
        $perPage = 24;

        $this->_aplicarFiltrosProdutos($pesquisa, $estoqueBaixo);
        if ($antesDe > 0) $this->db->where('idProdutos <', $antesDe);
        $this->db->order_by('idProdutos', 'DESC');
        $this->db->limit($perPage, 0);
        $results = $this->db->get('produtos')->result();

        echo $this->load->view('produtos/_table_rows_partial', ['results' => $results, 'semResultadosOculto' => true], true);
    }

    /**
     * Aplica os filtros de pesquisa/estoqueBaixo na query builder atual.
     */
    private function _aplicarFiltrosProdutos($pesquisa, $estoqueBaixo)
    {
        if ($pesquisa) {
            $this->db->group_start();
            $this->db->like('descricao', $pesquisa);
            $this->db->or_like('codDeBarra', $pesquisa);
            $this->db->or_like('imei', $pesquisa);
            $this->db->or_like('numero_serie', $pesquisa);
            $this->db->group_end();
        }
        if ($estoqueBaixo) {
            $this->db->where('estoque <= estoqueMinimo', null, false);
            $this->db->where('estoqueMinimo >', 0);
        }
    }

    /**
     * Faz o upload da foto do produto com um padrão seguro: primeiro carrega
     * a library SEM config, depois chama initialize() separadamente.
     *
     * Por quê: se `upload` já tiver sido carregada em algum outro ponto do
     * mesmo request (o CodeIgniter não recarrega libraries já carregadas),
     * chamar `$this->load->library('upload', $config)` com o config direto
     * no segundo parâmetro é IGNORADO silenciosamente — o upload passa a
     * usar upload_path/allowed_types antigos (ou vazios) e toda imagem
     * enviada falha, mesmo sendo jpg/png/webp válidos. É exatamente esse
     * padrão (load + initialize separados) que o Os.php já usa pro upload
     * das fotos do checklist, então aqui ficou igual.
     *
     * Retorna o nome de erro (string) em caso de falha, ou null se ok/sem arquivo.
     */
    private function _uploadFotoProduto(&$data)
    {
        if (empty($_FILES['foto']['name'])) {
            return null;
        }

        $pasta = FCPATH . 'assets/img/produtos/';
        if (!file_exists($pasta)) {
            mkdir($pasta, DIR_WRITE_MODE, true);
        }

        $this->load->library('upload');
        $this->upload->initialize([
            'upload_path'   => $pasta,
            'allowed_types' => 'jpg|jpeg|png|webp|gif|heic|heif',
            'max_size'      => 3072,
            'encrypt_name'  => true,
        ]);

        if ($this->upload->do_upload('foto')) {
            $data['foto'] = base_url('assets/img/produtos/' . $this->upload->data('file_name'));
            return null;
        }

        return trim(strip_tags($this->upload->display_errors('', '')));
    }

    public function adicionar()
    {
        if (! $this->permission->checkPermission($this->session->userdata('permissao'), 'aProduto')) {
            $this->session->set_flashdata('error', 'Você não tem permissão para adicionar produtos.');
            redirect(base_url());
        }

        $this->load->library('form_validation');
        $this->load->model('categorias_model');
        $this->data['custom_error'] = '';

        if ($this->form_validation->run('produtos') == false) {
            $this->data['custom_error'] = (validation_errors() ? '<div class="form_error">' . validation_errors() . '</div>' : false);
        } else {
            $precoCompra = $this->input->post('precoCompra');
            $precoCompra = str_replace(',', '', $precoCompra);
            $precoVenda = $this->input->post('precoVenda');
            $precoVenda = str_replace(',', '', $precoVenda);
            $data = [
                'codDeBarra'    => $this->input->post('codDeBarra'),
                'descricao'     => $this->input->post('descricao'),
                'marca'         => $this->input->post('marca'),
                'modelo'        => $this->input->post('modelo'),
                'localizacao'   => $this->input->post('localizacao'),
                'categorias_id' => $this->input->post('categorias_id') ?: null,
                'garantia_dias' => (int)$this->input->post('garantia_dias'),
                'ncm'           => $this->input->post('ncm'),
                'observacoes'   => $this->input->post('observacoes'),
                'unidade'       => $this->input->post('unidade'),
                'precoCompra'   => $precoCompra,
                'precoVenda'    => $precoVenda,
                // IMEI/SN — opcionais, usados principalmente pra celulares.
                // Guardados como null (em vez de string vazia) quando não
                // informado pra não conflitar com índices/unicidade futuros.
                'imei'          => $this->input->post('imei') ?: null,
                'numero_serie'  => $this->input->post('numero_serie') ?: null,
                // Começa em 0 de propósito: o valor digitado é aplicado logo abaixo via
                // estoque_model->registrar(), que também soma ao campo 'estoque'. Salvar
                // o valor aqui E somar de novo no registrar() era o que dobrava o estoque.
                'estoque'       => 0,
                'estoqueMinimo' => $this->input->post('estoqueMinimo'),
                'saida'         => $this->input->post('saida'),
                'entrada'       => $this->input->post('entrada'),
            ];

            $erroUploadFoto = $this->_uploadFotoProduto($data);

            if ($this->produtos_model->add('produtos', $data) == true) {
                // Registrar movimentação de estoque inicial
                // (o registrar() abaixo já soma ao estoque do produto — ver ajuste em $data)
                if ((int)$this->input->post('estoque') > 0) {
                    $this->load->model('estoque_model');
                    $pid = $this->db->insert_id();
                    if (method_exists($this->estoque_model, 'registrar')) {
                        $this->estoque_model->registrar($pid, 'entrada', 'inventario', null, (float)$this->input->post('estoque'), 'Estoque inicial');
                    } else {
                        // Fallback: se o model não tiver o método, seta direto (sem duplicar)
                        $this->db->where('idProdutos', $pid)->update('produtos', ['estoque' => (float)$this->input->post('estoque')]);
                    }
                }
                if ($erroUploadFoto) {
                    $this->session->set_flashdata('error', 'Produto adicionado, mas a imagem não pôde ser enviada: ' . $erroUploadFoto);
                } else {
                    $this->session->set_flashdata('success', 'Produto adicionado com sucesso!');
                }
                log_info('Adicionou um produto');
                redirect(site_url('produtos/adicionar/'));
            } else {
                $this->data['custom_error'] = '<div class="form_error"><p>An Error Occured.</p></div>';
            }
        }
        $this->data['view'] = 'produtos/adicionarProduto';

        return $this->layout();
    }

    public function editar()
    {
        if (! $this->uri->segment(3) || ! is_numeric($this->uri->segment(3)) || ! $this->produtos_model->getById($this->uri->segment(3))) {
            $this->session->set_flashdata('error', 'Produto não encontrado ou parâmetro inválido.');
            redirect('produtos/gerenciar');
        }

        if (! $this->permission->checkPermission($this->session->userdata('permissao'), 'eProduto')) {
            $this->session->set_flashdata('error', 'Você não tem permissão para editar produtos.');
            redirect(base_url());
        }
        $this->load->library('form_validation');
        $this->load->model('categorias_model');
        $this->data['custom_error'] = '';

        if ($this->form_validation->run('produtos') == false) {
            $this->data['custom_error'] = (validation_errors() ? '<div class="form_error">' . validation_errors() . '</div>' : false);
        } else {
            $precoCompra = $this->input->post('precoCompra');
            $precoCompra = str_replace(',', '', $precoCompra);
            $precoVenda = $this->input->post('precoVenda');
            $precoVenda = str_replace(',', '', $precoVenda);
            $data = [
                'codDeBarra'    => $this->input->post('codDeBarra'),
                'descricao'     => $this->input->post('descricao'),
                'marca'         => $this->input->post('marca'),
                'modelo'        => $this->input->post('modelo'),
                'localizacao'   => $this->input->post('localizacao'),
                'categorias_id' => $this->input->post('categorias_id') ?: null,
                'garantia_dias' => (int)$this->input->post('garantia_dias'),
                'ncm'           => $this->input->post('ncm'),
                'observacoes'   => $this->input->post('observacoes'),
                'unidade'       => $this->input->post('unidade'),
                'precoCompra'   => $precoCompra,
                'precoVenda'    => $precoVenda,
                'imei'          => $this->input->post('imei') ?: null,
                'numero_serie'  => $this->input->post('numero_serie') ?: null,
                'estoque'       => $this->input->post('estoque'),
                'estoqueMinimo' => $this->input->post('estoqueMinimo'),
                'saida'         => $this->input->post('saida'),
                'entrada'       => $this->input->post('entrada'),
            ];

            $erroUploadFoto = $this->_uploadFotoProduto($data);

            if ($this->produtos_model->edit('produtos', $data, 'idProdutos', $this->input->post('idProdutos')) == true) {
                if ($erroUploadFoto) {
                    $this->session->set_flashdata('error', 'Produto editado, mas a imagem não pôde ser enviada: ' . $erroUploadFoto);
                } else {
                    $this->session->set_flashdata('success', 'Produto editado com sucesso!');
                }
                log_info('Alterou um produto. ID: ' . $this->input->post('idProdutos'));
                redirect(site_url('produtos/editar/') . $this->input->post('idProdutos'));
            } else {
                $this->data['custom_error'] = '<div class="form_error"><p>An Error Occured</p></div>';
            }
        }

        $this->data['result'] = $this->produtos_model->getById($this->uri->segment(3));

        $this->data['view'] = 'produtos/editarProduto';

        return $this->layout();
    }

    public function visualizar()
    {
        if (! $this->uri->segment(3) || ! is_numeric($this->uri->segment(3))) {
            $this->session->set_flashdata('error', 'Item não pode ser encontrado, parâmetro não foi passado corretamente.');
            redirect('sisos');
        }

        if (! $this->permission->checkPermission($this->session->userdata('permissao'), 'vProduto')) {
            $this->session->set_flashdata('error', 'Você não tem permissão para visualizar produtos.');
            redirect(base_url());
        }

        $this->data['result'] = $this->produtos_model->getById($this->uri->segment(3));

        if ($this->data['result'] == null) {
            $this->session->set_flashdata('error', 'Produto não encontrado.');
            redirect(site_url('produtos/editar/') . $this->input->post('idProdutos'));
        }

        $this->data['view'] = 'produtos/visualizarProduto';

        return $this->layout();
    }

    public function excluir()
    {
        if (! $this->permission->checkPermission($this->session->userdata('permissao'), 'dProduto')) {
            $this->session->set_flashdata('error', 'Você não tem permissão para excluir produtos.');
            redirect(base_url());
        }

        $id = $this->input->post('id');
        if ($id == null) {
            $this->session->set_flashdata('error', 'Erro ao tentar excluir produto.');
            redirect(base_url() . 'index.php/produtos/gerenciar/');
        }

        $this->produtos_model->delete('produtos_os', 'produtos_id', $id);
        $this->produtos_model->delete('itens_de_vendas', 'produtos_id', $id);
        $this->produtos_model->delete('produtos', 'idProdutos', $id);

        log_info('Removeu um produto. ID: ' . $id);

        $this->session->set_flashdata('success', 'Produto excluido com sucesso!');
        redirect(site_url('produtos/gerenciar/'));
    }

    public function atualizar_estoque()
    {
        if (! $this->permission->checkPermission($this->session->userdata('permissao'), 'eProduto')) {
            $this->session->set_flashdata('error', 'Você não tem permissão para atualizar estoque de produtos.');
            redirect(base_url());
        }

        $idProduto = $this->input->post('id');
        $novoEstoque = $this->input->post('estoque');
        $estoqueAtual = $this->input->post('estoqueAtual');

        $estoque = $estoqueAtual + $novoEstoque;

        $data = [
            'estoque' => $estoque,
        ];

        if ($this->produtos_model->edit('produtos', $data, 'idProdutos', $idProduto) == true) {
            $this->session->set_flashdata('success', 'Estoque de Produto atualizado com sucesso!');
            log_info('Atualizou estoque de um produto. ID: ' . $idProduto);
            redirect(site_url('produtos/visualizar/') . $idProduto);
        } else {
            $this->data['custom_error'] = '<div class="alert">Ocorreu um erro.</div>';
        }
    }

    /**
     * Autocomplete de produtos por IMEI/Número de Série — útil pra achar
     * rápido um aparelho específico já cadastrado (ex: conferir garantia).
     */
    public function autoCompleteImeiSerial()
    {
        if (! isset($_GET['term'])) {
            return;
        }

        $q = $_GET['term'];
        $this->db->select('idProdutos, descricao, imei, numero_serie, marca, modelo');
        $this->db->group_start();
        $this->db->like('imei', $q);
        $this->db->or_like('numero_serie', $q);
        $this->db->group_end();
        $this->db->limit(15);
        $query = $this->db->get('produtos');

        $row_set = [];
        foreach ($query->result() as $row) {
            $row_set[] = [
                'label' => $row->descricao . (($row->marca || $row->modelo) ? ' (' . trim($row->marca . ' ' . $row->modelo) . ')' : '')
                    . ($row->imei ? ' | IMEI: ' . $row->imei : '')
                    . ($row->numero_serie ? ' | SN: ' . $row->numero_serie : ''),
                'id' => $row->idProdutos,
            ];
        }

        header('Content-Type: application/json');
        echo json_encode($row_set);
    }
}
