<?= $topo ?>
<div class="rp-foot" style="margin-bottom:8px;">Período: <?= htmlspecialchars($periodo) ?></div>
<?php
$tQ = array_sum(array_map(fn($p) => (int)$p->qtdVendida, $produtos));
$tV = array_sum(array_map(fn($p) => floatval($p->valorTotal), $produtos));
?>
<table class="rp-tbl">
    <thead><tr>
        <th class="c">#</th>
        <th>Produto</th>
        <th class="r">Preço Venda</th>
        <th class="c">Qtd. Vendida</th>
        <th class="r">Valor Total</th>
    </tr></thead>
    <tbody>
    <?php foreach ($produtos as $i => $p): ?>
    <tr class="<?= $i % 2 == 0 ? 'impar' : 'par' ?>">
        <td class="c"><?= $i + 1 ?>º</td>
        <td><?= htmlspecialchars($p->descricao) ?></td>
        <td class="r">R$ <?= number_format($p->precoVenda, 2, ',', '.') ?></td>
        <td class="c"><span class="b b-g"><?= (int)$p->qtdVendida ?></span></td>
        <td class="r">R$ <?= number_format($p->valorTotal, 2, ',', '.') ?></td>
    </tr>
    <?php endforeach; ?>
    <?php if (!$produtos): ?>
    <tr><td colspan="5" style="text-align:center;">Nenhum produto vendido no período.</td></tr>
    <?php endif; ?>
    <tr class="tot">
        <td colspan="3" style="text-align:right;">TOTAIS (<?= count($produtos) ?> produtos)</td>
        <td class="c"><?= $tQ ?></td>
        <td class="r">R$ <?= number_format($tV, 2, ',', '.') ?></td>
    </tr>
    </tbody>
</table>
<div class="rp-foot">Data do Relatório: <?= date('d/m/Y') ?></div>
