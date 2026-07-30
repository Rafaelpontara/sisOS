<?php
$totalDia    = 0;
$countVendas = count($vendas ?? []);
$formas      = [];
$maiorVenda  = 0;
$vendasHora  = array_fill(0, 24, 0);

foreach (($vendas ?? []) as $v) {
    $val = floatval($v->totalFinal ?? (floatval($v->valor_desconto) > 0 ? floatval($v->valor_desconto) : floatval($v->valorTotal ?? 0)));
    if (strtolower($v->status ?? '') !== 'cancelado') {
        $totalDia += $val;
        if ($val > $maiorVenda) $maiorVenda = $val;
    }
    $forma = $v->forma_pgto ?: 'Não informado';
    $formas[$forma] = ($formas[$forma] ?? 0) + $val;
    $hora = !empty($v->horaVenda) && $v->horaVenda !== '—'
        ? (int)explode(':', $v->horaVenda)[0]
        : ($v->dataVenda ? (int)date('G', strtotime($v->dataVenda)) : 0);
    if (isset($vendasHora[$hora])) $vendasHora[$hora] += $val;
}
arsort($formas);
$ticketMedio = $countVendas > 0 ? $totalDia / $countVendas : 0;
?>

<style>
/* ── PDV Relatório ─────────────────────────────────── */
.pdvr-wrap      { padding: 0 8px 32px; }
.pdvr-header    { display:flex;align-items:center;justify-content:space-between;
                  flex-wrap:wrap;gap:12px;margin-bottom:20px;
                  padding:16px 20px;background:#1e2235;border-radius:14px;
                  border:1px solid rgba(255,255,255,0.07); }
.pdvr-title     { font-size:18px;font-weight:800;color:#e8eaf0;
                  display:flex;align-items:center;gap:8px; }
.pdvr-kpi-grid  { display:grid;grid-template-columns:repeat(auto-fill,minmax(180px,1fr));
                  gap:12px;margin-bottom:20px; }
.pdvr-kpi       { background:#1e2235;border-radius:12px;padding:16px;
                  border:1px solid rgba(255,255,255,0.07); }
.pdvr-kpi-lbl   { font-size:10px;font-weight:700;color:#6b7280;
                  text-transform:uppercase;letter-spacing:.6px;margin-bottom:6px; }
