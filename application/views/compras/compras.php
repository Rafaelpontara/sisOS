<link rel="stylesheet" href="<?php echo base_url(); ?>assets/js/jquery-ui/css/smoothness/jquery-ui-1.9.2.custom.css" />
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/table-custom.css" />
<script src="<?php echo base_url() ?>assets/js/sweetalert2.all.min.js"></script>

<div class="new122">
    <div class="widget-title" style="margin:-20px 0 0">
        <span class="icon"><i class="bx bx-purchase-tag-alt"></i></span>
        <h5>Compras / Entradas de Estoque</h5>
    </div>

    <div class="span12" style="margin-left:0">
        <form method="get" action="<?= site_url('compras/gerenciar') ?>">
            <?php if ($this->permission->checkPermission($this->session->userdata('permissao'), 'aCompra')): ?>
                <div class="span2">
                    <a href="<?= site_url('compras/adicionar') ?>" class="button btn btn-mini btn-success">
                        <span class="button__icon"><i class='bx bx-plus-circle'></i></span>
                        <span class="button__text2">Nova Compra</span>
                    </a>
                </div>
                <div class="span2">
                    <a href="<?= site_url('compras/saidas') ?>" class="button btn btn-mini btn-warning">
                        <span class="button__icon"><i class='bx bx-export'></i></span>
                        <span class="button__text2">Saídas</span>
                    </a>
                </div>
            <?php endif; ?>
            <div class="span3">
                <input type="text" name="pesquisa" placeholder="Descrição ou fornecedor..." class="span12" value="<?= $this->input->get('pesquisa') ?>">
            </div>
            <div class="span2">
                <select name="status" class="span12">
                    <option value="">Todos os status</option>
                    <?php foreach (['pendente','pago','parcial','cancelado'] as $s): ?>
                        <option value="<?=$s?>" <?=$this->input->get('status')==$s?'selected':''?>><?=ucfirst($s)?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="span3">
                <input type="text" name="data"  autocomplete="off" placeholder="Data Inicial" class="span6 datepicker" value="<?=$this->input->get('data')?>">
                <input type="text" name="data2" autocomplete="off" placeholder="Data Final"   class="span6 datepicker" value="<?=$this->input->get('data2')?>">
            </div>
            <div class="span1">
                <button class="button btn btn-mini btn-inverse" style="min-width:30px">
                    <span class="button__icon"><i class='bx bx-search-alt'></i></span>
                </button>
            </div>
        </form>
    </div>

    <div class="widget-box" style="margin-top:8px">
        <div class="widget-content nopadding">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Descrição</th>
                        <th>Fornecedor / Cliente</th>
                        <th>Data Compra</th>
                        <th>Vencimento</th>
                        <th>Valor Total</th>
                        <th>Valor Pago</th>
                        <th>Status</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody>
                <?php if ($results): foreach ($results as $r):
                    $cores = ['pendente'=>'#f0ad4e','pago'=>'#5cb85c','parcial'=>'#5bc0de','cancelado'=>'#d9534f'];
                    $cor = $cores[$r->status] ?? '#aaa';
                ?>
                    <tr>
                        <td><?= $r->idCompra ?></td>
                        <td><?= htmlspecialchars($r->descricao) ?></td>
                        <td><?= htmlspecialchars($r->nomeCliente ?: $r->fornecedor ?: '—') ?></td>
                        <td><?= date('d/m/Y', strtotime($r->data_compra)) ?></td>
                        <td><?= $r->data_vencimento ? date('d/m/Y', strtotime($r->data_vencimento)) : '—' ?></td>
                        <td>R$ <?= number_format($r->valor_total, 2, ',', '.') ?></td>
                        <td>R$ <?= number_format($r->valor_pago, 2, ',', '.') ?></td>
                        <td><span class="badge" style="background:<?=$cor?>"><?= ucfirst($r->status) ?></span></td>
                        <td>
                            <a href="<?= site_url('compras/visualizar/'.$r->idCompra) ?>" class="btn btn-mini btn-info" title="Visualizar"><i class="bx bx-show"></i></a>
                            <?php if ($this->permission->checkPermission($this->session->userdata('permissao'), 'eCompra')): ?>
                                <a href="<?= site_url('compras/editar/'.$r->idCompra) ?>" class="btn btn-mini btn-success" title="Editar"><i class="bx bx-edit"></i></a>
                            <?php endif; ?>
                            <?php if ($this->permission->checkPermission($this->session->userdata('permissao'), 'dCompra')): ?>
                                <button class="btn btn-mini btn-danger btn-excluir" data-id="<?=$r->idCompra?>" title="Excluir"><i class="bx bx-trash"></i></button>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endforeach; else: ?>
                    <tr><td colspan="9" class="text-center">Nenhuma compra cadastrada.</td></tr>
                <?php endif; ?>
                </tbody>
            </table>
            <?= $this->pagination->create_links() ?>
        </div>
    </div>
</div>

<link rel="stylesheet" href="<?php echo base_url(); ?>assets/js/jquery-ui/css/smoothness/jquery-ui-1.9.2.custom.css"/>
<script src="<?php echo base_url() ?>assets/js/jquery-ui/js/jquery-ui-1.9.2.custom.js"></script>
<script>
$(document).ready(function(){
    $(".datepicker").datepicker({dateFormat:'dd/mm/yy'});
    $(".btn-excluir").on("click", function(){
        var id = $(this).data('id');
        Swal.fire({
            title:'Excluir compra?',
            text:'Esta ação não pode ser desfeita.',
            icon:'warning',
            showCancelButton:true,
            confirmButtonText:'Sim, excluir',
            cancelButtonText:'Cancelar'
        }).then(function(r){
            if(r.isConfirmed){
                $.post('<?= site_url('compras/excluir') ?>',{id:id,'<?=$this->security->get_csrf_token_name()?>':'<?=$this->security->get_csrf_hash()?>'},function(res){
                    if(res.result) location.reload();
                    else Swal.fire('Erro','Não foi possível excluir.','error');
                },'json');
            }
        });
    });
});
</script>
