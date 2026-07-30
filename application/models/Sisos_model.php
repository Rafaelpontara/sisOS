<?php

class Sisos_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    public function get($table, $fields, $where = '', $perpage = 0, $start = 0, $one = false, $array = 'array')
    {
        $this->db->select($fields);
        $this->db->from($table);
        $this->db->limit($perpage, $start);
        if ($where) {
            $this->db->where($where);
        }

        $query = $this->db->get();

        $result = ! $one ? $query->result() : $query->row();

        return $result;
    }

    public function getById($id)
    {
        $this->db->from('usuarios');
        $this->db->select('usuarios.*, permissoes.nome as permissao');
        $this->db->join('permissoes', 'permissoes.idPermissao = usuarios.permissoes_id', 'left');
        $this->db->where('idUsuarios', $id);
        $this->db->limit(1);

        return $this->db->get()->row();
    }

    public function alterarSenha($senha)
    {
        $this->db->set('senha', password_hash($senha, PASSWORD_DEFAULT));
        $this->db->where('idUsuarios', $this->session->userdata('id_admin'));
        $this->db->update('usuarios');

        if ($this->db->affected_rows() >= 0) {
            return true;
        }

        return false;
    }

    public function pesquisar($termo)
    {
        $data = [];
        $t = $this->db->escape_like_str($termo);

        // Clientes
        $this->db->like('nomeCliente', $termo);
        $this->db->or_like('telefone', $termo);
        $this->db->or_like('celular', $termo);
        $this->db->or_like('documento', $termo);
        $this->db->or_like('email', $termo);
        $this->db->limit(15);
        $data['clientes'] = $this->db->get('clientes')->result();

        // OS - search by number, client name, description, equipment
        $sql = "SELECT os.*, clientes.nomeCliente
                FROM os
                LEFT JOIN clientes ON os.clientes_id = clientes.idClientes
                WHERE os.idOs LIKE '%$t%'
                   OR os.descricaoProduto LIKE '%$t%'
                   OR os.defeito LIKE '%$t%'
                   OR os.equipamento LIKE '%$t%'
                   OR os.numeroSerie LIKE '%$t%'
                   OR clientes.nomeCliente LIKE '%$t%'
                LIMIT 15";
        $data['os'] = $this->db->query($sql)->result();

        // Produtos
        $this->db->like('codDeBarra', $termo);
        $this->db->or_like('descricao', $termo);
        $this->db->or_like('marca', $termo);
        $this->db->or_like('modelo', $termo);
        $this->db->limit(50);
        $data['produtos'] = $this->db->get('produtos')->result();

        // Serviços
        $this->db->like('nome', $termo);
        $this->db->limit(15);
        $data['servicos'] = $this->db->get('servicos')->result();

        // Vendas
        $sql2 = "SELECT vendas.*, clientes.nomeCliente
                 FROM vendas
                 LEFT JOIN clientes ON vendas.clientes_id = clientes.idClientes
                 WHERE vendas.idVendas LIKE '%$t%'
                    OR clientes.nomeCliente LIKE '%$t%'
                 LIMIT 10";
        $data['vendas'] = $this->db->query($sql2)->result();

        return $data;
    }

    public function add($table, $data)
    {
        $this->db->insert($table, $data);
        if ($this->db->affected_rows() == '1') {
            return true;
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

    public function getOsOrcamentos()
    {
        $this->db->select('os.*, clientes.nomeCliente');
        $this->db->from('os');
        $this->db->join('clientes', 'clientes.idClientes = os.clientes_id');
        $this->db->where('os.status', 'Orçamento');
        $this->db->limit(10);

        return $this->db->get()->result();
    }
    
    public function getOsAbertas()
    {
        $this->db->select('os.*, clientes.nomeCliente');
        $this->db->from('os');
        $this->db->join('clientes', 'clientes.idClientes = os.clientes_id');
        $this->db->where('os.status', 'Aberto');
        $this->db->limit(10);

        return $this->db->get()->result();
    }

    public function getOsFinalizadas()
    {
        $this->db->select('os.*, clientes.nomeCliente');
        $this->db->from('os');
        $this->db->join('clientes', 'clientes.idClientes = os.clientes_id');
        $this->db->where('os.status', 'Finalizado');
        $this->db->order_by('os.idOs', 'DESC');
        $this->db->limit(10);

        return $this->db->get()->result();
    }

    public function getOsAprovadas()
    {
        $this->db->select('os.*, clientes.nomeCliente');
        $this->db->from('os');
        $this->db->join('clientes', 'clientes.idClientes = os.clientes_id');
        $this->db->where('os.status', 'Aprovado');
        $this->db->limit(10);

        return $this->db->get()->result();
    }

    public function getOsAguardandoPecas()
    {
        $this->db->select('os.*, clientes.nomeCliente');
        $this->db->from('os');
        $this->db->join('clientes', 'clientes.idClientes = os.clientes_id');
        $this->db->where('os.status', 'Aguardando Peças');
        $this->db->limit(10);

        return $this->db->get()->result();
    }

    public function getOsAndamento()
    {
        $this->db->select('os.*, clientes.nomeCliente');
        $this->db->from('os');
        $this->db->join('clientes', 'clientes.idClientes = os.clientes_id');
        $this->db->where('os.status', 'Em Andamento');
        $this->db->limit(10);

        return $this->db->get()->result();
    }

    public function getOsStatus($status)
    {
        $this->db->select('os.*, clientes.nomeCliente');
        $this->db->from('os');
        $this->db->join('clientes', 'clientes.idClientes = os.clientes_id');
        $this->db->where_in('os.status', $status);
        $this->db->order_by('os.idOs', 'DESC');
        $this->db->limit(10);

        return $this->db->get()->result();
    }
    
    public function getVendasStatus($vstatus)
    {
        $this->db->select('vendas.*, clientes.nomeCliente');
        $this->db->from('vendas');
        $this->db->join('clientes', 'clientes.idClientes = vendas.clientes_id');
        $this->db->where_in('vendas.status', $vstatus);
        $this->db->order_by('vendas.idVendas', 'DESC');
        $this->db->limit(10);

        return $this->db->get()->result();
    }

    public function getLancamentos()
    {
        $this->db->select('idLancamentos, tipo, cliente_fornecedor, descricao, data_vencimento, forma_pgto, valor_desconto, baixado');
        $this->db->from('lancamentos');
        $this->db->where('baixado', 0);
        $this->db->order_by('idLancamentos', 'DESC');
        $this->db->limit(10);

        $query = $this->db->get();
        return $query->result();
    }

    public function calendario($start, $end, $status = null)
    {
        $this->db->select(
            'os.*,
            clientes.nomeCliente,
            COALESCE((SELECT SUM(produtos_os.preco * produtos_os.quantidade ) FROM produtos_os WHERE produtos_os.os_id = os.idOs), 0) totalProdutos,
            COALESCE((SELECT SUM(servicos_os.preco * servicos_os.quantidade ) FROM servicos_os WHERE servicos_os.os_id = os.idOs), 0) totalServicos'
        );
        $this->db->from('os');
        $this->db->join('clientes', 'clientes.idClientes = os.clientes_id');
        $this->db->join('produtos_os', 'produtos_os.os_id = os.idOs', 'left');
        $this->db->join('servicos_os', 'servicos_os.os_id = os.idOs', 'left');
        $this->db->where('os.dataFinal >=', $start);
        $this->db->where('os.dataFinal <=', $end);
        $this->db->group_by('os.idOs');

        if (! empty($status)) {
            $this->db->where('os.status', $status);
        }

        return $this->db->get()->result();
    }

    public function getProdutosMinimo()
    {
        $sql = 'SELECT * FROM produtos WHERE estoque <= estoqueMinimo AND estoqueMinimo > 0 LIMIT 10';

        return $this->db->query($sql)->result();
    }

    public function getOsEstatisticas()
    {
        $sql = 'SELECT status, COUNT(status) as total FROM os GROUP BY status ORDER BY status';

        return $this->db->query($sql)->result();
    }

    public function getEstatisticasFinanceiro()
    {
        $sql = "SELECT SUM(CASE WHEN baixado = 1 AND LOWER(tipo) = 'receita' THEN COALESCE(valor, 0)  END) as total_receita,
                       SUM(CASE WHEN baixado = 1 AND tipo = 'despesa' THEN valor END) as total_despesa,
                       SUM(CASE WHEN baixado = 0 AND LOWER(tipo) = 'receita' THEN COALESCE(valor, 0)  END) as total_receita_pendente,
                       SUM(CASE WHEN baixado = 0 AND tipo = 'despesa' THEN valor END) as total_despesa_pendente FROM lancamentos";
        if ($this->db->query($sql) !== false) {
            return $this->db->query($sql)->row();
        }

        return false;
    }

    public function getEstatisticasFinanceiroMes($year)
    {
        $numbersOnly = preg_replace('/[^0-9]/', '', $year);

        if (! $numbersOnly) {
            $numbersOnly = date('Y');
        }

        $sql = "
            SELECT
                SUM(CASE WHEN (EXTRACT(MONTH FROM data_pagamento) = 1) AND baixado = 1 AND LOWER(tipo) = 'receita' THEN COALESCE(valor, 0)  END) AS VALOR_JAN_REC,
                SUM(CASE WHEN (EXTRACT(MONTH FROM data_pagamento) = 1) AND baixado = 1 AND tipo = 'despesa' THEN valor END) AS VALOR_JAN_DES,
                SUM(CASE WHEN (EXTRACT(MONTH FROM data_pagamento) = 2) AND baixado = 1 AND LOWER(tipo) = 'receita' THEN COALESCE(valor, 0)  END) AS VALOR_FEV_REC,
                SUM(CASE WHEN (EXTRACT(MONTH FROM data_pagamento) = 2) AND baixado = 1 AND tipo = 'despesa' THEN valor END) AS VALOR_FEV_DES,
                SUM(CASE WHEN (EXTRACT(MONTH FROM data_pagamento) = 3) AND baixado = 1 AND LOWER(tipo) = 'receita' THEN COALESCE(valor, 0)  END) AS VALOR_MAR_REC,
                SUM(CASE WHEN (EXTRACT(MONTH FROM data_pagamento) = 3) AND baixado = 1 AND tipo = 'despesa' THEN valor END) AS VALOR_MAR_DES,
                SUM(CASE WHEN (EXTRACT(MONTH FROM data_pagamento) = 4) AND baixado = 1 AND LOWER(tipo) = 'receita' THEN COALESCE(valor, 0)  END) AS VALOR_ABR_REC,
                SUM(CASE WHEN (EXTRACT(MONTH FROM data_pagamento) = 4) AND baixado = 1 AND tipo = 'despesa' THEN valor END) AS VALOR_ABR_DES,
                SUM(CASE WHEN (EXTRACT(MONTH FROM data_pagamento) = 5) AND baixado = 1 AND LOWER(tipo) = 'receita' THEN COALESCE(valor, 0)  END) AS VALOR_MAI_REC,
                SUM(CASE WHEN (EXTRACT(MONTH FROM data_pagamento) = 5) AND baixado = 1 AND tipo = 'despesa' THEN valor END) AS VALOR_MAI_DES,
                SUM(CASE WHEN (EXTRACT(MONTH FROM data_pagamento) = 6) AND baixado = 1 AND LOWER(tipo) = 'receita' THEN COALESCE(valor, 0)  END) AS VALOR_JUN_REC,
                SUM(CASE WHEN (EXTRACT(MONTH FROM data_pagamento) = 6) AND baixado = 1 AND tipo = 'despesa' THEN valor END) AS VALOR_JUN_DES,
                SUM(CASE WHEN (EXTRACT(MONTH FROM data_pagamento) = 7) AND baixado = 1 AND LOWER(tipo) = 'receita' THEN COALESCE(valor, 0)  END) AS VALOR_JUL_REC,
                SUM(CASE WHEN (EXTRACT(MONTH FROM data_pagamento) = 7) AND baixado = 1 AND tipo = 'despesa' THEN valor END) AS VALOR_JUL_DES,
                SUM(CASE WHEN (EXTRACT(MONTH FROM data_pagamento) = 8) AND baixado = 1 AND LOWER(tipo) = 'receita' THEN COALESCE(valor, 0)  END) AS VALOR_AGO_REC,
                SUM(CASE WHEN (EXTRACT(MONTH FROM data_pagamento) = 8) AND baixado = 1 AND tipo = 'despesa' THEN valor END) AS VALOR_AGO_DES,
                SUM(CASE WHEN (EXTRACT(MONTH FROM data_pagamento) = 9) AND baixado = 1 AND LOWER(tipo) = 'receita' THEN COALESCE(valor, 0)  END) AS VALOR_SET_REC,
                SUM(CASE WHEN (EXTRACT(MONTH FROM data_pagamento) = 9) AND baixado = 1 AND tipo = 'despesa' THEN valor END) AS VALOR_SET_DES,
                SUM(CASE WHEN (EXTRACT(MONTH FROM data_pagamento) = 10) AND baixado = 1 AND LOWER(tipo) = 'receita' THEN COALESCE(valor, 0)  END) AS VALOR_OUT_REC,
                SUM(CASE WHEN (EXTRACT(MONTH FROM data_pagamento) = 10) AND baixado = 1 AND tipo = 'despesa' THEN valor END) AS VALOR_OUT_DES,
                SUM(CASE WHEN (EXTRACT(MONTH FROM data_pagamento) = 11) AND baixado = 1 AND LOWER(tipo) = 'receita' THEN COALESCE(valor, 0)  END) AS VALOR_NOV_REC,
                SUM(CASE WHEN (EXTRACT(MONTH FROM data_pagamento) = 11) AND baixado = 1 AND tipo = 'despesa' THEN valor END) AS VALOR_NOV_DES,
                SUM(CASE WHEN (EXTRACT(MONTH FROM data_pagamento) = 12) AND baixado = 1 AND LOWER(tipo) = 'receita' THEN COALESCE(valor, 0)  END) AS VALOR_DEZ_REC,
                SUM(CASE WHEN (EXTRACT(MONTH FROM data_pagamento) = 12) AND baixado = 1 AND tipo = 'despesa' THEN valor END) AS VALOR_DEZ_DES
            FROM lancamentos
            WHERE EXTRACT(YEAR FROM data_pagamento) = ?
        ";
        if ($this->db->query($sql, [intval($numbersOnly)]) !== false) {
            return $this->db->query($sql, [intval($numbersOnly)])->row();
        }

        return false;
    }

    public function getEstatisticasFinanceiroDia($year)
    {
        $numbersOnly = preg_replace('/[^0-9]/', '', $year);
        if (! $numbersOnly) {
            $numbersOnly = date('Y');
        }
        // 'valor' já é o total final pago — não subtrair desconto de novo.
        // LOWER(tipo) para pegar 'Receita' (PDV) e 'receita' (formulário web).
        $sql = '
            SELECT
                SUM(CASE WHEN (EXTRACT(DAY FROM data_pagamento) = ' . date('d') . ') AND EXTRACT(MONTH FROM data_pagamento) = ' . date('m') . " AND baixado = 1 AND LOWER(tipo) = 'receita' THEN COALESCE(valor, 0) END) AS VALOR_" . date('m') . '_REC,
                SUM(CASE WHEN (EXTRACT(DAY FROM data_pagamento) = ' . date('d') . ') AND EXTRACT(MONTH FROM data_pagamento) = ' . date('m') . " AND baixado = 1 AND LOWER(tipo) = 'despesa' THEN COALESCE(valor, 0) END) AS VALOR_" . date('m') . '_DES
            FROM lancamentos
            WHERE EXTRACT(YEAR FROM data_pagamento) = ?
        ';
        if ($this->db->query($sql, [intval($numbersOnly)]) !== false) {
            return $this->db->query($sql, [intval($numbersOnly)])->row();
        }

        return false;
    }

    public function getEstatisticasFinanceiroMesInadimplencia($year)
    {
        $numbersOnly = preg_replace('/[^0-9]/', '', $year);

        if (! $numbersOnly) {
            $numbersOnly = date('Y');
        }

        $sql = "
            SELECT
                SUM(CASE WHEN (EXTRACT(MONTH FROM data_pagamento) = 1) AND baixado = 0 AND LOWER(tipo) = 'receita' THEN valor END) AS VALOR_JAN_REC,
                SUM(CASE WHEN (EXTRACT(MONTH FROM data_pagamento) = 1) AND baixado = 0 AND tipo = 'despesa' THEN valor END) AS VALOR_JAN_DES,
                SUM(CASE WHEN (EXTRACT(MONTH FROM data_pagamento) = 2) AND baixado = 0 AND LOWER(tipo) = 'receita' THEN valor END) AS VALOR_FEV_REC,
                SUM(CASE WHEN (EXTRACT(MONTH FROM data_pagamento) = 2) AND baixado = 0 AND tipo = 'despesa' THEN valor END) AS VALOR_FEV_DES,
                SUM(CASE WHEN (EXTRACT(MONTH FROM data_pagamento) = 3) AND baixado = 0 AND LOWER(tipo) = 'receita' THEN valor END) AS VALOR_MAR_REC,
                SUM(CASE WHEN (EXTRACT(MONTH FROM data_pagamento) = 3) AND baixado = 0 AND tipo = 'despesa' THEN valor END) AS VALOR_MAR_DES,
                SUM(CASE WHEN (EXTRACT(MONTH FROM data_pagamento) = 4) AND baixado = 0 AND LOWER(tipo) = 'receita' THEN valor END) AS VALOR_ABR_REC,
                SUM(CASE WHEN (EXTRACT(MONTH FROM data_pagamento) = 4) AND baixado = 0 AND tipo = 'despesa' THEN valor END) AS VALOR_ABR_DES,
                SUM(CASE WHEN (EXTRACT(MONTH FROM data_pagamento) = 5) AND baixado = 0 AND LOWER(tipo) = 'receita' THEN valor END) AS VALOR_MAI_REC,
                SUM(CASE WHEN (EXTRACT(MONTH FROM data_pagamento) = 5) AND baixado = 0 AND tipo = 'despesa' THEN valor END) AS VALOR_MAI_DES,
                SUM(CASE WHEN (EXTRACT(MONTH FROM data_pagamento) = 6) AND baixado = 0 AND LOWER(tipo) = 'receita' THEN valor END) AS VALOR_JUN_REC,
                SUM(CASE WHEN (EXTRACT(MONTH FROM data_pagamento) = 6) AND baixado = 0 AND tipo = 'despesa' THEN valor END) AS VALOR_JUN_DES,
                SUM(CASE WHEN (EXTRACT(MONTH FROM data_pagamento) = 7) AND baixado = 0 AND LOWER(tipo) = 'receita' THEN valor END) AS VALOR_JUL_REC,
                SUM(CASE WHEN (EXTRACT(MONTH FROM data_pagamento) = 7) AND baixado = 0 AND tipo = 'despesa' THEN valor END) AS VALOR_JUL_DES,
                SUM(CASE WHEN (EXTRACT(MONTH FROM data_pagamento) = 8) AND baixado = 0 AND LOWER(tipo) = 'receita' THEN valor END) AS VALOR_AGO_REC,
                SUM(CASE WHEN (EXTRACT(MONTH FROM data_pagamento) = 8) AND baixado = 0 AND tipo = 'despesa' THEN valor END) AS VALOR_AGO_DES,
                SUM(CASE WHEN (EXTRACT(MONTH FROM data_pagamento) = 9) AND baixado = 0 AND LOWER(tipo) = 'receita' THEN valor END) AS VALOR_SET_REC,
                SUM(CASE WHEN (EXTRACT(MONTH FROM data_pagamento) = 9) AND baixado = 0 AND tipo = 'despesa' THEN valor END) AS VALOR_SET_DES,
                SUM(CASE WHEN (EXTRACT(MONTH FROM data_pagamento) = 10) AND baixado = 0 AND LOWER(tipo) = 'receita' THEN valor END) AS VALOR_OUT_REC,
                SUM(CASE WHEN (EXTRACT(MONTH FROM data_pagamento) = 10) AND baixado = 0 AND tipo = 'despesa' THEN valor END) AS VALOR_OUT_DES,
                SUM(CASE WHEN (EXTRACT(MONTH FROM data_pagamento) = 11) AND baixado = 0 AND LOWER(tipo) = 'receita' THEN valor END) AS VALOR_NOV_REC,
                SUM(CASE WHEN (EXTRACT(MONTH FROM data_pagamento) = 11) AND baixado = 0 AND tipo = 'despesa' THEN valor END) AS VALOR_NOV_DES,
                SUM(CASE WHEN (EXTRACT(MONTH FROM data_pagamento) = 12) AND baixado = 0 AND LOWER(tipo) = 'receita' THEN valor END) AS VALOR_DEZ_REC,
                SUM(CASE WHEN (EXTRACT(MONTH FROM data_pagamento) = 12) AND baixado = 0 AND tipo = 'despesa' THEN valor END) AS VALOR_DEZ_DES
            FROM lancamentos
            WHERE EXTRACT(YEAR FROM data_pagamento) = ?
        ";
        if ($this->db->query($sql, [intval($numbersOnly)]) !== false) {
            return $this->db->query($sql, [intval($numbersOnly)])->row();
        }

        return false;
    }


    public function getOsHoje()
    {
        try {
            $this->db->where('DATE(dataInicial)', date('Y-m-d'));
            return $this->db->count_all_results('os');
        } catch (Exception $e) { return 0; }
    }

    public function getOsPorStatus()
    {
        $sql = "SELECT status, COUNT(*) as total FROM os GROUP BY status";
        return $this->db->query($sql)->result();
    }

    public function getReceitaHoje()
    {
        try {
            // 'valor' no lançamento já é o total final pago (pós-desconto).
            // NÃO subtrair desconto de novo — causaria valor menor que o real.
            // LOWER(tipo) para pegar 'Receita' (PDV) e 'receita' (formulário web).
            $cols = $this->db->query("SHOW COLUMNS FROM lancamentos LIKE 'data_baixa'")->result();
            if (!empty($cols)) {
                $sql = "SELECT SUM(COALESCE(valor, 0)) as total
                        FROM lancamentos
                        WHERE baixado=1 AND LOWER(tipo)='receita'
                        AND DATE(data_baixa)=CURDATE()";
            } else {
                $sql = "SELECT SUM(COALESCE(valor, 0)) as total
                        FROM lancamentos
                        WHERE baixado=1 AND LOWER(tipo)='receita'
                        AND DATE(data_vencimento)=CURDATE()";
            }
            $result = $this->db->query($sql);
            if ($result === false) return 0;
            $r = $result->row();
            return $r->total ?? 0;
        } catch (Exception $e) {
            return 0;
        }
    }

    public function getOsVencidas()
    {
        try {
            $this->db->where('dataFinal <', date('Y-m-d'));
            $this->db->where('dataFinal IS NOT NULL', null, false);
            $this->db->where_in('status', ['Aberto','Em Andamento','Aguardando Peças','Aprovado','Orçamento']);
            return $this->db->count_all_results('os');
        } catch (Exception $e) { return 0; }
    }

    public function getEstoqueBaixo()
    {
        try {
            $sql = "SELECT COUNT(*) as total FROM produtos WHERE estoque <= estoqueMinimo AND estoqueMinimo > 0";
            $r = $this->db->query($sql);
            if (!$r) return 0;
            $row = $r->row();
            return $row->total ?? 0;
        } catch (Exception $e) { return 0; }
    }

    // ── Comparações "vs ontem" para os cards do dashboard ────────────────
    // Mesma lógica exata dos métodos de hoje acima, só trocando a data.

    public function getOsOntem()
    {
        try {
            $this->db->where('DATE(dataInicial)', date('Y-m-d', strtotime('-1 day')));
            return $this->db->count_all_results('os');
        } catch (Exception $e) { return 0; }
    }

    public function getReceitaOntem()
    {
        try {
            $ontem = date('Y-m-d', strtotime('-1 day'));
            $cols = $this->db->query("SHOW COLUMNS FROM lancamentos LIKE 'data_baixa'")->result();
            if (!empty($cols)) {
                $sql = "SELECT SUM(COALESCE(valor, 0)) as total
                        FROM lancamentos
                        WHERE baixado=1 AND LOWER(tipo)='receita'
                        AND DATE(data_baixa) = ?";
            } else {
                $sql = "SELECT SUM(COALESCE(valor, 0)) as total
                        FROM lancamentos
                        WHERE baixado=1 AND LOWER(tipo)='receita'
                        AND DATE(data_vencimento) = ?";
            }
            $result = $this->db->query($sql, [$ontem]);
            if ($result === false) return 0;
            $r = $result->row();
            return $r->total ?? 0;
        } catch (Exception $e) {
            return 0;
        }
    }

    public function getOsVencidasOntem()
    {
        try {
            $ontem = date('Y-m-d', strtotime('-1 day'));
            $this->db->where('dataFinal <', $ontem);
            $this->db->where('dataFinal IS NOT NULL', null, false);
            $this->db->where_in('status', ['Aberto','Em Andamento','Aguardando Peças','Aprovado','Orçamento']);
            return $this->db->count_all_results('os');
        } catch (Exception $e) { return 0; }
    }

    public function getEstoqueZerado()
    {
        try {
            $sql = "SELECT COUNT(*) as total FROM produtos WHERE estoque <= 0";
            $r = $this->db->query($sql);
            if (!$r) return 0;
            $row = $r->row();
            return $row->total ?? 0;
        } catch (Exception $e) { return 0; }
    }

    // ── Atividades Recentes ───────────────────────────────────────────────
    // OBS: usa dataInicial (OS) e dataVenda (Vendas) como "quando aconteceu",
    // pois não existe coluna de última atualização nessas tabelas. Ou seja,
    // uma OS que mudou de status há pouco só aparece aqui se dataInicial for
    // recente — não é um log de alterações de verdade, é uma aproximação.
    public function getAtividadesRecentes($limite = 5)
    {
        try {
            $limite = (int)$limite;
            $sql = "
                (SELECT 'os' as tipo, idOs as id, status, dataInicial as quando
                 FROM os ORDER BY dataInicial DESC LIMIT $limite)
                UNION ALL
                (SELECT 'venda' as tipo, idVendas as id, status, dataVenda as quando
                 FROM vendas ORDER BY dataVenda DESC LIMIT $limite)
                ORDER BY quando DESC LIMIT $limite
            ";
            $result = $this->db->query($sql);
            return $result ? $result->result() : [];
        } catch (Exception $e) { return []; }
    }

    public function getLancamentosPendentes()
    {
        try {
            $this->db->where('baixado', 0);
            $this->db->where('tipo', 'receita');
            $this->db->where('data_vencimento <', date('Y-m-d'));
            return $this->db->count_all_results('lancamentos');
        } catch (Exception $e) { return 0; }
    }

    public function getOsPorTecnico()
    {
        try {
            $sql = "SELECT u.nome as tecnico,
                        COUNT(o.idOs) as total,
                        SUM(CASE WHEN o.status IN ('Finalizado','Faturado') THEN 1 ELSE 0 END) as finalizadas,
                        AVG(CASE WHEN o.dataFinal IS NOT NULL AND o.dataInicial IS NOT NULL
                            THEN DATEDIFF(o.dataFinal, o.dataInicial) ELSE NULL END) as media_dias
                    FROM os o
                    LEFT JOIN usuarios u ON o.usuarios_id = u.idUsuarios
                    WHERE o.dataInicial >= DATE_SUB(CURDATE(), INTERVAL 30 DAY)
                    GROUP BY o.usuarios_id, u.nome
                    ORDER BY total DESC";
            $r = $this->db->query($sql);
            return $r ? $r->result() : [];
        } catch (Exception $e) {
            return [];
        }
    }

    public function getNotificacoes()
    {
        $notifs = [];

        // OS vencidas
        $vencidas = $this->getOsVencidas();
        if ($vencidas > 0) {
            $notifs[] = ['tipo' => 'danger', 'icone' => 'bx-time-five',
                'msg' => "$vencidas OS com prazo vencido", 'link' => site_url('os/gerenciar') . '?vencidas=1'];
        }

        // Estoque baixo
        $baixo = $this->getEstoqueBaixo();
        if ($baixo > 0) {
            $notifs[] = ['tipo' => 'warning', 'icone' => 'bx-package',
                'msg' => "$baixo produto(s) com estoque baixo", 'link' => site_url('produtos')];
        }

        // Pagamentos pendentes atrasados
        $pendentes = $this->getLancamentosPendentes();
        if ($pendentes > 0) {
            $notifs[] = ['tipo' => 'warning', 'icone' => 'bx-dollar-circle',
                'msg' => "$pendentes pagamento(s) pendente(s) vencido(s)",
                'link' => site_url('financeiro/lancamentos') . '?status=0&vencimento_de=01/01/2000&vencimento_ate=' . date('d/m/Y', strtotime('-1 day'))];
        }

        // Aniversariantes do dia (só clientes com "Notificar aniversário" ligado)
        $aniversariantes = $this->db
            ->select('idClientes, nomeCliente')
            ->where('notif_aniversario', 1)
            ->where('dataNascimento IS NOT NULL', null, false)
            ->where('MONTH(dataNascimento) = MONTH(CURDATE())', null, false)
            ->where('DAY(dataNascimento) = DAY(CURDATE())', null, false)
            ->get('clientes')->result();

        foreach ($aniversariantes as $c) {
            $notifs[] = ['tipo' => 'info', 'icone' => 'bx-cake',
                'msg' => 'Hoje é aniversário de ' . $c->nomeCliente,
                'link' => site_url('clientes/visualizar/' . $c->idClientes)];
        }

        return $notifs;
    }

    public function getEmitente()
    {
        return $this->db->get('emitente')->row();
    }

    public function addEmitente($nome, $cnpj, $ie, $cep, $logradouro, $numero, $bairro, $cidade, $uf, $telefone, $email, $logo)
    {
        $this->db->set('nome', $nome);
        $this->db->set('cnpj', $cnpj);
        $this->db->set('ie', $ie);
        $this->db->set('cep', $cep);
        $this->db->set('rua', $logradouro);
        $this->db->set('numero', $numero);
        $this->db->set('bairro', $bairro);
        $this->db->set('cidade', $cidade);
        $this->db->set('uf', $uf);
        $this->db->set('telefone', $telefone);
        $this->db->set('email', $email);
        $this->db->set('url_logo', $logo);

        return $this->db->insert('emitente');
    }

    public function editEmitente($id, $nome, $cnpj, $ie, $cep, $logradouro, $numero, $bairro, $cidade, $uf, $telefone, $email)
    {
        $this->db->set('nome', $nome);
        $this->db->set('cnpj', $cnpj);
        $this->db->set('ie', $ie);
        $this->db->set('cep', $cep);
        $this->db->set('rua', $logradouro);
        $this->db->set('numero', $numero);
        $this->db->set('bairro', $bairro);
        $this->db->set('cidade', $cidade);
        $this->db->set('uf', $uf);
        $this->db->set('telefone', $telefone);
        $this->db->set('email', $email);
        $this->db->where('id', $id);

        return $this->db->update('emitente');
    }

    public function editLogo($id, $logo)
    {
        $this->db->set('url_logo', $logo);
        $this->db->where('id', $id);

        return $this->db->update('emitente');
    }

    public function editImageUser($id, $imageUserPath)
    {
        $this->db->set('url_image_user', $imageUserPath);
        $this->db->where('idUsuarios', $id);

        return $this->db->update('usuarios');
    }

    public function check_credentials($email)
    {
        $this->db->where('email', $email);
        $this->db->where('situacao', 1);
        $this->db->limit(1);

        return $this->db->get('usuarios')->row();
    }

    /**
     * Salvar configurações do sistema
     *
     * @param  array  $data
     * @return bool
     */
    public function saveConfiguracao($data)
    {
        try {
            foreach ($data as $key => $valor) {
                $exists = $this->db->where('config', $key)->count_all_results('configuracoes');
                if ($exists) {
                    $this->db->set('valor', $valor);
                    $this->db->where('config', $key);
                    $this->db->update('configuracoes');
                } else {
                    $this->db->insert('configuracoes', ['config' => $key, 'valor' => $valor]);
                }
            }
        } catch (Exception $e) {
            return false;
        }

        return true;
    }
}
