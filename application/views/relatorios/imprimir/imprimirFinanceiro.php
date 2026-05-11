<?= $topo ?>
<?php $tRec=0;$tDesp=0; ?>
<table class="rp-tbl">
    <thead><tr>
        <th>Cliente / Fornecedor</th>
        <th class="c">Tipo</th>
        <th class="r">Valor</th>
        <th class="r">Desconto</th>
        <th class="r">Valor Total</th>
        <th class="c">Vencimento</th>
        <th class="c">Pagamento</th>
        <th class="c">Forma Pgto.</th>
        <th class="c">Situação</th>
    </tr></thead>
    <tbody>
    <?php foreach($lancamentos as $i=>$l):
        $venc=date('d/m/Y',strtotime($l->data_vencimento));
        $pgto=($l->data_pagamento&&$l->data_pagamento!='0000-00-00')?date('d/m/Y',strtotime($l->data_pagamento)):'';
        $sit=$l->baixado==1?'Pago':'Pendente';
        $sitCls=$l->baixado==1?'b-g':'b-a';
        $tipCls=$l->tipo=='receita'?'b-g':'b-r';
        $vFinal=$l->valor_desconto!=0?$l->valor_desconto:$l->valor;
        $desc=$l->desconto!=0?($l->tipo_desconto=='real'?'R$ '.number_format($l->desconto,2,',','.'):number_format($l->desconto,2).'%'):'0,00';
        if($l->tipo=='receita') $tRec+=$vFinal; else $tDesp+=$vFinal;
    ?>
    <tr class="<?=$i%2==0?'impar':'par'?>">
        <td><?=htmlspecialchars($l->cliente_fornecedor??'')?></td>
        <td class="c"><span class="b <?=$tipCls?>"><?=htmlspecialchars($l->tipo)?></span></td>
        <td class="r">R$ <?=number_format($l->valor,2,',','.')?></td>
        <td class="r"><?=$desc?></td>
        <td class="r"><b>R$ <?=number_format($vFinal,2,',','.')?></b></td>
        <td class="c"><?=$venc?></td>
        <td class="c"><?=$pgto?></td>
        <td class="c"><?=htmlspecialchars($l->forma_pgto??'')?></td>
        <td class="c"><span class="b <?=$sitCls?>"><?=$sit?></span></td>
    </tr>
    <?php endforeach; ?>
    </tbody>
</table>
<?php $sal=$tRec-$tDesp; ?>
<table class="rp-res" cellspacing="0" cellpadding="0">
    <tr>
        <td class="res-rec">Total Receitas: &nbsp;<b>R$ <?=number_format($tRec,2,',','.')?></b></td>
        <td class="res-desp">Total Despesas: &nbsp;<b>R$ <?=number_format($tDesp,2,',','.')?></b></td>
        <td class="<?=$sal>=0?'res-sal':'res-neg'?>">Saldo: &nbsp;<b>R$ <?=number_format($sal,2,',','.')?></b></td>
    </tr>
</table>
<div class="rp-foot">Data do Relatório: <?=date('d/m/Y')?></div>
