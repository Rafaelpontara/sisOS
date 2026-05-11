<?php
// Helper de badge de status
function mcStatusBadge($status) {
    $map = [
        'Aberto'          => 'mb-blue',
        'Em Andamento'    => 'mb-indigo',
        'Orçamento'       => 'mb-amber',
        'Negociação'      => 'mb-amber',
        'Finalizado'      => 'mb-green',
        'Faturado'        => 'mb-green',
        'Cancelado'       => 'mb-red',
        'Aguardando Peças'=> 'mb-amber',
        'Aprovado'        => 'mb-purple',
    ];
    $cls = $map[$status] ?? 'mb-gray';
    return '<span class="mc-badge '.$cls.'">'.htmlspecialchars($status).'</span>';
}
function mcGarantiaBadge($venc) {
    if (!$venc) return '—';
    $parts = explode('/', $venc);
    if (count($parts) == 3) {
        $ts = strtotime($parts[2].'-'.$parts[1].'-'.$parts[0]);
        $cls = $ts >= strtotime('today') ? 'mb-green' : 'mb-red';
        return '<span class="mc-badge '.$cls.'">'.$venc.'</span>';
    }
    return '<span class="mc-badge mb-gray">'.$venc.'</span>';
}

// Contar totais
$totalOs = $os ? count($os) : 0;
$osAbertas = 0; $osFinalizadas = 0; $osOrcamentos = 0;
if ($os) foreach ($os as $o) {
    if (!in_array($o->status, ['Finalizado','Faturado','Cancelado'])) $osAbertas++;
    if (in_array($o->status, ['Finalizado','Faturado'])) $osFinalizadas++;
    if ($o->status == 'Orçamento') $osOrcamentos++;
}
$totalCompras = $compras ? count($compras) : 0;
$h = date('H');
$sauda = $h < 12 ? 'Bom dia' : ($h < 18 ? 'Boa tarde' : 'Boa noite');
$nome1 = explode(' ', $this->session->userdata('nome') ?: 'Cliente')[0];
?>

<!-- Saudação -->
<div style="margin-bottom:20px;">
    <h2 style="font-size:20px;font-weight:800;color:#e8eaf0;margin-bottom:4px;">
        <?= $sauda ?>, <?= htmlspecialchars($nome1) ?>! 👋
    </h2>
    <p style="font-size:13px;color:#9ca3af;">Bem-vindo à sua área do cliente.</p>
</div>

<!-- KPIs -->
<div class="mc-kpis">
    <a href="<?= base_url() ?>index.php/mine/os" class="mc-kpi" style="border-color:rgba(249,115,22,0.3);">
        <div class="mc-kpi-icon" style="background:rgba(249,115,22,0.15);"><i class='bx bx-file' style="color:#f97316;"></i></div>
        <div><div class="mc-kpi-val"><?= $totalOs ?></div><div class="mc-kpi-label">Total OS</div></div>
    </a>
    <a href="<?= base_url() ?>index.php/mine/os" class="mc-kpi" style="border-color:rgba(99,102,241,0.3);">
        <div class="mc-kpi-icon" style="background:rgba(99,102,241,0.15);"><i class='bx bx-loader-alt' style="color:#a5b4fc;"></i></div>
        <div><div class="mc-kpi-val"><?= $osAbertas ?></div><div class="mc-kpi-label">Em Andamento</div></div>
    </a>
    <a href="<?= base_url() ?>index.php/mine/os" class="mc-kpi" style="border-color:rgba(34,197,94,0.3);">
        <div class="mc-kpi-icon" style="background:rgba(34,197,94,0.15);"><i class='bx bx-check-circle' style="color:#22c55e;"></i></div>
        <div><div class="mc-kpi-val"><?= $osFinalizadas ?></div><div class="mc-kpi-label">Finalizadas</div></div>
    </a>
    <?php if ($osOrcamentos > 0): ?>
    <a href="<?= base_url() ?>index.php/mine/os" class="mc-kpi" style="border-color:rgba(251,191,36,0.4);">
        <div class="mc-kpi-icon" style="background:rgba(251,191,36,0.15);"><i class='bx bx-bell' style="color:#fbbf24;"></i></div>
        <div><div class="mc-kpi-val" style="color:#fbbf24;"><?= $osOrcamentos ?></div><div class="mc-kpi-label">Aguard. Aprovação</div></div>
    </a>
    <?php endif; ?>
    <a href="<?= base_url() ?>index.php/mine/compras" class="mc-kpi" style="border-color:rgba(168,85,247,0.3);">
        <div class="mc-kpi-icon" style="background:rgba(168,85,247,0.15);"><i class='bx bx-cart-alt' style="color:#a78bfa;"></i></div>
        <div><div class="mc-kpi-val"><?= $totalCompras ?></div><div class="mc-kpi-label">Compras</div></div>
    </a>
