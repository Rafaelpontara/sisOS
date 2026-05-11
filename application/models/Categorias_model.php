<?php if (!defined('BASEPATH')) { exit('No direct script access allowed'); }

class Categorias_model extends CI_Model
{
    public function __construct() { parent::__construct(); }

    public function getGrupos($tipo = null)
    {
        $this->db->where('parent_id IS NULL', null, false);
        if ($tipo) $this->db->where('tipo', $tipo);
        $this->db->where('status', 1);
        $this->db->order_by('categoria');
        return $this->db->get('categorias')->result();
    }

    public function getFilhos($parent_id)
    {
        $this->db->where('parent_id', $parent_id);
        $this->db->where('status', 1);
        $this->db->order_by('categoria');
        return $this->db->get('categorias')->result();
    }

    public function getAll($tipo = null)
    {
        if ($tipo) $this->db->where('tipo', $tipo);
        $this->db->order_by('parent_id IS NULL DESC, parent_id, categoria');
        return $this->db->get('categorias')->result();
    }

    public function getById($id)
    {
        return $this->db->where('idCategorias', $id)->get('categorias')->row();
    }

    public function add($data)
    {
        $this->db->insert('categorias', $data);
        return $this->db->insert_id();
    }

    public function edit($id, $data)
    {
        $this->db->where('idCategorias', $id);
        return $this->db->update('categorias', $data);
    }

    public function delete($id)
    {
        // Mover filhos para o grupo pai se houver
        $this->db->where('parent_id', $id)->update('categorias', ['parent_id' => null]);
        $this->db->where('idCategorias', $id)->delete('categorias');
        return true;
    }

    /** Retorna array agrupado para selects */
    public function getParaSelect($tipo = null)
    {
        $grupos = $this->getGrupos($tipo);
        $result = [];
        foreach ($grupos as $g) {
            $filhos = $this->getFilhos($g->idCategorias);
            $result[] = ['grupo' => $g, 'filhos' => $filhos];
        }
        return $result;
    }

    /** Retorna nome completo "Grupo > Subcategoria" */
    public function getNomeCompleto($id)
    {
        $cat = $this->getById($id);
        if (!$cat) return '';
        if ($cat->parent_id) {
            $pai = $this->getById($cat->parent_id);
            return ($pai ? $pai->categoria . ' › ' : '') . $cat->categoria;
        }
        return $cat->categoria;
    }
}
