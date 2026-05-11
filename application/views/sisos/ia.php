<style>
/* ── Layout ── */
.ia-wrap{max-width:1100px;margin:0 auto;}
.ia-header{display:flex;align-items:center;justify-content:space-between;margin-bottom:20px;flex-wrap:wrap;gap:10px;}
.ia-title{display:flex;align-items:center;gap:10px;}
.ia-title i{font-size:26px;color:#a78bfa;}
.ia-title h2{font-size:20px;font-weight:800;color:#e8eaf0;margin:0;}
.ia-provedor-badge{display:inline-flex;align-items:center;gap:5px;padding:3px 10px;border-radius:20px;font-size:11px;font-weight:700;background:rgba(99,102,241,0.15);color:#a5b4fc;border:1px solid rgba(99,102,241,0.25);}
/* Provider switcher */
.ia-prov-switcher{display:flex;gap:6px;flex-wrap:wrap;padding:10px 14px;border-bottom:1px solid rgba(255,255,255,0.05);background:#13151f;}
.ia-prov-btn{display:inline-flex;align-items:center;gap:5px;padding:5px 12px;border-radius:20px;font-size:11px;font-weight:700;cursor:pointer;border:1px solid rgba(255,255,255,0.1);background:rgba(255,255,255,0.04);color:#6b7280;transition:all .15s;white-space:nowrap;}
.ia-prov-btn:hover{background:rgba(255,255,255,0.09);color:#e8eaf0;}
.ia-prov-btn.active{color:#fff;border-color:transparent;}
.ia-prov-btn.disabled-prov{opacity:.4;cursor:not-allowed;}
.ia-prov-btn.disabled-prov::after{content:"sem chave";font-size:9px;opacity:.6;margin-left:2px;}
.ia-no-key{padding:10px 16px;background:rgba(239,68,68,0.08);border-bottom:1px solid rgba(239,68,68,0.15);font-size:12px;color:#fca5a5;display:none;}

/* ── Grid principal ── */
.ia-grid{display:grid;grid-template-columns:340px 1fr;gap:16px;align-items:start;}
@media(max-width:900px){.ia-grid{grid-template-columns:1fr;}}

/* ── Card base ── */
.ia-card{background:#1a1d2e;border:1px solid rgba(255,255,255,0.07);border-radius:14px;overflow:hidden;margin-bottom:14px;}
.ia-card-head{display:flex;align-items:center;gap:8px;padding:11px 16px;border-bottom:1px solid rgba(255,255,255,0.06);background:#252a3a;}
.ia-card-head i{font-size:15px;}
.ia-card-head span{font-size:11px;font-weight:700;color:#9ca3af;text-transform:uppercase;letter-spacing:.8px;}
.ia-card-body{padding:14px;}

/* ── Chat ── */
.ia-chat-wrap{display:flex;flex-direction:column;height:560px;}
.ia-messages{flex:1;overflow-y:auto;padding:16px;display:flex;flex-direction:column;gap:12px;}
.ia-messages::-webkit-scrollbar{width:4px;}
.ia-messages::-webkit-scrollbar-thumb{background:#444860;border-radius:4px;}
.ia-msg{display:flex;gap:10px;align-items:flex-start;}
.ia-msg-user{flex-direction:row-reverse;}
.ia-msg-avatar{width:32px;height:32px;border-radius:8px;display:flex;align-items:center;justify-content:center;font-size:15px;flex-shrink:0;}
.ia-msg-avatar-bot{background:linear-gradient(135deg,#6366f1,#4f46e5);}
.ia-msg-avatar-user{background:rgba(34,197,94,0.2);color:#4ade80;}
.ia-msg-bubble{max-width:80%;padding:10px 14px;border-radius:12px;font-size:13px;line-height:1.6;word-break:break-word;}
.ia-msg-bubble-bot{background:#252a3a;color:#e8eaf0;border-radius:4px 12px 12px 12px;}
.ia-msg-bubble-user{background:rgba(99,102,241,0.2);color:#e8eaf0;border:1px solid rgba(99,102,241,0.25);border-radius:12px 4px 12px 12px;}
.ia-msg-bubble pre{background:#13151f;border-radius:6px;padding:8px;font-size:12px;overflow-x:auto;margin-top:6px;}
.ia-typing{display:flex;gap:5px;align-items:center;padding:10px 14px;}
.ia-dot{width:7px;height:7px;border-radius:50%;background:#6366f1;animation:bounce .8s infinite;}
.ia-dot:nth-child(2){animation-delay:.15s;}
.ia-dot:nth-child(3){animation-delay:.3s;}
@keyframes bounce{0%,60%,100%{transform:translateY(0);}30%{transform:translateY(-6px);}}

/* ── Input chat ── */
.ia-input-wrap{padding:12px 16px;border-top:1px solid rgba(255,255,255,0.06);background:#13151f;display:flex;gap:8px;align-items:center;}
.ia-input{flex:1;background:#252a3a;border:1px solid #444860;color:#e8eaf0;border-radius:10px;padding:10px 14px;font-size:13px;resize:none;min-height:42px;max-height:120px;overflow-y:auto;}
.ia-input:focus{border-color:#6366f1;outline:none;}
.ia-send-btn{width:42px;height:42px;border-radius:10px;background:linear-gradient(135deg,#6366f1,#4f46e5);border:none;color:#fff;cursor:pointer;display:flex;align-items:center;justify-content:center;font-size:18px;flex-shrink:0;transition:all .15s;}
.ia-send-btn:hover{transform:scale(1.05);box-shadow:0 4px 12px rgba(99,102,241,0.4);}
.ia-send-btn:disabled{opacity:.4;cursor:default;transform:none;}

/* ── Sugestões rápidas ── */
.ia-chips{display:flex;flex-wrap:wrap;gap:6px;padding:10px 16px;border-top:1px solid rgba(255,255,255,0.04);}
.ia-chip{display:inline-flex;align-items:center;gap:5px;padding:5px 11px;border-radius:20px;background:rgba(99,102,241,0.1);border:1px solid rgba(99,102,241,0.25);color:#a5b4fc;font-size:11px;font-weight:600;cursor:pointer;transition:all .15s;white-space:nowrap;}
.ia-chip:hover{background:rgba(99,102,241,0.2);}

/* ── Ferramentas lado esquerdo ── */
.ia-tool-btn{display:flex;align-items:center;gap:10px;padding:10px 12px;border-radius:10px;border:1px solid rgba(255,255,255,0.07);background:#13151f;cursor:pointer;transition:all .15s;margin-bottom:8px;width:100%;text-align:left;}
.ia-tool-btn:hover{border-color:#6366f1;background:rgba(99,102,241,0.08);}
.ia-tool-btn i{font-size:18px;flex-shrink:0;}
.ia-tool-btn .tl{font-size:13px;font-weight:700;color:#e8eaf0;}
.ia-tool-btn .td{font-size:11px;color:#6b7280;margin-top:1px;}

/* ── Busca ── */
.ia-search-input{width:100%;background:#13151f;border:1px solid #444860;color:#e8eaf0;border-radius:8px;padding:9px 12px;font-size:13px;margin-bottom:8px;}
.ia-search-input:focus{border-color:#6366f1;outline:none;}
.ia-search-result{background:#252a3a;border:1px solid rgba(255,255,255,0.06);border-radius:10px;padding:10px 12px;margin-bottom:6px;cursor:pointer;transition:background .12s;}
.ia-search-result:hover{background:#2d3247;}
.ia-search-result .sr-title{font-size:13px;font-weight:600;color:#e8eaf0;}
.ia-search-result .sr-sub{font-size:11px;color:#9ca3af;margin-top:2px;}
.ia-search-result .sr-badge{display:inline-block;padding:1px 8px;border-radius:10px;font-size:10px;font-weight:700;margin-top:4px;}
.ia-no-result{text-align:center;padding:16px;color:#6b7280;font-size:13px;}
</style>

<div class="ia-wrap new122">

    <div class="ia-header">
        <div class="ia-title">
            <i class='bx bx-bot'></i>
            <h2>Assistente Sisos IA</h2>
        </div>
        <?php
        $iaProvR=$this->db->where('config','ia_provedor')->get('configuracoes')->row();
        $iaProv=$iaProvR?($iaProvR->valor?:'gemini'):'gemini';
        $modelMap=['gemini'=>'gemini_model','openai'=>'openai_model','claude'=>'claude_model','perplexity'=>'perplexity_model','deepseek'=>'deepseek_model','mistral'=>'mistral_model'];
        $modelR=$this->db->where('config',$modelMap[$iaProv]??'gemini_model')->get('configuracoes')->row();
        $modelName=$modelR?($modelR->valor?:'—'):'—';
        $provLabels=['gemini'=>['🔵','Gemini','#4285f4'],'openai'=>['🟢','ChatGPT','#10a37f'],'claude'=>['🟠','Claude','#d97706'],'perplexity'=>['🔴','Perplexity','#ef4444'],'deepseek'=>['🟣','DeepSeek','#8b5cf6'],'mistral'=>['⚪','Mistral','#9ca3af']];
        [$pIcon,$pName,$pColor]=$provLabels[$iaProv]??['🤖','IA','#6366f1'];
        ?>
        <div style="display:flex;gap:8px;align-items:center;flex-wrap:wrap;">
            <span id="iaProvBadge" style="font-size:12px;font-weight:700;padding:4px 12px;border-radius:20px;border:1px solid;color:<?= $pColor ?>;border-color:<?= $pColor ?>33;background:<?= $pColor ?>15;">
                <?= $pIcon ?> <?= $pName ?>
            </span>
            <span style="font-size:11px;color:#6b7280;background:rgba(255,255,255,0.05);padding:3px 10px;border-radius:20px;border:1px solid rgba(255,255,255,0.07);">
                <i class='bx bx-chip' style="font-size:10px;"></i> <span id="iaModelName"><?= htmlspecialchars($modelName) ?></span>
            </span>
            <a href="<?= site_url('sisos/configurar') ?>" style="font-size:11px;color:#6b7280;padding:3px 8px;border-radius:20px;border:1px solid rgba(255,255,255,0.07);text-decoration:none;">
                <i class='bx bx-cog'></i> Configurar
            </a>
        </div>
    </div>

    <!-- Seletor rápido de provedor -->
    <?php
    $provsAll = [
        'gemini'     => ['🔵','Gemini',    '#4285f4','gemini_api_key'],
        'openai'     => ['🟢','ChatGPT',   '#10a37f','openai_api_key'],
        'claude'     => ['🟠','Claude',    '#d97706','claude_api_key'],
        'perplexity' => ['🔴','Perplexity','#ef4444','perplexity_api_key'],
        'deepseek'   => ['🟣','DeepSeek',  '#8b5cf6','deepseek_api_key'],
        'mistral'    => ['⚪','Mistral',   '#9ca3af','mistral_api_key'],
    ];
    ?>
    <div class="ia-card" style="margin-bottom:14px;">
        <div class="ia-card-head"><i class='bx bx-network-chart' style="color:#a78bfa;"></i><span>Provedor de IA Ativo</span></div>
        <div class="ia-prov-switcher" id="iaProvSwitcher">
            <?php foreach ($provsAll as $pKey => [$pIco,$pLbl,$pClr,$pCfg]):
                $keyR2 = $this->db->where('config',$pCfg)->get('configuracoes')->row();
                $hasKey2 = $keyR2 && !empty($keyR2->valor);
                $isActive = ($iaProv === $pKey);
                $btnClass = 'ia-prov-btn' . ($isActive?' active':'') . (!$hasKey2?' disabled-prov':'');
                $btnStyle = $isActive ? "background:{$pClr};border-color:{$pClr};" : '';
            ?>
            <button class="<?= $btnClass ?>"
                    data-prov="<?= $pKey ?>"
                    data-color="<?= $pClr ?>"
                    data-label="<?= $pIco ?> <?= $pLbl ?>"
                    data-haskey="<?= $hasKey2?'1':'0' ?>"
                    style="<?= $btnStyle ?>"
                    onclick="trocarProvedor('<?= $pKey ?>','<?= $pClr ?>','<?= $pIco ?> <?= $pLbl ?>',<?= $hasKey2?'true':'false' ?>)">
                <?= $pIco ?> <?= $pLbl ?>
            </button>
            <?php endforeach; ?>
            <a href="<?= site_url('sisos/configurar') ?>#tabGemini" style="margin-left:auto;font-size:11px;color:#6b7280;align-self:center;text-decoration:none;">
                <i class='bx bx-key'></i> Gerenciar chaves
            </a>
        </div>
        <div class="ia-no-key" id="iaNokeyWarning">
            <i class='bx bx-error-circle'></i> Este provedor não tem chave API configurada. <a href="<?= site_url('sisos/configurar') ?>" style="color:#fca5a5;text-decoration:underline;">Configurar agora</a>
        </div>
    </div>

    <div class="ia-grid">

        <!-- ══ COLUNA ESQUERDA ══ -->
        <div>

            <!-- Busca do Sistema -->
            <div class="ia-card">
                <div class="ia-card-head">
                    <i class='bx bx-search' style="color:#fbbf24;"></i>
                    <span>Busca Rápida no Sistema</span>
                </div>
                <div class="ia-card-body">
                    <input type="text" id="iaSearchInput" class="ia-search-input" placeholder="Buscar cliente, OS, produto..." autocomplete="off">
                    <div id="iaSearchResults" style="max-height:220px;overflow-y:auto;"></div>
                </div>
            </div>

            <!-- Ferramentas IA -->
            <div class="ia-card">
                <div class="ia-card-head">
                    <i class='bx bx-rocket' style="color:#a78bfa;"></i>
                    <span>Ferramentas com IA</span>
                </div>
                <div class="ia-card-body">
                    <button class="ia-tool-btn" onclick="iaTool('resumo_dia')">
                        <i class='bx bx-bar-chart-alt-2' style="color:#fbbf24;"></i>
                        <div><div class="tl">Resumo do Dia</div><div class="td">OS, financeiro e alertas de hoje</div></div>
                    </button>
                    <button class="ia-tool-btn" onclick="iaTool('os_abertas')">
                        <i class='bx bx-file' style="color:#60a5fa;"></i>
                        <div><div class="tl">Status das OS Abertas</div><div class="td">Situação atual das ordens</div></div>
                    </button>
                    <button class="ia-tool-btn" onclick="iaTool('estoque_critico')">
                        <i class='bx bx-error' style="color:#f87171;"></i>
                        <div><div class="tl">Alertas de Estoque</div><div class="td">Produtos abaixo do mínimo</div></div>
                    </button>
                    <button class="ia-tool-btn" onclick="iaTool('inadimplentes')">
                        <i class='bx bx-dollar' style="color:#fbbf24;"></i>
                        <div><div class="tl">Cobranças Vencidas</div><div class="td">Clientes com pagamento em atraso</div></div>
                    </button>
                    <button class="ia-tool-btn" onclick="iaTool('sugestao_os')">
                        <i class='bx bx-bulb' style="color:#4ade80;"></i>
                        <div><div class="tl">Diagnóstico de OS</div><div class="td">IA sugere diagnóstico técnico</div></div>
                    </button>
                </div>
            </div>

            <!-- Atalhos do sistema -->
            <div class="ia-card">
                <div class="ia-card-head">
                    <i class='bx bx-link' style="color:#60a5fa;"></i>
                    <span>Atalhos Rápidos</span>
                </div>
                <div class="ia-card-body" style="display:grid;grid-template-columns:1fr 1fr;gap:6px;">
                    <?php
                    $atalhos = [
                        ['os/adicionar','bx-plus','Nova OS','#22c55e'],
                        ['clientes/adicionar','bx-user-plus','Novo Cliente','#3b82f6'],
                        ['financeiro/lancamentos','bx-bar-chart-alt-2','Lançamentos','#fbbf24'],
                        ['relatorios/os','bx-file','Rel. OS','#f97316'],
                        ['produtos','bx-package','Produtos','#8b5cf6'],
                        ['financeiro/dashboard','bx-wallet','Financeiro','#06b6d4'],
                    ];
                    foreach ($atalhos as $a):
                    ?>
                    <a href="<?= site_url($a[0]) ?>" style="display:flex;align-items:center;gap:7px;padding:8px 10px;border-radius:8px;background:#13151f;border:1px solid rgba(255,255,255,0.06);text-decoration:none;transition:all .12s;" onmouseover="this.style.borderColor='<?= $a[3] ?>33'" onmouseout="this.style.borderColor='rgba(255,255,255,0.06)'">
                        <i class='bx <?= $a[1] ?>' style="font-size:16px;color:<?= $a[3] ?>;flex-shrink:0;"></i>
                        <span style="font-size:12px;font-weight:600;color:#c9cad6;"><?= $a[2] ?></span>
                    </a>
                    <?php endforeach; ?>
                </div>
            </div>

        </div>

        <!-- ══ COLUNA DIREITA: CHAT ══ -->
        <div class="ia-card" style="margin-bottom:0;">
            <div class="ia-card-head">
                <i class='bx bx-chat' style="color:#a78bfa;"></i>
                <span>Chat com Assistente IA</span>
                <button onclick="limparChat()" style="margin-left:auto;background:rgba(255,255,255,0.07);border:1px solid rgba(255,255,255,0.1);color:#6b7280;border-radius:6px;padding:3px 10px;font-size:11px;cursor:pointer;" title="Limpar conversa">
                    <i class='bx bx-trash'></i> Limpar
                </button>
            </div>
            <div class="ia-chat-wrap">
                <div class="ia-messages" id="iaChatMessages">
                    <div class="ia-msg">
                        <div class="ia-msg-avatar ia-msg-avatar-bot"><i class='bx bx-bot'></i></div>
                        <div class="ia-msg-bubble ia-msg-bubble-bot">
                            Olá, <strong><?= htmlspecialchars($this->session->userdata('nome_admin') ?: 'Técnico') ?></strong>! 👋<br><br>
                            Sou o assistente inteligente do <strong>Sisos</strong>. Posso ajudar com:<br>
                            • Perguntas sobre OS, clientes e financeiro<br>
                            • Diagnósticos técnicos de equipamentos<br>
                            • Resumos e relatórios rápidos<br>
                            • Dúvidas sobre o sistema<br><br>
                            Use as <strong>ferramentas</strong> ao lado ou me faça uma pergunta!
                        </div>
                    </div>
                </div>

                <!-- Sugestões -->
                <div class="ia-chips">
                    <span class="ia-chip" onclick="iaEnviar('Quantas OS estão abertas hoje?')"><i class='bx bx-file'></i> OS abertas</span>
                    <span class="ia-chip" onclick="iaEnviar('Quais produtos estão com estoque crítico?')"><i class='bx bx-error'></i> Estoque baixo</span>
                    <span class="ia-chip" onclick="iaEnviar('Qual o resumo financeiro deste mês?')"><i class='bx bx-dollar'></i> Financeiro</span>
                    <span class="ia-chip" onclick="iaEnviar('Quais clientes têm cobranças vencidas?')"><i class='bx bx-time'></i> Inadimplência</span>
                </div>

                <!-- Input -->
                <div class="ia-input-wrap">
                    <textarea id="iaInput" class="ia-input" placeholder="Pergunte algo ao assistente..." rows="1"></textarea>
                    <button id="iaSendBtn" class="ia-send-btn" onclick="iaEnviarInput()">
                        <i class='bx bx-send'></i>
                    </button>
                </div>
            </div>
        </div>

    </div>
</div>

<!-- Modal diagnóstico OS -->
<div id="modalDiagnostico" style="display:none;position:fixed;inset:0;background:rgba(0,0,0,0.7);z-index:9999;align-items:center;justify-content:center;padding:20px;">
    <div style="background:#1a1d2e;border:1px solid rgba(255,255,255,0.1);border-radius:16px;max-width:500px;width:100%;padding:24px;">
        <h3 style="color:#e8eaf0;font-size:16px;font-weight:800;margin-bottom:14px;display:flex;align-items:center;gap:8px;">
            <i class='bx bx-bulb' style="color:#4ade80;"></i> Diagnóstico por IA
        </h3>
        <label style="font-size:11px;font-weight:700;color:#9ca3af;text-transform:uppercase;letter-spacing:.5px;display:block;margin-bottom:5px;">Número da OS</label>
        <div style="display:flex;gap:8px;margin-bottom:14px;">
            <input type="number" id="diagOsId" placeholder="Ex: 42" style="flex:1;background:#13151f;border:1px solid #444860;color:#e8eaf0;border-radius:8px;padding:9px 12px;font-size:13px;">
            <button onclick="enviarDiagnostico()" style="padding:9px 18px;background:linear-gradient(135deg,#22c55e,#16a34a);color:#fff;border:none;border-radius:8px;font-size:13px;font-weight:700;cursor:pointer;">
                <i class='bx bx-send'></i> Analisar
            </button>
        </div>
        <div id="diagResult" style="background:#13151f;border-radius:10px;padding:12px;font-size:13px;color:#c9cad6;min-height:60px;display:none;max-height:300px;overflow-y:auto;line-height:1.7;"></div>
        <div style="display:flex;justify-content:flex-end;margin-top:14px;">
            <button onclick="document.getElementById('modalDiagnostico').style.display='none'" style="padding:8px 16px;background:rgba(255,255,255,0.07);color:#9ca3af;border:1px solid rgba(255,255,255,0.1);border-radius:8px;font-size:13px;font-weight:700;cursor:pointer;">
                Fechar
            </button>
        </div>
    </div>
</div>

<script>
var iaHistorico = [];
var BASE = '<?= base_url() ?>';

// ── Enviar mensagem ─────────────────────────────────
function iaEnviar(msg) {
    if (!msg.trim()) return;
    document.getElementById('iaInput').value = '';
    adicionarMensagem('user', msg);
    mostrarTyping();
    iaHistorico.push({role:'user', content:msg});

    $.post(BASE+'index.php/sisos/chatGemini', {
        mensagem: msg,
        '<?= $this->security->get_csrf_token_name() ?>': '<?= $this->security->get_csrf_hash() ?>'
    }, function(data) {
        removerTyping();
        if (data.ok) {
            adicionarMensagem('bot', data.resposta);
            iaHistorico.push({role:'bot', content:data.resposta});
        } else {
            adicionarMensagem('bot', '⚠️ ' + (data.erro || 'Erro desconhecido.'));
        }
    }, 'json').fail(function() {
        removerTyping();
        adicionarMensagem('bot', '⚠️ Falha de conexão. Tente novamente.');
    });
}

function iaEnviarInput() {
    var msg = document.getElementById('iaInput').value.trim();
    if (msg) iaEnviar(msg);
}

// ── Adicionar mensagem no chat ──────────────────────
function adicionarMensagem(tipo, texto) {
    var chat = document.getElementById('iaChatMessages');
    var isBot = tipo === 'bot';
    var html = '<div class="ia-msg '+(isBot?'':'ia-msg-user')+'">'
        + '<div class="ia-msg-avatar '+(isBot?'ia-msg-avatar-bot':'ia-msg-avatar-user')+'">'
        + (isBot?'<i class=\'bx bx-bot\'></i>':'<i class=\'bx bx-user\'></i>')
        + '</div>'
        + '<div class="ia-msg-bubble '+(isBot?'ia-msg-bubble-bot':'ia-msg-bubble-user')+'">'
        + formatarTexto(texto)
        + '</div></div>';
    chat.insertAdjacentHTML('beforeend', html);
    chat.scrollTop = chat.scrollHeight;
}

function formatarTexto(t) {
    // Bold **text** e *text*
    t = t.replace(/\*\*(.*?)\*\*/g,'<strong>$1</strong>');
    t = t.replace(/\*(.*?)\*/g,'<em>$1</em>');
    // Código `code`
    t = t.replace(/`([^`]+)`/g,'<code style="background:#13151f;padding:1px 5px;border-radius:4px;font-size:12px;">$1</code>');
    // Listas com •
    t = t.replace(/^[•\-] (.+)$/gm,'<span style="display:block;padding-left:10px;">• $1</span>');
    // Quebras de linha
    t = t.replace(/\n/g,'<br>');
    return t;
}

function mostrarTyping() {
    var chat = document.getElementById('iaChatMessages');
    chat.insertAdjacentHTML('beforeend','<div class="ia-msg" id="iaTyping"><div class="ia-msg-avatar ia-msg-avatar-bot"><i class=\'bx bx-bot\'></i></div><div class="ia-msg-bubble ia-msg-bubble-bot"><div class="ia-typing"><span class="ia-dot"></span><span class="ia-dot"></span><span class="ia-dot"></span></div></div></div>');
    chat.scrollTop = chat.scrollHeight;
    document.getElementById('iaSendBtn').disabled = true;
}

function removerTyping() {
    var t = document.getElementById('iaTyping');
    if (t) t.remove();
    document.getElementById('iaSendBtn').disabled = false;
}

function limparChat() {
    iaHistorico = [];
    document.getElementById('iaChatMessages').innerHTML = '<div class="ia-msg"><div class="ia-msg-avatar ia-msg-avatar-bot"><i class=\'bx bx-bot\'></i></div><div class="ia-msg-bubble ia-msg-bubble-bot">Conversa reiniciada. Como posso ajudar?</div></div>';
}

// ── Enter para enviar ───────────────────────────────
document.getElementById('iaInput').addEventListener('keydown', function(e) {
    if (e.key === 'Enter' && !e.shiftKey) {
        e.preventDefault();
        iaEnviarInput();
    }
    // Auto resize
    this.style.height = 'auto';
    this.style.height = Math.min(this.scrollHeight, 120) + 'px';
});

// ── Ferramentas ─────────────────────────────────────
function iaTool(tipo) {
    var msgs = {
        resumo_dia: 'Faça um resumo completo do dia de hoje: quantas OS foram abertas, finalizadas e estão em andamento, e como está o financeiro do dia.',
        os_abertas: 'Liste o status atual de todas as OS abertas, agrupando por status e mostrando as mais urgentes ou atrasadas.',
        estoque_critico: 'Quais produtos estão com estoque abaixo do mínimo ou zerados? Liste os mais críticos.',
        inadimplentes: 'Quais clientes têm cobranças ou lançamentos vencidos? Liste por ordem de vencimento.',
        sugestao_os: null
    };
    if (tipo === 'sugestao_os') {
        document.getElementById('modalDiagnostico').style.display = 'flex';
        document.getElementById('diagResult').style.display = 'none';
        return;
    }
    if (msgs[tipo]) iaEnviar(msgs[tipo]);
}

// ── Diagnóstico por OS ──────────────────────────────
function enviarDiagnostico() {
    var id = document.getElementById('diagOsId').value.trim();
    if (!id) { alert('Informe o número da OS.'); return; }
    var res = document.getElementById('diagResult');
    res.style.display = 'block';
    res.innerHTML = '<div style="text-align:center;padding:14px;"><i class=\'bx bx-loader-alt bx-spin\' style=\'font-size:20px;color:#6366f1;\'></i></div>';

    $.post(BASE+'index.php/sisos/sugestaoGemini', {
        os_id: id,
        '<?= $this->security->get_csrf_token_name() ?>': '<?= $this->security->get_csrf_hash() ?>'
    }, function(data) {
        if (data.ok) {
            res.innerHTML = formatarTexto(data.resposta);
        } else {
            res.innerHTML = '<span style="color:#f87171;">⚠️ ' + (data.erro || 'Erro.') + '</span>';
        }
    }, 'json').fail(function() {
        res.innerHTML = '<span style="color:#f87171;">⚠️ Falha de conexão.</span>';
    });
}

function formatarTexto(t) {
    t = t.replace(/\*\*(.*?)\*\*/g,'<strong>$1</strong>');
    t = t.replace(/\*(.*?)\*/g,'<em>$1</em>');
    t = t.replace(/`([^`]+)`/g,'<code style="background:#252a3a;padding:1px 5px;border-radius:4px;font-size:12px;">$1</code>');
    t = t.replace(/^[•\-] (.+)$/gm,'<span style="display:block;padding-left:10px;">• $1</span>');
    t = t.replace(/\n/g,'<br>');
    return t;
}

// ── Busca no sistema ────────────────────────────────
var searchTimer;
$('#iaSearchInput').on('input', function() {
    clearTimeout(searchTimer);
    var q = $(this).val().trim();
    if (q.length < 2) { $('#iaSearchResults').html(''); return; }
    searchTimer = setTimeout(function() { iaBuscar(q); }, 350);
});

function iaBuscar(q) {
    var res = $('#iaSearchResults');
    res.html('<div style="text-align:center;padding:10px;color:#6b7280;font-size:12px;"><i class=\'bx bx-loader-alt bx-spin\'></i> Buscando...</div>');

    $.get(BASE+'index.php/sisos/buscaGlobal', { q: q }, function(data) {
        if (!data || (!data.clientes?.length && !data.os?.length && !data.produtos?.length)) {
            res.html('<div class="ia-no-result"><i class=\'bx bx-search-alt\' style=\'font-size:24px;display:block;opacity:.3;margin-bottom:6px;\'></i>Nenhum resultado para "'+q+'"</div>');
            return;
        }
        var html = '';
        if (data.clientes?.length) {
            data.clientes.slice(0,3).forEach(function(c) {
                html += '<a href="'+BASE+'index.php/clientes/visualizar/'+c.id+'" class="ia-search-result" style="text-decoration:none;display:block;">'
                    + '<div class="sr-title"><i class=\'bx bx-user\' style=\'color:#60a5fa;\'></i> '+c.nome+'</div>'
                    + '<div class="sr-sub">'+c.doc+'  '+c.tel+'</div>'
                    + '<span class="sr-badge" style="background:rgba(59,130,246,0.15);color:#60a5fa;">Cliente</span></a>';
            });
        }
        if (data.os?.length) {
            data.os.slice(0,3).forEach(function(o) {
                html += '<a href="'+BASE+'index.php/os/visualizar/'+o.id+'" class="ia-search-result" style="text-decoration:none;display:block;">'
                    + '<div class="sr-title"><i class=\'bx bx-file\' style=\'color:#fbbf24;\'></i> OS #'+String(o.id).padStart(4,'0')+'</div>'
                    + '<div class="sr-sub">'+o.cliente+' — '+o.status+'</div>'
                    + '<span class="sr-badge" style="background:rgba(251,191,36,0.15);color:#fbbf24;">OS</span></a>';
            });
        }
        if (data.produtos?.length) {
            data.produtos.slice(0,3).forEach(function(p) {
                html += '<a href="'+BASE+'index.php/produtos" class="ia-search-result" style="text-decoration:none;display:block;">'
                    + '<div class="sr-title"><i class=\'bx bx-package\' style=\'color:#a78bfa;\'></i> '+p.nome+'</div>'
                    + '<div class="sr-sub">Estoque: '+p.estoque+' | R$ '+p.preco+'</div>'
                    + '<span class="sr-badge" style="background:rgba(139,92,246,0.15);color:#c084fc;">Produto</span></a>';
            });
        }
        res.html(html);
    }, 'json').fail(function() {
        res.html('<div class="ia-no-result" style="color:#f87171;">Erro na busca.</div>');
    });
}

// ── Provider switcher ────────────────────────────
var _iaProvCurrent = '<?= $iaProv ?>';
var _iaProvColor   = '<?= $pColor ?>';

function trocarProvedor(prov, color, label, hasKey) {
    if (!hasKey) {
        document.getElementById('iaNokeyWarning').style.display = 'block';
        return;
    }
    document.getElementById('iaNokeyWarning').style.display = 'none';

    // Update buttons
    document.querySelectorAll('.ia-prov-btn').forEach(function(btn){
        btn.classList.remove('active');
        btn.style.background = '';
        btn.style.borderColor = '';
    });
    var activeBtn = document.querySelector('.ia-prov-btn[data-prov="'+prov+'"]');
    if (activeBtn) {
        activeBtn.classList.add('active');
        activeBtn.style.background = color;
        activeBtn.style.borderColor = color;
    }

    // Update badge
    var badge = document.getElementById('iaProvBadge');
    if (badge) {
        badge.textContent = label;
        badge.style.color = color;
        badge.style.borderColor = color + '33';
        badge.style.background = color + '15';
    }

    _iaProvCurrent = prov;

    // AJAX call to save
    $.post('<?= base_url() ?>index.php/sisos/trocarProvedor', {provedor: prov}, function(res){
        if (!res.ok) { alert('Erro ao trocar provedor: ' + res.erro); }
    }, 'json');
}
</script>
