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
$de  = _sanitizeDate($this->input->get('de'), date('Y-m-01'));
$ate = _sanitizeDate($this->input->get('ate'), date('Y-m-d'));
$mais_usados = $this->db->query("SELECT s.nome,COUNT(so.idServicos_os) as vezes_usado,
    SUM(so.quantidade) as qtd_total,SUM(so.preco*so.quantidade) as receita_gerada,
    AVG(so.preco) as preco_medio FROM servicos_os so
    LEFT JOIN servicos s ON s.idServicos=so.servicos_id
    LEFT JOIN os ON os.idOs=so.os_id WHERE os.dataInicial BETWEEN '$de' AND '$ate'
    GROUP BY so.servicos_id ORDER BY receita_gerada DESC LIMIT 20")->result();
$totais_serv = $this->db->query("SELECT SUM(so.preco*so.quantidade) as receita_total,
    COUNT(DISTINCT so.os_id) as os_com_servico,COUNT(so.idServicos_os) as total_servicos
    FROM servicos_os so LEFT JOIN os ON os.idOs=so.os_id
    WHERE os.dataInicial BETWEEN '$de' AND '$ate'")->row();
?>
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
        <div class="rel-title"><i class='bx bx-wrench' style="color:#22c55e;"></i><h2>Relatório de Serviços</h2></div>
        <a href="<?= site_url('relatorios/servicosRapid') ?>" target="_blank" class="rel-btn rel-btn-print"><i class='bx bx-file-pdf'></i> Gerar PDF/Imprimir</a>
    </div>
    <form method="get" class="rel-filters">
        <div class="rel-filter-item"><label class="rel-filter-label">De</label><input type="date" name="de" class="rel-input" value="<?= $de ?>"></div>
        <div class="rel-filter-item"><label class="rel-filter-label">Até</label><input type="date" name="ate" class="rel-input" value="<?= $ate ?>"></div>
        <button type="submit" class="rel-btn rel-btn-filter"><i class='bx bx-filter-alt'></i> Filtrar</button>
    </form>

    <?php $ts = $totais_serv; ?>
    <div class="rel-kpis">
        <div class="rel-kpi" style="border-color:rgba(34,197,94,0.3);">
            <div class="rel-kpi-icon" style="background:rgba(34,197,94,0.15);"><i class='bx bx-dollar' style="color:#22c55e;"></i></div>
            <div><div class="rel-kpi-val" style="font-size:14px;color:#4ade80;">R$ <?= number_format($ts->receita_total??0,2,',','.') ?></div><div class="rel-kpi-label">Receita de Serviços</div></div>
        </div>
        <div class="rel-kpi" style="border-color:rgba(99,102,241,0.3);">
            <div class="rel-kpi-icon" style="background:rgba(99,102,241,0.15);"><i class='bx bx-file' style="color:#a5b4fc;"></i></div>
            <div><div class="rel-kpi-val"><?= number_format($ts->os_com_servico??0) ?></div><div class="rel-kpi-label">OS com Serviço</div></div>
        </div>
        <div class="rel-kpi" style="border-color:rgba(251,191,36,0.3);">
            <div class="rel-kpi-icon" style="background:rgba(251,191,36,0.15);"><i class='bx bx-list-check' style="color:#fbbf24;"></i></div>
            <div><div class="rel-kpi-val"><?= number_format($ts->total_servicos??0) ?></div><div class="rel-kpi-label">Serviços Realizados</div></div>
        </div>
    </div>

    <div class="rel-card">
        <div class="rel-card-head">
            <i class='bx bx-trophy' style="color:#22c55e;"></i><span>Serviços Mais Realizados</span>
            <button onclick="exportarCSV('tblServ','servicos_<?= date('Y-m-d') ?>')" class="rel-btn-export"><i class='bx bx-export'></i> CSV</button>
        </div>
        <div class="rel-card-body" style="padding:0;">
            <table class="rel-tbl" id="tblServ">
                <thead><tr><th>#</th><th>Serviço</th><th>Qtd Usos</th><th>Qtd Total</th><th>Preço Médio</th><th>Receita Gerada</th></tr></thead>
                <tbody>
                <?php if (!empty($mais_usados)): foreach ($mais_usados as $i => $r): ?>
                <tr>
                    <td style="color:#fbbf24;font-weight:700;"><?= $i+1 ?>º</td>
                    <td style="font-weight:700;color:#e8eaf0;"><?= htmlspecialchars($r->nome??'—') ?></td>
                    <td><span class="rel-badge rb-green"><?= $r->vezes_usado ?></span></td>
                    <td style="color:#9ca3af;"><?= number_format($r->qtd_total??0) ?></td>
                    <td style="color:#9ca3af;">R$ <?= number_format($r->preco_medio??0,2,',','.') ?></td>
                    <td style="font-weight:700;color:#4ade80;">R$ <?= number_format($r->receita_gerada??0,2,',','.') ?></td>
                </tr>
                <?php endforeach; else: ?>
                <tr><td colspan="6" class="rel-empty">Nenhum serviço no período.</td></tr>
                <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<script>function exportarCSV(tblId,nome){var rows=document.querySelectorAll('#'+tblId+' tr');var csv=[];rows.forEach(function(r){var cols=r.querySelectorAll('td,th');csv.push(Array.from(cols).map(function(c){return '"'+c.innerText.replace(/"/g,'""')+'"';}).join(','));});var blob=new Blob(['\uFEFF'+csv.join('\n')],{type:'text/csv;charset=utf-8;'});var a=document.createElement('a');a.href=URL.createObjectURL(blob);a.download=nome+'.csv';a.click();}</script>
