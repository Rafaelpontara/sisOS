<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 * GarantiasController — API para o app mobile (somente leitura).
 *
 * A rota já existia em routes_api.php ('api/v1/garantias') mas o controller
 * nunca tinha sido criado. Como não temos acesso confirmado ao schema real
 * da tabela `garantias`, este controller descobre as colunas em tempo de
 * execução (SHOW COLUMNS) em vez de assumir nomes de campo — evita quebrar
 * com "Unknown column" caso a estrutura real seja diferente do esperado.
 *
 * Se no futuro a tabela/estrutura for confirmada, dá pra trocar o SELECT *
 * por campos específicos e remover essa camada defensiva.
 */
class GarantiasController extends REST_Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    // ══════════════════════════════════════════════════════════════
    // GET /api/v1/garantias  |  GET /api/v1/garantias/{id}
    // ══════════════════════════════════════════════════════════════
    public function index_get($id = '')
    {
        $this->logged_user();

        // Usa a mesma permissão de visualizar OS, já que o termo de garantia
        // só existe no contexto de uma OS. Ajuste aqui se existir uma chave
        // de permissão dedicada (ex: 'vGarantia') no seu sistema.
        if (! $this->permission->checkPermission($this->logged_user()->level, 'vOs')) {
            $this->response([
                'status' => false,
                'message' => 'Você não está autorizado a visualizar Termos de Garantia.',
            ], REST_Controller::HTTP_UNAUTHORIZED);
            return;
        }

        if (! $this->db->table_exists('garantias')) {
            $this->response([
                'status' => false,
                'message' => 'Tabela de garantias não encontrada no banco.',
            ], REST_Controller::HTTP_INTERNAL_SERVER_ERROR);
            return;
        }

        $cols = array_column($this->db->query('SHOW COLUMNS FROM `garantias`')->result_array(), 'Field');
        $pk = in_array('idGarantias', $cols, true) ? 'idGarantias' : $cols[0];

        if ($id && is_numeric($id)) {
            $row = $this->db->where($pk, $id)->get('garantias')->row();

            if (! $row) {
                $this->response([
                    'status' => false,
                    'message' => 'Termo de garantia não encontrado.',
                ], REST_Controller::HTTP_OK);
                return;
            }

            $this->response([
                'status' => true,
                'message' => 'Detalhes do Termo de Garantia',
                'result' => $row,
            ], REST_Controller::HTTP_OK);
            return;
        }

        $perPage = (int) ($this->get('perPage', true) ?: 50);
        $page = (int) ($this->get('page', true) ?: 0);
        $start = $page * $perPage;

        $result = $this->db
            ->order_by($pk, 'ASC')
            ->limit($perPage, $start)
            ->get('garantias')
            ->result();

        $this->response([
            'status' => true,
            'message' => 'Listando Termos de Garantia',
            'result' => $result,
        ], REST_Controller::HTTP_OK);
    }
}
