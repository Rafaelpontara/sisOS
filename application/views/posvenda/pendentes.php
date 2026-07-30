<style>
.pv-header{display:flex;justify-content:space-between;align-items:flex-start;margin-bottom:20px;flex-wrap:wrap;gap:14px;}
.pv-title{font-size:22px;font-weight:800;color:#e8eaf0;display:flex;align-items:center;gap:10px;}
.pv-title i{font-size:24px;color:#a78bfa;}
.pv-subtitle{font-size:13px;color:#6b7280;margin-top:2px;}
.pv-link-config{display:flex;align-items:center;gap:7px;padding:9px 16px;border-radius:8px;background:#1e2235;color:#c9cad6;font-size:13px;font-weight:700;text-decoration:none;border:1px solid rgba(255,255,255,0.08);transition:background .15s;}
.pv-link-config:hover{background:#252a3a;color:#e8eaf0;}

.pv-review-banner{display:flex;align-items:center;justify-content:space-between;gap:14px;background:linear-gradient(135deg,rgba(167,139,250,0.12),rgba(124,58,237,0.06));border:1px solid rgba(167,139,250,0.25);border-radius:14px;padding:16px 20px;margin-bottom:20px;flex-wrap:wrap;}
.pv-review-banner div{display:flex;align-items:center;gap:12px;}
.pv-review-banner i{font-size:26px;color:#a78bfa;}
.pv-review-banner strong{color:#e8eaf0;font-size:14px;}
.pv-review-banner span{color:#9ca3af;font-size:12.5px;}
.pv-btn-review{padding:8px 16px;border-radius:8px;background:#a78bfa;color:#111;font-size:12.5px;font-weight:700;text-decoration:none;}

.pv-grid{display:grid;grid-template-columns:repeat(auto-fill,minmax(300px,1fr));gap:14px;}
.pv-card{background:#1a1d2e;border:1px solid rgba(255,255,255,0.07);border-radius:14px;padding:16px;display:flex;flex-direction:column;gap:10px;transition:opacity .3s,transform .3s;}
.pv-card.enviado{opacity:0;transform:scale(0.96);pointer-events:none;}
.pv-card-top{display:flex;align-items:center;justify-content:space-between;}
.pv-tag{background:rgba(167,139,250,0.15);color:#a78bfa;font-size:10.5px;font-weight:700;padding:3px 9px;border-radius:20px;}
.pv-data{font-size:11px;color:#6b7280;}
.pv-cliente{font-size:15px;font-weight:700;color:#e8eaf0;}
.pv-equip{font-size:12px;color:#9ca3af;}
.pv-msg{background:#161925;border-radius:10px;padding:10px 12px;font-size:12px;color:#c9cad6;line-height:1.4;max-height:90px;overflow-y:auto;}
.pv-actions{display:flex;gap:8px;margin-top:auto;}
.pv-btn-enviar{flex:1;text-align:center;padding:9px 12px;border-radius:8px;background:linear-gradient(135deg,#22c55e,#16a34a);color:#fff;font-size:12.5px;font-weight:700;text-decoration:none;display:flex;align-items:center;justify-content:center;gap:6px;}
.pv-btn-pular{padding:9px 12px;border-radius:8px;background:rgba(255,255,255,0.06);color:#9ca3af;font-size:12.5px;font-weight:700;border:none;cursor:pointer;}

.pv-empty{grid-column:1/-1;text-align:center;padding:60px 20px;color:#6b7280;}
.pv-empty i{font-size:50px;display:block;margin-bottom:12px;opacity:.3;color:#4ade80;}
</style>

<div class="new122">
    <div class="pv-header">
        <div>
            <div class="pv-title"><i class='bx bx-message-rounded-dots'></i> Pós-Venda</div>
            <div class="pv-subtitle">Follow-ups pendentes de hoje — clique em enviar quando mandar a mensagem</div>
        </div>
        <a href="<?= site_url('posvenda/configurar') ?>" class="pv-link-config"><i class='bx bx-cog'></i> Configurar Modelos</a>
    </div>

    <?php if (!empty($reviewLink)): ?>
    <div class="pv-review-banner">
        <div><i class='bxl bx-star'></i><div><strong>Link de avaliação Google configurado</strong><br><span><?= htmlspecialchars($reviewLink) ?></span></div></div>
        <a href="<?= htmlspecialchars($reviewLink) ?>" target="_blank" class="pv-btn-review">Ver link</a>
    </div>
    <?php else: ?>
    <div class="pv-review-banner">
        <div><i class='bx bx-star' style="color:#f59e0b;"></i><div><strong>Você ainda não configurou o link de avaliação do Google</strong><br><span>Configure pra incluir nas mensagens de pós-venda</span></div></div>
        <a href="<?= site_url('posvenda/configurar') ?>" class="pv-btn-review">Configurar agora</a>
    </div>
    <?php endif; ?>

    <div class="pv-grid" id="pv-grid">
        <?php if (empty($pendentes)): ?>
        <div class="pv-empty">
            <i class='bx bx-check-circle'></i>
            Tudo em dia! Nenhum follow-up pendente por hoje.
        </div>
        <?php else: foreach ($pendentes as $p): ?>
        <div class="pv-card" id="pv-<?= $p['os_id'] ?>-<?= $p['template_id'] ?>">
            <div class="pv-card-top">
                <span class="pv-tag"><?= htmlspecialchars($p['titulo']) ?></span>
                <span class="pv-data">OS finalizada em <?= $p['dataFinal'] ? date('d/m/Y', strtotime($p['dataFinal'])) : '-' ?></span>
            </div>
            <div class="pv-cliente"><?= htmlspecialchars($p['cliente']) ?></div>
            <?php if (!empty($p['aparelho'])): ?>
            <div class="pv-equip"><i class='bx bx-devices'></i> <?= htmlspecialchars($p['aparelho']) ?></div>
            <?php endif; ?>
            <div class="pv-msg"><?= nl2br(htmlspecialchars($p['mensagem'])) ?></div>
            <div class="pv-actions">
                <?php if (!empty($p['telefone'])): ?>
                <a href="https://api.whatsapp.com/send?phone=55<?= $p['telefone'] ?>&text=<?= urlencode($p['mensagem']) ?>"
                   target="_blank" class="pv-btn-enviar" onclick="pvMarcarEnviado(<?= $p['os_id'] ?>, <?= $p['template_id'] ?>)">
                    <i class='bx bxl-whatsapp'></i> Enviar no WhatsApp
                </a>
                <?php else: ?>
                <span class="pv-btn-enviar" style="background:#374151;cursor:not-allowed;">Sem telefone cadastrado</span>
                <?php endif; ?>
                <button type="button" class="pv-btn-pular" onclick="pvMarcarEnviado(<?= $p['os_id'] ?>, <?= $p['template_id'] ?>)" title="Marcar como feito sem enviar">
                    <i class='bx bx-check'></i>
                </button>
            </div>
        </div>
        <?php endforeach; endif; ?>
    </div>
</div>

<script>
function pvMarcarEnviado(osId, templateId) {
    var card = document.getElementById('pv-' + osId + '-' + templateId);
    if (card) card.classList.add('enviado');
    fetch('<?= site_url("posvenda/marcarEnviado") ?>', {
        method: 'POST',
        headers: {'Content-Type': 'application/x-www-form-urlencoded'},
        body: 'os_id=' + osId + '&template_id=' + templateId
            + '&<?= $this->security->get_csrf_token_name() ?>=<?= $this->security->get_csrf_hash() ?>'
    }).catch(function() {});
}
</script>
