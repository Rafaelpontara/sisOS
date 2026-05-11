<script src="<?= base_url() ?>assets/js/jquery.validate.js"></script>
<script src="<?= base_url() ?>assets/js/maskmoney.js"></script>
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
.df-input,.df-select,.df-textarea{width:100%;background:#13151f;border:1px solid #444860;color:#e8eaf0;border-radius:8px;padding:9px 13px;font-size:13px;box-sizing:border-box;transition:border-color .15s;display:block;-webkit-appearance:none;}
.df-input:focus,.df-select:focus,.df-textarea:focus{border-color:#6366f1;outline:none;}
.df-select{height:38px;}
.df-textarea{min-height:90px;resize:vertical;}
.df-hint{font-size:11px;color:#6b7280;margin-top:4px;}
.df-btn{display:inline-flex;align-items:center;gap:6px;padding:10px 22px;border-radius:8px;font-size:13px;font-weight:700;text-decoration:none;border:none;cursor:pointer;transition:all .15s;}
.df-btn:hover{transform:translateY(-1px);text-decoration:none;}
.df-btn-save{background:linear-gradient(135deg,#22c55e,#16a34a);color:#fff;box-shadow:0 4px 12px rgba(34,197,94,0.3);}
.df-btn-update{background:linear-gradient(135deg,#6366f1,#4f46e5);color:#fff;box-shadow:0 4px 12px rgba(99,102,241,0.3);}
.df-btn-back{background:rgba(255,255,255,0.07);color:#9ca3af;border:1px solid rgba(255,255,255,0.1);}
.df-btn-back:hover{color:#e8eaf0;}
span.error{color:#f87171!important;font-size:11px!important;}
input.error,select.error,textarea.error{border-color:#f87171!important;}
/* trumbowyg dark */
.trumbowyg-box{border-radius:10px!important;overflow:hidden;border:1px solid #444860!important;}
.trumbowyg-button-pane{background:#252a3a!important;border-bottom:1px solid #444860!important;border-radius:10px 10px 0 0!important;}
.trumbowyg-button-pane button{color:#9ca3af!important;}
.trumbowyg-button-pane button:hover,.trumbowyg-button-pane button.trumbowyg-active{background:rgba(255,255,255,0.08)!important;color:#e8eaf0!important;}
.trumbowyg-editor{background:#13151f!important;color:#e8eaf0!important;border:none!important;border-radius:0 0 10px 10px!important;min-height:120px!important;padding:10px 14px!important;font-size:13px!important;}
</style>
<div class="df-wrap new122">
    <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:18px;flex-wrap:wrap;gap:10px;">
        <h2 style="font-size:18px;font-weight:800;color:#e8eaf0;display:flex;align-items:center;gap:8px;"><i class='bx bx-wrench' style="color:#6366f1;"></i> Editar Serviço</h2>
        <a href="<?= base_url() ?>index.php/servicos" class="df-btn df-btn-back" style="padding:8px 14px;font-size:12px;"><i class='bx bx-arrow-back'></i> Voltar</a>
    </div>
    <?php echo $custom_error; ?>
    <div class="df-card">
        <div class="df-card-head"><i class='bx bx-wrench' style="color:#6366f1;"></i><span>Dados do Serviço</span></div>
        <div class="df-card-body">
            <form action="<?= current_url() ?>" id="formServico" method="post">
                <?php echo form_hidden('idServicos', $result->idServicos) ?>
                <div class="df-field"><label class="df-label">Nome <span class="req">*</span></label><input id="nome" type="text" name="nome" class="df-input" value="<?= $result->nome ?>" required></div>
                <div class="df-field"><label class="df-label">Preço <span class="req">*</span></label><input id="preco" class="df-input money" data-affixes-stay="true" data-thousands="" data-decimal="." type="text" name="preco" value="<?= $result->preco ?>" required></div>
                <div class="df-field"><label class="df-label">Descrição</label><input id="descricao" type="text" name="descricao" class="df-input" value="<?= htmlspecialchars($result->descricao??'') ?>"></div>
                <div style="display:flex;justify-content:flex-end;gap:8px;margin-top:8px;">
                    <a href="<?= base_url() ?>index.php/servicos" class="df-btn df-btn-back"><i class='bx bx-x'></i> Cancelar</a>
                    <button type="submit" class="df-btn df-btn-update" id="btnSalvar"><i class='bx bx-save'></i> Salvar Alterações</button>
                </div>
            </form>
        </div>
    </div>
</div>
<script>$(document).ready(function(){$('.money').maskMoney();$('#formServico').validate({rules:{nome:{required:true},preco:{required:true}},messages:{nome:{required:'Campo obrigatório.'},preco:{required:'Campo obrigatório.'}},submitHandler:function(f){$('#btnSalvar').attr('disabled',true).html('<i class="bx bx-loader-alt bx-spin"></i> Salvando...');f.submit();}});});</script>
