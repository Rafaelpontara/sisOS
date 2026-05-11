<?php
$totalServico = 0;
$totalProdutos = 0;
function mcSB4($s){$m=['Aberto'=>'mb-blue','Em Andamento'=>'mb-indigo','Orçamento'=>'mb-amber','Finalizado'=>'mb-green','Faturado'=>'mb-green','Cancelado'=>'mb-red','Aguardando Peças'=>'mb-amber','Aprovado'=>'mb-purple'];$c=$m[$s]??'mb-gray';return '<span class="mc-badge '.$c.'">'.htmlspecialchars($s).'</span>';}
?>

<!-- Header -->
<div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:20px;flex-wrap:wrap;gap:10px;">
    <div style="display:flex;align-items:center;gap:10px;">
        <a href="<?= base_url() ?>index.php/mine/os" class="mc-btn mc-btn-ghost" style="padding:7px 12px;"><i class='bx bx-arrow-back'></i></a>
        <div>
            <h2 style="font-size:18px;font-weight:800;color:#e8eaf0;margin:0;">
                OS <span style="color:#fbbf24;">#<?= str_pad($result->idOs,4,'0',STR_PAD_LEFT) ?></span>
            </h2>
            <span style="font-size:12px;color:#9ca3af;">Aberta em <?= date('d/m/Y',strtotime($result->dataInicial)) ?></span>
        </div>
    </div>
    <div style="display:flex;align-items:center;gap:8px;flex-wrap:wrap;">
        <?= mcSB4($result->status) ?>
        <a href="<?= site_url('mine/imprimirOs/'.$result->idOs) ?>" target="_blank" class="mc-btn mc-btn-ghost" style="padding:7px 14px;font-size:12px;">
            <i class='bx bx-printer'></i> Imprimir
        </a>
        <?php if ($result->status=='Orçamento'): ?>
        <a href="<?= site_url('os/aprovar/'.$result->idOs.'?acao=sim') ?>" class="mc-btn mc-btn-success" style="padding:7px 14px;font-size:12px;">
            <i class='bx bx-check'></i> Aprovar
        </a>
        <a href="<?= site_url('os/aprovar/'.$result->idOs.'?acao=nao') ?>" class="mc-btn mc-btn-danger" style="padding:7px 14px;font-size:12px;">
            <i class='bx bx-x'></i> Recusar
        </a>
        <?php endif; ?>
    </div>
</div>

<!-- Emitente -->
<?php if ($emitente): ?>
<div class="mc-card mc-detail-section">
    <div class="mc-card-head"><div class="mc-card-head-left"><i class='bx bx-building' style="color:#60a5fa;"></i><span>Assistência Técnica</span></div></div>
    <div class="mc-card-body" style="display:flex;align-items:center;gap:16px;flex-wrap:wrap;">
        <?php if ($emitente->url_logo): ?>
        <img src="<?= $emitente->url_logo ?>" style="max-height:52px;max-width:140px;object-fit:contain;" alt="Logo">
        <?php endif; ?>
        <div>
            <div style="font-size:15px;font-weight:700;color:#e8eaf0;"><?= htmlspecialchars($emitente->nome) ?></div>
            <?php if ($emitente->cnpj!='00.000.000/0000-00'): ?><div style="font-size:12px;color:#9ca3af;">CNPJ: <?= htmlspecialchars($emitente->cnpj) ?></div><?php endif; ?>
            <div style="font-size:12px;color:#9ca3af;"><?= htmlspecialchars($emitente->rua.', '.$emitente->numero.' — '.$emitente->cidade.'/'.$emitente->uf) ?></div>
            <div style="font-size:12px;color:#9ca3af;"><?= htmlspecialchars($emitente->email.' | '.$emitente->telefone) ?></div>
        </div>
        <div style="margin-left:auto;text-align:right;">
            <div style="font-size:11px;color:#6b7280;margin-bottom:3px;">Responsável</div>
            <div style="font-size:13px;font-weight:600;color:#e8eaf0;"><?= htmlspecialchars($result->nome??'—') ?></div>
        </div>
    </div>
</div>
<?php endif; ?>

