<!DOCTYPE html>
<html lang="pt-br">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Etiqueta OS #<?= str_pad($os->idOs, 4, '0', STR_PAD_LEFT) ?></title>
<style>
* { box-sizing:border-box; margin:0; padding:0; }
body { font-family:Arial, sans-serif; background:#f1f1f1; padding:20px; }

.toolbar { max-width:400px; margin:0 auto 16px; display:flex; gap:10px; justify-content:center; }
.toolbar button {
    padding:10px 20px; border-radius:8px; border:none; cursor:pointer;
    font-size:14px; font-weight:700; background:#7c3aed; color:#fff;
}
.toolbar button:hover { background:#6d28d9; }

/* Etiqueta — tamanho pensado pra impressora térmica comum (58mm/80mm) ou
   uma etiqueta adesiva pequena impressa numa impressora normal */
.etiqueta {
    width:280px; margin:0 auto; background:#fff; border:1.5px dashed #999;
    border-radius:8px; padding:14px; text-align:center;
}
.etiqueta .os-num { font-size:13px; font-weight:800; color:#111; letter-spacing:.5px; }
.etiqueta .qr { margin:10px 0; }
.etiqueta .qr img { width:150px; height:150px; }
.etiqueta .info { font-size:10.5px; color:#444; line-height:1.4; margin-top:4px; }
.etiqueta .aviso { font-size:9px; color:#777; margin-top:8px; border-top:1px dashed #ccc; padding-top:6px; }

@media print {
    body { background:#fff; padding:0; }
    .toolbar { display:none; }
    .etiqueta { border:1px solid #000; }
}
</style>
</head>
<body>

<div class="toolbar">
    <button onclick="window.print()">🖨️ Imprimir Etiqueta</button>
</div>

<div class="etiqueta">
    <div class="os-num">OS #<?= str_pad($os->idOs, 4, '0', STR_PAD_LEFT) ?></div>
    <div class="qr"><img src="<?= $qrUrl ?>" alt="QR Code"></div>
    <?php $descProdLimpa = trim(strip_tags($os->descricaoProduto ?? '')); ?>
    <?php if ($descProdLimpa !== ''): ?>
    <div class="info"><?= htmlspecialchars(mb_substr($descProdLimpa, 0, 40)) ?></div>
    <?php endif; ?>
    <div class="aviso">Escaneie para acompanhar o status do reparo</div>
</div>

</body>
</html>
