<?php
function _sDate($v, $d) {
    return ($v && preg_match('/^\d{4}-\d{2}-\d{2}$/', $v)) ? $v : $d;
}

$de         = _sDate($this->input->get('de'),  date('Y-m-01'));
$ate        = _sDate($this->input->get('ate'), date('Y-m-d'));
$tecnico_id = $this->input->get('tecnico_id') ?: '';
$status_f   = $this->input->get('status') ?: 'Finalizado,Faturado';

// Técnicos para filtro
$tecnicos = $this->db->select('idUsuarios, nome')->get('usuarios')->result();

// ─── Query principal ──────────────────────────────────────────────────────
$wt = $tecnico_id ? " AND os.usuarios_id = '$tecnico_id'" : '';

$os_lucro = $this->db->query("
    SELECT
        os.idOs,
        os.status,
        os.dataFinal,
        os.dataInicial,
        c.nomeCliente,
        u.nome                                                          AS tecnico,
        os.valor_desconto,
        -- Total cobrado do cliente
        COALESCE(NULLIF(os.valor_desconto, 0),
            (SELECT COALESCE(SUM(so.preco * so.quantidade), 0) FROM servicos_os so WHERE so.os_id = os.idOs) +
            (SELECT COALESCE(SUM(po.preco * po.quantidade), 0) FROM produtos_os po WHERE po.os_id = os.idOs)
        )                                                               AS valor_cobrado,
        -- Valor dos serviços
        (SELECT COALESCE(SUM(so.preco * so.quantidade), 0)
         FROM servicos_os so WHERE so.os_id = os.idOs)                 AS val_servicos,
        -- Custo das peças (preço de compra × quantidade)
        (SELECT COALESCE(SUM(p.precoCompra * po.quantidade), 0)
         FROM produtos_os po
         JOIN produtos p ON p.idProdutos = po.produtos_id
         WHERE po.os_id = os.idOs)                                     AS custo_pecas,
        -- Valor de venda das peças (cobrado do cliente)
        (SELECT COALESCE(SUM(po.preco * po.quantidade), 0)
         FROM produtos_os po WHERE po.os_id = os.idOs)                 AS val_pecas_cobrado
    FROM os
    LEFT JOIN clientes c  ON c.idClientes  = os.clientes_id
    LEFT JOIN usuarios u  ON u.idUsuarios  = os.usuarios_id
    WHERE os.status IN ('Finalizado','Faturado')
      AND os.dataFinal BETWEEN '$de' AND '$ate' $wt
    ORDER BY os.dataFinal DESC
    LIMIT 500
")->result();

// Calcular lucro de cada OS
$totalCobrado  = 0;
$totalCusto    = 0;
$totalLucro    = 0;
$totalServicos = 0;
$qtdOs         = 0;
$lucroPorTecnico = [];

foreach ($os_lucro as &$r) {
    // Lucro = valor cobrado − custo das peças (serviços são lucro puro)
    $r->lucro       = $r->valor_cobrado - $r->custo_pecas;
    $r->margem      = $r->valor_cobrado > 0 ? round($r->lucro / $r->valor_cobrado * 100, 1) : 0;

    $totalCobrado  += $r->valor_cobrado;
    $totalCusto    += $r->custo_pecas;
    $totalLucro    += $r->lucro;
    $totalServicos += $r->val_servicos;
    $qtdOs++;

    // Agrupar por técnico
    $tec = $r->tecnico ?? 'N/A';
    if (!isset($lucroPorTecnico[$tec])) {
        $lucroPorTecnico[$tec] = ['qtd' => 0, 'cobrado' => 0, 'custo' => 0, 'lucro' => 0];
    }
    $lucroPorTecnico[$tec]['qtd']++;
    $lucroPorTecnico[$tec]['cobrado'] += $r->valor_cobrado;
    $lucroPorTecnico[$tec]['custo']   += $r->custo_pecas;
    $lucroPorTecnico[$tec]['lucro']   += $r->lucro;
}
unset($r);

// Ordenar por lucro desc
uasort($lucroPorTecnico, fn($a, $b) => $b['lucro'] <=> $a['lucro']);

$margemGeral = $totalCobrado > 0 ? round($totalLucro / $totalCobrado * 100, 1) : 0;
?>
<style>
.rel-wrap{max-width:1200px;margin:0 auto;}
.rel-header{display:flex;align-items:center;justify-content:space-between;margin-bottom:18px;flex-wrap:wrap;gap:10px;}
.rel-title{display:flex;align-items:center;gap:10px;}
.rel-title h2{font-size:20px;font-weight:800;color:#e8eaf0;margin:0;}
.rel-filters{display:flex;gap:10px;flex-wrap:wrap;align-items:flex-end;background:#1a1d2e;border:1px solid rgba(255,255,255,0.07);border-radius:14px;padding:14px 18px;margin-bottom:16px;}
.rel-filter-item{display:flex;flex-direction:column;gap:4px;}
.rel-filter-label{font-size:10px;font-weight:700;color:#6b7280;text-transform:uppercase;letter-spacing:.6px;}
.rel-input,.rel-select{background:#252a3a;border:1px solid #444860;color:#e8eaf0;border-radius:8px;padding:7px 12px;font-size:13px;height:36px;-webkit-appearance:none;}
.rel-input:focus,.rel-select:focus{border-color:#fbbf24;outline:none;}
.rel-btn{display:inline-flex;align-items:center;gap:6px;padding:8px 16px;border-radius:8px;font-size:13px;font-weight:700;border:none;cursor:pointer;transition:all .15s;height:36px;text-decoration:none;}
.rel-btn-filter{background:linear-gradient(135deg,#fbbf24,#b45309);color:#111;}
.rel-btn-print{background:#252a3a;color:#9ca3af;border:1px solid #444860;}
.rel-kpis{display:grid;grid-template-columns:repeat(auto-fill,minmax(180px,1fr));gap:12px;margin-bottom:16px;}
.rel-kpi{background:#1a1d2e;border:1px solid rgba(255,255,255,0.07);border-radius:14px;padding:14px 16px;display:flex;align-items:center;gap:14px;}
.rel-kpi-icon{width:44px;height:44px;border-radius:12px;display:flex;align-items:center;justify-content:center;font-size:20px;flex-shrink:0;}
.rel-kpi-val{font-size:18px;font-weight:800;color:#e8eaf0;line-height:1;margin-bottom:3px;}
.rel-kpi-label{font-size:10px;font-weight:700;color:#6b7280;text-transform:uppercase;letter-spacing:.6px;}
.rel-card{background:#1a1d2e;border:1px solid rgba(255,255,255,0.07);border-radius:14px;overflow:hidden;margin-bottom:14px;}
.rel-card-head{display:flex;align-items:center;gap:8px;padding:11px 16px;border-bottom:1px solid rgba(255,255,255,0.06);background:#252a3a;}
.rel-card-head i{font-size:15px;}.rel-card-head span{font-size:11px;font-weight:700;color:#9ca3af;text-transform:uppercase;letter-spacing:.8px;flex:1;}
.rel-tbl{width:100%;border-collapse:collapse;}
.rel-tbl thead th{background:#252a3a;color:#9ca3af;font-size:11px;font-weight:700;text-transform:uppercase;letter-spacing:.5px;padding:10px 14px;border-bottom:1px solid rgba(255,255,255,0.07);white-space:nowrap;}
.rel-tbl thead th.r{text-align:right;}.rel-tbl thead th.c{text-align:center;}
.rel-tbl tbody tr{border-bottom:1px solid rgba(255,255,255,0.04);transition:background .12s;}
.rel-tbl tbody tr:hover{background:rgba(255,255,255,0.03);}
.rel-tbl tbody td{padding:9px 14px;font-size:13px;color:#c9cad6;vertical-align:middle;}
.rel-tbl tbody td.r{text-align:right;}.rel-tbl tbody td.c{text-align:center;}
.rel-badge{display:inline-block;padding:2px 10px;border-radius:20px;font-size:11px;font-weight:700;}
.rb-green{background:rgba(34,197,94,0.15);color:#4ade80;}
.rb-red{background:rgba(239,68,68,0.15);color:#f87171;}
.rb-amber{background:rgba(251,191,36,0.15);color:#fbbf24;}
.rb-blue{background:rgba(96,165,250,0.15);color:#60a5fa;}
.rb-purple{background:rgba(167,139,250,0.15);color:#a78bfa;}
.rel-btn-export{display:inline-flex;align-items:center;gap:5px;padding:5px 12px;background:rgba(34,197,94,0.15);color:#4ade80;border:1px solid rgba(34,197,94,0.3);border-radius:7px;font-size:12px;font-weight:700;cursor:pointer;}
/* Margem barra */
.mg-bar{display:flex;align-items:center;gap:6px;}
.mg-track{flex:1;background:rgba(255,255,255,0.07);border-radius:4px;height:6px;min-width:50px;}
.mg-fill{height:6px;border-radius:4px;}
@media print{
    .rel-filters,.rel-btn,.rel-btn-export,.new122>*:not(.rel-wrap){display:none!important;}
    .rel-wrap{max-width:100%;}
    .rel-card,.rel-kpi{background:#fff!important;border:1px solid #ddd!important;}
    .rel-card-head{background:#f5f5f5!important;}
    .rel-tbl thead th,.rel-kpi-label,.rel-card-head span{color:#555!important;}
    .rel-tbl tbody td,.rel-kpi-val{color:#111!important;}
}
</style>

<div class="rel-wrap new122">

    <div class="rel-header">
        <div class="rel-title">
            <i class='bx bx-trending-up' style="color:#22c55e;font-size:24px;"></i>
            <h2>Relatório de Lucratividade</h2>
        </div>
        <button onclick="window.print()" class="rel-btn rel-btn-print">
            <i class='bx bx-printer'></i> Imprimir
        </button>
    </div>

    <!-- Filtros -->
    <form method="get" class="rel-filters">
        <div class="rel-filter-item">
            <label class="rel-filter-label">De</label>
            <input type="date" name="de" class="rel-input" value="<?= $de ?>">
        </div>
        <div class="rel-filter-item">
            <label class="rel-filter-label">Até</label>
            <input type="date" name="ate" class="rel-input" value="<?= $ate ?>">
        </div>
        <div class="rel-filter-item">
            <label class="rel-filter-label">Técnico</label>
            <select name="tecnico_id" class="rel-select">
                <option value="">Todos</option>
                <?php foreach ($tecnicos as $t): ?>
                <option value="<?= $t->idUsuarios ?>" <?= $tecnico_id == $t->idUsuarios ? 'selected' : '' ?>>
                    <?= htmlspecialchars($t->nome) ?>
                </option>
                <?php endforeach; ?>
            </select>
        </div>
        <button type="submit" class="rel-btn rel-btn-filter">
            <i class='bx bx-filter-alt'></i> Filtrar
        </button>
    </form>

    <!-- KPIs -->
    <div class="rel-kpis">
        <div class="rel-kpi" style="border-color:rgba(96,165,250,0.3);">
            <div class="rel-kpi-icon" style="background:rgba(96,165,250,0.15);"><i class='bx bx-file-blank' style="color:#60a5fa;"></i></div>
            <div><div class="rel-kpi-val"><?= $qtdOs ?></div><div class="rel-kpi-label">OS Analisadas</div></div>
        </div>
        <div class="rel-kpi" style="border-color:rgba(167,139,250,0.3);">
            <div class="rel-kpi-icon" style="background:rgba(167,139,250,0.15);"><i class='bx bx-dollar-circle' style="color:#a78bfa;"></i></div>
            <div><div class="rel-kpi-val" style="font-size:14px;">R$ <?= number_format($totalCobrado,2,',','.') ?></div><div class="rel-kpi-label">Total Faturado</div></div>
        </div>
        <div class="rel-kpi" style="border-color:rgba(239,68,68,0.3);">
            <div class="rel-kpi-icon" style="background:rgba(239,68,68,0.15);"><i class='bx bx-chip' style="color:#f87171;"></i></div>
            <div><div class="rel-kpi-val" style="font-size:14px;">R$ <?= number_format($totalCusto,2,',','.') ?></div><div class="rel-kpi-label">Custo de Peças</div></div>
        </div>
        <div class="rel-kpi" style="border-color:rgba(34,197,94,0.3);background:rgba(34,197,94,0.03);">
            <div class="rel-kpi-icon" style="background:rgba(34,197,94,0.15);"><i class='bx bx-trending-up' style="color:#22c55e;"></i></div>
            <div><div class="rel-kpi-val" style="font-size:14px;color:#22c55e;">R$ <?= number_format($totalLucro,2,',','.') ?></div><div class="rel-kpi-label">Lucro Total</div></div>
        </div>
        <div class="rel-kpi" style="border-color:rgba(251,191,36,0.3);">
            <div class="rel-kpi-icon" style="background:rgba(251,191,36,0.15);"><i class='bx bx-percent' style="color:#fbbf24;"></i></div>
            <div><div class="rel-kpi-val" style="color:#fbbf24;"><?= $margemGeral ?>%</div><div class="rel-kpi-label">Margem Geral</div></div>
        </div>
    </div>

    <!-- Lucratividade por Técnico -->
    <?php if (count($lucroPorTecnico) > 1): ?>
    <div class="rel-card" style="margin-bottom:14px;">
        <div class="rel-card-head">
            <i class='bx bx-user-check' style="color:#a78bfa;"></i>
            <span>Lucratividade por Técnico</span>
        </div>
        <div style="overflow-x:auto;">
        <table class="rel-tbl" style="min-width:600px;">
            <thead>
                <tr>
                    <th>Técnico</th>
                    <th class="c">OS</th>
                    <th class="r">Faturado</th>
                    <th class="r">Custo Peças</th>
                    <th class="r" style="color:#22c55e;">Lucro</th>
                    <th class="c">Margem</th>
                </tr>
            </thead>
            <tbody>
            <?php foreach ($lucroPorTecnico as $tec => $dados):
                $mg = $dados['cobrado'] > 0 ? round($dados['lucro'] / $dados['cobrado'] * 100, 1) : 0;
                $mgColor = $mg >= 50 ? '#22c55e' : ($mg >= 30 ? '#fbbf24' : '#f87171');
            ?>
            <tr>
                <td style="font-weight:700;color:#e8eaf0;"><?= htmlspecialchars($tec) ?></td>
                <td class="c"><span class="rel-badge rb-blue"><?= $dados['qtd'] ?></span></td>
                <td class="r" style="color:#a78bfa;font-weight:700;">R$ <?= number_format($dados['cobrado'],2,',','.') ?></td>
                <td class="r" style="color:#f87171;">R$ <?= number_format($dados['custo'],2,',','.') ?></td>
                <td class="r" style="color:#22c55e;font-weight:800;">R$ <?= number_format($dados['lucro'],2,',','.') ?></td>
                <td class="c">
                    <div class="mg-bar">
                        <div class="mg-track"><div class="mg-fill" style="width:<?= min($mg,100) ?>%;background:<?= $mgColor ?>;"></div></div>
                        <span style="font-size:11px;color:<?= $mgColor ?>;min-width:36px;"><?= $mg ?>%</span>
                    </div>
                </td>
            </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
        </div>
    </div>
    <?php endif; ?>

    <!-- Detalhamento por OS -->
    <div class="rel-card">
        <div class="rel-card-head">
            <i class='bx bx-list-ul' style="color:#6366f1;"></i>
            <span>Lucratividade por OS (<?= count($os_lucro) ?>)</span>
            <button onclick="exportarCSV('tblLucro','lucratividade_<?= date('Y-m-d') ?>')" class="rel-btn-export">
                <i class='bx bx-export'></i> CSV
            </button>
        </div>
        <div style="overflow-x:auto;">
        <table class="rel-tbl" id="tblLucro" style="min-width:800px;">
            <thead>
                <tr>
                    <th>OS</th>
                    <th>Cliente</th>
                    <th>Técnico</th>
                    <th class="c">Saída</th>
                    <th class="r">Serviços</th>
                    <th class="r">Peças (cobrado)</th>
                    <th class="r">Custo Peças</th>
                    <th class="r">Total Cobrado</th>
                    <th class="r" style="color:#22c55e;">Lucro</th>
                    <th class="c">Margem</th>
                </tr>
            </thead>
            <tbody>
            <?php if (!empty($os_lucro)): foreach ($os_lucro as $r):
                $mgColor = $r->margem >= 50 ? '#22c55e' : ($r->margem >= 30 ? '#fbbf24' : '#f87171');
            ?>
            <tr>
                <td>
                    <a href="<?= site_url('os/visualizar/'.$r->idOs) ?>" style="color:#60a5fa;text-decoration:none;font-size:12px;font-weight:600;">
                        #<?= str_pad($r->idOs,4,'0',STR_PAD_LEFT) ?>
                    </a>
                </td>
                <td style="max-width:150px;overflow:hidden;text-overflow:ellipsis;white-space:nowrap;">
                    <?= htmlspecialchars($r->nomeCliente ?? '—') ?>
                </td>
                <td style="font-size:12px;color:#9ca3af;"><?= htmlspecialchars($r->tecnico ?? '—') ?></td>
                <td class="c" style="font-size:12px;color:#9ca3af;white-space:nowrap;">
                    <?= $r->dataFinal ? date('d/m/Y', strtotime($r->dataFinal)) : '—' ?>
                </td>
                <td class="r" style="color:#a78bfa;">R$ <?= number_format($r->val_servicos,2,',','.') ?></td>
                <td class="r" style="color:#60a5fa;">R$ <?= number_format($r->val_pecas_cobrado,2,',','.') ?></td>
                <td class="r" style="color:#f87171;">R$ <?= number_format($r->custo_pecas,2,',','.') ?></td>
                <td class="r" style="font-weight:700;color:#e8eaf0;">R$ <?= number_format($r->valor_cobrado,2,',','.') ?></td>
                <td class="r" style="font-weight:800;color:#22c55e;">R$ <?= number_format($r->lucro,2,',','.') ?></td>
                <td class="c">
                    <div class="mg-bar">
                        <div class="mg-track"><div class="mg-fill" style="width:<?= min(max($r->margem,0),100) ?>%;background:<?= $mgColor ?>;"></div></div>
                        <span style="font-size:11px;color:<?= $mgColor ?>;min-width:36px;"><?= $r->margem ?>%</span>
                    </div>
                </td>
            </tr>
            <?php endforeach; else: ?>
            <tr><td colspan="10" style="text-align:center;padding:40px;color:#6b7280;">Nenhuma OS finalizada no período.</td></tr>
            <?php endif; ?>
            </tbody>
            <tfoot>
                <tr style="background:#252a3a;border-top:2px solid #4f46e5;">
                    <td colspan="4" style="padding:10px 14px;font-weight:800;color:#e8eaf0;font-size:11px;text-transform:uppercase;">Total Geral (<?= $qtdOs ?> OS)</td>
                    <td style="padding:10px 14px;text-align:right;color:#a78bfa;font-weight:700;">R$ <?= number_format($totalServicos,2,',','.') ?></td>
                    <td style="padding:10px 14px;text-align:right;color:#60a5fa;font-weight:700;">R$ <?= number_format(array_sum(array_column($os_lucro,'val_pecas_cobrado')),2,',','.') ?></td>
                    <td style="padding:10px 14px;text-align:right;color:#f87171;font-weight:700;">R$ <?= number_format($totalCusto,2,',','.') ?></td>
                    <td style="padding:10px 14px;text-align:right;color:#e8eaf0;font-weight:800;">R$ <?= number_format($totalCobrado,2,',','.') ?></td>
                    <td style="padding:10px 14px;text-align:right;color:#22c55e;font-weight:800;">R$ <?= number_format($totalLucro,2,',','.') ?></td>
                    <td style="padding:10px 14px;text-align:center;color:#fbbf24;font-weight:800;"><?= $margemGeral ?>%</td>
                </tr>
            </tfoot>
        </table>
        </div>
    </div>

</div>

<script>
function exportarCSV(tblId, nome) {
    var rows = document.querySelectorAll('#'+tblId+' tr');
    var csv = [];
    rows.forEach(function(r){
        var cols = r.querySelectorAll('td,th');
        csv.push(Array.from(cols).map(function(c){ return '"'+c.innerText.replace(/"/g,'""')+'"'; }).join(','));
    });
    var blob = new Blob(['\uFEFF'+csv.join('\n')], {type:'text/csv;charset=utf-8;'});
    var a = document.createElement('a'); a.href = URL.createObjectURL(blob); a.download = nome+'.csv'; a.click();
}
</script>
