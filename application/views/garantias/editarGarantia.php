<link rel="stylesheet" href="<?= base_url() ?>assets/js/jquery-ui/css/smoothness/jquery-ui-1.9.2.custom.css">
<script src="<?= base_url() ?>assets/js/jquery-ui/js/jquery-ui-1.9.2.custom.js"></script>
<script src="<?= base_url() ?>assets/js/jquery.validate.js"></script>
<link rel="stylesheet" href="<?= base_url() ?>assets/trumbowyg/ui/trumbowyg.css">
<script src="<?= base_url() ?>assets/trumbowyg/trumbowyg.js"></script>
<script src="<?= base_url() ?>assets/trumbowyg/langs/pt_br.js"></script>
<style>
.dg-wrap *,.dg-wrap *::before,.dg-wrap *::after{box-sizing:border-box;}
.dg-wrap .widget-box,.dg-wrap .row-fluid,.dg-wrap .span12,.dg-wrap .form-horizontal{all:unset;display:block;}
.dg-wrap{max-width:860px;margin:0 auto;font-family:inherit;}
.dg-card{background:#1a1d2e;border:1px solid rgba(255,255,255,0.07);border-radius:14px;overflow:hidden;margin-bottom:14px;}
.dg-card-head{display:flex;align-items:center;gap:8px;padding:11px 16px;border-bottom:1px solid rgba(255,255,255,0.06);background:#252a3a;}
.dg-card-head i{font-size:15px;}
.dg-card-head span{font-size:11px;font-weight:700;color:#9ca3af;text-transform:uppercase;letter-spacing:.8px;}
.dg-card-body{padding:18px;}
.dg-grid{display:grid;grid-template-columns:1fr 1fr 1fr;gap:14px;}
@media(max-width:640px){.dg-grid{grid-template-columns:1fr;}}
.dg-field{margin-bottom:14px;}
.dg-label{font-size:11px;font-weight:700;color:#9ca3af;text-transform:uppercase;letter-spacing:.5px;display:block;margin-bottom:5px;}
.dg-input,.dg-textarea{width:100%;background:#13151f;border:1px solid #444860;color:#e8eaf0;border-radius:8px;padding:9px 13px;font-size:13px;box-sizing:border-box;transition:border-color .15s;display:block;}
.dg-input:focus{border-color:#6366f1;outline:none;}
.dg-input:disabled{background:#1a1d2e;color:#6b7280;cursor:default;}
.dg-btn{display:inline-flex;align-items:center;gap:6px;padding:10px 22px;border-radius:8px;font-size:13px;font-weight:700;text-decoration:none;border:none;cursor:pointer;transition:all .15s;}
.dg-btn:hover{transform:translateY(-1px);text-decoration:none;}
.dg-btn-update{background:linear-gradient(135deg,#6366f1,#4f46e5);color:#fff;box-shadow:0 4px 12px rgba(99,102,241,0.3);}
.dg-btn-back{background:rgba(255,255,255,0.07);color:#9ca3af;border:1px solid rgba(255,255,255,0.1);}
.dg-btn-back:hover{color:#e8eaf0;}
/* trumbowyg dark */
.trumbowyg-box{border-radius:10px!important;overflow:hidden;border:1px solid #444860!important;}
.trumbowyg-button-pane{background:#252a3a!important;border-bottom:1px solid #444860!important;border-radius:10px 10px 0 0!important;}
.trumbowyg-button-pane button{color:#9ca3af!important;}
.trumbowyg-button-pane button:hover,.trumbowyg-button-pane button.trumbowyg-active{background:rgba(255,255,255,0.08)!important;color:#e8eaf0!important;}
.trumbowyg-editor{background:#13151f!important;color:#e8eaf0!important;border:none!important;border-radius:0 0 10px 10px!important;min-height:220px!important;padding:12px 16px!important;font-size:13px!important;line-height:1.7!important;}
span.error{color:#f87171!important;font-size:11px!important;}
</style>

<div class="dg-wrap new122">

    <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:18px;flex-wrap:wrap;gap:10px;">
        <h2 style="font-size:18px;font-weight:800;color:#e8eaf0;display:flex;align-items:center;gap:8px;">
            <i class='bx bx-shield-alt-2' style="color:#6366f1;"></i> Editar Termo de Garantia
        </h2>
        <a href="<?= base_url() ?>index.php/garantias" class="dg-btn dg-btn-back" style="padding:8px 14px;font-size:12px;">
            <i class='bx bx-arrow-back'></i> Voltar
        </a>
    </div>

    <?php if ($custom_error): ?>
    <div style="background:rgba(239,68,68,0.1);border:1px solid rgba(239,68,68,0.3);border-radius:8px;padding:10px 14px;font-size:13px;color:#f87171;margin-bottom:14px;display:flex;align-items:center;gap:8px;">
        <i class='bx bx-error-circle'></i> Dados incompletos. Verifique os campos obrigatórios.
    </div>
    <?php endif; ?>

    <form action="<?= current_url() ?>" method="post" id="formGarantia">
        <?= form_hidden('idGarantias', $result->idGarantias) ?>

        <!-- Informações -->
        <div class="dg-card">
            <div class="dg-card-head"><i class='bx bx-info-circle' style="color:#6366f1;"></i><span>Informações do Termo</span></div>
            <div class="dg-card-body">
                <div class="dg-grid">
                    <div class="dg-field">
                        <label class="dg-label">Data</label>
                        <input id="dataGarantia" class="dg-input datepicker" type="text" name="dataGarantia"
                               value="<?= date('d/m/Y', strtotime($result->dataGarantia)) ?>" disabled>
                        <div style="font-size:11px;color:#6b7280;margin-top:4px;">Campo somente leitura</div>
                    </div>
                    <div class="dg-field">
                        <label class="dg-label">Responsável</label>
                        <input id="responsavel" class="dg-input" type="text" value="<?= htmlspecialchars($result->nome) ?>" disabled>
                        <div style="font-size:11px;color:#6b7280;margin-top:4px;">Campo somente leitura</div>
                    </div>
                    <div class="dg-field">
                        <label class="dg-label">Referência da Garantia</label>
                        <input id="refGarantia" class="dg-input" type="text" name="refGarantia"
                               value="<?= htmlspecialchars($result->refGarantia ?? '') ?>"
                               placeholder="Ex: OS #0042, Produto XYZ...">
                    </div>
                </div>
            </div>
        </div>

        <!-- Texto do Termo -->
        <div class="dg-card">
            <div class="dg-card-head"><i class='bx bx-file-blank' style="color:#fbbf24;"></i><span>Texto do Termo de Garantia</span></div>
            <div class="dg-card-body">
                <textarea class="editor" name="textoGarantia" id="textoGarantia"><?= $result->textoGarantia ?></textarea>
            </div>
        </div>

        <div style="display:flex;justify-content:flex-end;gap:8px;padding:4px 0 8px;">
            <a href="<?= base_url() ?>index.php/garantias" class="dg-btn dg-btn-back"><i class='bx bx-x'></i> Cancelar</a>
            <button type="submit" class="dg-btn dg-btn-update" id="btnSalvar"><i class='bx bx-save'></i> Salvar Alterações</button>
        </div>
    </form>
</div>

<script>
$(document).ready(function(){
    $('.datepicker').datepicker({ dateFormat:'dd/mm/yy' });
    $('.editor').trumbowyg({ lang:'pt_br', semantic:{'strikethrough':'s'} });
    $('#formGarantia').validate({
        rules:{ textoGarantia:{required:true} },
        messages:{ textoGarantia:{required:'Campo obrigatório.'} },
        submitHandler:function(f){$('#btnSalvar').attr('disabled',true).html('<i class="bx bx-loader-alt bx-spin"></i> Salvando...');f.submit();}
    });
});
</script>
