<style>
/* ══════════════════════════════════════════════════════════
   CHAT DA EQUIPE
   ══════════════════════════════════════════════════════════ */
.chat-wrap {
    display: flex;
    height: calc(100vh - 140px);
    min-height: 480px;
    background: #1a1d2e;
    border: 1px solid rgba(255,255,255,0.07);
    border-radius: 14px;
    overflow: hidden;
}

/* ── Sidebar ── */
.chat-sidebar {
    width: 260px;
    flex-shrink: 0;
    border-right: 1px solid rgba(255,255,255,0.07);
    display: flex;
    flex-direction: column;
    background: #161925;
}
.chat-sidebar-head {
    padding: 16px 16px 10px;
    font-size: 11px;
    font-weight: 700;
    color: #6b7280;
    text-transform: uppercase;
    letter-spacing: .6px;
}
.chat-lista { flex: 1; overflow-y: auto; padding: 0 8px 12px; }
.chat-item {
    display: flex; align-items: center; gap: 10px;
    padding: 9px 10px; border-radius: 10px; cursor: pointer;
    transition: background .15s; margin-bottom: 2px; position: relative;
}
.chat-item:hover { background: rgba(255,255,255,0.04); }
.chat-item.ativo { background: rgba(167,139,250,0.15); }
.chat-avatar {
    width: 36px; height: 36px; border-radius: 50%; flex-shrink: 0;
    display: flex; align-items: center; justify-content: center;
    font-size: 13px; font-weight: 800; color: #fff;
    background: linear-gradient(135deg,#a78bfa,#7c3aed);
}
.chat-avatar.geral { background: linear-gradient(135deg,#34d399,#10b981); }
.chat-item-info { flex: 1; overflow: hidden; }
.chat-item-nome { font-size: 13px; font-weight: 600; color: #e8eaf0; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
.chat-badge {
    min-width: 18px; height: 18px; border-radius: 20px; background: #ef4444; color: #fff;
    font-size: 10px; font-weight: 800; display: flex; align-items: center; justify-content: center;
    padding: 0 5px; flex-shrink: 0;
}

/* ── Área principal ── */
.chat-main { flex: 1; display: flex; flex-direction: column; min-width: 0; }
.chat-header {
    padding: 14px 20px; border-bottom: 1px solid rgba(255,255,255,0.07);
    display: flex; align-items: center; gap: 10px; font-weight: 700; color: #e8eaf0; font-size: 14px;
}
.chat-header i { font-size: 18px; color: #a78bfa; }

.chat-mensagens {
    flex: 1; overflow-y: auto; padding: 18px 20px;
    display: flex; flex-direction: column; gap: 10px;
}
.chat-msg { max-width: 65%; display: flex; flex-direction: column; gap: 2px; }
.chat-msg.minha { align-self: flex-end; align-items: flex-end; }
.chat-msg.outra { align-self: flex-start; align-items: flex-start; }
.chat-msg-autor { font-size: 10.5px; font-weight: 700; color: #a78bfa; }
.chat-msg-bolha {
    padding: 9px 13px; border-radius: 14px; font-size: 13.5px; color: #e8eaf0;
    background: #252a3a; word-wrap: break-word; white-space: pre-wrap;
}
.chat-msg.minha .chat-msg-bolha { background: linear-gradient(135deg,#7c3aed,#a78bfa); border-bottom-right-radius: 4px; }
.chat-msg.outra .chat-msg-bolha { border-bottom-left-radius: 4px; }
.chat-msg-hora { font-size: 10px; color: #6b7280; margin-top: 1px; }

.chat-vazio { text-align: center; color: #6b7280; padding: 40px 20px; font-size: 13px; margin: auto; }
.chat-vazio i { font-size: 40px; display: block; margin-bottom: 10px; opacity: .3; }

.chat-input-bar {
    display: flex; gap: 10px; padding: 14px 20px; border-top: 1px solid rgba(255,255,255,0.07);
}
.chat-input-bar input {
    flex: 1; background: #1e2133; border: 1px solid #444860; color: #e8eaf0;
    border-radius: 10px; padding: 10px 14px; font-size: 13.5px;
}
.chat-input-bar input:focus { outline: none; border-color: #a78bfa; }
.chat-input-bar button {
    width: 42px; height: 42px; border-radius: 10px; border: none; cursor: pointer;
    background: linear-gradient(135deg,#a78bfa,#7c3aed); color: #fff; font-size: 18px;
    display: flex; align-items: center; justify-content: center; flex-shrink: 0;
    transition: transform .15s;
}
.chat-input-bar button:hover { transform: scale(1.08); }

@media (max-width: 768px) {
    .chat-wrap { flex-direction: column; height: auto; }
    .chat-sidebar { width: 100%; max-height: 200px; border-right: none; border-bottom: 1px solid rgba(255,255,255,0.07); }
    .chat-main { height: 60vh; }
}

/* ── Referências (chip clicável pra OS/Venda/Cliente/Produto/etc) ── */
.chat-ref-chip {
    display: inline-flex; align-items: center; gap: 5px;
    background: color-mix(in srgb, var(--ref-cor, #a78bfa) 16%, transparent);
    border: 1px solid color-mix(in srgb, var(--ref-cor, #a78bfa) 45%, transparent);
    color: var(--ref-cor, #a78bfa) !important;
    border-radius: 20px; padding: 3px 11px 3px 9px; font-size: 12px; font-weight: 700;
    text-decoration: none !important; margin: 2px 2px 0 0; vertical-align: middle;
}
.chat-ref-chip:hover { filter: brightness(1.15); }
.chat-ref-chip i { font-size: 13px; }

/* ── Mensagem de "chamar atenção" (nudge) ── */
.chat-msg-atencao {
    align-self: center !important; max-width: 85%;
    background: rgba(251,191,36,0.1); border: 1px solid rgba(251,191,36,0.3);
    border-radius: 20px; padding: 6px 16px; font-size: 12.5px; color: #fbbf24;
    font-weight: 700; display: flex; align-items: center; gap: 6px;
}

@keyframes chatShake {
    0%, 100% { transform: translate(0,0); }
    10% { transform: translate(-6px,0); } 20% { transform: translate(6px,0); }
    30% { transform: translate(-6px,0); } 40% { transform: translate(6px,0); }
    50% { transform: translate(-4px,0); } 60% { transform: translate(4px,0); }
    70% { transform: translate(-3px,0); } 80% { transform: translate(3px,0); }
    90% { transform: translate(-2px,0); }
}
.chat-wrap.chat-shake { animation: chatShake .5s; }

/* ── Barra de ações extra no input (emoji, referência, chamar atenção) ── */
.chat-input-bar { position: relative; flex-wrap: wrap; }
.chat-aux-btn {
    width: 42px; height: 42px; border-radius: 10px; border: 1px solid #444860; cursor: pointer;
    background: #1e2133; color: #9ca3af; font-size: 17px;
    display: flex; align-items: center; justify-content: center; flex-shrink: 0;
    transition: background .15s, color .15s;
}
.chat-aux-btn:hover { background: #252a3a; color: #e8eaf0; }
.chat-aux-btn.chat-aux-atencao { color: #fbbf24; border-color: rgba(251,191,36,0.4); }
.chat-aux-btn.chat-aux-atencao:hover { background: rgba(251,191,36,0.12); }
.chat-aux-btn.chat-aux-atencao.desativado { color: #4b5060; border-color: #444860; opacity: .55; }
.chat-aux-btn.chat-aux-atencao.desativado:hover { background: #1e2133; }

.chat-popover {
    position: absolute; bottom: 62px; left: 20px; width: 360px; max-width: calc(100% - 40px); max-height: 360px;
    background: #1e2133; border: 1px solid #444860; border-radius: 12px;
    box-shadow: 0 12px 30px rgba(0,0,0,0.45); padding: 12px; z-index: 40;
    display: none; flex-direction: column; gap: 8px; overflow: hidden;
}
.chat-popover.aberto { display: flex; }
.chat-popover-titulo { font-size: 11px; font-weight: 800; color: #6b7280; text-transform: uppercase; letter-spacing: .5px; flex-shrink: 0; }

/* Emoji picker */
.chat-emoji-grid { display: grid; grid-template-columns: repeat(8, 1fr); gap: 2px; overflow-y: auto; max-height: 220px; }
.chat-emoji-item { font-size: 19px; text-align: center; padding: 4px 0; border-radius: 6px; cursor: pointer; background: none; border: none; }
.chat-emoji-item:hover { background: rgba(255,255,255,0.08); }

/* Painel de referência (menção @) — v2, reforçado contra qualquer
   herança/conflito de estilo: cada resultado é isolado (position:static,
   float:none, contain:layout) e empilhado só pelo fluxo normal de blocos
   da lista (nunca por flex/grid no container pai). Dentro de CADA botão
   pode ter flex à vontade — isso não afeta o empilhamento entre botões. */
.chat-ref-resultados {
    display: block !important;
    width: 100% !important;
    overflow-y: auto; overflow-x: hidden; max-height: 280px;
}
.chat-ref-resultado {
    all: unset; /* zera qualquer estilo padrão de <button> do navegador */
    box-sizing: border-box !important;
    display: flex !important;
    position: static !important;
    float: none !important;
    contain: layout;
    align-items: center;
    gap: 10px;
    width: 100% !important;
    text-align: left;
    background: #13151f;
    border: 1px solid rgba(255,255,255,0.06);
    color: #c9cad6;
    border-radius: 8px;
    padding: 9px 12px;
    font-size: 12.5px;
    line-height: 1.4;
    cursor: pointer;
    margin: 0 0 6px 0 !important;
    white-space: normal;
    overflow-wrap: break-word;
}
.chat-ref-resultado:last-child { margin-bottom: 0 !important; }
.chat-ref-resultado:hover { border-color: #a78bfa; color: #e8eaf0; background: #191c2b; }
.chat-ref-resultado.selecionada { border-color: #a78bfa; background: rgba(167,139,250,0.1); }
.chat-ref-resultado-icone {
    flex-shrink: 0; width: 26px; height: 26px; border-radius: 7px;
    display: flex; align-items: center; justify-content: center; font-size: 13px;
    background: color-mix(in srgb, var(--ref-cor, #a78bfa) 18%, transparent);
    color: var(--ref-cor, #a78bfa);
}
.chat-ref-resultado-corpo { flex: 1; min-width: 0; display: flex; flex-direction: column; gap: 2px; }
.chat-ref-resultado-tag {
    font-size: 9.5px; font-weight: 800; letter-spacing: .4px;
    color: var(--ref-cor, #a78bfa); text-transform: uppercase;
}
.chat-ref-resultado-label {
    font-size: 12.5px; color: #e8eaf0; overflow: hidden; text-overflow: ellipsis;
    white-space: nowrap;
}
.chat-ref-vazio { font-size: 12px; color: #6b7280; text-align: center; padding: 10px 0; }

.chat-toast {
    position: absolute; bottom: 62px; left: 50%; transform: translateX(-50%);
    background: #252a3a; border: 1px solid #444860; color: #e8eaf0; font-size: 12.5px;
    padding: 8px 16px; border-radius: 20px; z-index: 50; box-shadow: 0 8px 20px rgba(0,0,0,0.35);
}
</style>

<?php
/**
 * Interpreta o texto de uma mensagem do chat, transformando marcadores
 * de referência (§REF:TIPO:ID:LABEL§) em links clicáveis que levam
 * direto pra tela daquele registro (OS, Venda, Cliente, Produto,
 * Solução técnica ou Pedido) — usado só na renderização inicial (via
 * PHP); as mensagens que chegam depois via polling passam pela mesma
 * lógica, só que em JS (função formatarMensagemHtml).
 */
function chatFormatarMensagem($texto)
{
    $mapa = [
        'OS'      => ['url' => 'os/visualizar/',       'icone' => 'bx-file-blank', 'cor' => '#60a5fa'],
        'VENDA'   => ['url' => 'vendas/visualizar/',   'icone' => 'bx-cart-alt',   'cor' => '#34d399'],
        'CLIENTE' => ['url' => 'clientes/visualizar/', 'icone' => 'bx-user',       'cor' => '#a78bfa'],
        'PRODUTO' => ['url' => 'produtos/visualizar/', 'icone' => 'bx-basket',     'cor' => '#fbbf24'],
        'SOLUCAO' => ['url' => 'solucoes/visualizar/', 'icone' => 'bx-bulb',       'cor' => '#f472b6'],
        'PEDIDO'  => ['url' => 'pedidos?destaque=',    'icone' => 'bx-task',       'cor' => '#38bdf8'],
    ];

    $texto = htmlspecialchars($texto);

    $texto = preg_replace_callback('/§REF:([A-Z]+):(\d+):([^§]*)§/', function ($m) use ($mapa) {
        $tipo = $m[1];
        if (!isset($mapa[$tipo])) {
            return $m[0];
        }
        $info = $mapa[$tipo];
        $href = base_url('index.php/' . $info['url'] . $m[2]);

        return '<a href="' . $href . '" target="_blank" class="chat-ref-chip" style="--ref-cor:' . $info['cor'] . '"><i class="bx ' . $info['icone'] . '"></i>' . $m[3] . '</a>';
    }, $texto);

    return nl2br($texto);
}
?>

<div class="new122">
    <div class="pg-header" style="margin-bottom:16px;">
        <div class="pg-title" style="font-size:22px;font-weight:800;color:#e8eaf0;display:flex;align-items:center;gap:10px;">
            <i class='bx bx-chat' style="font-size:24px;color:#a78bfa;"></i> Chat da Equipe
        </div>
    </div>

    <div class="chat-wrap">
        <!-- Sidebar -->
        <div class="chat-sidebar">
            <div class="chat-sidebar-head">Conversas</div>
            <div class="chat-lista" id="chat-lista">
                <div class="chat-item ativo" data-tipo="geral" data-id="0" onclick="chatAbrir('geral', 0, 'Geral', this)">
                    <div class="chat-avatar geral"><i class='bx bx-group'></i></div>
                    <div class="chat-item-info">
                        <div class="chat-item-nome">Geral</div>
                    </div>
                    <span class="chat-badge" id="chat-badge-geral" style="<?= ($naoLidasGeral ?? 0) > 0 ? '' : 'display:none;' ?>"><?= (int) ($naoLidasGeral ?? 0) ?></span>
                </div>

                <?php foreach ($usuarios as $u): ?>
                <div class="chat-item" data-tipo="privado" data-id="<?= $u->idUsuarios ?>"
                     onclick="chatAbrir('privado', <?= $u->idUsuarios ?>, '<?= htmlspecialchars(addslashes($u->nome)) ?>', this)">
                    <div class="chat-avatar"><?= strtoupper(mb_substr($u->nome, 0, 1)) ?></div>
                    <div class="chat-item-info">
                        <div class="chat-item-nome"><?= htmlspecialchars($u->nome) ?></div>
                    </div>
                    <span class="chat-badge" id="chat-badge-user-<?= $u->idUsuarios ?>" style="<?= $u->naoLidas > 0 ? '' : 'display:none;' ?>"><?= (int) $u->naoLidas ?></span>
                </div>
                <?php endforeach; ?>
            </div>
        </div>

        <!-- Área principal -->
        <div class="chat-main">
            <div class="chat-header"><i class='bx bx-group'></i> <span id="chat-titulo">Geral</span></div>
            <div class="chat-mensagens" id="chat-mensagens">
                <?php if (empty($mensagensGerais)): ?>
                <div class="chat-vazio"><i class='bx bx-message-rounded-dots'></i>Nenhuma mensagem ainda. Diga oi pra equipe!</div>
                <?php else: foreach ($mensagensGerais as $m): ?>
                <?php if (($m->tipo ?? 'texto') === 'atencao'): ?>
                <div class="chat-msg chat-msg-atencao" data-id="<?= $m->idMensagem ?>">
                    <i class='bx bx-bell'></i> <?= htmlspecialchars($m->mensagem) ?>
                </div>
                <?php else: ?>
                <div class="chat-msg <?= $m->remetente_id == $meuId ? 'minha' : 'outra' ?>" data-id="<?= $m->idMensagem ?>">
                    <?php if ($m->remetente_id != $meuId): ?>
                    <div class="chat-msg-autor"><?= htmlspecialchars($m->remetenteNome ?? '—') ?></div>
                    <?php endif; ?>
                    <div class="chat-msg-bolha"><?= chatFormatarMensagem($m->mensagem) ?></div>
                    <div class="chat-msg-hora"><?= date('H:i', strtotime($m->data_envio)) ?></div>
                </div>
                <?php endif; ?>
                <?php endforeach; endif; ?>
            </div>
            <div class="chat-input-bar">
                <!-- Painel de emojis -->
                <div class="chat-popover" id="chat-emoji-panel">
                    <div class="chat-popover-titulo">Emojis</div>
                    <div class="chat-emoji-grid" id="chat-emoji-grid"></div>
                </div>

                <!-- Painel de referência (marcar OS, Venda, Cliente, etc) — abre
                     sozinho ao digitar "@" na mensagem, tipo menção de rede social -->
                <div class="chat-popover" id="chat-ref-panel">
                    <div class="chat-popover-titulo">Digite depois do @ pra buscar</div>
                    <div class="chat-ref-resultados" id="chat-ref-resultados">
                        <div class="chat-ref-vazio">Digite @ na mensagem e o número ou nome — OS, Venda, Cliente, Produto, Solução ou Pedido.</div>
                    </div>
                </div>

                <button type="button" class="chat-aux-btn" id="btn-emoji" title="Emojis" onclick="chatTogglePainel('emoji')"><i class='bx bx-smile'></i></button>
                <button type="button" class="chat-aux-btn" id="btn-ref" title="Marcar OS, Venda, Cliente... (digite @)" onclick="chatInserirArroba()"><i class='bx bx-at'></i></button>
                <input type="text" id="chat-input" placeholder="Escreva uma mensagem... (@ pra marcar OS, Venda, Cliente...)" maxlength="1000" autocomplete="off">
                <button type="button" class="chat-aux-btn chat-aux-atencao desativado" id="btn-atencao" title="Chamar atenção (só em conversa privada)" onclick="chatChamarAtencao()"><i class='bx bx-bell'></i></button>
                <button type="button" onclick="chatEnviar()"><i class='bx bx-send'></i></button>
            </div>
        </div>
    </div>
</div>

<script>
(function() {
    var meuId = <?= (int) $meuId ?>;
    var conversaAtual = { tipo: 'geral', id: 0 };
    var ultimoIdVisto = { geral: <?= !empty($mensagensGerais) ? end($mensagensGerais)->idMensagem : 0 ?> };
    var pollingTimer = null;
    var sidebarTimer = null;
    var BASE_URL_INDEX = '<?= base_url('index.php/') ?>';

    var mensagensEl = document.getElementById('chat-mensagens');
    var inputEl = document.getElementById('chat-input');
    var tituloEl = document.getElementById('chat-titulo');
    var btnAtencaoEl = document.getElementById('btn-atencao');

    // ── Referências clicáveis (OS, Venda, Cliente, Produto, Solução, Pedido) ──
    var REF_MAPA = {
        OS:      { url: 'os/visualizar/',       icone: 'bx-file-blank', cor: '#60a5fa' },
        VENDA:   { url: 'vendas/visualizar/',   icone: 'bx-cart-alt',   cor: '#34d399' },
        CLIENTE: { url: 'clientes/visualizar/', icone: 'bx-user',       cor: '#a78bfa' },
        PRODUTO: { url: 'produtos/visualizar/', icone: 'bx-basket',     cor: '#fbbf24' },
        SOLUCAO: { url: 'solucoes/visualizar/', icone: 'bx-bulb',       cor: '#f472b6' },
        PEDIDO:  { url: 'pedidos?destaque=',    icone: 'bx-task',       cor: '#38bdf8' }
    };

    function formatarMensagemHtml(textoEscapado) {
        var html = textoEscapado.replace(/§REF:([A-Z]+):(\d+):([^§]*)§/g, function(tudo, tipo, id, label) {
            var info = REF_MAPA[tipo];
            if (!info) return tudo;
            var href = BASE_URL_INDEX + info.url + id;
            return '<a href="' + href + '" target="_blank" class="chat-ref-chip" style="--ref-cor:' + info.cor + '"><i class="bx ' + info.icone + '"></i>' + label + '</a>';
        });
        return html.replace(/\n/g, '<br>');
    }

    // ── Token CSRF (com auto-renovação) ─────────────────────────────────
    // Guardado em variável (não fixo) porque o chat faz vários POSTs
    // seguidos sem recarregar a página — se o config tiver
    // "csrf_regenerate" ligado, o token muda a cada POST. Sem isso, a
    // partir da 2ª mensagem o token ficava velho e o envio falhava
    // silenciosamente (o fetch caía no .catch() sem avisar nada).
    var csrfNome = '<?= $this->security->get_csrf_token_name() ?>';
    var csrfValor = '<?= $this->security->get_csrf_hash() ?>';

    function csrfData() {
        var d = {};
        d[csrfNome] = csrfValor;
        return d;
    }

    function atualizarCsrf(data) {
        if (data && data.csrf_name && data.csrf_hash) {
            csrfNome = data.csrf_name;
            csrfValor = data.csrf_hash;
        }
    }

    function escaparHtml(s) {
        var div = document.createElement('div');
        div.textContent = s;
        return div.innerHTML;
    }

    function scrollParaFinal() {
        mensagensEl.scrollTop = mensagensEl.scrollHeight;
    }

    function renderMensagem(m) {
        if (m.tipo === 'atencao') {
            var divAtencao = document.createElement('div');
            divAtencao.className = 'chat-msg chat-msg-atencao';
            divAtencao.setAttribute('data-id', m.idMensagem);
            divAtencao.innerHTML = '<i class="bx bx-bell"></i>' + escaparHtml(m.mensagem);
            return divAtencao;
        }

        var minha = (parseInt(m.remetente_id, 10) === meuId);
        var div = document.createElement('div');
        div.className = 'chat-msg ' + (minha ? 'minha' : 'outra');
        div.setAttribute('data-id', m.idMensagem);

        var autorHtml = (!minha) ? '<div class="chat-msg-autor">' + escaparHtml(m.remetenteNome || '—') + '</div>' : '';
        var hora = new Date(m.data_envio.replace(' ', 'T'));
        var horaFmt = isNaN(hora.getTime()) ? '' : (('0' + hora.getHours()).slice(-2) + ':' + ('0' + hora.getMinutes()).slice(-2));

        div.innerHTML = autorHtml +
            '<div class="chat-msg-bolha">' + formatarMensagemHtml(escaparHtml(m.mensagem)) + '</div>' +
            '<div class="chat-msg-hora">' + horaFmt + '</div>';

        return div;
    }

    window.chatAbrir = function(tipo, id, nome, elClicado) {
        conversaAtual = { tipo: tipo, id: id };
        tituloEl.textContent = nome;
        if (btnAtencaoEl) {
            var ehPrivado = (tipo === 'privado');
            btnAtencaoEl.classList.toggle('desativado', !ehPrivado);
            btnAtencaoEl.title = ehPrivado ? 'Chamar atenção' : 'Chamar atenção (só funciona em conversa privada — abra uma conversa com alguém na lateral)';
        }
        chatFecharPaineis();

        document.querySelectorAll('.chat-item').forEach(function(el) { el.classList.remove('ativo'); });
        if (elClicado) elClicado.classList.add('ativo');

        mensagensEl.innerHTML = '<div class="chat-vazio"><i class="bx bx-loader-alt bx-spin"></i>Carregando...</div>';

        if (tipo === 'geral') {
            fetch('<?= site_url("chat/mensagensGerais") ?>?desde_id=0')
                .then(function(r) { return r.json(); })
                .then(function(data) { renderInicial(data.mensagens || []); zerarBadge('geral'); marcarGeralLido(); });
        } else {
            fetch('<?= site_url("chat/mensagensPrivadas") ?>/' + id + '?desde_id=0')
                .then(function(r) { return r.json(); })
                .then(function(data) { renderInicial(data.mensagens || []); zerarBadge('user-' + id); });
        }

        reiniciarPolling();
    };

    function renderInicial(mensagens) {
        mensagensEl.innerHTML = '';
        if (!mensagens.length) {
            mensagensEl.innerHTML = '<div class="chat-vazio"><i class="bx bx-message-rounded-dots"></i>Nenhuma mensagem ainda.</div>';
        } else {
            mensagens.forEach(function(m) { mensagensEl.appendChild(renderMensagem(m)); });
        }
        var ultima = mensagens.length ? mensagens[mensagens.length - 1].idMensagem : 0;
        if (conversaAtual.tipo === 'geral') ultimoIdVisto.geral = ultima;
        else ultimoIdVisto['priv_' + conversaAtual.id] = ultima;
        scrollParaFinal();
    }

    function zerarBadge(sufixo) {
        var el = document.getElementById('chat-badge-' + sufixo);
        if (el) { el.style.display = 'none'; el.textContent = '0'; }
    }

    function marcarGeralLido() {
        fetch('<?= site_url("chat/marcarGeralLido") ?>', { method: 'POST', headers: {'Content-Type':'application/x-www-form-urlencoded'}, body: new URLSearchParams(csrfData()).toString() })
            .then(function(r) { return r.json(); })
            .then(atualizarCsrf)
            .catch(function() {});
    }

    function poll() {
        var url, chave;
        if (conversaAtual.tipo === 'geral') {
            chave = 'geral';
            url = '<?= site_url("chat/mensagensGerais") ?>?desde_id=' + (ultimoIdVisto.geral || 0);
        } else {
            chave = 'priv_' + conversaAtual.id;
            url = '<?= site_url("chat/mensagensPrivadas") ?>/' + conversaAtual.id + '?desde_id=' + (ultimoIdVisto[chave] || 0);
        }

        fetch(url).then(function(r) { return r.json(); }).then(function(data) {
            var novas = data.mensagens || [];
            if (!novas.length) return;

            var vazio = mensagensEl.querySelector('.chat-vazio');
            if (vazio) mensagensEl.innerHTML = '';

            novas.forEach(function(m) {
                mensagensEl.appendChild(renderMensagem(m));
                if (m.tipo === 'atencao' && parseInt(m.remetente_id, 10) !== meuId) {
                    dispararAtencao();
                }
            });
            ultimoIdVisto[chave] = novas[novas.length - 1].idMensagem;
            scrollParaFinal();

            if (conversaAtual.tipo === 'geral') marcarGeralLido();
        }).catch(function() {});

        atualizarSidebar();
    }

    function atualizarSidebar() {
        fetch('<?= site_url("chat/listarConversas") ?>').then(function(r) { return r.json(); }).then(function(data) {
            // Badge geral só atualiza se a conversa aberta NÃO for o geral (senão já foi zerado acima)
            if (conversaAtual.tipo !== 'geral') {
                var bg = document.getElementById('chat-badge-geral');
                if (bg) {
                    if (data.naoLidasGeral > 0) { bg.style.display = ''; bg.textContent = data.naoLidasGeral; }
                    else { bg.style.display = 'none'; }
                }
            }
            (data.usuarios || []).forEach(function(u) {
                if (conversaAtual.tipo === 'privado' && conversaAtual.id === u.idUsuarios) return;
                var el = document.getElementById('chat-badge-user-' + u.idUsuarios);
                if (el) {
                    if (u.naoLidas > 0) { el.style.display = ''; el.textContent = u.naoLidas; }
                    else { el.style.display = 'none'; }
                }
            });
        }).catch(function() {});
    }

    function reiniciarPolling() {
        if (pollingTimer) clearInterval(pollingTimer);
        pollingTimer = setInterval(poll, 3000);
    }

    window.chatEnviar = function() {
        var texto = inputEl.value.trim();
        if (!texto) return;
        inputEl.value = '';

        var body = csrfData();
        body.mensagem = texto;
        var url;
        if (conversaAtual.tipo === 'geral') {
            url = '<?= site_url("chat/enviarGeral") ?>';
        } else {
            body.destinatario_id = conversaAtual.id;
            url = '<?= site_url("chat/enviarPrivado") ?>';
        }

        fetch(url, { method: 'POST', headers: {'Content-Type':'application/x-www-form-urlencoded'}, body: new URLSearchParams(body).toString() })
            .then(function(r) {
                return r.text().then(function(txt) {
                    var data;
                    try { data = JSON.parse(txt); }
                    catch (erroParse) {
                        throw new Error('Resposta inesperada do servidor (HTTP ' + r.status + '): ' + txt.replace(/<[^>]*>/g, ' ').trim().slice(0, 180));
                    }
                    return data;
                });
            })
            .then(function(data) {
                atualizarCsrf(data);
                if (data.sucesso === false) { chatToast(data.erro || 'Não foi possível enviar a mensagem.'); }
                poll();
            })
            .catch(function(err) {
                console.error('Envio de mensagem falhou:', err);
                chatToast((err && err.message) ? err.message : 'Erro ao enviar a mensagem.');
            });
    };

    // ── Inserir texto na posição do cursor do campo de mensagem ─────────
    function inserirNoInput(texto) {
        var inicio = inputEl.selectionStart != null ? inputEl.selectionStart : inputEl.value.length;
        var fim = inputEl.selectionEnd != null ? inputEl.selectionEnd : inputEl.value.length;
        var valor = inputEl.value;
        inputEl.value = valor.slice(0, inicio) + texto + valor.slice(fim);
        var novaPos = inicio + texto.length;
        inputEl.focus();
        inputEl.setSelectionRange(novaPos, novaPos);
    }

    // ── Toast simples (avisos como o throttle do "chamar atenção") ─────
    function chatToast(msg) {
        var el = document.createElement('div');
        el.className = 'chat-toast';
        el.textContent = msg;
        document.querySelector('.chat-input-bar').appendChild(el);
        setTimeout(function() { el.remove(); }, 2600);
    }

    // ── Painéis (emoji / referência) ─────────────────────────────────────
    var emojiPanel = document.getElementById('chat-emoji-panel');
    var refPanel = document.getElementById('chat-ref-panel');

    window.chatFecharPaineis = function() {
        emojiPanel.classList.remove('aberto');
        refPanel.classList.remove('aberto');
        arrobaPos = -1;
    };

    window.chatTogglePainel = function(nome) {
        var painel = (nome === 'emoji') ? emojiPanel : refPanel;
        var outro = (nome === 'emoji') ? refPanel : emojiPanel;
        outro.classList.remove('aberto');
        painel.classList.toggle('aberto');
    };

    document.addEventListener('click', function(e) {
        var dentroPopover = e.target.closest('.chat-popover') || e.target.closest('#btn-emoji') || e.target.closest('#btn-ref') || e.target === inputEl;
        if (!dentroPopover) chatFecharPaineis();
    });

    // ── Emojis ────────────────────────────────────────────────────────
    var EMOJIS = ['😀','😁','😂','🤣','😊','😉','😍','🥰','😘','😎','🤔','🙂','🙃','😅','😇',
        '🙁','😢','😭','😡','😱','😴','🤝','👍','👎','👏','🙏','💪','✌️','👌','🤙',
        '❤️','🔥','⭐','✅','❌','⚠️','📌','📎','📱','💻','🔧','🔩','🔋','📦','🛠️',
        '🕐','📅','💰','💵','🎉','😬','🤷','👀','✍️','📷'];

    var emojiGrid = document.getElementById('chat-emoji-grid');
    EMOJIS.forEach(function(emoji) {
        var btn = document.createElement('button');
        btn.type = 'button';
        btn.className = 'chat-emoji-item';
        btn.textContent = emoji;
        btn.onclick = function() { inserirNoInput(emoji); };
        emojiGrid.appendChild(btn);
    });

    // ── Marcar OS, Venda, Cliente, Produto, Solução ou Pedido tipo "@menção" ──
    // Digitar "@" na mensagem e continuar digitando (número ou nome) já
    // busca nos 6 tipos ao mesmo tempo e mostra as opções — sem precisar
    // escolher um tipo antes.
    var TIPOS_MENCAO = ['OS', 'VENDA', 'CLIENTE', 'PRODUTO', 'SOLUCAO', 'PEDIDO'];
    var arrobaPos = -1;      // posição do "@" ativo no texto, ou -1 se nenhum
    var mencaoDebounce = null;
    var resultadosMencaoAtual = [];

    function chatBuscarMencao(termo) {
        var resultadosEl = document.getElementById('chat-ref-resultados');

        if (!termo) {
            resultadosEl.innerHTML = '<div class="chat-ref-vazio">Continue digitando o número ou nome...</div>';
            resultadosMencaoAtual = [];
            return;
        }

        resultadosEl.innerHTML = '<div class="chat-ref-vazio"><i class="bx bx-loader-alt bx-spin"></i> Buscando...</div>';

        var promessas = TIPOS_MENCAO.map(function(tipo) {
            return fetch('<?= site_url("chat/buscarReferencias") ?>?tipo=' + tipo + '&termo=' + encodeURIComponent(termo))
                .then(function(r) { return r.json(); })
                .then(function(data) {
                    atualizarCsrf(data);
                    return (data.resultados || []).map(function(r) { r.tipo = tipo; return r; });
                })
                .catch(function() { return []; });
        });

        Promise.all(promessas).then(function(listas) {
            var todos = [].concat.apply([], listas).slice(0, 10);
            resultadosMencaoAtual = todos;
            renderizarResultadosMencao(todos);
        });
    }

    function renderizarResultadosMencao(lista) {
        var resultadosEl = document.getElementById('chat-ref-resultados');
        if (!lista.length) {
            resultadosEl.innerHTML = '<div class="chat-ref-vazio">Nada encontrado.</div>';
            return;
        }
        // Limpa tudo antes de montar de novo — evita qualquer resíduo de
        // uma busca anterior ficar sobreposto com a nova.
        while (resultadosEl.firstChild) { resultadosEl.removeChild(resultadosEl.firstChild); }

        lista.forEach(function(r) {
            var info = REF_MAPA[r.tipo] || {};
            var btn = document.createElement('button');
            btn.type = 'button';
            btn.className = 'chat-ref-resultado';
            btn.style.setProperty('--ref-cor', info.cor || '#a78bfa');

            var icone = document.createElement('span');
            icone.className = 'chat-ref-resultado-icone';
            icone.innerHTML = '<i class="bx ' + (info.icone || 'bx-hash') + '"></i>';

            var corpo = document.createElement('span');
            corpo.className = 'chat-ref-resultado-corpo';
            var tag = document.createElement('span');
            tag.className = 'chat-ref-resultado-tag';
            tag.textContent = r.tipo;
            var label = document.createElement('span');
            label.className = 'chat-ref-resultado-label';
            label.textContent = r.label;
            corpo.appendChild(tag);
            corpo.appendChild(label);

            btn.appendChild(icone);
            btn.appendChild(corpo);
            btn.onclick = function() { chatEscolherMencao(r.tipo, r.id, r.label); };
            resultadosEl.appendChild(btn);
        });
    }

    function chatEscolherMencao(tipo, id, label) {
        if (arrobaPos === -1) return;
        var val = inputEl.value;
        var cursor = inputEl.selectionStart != null ? inputEl.selectionStart : val.length;
        var labelLimpo = String(label).replace(/§/g, '');
        var marcador = '§REF:' + tipo + ':' + id + ':' + labelLimpo + '§ ';

        inputEl.value = val.slice(0, arrobaPos) + marcador + val.slice(cursor);
        var novaPos = arrobaPos + marcador.length;
        inputEl.focus();
        inputEl.setSelectionRange(novaPos, novaPos);
        chatFecharPaineis();
    }

    // Insere um "@" (usado pelo botão de link) e já dispara a busca de menção
    window.chatInserirArroba = function() {
        inserirNoInput('@');
        inputEl.dispatchEvent(new Event('input'));
    };

    inputEl.addEventListener('input', function() {
        var val = inputEl.value;
        var cursor = inputEl.selectionStart != null ? inputEl.selectionStart : val.length;
        var antesDoCursor = val.slice(0, cursor);
        var idxArroba = antesDoCursor.lastIndexOf('@');

        // Só considera "@" ativo se não tiver espaço/quebra de linha entre
        // ele e o cursor (senão é um "@" antigo, já digitado antes).
        if (idxArroba === -1 || /\s/.test(antesDoCursor.slice(idxArroba))) {
            arrobaPos = -1;
            refPanel.classList.remove('aberto');
            return;
        }

        arrobaPos = idxArroba;
        var termo = antesDoCursor.slice(idxArroba + 1);
        emojiPanel.classList.remove('aberto');
        refPanel.classList.add('aberto');

        clearTimeout(mencaoDebounce);
        mencaoDebounce = setTimeout(function() { chatBuscarMencao(termo); }, 250);
    });

    inputEl.addEventListener('keydown', function(e) {
        if (arrobaPos !== -1 && refPanel.classList.contains('aberto')) {
            if (e.key === 'Escape') { e.preventDefault(); chatFecharPaineis(); return; }
            if (e.key === 'Enter') {
                e.preventDefault();
                if (resultadosMencaoAtual.length) {
                    var primeiro = resultadosMencaoAtual[0];
                    chatEscolherMencao(primeiro.tipo, primeiro.id, primeiro.label);
                }
                return;
            }
        }
        if (e.key === 'Enter' && !e.shiftKey) { e.preventDefault(); chatEnviar(); }
    });

    // ── Chamar atenção (estilo Windows Live Messenger) ──────────────────
    function dispararAtencao() {
        var wrap = document.querySelector('.chat-wrap');
        wrap.classList.remove('chat-shake');
        void wrap.offsetWidth; // força reflow pra poder repetir a animação
        wrap.classList.add('chat-shake');
        setTimeout(function() { wrap.classList.remove('chat-shake'); }, 600);
        tocarBeep();
    }

    function tocarBeep() {
        try {
            var ctx = new (window.AudioContext || window.webkitAudioContext)();
            var osc = ctx.createOscillator();
            var gain = ctx.createGain();
            osc.type = 'sine';
            osc.frequency.setValueAtTime(880, ctx.currentTime);
            osc.frequency.setValueAtTime(660, ctx.currentTime + 0.12);
            gain.gain.setValueAtTime(0.15, ctx.currentTime);
            gain.gain.exponentialRampToValueAtTime(0.001, ctx.currentTime + 0.32);
            osc.connect(gain);
            gain.connect(ctx.destination);
            osc.start();
            osc.stop(ctx.currentTime + 0.34);
        } catch (e) { /* navegador sem suporte a áudio — ignora silenciosamente */ }
    }

    window.chatChamarAtencao = function() {
        if (conversaAtual.tipo !== 'privado') {
            chatToast('Chamar atenção só funciona numa conversa privada — abra uma conversa com alguém na lateral primeiro.');
            return;
        }

        var body = csrfData();
        body.destinatario_id = conversaAtual.id;

        fetch('<?= site_url("chat/chamarAtencao") ?>', { method: 'POST', headers: {'Content-Type':'application/x-www-form-urlencoded'}, body: new URLSearchParams(body).toString() })
            .then(function(r) {
                // Se o servidor não devolveu JSON (ex: página de erro do CI,
                // token CSRF recusado, sessão caiu), lê como texto pra
                // mostrar a causa real em vez de um "erro de conexão" genérico.
                return r.text().then(function(txt) {
                    var data;
                    try { data = JSON.parse(txt); }
                    catch (erroParse) {
                        throw new Error('Resposta inesperada do servidor (HTTP ' + r.status + '): ' + txt.replace(/<[^>]*>/g, ' ').trim().slice(0, 180));
                    }
                    return data;
                });
            })
            .then(function(data) {
                atualizarCsrf(data);
                if (data.sucesso) { dispararAtencao(); poll(); }
                else { chatToast(data.erro || 'Não foi possível chamar atenção agora.'); }
            })
            .catch(function(err) {
                console.error('chamarAtencao falhou:', err);
                chatToast((err && err.message) ? err.message : 'Erro de conexão.');
            });
    };

    // Inicia
    marcarGeralLido();
    reiniciarPolling();
    sidebarTimer = setInterval(atualizarSidebar, 8000);
    scrollParaFinal();
})();
</script>
