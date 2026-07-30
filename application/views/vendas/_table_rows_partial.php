<?php if (!isset($results) || !$results): ?>
    <?php if (empty($semResultadosOculto)): ?>
    <tr><td colspan="12" style="text-align:center;padding:40px;color:#6b7280;">Nenhuma venda cadastrada</td></tr>
    <?php endif; ?>
<?php else:
foreach ($results as $r):
    $spMap = ['Aberto'=>'sp-ab','Orçamento'=>'sp-or','Finalizado'=>'sp-fi','Faturado'=>'sp-fi','Cancelado'=>'sp-ca'];
    $spC = $spMap[$r->status] ?? 'sp-ot';

    // totalProdutos = subtotal bruto (sem desconto)
    // desconto = valor descontado em R$
    // valor_desconto = total final pago pelo cliente
    $subtotalBruto  = floatval($r->totalProdutos ?? $r->valorTotal ?? 0);
    $descontoValor  = floatval($r->desconto ?? 0);
    $totalComDesc   = floatval($r->valor_desconto ?? 0);
    if ($totalComDesc <= 0) $totalComDesc = $subtotalBruto - $descontoValor;
    if ($totalComDesc <= 0) $totalComDesc = $subtotalBruto;
?>
<tr data-id="<?= $r->idVendas ?>">
    <td style="color:#6b7280;font-size:12px;"><?= $r->idVendas ?></td>
    <td style="font-weight:600;color:#e8eaf0;"><?= htmlspecialchars($r->nomeCliente ?? '-') ?></td>
    <td style="color:#9ca3af;font-size:12px;"><?= htmlspecialchars($r->nomeVendedor ?? '-') ?></td>
    <td style="font-size:12px;color:#9ca3af;"><?= htmlspecialchars(mb_substr($r->produtos ?? '-', 0, 30)) ?></td>
    <td style="font-size:12px;"><?= $r->dataVenda ? date('d/m/Y', strtotime($r->dataVenda)) : '-' ?></td>
    <td style="font-size:12px;"><?= $r->vencGarantia ?? '-' ?></td>
    <td style="font-weight:600;">R$ <?= number_format($subtotalBruto, 2, ',', '.') ?></td>
    <td style="color:#f87171;"><?= $descontoValor > 0 ? '- R$ ' . number_format($descontoValor, 2, ',', '.') : '-' ?></td>
    <td style="font-weight:600;color:#e8eaf0;">R$ <?= number_format($totalComDesc, 2, ',', '.') ?></td>
    <td style="color:#4ade80;">R$ <?= number_format($r->faturado ? $totalComDesc : 0, 2, ',', '.') ?></td>
    <td><span class="sp <?= $spC ?>"><?= htmlspecialchars($r->status) ?></span></td>
    <td>
        <div class="act-btns">
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
            <a href="#modal-excluir" role="button" data-toggle="modal" venda="<?= $r->idVendas ?>" class="act-btn ab-d" title="Excluir"><i class="bx bx-trash-alt"></i></a>
            <?php endif; ?>
        </div>
    </td>
</tr>
<?php endforeach; endif; ?>
