<link rel="stylesheet" href="<?php echo base_url(); ?>assets/js/jquery-ui/css/smoothness/jquery-ui-1.9.2.custom.css"/>
<script src="<?php echo base_url() ?>assets/js/jquery-ui/js/jquery-ui-1.9.2.custom.js"></script>
<script src="<?php echo base_url() ?>assets/js/maskmoney.js"></script>
<script src="<?php echo base_url() ?>assets/js/jquery.mask.min.js"></script>

<div class="row-fluid" style="margin-top:0">
    <div class="span12">
        <div class="widget-box">
            <div class="widget-title">
                <span class="icon"><i class="bx bx-purchase-tag-alt"></i></span>
                <h5>Nova Compra / Entrada de Estoque</h5>
            </div>
            <div class="widget-content nopadding">
                <?= $custom_error ?>
                <form action="<?= current_url() ?>" method="post" class="form-horizontal" id="formCompra">
                    <input type="hidden" name="<?= $this->security->get_csrf_token_name() ?>" value="<?= $this->security->get_csrf_hash() ?>">

                    <div class="control-group">
                        <label class="control-label">Descrição / Produto comprado <span class="required">*</span></label>
                        <div class="controls">
                            <input type="text" name="descricao" class="span8" placeholder="Ex: Compra de peças, reposição de estoque..." required value="<?= set_value('descricao') ?>">
                        </div>
                    </div>

                    <div class="control-group">
                        <label class="control-label">Fornecedor / Nome</label>
                        <div class="controls">
                            <input type="text" id="fornecedor_txt" name="fornecedor" class="span5" placeholder="Nome do fornecedor" value="<?= set_value('fornecedor') ?>">
                            <span class="help-inline">ou buscar cliente cadastrado:</span>
                            <input type="text" id="clienteBusca" class="span4" placeholder="Buscar cliente...">
                            <input type="hidden" name="clientes_id" id="clientes_id">
                        </div>
                    </div>

                    <div class="control-group">
                        <label class="control-label">Data da Compra <span class="required">*</span></label>
                        <div class="controls">
                            <input type="text" name="data_compra" id="data_compra" class="span3 datepicker" value="<?= date('d/m/Y') ?>" required>
                        </div>
                    </div>

                    <div class="control-group">
                        <label class="control-label">Data de Vencimento</label>
                        <div class="controls">
                            <input type="text" name="data_vencimento" id="data_vencimento" class="span3 datepicker" value="">
                            <span class="help-inline">Prazo para pagamento ao fornecedor</span>
                        </div>
                    </div>

                    <div class="control-group">
                        <label class="control-label">Valor Total <span class="required">*</span></label>
                        <div class="controls">
                            <input type="text" name="valor_total" id="valor_total" class="span3 money" placeholder="0,00" required>
                        </div>
                    </div>

                    <div class="control-group">
                        <label class="control-label">Valor Pago</label>
                        <div class="controls">
                            <input type="text" name="valor_pago" id="valor_pago" class="span3 money" placeholder="0,00">
                        </div>
                    </div>

                    <div class="control-group">
                        <label class="control-label">Forma de Pagamento</label>
                        <div class="controls">
                            <select name="forma_pgto" class="span4">
                                <option value="">Selecione...</option>
                                <?php foreach(['Dinheiro','Cartão de Crédito','Cartão de Débito','Boleto','PIX','Transferência','Cheque','Outros'] as $f): ?>
                                    <option value="<?=$f?>"><?=$f?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>

                    <div class="control-group">
                        <label class="control-label">Status</label>
                        <div class="controls">
                            <select name="status" class="span3">
                                <option value="pendente">Pendente</option>
                                <option value="parcial">Parcialmente Pago</option>
                                <option value="pago">Pago</option>
                                <option value="cancelado">Cancelado</option>
                            </select>
                        </div>
                    </div>

                    <div class="control-group">
                        <label class="control-label">Nº Nota Fiscal</label>
                        <div class="controls">
                            <input type="text" name="nota_fiscal" class="span4" placeholder="Número da NF (opcional)" value="<?= set_value('nota_fiscal') ?>">
                        </div>
                    </div>

                    <div class="control-group">
                        <label class="control-label">Observações</label>
                        <div class="controls">
                            <textarea name="observacoes" class="span8" rows="3" placeholder="Observações adicionais..."><?= set_value('observacoes') ?></textarea>
                        </div>
                    </div>

                    <div class="form-actions">
                        <button type="submit" class="button btn btn-success">
                            <span class="button__icon"><i class='bx bx-save'></i></span>
                            <span class="button__text2">Salvar Compra</span>
                        </button>
                        <a href="<?= site_url('compras') ?>" class="button btn btn-warning">
                            <span class="button__icon"><i class='bx bx-undo'></i></span>
                            <span class="button__text2">Voltar</span>
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
$(document).ready(function(){
    $(".datepicker").datepicker({dateFormat:'dd/mm/yy'});
    $(".money").maskMoney({prefix:'', thousands:'.', decimal:','});

    $("#clienteBusca").autocomplete({
        source: "<?= site_url('clientes/autoCompleteCliente') ?>",
        minLength: 2,
        select: function(e, ui){
            $("#clientes_id").val(ui.item.id);
            $("#fornecedor_txt").val(ui.item.label);
        }
    });
});
</script>
