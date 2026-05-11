<?= $topo ?>
<table class="rp-tbl">
    <thead><tr>
        <th class="c" style="width:44px;">OS</th>
        <th>Cliente</th>
        <th class="c">Status</th>
        <th class="c">Data</th>
        <th>Descrição</th>
        <th class="r">Produtos</th>
        <th class="r">Serviços</th>
        <th class="r">Total</th>
        <th class="r">Desconto</th>
        <th class="r">C/Desc.</th>
    </tr></thead>
    <tbody>
    <?php foreach($os as $i=>$c):
        $sc=['Finalizado'=>'b-g','Faturado'=>'b-g','Cancelado'=>'b-r','Orçamento'=>'b-a','Aberto'=>'b-b'];
        $cl=$sc[$c->status]??'b-gr';
        $tot=$c->total_produto+$c->total_servico;
        $tDesc=$c->valor_desconto!=0?$c->valor_desconto:$tot;
        $desc=$c->desconto!=0?($c->tipo_desconto=='real'?'R$ '.number_format($c->desconto,2,',','.'):number_format($c->desconto,2).'%'):'—';
    ?>
    <tr class="<?=$i%2==0?'impar':'par'?>">
        <td class="c">#<?=str_pad($c->idOs,4,'0',STR_PAD_LEFT)?></td>
        <td><?=htmlspecialchars($c->nomeCliente)?></td>
        <td class="c"><span class="b <?=$cl?>"><?=htmlspecialchars($c->status)?></span></td>
        <td class="c"><?=date('d/m/Y',strtotime($c->dataInicial))?></td>
        <td style="font-size:9.5px;"><?=htmlspecialchars(mb_substr(strip_tags($c->descricaoProduto??''),0,45))?></td>
        <td class="r">R$ <?=number_format($c->total_produto,2,',','.')?></td>
        <td class="r">R$ <?=number_format($c->total_servico,2,',','.')?></td>
        <td class="r">R$ <?=number_format($tot,2,',','.')?></td>
        <td class="r"><?=$desc?></td>
        <td class="r"><b>R$ <?=number_format($tDesc,2,',','.')?></b></td>
    </tr>
    <?php endforeach; ?>
    <tr class="tot">
        <td colspan="5" style="text-align:right;">TOTAIS (<?=count($os)?> OS)</td>
        <td class="r">R$ <?=number_format($total_produtos,2,',','.')?></td>
        <td class="r">R$ <?=number_format($total_servicos,2,',','.')?></td>
        <td class="r">R$ <?=number_format($total_produtos+$total_servicos,2,',','.')?></td>
        <td></td>
        <td class="r">R$ <?=number_format($total_geral,2,',','.')?></td>
    </tr>
    </tbody>
</table>
<div class="rp-foot">Data do Relatório: <?=date('d/m/Y')?></div>
