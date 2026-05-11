<?php
$statusCores = [
    'Aberto'          => ['pb-blue',   'bx-folder-open'],
    'Em Andamento'    => ['pb-purple', 'bx-loader-alt'],
    'Orçamento'       => ['pb-amber',  'bx-file'],
    'Finalizado'      => ['pb-green',  'bx-check-circle'],
    'Faturado'        => ['pb-green',  'bx-dollar-circle'],
    'Cancelado'       => ['pb-red',    'bx-x-circle'],
    'Aguardando Peças'=> ['pb-amber',  'bx-time'],
    'Aprovado'        => ['pb-green',  'bx-check'],
];
function portalBadge($status, $map) {
    $c = $map[$status] ?? ['pb-gray','bx-circle'];
    return '<span class="p-badge '.$c[0].'"><i class="bx '.$c[1].'"></i> '.htmlspecialchars($status).'</span>';
}
?>

<!-- Saudação -->
<div style="margin-bottom:20px;">
    <h2 style="font-size:20px;font-weight:800;color:#e8eaf0;margin-bottom:4px;">
        <?php
        $h = date('H');
        echo $h < 12 ? 'Bom dia' : ($h < 18 ? 'Boa tarde' : 'Boa noite');
        ?>, <?= htmlspecialchars(explode(' ', $mine_nome)[0]) ?>! 👋
    </h2>
    <p style="font-size:13px;color:#9ca3af;">Acompanhe o status das suas Ordens de Serviço.</p>
</div>

<!-- KPIs -->
<div class="p-kpis">
    <div class="p-kpi" style="border-color:rgba(249,115,22,0.3);">
        <div class="p-kpi-icon" style="background:rgba(249,115,22,0.15);">
            <i class='bx bx-file' style="color:#f97316;"></i>
        </div>
        <div>
            <div class="p-kpi-val"><?= $resumoOs->total ?? 0 ?></div>
            <div class="p-kpi-label">Total de OS</div>
        </div>
    </div>
    <div class="p-kpi" style="border-color:rgba(99,102,241,0.3);">
        <div class="p-kpi-icon" style="background:rgba(99,102,241,0.15);">
            <i class='bx bx-loader-alt' style="color:#a5b4fc;"></i>
        </div>
        <div>
            <div class="p-kpi-val"><?= $resumoOs->abertas ?? 0 ?></div>
            <div class="p-kpi-label">Em Andamento</div>
        </div>
    </div>
    <div class="p-kpi" style="border-color:rgba(34,197,94,0.3);">
        <div class="p-kpi-icon" style="background:rgba(34,197,94,0.15);">
            <i class='bx bx-check-circle' style="color:#22c55e;"></i>
        </div>
        <div>
            <div class="p-kpi-val"><?= $resumoOs->finalizadas ?? 0 ?></div>
            <div class="p-kpi-label">Finalizadas</div>
        </div>
    </div>
    <div class="p-kpi" style="border-color:rgba(251,191,36,0.3);">
        <div class="p-kpi-icon" style="background:rgba(251,191,36,0.15);">
            <i class='bx bx-file-blank' style="color:#fbbf24;"></i>
        </div>
        <div>
            <div class="p-kpi-val"><?= $resumoOs->orcamentos ?? 0 ?></div>
            <div class="p-kpi-label">Orçamentos</div>
        </div>
    </div>
</div>

