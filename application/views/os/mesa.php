<style>
@keyframes mesaCardIn{from{opacity:0;transform:translateY(6px);}to{opacity:1;transform:translateY(0);}}
@keyframes mesaPulse{0%{transform:scale(1);}50%{transform:scale(1.15);}100%{transform:scale(1);}}

.mesa-header{display:flex;justify-content:space-between;align-items:center;margin-bottom:18px;flex-wrap:wrap;gap:10px;}
.mesa-title{font-size:22px;font-weight:800;color:#e8eaf0;display:flex;align-items:center;gap:10px;}
.mesa-title i{font-size:24px;background:linear-gradient(135deg,#a78bfa,#7c3aed);-webkit-background-clip:text;background-clip:text;color:transparent;}
.mesa-subtitle{font-size:13px;color:#6b7280;margin-top:2px;}
.mesa-link-lista{display:flex;align-items:center;gap:7px;padding:9px 16px;border-radius:8px;background:#1e2235;color:#c9cad6;font-size:13px;font-weight:700;text-decoration:none;border:1px solid rgba(255,255,255,0.08);transition:all .15s;}
.mesa-link-lista:hover{background:#252a3a;color:#e8eaf0;transform:translateY(-1px);}

.mesa-board{display:flex;gap:14px;overflow-x:auto;padding:2px 2px 14px;align-items:flex-start;}
.mesa-col{background:#161925;border:1px solid rgba(255,255,255,0.07);border-radius:14px;min-width:280px;max-width:300px;flex-shrink:0;display:flex;flex-direction:column;max-height:calc(100vh - 220px);overflow:hidden;position:relative;}
.mesa-col::before{content:'';position:absolute;top:0;left:0;right:0;height:3px;background:var(--col-accent,#a78bfa);}
.mesa-col-head{display:flex;align-items:center;gap:9px;padding:14px 14px 12px;border-bottom:1px solid rgba(255,255,255,0.07);}
.mesa-col-icon{width:26px;height:26px;border-radius:8px;display:flex;align-items:center;justify-content:center;font-size:14px;background:var(--col-accent-bg,rgba(167,139,250,0.15));color:var(--col-accent,#a78bfa);flex-shrink:0;}
.mesa-col-titulo{font-size:12.5px;font-weight:700;color:#e8eaf0;text-transform:uppercase;letter-spacing:.4px;flex:1;}
.mesa-col-count{background:var(--col-accent-bg,rgba(167,139,250,0.15));color:var(--col-accent,#a78bfa);font-size:11px;font-weight:800;padding:2px 9px;border-radius:20px;transition:transform .2s;}
.mesa-col-count.pulsando{animation:mesaPulse .4s ease;}
.mesa-col-body{padding:10px;overflow-y:auto;flex:1;display:flex;flex-direction:column;gap:10px;min-height:80px;transition:background .15s;}
.mesa-col-body.drag-over{background:var(--col-accent-bg,rgba(167,139,250,0.08));box-shadow:inset 0 0 0 2px var(--col-accent,#a78bfa);border-radius:0 0 13px 13px;}
.mesa-col-empty{text-align:center;color:#4b5563;font-size:12px;padding:26px 10px;display:flex;flex-direction:column;align-items:center;gap:6px;}
.mesa-col-empty i{font-size:26px;opacity:.4;}

.mesa-card{background:#1e2235;border:1px solid rgba(255,255,255,0.08);border-left:3px solid var(--idade-cor,#444860);border-radius:11px;padding:12px;cursor:grab;transition:transform .15s,border-color .15s,box-shadow .15s;position:relative;animation:mesaCardIn .25s ease both;}
.mesa-card:active{cursor:grabbing;}
.mesa-card:hover{border-color:rgba(167,139,250,0.35);box-shadow:0 8px 20px rgba(0,0,0,0.3);transform:translateY(-2px);}
.mesa-card.dragging{opacity:0.35;transform:scale(0.97);}
.mesa-card-top{display:flex;align-items:center;justify-content:space-between;margin-bottom:6px;}
.mesa-num{font-size:11px;color:#6b7280;font-weight:700;}
.mesa-menu-btn{background:none;border:none;color:#6b7280;cursor:pointer;font-size:16px;padding:2px 6px;border-radius:6px;transition:background .12s;}
.mesa-menu-btn:hover{background:rgba(255,255,255,0.08);color:#e8eaf0;}
.mesa-cliente{font-size:13.5px;font-weight:700;color:#e8eaf0;margin-bottom:2px;}
.mesa-equip{font-size:11.5px;color:#9ca3af;margin-bottom:8px;display:flex;align-items:center;gap:5px;}
.mesa-foot{display:flex;align-items:center;justify-content:space-between;font-size:11.5px;padding-top:8px;border-top:1px solid rgba(255,255,255,0.06);}
.mesa-total{font-weight:800;color:#4ade80;}
.mesa-data{color:#6b7280;display:flex;align-items:center;gap:4px;}

.mesa-dropdown{position:absolute;top:32px;right:8px;background:#252a3a;border:1px solid rgba(255,255,255,0.1);border-radius:10px;box-shadow:0 10px 30px rgba(0,0,0,0.45);z-index:20;min-width:170px;display:none;overflow:hidden;}
.mesa-dropdown.aberto{display:block;}
.mesa-dropdown a{display:flex;align-items:center;gap:9px;padding:9px 14px;font-size:12.5px;color:#c9cad6;text-decoration:none;transition:background .12s;}
.mesa-dropdown a:hover{background:rgba(167,139,250,0.1);color:#e8eaf0;}
.mesa-dropdown a.perigo:hover{background:rgba(239,68,68,0.12);color:#f87171;}
.mesa-dropdown hr{border:none;border-top:1px solid rgba(255,255,255,0.07);margin:4px 0;}

.mesa-prioridade-tag{position:absolute;top:-8px;left:10px;font-size:9.5px;font-weight:800;padding:2px 8px;border-radius:20px;display:flex;align-items:center;gap:3px;z-index:5;}
.mesa-prio-alta{background:#ef4444;color:#fff;}
.mesa-prio-baixa{background:#374151;color:#9ca3af;}
.mesa-dd-secao{padding:8px 14px 4px;font-size:9.5px;font-weight:800;color:#6b7280;text-transform:uppercase;letter-spacing:.6px;}
.mesa-prio-grupo{display:flex;gap:4px;padding:0 10px 6px;}
.mesa-prio-btn{flex:1;background:#1e2235;border:1px solid rgba(255,255,255,0.08);color:#9ca3af;font-size:11px;font-weight:700;padding:6px 4px;border-radius:7px;cursor:pointer;transition:all .12s;}
.mesa-prio-btn:hover{background:#252a3a;}
.mesa-prio-btn.ativo{background:rgba(167,139,250,0.18);border-color:rgba(167,139,250,0.4);color:#a78bfa;}

.mesa-board::-webkit-scrollbar{height:8px;}
.mesa-board::-webkit-scrollbar-thumb{background:#2e3447;border-radius:10px;}
.mesa-col-body::-webkit-scrollbar{width:6px;}
.mesa-col-body::-webkit-scrollbar-thumb{background:#2e3447;border-radius:10px;}

.mesa-aviso-overlay{position:fixed;inset:0;background:rgba(0,0,0,0.6);z-index:1000;display:flex;align-items:center;justify-content:center;padding:20px;}
.mesa-aviso-card{background:#1a1d2e;border:1px solid rgba(255,255,255,0.1);border-radius:16px;max-width:380px;width:100%;padding:22px;box-shadow:0 20px 50px rgba(0,0,0,0.5);}
.mesa-aviso-topo{font-size:16px;font-weight:800;color:#4ade80;margin-bottom:12px;}
.mesa-aviso-cliente{font-size:15px;font-weight:700;color:#e8eaf0;}
.mesa-aviso-os{font-size:12px;color:#9ca3af;margin-bottom:14px;}
.mesa-aviso-label{font-size:10px;font-weight:800;color:#6b7280;text-transform:uppercase;letter-spacing:.6px;margin-bottom:6px;}
.mesa-aviso-msg{background:#161925;border-radius:10px;padding:12px 14px;font-size:12.5px;color:#c9cad6;line-height:1.5;margin-bottom:16px;max-height:160px;overflow-y:auto;}
.mesa-aviso-btns{display:flex;gap:8px;flex-wrap:wrap;}
.mesa-aviso-btn{flex:1;min-width:100px;padding:10px 12px;border-radius:9px;font-size:12.5px;font-weight:700;border:none;cursor:pointer;}
.mesa-aviso-cancelar{background:rgba(255,255,255,0.06);color:#9ca3af;}
.mesa-aviso-contatar{background:rgba(96,165,250,0.15);color:#60a5fa;}
.mesa-aviso-avisar{background:linear-gradient(135deg,#22c55e,#16a34a);color:#fff;}
</style>

<div class="new122">
    <div class="mesa-header">
        <div>
            <div class="mesa-title"><i class='bx bx-grid-alt'></i> Mesa de Trabalho</div>
            <div class="mesa-subtitle">Arraste os cards entre as colunas para mudar o status da OS</div>
        </div>
        <a href="<?= site_url('os/gerenciar') ?>" class="mesa-link-lista"><i class='bx bx-list-ul'></i> Ver como lista</a>
    </div>

    <div class="mesa-board">
        <?php
        $colCores = [
            'novo'     => ['cor' => '#60a5fa', 'bg' => 'rgba(96,165,250,0.15)',  'icone' => 'bx-file-blank'],
            'peca'     => ['cor' => '#f59e0b', 'bg' => 'rgba(245,158,11,0.15)',  'icone' => 'bx-package'],
            'servico'  => ['cor' => '#a78bfa', 'bg' => 'rgba(167,139,250,0.15)', 'icone' => 'bx-wrench'],
            'pronto'   => ['cor' => '#22c55e', 'bg' => 'rgba(34,197,94,0.15)',   'icone' => 'bx-check-circle'],
            'entregue' => ['cor' => '#22d3ee', 'bg' => 'rgba(6,182,212,0.15)',   'icone' => 'bx-check-double'],
        ];
        foreach ($colunas as $chave => $coluna):
            $cc = $colCores[$chave] ?? ['cor' => '#a78bfa', 'bg' => 'rgba(167,139,250,0.15)', 'icone' => 'bx-folder'];
        ?>
        <div class="mesa-col" style="--col-accent:<?= $cc['cor'] ?>;--col-accent-bg:<?= $cc['bg'] ?>;">
            <div class="mesa-col-head">
                <div class="mesa-col-icon"><i class='bx <?= $cc['icone'] ?>'></i></div>
                <span class="mesa-col-titulo"><?= htmlspecialchars($coluna['titulo']) ?></span>
                <span class="mesa-col-count" id="count-<?= $chave ?>"><?= count($coluna['itens']) ?></span>
            </div>
            <div class="mesa-col-body" data-coluna="<?= $chave ?>" data-status="<?= htmlspecialchars($coluna['statusRepresentativo']) ?>">
                <?php if (empty($coluna['itens'])): ?>
                <div class="mesa-col-empty"><i class='bx bx-inbox'></i>Nenhuma OS aqui</div>
                <?php else: foreach ($coluna['itens'] as $os):
                    $diasAberta = $os->dataInicial ? (int)floor((time() - strtotime($os->dataInicial)) / 86400) : 0;
                    if ($diasAberta <= 2) $idadeCor = '#22c55e';
                    elseif ($diasAberta <= 6) $idadeCor = '#f59e0b';
                    else $idadeCor = '#ef4444';
                ?>
                <div class="mesa-card" draggable="true" data-id="<?= $os->idOs ?>" style="--idade-cor:<?= $idadeCor ?>;">
                    <?php if (($os->prioridade ?? 'normal') === 'alta'): ?>
                    <div class="mesa-prioridade-tag mesa-prio-alta"><i class='bx bx-error'></i> Alta</div>
                    <?php elseif (($os->prioridade ?? 'normal') === 'baixa'): ?>
                    <div class="mesa-prioridade-tag mesa-prio-baixa">Baixa</div>
                    <?php endif; ?>
                    <div class="mesa-card-top">
                        <span class="mesa-num">#<?= str_pad($os->idOs, 4, '0', STR_PAD_LEFT) ?></span>
                        <button type="button" class="mesa-menu-btn" onclick="mesaToggleMenu(event, <?= $os->idOs ?>)"><i class='bx bx-dots-vertical-rounded'></i></button>
                        <div class="mesa-dropdown" id="menu-<?= $os->idOs ?>">
                            <a href="<?= base_url() ?>index.php/os/visualizar/<?= $os->idOs ?>"><i class='bx bx-show'></i> Ver OS</a>
                            <?php if ($this->permission->checkPermission($this->session->userdata('permissao'), 'eOs')): ?>
                            <a href="<?= base_url() ?>index.php/os/editar/<?= $os->idOs ?>"><i class='bx bx-edit'></i> Editar OS</a>
                            <?php endif; ?>
                            <a href="<?= base_url() ?>index.php/os/imprimir/<?= $os->idOs ?>" target="_blank"><i class='bx bx-printer'></i> Imprimir PDF</a>

                            <?php if ($this->permission->checkPermission($this->session->userdata('permissao'), 'eOs')): ?>
                            <div class="mesa-dd-secao">PRIORIDADE</div>
                            <div class="mesa-prio-grupo">
                                <button type="button" class="mesa-prio-btn <?= ($os->prioridade ?? 'normal') === 'baixa' ? 'ativo' : '' ?>" onclick="mesaMudarPrioridade(event, <?= $os->idOs ?>, 'baixa')">Baixa</button>
                                <button type="button" class="mesa-prio-btn <?= ($os->prioridade ?? 'normal') === 'normal' ? 'ativo' : '' ?>" onclick="mesaMudarPrioridade(event, <?= $os->idOs ?>, 'normal')">Normal</button>
                                <button type="button" class="mesa-prio-btn <?= ($os->prioridade ?? 'normal') === 'alta' ? 'ativo' : '' ?>" onclick="mesaMudarPrioridade(event, <?= $os->idOs ?>, 'alta')">Alta</button>
                            </div>

                            <hr>
                            <a href="#" onclick="mesaAvancarStatus(event, <?= $os->idOs ?>);return false;"><i class='bx bx-right-arrow-circle' style="color:#60a5fa;"></i> Avançar Status</a>
                            <a href="#" onclick="mesaArquivar(event, <?= $os->idOs ?>);return false;"><i class='bx bx-archive' style="color:#f59e0b;"></i> Arquivar</a>
                            <?php endif; ?>

                            <?php if ($this->permission->checkPermission($this->session->userdata('permissao'), 'dOs')): ?>
                            <hr>
                            <a href="#" class="perigo" onclick="mesaExcluir(<?= $os->idOs ?>);return false;"><i class='bx bx-trash-alt'></i> Excluir</a>
                            <?php endif; ?>
                        </div>
                    </div>
                    <div class="mesa-cliente"><?= htmlspecialchars($os->nomeCliente ?? '—') ?></div>
                    <?php if (!empty($os->equipamento)): ?>
                    <div class="mesa-equip"><i class='bx bx-devices'></i> <?= htmlspecialchars($os->equipamento) ?></div>
                    <?php endif; ?>
                    <div class="mesa-foot">
                        <span class="mesa-total">R$ <?= number_format($os->totalProdutos + $os->totalServicos, 2, ',', '.') ?></span>
                        <span class="mesa-data" title="<?= $diasAberta ?> dia(s) nesta etapa"><i class='bx bx-time-five' style="color:<?= $idadeCor ?>;"></i> <?= $os->dataInicial ? date('d/m/Y', strtotime($os->dataInicial)) : '-' ?></span>
                    </div>
                </div>
                <?php endforeach; endif; ?>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
</div>

<!-- Modal Excluir (reaproveita a rota que já existe) -->
<form id="formMesaExcluir" action="<?= base_url() ?>index.php/os/excluir" method="post" style="display:none;">
    <input type="hidden" id="mesaIdExcluir" name="id" value="">
</form>

<script>
function mesaToggleMenu(ev, id) {
    ev.stopPropagation();
    document.querySelectorAll('.mesa-dropdown.aberto').forEach(function(el) {
        if (el.id !== 'menu-' + id) el.classList.remove('aberto');
    });
    document.getElementById('menu-' + id).classList.toggle('aberto');
}
document.addEventListener('click', function() {
    document.querySelectorAll('.mesa-dropdown.aberto').forEach(function(el) { el.classList.remove('aberto'); });
});

function mesaMostrarAvisoCliente(aviso, aoFechar) {
    var overlay = document.createElement('div');
    overlay.className = 'mesa-aviso-overlay';
    overlay.innerHTML =
        '<div class="mesa-aviso-card">' +
            '<div class="mesa-aviso-topo">🎉 Aparelho Pronto!</div>' +
            '<div class="mesa-aviso-cliente">' + aviso.cliente + '</div>' +
            '<div class="mesa-aviso-os">OS #' + aviso.osNum + (aviso.equipamento ? ' · ' + aviso.equipamento : '') + '</div>' +
            '<div class="mesa-aviso-label">PRÉVIA DA MENSAGEM</div>' +
            '<div class="mesa-aviso-msg">' + aviso.mensagem.replace(/\n/g, '<br>') + '</div>' +
            '<div class="mesa-aviso-btns">' +
                '<button type="button" class="mesa-aviso-btn mesa-aviso-cancelar">Cancelar</button>' +
                '<button type="button" class="mesa-aviso-btn mesa-aviso-contatar">Apenas Contatar</button>' +
                '<button type="button" class="mesa-aviso-btn mesa-aviso-avisar">Avisar Cliente</button>' +
            '</div>' +
        '</div>';
    document.body.appendChild(overlay);

    function fechar() {
        overlay.remove();
        if (aoFechar) aoFechar();
    }

    overlay.querySelector('.mesa-aviso-cancelar').addEventListener('click', fechar);
    overlay.querySelector('.mesa-aviso-contatar').addEventListener('click', function() {
        if (aviso.telefone) window.open('https://api.whatsapp.com/send?phone=55' + aviso.telefone, '_blank');
        fechar();
    });
    overlay.querySelector('.mesa-aviso-avisar').addEventListener('click', function() {
        if (aviso.telefone) {
            window.open('https://api.whatsapp.com/send?phone=55' + aviso.telefone + '&text=' + encodeURIComponent(aviso.mensagem), '_blank');
        } else {
            alert('Este cliente não tem telefone/WhatsApp cadastrado.');
        }
        fechar();
    });
}

function mesaExcluir(id) {
    if (!confirm('Deseja realmente excluir esta OS? Essa ação não pode ser desfeita.')) return;
    document.getElementById('mesaIdExcluir').value = id;
    document.getElementById('formMesaExcluir').submit();
}

function mesaMudarPrioridade(ev, id, prioridade) {
    ev.stopPropagation();
    var card = document.querySelector('.mesa-card[data-id="' + id + '"]');
    var grupo = ev.target.closest('.mesa-prio-grupo');
    if (grupo) {
        grupo.querySelectorAll('.mesa-prio-btn').forEach(function(b) { b.classList.remove('ativo'); });
        ev.target.classList.add('ativo');
    }

    fetch('<?= site_url("os/mesaAtualizarPrioridade") ?>', {
        method: 'POST',
        headers: {'Content-Type': 'application/x-www-form-urlencoded'},
        body: 'id=' + id + '&prioridade=' + prioridade
            + '&<?= $this->security->get_csrf_token_name() ?>=<?= $this->security->get_csrf_hash() ?>'
    }).then(function(res) { return res.json(); }).then(function(data) {
        if (data.sucesso) location.reload(); // recarrega pra atualizar a etiqueta de prioridade no card
        else alert('Não foi possível mudar a prioridade.');
    }).catch(function() { alert('Erro de conexão.'); });
}

function mesaAvancarStatus(ev, id) {
    ev.stopPropagation();
    if (!confirm('Avançar esta OS pra próxima etapa?')) return;

    fetch('<?= site_url("os/mesaAvancarStatus") ?>', {
        method: 'POST',
        headers: {'Content-Type': 'application/x-www-form-urlencoded'},
        body: 'id=' + id + '&<?= $this->security->get_csrf_token_name() ?>=<?= $this->security->get_csrf_hash() ?>'
    }).then(function(res) { return res.json(); }).then(function(data) {
        if (data.sucesso) {
            if (data.aviso) {
                mesaMostrarAvisoCliente(data.aviso, function() { location.reload(); });
            } else {
                location.reload();
            }
        } else {
            alert(data.erro || 'Não foi possível avançar o status.');
        }
    }).catch(function() { alert('Erro de conexão.'); });
}

function mesaArquivar(ev, id) {
    ev.stopPropagation();
    if (!confirm('Arquivar esta OS? Ela sai da Mesa de Trabalho, mas continua acessível pela listagem normal.')) return;

    fetch('<?= site_url("os/mesaArquivar") ?>', {
        method: 'POST',
        headers: {'Content-Type': 'application/x-www-form-urlencoded'},
        body: 'id=' + id + '&<?= $this->security->get_csrf_token_name() ?>=<?= $this->security->get_csrf_hash() ?>'
    }).then(function(res) { return res.json(); }).then(function(data) {
        if (data.sucesso) {
            var card = document.querySelector('.mesa-card[data-id="' + id + '"]');
            if (card) card.remove();
        } else {
            alert('Não foi possível arquivar.');
        }
    }).catch(function() { alert('Erro de conexão.'); });
}

// ── Arrastar e soltar entre colunas (mouse E toque, pra funcionar bem
//    no tablet também, não só no computador) ──────────────────────
(function() {
    var cardArrastado = null;

    function moverCardParaColuna(card, coluna) {
        var colunaOrigem = card.closest('.mesa-col-body');
        if (colunaOrigem === coluna) return; // soltou na mesma coluna, nada muda

        var id = card.getAttribute('data-id');
        var novoStatus = coluna.getAttribute('data-status');

        // Move visualmente já (otimista) — remove o "vazio" se precisar
        var emptyMsg = coluna.querySelector('.mesa-col-empty');
        if (emptyMsg) emptyMsg.remove();
        coluna.appendChild(card);
        atualizarContadores();

        fetch('<?= site_url("os/mesaAtualizarStatus") ?>', {
            method: 'POST',
            headers: {'Content-Type': 'application/x-www-form-urlencoded'},
            body: 'id=' + encodeURIComponent(id) + '&status=' + encodeURIComponent(novoStatus)
                + '&<?= $this->security->get_csrf_token_name() ?>=<?= $this->security->get_csrf_hash() ?>'
        })
        .then(function(res) { return res.json(); })
        .then(function(data) {
            if (!data.sucesso) {
                alert('Não foi possível mover a OS: ' + (data.erro || 'erro desconhecido') + '. A página será recarregada.');
                location.reload();
            } else if (data.aviso) {
                mesaMostrarAvisoCliente(data.aviso);
            }
        })
        .catch(function() {
            alert('Erro de conexão ao mover a OS. A página será recarregada.');
            location.reload();
        });
    }

    // ── Mouse (HTML5 drag-and-drop nativo) ──
    document.querySelectorAll('.mesa-card').forEach(function(card) {
        card.addEventListener('dragstart', function() {
            cardArrastado = card;
            card.classList.add('dragging');
        });
        card.addEventListener('dragend', function() {
            card.classList.remove('dragging');
            cardArrastado = null;
        });
    });

    document.querySelectorAll('.mesa-col-body').forEach(function(coluna) {
        coluna.addEventListener('dragover', function(e) {
            e.preventDefault();
            coluna.classList.add('drag-over');
        });
        coluna.addEventListener('dragleave', function() {
            coluna.classList.remove('drag-over');
        });
        coluna.addEventListener('drop', function(e) {
            e.preventDefault();
            coluna.classList.remove('drag-over');
            if (!cardArrastado) return;
            moverCardParaColuna(cardArrastado, coluna);
        });
    });

    // ── Toque (tablet) — o drag-and-drop nativo do HTML5 não responde
    //    bem a toque na maioria dos navegadores, então isso é feito na
    //    mão: segue o dedo, e ao soltar, verifica em cima de qual coluna
    //    o dedo estava. ──
    var touchCard = null;
    var touchGhost = null;
    var touchOffsetX = 0, touchOffsetY = 0;
    var touchIniciouArraste = false;
    var TOQUE_LIMIAR_PX = 12; // só considera "arrastar" depois de mover isso, pra não atrapalhar toque simples/scroll

    document.querySelectorAll('.mesa-card').forEach(function(card) {
        card.addEventListener('touchstart', function(e) {
            if (e.target.closest('.mesa-menu-btn') || e.target.closest('.mesa-dropdown')) return; // não interfere no menu "⋮"
            var t = e.touches[0];
            var rect = card.getBoundingClientRect();
            touchCard = card;
            touchOffsetX = t.clientX - rect.left;
            touchOffsetY = t.clientY - rect.top;
            touchIniciouArraste = false;
        }, { passive: true });

        card.addEventListener('touchmove', function(e) {
            if (!touchCard) return;
            var t = e.touches[0];

            if (!touchIniciouArraste) {
                var rect = touchCard.getBoundingClientRect();
                var dx = Math.abs(t.clientX - (rect.left + touchOffsetX));
                var dy = Math.abs(t.clientY - (rect.top + touchOffsetY));
                if (dx < TOQUE_LIMIAR_PX && dy < TOQUE_LIMIAR_PX) return; // ainda não é arraste de verdade

                touchIniciouArraste = true;
                touchCard.classList.add('dragging');
                touchGhost = touchCard.cloneNode(true);
                touchGhost.style.position = 'fixed';
                touchGhost.style.width = touchCard.offsetWidth + 'px';
                touchGhost.style.pointerEvents = 'none';
                touchGhost.style.zIndex = '999';
                touchGhost.style.opacity = '0.9';
                touchGhost.style.boxShadow = '0 12px 28px rgba(0,0,0,0.5)';
                document.body.appendChild(touchGhost);
            }

            e.preventDefault(); // trava o scroll da página só depois que confirmou que é arraste
            touchGhost.style.left = (t.clientX - touchOffsetX) + 'px';
            touchGhost.style.top = (t.clientY - touchOffsetY) + 'px';

            document.querySelectorAll('.mesa-col-body').forEach(function(c) { c.classList.remove('drag-over'); });
            var alvo = document.elementFromPoint(t.clientX, t.clientY);
            var colunaAlvo = alvo ? alvo.closest('.mesa-col-body') : null;
            if (colunaAlvo) colunaAlvo.classList.add('drag-over');
        }, { passive: false });

        card.addEventListener('touchend', function(e) {
            if (!touchCard) return;

            if (touchIniciouArraste) {
                var t = e.changedTouches[0];
                document.querySelectorAll('.mesa-col-body').forEach(function(c) { c.classList.remove('drag-over'); });
                if (touchGhost) touchGhost.remove();
                touchCard.classList.remove('dragging');

                var alvo = document.elementFromPoint(t.clientX, t.clientY);
                var colunaAlvo = alvo ? alvo.closest('.mesa-col-body') : null;
                if (colunaAlvo) moverCardParaColuna(touchCard, colunaAlvo);
            }

            touchCard = null;
            touchGhost = null;
            touchIniciouArraste = false;
        });
    });

    function atualizarContadores() {
        document.querySelectorAll('.mesa-col').forEach(function(col) {
            var body = col.querySelector('.mesa-col-body');
            var chave = body.getAttribute('data-coluna');
            var qtd = body.querySelectorAll('.mesa-card').length;
            var countEl = document.getElementById('count-' + chave);
            if (countEl && countEl.textContent != qtd) {
                countEl.textContent = qtd;
                countEl.classList.remove('pulsando');
                void countEl.offsetWidth;
                countEl.classList.add('pulsando');
            }
            var empty = body.querySelector('.mesa-col-empty');
            if (qtd > 0 && empty) empty.remove();
            if (qtd === 0 && !body.querySelector('.mesa-col-empty')) {
                var div = document.createElement('div');
                div.className = 'mesa-col-empty';
                div.innerHTML = '<i class="bx bx-inbox"></i>Nenhuma OS aqui';
                body.appendChild(div);
            }
        });
    }
})();
</script>
