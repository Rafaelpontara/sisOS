<link rel="stylesheet" href="<?= base_url() ?>assets/js/jquery-ui/css/smoothness/jquery-ui-1.9.2.custom.css" />
<script src="<?= base_url() ?>assets/js/jquery-ui/js/jquery-ui-1.9.2.custom.js"></script>
<script src="<?= base_url() ?>assets/js/jquery.validate.js"></script>
<link rel="stylesheet" href="<?= base_url() ?>assets/trumbowyg/ui/trumbowyg.css">
<script src="<?= base_url() ?>assets/trumbowyg/trumbowyg.js"></script>
<script src="<?= base_url() ?>assets/trumbowyg/langs/pt_br.js"></script>
<link rel="stylesheet" href="<?= base_url() ?>assets/css/custom.css" />

<style>
.gar-wrap{max-width:860px;margin:0 auto;}
.gar-header{display:flex;align-items:center;justify-content:space-between;margin-bottom:20px;flex-wrap:wrap;gap:10px;}
.gar-title{display:flex;align-items:center;gap:10px;}
.gar-title i{font-size:24px;color:#4ade80;}
.gar-title h2{font-size:20px;font-weight:800;color:#e8eaf0;margin:0;}
.gar-card{background:#1a1d2e;border:1px solid rgba(255,255,255,0.07);border-radius:14px;overflow:hidden;margin-bottom:14px;}
.gar-card-head{display:flex;align-items:center;gap:8px;padding:11px 18px;border-bottom:1px solid rgba(255,255,255,0.06);background:#252a3a;}
.gar-card-head i{font-size:15px;color:#4ade80;}
.gar-card-head span{font-size:11px;font-weight:700;color:#9ca3af;text-transform:uppercase;letter-spacing:.8px;}
.gar-card-body{padding:18px;}
.gar-grid{display:grid;grid-template-columns:1fr 1fr 1fr;gap:14px;}
@media(max-width:640px){.gar-grid{grid-template-columns:1fr;}}
.gar-label{font-size:11px;font-weight:700;color:#9ca3af;text-transform:uppercase;letter-spacing:.5px;display:block;margin-bottom:5px;}
.gar-label .req{color:#f87171;margin-left:2px;}
.gar-input,.gar-select{width:100%;background:#13151f;border:1px solid #444860;color:#e8eaf0;border-radius:8px;padding:9px 13px;font-size:13px;box-sizing:border-box;transition:border-color .15s;-webkit-appearance:none;}
.gar-input:focus,.gar-select:focus{border-color:#4ade80;outline:none;}
.gar-input:disabled{background:#1a1d2e;color:#6b7280;cursor:not-allowed;}
.gar-select{height:38px;}
.gar-obs{font-size:11px;color:#6b7280;margin-top:4px;}
/* Trumbowyg dark */
.trumbowyg-box{border-radius:10px!important;overflow:hidden;border:1px solid #444860!important;}
.trumbowyg-button-pane{background:#252a3a!important;border-bottom:1px solid #444860!important;border-radius:10px 10px 0 0!important;}
.trumbowyg-button-pane button,.trumbowyg-button-pane .trumbowyg-button-group::before{color:#9ca3af!important;}
.trumbowyg-button-pane button:hover,.trumbowyg-button-pane button.trumbowyg-active{background:rgba(255,255,255,0.08)!important;color:#e8eaf0!important;}
.trumbowyg-editor{background:#13151f!important;color:#e8eaf0!important;border:none!important;border-radius:0 0 10px 10px!important;min-height:220px!important;padding:12px 14px!important;font-size:13px!important;line-height:1.7!important;}
/* Footer */
.gar-footer{display:flex;justify-content:flex-end;gap:8px;padding:16px 18px;border-top:1px solid rgba(255,255,255,0.06);background:#1a1d2e;border-radius:0 0 14px 14px;}
.gar-btn{display:inline-flex;align-items:center;gap:6px;padding:9px 20px;border-radius:8px;font-size:13px;font-weight:700;text-decoration:none;border:none;cursor:pointer;transition:all .15s;}
.gar-btn:hover{transform:translateY(-1px);text-decoration:none;}
.gar-btn-save{background:linear-gradient(135deg,#22c55e,#16a34a);color:#fff;box-shadow:0 4px 12px rgba(34,197,94,0.3);}
.gar-btn-back{background:rgba(255,255,255,0.07);color:#9ca3af;border:1px solid rgba(255,255,255,0.1);}
.gar-btn-back:hover{color:#e8eaf0;}
.gar-alert{background:rgba(239,68,68,0.1);border:1px solid rgba(239,68,68,0.3);border-radius:8px;padding:10px 14px;font-size:13px;color:#f87171;margin-bottom:14px;display:flex;gap:8px;align-items:center;}
label.error{color:#f87171!important;font-size:11px!important;}
input.error{border-color:#f87171!important;}
</style>

<div class="gar-wrap new122">

    <div class="gar-header">
        <div class="gar-title">
            <i class='bx bx-shield-check'></i>
            <h2>Cadastro de Termo de Garantia</h2>
        </div>
        <a href="<?= base_url() ?>index.php/garantias" class="gar-btn gar-btn-back" style="padding:8px 16px;font-size:13px;">
            <i class='bx bx-arrow-back'></i> Voltar
        </a>
    </div>

    <?php if ($custom_error == true): ?>
    <div class="gar-alert">
        <i class='bx bx-error-circle' style="font-size:16px;flex-shrink:0;"></i>
        Dados incompletos. Verifique os campos obrigatórios (*).
    </div>
    <?php endif; ?>

    <form action="<?= current_url() ?>" method="post" id="formGarantia">

        <!-- Informações básicas -->
        <div class="gar-card">
            <div class="gar-card-head">
                <i class='bx bx-info-circle'></i><span>Informações do Termo</span>
            </div>
            <div class="gar-card-body">
                <div class="gar-grid">
                    <div>
                        <label class="gar-label">Data <span class="req">*</span></label>
                        <input id="dataGarantia" class="gar-input datepicker" type="text"
                               name="dataGarantia" value="<?= date('d/m/Y') ?>" disabled />
                        <div class="gar-obs">Preenchida automaticamente</div>
                    </div>
                    <div>
                        <label class="gar-label">Responsável</label>
                        <input class="gar-input" type="text" name="usuarios_id"
                               value="<?= $this->session->userdata('nome_admin') ?>" disabled />
                    </div>
                    <div>
                        <label class="gar-label">Referência <span class="req">*</span></label>
                        <input type="text" class="gar-input" name="refGarantia" id="refGarantia" required
                               placeholder="Ex: TV, Notebook, Celular..." />
                        <div class="gar-obs">Identifica para qual tipo de equipamento se aplica</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Texto do Termo -->
        <div class="gar-card">
            <div class="gar-card-head">
                <i class='bx bx-file-blank'></i><span>Texto do Termo de Garantia <span style="color:#f87171;">*</span></span>
            </div>
            <div class="gar-card-body">
                <textarea required class="editor" name="textoGarantia" id="textoGarantia"></textarea>
                <div class="gar-obs" style="margin-top:8px;">
                    <i class='bx bx-info-circle'></i>
                    Este texto será impresso no documento de garantia entregue ao cliente ao finalizar uma OS.
                    Use variáveis: <strong style="color:#fbbf24;">{GARANTIA_DIAS}</strong>, <strong style="color:#fbbf24;">{DATA_GARANTIA}</strong>, <strong style="color:#fbbf24;">{CLIENTE}</strong>
                </div>
            </div>
        </div>

        <!-- Footer -->
        <div class="gar-footer">
            <a href="<?= base_url() ?>index.php/garantias" class="gar-btn gar-btn-back">
                <i class='bx bx-x'></i> Cancelar
            </a>
            <button type="submit" class="gar-btn gar-btn-save" id="btnSalvar">
                <i class='bx bx-save'></i> Salvar Termo
            </button>
        </div>

    </form>
</div>

<script>
$(document).ready(function() {
    $(".datepicker").datepicker({ dateFormat: 'dd/mm/yy' });
    $('.editor').trumbowyg({ lang: 'pt_br', semantic: { strikethrough: 's' } });

    $("#formGarantia").validate({
        rules: {
            refGarantia: { required: true }
        },
        messages: {
            refGarantia: { required: 'Campo obrigatório.' }
        },
        errorClass: 'help-inline',
        errorElement: 'span',
        submitHandler: function(form) {
            $('#btnSalvar').attr('disabled', true)
                .html('<i class="bx bx-loader-alt bx-spin"></i> Salvando...');
            form.submit();
        }
    });
});
</script>
