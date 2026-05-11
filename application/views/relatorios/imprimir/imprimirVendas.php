<?= $topo ?>
<?php $sum=0;foreach($vendas as $v)$sum+=($v->valor_desconto!=0?$v->valor_desconto:$v->valorTotal); ?>
<table class="rp-tbl">
    <thead><tr>
        <th class="c" style="width:44px;">#</th>
        <th>Cliente</th>
        <th class="c">Vendedor</th>
        <th class="c">Data</th>
        <th class="r">Subtotal</th>
        <th class="r">Desconto</th>
        <th class="r">Total</th>
        <th class="c">Faturado</th>
    </tr></thead>
    <tbody>
    <?php foreach($vendas as $i=>$v):
        $total=$v->valor_desconto!=0?$v->valor_desconto:$v->valorTotal;
        $desc=$v->desconto!=0?($v->tipo_desconto=='real'?'R$ '.number_format($v->desconto,2,',','.'):number_format($v->desconto,2).'%'):'—';
    ?>
    <tr class="<?=$i%2==0?'impar':'par'?>">
        <td class="c">#<?=str_pad($v->idVendas,4,'0',STR_PAD_LEFT)?></td>
        <td><?=htmlspecialchars($v->nomeCliente??'')?></td>
        <td class="c"><?=htmlspecialchars($v->nome??'')?></td>
        <td class="c"><?=date('d/m/Y',strtotime($v->dataVenda))?></td>
        <td class="r">R$ <?=number_format($v->valorTotal,2,',','.')?></td>
        <td class="r"><?=$desc?></td>
        <td class="r"><b>R$ <?=number_format($total,2,',','.')?></b></td>
        <td class="c"><span class="b <?=$v->faturado?'b-g':'b-a'?>"><?=$v->faturado?'Sim':'Não'?></span></td>
    </tr>
    <?php endforeach; ?>
    <tr class="tot">
        <td colspan="6" style="text-align:right;">TOTAL (<?=count($vendas)?> vendas)</td>
        <td class="r">R$ <?=number_format($sum,2,',','.')?></td>
        <td></td>
    </tr>
    </tbody>
</table>
<div class="rp-foot">Data do Relatório: <?=date('d/m/Y')?></div>
