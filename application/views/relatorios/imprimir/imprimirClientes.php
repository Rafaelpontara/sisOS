<?= $topo ?>
<table class="rp-tbl">
    <thead><tr>
        <th>Nome</th>
        <th class="c">CPF / CNPJ</th>
        <th class="c">Telefone</th>
        <th>E-mail</th>
        <th class="c">Cadastro</th>
    </tr></thead>
    <tbody>
    <?php foreach($clientes as $i=>$c): ?>
    <tr class="<?=$i%2==0?'impar':'par'?>">
        <td><?=htmlspecialchars($c->nomeCliente)?></td>
        <td class="c"><?=htmlspecialchars($c->documento??'')?></td>
        <td class="c"><?=htmlspecialchars($c->telefone??($c->celular??''))?></td>
        <td><?=htmlspecialchars($c->email??'')?></td>
        <td class="c"><?=date('d/m/Y',strtotime($c->dataCadastro))?></td>
    </tr>
    <?php endforeach; ?>
    <tr class="tot"><td colspan="5">Total: <?=count($clientes)?> cliente(s)</td></tr>
    </tbody>
</table>
<div class="rp-foot">Data do Relatório: <?=date('d/m/Y')?></div>
