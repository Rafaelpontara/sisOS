<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class ArquivosController extends REST_Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * POST /api/v1/arquivos
     * Upload de arquivo (foto, vídeo) para o módulo de Arquivos do sistema
     * Campos: file (multipart), nome, os_id (opcional), clientes_id (opcional)
     */
    public function index_post()
    {
        $this->logged_user();
        $this->load->library('upload');

        $directory = FCPATH . 'assets' . DIRECTORY_SEPARATOR . 'arquivos' . DIRECTORY_SEPARATOR . date('Y-m');

        if (!is_dir($directory)) {
            try {
                mkdir($directory, 0755, true);
            } catch (Exception $e) {
                $this->response(['status'=>false,'message'=>'Erro ao criar diretório.'], 500);
                return;
            }
        }

        $upload_conf = [
            'upload_path'   => $directory,
            'allowed_types' => 'jpg|jpeg|png|gif|mp4|webm|mov|pdf|JPG|JPEG|PNG|MP4',
            'max_size'      => 51200, // 50MB
        ];

        $this->upload->initialize($upload_conf);

        if (!isset($_FILES['file']) && !isset($_FILES['userfile'])) {
            $this->response(['status'=>false,'message'=>'Nenhum arquivo enviado.'], 400);
            return;
        }

        $field = isset($_FILES['file']) ? 'file' : 'userfile';

        if (!$this->upload->do_upload($field)) {
            $this->response(['status'=>false,'message'=>$this->upload->display_errors('','')], 400);
            return;
        }

        $upload_data = $this->upload->data();
        $new_name    = uniqid() . '.' . pathinfo($upload_data['file_name'], PATHINFO_EXTENSION);
        $new_path    = $directory . DIRECTORY_SEPARATOR . $new_name;
        rename($upload_data['full_path'], $new_path);

        $nome       = $this->post('nome') ?: pathinfo($upload_data['orig_name'], PATHINFO_FILENAME);
        $osId       = $this->post('os_id');
        $clienteId  = $this->post('clientes_id');
        $usuarioId  = $this->session->userdata('id_admin');
        $tipo       = $upload_data['image_type'] ? 'imagem' : 'video';
        $url        = base_url('assets/arquivos/' . date('Y-m') . '/' . $new_name);

        // Detectar colunas disponíveis na tabela arquivos
        $data = [];
        try {
            $cols = array_column(
                $this->db->query("SHOW COLUMNS FROM `arquivos`")->result_array(),
                'Field'
            );
            $map = [
                'nome'         => $nome,
                'arquivo'      => $new_name,
                'tipo'         => $tipo,
                'url'          => $url,
                'usuarios_id'  => $usuarioId,
                'dataCadastro' => date('Y-m-d H:i:s'),
                'data'         => date('Y-m-d H:i:s'),
                'os_id'        => $osId ?: null,
                'clientes_id'  => $clienteId ?: null,
                'path'         => 'assets/arquivos/' . date('Y-m') . '/' . $new_name,
            ];
            foreach ($map as $col => $val) {
                if (in_array($col, $cols) && $val !== null) {
                    $data[$col] = $val;
                }
            }
        } catch (Exception $e) {
            $data = ['nome'=>$nome,'arquivo'=>$new_name,'usuarios_id'=>$usuarioId];
        }

        $insertId = 0;
        try {
            if (!empty($data)) {
                $this->db->insert('arquivos', $data);
                $insertId = $this->db->insert_id();
            }
        } catch (Exception $e) {
            $insertId = 0;
        }

        $this->response([
            'status'  => true,
            'message' => 'Arquivo enviado com sucesso!',
            'result'  => [
                'id'     => $insertId,
                'nome'   => $nome,
                'url'    => $url,
                'tipo'   => $tipo,
            ],
        ], 200);
    }

    /**
     * GET /api/v1/arquivos
     * Lista arquivos do sistema
     */
    public function index_get()
    {
        $this->logged_user();
        $osId      = $this->get('os_id');
        $clienteId = $this->get('clientes_id');
        $perPage   = (int)($this->get('perPage') ?: 30);

        if ($osId) {
            $this->db->where('os_id', $osId);
        } elseif ($clienteId) {
            $this->db->where('clientes_id', $clienteId);
        }

        $this->db->order_by('dataCadastro', 'DESC');
        $this->db->limit($perPage);
        $result = $this->db->get('arquivos')->result();

        $this->response(['status'=>true,'result'=>$result], 200);
    }
}
