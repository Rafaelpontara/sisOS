<?php
// Verifica acesso direto
defined('BASEPATH') or exit('No direct script access allowed');
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Garantia Digital — OS #<?= str_pad($os->idOs, 4, '0', STR_PAD_LEFT) ?></title>
    <link href='https://unpkg.com/boxicons@2.1.1/css/boxicons.min.css' rel='stylesheet'>
    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
        body { font-family: 'Segoe UI', Arial, sans-serif; background: #0f1117; min-height: 100vh; display: flex; flex-direction: column; align-items: center; justify-content: center; padding: 24px 16px; color: #e8eaf0; }
        .gd-wrap { width: 100%; max-width: 560px; }
        .gd-header { background: #1a1d2e; border: 1px solid rgba(255,255,255,0.08); border-radius: 18px 18px 0 0; padding: 24px; text-align: center; border-bottom: 2px solid #22c55e; }
        .gd-header img { max-height: 60px; max-width: 200px; object-fit: contain; margin-bottom: 10px; }
        .gd-header h1 { font-size: 18px; font-weight: 800; color: #e8eaf0; }
        .gd-header p { font-size: 12px; color: #9ca3af; margin-top: 2px; }
        .gd-badge { background: linear-gradient(135deg, #16a34a, #22c55e); padding: 16px 24px; text-align: center; }
        .gd-badge-title { font-size: 11px; font-weight: 700; letter-spacing: 2px; text-transform: uppercase; color: rgba(255,255,255,0.8); margin-bottom: 4px; }
        .gd-badge-num { font-size: 28px; font-weight: 900; color: #fff; letter-spacing: 2px; }
        .gd-body { background: #1a1d2e; border: 1px solid rgba(255,255,255,0.08); border-top: none; padding: 24px; }
        .gd-info-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 12px; margin-bottom: 20px; }
        @media(max-width:480px) { .gd-info-grid { grid-template-columns: 1fr; } }
        .gd-info { background: #252a3a; border-radius: 10px; padding: 12px 14px; border: 1px solid rgba(255,255,255,0.06); }
        .gd-info-label { font-size: 10px; font-weight: 700; color: #6b7280; text-transform: uppercase; letter-spacing: .6px; margin-bottom: 4px; }
        .gd-info-val { font-size: 14px; font-weight: 700; color: #e8eaf0; }
        .gd-info-val.green { color: #22c55e; }
        .gd-validade { background: rgba(34,197,94,0.1); border: 1px solid rgba(34,197,94,0.3); border-radius: 12px; padding: 16px; text-align: center; margin-bottom: 20px; }
        .gd-validade-label { font-size: 11px; font-weight: 700; color: #4ade80; text-transform: uppercase; letter-spacing: 1px; margin-bottom: 6px; }
        .gd-validade-data { font-size: 22px; font-weight: 800; color: #22c55e; }
        .gd-validade-sub { font-size: 12px; color: #6b7280; margin-top: 4px; }
        .gd-section-title { font-size: 10px; font-weight: 700; color: #6b7280; text-transform: uppercase; letter-spacing: 1px; margin-bottom: 8px; display: flex; align-items: center; gap: 6px; }
        .gd-item { display: flex; justify-content: space-between; align-items: center; padding: 8px 12px; background: #252a3a; border-radius: 8px; margin-bottom: 6px; font-size: 13px; }
        .gd-item-nome { color: #e8eaf0; font-weight: 600; }
        .gd-item-qtd { color: #9ca3af; font-size: 12px; }
        .gd-qr { text-align: center; margin: 20px 0; padding: 20px; background: #252a3a; border-radius: 14px; border: 1px solid rgba(255,255,255,0.06); }
        .gd-qr img { width: 160px; height: 160px; border-radius: 8px; background: #fff; padding: 8px; }
        .gd-qr-label { font-size: 11px; color: #9ca3af; margin-top: 10px; }
        .gd-qr-link { font-size: 11px; color: #6366f1; word-break: break-all; margin-top: 4px; }
        .gd-obs { background: rgba(251,191,36,0.08); border: 1px solid rgba(251,191,36,0.2); border-radius: 10px; padding: 12px 16px; font-size: 13px; color: #fbbf24; margin-bottom: 20px; display: flex; gap: 9px; }
        .gd-footer { background: #252a3a; border: 1px solid rgba(255,255,255,0.08); border-top: none; border-radius: 0 0 18px 18px; padding: 16px 24px; text-align: center; font-size: 11px; color: #6b7280; }
        .gd-print-btn { display: inline-flex; align-items: center; gap: 6px; padding: 10px 20px; background: linear-gradient(135deg, #22c55e, #16a34a); color: #fff; border: none; border-radius: 10px; font-size: 13px; font-weight: 700; cursor: pointer; margin-bottom: 16px; text-decoration: none; }
        @media print {
            .gd-no-print { display: none !important; }
            body { background: #fff; padding: 0; }
            .gd-header, .gd-body, .gd-footer { border-color: #ddd !important; }
            .gd-badge { background: #16a34a; }
            .gd-info, .gd-qr, .gd-item { background: #f5f5f5 !important; }
            .gd-info-val, .gd-item-nome { color: #111 !important; }
            .gd-info-label, .gd-item-qtd, .gd-qr-label { color: #555 !important; }
            .gd-header h1, .gd-header p { color: #111 !important; }
            .gd-validade { background: #f0fdf4 !important; border-color: #22c55e !important; }
        }
    </style>
</head>
<body>
<div class="gd-wrap">

    <div class="gd-no-print" style="text-align:center;margin-bottom:14px;">
        <button onclick="window.print()" class="gd-print-btn"><i class='bx bx-printer'></i> Imprimir / Salvar PDF</button>
        <a href="<?= site_url('os/visualizar/' . $os->idOs) ?>" class="gd-print-btn" style="background:rgba(255,255,255,0.1);color:#9ca3af;margin-left:8px;"><i class='bx bx-arrow-back'></i> Voltar</a>
    </div>

    <div class="gd-header">
        <?php if (!empty($emitente->url_logo)): ?>
        <img src="<?= strpos($emitente->url_logo, 'http') === 0 ? $emitente->url_logo : base_url($emitente->url_logo) ?>" alt="Logo"><br>
        <?php endif; ?>
        <h1><?= strip_tags($emitente->nome ?? 'Assistência Técnica') ?></h1>
        <p>
            <?php if (!empty($emitente->cnpj)): ?>CNPJ: <?= strip_tags($emitente->cnpj) ?> &nbsp;|&nbsp;<?php endif; ?>
            <?php if (!empty($emitente->telefone)): ?><?= strip_tags($emitente->telefone) ?><?php endif; ?>
        </p>
    </div>

    <div class="gd-badge">
        <div class="gd-badge-title"><i class='bx bx-shield-check'></i> Certificado de Garantia</div>
        <div class="gd-badge-num">OS #<?= str_pad($os->idOs, 4, '0', STR_PAD_LEFT) ?></div>
    </div>

    <div class="gd-body">

        <div class="gd-info-grid">
            <div class="gd-info">
                <div class="gd-info-label">Cliente</div>
                <div class="gd-info-val"><?= strip_tags($os->nomeCliente ?? '-') ?></div>
            </div>
            <div class="gd-info">
                <div class="gd-info-label">Equipamento</div>
                <div class="gd-info-val"><?= strip_tags($os->equipamento ?? $os->descricaoProduto ?? '-') ?></div>
            </div>
            <div class="gd-info">
                <div class="gd-info-label">Data de Saída</div>
                <div class="gd-info-val"><?= !empty($os->dataFinal) ? date('d/m/Y', strtotime($os->dataFinal)) : date('d/m/Y') ?></div>
            </div>
            <div class="gd-info">
                <div class="gd-info-label">Prazo de Garantia</div>
                <div class="gd-info-val green"><?= (int)$os->garantia ?> dia(s)</div>
            </div>
        </div>

        <?php
        $dataBase = !empty($os->dataFinal) ? $os->dataFinal : date('Y-m-d');
        $dataVenc = date('d/m/Y', strtotime($dataBase . ' +' . (int)$os->garantia . ' days'));
        $diasRest = (int) ceil((strtotime($dataBase . ' +' . (int)$os->garantia . ' days') - time()) / 86400);
        $vencido  = $diasRest < 0;
        ?>
        <div class="gd-validade" style="<?= $vencido ? 'background:rgba(239,68,68,0.1);border-color:rgba(239,68,68,0.3);' : '' ?>">
            <div class="gd-validade-label" style="<?= $vencido ? 'color:#f87171;' : '' ?>"><?= $vencido ? 'Garantia Vencida' : 'Garantia Valida ate' ?></div>
            <div class="gd-validade-data" style="<?= $vencido ? 'color:#f87171;' : '' ?>"><?= $dataVenc ?></div>
            <div class="gd-validade-sub"><?= $vencido ? 'Venceu ha ' . abs($diasRest) . ' dia(s)' : $diasRest . ' dia(s) restante(s)' ?></div>
        </div>

        <?php if (!empty($servicos)): ?>
        <div style="margin-bottom:16px;">
            <div class="gd-section-title"><i class='bx bx-wrench'></i> Servicos Realizados</div>
            <?php foreach ($servicos as $s): ?>
            <div class="gd-item">
                <span class="gd-item-nome"><?= strip_tags($s->nome ?? $s->descricao ?? '') ?></span>
                <span class="gd-item-qtd"><?= (int)$s->quantidade ?>x</span>
            </div>
            <?php endforeach; ?>
        </div>
        <?php endif; ?>

        <?php if (!empty($produtos)): ?>
        <div style="margin-bottom:16px;">
            <div class="gd-section-title"><i class='bx bx-chip'></i> Pecas Utilizadas</div>
            <?php foreach ($produtos as $p): ?>
            <div class="gd-item">
                <span class="gd-item-nome"><?= strip_tags($p->descricao ?? '') ?></span>
                <span class="gd-item-qtd"><?= (int)$p->quantidade ?>x</span>
            </div>
            <?php endforeach; ?>
        </div>
        <?php endif; ?>

        <?php if (!empty($os->laudoTecnico)): ?>
        <div class="gd-obs">
            <i class='bx bx-info-circle' style="flex-shrink:0;font-size:18px;"></i>
            <span><?= strip_tags($os->laudoTecnico) ?></span>
        </div>
        <?php endif; ?>

        <div class="gd-qr">
            <img src="<?= $qrUrl ?>" alt="QR Code da Garantia">
            <div class="gd-qr-label">Escaneie para verificar a autenticidade desta garantia</div>
            <div class="gd-qr-link"><?= $link ?></div>
        </div>

    </div>

    <div class="gd-footer">
        Documento gerado em <?= date('d/m/Y') ?> as <?= date('H:i') ?> &nbsp;|&nbsp; <?= strip_tags($emitente->nome ?? '') ?><br>
        <span style="color:#4b5563;">Este documento e valido como comprovante de garantia do servico prestado.</span>
    </div>

</div>
</body>
</html>
