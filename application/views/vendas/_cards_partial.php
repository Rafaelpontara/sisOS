<?php if (!$results): ?>
    <?php if (empty($semResultadosOculto)): ?>
    <div class="vd-empty">
        <i class='bx bx-cart-alt'></i>
        Nenhuma venda cadastrada
    </div>
    <?php endif; ?>
<?php else: foreach ($results as $r):
    $spMap = ['Aberto'=>'sp-ab','Orçamento'=>'sp-or','Finalizado'=>'sp-fi','Faturado'=>'sp-fi','Cancelado'=>'sp-ca'];
    $spC = $spMap[$r->status] ?? 'sp-ot';

    $subtotalBruto = floatval($r->totalProdutos ?? $r->valorTotal ?? 0);
    $descontoValor = floatval($r->desconto ?? 0);
    $totalComDesc  = floatval($r->valor_desconto ?? 0);
    if ($totalComDesc <= 0) $totalComDesc = $subtotalBruto - $descontoValor;
    if ($totalComDesc <= 0) $totalComDesc = $subtotalBruto;
?>
<div class="vd-card" data-search="<?= htmlspecialchars(mb_strtolower($r->idVendas . ' ' . ($r->nomeCliente ?? '') . ' ' . $r->status)) ?>">
    <div class="vd-card-top">
        <span class="vd-num">#<?= $r->idVendas ?></span>
        <span class="sp <?= $spC ?>"><?= htmlspecialchars($r->status) ?></span>
    </div>

    <div class="vd-cliente"><?= htmlspecialchars($r->nomeCliente ?? '-') ?></div>
    <div class="vd-vendedor"><i class='bx bx-user'></i> <?= htmlspecialchars($r->nomeVendedor ?? '-') ?></div>

    <?php if (!empty($r->produtos)): ?>
    <div class="vd-produtos"><?= htmlspecialchars(mb_substr($r->produtos, 0, 60)) ?></div>
    <?php endif; ?>

    <div class="vd-row">
        <div><span class="vd-row-label">Data</span><span class="vd-row-val"><?= $r->dataVenda ? date('d/m/Y', strtotime($r->dataVenda)) : '-' ?></span></div>
        <div style="text-align:right;"><span class="vd-row-label">Venc. Garantia</span><span class="vd-row-val"><?= $r->vencGarantia ?? '-' ?></span></div>
    </div>

    <div class="vd-financeiro">
        <div>
            <span class="vd-total">R$ <?= number_format($totalComDesc, 2, ',', '.') ?></span>
            <?php if ($descontoValor > 0): ?>
            <span class="vd-desconto">- R$ <?= number_format($descontoValor, 2, ',', '.') ?> desc.</span>
            <?php endif; ?>
        </div>
        <?php if (!empty($r->faturado)): ?>
        <span class="sp sp-fi">Faturado</span>
        <?php endif; ?>
    </div>

    <div class="vd-card-footer">
        <?php if (!empty($permissao_vVenda)): ?>
        <a href="<?= base_url() ?>index.php/vendas/visualizar/<?= $r->idVendas ?>" class="act-btn ab-v" title="Ver"><i class="bx bx-show"></i></a>
        <?php endif; ?>
        <?php if (!empty($permissao_eVenda)): ?>
        <a href="<?= base_url() ?>index.php/vendas/editar/<?= $r->idVendas ?>" class="act-btn ab-e" title="Editar"><i class="bx bx-edit"></i></a>
        <?php endif; ?>
        <?php if (!empty($permissao_eVenda) && $r->status !== 'Cancelado'): ?>
        <a href="#modal-cancelar" role="button" data-toggle="modal" venda="<?= $r->idVendas ?>" class="act-btn ab-c" title="Cancelar Venda"><i class="bx bx-x-circle"></i></a>
        <?php endif; ?>
        <?php if (!empty($permissao_dVenda)): ?>
        <a href="#modal-excluir" role="button" data-toggle="modal" venda="<?= $r->idVendas ?>" class="act-btn ab-d" title="Excluir" style="margin-left:auto;"><i class="bx bx-trash-alt"></i></a>
        <?php endif; ?>
    </div>
</div>
<?php endforeach; endif; ?>
