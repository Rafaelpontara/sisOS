<script src="<?= base_url() ?>assets/js/jquery-ui/js/jquery-ui-1.9.2.custom.js"></script>
<script src="<?= base_url() ?>assets/js/jquery.validate.js"></script>
<style>
.df-wrap *,.df-wrap *::before,.df-wrap *::after{box-sizing:border-box;}
.df-wrap .widget-box,.df-wrap .row-fluid,.df-wrap .span12,.df-wrap .form-horizontal,.df-wrap .control-group,.df-wrap .controls,.df-wrap .form-actions{all:unset;display:block;}
.df-wrap{max-width:680px;margin:0 auto;font-family:inherit;}
.df-card{background:#1a1d2e;border:1px solid rgba(255,255,255,0.07);border-radius:14px;overflow:hidden;margin-bottom:14px;}
.df-card-head{display:flex;align-items:center;gap:8px;padding:11px 16px;border-bottom:1px solid rgba(255,255,255,0.06);background:#252a3a;}
.df-card-head i{font-size:15px;}
.df-card-head span{font-size:11px;font-weight:700;color:#9ca3af;text-transform:uppercase;letter-spacing:.8px;}
.df-card-body{padding:18px;}
.df-field{margin-bottom:14px;}
.df-label{font-size:11px;font-weight:700;color:#9ca3af;text-transform:uppercase;letter-spacing:.5px;display:block;margin-bottom:5px;}
.df-label .req{color:#f87171;margin-left:2px;}
.df-input,.df-textarea{width:100%;background:#13151f;border:1px solid #444860;color:#e8eaf0;border-radius:8px;padding:9px 13px;font-size:13px;box-sizing:border-box;transition:border-color .15s;display:block;}
.df-input:focus,.df-textarea:focus{border-color:#6366f1;outline:none;}
.df-textarea{min-height:80px;resize:vertical;}
.df-btn{display:inline-flex;align-items:center;gap:6px;padding:10px 22px;border-radius:8px;font-size:13px;font-weight:700;text-decoration:none;border:none;cursor:pointer;transition:all .15s;}
.df-btn:hover{transform:translateY(-1px);text-decoration:none;}
.df-btn-update{background:linear-gradient(135deg,#6366f1,#4f46e5);color:#fff;box-shadow:0 4px 12px rgba(99,102,241,0.3);}
.df-btn-back{background:rgba(255,255,255,0.07);color:#9ca3af;border:1px solid rgba(255,255,255,0.1);}
.df-btn-back:hover{color:#e8eaf0;}
span.error{color:#f87171!important;font-size:11px!important;}
input.error{border-color:#f87171!important;}
</style>

<div class="df-wrap new122">
    <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:18px;flex-wrap:wrap;gap:10px;">
        <h2 style="font-size:18px;font-weight:800;color:#e8eaf0;display:flex;align-items:center;gap:8px;"><i class='bx bx-file-edit' style="color:#6366f1;"></i> Editar Arquivo</h2>
        <a href="<?= base_url() ?>index.php/arquivos" class="df-btn df-btn-back" style="padding:8px 14px;font-size:12px;"><i class='bx bx-arrow-back'></i> Voltar</a>
    </div>
    <?php echo $custom_error; ?>
    <div class="df-card">
        <div class="df-card-head"><i class='bx bx-file-edit' style="color:#6366f1;"></i><span>Editar Informações do Arquivo</span></div>
        <div class="df-card-body">

            <!-- Info do arquivo atual -->
            <div style="background:#13151f;border:1px solid rgba(255,255,255,0.06);border-radius:10px;padding:12px 14px;margin-bottom:16px;display:flex;align-items:center;gap:12px;">
                <i class='bx bx-file' style="font-size:28px;color:#6b7280;flex-shrink:0;"></i>
                <div>
                    <div style="font-size:13px;font-weight:600;color:#e8eaf0;"><?= htmlspecialchars($result->documento ?? '—') ?></div>
                    <div style="font-size:11px;color:#6b7280;">Arquivo cadastrado em <?= date('d/m/Y', strtotime($result->cadastro)) ?></div>
                </div>
            </div>

            <form action="<?= current_url() ?>" id="formArquivo" method="post">
                <input type="hidden" name="idDocumentos" value="<?= $result->idDocumentos ?>">

                <div class="df-field">
                    <label class="df-label">Nome do Arquivo <span class="req">*</span></label>
                    <input id="nome" type="text" name="nome" class="df-input" value="<?= htmlspecialchars($result->documento) ?>" required>
                </div>

                <div class="df-field">
                    <label class="df-label">Descrição</label>
                    <textarea name="descricao" id="descricao" class="df-textarea"><?= htmlspecialchars($result->descricao ?? '') ?></textarea>
                </div>

                <div class="df-field">
                    <label class="df-label">Data</label>
                    <input id="data" type="text" class="df-input datepicker" name="data"
                           value="<?= date('d/m/Y', strtotime($result->cadastro)) ?>"
                           style="max-width:160px;">
                </div>

                <div style="display:flex;justify-content:flex-end;gap:8px;margin-top:8px;">
                    <a href="<?= base_url() ?>index.php/arquivos" class="df-btn df-btn-back"><i class='bx bx-x'></i> Cancelar</a>
                    <button type="submit" class="df-btn df-btn-update" id="btnSalvar"><i class='bx bx-save'></i> Salvar Alterações</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
$(document).ready(function(){
    $('.datepicker').datepicker({ dateFormat:'dd/mm/yy' });
    $('#formArquivo').validate({
        rules:{ nome:{required:true} },
        messages:{ nome:{required:'Campo obrigatório.'} },
        submitHandler:function(f){$('#btnSalvar').attr('disabled',true).html('<i class="bx bx-loader-alt bx-spin"></i> Salvando...');f.submit();}
    });
});
</script>
