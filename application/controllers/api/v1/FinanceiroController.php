<?php
defined('BASEPATH') or exit('No direct script access allowed');

class FinanceiroController extends REST_Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    /** Verifica permissão financeira */
    private function _temPermissao()
    {
        $this->logged_user();
        $level = $this->logged_user()->level;
        // Não existe "admin universal" no sistema — cada perfil tem seu próprio
        // conjunto de permissões na tabela `permissoes`. Acesso ao financeiro
        // depende de ter pelo menos uma destas chaves marcadas como 1.
        return $this->permission->checkPermission($level, 'vLancamento')
            || $this->permission->checkPermission($level, 'aLancamento')
            || $this->permission->checkPermission($level, 'rFinanceiro');
    }

    // ══════════════════════════════════════════════════════════════
    // GET /api/v1/financeiro/dashboard
    // Params: mes, ano
    // ══════════════════════════════════════════════════════════════
    public function dashboard_get()
    {
        if (!$this->_temPermissao()) {
            $this->response(['status'=>false,'message'=>'Sem permissão.'], 403); return;
        }

        $mes = $this->get('mes') ?: date('m');
        $ano = $this->get('ano') ?: date('Y');

        // Receitas pagas no mês
        $rec = $this->db->select_sum('valor')
            ->where('LOWER(tipo)', 'receita')
            ->where('baixado', 1)
            ->where('MONTH(data_vencimento)', $mes)
            ->where('YEAR(data_vencimento)',  $ano)
            ->get('lancamentos')->row();

        // Despesas pagas no mês
        $desp = $this->db->select_sum('valor')
            ->where('LOWER(tipo)', 'despesa')
            ->where('baixado', 1)
            ->where('MONTH(data_vencimento)', $mes)
            ->where('YEAR(data_vencimento)',  $ano)
            ->get('lancamentos')->row();

        // Receitas pendentes
        $recPend = $this->db->select_sum('valor')
            ->where('LOWER(tipo)', 'receita')
            ->where('baixado', 0)
            ->get('lancamentos')->row();

        // Despesas pendentes
        $despPend = $this->db->select_sum('valor')
            ->where('LOWER(tipo)', 'despesa')
            ->where('baixado', 0)
            ->get('lancamentos')->row();

        // Total de lançamentos do mês
        $totalLanc = $this->db
            ->where('MONTH(data_vencimento)', $mes)
            ->where('YEAR(data_vencimento)',  $ano)
            ->count_all_results('lancamentos');

        $receitas  = floatval($rec->valor  ?? 0);
        $despesas  = floatval($desp->valor ?? 0);

        $this->response([
            'status' => true,
            'result' => [
                'receitas'         => $receitas,
                'despesas'         => $despesas,
                'saldo'            => $receitas - $despesas,
                'pendentes'        => floatval($recPend->valor  ?? 0),
                'despesas_pend'    => floatval($despPend->valor ?? 0),
                'total_lancamentos'=> $totalLanc,
                'mes'              => $mes,
                'ano'              => $ano,
            ],
        ], 200);
    }

    // ══════════════════════════════════════════════════════════════
    // GET /api/v1/financeiro/lancamentos
    // Params: tipo, page, perPage, search, baixado, mes, ano
    // ══════════════════════════════════════════════════════════════
    public function lancamentos_get()
    {
        if (!$this->_temPermissao()) {
            $this->response(['status'=>false,'message'=>'Sem permissão.'], 403); return;
        }

        $perPage = (int)($this->get('perPage') ?: 30);
        $page    = max(1, (int)($this->get('page') ?: 1));
        $tipo    = $this->get('tipo')   ?: '';
        $search  = $this->get('search') ?: '';
        $baixado = $this->get('baixado');
        $mes     = $this->get('mes')    ?: '';
        $ano     = $this->get('ano')    ?: '';
        $start   = ($page - 1) * $perPage;

        $this->db->select('lancamentos.*, COALESCE(clientes.nomeCliente, lancamentos.cliente_fornecedor, \'\') as nomeCliente');
        $this->db->from('lancamentos');
        $this->db->join('clientes', 'clientes.idClientes = lancamentos.clientes_id', 'left');

        if ($tipo)    $this->db->where('LOWER(lancamentos.tipo)', strtolower($tipo));
        if ($search)  $this->db->like('lancamentos.descricao', $search);
        if ($mes)     $this->db->where('MONTH(lancamentos.data_vencimento)', $mes);
        if ($ano)     $this->db->where('YEAR(lancamentos.data_vencimento)',  $ano);
        if ($baixado !== null && $baixado !== '') {
            $this->db->where('lancamentos.baixado', (int)$baixado);
        }

        // Total para paginação
        $total = $this->db->count_all_results('', false);

        $this->db->order_by('lancamentos.data_vencimento', 'DESC');
        $this->db->limit($perPage, $start);
        $result = $this->db->get()->result();

        $this->response([
            'status'  => true,
            'result'  => $result,
            'total'   => $total,
            'page'    => $page,
            'perPage' => $perPage,
            'pages'   => ceil($total / $perPage),
        ], 200);
    }

    // ══════════════════════════════════════════════════════════════
    // POST /api/v1/financeiro/lancamentos
    // ══════════════════════════════════════════════════════════════
    public function lancamentos_post()
    {
        $this->logged_user();
        $level = $this->logged_user()->level;
        if (!$this->permission->checkPermission($level, 'aLancamento')) {
            $this->response(['status'=>false,'message'=>'Sem permissão.'], 403); return;
        }

        $_POST = (array) json_decode(file_get_contents('php://input'), true);

        $descricao = trim($this->post('descricao') ?? '');
        $valor     = floatval($this->post('valor') ?? 0);
        if (!$descricao || $valor <= 0) {
            $this->response(['status'=>false,'message'=>'Descrição e valor são obrigatórios.'], 400); return;
        }

        $data = [
            'descricao'          => $descricao,
            'valor'              => $valor,
            'valor_desconto'     => $valor,
            'tipo'               => ucfirst(strtolower($this->post('tipo') ?: 'Receita')),
            'forma_pgto'         => $this->post('forma_pgto') ?: '',
            'data_vencimento'    => $this->post('data_vencimento') ?: date('Y-m-d'),
            'baixado'            => (int)($this->post('baixado') ?: 0),
            'cliente_fornecedor' => $this->post('cliente_fornecedor') ?: '',
            'observacoes'        => $this->post('observacoes') ?: '',
            'usuarios_id'        => $this->session->userdata('id_admin'),
        ];

        // Vincular cliente se informado
        if ($this->post('clientes_id')) {
            $data['clientes_id'] = (int)$this->post('clientes_id');
        }
        // Vincular venda se informado
        if ($this->post('vendas_id')) {
            $data['vendas_id'] = (int)$this->post('vendas_id');
        }

        if ($this->db->insert('lancamentos', $data)) {
            $this->response([
                'status'  => true,
                'message' => 'Lançamento criado com sucesso!',
                'result'  => ['id' => $this->db->insert_id()],
            ], 200);
        } else {
            $this->response(['status'=>false,'message'=>'Erro ao criar lançamento.'], 500);
        }
    }

    // ══════════════════════════════════════════════════════════════
    // PUT /api/v1/financeiro/lancamentos/{id}
    // ══════════════════════════════════════════════════════════════
    public function lancamentos_put($id)
    {
        $this->logged_user();
        $level = $this->logged_user()->level;
        if (!$this->permission->checkPermission($level, 'aLancamento')) {
            $this->response(['status'=>false,'message'=>'Sem permissão.'], 403); return;
        }

        if (!$id) {
            $this->response(['status'=>false,'message'=>'ID não informado.'], 400); return;
        }

        $lanc = $this->db->where('idLancamentos', $id)->get('lancamentos')->row();
        if (!$lanc) {
            $this->response(['status'=>false,'message'=>'Lançamento não encontrado.'], 404); return;
        }

        $_POST = (array) json_decode(file_get_contents('php://input'), true);

        $data = [];
        if (isset($_POST['descricao']))       $data['descricao']       = $_POST['descricao'];
        if (isset($_POST['valor']))            $data['valor']           = floatval($_POST['valor']);
        if (isset($_POST['tipo']))             $data['tipo']            = ucfirst(strtolower($_POST['tipo']));
        if (isset($_POST['forma_pgto']))       $data['forma_pgto']      = $_POST['forma_pgto'];
        if (isset($_POST['data_vencimento'])) $data['data_vencimento'] = $_POST['data_vencimento'];
        if (isset($_POST['baixado']))          $data['baixado']         = (int)$_POST['baixado'];
        if (isset($_POST['observacoes']))      $data['observacoes']     = $_POST['observacoes'];

        if (empty($data)) {
            $this->response(['status'=>false,'message'=>'Nenhum campo para atualizar.'], 400); return;
        }

        $this->db->where('idLancamentos', $id)->update('lancamentos', $data);

        $this->response([
            'status'  => true,
            'message' => 'Lançamento atualizado!',
            'result'  => $this->db->where('idLancamentos', $id)->get('lancamentos')->row(),
        ], 200);
    }

    // ══════════════════════════════════════════════════════════════
    // DELETE /api/v1/financeiro/lancamentos/{id}
    // ══════════════════════════════════════════════════════════════
    public function lancamentos_delete($id)
    {
        $this->logged_user();
        $level = $this->logged_user()->level;
        if (!$this->permission->checkPermission($level, 'rFinanceiro')) {
            $this->response(['status'=>false,'message'=>'Sem permissão.'], 403); return;
        }

        if (!$id) {
            $this->response(['status'=>false,'message'=>'ID não informado.'], 400); return;
        }

        $lanc = $this->db->where('idLancamentos', $id)->get('lancamentos')->row();
        if (!$lanc) {
            $this->response(['status'=>false,'message'=>'Lançamento não encontrado.'], 404); return;
        }

        $this->db->where('idLancamentos', $id)->delete('lancamentos');
        $this->response(['status'=>true,'message'=>'Lançamento excluído!'], 200);
    }

    // ══════════════════════════════════════════════════════════════
    // POST /api/v1/financeiro/baixar/{id}
    // Dá baixa em um lançamento (marca como pago)
    // ══════════════════════════════════════════════════════════════
    public function baixar_post($id)
    {
        $this->logged_user();
        $level = $this->logged_user()->level;
        if (!$this->permission->checkPermission($level, 'aLancamento')) {
            $this->response(['status'=>false,'message'=>'Sem permissão.'], 403); return;
        }

        if (!$id) {
            $this->response(['status'=>false,'message'=>'ID não informado.'], 400); return;
        }

        $_POST = (array) json_decode(file_get_contents('php://input'), true);

        $this->db->where('idLancamentos', $id)->update('lancamentos', [
            'baixado'         => 1,
            'data_pagamento'  => $this->post('data_pagamento') ?: date('Y-m-d'),
            'forma_pgto'      => $this->post('forma_pgto') ?: '',
        ]);

        $this->response(['status'=>true,'message'=>'Lançamento baixado com sucesso!'], 200);
    }

    // ══════════════════════════════════════════════════════════════
    // GET /api/v1/financeiro/resumo-anual
    // Retorna resumo mês a mês do ano
    // ══════════════════════════════════════════════════════════════
    public function resumoAnual_get()
    {
        if (!$this->_temPermissao()) {
            $this->response(['status'=>false,'message'=>'Sem permissão.'], 403); return;
        }

        $ano = $this->get('ano') ?: date('Y');

        $sql = "SELECT
            MONTH(data_vencimento) as mes,
            SUM(CASE WHEN LOWER(tipo)='receita' AND baixado=1 THEN valor ELSE 0 END) as receitas,
            SUM(CASE WHEN LOWER(tipo)='despesa' AND baixado=1 THEN valor ELSE 0 END) as despesas
            FROM lancamentos
            WHERE YEAR(data_vencimento) = ?
            GROUP BY MONTH(data_vencimento)
            ORDER BY mes ASC";

        $result = $this->db->query($sql, [$ano])->result();

        // Preencher os 12 meses mesmo sem dados
        $meses = [];
        for ($m = 1; $m <= 12; $m++) {
            $meses[$m] = ['mes' => $m, 'receitas' => 0, 'despesas' => 0, 'saldo' => 0];
        }
        foreach ($result as $r) {
            $meses[(int)$r->mes] = [
                'mes'      => (int)$r->mes,
                'receitas' => floatval($r->receitas),
                'despesas' => floatval($r->despesas),
                'saldo'    => floatval($r->receitas) - floatval($r->despesas),
            ];
        }

        $this->response(['status'=>true,'result'=>array_values($meses),'ano'=>$ano], 200);
    }
}
