<?php

if (! defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class PosVenda extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->data['menuPosVenda'] = 'PosVenda';
    }

    public function index()
    {
        $this->pendentes();
    }

    /**
     * Painel principal — mostra, pra cada OS Finalizada/Faturada que já
     * bateu o prazo de algum template ativo e ainda não recebeu aquela
     * mensagem, um cartão com o texto pronto e um botão de enviar no
     * WhatsApp (clique manual — este sistema não tem envio automático).
     */
    public function pendentes()
    {
        if (! $this->permission->checkPermission($this->session->userdata('permissao'), 'vOs')) {
            $this->session->set_flashdata('error', 'Você não tem permissão para acessar o Pós-Venda.');
            redirect(base_url());
        }

        $this->load->model('sisos_model');
        $emitente = $this->sisos_model->getEmitente();

        $templates = $this->db->where('ativo', 1)->order_by('ordem', 'asc')->get('pos_venda_templates')->result();

        $pendentes = [];
        foreach ($templates as $tpl) {
            $sql = "SELECT os.idOs, os.clientes_id, os.descricaoProduto, os.dataFinal,
                           c.nomeCliente, c.celular, c.telefone
                    FROM os
                    INNER JOIN clientes c ON c.idClientes = os.clientes_id
                    WHERE os.status IN ('Finalizado','Faturado')
                      AND os.dataFinal IS NOT NULL
                      AND DATE_ADD(os.dataFinal, INTERVAL ? DAY) <= CURDATE()
                      AND NOT EXISTS (
                          SELECT 1 FROM pos_venda_enviados pe
                          WHERE pe.os_id = os.idOs AND pe.template_id = ?
                      )
                    ORDER BY os.dataFinal ASC
                    LIMIT 100";
            $rows = $this->db->query($sql, [$tpl->dias_apos, $tpl->id])->result();

            foreach ($rows as $row) {
                $aparelhoLimpo = trim(strip_tags($row->descricaoProduto ?? ''));
                if ($aparelhoLimpo === '') {
                    $aparelhoLimpo = 'seu aparelho';
                }

                // Só gera/reaproveita o link de pesquisa se o modelo realmente usar {pesquisa} —
                // evita criar registro em pesquisas_satisfacao à toa em todo carregamento da tela.
                $linkPesquisa = '';
                if (strpos($tpl->mensagem, '{pesquisa}') !== false) {
                    $linkPesquisa = $this->linkPesquisaParaOs($row->idOs, $row->clientes_id);
                }

                $msg = str_replace(
                    ['{nome}', '{empresa}', '{aparelho}', '{pesquisa}'],
                    [$row->nomeCliente, $emitente->nome ?? '', $aparelhoLimpo, $linkPesquisa],
                    $tpl->mensagem
                );
                $telefone = preg_replace('/\D/', '', $row->celular ?: $row->telefone ?: '');
                $pendentes[] = [
                    'os_id'       => $row->idOs,
                    'template_id' => $tpl->id,
                    'cliente'     => $row->nomeCliente,
                    'aparelho'    => $aparelhoLimpo,
                    'dataFinal'   => $row->dataFinal,
                    'titulo'      => $tpl->titulo,
                    'mensagem'    => $msg,
                    'telefone'    => $telefone,
                ];
            }
        }

        $this->data['pendentes'] = $pendentes;
        $this->data['reviewLink'] = $this->db->where('config', 'google_review_link')->get('configuracoes')->row()->valor ?? '';
        $this->data['view'] = 'posvenda/pendentes';

        return $this->layout();
    }

    /**
     * Gera (ou reaproveita, se ainda não respondida) o link público da
     * Pesquisa de Satisfação pra uma OS — mesma tabela/token usados pelo
     * botão "Pesquisa de Satisfação" na tela de visualizar OS.
     */
    private function linkPesquisaParaOs($osId, $clientesId)
    {
        $existente = $this->db->where('os_id', $osId)->where('respondida', 0)
            ->order_by('id', 'desc')->get('pesquisas_satisfacao')->row();

        if ($existente) {
            return site_url('pesquisa/responder/' . $existente->token);
        }

        $token = bin2hex(random_bytes(16));
        $this->db->insert('pesquisas_satisfacao', [
            'os_id'        => $osId,
            'clientes_id'  => $clientesId,
            'token'        => $token,
            'data_criacao' => date('Y-m-d H:i:s'),
        ]);

        return site_url('pesquisa/responder/' . $token);
    }

    /**
     * Marca uma pendência como enviada (chamado via AJAX quando o usuário
     * clica em "Enviar no WhatsApp" — não confirma que o WhatsApp realmente
     * abriu/enviou, só registra a intenção pra não mostrar de novo amanhã).
     */
    public function marcarEnviado()
    {
        header('Content-Type: application/json');

        $osId = (int) $this->input->post('os_id');
        $templateId = (int) $this->input->post('template_id');

        if (! $osId || ! $templateId) {
            echo json_encode(['sucesso' => false]);
            return;
        }

        $this->db->insert('pos_venda_enviados', [
            'os_id' => $osId,
            'template_id' => $templateId,
            'data_envio' => date('Y-m-d H:i:s'),
        ]);

        echo json_encode(['sucesso' => true]);
    }

    /**
     * Tela de configuração: link de avaliação do Google + lista de templates.
     */
    public function configurar()
    {

        if ($this->input->post('salvar_review_link')) {
            $link = $this->input->post('google_review_link');
            $existe = $this->db->where('config', 'google_review_link')->get('configuracoes')->row();
            if ($existe) {
                $this->db->where('config', 'google_review_link')->update('configuracoes', ['valor' => $link]);
            } else {
                $this->db->insert('configuracoes', ['config' => 'google_review_link', 'valor' => $link]);
            }
            $this->session->set_flashdata('success', 'Link de avaliação salvo com sucesso!');
            redirect(site_url('posvenda/configurar'));
        }

        $this->data['templates'] = $this->db->order_by('ordem', 'asc')->get('pos_venda_templates')->result();
        $this->data['reviewLink'] = $this->db->where('config', 'google_review_link')->get('configuracoes')->row()->valor ?? '';
        $this->data['view'] = 'posvenda/configurar';

        return $this->layout();
    }

    public function salvarTemplate()
    {

        $id = $this->input->post('id');
        $data = [
            'titulo'    => $this->input->post('titulo'),
            'dias_apos' => (int) $this->input->post('dias_apos'),
            'mensagem'  => $this->input->post('mensagem'),
            'ativo'     => $this->input->post('ativo') ? 1 : 0,
        ];

        if ($id) {
            $this->db->where('id', $id)->update('pos_venda_templates', $data);
            $this->session->set_flashdata('success', 'Modelo de mensagem atualizado!');
        } else {
            $maxOrdem = $this->db->select_max('ordem')->get('pos_venda_templates')->row()->ordem ?? 0;
            $data['ordem'] = $maxOrdem + 1;
            $this->db->insert('pos_venda_templates', $data);
            $this->session->set_flashdata('success', 'Modelo de mensagem criado!');
        }

        redirect(site_url('posvenda/configurar'));
    }

    public function excluirTemplate()
    {

        $id = $this->input->post('id');
        if ($id) {
            $this->db->where('id', $id)->delete('pos_venda_templates');
            $this->session->set_flashdata('success', 'Modelo removido.');
        }
        redirect(site_url('posvenda/configurar'));
    }
}
