<?php
$ano = $this->input->get('ano') ?: date('Y');
$por_mes = $this->db->query("SELECT MONTH(data_vencimento) as mes,
    SUM(CASE WHEN tipo='receita' AND baixado=1 THEN IF(valor_desconto>0,valor_desconto,valor) ELSE 0 END) as receita
    FROM lancamentos WHERE YEAR(data_vencimento)='$ano' AND tipo='receita' AND baixado=1
    GROUP BY mes ORDER BY mes")->result();
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

<?php
$meses = ['','Janeiro','Fevereiro','Março','Abril','Maio','Junho','Julho','Agosto','Setembro','Outubro','Novembro','Dezembro'];
$limite_mei_mensal = 6750.00; // Limite MEI 2025: R$ 81.000/ano = R$ 6.750/mês
$total_ano = 0;
foreach ($por_mes as $m) $total_ano += $m->receita;
$limite_ano = 81000.00;
$pct_limite = min(100, round(($total_ano / $limite_ano) * 100));
?>

<div class="rel-wrap new122">
    <div class="rel-header">
        <div class="rel-title"><i class='bx bx-receipt' style="color:#fbbf24;"></i><h2>Receitas Brutas — MEI</h2></div>
    </div>

    <form method="get" class="rel-filters">
        <div class="rel-filter-item">
            <label class="rel-filter-label">Ano</label>
            <input type="number" name="ano" class="rel-input" value="<?= $ano ?>" min="2020" max="<?= date('Y')+1 ?>" style="max-width:100px;">
        </div>
        <button type="submit" class="rel-btn rel-btn-filter"><i class='bx bx-filter-alt'></i> Filtrar</button>
    </form>

    <!-- KPIs MEI -->
    <div class="rel-kpis">
        <div class="rel-kpi" style="border-color:rgba(251,191,36,0.3);">
            <div class="rel-kpi-icon" style="background:rgba(251,191,36,0.15);"><i class='bx bx-dollar' style="color:#fbbf24;"></i></div>
            <div><div class="rel-kpi-val" style="font-size:14px;color:#fbbf24;">R$ <?= number_format($total_ano,2,',','.') ?></div><div class="rel-kpi-label">Total <?= $ano ?></div></div>
        </div>
        <div class="rel-kpi" style="border-color:rgba(251,191,36,0.3);">
            <div class="rel-kpi-icon" style="background:rgba(251,191,36,0.15);"><i class='bx bx-trending-up' style="color:#fbbf24;"></i></div>
            <div><div class="rel-kpi-val" style="font-size:14px;color:<?= $pct_limite >= 90 ? '#f87171' : ($pct_limite >= 70 ? '#fbbf24' : '#4ade80') ?>;"><?= $pct_limite ?>%</div><div class="rel-kpi-label">Limite MEI Utilizado</div></div>
        </div>
        <div class="rel-kpi" style="border-color:rgba(34,197,94,0.3);">
            <div class="rel-kpi-icon" style="background:rgba(34,197,94,0.15);"><i class='bx bx-shield' style="color:#22c55e;"></i></div>
            <div><div class="rel-kpi-val" style="font-size:14px;color:#4ade80;">R$ <?= number_format($limite_ano - $total_ano,2,',','.') ?></div><div class="rel-kpi-label">Saldo Disponível</div></div>
        </div>
    </div>

    <!-- Alerta limite -->
    <?php if ($pct_limite >= 80): ?>
    <div style="background:rgba(<?= $pct_limite >= 95 ? '239,68,68' : '245,158,11' ?>,0.1);border:1px solid rgba(<?= $pct_limite >= 95 ? '239,68,68' : '245,158,11' ?>,0.3);border-radius:10px;padding:12px 16px;margin-bottom:14px;display:flex;align-items:center;gap:10px;font-size:13px;color:<?= $pct_limite >= 95 ? '#f87171' : '#fbbf24' ?>;">
        <i class='bx bx-error-circle' style="font-size:20px;flex-shrink:0;"></i>
        <div>
            <strong><?= $pct_limite >= 95 ? '⚠️ ATENÇÃO CRÍTICA' : '⚠️ Atenção' ?>:</strong>
            Você já utilizou <?= $pct_limite ?>% do limite anual MEI de R$ <?= number_format($limite_ano,2,',','.') ?>.
            <?= $pct_limite >= 95 ? ' Considere formalizar como ME antes de ultrapassar o limite.' : '' ?>
        </div>
    </div>
    <?php endif; ?>

    <!-- Barra de progresso do limite -->
    <div class="rel-card" style="margin-bottom:14px;">
        <div class="rel-card-head"><i class='bx bx-slider' style="color:#fbbf24;"></i><span>Limite Anual MEI <?= $ano ?> — R$ <?= number_format($limite_ano,2,',','.') ?></span></div>
        <div class="rel-card-body">
            <div style="background:rgba(255,255,255,0.07);border-radius:8px;height:20px;overflow:hidden;margin-bottom:8px;">
                <div style="width:<?= $pct_limite ?>%;background:<?= $pct_limite >= 90 ? '#ef4444' : ($pct_limite >= 70 ? '#f59e0b' : '#22c55e') ?>;height:100%;border-radius:8px;transition:width 1s;display:flex;align-items:center;justify-content:flex-end;padding-right:8px;">
                    <span style="font-size:11px;font-weight:700;color:#fff;"><?= $pct_limite ?>%</span>
                </div>
            </div>
            <div style="display:flex;justify-content:space-between;font-size:11px;color:#6b7280;">
                <span>R$ 0</span>
                <span style="color:#4ade80;">R$ <?= number_format($total_ano,0,'.','.') ?> faturado</span>
                <span>R$ <?= number_format($limite_ano,0,'.','.') ?></span>
            </div>
        </div>
    </div>

    <!-- Gráfico + Tabela -->
    <div class="rel-charts-grid" style="margin-bottom:14px;">
        <div class="rel-card">
            <div class="rel-card-head"><i class='bx bx-bar-chart-alt-2' style="color:#fbbf24;"></i><span>Faturamento Mensal <?= $ano ?></span></div>
            <div class="rel-card-body"><canvas id="chartMei" height="200"></canvas></div>
        </div>
        <div class="rel-card">
            <div class="rel-card-head"><i class='bx bx-table' style="color:#fbbf24;"></i><span>Tabela Mensal</span></div>
            <div class="rel-card-body" style="padding:0;">
                <table class="rel-tbl">
                    <thead><tr><th>Mês</th><th>Receita</th><th>% do Limite Mensal</th></tr></thead>
                    <tbody>
                    <?php
                    $receitasPorMes = [];
                    foreach ($por_mes as $r) $receitasPorMes[(int)$r->mes] = $r->receita;
                    for ($m = 1; $m <= 12; $m++):
                        $rec = $receitasPorMes[$m] ?? 0;
                        $pct = $limite_mei_mensal > 0 ? min(100, round(($rec / $limite_mei_mensal) * 100)) : 0;
                    ?>
                    <tr>
                        <td style="color:#c9cad6;"><?= $meses[$m] ?></td>
                        <td style="font-weight:<?= $rec > 0 ? '700' : '400' ?>;color:<?= $rec > 0 ? '#fbbf24' : '#6b7280' ?>;">
                            R$ <?= number_format($rec,2,',','.') ?>
                        </td>
                        <td>
                            <?php if ($rec > 0): ?>
                            <div style="display:flex;align-items:center;gap:8px;">
                                <div style="flex:1;background:rgba(255,255,255,0.07);border-radius:3px;height:5px;">
                                    <div style="width:<?= $pct ?>%;background:<?= $pct>=90?'#ef4444':($pct>=70?'#f59e0b':'#22c55e') ?>;height:5px;border-radius:3px;"></div>
                                </div>
                                <span style="font-size:11px;color:#6b7280;"><?= $pct ?>%</span>
                            </div>
                            <?php else: ?>
                            <span style="color:#6b7280;font-size:12px;">—</span>
                            <?php endif; ?>
                        </td>
                    </tr>
                    <?php endfor; ?>
                    <tr style="border-top:2px solid rgba(255,255,255,0.1);">
                        <td style="font-weight:700;color:#e8eaf0;">TOTAL</td>
                        <td style="font-weight:800;color:#fbbf24;font-size:14px;">R$ <?= number_format($total_ano,2,',','.') ?></td>
                        <td style="color:<?= $pct_limite>=90?'#f87171':($pct_limite>=70?'#fbbf24':'#4ade80') ?>;font-weight:700;"><?= $pct_limite ?>% do limite anual</td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script>
var ctxMei = document.getElementById('chartMei').getContext('2d');
var recMeses = <?php
    $arr = array_fill(1,12,0);
    foreach ($por_mes as $r) $arr[(int)$r->mes] = round($r->receita,2);
    echo json_encode(array_values($arr));
?>;
new Chart(ctxMei, {
    type: 'bar',
    data: {
        labels: ['Jan','Fev','Mar','Abr','Mai','Jun','Jul','Ago','Set','Out','Nov','Dez'],
        datasets: [{
            label: 'Receita',
            data: recMeses,
            backgroundColor: recMeses.map(v => v >= <?= $limite_mei_mensal ?> ? 'rgba(239,68,68,0.8)' : (v >= <?= $limite_mei_mensal * 0.8 ?> ? 'rgba(245,158,11,0.8)' : 'rgba(251,191,36,0.7)')),
            borderRadius: 8
        },{
            label: 'Limite Mensal',
            data: Array(12).fill(<?= $limite_mei_mensal ?>),
            type: 'line', borderColor: '#ef4444', borderDash: [5,5],
            borderWidth: 1.5, pointRadius: 0, fill: false
        }]
    },
    options: {
        scales: {
            y: { beginAtZero:true, grid:{color:'rgba(255,255,255,0.05)'}, ticks:{color:'#6b7280', callback: v=>'R$'+v.toLocaleString('pt-BR')} },
            x: { grid:{display:false}, ticks:{color:'#6b7280'} }
        },
        plugins:{ legend:{position:'bottom',labels:{color:'#9ca3af',usePointStyle:true}} }
    }
});
</script>
