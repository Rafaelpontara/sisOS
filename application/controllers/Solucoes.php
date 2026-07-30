<?php

if (! defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Solucoes extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->helper('form');
        $this->data['menuSolucoes'] = 'Solucoes';
    }

    public function index()
    {
        $this->gerenciar();
    }

    public function gerenciar()
    {
        if (! $this->permission->checkPermission($this->session->userdata('permissao'), 'dOs')) {
            $this->session->set_flashdata('error', 'Você não tem permissão para visualizar soluções técnicas.');
            redirect(base_url());
        }

        $pesquisa = $this->input->get('pesquisa');
        $perPage  = 24;

        if ($pesquisa) {
            $this->db->where("MATCH(titulo, equipamento, problema, solucao) AGAINST (? IN NATURAL LANGUAGE MODE)", [$pesquisa], false);
        }
        $this->db->order_by('dataCriacao', 'desc');
        $this->db->limit($perPage, 0);
        $this->data['results'] = $this->db->get('solucoes_tecnicas')->result();

        $this->data['statTotal'] = $this->db->count_all('solucoes_tecnicas');
        $this->data['pesquisa']  = $pesquisa;
        $this->data['perPage']   = $perPage;

        $this->data['view'] = 'solucoes/solucoes';

        return $this->layout();
    }

    public function carregarMais()
    {
        if (! $this->permission->checkPermission($this->session->userdata('permissao'), 'dOs')) {
            return; // resposta vazia — sem permissão, não carrega mais nada
        }

        $pesquisa = $this->input->get('pesquisa');
        $antesDe  = (int) $this->input->get('antes_de');
        $perPage  = 24;

        if ($pesquisa) {
            $this->db->where("MATCH(titulo, equipamento, problema, solucao) AGAINST (? IN NATURAL LANGUAGE MODE)", [$pesquisa], false);
        }
        if ($antesDe > 0) {
            $this->db->where('id <', $antesDe);
        }
        $this->db->order_by('dataCriacao', 'desc');
        $this->db->limit($perPage, 0);
        $results = $this->db->get('solucoes_tecnicas')->result();

        echo $this->load->view('solucoes/_cards_partial', ['results' => $results, 'semResultadosOculto' => true], true);
    }

    public function adicionar()
    {
        if (! $this->permission->checkPermission($this->session->userdata('permissao'), 'dOs')) {
            $this->session->set_flashdata('error', 'Você não tem permissão para adicionar soluções técnicas.');
            redirect(base_url());
        }

        $this->load->library('form_validation');
        $this->data['custom_error'] = '';

        if ($this->input->post('titulo')) {
            $data = [
                'titulo'      => $this->input->post('titulo'),
                'equipamento' => $this->input->post('equipamento'),
                'problema'    => $this->input->post('problema'),
                'solucao'     => $this->input->post('solucao'),
                'usuarios_id' => $this->session->userdata('idUsuarios') ?: null,
                'os_id'       => $this->input->post('os_id') ?: null,
                'dataCriacao' => date('Y-m-d H:i:s'),
            ];

            $this->db->insert('solucoes_tecnicas', $data);
            $solucaoId = $this->db->insert_id();

            $this->_processarUploads($solucaoId);

            $this->session->set_flashdata('success', 'Solução salva com sucesso!');
            log_info('Adicionou uma solução técnica. ID: ' . $solucaoId);
            redirect(site_url('solucoes/visualizar/' . $solucaoId));
        }

        $this->data['view'] = 'solucoes/adicionar';

        return $this->layout();
    }

    public function editar()
    {
        if (! $this->permission->checkPermission($this->session->userdata('permissao'), 'dOs')) {
            $this->session->set_flashdata('error', 'Você não tem permissão para editar soluções técnicas.');
            redirect(base_url());
        }

        $id = $this->uri->segment(3);
        if (!$id || !is_numeric($id)) {
            show_404(); return;
        }

        if ($this->input->post('titulo')) {
            $data = [
                'titulo'          => $this->input->post('titulo'),
                'equipamento'     => $this->input->post('equipamento'),
                'problema'        => $this->input->post('problema'),
                'solucao'         => $this->input->post('solucao'),
                'dataAtualizacao' => date('Y-m-d H:i:s'),
            ];
            $this->db->where('id', $id)->update('solucoes_tecnicas', $data);

            $this->_processarUploads($id);

            // Remover mídias marcadas para exclusão
            $removerIds = $this->input->post('remover_midia');
            if ($removerIds) {
                foreach ((array) $removerIds as $midiaId) {
                    $this->_removerMidia($midiaId);
                }
            }

            $this->session->set_flashdata('success', 'Solução atualizada com sucesso!');
            redirect(site_url('solucoes/visualizar/' . $id));
        }

        $this->data['result'] = $this->db->where('id', $id)->get('solucoes_tecnicas')->row();
        if (!$this->data['result']) { show_404(); return; }

        $this->data['midias'] = $this->db->where('solucao_id', $id)->order_by('ordem', 'asc')->get('solucoes_tecnicas_midia')->result();
        $this->data['view'] = 'solucoes/editar';

        return $this->layout();
    }

    public function visualizar()
    {
        if (! $this->permission->checkPermission($this->session->userdata('permissao'), 'dOs')) {
            $this->session->set_flashdata('error', 'Você não tem permissão para visualizar soluções técnicas.');
            redirect(base_url());
        }

        $id = $this->uri->segment(3);
        if (!$id || !is_numeric($id)) {
            show_404(); return;
        }

        $this->db->set('visualizacoes', 'visualizacoes+1', false);
        $this->db->where('id', $id);
        $this->db->update('solucoes_tecnicas');

        $this->data['result'] = $this->db->where('id', $id)->get('solucoes_tecnicas')->row();
        if (!$this->data['result']) { show_404(); return; }

        $this->data['midias'] = $this->db->where('solucao_id', $id)->order_by('ordem', 'asc')->get('solucoes_tecnicas_midia')->result();
        $this->data['view'] = 'solucoes/visualizar';

        return $this->layout();
    }

    public function excluir()
    {
        if (! $this->permission->checkPermission($this->session->userdata('permissao'), 'dOs')) {
            $this->session->set_flashdata('error', 'Você não tem permissão para excluir soluções técnicas.');
            redirect(base_url());
        }

        $id = $this->input->post('id');
        if (!$id) {
            $this->session->set_flashdata('error', 'Erro ao excluir.');
            redirect(site_url('solucoes'));
        }

        // Apaga os arquivos físicos das mídias antes de deletar o registro
        $midias = $this->db->where('solucao_id', $id)->get('solucoes_tecnicas_midia')->result();
        foreach ($midias as $m) {
            $caminhoFisico = FCPATH . ltrim(str_replace(base_url(), '', $m->caminho), '/');
            if (is_file($caminhoFisico)) @unlink($caminhoFisico);
        }

        $this->db->where('id', $id)->delete('solucoes_tecnicas_midia');
        $this->db->where('id', $id)->delete('solucoes_tecnicas');

        log_info('Removeu uma solução técnica. ID: ' . $id);
        $this->session->set_flashdata('success', 'Solução removida.');
        redirect(site_url('solucoes'));
    }

    /**
     * Processa uploads de fotos (múltiplas) e vídeo (1 arquivo OU 1 link),
     * anexando à solução indicada.
     */
    private function _processarUploads($solucaoId)
    {
        $pastaFotos  = FCPATH . 'assets/img/solucoes/';
        $pastaVideos = FCPATH . 'assets/videos/solucoes/';
        if (!file_exists($pastaFotos)) mkdir($pastaFotos, DIR_WRITE_MODE, true);
        if (!file_exists($pastaVideos)) mkdir($pastaVideos, DIR_WRITE_MODE, true);

        // Fotos (múltiplas — input com name="fotos[]")
        if (!empty($_FILES['fotos']['name'][0])) {
            $totalFotos = count($_FILES['fotos']['name']);
            for ($i = 0; $i < $totalFotos; $i++) {
                if (empty($_FILES['fotos']['name'][$i])) continue;
                $_FILES['foto_temp']['name']     = $_FILES['fotos']['name'][$i];
                $_FILES['foto_temp']['type']     = $_FILES['fotos']['type'][$i];
                $_FILES['foto_temp']['tmp_name'] = $_FILES['fotos']['tmp_name'][$i];
                $_FILES['foto_temp']['error']    = $_FILES['fotos']['error'][$i];
                $_FILES['foto_temp']['size']     = $_FILES['fotos']['size'][$i];

                $this->load->library('upload', [
                    'upload_path'   => $pastaFotos,
                    'allowed_types' => 'jpg|jpeg|png|webp',
                    'max_size'      => 5120, // 5MB por foto
                    'encrypt_name'  => true,
                ]);
                if ($this->upload->do_upload('foto_temp')) {
                    $up = $this->upload->data();
                    $this->db->insert('solucoes_tecnicas_midia', [
                        'solucao_id' => $solucaoId,
                        'tipo'       => 'foto',
                        'caminho'    => base_url('assets/img/solucoes/' . $up['file_name']),
                    ]);
                }
            }
        }

        // Vídeo — upload direto (opcional, com limite de tamanho)
        if (!empty($_FILES['video']['name'])) {
            $this->load->library('upload', [
                'upload_path'   => $pastaVideos,
                'allowed_types' => 'mp4|webm|mov',
                'max_size'      => 30720, // 30MB — limite pra não sobrecarregar hospedagens compartilhadas
                'encrypt_name'  => true,
            ]);
            if ($this->upload->do_upload('video')) {
                $up = $this->upload->data();
                $this->db->insert('solucoes_tecnicas_midia', [
                    'solucao_id' => $solucaoId,
                    'tipo'       => 'video',
                    'caminho'    => base_url('assets/videos/solucoes/' . $up['file_name']),
                ]);
            }
        }

        // Vídeo — link externo (YouTube, Google Drive, etc.) como alternativa
        $videoLink = $this->input->post('video_url');
        if ($videoLink) {
            $this->db->insert('solucoes_tecnicas_midia', [
                'solucao_id' => $solucaoId,
                'tipo'       => 'video',
                'caminho'    => $videoLink,
            ]);
        }
    }

    private function _removerMidia($midiaId)
    {
        $m = $this->db->where('id', $midiaId)->get('solucoes_tecnicas_midia')->row();
        if (!$m) return;

        // Só tenta apagar arquivo físico se o caminho for do próprio servidor
        // (não mexe em links externos tipo YouTube)
        if (strpos($m->caminho, base_url()) === 0) {
            $caminhoFisico = FCPATH . ltrim(str_replace(base_url(), '', $m->caminho), '/');
            if (is_file($caminhoFisico)) @unlink($caminhoFisico);
        }

        $this->db->where('id', $midiaId)->delete('solucoes_tecnicas_midia');
    }
}
