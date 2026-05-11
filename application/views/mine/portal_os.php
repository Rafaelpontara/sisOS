<?php
$statusCores = [
    'Aberto'          => 'pb-blue',
    'Em Andamento'    => 'pb-purple',
    'Orçamento'       => 'pb-amber',
    'Finalizado'      => 'pb-green',
    'Faturado'        => 'pb-green',
    'Cancelado'       => 'pb-red',
    'Aguardando Peças'=> 'pb-amber',
    'Aprovado'        => 'pb-green',
];
?>

<div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:18px;flex-wrap:wrap;gap:10px;">
    <h2 style="font-size:20px;font-weight:800;color:#e8eaf0;display:flex;align-items:center;gap:8px;">
        <i class='bx bx-file' style="color:#f97316;"></i> Minhas Ordens de Serviço
    </h2>
</div>

<!-- Filtro de status -->
<div style="display:flex;gap:6px;flex-wrap:wrap;margin-bottom:16px;">
    <?php
    $statuses = [
        ''                 => ['Todos','pb-gray'],
        'Aberto'           => ['Aberto','pb-blue'],
        'Em Andamento'     => ['Em Andamento','pb-purple'],
        'Orçamento'        => ['Orçamento','pb-amber'],
        'Finalizado'       => ['Finalizado','pb-green'],
        'Faturado'         => ['Faturado','pb-green'],
        'Cancelado'        => ['Cancelado','pb-red'],
        'Aguardando Peças' => ['Aguardando Peças','pb-amber'],
    ];
    foreach ($statuses as $val => $info):
        $active = ($status_sel === $val);
    ?>
    <a href="<?= site_url('mine/os') ?>?status=<?= urlencode($val) ?>"
       class="p-badge <?= $info[1] ?>"
       style="padding:6px 14px;font-size:12px;cursor:pointer;text-decoration:none;<?= $active ? 'opacity:1;box-shadow:0 2px 8px rgba(0,0,0,0.3);' : 'opacity:0.5;' ?>">
        <?= $info[0] ?>
    </a>
    <?php endforeach; ?>
</div>

<!-- Tabela -->
<div class="p-card">
    <div class="p-card-body" style="padding:0;">
        <table class="p-tbl">
            <thead>
                <tr>
                    <th style="width:70px;">#</th>
                    <th style="width:110px;">Data</th>
                    <th>Equipamento</th>
                    <th>Defeito</th>
                    <th style="width:140px;">Status</th>
                    <th style="width:110px;">Valor</th>
                    <th style="width:60px;"></th>
                </tr>
            </thead>
            <tbody>
            <?php if (!empty($lista)): foreach ($lista as $os): ?>
            <tr>
                <td style="color:#9ca3af;font-size:12px;">#<?= str_pad($os->idOs,4,'0',STR_PAD_LEFT) ?></td>
                <td style="font-size:12px;"><?= date('d/m/Y',strtotime($os->dataInicial)) ?></td>
                <td style="font-weight:600;color:#e8eaf0;"><?= htmlspecialchars($os->equipamento ?? '—') ?></td>
                <td style="font-size:12px;color:#9ca3af;max-width:200px;overflow:hidden;text-overflow:ellipsis;white-space:nowrap;">
                    <?= htmlspecialchars(strip_tags($os->defeito ?? '—')) ?>
                </td>
                <td>
                    <span class="p-badge <?= $statusCores[$os->status] ?? 'pb-gray' ?>">
                        <?= htmlspecialchars($os->status) ?>
                    </span>
                </td>
                <td style="font-weight:700;color:#fbbf24;">
                    R$ <?= number_format($os->valor_total ?? 0,2,',','.') ?>
                </td>
                <td>
                    <a href="<?= site_url('mine/verOs/'.$os->idOs) ?>"
                       class="p-btn pb-ghost" style="padding:5px 10px;font-size:13px;width:32px;height:32px;justify-content:center;">
                        <i class='bx bx-show'></i>
                    </a>
                </td>
            </tr>
            <?php endforeach; else: ?>
            <tr>
                <td colspan="7" class="p-empty">
                    <i class='bx bx-file' style="font-size:32px;display:block;margin-bottom:8px;opacity:.3;"></i>
                    Nenhuma OS encontrada<?= $status_sel ? ' com status "'.$status_sel.'"' : '' ?>.
                </td>
            </tr>
            <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>