<!-- Orçamentos pendentes aprovação -->
<?php if (!empty($orcamentos)): ?>
<div class="p-card" style="border-color:rgba(251,191,36,0.3);margin-bottom:16px;">
    <div class="p-card-head" style="background:rgba(251,191,36,0.08);">
        <div class="p-card-head-left">
            <i class='bx bx-bell' style="color:#fbbf24;"></i>
            <span style="color:#fbbf24;">Orçamentos aguardando sua aprovação</span>
        </div>
        <span style="background:rgba(251,191,36,0.2);color:#fbbf24;font-size:11px;font-weight:700;padding:2px 8px;border-radius:10px;">
            <?= count($orcamentos) ?>
        </span>
    </div>
    <div class="p-card-body" style="padding:0;">
        <table class="p-tbl">
            <thead>
                <tr>
                    <th>OS</th><th>Equipamento</th><th>Defeito</th><th>Valor</th><th>Ação</th>
                </tr>
            </thead>
            <tbody>
            <?php foreach ($orcamentos as $o): ?>
            <tr>
                <td style="color:#9ca3af;font-size:12px;">#<?= str_pad($o->idOs,4,'0',STR_PAD_LEFT) ?></td>
                <td style="font-weight:600;color:#e8eaf0;"><?= htmlspecialchars($o->equipamento ?? '—') ?></td>
                <td style="font-size:12px;color:#9ca3af;max-width:160px;overflow:hidden;text-overflow:ellipsis;white-space:nowrap;">
                    <?= htmlspecialchars(strip_tags($o->defeito ?? '—')) ?>
                </td>
                <td style="font-weight:700;color:#fbbf24;">
                    R$ <?= number_format($o->valor_total ?? 0, 2, ',', '.') ?>
                </td>
                <td>
                    <div style="display:flex;gap:6px;flex-wrap:wrap;">
                        <a href="<?= site_url('mine/verOs/'.$o->idOs) ?>" class="p-btn pb-ghost" style="padding:5px 12px;font-size:12px;">
                            <i class='bx bx-show'></i> Ver
                        </a>
                        <a href="<?= site_url('os/aprovar/'.$o->idOs.'?acao=sim') ?>" class="p-btn pb-green-btn" style="padding:5px 12px;font-size:12px;">
                            <i class='bx bx-check'></i> Aprovar
                        </a>
                        <a href="<?= site_url('os/aprovar/'.$o->idOs.'?acao=nao') ?>" class="p-btn pb-red-btn" style="padding:5px 12px;font-size:12px;">
                            <i class='bx bx-x'></i> Recusar
                        </a>
                    </div>
                </td>
            </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>
<?php endif; ?>

<!-- Últimas OS -->
<div class="p-card">
    <div class="p-card-head">
        <div class="p-card-head-left">
            <i class='bx bx-history' style="color:#6366f1;"></i>
            <span>Últimas Ordens de Serviço</span>
        </div>
        <a href="<?= site_url('mine/os') ?>" style="font-size:12px;color:#6b7280;text-decoration:none;">
            Ver todas →
        </a>
    </div>
    <div class="p-card-body" style="padding:0;">
        <table class="p-tbl">
            <thead>
                <tr><th>#</th><th>Data</th><th>Equipamento</th><th>Status</th><th>Valor</th><th></th></tr>
            </thead>
            <tbody>
            <?php if (!empty($ultimasOs)): foreach ($ultimasOs as $o): ?>
            <tr>
                <td style="color:#9ca3af;font-size:12px;">#<?= str_pad($o->idOs,4,'0',STR_PAD_LEFT) ?></td>
                <td style="font-size:12px;"><?= date('d/m/Y',strtotime($o->dataInicial)) ?></td>
                <td style="font-weight:600;color:#e8eaf0;"><?= htmlspecialchars($o->equipamento ?? '—') ?></td>
                <td><?= portalBadge($o->status, $statusCores) ?></td>
                <td style="color:#fbbf24;font-weight:700;">
                    R$ <?= number_format($o->valor_total ?? 0,2,',','.') ?>
                </td>
                <td>
                    <a href="<?= site_url('mine/verOs/'.$o->idOs) ?>" class="p-btn pb-ghost" style="padding:5px 10px;font-size:12px;">
                        <i class='bx bx-show'></i>
                    </a>
                </td>
            </tr>
            <?php endforeach; else: ?>
            <tr><td colspan="6" class="p-empty">Nenhuma OS cadastrada.</td></tr>
            <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>
