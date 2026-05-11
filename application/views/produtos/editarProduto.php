<script src="<?= base_url() ?>assets/js/jquery.validate.js"></script>
<script src="<?= base_url() ?>assets/js/maskmoney.js"></script>

<style>
.ep-wrap *,.ep-wrap *::before,.ep-wrap *::after{box-sizing:border-box;}
.ep-wrap .widget-box,.ep-wrap .row-fluid,.ep-wrap .span12,.ep-wrap .span6,.ep-wrap .span4,.ep-wrap .span3,.ep-wrap .span2{all:unset;display:block;}
.ep-wrap{font-family:inherit;max-width:900px;margin:0 auto;}

.ep-header{display:flex;align-items:center;justify-content:space-between;margin-bottom:20px;flex-wrap:wrap;gap:10px;}
.ep-title{font-size:18px;font-weight:800;color:#e8eaf0;display:flex;align-items:center;gap:8px;}
.ep-title i{font-size:20px;color:#8b5cf6;}

.ep-card{background:#1a1d2e;border:1px solid rgba(255,255,255,0.07);border-radius:14px;overflow:hidden;margin-bottom:14px;}
.ep-card-head{display:flex;align-items:center;gap:8px;padding:11px 16px;border-bottom:1px solid rgba(255,255,255,0.06);background:#252a3a;}
.ep-card-head i{font-size:15px;color:#8b5cf6;}
.ep-card-head span{font-size:11px;font-weight:700;color:#9ca3af;text-transform:uppercase;letter-spacing:.8px;}
.ep-card-body{padding:18px;}

.ep-grid{display:grid;grid-template-columns:1fr 1fr;gap:14px;}
.ep-grid-3{display:grid;grid-template-columns:1fr 1fr 1fr;gap:14px;}
@media(max-width:640px){.ep-grid,.ep-grid-3{grid-template-columns:1fr;}}
.ep-field{margin-bottom:0;}
.ep-label{font-size:11px;font-weight:700;color:#9ca3af;text-transform:uppercase;letter-spacing:.5px;display:block;margin-bottom:5px;}
.ep-label .req{color:#f87171;margin-left:2px;}
.ep-input,.ep-select,.ep-textarea{width:100%;background:#13151f;border:1px solid #444860;color:#e8eaf0;border-radius:8px;padding:9px 13px;font-size:13px;box-sizing:border-box;transition:border-color .15s;display:block;-webkit-appearance:none;}
.ep-input:focus,.ep-select:focus,.ep-textarea:focus{border-color:#8b5cf6;outline:none;}
.ep-select{height:38px;}
.ep-textarea{min-height:90px;resize:vertical;}
.ep-input.readonly-field{background:#1a1d2e;color:#fbbf24;font-weight:700;cursor:default;}

.ep-inline-row{display:flex;gap:10px;align-items:flex-end;flex-wrap:wrap;}
.ep-inline-row .ep-input-sm{width:90px!important;flex-shrink:0;}

.ep-toggle-wrap{display:flex;gap:8px;flex-wrap:wrap;}
.ep-toggle-label{display:flex;align-items:center;gap:8px;padding:8px 14px;border-radius:8px;background:#13151f;border:1px solid #444860;cursor:pointer;font-size:13px;color:#9ca3af;transition:all .15s;user-select:none;}
.ep-toggle-label input[type=checkbox]{display:none;}
.ep-toggle-label input:checked ~ span{color:#8b5cf6;}
.ep-toggle-label:has(input:checked){background:rgba(139,92,246,0.12);border-color:rgba(139,92,246,0.4);color:#c084fc;}
.ep-toggle-check{width:18px;height:18px;border-radius:4px;border:2px solid #444860;display:inline-flex;align-items:center;justify-content:center;flex-shrink:0;transition:all .15s;font-size:11px;font-weight:700;}
.ep-toggle-label:has(input:checked) .ep-toggle-check{background:#8b5cf6;border-color:#8b5cf6;color:#fff;}

.ep-margem-hint{font-size:11px;color:#f87171;display:none;margin-top:3px;}
.ep-margem-result{font-size:12px;color:#4ade80;margin-top:3px;font-weight:600;display:none;}

.ep-foto-preview{display:flex;align-items:center;gap:12px;padding:10px 14px;background:#252a3a;border-radius:10px;border:1px solid rgba(255,255,255,0.06);margin-bottom:10px;}
.ep-foto-preview img{max-height:70px;max-width:100px;object-fit:contain;border-radius:6px;}

.ep-btn{display:inline-flex;align-items:center;gap:6px;padding:10px 22px;border-radius:8px;font-size:13px;font-weight:700;text-decoration:none;border:none;cursor:pointer;transition:all .15s;}
.ep-btn:hover{transform:translateY(-1px);text-decoration:none;}
.ep-btn-save{background:linear-gradient(135deg,#22c55e,#16a34a);color:#fff;box-shadow:0 4px 12px rgba(34,197,94,0.3);}
.ep-btn-back{background:rgba(255,255,255,0.07);color:#9ca3af;border:1px solid rgba(255,255,255,0.1);}
.ep-btn-back:hover{color:#e8eaf0;}

label.error{color:#f87171!important;font-size:11px!important;}
input.error,select.error{border-color:#f87171!important;}
</style>

<div class="ep-wrap new122">

    <div class="ep-header">
        <div class="ep-title">
            <i class='bx bx-package'></i>
            Editar Produto
        </div>
        <a href="<?= base_url() ?>index.php/produtos" class="ep-btn ep-btn-back" style="padding:8px 14px;font-size:12px;">
            <i class='bx bx-arrow-back'></i> Voltar
        </a>
    </div>

    <?php echo $custom_error; ?>

    <form action="<?= current_url() ?>" id="formProduto" method="post" enctype="multipart/form-data">
        <?= form_hidden('idProdutos', $result->idProdutos) ?>

        <!-- ── Identificação ── -->
        <div class="ep-card">
            <div class="ep-card-head"><i class='bx bx-barcode'></i><span>Identificação</span></div>
            <div class="ep-card-body">
                <div class="ep-grid">
                    <div class="ep-field">
                        <label class="ep-label">Descrição <span class="req">*</span></label>
                        <input id="descricao" type="text" name="descricao" class="ep-input" value="<?= htmlspecialchars($result->descricao) ?>" required />
                    </div>
                    <div class="ep-field">
                        <label class="ep-label">Código de Barras</label>
                        <input id="codDeBarra" type="text" name="codDeBarra" class="ep-input" value="<?= htmlspecialchars($result->codDeBarra??'') ?>" />
                    </div>
                    <div class="ep-field">
                        <label class="ep-label">Marca</label>
                        <input type="text" name="marca" class="ep-input" value="<?= htmlspecialchars($result->marca??'') ?>" />
                    </div>
                    <div class="ep-field">
                        <label class="ep-label">Modelo</label>
                        <input type="text" name="modelo" class="ep-input" value="<?= htmlspecialchars($result->modelo??'') ?>" />
                    </div>
                    <div class="ep-field">
                        <label class="ep-label">NCM</label>
                        <input type="text" name="ncm" class="ep-input" maxlength="10" value="<?= htmlspecialchars($result->ncm??'') ?>" placeholder="Ex: 85171231" />
                    </div>
                    <div class="ep-field">
                        <label class="ep-label">Localização (prateleira)</label>
                        <input type="text" name="localizacao" class="ep-input" value="<?= htmlspecialchars($result->localizacao??'') ?>" placeholder="Ex: Prateleira A3" />
                    </div>
                </div>

                <div style="margin-top:14px;">
                    <label class="ep-label">Tipo de Movimento</label>
                    <div class="ep-toggle-wrap">
                        <label class="ep-toggle-label">
                            <input type="checkbox" name="entrada" value="1" id="chkEntrada" <?= ($result->entrada==1)?'checked':'' ?>>
                            <div class="ep-toggle-check">✓</div>
                            <span>Entrada</span>
                        </label>
                        <label class="ep-toggle-label">
                            <input type="checkbox" name="saida" value="1" id="chkSaida" <?= ($result->saida==1)?'checked':'' ?>>
                            <div class="ep-toggle-check">✓</div>
                            <span>Saída</span>
                        </label>
                    </div>
                </div>
            </div>
        </div>

        <!-- ── Preços ── -->
        <div class="ep-card">
            <div class="ep-card-head"><i class='bx bx-dollar-circle'></i><span>Preços & Margem</span></div>
            <div class="ep-card-body">
                <div class="ep-grid-3" style="margin-bottom:14px;">
                    <div class="ep-field">
                        <label class="ep-label">Preço de Compra <span class="req">*</span></label>
                        <input id="precoCompra" class="ep-input money" data-affixes-stay="true" data-thousands="" data-decimal="."
                            type="text" name="precoCompra" value="<?= $result->precoCompra ?>" required />
                        <span class="ep-margem-hint" id="alertaCompra">Preencha o preço de compra primeiro.</span>
                    </div>
                    <div class="ep-field">
                        <label class="ep-label">Preço de Venda <span class="req">*</span></label>
                        <input id="precoVenda" class="ep-input money" data-affixes-stay="true" data-thousands="" data-decimal="."
                            type="text" name="precoVenda" value="<?= $result->precoVenda ?>" required />
                        <div class="ep-margem-result" id="margemResult"></div>
                    </div>
                    <div class="ep-field">
                        <label class="ep-label">Garantia do Produto (dias)</label>
                        <input type="number" name="garantia_dias" class="ep-input" value="<?= $result->garantia_dias??0 ?>" min="0" placeholder="0" />
                    </div>
                </div>

                <!-- Calculadora de lucro -->
                <div style="background:#13151f;border:1px solid #444860;border-radius:10px;padding:14px;">
                    <div style="font-size:11px;font-weight:700;color:#9ca3af;text-transform:uppercase;letter-spacing:.8px;margin-bottom:10px;">
                        <i class='bx bx-calculator' style="color:#fbbf24;"></i> Calculadora de Margem
                    </div>
                    <div class="ep-inline-row">
                        <div>
                            <label class="ep-label">Tipo</label>
                            <select id="selectLucro" name="selectLucro" class="ep-select" style="width:160px;">
                                <option value="markup">Markup (%)</option>
                                <option value="margemLucro">Margem de Lucro (%)</option>
                            </select>
                        </div>
                        <div>
                            <label class="ep-label">Percentual</label>
                            <input id="Lucro" name="Lucro" type="text" class="ep-input ep-input-sm" placeholder="%" maxlength="5" />
                        </div>
                        <div style="align-self:flex-end;">
                            <span style="font-size:11px;color:#6b7280;line-height:1.5;display:block;">
                                Markup: % sobre custo &nbsp;·&nbsp; Margem: % sobre venda
                            </span>
                            <span style="color:#f87171;font-size:11px;" id="errorAlert"></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- ── Estoque ── -->
        <div class="ep-card">
            <div class="ep-card-head"><i class='bx bx-store'></i><span>Estoque & Unidade</span></div>
            <div class="ep-card-body">
                <div class="ep-grid">
                    <div class="ep-field">
                        <label class="ep-label">Unidade <span class="req">*</span></label>
                        <select id="unidade" name="unidade" class="ep-select" required></select>
                    </div>
                    <div class="ep-field">
                        <label class="ep-label">Estoque Atual <span class="req">*</span></label>
                        <input id="estoque" type="number" name="estoque" class="ep-input" value="<?= $result->estoque ?>" required min="0" />
                    </div>
                    <div class="ep-field">
                        <label class="ep-label">Estoque Mínimo</label>
                        <input id="estoqueMinimo" type="number" name="estoqueMinimo" class="ep-input" value="<?= $result->estoqueMinimo ?>" min="0" />
                    </div>
                    <div class="ep-field">
                        <label class="ep-label">Categoria</label>
                        <?php
                        $this->load->model('categorias_model');
                        $cats = $this->categorias_model->getParaSelect();
                        ?>
                        <select name="categorias_id" class="ep-select">
                            <option value="">Sem categoria</option>
                            <?php foreach ($cats as $grupo): ?>
                            <optgroup label="<?= htmlspecialchars($grupo['grupo']->categoria) ?>">
                                <?php foreach ($grupo['filhos'] as $f): ?>
                                <option value="<?= $f->idCategorias ?>" <?= ($result->categorias_id??0)==$f->idCategorias?'selected':'' ?>>
                                    <?= htmlspecialchars($f->categoria) ?>
                                </option>
                                <?php endforeach; ?>
                            </optgroup>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
            </div>
        </div>

        <!-- ── Foto & Obs ── -->
        <div class="ep-card">
            <div class="ep-card-head"><i class='bx bx-image'></i><span>Foto & Observações</span></div>
            <div class="ep-card-body">
                <div class="ep-grid">
                    <div class="ep-field">
                        <label class="ep-label">Foto do Produto</label>
                        <?php if (!empty($result->foto)): ?>
                        <div class="ep-foto-preview">
                            <img src="<?= $result->foto ?>" alt="Foto atual" id="previewFoto">
                            <div>
                                <div style="font-size:12px;font-weight:600;color:#c9cad6;">Foto atual</div>
                                <div style="font-size:11px;color:#6b7280;margin-top:2px;">Selecione nova foto para substituir</div>
                            </div>
                        </div>
                        <?php else: ?>
                        <div id="previewFoto"></div>
                        <?php endif; ?>
                        <input type="file" name="foto" accept="image/*" id="inputFoto"
                            style="background:#13151f;border:1px solid #444860;color:#e8eaf0;border-radius:8px;padding:7px 12px;font-size:12px;width:100%;" />
                        <div style="font-size:11px;color:#6b7280;margin-top:4px;">Deixe vazio para manter a foto atual.</div>
                    </div>
                    <div class="ep-field">
                        <label class="ep-label">Observações</label>
                        <textarea name="observacoes" class="ep-textarea"><?= htmlspecialchars($result->observacoes??'') ?></textarea>
                    </div>
                </div>
            </div>
        </div>

        <!-- ── Ações ── -->
        <div style="display:flex;justify-content:flex-end;gap:8px;padding:4px 0 8px;">
            <a href="<?= base_url() ?>index.php/produtos" class="ep-btn ep-btn-back">
                <i class='bx bx-x'></i> Cancelar
            </a>
            <button type="submit" class="ep-btn ep-btn-save" id="btnSalvarProd">
                <i class='bx bx-save'></i> Salvar Produto
            </button>
        </div>

    </form>
</div>

<script>
$(document).ready(function() {
    // Máscara dinheiro
    $('.money').maskMoney();

    // Preview foto
    $('#inputFoto').on('change', function() {
        var r = new FileReader();
        r.onload = function(e) {
            if ($('#previewFoto').is('img')) {
                $('#previewFoto').attr('src', e.target.result);
            } else {
                $('#previewFoto').html('<div class="ep-foto-preview"><img src="'+e.target.result+'" style="max-height:70px;border-radius:6px;"><div style="font-size:12px;color:#4ade80;font-weight:600;">Nova foto selecionada</div></div>');
            }
        };
        r.readAsDataURL(this.files[0]);
    });

    // Calculadora de lucro
    function calcPrecoVenda() {
        var compra = parseFloat($('#precoCompra').val()) || 0;
        var lucro  = parseFloat($('#Lucro').val()) || 0;
        var tipo   = $('#selectLucro').val();
        if (compra <= 0 || lucro <= 0) return;
        var venda = tipo === 'markup'
            ? (compra * (1 + lucro / 100)).toFixed(2)
            : (compra / (1 - lucro / 100)).toFixed(2);
        $('#precoVenda').val(venda);
        var margem = ((venda - compra) / venda * 100).toFixed(1);
        $('#margemResult').text('Margem: ' + margem + '% | Lucro: R$ ' + (venda - compra).toFixed(2)).show();
    }

    $('#Lucro').on('keyup', function() {
        this.value = this.value.replace(/[^0-9.]/g,'');
        var compra = parseFloat($('#precoCompra').val()) || 0;
        if (!compra) { $('#alertaCompra').show(); $('#Lucro').val(''); return; }
        $('#alertaCompra').hide();
        calcPrecoVenda();
    });
    $('#precoCompra, #selectLucro').on('change input', calcPrecoVenda);

    $('#precoVenda').on('focusout', function() {
        var venda  = parseFloat($(this).val()) || 0;
        var compra = parseFloat($('#precoCompra').val()) || 0;
        if (venda > 0 && compra > 0) {
            var margem = ((venda - compra) / venda * 100).toFixed(1);
            $('#margemResult').text('Margem: ' + margem + '% | Lucro: R$ ' + (venda - compra).toFixed(2)).show();
        }
        if (venda < compra && venda > 0) {
            $('#errorAlert').text('Preço de venda menor que o de compra!').css('color','#f87171');
        } else {
            $('#errorAlert').text('');
        }
    });

    // Carregar unidades
    $.getJSON('<?= base_url() ?>assets/json/tabela_medidas.json', function(data) {
        $.each(data.medidas, function(i, m) {
            $('#unidade').append(new Option(m.descricao, m.sigla));
        });
        $('#unidade option[value="<?= $result->unidade ?>"]').prop('selected', true);
    });

    // Validação
    $('#formProduto').validate({
        rules: {
            descricao:  { required: true },
            unidade:    { required: true },
            precoCompra:{ required: true },
            precoVenda: { required: true },
            estoque:    { required: true }
        },
        messages: {
            descricao:   { required: 'Campo obrigatório.' },
            unidade:     { required: 'Selecione uma unidade.' },
            precoCompra: { required: 'Campo obrigatório.' },
            precoVenda:  { required: 'Campo obrigatório.' },
            estoque:     { required: 'Campo obrigatório.' }
        },
        submitHandler: function(form) {
            $('#btnSalvarProd').attr('disabled',true).html('<i class="bx bx-loader-alt bx-spin"></i> Salvando...');
            form.submit();
        }
    });
});
</script>
