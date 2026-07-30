<style>
.pv-header{display:flex;justify-content:space-between;align-items:flex-start;margin-bottom:20px;flex-wrap:wrap;gap:14px;}
.pv-title{font-size:22px;font-weight:800;color:#e8eaf0;display:flex;align-items:center;gap:10px;}
.pv-title i{font-size:24px;color:#a78bfa;}
.pv-link-voltar{display:flex;align-items:center;gap:7px;padding:9px 16px;border-radius:8px;background:#1e2235;color:#c9cad6;font-size:13px;font-weight:700;text-decoration:none;border:1px solid rgba(255,255,255,0.08);}

.pv-card{background:#1a1d2e;border:1px solid rgba(255,255,255,0.07);border-radius:14px;padding:20px;margin-bottom:18px;}
.pv-card h5{color:#e8eaf0;font-size:15px;font-weight:700;margin-bottom:14px;display:flex;align-items:center;gap:8px;}
.pv-card h5 i{color:#a78bfa;font-size:18px;}
.pv-input, .pv-textarea{width:100%;background:#1e2133;border:1px solid #444860;color:#e8eaf0;border-radius:8px;padding:10px 12px;font-size:13px;box-sizing:border-box;}
.pv-input:focus, .pv-textarea:focus{outline:none;border-color:#a78bfa;}
.pv-label{font-size:11px;font-weight:700;color:#9ca3af;text-transform:uppercase;letter-spacing:.5px;margin-bottom:6px;display:block;}
.pv-btn{padding:9px 18px;border-radius:8px;background:linear-gradient(135deg,#a78bfa,#7c3aed);color:#fff;font-size:13px;font-weight:700;border:none;cursor:pointer;}
.pv-btn-add{display:flex;align-items:center;gap:7px;padding:9px 16px;border-radius:8px;background:linear-gradient(135deg,#22c55e,#16a34a);color:#fff;font-size:13px;font-weight:700;border:none;cursor:pointer;text-decoration:none;}

.pv-tpl-item{background:#161925;border:1px solid rgba(255,255,255,0.06);border-radius:12px;padding:14px 16px;margin-bottom:10px;display:flex;justify-content:space-between;align-items:flex-start;gap:14px;}
.pv-tpl-item.inativo{opacity:0.5;}
.pv-tpl-info strong{color:#e8eaf0;font-size:13.5px;}
.pv-tpl-info .dias{color:#a78bfa;font-size:11.5px;font-weight:700;margin-left:8px;}
.pv-tpl-info p{color:#9ca3af;font-size:12px;margin-top:6px;max-width:520px;}
.pv-tpl-actions{display:flex;gap:6px;flex-shrink:0;}
.pv-tpl-btn{width:32px;height:32px;border-radius:8px;display:flex;align-items:center;justify-content:center;font-size:14px;border:none;cursor:pointer;text-decoration:none;}
.pv-tpl-edit{background:rgba(34,197,94,0.15);color:#4ade80;}
.pv-tpl-del{background:rgba(239,68,68,0.15);color:#f87171;}

.pv-form-row{margin-bottom:14px;}
</style>

<div class="new122">
    <div class="pv-header">
        <div class="pv-title"><i class='bx bx-cog'></i> Configurar Pós-Venda</div>
        <a href="<?= site_url('posvenda') ?>" class="pv-link-voltar"><i class='bx bx-arrow-back'></i> Voltar</a>
    </div>

    <!-- Link de avaliação Google -->
    <div class="pv-card">
        <h5><i class='bx bx-star'></i> Link de Avaliação do Google</h5>
        <form method="post" action="<?= site_url('posvenda/configurar') ?>">
            <div class="pv-form-row">
                <label class="pv-label">Link do Google Meu Negócio</label>
                <input type="text" name="google_review_link" class="pv-input" value="<?= htmlspecialchars($reviewLink) ?>" placeholder="https://g.page/r/....">
            </div>
            <button type="submit" name="salvar_review_link" value="1" class="pv-btn">Salvar Link</button>
        </form>
    </div>

    <!-- Modelos de mensagem -->
    <div class="pv-card">
        <h5><i class='bx bx-message-square-detail'></i> Modelos de Mensagem</h5>

        <?php if (empty($templates)): ?>
        <p style="color:#6b7280;font-size:13px;margin-bottom:14px;">Nenhum modelo cadastrado ainda.</p>
        <?php else: foreach ($templates as $t): ?>
        <div class="pv-tpl-item <?= $t->ativo ? '' : 'inativo' ?>">
            <div class="pv-tpl-info">
                <strong><?= htmlspecialchars($t->titulo) ?></strong><span class="dias"><?= (int)$t->dias_apos ?> dia(s) após finalizar</span>
                <p><?= nl2br(htmlspecialchars($t->mensagem)) ?></p>
            </div>
            <div class="pv-tpl-actions">
                <button type="button" class="pv-tpl-btn pv-tpl-edit" onclick='pvEditar(<?= json_encode($t) ?>)' title="Editar"><i class='bx bx-edit'></i></button>
                <a href="#" onclick="pvExcluir(<?= $t->id ?>);return false;" class="pv-tpl-btn pv-tpl-del" title="Excluir"><i class='bx bx-trash-alt'></i></a>
            </div>
        </div>
        <?php endforeach; endif; ?>

        <button type="button" class="pv-btn-add" style="margin-top:8px;" onclick="pvNovo()"><i class='bx bx-plus-circle'></i> Novo Modelo</button>
    </div>
</div>

<!-- Modal Adicionar/Editar Template -->
<div id="modal-template" class="modal hide fade" tabindex="-1">
    <form action="<?= site_url('posvenda/salvarTemplate') ?>" method="post">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 id="modalTplTitulo">Novo Modelo de Mensagem</h4>
        </div>
        <div class="modal-body" style="padding:20px;">
            <input type="hidden" name="id" id="tplId" value="">
            <div class="pv-form-row">
                <label class="pv-label">Título (interno, só pra identificar)</label>
                <input type="text" name="titulo" id="tplTitulo" class="pv-input" placeholder="Ex: Feedback Inicial" required>
            </div>
            <div class="pv-form-row">
                <label class="pv-label">Enviar quantos dias após a OS ser finalizada?</label>
                <input type="number" name="dias_apos" id="tplDias" class="pv-input" value="3" min="0" required>
            </div>
            <div class="pv-form-row">
                <label class="pv-label">Mensagem</label>
                <textarea name="mensagem" id="tplMensagem" class="pv-textarea" rows="4" placeholder="Use {nome}, {empresa}, {aparelho} e {pesquisa} — serão substituídos automaticamente" required></textarea>
                <div style="font-size:11px;color:#6b7280;margin-top:5px;">Variáveis disponíveis: <code>{nome}</code>, <code>{empresa}</code>, <code>{aparelho}</code>, <code>{pesquisa}</code> (link da pesquisa de satisfação)</div>
            </div>
            <div class="pv-form-row" style="display:flex;align-items:center;gap:8px;">
                <input type="checkbox" name="ativo" id="tplAtivo" value="1" checked style="width:auto;">
                <label for="tplAtivo" style="margin:0;color:#c9cad6;font-size:13px;">Ativo (aparece no painel de pendentes)</label>
            </div>
        </div>
        <div class="modal-footer" style="display:flex;justify-content:center;gap:10px;">
            <button type="button" class="button btn btn-warning" data-dismiss="modal"><span class="button__icon"><i class="bx bx-x"></i></span><span class="button__text2">Cancelar</span></button>
            <button type="submit" class="button btn btn-success"><span class="button__icon"><i class='bx bx-save'></i></span><span class="button__text2">Salvar</span></button>
        </div>
    </form>
</div>

<!-- Form oculto para excluir -->
<form id="formExcluirTpl" action="<?= site_url('posvenda/excluirTemplate') ?>" method="post" style="display:none;">
    <input type="hidden" id="tplIdExcluir" name="id" value="">
</form>

<script>
function pvNovo() {
    document.getElementById('modalTplTitulo').textContent = 'Novo Modelo de Mensagem';
    document.getElementById('tplId').value = '';
    document.getElementById('tplTitulo').value = '';
    document.getElementById('tplDias').value = 3;
    document.getElementById('tplMensagem').value = '';
    document.getElementById('tplAtivo').checked = true;
    $('#modal-template').modal('show');
}

function pvEditar(t) {
    document.getElementById('modalTplTitulo').textContent = 'Editar Modelo de Mensagem';
    document.getElementById('tplId').value = t.id;
    document.getElementById('tplTitulo').value = t.titulo;
    document.getElementById('tplDias').value = t.dias_apos;
    document.getElementById('tplMensagem').value = t.mensagem;
    document.getElementById('tplAtivo').checked = (t.ativo == 1 || t.ativo === true);
    $('#modal-template').modal('show');
}

function pvExcluir(id) {
    if (!confirm('Deseja realmente excluir este modelo de mensagem?')) return;
    document.getElementById('tplIdExcluir').value = id;
    document.getElementById('formExcluirTpl').submit();
}
</script>
