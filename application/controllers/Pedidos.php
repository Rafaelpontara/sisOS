<?php

if (! defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Pedidos extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->helper('form');
        $this->data['menuPedidos'] = 'Pedidos';
    }

    public function index()
    {
        $this->gerenciar();
    }

    public function gerenciar()
    {
        if (! $this->permission->checkPermission($this->session->userdata('permissao'), 'vPedido')) {
            $this->session->set_flashdata('error', 'Você não tem permissão para visualizar pedidos.');
            redirect(base_url());
        }

        $pesquisa = $this->input->get('pesquisa');

        $this->data['pendentes'] = $this->_buscarPedidos('Pendente', $pesquisa);
        $this->data['comprados'] = $this->_buscarPedidos('Comprado', $pesquisa);
        $this->data['entregues'] = $this->_buscarPedidos('Entregue', $pesquisa);
        $this->data['pesquisa']  = $pesquisa;

        $this->data['view'] = 'pedidos/pedidos';

        return $this->layout();
    }

    /**
     * Busca os pedidos de uma coluna do quadro (status), já trazendo os dados
     * do cliente e do produto vinculados (quando houver) via LEFT JOIN.
     */
    private function _buscarPedidos($status, $pesquisa = null)
    {
        $this->db->select('pedidos_produtos.*, clientes.nomeCliente, clientes.celular AS celular_cliente, clientes.telefone AS telefone_cliente, produtos.descricao AS produto_cadastrado_desc');
        $this->db->from('pedidos_produtos');
        $this->db->join('clientes', 'clientes.idClientes = pedidos_produtos.clientes_id', 'left');
        $this->db->join('produtos', 'produtos.idProdutos = pedidos_produtos.produtos_id', 'left');
        $this->db->where('pedidos_produtos.status', $status);

        if ($pesquisa) {
            $this->db->group_start();
            $this->db->like('pedidos_produtos.descricao', $pesquisa);
            $this->db->or_like('clientes.nomeCliente', $pesquisa);
            $this->db->group_end();
        }

        if ($status === 'Pendente') {
            $this->db->order_by("FIELD(pedidos_produtos.prioridade,'Alta','Normal','Baixa')", '', false);
            $this->db->order_by('pedidos_produtos.dataCriacao', 'ASC');
        } elseif ($status === 'Comprado') {
            $this->db->order_by('pedidos_produtos.dataComprado', 'DESC');
        } else {
            $this->db->order_by('pedidos_produtos.dataEntregue', 'DESC');
        }

        $this->db->limit(100);

        return $this->db->get()->result();
    }

    public function adicionar()
    {
        if (! $this->permission->checkPermission($this->session->userdata('permissao'), 'aPedido')) {
            $this->session->set_flashdata('error', 'Você não tem permissão para adicionar pedidos.');
            redirect(base_url());
        }

        $descricao = trim((string) $this->input->post('descricao'));
        if ($descricao === '') {
            $this->session->set_flashdata('error', 'A descrição do item é obrigatória.');
            redirect(site_url('pedidos'));
        }

        $data = [
            'descricao'   => $descricao,
            'produtos_id' => $this->input->post('produtos_id') ?: null,
            'clientes_id' => $this->input->post('clientes_id') ?: null,
            'quantidade'  => (int) $this->input->post('quantidade') > 0 ? (int) $this->input->post('quantidade') : 1,
            'observacao'  => $this->input->post('observacao'),
            'prioridade'  => in_array($this->input->post('prioridade'), ['Baixa', 'Normal', 'Alta'], true) ? $this->input->post('prioridade') : 'Normal',
            'status'      => 'Pendente',
            'usuarios_id' => $this->session->userdata('idUsuarios') ?: null,
            'dataCriacao' => date('Y-m-d H:i:s'),
        ];

        $foto = $this->_processarFoto();
        if ($foto) {
            $data['foto'] = $foto;
        }

        $this->db->insert('pedidos_produtos', $data);
        log_info('Adicionou um pedido/anotação de produto. ID: ' . $this->db->insert_id());

        $this->session->set_flashdata('success', 'Pedido registrado com sucesso!');
        redirect(site_url('pedidos'));
    }

    public function editar()
    {
        if (! $this->permission->checkPermission($this->session->userdata('permissao'), 'ePedido')) {
            $this->session->set_flashdata('error', 'Você não tem permissão para editar pedidos.');
            redirect(base_url());
        }

        $id = $this->input->post('id');
        if (! $id) {
            $this->session->set_flashdata('error', 'Pedido não encontrado.');
            redirect(site_url('pedidos'));
        }

        $descricao = trim((string) $this->input->post('descricao'));
        if ($descricao === '') {
            $this->session->set_flashdata('error', 'A descrição do item é obrigatória.');
            redirect(site_url('pedidos'));
        }

        $data = [
            'descricao'   => $descricao,
            'produtos_id' => $this->input->post('produtos_id') ?: null,
            'clientes_id' => $this->input->post('clientes_id') ?: null,
            'quantidade'  => (int) $this->input->post('quantidade') > 0 ? (int) $this->input->post('quantidade') : 1,
            'observacao'  => $this->input->post('observacao'),
            'prioridade'  => in_array($this->input->post('prioridade'), ['Baixa', 'Normal', 'Alta'], true) ? $this->input->post('prioridade') : 'Normal',
        ];

        $pedidoAtual = $this->db->where('id', $id)->get('pedidos_produtos')->row();

        if ($this->input->post('remover_foto') && !empty($pedidoAtual->foto)) {
            $this->_apagarFotoFisica($pedidoAtual->foto);
            $data['foto'] = null;
        }

        $foto = $this->_processarFoto();
        if ($foto) {
            // Substituiu por uma nova: apaga a antiga do disco, se houver.
            if (!empty($pedidoAtual->foto)) {
                $this->_apagarFotoFisica($pedidoAtual->foto);
            }
            $data['foto'] = $foto;
        }

        $this->db->where('id', $id)->update('pedidos_produtos', $data);
        log_info('Editou um pedido/anotação de produto. ID: ' . $id);

        $this->session->set_flashdata('success', 'Pedido atualizado com sucesso!');
        redirect(site_url('pedidos'));
    }

    /**
     * Move o pedido entre as colunas do quadro (Pendente -> Comprado -> Entregue).
     * Chamado via AJAX tanto pelos botões de ação rápida quanto pelo drag-and-drop.
     */
    public function moverStatus()
    {
        header('Content-Type: application/json');

        if (! $this->permission->checkPermission($this->session->userdata('permissao'), 'ePedido')) {
            echo json_encode(['sucesso' => false, 'erro' => 'Você não tem permissão para mover pedidos.']);
            return;
        }

        $id = $this->input->post('id');
        $novoStatus = $this->input->post('status');

        if (! $id || ! in_array($novoStatus, ['Pendente', 'Comprado', 'Entregue'], true)) {
            echo json_encode(['sucesso' => false, 'erro' => 'Parâmetros inválidos.']);
            return;
        }

        $data = ['status' => $novoStatus];
        if ($novoStatus === 'Comprado') {
            $data['dataComprado'] = date('Y-m-d H:i:s');
        } elseif ($novoStatus === 'Entregue') {
            $data['dataEntregue'] = date('Y-m-d H:i:s');
        }

        $this->db->where('id', $id)->update('pedidos_produtos', $data);
        log_info('Alterou status de um pedido para ' . $novoStatus . '. ID: ' . $id);

        echo json_encode(['sucesso' => true]);
    }

    public function excluir()
    {
        if (! $this->permission->checkPermission($this->session->userdata('permissao'), 'dPedido')) {
            $this->session->set_flashdata('error', 'Você não tem permissão para excluir pedidos.');
            redirect(base_url());
        }

        $id = $this->input->post('id');
        if ($id) {
            $pedido = $this->db->where('id', $id)->get('pedidos_produtos')->row();
            if ($pedido && !empty($pedido->foto)) {
                $this->_apagarFotoFisica($pedido->foto);
            }
            $this->db->where('id', $id)->delete('pedidos_produtos');
            log_info('Removeu um pedido/anotação de produto. ID: ' . $id);
        }

        $this->session->set_flashdata('success', 'Pedido removido.');
        redirect(site_url('pedidos'));
    }

    /**
     * Autocomplete de produtos já cadastrados (busca por descrição, marca ou modelo).
     * Endpoint próprio, independente do controller Produtos.php, para não mexer
     * em nada do módulo de produtos já existente.
     */
    public function autoCompleteProduto()
    {
        header('Content-Type: application/json');

        if (! isset($_GET['term']) || trim($_GET['term']) === '') {
            echo json_encode([]);
            return;
        }
        $q = $_GET['term'];

        $this->db->select('idProdutos, descricao, marca, modelo, estoque');
        $this->db->from('produtos');
        $this->db->group_start();
        $this->db->like('descricao', $q);
        $this->db->or_like('marca', $q);
        $this->db->or_like('modelo', $q);
        $this->db->group_end();
        $this->db->limit(20);
        $query = $this->db->get();

        $row_set = [];
        foreach ($query->result() as $row) {
            $partes = array_filter([$row->descricao, $row->marca, $row->modelo]);
            $label  = implode(' - ', $partes) . ' (estoque: ' . (int) $row->estoque . ')';
            $row_set[] = [
                'label'     => $label,
                'id'        => $row->idProdutos,
                'descricao' => $row->descricao,
            ];
        }

        echo json_encode($row_set);
    }

    /**
     * Processa o upload de uma foto única do pedido (campo "foto" do formulário).
     * Retorna a URL pública salva, ou null se nenhum arquivo válido foi enviado.
     */
    private function _processarFoto()
    {
        if (empty($_FILES['foto']['name'])) {
            return null;
        }

        $pasta = FCPATH . 'assets/img/pedidos/';
        if (! file_exists($pasta)) {
            mkdir($pasta, DIR_WRITE_MODE, true);
        }

        $this->load->library('upload', [
            'upload_path'   => $pasta,
            'allowed_types' => 'jpg|jpeg|png|webp',
            'max_size'      => 4096, // 4MB
            'encrypt_name'  => true,
        ]);

        if ($this->upload->do_upload('foto')) {
            return base_url('assets/img/pedidos/' . $this->upload->data('file_name'));
        }

        return null;
    }

    /**
     * Apaga o arquivo físico de uma foto de pedido, se ele pertencer a este servidor
     * (por segurança, nunca tenta apagar links externos).
     */
    private function _apagarFotoFisica($caminho)
    {
        if (strpos($caminho, base_url()) !== 0) {
            return;
        }
        $caminhoFisico = FCPATH . ltrim(str_replace(base_url(), '', $caminho), '/');
        if (is_file($caminhoFisico)) {
            @unlink($caminhoFisico);
        }
    }
}
