<script src="<?php echo base_url() ?>assets/js/sweetalert2.all.min.js"></script>
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/js/jquery-ui/css/smoothness/jquery-ui-1.9.2.custom.css"/>
<script src="<?php echo base_url() ?>assets/js/jquery-ui/js/jquery-ui-1.9.2.custom.js"></script>

<div class="new122">
    <div class="widget-title" style="margin:-20px 0 0">
        <span class="icon"><i class="bx bx-export"></i></span>
        <h5>Saídas de Estoque</h5>
        <div style="float:right;padding:5px">
            <a href="<?= site_url('compras') ?>" class="button btn btn-mini btn-warning">
                <span class="button__icon"><i class='bx bx-undo'></i></span>
                <span class="button__text2">Voltar para Compras</span>
            </a>
        </div>
    </div>

    <!-- Formulário de nova saída -->
    <?php if ($this->permission->checkPermission($this->session->userdata('permissao'), 'aCompra')): ?>
    <div class="widget-box" style="margin-top:10px">
        <div class="widget-title">
            <span class="icon"><i class="bx bx-minus-circle"></i></span>
            <h5>Registrar Nova Saída</h5>
        </div>
        <div class="widget-content" style="padding:15px">
            <div class="row-fluid" id="formSaida">
                <div class="span4">
                    <label>Produto <span class="required">*</span></label>
                    <select id="produtos_id" class="span12">
                        <option value="">Selecione o produto...</option>
                        <?php foreach ($produtos as $p): ?>
                            <option value="<?= $p->idProdutos ?>"><?= htmlspecialchars($p->descricao) ?> (Estoque: <?= $p->estoque ?>)</option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="span2">
                    <label>Quantidade <span class="required">*</span></label>
                    <input type="number" id="quantidade" class="span12" value="1" min="0.001" step="0.001">
                </div>
                <div class="span3">
                    <label>Motivo <span class="required">*</span></label>
                    <select id="motivo" class="span12">
                        <option value="">Selecione...</option>
                        <option value="Perda / Avaria">Perda / Avaria</option>
                        <option value="Uso interno">Uso interno</option>
                        <option value="Devolução ao fornecedor">Devolução ao fornecedor</option>
                        <option value="Ajuste de inventário">Ajuste de inventário</option>
                        <option value="Vencimento / Expirado">Vencimento / Expirado</option>
                        <option value="Outro">Outro</option>
                    </select>
                </div>
                <div class="span2">
                    <label>Data</label>
                    <input type="text" id="data_saida" class="span12 datepicker" value="<?= date('d/m/Y') ?>">
                </div>
                <div class="span1" style="padding-top:18px">
                    <button class="button btn btn-danger" id="btnAddSaida">
                        <span class="button__icon"><i class='bx bx-save'></i></span>
                        <span class="button__text2">Registrar</span>
                    </button>
                </div>
                <div class="span12" style="margin-top:8px">
                    <label>Observações</label>
                    <input type="text" id="observacoes" class="span8" placeholder="Observação adicional (opcional)">
                </div>
            </div>
        </div>
    </div>
    <?php endif; ?>

    <!-- Listagem de saídas -->
    <div class="widget-box" style="margin-top:10px">
        <div class="widget-content nopadding">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Produto</th>
                        <th>Quantidade</th>
                        <th>Motivo</th>
                        <th>Data</th>
                        <th>Usuário</th>
                        <th>Ação</th>
                    </tr>
                </thead>
                <tbody id="tabelaSaidas">
                <?php if ($results): foreach ($results as $r): ?>
                    <tr id="saida-<?= $r->idSaida ?>">
                        <td><?= $r->idSaida ?></td>
                        <td><?= htmlspecialchars($r->nomeProduto) ?></td>
                        <td><?= number_format($r->quantidade, 0, ',', '.') ?></td>
                        <td><?= htmlspecialchars($r->motivo) ?></td>
                        <td><?= date('d/m/Y', strtotime($r->data_saida)) ?></td>
                        <td><?= htmlspecialchars($r->nomeUsuario) ?></td>
                        <td>
                            <?php if ($this->permission->checkPermission($this->session->userdata('permissao'), 'dCompra')): ?>
                                <button class="btn btn-mini btn-danger btn-excluir-saida" data-id="<?= $r->idSaida ?>" title="Excluir">
                                    <i class="bx bx-trash"></i>
                                </button>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endforeach; else: ?>
                    <tr><td colspan="7" class="text-center muted">Nenhuma saída registrada.</td></tr>
                <?php endif; ?>
                </tbody>
            </table>
            <?= $this->pagination->create_links() ?>
        </div>
    </div>
</div>

<script>
var CSRF_NAME = '<?= $this->security->get_csrf_token_name() ?>';
var CSRF_HASH = '<?= $this->security->get_csrf_hash() ?>';

$(document).ready(function(){
    $(".datepicker").datepicker({dateFormat:'dd/mm/yy'});

    $("#btnAddSaida").on("click", function(){
        var produtoId = $("#produtos_id").val();
        var quantidade = $("#quantidade").val();
        var motivo = $("#motivo").val();
        var data_saida = $("#data_saida").val();

        if(!produtoId || !quantidade || !motivo){
            Swal.fire('Atenção','Preencha produto, quantidade e motivo.','warning');
            return;
        }

        var dados = {
            produtos_id: produtoId,
            quantidade: quantidade,
            motivo: motivo,
            data_saida: data_saida,
            observacoes: $("#observacoes").val()
        };
        dados[CSRF_NAME] = CSRF_HASH;

        $.post("<?= site_url('compras/adicionarSaida') ?>", dados, function(res){
            if(res.result){
                Swal.fire({icon:'success',title:'Saída registrada!',timer:1500,showConfirmButton:false})
                    .then(function(){ location.reload(); });
            } else {
                Swal.fire('Erro', res.messages || 'Erro ao registrar saída.', 'error');
            }
        },'json');
    });

    $(document).on("click",".btn-excluir-saida",function(){
        var id = $(this).data('id');
        Swal.fire({title:'Remover saída?',icon:'warning',showCancelButton:true,confirmButtonText:'Sim'}).then(function(r){
            if(r.isConfirmed){
                var d={id:id}; d[CSRF_NAME]=CSRF_HASH;
                $.post("<?= site_url('compras/excluirSaida') ?>",d,function(res){
                    if(res.result) $("#saida-"+id).fadeOut(300,function(){$(this).remove();});
                },'json');
            }
        });
    });
});
</script>
