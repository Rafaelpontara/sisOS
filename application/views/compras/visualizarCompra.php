<script src="<?php echo base_url() ?>assets/js/sweetalert2.all.min.js"></script>
<script src="<?php echo base_url() ?>assets/js/maskmoney.js"></script>
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/js/jquery-ui/css/smoothness/jquery-ui-1.9.2.custom.css"/>
<script src="<?php echo base_url() ?>assets/js/jquery-ui/js/jquery-ui-1.9.2.custom.js"></script>

<div class="row-fluid" style="margin-top:0">
    <div class="span12">
        <div class="widget-box">
            <div class="widget-title">
                <span class="icon"><i class="bx bx-purchase-tag-alt"></i></span>
                <h5>Compra #<?= $result->idCompra ?> — <?= htmlspecialchars($result->descricao) ?></h5>
                <div style="float:right;padding:8px;">
                    <?php if ($this->permission->checkPermission($this->session->userdata('permissao'), 'eCompra')): ?>
                        <a href="<?= site_url('compras/editar/'.$result->idCompra) ?>" class="button btn btn-mini btn-success">
                            <span class="button__icon"><i class='bx bx-edit'></i></span><span class="button__text2">Editar</span>
                        </a>
                    <?php endif; ?>
                    <a href="<?= site_url('compras') ?>" class="button btn btn-mini btn-warning">
                        <span class="button__icon"><i class='bx bx-undo'></i></span><span class="button__text2">Voltar</span>
                    </a>
                </div>
            </div>
            <div class="widget-content" style="padding:15px">
                <div class="row-fluid">
                    <div class="span6">
                        <table class="table table-condensed">
                            <tr><th>Fornecedor</th><td><?= htmlspecialchars($result->nomeCliente ?: $result->fornecedor ?: '—') ?></td></tr>
                            <tr><th>Data da Compra</th><td><?= date('d/m/Y', strtotime($result->data_compra)) ?></td></tr>
                            <tr><th>Vencimento</th><td><?= $result->data_vencimento ? date('d/m/Y', strtotime($result->data_vencimento)) : '—' ?></td></tr>
                            <tr><th>Forma de Pgto</th><td><?= htmlspecialchars($result->forma_pgto ?: '—') ?></td></tr>
                            <tr><th>Nota Fiscal</th><td><?= htmlspecialchars($result->nota_fiscal ?: '—') ?></td></tr>
                        </table>
                    </div>
                    <div class="span6">
                        <table class="table table-condensed">
                            <tr><th>Valor Total</th><td><strong>R$ <?= number_format($result->valor_total, 2, ',', '.') ?></strong></td></tr>
                            <tr><th>Valor Pago</th><td>R$ <?= number_format($result->valor_pago, 2, ',', '.') ?></td></tr>
                            <tr><th>Saldo</th><td>R$ <?= number_format($result->valor_total - $result->valor_pago, 2, ',', '.') ?></td></tr>
                            <tr><th>Status</th>
                                <td>
                                    <?php $cores=['pendente'=>'warning','pago'=>'success','parcial'=>'info','cancelado'=>'danger']; ?>
                                    <span class="badge badge-<?= $cores[$result->status] ?? 'default' ?>"><?= ucfirst($result->status) ?></span>
                                </td>
                            </tr>
                            <tr><th>Responsável</th><td><?= htmlspecialchars($result->nomeUsuario) ?></td></tr>
                        </table>
                        <?php if ($result->observacoes): ?>
                            <p><strong>Obs:</strong> <?= nl2br(htmlspecialchars($result->observacoes)) ?></p>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>

        <!-- Itens da compra -->
        <div class="widget-box" style="margin-top:10px">
            <div class="widget-title">
                <span class="icon"><i class="bx bx-list-ul"></i></span>
                <h5>Itens da Compra (Produtos Recebidos)</h5>
            </div>
            <div class="widget-content nopadding">
                <table class="table table-bordered" id="tabelaItens">
                    <thead>
                        <tr>
                            <th>Produto</th>
                            <th>Descrição</th>
                            <th>Qtd</th>
                            <th>Preço Unit.</th>
                            <th>Subtotal</th>
                            <th>Ação</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php if ($itens): foreach ($itens as $item): ?>
                        <tr id="item-<?= $item->idItem ?>">
                            <td><?= htmlspecialchars($item->nomeProduto ?: '—') ?></td>
                            <td><?= htmlspecialchars($item->descricao) ?></td>
                            <td><?= number_format($item->quantidade, 0, ',', '.') ?></td>
                            <td>R$ <?= number_format($item->preco_unit, 2, ',', '.') ?></td>
                            <td>R$ <?= number_format($item->subTotal, 2, ',', '.') ?></td>
                            <td>
                                <button class="btn btn-mini btn-danger btn-excluir-item" data-id="<?= $item->idItem ?>">
                                    <i class="bx bx-trash"></i>
                                </button>
                            </td>
                        </tr>
                    <?php endforeach; else: ?>
                        <tr id="semItens"><td colspan="6" class="text-center muted">Nenhum item adicionado.</td></tr>
                    <?php endif; ?>
                    </tbody>
                </table>

                <!-- Formulário de adicionar item -->
                <?php if ($this->permission->checkPermission($this->session->userdata('permissao'), 'eCompra')): ?>
                <div style="padding:10px;border-top:1px solid #eee">
                    <h6>Adicionar Item</h6>
                    <div class="row-fluid">
                        <div class="span4">
                            <label>Produto (buscar no estoque)</label>
                            <input type="text" id="produtoBusca" class="span12" placeholder="Digite para buscar...">
                            <input type="hidden" id="produtos_id">
                        </div>
                        <div class="span4">
                            <label>Descrição <span class="required">*</span></label>
                            <input type="text" id="itemDescricao" class="span12" placeholder="Descrição do item">
                        </div>
                        <div class="span1">
                            <label>Qtd</label>
                            <input type="number" id="itemQtd" class="span12" value="1" min="0.001" step="0.001">
                        </div>
                        <div class="span2">
                            <label>Preço Unit.</label>
                            <input type="text" id="itemPreco" class="span12 money" placeholder="0,00">
                        </div>
                        <div class="span1" style="padding-top:18px">
                            <button class="button btn btn-success btn-mini" id="btnAddItem">
                                <i class='bx bx-plus'></i>
                            </button>
                        </div>
                    </div>
                </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<script>