</div>

<!-- Atalhos -->
<div style="display:flex;gap:8px;flex-wrap:wrap;margin-bottom:18px;">
    <a href="<?= base_url() ?>index.php/mine/os" class="mc-btn mc-btn-ghost">
        <i class='bx bx-file'></i> Ver OS
    </a>
    <a href="<?= base_url() ?>index.php/mine/compras" class="mc-btn mc-btn-ghost">
        <i class='bx bx-cart-alt'></i> Compras
    </a>
    <a href="<?= base_url() ?>index.php/mine/cobrancas" class="mc-btn mc-btn-ghost">
        <i class='bx bx-credit-card-front'></i> Cobranças
    </a>
    <?php if (!$this->session->userdata('cadastra_os')): ?>
    <a href="<?= base_url() ?>index.php/mine/adicionarOs" class="mc-btn mc-btn-success">
        <i class='bx bx-plus'></i> Abrir Nova OS
    </a>
    <?php endif; ?>
</div>

<!-- Orçamentos para aprovação -->
<?php
$orcamentos = [];
if ($os) foreach ($os as $o) if ($o->status == 'Orçamento') $orcamentos[] = $o;
if (!empty($orcamentos)):
?>
<div class="mc-card" style="border-color:rgba(251,191,36,0.4);margin-bottom:14px;">
    <div class="mc-card-head" style="background:rgba(251,191,36,0.07);">
        <div class="mc-card-head-left">
            <i class='bx bx-bell' style="color:#fbbf24;"></i>
            <span style="color:#fbbf24;">Orçamentos aguardando sua aprovação</span>
        </div>
        <span class="mc-badge mb-amber"><?= count($orcamentos) ?></span>
    </div>
    <div style="overflow-x:auto;">
        <table class="mc-tbl">
            <thead><tr><th>#</th><th>Equipamento</th><th>Técnico</th><th>Data</th><th style="text-align:right;">Ações</th></tr></thead>
            <tbody>
            <?php foreach ($orcamentos as $o): ?>
            <tr>
                <td style="color:#9ca3af;font-size:12px;">#<?= str_pad($o->idOs,4,'0',STR_PAD_LEFT) ?></td>
                <td style="font-weight:600;color:#e8eaf0;"><?= htmlspecialchars($o->equipamento ?? strip_tags($o->descricaoProduto ?? '—')) ?></td>
                <td style="font-size:12px;color:#9ca3af;"><?= htmlspecialchars($o->nome ?? '—') ?></td>
                <td style="font-size:12px;"><?= date('d/m/Y',strtotime($o->dataInicial)) ?></td>
                <td style="text-align:right;">
                    <div style="display:inline-flex;gap:5px;">
                        <a href="<?= base_url() ?>index.php/mine/visualizarOs/<?= $o->idOs ?>" class="mc-act mc-act-view" title="Visualizar"><i class='bx bx-show'></i></a>
                        <a href="<?= site_url('os/aprovar/'.$o->idOs.'?acao=sim') ?>" class="mc-act mc-act-ok" title="Aprovar"><i class='bx bx-check'></i></a>
                        <a href="<?= site_url('os/aprovar/'.$o->idOs.'?acao=nao') ?>" class="mc-act mc-act-no" title="Recusar"><i class='bx bx-x'></i></a>
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
<div class="mc-card">
    <div class="mc-card-head">
        <div class="mc-card-head-left">
            <i class='bx bx-file' style="color:#f97316;"></i>
            <span>Últimas Ordens de Serviço</span>
        </div>
        <a href="<?= base_url() ?>index.php/mine/os" class="mc-btn mc-btn-ghost mc-btn-sm">Ver todas →</a>
    </div>
    <div style="overflow-x:auto;">
        <table class="mc-tbl">
            <thead><tr><th>#</th><th>Técnico</th><th>Data</th><th>Garantia</th><th>Status</th><th style="text-align:right;">Ações</th></tr></thead>
            <tbody>
            <?php if ($os): foreach (array_slice($os, 0, 6) as $o):
                $venc = '';
                if ($o->garantia && is_numeric($o->garantia) && !empty($o->dataFinal) && $o->dataFinal!='0000-00-00') {
                    $venc = dateInterval($o->dataFinal, $o->garantia);
                } elseif ($o->garantia == '0') { $venc = 'Sem Garantia'; }
            ?>
            <tr>
                <td style="color:#9ca3af;font-size:12px;">#<?= str_pad($o->idOs,4,'0',STR_PAD_LEFT) ?></td>
                <td style="font-size:12px;color:#9ca3af;"><?= htmlspecialchars($o->nome??'—') ?></td>
                <td style="font-size:12px;"><?= date('d/m/Y',strtotime($o->dataInicial)) ?></td>
                <td><?= mcGarantiaBadge($venc) ?></td>
                <td><?= mcStatusBadge($o->status) ?></td>
                <td style="text-align:right;">
                    <div style="display:inline-flex;gap:5px;">
                        <a href="<?= base_url() ?>index.php/mine/visualizarOs/<?= $o->idOs ?>" class="mc-act mc-act-view" title="Visualizar"><i class='bx bx-show'></i></a>
                        <a href="<?= base_url() ?>index.php/mine/imprimirOs/<?= $o->idOs ?>" class="mc-act mc-act-print" title="Imprimir" target="_blank"><i class='bx bx-printer'></i></a>
                        <a href="<?= base_url() ?>index.php/mine/detalhesOs/<?= $o->idOs ?>" class="mc-act mc-act-detail" title="Detalhes"><i class='bx bx-detail'></i></a>
                    </div>
                </td>
            </tr>
            <?php endforeach; else: ?>
            <tr><td colspan="6" class="mc-empty"><i class='bx bx-file' style="font-size:24px;display:block;margin-bottom:6px;opacity:.3;"></i>Nenhuma OS encontrada.</td></tr>
            <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<!-- Últimas Compras -->