.pdvr-kpi-val   { font-size:22px;font-weight:900;line-height:1; }
.pdvr-kpi-sub   { font-size:11px;color:#6b7280;margin-top:4px; }
.pdvr-section   { background:#1e2235;border-radius:12px;border:1px solid rgba(255,255,255,0.07);
                  margin-bottom:16px;overflow:hidden; }
.pdvr-sec-head  { padding:12px 16px;border-bottom:1px solid rgba(255,255,255,0.06);
                  font-size:12px;font-weight:800;color:#9ca3af;
                  text-transform:uppercase;letter-spacing:.6px;
                  display:flex;align-items:center;gap:6px; }
.pdvr-sec-body  { padding:14px 16px; }
.pdvr-forma-item{ display:flex;align-items:center;justify-content:space-between;
                  padding:8px 0;border-bottom:1px solid rgba(255,255,255,0.04); }
.pdvr-forma-item:last-child{ border-bottom:none; }
.pdvr-forma-bar { height:4px;border-radius:2px;background:#f97316;margin-top:4px; }
.pdvr-table     { width:100%;border-collapse:collapse; }
.pdvr-table th  { background:#13151f;color:#6b7280;font-size:11px;font-weight:700;
                  text-transform:uppercase;letter-spacing:.4px;
                  padding:10px 12px;border-bottom:1px solid rgba(255,255,255,0.06); }
.pdvr-table td  { padding:10px 12px;font-size:13px;color:#c9cad6;
                  border-bottom:1px solid rgba(255,255,255,0.04);vertical-align:middle; }
.pdvr-table tr:last-child td { border-bottom:none; }
.pdvr-table tr:hover td { background:rgba(249,115,22,0.04); }
.pdvr-badge     { display:inline-block;padding:3px 10px;border-radius:20px;
                  font-size:10px;font-weight:700; }
.pdvr-badge-ok  { background:rgba(74,222,128,0.12);color:#4ade80; }
.pdvr-badge-ca  { background:rgba(248,113,113,0.12);color:#f87171; }
.pdvr-filter-form { display:flex;align-items:center;gap:10px;flex-wrap:wrap; }
.pdvr-filter-form input[type=date] {
    background:#252a3a;border:1px solid #444860;color:#e8eaf0;
    border-radius:8px;padding:7px 12px;font-size:13px; }
.pdvr-btn { display:inline-flex;align-items:center;gap:5px;padding:7px 14px;
            border-radius:8px;font-size:12px;font-weight:700;text-decoration:none;
            border:none;cursor:pointer;transition:all .15s; }
.pdvr-btn-primary { background:linear-gradient(135deg,#f97316,#ea580c);color:#fff; }
.pdvr-btn-green   { background:rgba(74,222,128,0.12);color:#4ade80;
                    border:1px solid rgba(74,222,128,0.25); }
.pdvr-empty { padding:40px;text-align:center;color:#6b7280;font-size:14px; }
</style>

<div class="pdvr-wrap">

    <!-- Header -->
    <div class="pdvr-header">
        <div class="pdvr-title">
            <i class='bx bx-store-alt' style="color:#f97316;font-size:22px;"></i>
            Relatório PDV — <?= date('d/m/Y', strtotime($data)) ?>
        </div>
        <div style="display:flex;align-items:center;gap:8px;flex-wrap:wrap;">
            <form class="pdvr-filter-form" method="get" action="<?= site_url('pdv/relatorio') ?>">
                <input type="date" name="data" value="<?= $data ?>">
                <button type="submit" class="pdvr-btn pdvr-btn-primary">
                    <i class='bx bx-search-alt'></i> Filtrar
                </button>
            </form>
            <a href="<?= site_url('pdv') ?>" class="pdvr-btn pdvr-btn-green">
                <i class='bx bx-store'></i> Abrir PDV
            </a>
            <button onclick="window.print()" class="pdvr-btn" style="background:#252a3a;color:#9ca3af;">
                <i class='bx bx-printer'></i> Imprimir
            </button>
        </div>
    </div>

    <!-- KPIs -->
    <div class="pdvr-kpi-grid">
        <div class="pdvr-kpi">
            <div class="pdvr-kpi-lbl"><i class='bx bx-trending-up'></i> Total do Dia</div>
            <div class="pdvr-kpi-val" style="color:#4ade80;">
                R$ <?= number_format($totalDia, 2, ',', '.') ?>
            </div>
            <div class="pdvr-kpi-sub">Vendas faturadas</div>
        </div>
        <div class="pdvr-kpi">
            <div class="pdvr-kpi-lbl"><i class='bx bx-cart'></i> Vendas</div>
            <div class="pdvr-kpi-val" style="color:#60a5fa;"><?= $countVendas ?></div>
            <div class="pdvr-kpi-sub">Transações no dia</div>
        </div>
        <div class="pdvr-kpi">
            <div class="pdvr-kpi-lbl"><i class='bx bx-receipt'></i> Ticket Médio</div>
            <div class="pdvr-kpi-val" style="color:#f97316;">
                R$ <?= number_format($ticketMedio, 2, ',', '.') ?>
            </div>
            <div class="pdvr-kpi-sub">Por venda</div>
        </div>
        <div class="pdvr-kpi">
            <div class="pdvr-kpi-lbl"><i class='bx bx-trophy'></i> Maior Venda</div>
            <div class="pdvr-kpi-val" style="color:#fbbf24;">
                R$ <?= number_format($maiorVenda, 2, ',', '.') ?>
            </div>
            <div class="pdvr-kpi-sub">Valor mais alto do dia</div>
        </div>
    </div>

    <div class="row-fluid">
        <div class="span6">
            <!-- Formas de Pagamento -->
            <div class="pdvr-section">
                <div class="pdvr-sec-head">
                    <i class='bx bx-credit-card'></i> Formas de Pagamento
                </div>
                <div class="pdvr-sec-body">
                    <?php if (empty($formas)): ?>
                    <div class="pdvr-empty">Nenhuma venda no período</div>
                    <?php else: ?>
                    <?php foreach ($formas as $forma => $valor): ?>
                    <?php $pct = $totalDia > 0 ? round($valor / $totalDia * 100) : 0; ?>
                    <div class="pdvr-forma-item">
                        <div>
                            <div style="font-size:13px;font-weight:600;color:#e8eaf0;">
                                <?= htmlspecialchars($forma) ?>
                            </div>
                            <div class="pdvr-forma-bar" style="width:<?= $pct ?>px;max-width:200px;"></div>
                        </div>
                        <div style="text-align:right;">
                            <div style="font-size:14px;font-weight:800;color:#4ade80;">
                                R$ <?= number_format($valor, 2, ',', '.') ?>
                            </div>
                            <div style="font-size:11px;color:#6b7280;"><?= $pct ?>%</div>
                        </div>
                    </div>
                    <?php endforeach; ?>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <div class="span6">
            <!-- Resumo Rápido -->
            <div class="pdvr-section">
                <div class="pdvr-sec-head">
                    <i class='bx bx-bar-chart-alt-2'></i> Resumo
                </div>
                <div class="pdvr-sec-body">
                    <?php
                    $totalDesc = array_sum(array_map(function($v) {
                        if (strtolower($v->status ?? '') === 'cancelado') return 0;
                        $bruto   = floatval($v->valorTotal ?? 0);
                        $liquido = floatval($v->valor_desconto) > 0 ? floatval($v->valor_desconto) : $bruto;
                        return max(0, $bruto - $liquido);
                    }, $vendas ?? []));
                    $countCanc = count(array_filter($vendas ?? [], fn($v) => strtolower($v->status) === 'cancelado'));
                    $countFat  = count(array_filter($vendas ?? [], fn($v) => $v->faturado == 1));
                    ?>
                    <div class="pdvr-forma-item">
                        <span style="color:#9ca3af;font-size:13px;">Vendas Faturadas</span>
                        <span style="font-weight:700;color:#4ade80;"><?= $countFat ?></span>
                    </div>
                    <div class="pdvr-forma-item">
                        <span style="color:#9ca3af;font-size:13px;">Vendas Canceladas</span>
                        <span style="font-weight:700;color:#f87171;"><?= $countCanc ?></span>
                    </div>
                    <div class="pdvr-forma-item">
                        <span style="color:#9ca3af;font-size:13px;">Total de Descontos</span>
                        <span style="font-weight:700;color:#fbbf24;">
                            R$ <?= number_format($totalDesc, 2, ',', '.') ?>
                        </span>
                    </div>
                    <div class="pdvr-forma-item">
                        <span style="color:#9ca3af;font-size:13px;">Receita Líquida</span>
                        <span style="font-weight:700;color:#4ade80;">
                            R$ <?= number_format($totalDia - $totalDesc, 2, ',', '.') ?>
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Tabela de Vendas -->
    <div class="pdvr-section">
        <div class="pdvr-sec-head">
            <i class='bx bx-list-ul'></i> Detalhamento das Vendas
            <span style="margin-left:auto;font-size:11px;color:#6b7280;font-weight:400;">
                <?= $countVendas ?> registro<?= $countVendas !== 1 ? 's' : '' ?>
            </span>
        </div>
        <?php if (empty($vendas)): ?>
        <div class="pdvr-empty">
            <i class='bx bx-shopping-bag' style="font-size:40px;display:block;margin-bottom:8px;"></i>
            Nenhuma venda registrada para <?= date('d/m/Y', strtotime($data)) ?>
        </div>
        <?php else: ?>
        <div style="overflow-x:auto;">
            <table class="pdvr-table">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Hora</th>
                        <th>Cliente</th>
                        <th>Vendedor</th>
                        <th>Produtos</th>
                        <th>Forma Pgto</th>
                        <th>Desconto</th>
                        <th>Total</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                <?php foreach ($vendas as $v):
                    $val   = floatval($v->totalFinal ?? floatval($v->valor_desconto ?? $v->valorTotal ?? 0));
                    // Tentar pegar hora de várias fontes
                    if (!empty($v->horaVenda) && $v->horaVenda !== '—') {
                        $hora = $v->horaVenda;
                    } elseif (!empty($v->dataVenda) && strlen($v->dataVenda) > 10) {
                        // dataVenda salvo com timestamp
                        $hora = date('H:i', strtotime($v->dataVenda));
                    } elseif (!empty($v->observacoes) && preg_match('/(\d{2}:\d{2})/', $v->observacoes, $m)) {
                        // Extrair hora das observações: 'PDV - 14/06/2026 17:51'
                        $hora = $m[1];
                    } else {
                        $hora = '—';
                    }
                    $isCan = strtolower($v->status ?? '') === 'cancelado';
                ?>
                <tr>
                    <td style="color:#6b7280;font-size:11px;"><?= $v->idVendas ?></td>
                    <td style="font-size:12px;color:#9ca3af;"><?= $hora ?></td>
                    <td style="font-weight:600;">
                        <?= htmlspecialchars($v->nomeCliente ?? '—') ?>
                    </td>
                    <td style="font-size:12px;color:#9ca3af;">
                        <?= htmlspecialchars($v->nomeVendedor ?? $v->nome ?? '—') ?>
                    </td>
                    <td style="font-size:11px;color:#9ca3af;max-width:160px;overflow:hidden;text-overflow:ellipsis;white-space:nowrap;">
                        <?= htmlspecialchars(mb_substr($v->produtos ?? '—', 0, 40)) ?>
                    </td>
                    <td style="font-size:12px;"><?= htmlspecialchars($v->forma_pgto ?? '—') ?></td>
                    <td style="color:#f87171;font-size:12px;">
                        <?php
                        $brutoV  = floatval($v->valorTotal ?? 0);
                        $liquV   = floatval($v->valor_desconto) > 0 ? floatval($v->valor_desconto) : $brutoV;
                        $descV   = max(0, $brutoV - $liquV);
                        echo $descV > 0 ? '- R$ ' . number_format($descV, 2, ',', '.') : '—';
                        ?>
                    </td>
                    <td style="font-weight:700;color:<?= $isCan ? '#f87171' : '#4ade80' ?>;">
                        R$ <?= number_format($val, 2, ',', '.') ?>
                    </td>
                    <td>
                        <span class="pdvr-badge <?= $isCan ? 'pdvr-badge-ca' : 'pdvr-badge-ok' ?>">
                            <?= htmlspecialchars($v->status ?? 'Faturado') ?>
                        </span>
                    </td>
                </tr>
                <?php endforeach; ?>
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="7" style="text-align:right;font-weight:700;color:#9ca3af;font-size:13px;">
                            TOTAL DO DIA:
                        </td>
                        <td style="font-weight:900;color:#4ade80;font-size:15px;">
                            R$ <?= number_format($totalDia, 2, ',', '.') ?>
                        </td>
                        <td></td>
                    </tr>
                </tfoot>
            </table>
        </div>
        <?php endif; ?>
    </div>

</div>