<!-- Status & Datas -->
<div class="mc-card mc-detail-section">
    <div class="mc-card-head"><div class="mc-card-head-left"><i class='bx bx-calendar' style="color:#fbbf24;"></i><span>Status & Datas</span></div></div>
    <div class="mc-card-body">
        <div class="mc-grid-2">
            <div class="mc-info-row"><span class="mc-info-lbl">Status</span><div><?= mcSB4($result->status) ?></div></div>
            <div class="mc-info-row"><span class="mc-info-lbl">Data de Abertura</span><span class="mc-info-val"><?= date('d/m/Y',strtotime($result->dataInicial)) ?></span></div>
            <?php if (!empty($result->dataFinal)&&$result->dataFinal!='0000-00-00'): ?>
            <div class="mc-info-row"><span class="mc-info-lbl">Data Final / Prazo</span><span class="mc-info-val"><?= date('d/m/Y',strtotime($result->dataFinal)) ?></span></div>
            <?php endif; ?>
            <?php if ($result->garantia): ?>
            <div class="mc-info-row">
                <span class="mc-info-lbl">Garantia</span>
                <span class="mc-info-val"><?= $result->garantia ?> dia(s)
                <?php if (in_array($result->status,['Finalizado','Faturado'])&&!empty($result->dataFinal)&&$result->dataFinal!='0000-00-00'):
                    $venc=dateInterval($result->dataFinal,$result->garantia);
                    $parts=explode('/',$venc);
                    if(count($parts)==3){$ts=strtotime($parts[2].'-'.$parts[1].'-'.$parts[0]);$ok=$ts>=strtotime('today');}else{$ok=false;}
                ?>
                — <span class="mc-badge <?= $ok?'mb-green':'mb-red' ?>"><?= $ok?'válida até '.$venc:'vencida em '.$venc ?></span>
                <?php endif; ?>
                </span>
            </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<!-- Equipamento / Descrição / Defeito / Observações -->
<?php if ($result->descricaoProduto||$result->defeito||$result->observacoes||$result->equipamento): ?>
<div class="mc-card mc-detail-section">
    <div class="mc-card-head"><div class="mc-card-head-left"><i class='bx bx-devices' style="color:#a78bfa;"></i><span>Detalhes do Equipamento</span></div></div>
    <div class="mc-card-body">
        <?php if (!empty($result->equipamento)): ?>
        <div class="mc-info-row" style="margin-bottom:14px;"><span class="mc-info-lbl">Equipamento</span><span class="mc-info-val" style="font-weight:700;"><?= htmlspecialchars($result->equipamento) ?></span></div>
        <?php endif; ?>
        <?php if ($result->descricaoProduto): ?>
        <div style="margin-bottom:14px;"><div class="mc-info-lbl" style="margin-bottom:5px;">Descrição</div><div class="mc-text-box"><?= printSafeHtml($result->descricaoProduto) ?></div></div>
        <?php endif; ?>
        <?php if ($result->defeito): ?>
        <div style="margin-bottom:14px;"><div class="mc-info-lbl" style="color:#f87171;margin-bottom:5px;">Defeito Apresentado</div><div class="mc-text-box"><?= printSafeHtml($result->defeito) ?></div></div>
        <?php endif; ?>
        <?php if ($result->observacoes): ?>
        <div><div class="mc-info-lbl" style="margin-bottom:5px;">Observações</div><div class="mc-text-box"><?= printSafeHtml($result->observacoes) ?></div></div>
        <?php endif; ?>
    </div>
</div>
<?php endif; ?>

<!-- Laudo técnico (só se finalizado) -->
<?php if (!empty($result->laudoTecnico)&&in_array($result->status,['Finalizado','Faturado'])): ?>
<div class="mc-card mc-detail-section">
    <div class="mc-card-head"><div class="mc-card-head-left"><i class='bx bx-search-alt' style="color:#a78bfa;"></i><span>Laudo Técnico</span></div></div>
    <div class="mc-card-body"><div class="mc-text-box"><?= printSafeHtml($result->laudoTecnico) ?></div></div>
</div>
<?php endif; ?>