<div class="mc-card">
    <div class="mc-card-head">
        <div class="mc-card-head-left">
            <i class='bx bx-cart-alt' style="color:#a78bfa;"></i>
            <span>Últimas Compras</span>
        </div>
        <a href="<?= base_url() ?>index.php/mine/compras" class="mc-btn mc-btn-ghost mc-btn-sm">Ver todas →</a>
    </div>
    <div style="overflow-x:auto;">
        <table class="mc-tbl">
            <thead><tr><th>#</th><th>Responsável</th><th>Data</th><th>Faturado</th><th>Status</th><th style="text-align:right;">Ações</th></tr></thead>
            <tbody>
            <?php if ($compras): foreach (array_slice($compras, 0, 5) as $c): ?>
            <tr>
                <td style="color:#9ca3af;font-size:12px;">#<?= str_pad($c->idVendas,4,'0',STR_PAD_LEFT) ?></td>
                <td style="font-size:12px;color:#9ca3af;"><?= htmlspecialchars($c->nome??'—') ?></td>
                <td style="font-size:12px;"><?= date('d/m/Y',strtotime($c->dataVenda)) ?></td>
                <td><?= $c->faturado ? '<span class="mc-badge mb-green">Sim</span>' : '<span class="mc-badge mb-gray">Não</span>' ?></td>
                <td><?= mcStatusBadge($c->status??'—') ?></td>
                <td style="text-align:right;">
                    <div style="display:inline-flex;gap:5px;">
                        <a href="<?= base_url() ?>index.php/mine/visualizarCompra/<?= $c->idVendas ?>" class="mc-act mc-act-view" title="Visualizar"><i class='bx bx-show'></i></a>
                        <a href="<?= base_url() ?>index.php/mine/imprimirCompra/<?= $c->idVendas ?>" class="mc-act mc-act-print" title="Imprimir" target="_blank"><i class='bx bx-printer'></i></a>
                    </div>
                </td>
            </tr>
            <?php endforeach; else: ?>
            <tr><td colspan="6" class="mc-empty">Nenhuma compra encontrada.</td></tr>
            <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>
