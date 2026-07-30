<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class PermissoesController extends REST_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->logged_user(); // só precisa estar logado
    }

    // GET /api/v1/permissoes — retorna permissões do usuário logado
    public function index_get()
    {
        // Buscar permissões do usuário logado via token
        $token = $this->_getToken();
        if (!$token) {
            $this->response(['status'=>false,'message'=>'Não autorizado.'], 401);
            return;
        }

        $user = $this->db->where('access_token', $token)->get('usuarios')->row();
        if (!$user) {
            $this->response(['status'=>false,'message'=>'Usuário não encontrado.'], 401);
            return;
        }

        $permissao = $this->db->where('idPermissao', $user->permissoes_id)
                              ->get('permissoes')->row();

        $permsArray = [];
        if ($permissao && !empty($permissao->permissoes)) {
            $permsArray = unserialize($permissao->permissoes) ?: [];
        }

        // Não existe "admin" especial no sistema: cada perfil tem seu próprio
        // array de chaves (vOs, eOs, aVenda, cPermissao, etc). O app deve
        // checar cada permissão individualmente, exatamente como o backend faz.
        $this->response([
            'status' => true,
            'result' => [
                'permissoes_id' => $user->permissoes_id,
                'nome_perfil'   => $permissao->nome ?? '',
                'permissoes'    => $permsArray, // ex: {vOs:1, eOs:0, aVenda:1, cPermissao:0, ...}
            ],
        ], 200);
    }

    private function _getToken()
    {
        // Tentar pegar token do header Authorization: Bearer TOKEN
        $headers = $this->input->request_headers();
        foreach ($headers as $k => $v) {
            if (strtolower($k) === 'authorization' && strpos($v, 'Bearer ') === 0) {
                return trim(substr($v, 7));
            }
        }
        // Fallback: X-API-KEY header
        return $this->input->get_request_header('X-API-KEY') ?? '';
    }
}
