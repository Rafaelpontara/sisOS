<div class="new122">
    <div class="widget-title" style="margin:-20px 0 10px">
        <span class="icon"><i class="bx bx-transfer"></i></span>
        <h5>Movimentações de Estoque</h5>
        <div style="float:right;padding:5px">
            <a href="<?= site_url('estoque/inventario') ?>" class="button btn btn-mini btn-info">
                <i class='bx bx-package'></i> Inventário
            </a>
                    <a href="<?= site_url('estoque/avarias') ?>" class="button btn btn-mini btn-danger">
                        <span class="button__icon"><i class='bx bx-error-alt'></i></span>
                        <span class="button__text2">Avarias</span>
                    </a>
        </div>
    </div>

    <!-- Filtro -->
    <form method="get" action="<?= site_url('estoque/movimentacoes') ?>" style="margin-bottom:10px">
        <div class="span3"><input type="text" name="pesquisa" class="span12" placeholder="Buscar produto..." value="<?= $this->input->get('pesquisa') ?>"></div>
        <div class="span2">
            <select name="tipo" class="span12">
                <option value="">Todos os tipos</option>
                <option value="entrada" <?= $this->input->get('tipo')=='entrada'?'selected':''?>>Entradas</option>
                <option value="saida"   <?= $this->input->get('tipo')=='saida'?'selected':''?>>Saídas</option>
            </select>
        </div>
        <div class="span2">
            <select name="origem" class="span12">
                <option value="">Todas as origens</option>
                <?php foreach (['compra','venda','os','avaria','ajuste','inventario'] as $o): ?>
                    <option value="<?=$o?>" <?=$this->input->get('origem')==$o?'selected':''?>><?=ucfirst($o)?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="span2"><input type="text" name="data"  class="span12 datepicker" placeholder="De" value="<?=$this->input->get('data')?>"></div>
        <div class="span2"><input type="text" name="data2" class="span12 datepicker" placeholder="Até" value="<?=$this->input->get('data2')?>"></div>
        <div class="span1"><button class="button btn btn-inverse btn-mini"><i class='bx bx-search-alt'></i></button></div>
    </form>

    <?php if (!empty($abaixo_minimo)): ?>
    <div class="alert alert-warning" style="margin-bottom:10px">
        <i class="bx bx-error-circle"></i> <?= count($abaixo_minimo) ?> produto(s) abaixo do estoque mínimo.
        <a href="<?= site_url('estoque/inventario') ?>">Ver inventário</a>
    </div>
    <?php endif; ?>

    <div class="widget-box">
        <div class="widget-content nopadding">
            <table class="table table-bordered table-hover">
                <thead>
                    <tr>
                        <th>Data/Hora</th>
                        <th>Produto</th>
                        <th>Tipo</th>
                        <th>Origem</th>
                        <th>Quantidade</th>
                        <th>Estoque Antes</th>
                        <th>Estoque Depois</th>
                        <th>Observação</th>
                        <th>Usuário</th>
                    </tr>
                </thead>
                <tbody>
                <?php if ($results): foreach ($results as $r):
                    $corTipo = $r->tipo === 'entrada' ? '#27ae60' : '#e74c3c';
                    $sinal   = $r->tipo === 'entrada' ? '+' : '-';
                ?>
                <tr>
                    <td><?= date('d/m/Y H:i', strtotime($r->created_at)) ?></td>
                    <td><a href="<?= site_url('produtos/visualizar/'.$r->produtos_id) ?>"><?= htmlspecialchars($r->nomeProduto) ?></a></td>
                    <td><span style="color:<?=$corTipo?>;font-weight:600"><?= ucfirst($r->tipo) ?></span></td>
                    <td><?= ucfirst($r->origem) ?><?= $r->origem_id ? " #$r->origem_id" : '' ?></td>
                    <td style="color:<?=$corTipo?>;font-weight:600"><?= $sinal . number_format($r->quantidade, 2, ',', '.') ?></td>
                    <td><?= number_format($r->estoque_antes, 2, ',', '.') ?></td>
                    <td><?= number_format($r->estoque_depois, 2, ',', '.') ?></td>
                    <td><?= htmlspecialchars($r->observacao ?? '—') ?></td>
                    <td><?= htmlspecialchars($r->nomeUsuario) ?></td>
                </tr>
                <?php endforeach; else: ?>
                    <tr><td colspan="9" class="text-center muted" style="padding:20px">Nenhuma movimentação encontrada.</td></tr>
                <?php endif; ?>
                </tbody>
            </table>
            <?= $this->pagination->create_links() ?>
        </div>
    </div>
</div>

<link rel="stylesheet" href="<?php echo base_url(); ?>assets/js/jquery-ui/css/smoothness/jquery-ui-1.9.2.custom.css"/>
<script src="<?php echo base_url() ?>assets/js/jquery-ui/js/jquery-ui-1.9.2.custom.js"></script>
<script>$(function(){ $(".datepicker").datepicker({dateFormat:'dd/mm/yy'}); });</script>
