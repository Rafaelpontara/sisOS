<?= $topo ?>
<?php
$tE=array_sum(array_column($produtos,'estoque'));
$tV=array_sum(array_column($produtos,'valorEstoque'));
$tC=array_sum(array_map(fn($p)=>floatval($p->estoque)*floatval($p->precoCompra),$produtos));
?>
<table class="rp-tbl">
    <thead><tr>
        <th>Produto</th>
        <th class="c">UN</th>
        <th class="r">Pr. Compra</th>
        <th class="r">Pr. Venda</th>
        <th class="r">Margem%</th>
        <th class="c">Estoque</th>
        <th class="r">Val. Venda</th>
        <th class="r">Val. Custo</th>
    </tr></thead>
    <tbody>
    <?php foreach($produtos as $i=>$p):
        $margem=$p->precoVenda>0?round(($p->precoVenda-$p->precoCompra)/$p->precoVenda*100,1):0;
        $min=isset($p->estoqueMinimo)?$p->estoqueMinimo:0;
        $ec=$p->estoque<=0?'b-r':($p->estoque<=$min&&$min>0?'b-a':'b-g');
    ?>
    <tr class="<?=$i%2==0?'impar':'par'?>">
        <td><?=htmlspecialchars($p->descricao)?></td>
        <td class="c"><?=htmlspecialchars($p->unidade)?></td>
        <td class="r">R$ <?=number_format($p->precoCompra,2,',','.')?></td>
        <td class="r">R$ <?=number_format($p->precoVenda,2,',','.')?></td>
        <td class="r"><?=$margem?>%</td>
        <td class="c"><span class="b <?=$ec?>"><?=$p->estoque?></span></td>
        <td class="r">R$ <?=number_format($p->valorEstoque,2,',','.')?></td>
        <td class="r">R$ <?=number_format(floatval($p->estoque)*floatval($p->precoCompra),2,',','.')?></td>
    </tr>
    <?php endforeach; ?>
    <tr class="tot">
        <td colspan="5" style="text-align:right;">TOTAIS (<?=count($produtos)?> produtos)</td>
        <td class="c"><?=$tE?></td>
        <td class="r">R$ <?=number_format($tV,2,',','.')?></td>
        <td class="r">R$ <?=number_format($tC,2,',','.')?></td>
    </tr>
    </tbody>
</table>
<div class="rp-foot">Data do Relatório: <?=date('d/m/Y')?></div>
