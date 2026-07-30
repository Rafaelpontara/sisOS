<?php

if (! defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Os extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->helper(['form', 'url']);
        $this->load->model('os_model');
        $this->data['menuOs'] = 'OS';
    }

    public function index()
    {
        $this->gerenciar();
    }

    public function gerenciar()
    {
        $this->load->library('pagination');
        $this->load->model('sisos_model');

        // Preferência de visualização (lista/grade) — se vier na URL, salva
        // na sessão pra lembrar da próxima vez que a pessoa entrar na tela.
        $visualizacaoParam = $this->input->get('visualizacao');
        if (in_array($visualizacaoParam, ['lista', 'grade'], true)) {
            $this->session->set_userdata('os_visualizacao', $visualizacaoParam);
        }
        $this->data['visualizacaoAtual'] = $this->session->userdata('os_visualizacao') ?: 'grade';

        // Per page dinâmico
        $perPageCount = (int)($this->input->get('per_page_count') ?: 10);
        $perPageCount = in_array($perPageCount, [10,25,50,100]) ? $perPageCount : 10;
        $this->data['configuration']['per_page'] = $perPageCount;

        $where_array = [];

        $pesquisa  = $this->input->get('pesquisa');
        $status    = $this->input->get('status');
        $inputDe   = $this->input->get('data');
        $inputAte  = $this->input->get('data2');
        $numero_os = $this->input->get('numero_os');

        if ($pesquisa) {
            $where_array['pesquisa'] = $pesquisa;
        }
        if ($numero_os && is_numeric($numero_os)) {
            $where_array['numero_os'] = (int)$numero_os;
        }
        if ($status) {
            $where_array['status'] = $status;
        }
        if ($inputDe) {
            $de = explode('/', $inputDe);
            $de = $de[2] . '-' . $de[1] . '-' . $de[0];

            $where_array['de'] = $de;
        }
        if ($inputAte) {
            $ate = explode('/', $inputAte);
            $ate = $ate[2] . '-' . $ate[1] . '-' . $ate[0];

            $where_array['ate'] = $ate;
        }

        // Agenda de entregas filter
        $entregaHoje = $this->input->get('entrega_hoje');
        if ($entregaHoje) {
            $where_array['entrega_hoje'] = date('Y-m-d');
        }

        // Filtro "Entregue ao Cliente" (Sim/Não) — separado do status.
        // OBS: precisa que os_model.php saiba tratar essa chave no where_array
        // (mesmo padrão de 'status'/'pesquisa'/etc já usado nesse método).
        $entregue = $this->input->get('entregue');
        if ($entregue === '0' || $entregue === '1') {
            $where_array['entregue'] = (int) $entregue;
        }

        // Filtro "OS Vencidas" — usado pelo link da notificação do sininho.
        if ($this->input->get('vencidas')) {
            $where_array['vencidas'] = true;
        }

        // Suffix com todos os filtros incluindo numero_os e per_page
        $suffix = "?pesquisa={$pesquisa}&status={$status}&data={$inputDe}&data2={$inputAte}&numero_os={$numero_os}&per_page_count={$perPageCount}&entregue={$entregue}";

        $this->data['configuration']['base_url']        = site_url('os/gerenciar/') . $suffix . '&page=';
        $this->data['configuration']['page_query_string'] = false;
        $this->data['configuration']['use_page_numbers'] = false;
        $this->data['configuration']['total_rows']      = $this->os_model->countOs($where_array);
        $this->data['configuration']['suffix']          = $suffix;
        $this->data['configuration']['first_url']       = site_url('os/gerenciar/') . $suffix;

        $this->pagination->initialize($this->data['configuration']);

        // Offset: usa segmento da URL
        $offset = (int)($this->uri->segment(3) ?: 0);

        $this->data['results'] = $this->os_model->getOs(
            'os',
            'os.*,
            COALESCE((SELECT SUM(p2.preco * p2.quantidade) FROM produtos_os p2 WHERE p2.os_id = os.idOs), 0) totalProdutos,
            COALESCE((SELECT SUM(s2.preco * s2.quantidade) FROM servicos_os s2 WHERE s2.os_id = os.idOs), 0) totalServicos',
            $where_array,
            $this->data['configuration']['per_page'],
            $offset
        );

        $this->data['texto_de_notificacao'] = $this->data['configuration']['notifica_whats'];
        $this->data['emitente'] = $this->sisos_model->getEmitente();
        $this->data['view'] = 'os/os';

        return $this->layout();
    }

    /**
     * Mesa de Trabalho — visão em quadro (Kanban) das OS abertas, agrupadas
     * por status em colunas. Usa os mesmos dados/permissões da listagem
     * normal, só apresenta de forma diferente.
     */
    public function mesa()
    {
        if (! $this->permission->checkPermission($this->session->userdata('permissao'), 'vOs')) {
            $this->session->set_flashdata('error', 'Você não tem permissão para visualizar OS.');
            redirect(base_url());
        }

        // Colunas do quadro — cada uma agrupa um ou mais status já existentes.
        // Mover um card pra uma coluna grava o "status representativo" dela.
        $colunas = [
            'novo'      => ['titulo' => 'Novo / Orçamento',   'statusRepresentativo' => 'Aberto',        'statusIncluidos' => ['Aberto','Orçamento','Negociação']],
            'peca'      => ['titulo' => 'Aguardando Peça',    'statusRepresentativo' => 'Aguardando Peças','statusIncluidos' => ['Aguardando Peças']],
            'servico'   => ['titulo' => 'Em Serviço',         'statusRepresentativo' => 'Em Andamento',  'statusIncluidos' => ['Em Andamento','Aprovado','Em Teste','Aguardando Autorização']],
            'pronto'    => ['titulo' => 'Pronto',             'statusRepresentativo' => 'Finalizado',    'statusIncluidos' => ['Finalizado']],
            'entregue'  => ['titulo' => 'Entregue / Faturado','statusRepresentativo' => 'Faturado',      'statusIncluidos' => ['Faturado']],
        ];

        $todosStatusIncluidos = [];
        foreach ($colunas as $c) $todosStatusIncluidos = array_merge($todosStatusIncluidos, $c['statusIncluidos']);

        $resultados = $this->db
            ->select('os.*,
                COALESCE((SELECT SUM(p2.preco * p2.quantidade) FROM produtos_os p2 WHERE p2.os_id = os.idOs), 0) totalProdutos,
                COALESCE((SELECT SUM(s2.preco * s2.quantidade) FROM servicos_os s2 WHERE s2.os_id = os.idOs), 0) totalServicos,
                clientes.nomeCliente')
            ->join('clientes', 'clientes.idClientes = os.clientes_id', 'left')
            ->where_in('os.status', $todosStatusIncluidos)
            ->where('os.arquivada', 0)
            ->order_by('os.idOs', 'desc')
            ->get('os')->result();

        // Distribui cada OS na coluna certa, com as de prioridade "alta"
        // aparecendo primeiro dentro de cada coluna
        $ordemPrioridade = ['alta' => 0, 'normal' => 1, 'baixa' => 2];
        foreach ($colunas as $chave => &$coluna) {
            $itens = array_values(array_filter($resultados, function ($r) use ($coluna) {
                return in_array($r->status, $coluna['statusIncluidos']);
            }));
            usort($itens, function ($a, $b) use ($ordemPrioridade) {
                $pa = $ordemPrioridade[$a->prioridade ?? 'normal'] ?? 1;
                $pb = $ordemPrioridade[$b->prioridade ?? 'normal'] ?? 1;
                return $pa <=> $pb;
            });
            $coluna['itens'] = $itens;
        }
        unset($coluna);

        // Chaves das colunas na ordem, pra "Avançar Status" saber qual é a próxima
        $this->data['ordemColunas'] = array_keys($colunas);
        $this->data['colunas'] = $colunas;
        $this->data['menuMesa'] = 'Mesa';
        $this->data['view'] = 'os/mesa';

        return $this->layout();
    }

    /**
     * AJAX — muda o status da OS quando o card é arrastado pra outra coluna.
     */
    public function mesaAtualizarStatus()
    {
        header('Content-Type: application/json');

        if (! $this->permission->checkPermission($this->session->userdata('permissao'), 'eOs')) {
            echo json_encode(['sucesso' => false, 'erro' => 'Sem permissão para editar OS.']);
            return;
        }

        $id = (int) $this->input->post('id');
        $novoStatus = $this->input->post('status');
        $statusValidos = ['Aberto','Orçamento','Negociação','Aguardando Peças','Em Andamento','Aprovado','Em Teste','Aguardando Autorização','Finalizado','Faturado'];

        if (! $id || ! in_array($novoStatus, $statusValidos, true)) {
            echo json_encode(['sucesso' => false, 'erro' => 'Dados inválidos.']);
            return;
        }

        $ok = $this->os_model->edit('os', ['status' => $novoStatus], 'idOs', $id);
        log_info('Mudou status da OS pela Mesa de Trabalho. ID: ' . $id . ' -> ' . $novoStatus);

        $resposta = ['sucesso' => (bool) $ok];
        $aviso = $this->_montarAvisoCliente($id, $novoStatus);
        if ($aviso) $resposta['aviso'] = $aviso;

        echo json_encode($resposta);
    }

    /**
     * Muda a prioridade de uma OS (Baixa/Normal/Alta) direto pelo card da
     * Mesa de Trabalho.
     */
    public function mesaAtualizarPrioridade()
    {
        header('Content-Type: application/json');

        if (! $this->permission->checkPermission($this->session->userdata('permissao'), 'eOs')) {
            echo json_encode(['sucesso' => false, 'erro' => 'Sem permissão.']);
            return;
        }

        $id = (int) $this->input->post('id');
        $prioridade = $this->input->post('prioridade');

        if (! $id || ! in_array($prioridade, ['baixa', 'normal', 'alta'], true)) {
            echo json_encode(['sucesso' => false, 'erro' => 'Dados inválidos.']);
            return;
        }

        $ok = $this->os_model->edit('os', ['prioridade' => $prioridade], 'idOs', $id);
        echo json_encode(['sucesso' => (bool) $ok]);
    }

    /**
     * Arquiva uma OS — some da Mesa de Trabalho sem excluir de verdade
     * (continua acessível pela listagem normal e pelos relatórios).
     */
    public function mesaArquivar()
    {
        header('Content-Type: application/json');

        if (! $this->permission->checkPermission($this->session->userdata('permissao'), 'eOs')) {
            echo json_encode(['sucesso' => false, 'erro' => 'Sem permissão.']);
            return;
        }

        $id = (int) $this->input->post('id');
        if (! $id) {
            echo json_encode(['sucesso' => false, 'erro' => 'ID inválido.']);
            return;
        }

        $ok = $this->os_model->edit('os', ['arquivada' => 1], 'idOs', $id);
        log_info('Arquivou OS pela Mesa de Trabalho. ID: ' . $id);
        echo json_encode(['sucesso' => (bool) $ok]);
    }

    /**
     * "Avançar Status" — move a OS pra próxima coluna da sequência (Novo →
     * Aguardando Peça → Em Serviço → Pronto → Entregue), sem precisar
     * arrastar o card manualmente.
     */
    public function mesaAvancarStatus()
    {
        header('Content-Type: application/json');

        if (! $this->permission->checkPermission($this->session->userdata('permissao'), 'eOs')) {
            echo json_encode(['sucesso' => false, 'erro' => 'Sem permissão.']);
            return;
        }

        $id = (int) $this->input->post('id');
        if (! $id) {
            echo json_encode(['sucesso' => false, 'erro' => 'ID inválido.']);
            return;
        }

        // Mesma sequência/status-representativo usado em mesa()
        $sequencia = [
            'Aberto'            => 'Aguardando Peças',
            'Orçamento'         => 'Aguardando Peças',
            'Negociação'        => 'Aguardando Peças',
            'Aguardando Peças'  => 'Em Andamento',
            'Em Andamento'      => 'Finalizado',
            'Aprovado'          => 'Finalizado',
            'Em Teste'          => 'Finalizado',
            'Aguardando Autorização' => 'Finalizado',
            'Finalizado'        => 'Faturado',
        ];

        $os = $this->os_model->getById($id);
        if (! $os) {
            echo json_encode(['sucesso' => false, 'erro' => 'OS não encontrada.']);
            return;
        }

        $novoStatus = $sequencia[$os->status] ?? null;
        if (! $novoStatus) {
            echo json_encode(['sucesso' => false, 'erro' => 'Esta OS já está na última etapa.']);
            return;
        }

        $this->os_model->edit('os', ['status' => $novoStatus], 'idOs', $id);
        log_info('Avançou status da OS pela Mesa de Trabalho. ID: ' . $id . ' -> ' . $novoStatus);

        $resposta = ['sucesso' => true, 'novoStatus' => $novoStatus];
        $aviso = $this->_montarAvisoCliente($id, $novoStatus);
        if ($aviso) $resposta['aviso'] = $aviso;

        echo json_encode($resposta);
    }

    /**
     * Garante que a OS tenha um token de acompanhamento público — gera na
     * primeira vez que a OS é aberta (visualizar/editar), se ainda não tiver.
     * Recebe o $result por referência pra já refletir na tela atual sem
     * precisar recarregar a página.
     */
    private function _garantirTrackingToken(&$osResult)
    {
        if (empty($osResult) || !empty($osResult->tracking_token)) {
            return;
        }

        $token = bin2hex(random_bytes(16)); // 32 caracteres, não-adivinhável
        $this->os_model->edit('os', ['tracking_token' => $token], 'idOs', $osResult->idOs);
        $osResult->tracking_token = $token;
    }

    /**
     * Monta os dados do aviso automático sugerido ao cliente quando a OS
     * muda pra um status "marco" (por enquanto, só Finalizado — aparelho
     * pronto). Retorna null se esse status não gera aviso.
     */
    private function _montarAvisoCliente($idOs, $novoStatus)
    {
        $statusComAviso = ['Finalizado' => '✅ *Seu {equipamento}* está pronto! 🎉'];
        if (! isset($statusComAviso[$novoStatus])) {
            return null;
        }

        $os = $this->db
            ->select('os.*, clientes.nomeCliente, clientes.celular, clientes.telefone')
            ->join('clientes', 'clientes.idClientes = os.clientes_id', 'left')
            ->where('os.idOs', $idOs)
            ->get('os')->row();

        if (! $os) return null;

        $this->_garantirTrackingToken($os);
        $link = site_url('mine/acompanhar/' . $os->tracking_token);

        $total = (float) $this->db
            ->select('COALESCE(SUM(p2.preco*p2.quantidade),0) + COALESCE(SUM(s2.preco*s2.quantidade),0) as total')
            ->from('os')
            ->join('produtos_os p2', 'p2.os_id = os.idOs', 'left')
            ->join('servicos_os s2', 's2.os_id = os.idOs', 'left')
            ->where('os.idOs', $idOs)
            ->get()->row()->total ?? 0;

        $mensagem = 'Olá *' . ($os->nomeCliente ?? '') . '*! ' . str_replace('{equipamento}', $os->descricaoProduto ?? 'aparelho', $statusComAviso[$novoStatus]) . "\n"
                  . '💰 Valor: *R$ ' . number_format($total, 2, ',', '.') . "*\n"
                  . '🔗 Detalhes: ' . $link . "\n"
                  . 'Você já pode retirar na nossa loja. Te esperamos!';

        $telefone = preg_replace('/\D/', '', $os->celular ?: $os->telefone ?: '');

        return [
            'cliente'   => $os->nomeCliente,
            'osNum'     => str_pad($os->idOs, 4, '0', STR_PAD_LEFT),
            'equipamento' => $os->descricaoProduto,
            'mensagem'  => $mensagem,
            'telefone'  => $telefone,
        ];
    }

    /**
     * Endpoint AJAX chamado pela rolagem infinita da listagem de OS (a
     * tela normal — não confundir com a Mesa de Trabalho).
     * Usa paginação por cursor (idOs < último visto) em vez de OFFSET —
     * mais rápida conforme a base cresce, porque usa o índice da chave
     * primária ao invés de "pular e descartar" registros.
     */
    public function carregarMais()
    {
        if (! $this->permission->checkPermission($this->session->userdata('permissao'), 'vOs')) {
            return;
        }

        $where_array = [];

        $pesquisa  = $this->input->get('pesquisa');
        $status    = $this->input->get('status');
        $inputDe   = $this->input->get('data');
        $inputAte  = $this->input->get('data2');
        $numero_os = $this->input->get('numero_os');

        if ($pesquisa) $where_array['pesquisa'] = $pesquisa;
        if ($numero_os && is_numeric($numero_os)) $where_array['numero_os'] = (int) $numero_os;
        if ($status) $where_array['status'] = $status;
        if ($inputDe) {
            $de = explode('/', $inputDe);
            if (count($de) === 3) $where_array['de'] = $de[2] . '-' . $de[1] . '-' . $de[0];
        }
        if ($inputAte) {
            $ate = explode('/', $inputAte);
            if (count($ate) === 3) $where_array['ate'] = $ate[2] . '-' . $ate[1] . '-' . $ate[0];
        }
        if ($this->input->get('entrega_hoje')) $where_array['entrega_hoje'] = date('Y-m-d');
        $entregue = $this->input->get('entregue');
        if ($entregue === '0' || $entregue === '1') $where_array['entregue'] = (int) $entregue;
        if ($this->input->get('vencidas')) $where_array['vencidas'] = true;

        // Cursor: idOs do último card já carregado na tela (não é mais um
        // "offset"/contagem — é o próprio ID, usado direto no WHERE).
        $antesDe = (int) $this->input->get('antes_de');
        if ($antesDe > 0) $where_array['antes_de'] = $antesDe;

        $perPage = 24;

        $results = $this->os_model->getOs(
            'os',
            'os.*,
            COALESCE((SELECT SUM(p2.preco * p2.quantidade) FROM produtos_os p2 WHERE p2.os_id = os.idOs), 0) totalProdutos,
            COALESCE((SELECT SUM(s2.preco * s2.quantidade) FROM servicos_os s2 WHERE s2.os_id = os.idOs), 0) totalServicos',
            $where_array,
            $perPage,
            0
        );

        $modo = $this->input->get('modo') === 'lista' ? 'lista' : 'grade';
        if ($modo === 'lista') {
            echo $this->load->view('os/_table_rows_partial', ['results' => $results, 'semResultadosOculto' => true], true);
        } else {
            echo $this->load->view('os/_cards_partial', ['results' => $results, 'semResultadosOculto' => true], true);
        }
    }

    public function adicionar()
    {

        if (! $this->permission->checkPermission($this->session->userdata('permissao'), 'aOs')) {
            $this->session->set_flashdata('error', 'Você não tem permissão para adicionar O.S.');
            redirect(base_url());
        }

        // Verificar se o cliente está bloqueado
        $clienteId = $this->input->post('clientes_id');
        if ($clienteId) {
            $cliente = $this->db->where('idClientes', $clienteId)->get('clientes')->row();
            if ($cliente && !empty($cliente->bloqueado)) {
                $this->session->set_flashdata('error', 'Cliente BLOQUEADO. Motivo: ' . ($cliente->motivo_bloqueio ?: 'não informado') . '. Regularize a situação antes de abrir uma OS.');
                redirect(site_url('os/gerenciar'));
            }
        }

        $this->load->library('form_validation');
        $this->data['custom_error'] = '';

        if ($this->form_validation->run('os') == false) {
            $this->data['custom_error'] = (validation_errors() ? true : false);
        } else {
            $dataInicial = $this->input->post('dataInicial');
            $dataFinal = $this->input->post('dataFinal');
            $termoGarantiaId = $this->input->post('termoGarantia');

            try {
                $dataInicial = explode('/', $dataInicial);
                $dataInicial = $dataInicial[2] . '-' . $dataInicial[1] . '-' . $dataInicial[0];

                if ($dataFinal) {
                    $dataFinal = explode('/', $dataFinal);
                    $dataFinal = $dataFinal[2] . '-' . $dataFinal[1] . '-' . $dataFinal[0];
                } else {
                    $dataFinal = date('Y/m/d');
                }

                $termoGarantiaId = (! $termoGarantiaId == null || ! $termoGarantiaId == '')
                    ? $this->input->post('garantias_id')
                    : null;
            } catch (Exception $e) {
                $dataInicial = date('Y/m/d');
                $dataFinal = date('Y/m/d');
            }

            // Checklist
            // Suporta novo formato (checklist_json) e legado (checklist_itens[])
            $checklistObs  = $this->input->post('checklist_obs') ?: '';
            $ckJsonRaw     = $this->input->post('checklist_json');
            if ($ckJsonRaw) {
                // Novo formato: JSON com estados ok/defeito/nvf por item
                $ckData = json_decode($ckJsonRaw, true) ?: [];
                $checklistJson = json_encode([
                    'itens' => $ckData['itens'] ?? [],
                    'obs'   => $ckData['obs']   ?? $checklistObs,
                    'v'     => 2, // versão do formato
                ]);
            } else {
                // Formato legado: array de itens marcados
                $checklistItens = $this->input->post('checklist_itens') ?: [];
                $checklistJson  = json_encode(['itens' => $checklistItens, 'obs' => $checklistObs, 'v' => 1]);
            }

            // Upload fotos checklist
            $fotoUrls = [];
            if (!empty($_FILES['checklist_fotos']['name'][0])) {
                $pasta = FCPATH . 'assets/img/checklist/';
                if (!file_exists($pasta)) mkdir($pasta, DIR_WRITE_MODE, true);
                $this->load->library('upload');
                foreach ($_FILES['checklist_fotos']['name'] as $i => $fname) {
                    if (!$fname) continue;
                    $_FILES['foto_tmp'] = array_map(fn($a) => $a[$i], $_FILES['checklist_fotos']);
                    $this->upload->initialize(['upload_path'=>$pasta,'allowed_types'=>'jpg|jpeg|png|webp','max_size'=>2048,'encrypt_name'=>true]);
                    if ($this->upload->do_upload('foto_tmp')) {
                        $fotoUrls[] = base_url('assets/img/checklist/' . $this->upload->data('file_name'));
                    }
                    if (count($fotoUrls) >= 4) break;
                }
            }

            // Recorrência
            $isRecorrente = $this->input->post('is_recorrente') ? 1 : 0;
            $recTipo      = $this->input->post('recorrencia_tipo');
            $recProxRaw   = $this->input->post('recorrencia_proxima');
            $recProx      = null;
            if ($recProxRaw) {
                $rp = explode('/', $recProxRaw);
                $recProx = count($rp)===3 ? "$rp[2]-$rp[1]-$rp[0]" : $recProxRaw;
            }

            $data = [
                'dataInicial'         => $dataInicial,
                'clientes_id'         => $this->input->post('clientes_id'),
                'usuarios_id'         => $this->input->post('usuarios_id'),
                'atendente_id'        => $this->input->post('atendente_id') ?: $this->session->userdata('id_admin'),
                'dataFinal'           => $dataFinal,
                'garantia'            => $this->input->post('garantia'),
                'garantias_id'        => $termoGarantiaId,
                'descricaoProduto'    => $this->input->post('descricaoProduto'),
                'equipamento'         => $this->input->post('equipamento'),
                'numeroSerie'         => $this->input->post('numeroSerie'),
                'defeito'             => $this->input->post('defeito'),
                'status'              => $this->input->post('status'),
                'situacao_financeira' => 'pendente',
                'observacoes'         => $this->input->post('observacoes'),
                'laudoTecnico'        => $this->input->post('laudoTecnico'),
                'checklist'           => $checklistJson,
                'checklist_fotos'     => json_encode($fotoUrls),
                'senha_tipo'          => $this->input->post('senha_tipo')  ?: null,
                'senha_valor'         => $this->input->post('senha_valor') ?: null,
                'checklist_saida'     => $this->_processarChecklistSaida(),
                'is_recorrente'       => $isRecorrente,
                'recorrencia_tipo'    => $isRecorrente ? $recTipo : null,
                'recorrencia_proxima' => $isRecorrente ? $recProx : null,
                'faturado'            => 0,
                'dataEntrega'         => ($this->input->post('dataEntrega') ? implode('-', array_reverse(explode('/', $this->input->post('dataEntrega')))) : null),
                'os_origem_id'        => ($this->input->post('os_origem_id') ?: ($this->input->get('os_origem') ?: null)),
            ];

            if (is_numeric($id = $this->os_model->add('os', $data, true))) {
                $this->load->model('sisos_model');
                $this->load->model('usuarios_model');

                $idOs = $id;
                $os = $this->os_model->getById($idOs);
                $emitente = $this->sisos_model->getEmitente();

                $tecnico = $this->usuarios_model->getById($os->usuarios_id);

                // Verificar configuração de notificação
                if ($this->data['configuration']['os_notification'] != 'nenhum' && $this->data['configuration']['email_automatico'] == 1) {
                    $remetentes = [];
                    switch ($this->data['configuration']['os_notification']) {
                        case 'todos':
                            array_push($remetentes, $os->email);
                            array_push($remetentes, $tecnico->email);
                            array_push($remetentes, $emitente->email);
                            break;
                        case 'cliente':
                            array_push($remetentes, $os->email);
                            break;
                        case 'tecnico':
                            array_push($remetentes, $tecnico->email);
                            break;
                        case 'emitente':
                            array_push($remetentes, $emitente->email);
                            break;
                        default:
                            array_push($remetentes, $os->email);
                            break;
                    }
                    $this->enviarOsPorEmail($idOs, $remetentes, 'Ordem de Serviço - Criada');
                }

                $this->session->set_flashdata('success', 'OS adicionada com sucesso, você pode adicionar produtos ou serviços a essa OS nas abas de Produtos e Serviços!');
                log_info('Adicionou uma OS. ID: ' . $id);
                redirect(site_url('os/criadaComSucesso/') . $id);
            } else {
                $this->data['custom_error'] = '<div class="alert">Ocorreu um erro.</div>';
            }
        }

        $this->data['view'] = 'os/adicionarOs';

        return $this->layout();
    }

    public function editar()
    {
        if (! $this->uri->segment(3) || ! is_numeric($this->uri->segment(3)) || ! $this->os_model->getById($this->uri->segment(3))) {
            $this->session->set_flashdata('error', 'OS não encontrada ou parâmetro inválido.');
            redirect('os/gerenciar');
        }

        if (! $this->permission->checkPermission($this->session->userdata('permissao'), 'eOs')) {
            $this->session->set_flashdata('error', 'Você não tem permissão para editar O.S.');
            redirect(base_url());
        }

        $this->load->library('form_validation');
        $this->load->model('usuarios_model');
        $this->data['custom_error'] = '';
        $this->data['texto_de_notificacao'] = $this->data['configuration']['notifica_whats'];

        $this->data['editavel'] = $this->os_model->isEditable($this->input->post('idOs'));
        if (! $this->data['editavel']) {
            $this->session->set_flashdata('error', 'Esta OS já e seu status não pode ser alterado e nem suas informações atualizadas. Por favor abrir uma nova OS.');

            redirect(site_url('os'));
        }

        if ($this->form_validation->run('os') == false) {
            $this->data['custom_error'] = (validation_errors() ? '<div class="form_error">' . validation_errors() . '</div>' : false);
        } else {
            $dataInicial = $this->input->post('dataInicial');
            $dataFinal = $this->input->post('dataFinal');
            $termoGarantiaId = $this->input->post('garantias_id') ?: null;

            try {
                $dataInicial = explode('/', $dataInicial);
                $dataInicial = $dataInicial[2] . '-' . $dataInicial[1] . '-' . $dataInicial[0];

                $dataFinal = explode('/', $dataFinal);
                $dataFinal = $dataFinal[2] . '-' . $dataFinal[1] . '-' . $dataFinal[0];
            } catch (Exception $e) {
                $dataInicial = date('Y/m/d');
            }

            // Data retirada
            $dataRetirada = null;
            $dataRetiradaRaw = $this->input->post('data_retirada');
            if ($dataRetiradaRaw) {
                $dr = explode('/', $dataRetiradaRaw);
                if (count($dr) === 3) $dataRetirada = $dr[2].'-'.$dr[1].'-'.$dr[0];
            }

            // Checklist de entrada — isso faltava aqui em editar() (só existia
            // em adicionar()), por isso o checklist preenchido ao editar uma
            // OS existente nunca era salvo.
            $osAtual = $this->os_model->getById($this->input->post('idOs'));
            $checklistObs = $this->input->post('checklist_obs') ?: '';
            $ckJsonRaw    = $this->input->post('checklist_json');
            if ($ckJsonRaw) {
                $ckData = json_decode($ckJsonRaw, true) ?: [];
                $checklistJson = json_encode([
                    'itens' => $ckData['itens'] ?? [],
                    'obs'   => $ckData['obs']   ?? $checklistObs,
                    'v'     => 2,
                ]);
            } elseif ($this->input->post('checklist_itens') !== null) {
                $checklistItens = $this->input->post('checklist_itens') ?: [];
                $checklistJson  = json_encode(['itens' => $checklistItens, 'obs' => $checklistObs, 'v' => 1]);
            } else {
                // Nenhum campo de checklist veio no POST — mantém o que já
                // estava salvo, em vez de apagar sem querer.
                $checklistJson = $osAtual->checklist ?? null;
            }

            // Fotos do checklist — soma com as que já existiam em vez de substituir
            $fotoUrls = json_decode($osAtual->checklist_fotos ?? '[]', true) ?: [];
            if (!empty($_FILES['checklist_fotos']['name'][0])) {
                $pasta = FCPATH . 'assets/img/checklist/';
                if (!file_exists($pasta)) mkdir($pasta, DIR_WRITE_MODE, true);
                $this->load->library('upload');
                foreach ($_FILES['checklist_fotos']['name'] as $i => $fname) {
                    if (!$fname) continue;
                    $_FILES['foto_tmp'] = array_map(fn($a) => $a[$i], $_FILES['checklist_fotos']);
                    $this->upload->initialize(['upload_path'=>$pasta,'allowed_types'=>'jpg|jpeg|png|webp','max_size'=>2048,'encrypt_name'=>true]);
                    if ($this->upload->do_upload('foto_tmp')) {
                        $fotoUrls[] = base_url('assets/img/checklist/' . $this->upload->data('file_name'));
                    }
                    if (count($fotoUrls) >= 4) break;
                }
            }

            $data = [
                'dataInicial'        => $dataInicial,
                'dataFinal'          => $dataFinal,
                'data_retirada'      => $dataRetirada,
                'situacao_financeira'=> $this->input->post('situacao_financeira') ?: 'pendente',
                'entregue'           => $this->input->post('entregue') ? 1 : 0,
                'garantia'           => $this->input->post('garantia'),
                'garantias_id'       => $termoGarantiaId,
                'descricaoProduto'   => $this->input->post('descricaoProduto'),
                'equipamento'        => $this->input->post('equipamento'),
                'numeroSerie'        => $this->input->post('numeroSerie'),
                'defeito'            => $this->input->post('defeito'),
                'status'             => $this->input->post('status'),
                'observacoes'        => $this->input->post('observacoes'),
                'laudoTecnico'       => $this->input->post('laudoTecnico'),
                'usuarios_id'        => $this->input->post('usuarios_id'),
                'atendente_id'       => $this->input->post('atendente_id') ?: $this->session->userdata('id_admin'),
                'clientes_id'        => $this->input->post('clientes_id'),
                'dataEntrega'        => ($this->input->post('dataEntrega') ? implode('-', array_reverse(explode('/', $this->input->post('dataEntrega')))) : null),
                'senha_tipo'         => $this->input->post('senha_tipo')  ?: null,
                'senha_valor'        => $this->input->post('senha_valor') ?: null,
                'checklist'          => $checklistJson,
                'checklist_fotos'    => json_encode($fotoUrls),
                'checklist_saida'    => $this->_processarChecklistSaida(),
            ];
            $os = $this->os_model->getById($this->input->post('idOs'));

            //Verifica para poder fazer a devolução do produto para o estoque caso OS seja cancelada.

            if (strtolower($this->input->post('status')) == 'cancelado' && strtolower($os->status) != 'cancelado') {
                $this->devolucaoEstoque($this->input->post('idOs'));
            }

            if (strtolower($os->status) == 'cancelado' && strtolower($this->input->post('status')) != 'cancelado') {
                $this->debitarEstoque($this->input->post('idOs'));
            }

            if ($this->os_model->edit('os', $data, 'idOs', $this->input->post('idOs')) == true) {
                $this->load->model('sisos_model');
                $this->load->model('usuarios_model');

                $idOs = $this->input->post('idOs');

                $os = $this->os_model->getById($idOs);
                $emitente = $this->sisos_model->getEmitente();
                $tecnico = $this->usuarios_model->getById($os->usuarios_id);

                // Verificar configuração de notificação
                if ($this->data['configuration']['os_notification'] != 'nenhum' && $this->data['configuration']['email_automatico'] == 1) {
                    $remetentes = [];
                    switch ($this->data['configuration']['os_notification']) {
                        case 'todos':
                            array_push($remetentes, $os->email);
                            array_push($remetentes, $tecnico->email);
                            array_push($remetentes, $emitente->email);
                            break;
                        case 'cliente':
                            array_push($remetentes, $os->email);
                            break;
                        case 'tecnico':
                            array_push($remetentes, $tecnico->email);
                            break;
                        case 'emitente':
                            array_push($remetentes, $emitente->email);
                            break;
                        default:
                            array_push($remetentes, $os->email);
                            break;
                    }
                    $this->enviarOsPorEmail($idOs, $remetentes, 'Ordem de Serviço - Editada');
                }

                // Log status change in anotacoes_os
                $os_reloaded = $this->os_model->getById($this->input->post('idOs'));
                if (isset($os) && $os_reloaded && $os->status != $os_reloaded->status) {
                    $this->db->insert('anotacoes_os', [
                        'anotacao'  => '🔄 Status: "' . $os->status . '" → "' . $os_reloaded->status . '" por ' . $this->session->userdata('nome_admin'),
                        'data_hora' => date('Y-m-d H:i:s'),
                        'os_id'     => $this->input->post('idOs'),
                    ]);
                }

                $this->session->set_flashdata('success', 'Os editada com sucesso!');
                log_info('Alterou uma OS. ID: ' . $this->input->post('idOs'));
                redirect(site_url('os/editar/') . $this->input->post('idOs'));
            } else {
                $this->data['custom_error'] = '<div class="form_error"><p>Ocorreu um erro</p></div>';
            }
        }

        $this->data['result'] = $this->os_model->getById($this->uri->segment(3));
        $this->_garantirTrackingToken($this->data['result']);

        $this->data['produtos'] = $this->os_model->getProdutos($this->uri->segment(3));
        $this->data['servicos'] = $this->os_model->getServicos($this->uri->segment(3));
        $this->data['anexos'] = $this->os_model->getAnexos($this->uri->segment(3));
        $this->data['anotacoes'] = $this->os_model->getAnotacoes($this->uri->segment(3));

        if ($return = $this->os_model->valorTotalOS($this->uri->segment(3))) {
            $this->data['totalServico'] = $return['totalServico'];
            $this->data['totalProdutos'] = $return['totalProdutos'];
        }

        $this->load->model('sisos_model');
        $this->data['emitente'] = $this->sisos_model->getEmitente();

        $this->data['view'] = 'os/editarOs';

        return $this->layout();
    }

    public function visualizar()
    {
        if (! $this->uri->segment(3) || ! is_numeric($this->uri->segment(3))) {
            $this->session->set_flashdata('error', 'Item não pode ser encontrado, parâmetro não foi passado corretamente.');
            redirect('sisos');
        }

        if (! $this->permission->checkPermission($this->session->userdata('permissao'), 'vOs')) {
            $this->session->set_flashdata('error', 'Você não tem permissão para visualizar O.S.');
            redirect(base_url());
        }

        $this->data['custom_error'] = '';
        $this->data['texto_de_notificacao'] = $this->data['configuration']['notifica_whats'];

        $this->load->model('sisos_model');
        $this->load->model('usuarios_model');
        $this->data['result'] = $this->os_model->getById($this->uri->segment(3));
        $this->_garantirTrackingToken($this->data['result']);
        $this->data['produtos'] = $this->os_model->getProdutos($this->uri->segment(3));
        $this->data['servicos'] = $this->os_model->getServicos($this->uri->segment(3));
        $this->data['emitente'] = $this->sisos_model->getEmitente();
        $this->data['anexos'] = $this->os_model->getAnexos($this->uri->segment(3));
        $this->data['anotacoes'] = $this->os_model->getAnotacoes($this->uri->segment(3));
        $this->data['editavel'] = $this->os_model->isEditable($this->uri->segment(3));
        $this->data['qrCode'] = $this->os_model->getQrCode(
            $this->uri->segment(3),
            $this->data['configuration']['pix_key'],
            $this->data['emitente']
        );
        $this->data['modalGerarPagamento'] = $this->load->view(
            'cobrancas/modalGerarPagamento',
            [
                'id' => $this->uri->segment(3),
                'tipo' => 'os',
            ],
            true
        );
        $this->data['view'] = 'os/visualizarOs';
        $this->data['chaveFormatada'] = $this->formatarChave($this->data['configuration']['pix_key']);

        if ($return = $this->os_model->valorTotalOS($this->uri->segment(3))) {
            $this->data['totalServico'] = $return['totalServico'];
            $this->data['totalProdutos'] = $return['totalProdutos'];
        }

        return $this->layout();
    }

    public function validarCPF($cpf)
    {
        $cpf = preg_replace('/[^0-9]/', '', $cpf);
        if (strlen($cpf) !== 11 || preg_match('/^(\d)\1+$/', $cpf)) {
            return false;
        }
        $soma1 = 0;
        for ($i = 0; $i < 9; $i++) {
            $soma1 += $cpf[$i] * (10 - $i);
        }
        $resto1 = $soma1 % 11;
        $dv1 = ($resto1 < 2) ? 0 : 11 - $resto1;
        if ($dv1 != $cpf[9]) {
            return false;
        }
        $soma2 = 0;
        for ($i = 0; $i < 10; $i++) {
            $soma2 += $cpf[$i] * (11 - $i);
        }
        $resto2 = $soma2 % 11;
        $dv2 = ($resto2 < 2) ? 0 : 11 - $resto2;

        return $dv2 == $cpf[10];
    }

    public function validarCNPJ($cnpj)
    {
        $cnpj = preg_replace('/[^0-9]/', '', $cnpj);
        if (strlen($cnpj) !== 14 || preg_match('/^(\d)\1+$/', $cnpj)) {
            return false;
        }
        $soma1 = 0;
        for ($i = 0, $pos = 5; $i < 12; $i++, $pos--) {
            $pos = ($pos < 2) ? 9 : $pos;
            $soma1 += $cnpj[$i] * $pos;
        }
        $dv1 = ($soma1 % 11 < 2) ? 0 : 11 - ($soma1 % 11);
        if ($dv1 != $cnpj[12]) {
            return false;
        }
        $soma2 = 0;
        for ($i = 0, $pos = 6; $i < 13; $i++, $pos--) {
            $pos = ($pos < 2) ? 9 : $pos;
            $soma2 += $cnpj[$i] * $pos;
        }
        $dv2 = ($soma2 % 11 < 2) ? 0 : 11 - ($soma2 % 11);

        return $dv2 == $cnpj[13];
    }

    public function formatarChave($chave)
    {
        if ($this->validarCPF($chave)) {
            return substr($chave, 0, 3) . '.' . substr($chave, 3, 3) . '.' . substr($chave, 6, 3) . '-' . substr($chave, 9);
        } elseif ($this->validarCNPJ($chave)) {
            return substr($chave, 0, 2) . '.' . substr($chave, 2, 3) . '.' . substr($chave, 5, 3) . '/' . substr($chave, 8, 4) . '-' . substr($chave, 12);
        } elseif (strlen($chave) === 11) {
            return '(' . substr($chave, 0, 2) . ') ' . substr($chave, 2, 5) . '-' . substr($chave, 7);
        }

        return $chave;
    }

    public function imprimir()
    {
        if (! $this->uri->segment(3) || ! is_numeric($this->uri->segment(3))) {
            $this->session->set_flashdata('error', 'Item não pode ser encontrado, parâmetro não foi passado corretamente.');
            redirect('sisos');
        }

        if (! $this->permission->checkPermission($this->session->userdata('permissao'), 'vOs')) {
            $this->session->set_flashdata('error', 'Você não tem permissão para visualizar O.S.');
            redirect(base_url());
        }

        $this->data['custom_error'] = '';
        $this->load->model('sisos_model');
        $this->data['result'] = $this->os_model->getById($this->uri->segment(3));
        $this->data['produtos'] = $this->os_model->getProdutos($this->uri->segment(3));
        $this->data['servicos'] = $this->os_model->getServicos($this->uri->segment(3));
        $this->data['anexos'] = $this->os_model->getAnexos($this->uri->segment(3));
        $this->data['emitente'] = $this->sisos_model->getEmitente();
        if ($this->data['configuration']['pix_key']) {
            $this->data['qrCode'] = $this->os_model->getQrCode(
                $this->uri->segment(3),
                $this->data['configuration']['pix_key'],
                $this->data['emitente']
            );
            $this->data['chaveFormatada'] = $this->formatarChave($this->data['configuration']['pix_key']);
        }
        
        $this->data['imprimirAnexo'] = isset($_ENV['IMPRIMIR_ANEXOS']) ? (filter_var($_ENV['IMPRIMIR_ANEXOS'] ?? false, FILTER_VALIDATE_BOOLEAN)) : false;

        $this->load->view('os/imprimirOs', $this->data);
    }

    public function imprimirTermica()
    {
        if (! $this->uri->segment(3) || ! is_numeric($this->uri->segment(3))) {
            $this->session->set_flashdata('error', 'Item não pode ser encontrado, parâmetro não foi passado corretamente.');
            redirect('sisos');
        }

        if (! $this->permission->checkPermission($this->session->userdata('permissao'), 'vOs')) {
            $this->session->set_flashdata('error', 'Você não tem permissão para visualizar O.S.');
            redirect(base_url());
        }

        $this->data['custom_error'] = '';
        $this->load->model('sisos_model');
        $this->data['result'] = $this->os_model->getById($this->uri->segment(3));
        $this->data['produtos'] = $this->os_model->getProdutos($this->uri->segment(3));
        $this->data['servicos'] = $this->os_model->getServicos($this->uri->segment(3));
        $this->data['emitente'] = $this->sisos_model->getEmitente();
        $this->data['qrCode'] = $this->os_model->getQrCode(
            $this->uri->segment(3),
            $this->data['configuration']['pix_key'],
            $this->data['emitente']
        );
        $this->data['chaveFormatada'] = $this->formatarChave($this->data['configuration']['pix_key']);

        $this->load->view('os/imprimirOsTermica', $this->data);
    }

    public function enviar_email()
    {
        if (! $this->uri->segment(3) || ! is_numeric($this->uri->segment(3))) {
            $this->session->set_flashdata('error', 'Item não pode ser encontrado, parâmetro não foi passado corretamente.');
            redirect('sisos');
        }

        if (! $this->permission->checkPermission($this->session->userdata('permissao'), 'vOs')) {
            $this->session->set_flashdata('error', 'Você não tem permissão para enviar O.S. por e-mail.');
            redirect(base_url());
        }

        $this->load->model('sisos_model');
        $this->load->model('usuarios_model');
        $this->data['result'] = $this->os_model->getById($this->uri->segment(3));
        if (! isset($this->data['result']->email)) {
            $this->session->set_flashdata('error', 'O cliente não tem e-mail cadastrado.');
            redirect(site_url('os'));
        }

        $this->data['produtos'] = $this->os_model->getProdutos($this->uri->segment(3));
        $this->data['servicos'] = $this->os_model->getServicos($this->uri->segment(3));
        $this->data['emitente'] = $this->sisos_model->getEmitente();

        if (! isset($this->data['emitente']->email)) {
            $this->session->set_flashdata('error', 'Efetue o cadastro dos dados de emitente');
            redirect(site_url('os'));
        }

        $idOs = $this->uri->segment(3);

        $emitente = $this->data['emitente'];
        $tecnico = $this->usuarios_model->getById($this->data['result']->usuarios_id);

        // Verificar configuração de notificação
        $ValidarEmail = false;
        if ($this->data['configuration']['os_notification'] != 'nenhum') {
            $remetentes = [];
            switch ($this->data['configuration']['os_notification']) {
                case 'todos':
                    array_push($remetentes, $this->data['result']->email);
                    array_push($remetentes, $tecnico->email);
                    array_push($remetentes, $emitente->email);
                    $ValidarEmail = true;
                    break;
                case 'cliente':
                    array_push($remetentes, $this->data['result']->email);
                    $ValidarEmail = true;
                    break;
                case 'tecnico':
                    array_push($remetentes, $tecnico->email);
                    break;
                case 'emitente':
                    array_push($remetentes, $emitente->email);
                    break;
                default:
                    array_push($remetentes, $this->data['result']->email);
                    $ValidarEmail = true;
                    break;
            }

            if ($ValidarEmail) {
                if (empty($this->data['result']->email) || ! filter_var($this->data['result']->email, FILTER_VALIDATE_EMAIL)) {
                    $this->session->set_flashdata('error', 'Por favor preencha o email do cliente');
                    redirect(site_url('os/visualizar/') . $this->uri->segment(3));
                }
            }

            $enviouEmail = $this->enviarOsPorEmail($idOs, $remetentes, 'Ordem de Serviço');

            if ($enviouEmail) {
                $this->session->set_flashdata('success', 'O email está sendo processado e será enviado em breve.');
                log_info('Enviou e-mail para o cliente: ' . $this->data['result']->nomeCliente . '. E-mail: ' . $this->data['result']->email);
                redirect(site_url('os'));
            } else {
                $this->session->set_flashdata('error', 'Ocorreu um erro ao enviar e-mail.');
                redirect(site_url('os'));
            }
        }

        $this->session->set_flashdata('success', 'O sistema está com uma configuração ativada para não notificar. Entre em contato com o administrador.');
        redirect(site_url('os'));
    }

    private function devolucaoEstoque($id)
    {
        if ($produtos = $this->os_model->getProdutos($id)) {
            $this->load->model('produtos_model');
            if ($this->data['configuration']['control_estoque']) {
                foreach ($produtos as $p) {
                    $this->produtos_model->updateEstoque($p->produtos_id, $p->quantidade, '+');
                    log_info('ESTOQUE: Produto id ' . $p->produtos_id . ' voltou ao estoque. Quantidade: ' . $p->quantidade . '. Motivo: Cancelamento/Exclusão');
                }
            }
        }
    }

    private function debitarEstoque($id)
    {
        if ($produtos = $this->os_model->getProdutos($id)) {
            $this->load->model('produtos_model');
            if ($this->data['configuration']['control_estoque']) {
                foreach ($produtos as $p) {
                    $this->produtos_model->updateEstoque($p->produtos_id, $p->quantidade, '-');
                    log_info('ESTOQUE: Produto id ' . $p->produtos_id . ' baixa do estoque. Quantidade: ' . $p->quantidade . '. Motivo: Mudou status que já estava Cancelado para outro');
                }
            }
        }
    }

    public function excluir()
    {
        if (! $this->permission->checkPermission($this->session->userdata('permissao'), 'dOs')) {
            $this->session->set_flashdata('error', 'Você não tem permissão para excluir O.S.');
            redirect(base_url());
        }

        $id = $this->input->post('id');
        $os = $this->os_model->getByIdCobrancas($id);
        if ($os == null) {
            $os = $this->os_model->getById($id);
            if ($os == null) {
                $this->session->set_flashdata('error', 'Erro ao tentar excluir OS.');
                redirect(base_url() . 'index.php/os/gerenciar/');
            }
        }

        if (isset($os->idCobranca) != null) {
            if ($os->status == 'canceled') {
                $this->os_model->delete('cobrancas', 'os_id', $id);
            } else {
                $this->session->set_flashdata('error', 'Existe uma cobrança associada a esta OS, deve cancelar e/ou excluir a cobrança primeiro!');
                redirect(site_url('os/gerenciar/'));
            }
        }

        $osStockRefund = $this->os_model->getById($id);
        //Verifica para poder fazer a devolução do produto para o estoque caso OS seja excluida.
        if (strtolower($osStockRefund->status) != 'cancelado') {
            $this->devolucaoEstoque($id);
        }

        $this->os_model->delete('servicos_os', 'os_id', $id);
        $this->os_model->delete('produtos_os', 'os_id', $id);
        $this->os_model->delete('anexos', 'os_id', $id);
        $this->os_model->delete('os', 'idOs', $id);
        if ((int) $os->faturado === 1) {
            $this->os_model->delete('lancamentos', 'descricao', "Fatura de OS - #${id}");
        }

        log_info('Removeu uma OS. ID: ' . $id);
        $this->session->set_flashdata('success', 'OS excluída com sucesso!');
        redirect(site_url('os/gerenciar/'));
    }

    public function aprovar($id = null)
    {
        // Public endpoint for client to approve OS via link
        if (!$id || !is_numeric($id)) {
            show_404();
        }
        $this->load->model('os_model');
        $os = $this->os_model->getById($id);
        if (!$os) show_404();

        $acao = $this->input->get('acao');
        if ($acao === 'sim') {
            $this->os_model->edit('os', ['status' => 'Aprovado'], 'idOs', $id);
            $this->db->insert('anotacoes_os', [
                'anotacao'  => '✅ OS aprovada pelo cliente via link.',
                'data_hora' => date('Y-m-d H:i:s'),
                'os_id'     => $id,
            ]);
            echo '<div style="font-family:sans-serif;text-align:center;padding:40px;"><h2 style="color:#22c55e;">✅ OS #' . $id . ' Aprovada!</h2><p>Obrigado. Nossa equipe já foi notificada.</p></div>';
        } elseif ($acao === 'nao') {
            $this->os_model->edit('os', ['status' => 'Recusado'], 'idOs', $id);
            $this->db->insert('anotacoes_os', [
                'anotacao'  => '❌ OS recusada pelo cliente via link.',
                'data_hora' => date('Y-m-d H:i:s'),
                'os_id'     => $id,
            ]);
            echo '<div style="font-family:sans-serif;text-align:center;padding:40px;"><h2 style="color:#ef4444;">❌ OS #' . $id . ' Recusada.</h2><p>Obrigado pelo retorno. Nossa equipe já foi notificada.</p></div>';
        } else {
            // Show approval page
            echo '<div style="font-family:sans-serif;text-align:center;padding:40px;max-width:400px;margin:0 auto;">';
            echo '<h2>OS #' . $id . ' - Aprovação de Orçamento</h2>';
            echo '<p>Cliente: <strong>' . htmlspecialchars($os->nomeCliente) . '</strong></p>';
            echo '<p style="margin:20px 0;">Deseja aprovar o serviço?</p>';
            echo '<a href="' . site_url('os/aprovar/' . $id . '?acao=sim') . '" style="background:#22c55e;color:#fff;padding:12px 28px;border-radius:8px;text-decoration:none;margin-right:10px;font-weight:700;">✅ Aprovar</a>';
            echo '<a href="' . site_url('os/aprovar/' . $id . '?acao=nao') . '" style="background:#ef4444;color:#fff;padding:12px 28px;border-radius:8px;text-decoration:none;font-weight:700;">❌ Recusar</a>';
            echo '</div>';
        }
        exit();
    }

    public function autoCompleteProduto()
    {
        if (isset($_GET['term'])) {
            $q = strtolower($_GET['term']);
            $this->os_model->autoCompleteProduto($q);
        }
    }

    public function autoCompleteProdutoSaida()
    {
        if (isset($_GET['term'])) {
            $q = strtolower($_GET['term']);
            $this->os_model->autoCompleteProdutoSaida($q);
        }
    }

    public function autoCompleteCliente()
    {
        if (isset($_GET['term'])) {
            $q = strtolower($_GET['term']);
            $this->os_model->autoCompleteCliente($q);
        }
    }

    public function autoCompleteUsuario()
    {
        if (isset($_GET['term'])) {
            $q = strtolower($_GET['term']);
            $this->os_model->autoCompleteUsuario($q);
        }
    }

    public function autoCompleteTermoGarantia()
    {
        if (isset($_GET['term'])) {
            $q = strtolower($_GET['term']);
            $this->os_model->autoCompleteTermoGarantia($q);
        }
    }

    public function autoCompleteServico()
    {
        if (isset($_GET['term'])) {
            $q = strtolower($_GET['term']);
            $this->os_model->autoCompleteServico($q);
        }
    }

    public function adicionarProduto()
    {
        $this->load->library('form_validation');

        if ($this->form_validation->run('adicionar_produto_os') === false) {
            $errors = validation_errors();

            return $this->output
                ->set_content_type('application/json')
                ->set_status_header(400)
                ->set_output(json_encode($errors));
        }

        $preco = $this->input->post('preco');
        $quantidade = $this->input->post('quantidade');
        $subtotal = $preco * $quantidade;
        $produto = $this->input->post('idProduto');
        $data = [
            'quantidade' => $quantidade,
            'subTotal' => $subtotal,
            'produtos_id' => $produto,
            'preco' => $preco,
            'os_id' => $this->input->post('idOsProduto'),
        ];

        $id = $this->input->post('idOsProduto');
        $os = $this->os_model->getById($id);
        if ($os == null) {
            $this->session->set_flashdata('error', 'Erro ao tentar inserir produto na OS.');
            redirect(base_url() . 'index.php/os/gerenciar/');
        }

        if ($this->os_model->add('produtos_os', $data) == true) {
            $this->load->model('produtos_model');

            if ($this->data['configuration']['control_estoque']) {
                $this->produtos_model->updateEstoque($produto, $quantidade, '-');
            }

            $this->db->set('desconto', 0.00);
            $this->db->set('valor_desconto', 0.00);
            $this->db->set('tipo_desconto', null);
            $this->db->where('idOs', $id);
            $this->db->update('os');

            log_info('Adicionou produto a uma OS. ID (OS): ' . $this->input->post('idOsProduto'));

            return $this->output
                ->set_content_type('application/json')
                ->set_status_header(200)
                ->set_output(json_encode(['result' => true]));
        } else {
            return $this->output
                ->set_content_type('application/json')
                ->set_status_header(500)
                ->set_output(json_encode(['result' => false]));
        }
    }

    public function excluirProduto()
    {
        $id = $this->input->post('idProduto');
        $idOs = $this->input->post('idOs');

        $os = $this->os_model->getById($idOs);
        if ($os == null) {
            $this->session->set_flashdata('error', 'Erro ao tentar excluir produto na OS.');
            redirect(base_url() . 'index.php/os/gerenciar/');
        }

        if ($this->os_model->delete('produtos_os', 'idProdutos_os', $id) == true) {
            $quantidade = $this->input->post('quantidade');
            $produto = $this->input->post('produto');

            $this->load->model('produtos_model');

            if ($this->data['configuration']['control_estoque']) {
                $this->produtos_model->updateEstoque($produto, $quantidade, '+');
            }

            $this->db->set('desconto', 0.00);
            $this->db->set('valor_desconto', 0.00);
            $this->db->set('tipo_desconto', null);
            $this->db->where('idOs', $idOs);
            $this->db->update('os');

            log_info('Removeu produto de uma OS. ID (OS): ' . $idOs);

            echo json_encode(['result' => true]);
        } else {
            echo json_encode(['result' => false]);
        }
    }

    public function adicionarServico()
    {
        $this->load->library('form_validation');

        if ($this->form_validation->run('adicionar_servico_os') === false) {
            $errors = validation_errors();

            return $this->output
                ->set_content_type('application/json')
                ->set_status_header(400)
                ->set_output(json_encode($errors));
        }

        $data = [
            'servicos_id' => $this->input->post('idServico'),
            'quantidade' => $this->input->post('quantidade'),
            'preco' => $this->input->post('preco'),
            'os_id' => $this->input->post('idOsServico'),
            'subTotal' => $this->input->post('preco') * $this->input->post('quantidade'),
        ];

        if ($this->os_model->add('servicos_os', $data) == true) {
            log_info('Adicionou serviço a uma OS. ID (OS): ' . $this->input->post('idOsServico'));

            $this->db->set('desconto', 0.00);
            $this->db->set('valor_desconto', 0.00);
            $this->db->set('tipo_desconto', null);
            $this->db->where('idOs', $this->input->post('idOsServico'));
            $this->db->update('os');

            return $this->output
                ->set_content_type('application/json')
                ->set_status_header(200)
                ->set_output(json_encode(['result' => true]));
        } else {
            return $this->output
                ->set_content_type('application/json')
                ->set_status_header(500)
                ->set_output(json_encode(['result' => false]));
        }
    }

    public function excluirServico()
    {
        $ID = $this->input->post('idServico');
        $idOs = $this->input->post('idOs');

        if ($this->os_model->delete('servicos_os', 'idServicos_os', $ID) == true) {
            log_info('Removeu serviço de uma OS. ID (OS): ' . $idOs);
            $this->db->set('desconto', 0.00);
            $this->db->set('valor_desconto', 0.00);
            $this->db->set('tipo_desconto', null);
            $this->db->where('idOs', $idOs);
            $this->db->update('os');
            echo json_encode(['result' => true]);
        } else {
            echo json_encode(['result' => false]);
        }
    }

    public function anexar()
    {
        $this->load->library('upload');
        $this->load->library('image_lib');

        $directory = FCPATH . 'assets' . DIRECTORY_SEPARATOR . 'anexos' . DIRECTORY_SEPARATOR . date('m-Y') . DIRECTORY_SEPARATOR . 'OS-' . $this->input->post('idOsServico');

        // If it exist, check if it's a directory
        if (! is_dir($directory . DIRECTORY_SEPARATOR . 'thumbs')) {
            // make directory for images and thumbs
            try {
                mkdir($directory . DIRECTORY_SEPARATOR . 'thumbs', 0755, true);
            } catch (Exception $e) {
                echo json_encode(['result' => false, 'mensagem' => $e->getMessage()]);
                exit();
            }
        }

        $upload_conf = [
            'upload_path' => $directory,
            'allowed_types' => 'jpg|png|gif|jpeg|JPG|PNG|GIF|JPEG|pdf|PDF|cdr|CDR|docx|DOCX|txt', // formatos permitidos para anexos de os
            'max_size' => 0,
        ];

        $this->upload->initialize($upload_conf);

        foreach ($_FILES['userfile'] as $key => $val) {
            $i = 1;
            foreach ($val as $v) {
                $field_name = 'file_' . $i;
                $_FILES[$field_name][$key] = $v;
                $i++;
            }
        }
        unset($_FILES['userfile']);

        $error = [];
        $success = [];

        foreach ($_FILES as $field_name => $file) {
            if (! $this->upload->do_upload($field_name)) {
                $error['upload'][] = $this->upload->display_errors();
            } else {
                $upload_data = $this->upload->data();

                // Gera um nome de arquivo aleatório mantendo a extensão original
                $new_file_name = uniqid() . '.' . pathinfo($upload_data['file_name'], PATHINFO_EXTENSION);
                $new_file_path = $upload_data['file_path'] . $new_file_name;

                rename($upload_data['full_path'], $new_file_path);

                if ($upload_data['is_image'] == 1) {
                    $resize_conf = [
                        'source_image' => $new_file_path,
                        'new_image' => $upload_data['file_path'] . 'thumbs' . DIRECTORY_SEPARATOR . 'thumb_' . $new_file_name,
                        'width' => 200,
                        'height' => 125,
                    ];

                    $this->image_lib->initialize($resize_conf);

                    if (! $this->image_lib->resize()) {
                        $error['resize'][] = $this->image_lib->display_errors();
                    } else {
                        $success[] = $upload_data;
                        $this->load->model('Os_model');
                        $result = $this->Os_model->anexar($this->input->post('idOsServico'), $new_file_name, base_url('assets' . DIRECTORY_SEPARATOR . 'anexos' . DIRECTORY_SEPARATOR . date('m-Y') . DIRECTORY_SEPARATOR . 'OS-' . $this->input->post('idOsServico')), 'thumb_' . $new_file_name, $directory);
                        if (! $result) {
                            $error['db'][] = 'Erro ao inserir no banco de dados.';
                        }
                    }
                } else {
                    $success[] = $upload_data;

                    $this->load->model('Os_model');

                    $result = $this->Os_model->anexar($this->input->post('idOsServico'), $new_file_name, base_url('assets' . DIRECTORY_SEPARATOR . 'anexos' . DIRECTORY_SEPARATOR . date('m-Y') . DIRECTORY_SEPARATOR . 'OS-' . $this->input->post('idOsServico')), '', $directory);
                    if (! $result) {
                        $error['db'][] = 'Erro ao inserir no banco de dados.';
                    }
                }
            }
        }

        if (count($error) > 0) {
            echo json_encode(['result' => false, 'mensagem' => 'Ocorreu um erro ao processar os arquivos.', 'errors' => $error]);
        } else {
            log_info('Adicionou anexo(s) a uma OS. ID (OS): ' . $this->input->post('idOsServico'));
            echo json_encode(['result' => true, 'mensagem' => 'Arquivo(s) anexado(s) com sucesso.']);
        }
    }

    public function excluirAnexo($id = null)
    {
        if ($id == null || ! is_numeric($id)) {
            echo json_encode(['result' => false, 'mensagem' => 'Erro ao tentar excluir anexo.']);
        } else {
            $this->db->where('idAnexos', $id);
            $file = $this->db->get('anexos', 1)->row();
            $idOs = $this->input->post('idOs');

            unlink($file->path . DIRECTORY_SEPARATOR . $file->anexo);

            if ($file->thumb != null) {
                unlink($file->path . DIRECTORY_SEPARATOR . 'thumbs' . DIRECTORY_SEPARATOR . $file->thumb);
            }

            if ($this->os_model->delete('anexos', 'idAnexos', $id) == true) {
                log_info('Removeu anexo de uma OS. ID (OS): ' . $idOs);
                echo json_encode(['result' => true, 'mensagem' => 'Anexo excluído com sucesso.']);
            } else {
                echo json_encode(['result' => false, 'mensagem' => 'Erro ao tentar excluir anexo.']);
            }
        }
    }

    public function downloadanexo($id = null)
    {
        if ($id != null && is_numeric($id)) {
            $this->db->where('idAnexos', $id);
            $file = $this->db->get('anexos', 1)->row();

            $this->load->library('zip');
            $path = $file->path;
            $this->zip->read_file($path . '/' . $file->anexo);
            $this->zip->download('file' . date('d-m-Y-H.i.s') . '.zip');
        }
    }

    public function adicionarDesconto()
    {
        if ($this->input->post('desconto') == '') {
            return $this->output
                ->set_content_type('application/json')
                ->set_status_header(400)
                ->set_output(json_encode(['messages' => 'Campo desconto vazio']));
        } else {
            $idOs = $this->input->post('idOs');

            // Busca o subtotal real da OS pra validar no servidor — usa
            // getProdutos()/getServicos() porque getById() NÃO calcula
            // totalProdutos/totalServicos (não existem como coluna).
            $produtosOs = $this->os_model->getProdutos($idOs);
            $servicosOs = $this->os_model->getServicos($idOs);

            $subtotal = 0;
            foreach ($produtosOs as $p) {
                $subtotal += isset($p->subTotal) ? floatval($p->subTotal) : floatval($p->preco ?: $p->precoVenda) * floatval($p->quantidade ?: 1);
            }
            foreach ($servicosOs as $s) {
                $subtotal += floatval($s->preco ?: $s->precoVenda) * floatval($s->quantidade ?: 1);
            }

            $resultado = floatval(str_replace(',', '.', $this->input->post('resultado')));
            if ($resultado < 0) {
                $resultado = 0;
            }
            if ($subtotal > 0 && $resultado > $subtotal) {
                $resultado = $subtotal;
            }

            $data = [
                'tipo_desconto' => $this->input->post('tipoDesconto'),
                'desconto' => $this->input->post('desconto'),
                'valor_desconto' => $resultado,
            ];
            $editavel = $this->os_model->isEditable($idOs);
            if (! $editavel) {
                return $this->output
                    ->set_content_type('application/json')
                    ->set_status_header(400)
                    ->set_output(json_encode(['result' => false, 'messages', 'Desconto não pode ser adiciona. Os não ja Faturada/Cancelada']));
            }
            if ($this->os_model->edit('os', $data, 'idOs', $idOs) == true) {
                log_info('Adicionou um desconto na OS. ID: ' . $idOs);

                return $this->output
                    ->set_content_type('application/json')
                    ->set_status_header(201)
                    ->set_output(json_encode(['result' => true, 'messages' => 'Desconto adicionado com sucesso!']));
            } else {
                log_info('Ocorreu um erro ao tentar adiciona desconto a OS: ' . $idOs);

                return $this->output
                    ->set_content_type('application/json')
                    ->set_status_header(400)
                    ->set_output(json_encode(['result' => false, 'messages', 'Ocorreu um erro ao tentar adiciona desconto a OS.']));
            }
        }

        return $this->output
            ->set_content_type('application/json')
            ->set_status_header(400)
            ->set_output(json_encode(['result' => false, 'messages', 'Ocorreu um erro ao tentar adiciona desconto a OS.']));
    }

    public function faturar()
    {
        $this->load->library('form_validation');
        $this->data['custom_error'] = '';

        if ($this->form_validation->run('receita') == false) {
            $this->data['custom_error'] = (validation_errors() ? '<div class="form_error">' . validation_errors() . '</div>' : false);
        } else {
            $vencimento = $this->input->post('vencimento');
            $recebimento = $this->input->post('recebimento');

            try {
                $vencimento = DateTime::createFromFormat('d/m/Y', $vencimento)->format('Y-m-d');
                if ($recebimento != null) {
                    $recebimento = DateTime::createFromFormat('d/m/Y', $recebimento)->format('Y-m-d');
                }
            } catch (Exception $e) {
                $vencimento = date('Y-m-d');
            }

            $os_id = $this->input->post('os_id');
            $valorTotalData = $this->os_model->valorTotalOS($os_id);

            $valorTotalServico = $valorTotalData['totalServico'];
            $valorTotalProduto = $valorTotalData['totalProdutos'];
            $valorDesconto = $valorTotalData['valor_desconto'];

            $valorTotal = $valorTotalServico + $valorTotalProduto;
            $valorTotalComDesconto = $valorTotal - $valorDesconto;

            $data = [
                'descricao' => $this->input->post('descricao'),
                'valor' => $valorTotal,
                'tipo_desconto' => 'real',
                'desconto' => ($valorDesconto > 0) ? $valorTotalComDesconto : 0,
                'valor_desconto' => ($valorDesconto > 0) ? $valorDesconto : $valorTotal,
                'clientes_id' => $this->input->post('clientes_id'),
                'data_vencimento' => $vencimento,
                'data_pagamento' => $recebimento,
                'baixado' => $this->input->post('recebido') ?: 0,
                'cliente_fornecedor' => $this->input->post('cliente'),
                'forma_pgto' => $this->input->post('formaPgto'),
                'tipo' => $this->input->post('tipo'),
                'observacoes' => $this->input->post('observacoes'),
                'usuarios_id' => $this->session->userdata('id_admin'),
            ];

            $this->db->trans_start();

            $editavel = $this->os_model->isEditable($os_id);
            if (!$editavel) {
                $this->db->trans_rollback();
                return $this->output
                    ->set_content_type('application/json')
                    ->set_status_header(400)
                    ->set_output(json_encode(['result' => false]));
            }

            if ($this->os_model->add('lancamentos', $data)) {
                $this->db->set('faturado', 1);
                $this->db->set('valorTotal', $valorTotal);

                if ($valorDesconto > 0) {
                    $this->db->set('desconto', $valorTotalComDesconto);
                    $this->db->set('valor_desconto', $valorDesconto);
                } else {
                    $this->db->set('desconto', 0);
                    $this->db->set('valor_desconto', $valorTotal);
                }

                $this->db->set('status', 'Faturado');
                $this->db->where('idOs', $os_id);
                $this->db->update('os');

                log_info('Faturou uma OS. ID: ' . $os_id);

                $this->db->trans_complete();

                if ($this->db->trans_status() === false) {
                    $this->session->set_flashdata('error', 'Ocorreu um erro ao tentar faturar OS.');
                    $json = ['result' => false];
                } else {
                    $this->session->set_flashdata('success', 'OS faturada com sucesso!');
                    $json = ['result' => true];
                }
            } else {
                $this->db->trans_rollback();
                $this->session->set_flashdata('error', 'Ocorreu um erro ao tentar faturar OS.');
                $json = ['result' => false];
            }

            echo json_encode($json);
            exit();
        }

        $this->session->set_flashdata('error', 'Ocorreu um erro ao tentar faturar OS.');
        $json = ['result' => false];
        echo json_encode($json);
    }

    private function enviarOsPorEmail($idOs, $remetentes, $assunto)
    {
        $dados = [];

        $this->load->model('sisos_model');
        $dados['result'] = $this->os_model->getById($idOs);
        if (! isset($dados['result']->email)) {
            return false;
        }

        $dados['produtos'] = $this->os_model->getProdutos($idOs);
        $dados['servicos'] = $this->os_model->getServicos($idOs);
        $dados['emitente'] = $this->sisos_model->getEmitente();
        $emitente = $dados['emitente'];
        if (! isset($emitente->email)) {
            return false;
        }

        $html = $this->load->view('os/emails/os', $dados, true);

        $this->load->model('email_model');

        $remetentes = array_unique($remetentes);
        foreach ($remetentes as $remetente) {
            if ($remetente) {
                $headers = ['From' => $emitente->email, 'Subject' => $assunto, 'Return-Path' => ''];
                $email = [
                    'to' => $remetente,
                    'message' => $html,
                    'status' => 'pending',
                    'date' => date('Y-m-d H:i:s'),
                    'headers' => serialize($headers),
                ];
                $this->email_model->add('email_queue', $email);
            } else {
                log_info('Email não adicionado a Lista de envio de e-mails. Verifique se o remetente esta cadastrado. OS ID: ' . $idOs);
            }
        }

        return true;
    }

    public function adicionarAnotacao()
    {
        $this->load->library('form_validation');
        if ($this->form_validation->run('anotacoes_os') == false) {
            echo json_encode(validation_errors());
        } else {
            $data = [
                'anotacao' => '[' . $this->session->userdata('nome_admin') . '] ' . $this->input->post('anotacao'),
                'data_hora' => date('Y-m-d H:i:s'),
                'os_id' => $this->input->post('os_id'),
            ];

            if ($this->os_model->add('anotacoes_os', $data) == true) {
                log_info('Adicionou anotação a uma OS. ID (OS): ' . $this->input->post('os_id'));
                echo json_encode(['result' => true]);
            } else {
                echo json_encode(['result' => false]);
            }
        }
    }

    public function excluirAnotacao()
    {
        $id = $this->input->post('idAnotacao');
        $idOs = $this->input->post('idOs');

        if ($this->os_model->delete('anotacoes_os', 'idAnotacoes', $id) == true) {
            log_info('Removeu anotação de uma OS. ID (OS): ' . $idOs);
            echo json_encode(['result' => true]);
        } else {
            echo json_encode(['result' => false]);
        }
    }

    /**
     * Cancelar OS faturada/finalizada — devolve estoque e remove lançamento
     */
    public function garantiaDigital($idOs = null)
    {
        if (!$idOs || !is_numeric($idOs)) {
            show_404(); return;
        }

        $this->load->model('sisos_model');
        $os       = $this->os_model->getById($idOs);
        $emitente = $this->sisos_model->getEmitente();

        if (!$os) { show_404(); return; }

        // Só exibe garantia para OS finalizadas/faturadas com garantia definida
        $statusValidos = ['Finalizado', 'Faturado'];
        if (!in_array($os->status, $statusValidos) || !$os->garantia) {
            $this->session->set_flashdata('error', 'Garantia não disponível para esta OS.');
            redirect(site_url('os/visualizar/' . $idOs));
            return;
        }

        $produtos  = $this->os_model->getProdutos($idOs);
        $servicos  = $this->os_model->getServicos($idOs);
        // Aponta para a Área do Cliente (Mine), não mais para o controller
        // interno Os — assim o cliente não cai numa tela de login de
        // funcionário ao escanear o QR Code.
        $link      = site_url('mine/garantia/' . $idOs);

        // QR Code via API pública
        $qrUrl = 'https://api.qrserver.com/v1/create-qr-code/?size=180x180&data=' . urlencode($link);

        $data = [
            'os'       => $os,
            'emitente' => $emitente,
            'produtos' => $produtos,
            'servicos' => $servicos,
            'link'     => $link,
            'qrUrl'    => $qrUrl,
        ];

        // View standalone (sem layout do sistema)
        $this->load->view('os/garantia_digital', $data);
    }

    /**
     * Etiqueta com QR Code pro aparelho — pra colar fisicamente, aponta
     * pro Link de Acompanhamento (gera o token se ainda não tiver).
     */
    public function etiqueta($idOs = null)
    {
        if (!$idOs || !is_numeric($idOs)) {
            show_404(); return;
        }

        $os = $this->os_model->getById($idOs);
        if (!$os) { show_404(); return; }

        $this->_garantirTrackingToken($os);

        $link  = site_url('mine/acompanhar/' . $os->tracking_token);
        $qrUrl = 'https://api.qrserver.com/v1/create-qr-code/?size=220x220&data=' . urlencode($link);

        $data = [
            'os'    => $os,
            'link'  => $link,
            'qrUrl' => $qrUrl,
        ];

        $this->load->view('os/etiqueta', $data);
    }

    /**
     * Tela de "sucesso" mostrada logo depois de criar uma OS nova — atalhos
     * rápidos pra imprimir (A4/Cupom/Etiqueta) ou já avisar o cliente pelo
     * WhatsApp, sem precisar navegar até a tela de edição pra achar esses
     * botões.
     */
    public function criadaComSucesso($idOs = null)
    {
        if (!$idOs || !is_numeric($idOs)) {
            show_404(); return;
        }

        $os = $this->db
            ->select('os.*, clientes.nomeCliente, clientes.celular, clientes.telefone')
            ->join('clientes', 'clientes.idClientes = os.clientes_id', 'left')
            ->where('os.idOs', $idOs)
            ->get('os')->row();

        if (!$os) { show_404(); return; }

        $this->_garantirTrackingToken($os);

        $telefone = preg_replace('/\D/', '', $os->celular ?: $os->telefone ?: '');
        $link = site_url('mine/acompanhar/' . $os->tracking_token);
        $mensagem = 'Olá *' . ($os->nomeCliente ?? '') . '*! Recebemos seu(a) *' . ($os->descricaoProduto ?? 'aparelho') . '* aqui na assistência. '
                  . 'Você pode acompanhar o andamento do reparo em tempo real por este link: ' . $link;

        $this->data['os'] = $os;
        $this->data['telefone'] = $telefone;
        $this->data['linkWhats'] = 'https://api.whatsapp.com/send?phone=55' . $telefone . '&text=' . urlencode($mensagem);
        $this->data['view'] = 'os/sucesso';

        return $this->layout();
    }

    /**
     * Salva a assinatura digital do cliente na entrega (capturada por
     * canvas na tela, enviada como imagem em base64).
     */
    public function salvarAssinatura()
    {
        header('Content-Type: application/json');

        if (! $this->permission->checkPermission($this->session->userdata('permissao'), 'eOs')) {
            echo json_encode(['sucesso' => false, 'erro' => 'Sem permissão.']);
            return;
        }

        $idOs = (int) $this->input->post('id');
        $imagemBase64 = $this->input->post('assinatura');

        if (! $idOs || ! $imagemBase64 || strpos($imagemBase64, 'data:image/png;base64,') !== 0) {
            echo json_encode(['sucesso' => false, 'erro' => 'Dados inválidos.']);
            return;
        }

        // Limite de tamanho básico (~1.5MB em base64) pra evitar abuso
        if (strlen($imagemBase64) > 1500000) {
            echo json_encode(['sucesso' => false, 'erro' => 'Imagem muito grande.']);
            return;
        }

        $ok = $this->os_model->edit('os', [
            'assinatura_entrega' => $imagemBase64,
            'assinatura_data'    => date('Y-m-d H:i:s'),
        ], 'idOs', $idOs);

        log_info('Registrou assinatura digital de entrega. OS ID: ' . $idOs);
        echo json_encode(['sucesso' => (bool) $ok]);
    }

    public function cancelar()
    {
        if (!$this->permission->checkPermission($this->session->userdata('permissao'), 'eOs')) {
            $this->session->set_flashdata('error', 'Você não tem permissão para cancelar OS.');
            redirect(base_url());
        }

        $id = $this->input->post('id');
        if (!$id || !is_numeric($id)) {
            $this->session->set_flashdata('error', 'OS inválida.');
            redirect(site_url('os/gerenciar/'));
        }

        $os = $this->os_model->getById($id);
        if (!$os) {
            $this->session->set_flashdata('error', 'OS não encontrada.');
            redirect(site_url('os/gerenciar/'));
        }

        // Só pode cancelar se não estiver já cancelada
        if ($os->status === 'Cancelado') {
            $this->session->set_flashdata('error', 'OS já está cancelada.');
            redirect(site_url('os/visualizar/' . $id));
        }

        // 1. Devolver estoque
        $this->devolucaoEstoque($id);

        // 2. Excluir lançamento financeiro vinculado
        $this->db->where('descricao', "Fatura de OS - #$id")->delete('lancamentos');
        // Também busca por vendas_id ou os_id se existir
        $this->db->where('descricao', "Fatura de OS Nº: $id")->delete('lancamentos');

        // 3. Mudar status para Cancelado
        $motivo = $this->input->post('motivo') ?: 'Cancelado manualmente';
        $this->db->where('idOs', $id)->update('os', [
            'status'     => 'Cancelado',
            'observacoes' => trim(($os->observacoes ?? '') . "
[CANCELADO em " . date('d/m/Y H:i') . " por " . $this->session->userdata('nome') . "] " . $motivo),
        ]);

        log_info("OS #$id cancelada. Motivo: $motivo. Estoque devolvido.");
        $this->session->set_flashdata('success', "OS #{$id} cancelada com sucesso. Estoque devolvido.");
        redirect(site_url('os/visualizar/' . $id));
    }


    /**
     * Processa e serializa o checklist de saída do POST
     */
    private function _processarChecklistSaida() {
        $json = $this->input->post('checklist_saida_json');
        if ($json) {
            $data = json_decode($json, true) ?: [];
            if (!empty($data['itens'])) {
                return json_encode(['itens' => $data['itens'], 'obs' => $data['obs'] ?? '', 'v' => 2]);
            }
        }
        return null;
    }

}