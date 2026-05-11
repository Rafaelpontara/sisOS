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
$de  = _sanitizeDate($this->input->get('de'), date('Y-01-01'));
$ate = _sanitizeDate($this->input->get('ate'), date('Y-m-d'));
$mais_os = $this->db->query("SELECT c.idClientes,c.nomeCliente,c.celular,
    COUNT(os.idOs) as total_os,
    SUM(CASE WHEN os.status IN ('Finalizado','Faturado') THEN 1 ELSE 0 END) as finalizadas,
    MAX(os.dataInicial) as ultima_os
    FROM clientes c LEFT JOIN os ON os.clientes_id=c.idClientes
    AND os.dataInicial BETWEEN '$de' AND '$ate'
    GROUP BY c.idClientes ORDER BY total_os DESC LIMIT 20")->result();
$novos_por_mes = $this->db->query("SELECT DATE_FORMAT(dataCadastro,'%Y-%m') as mes,COUNT(*) as total
    FROM clientes WHERE dataCadastro>=DATE_SUB(NOW(),INTERVAL 12 MONTH)
    GROUP BY mes ORDER BY mes ASC")->result();
$total_clientes    = $this->db->count_all('clientes');
$total_fornecedores= $this->db->where('fornecedor',1)->count_all_results('clientes');
$novos_mes         = $this->db->where('dataCadastro >=',date('Y-m-01'))->count_all_results('clientes');
$inativos = $this->db->query("SELECT c.nomeCliente,c.celular,MAX(os.dataInicial) as ultima_os,
    DATEDIFF(NOW(),MAX(os.dataInicial)) as dias_sem_os
    FROM clientes c LEFT JOIN os ON os.clientes_id=c.idClientes
    GROUP BY c.idClientes HAVING ultima_os IS NOT NULL AND dias_sem_os>90
    ORDER BY dias_sem_os DESC LIMIT 20")->result();
?>
<script src="https://cdn.jsdelivr.net/npm/chart.js@3.7.0/dist/chart.min.js"></script>
<style>/* ══════════════════════════════════════
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

    <div class="rel-header">
        <div class="rel-title"><i class='bx bx-group' style="color:#3b82f6;"></i><h2>Relatório de Clientes</h2></div>
        <a href="<?= site_url('relatorios/clientesRapid') ?>" target="_blank" class="rel-btn rel-btn-print"><i class='bx bx-file-pdf'></i>Gerar PDF/Imprimir</a>
    </div>

    <form method="get" class="rel-filters">
        <div class="rel-filter-item">
            <label class="rel-filter-label">De</label>
            <input type="date" name="de" class="rel-input" value="<?= $de ?>">
        </div>
        <div class="rel-filter-item">
            <label class="rel-filter-label">Até</label>
            <input type="date" name="ate" class="rel-input" value="<?= $ate ?>">
        </div>
        <button type="submit" class="rel-btn rel-btn-filter"><i class='bx bx-filter-alt'></i> Filtrar</button>
    </form>

    <!-- KPIs -->
    <div class="rel-kpis">
        <div class="rel-kpi" style="border-color:rgba(59,130,246,0.3);">
            <div class="rel-kpi-icon" style="background:rgba(59,130,246,0.15);"><i class='bx bxs-group' style="color:#3b82f6;"></i></div>
            <div><div class="rel-kpi-val"><?= number_format($total_clientes) ?></div><div class="rel-kpi-label">Total Clientes</div></div>
        </div>
        <div class="rel-kpi" style="border-color:rgba(168,85,247,0.3);">
            <div class="rel-kpi-icon" style="background:rgba(168,85,247,0.15);"><i class='bx bx-building' style="color:#a78bfa;"></i></div>
            <div><div class="rel-kpi-val"><?= number_format($total_fornecedores) ?></div><div class="rel-kpi-label">Fornecedores</div></div>
        </div>
        <div class="rel-kpi" style="border-color:rgba(34,197,94,0.3);">
            <div class="rel-kpi-icon" style="background:rgba(34,197,94,0.15);"><i class='bx bx-user-plus' style="color:#22c55e;"></i></div>
            <div><div class="rel-kpi-val"><?= number_format($novos_mes) ?></div><div class="rel-kpi-label">Novos este mês</div></div>
        </div>
    </div>

    <!-- Gráfico novos clientes -->
    <div class="rel-card" style="margin-bottom:14px;">
        <div class="rel-card-head"><i class='bx bx-bar-chart-alt-2' style="color:#3b82f6;"></i><span>Novos Clientes por Mês (12 meses)</span></div>
        <div class="rel-card-body"><canvas id="chartNovos" height="140"></canvas></div>
    </div>

    <!-- Clientes com mais OS -->
    <div class="rel-card" style="margin-bottom:14px;">
        <div class="rel-card-head">
            <i class='bx bx-trophy' style="color:#fbbf24;"></i><span>Clientes com Mais OS no Período</span>
            <button onclick="exportarCSV('tblCli','clientes_<?= date('Y-m-d') ?>')" class="rel-btn-export"><i class='bx bx-export'></i> CSV</button>
        </div>
        <div class="rel-card-body" style="padding:0;">
            <table class="rel-tbl" id="tblCli">
                <thead><tr><th>#</th><th>Cliente</th><th>Celular</th><th>Total OS</th><th>Finalizadas</th><th>Última OS</th></tr></thead>
                <tbody>
                <?php if (!empty($mais_os)): foreach ($mais_os as $i => $r): ?>
                <tr>
                    <td style="color:#fbbf24;font-weight:700;font-size:13px;"><?= $i+1 ?>º</td>
                    <td style="font-weight:700;color:#e8eaf0;">
                        <a href="<?= site_url('clientes/visualizar/'.$r->idClientes) ?>" style="color:#60a5fa;text-decoration:none;">
                            <?= htmlspecialchars($r->nomeCliente) ?>
                        </a>
                    </td>
                    <td style="font-size:12px;color:#9ca3af;">
                        <?php if (!empty($r->celular)): ?>
                        <a href="https://wa.me/55<?= preg_replace('/\D/','',$r->celular) ?>" target="_blank" style="color:#4ade80;text-decoration:none;">
                            <i class='bx bxl-whatsapp'></i> <?= htmlspecialchars($r->celular) ?>
                        </a>
                        <?php else: ?>—<?php endif; ?>
                    </td>
                    <td><span class="rel-badge rb-blue"><?= $r->total_os ?></span></td>
                    <td><span class="rel-badge rb-green"><?= $r->finalizadas ?></span></td>
                    <td style="font-size:12px;color:#9ca3af;">
                        <?= $r->ultima_os ? date('d/m/Y',strtotime($r->ultima_os)) : '—' ?>
                    </td>
                </tr>
                <?php endforeach; else: ?>
                <tr><td colspan="6" class="rel-empty">Nenhum cliente com OS no período.</td></tr>
                <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Clientes Inativos -->
    <div class="rel-card">
        <div class="rel-card-head"><i class='bx bx-user-x' style="color:#f87171;"></i><span>Clientes Inativos (sem OS há +90 dias)</span></div>
        <div class="rel-card-body" style="padding:0;">
            <table class="rel-tbl">
                <thead><tr><th>Cliente</th><th>Celular</th><th>Última OS</th><th>Dias sem OS</th><th>Contato</th></tr></thead>
                <tbody>
                <?php if (!empty($inativos)): foreach ($inativos as $r): ?>
                <tr>
                    <td style="font-weight:600;color:#e8eaf0;"><?= htmlspecialchars($r->nomeCliente) ?></td>
                    <td style="font-size:12px;color:#9ca3af;">
                        <?= !empty($r->celular) ? htmlspecialchars($r->celular) : '—' ?>
                    </td>
                    <td style="font-size:12px;color:#9ca3af;">
                        <?= $r->ultima_os ? date('d/m/Y',strtotime($r->ultima_os)) : '—' ?>
                    </td>
                    <td>
                        <span class="rel-badge <?= $r->dias_sem_os > 180 ? 'rb-red' : 'rb-amber' ?>">
                            <?= $r->dias_sem_os ?> dias
                        </span>
                    </td>
                    <td>
                        <?php if (!empty($r->celular)): ?>
                        <a href="https://wa.me/55<?= preg_replace('/\D/','',$r->celular) ?>?text=<?= urlencode('Olá '.$r->nomeCliente.'! Faz um tempo que não te vemos. Podemos ajudar com algo?') ?>"
                           target="_blank" class="rel-btn" style="padding:4px 10px;font-size:11px;background:rgba(37,211,102,0.15);color:#4ade80;border:1px solid rgba(37,211,102,0.3);">
                            <i class='bx bxl-whatsapp'></i> Contatar
                        </a>
                        <?php endif; ?>
                    </td>
                </tr>
                <?php endforeach; else: ?>
                <tr><td colspan="5" class="rel-empty">Nenhum cliente inativo.</td></tr>
                <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>

</div>

<script>
var ctxN = document.getElementById('chartNovos').getContext('2d');
new Chart(ctxN, {
    type: 'bar',
    data: {
        labels: [<?= implode(',', array_map(fn($r) => '"'.substr($r->mes,5).'/'.substr($r->mes,0,4).'"', $novos_por_mes)) ?>],
        datasets: [{ label:'Novos Clientes', data:[<?= implode(',', array_map(fn($r) => $r->total, $novos_por_mes)) ?>], backgroundColor:'rgba(59,130,246,0.7)', borderRadius:8 }]
    },
    options: {
        scales: {
            y:{ beginAtZero:true, grid:{color:'rgba(255,255,255,0.05)'}, ticks:{color:'#6b7280'} },
            x:{ grid:{display:false}, ticks:{color:'#6b7280'} }
        },
        plugins:{ legend:{display:false} }
    }
});

function exportarCSV(tblId, nome) {
    var rows = document.querySelectorAll('#'+tblId+' tr');
    var csv = [];
    rows.forEach(function(r){
        var cols = r.querySelectorAll('td,th');
        csv.push(Array.from(cols).map(function(c){return '"'+c.innerText.replace(/"/g,'""')+'"';}).join(','));
    });
    var blob = new Blob(['\uFEFF'+csv.join('\n')],{type:'text/csv;charset=utf-8;'});
    var a = document.createElement('a');
    a.href = URL.createObjectURL(blob);
    a.download = nome+'.csv';
    a.click();
}
</script>
