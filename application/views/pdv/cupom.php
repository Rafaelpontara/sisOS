<!DOCTYPE html>
<html lang="pt-br">
<head>
<meta charset="UTF-8">
<title>Cupom #<?= $venda->idVendas ?? '' ?></title>
<style>
* { margin:0; padding:0; box-sizing:border-box; }
body { font-family:'Courier New', monospace; font-size:12px; width:80mm; margin:0 auto; background:#fff; }
.center { text-align:center; }
.bold { font-weight:bold; }
.sep { border-top:1px dashed #000; margin:6px 0; }
.sep-solid { border-top:1px solid #000; margin:6px 0; }
.row { display:flex; justify-content:space-between; margin:2px 0; }
.row .desc { flex:1; }
.big { font-size:16px; font-weight:bold; }
@media print { .no-print { display:none; } }
</style>
</head>
<body>

<div class="no-print" style="text-align:center;padding:8px;background:#f5f5f5;border-bottom:1px solid #ddd;width:100%;position:fixed;top:0">
    <button onclick="window.print()" style="padding:6px 20px;background:#27ae60;color:#fff;border:none;border-radius:4px;cursor:pointer;font-size:13px">🖨️ Imprimir</button>
    <button onclick="window.close()" style="padding:6px 12px;background:#888;color:#fff;border:none;border-radius:4px;cursor:pointer;font-size:13px;margin-left:6px">Fechar</button>
</div>

<div style="padding-top:50px">
    <!-- Cabeçalho -->
    <div class="center">
        <?php if ($emitente): ?>
            <div class="bold" style="font-size:14px"><?= htmlspecialchars($emitente->nome) ?></div>
            <?php if ($emitente->cnpj): ?><div>CNPJ: <?= htmlspecialchars($emitente->cnpj) ?></div><?php endif; ?>
            <?php if ($emitente->logradouro): ?>
                <div><?= htmlspecialchars($emitente->logradouro . ($emitente->numero ? ', '.$emitente->numero : '')) ?></div>
                <div><?= htmlspecialchars(($emitente->cidade ?? '') . ($emitente->uf ? ' - '.$emitente->uf : '')) ?></div>
            <?php endif; ?>
            <?php if ($emitente->telefone): ?><div>Tel: <?= htmlspecialchars($emitente->telefone) ?></div><?php endif; ?>
        <?php else: ?>
            <div class="bold" style="font-size:14px">SISOS</div>
        <?php endif; ?>
    </div>

    <div class="sep-solid"></div>

    <div class="center">
        <div class="bold">CUPOM NÃO FISCAL</div>
        <div>Nº <?= str_pad($venda->idVendas, 6, '0', STR_PAD_LEFT) ?> — <?= date('d/m/Y H:i') ?></div>
        <?php if (!empty($venda->nomeCliente)): ?>
            <div>Cliente: <?= htmlspecialchars($venda->nomeCliente) ?></div>
        <?php endif; ?>
    </div>

    <div class="sep"></div>

    <!-- Itens -->
    <?php foreach ($itens as $i => $item): ?>
    <div style="margin:3px 0">
        <div><?= ($i+1) ?>. <?= htmlspecialchars($item->descricao) ?></div>
        <div class="row">
            <span><?= number_format($item->quantidade, 0) ?> x R$ <?= number_format($item->preco, 2, ',', '.') ?></span>
            <span class="bold">R$ <?= number_format($item->subTotal, 2, ',', '.') ?></span>
        </div>
    </div>
    <?php endforeach; ?>

    <div class="sep"></div>

    <!-- Totais -->
    <?php
    $subtotal = array_sum(array_column((array)$itens, 'subTotal'));
    $total    = $venda->valor_desconto > 0 ? $venda->valor_desconto : $venda->valorTotal;
    $desconto = $venda->desconto ?? 0;
    ?>
    <div class="row"><span>Subtotal:</span><span>R$ <?= number_format($subtotal, 2, ',', '.') ?></span></div>
    <?php if ($desconto > 0): ?>
    <div class="row"><span>Desconto:</span><span>- R$ <?= number_format($subtotal - $total, 2, ',', '.') ?></span></div>
    <?php endif; ?>

    <div class="sep-solid"></div>
    <div class="row big"><span>TOTAL:</span><span>R$ <?= number_format($total, 2, ',', '.') ?></span></div>
    <div class="sep-solid"></div>

    <div class="row"><span>Forma de pgto:</span><span><?= htmlspecialchars($venda->forma_pgto ?? '—') ?></span></div>

    <div class="sep"></div>

    <div class="center" style="font-size:10px">
        <div>Obrigado pela preferência!</div>
        <div style="margin-top:4px"><?= date('d/m/Y \à\s H:i:s') ?></div>
    </div>
</div>

<script>
// Auto-print se aberto pelo PDV
if (window.opener) {
    window.onload = function(){ window.print(); };
}
</script>
</body>
</html>
