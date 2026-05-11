<link rel="stylesheet" href="<?= base_url() ?>assets/trumbowyg/ui/trumbowyg.css">
<script src="<?= base_url() ?>assets/js/jquery-ui/js/jquery-ui-1.9.2.custom.js"></script>
<script src="<?= base_url() ?>assets/js/jquery.validate.js"></script>
<script src="<?= base_url() ?>assets/trumbowyg/trumbowyg.js"></script>
<script src="<?= base_url() ?>assets/trumbowyg/langs/pt_br.js"></script>

<?php
// Verifica se o cliente pode abrir OS
// Configuração 'mine_permite_abrir_os' na tabela configuracoes
// 0 = bloqueado (padrão seguro), 1 = liberado para todos
try {
    $cfgOs = $this->db->where('config', 'mine_permite_abrir_os')->get('configuracoes')->row();
    $permiteAbrirOs = $cfgOs ? (int)$cfgOs->valor : 0;
} catch(Exception $e) {
    $permiteAbrirOs = 0;
}
// Também verifica se este cliente específico tem permissão individual
// coluna 'pode_abrir_os' na tabela clientes (se existir)
try {
    $clienteId = $this->session->userdata('cliente_id');
    $clienteRow = $this->db->select('pode_abrir_os')->where('idClientes', $clienteId)->get('clientes')->row();
    $clientePermitido = $clienteRow && isset($clienteRow->pode_abrir_os) ? (int)$clienteRow->pode_abrir_os : -1;
} catch(Exception $e) {
    $clientePermitido = -1;
}
// Lógica final:
// - Se cliente tem permissão individual (1) → libera
// - Senão, usa configuração global
$podeAbrir = ($clientePermitido === 1) || ($clientePermitido === -1 && $permiteAbrirOs === 1);
?>

