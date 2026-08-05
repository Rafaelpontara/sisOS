<?php

class Chat_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Lista todos os usuários (menos eu mesmo) pra montar a barra lateral
     * de conversas privadas, já com a contagem de mensagens não lidas
     * de cada um.
     */
    public function listarUsuarios($meuId)
    {
        $this->db->select('idUsuarios, nome');
        $this->db->where('idUsuarios !=', $meuId);
        $this->db->order_by('nome', 'asc');
        $usuarios = $this->db->get('usuarios')->result();

        foreach ($usuarios as $u) {
            $u->naoLidas = $this->db
                ->where('remetente_id', $u->idUsuarios)
                ->where('destinatario_id', $meuId)
                ->where('lida', 0)
                ->count_all_results('chat_mensagens');
        }

        return $usuarios;
    }

    /**
     * Quantas mensagens não lidas o usuário tem no canal Geral —
     * conta quantas mensagens de grupo têm id maior que o último que
     * ele marcou como lido.
     */
    public function contarNaoLidasGeral($meuId)
    {
        $ultimoLido = $this->db
            ->where('usuarios_id', $meuId)
            ->get('chat_geral_leitura')
            ->row();

        $ultimoId = $ultimoLido ? (int) $ultimoLido->ultimo_id_lido : 0;

        $this->db->where('destinatario_id', null);
        $this->db->where('idMensagem >', $ultimoId);
        $this->db->where('remetente_id !=', $meuId);

        return $this->db->count_all_results('chat_mensagens');
    }

    /**
     * Mensagens do canal Geral a partir de um determinado id (cursor) —
     * usado tanto pro carregamento inicial (desdeId = 0, traz as últimas
     * N) quanto pro polling (desdeId = id da última que o cliente já tem).
     */
    public function getMensagensGerais($desdeId = 0, $limite = 50)
    {
        $this->db->select('cm.*, u.nome as remetenteNome');
        $this->db->from('chat_mensagens cm');
        $this->db->join('usuarios u', 'u.idUsuarios = cm.remetente_id', 'left');
        $this->db->where('cm.destinatario_id', null);

        if ($desdeId > 0) {
            $this->db->where('cm.idMensagem >', $desdeId);
            $this->db->order_by('cm.idMensagem', 'asc');
        } else {
            // Carregamento inicial: pega as últimas $limite e devolve em ordem cronológica
            $this->db->order_by('cm.idMensagem', 'desc');
            $this->db->limit($limite);
        }

        $result = $this->db->get()->result();

        if ($desdeId == 0) {
            $result = array_reverse($result);
        }

        return $result;
    }

    public function enviarGeral($remetenteId, $texto, $tipo = 'texto')
    {
        $this->db->insert('chat_mensagens', [
            'remetente_id'    => $remetenteId,
            'destinatario_id' => null,
            'mensagem'        => $texto,
            'tipo'            => $tipo,
            'data_envio'      => date('Y-m-d H:i:s'),
        ]);

        return $this->db->insert_id();
    }

    /**
     * Marca como "lido" o canal Geral até a última mensagem existente
     * no momento — chamado quando o usuário abre/foca a aba Geral.
     */
    public function marcarGeralComoLido($meuId)
    {
        $ultima = $this->db->select_max('idMensagem')->where('destinatario_id', null)->get('chat_mensagens')->row();
        $ultimoId = $ultima && $ultima->idMensagem ? (int) $ultima->idMensagem : 0;

        $existe = $this->db->where('usuarios_id', $meuId)->get('chat_geral_leitura')->row();
        if ($existe) {
            $this->db->where('usuarios_id', $meuId)->update('chat_geral_leitura', ['ultimo_id_lido' => $ultimoId]);
        } else {
            $this->db->insert('chat_geral_leitura', ['usuarios_id' => $meuId, 'ultimo_id_lido' => $ultimoId]);
        }
    }

    /**
     * Conversa privada entre dois usuários, a partir de um cursor (id).
     */
    public function getMensagensPrivadas($euId, $outroId, $desdeId = 0, $limite = 50)
    {
        $this->db->select('cm.*, u.nome as remetenteNome');
        $this->db->from('chat_mensagens cm');
        $this->db->join('usuarios u', 'u.idUsuarios = cm.remetente_id', 'left');
        $this->db->group_start();
        $this->db->where('remetente_id', $euId)->where('destinatario_id', $outroId);
        $this->db->or_group_start()->where('remetente_id', $outroId)->where('destinatario_id', $euId)->group_end();
        $this->db->group_end();

        if ($desdeId > 0) {
            $this->db->where('cm.idMensagem >', $desdeId);
            $this->db->order_by('cm.idMensagem', 'asc');
        } else {
            $this->db->order_by('cm.idMensagem', 'desc');
            $this->db->limit($limite);
        }

        $result = $this->db->get()->result();

        if ($desdeId == 0) {
            $result = array_reverse($result);
        }

        return $result;
    }

    public function enviarPrivado($remetenteId, $destinatarioId, $texto, $tipo = 'texto')
    {
        $this->db->insert('chat_mensagens', [
            'remetente_id'    => $remetenteId,
            'destinatario_id' => $destinatarioId,
            'mensagem'        => $texto,
            'tipo'            => $tipo,
            'data_envio'      => date('Y-m-d H:i:s'),
        ]);

        return $this->db->insert_id();
    }

    /**
     * Throttle do "chamar atenção" (nudge) — evita spam permitindo só
     * 1 chamada a cada 10 segundos por par de usuários.
     */
    public function podeChamarAtencao($remetenteId, $destinatarioId)
    {
        $this->db->where('remetente_id', $remetenteId);
        $this->db->where('destinatario_id', $destinatarioId);
        $this->db->where('tipo', 'atencao');
        $this->db->where('data_envio >=', date('Y-m-d H:i:s', time() - 10));

        return $this->db->count_all_results('chat_mensagens') === 0;
    }

    /**
     * Busca registros pra "marcar" numa mensagem do chat (OS, Venda,
     * Cliente, Produto, Solução técnica ou Pedido) — usado pelo painel
     * de referência do chat, que insere um marcador especial no texto
     * da mensagem (interpretado na hora de exibir, virando um link
     * clicável que leva direto pra tela daquele registro).
     */
    public function buscarReferencias($tipo, $termo)
    {
        $termo = trim((string) $termo);
        $numerico = is_numeric($termo);
        $resultados = [];

        switch ($tipo) {
            case 'OS':
                $this->db->select('os.idOs, os.equipamento, clientes.nomeCliente');
                $this->db->from('os');
                $this->db->join('clientes', 'clientes.idClientes = os.clientes_id', 'left');
                if ($numerico) {
                    $this->db->where('os.idOs', (int) $termo);
                } else {
                    $this->db->group_start();
                    $this->db->like('clientes.nomeCliente', $termo);
                    $this->db->or_like('os.equipamento', $termo);
                    $this->db->group_end();
                }
                $this->db->order_by('os.idOs', 'desc');
                $this->db->limit(8);
                foreach ($this->db->get()->result() as $r) {
                    $label = 'OS #' . $r->idOs;
                    if ($r->nomeCliente) { $label .= ' — ' . $r->nomeCliente; }
                    if ($r->equipamento) { $label .= ' (' . $r->equipamento . ')'; }
                    $resultados[] = ['id' => $r->idOs, 'label' => $label];
                }
                break;

            case 'VENDA':
                $this->db->select('vendas.idVendas, clientes.nomeCliente');
                $this->db->from('vendas');
                $this->db->join('clientes', 'clientes.idClientes = vendas.clientes_id', 'left');
                if ($numerico) {
                    $this->db->where('vendas.idVendas', (int) $termo);
                } else {
                    $this->db->like('clientes.nomeCliente', $termo);
                }
                $this->db->order_by('vendas.idVendas', 'desc');
                $this->db->limit(8);
                foreach ($this->db->get()->result() as $r) {
                    $label = 'Venda #' . $r->idVendas;
                    if ($r->nomeCliente) { $label .= ' — ' . $r->nomeCliente; }
                    $resultados[] = ['id' => $r->idVendas, 'label' => $label];
                }
                break;

            case 'CLIENTE':
                $this->db->select('idClientes, nomeCliente');
                $this->db->from('clientes');
                if ($numerico) {
                    $this->db->where('idClientes', (int) $termo);
                } else {
                    $this->db->group_start();
                    $this->db->like('nomeCliente', $termo);
                    $this->db->or_like('documento', $termo);
                    $this->db->or_like('telefone', $termo);
                    $this->db->group_end();
                }
                $this->db->order_by('idClientes', 'desc');
                $this->db->limit(8);
                foreach ($this->db->get()->result() as $r) {
                    $resultados[] = ['id' => $r->idClientes, 'label' => $r->nomeCliente];
                }
                break;

            case 'PRODUTO':
                $this->db->select('idProdutos, descricao, modelo');
                $this->db->from('produtos');
                if ($numerico) {
                    $this->db->where('idProdutos', (int) $termo);
                } else {
                    $this->db->group_start();
                    $this->db->like('descricao', $termo);
                    $this->db->or_like('modelo', $termo);
                    $this->db->group_end();
                }
                $this->db->order_by('idProdutos', 'desc');
                $this->db->limit(8);
                foreach ($this->db->get()->result() as $r) {
                    $label = $r->descricao;
                    if ($r->modelo) { $label .= ' (' . $r->modelo . ')'; }
                    $resultados[] = ['id' => $r->idProdutos, 'label' => $label];
                }
                break;

            case 'SOLUCAO':
                $this->db->select('id, titulo, equipamento');
                $this->db->from('solucoes_tecnicas');
                if ($numerico) {
                    $this->db->where('id', (int) $termo);
                } else {
                    $this->db->group_start();
                    $this->db->like('titulo', $termo);
                    $this->db->or_like('equipamento', $termo);
                    $this->db->group_end();
                }
                $this->db->order_by('id', 'desc');
                $this->db->limit(8);
                foreach ($this->db->get()->result() as $r) {
                    $resultados[] = ['id' => $r->id, 'label' => $r->titulo];
                }
                break;

            case 'PEDIDO':
                $this->db->select('pedidos_produtos.id, pedidos_produtos.descricao, clientes.nomeCliente');
                $this->db->from('pedidos_produtos');
                $this->db->join('clientes', 'clientes.idClientes = pedidos_produtos.clientes_id', 'left');
                if ($numerico) {
                    $this->db->where('pedidos_produtos.id', (int) $termo);
                } else {
                    $this->db->like('pedidos_produtos.descricao', $termo);
                }
                $this->db->order_by('pedidos_produtos.id', 'desc');
                $this->db->limit(8);
                foreach ($this->db->get()->result() as $r) {
                    $label = $r->descricao;
                    if ($r->nomeCliente) { $label .= ' — ' . $r->nomeCliente; }
                    $resultados[] = ['id' => $r->id, 'label' => $label];
                }
                break;
        }

        return $resultados;
    }

    /**
     * Marca como lidas as mensagens que o outro usuário me mandou —
     * chamado quando eu abro a conversa com ele.
     */
    public function marcarPrivadasComoLidas($euId, $outroId)
    {
        $this->db->where('remetente_id', $outroId);
        $this->db->where('destinatario_id', $euId);
        $this->db->where('lida', 0);
        $this->db->update('chat_mensagens', ['lida' => 1]);
    }

    public function getUsuarioPorId($id)
    {
        return $this->db->where('idUsuarios', $id)->get('usuarios')->row();
    }
}
