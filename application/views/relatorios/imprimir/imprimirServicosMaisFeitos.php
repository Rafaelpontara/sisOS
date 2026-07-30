<?= $topo ?>
<div class="rp-foot" style="margin-bottom:8px;">Período: <?= htmlspecialchars($periodo) ?></div>
<?php
$tQ = array_sum(array_map(fn($s) => (int)$s->qtdFeita, $servicos));
$tV = array_sum(array_map(fn($s) => floatval($s->valorTotal), $servicos));
?>
<table class="rp-tbl">
    <thead><tr>
        <th class="c">#</th>
        <th>Serviço</th>
        <th class="r">Preço Base</th>
        <th class="c">Qtd. Realizada</th>
        <th class="r">Valor Total</th>
    </tr></thead>
    <tbody>
    <?php foreach ($servicos as $i => $s): ?>
    <tr class="<?= $i % 2 == 0 ? 'impar' : 'par' ?>">
        <td class="c"><?= $i + 1 ?>º</td>
        <td><?= htmlspecialchars($s->nome) ?></td>
        <td class="r">R$ <?= number_format($s->preco, 2, ',', '.') ?></td>
        <td class="c"><span class="b b-g"><?= (int)$s->qtdFeita ?></span></td>
        <td class="r">R$ <?= number_format($s->valorTotal, 2, ',', '.') ?></td>
    </tr>
    <?php endforeach; ?>
    <?php if (!$servicos): ?>
    <tr><td colspan="5" style="text-align:center;">Nenhum serviço realizado no período.</td></tr>
    <?php endif; ?>
    <tr class="tot">
        <td colspan="3" style="text-align:right;">TOTAIS (<?= count($servicos) ?> serviços)</td>
        <td class="c"><?= $tQ ?></td>
        <td class="r">R$ <?= number_format($tV, 2, ',', '.') ?></td>
    </tr>
    </tbody>
</table>
<div class="rp-foot">Data do Relatório: <?= date('d/m/Y') ?></div>
