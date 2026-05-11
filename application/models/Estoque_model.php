<?php if (!defined('BASEPATH')) { exit('No direct script access allowed'); }

class Estoque_model extends CI_Model
{
    public function __construct() { parent::__construct(); }

    /** Registra uma movimentação e atualiza o saldo do produto */
    public function registrar($produtos_id, $tipo, $origem, $origem_id, $quantidade, $observacao = null)
    {
        $produto = $this->db->where('idProdutos', $produtos_id)->get('produtos')->row();
        if (!$produto) return false;

        $antes  = (float)$produto->estoque;
        $depois = $tipo === 'entrada' ? $antes + $quantidade : $antes - $quantidade;

        $this->db->insert('estoque_movimentacoes', [
            'produtos_id'    => $produtos_id,
            'tipo'           => $tipo,
            'origem'         => $origem,
            'origem_id'      => $origem_id,
            'quantidade'     => $quantidade,
            'estoque_antes'  => $antes,
            'estoque_depois' => $depois,
            'observacao'     => $observacao,
            'usuarios_id'    => $this->session->userdata('id_admin') ?: 1,
        ]);

        $this->db->where('idProdutos', $produtos_id)->update('produtos', ['estoque' => $depois]);
        return $depois;
    }

    /** Listagem de movimentações com filtros */
    public function getMovimentacoes($perpage = 0, $start = 0, $where = [])
    {
        $this->db->select('em.*, p.descricao as nomeProduto, p.estoque as estoque_atual, u.nome as nomeUsuario');
        $this->db->from('estoque_movimentacoes em');
        $this->db->join('produtos p', 'p.idProdutos = em.produtos_id', 'left');
        $this->db->join('usuarios u', 'u.idUsuarios = em.usuarios_id', 'left');

        if (!empty($where['produtos_id'])) $this->db->where('em.produtos_id', $where['produtos_id']);
        if (!empty($where['tipo']))        $this->db->where('em.tipo', $where['tipo']);
        if (!empty($where['origem']))      $this->db->where('em.origem', $where['origem']);
        if (!empty($where['de']))          $this->db->where('DATE(em.created_at) >=', $where['de']);
        if (!empty($where['ate']))         $this->db->where('DATE(em.created_at) <=', $where['ate']);
        if (!empty($where['pesquisa']))    $this->db->like('p.descricao', $where['pesquisa']);

        $this->db->order_by('em.id', 'DESC');
        if ($perpage) $this->db->limit($perpage, $start);
        return $this->db->get()->result();
    }

    public function countMovimentacoes($where = [])
    {
        $this->db->from('estoque_movimentacoes em');
        $this->db->join('produtos p', 'p.idProdutos = em.produtos_id', 'left');
        if (!empty($where['produtos_id'])) $this->db->where('em.produtos_id', $where['produtos_id']);
        if (!empty($where['tipo']))        $this->db->where('em.tipo', $where['tipo']);
        if (!empty($where['pesquisa']))    $this->db->like('p.descricao', $where['pesquisa']);
        return $this->db->count_all_results();
    }

    /** Resumo por produto (para inventário) */
    public function getResumoEstoque($pesquisa = null)
    {
        $this->db->select('p.idProdutos, p.descricao, p.marca, p.localizacao, p.estoque, p.estoqueMinimo,
            SUM(CASE WHEN em.tipo="entrada" THEN em.quantidade ELSE 0 END) as total_entradas,
            SUM(CASE WHEN em.tipo="saida" THEN em.quantidade ELSE 0 END) as total_saidas');
        $this->db->from('produtos p');
        $this->db->join('estoque_movimentacoes em', 'em.produtos_id = p.idProdutos', 'left');
        if ($pesquisa) $this->db->like('p.descricao', $pesquisa);
        $this->db->group_by('p.idProdutos');
        $this->db->order_by('p.descricao');
        return $this->db->get()->result();
    }

    /** Produtos abaixo do estoque mínimo */
    public function getAbaixoMinimo()
    {
        $this->db->where('estoque <= estoqueMinimo');
        $this->db->where('estoqueMinimo >', 0);
        return $this->db->get('produtos')->result();
    }
}
