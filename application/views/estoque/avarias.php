<link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/custom.css" />

<div class="row-fluid" style="margin-top:0">
    <div class="span12">
        <div class="widget-box">
            <div class="widget-title" style="margin:-20px 0 0">
                <span class="icon"><i class='bx bx-error-alt'></i></span>
                <h5>Avarias / Perdas de Estoque</h5>
                <div class="buttons">
                    <button class="button btn btn-mini btn-danger" id="btnNovaAvaria">
                        <span class="button__icon"><i class='bx bx-plus'></i></span>
                        <span class="button__text2">Registrar Avaria</span>
                    </button>
                    <a href="<?= site_url('estoque/inventario') ?>" class="button btn btn-mini btn-inverse">
                        <span class="button__icon"><i class='bx bx-list-ul'></i></span>
                        <span class="button__text2">Inventário</span>
                    </a>
                    <a href="<?= site_url('estoque/movimentacoes') ?>" class="button btn btn-mini btn-inverse">
                        <span class="button__icon"><i class='bx bx-transfer'></i></span>
                        <span class="button__text2">Movimentações</span>
                    </a>
                </div>
            </div>
            <div class="widget-content nopadding">
                <?php if (!$avarias): ?>
                    <div class="alert alert-info" style="margin:20px">Nenhuma avaria registrada.</div>
                <?php else: ?>
                <table class="table table-bordered table-hover">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Data</th>
                            <th>Produto</th>
                            <th>Qtd</th>
                            <th>Motivo</th>
                            <th>Observação</th>
                            <th>Responsável</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($avarias as $a): ?>
                        <tr>
                            <td><?= $a->idAvaria ?></td>
                            <td><?= date('d/m/Y', strtotime($a->data)) ?></td>
                            <td><strong><?= htmlspecialchars($a->nomeProduto) ?></strong></td>
                            <td><span class="badge badge-important"><?= number_format($a->quantidade, 2) ?></span></td>
                            <td><?= htmlspecialchars($a->motivo ?: '—') ?></td>
                            <td><?= htmlspecialchars($a->observacao ?: '—') ?></td>
                            <td><?= htmlspecialchars($a->nomeUsuario ?: '—') ?></td>
                        </tr>
                    <?php endforeach; ?>
                    </tbody>
                </table>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<!-- Modal Registrar Avaria -->
<div id="modalAvaria" class="modal hide fade" tabindex="-1" role="dialog">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">×</button>
        <h5><i class='bx bx-error-alt'></i> Registrar Avaria / Perda</h5>
    </div>
    <div class="modal-body">
        <div class="control-group">
            <label class="control-label">Produto<span class="required">*</span></label>
            <div class="controls">
                <input type="text" id="avProduto" class="span12" placeholder="Digite o nome do produto..." autocomplete="off" />
                <input type="hidden" id="avProdutoId" />
            </div>
        </div>
        <div class="control-group">
            <label class="control-label">Quantidade<span class="required">*</span></label>
            <div class="controls">
                <input type="number" id="avQtd" class="span4" min="0.01" step="0.01" value="1" />
            </div>
        </div>
        <div class="control-group">
            <label class="control-label">Data da Avaria</label>
            <div class="controls">
                <input type="text" id="avData" class="span4 datepicker" value="<?= date('d/m/Y') ?>" />
            </div>
        </div>
        <div class="control-group">
            <label class="control-label">Motivo</label>
            <div class="controls">
                <select id="avMotivo" class="span8">
                    <option value="">Selecione...</option>
                    <option>Avaria física</option>
                    <option>Produto vencido</option>
                    <option>Perda / extravio</option>
                    <option>Dano durante reparo</option>
                    <option>Queima / curto circuito</option>
                    <option>Roubo / furto</option>
                    <option>Erro de inventário</option>
                    <option>Outro</option>
                </select>
            </div>
        </div>
        <div class="control-group">
            <label class="control-label">Observação</label>
            <div class="controls">
                <textarea id="avObs" class="span12" rows="3" placeholder="Detalhes adicionais..."></textarea>
            </div>
        </div>
    </div>
    <div class="modal-footer" style="display:flex;justify-content:center;gap:8px">
        <button type="button" class="button btn btn-danger btn-mini" data-dismiss="modal">
            <span class="button__icon"><i class='bx bx-x'></i></span><span class="button__text2">Cancelar</span>
        </button>
        <button type="button" id="btnSalvarAvaria" class="button btn btn-success btn-mini">
            <span class="button__icon"><i class='bx bx-save'></i></span><span class="button__text2">Registrar</span>
        </button>
    </div>
</div>

<script>
$(document).ready(function(){
    $(".datepicker").datepicker({ dateFormat: 'dd/mm/yy' });

    $('#btnNovaAvaria').click(function(){ $('#modalAvaria').modal('show'); });

    $('#avProduto').autocomplete({
        source: '<?= base_url() ?>index.php/estoque/ajustar',
        minLength: 2,
        source: function(req, resp){
            $.getJSON('<?= base_url() ?>index.php/produtos/autoComplete', {term: req.term}, function(data){
                resp(data);
            });
        },
        select: function(e, ui){
            $('#avProdutoId').val(ui.item.id);
        }
    });

    // Use vendas autocomplete for products
    $('#avProduto').autocomplete({
        source: '<?= base_url() ?>index.php/vendas/autoCompleteProduto',
        minLength: 2,
        select: function(e, ui){
            $('#avProduto').val(ui.item.label.split(' | ')[0]);
            $('#avProdutoId').val(ui.item.id);
            return false;
        }
    });

    $('#btnSalvarAvaria').click(function(){
        var prodId = $('#avProdutoId').val();
        var qtd    = $('#avQtd').val();
        if (!prodId || !qtd) { alert('Produto e quantidade são obrigatórios.'); return; }
        $.post('<?= site_url('estoque/registrarAvaria') ?>', {
            produtos_id: prodId,
            quantidade:  qtd,
            data:        $('#avData').val(),
            motivo:      $('#avMotivo').val(),
            observacao:  $('#avObs').val(),
            '<?= $this->security->get_csrf_token_name() ?>': '<?= $this->security->get_csrf_hash() ?>'
        }, function(res){
            if (res.result) {
                $('#modalAvaria').modal('hide');
                location.reload();
            } else {
                alert('Erro: ' + (res.messages || 'Não foi possível registrar.'));
            }
        }, 'json');
    });
});
</script>
