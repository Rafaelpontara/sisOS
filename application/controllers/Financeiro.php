<?php

if (! defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Financeiro extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('financeiro_model');
        $this->load->helper('codegen_helper');
        $this->data['menuLancamentos'] = 'financeiro';
    }

    public function index()
    {
        $this->lancamentos();
    }

    public function dashboard()
    {
        if (!$this->permission->checkPermission($this->session->userdata('permissao'), 'vLancamento')) {
            redirect(base_url());
        }

        $this->load->model('categorias_model');

        // Período
        $mes  = (int)($this->input->get('mes')  ?: date('m'));
        $ano  = (int)($this->input->get('ano')  ?: date('Y'));
        $tipo = $this->input->get('tipo') ?: '';

        $inicio = sprintf('%04d-%02d-01', $ano, $mes);
        $fim    = date('Y-m-t', strtotime($inicio));

        $where = "data_vencimento >= '$inicio' AND data_vencimento <= '$fim'";
        if ($tipo === 'receita') $where .= " AND tipo = 'receita'";
        if ($tipo === 'despesa') $where .= " AND tipo = 'despesa'";

        // Totais cards
        $sql = "SELECT
            SUM(CASE WHEN baixado=1 AND tipo='receita' THEN IF(valor_desconto=0,valor,valor_desconto) ELSE 0 END) as receitas_pagas,
            SUM(CASE WHEN baixado=0 AND tipo='receita' THEN IF(valor_desconto=0,valor,valor_desconto) ELSE 0 END) as receitas_pendentes,
            SUM(CASE WHEN baixado=1 AND tipo='despesa' THEN valor-desconto ELSE 0 END) as despesas_pagas,
            SUM(CASE WHEN baixado=0 AND tipo='despesa' THEN valor-desconto ELSE 0 END) as despesas_pendentes,
            SUM(CASE WHEN tipo='receita' THEN IF(valor_desconto=0,valor,valor_desconto) ELSE 0 END) as receitas_sem_desconto,
            SUM(CASE WHEN tipo='despesa' THEN valor ELSE 0 END) as despesas_sem_desconto,
            SUM(CASE WHEN baixado=1 THEN desconto ELSE 0 END) as descontos_aplicados
            FROM lancamentos WHERE $where";

        $qTotais = $this->db->query($sql);
        $this->data['totais'] = $qTotais ? $qTotais->row() : (object)[];

        // Lançamentos do período com join de categoria
        $sqlLanc = "SELECT l.*,
            c.categoria as nome_categoria,
            cp.categoria as nome_grupo
            FROM lancamentos l
            LEFT JOIN categorias c  ON c.idCategorias = l.categorias_id
            LEFT JOIN categorias cp ON cp.idCategorias = c.parent_id
            WHERE $where ORDER BY l.data_vencimento DESC";

        $qLanc = $this->db->query($sqlLanc);

        // Fallback caso parent_id não exista ou query falhe
        if ($qLanc === false) {
            $sqlLanc = "SELECT l.*, c.categoria as nome_categoria, '' as nome_grupo
                FROM lancamentos l
                LEFT JOIN categorias c ON c.idCategorias = l.categorias_id
                WHERE $where ORDER BY l.data_vencimento DESC";
            $qLanc = $this->db->query($sqlLanc);
        }

        $this->data['lancamentos'] = $qLanc ? $qLanc->result() : [];

        $this->data['mes']  = $mes;
        $this->data['ano']  = $ano;
        $this->data['tipo'] = $tipo;
        $this->data['menuDashFinanceiro'] = true;
        $this->data['menuLancamentos'] = 'financeiro';
        $this->data['view'] = 'financeiro/dashboard';
        return $this->layout();
    }

    public function lancamentos()
    {
        if (! $this->permission->checkPermission($this->session->userdata('permissao'), 'vLancamento')) {
            $this->session->set_flashdata('error', 'Você não tem permissão para visualizar lançamentos.');
            redirect(base_url());
        }

        $where = '';
        $vencimento_de  = $this->input->get('vencimento_de')  ?: date('d/m/Y');
        $vencimento_ate = $this->input->get('vencimento_ate') ?: date('d/m/Y');
        $cliente  = $this->input->get('cliente');
        $tipo     = $this->input->get('tipo');
        $status   = $this->input->get('status');
        $periodo  = $this->input->get('periodo');

        if (! empty($vencimento_de)) {
            $date = DateTime::createFromFormat('d/m/Y', $vencimento_de);
            if ($date) {
                $dateString = $date->format('Y-m-d');
                $where = empty($where)
                    ? "data_vencimento >= '$dateString'"
                    : "$where AND data_vencimento >= '$dateString'";
            }
        }

        if (! empty($vencimento_ate)) {
            $date = DateTime::createFromFormat('d/m/Y', $vencimento_ate);
            if ($date) {
                $dateString = $date->format('Y-m-d');
                $where = empty($where)
                    ? "data_vencimento <= '$dateString'"
                    : "$where AND data_vencimento <= '$dateString'";
            }
        }

        if (isset($status) && $status != '') {
            $where = empty($where)
                ? "baixado = '$status'"
                : "$where AND baixado = '$status'";
        }

        if (! empty($cliente)) {
            $where = empty($where)
                ? "cliente_fornecedor LIKE '%{$cliente}%'"
                : "$where AND cliente_fornecedor LIKE '%{$cliente}%'";
        }

        if (! empty($tipo)) {
            $where = empty($where)
                ? "tipo = '$tipo'"
                : "$where AND tipo = '$tipo'";
        }

        $this->load->library('pagination');

        $this->data['configuration']['base_url'] = site_url("financeiro/lancamentos/?vencimento_de=$vencimento_de&vencimento_ate=$vencimento_ate&cliente=$cliente&tipo=$tipo&status=$status&periodo=$periodo");
        $this->data['configuration']['total_rows'] = $this->financeiro_model->count('lancamentos', $where);
        $this->data['configuration']['page_query_string'] = true;

        $this->pagination->initialize($this->data['configuration']);

        $this->data['results'] = $this->financeiro_model->get('lancamentos', '*', $where, $this->data['configuration']['per_page'], $this->input->get('per_page'));
        $this->data['totals']  = $this->financeiro_model->getTotals($where);
        $this->data['estatisticas_financeiro'] = $this->financeiro_model->getEstatisticasFinanceiro2();

        $this->data['view'] = 'financeiro/lancamentos';
        return $this->layout();
    }

    // ─── RECEITA ──────────────────────────────────────────────────────────────

    public function adicionarReceita()
    {
        if (!$this->permission->checkPermission($this->session->userdata('permissao'), 'aLancamento')) {
            $this->session->set_flashdata('error', 'Você não tem permissão para adicionar lançamentos.');
            redirect(base_url());
        }

        $this->load->library('form_validation');
        $this->data['custom_error'] = '';
        $urlAtual = $this->input->post('urlAtual');

        // Validação manual — mais confiável que form_validation com campos dinâmicos
        $v_descricao  = trim($this->input->post('descricao'));
        $v_cliente    = trim($this->input->post('cliente'));
        $v_valor      = trim($this->input->post('valor'));
        $v_vencimento = trim($this->input->post('vencimento'));

        if (empty($v_descricao) || empty($v_cliente) || empty($v_valor) || empty($v_vencimento)) {
            $this->session->set_flashdata('error', 'Preencha todos os campos obrigatórios da receita.');
            if ($urlAtual) redirect($urlAtual); else redirect(site_url('financeiro/lancamentos'));
            return;
        }

        if (true) {
            $vencimento  = $this->input->post('vencimento');
            $recebimento = $this->input->post('recebimento');

            if ($recebimento != null) {
                $parts = explode('/', $recebimento);
                $recebimento = $parts[2] . '-' . $parts[1] . '-' . $parts[0];
            }
            if ($vencimento == null) {
                $vencimento = date('d/m/Y');
            }
            try {
                $parts = explode('/', $vencimento);
                $vencimento = $parts[2] . '-' . $parts[1] . '-' . $parts[0];
            } catch (Exception $e) {
                $vencimento = date('Y-m-d');
            }

            $valor          = str_replace(',', '.', $this->input->post('valor'));
            $valor_desconto = floatval(str_replace(',', '.', $this->input->post('valor_desconto')));
            $desconto       = $valor_desconto;
            $total_sem_desc = floatval($valor) + $valor_desconto;
            $valor          = $total_sem_desc;
            $valor_desconto = $valor - $desconto;

            if (!is_numeric($valor_desconto)) {
                $valor_desconto = 0;
            }
            if (!is_numeric($valor)) {
                $valor = 0;
            }

            $data = [
                'descricao'          => set_value('descricao'),
                'valor'              => number_format($valor, 2, '.', ''),
                'valor_desconto'     => number_format($valor_desconto, 2, '.', ''),
                'desconto'           => $desconto,
                'tipo_desconto'      => 'real',
                'data_vencimento'    => $vencimento,
                'data_pagamento'     => $recebimento ?: date('Y-m-d'),
                'baixado'            => $this->input->post('recebido') ?: 0,
                'cliente_fornecedor' => set_value('cliente'),
                'forma_pgto'         => $this->input->post('formaPgto'),
                'tipo'               => 'receita',
                'observacoes'        => set_value('observacoes'),
                'usuarios_id'        => $this->session->userdata('id_admin'),
            ];

            if (set_value('idCliente')) {
                $data['clientes_id'] = set_value('idCliente');
            }
            if (empty($data['valor_desconto'])) {
                $data['valor_desconto'] = '0';
            }

            if ($this->financeiro_model->add('lancamentos', $data) == true) {
                $this->session->set_flashdata('success', 'Receita adicionada com sucesso!');
                log_info('Adicionou uma receita em Financeiro');
                redirect($urlAtual);
            } else {
                $this->session->set_flashdata('error', 'Ocorreu um erro ao tentar adicionar a receita.');
                redirect($urlAtual);
            }
        }

        $this->session->set_flashdata('error', 'Ocorreu um erro ao tentar adicionar a receita.');
        redirect($urlAtual);
    }

    public function adicionarReceita_parc()
    {
        $urlAtual = $this->input->post('urlAtual');

        if (! $this->permission->checkPermission($this->session->userdata('permissao'), 'aLancamento')) {
            $this->session->set_flashdata('error', 'Você não tem permissão para adicionar lançamentos.');
            redirect(base_url());
        }

        $valor_desconto   = str_replace(',', '.', $this->input->post('desconto_parc') ?: 0);
        $entrada          = $this->input->post('entrada') ?: 0;
        $qtdparcelas_parc = $this->input->post('qtdparcelas_parc') ?: 1;
        $valor_parc       = $this->input->post('valor_parc');
        $valorparcelas    = ($valor_parc - $entrada) / $qtdparcelas_parc;

        $desconto_por_parcela = $valor_desconto > 0 ? ($valor_desconto / $qtdparcelas_parc) : 0;
        $descricao_parc_valor = $valor_parc + $valor_desconto;
        $total_com_desconto   = $valorparcelas + $desconto_por_parcela;

        if ($entrada >= $valor_parc) {
            $this->session->set_flashdata('error', 'O valor da entrada não pode ser maior ou igual ao valor total!');
            redirect($urlAtual);
        }

        $dia_pgto      = $this->input->post('dia_pgto');
        $dia_base_pgto = $this->input->post('dia_base_pgto');
        $recebimento   = $this->input->post('recebimento');

        try {
            $p = explode('/', $dia_pgto);
            $dia_pgto = $p[2] . '-' . $p[1] . '-' . $p[0];

            $p = explode('/', $dia_base_pgto);
            $dia_base_pgto = $p[2] . '-' . $p[1] . '-' . $p[0];
        } catch (Exception $e) {
            $dia_pgto = date('Y-m-d');
            $dia_base_pgto = date('Y-m-d');
        }

        if ($recebimento) {
            try {
                $p = explode('/', $recebimento);
                $recebimento = $p[2] . '-' . $p[1] . '-' . $p[0];
            } catch (Exception $e) {}
        }

        if ($entrada == 0) {
            $loops = 1;
            while ($loops <= $qtdparcelas_parc) {
                $myDateTime  = new DateTime($dia_base_pgto);
                $myDayOfMonth = date_format($myDateTime, 'j');
                date_modify($myDateTime, '+' . ($loops - 1) . ' months');
                $myNewDayOfMonth = date_format($myDateTime, 'j');
                if ($myDayOfMonth > 28 && $myNewDayOfMonth < 4) {
                    date_modify($myDateTime, "-$myNewDayOfMonth days");
                }

                $data = [
                    'descricao'          => $this->input->post('descricao_parc') . ' - Parcelamento de R$' . $descricao_parc_valor . ' [' . $loops . '/' . $qtdparcelas_parc . ']',
                    'valor'              => $total_com_desconto,
                    'desconto'           => $desconto_por_parcela,
                    'tipo_desconto'      => 'real',
                    'valor_desconto'     => $valorparcelas,
                    'data_vencimento'    => date_format($myDateTime, 'Y-m-d'),
                    'data_pagamento'     => $recebimento ?: date_format($myDateTime, 'Y-m-d'),
                    'baixado'            => 0,
                    'cliente_fornecedor' => $this->input->post('cliente_parc'),
                    'clientes_id'        => $this->input->post('idCliente_parc'),
                    'observacoes'        => $this->input->post('observacoes_parc'),
                    'forma_pgto'         => $this->input->post('formaPgto_parc'),
                    'tipo'               => $this->input->post('tipo_parc'),
                    'usuarios_id'        => $this->session->userdata('id_admin'),
                ];

                if ($this->financeiro_model->add('lancamentos', $data) == true) {
                    $this->session->set_flashdata('success', 'Lançamento adicionado com sucesso!');
                    log_info('Adicionou um lançamento parcelado em Financeiro');
                }
                $loops++;
            }
            redirect($urlAtual);
        } else {
            $data1 = [
                'descricao'          => $this->input->post('descricao_parc') . ' - Entrada do parc. de R$' . $descricao_parc_valor,
                'valor'              => $entrada,
                'desconto'           => 0,
                'valor_desconto'     => $entrada,
                'tipo_desconto'      => 'real',
                'data_vencimento'    => $dia_pgto,
                'data_pagamento'     => $dia_pgto ?: date('Y-m-d'),
                'baixado'            => 1,
                'cliente_fornecedor' => $this->input->post('cliente_parc'),
                'clientes_id'        => $this->input->post('idCliente_parc'),
                'observacoes'        => $this->input->post('observacoes_parc'),
                'forma_pgto'         => $this->input->post('formaPgto_parc'),
                'tipo'               => $this->input->post('tipo_parc'),
                'usuarios_id'        => $this->session->userdata('id_admin'),
            ];
            $this->financeiro_model->add1('lancamentos', $data1);

            $loops = 1;
            while ($loops <= $qtdparcelas_parc) {
                $myDateTime   = new DateTime($dia_base_pgto);
                $myDayOfMonth = date_format($myDateTime, 'j');
                date_modify($myDateTime, '+' . ($loops - 1) . ' months');
                $myNewDayOfMonth = date_format($myDateTime, 'j');
                if ($myDayOfMonth > 28 && $myNewDayOfMonth < 4) {
                    date_modify($myDateTime, "-$myNewDayOfMonth days");
                }

                $data = [
                    'descricao'          => $this->input->post('descricao_parc') . ' - Parcelamento de R$' . $descricao_parc_valor . ' [' . $loops . '/' . $qtdparcelas_parc . ']',
                    'valor'              => $total_com_desconto,
                    'desconto'           => $desconto_por_parcela,
                    'tipo_desconto'      => 'real',
                    'valor_desconto'     => $valorparcelas,
                    'data_vencimento'    => date_format($myDateTime, 'Y-m-d'),
                    'data_pagamento'     => date_format($myDateTime, 'Y-m-d'),
                    'baixado'            => 0,
                    'cliente_fornecedor' => $this->input->post('cliente_parc'),
                    'clientes_id'        => $this->input->post('idCliente_parc'),
                    'observacoes'        => $this->input->post('observacoes_parc'),
                    'forma_pgto'         => $this->input->post('formaPgto_parc'),
                    'tipo'               => $this->input->post('tipo_parc'),
                    'usuarios_id'        => $this->session->userdata('id_admin'),
                ];

                if ($this->financeiro_model->add('lancamentos', $data) == true) {
                    $this->session->set_flashdata('success', 'Lançamento adicionado com sucesso!');
                    log_info('Adicionou um lançamento parcelado em Financeiro');
                }
                $loops++;
            }
            redirect($urlAtual);
        }

        $this->session->set_flashdata('error', 'Ocorreu um erro ao tentar adicionar o lançamento');
        redirect($urlAtual);
    }

    // ─── DESPESA ──────────────────────────────────────────────────────────────

    public function adicionarDespesa()
    {
        if (! $this->permission->checkPermission($this->session->userdata('permissao'), 'aLancamento')) {
            $this->session->set_flashdata('error', 'Você não tem permissão para adicionar lançamentos.');
            redirect(base_url());
        }

        $this->data['custom_error'] = '';
        $urlAtual = $this->input->post('urlAtual');

        // Validação manual — campos usam sufixo _desp para evitar conflito com modal de receita
        $descricao  = trim($this->input->post('descricao_desp'));
        $valor_raw  = trim($this->input->post('valor_desp'));
        $vencimento = trim($this->input->post('vencimento_desp'));
        $fornecedor = trim($this->input->post('fornecedor_desp'));

        if (empty($descricao) || empty($valor_raw) || empty($vencimento) || empty($fornecedor)) {
            $this->session->set_flashdata('error', 'Preencha todos os campos obrigatórios da despesa.');
            if ($urlAtual) redirect($urlAtual); else redirect(site_url('financeiro/lancamentos'));
            return;
        }

        if (true) {
            $pagamento = $this->input->post('pagamento_desp');

            if ($pagamento != null) {
                $parts = explode('/', $pagamento);
                $pagamento = $parts[2] . '-' . $parts[1] . '-' . $parts[0];
            }

            // Converte vencimento dd/mm/yyyy -> yyyy-mm-dd
            try {
                $parts = explode('/', $vencimento);
                $vencimento = $parts[2] . '-' . $parts[1] . '-' . $parts[0];
            } catch (Exception $e) {
                $vencimento = date('Y-m-d');
            }

            // Converte valor monetário brasileiro para float
            $valor = str_replace(',', '.', $valor_raw);
            // Remove separador de milhar se houver (ex: 1.500,00 -> 1500.00)
            if (substr_count($valor, '.') > 1) {
                $valor = str_replace('.', '', $valor_raw);
                $valor = str_replace(',', '.', $valor);
            }
            if (!is_numeric($valor)) {
                $valor = preg_replace('/[^0-9]/', '', $valor_raw);
            }

            $data = [
                'descricao'          => $descricao,
                'valor'              => $valor,
                'desconto'           => 0,
                'valor_desconto'     => 0,
                'tipo_desconto'      => 'real',
                'data_vencimento'    => $vencimento,
                'data_pagamento'     => $pagamento ?: date('Y-m-d'),
                'baixado'            => $this->input->post('pago_desp') ?: 0,
                'cliente_fornecedor' => $fornecedor,
                'forma_pgto'         => $this->input->post('formaPgto_desp'),
                'tipo'               => 'despesa',
                'observacoes'        => $this->input->post('observacoes_desp'),
                'categorias_id'      => $this->input->post('categoria_desp') ?: null,
                'usuarios_id'        => $this->session->userdata('id_admin'),
            ];

            if ($this->input->post('idFornecedor_desp')) {
                $data['clientes_id'] = $this->input->post('idFornecedor_desp');
            }

            if ($this->financeiro_model->add('lancamentos', $data) == true) {
                $this->session->set_flashdata('success', 'Despesa adicionada com sucesso!');
                log_info('Adicionou uma despesa');
                redirect($urlAtual);
            } else {
                $this->session->set_flashdata('error', 'Ocorreu um erro ao tentar adicionar despesa!');
                redirect($urlAtual);
            }
        }

        $this->session->set_flashdata('error', 'Ocorreu um erro ao tentar adicionar despesa.');
        redirect($urlAtual);
    }

    // ─── EDITAR ───────────────────────────────────────────────────────────────

    public function editar()
    {
        if (! $this->permission->checkPermission($this->session->userdata('permissao'), 'eLancamento')) {
            $this->session->set_flashdata('error', 'Você não tem permissão para editar lançamentos.');
            redirect(base_url());
        }

        $this->load->library('form_validation');
        $this->data['custom_error'] = '';
        $urlAtual = $this->input->post('urlAtual');

        $this->form_validation->set_rules('descricao', '', 'trim|required');
        $this->form_validation->set_rules('fornecedor', '', 'trim|required');
        $this->form_validation->set_rules('valor',      '', 'trim|required');
        $this->form_validation->set_rules('vencimento', '', 'trim|required');
        $this->form_validation->set_rules('pagamento',  '', 'trim');

        if ($this->form_validation->run() == false) {
            $this->data['custom_error'] = (validation_errors() ? '<div class="form_error">' . validation_errors() . '</div>' : false);
        } else {
            $vencimento = $this->input->post('vencimento');
            $pagamento  = $this->input->post('pagamento');

            try {
                $p = explode('/', $vencimento);
                $vencimento = $p[2] . '-' . $p[1] . '-' . $p[0];

                if ($pagamento) {
                    $p = explode('/', $pagamento);
                    $pagamento = $p[2] . '-' . $p[1] . '-' . $p[0];
                }
            } catch (Exception $e) {
                $vencimento = date('Y-m-d');
            }

            $parseMoney = static function ($value) {
                if ($value === null || $value === '') return 0.0;
                return (float) str_replace(',', '.', $value);
            };

            $valor_total      = $parseMoney($this->input->post('valor'));
            $desconto         = $parseMoney($this->input->post('descontos_editar'));
            $valor_com_desconto = $parseMoney($this->input->post('valor_desconto_editar'));

            if ($valor_com_desconto <= 0) {
                $valor_com_desconto = $valor_total - $desconto;
            }
            if ($desconto <= 0 && $valor_total > $valor_com_desconto) {
                $desconto = $valor_total - $valor_com_desconto;
            }
            if ($valor_com_desconto < 0) {
                $valor_com_desconto = 0;
            }

            $data = [
                'descricao'          => $this->input->post('descricao'),
                'data_vencimento'    => $vencimento,
                'data_pagamento'     => $pagamento,
                'valor'              => $valor_total,
                'desconto'           => $desconto,
                'tipo_desconto'      => 'real',
                'valor_desconto'     => $valor_com_desconto,
                'baixado'            => $this->input->post('pago') ?: 0,
                'cliente_fornecedor' => $this->input->post('fornecedor'),
                'forma_pgto'         => $this->input->post('formaPgto'),
                'tipo'               => $this->input->post('tipo'),
                'observacoes'        => $this->input->post('observacoes'),
                'usuarios_id'        => $this->session->userdata('id_admin'),
            ];

            if ($this->input->post('idFornecedor')) {
                $data['clientes_id'] = $this->input->post('idFornecedor');
            }
            if (empty($data['valor_desconto'])) {
                $data['valor_desconto'] = '0';
            }
            if ($this->input->post('idCliente')) {
                $data['clientes_id'] = $this->input->post('idCliente');
            }

            if ($this->financeiro_model->edit('lancamentos', $data, 'idLancamentos', $this->input->post('id')) == true) {
                $this->session->set_flashdata('success', 'Lançamento editado com sucesso!');
                log_info('Alterou um lançamento no financeiro. ID ' . $this->input->post('id'));
                redirect($urlAtual);
            } else {
                $this->session->set_flashdata('error', 'Ocorreu um erro ao tentar editar lançamento!');
                redirect($urlAtual);
            }
        }

        $this->session->set_flashdata('error', 'Ocorreu um erro ao tentar editar lançamento.');
        redirect($urlAtual);
    }

    // ─── EXCLUIR ──────────────────────────────────────────────────────────────

    public function excluirLancamento()
    {
        if (! $this->permission->checkPermission($this->session->userdata('permissao'), 'dLancamento')) {
            $this->session->set_flashdata('error', 'Você não tem permissão para excluir lançamentos.');
            redirect(base_url());
        }

        $id = $this->input->post('id');

        if ($id == null || ! is_numeric($id)) {
            echo json_encode(['result' => false, 'message' => 'ID inválido']);
            exit();
        }

        $this->db->trans_start();

        $this->db->set('lancamentos_id', null);
        $this->db->set('faturado', 0);
        $this->db->set('status', 'Finalizado');
        $this->db->where('lancamentos_id', $id);
        $this->db->update('vendas');

        $result = $this->financeiro_model->delete('lancamentos', 'idLancamentos', $id);

        if ($result) {
            $this->db->trans_complete();
            if ($this->db->trans_status() === false) {
                $this->db->trans_rollback();
                $this->session->set_flashdata('error', 'Ocorreu um erro ao tentar excluir o lançamento.');
                $json = ['result' => false, 'message' => 'Erro na transação'];
            } else {
                log_info('Excluiu um lançamento. ID: ' . $id);
                $this->session->set_flashdata('success', 'Lançamento excluído com sucesso!');
                $json = ['result' => true];
            }
        } else {
            $this->db->trans_rollback();
            $this->session->set_flashdata('error', 'Ocorreu um erro ao tentar excluir o lançamento.');
            $json = ['result' => false, 'message' => 'Erro ao excluir lançamento'];
        }

        echo json_encode($json);
        exit();
    }

    // ─── AUTOCOMPLETE ─────────────────────────────────────────────────────────

    public function autoCompleteClienteFornecedor()
    {
        if (isset($_GET['term'])) {
            $q = strtolower($_GET['term']);
            $this->financeiro_model->autoCompleteClienteFornecedor($q);
        }
    }

    public function autoCompleteClienteAddReceita()
    {
        if (isset($_GET['term'])) {
            $q = strtolower($_GET['term']);
            $this->financeiro_model->autoCompleteClienteReceita($q);
        }
    }

    // ─── HELPERS DE PERÍODO ───────────────────────────────────────────────────

    protected function getThisYear()
    {
        $dias     = date('z');
        $primeiro = date('Y-m-d', strtotime('-' . $dias . ' day'));
        $ultimo   = date('Y-m-d', strtotime('+' . (364 - $dias) . ' day'));
        return [$primeiro, $ultimo];
    }

    protected function getThisWeek()
    {
        return [
            date('Y/m/d', strtotime('last sunday', strtotime('now'))),
            date('Y/m/d', strtotime('next saturday', strtotime('now')))
        ];
    }

    protected function getLastSevenDays()
    {
        return [
            date('Y-m-d', strtotime('-7 day')),
            date('Y-m-d')
        ];
    }

    protected function getThisMonth()
    {
        $mes = date('m');
        $ano = date('Y');
        return [
            $ano . '-' . $mes . '-01',
            $ano . '-' . $mes . '-' . date('t')
        ];
    }
}