<!-- Produtos e Serviços -->
<?php if (!empty($servicos)||!empty($produtos)): ?>
<div class="mc-card mc-detail-section">
    <div class="mc-card-head"><div class="mc-card-head-left"><i class='bx bx-receipt' style="color:#fbbf24;"></i><span>Peças e Serviços</span></div></div>
    <div style="overflow-x:auto;">
        <table class="mc-tbl">
            <thead><tr><th>Descrição</th><th>Tipo</th><th style="width:60px;text-align:center;">Qtd</th><th style="width:110px;">Unit.</th><th style="width:120px;text-align:right;">Subtotal</th></tr></thead>
            <tbody>
            <?php foreach ($servicos as $s):
                $pr=$s->preco?:$s->precoVenda; $qt=$s->quantidade?:1; $sub=$pr*$qt; $totalServico+=$sub;
            ?>
            <tr>
                <td style="font-weight:600;color:#e8eaf0;"><?= htmlspecialchars($s->nome??'—') ?></td>
                <td><span class="mc-badge mb-green" style="font-size:10px;">Serviço</span></td>
                <td style="text-align:center;"><?= $qt ?></td>
                <td>R$ <?= number_format($pr,2,',','.') ?></td>
                <td style="text-align:right;font-weight:600;">R$ <?= number_format($sub,2,',','.') ?></td>
            </tr>
            <?php endforeach; ?>
            <?php foreach ($produtos as $p):
                $sub=$p->subTotal; $totalProdutos+=$sub;
            ?>
            <tr>
                <td style="font-weight:600;color:#e8eaf0;"><?= htmlspecialchars($p->descricao??'—') ?></td>
                <td><span class="mc-badge mb-purple" style="font-size:10px;">Peça</span></td>
                <td style="text-align:center;"><?= $p->quantidade ?></td>
                <td>R$ <?= number_format($p->preco?:$p->precoVenda,2,',','.') ?></td>
                <td style="text-align:right;font-weight:600;">R$ <?= number_format($sub,2,',','.') ?></td>
            </tr>
            <?php endforeach; ?>
            </tbody>
            <tfoot>
                <?php $totalGeral=$totalProdutos+$totalServico; if ($result->valor_desconto): ?>
                <tr><td colspan="4" style="text-align:right;color:#9ca3af;padding:9px 14px;">Subtotal:</td><td style="text-align:right;padding:9px 14px;">R$ <?= number_format($totalGeral,2,',','.') ?></td></tr>
                <tr><td colspan="4" style="text-align:right;color:#f87171;padding:9px 14px;">Desconto:</td><td style="text-align:right;color:#f87171;padding:9px 14px;">- R$ <?= number_format($totalGeral-$result->valor_desconto,2,',','.') ?></td></tr>
                <?php endif; ?>
                <tr style="background:rgba(251,191,36,0.05);border-top:2px solid rgba(255,255,255,0.08);">
                    <td colspan="4" style="text-align:right;font-weight:800;font-size:14px;color:#e8eaf0;padding:12px 14px;">TOTAL:</td>
                    <td style="text-align:right;font-weight:800;font-size:16px;color:#fbbf24;padding:12px 14px;">R$ <?= number_format($result->valor_desconto?:$totalGeral,2,',','.') ?></td>
                </tr>
            </tfoot>
        </table>
    </div>
</div>

<!-- PIX QR Code -->
<?php if (!empty($qrCode)&&!empty($this->data['configuration']['pix_key'])): ?>
<div class="mc-card">
    <div class="mc-card-head"><div class="mc-card-head-left"><i class='bx bx-qr' style="color:#06b6d4;"></i><span>Pagamento via PIX</span></div></div>
    <div class="mc-card-body" style="text-align:center;padding:24px;">
        <img src="<?= $qrCode ?>" style="width:180px;border-radius:12px;border:3px solid rgba(6,182,212,0.4);margin-bottom:12px;" alt="QR Code PIX">
        <div style="font-size:13px;color:#9ca3af;margin-bottom:6px;">Chave PIX: <strong style="color:#e8eaf0;"><?= htmlspecialchars($chaveFormatada??'') ?></strong></div>
        <div style="font-size:18px;font-weight:800;color:#fbbf24;">R$ <?= number_format($result->valor_desconto?:$totalGeral,2,',','.') ?></div>
    </div>
</div>
<?php endif; ?>
<?php endif; ?>
