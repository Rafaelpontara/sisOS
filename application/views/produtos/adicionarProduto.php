<script src="<?= base_url() ?>assets/js/jquery.validate.js"></script>
<script src="<?= base_url() ?>assets/js/maskmoney.js"></script>
<style>
.fp-wrap *,.fp-wrap *::before,.fp-wrap *::after{box-sizing:border-box;}
.fp-wrap .widget-box,.fp-wrap .row-fluid,.fp-wrap .span12,.fp-wrap .span6,.fp-wrap .span4,.fp-wrap .span3,.fp-wrap .span2,.fp-wrap .form-horizontal,.fp-wrap .control-group,.fp-wrap .controls,.fp-wrap .form-actions{all:unset;display:block;}
.fp-wrap{max-width:860px;margin:0 auto;font-family:inherit;}
.fp-card{background:#1a1d2e;border:1px solid rgba(255,255,255,0.07);border-radius:14px;overflow:hidden;margin-bottom:14px;}
.fp-card-head{display:flex;align-items:center;gap:8px;padding:11px 16px;border-bottom:1px solid rgba(255,255,255,0.06);background:#252a3a;}
.fp-card-head i{font-size:15px;}
.fp-card-head span{font-size:11px;font-weight:700;color:#9ca3af;text-transform:uppercase;letter-spacing:.8px;}
.fp-card-body{padding:18px;}
.fp-grid{display:grid;grid-template-columns:1fr 1fr;gap:14px;}
.fp-grid-3{display:grid;grid-template-columns:1fr 1fr 1fr;gap:14px;}
@media(max-width:640px){.fp-grid,.fp-grid-3{grid-template-columns:1fr;}}
.fp-field{margin-bottom:0;}
.fp-label{font-size:11px;font-weight:700;color:#9ca3af;text-transform:uppercase;letter-spacing:.5px;display:block;margin-bottom:5px;}
.fp-label .req{color:#f87171;margin-left:2px;}
.fp-input,.fp-select,.fp-textarea{width:100%;background:#13151f;border:1px solid #444860;color:#e8eaf0;border-radius:8px;padding:9px 13px;font-size:13px;box-sizing:border-box;transition:border-color .15s;display:block;-webkit-appearance:none;}
.fp-input:focus,.fp-select:focus,.fp-textarea:focus{border-color:#8b5cf6;outline:none;}
.fp-select{height:38px;}
.fp-textarea{min-height:80px;resize:vertical;}
.fp-hint{font-size:11px;color:#6b7280;margin-top:4px;}
.fp-toggle-wrap{display:flex;gap:8px;flex-wrap:wrap;}
.fp-toggle{display:flex;align-items:center;gap:8px;padding:8px 14px;border-radius:8px;background:#13151f;border:1px solid #444860;cursor:pointer;font-size:13px;color:#9ca3af;transition:all .15s;user-select:none;}
.fp-toggle:has(input:checked){background:rgba(139,92,246,0.12);border-color:rgba(139,92,246,0.4);color:#c084fc;}
.fp-toggle input{display:none;}
.fp-toggle-check{width:18px;height:18px;border-radius:4px;border:2px solid #444860;display:inline-flex;align-items:center;justify-content:center;flex-shrink:0;font-size:11px;transition:all .15s;}
.fp-toggle:has(input:checked) .fp-toggle-check{background:#8b5cf6;border-color:#8b5cf6;color:#fff;}
.fp-calc{background:#13151f;border:1px solid #444860;border-radius:10px;padding:14px;}
.fp-calc-title{font-size:11px;font-weight:700;color:#9ca3af;text-transform:uppercase;letter-spacing:.8px;margin-bottom:10px;}
.fp-foto-preview img{max-height:80px;max-width:120px;object-fit:contain;border-radius:8px;margin-top:8px;}
.fp-btn{display:inline-flex;align-items:center;gap:6px;padding:10px 22px;border-radius:8px;font-size:13px;font-weight:700;text-decoration:none;border:none;cursor:pointer;transition:all .15s;}
.fp-btn:hover{transform:translateY(-1px);text-decoration:none;}
.fp-btn-save{background:linear-gradient(135deg,#22c55e,#16a34a);color:#fff;box-shadow:0 4px 12px rgba(34,197,94,0.3);}
.fp-btn-back{background:rgba(255,255,255,0.07);color:#9ca3af;border:1px solid rgba(255,255,255,0.1);}
.fp-btn-back:hover{color:#e8eaf0;}
.fp-margem{font-size:12px;color:#4ade80;margin-top:4px;display:none;}
span.error{color:#f87171!important;font-size:11px!important;}
input.error,select.error{border-color:#f87171!important;}
</style>

<div class="fp-wrap new122">
    <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:18px;flex-wrap:wrap;gap:10px;">
        <h2 style="font-size:18px;font-weight:800;color:#e8eaf0;display:flex;align-items:center;gap:8px;"><i class='bx bx-package' style="color:#8b5cf6;"></i> Cadastro de Produto</h2>
        <a href="<?= base_url() ?>index.php/produtos" class="fp-btn fp-btn-back" style="padding:8px 14px;font-size:12px;"><i class='bx bx-arrow-back'></i> Voltar</a>
    </div>
    <?php echo $custom_error; ?>
    <form action="<?= current_url() ?>" id="formProduto" method="post" enctype="multipart/form-data">

        <!-- Identificação -->
        <div class="fp-card">
            <div class="fp-card-head"><i class='bx bx-barcode' style="color:#8b5cf6;"></i><span>Identificação</span></div>
            <div class="fp-card-body">
                <div class="fp-grid">
                    <div class="fp-field"><label class="fp-label">Descrição <span class="req">*</span></label><input id="descricao" type="text" name="descricao" class="fp-input" value="<?= set_value('descricao') ?>" required></div>
                    <div class="fp-field"><label class="fp-label">Código de Barras</label><input id="codDeBarra" type="text" name="codDeBarra" class="fp-input" value="<?= set_value('codDeBarra') ?>"></div>
                    <div class="fp-field"><label class="fp-label">Marca</label><input type="text" name="marca" class="fp-input" value="<?= set_value('marca') ?>" placeholder="Ex: Samsung, Dell..."></div>
                    <div class="fp-field"><label class="fp-label">Modelo</label><input type="text" name="modelo" class="fp-input" value="<?= set_value('modelo') ?>" placeholder="Ex: Galaxy A54..."></div>
                    <div class="fp-field"><label class="fp-label">NCM</label><input type="text" name="ncm" class="fp-input" maxlength="10" value="<?= set_value('ncm') ?>" placeholder="00000000"><div class="fp-hint">Código fiscal para NF-e</div></div>
                    <div class="fp-field"><label class="fp-label">Localização no Estoque</label><input type="text" name="localizacao" class="fp-input" value="<?= set_value('localizacao') ?>" placeholder="Ex: Prateleira A3"><div class="fp-hint">Onde o produto está fisicamente</div></div>
                </div>
                <div style="margin-top:14px;">
                    <label class="fp-label">Tipo de Movimento</label>
                    <div class="fp-toggle-wrap">
                        <label class="fp-toggle"><input type="checkbox" name="entrada" value="1" checked><div class="fp-toggle-check">✓</div><span>Entrada</span></label>
                        <label class="fp-toggle"><input type="checkbox" name="saida" value="1" checked><div class="fp-toggle-check">✓</div><span>Saída</span></label>
                    </div>
                </div>
            </div>
        </div>

        <!-- Preços -->
        <div class="fp-card">
            <div class="fp-card-head"><i class='bx bx-dollar-circle' style="color:#fbbf24;"></i><span>Preços & Margem</span></div>
            <div class="fp-card-body">
                <div class="fp-grid-3" style="margin-bottom:14px;">
                    <div class="fp-field"><label class="fp-label">Preço de Compra <span class="req">*</span></label><input id="precoCompra" class="fp-input money" data-affixes-stay="true" data-thousands="" data-decimal="." type="text" name="precoCompra" value="<?= set_value('precoCompra') ?>" required></div>
                    <div class="fp-field"><label class="fp-label">Preço de Venda <span class="req">*</span></label><input id="precoVenda" class="fp-input money" data-affixes-stay="true" data-thousands="" data-decimal="." type="text" name="precoVenda" value="<?= set_value('precoVenda') ?>" required><div class="fp-margem" id="margemResult"></div></div>
                    <div class="fp-field"><label class="fp-label">Garantia (dias)</label><input type="number" name="garantia_dias" class="fp-input" value="<?= set_value('garantia_dias','0') ?>" min="0" placeholder="0"><div class="fp-hint">0 = sem garantia</div></div>
                </div>
                <div class="fp-calc">
                    <div class="fp-calc-title"><i class='bx bx-calculator' style="color:#fbbf24;"></i> Calculadora de Margem</div>
                    <div style="display:flex;gap:10px;align-items:flex-end;flex-wrap:wrap;">
                        <div><label class="fp-label">Tipo</label><select id="selectLucro" name="selectLucro" class="fp-select" style="width:160px;"><option value="markup">Markup (%)</option><option value="margemLucro">Margem de Lucro (%)</option></select></div>
                        <div><label class="fp-label">Percentual</label><input id="Lucro" name="Lucro" type="text" class="fp-input" style="width:80px;" placeholder="%" maxlength="5"></div>
                        <span style="font-size:11px;color:#6b7280;padding-bottom:2px;">Markup: sobre custo &nbsp;·&nbsp; Margem: sobre venda</span>
                        <span style="color:#f87171;font-size:11px;padding-bottom:2px;" id="errorAlert"></span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Estoque -->
        <div class="fp-card">
            <div class="fp-card-head"><i class='bx bx-store' style="color:#22c55e;"></i><span>Estoque & Classificação</span></div>
            <div class="fp-card-body">
                <div class="fp-grid">
                    <div class="fp-field"><label class="fp-label">Unidade <span class="req">*</span></label><select id="unidade" name="unidade" class="fp-select" required></select></div>
                    <div class="fp-field"><label class="fp-label">Estoque Atual <span class="req">*</span></label><input id="estoque" type="number" name="estoque" class="fp-input" value="<?= set_value('estoque','0') ?>" required min="0"></div>
                    <div class="fp-field"><label class="fp-label">Estoque Mínimo</label><input id="estoqueMinimo" type="number" name="estoqueMinimo" class="fp-input" value="<?= set_value('estoqueMinimo','0') ?>" min="0"></div>
                    <div class="fp-field">
                        <label class="fp-label">Categoria</label>
                        <?php $this->load->model('categorias_model'); $cats=$this->categorias_model->getParaSelect(); ?>
                        <select name="categorias_id" class="fp-select">
                            <option value="">Sem categoria</option>
                            <?php foreach($cats as $grupo): ?>
                            <optgroup label="<?= htmlspecialchars($grupo['grupo']->categoria) ?>">
                                <?php foreach($grupo['filhos'] as $f): ?>
                                <option value="<?= $f->idCategorias ?>"><?= htmlspecialchars($f->categoria) ?></option>
                                <?php endforeach; ?>
                            </optgroup>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
            </div>
        </div>

        <!-- Foto & Obs -->
        <div class="fp-card">
            <div class="fp-card-head"><i class='bx bx-image' style="color:#60a5fa;"></i><span>Foto & Observações</span></div>
            <div class="fp-card-body">
                <div class="fp-grid">
                    <div class="fp-field">
                        <label class="fp-label">Foto do Produto</label>
                        <input type="file" name="foto" accept="image/*" id="inputFoto" style="background:#13151f;border:1px solid #444860;color:#e8eaf0;border-radius:8px;padding:7px 12px;font-size:13px;width:100%;">
                        <div class="fp-hint">JPG, PNG ou WebP. Máx 3MB.</div>
                        <div id="previewFoto" class="fp-foto-preview"></div>
                    </div>
                    <div class="fp-field"><label class="fp-label">Observações</label><textarea name="observacoes" class="fp-textarea"><?= set_value('observacoes') ?></textarea></div>
                </div>
            </div>
        </div>

        <div style="display:flex;justify-content:flex-end;gap:8px;padding:4px 0 8px;">
            <a href="<?= base_url() ?>index.php/produtos" class="fp-btn fp-btn-back"><i class='bx bx-x'></i> Cancelar</a>
            <button type="submit" class="fp-btn fp-btn-save" id="btnSalvar"><i class='bx bx-plus-circle'></i> Cadastrar Produto</button>
        </div>
    </form>
</div>

<script>
$(document).ready(function(){
    $('.money').maskMoney();
    $('#inputFoto').on('change',function(){var r=new FileReader();r.onload=function(e){$('#previewFoto').html('<img src="'+e.target.result+'">');};r.readAsDataURL(this.files[0]);});
    $.getJSON('<?= base_url() ?>assets/json/tabela_medidas.json',function(data){$.each(data.medidas,function(i,m){$('#unidade').append(new Option(m.descricao,m.sigla));});});
    function calcMargem(){var c=parseFloat($('#precoCompra').val())||0,v=parseFloat($('#precoVenda').val())||0;if(c>0&&v>0){var m=((v-c)/v*100).toFixed(1);$('#margemResult').text('Margem: '+m+'% | Lucro: R$'+(v-c).toFixed(2)).show();}else{$('#margemResult').hide();}}
    function calcLucro(c,l){return $('#selectLucro').val()==='markup'?(c*(1+l/100)).toFixed(2):(c/(1-l/100)).toFixed(2);}
    $('#Lucro').keyup(function(){this.value=this.value.replace(/[^0-9.]/g,'');var c=parseFloat($('#precoCompra').val())||0;if(!c){$('#errorAlert').text('Preencha o preço de compra primeiro.');$('#Lucro').val('');return;}$('#errorAlert').text('');$('#precoVenda').val(calcLucro(c,parseFloat($(this).val())||0));calcMargem();});
    $('#precoCompra,#selectLucro').on('change input',function(){var l=parseFloat($('#Lucro').val())||0;if(l>0){$('#precoVenda').val(calcLucro(parseFloat($('#precoCompra').val())||0,l));}calcMargem();});
    $('#precoVenda').focusout(function(){var v=parseFloat($(this).val())||0,c=parseFloat($('#precoCompra').val())||0;if(v>0&&v<c){$('#errorAlert').text('Preço de venda menor que o de compra!').css('color','#f87171');}else{$('#errorAlert').text('');}calcMargem();});
    $('#formProduto').validate({rules:{descricao:{required:true},unidade:{required:true},precoCompra:{required:true},precoVenda:{required:true},estoque:{required:true}},messages:{descricao:{required:'Campo obrigatório.'},unidade:{required:'Campo obrigatório.'},precoCompra:{required:'Campo obrigatório.'},precoVenda:{required:'Campo obrigatório.'},estoque:{required:'Campo obrigatório.'}},submitHandler:function(f){$('#btnSalvar').attr('disabled',true).html('<i class="bx bx-loader-alt bx-spin"></i> Salvando...');f.submit();}});
});
</script>
