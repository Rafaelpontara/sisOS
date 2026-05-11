<?php
// ── Sanitização de parâmetros GET ──────────────────────────
function _sanitizeDate($v, $def) {
    if (!$v) return $def;
    return preg_match('/^\d{4}-\d{2}-\d{2}$/', $v) ? $v : $def;
}
function _sanitizeEnum($v, $allowed, $def='') {
    return in_array($v, $allowed, true) ? $v : $def;
}
?>
<?php
// ── Queries diretas — controller não passa dados para esta view ──
$de  = _sanitizeDate($this->input->get('de'), date('Y-m-01'));
$ate = _sanitizeDate($this->input->get('ate'), date('Y-m-d'));
$tecnico_id  = $this->input->get('tecnico_id') ?: '';
$status_sel  = $this->input->get('status') ?: '';

$w  = "os.dataInicial BETWEEN '$de' AND '$ate'";
$wt = $tecnico_id ? " AND os.usuarios_id='$tecnico_id'" : '';
$ws = $status_sel ? " AND os.status='$status_sel'" : '';

$por_status = $this->db->query("SELECT status, COUNT(*) as total FROM os WHERE $w$wt$ws GROUP BY status ORDER BY total DESC")->result();
$por_tecnico = $this->db->query("SELECT u.nome as tecnico, COUNT(os.idOs) as total,
    SUM(CASE WHEN os.status IN ('Finalizado','Faturado') THEN 1 ELSE 0 END) as finalizadas,
    AVG(DATEDIFF(COALESCE(os.dataFinal,NOW()),os.dataInicial)) as media_dias
    FROM os LEFT JOIN usuarios u ON u.idUsuarios=os.usuarios_id
    WHERE $w$ws GROUP BY os.usuarios_id ORDER BY total DESC")->result();
$por_mes = $this->db->query("SELECT DATE_FORMAT(dataInicial,'%Y-%m') as mes, COUNT(*) as total,
    SUM(CASE WHEN status IN ('Finalizado','Faturado') THEN 1 ELSE 0 END) as finalizadas
    FROM os WHERE dataInicial>=DATE_SUB(NOW(),INTERVAL 12 MONTH)
    GROUP BY mes ORDER BY mes ASC")->result();
$resumo = $this->db->query("SELECT COUNT(os.idOs) as total_os,
    SUM(COALESCE(po.tp,0)+COALESCE(so.ts,0)) as receita_total,
    AVG(COALESCE(po.tp,0)+COALESCE(so.ts,0)) as ticket_medio
    FROM os
    LEFT JOIN (SELECT os_id,SUM(preco*quantidade) as tp FROM produtos_os GROUP BY os_id) po ON po.os_id=os.idOs
    LEFT JOIN (SELECT os_id,SUM(preco*quantidade) as ts FROM servicos_os GROUP BY os_id) so ON so.os_id=os.idOs
    WHERE $w$wt$ws")->row();
$lista = $this->db->query("SELECT os.idOs,os.dataInicial,os.dataFinal,os.status,os.equipamento,os.defeito,
    c.nomeCliente,u.nome as tecnico,
    COALESCE(po.tp,0)+COALESCE(so.ts,0) as valor_total
    FROM os LEFT JOIN clientes c ON c.idClientes=os.clientes_id
    LEFT JOIN usuarios u ON u.idUsuarios=os.usuarios_id
    LEFT JOIN (SELECT os_id,SUM(preco*quantidade) as tp FROM produtos_os GROUP BY os_id) po ON po.os_id=os.idOs
    LEFT JOIN (SELECT os_id,SUM(preco*quantidade) as ts FROM servicos_os GROUP BY os_id) so ON so.os_id=os.idOs
    WHERE $w$wt$ws ORDER BY os.dataInicial DESC LIMIT 200")->result();
$tecnicos = $this->db->select('idUsuarios,nome')->get('usuarios')->result();
?>
<script src="https://cdn.jsdelivr.net/npm/chart.js@3.7.0/dist/chart.min.js"></script>
<?php
$mesesNome = ['','Jan','Fev','Mar','Abr','Mai','Jun','Jul','Ago','Set','Out','Nov','Dez'];
$statusCores = [
    'Aberto'          => '#3b82f6',
    'Em Andamento'    => '#6366f1',
    'Orçamento'       => '#fbbf24',
    'Finalizado'      => '#22c55e',
    'Faturado'        => '#a78bfa',
    'Cancelado'       => '#ef4444',
    'Aguardando Peças'=> '#f59e0b',
    'Aprovado'        => '#34d399',
];
?>
<style>
/* ══════════════════════════════════════
   ESTILO COMPARTILHADO — RELATÓRIOS
══════════════════════════════════════ */
.rel-wrap{max-width:1200px;margin:0 auto;}
.rel-header{display:flex;align-items:center;justify-content:space-between;margin-bottom:18px;flex-wrap:wrap;gap:10px;}
.rel-title{display:flex;align-items:center;gap:10px;}
.rel-title h2{font-size:20px;font-weight:800;color:#e8eaf0;margin:0;}
.rel-title i{font-size:24px;}

/* Filtros */
.rel-filters{display:flex;gap:10px;flex-wrap:wrap;align-items:flex-end;background:#1a1d2e;border:1px solid rgba(255,255,255,0.07);border-radius:14px;padding:14px 18px;margin-bottom:16px;}
.rel-filter-item{display:flex;flex-direction:column;gap:4px;}
.rel-filter-label{font-size:10px;font-weight:700;color:#6b7280;text-transform:uppercase;letter-spacing:.6px;}
.rel-input,.rel-select{background:#252a3a;border:1px solid #444860;color:#e8eaf0;border-radius:8px;padding:7px 12px;font-size:13px;height:36px;-webkit-appearance:none;}
.rel-input:focus,.rel-select:focus{border-color:#fbbf24;outline:none;}
.rel-input[type=date]{min-width:140px;}

/* Botões */
.rel-btn{display:inline-flex;align-items:center;gap:6px;padding:8px 16px;border-radius:8px;font-size:13px;font-weight:700;border:none;cursor:pointer;transition:all .15s;text-decoration:none;}
.rel-btn:hover{transform:translateY(-1px);}
.rel-btn-filter{background:linear-gradient(135deg,#fbbf24,#b45309);color:#111;height:36px;}
.rel-btn-print{background:#252a3a;color:#9ca3af;border:1px solid #444860;}
.rel-btn-print:hover{background:#2d3247;color:#e8eaf0;}
.rel-btn-export{display:inline-flex;align-items:center;gap:5px;padding:5px 12px;background:rgba(34,197,94,0.15);color:#4ade80;border:1px solid rgba(34,197,94,0.3);border-radius:7px;font-size:12px;font-weight:700;cursor:pointer;transition:all .15s;margin-left:auto;}
.rel-btn-export:hover{background:rgba(34,197,94,0.3);}

/* KPIs */
.rel-kpis{display:grid;grid-template-columns:repeat(auto-fill,minmax(200px,1fr));gap:12px;margin-bottom:16px;}
.rel-kpi{background:#1a1d2e;border:1px solid rgba(255,255,255,0.07);border-radius:14px;padding:14px 16px;display:flex;align-items:center;gap:14px;transition:transform .15s;}
.rel-kpi:hover{transform:translateY(-2px);}
.rel-kpi-icon{width:44px;height:44px;border-radius:12px;display:flex;align-items:center;justify-content:center;font-size:20px;flex-shrink:0;}
.rel-kpi-val{font-size:22px;font-weight:800;color:#e8eaf0;line-height:1;margin-bottom:3px;}
.rel-kpi-label{font-size:10px;font-weight:700;color:#6b7280;text-transform:uppercase;letter-spacing:.6px;}

/* Cards */
.rel-card{background:#1a1d2e;border:1px solid rgba(255,255,255,0.07);border-radius:14px;overflow:hidden;margin-bottom:14px;}
.rel-card-head{display:flex;align-items:center;gap:8px;padding:11px 16px;border-bottom:1px solid rgba(255,255,255,0.06);background:#252a3a;}
.rel-card-head i{font-size:15px;}
.rel-card-head span{font-size:11px;font-weight:700;color:#9ca3af;text-transform:uppercase;letter-spacing:.8px;flex:1;}
.rel-card-body{padding:16px;}

/* Grid gráficos */
.rel-charts-grid{display:grid;grid-template-columns:1fr 1fr;gap:14px;margin-bottom:14px;}
@media(max-width:900px){.rel-charts-grid{grid-template-columns:1fr;}}

/* Tabelas */
.rel-tbl{width:100%;border-collapse:collapse;}
.rel-tbl thead th{background:#252a3a;color:#9ca3af;font-size:11px;font-weight:700;text-transform:uppercase;letter-spacing:.5px;padding:10px 14px;border-bottom:1px solid rgba(255,255,255,0.07);white-space:nowrap;}
.rel-tbl tbody tr{border-bottom:1px solid rgba(255,255,255,0.04);transition:background .12s;}
.rel-tbl tbody tr:hover{background:rgba(255,255,255,0.03);}
.rel-tbl tbody td{padding:9px 14px;font-size:13px;color:#c9cad6;vertical-align:middle;}
.rel-empty{text-align:center;padding:30px!important;color:#6b7280!important;}

/* Badges status */
.rel-badge{display:inline-block;padding:2px 10px;border-radius:20px;font-size:11px;font-weight:700;}
.rb-green{background:rgba(34,197,94,0.15);color:#4ade80;}
.rb-red  {background:rgba(239,68,68,0.15);color:#f87171;}
.rb-blue {background:rgba(59,130,246,0.15);color:#60a5fa;}
.rb-amber{background:rgba(245,158,11,0.15);color:#fbbf24;}
.rb-gray {background:rgba(156,163,175,0.15);color:#9ca3af;}
.rb-purple{background:rgba(168,85,247,0.15);color:#c084fc;}

/* Barra de progresso */
.rel-bar-wrap{display:flex;align-items:center;gap:8px;}
.rel-bar-track{flex:1;background:rgba(255,255,255,0.07);border-radius:4px;height:6px;}
.rel-bar-fill{height:6px;border-radius:4px;}

/* Print */
@media print{
    .rel-filters,.rel-btn,.rel-btn-export,.new122 > *:not(.rel-wrap){display:none!important;}
    .rel-wrap{max-width:100%;}
    .rel-card,.rel-kpi{background:#fff!important;border:1px solid #ddd!important;color:#111!important;}
    .rel-card-head{background:#f5f5f5!important;}
    .rel-card-head span,.rel-kpi-label,.rel-tbl thead th{color:#555!important;}
    .rel-kpi-val,.rel-tbl tbody td{color:#111!important;}
}

</style>

<div class="rel-wrap new122">

    <!-- Header -->
    <div class="rel-header">
        <div class="rel-title"><i class='bx bx-file' style="color:#f97316;"></i><h2>Relatório de OS</h2></div>
        <a href="<?= site_url('relatorios/osRapid') ?>" target="_blank" class="rel-btn rel-btn-print"><i class='bx bx-file-pdf'></i> Gerar PDF/imprimir</a>
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
        <div class="rel-filter-item">
            <label class="rel-filter-label">Status</label>
            <select name="status" class="rel-select">
                <option value="">Todos</option>
                <?php foreach (['Aberto','Orçamento','Em Andamento','Finalizado','Faturado','Cancelado','Aguardando Peças','Aprovado'] as $st): ?>
                <option value="<?= $st ?>" <?= $status_sel == $st ? 'selected' : '' ?>><?= $st ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <button type="submit" class="rel-btn rel-btn-filter"><i class='bx bx-filter-alt'></i> Filtrar</button>
    </form>

    <!-- KPIs -->
    <div class="rel-kpis">
        <div class="rel-kpi" style="border-color:rgba(249,115,22,0.3);">
            <div class="rel-kpi-icon" style="background:rgba(249,115,22,0.15);"><i class='bx bx-file' style="color:#f97316;"></i></div>
            <div><div class="rel-kpi-val"><?= number_format($resumo->total_os ?? 0) ?></div><div class="rel-kpi-label">Total de OS</div></div>
        </div>
        <div class="rel-kpi" style="border-color:rgba(34,197,94,0.3);">
            <div class="rel-kpi-icon" style="background:rgba(34,197,94,0.15);"><i class='bx bx-dollar' style="color:#22c55e;"></i></div>
            <div><div class="rel-kpi-val" style="font-size:16px;">R$ <?= number_format($resumo->receita_total ?? 0,2,',','.') ?></div><div class="rel-kpi-label">Receita Total</div></div>
        </div>
        <div class="rel-kpi" style="border-color:rgba(99,102,241,0.3);">
            <div class="rel-kpi-icon" style="background:rgba(99,102,241,0.15);"><i class='bx bx-trending-up' style="color:#a5b4fc;"></i></div>
            <div><div class="rel-kpi-val" style="font-size:16px;">R$ <?= number_format($resumo->ticket_medio ?? 0,2,',','.') ?></div><div class="rel-kpi-label">Ticket Médio</div></div>
        </div>
    </div>

    <!-- Gráficos -->
    <div class="rel-charts-grid">
        <div class="rel-card">
            <div class="rel-card-head"><i class='bx bx-pie-chart-alt-2' style="color:#f97316;"></i><span>OS por Status</span></div>
            <div class="rel-card-body" style="padding:16px;">
                <canvas id="chartStatus" height="200"></canvas>
            </div>
        </div>
        <div class="rel-card">
            <div class="rel-card-head"><i class='bx bx-bar-chart-alt-2' style="color:#60a5fa;"></i><span>OS por Mês (12 meses)</span></div>
            <div class="rel-card-body" style="padding:16px;">
                <canvas id="chartMes" height="200"></canvas>
            </div>
        </div>
    </div>

    <!-- Por Técnico -->
    <div class="rel-card" style="margin-bottom:14px;">
        <div class="rel-card-head"><i class='bx bx-user-check' style="color:#4ade80;"></i><span>Desempenho por Técnico</span></div>
        <div class="rel-card-body" style="padding:0;">
            <table class="rel-tbl">
                <thead><tr><th>Técnico</th><th>Total OS</th><th>Finalizadas</th><th>Tempo Médio</th><th>Taxa</th></tr></thead>
                <tbody>
                <?php if (!empty($por_tecnico)): foreach ($por_tecnico as $t):
                    $taxa = $t->total > 0 ? round(($t->finalizadas / $t->total) * 100) : 0;
                    $cor  = $taxa >= 70 ? '#22c55e' : ($taxa >= 40 ? '#f59e0b' : '#ef4444');
                ?>
                <tr>
                    <td style="font-weight:600;color:#e8eaf0;"><?= htmlspecialchars($t->tecnico ?? 'N/A') ?></td>
                    <td><?= $t->total ?></td>
                    <td><?= $t->finalizadas ?></td>
                    <td style="color:#9ca3af;"><?= $t->media_dias ? number_format($t->media_dias,1).' dias' : '—' ?></td>
                    <td>
                        <div style="display:flex;align-items:center;gap:8px;">
                            <div style="flex:1;background:rgba(255,255,255,0.07);border-radius:4px;height:6px;">
                                <div style="width:<?= $taxa ?>%;background:<?= $cor ?>;height:6px;border-radius:4px;"></div>
                            </div>
                            <span style="font-size:12px;font-weight:700;color:<?= $cor ?>;min-width:34px;"><?= $taxa ?>%</span>
                        </div>
                    </td>
                </tr>
                <?php endforeach; else: ?>
                <tr><td colspan="5" class="rel-empty">Nenhum dado.</td></tr>
                <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Listagem -->
    <div class="rel-card">
        <div class="rel-card-head">
            <i class='bx bx-list-ul' style="color:#fbbf24;"></i><span>Listagem Detalhada (últimas 200)</span>
            <button onclick="exportarCSV('tblOs','os_<?= date('Y-m-d') ?>')" class="rel-btn-export"><i class='bx bx-export'></i> CSV</button>
        </div>
        <div class="rel-card-body" style="padding:0;">
            <table class="rel-tbl" id="tblOs">
                <thead><tr><th>#</th><th>Data</th><th>Cliente</th><th>Técnico</th><th>Equipamento</th><th>Status</th><th>Valor</th></tr></thead>
                <tbody>
                <?php if (!empty($lista)): foreach ($lista as $r): ?>
                <tr>
                    <td style="color:#6b7280;font-size:12px;">#<?= str_pad($r->idOs,4,'0',STR_PAD_LEFT) ?></td>
                    <td style="font-size:12px;"><?= date('d/m/Y',strtotime($r->dataInicial)) ?></td>
                    <td style="font-weight:600;color:#e8eaf0;"><?= htmlspecialchars($r->nomeCliente ?? '—') ?></td>
                    <td style="font-size:12px;color:#9ca3af;"><?= htmlspecialchars($r->tecnico ?? '—') ?></td>
                    <td style="font-size:12px;color:#9ca3af;"><?= htmlspecialchars($r->equipamento ?? '—') ?></td>
                    <td><?php
                        $cor = $statusCores[$r->status] ?? '#9ca3af';
                        echo '<span style="background:'.str_replace('#','',$cor)!=$cor?'rgba('.implode(',',sscanf(substr($cor,1),'%02x%02x%02x')).', 0.15)':'rgba(156,163,175,0.15)'.';color:'.$cor.';padding:2px 10px;border-radius:20px;font-size:11px;font-weight:700;">'.htmlspecialchars($r->status).'</span>';
                    ?></td>
                    <td style="font-weight:700;color:#fbbf24;">R$ <?= number_format($r->valor_total,2,',','.') ?></td>
                </tr>
                <?php endforeach; else: ?>
                <tr><td colspan="7" class="rel-empty">Nenhuma OS no período.</td></tr>
                <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>

</div>

<script>
// Gráfico Status
var ctxS = document.getElementById('chartStatus').getContext('2d');
new Chart(ctxS, {
    type: 'doughnut',
    data: {
        labels: [<?= implode(',', array_map(fn($r) => '"'.htmlspecialchars($r->status).'"', $por_status)) ?>],
        datasets: [{
            data: [<?= implode(',', array_map(fn($r) => $r->total, $por_status)) ?>],
            backgroundColor: [<?= implode(',', array_map(function($r) use ($statusCores) {
                $c = $statusCores[$r->status] ?? '#9ca3af';
                return '"'.$c.'"';
            }, $por_status)) ?>],
            borderWidth: 0,
        }]
    },
    options: { plugins: { legend: { position:'bottom', labels:{ color:'#9ca3af', usePointStyle:true }}}}
});

// Gráfico Meses
var ctxM = document.getElementById('chartMes').getContext('2d');
var meses = [<?= implode(',', array_map(fn($r) => '"'.substr($r->mes,5).'/'.substr($r->mes,0,4).'"', $por_mes)) ?>];
new Chart(ctxM, {
    type: 'bar',
    data: {
        labels: meses,
        datasets: [
            { label:'Total', data:[<?= implode(',', array_map(fn($r) => $r->total, $por_mes)) ?>], backgroundColor:'rgba(249,115,22,0.6)', borderRadius:6 },
            { label:'Finalizadas', data:[<?= implode(',', array_map(fn($r) => $r->finalizadas, $por_mes)) ?>], backgroundColor:'rgba(34,197,94,0.6)', borderRadius:6 }
        ]
    },
    options: {
        scales: {
            y: { beginAtZero:true, grid:{color:'rgba(255,255,255,0.05)'}, ticks:{color:'#6b7280'} },
            x: { grid:{display:false}, ticks:{color:'#6b7280'} }
        },
        plugins:{ legend:{ position:'bottom', labels:{ color:'#9ca3af', usePointStyle:true }}}
    }
});

function exportarCSV(tblId, nome) {
    var rows = document.querySelectorAll('#'+tblId+' tr');
    var csv = [];
    rows.forEach(function(r) {
        var cols = r.querySelectorAll('td, th');
        var row = Array.from(cols).map(function(c) { return '"'+c.innerText.replace(/"/g,'""')+'"'; });
        csv.push(row.join(','));
    });
    var blob = new Blob(['\uFEFF'+csv.join('\n')], {type:'text/csv;charset=utf-8;'});
    var link = document.createElement('a');
    link.href = URL.createObjectURL(blob);
    link.download = nome+'.csv';
    link.click();
}
</script>