var CSRF_NAME  = '<?= $this->security->get_csrf_token_name() ?>';
var CSRF_HASH  = '<?= $this->security->get_csrf_hash() ?>';
var COMPRA_ID  = <?= $result->idCompra ?>;

$(document).ready(function(){
    $(".money").maskMoney({prefix:'',thousands:'.',decimal:','});

    $("#produtoBusca").autocomplete({
        source: "<?= site_url('os/autoCompleteProduto') ?>",
        minLength: 2,
        select: function(e, ui){
            $("#produtos_id").val(ui.item.id);
            $("#itemDescricao").val(ui.item.label.split(' | ')[0]);
            if(ui.item.preco) $("#itemPreco").val(ui.item.preco.toString().replace('.',','));
        }
    });

    $("#btnAddItem").on("click", function(){
        var desc = $("#itemDescricao").val().trim();
        if(!desc){ alert("Informe a descrição do item."); return; }
        var dados = {
            compras_id:  COMPRA_ID,
            produtos_id: $("#produtos_id").val(),
            descricao:   desc,
            quantidade:  $("#itemQtd").val(),
            preco_unit:  $("#itemPreco").val()
        };
        dados[CSRF_NAME] = CSRF_HASH;
        $.post("<?= site_url('compras/adicionarItem') ?>", dados, function(res){
            if(res.result){ location.reload(); }
            else { alert("Erro ao adicionar item."); }
        },'json');
    });

    $(document).on("click",".btn-excluir-item", function(){
        var id = $(this).data('id');
        Swal.fire({title:'Remover item?',icon:'warning',showCancelButton:true,confirmButtonText:'Sim'}).then(function(r){
            if(r.isConfirmed){
                var d = {id:id}; d[CSRF_NAME]=CSRF_HASH;
                $.post("<?= site_url('compras/excluirItem') ?>",d,function(res){
                    if(res.result) $("#item-"+id).remove();
                },'json');
            }
        });
    });
});
</script>
