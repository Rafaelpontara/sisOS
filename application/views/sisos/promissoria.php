<style>
/* ── Layout dark ── */
.prom-wrap{max-width:900px;margin:0 auto;}
.prom-header{display:flex;align-items:center;justify-content:space-between;margin-bottom:20px;flex-wrap:wrap;gap:10px;}
.prom-title{display:flex;align-items:center;gap:10px;}
.prom-title i{font-size:24px;color:#fbbf24;}
.prom-title h2{font-size:20px;font-weight:800;color:#e8eaf0;margin:0;}

.prom-card{background:#1a1d2e;border:1px solid rgba(255,255,255,0.07);border-radius:14px;overflow:hidden;margin-bottom:14px;}
.prom-card-head{display:flex;align-items:center;gap:8px;padding:12px 18px;border-bottom:1px solid rgba(255,255,255,0.06);background:#252a3a;}
.prom-card-head i{font-size:15px;color:#fbbf24;}
.prom-card-head span{font-size:11px;font-weight:700;color:#9ca3af;text-transform:uppercase;letter-spacing:.8px;}
.prom-card-body{padding:20px;}

.prom-grid{display:grid;grid-template-columns:1fr 1fr;gap:14px;}
.prom-grid-3{display:grid;grid-template-columns:1fr 1fr 1fr;gap:14px;}
@media(max-width:640px){.prom-grid,.prom-grid-3{grid-template-columns:1fr;}}

.prom-label{font-size:11px;font-weight:700;color:#9ca3af;text-transform:uppercase;letter-spacing:.5px;display:block;margin-bottom:5px;}
.prom-label .req{color:#f87171;margin-left:2px;}
.prom-input,.prom-select,.prom-textarea{
    width:100%;background:#13151f;border:1px solid #444860;color:#e8eaf0;
    border-radius:8px;padding:9px 13px;font-size:13px;display:block;
    transition:border-color .15s;box-sizing:border-box;
}
.prom-input:focus,.prom-select:focus,.prom-textarea:focus{border-color:#fbbf24;outline:none;}
.prom-select{height:38px;-webkit-appearance:none;appearance:none;}
.prom-textarea{min-height:80px;resize:vertical;}

.prom-actions{display:flex;gap:10px;flex-wrap:wrap;justify-content:flex-end;padding:16px 20px;border-top:1px solid rgba(255,255,255,0.06);background:#1a1d2e;border-radius:0 0 14px 14px;}
.prom-btn{display:inline-flex;align-items:center;gap:7px;padding:10px 22px;border-radius:8px;font-size:13px;font-weight:700;border:none;cursor:pointer;transition:all .15s;text-decoration:none;}
.prom-btn:hover{transform:translateY(-1px);}
.prom-btn-print{background:linear-gradient(135deg,#fbbf24,#b45309);color:#111;box-shadow:0 4px 14px rgba(251,191,36,0.3);}
.prom-btn-pdf{background:linear-gradient(135deg,#ef4444,#dc2626);color:#fff;box-shadow:0 4px 14px rgba(239,68,68,0.3);}
.prom-btn-clear{background:rgba(255,255,255,0.07);color:#9ca3af;border:1px solid rgba(255,255,255,0.1);}

/* ── Autocomplete dark ── */
.ui-autocomplete{background:#1e2133!important;border:1px solid #444860!important;border-radius:8px!important;box-shadow:0 8px 24px rgba(0,0,0,0.4)!important;z-index:9999!important;}
.ui-menu-item-wrapper{padding:8px 14px!important;font-size:13px!important;color:#c9cad6!important;}
.ui-state-active,.ui-widget-content .ui-state-active{background:rgba(251,191,36,0.15)!important;color:#fbbf24!important;border:none!important;}

/* ── Preview inline ── */
.prom-preview-wrap{background:#f0f0e8;border-radius:12px;padding:6px;margin-top:16px;box-shadow:0 4px 24px rgba(0,0,0,0.4);}
.prom-preview-label{font-size:10px;font-weight:700;color:#9ca3af;text-transform:uppercase;letter-spacing:.8px;text-align:center;padding:8px 0 4px;}

/* ══════════════════════════════
   ÁREA DE IMPRESSÃO — A4
══════════════════════════════ */
#promPrintArea{
    display:none;
    background:#fff;
    width:210mm;
    min-height:148mm;
    padding:18mm 18mm 14mm;
    font-family:'Times New Roman',serif;
    font-size:12pt;
    color:#000;
    line-height:1.6;
    box-sizing:border-box;
}

/* Topo */
.pp-header{text-align:center;border-bottom:2px solid #000;padding-bottom:8px;margin-bottom:12px;}
.pp-empresa{font-size:10pt;color:#444;margin-bottom:4px;}
.pp-titulo{font-size:16pt;font-weight:700;text-transform:uppercase;letter-spacing:3px;margin:0;}
.pp-num{font-size:9pt;color:#555;margin-top:3px;}

/* Valor em destaque */
.pp-valor-wrap{display:flex;justify-content:space-between;align-items:flex-start;margin:10px 0 8px;}
.pp-valor-box{border:2px solid #000;padding:8px 16px;border-radius:4px;font-size:14pt;font-weight:700;min-width:160px;text-align:center;}
.pp-vencimento-box{text-align:right;font-size:10pt;}
.pp-vencimento-box strong{display:block;font-size:9pt;color:#555;margin-bottom:2px;}

/* Texto corrido */
.pp-texto{text-align:justify;margin:10px 0;font-size:11pt;line-height:1.8;}

/* Campos com linha */
.pp-linha{border-bottom:1px solid #333;min-height:24px;margin:4px 0;display:block;}
.pp-campo-label{font-size:9pt;color:#555;font-weight:700;margin-top:8px;display:block;}
.pp-row2{display:grid;grid-template-columns:1fr 1fr;gap:20px;margin:6px 0;}
.pp-row3{display:grid;grid-template-columns:1fr 1fr 1fr;gap:14px;margin:6px 0;}

/* Assinaturas */
.pp-assin-wrap{display:grid;grid-template-columns:1fr 1fr;gap:40px;margin-top:24px;}
.pp-assin-box{text-align:center;}
.pp-assin-line{border-bottom:1px solid #000;margin-bottom:4px;height:40px;}
.pp-assin-nome{font-size:9pt;color:#555;}

/* Rodapé */
.pp-footer{margin-top:12px;border-top:1px solid #ccc;padding-top:6px;font-size:8pt;color:#777;text-align:center;}

/* Local e data */
.pp-local-data{text-align:right;margin:12px 0 8px;font-size:10pt;}

/* ══════════════════════════════
   PRINT CSS
══════════════════════════════ */
@media print {
    body > *:not(#promPrintArea) { display:none!important; }
    #promPrintArea { display:block!important; margin:0!important; padding:15mm!important; box-shadow:none!important; }
    @page { size:A4; margin:0; }
}
</style>

<link rel="stylesheet" href="<?= base_url() ?>assets/js/jquery-ui/css/smoothness/jquery-ui-1.9.2.custom.css" />
<script src="<?= base_url() ?>assets/js/jquery-ui/js/jquery-ui-1.9.2.custom.js"></script>

<div class="prom-wrap new122">

    <div class="prom-header">
        <div class="prom-title">
            <i class='bx bx-pen'></i>
            <h2>Promissória Avulsa</h2>
        </div>
    </div>

    <!-- ── EMITENTE ── -->
    <div class="prom-card">
        <div class="prom-card-head">
            <i class='bx bx-building'></i><span>Dados do Emitente (Quem Deve)</span>
        </div>
        <div class="prom-card-body">
            <div class="prom-grid">
                <div>
                    <label class="prom-label">Nome Completo <span class="req">*</span></label>
                    <input type="text" id="emitente_nome" class="prom-input" placeholder="Nome do devedor" autocomplete="off" />
                </div>
                <div>
                    <label class="prom-label">CPF / CNPJ</label>
                    <input type="text" id="emitente_doc" class="prom-input" placeholder="000.000.000-00" />
                </div>
                <div>
                    <label class="prom-label">Endereço</label>
                    <input type="text" id="emitente_end" class="prom-input" placeholder="Rua, nº, bairro" />
                </div>
                <div>
                    <label class="prom-label">Cidade / Estado</label>
                    <input type="text" id="emitente_cidade" class="prom-input" placeholder="Ex: São Paulo — SP" />
                </div>
            </div>
        </div>
    </div>

    <!-- ── BENEFICIÁRIO ── -->
    <div class="prom-card">
        <div class="prom-card-head">
            <i class='bx bx-user-check'></i><span>Beneficiário (Quem Recebe)</span>
        </div>
        <div class="prom-card-body">
            <div class="prom-grid">
                <div>
                    <label class="prom-label">Nome Completo <span class="req">*</span></label>
                    <input type="text" id="benef_nome" class="prom-input" placeholder="Nome do credor" autocomplete="off" />
                    <input type="hidden" id="benef_id" />
                </div>
                <div>
                    <label class="prom-label">CPF / CNPJ</label>
                    <input type="text" id="benef_doc" class="prom-input" placeholder="000.000.000-00" />
                </div>
            </div>
        </div>
    </div>

    <!-- ── VALORES ── -->
    <div class="prom-card">
        <div class="prom-card-head">
            <i class='bx bx-dollar-circle'></i><span>Valor & Vencimento</span>
        </div>
        <div class="prom-card-body">
            <div class="prom-grid-3">
                <div>
                    <label class="prom-label">Valor (R$) <span class="req">*</span></label>
                    <input type="text" id="prom_valor" class="prom-input" placeholder="0,00" />
                </div>
                <div>
                    <label class="prom-label">Vencimento <span class="req">*</span></label>
                    <input type="text" id="prom_vencimento" class="prom-input datepicker" placeholder="dd/mm/aaaa" autocomplete="off" />
                </div>
                <div>
                    <label class="prom-label">Nº da Promissória</label>
                    <input type="text" id="prom_numero" class="prom-input" placeholder="Ex: 001/2026" value="001/<?= date('Y') ?>" />
                </div>
            </div>
            <div style="margin-top:14px;">
                <label class="prom-label">Valor por Extenso <span class="req">*</span></label>
                <input type="text" id="prom_valor_extenso" class="prom-input" placeholder="Ex: Dois mil e quinhentos reais" />
            </div>
        </div>
    </div>

    <!-- ── DETALHES ── -->
    <div class="prom-card">
        <div class="prom-card-head">
            <i class='bx bx-detail'></i><span>Detalhes Adicionais</span>
        </div>
        <div class="prom-card-body">
            <div class="prom-grid" style="margin-bottom:14px;">
                <div>
                    <label class="prom-label">Local de Emissão</label>
                    <input type="text" id="prom_local" class="prom-input" placeholder="Ex: São Paulo — SP"
                           value="<?= htmlspecialchars((isset($emitente->cidade) ? $emitente->cidade : '') . (isset($emitente->estado) && $emitente->estado ? ' — '.$emitente->estado : '')) ?>" />
                </div>
                <div>
                    <label class="prom-label">Data de Emissão</label>
                    <input type="text" id="prom_emissao" class="prom-input datepicker" value="<?= date('d/m/Y') ?>" autocomplete="off" />
                </div>
            </div>
            <div>
                <label class="prom-label">Observações / Referência</label>
                <textarea id="prom_obs" class="prom-textarea" placeholder="Ex: Referente à OS #0042, compra de produto, prestação de serviço..."></textarea>
            </div>
            <div style="margin-top:14px;">
                <label class="prom-label">Juros ao mês (% a.m.)</label>
                <input type="text" id="prom_juros" class="prom-input" style="max-width:140px;"
                       placeholder="Ex: 2%" value="2%" />
            </div>
        </div>
    </div>

    <!-- ── AÇÕES ── -->
    <div class="prom-card">
        <div class="prom-actions">
            <button type="button" class="prom-btn prom-btn-clear" onclick="limparForm()">
                <i class='bx bx-refresh'></i> Limpar
            </button>
            <button type="button" class="prom-btn prom-btn-pdf" onclick="gerarPDF()">
                <i class='bx bx-file-pdf'></i> Salvar PDF
            </button>
            <button type="button" class="prom-btn prom-btn-print" onclick="imprimirPromissoria()">
                <i class='bx bx-printer'></i> Imprimir
            </button>
        </div>
    </div>

</div><!-- /.prom-wrap -->

<!-- ══════════════════════════════════════════
     ÁREA DE IMPRESSÃO (oculta em tela, visível no print)
══════════════════════════════════════════ -->
<div id="promPrintArea">
    <!-- Cabeçalho -->
    <div class="pp-header">
        <div class="pp-empresa" id="pp_empresa">
            <?= htmlspecialchars($emitente->nome ?? $configuration['app_name'] ?? '') ?>
            <?php if (!empty($emitente->cnpj)): ?> — CNPJ: <?= $emitente->cnpj ?><?php endif; ?>
        </div>
        <div class="pp-titulo">NOTA PROMISSÓRIA</div>
        <div class="pp-num">Nº <span id="pp_numero">___</span></div>
    </div>

    <!-- Valor + Vencimento -->
    <div class="pp-valor-wrap">
        <div>
            <div style="font-size:9pt;color:#555;font-weight:700;margin-bottom:3px;">VALOR</div>
            <div class="pp-valor-box">R$ <span id="pp_valor">_______________</span></div>
        </div>
        <div class="pp-vencimento-box">
            <strong>VENCIMENTO</strong>
            <span id="pp_vencimento">___/___/_______</span>
        </div>
    </div>

    <!-- Texto principal -->
    <div class="pp-texto">
        No dia <strong><span id="pp_vencimento2">___/___/_______</span></strong>,
        pagarei <strong>(ou pagaremos)</strong> por esta única via de
        <strong>NOTA PROMISSÓRIA</strong> a
        <strong><span id="pp_benef">___________________________</span></strong>
        ou à sua ordem, a quantia de
        <strong>R$ <span id="pp_valor2">_______________</span></strong>
        (<strong><span id="pp_valor_extenso">___________________________________________</span></strong>),
        em moeda corrente nacional.
        Em caso de inadimplemento, incidirão juros de mora de
        <strong><span id="pp_juros">2%</span></strong> ao mês, além de correção monetária pelo IGPM/FGV.
    </div>

    <!-- Referência -->
    <div id="pp_obs_wrap" style="display:none;margin:6px 0;">
        <span style="font-size:9pt;color:#555;font-weight:700;">Referente a:</span>
        <span id="pp_obs" style="font-size:10pt;"></span>
    </div>

    <!-- Dados do Emitente -->
    <div style="margin-top:12px;">
        <span class="pp-campo-label">EMITENTE</span>
        <div class="pp-row2">
            <div>
                <span class="pp-campo-label">Nome:</span>
                <span class="pp-linha" id="pp_emitente_nome"></span>
            </div>
            <div>
                <span class="pp-campo-label">CPF / CNPJ:</span>
                <span class="pp-linha" id="pp_emitente_doc"></span>
            </div>
        </div>
        <span class="pp-campo-label">Endereço:</span>
        <span class="pp-linha" id="pp_emitente_end"></span>
        <div class="pp-row2" style="margin-top:4px;">
            <div>
                <span class="pp-campo-label">Cidade / Estado:</span>
                <span class="pp-linha" id="pp_emitente_cidade"></span>
            </div>
            <div>
                <span class="pp-campo-label">CPF / CNPJ Beneficiário:</span>
                <span class="pp-linha" id="pp_benef_doc"></span>
            </div>
        </div>
    </div>

    <!-- Local e Data -->
    <div class="pp-local-data">
        <span id="pp_local"></span>, <span id="pp_emissao"></span>
    </div>

    <!-- Assinaturas -->
    <div class="pp-assin-wrap">
        <div class="pp-assin-box">
            <div class="pp-assin-line"></div>
            <div class="pp-assin-nome" id="pp_assin_emitente">Emitente / Devedor</div>
        </div>
        <div class="pp-assin-box">
            <div class="pp-assin-line"></div>
            <div class="pp-assin-nome">Beneficiário / Credor</div>
        </div>
    </div>

    <!-- Rodapé -->
    <div class="pp-footer">
        Documento gerado em <?= date('d/m/Y H:i') ?> &nbsp;·&nbsp;
        <?= htmlspecialchars($configuration['app_name'] ?? 'SISOS') ?>
        &nbsp;·&nbsp; Esta promissória constitui título executivo extrajudicial (Art. 585, I, CPC)
    </div>
</div>

<script>
$(document).ready(function() {

    // Datepicker
    $('.datepicker').datepicker({ dateFormat: 'dd/mm/yy' });

    // Autocomplete beneficiário (clientes)
    $('#benef_nome').autocomplete({
        source: '<?= site_url('clientes/autoCompleteCliente') ?>',
        minLength: 1,
        select: function(e, ui) {
            $('#benef_nome').val(ui.item.label);
            $('#benef_id').val(ui.item.id);
            return false;
        }
    });

    // Autocomplete emitente
    $('#emitente_nome').autocomplete({
        source: '<?= site_url('clientes/autoCompleteCliente') ?>',
        minLength: 1,
        select: function(e, ui) {
            $('#emitente_nome').val(ui.item.label);
            return false;
        }
    });

    // Máscara de valor
    $('#prom_valor').on('input', function() {
        var v = $(this).val().replace(/\D/g,'');
        if (!v) { $(this).val(''); return; }
        v = (parseInt(v) / 100).toFixed(2);
        v = v.replace('.',',').replace(/\B(?=(\d{3})+(?!\d))/g, function(m, i, s) {
            return s[i - 1] ? '.' : '';
        });
        $(this).val(v);
    });
});

// Preenche área de impressão com os dados do form
function preencherPrint() {
    var erros = [];
    if (!$('#emitente_nome').val().trim()) erros.push('Nome do Emitente');
    if (!$('#benef_nome').val().trim())    erros.push('Nome do Beneficiário');
    if (!$('#prom_valor').val().trim())    erros.push('Valor');
    if (!$('#prom_vencimento').val().trim()) erros.push('Vencimento');

    if (erros.length) {
        alert('Preencha os campos obrigatórios:\n• ' + erros.join('\n• '));
        return false;
    }

    var num  = $('#prom_numero').val() || '—';
    var val  = $('#prom_valor').val();
    var venc = $('#prom_vencimento').val();
    var ext  = $('#prom_valor_extenso').val() || '______________________________________';
    var benef = $('#benef_nome').val();
    var emNome = $('#emitente_nome').val();
    var juros = $('#prom_juros').val() || '2%';
    var obs   = $('#prom_obs').val().trim();

    $('#pp_numero').text(num);
    $('#pp_valor').text(val);
    $('#pp_valor2').text(val);
    $('#pp_vencimento').text(venc);
    $('#pp_vencimento2').text(venc);
    $('#pp_benef').text(benef);
    $('#pp_valor_extenso').text(ext);
    $('#pp_juros').text(juros);
    $('#pp_emitente_nome').text(emNome);
    $('#pp_emitente_doc').text($('#emitente_doc').val());
    $('#pp_emitente_end').text($('#emitente_end').val());
    $('#pp_emitente_cidade').text($('#emitente_cidade').val());
    $('#pp_benef_doc').text($('#benef_doc').val());
    $('#pp_local').text($('#prom_local').val());
    $('#pp_emissao').text($('#prom_emissao').val());
    $('#pp_assin_emitente').text(emNome || 'Emitente / Devedor');

    if (obs) {
        $('#pp_obs').text(obs);
        $('#pp_obs_wrap').show();
    } else {
        $('#pp_obs_wrap').hide();
    }

    return true;
}

function imprimirPromissoria() {
    if (!preencherPrint()) return;
    window.print();
}

function gerarPDF() {
    if (!preencherPrint()) return;

    // Usa o print do navegador em modo PDF
    var originalTitle = document.title;
    var num = $('#prom_numero').val() || 'promissoria';
    document.title = 'Promissoria_' + num.replace(/\//g,'-');

    // Força Print para PDF
    window.print();
    document.title = originalTitle;
}

function limparForm() {
    $('#emitente_nome, #emitente_doc, #emitente_end, #emitente_cidade').val('');
    $('#benef_nome, #benef_doc, #benef_id').val('');
    $('#prom_valor, #prom_vencimento, #prom_valor_extenso, #prom_obs').val('');
    $('#prom_numero').val('001/<?= date('Y') ?>');
    $('#prom_juros').val('2%');
    $('#prom_emissao').val('<?= date('d/m/Y') ?>');
    $('#emitente_nome').focus();
}
</script>
