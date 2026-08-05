<?php

class Clientes_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    public function get($table, $fields, $where = '', $perpage = 0, $start = 0, $one = false, $array = 'array', $antesDe = 0, $apenasFornecedor = false, $tagId = 0)
    {
        $this->db->select($fields);
        $this->db->from($table);

        // Filtro por tag (categoria do cliente) — só aplica o JOIN se a tabela
        // de tags já existir (SQL cliente_tags_add_tables.sql precisa ter sido
        // rodado); senão ignora o filtro em vez de quebrar a query inteira.
        if ($tagId > 0 && $this->db->table_exists('clientes_tags')) {
            $this->db->join('clientes_tags ctf', 'ctf.clientes_id = ' . $table . '.idClientes');
            $this->db->where('ctf.cliente_tags_id', $tagId);
        }

        // Agrupa as condições de busca (nome/documento/email/telefone) entre
        // parênteses — sem isso, combinar com outro WHERE (como o cursor
        // abaixo) faria o SQL avaliar errado por causa da precedência de
        // AND/OR (um filtro "vazaria" pras outras condições OR).
        if ($where) {
            $this->db->group_start();
            $this->db->like('nomeCliente', $where);
            $this->db->or_like('documento', $where);
            $this->db->or_like('email', $where);
            $this->db->or_like('telefone', $where);
            // Pesquisa por ID do cliente — se o termo digitado for só números,
            // também considera bater exatamente com o idClientes.
            if (ctype_digit((string) $where)) {
                $this->db->or_where('idClientes', (int) $where);
            }
            $this->db->group_end();
        }

        // Filtro "somente fornecedores"
        if ($apenasFornecedor) {
            $this->db->where('fornecedor', 1);
        }

        // Paginação por cursor (mais rápida que OFFSET em bases grandes,
        // porque usa o índice da chave primária em vez de "pular e
        // descartar" registros) — usada pela rolagem infinita da tela de
        // Clientes. Quando não informado, cai no OFFSET tradicional (usado
        // no 1º carregamento da página, ou por qualquer outra tela que
        // ainda chame este método sem o cursor).
        if ($antesDe > 0) {
            $this->db->where('idClientes <', (int) $antesDe);
        }

        $this->db->order_by('idClientes', 'desc');
        $this->db->limit($perpage, $antesDe > 0 ? 0 : $start);

        $query = $this->db->get();

        $result = ! $one ? $query->result() : $query->row();

        return $result;
    }

    /**
     * Tags de uma lista de clientes, agrupadas por clientes_id — usado na
     * tela de listagem pra não precisar de 1 query por card.
     */
    public function getTagsPorCliente($idsClientes)
    {
        if (empty($idsClientes)) {
            return [];
        }

        // Mesma guarda: sem as tabelas de tags criadas, retorna vazio em vez
        // de quebrar a listagem inteira de clientes.
        if (! $this->db->table_exists('clientes_tags') || ! $this->db->table_exists('cliente_tags')) {
            return [];
        }

        // ct.id/ct.nome são os nomes reais no banco — aliasados pra idTag/tag
        // pra não precisar mudar a view que já espera esses nomes.
        $this->db->select('clt.clientes_id, ct.id AS idTag, ct.nome AS tag, ct.cor');
        $this->db->from('clientes_tags clt');
        $this->db->join('cliente_tags ct', 'ct.id = clt.cliente_tags_id');
        $this->db->where_in('clt.clientes_id', $idsClientes);
        $rows = $this->db->get()->result();

        $porCliente = [];
        foreach ($rows as $r) {
            $porCliente[$r->clientes_id][] = $r;
        }

        return $porCliente;
    }

    public function getById($id)
    {
        $this->db->where('idClientes', $id);
        $this->db->limit(1);

        return $this->db->get('clientes')->row();
    }

    public function add($table, $data)
    {
        $this->db->insert($table, $data);
        if ($this->db->affected_rows() == '1') {
            return $this->db->insert_id($table);
        }

        return false;
    }

    public function edit($table, $data, $fieldID, $ID)
    {
        $this->db->where($fieldID, $ID);
        $this->db->update($table, $data);

        if ($this->db->affected_rows() >= 0) {
            return true;
        }

        return false;
    }

    public function delete($table, $fieldID, $ID)
    {
        $this->db->where($fieldID, $ID);
        $this->db->delete($table);
        if ($this->db->affected_rows() == '1') {
            return true;
        }

        return false;
    }

    public function count($table)
    {
        return $this->db->count_all($table);
    }

    public function getOsByCliente($id)
    {
        $this->db->where('clientes_id', $id);
        $this->db->order_by('idOs', 'desc');
        $this->db->limit(10);

        return $this->db->get('os')->result();
    }

    /**
     * Retorna todas as OS vinculados ao cliente
     *
     * @param  int  $id
     * @return array
     */
    public function getAllOsByClient($id)
    {
        $this->db->where('clientes_id', $id);

        return $this->db->get('os')->result();
    }

    /**
     * Remover todas as OS por cliente
     *
     * @param  array  $os
     * @return bool
     */
    public function removeClientOs($os)
    {
        try {
            foreach ($os as $o) {
                $this->db->where('os_id', $o->idOs);
                $this->db->delete('servicos_os');

                $this->db->where('os_id', $o->idOs);
                $this->db->delete('produtos_os');

                $this->db->where('idOs', $o->idOs);
                $this->db->delete('os');
            }
        } catch (Exception $e) {
            return false;
        }

        return true;
    }

    /**
     * Retorna todas as Vendas vinculados ao cliente
     *
     * @param  int  $id
     * @return array
     */
    public function getAllVendasByClient($id)
    {
        $this->db->where('clientes_id', $id);

        return $this->db->get('vendas')->result();
    }

    /**
     * Remover todas as Vendas por cliente
     *
     * @param  array  $vendas
     * @return bool
     */
    public function removeClientVendas($vendas)
    {
        try {
            foreach ($vendas as $v) {
                $this->db->where('vendas_id', $v->idVendas);
                $this->db->delete('itens_de_vendas');

                $this->db->where('idVendas', $v->idVendas);
                $this->db->delete('vendas');
            }
        } catch (Exception $e) {
            return false;
        }

        return true;
    }

    /**
     * Verifica se o e-mail já existe na tabela de clientes
     *
     * @param  string  $email
     * @param  int     $id (opcional, para excluir o próprio cliente na edição)
     * @return bool
     */
    public function emailExists($email, $id = null)
    {
        $this->db->where('email', $email);
        
        if ($id !== null) {
            $this->db->where('idClientes !=', $id);
        }
        
        $query = $this->db->get('clientes');
        
        return $query->num_rows() > 0;
    }

    public function addReturnId($table, $data)
    {
        $this->db->insert($table, $data);
        $id = $this->db->insert_id();
        return $id ?: false;
    }

    public function buscarParaAutocomplete($term)
    {
        $this->db->select('idClientes as id, nomeCliente as label, nomeCliente as value');
        $this->db->like('nomeCliente', $term);
        $this->db->or_like('documento', $term);
        $this->db->or_like('telefone', $term);
        $this->db->limit(10);
        $result = $this->db->get('clientes');
        return $result->result_array();
    }

}