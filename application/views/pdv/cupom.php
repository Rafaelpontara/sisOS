<!DOCTYPE html>
<html lang="pt-br">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Cupom #<?= str_pad($venda->idVendas ?? '', 6, '0', STR_PAD_LEFT) ?></title>
<style>
* { margin:0; padding:0; box-sizing:border-box; }

body {
    font-family: 'Courier New', Courier, monospace;
    font-size: 12px;
    width: 80mm;
    margin: 0 auto;
    background: #fff;
    color: #111;
}

/* ── Barra de ações (não imprime) ── */
.no-print {
    position: fixed;
    top: 0; left: 0; right: 0;
    background: #1a1d2e;
    padding: 10px 16px;
    display: flex;
    gap: 8px;
    justify-content: center;
    z-index: 99;
    border-bottom: 2px solid #7c3aed;
}
.btn-print {
    padding: 8px 20px;
    background: #7c3aed;
    color: #fff;
    border: none;
    border-radius: 6px;
    cursor: pointer;
    font-size: 13px;
    font-weight: 700;
    display: flex;
    align-items: center;
    gap: 6px;
}
.btn-close {
    padding: 8px 16px;
    background: rgba(255,255,255,0.1);
    color: #ccc;
    border: 1px solid rgba(255,255,255,0.15);
    border-radius: 6px;
    cursor: pointer;
    font-size: 13px;
}

/* ── Cupom ── */
.cupom {
    padding: 8mm 4mm;
    margin-top: 52px;
}

/* Cabeçalho */
.cab {
    text-align: center;
    padding-bottom: 6px;
    border-bottom: 2px solid #111;
    margin-bottom: 6px;
}
.cab .nome {
    font-size: 15px;
    font-weight: 900;
    text-transform: uppercase;
    letter-spacing: 1px;
}
.cab .sub {
    font-size: 10px;
    color: #444;
    margin-top: 2px;
}
.cab .logo {
    max-width: 40mm;
    max-height: 15mm;
    object-fit: contain;
    margin-bottom: 4px;
}

/* Info cupom */
.cupom-info {
    text-align: center;
    border: 1px dashed #999;
    padding: 5px;
    margin: 6px 0;
    border-radius: 3px;
}
.cupom-info .titulo {
    font-size: 13px;
    font-weight: 900;
    letter-spacing: 2px;
}
.cupom-info .num {
    font-size: 11px;
    color: #555;
}

/* Cliente */
.cliente-row {
    font-size: 11px;
    margin: 4px 0;
    padding: 3px 0;
    border-bottom: 1px dashed #ccc;
}

