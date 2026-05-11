<script src="<?php echo base_url() ?>assets/js/sweetalert2.all.min.js"></script>
<style>
.badge-estoque-ok   { background:#27ae60; color:#fff; padding:3px 8px; border-radius:3px; }
.badge-estoque-low  { background:#e67e22; color:#fff; padding:3px 8px; border-radius:3px; }
.badge-estoque-neg  { background:#c0392b; color:#fff; padding:3px 8px; border-radius:3px; }
.card-resumo { background:#fff; border-radius:8px; padding:15px; text-align:center; box-shadow:0 2px 6px rgba(0,0,0,.08); margin-bottom:10px; }
.card-resumo h3 { font-size:26px; font-weight:700; margin:4px 0; }
.card-resumo small { color:#888; font-size:11px; }
</style>

<div class="new122">
    <div class="widget-title" style="margin:-20px 0 10px">
        <span class="icon"><i class="bx bx-package"></i></span>
        <h5>Inventário de Estoque</h5>
        <div style="float:right;padding:5px;">
            <a href="<?= site_url('estoque/movimentacoes') ?>" class="button btn btn-mini btn-inverse">
                <i class='bx bx-transfer'></i> Movimentações
            </a>
        </div>
    </div>

    <!-- Cards resumo -->
    <?php
    $totalProdutos = count($results);
    $totalAbaixo   = count($abaixo_minimo);
    $totalNegativos = count(array_filter($results, fn($r) => $r->estoque < 0));
    $totalValor = array_sum(array_map(fn($r) => $r->estoque * ($r->precoCompra ?? 0), $results));
    ?>
    <div class="row-fluid" style="margin-bottom:10px">
        <div class="span3"><div class="card-resumo">
            <small>TOTAL DE PRODUTOS</small>
            <h3 style="color:#2c3e50"><?= $totalProdutos ?></h3>
        </div></div>
        <div class="span3"><div class="card-resumo">
            <small>ABAIXO DO MÍNIMO</small>
            <h3 style="color:#e67e22"><?= $totalAbaixo ?></h3>
        </div></div>
        <div class="span3"><div class="card-resumo">
            <small>ESTOQUE NEGATIVO</small>
            <h3 style="color:#c0392b"><?= $totalNegativos ?></h3>
        </div></div>
        <div class="span3"><div class="card-resumo">
            <small>VALOR EM ESTOQUE</small>
            <h3 style="color:#27ae60; font-size:18px">R$ <?= number_format($totalValor, 2, ',', '.') ?></h3>
        </div></div>
    </div>

    <!-- Filtro -->
    <form method="get" action="<?= site_url('estoque/inventario') ?>" style="margin-bottom:10px">
        <div class="span4"><input type="text" name="pesquisa" class="span12" placeholder="Buscar produto..." value="<?= $this->input->get('pesquisa') ?>"></div>
        <div class="span2"><button class="button btn btn-inverse btn-mini"><i class='bx bx-search-alt'></i> Buscar</button></div>
    </form>

    <?php if ($totalAbaixo > 0): ?>
    <div class="alert alert-warning">
        <i class="bx bx-error-circle"></i> <strong><?= $totalAbaixo ?></strong> produto(s) com estoque abaixo do mínimo:
        <?php foreach ($abaixo_minimo as $p): ?>
            <strong><?= htmlspecialchars($p->descricao) ?></strong> (<?= $p->estoque ?>)<?= $p !== end($abaixo_minimo) ? ', ' : '' ?>
        <?php endforeach; ?>
    </div>
    <?php endif; ?>

    <div class="widget-box">
        <div class="widget-content nopadding">
            <table class="table table-bordered table-hover">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Produto</th>
                        <th>Marca</th>
                        <th>Localização</th>
                        <th>Entradas</th>
                        <th>Saídas</th>
                        <th>Estoque Atual</th>
                        <th>Mínimo</th>
                        <th>Situação</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody>
                <?php foreach ($results as $r):
                    $estoque = (float)$r->estoque;
                    $min     = (int)($r->estoqueMinimo ?? 0);
                    if ($estoque < 0) $badge = 'badge-estoque-neg';
                    elseif ($min > 0 && $estoque <= $min) $badge = 'badge-estoque-low';
                    else $badge = 'badge-estoque-ok';
                ?>
                <tr>
                    <td><?= $r->idProdutos ?></td>
                    <td>
                        <a href="<?= site_url('produtos/visualizar/'.$r->idProdutos) ?>"><?= htmlspecialchars($r->descricao) ?></a>
                    <a href="<?= site_url('estoque/avarias') ?>" class="button btn btn-mini btn-danger">
                        <span class="button__icon"><i class='bx bx-error-alt'></i></span>
                        <span class="button__text2">Avarias</span>
                    </a>
                    </td>
                    <td><?= htmlspecialchars($r->marca ?? '—') ?></td>
                    <td><?= htmlspecialchars($r->localizacao ?? '—') ?></td>
                    <td class="text-center" style="color:#27ae60;font-weight:600">+<?= number_format($r->total_entradas ?? 0, 0, ',', '.') ?></td>
                    <td class="text-center" style="color:#c0392b;font-weight:600">-<?= number_format($r->total_saidas ?? 0, 0, ',', '.') ?></td>
                    <td class="text-center"><span class="<?= $badge ?>"><?= number_format($estoque, 0, ',', '.') ?></span></td>
                    <td class="text-center"><?= $min ?: '—' ?></td>
                    <td class="text-center">
                        <?php if ($estoque < 0): ?><span class="badge badge-danger">Negativo</span>
                        <?php elseif ($min > 0 && $estoque <= $min): ?><span class="badge badge-warning">Baixo</span>
                        <?php else: ?><span class="badge badge-success">OK</span>
                        <?php endif; ?>
                    </td>
                    <td>
                        <button class="btn btn-mini btn-info btn-historico" data-id="<?= $r->idProdutos ?>" data-nome="<?= htmlspecialchars($r->descricao) ?>" title="Histórico"><i class="bx bx-history"></i></button>
                        <button class="btn btn-mini btn-warning btn-ajustar" data-id="<?= $r->idProdutos ?>" data-estoque="<?= $estoque ?>" title="Ajustar"><i class="bx bx-edit"></i></button>
                    </td>
                </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Modal histórico -->
<div id="modalHistorico" class="modal hide fade" tabindex="-1">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 id="modalHistoricoTitulo">Histórico de Movimentações</h4>
    </div>
    <div class="modal-body" id="modalHistoricoBody" style="max-height:400px;overflow-y:auto">
        <p>Carregando...</p>
    </div>
</div>

<!-- Modal ajuste -->
<div id="modalAjuste" class="modal hide fade" tabindex="-1">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4>Ajuste Manual de Estoque</h4>
    </div>
    <div class="modal-body">
        <input type="hidden" id="ajuste_produto_id">
        <div class="control-group">
            <label>Tipo</label>
            <select id="ajuste_tipo" class="span12">
                <option value="entrada">Entrada (adicionar)</option>
                <option value="saida">Saída (remover)</option>
            </select>
        </div>
        <div class="control-group">
            <label>Quantidade</label>
            <input type="number" id="ajuste_qtd" class="span12" value="1" min="0.001" step="0.001">
        </div>
        <div class="control-group">
            <label>Observação</label>
            <input type="text" id="ajuste_obs" class="span12" placeholder="Motivo do ajuste...">
        </div>
    </div>
    <div class="modal-footer">
        <button class="btn btn-success" id="btnConfirmarAjuste">Confirmar</button>
        <button class="btn" data-dismiss="modal">Cancelar</button>
    </div>
</div>

<script>
var CSRF_NAME = '<?= $this->security->get_csrf_token_name() ?>';
var CSRF_HASH = '<?= $this->security->get_csrf_hash() ?>';

$(document).ready(function(){
    // Histórico
    $('.btn-historico').on('click', function(){
        var id   = $(this).data('id');
        var nome = $(this).data('nome');
        $('#modalHistoricoTitulo').text('Histórico: ' + nome);
        $('#modalHistoricoBody').html('<p>Carregando...</p>');
        $('#modalHistorico').modal('show');
        $.get('<?= site_url('estoque/historicoProduto') ?>?id=' + id, function(data){
            if (!data.length) { $('#modalHistoricoBody').html('<p class="muted">Sem movimentações registradas.</p>'); return; }
            var html = '<table class="table table-condensed"><thead><tr><th>Data</th><th>Tipo</th><th>Origem</th><th>Qtd</th><th>Antes</th><th>Depois</th><th>Usuário</th></tr></thead><tbody>';
            $.each(data, function(i,m){
                var cor = m.tipo === 'entrada' ? 'green' : 'red';
                html += '<tr><td>'+m.data+'</td><td style="color:'+cor+'">'+m.tipo+'</td><td>'+m.origem+'</td><td>'+(m.tipo==='entrada'?'+':'-')+m.qtd+'</td><td>'+m.antes+'</td><td>'+m.depois+'</td><td>'+m.usuario+'</td></tr>';
            });
            html += '</tbody></table>';
            $('#modalHistoricoBody').html(html);
        }, 'json');
    });

    // Ajuste
    $('.btn-ajustar').on('click', function(){
        $('#ajuste_produto_id').val($(this).data('id'));
        $('#ajuste_qtd').val(1);
        $('#ajuste_obs').val('');
        $('#modalAjuste').modal('show');
    });

    $('#btnConfirmarAjuste').on('click', function(){
        var d = {
            produtos_id: $('#ajuste_produto_id').val(),
            tipo: $('#ajuste_tipo').val(),
            quantidade: $('#ajuste_qtd').val(),
            observacao: $('#ajuste_obs').val()
        };
        d[CSRF_NAME] = CSRF_HASH;
        $.post('<?= site_url('estoque/ajustar') ?>', d, function(res){
            if (res.result) {
                Swal.fire({icon:'success',title:'Ajuste realizado!',text:'Novo estoque: '+res.estoque,timer:2000,showConfirmButton:false}).then(function(){ location.reload(); });
            } else {
                Swal.fire('Erro', res.messages || 'Não foi possível ajustar.', 'error');
            }
        },'json');
    });
});
</script>
