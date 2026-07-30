<?php

if (! defined('BASEPATH')) {
    exit('No direct script access allowed');
}

/**
 * Pesquisa de Satisfação — avaliação de Atendimento, Serviço e Ambiente da loja.
 *
 * Fluxo:
 *  1) gerarLink()   — chamado via AJAX (botão na OS ou pelo Pós-Venda) — cria
 *     (ou reaproveita, se ainda não respondida) um token pra uma OS específica.
 *  2) responder($token) — página pública, sem login, o cliente avalia.
 *  3) salvar()      — AJAX público, grava as notas + comentário.
 *  4) resultados()  — painel interno com médias e lista de respostas.
 */
class Pesquisa extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->data['menuPesquisa'] = 'pesquisa';
    }

    /**
     * Gera (ou reaproveita) o link de pesquisa pra uma OS. Chamado via AJAX
     * tanto pelo botão na tela de visualizar OS quanto pelo Pós-Venda.
     */
    public function gerarLink()
    {
        header('Content-Type: application/json');

        if (! $this->permission->checkPermission($this->session->userdata('permissao'), 'vOs')) {
            echo json_encode(['sucesso' => false, 'erro' => 'Sem permissão.']);
            return;
        }

        $osId = (int) $this->input->post('os_id');
        if (! $osId) {
            echo json_encode(['sucesso' => false, 'erro' => 'OS inválida.']);
            return;
        }

        // Já existe uma pesquisa pendente (ainda não respondida) pra essa OS?
        // Se sim, reaproveita o mesmo token em vez de criar outra.
        $existente = $this->db->where('os_id', $osId)->where('respondida', 0)
            ->order_by('id', 'desc')->get('pesquisas_satisfacao')->row();

        if ($existente) {
            echo json_encode(['sucesso' => true, 'link' => site_url('pesquisa/responder/' . $existente->token)]);
            return;
        }

        $os = $this->db->where('idOs', $osId)->get('os')->row();
        if (! $os) {
            echo json_encode(['sucesso' => false, 'erro' => 'OS não encontrada.']);
            return;
        }

        $token = bin2hex(random_bytes(16));

        $this->db->insert('pesquisas_satisfacao', [
            'os_id'        => $osId,
            'clientes_id'  => $os->clientes_id,
            'token'        => $token,
            'data_criacao' => date('Y-m-d H:i:s'),
        ]);

        echo json_encode(['sucesso' => true, 'link' => site_url('pesquisa/responder/' . $token)]);
    }

    /**
     * Página pública (sem login) onde o cliente avalia. Renderiza um HTML
     * completo próprio, sem passar pelo layout interno do sistema — mesmo
     * padrão usado no Link de Acompanhamento.
     */
    public function responder($token = null)
    {
        if (! $token) {
            show_404();
            return;
        }

        $pesquisa = $this->db->where('token', $token)->get('pesquisas_satisfacao')->row();
        if (! $pesquisa) {
            echo '<div style="font-family:Arial,sans-serif;text-align:center;padding:60px 20px;color:#6b7280;">Link inválido ou expirado.</div>';
            return;
        }

        $os = $this->db->select('idOs, descricaoProduto')->where('idOs', $pesquisa->os_id)->get('os')->row();
        $cliente = $this->db->select('nomeCliente')->where('idClientes', $pesquisa->clientes_id)->get('clientes')->row();

        $this->load->model('sisos_model');
        $emitente = $this->sisos_model->getEmitente();

        $data = [
            'pesquisa' => $pesquisa,
            'os'       => $os,
            'cliente'  => $cliente,
            'emitente' => $emitente,
            'token'    => $token,
        ];

        $this->load->view('pesquisa/responder', $data);
    }

    /**
     * AJAX público — grava a resposta da pesquisa.
     */
    public function salvar()
    {
        header('Content-Type: application/json');

        $token = $this->input->post('token');
        $pesquisa = $this->db->where('token', $token)->get('pesquisas_satisfacao')->row();

        if (! $pesquisa) {
            echo json_encode(['sucesso' => false, 'erro' => 'Link inválido.']);
            return;
        }
        if ($pesquisa->respondida) {
            echo json_encode(['sucesso' => false, 'erro' => 'Esta pesquisa já foi respondida.']);
            return;
        }

        $notaAtendimento = (int) $this->input->post('nota_atendimento');
        $notaServico     = (int) $this->input->post('nota_servico');
        $notaAmbiente    = (int) $this->input->post('nota_ambiente');
        $comentario      = trim((string) $this->input->post('comentario'));

        foreach ([$notaAtendimento, $notaServico, $notaAmbiente] as $nota) {
            if ($nota < 1 || $nota > 5) {
                echo json_encode(['sucesso' => false, 'erro' => 'Avalie os três critérios antes de enviar.']);
                return;
            }
        }

        $this->db->where('token', $token)->update('pesquisas_satisfacao', [
            'nota_atendimento' => $notaAtendimento,
            'nota_servico'     => $notaServico,
            'nota_ambiente'    => $notaAmbiente,
            'comentario'       => $comentario !== '' ? $comentario : null,
            'respondida'       => 1,
            'data_resposta'    => date('Y-m-d H:i:s'),
        ]);

        echo json_encode(['sucesso' => true]);
    }

    /**
     * Painel interno — médias por critério + lista das respostas recebidas.
     */
    public function resultados()
    {
        // Acesso restrito a quem tem permissão de excluir OS (dOs) — critério
        // mais alto que o resto da tela, a pedido, já que são dados sensíveis
        // de feedback de clientes.
        if (! $this->permission->checkPermission($this->session->userdata('permissao'), 'dOs')) {
            $this->session->set_flashdata('error', 'Você não tem permissão para ver os resultados da pesquisa.');
            redirect(base_url());
        }

        $medias = $this->db
            ->select('AVG(nota_atendimento) as media_atendimento, AVG(nota_servico) as media_servico, AVG(nota_ambiente) as media_ambiente, COUNT(*) as total')
            ->where('respondida', 1)
            ->get('pesquisas_satisfacao')->row();

        $totalEnviadas = $this->db->count_all_results('pesquisas_satisfacao');

        $this->db->select('ps.*, c.nomeCliente, o.idOs, o.descricaoProduto');
        $this->db->from('pesquisas_satisfacao ps');
        $this->db->join('clientes c', 'c.idClientes = ps.clientes_id', 'left');
        $this->db->join('os o', 'o.idOs = ps.os_id', 'left');
        $this->db->where('ps.respondida', 1);
        $this->db->order_by('ps.data_resposta', 'desc');
        $this->db->limit(100);
        $respostas = $this->db->get()->result();

        $this->data['medias']         = $medias;
        $this->data['totalEnviadas']  = $totalEnviadas;
        $this->data['respostas']      = $respostas;
        $this->data['view']           = 'pesquisa/resultados';

        return $this->layout();
    }
}
