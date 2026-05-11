<?php
$statusCores = [
    'Aberto'          => ['pb-blue',   '#60a5fa'],
    'Em Andamento'    => ['pb-purple', '#c084fc'],
    'Orçamento'       => ['pb-amber',  '#fbbf24'],
    'Finalizado'      => ['pb-green',  '#4ade80'],
    'Faturado'        => ['pb-green',  '#4ade80'],
    'Cancelado'       => ['pb-red',    '#f87171'],
    'Aguardando Peças'=> ['pb-amber',  '#fbbf24'],
];
$sc = $statusCores[$os->status] ?? ['pb-gray','#9ca3af'];
?>

<!-- Back + título -->
<div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:20px;flex-wrap:wrap;gap:10px;">
    <div style="display:flex;align-items:center;gap:10px;">
        <a href="<?= site_url('mine/os') ?>" class="p-btn pb-ghost" style="padding:7px 12px;font-size:13px;">
            <i class='bx bx-arrow-back'></i>
        </a>
        <div>
            <h2 style="font-size:18px;font-weight:800;color:#e8eaf0;margin:0;">
                OS <span style="color:#fbbf24;">#<?= str_pad($os->idOs,4,'0',STR_PAD_LEFT) ?></span>
            </h2>
            <span style="font-size:12px;color:#6b7280;">Aberta em <?= date('d/m/Y',strtotime($os->dataInicial)) ?></span>
        </div>
    </div>
    <div style="display:flex;align-items:center;gap:8px;flex-wrap:wrap;">
        <span class="p-badge <?= $sc[0] ?>" style="padding:5px 14px;font-size:12px;"><?= htmlspecialchars($os->status) ?></span>
        <?php if ($os->status === 'Orçamento'): ?>
        <a href="<?= site_url('os/aprovar/'.$os->idOs.'?acao=sim') ?>" class="p-btn pb-green-btn" style="padding:7px 14px;font-size:12px;">
            <i class='bx bx-check'></i> Aprovar
        </a>
        <a href="<?= site_url('os/aprovar/'.$os->idOs.'?acao=nao') ?>" class="p-btn pb-red-btn" style="padding:7px 14px;font-size:12px;">
            <i class='bx bx-x'></i> Recusar
        </a>
        <?php endif; ?>
    </div>
</div>

<!-- Equipamento + Técnico -->
<div class="p-card p-section">
    <div class="p-card-head">
        <div class="p-card-head-left">
            <i class='bx bx-devices' style="color:#60a5fa;"></i>
            <span>Equipamento & Responsável</span>
        </div>
    </div>
    <div class="p-card-body">
        <div class="p-info-grid">
            <div>
                <?php if (!empty($os->equipamento)): ?>
                <div class="p-field-view">
                    <span class="lbl">Equipamento</span>
                    <span class="val" style="font-weight:700;"><?= htmlspecialchars($os->equipamento) ?></span>
                </div>
                <?php endif; ?>
                <?php if (!empty($os->numeroSerie)): ?>
                <div class="p-field-view">
                    <span class="lbl">Nº de Série / IMEI</span>
                    <span class="val"><?= htmlspecialchars($os->numeroSerie) ?></span>
                </div>
                <?php endif; ?>
                <div class="p-field-view">
                    <span class="lbl">Data de Abertura</span>
                    <span class="val"><?= date('d/m/Y', strtotime($os->dataInicial)) ?></span>
                </div>
                <?php if ($os->dataFinal && $os->dataFinal != '0000-00-00'): ?>
                <div class="p-field-view">
                    <span class="lbl">Prazo / Data Final</span>
                    <span class="val"><?= date('d/m/Y', strtotime($os->dataFinal)) ?></span>
                </div>
                <?php endif; ?>
            </div>
            <div>
                <div class="p-field-view">
                    <span class="lbl">Técnico Responsável</span>
                    <span class="val" style="font-weight:600;"><?= htmlspecialchars($os->tecnico ?? '—') ?></span>
                </div>
                <?php if (!empty($os->garantia)): ?>
                <div class="p-field-view">
                    <span class="lbl">Garantia</span>
                    <span class="val"><?= $os->garantia ?> dia(s)</span>
                </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<!-- Defeito + Observações -->
<?php if ($os->defeito || $os->observacoes): ?>
<div class="p-card p-section">
    <div class="p-card-head">
        <div class="p-card-head-left">
            <i class='bx bx-detail' style="color:#fbbf24;"></i>
            <span>Detalhes</span>
        </div>
    </div>
    <div class="p-card-body">
        <?php if ($os->defeito): ?>
        <div class="p-field-view" style="margin-bottom:14px;">
            <span class="lbl" style="color:#f87171;">Defeito Apresentado</span>
            <div class="p-text-box" style="margin-top:4px;"><?= nl2br(htmlspecialchars(strip_tags($os->defeito))) ?></div>
        </div>
        <?php endif; ?>
        <?php if ($os->observacoes): ?>
        <div class="p-field-view">
            <span class="lbl">Observações</span>
            <div class="p-text-box" style="margin-top:4px;"><?= nl2br(htmlspecialchars(strip_tags($os->observacoes))) ?></div>
        </div>
        <?php endif; ?>
    </div>
