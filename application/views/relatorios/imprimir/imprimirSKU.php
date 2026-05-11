<?= $topo ?>
<?php $tV=array_sum(array_column($resultados,'valorEstoque')); ?>
<table class="rp-tbl">
    <thead><tr>
        <th class="c" style="width:78px;">Cód. Barras</th>
        <th>Produto</th>
        <th class="c">UN</th>
        <th class="r">Compra</th>
        <th class="r">Venda</th>
        <th class="r">Margem%</th>
        <th class="c">Estoque</th>
        <th class="r">Val. Estoque</th>
    </tr></thead>
    <tbody>
    <?php foreach($resultados as $i=>$p):
        $margem=$p->precoVenda>0?round(($p->precoVenda-$p->precoCompra)/$p->precoVenda*100,1):0;
        $min=isset($p->estoqueMinimo)?$p->estoqueMinimo:0;
        $ec=$p->estoque<=0?'b-r':($p->estoque<=$min&&$min>0?'b-a':'b-g');
    ?>
    <tr class="<?=$i%2==0?'impar':'par'?>">
        <td class="c" style="font-size:9px;"><?=htmlspecialchars($p->codDeBarra??'')?></td>
        <td><?=htmlspecialchars($p->descricao)?></td>
        <td class="c"><?=htmlspecialchars($p->unidade)?></td>
        <td class="r">R$ <?=number_format($p->precoCompra,2,',','.')?></td>
        <td class="r">R$ <?=number_format($p->precoVenda,2,',','.')?></td>
        <td class="r"><?=$margem?>%</td>
        <td class="c"><span class="b <?=$ec?>"><?=$p->estoque?></span></td>
        <td class="r">R$ <?=number_format($p->valorEstoque,2,',','.')?></td>
    </tr>
    <?php endforeach; ?>
    <tr class="tot">
        <td colspan="7" style="text-align:right;">TOTAL VALOR ESTOQUE (Venda)</td>
        <td class="r">R$ <?=number_format($tV,2,',','.')?></td>
    </tr>
    </tbody>
</table>
<div class="rp-foot">Data do Relatório: <?=date('d/m/Y')?></div>