/* Separadores */
.sep  { border-top: 1px dashed #999; margin: 6px 0; }
.sep2 { border-top: 2px solid #111;  margin: 6px 0; }

/* Itens */
.item {
    margin: 4px 0;
    padding: 2px 0;
    border-bottom: 1px dotted #ddd;
}
.item-nome {
    font-weight: 700;
    font-size: 11px;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
    max-width: 70mm;
}
.item-row {
    display: flex;
    justify-content: space-between;
    font-size: 11px;
    color: #444;
}
.item-row .val {
    font-weight: 700;
    color: #111;
}

/* Totais */
.total-row {
    display: flex;
    justify-content: space-between;
    margin: 3px 0;
    font-size: 12px;
}
.total-row.desconto { color: #c00; }
.total-final {
    display: flex;
    justify-content: space-between;
    font-size: 18px;
    font-weight: 900;
    margin: 5px 0;
    letter-spacing: 1px;
}
.pgto-row {
    display: flex;
    justify-content: space-between;
    font-size: 11px;
    margin: 2px 0;
}
.pgto-row .label { color: #555; }

/* Rodapé */
.rodape {
    text-align: center;
    margin-top: 8px;
    font-size: 10px;
    color: #555;
    border-top: 1px dashed #999;
    padding-top: 6px;
}
.rodape .obrigado {
    font-size: 13px;
    font-weight: 900;
    color: #111;
    margin-bottom: 3px;
}
.rodape .volte {
    font-style: italic;
    margin-bottom: 4px;
}
.powered {
    font-size: 9px;
    color: #bbb;
    margin-top: 6px;
}

@media print {
    .no-print { display: none !important; }
    .cupom { margin-top: 0; }
    body { width: 80mm; }
    @page { margin: 0; size: 80mm auto; }
}
</style>
</head>
<body>

<!-- Barra de ações -->
<div class="no-print">
    <button class="btn-print" onclick="window.print()">🖨️ Imprimir</button>
    <button class="btn-close" onclick="window.close()">✕ Fechar</button>
</div>

<div class="cupom">

    <!-- Cabeçalho -->
    <div class="cab">
        <?php if (!empty($emitente)): ?>
            <?php if (!empty($emitente->url_logo)): ?>
            <img class="logo" src="<?= $emitente->url_logo ?>" alt="Logo">
            <?php endif; ?>
            <div class="nome"><?= htmlspecialchars($emitente->nome) ?></div>
            <?php if (!empty($emitente->cnpj)): ?>
            <div class="sub">CNPJ: <?= htmlspecialchars($emitente->cnpj) ?></div>
            <?php endif; ?>
            <?php
            $end = trim(implode(', ', array_filter([
                $emitente->rua   ?? '',
                $emitente->numero ?? '',
                $emitente->bairro ?? '',
            ])));
            $loc = trim(($emitente->cidade ?? '') . (!empty($emitente->uf) ? ' - '.$emitente->uf : ''));
            ?>
            <?php if ($end): ?><div class="sub"><?= htmlspecialchars($end) ?></div><?php endif; ?>
            <?php if ($loc): ?><div class="sub"><?= htmlspecialchars($loc) ?></div><?php endif; ?>
            <?php if (!empty($emitente->telefone)): ?>
            <div class="sub">Tel: <?= htmlspecialchars($emitente->telefone) ?></div>
            <?php endif; ?>
            <?php if (!empty($emitente->email)): ?>
            <div class="sub"><?= htmlspecialchars($emitente->email) ?></div>
            <?php endif; ?>
        <?php else: ?>
            <div class="nome">SISOS</div>
        <?php endif; ?>
    </div>

    <!-- Info do cupom -->
    <div class="cupom-info">
        <div class="titulo">CUPOM NÃO FISCAL</div>
        <div class="num">
            Nº <?= str_pad($venda->idVendas ?? '', 6, '0', STR_PAD_LEFT) ?>
            &nbsp;|&nbsp;
            <?= date('d/m/Y H:i') ?>
        </div>
    </div>

    <!-- Cliente -->
    <?php if (!empty($venda->nomeCliente) && $venda->nomeCliente !== 'Consumidor Final'): ?>
    <div class="cliente-row">
        <strong>Cliente:</strong> <?= htmlspecialchars($venda->nomeCliente) ?>
    </div>
    <?php endif; ?>

    <!-- Itens -->
    <div class="sep"></div>
    <div style="font-size:10px;font-weight:700;color:#555;letter-spacing:1px;margin-bottom:4px;">ITENS</div>

    <?php
    $subtotal = 0;
    foreach ($itens as $i => $item):
        $subtotal += $item->subTotal;
    ?>
    <div class="item">
        <div class="item-nome"><?= ($i+1) ?>. <?= htmlspecialchars($item->descricao ?? 'Produto') ?></div>
        <?php if (!empty($item->codDeBarra)): ?>
        <div style="font-size:10px;color:#777;">Cód: <?= htmlspecialchars($item->codDeBarra) ?></div>
        <?php endif; ?>
        <div class="item-row">
            <span><?= number_format($item->quantidade, 0) ?> un × R$ <?= number_format($item->preco, 2, ',', '.') ?></span>
            <span class="val">R$ <?= number_format($item->subTotal, 2, ',', '.') ?></span>
        </div>
    </div>
    <?php endforeach; ?>

    <!-- Totais -->
    <div class="sep2"></div>

    <div class="total-row">
        <span>Subtotal</span>
        <span>R$ <?= number_format($subtotal, 2, ',', '.') ?></span>
    </div>

    <?php
    $total = $venda->valorTotal ?? $subtotal;
    $descVal = $subtotal - $total;
    if ($venda->valor_desconto > 0) {
        $total = $venda->valor_desconto;
        $descVal = $subtotal - $total;
    }
    ?>

    <?php if ($descVal > 0): ?>
    <div class="total-row desconto">
        <span>Desconto</span>
        <span>- R$ <?= number_format($descVal, 2, ',', '.') ?></span>
    </div>
    <?php endif; ?>

    <div class="sep2"></div>
    <div class="total-final">
        <span>TOTAL</span>
        <span>R$ <?= number_format($total, 2, ',', '.') ?></span>
    </div>
    <div class="sep2"></div>

    <!-- Pagamento -->
    <?php
    $fpgto = $forma_pgto ?? ($venda->forma_pgto ?? null);
    ?>
    <?php if (!empty($fpgto) && $fpgto !== '—'): ?>
    <div class="pgto-row">
        <span class="label">Forma de pagamento</span>
        <span><strong><?= htmlspecialchars($fpgto) ?></strong></span>
    </div>
    <?php endif; ?>
    <?php if (!empty($valor_recebido) && $valor_recebido > 0): ?>
    <div class="pgto-row">
        <span class="label">Valor recebido</span>
        <span>R$ <?= number_format($valor_recebido, 2, ',', '.') ?></span>
    </div>
    <?php
    $troco = $valor_recebido - $total;
    if ($troco > 0):
    ?>
    <div class="pgto-row" style="color:#007700;font-weight:700;">
        <span>Troco</span>
        <span>R$ <?= number_format($troco, 2, ',', '.') ?></span>
    </div>
    <?php endif; ?>
    <?php endif; ?>

    <!-- Rodapé -->
    <div class="rodape">
        <div class="obrigado">✦ Obrigado pela preferência! ✦</div>
        <div class="volte">Volte sempre!</div>
        <div><?= date('d/m/Y \à\s H:i:s') ?></div>
        <div class="powered">SISOS — Sistema de Gestão</div>
    </div>

</div>

<script>
if (window.opener) {
    window.onload = function(){ 
        setTimeout(function(){ window.print(); }, 400);
    };
}
</script>
</body>
</html>
