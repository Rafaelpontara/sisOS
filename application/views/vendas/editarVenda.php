<link rel="stylesheet" href="<?= base_url() ?>assets/js/jquery-ui/css/smoothness/jquery-ui-1.9.2.custom.css">
<script src="<?= base_url() ?>assets/js/jquery-ui/js/jquery-ui-1.9.2.custom.js"></script>
<script src="<?= base_url() ?>assets/js/jquery.validate.js"></script>
<script src="<?= base_url() ?>assets/js/sweetalert2.all.min.js"></script>
<script src="<?= base_url() ?>assets/js/maskmoney.js"></script>
<link rel="stylesheet" href="<?= base_url() ?>assets/trumbowyg/ui/trumbowyg.css">
<script src="<?= base_url() ?>assets/trumbowyg/trumbowyg.js"></script>
<script src="<?= base_url() ?>assets/trumbowyg/langs/pt_br.js"></script>

<style>
.ev-wrap *,.ev-wrap *::before,.ev-wrap *::after{box-sizing:border-box;}
.ev-wrap{max-width:1100px;margin:0 auto;font-family:inherit;}

/* Tabs */
.ev-tabs{display:flex;gap:2px;border-bottom:2px solid rgba(255,255,255,0.08);margin-bottom:16px;}
.ev-tab{padding:9px 20px;font-size:13px;font-weight:700;color:#6b7280;cursor:pointer;border:none;background:none;border-bottom:3px solid transparent;margin-bottom:-2px;transition:all .15s;}
.ev-tab.active{color:#fbbf24;border-bottom-color:#fbbf24;}

/* Card */
.ev-card{background:#1a1d2e;border:1px solid rgba(255,255,255,0.07);border-radius:14px;overflow:hidden;margin-bottom:14px;}
.ev-card-head{display:flex;align-items:center;gap:8px;padding:11px 16px;border-bottom:1px solid rgba(255,255,255,0.06);background:#252a3a;}
.ev-card-head i{font-size:15px;}
.ev-card-head span{font-size:11px;font-weight:700;color:#9ca3af;text-transform:uppercase;letter-spacing:.8px;}
.ev-card-body{padding:16px;}

/* Grid */
.ev-grid{display:grid;grid-template-columns:repeat(5,1fr);gap:12px;}
.ev-grid-2{display:grid;grid-template-columns:1fr 1fr;gap:14px;}
@media(max-width:768px){.ev-grid{grid-template-columns:1fr 1fr;}.ev-grid-2{grid-template-columns:1fr;}}

/* Form */
.ev-field{display:flex;flex-direction:column;gap:4px;}
.ev-label{font-size:11px;font-weight:700;color:#9ca3af;text-transform:uppercase;letter-spacing:.5px;}
.ev-label .req{color:#f87171;margin-left:2px;}
.ev-input,.ev-select{background:#13151f;border:1px solid #444860;color:#e8eaf0;border-radius:8px;padding:8px 12px;font-size:13px;width:100%;transition:border-color .15s;-webkit-appearance:none;}
.ev-input:focus,.ev-select:focus{border-color:#fbbf24;outline:none;}
.ev-select{height:38px;}

/* Btn */
.ev-btn{display:inline-flex;align-items:center;gap:6px;padding:9px 18px;border-radius:8px;font-size:13px;font-weight:700;text-decoration:none;border:none;cursor:pointer;transition:all .15s;}
.ev-btn:hover{transform:translateY(-1px);text-decoration:none;}
.ev-btn-danger {background:linear-gradient(135deg,#ef4444,#dc2626);color:#fff;}
.ev-btn-primary{background:linear-gradient(135deg,#3b82f6,#2563eb);color:#fff;}
.ev-btn-success{background:linear-gradient(135deg,#22c55e,#16a34a);color:#fff;}
.ev-btn-amber  {background:linear-gradient(135deg,#fbbf24,#d97706);color:#111;}
.ev-btn-ghost  {background:rgba(255,255,255,0.07);color:#9ca3af;border:1px solid rgba(255,255,255,0.1);}

/* Produto form */
.ev-prod-row{display:flex;gap:10px;align-items:flex-end;flex-wrap:wrap;}
.ev-prod-row .ev-field{flex:1;min-width:140px;}
.ev-prod-row .ev-field.sm{min-width:90px;flex:0 0 100px;}
.ev-prod-row .ev-field.xs{min-width:130px;flex:0 0 130px;}

/* Table */
.ev-tbl-wrap{overflow-x:auto;}
.ev-tbl{width:100%;border-collapse:collapse;font-size:13px;}
.ev-tbl thead th{background:#252a3a;color:#9ca3af;font-size:11px;font-weight:700;text-transform:uppercase;letter-spacing:.5px;padding:9px 12px;border-bottom:1px solid rgba(255,255,255,0.07);}
.ev-tbl tbody tr{border-bottom:1px solid rgba(255,255,255,0.04);transition:background .12s;}
.ev-tbl tbody tr:hover{background:rgba(255,255,255,0.03);}
.ev-tbl tbody td{padding:9px 12px;color:#c9cad6;}
.ev-tbl tfoot td{padding:9px 12px;background:#252a3a;font-weight:700;}
.ev-del{width:28px;height:28px;border-radius:6px;background:rgba(239,68,68,0.15);color:#f87171;border:none;cursor:pointer;display:inline-flex;align-items:center;justify-content:center;font-size:14px;transition:all .12s;}
.ev-del:hover{background:rgba(239,68,68,0.3);}

/* Desconto */
.ev-desc-row{display:flex;gap:10px;align-items:flex-end;flex-wrap:wrap;padding:12px;background:#13151f;border-radius:10px;border:1px solid rgba(255,255,255,0.06);}

/* Trumbowyg dark */
.trumbowyg-box{border-radius:10px!important;overflow:hidden;border:1px solid #444860!important;}
.trumbowyg-button-pane{background:#252a3a!important;border-bottom:1px solid #444860!important;}
.trumbowyg-button-pane button{color:#9ca3af!important;}
.trumbowyg-button-pane button:hover{background:rgba(255,255,255,0.08)!important;color:#e8eaf0!important;}
.trumbowyg-editor{background:#13151f!important;color:#e8eaf0!important;border:none!important;min-height:140px!important;padding:10px 14px!important;font-size:13px!important;}

span.error{color:#f87171!important;font-size:11px!important;}

/* Modal Faturar */
.ev-modal-backdrop{display:none;position:fixed;inset:0;background:rgba(0,0,0,0.7);z-index:1050;align-items:center;justify-content:center;padding:20px;}
.ev-modal-backdrop.show{display:flex;}
.ev-modal{background:#1a1d2e;border:1px solid rgba(255,255,255,0.1);border-radius:16px;width:100%;max-width:520px;overflow:hidden;}
.ev-modal-head{background:#252a3a;border-bottom:1px solid rgba(255,255,255,0.08);padding:14px 18px;display:flex;align-items:center;justify-content:space-between;}
.ev-modal-head h3{font-size:16px;font-weight:800;color:#e8eaf0;margin:0;display:flex;align-items:center;gap:8px;}
.ev-modal-close{background:none;border:none;color:#6b7280;font-size:20px;cursor:pointer;line-height:1;padding:0;}
.ev-modal-body{padding:18px;display:flex;flex-direction:column;gap:12px;}
.ev-modal-foot{padding:12px 18px;border-top:1px solid rgba(255,255,255,0.08);background:#252a3a;display:flex;justify-content:flex-end;gap:8px;}
</style>

<div class="ev-wrap new122">

    <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:16px;flex-wrap:wrap;gap:10px;">
        <h2 style="font-size:20px;font-weight:800;color:#e8eaf0;display:flex;align-items:center;gap:10px;">
            <i class='bx bx-cart-alt' style="color:#fbbf24;"></i>
            Editar Venda &nbsp;<span style="color:#fbbf24;">#<?= $result->idVendas ?></span>
        </h2>
        <?php if ($result->faturado == 0): ?>
        <button onclick="document.getElementById('modalFaturar').classList.add('show')" class="ev-btn ev-btn-danger">
            <i class='bx bx-dollar'></i> Faturar
        </button>
        <?php endif; ?>
    </div>

    <!-- Tabs -->
    <div class="ev-tabs">
        <button class="ev-tab active" id="tabDetalhes" onclick="switchTab('tab1',this)">Detalhes da Venda</button>
        <button class="ev-tab" id="tabProdutos" onclick="switchTab('tab2',this)">Produtos</button>
    </div>

    <!-- ── TAB 1: DETALHES ── -->
    <div id="tab1">
        <form action="<?= current_url() ?>" method="post" id="formVendas">
            <?= form_hidden('idVendas', $result->idVendas) ?>

            <div class="ev-card">
                <div class="ev-card-head"><i class='bx bx-info-circle' style="color:#fbbf24;"></i><span>Dados da Venda</span></div>
                <div class="ev-card-body">
                    <div class="ev-grid">
                        <div class="ev-field">
                            <label class="ev-label">Data Final</label>
                            <input id="dataVenda" class="ev-input datepicker" type="text" name="dataVenda"
                                   value="<?= date('d/m/Y', strtotime($result->dataVenda)) ?>">
                        </div>
                        <div class="ev-field">
                            <label class="ev-label">Cliente <span class="req">*</span></label>
                            <input id="cliente" class="ev-input" type="text" name="cliente" value="<?= htmlspecialchars($result->nomeCliente) ?>" required>
                            <input id="clientes_id" type="hidden" name="clientes_id" value="<?= $result->clientes_id ?>">
                            <input id="valorTotal" type="hidden" name="valorTotal" value="">
                        </div>
                        <div class="ev-field">
                            <label class="ev-label">Vendedor <span class="req">*</span></label>
                            <input id="tecnico" class="ev-input" type="text" name="tecnico" value="<?= htmlspecialchars($result->nome) ?>" required>
                            <input id="usuarios_id" type="hidden" name="usuarios_id" value="<?= $result->usuarios_id ?>">
                        </div>
                        <div class="ev-field">
                            <label class="ev-label">Status <span class="req">*</span></label>
                            <select class="ev-select" name="status" id="status">
                                <?php foreach(['Orçamento','Aberto','Faturado','Negociação','Em Andamento','Finalizado','Cancelado','Aguardando Peças','Aprovado'] as $s): ?>
                                <option <?= $result->status==$s?'selected':'' ?> value="<?= $s ?>"><?= $s ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="ev-field">
                            <label class="ev-label">Garantia (dias)</label>
                            <input id="garantia" type="number" min="0" max="9999" class="ev-input" name="garantia" value="<?= $result->garantia ?>">
                        </div>
                    </div>
                </div>
            </div>

            <!-- Observações -->
            <div class="ev-card">
                <div class="ev-card-head"><i class='bx bx-comment-detail' style="color:#60a5fa;"></i><span>Observações</span></div>
                <div class="ev-card-body">
                    <div class="ev-grid-2">
                        <div>
                            <label class="ev-label" style="display:block;margin-bottom:5px;">Observações Internas</label>
                            <textarea class="editor" name="observacoes" id="observacoes"><?= $result->observacoes ?></textarea>
                        </div>
                        <div>
                            <label class="ev-label" style="display:block;margin-bottom:5px;">Observações ao Cliente</label>
                            <textarea class="editor" name="observacoes_cliente" id="observacoes_cliente"><?= $result->observacoes_cliente ?></textarea>
                        </div>
                    </div>
                </div>
            </div>

            <div style="display:flex;gap:8px;justify-content:flex-end;padding:4px 0 8px;">
                <a href="<?= base_url() ?>index.php/vendas" class="ev-btn ev-btn-ghost"><i class='bx bx-arrow-back'></i> Voltar</a>
                <a href="<?= base_url() ?>index.php/vendas/visualizar/<?= $result->idVendas ?>" class="ev-btn ev-btn-primary"><i class='bx bx-show'></i> Visualizar</a>
                <button class="ev-btn ev-btn-success" id="btnContinuar"><i class='bx bx-sync'></i> Atualizar</button>
            </div>
        </form>
    </div>

    <!-- ── TAB 2: PRODUTOS ── -->
    <div id="tab2" style="display:none;">

        <!-- Adicionar produto -->
        <div class="ev-card">
            <div class="ev-card-head"><i class='bx bx-plus-circle' style="color:#22c55e;"></i><span>Adicionar Produto</span></div>
            <div class="ev-card-body">
                <form id="formProdutos" action="<?= base_url() ?>index.php/vendas/adicionarProduto" method="post">
                    <input type="hidden" name="idProduto" id="idProduto">
                    <input type="hidden" name="idVendasProduto" id="idVendasProduto" value="<?= $result->idVendas ?>">
                    <input type="hidden" name="estoque" id="estoque" value="">
                    <div class="ev-prod-row" style="margin-bottom:10px;">
                        <div class="ev-field" style="flex:2;min-width:220px;">
                            <label class="ev-label">Produto (nome ou código de barras)</label>
                            <input type="text" class="ev-input" name="produto" id="produto" placeholder="Digite o nome do produto">
                        </div>
                        <div class="ev-field xs">
                            <label class="ev-label">Cód. Barras</label>
                            <div style="display:flex;gap:4px;">
                                <input type="text" id="inputBarcode" class="ev-input" placeholder="Cód. Barras">
                                <button type="button" id="btnBarcode" class="ev-btn ev-btn-ghost" style="padding:8px 10px;flex-shrink:0;" title="Buscar"><i class='bx bx-barcode'></i></button>
                            </div>
                        </div>
                        <div class="ev-field sm">
                            <label class="ev-label">Preço</label>
                            <input type="text" class="ev-input money" id="preco" name="preco" placeholder="0.00">
                        </div>
                        <div class="ev-field sm">
                            <label class="ev-label">Quantidade</label>
                            <input type="text" class="ev-input" id="quantidade" name="quantidade" placeholder="1">
                        </div>
                        <button class="ev-btn ev-btn-success" id="btnAdicionarProduto" style="margin-bottom:0;flex-shrink:0;">
                            <i class='bx bx-plus-circle'></i> Adicionar
                        </button>
                    </div>
                </form>

                <!-- Desconto -->
                <div class="ev-desc-row">
                    <form id="formDesconto" action="<?= base_url() ?>index.php/vendas/adicionarDesconto" method="POST" style="display:flex;gap:10px;align-items:flex-end;flex-wrap:wrap;width:100%;">
                        <input type="hidden" name="idVendas" id="idVendas" value="<?= $result->idVendas ?>">
                        <div class="ev-field sm">
                            <label class="ev-label">Desconto</label>
                            <input style="width:90px;" id="desconto" name="desconto" type="text" placeholder="0.00" maxlength="6" class="ev-input">
                        </div>
                        <div class="ev-field" style="min-width:80px;flex:0 0 90px;">
                            <label class="ev-label">Tipo</label>
                            <select name="tipoDesconto" id="tipoDesconto" class="ev-select" style="width:90px;">
                                <option value="real">R$</option>
                                <option value="porcento" <?= $result->tipo_desconto=='porcento'?'selected':'' ?>>%</option>
                            </select>
                        </div>
                        <div class="ev-field" style="min-width:160px;flex:1;">
                            <label class="ev-label">Total com Desconto</label>
                            <input class="ev-input money" id="resultado" type="text" data-affixes-stay="true" data-thousands="" data-decimal="." name="resultado" value="" readonly>
                        </div>
                        <button class="ev-btn ev-btn-amber" id="btnAdicionarDesconto" style="flex-shrink:0;">
                            <i class='bx bx-check'></i> Aplicar
                        </button>
                        <span style="color:#f87171;font-size:11px;align-self:center;" id="errorAlert"></span>
                    </form>
                </div>
            </div>
        </div>

        <!-- Tabela produtos -->
        <div class="ev-card">
            <div class="ev-card-head"><i class='bx bx-package' style="color:#a78bfa;"></i><span>Produtos da Venda</span></div>
            <div id="divProdutos">
                <div class="ev-tbl-wrap">
                    <table class="ev-tbl" id="tblProdutos">
                        <thead><tr><th>Produto</th><th style="width:10%;text-align:center;">Qtd</th><th style="width:12%;">Preço</th><th style="width:6%;text-align:center;">Ação</th><th style="width:12%;text-align:right;">Subtotal</th></tr></thead>
                        <tbody>
                        <?php
                        $total = 0;
                        foreach ($produtos as $p) {
                            $preco = $p->preco ?: $p->precoVenda;
                            $total += $p->subTotal;
                            echo '<tr>';
                            echo '<td>'.htmlspecialchars($p->descricao).'</td>';
                            echo '<td style="text-align:center;">'.$p->quantidade.'</td>';
                            echo '<td>R$ '.$preco.'</td>';
                            echo '<td style="text-align:center;"><button class="ev-del" idAcao="'.$p->idItens.'" prodAcao="'.$p->idProdutos.'" quantAcao="'.$p->quantidade.'" title="Excluir"><i class="bx bx-trash"></i></button></td>';
                            echo '<td style="text-align:right;">R$ '.number_format($p->subTotal,2,',','.').'</td>';
                            echo '</tr>';
                        }
                        ?>
                        </tbody>
                        <tfoot>
                            <tr><td colspan="4" style="text-align:right;color:#9ca3af;">Total:</td><td style="text-align:right;color:#fbbf24;">R$ <?= number_format($total,2,',','.') ?></td></tr>
                            <?php if ($result->valor_desconto != 0 && $result->desconto != 0): ?>
                            <tr><td colspan="4" style="text-align:right;color:#9ca3af;">Desconto:</td><td style="text-align:right;color:#f87171;"><?= $result->tipo_desconto=='real'?'R$ ':'' ?><?= number_format($result->desconto,2,',','.') ?><?= $result->tipo_desconto=='porcento'?' %':'' ?></td></tr>
                            <tr><td colspan="4" style="text-align:right;color:#9ca3af;">Total c/ Desconto:</td><td style="text-align:right;font-size:15px;color:#4ade80;">R$ <?= number_format($result->valor_desconto,2,',','.') ?></td></tr>
                            <?php endif; ?>
                        </tfoot>
                    </table>
                </div>
                <input type="hidden" id="total-venda" value="<?= number_format($total,2,'.','')?> ">
                <?php if ($result->valor_desconto != 0): ?>
                <input type="hidden" id="total-desconto" value="<?= number_format($result->valor_desconto,2,'.','')?> ">
                <?php endif; ?>
            </div>
        </div>
    </div>

</div>

<!-- ── MODAL FATURAR ── -->
<div id="modalFaturar" class="ev-modal-backdrop">
    <div class="ev-modal">
        <div class="ev-modal-head">
            <h3><i class='bx bx-dollar-circle' style="color:#fbbf24;"></i> Faturar Venda</h3>
            <button class="ev-modal-close" onclick="document.getElementById('modalFaturar').classList.remove('show')">×</button>
        </div>
        <form id="formFaturar" action="<?= current_url() ?>" method="post">
            <div class="ev-modal-body">
                <div style="background:rgba(99,102,241,0.1);border:1px solid rgba(99,102,241,0.3);border-radius:8px;padding:10px 14px;font-size:13px;color:#a5b4fc;">
                    <i class='bx bx-info-circle'></i> Preencha os campos com asterisco obrigatoriamente.
                </div>
                <div class="ev-field">
                    <label class="ev-label">Descrição</label>
                    <input class="ev-input" id="descricao" type="text" name="descricao" value="Fatura de Venda Nº: <?= $result->idVendas ?>">
                </div>
                <div class="ev-field">
                    <label class="ev-label">Cliente <span class="req">*</span></label>
                    <input class="ev-input" id="cliente_fat" type="text" name="cliente" value="<?= htmlspecialchars($result->nomeCliente) ?>">
                    <input type="hidden" name="clientes_id" value="<?= $result->clientes_id ?>">
                    <input type="hidden" name="vendas_id" value="<?= $result->idVendas ?>">
                    <input type="hidden" name="tipo" value="receita">
                </div>
                <div style="display:grid;grid-template-columns:1fr 1fr;gap:12px;">
                    <div class="ev-field">
                        <label class="ev-label">Valor <span class="req">*</span></label>
                        <input class="ev-input money" id="valor" type="text" name="valor" value="<?= number_format($total,2,'.','')?> ">
                    </div>
                    <div class="ev-field">
                        <label class="ev-label">Valor c/ Desconto <span class="req">*</span></label>
                        <input class="ev-input money" id="faturar-desconto" type="text" name="faturar-desconto" value="<?= number_format($result->valor_desconto,2,'.','')?> ">
                    </div>
                </div>
                <div class="ev-field" style="max-width:200px;">
                    <label class="ev-label">Data Entrada <span class="req">*</span></label>
                    <input class="ev-input datepicker" autocomplete="off" id="vencimento" type="text" name="vencimento">
                </div>
                <div>
                    <label style="display:flex;align-items:center;gap:8px;cursor:pointer;font-size:13px;color:#9ca3af;">
                        <input id="recebido" type="checkbox" name="recebido" value="1" style="width:16px;height:16px;accent-color:#22c55e;">
                        <span>Recebido?</span>
                    </label>
                </div>
                <div id="divRecebimento" style="display:none;display:grid;grid-template-columns:1fr 1fr;gap:12px;">
                    <div class="ev-field">
                        <label class="ev-label">Data Recebimento</label>
                        <input class="ev-input datepicker" autocomplete="off" id="recebimento" type="text" name="recebimento">
                    </div>
                    <div class="ev-field">
                        <label class="ev-label">Forma de Pagamento</label>
                        <select name="formaPgto" id="formaPgto" class="ev-select">
                            <?php foreach(['Dinheiro','Cartão de Crédito','Débito','Boleto','Depósito','Pix','Cheque'] as $fp): ?>
                            <option value="<?= $fp ?>"><?= $fp ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
            </div>
            <div class="ev-modal-foot">
                <button type="button" class="ev-btn ev-btn-ghost" id="btn-cancelar-faturar" onclick="document.getElementById('modalFaturar').classList.remove('show')">
                    <i class='bx bx-x'></i> Cancelar
                </button>
                <button type="submit" class="ev-btn ev-btn-danger">
                    <i class='bx bx-dollar'></i> Faturar
                </button>
            </div>
        </form>
    </div>
</div>

<script>
// ── Tab switch ──
function switchTab(tab, btn) {
    document.getElementById('tab1').style.display = 'none';
    document.getElementById('tab2').style.display = 'none';
    document.getElementById(tab).style.display = 'block';
    document.querySelectorAll('.ev-tab').forEach(t => t.classList.remove('active'));
    btn.classList.add('active');
}

$(document).ready(function(){
    $(".money").maskMoney();
    $(".datepicker").datepicker({ dateFormat:'dd/mm/yy' });
    $('.editor').trumbowyg({ lang:'pt_br', semantic:{'strikethrough':'s'} });

    $('#recebido').click(function(){
        $('#divRecebimento').css('display', $(this).is(':checked') ? 'grid' : 'none');
    });

    // Btn faturar no topo
    $('#btn-faturar').click(function(e){
        e.preventDefault();
        var valor = $('#total-venda').val();
        var valor_desconto = $('#total-desconto').val();
        valor_desconto != 0.00 || valor_desconto ? $('#valor').attr('readonly',false) : $('#faturar-desconto').attr('readonly',false);
        valor = valor.replace(',','');
        $('#valor').val(valor);
        document.getElementById('modalFaturar').classList.add('show');
    });

    // Desconto calc
    var valorBackup = $("#total-venda").val();

    function calcDesconto(valor, desconto, tipoDesconto) {
        if (tipoDesconto=='real') return valor - desconto;
        if (tipoDesconto=='porcento') return (valor - desconto*valor/100).toFixed(2);
        return 0;
    }
    function validarDesconto(resultado, valor) {
        return resultado == valor ? "" : Number(resultado).toFixed(2);
    }

    $("#desconto").keyup(function(){
        this.value = this.value.replace(/[^0-9.]/g,'');
        if (!$("#total-venda").val()) {
            $('#errorAlert').text('Valor não pode ser apagado.').fadeOut(5000);
            $('#desconto').val(''); $('#resultado').val('');
            $("#total-venda").val(valorBackup); return;
        }
        $('#resultado').val(calcDesconto(+$("#total-venda").val(), +$(this).val(), $("#tipoDesconto").val()));
        $('#resultado').val(validarDesconto(+$('#resultado').val(), +$("#total-venda").val()));
    });

    $('#tipoDesconto').on('change',function(){
        $('#resultado').val(calcDesconto(+$("#total-venda").val(), +$("#desconto").val(), $(this).val()));
        $('#resultado').val(validarDesconto(+$('#resultado').val(), +$("#total-venda").val()));
    });

    // Produto autocomplete
    $("#produto").autocomplete({
        source:"<?= base_url() ?>index.php/os/autoCompleteProdutoSaida", minLength:2,
        select:function(e,ui){ $("#idProduto").val(ui.item.id); $("#estoque").val(ui.item.estoque); $("#preco").val(ui.item.preco); $("#quantidade").focus(); }
    });
    $("#cliente").autocomplete({
        source:"<?= base_url() ?>index.php/os/autoCompleteCliente", minLength:2,
        select:function(e,ui){ $("#clientes_id").val(ui.item.id); }
    });
    $("#tecnico").autocomplete({
        source:"<?= base_url() ?>index.php/os/autoCompleteUsuario", minLength:2,
        select:function(e,ui){ $("#usuarios_id").val(ui.item.id); }
    });

    // Barcode
    function buscarPorBarcode(code) {
        if (!code) return;
        $.getJSON('<?= base_url() ?>index.php/vendas/buscarPorBarcode', {code:code}, function(data){
            if (data && data.length>0) {
                var item=data[0];
                $('#produto').val(item.label.split(' | ')[0]);
                $('#idProduto').val(item.id); $('#estoque').val(item.estoque);
                $('#preco').val(item.preco); $('#quantidade').val(1).focus();
                $('#inputBarcode').val('');
            } else { alert('Produto não encontrado: '+code); $('#inputBarcode').val('').focus(); }
        });
    }
    $('#inputBarcode').on('keydown',function(e){ if(e.which===13){e.preventDefault();buscarPorBarcode($(this).val().trim());} });
    $('#btnBarcode').on('click',function(){ buscarPorBarcode($('#inputBarcode').val().trim()); });

    // Delete produto
    $(document).on('click','button[idAcao]',function(e){
        e.preventDefault();
        var id=$(this).attr('idAcao'), qt=$(this).attr('quantAcao'), pr=$(this).attr('prodAcao');
        if ((id%1)==0) {
            $("#divProdutos").html("<div style='padding:20px;text-align:center;color:#9ca3af;'>Carregando...</div>");
            $.ajax({ type:"POST", url:"<?= base_url() ?>index.php/vendas/excluirProduto",
                data:"idProduto="+id+"&idVendas="+<?= $result->idVendas ?>+"&quantidade="+qt+"&produto="+pr, dataType:'json',
                success:function(data){ if(data.result){ $("#divProdutos").load("<?= current_url() ?> #divProdutos"); $("#resultado,#desconto").val(""); }
                else { Swal.fire({type:"error",title:"Atenção",html:"Erro ao excluir produto."+data.messages}); $("#divProdutos").load("<?= current_url() ?> #divProdutos"); } }
            });
        }
    });

    // Form desconto
    $('#formDesconto').submit(function(e){
        e.preventDefault();
        $("#divProdutos").html("<div style='padding:20px;text-align:center;color:#9ca3af;'>Processando...</div>");
        $.ajax({ url:$(this).attr('action'), type:'post', data:$(this).serialize(),
            beforeSend:function(){ Swal.fire({title:'Processando',text:'Registrando desconto...',icon:'info',showConfirmButton:false,allowOutsideClick:false}); },
            success:function(r){
                if(r.result){ Swal.fire({type:"success",title:"Sucesso",text:r.messages}); }
                else { Swal.fire({type:"error",title:"Atenção",text:r.messages}); }
                $("#divProdutos").load("<?= current_url() ?> #divProdutos");
                $("#desconto,#resultado").val("");
            }, error:function(r){ Swal.fire({type:"error",title:"Atenção",text:r.responseJSON?.messages}); }
        });
    });

    // Form faturar
    $("#formFaturar").validate({
        rules:{ descricao:{required:true}, cliente:{required:true}, valor:{required:true}, vencimento:{required:true} },
        messages:{ descricao:{required:'Campo obrigatório.'}, cliente:{required:'Campo obrigatório.'}, valor:{required:'Campo obrigatório.'}, vencimento:{required:'Campo obrigatório.'} },
        submitHandler:function(form){
            var dados=$(form).serialize();
            var qtd=$('#tblProdutos >tbody >tr').length;
            $('#btn-cancelar-faturar').trigger('click');
            if (qtd<=0) {
                Swal.fire({type:"error",title:"Atenção",text:"Não é possível faturar uma venda sem produtos"});
            } else {
                $.ajax({ type:"POST", url:"<?= base_url() ?>index.php/vendas/faturar", data:dados, dataType:'json',
                    success:function(data){ if(data.result==true){ window.location.reload(true); }
                    else { Swal.fire({type:"error",title:"Atenção",text:"Erro ao faturar venda."}); } }
                });
            }
            return false;
        }
    });

    // Form venda
    $("#formVendas").validate({
        rules:{ cliente:{required:true}, tecnico:{required:true}, dataVenda:{required:true} },
        submitHandler:function(form){ $('#btnContinuar').attr('disabled',true).html('<i class="bx bx-loader-alt bx-spin"></i> Salvando...'); form.submit(); }
    });

    // Form produtos
    $("#formProdutos").validate({
        rules:{ preco:{required:true}, quantidade:{required:true} },
        submitHandler:function(form){
            var qtd=parseInt($("#quantidade").val()), est=parseInt($("#estoque").val());
            <?php if(!$configuration['control_estoque']): ?>est=1000000;<?php endif; ?>
            if(est<qtd){ Swal.fire({type:"warning",title:"Atenção",text:"Estoque insuficiente."}); }
            else {
                $("#divProdutos").html("<div style='padding:20px;text-align:center;color:#9ca3af;'>Adicionando...</div>");
                $.ajax({ type:"POST", url:"<?= base_url() ?>index.php/vendas/adicionarProduto", data:$(form).serialize(), dataType:'json',
                    success:function(data){
                        if(data.result){ $("#divProdutos").load("<?= current_url() ?> #divProdutos"); $("#quantidade,#preco,#produto").val('').first().focus(); $("#resultado,#desconto").val(""); }
                        else { Swal.fire({type:"error",title:"Atenção",html:"Erro ao adicionar produto.<br>"+data.messages}); $("#divProdutos").load("<?= current_url() ?> #divProdutos"); }
                    }
                });
                return false;
            }
        }
    });
});
</script>
