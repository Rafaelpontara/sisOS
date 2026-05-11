<?php if (!defined('BASEPATH')) { exit('No direct script access allowed'); }

class Compras_model extends CI_Model
{
    public function __construct() { parent::__construct(); }

    // ─── Compras ─────────────────────────────────────────────────────────────

    public function getAll($perpage = 0, $start = 0, $where = [])
    {
        $this->db->select('compras.*, clientes.nomeCliente, usuarios.nome as nomeUsuario');
        $this->db->from('compras');
        $this->db->join('clientes', 'clientes.idClientes = compras.clientes_id', 'left');
        $this->db->join('usuarios', 'usuarios.idUsuarios = compras.usuarios_id', 'left');

        if (!empty($where['pesquisa'])) {
            $this->db->group_start();
            $this->db->like('compras.descricao', $where['pesquisa']);
            $this->db->or_like('compras.fornecedor', $where['pesquisa']);
            $this->db->or_like('clientes.nomeCliente', $where['pesquisa']);
            $this->db->group_end();
        }
        if (!empty($where['status'])) {
            $this->db->where('compras.status', $where['status']);
        }
        if (!empty($where['de'])) {
            $this->db->where('compras.data_compra >=', $where['de']);
        }
        if (!empty($where['ate'])) {
            $this->db->where('compras.data_compra <=', $where['ate']);
        }

        $this->db->order_by('compras.idCompra', 'DESC');
        if ($perpage) { $this->db->limit($perpage, $start); }

        return $this->db->get()->result();
    }

    public function count($where = [])
    {
        if (!empty($where['pesquisa'])) {
            $this->db->like('descricao', $where['pesquisa']);
        }
        return $this->db->count_all_results('compras');
    }

    public function getById($id)
    {
        $this->db->select('compras.*, clientes.nomeCliente, clientes.documento, usuarios.nome as nomeUsuario');
        $this->db->from('compras');
        $this->db->join('clientes', 'clientes.idClientes = compras.clientes_id', 'left');
        $this->db->join('usuarios', 'usuarios.idUsuarios = compras.usuarios_id', 'left');
        $this->db->where('compras.idCompra', $id);
        return $this->db->get()->row();
    }

    public function add($data)
    {
        $this->db->insert('compras', $data);
        return $this->db->insert_id();
    }

    public function edit($id, $data)
    {
        $this->db->where('idCompra', $id);
        return $this->db->update('compras', $data);
    }

    public function delete($id)
    {
        $this->db->where('idCompra', $id);
        $this->db->delete('compras');
        $this->db->where('compras_id', $id);
        $this->db->delete('itens_de_compras');
        return true;
    }

    // ─── Itens das compras ────────────────────────────────────────────────────

    public function getItens($compra_id)
    {
        $this->db->select('itens_de_compras.*, produtos.descricao as nomeProduto');
        $this->db->from('itens_de_compras');
        $this->db->join('produtos', 'produtos.idProdutos = itens_de_compras.produtos_id', 'left');
        $this->db->where('itens_de_compras.compras_id', $compra_id);
        return $this->db->get()->result();
    }

    public function addItem($data)
    {
        $this->db->insert('itens_de_compras', $data);
        return $this->db->insert_id();
    }

    public function deleteItem($id)
    {
        $this->db->where('idItem', $id);
        return $this->db->delete('itens_de_compras');
    }

    // ─── Saídas de estoque ────────────────────────────────────────────────────

    public function getSaidas($perpage = 0, $start = 0, $where = [])
    {
        $this->db->select('saidas_estoque.*, produtos.descricao as nomeProduto, usuarios.nome as nomeUsuario');
        $this->db->from('saidas_estoque');
        $this->db->join('produtos', 'produtos.idProdutos = saidas_estoque.produtos_id', 'left');
        $this->db->join('usuarios', 'usuarios.idUsuarios = saidas_estoque.usuarios_id', 'left');

        if (!empty($where['pesquisa'])) {
            $this->db->group_start();
            $this->db->like('produtos.descricao', $where['pesquisa']);
            $this->db->or_like('saidas_estoque.motivo', $where['pesquisa']);
            $this->db->group_end();
        }
        if (!empty($where['de'])) {
            $this->db->where('saidas_estoque.data_saida >=', $where['de']);
        }
        if (!empty($where['ate'])) {
            $this->db->where('saidas_estoque.data_saida <=', $where['ate']);
        }

        $this->db->order_by('saidas_estoque.idSaida', 'DESC');
        if ($perpage) { $this->db->limit($perpage, $start); }
        return $this->db->get()->result();
    }

    public function countSaidas() { return $this->db->count_all_results('saidas_estoque'); }

    public function addSaida($data)
    {
        $this->db->insert('saidas_estoque', $data);
        return $this->db->insert_id();
    }

    public function deleteSaida($id)
    {
        $this->db->where('idSaida', $id);
        return $this->db->delete('saidas_estoque');
    }

    // ─── Estatísticas dashboard ───────────────────────────────────────────────

    public function totalMes()
    {
        $this->db->select_sum('valor_total');
        $this->db->where('MONTH(data_compra)', date('m'));
        $this->db->where('YEAR(data_compra)', date('Y'));
        $row = $this->db->get('compras')->row();
        return $row->valor_total ?? 0;
    }

    public function totalPendentes()
    {
        $this->db->where('status', 'pendente');
        return $this->db->count_all_results('compras');
    }
}