<style>
/* Trumbowyg dark */
.trumbowyg-box{border-radius:10px!important;overflow:hidden;border:1px solid #444860!important;}
.trumbowyg-button-pane{background:#252a3a!important;border-bottom:1px solid #444860!important;border-radius:10px 10px 0 0!important;}
.trumbowyg-button-pane button,.trumbowyg-button-pane .trumbowyg-button-group::before{color:#9ca3af!important;}
.trumbowyg-button-pane button:hover,.trumbowyg-button-pane button.trumbowyg-active{background:rgba(255,255,255,0.08)!important;color:#e8eaf0!important;}
.trumbowyg-editor{background:#13151f!important;color:#e8eaf0!important;border:none!important;border-radius:0 0 10px 10px!important;min-height:120px!important;padding:10px 14px!important;font-size:13px!important;line-height:1.7!important;}
label.error{color:#f87171!important;font-size:11px!important;}
</style>

<div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:18px;flex-wrap:wrap;gap:10px;">
    <h2 style="font-size:18px;font-weight:800;color:#e8eaf0;display:flex;align-items:center;gap:8px;">
        <i class='bx bx-plus-circle' style="color:#22c55e;"></i> Abrir Ordem de Serviço
    </h2>
    <a href="<?= base_url() ?>index.php/mine/os" class="mc-btn mc-btn-ghost" style="padding:7px 14px;font-size:13px;">
        <i class='bx bx-arrow-back'></i> Voltar
    </a>
</div>

<?php if (!$podeAbrir): ?>

<!-- ── BLOQUEADO ── -->
<div class="mc-card" style="border-color:rgba(245,158,11,0.3);">
    <div class="mc-card-body" style="padding:40px 24px;text-align:center;">
        <div style="width:72px;height:72px;border-radius:20px;background:rgba(245,158,11,0.12);border:2px solid rgba(245,158,11,0.3);display:flex;align-items:center;justify-content:center;font-size:32px;margin:0 auto 16px;">
            <i class='bx bx-lock' style="color:#fbbf24;"></i>
        </div>
        <h3 style="font-size:18px;font-weight:800;color:#e8eaf0;margin-bottom:8px;">
            Abertura de OS Indisponível
        </h3>
        <p style="font-size:14px;color:#9ca3af;max-width:420px;margin:0 auto 20px;line-height:1.7;">
            Para abrir uma Ordem de Serviço, primeiro traga seu equipamento à nossa loja.<br>
            Nossa equipe irá analisá-lo e abrirá o atendimento para você.
        </p>
        <div style="background:#1a1d2e;border:1px solid rgba(255,255,255,0.07);border-radius:12px;padding:16px 20px;max-width:360px;margin:0 auto 24px;">
            <div style="font-size:12px;font-weight:700;color:#9ca3af;text-transform:uppercase;letter-spacing:.6px;margin-bottom:10px;">Como funciona</div>
            <div style="display:flex;flex-direction:column;gap:10px;text-align:left;">
                <div style="display:flex;gap:10px;align-items:flex-start;">
                    <div style="width:24px;height:24px;border-radius:6px;background:rgba(99,102,241,0.2);color:#a5b4fc;display:flex;align-items:center;justify-content:center;font-size:12px;font-weight:700;flex-shrink:0;">1</div>
                    <span style="font-size:13px;color:#c9cad6;">Traga seu equipamento à nossa loja</span>
                </div>
                <div style="display:flex;gap:10px;align-items:flex-start;">
                    <div style="width:24px;height:24px;border-radius:6px;background:rgba(99,102,241,0.2);color:#a5b4fc;display:flex;align-items:center;justify-content:center;font-size:12px;font-weight:700;flex-shrink:0;">2</div>
                    <span style="font-size:13px;color:#c9cad6;">Nossa equipe faz o diagnóstico inicial</span>
                </div>
                <div style="display:flex;gap:10px;align-items:flex-start;">
                    <div style="width:24px;height:24px;border-radius:6px;background:rgba(34,197,94,0.2);color:#4ade80;display:flex;align-items:center;justify-content:center;font-size:12px;font-weight:700;flex-shrink:0;">3</div>
                    <span style="font-size:13px;color:#c9cad6;">A OS é aberta e aparece aqui automaticamente</span>
                </div>
            </div>
        </div>
        <a href="<?= base_url() ?>index.php/mine/os" class="mc-btn mc-btn-primary" style="display:inline-flex;">
            <i class='bx bx-file'></i> Ver Minhas OS
        </a>
    </div>
</div>

<?php else: ?>

<!-- ── FORMULÁRIO ── -->
<div class="mc-alert mc-alert-info" style="margin-bottom:14px;">
    <i class='bx bx-info-circle'></i>
    Preencha os campos abaixo descrevendo o equipamento e o problema. Campos com <strong style="color:#f87171;">*</strong> são obrigatórios.
</div>

<form action="<?= current_url() ?>" method="post" id="formOs">
    <input type="hidden" name="<?= $this->security->get_csrf_token_name() ?>" value="<?= $this->security->get_csrf_hash() ?>">

    <div class="mc-card" style="margin-bottom:14px;">
        <div class="mc-card-head">
            <div class="mc-card-head-left">
                <i class='bx bx-devices' style="color:#22c55e;"></i>
                <span>Detalhes da OS</span>
            </div>
        </div>
        <div class="mc-card-body">

            <div class="mc-form-group">
                <label class="mc-label">Descrição do Produto / Equipamento <span style="color:#f87171;">*</span></label>
                <textarea class="editor" name="descricaoProduto" id="descricaoProduto"></textarea>
                <div style="font-size:11px;color:#6b7280;margin-top:4px;">
                    Ex: Notebook Dell Inspiron 15, Celular Samsung Galaxy A54, TV LG 55"...
                </div>
            </div>

            <div class="mc-form-group" style="margin-top:16px;">
                <label class="mc-label">Defeito / Problema <span style="color:#9ca3af;font-weight:400;text-transform:none;letter-spacing:0;">(opcional)</span></label>
                <textarea class="editor" name="defeito" id="defeito"></textarea>
                <div style="font-size:11px;color:#6b7280;margin-top:4px;">
                    Descreva o problema com o máximo de detalhes possível.
                </div>
            </div>

            <div class="mc-form-group" style="margin-top:16px;">
                <label class="mc-label">Observações <span style="color:#9ca3af;font-weight:400;text-transform:none;letter-spacing:0;">(opcional)</span></label>
                <textarea class="editor" name="observacoes" id="observacoes"></textarea>
            </div>

        </div>
    </div>

    <div style="display:flex;gap:8px;justify-content:flex-end;">
        <a href="<?= base_url() ?>index.php/mine/os" class="mc-btn mc-btn-ghost">
            <i class='bx bx-x'></i> Cancelar
        </a>
        <button type="submit" class="mc-btn mc-btn-success" id="btnContinuar">
            <i class='bx bx-plus-circle'></i> Abrir OS
        </button>
    </div>
</form>

<?php endif; ?>

<script>
$(document).ready(function() {
    <?php if ($podeAbrir): ?>
    $('.editor').trumbowyg({ lang:'pt_br', semantic:{strikethrough:'s'} });

    $('#formOs').validate({
        rules: { descricaoProduto: { required: true } },
        messages: { descricaoProduto: { required: 'Descreva o produto ou equipamento.' } },
        submitHandler: function(form) {
            $('#btnContinuar').attr('disabled',true).html('<i class="bx bx-loader-alt bx-spin"></i> Enviando...');
            form.submit();
        }
    });
    <?php endif; ?>
});
</script>
