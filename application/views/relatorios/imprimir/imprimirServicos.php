<?= $topo ?>
<table class="rp-tbl">
    <thead><tr>
        <th>Nome do Serviço</th>
        <th>Descrição</th>
        <th class="r">Preço</th>
    </tr></thead>
    <tbody>
    <?php foreach($servicos as $i=>$s): ?>
    <tr class="<?=$i%2==0?'impar':'par'?>">
        <td><b><?=htmlspecialchars($s->nome)?></b></td>
        <td><?=htmlspecialchars($s->descricao??'')?></td>
        <td class="r">R$ <?=number_format($s->preco,2,',','.')?></td>
    </tr>
    <?php endforeach; ?>
    <tr class="tot"><td colspan="3">Total: <?=count($servicos)?> serviço(s)</td></tr>
    </tbody>
</table>
<div class="rp-foot">Data do Relatório: <?=date('d/m/Y')?></div>