</div>
<?php endif; ?>

<!-- Laudo Técnico (só se finalizado) -->
<?php if (!empty($os->laudoTecnico) && in_array($os->status, ['Finalizado','Faturado'])): ?>
<div class="p-card p-section">
    <div class="p-card-head">
        <div class="p-card-head-left">
            <i class='bx bx-search-alt' style="color:#a78bfa;"></i>
            <span>Laudo Técnico</span>
        </div>
    </div>
    <div class="p-card-body">
        <div class="p-text-box"><?= nl2br(htmlspecialchars(strip_tags($os->laudoTecnico))) ?></div>
    </div>
</div>
<?php endif; ?>

<!-- Produtos e Serviços -->
<?php if (!empty($produtos) || !empty($servicos)): ?>
<div class="p-card p-section">
    <div class="p-card-head">
        <div class="p-card-head-left">
            <i class='bx bx-receipt' style="color:#fbbf24;"></i>
            <span>Serviços e Peças</span>
        </div>
    </div>
    <div class="p-card-body" style="padding:0;">
        <table class="p-tbl">
            <thead><tr><th>Descrição</th><th>Tipo</th><th style="width:60px;">Qtd</th><th style="width:110px;">Unit.</th><th style="width:120px;">Subtotal</th></tr></thead>
            <tbody>
            <?php foreach ($servicos as $s): ?>
            <tr>
                <td style="font-weight:600;color:#e8eaf0;"><?= htmlspecialchars($s->nome ?? '—') ?></td>
                <td><span class="p-badge pb-green" style="font-size:10px;">Serviço</span></td>
                <td><?= $s->quantidade ?? 1 ?></td>
                <td>R$ <?= number_format($s->preco ?? 0,2,',','.') ?></td>
                <td style="font-weight:600;">R$ <?= number_format(($s->preco??0)*($s->quantidade??1),2,',','.') ?></td>
            </tr>
            <?php endforeach; ?>
            <?php foreach ($produtos as $p): ?>
            <tr>
                <td style="font-weight:600;color:#e8eaf0;"><?= htmlspecialchars($p->descricao ?? '—') ?></td>
                <td><span class="p-badge pb-purple" style="font-size:10px;">Peça</span></td>
                <td><?= $p->quantidade ?? 1 ?></td>
                <td>R$ <?= number_format($p->preco ?? 0,2,',','.') ?></td>
                <td style="font-weight:600;">R$ <?= number_format(($p->preco??0)*($p->quantidade??1),2,',','.') ?></td>
            </tr>
            <?php endforeach; ?>
            </tbody>
            <tfoot>
                <?php if ($desconto > 0): ?>
                <tr>
                    <td colspan="4" style="text-align:right;color:#9ca3af;padding:9px 14px;">Subtotal:</td>
                    <td style="padding:9px 14px;">R$ <?= number_format($totalProd+$totalServ,2,',','.') ?></td>
                </tr>
                <tr>
                    <td colspan="4" style="text-align:right;color:#f87171;padding:9px 14px;">Desconto:</td>
                    <td style="color:#f87171;padding:9px 14px;">- R$ <?= number_format($desconto,2,',','.') ?></td>
                </tr>
                <?php endif; ?>
                <tr style="background:rgba(251,191,36,0.05);border-top:2px solid rgba(255,255,255,0.08);">
                    <td colspan="4" style="text-align:right;font-weight:800;font-size:15px;color:#e8eaf0;padding:12px 14px;">TOTAL:</td>
                    <td style="font-weight:800;font-size:16px;color:#fbbf24;padding:12px 14px;">R$ <?= number_format($totalFinal,2,',','.') ?></td>
                </tr>
            </tfoot>
        </table>
    </div>
</div>
<?php endif; ?>

<!-- Histórico / Anotações -->
<?php if (!empty($anotacoes)): ?>
<div class="p-card p-section">
    <div class="p-card-head">
        <div class="p-card-head-left">
            <i class='bx bx-history' style="color:#60a5fa;"></i>
            <span>Histórico de Atualizações</span>
        </div>
    </div>
    <div class="p-card-body" style="padding:0;">
        <?php foreach ($anotacoes as $a): ?>
        <div style="padding:12px 18px;border-bottom:1px solid rgba(255,255,255,0.04);display:flex;gap:12px;align-items:flex-start;">
            <div style="width:8px;height:8px;border-radius:50%;background:#6366f1;flex-shrink:0;margin-top:5px;"></div>
            <div style="flex:1;">
                <div style="font-size:13px;color:#c9cad6;"><?= htmlspecialchars($a->anotacao) ?></div>
                <div style="font-size:11px;color:#6b7280;margin-top:3px;"><?= date('d/m/Y H:i',strtotime($a->data_hora)) ?></div>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
</div>
<?php endif; ?>
