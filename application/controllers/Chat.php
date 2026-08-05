<?php

if (! defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Chat extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->load->model('chat_model');
        $this->data['menuChat'] = 'chat';
    }

    /**
     * Token CSRF atual, pra devolver junto de toda resposta JSON que vem
     * de um POST. Necessário porque o chat faz várias chamadas seguidas
     * na mesma página (sem recarregar) — se o config tiver
     * `csrf_regenerate` ligado, o token muda a cada POST, e sem isso o
     * token guardado no JS desde o carregamento da página ficaria velho
     * já na segunda mensagem enviada (era exatamente isso que fazia as
     * mensagens "não enviarem": o token antigo era recusado silenciosamente
     * pelo fetch, que cai no .catch() sem mostrar erro nenhum).
     */
    private function csrfPayload()
    {
        return [
            'csrf_name' => $this->security->get_csrf_token_name(),
            'csrf_hash' => $this->security->get_csrf_hash(),
        ];
    }

    /**
     * Tela principal do chat — canal Geral + lista de colegas.
     * Não usa um permissão vX/aX específica porque é uma ferramenta de
     * comunicação da equipe, não um módulo de dados; se quiser restringir
     * o acesso, dá pra adicionar um checkPermission aqui igual aos outros
     * controllers.
     */
    public function index()
    {
        $meuId = $this->session->userdata('id_admin');

        $this->data['usuarios']          = $this->chat_model->listarUsuarios($meuId);
        $this->data['mensagensGerais']   = $this->chat_model->getMensagensGerais(0, 50);
        $this->data['naoLidasGeral']     = $this->chat_model->contarNaoLidasGeral($meuId);
        $this->data['meuId']             = $meuId;
        $this->data['view']              = 'chat/chat';

        return $this->layout();
    }

    /**
     * Polling do canal Geral — devolve mensagens novas a partir de um id.
     */
    public function mensagensGerais()
    {
        $desdeId = (int) $this->input->get('desde_id');
        $mensagens = $this->chat_model->getMensagensGerais($desdeId, 50);

        header('Content-Type: application/json');
        echo json_encode(['mensagens' => $mensagens]);
    }

    public function enviarGeral()
    {
        $meuId = $this->session->userdata('id_admin');
        $texto = trim($this->input->post('mensagem'));

        header('Content-Type: application/json');

        if ($texto === '') {
            echo json_encode(array_merge(['sucesso' => false, 'erro' => 'Mensagem vazia.'], $this->csrfPayload()));
            return;
        }

        $id = $this->chat_model->enviarGeral($meuId, $texto);
        echo json_encode(array_merge(['sucesso' => (bool) $id, 'id' => $id], $this->csrfPayload()));
    }

    /**
     * Marca o canal Geral como lido (chamado quando o usuário foca a aba).
     */
    public function marcarGeralLido()
    {
        $meuId = $this->session->userdata('id_admin');
        $this->chat_model->marcarGeralComoLido($meuId);

        header('Content-Type: application/json');
        echo json_encode(array_merge(['sucesso' => true], $this->csrfPayload()));
    }

    /**
     * Polling de uma conversa privada — devolve mensagens novas a partir
     * de um id, e marca como lidas as que o outro usuário mandou.
     */
    public function mensagensPrivadas($outroId)
    {
        $meuId   = $this->session->userdata('id_admin');
        $outroId = (int) $outroId;
        $desdeId = (int) $this->input->get('desde_id');

        $mensagens = $this->chat_model->getMensagensPrivadas($meuId, $outroId, $desdeId, 50);
        $this->chat_model->marcarPrivadasComoLidas($meuId, $outroId);

        header('Content-Type: application/json');
        echo json_encode(['mensagens' => $mensagens]);
    }

    public function enviarPrivado()
    {
        $meuId          = $this->session->userdata('id_admin');
        $destinatarioId = (int) $this->input->post('destinatario_id');
        $texto          = trim($this->input->post('mensagem'));

        header('Content-Type: application/json');

        if ($texto === '' || !$destinatarioId) {
            echo json_encode(array_merge(['sucesso' => false, 'erro' => 'Dados inválidos.'], $this->csrfPayload()));
            return;
        }

        $id = $this->chat_model->enviarPrivado($meuId, $destinatarioId, $texto);
        echo json_encode(array_merge(['sucesso' => (bool) $id, 'id' => $id], $this->csrfPayload()));
    }

    /**
     * Devolve a lista de usuários com contagem de não lidas atualizada —
     * usado pra atualizar os badges da barra lateral periodicamente.
     */
    public function listarConversas()
    {
        $meuId = $this->session->userdata('id_admin');
        $usuarios = $this->chat_model->listarUsuarios($meuId);
        $naoLidasGeral = $this->chat_model->contarNaoLidasGeral($meuId);

        header('Content-Type: application/json');
        echo json_encode(['usuarios' => $usuarios, 'naoLidasGeral' => $naoLidasGeral]);
    }

    /**
     * "Chamar atenção" (nudge) numa conversa privada — igual ao antigo
     * recurso do Windows Live Messenger. Envia uma mensagem especial
     * (tipo = 'atencao') que o outro usuário recebe com a tela
     * tremendo e um som, via polling normal.
     */
    public function chamarAtencao()
    {
        $meuId          = $this->session->userdata('id_admin');
        $destinatarioId = (int) $this->input->post('destinatario_id');

        header('Content-Type: application/json');

        if (!$destinatarioId) {
            echo json_encode(array_merge(['sucesso' => false, 'erro' => 'Destinatário inválido.'], $this->csrfPayload()));
            return;
        }

        if (!$this->chat_model->podeChamarAtencao($meuId, $destinatarioId)) {
            echo json_encode(array_merge(['sucesso' => false, 'erro' => 'Aguarde alguns segundos antes de chamar atenção de novo.'], $this->csrfPayload()));
            return;
        }

        $meu   = $this->chat_model->getUsuarioPorId($meuId);
        $texto = '🔔 ' . ($meu->nome ?? 'Alguém') . ' chamou sua atenção!';
        $id    = $this->chat_model->enviarPrivado($meuId, $destinatarioId, $texto, 'atencao');

        echo json_encode(array_merge(['sucesso' => (bool) $id, 'id' => $id], $this->csrfPayload()));
    }

    /**
     * Busca registros (OS, Venda, Cliente, Produto, Solução ou Pedido)
     * pra "marcar" numa mensagem — alimenta o painel de referência do
     * chat, que insere um marcador especial no texto (interpretado na
     * exibição como um link clicável pra tela do registro).
     */
    public function buscarReferencias()
    {
        $tipo  = strtoupper((string) $this->input->get('tipo'));
        $termo = (string) $this->input->get('termo');

        $tiposValidos = ['OS', 'VENDA', 'CLIENTE', 'PRODUTO', 'SOLUCAO', 'PEDIDO'];

        header('Content-Type: application/json');

        if (!in_array($tipo, $tiposValidos, true) || trim($termo) === '') {
            echo json_encode(['resultados' => []]);
            return;
        }

        echo json_encode(['resultados' => $this->chat_model->buscarReferencias($tipo, $termo)]);
    }
}
