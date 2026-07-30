<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Caixa extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('sisos_model');

        // Verifica se módulo de caixa está ativo
        if (empty($this->data['configuration']['pdv_caixa_enabled']) ||
            $this->data['configuration']['pdv_caixa_enabled'] != '1') {
            $this->session->set_flashdata('error', 'Módulo de controle de caixa não está ativado.');
            redirect(base_url());
        }

        if (!$this->permission->checkPermission($this->session->userdata('permissao'), 'aVenda')) {
            $this->session->set_flashdata('error', 'Sem permissão para acessar o caixa.');
            redirect(base_url());
        }
    }

    // ─── Tela principal do caixa ──────────────────────────────────────────────
    public function index()
    {
        $sessao = $this->_getSessaoAberta();
        if ($sessao) {
            $this->data['sessao']     = $sessao;
            $this->data['movimentos'] = $this->_getMovimentos($sessao->id);
            $this->data['totais']     = $this->_getTotaisSessao($sessao->id);
            $this->data['view']       = 'caixa/caixa_aberto';
        } else {
            $this->data['view'] = 'caixa/caixa_abertura';
        }
        return $this->layout();
    }

    // ─── Abrir caixa ─────────────────────────────────────────────────────────
    public function abrir()
    {
        if ($this->_getSessaoAberta()) {
            $this->session->set_flashdata('error', 'Já existe um caixa aberto.');
            redirect(site_url('caixa'));
        }

        $saldo_inicial = (float)str_replace(',', '.', $this->input->post('saldo_inicial') ?: 0);
        $obs           = $this->input->post('observacoes') ?: '';
        $usuario_id    = $this->session->userdata('id_admin');

        // Criar sessão
        $this->db->insert('caixa_sessoes', [
            'usuarios_id'   => $usuario_id,
            'saldo_inicial' => $saldo_inicial,
            'observacoes'   => $obs,
            'status'        => 'aberto',
            'data_abertura' => date('Y-m-d H:i:s'),
        ]);
        $sessao_id = $this->db->insert_id();

        // Registrar movimento de abertura
        $this->db->insert('caixa_movimentos', [
            'sessao_id'   => $sessao_id,
            'usuarios_id' => $usuario_id,
            'tipo'        => 'abertura',
            'valor'       => $saldo_inicial,
            'descricao'   => 'Abertura de caixa' . ($obs ? " — $obs" : ''),
            'created_at'  => date('Y-m-d H:i:s'),
        ]);

        log_info("Caixa aberto. Saldo inicial: R$ " . number_format($saldo_inicial, 2, ',', '.'));
        $this->session->set_flashdata('success', 'Caixa aberto com sucesso!');
        redirect(site_url('caixa'));
    }

    // ─── Sangria ─────────────────────────────────────────────────────────────
    public function sangria()
    {
        $sessao = $this->_getSessaoAberta();
        if (!$sessao) {
            echo json_encode(['status' => false, 'message' => 'Nenhum caixa aberto.']); return;
        }

        $valor     = (float)str_replace(',', '.', $this->input->post('valor') ?: 0);
        $descricao = $this->input->post('descricao') ?: 'Sangria de caixa';

        if ($valor <= 0) {
            echo json_encode(['status' => false, 'message' => 'Valor inválido.']); return;
        }

        $this->db->insert('caixa_movimentos', [
            'sessao_id'   => $sessao->id,
            'usuarios_id' => $this->session->userdata('id_admin'),
            'tipo'        => 'sangria',
            'valor'       => $valor,
            'descricao'   => $descricao,
            'created_at'  => date('Y-m-d H:i:s'),
        ]);

        log_info("Sangria de caixa: R$ " . number_format($valor, 2, ',', '.') . " — $descricao");
        echo json_encode(['status' => true, 'message' => 'Sangria registrada!']);
    }

    // ─── Entrada manual ──────────────────────────────────────────────────────
    public function entrada()
    {
        $sessao = $this->_getSessaoAberta();
        if (!$sessao) {
            echo json_encode(['status' => false, 'message' => 'Nenhum caixa aberto.']); return;
        }

        $valor      = (float)str_replace(',', '.', $this->input->post('valor') ?: 0);
        $descricao  = $this->input->post('descricao') ?: 'Entrada manual';
        $forma_pgto = $this->input->post('forma_pgto') ?: 'Dinheiro';

        if ($valor <= 0) {
            echo json_encode(['status' => false, 'message' => 'Valor inválido.']); return;
        }

        $this->db->insert('caixa_movimentos', [
            'sessao_id'   => $sessao->id,
            'usuarios_id' => $this->session->userdata('id_admin'),
            'tipo'        => 'entrada',
            'valor'       => $valor,
            'descricao'   => $descricao,
            'forma_pgto'  => $forma_pgto,
            'created_at'  => date('Y-m-d H:i:s'),
        ]);

        echo json_encode(['status' => true, 'message' => 'Entrada registrada!']);
    }

    // ─── Fechar caixa ────────────────────────────────────────────────────────
    public function fechar()
    {
        $sessao = $this->_getSessaoAberta();
        if (!$sessao) {
            $this->session->set_flashdata('error', 'Nenhum caixa aberto.');
            redirect(site_url('caixa'));
        }

        $saldo_final = (float)str_replace(',', '.', $this->input->post('saldo_final') ?: 0);
        $obs         = $this->input->post('observacoes') ?: '';
        $totais      = $this->_getTotaisSessao($sessao->id);

        // Registrar movimento de fechamento
        $this->db->insert('caixa_movimentos', [
            'sessao_id'   => $sessao->id,
            'usuarios_id' => $this->session->userdata('id_admin'),
            'tipo'        => 'fechamento',
            'valor'       => $saldo_final,
            'descricao'   => 'Fechamento de caixa' . ($obs ? " — $obs" : ''),
            'created_at'  => date('Y-m-d H:i:s'),
        ]);

        // Atualizar sessão
        $this->db->where('id', $sessao->id)->update('caixa_sessoes', [
            'data_fechamento' => date('Y-m-d H:i:s'),
            'saldo_final'     => $saldo_final,
            'total_vendas'    => $totais['total_vendas'],
            'total_sangrias'  => $totais['total_sangrias'],
            'total_entradas'  => $totais['total_entradas'],
            'status'          => 'fechado',
        ]);

        log_info("Caixa fechado. Saldo final: R$ " . number_format($saldo_final, 2, ',', '.'));
        $this->session->set_flashdata('success', 'Caixa fechado com sucesso!');
        redirect(site_url('caixa/historico'));
    }

    // ─── Histórico de sessões ─────────────────────────────────────────────────
    public function historico()
    {
        $sessoes = $this->db
            ->select('cs.*, u.nome as operador')
            ->from('caixa_sessoes cs')
            ->join('usuarios u', 'u.idUsuarios = cs.usuarios_id', 'left')
            ->order_by('cs.id', 'DESC')
            ->limit(50)
            ->get()->result();

        $this->data['sessoes'] = $sessoes;
        $this->data['view']    = 'caixa/caixa_historico';
        return $this->layout();
    }

    // ─── Detalhe de sessão ────────────────────────────────────────────────────
    public function detalhe($id = null)
    {
        if (!$id) { redirect(site_url('caixa/historico')); }

        $sessao = $this->db
            ->select('cs.*, u.nome as operador')
            ->from('caixa_sessoes cs')
            ->join('usuarios u', 'u.idUsuarios = cs.usuarios_id', 'left')
            ->where('cs.id', $id)
            ->get()->row();

        if (!$sessao) { show_404(); }

        $this->data['sessao']     = $sessao;
        $this->data['movimentos'] = $this->_getMovimentos($id);
        $this->data['totais']     = $this->_getTotaisSessao($id);
        $this->data['view']       = 'caixa/caixa_detalhe';
        return $this->layout();
    }

    // ─── Registrar venda no caixa (chamado pelo Pdv.php) ─────────────────────
    public function registrarVenda($sessao_id, $valor, $forma_pgto, $venda_id)
    {
        $this->db->insert('caixa_movimentos', [
            'sessao_id'      => $sessao_id,
            'usuarios_id'    => $this->session->userdata('id_admin'),
            'tipo'           => 'venda',
            'valor'          => $valor,
            'descricao'      => 'Venda #' . str_pad($venda_id, 4, '0', STR_PAD_LEFT),
            'forma_pgto'     => $forma_pgto,
            'referencia_id'  => $venda_id,
            'created_at'     => date('Y-m-d H:i:s'),
        ]);
    }

    // ─── Helpers privados ─────────────────────────────────────────────────────
    private function _getSessaoAberta()
    {
        return $this->db
            ->where('status', 'aberto')
            ->where('usuarios_id', $this->session->userdata('id_admin'))
            ->order_by('id', 'DESC')
            ->limit(1)
            ->get('caixa_sessoes')->row();
    }

    private function _getMovimentos($sessao_id)
    {
        return $this->db
            ->select('cm.*, u.nome as operador')
            ->from('caixa_movimentos cm')
            ->join('usuarios u', 'u.idUsuarios = cm.usuarios_id', 'left')
            ->where('cm.sessao_id', $sessao_id)
            ->order_by('cm.created_at', 'ASC')
            ->get()->result();
    }

    private function _getTotaisSessao($sessao_id)
    {
        $r = $this->db->query("
            SELECT
                SUM(CASE WHEN tipo='venda'    THEN valor ELSE 0 END) as total_vendas,
                SUM(CASE WHEN tipo='sangria'  THEN valor ELSE 0 END) as total_sangrias,
                SUM(CASE WHEN tipo='entrada'  THEN valor ELSE 0 END) as total_entradas,
                SUM(CASE WHEN tipo='abertura' THEN valor ELSE 0 END) as saldo_inicial,
                COUNT(CASE WHEN tipo='venda'  THEN 1 END)            as qtd_vendas
            FROM caixa_movimentos WHERE sessao_id = ?
        ", [$sessao_id])->row_array();

        $saldo_esperado = ($r['saldo_inicial'] ?? 0)
                        + ($r['total_vendas']   ?? 0)
                        + ($r['total_entradas'] ?? 0)
                        - ($r['total_sangrias'] ?? 0);

        return array_merge($r, ['saldo_esperado' => $saldo_esperado]);
    }
}
