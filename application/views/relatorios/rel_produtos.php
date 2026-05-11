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
$mais_usados = $this->db->query("SELECT p.descricao,p.precoVenda,p.estoque,
    COUNT(po.idProdutos_os) as vezes_usado,SUM(po.quantidade) as qtd_total,
    SUM(po.preco*po.quantidade) as receita_gerada
    FROM produtos_os po LEFT JOIN produtos p ON p.idProdutos=po.produtos_id
    LEFT JOIN os ON os.idOs=po.os_id WHERE os.dataInicial BETWEEN '$de' AND '$ate'
    GROUP BY po.produtos_id ORDER BY vezes_usado DESC LIMIT 20")->result();
$estoque_critico = $this->db->query("SELECT descricao,estoque,estoqueMinimo,precoVenda,precoCompra,
    (precoVenda-precoCompra) as margem FROM produtos
    WHERE estoque<=estoqueMinimo AND estoqueMinimo>0 ORDER BY estoque ASC")->result();
$totais_prod = $this->db->query("SELECT COUNT(*) as total,
    SUM(estoque*precoVenda) as valor_estoque,SUM(estoque*precoCompra) as custo_estoque,
    SUM(CASE WHEN estoque=0 THEN 1 ELSE 0 END) as zerados,
    SUM(CASE WHEN estoque<=estoqueMinimo AND estoqueMinimo>0 THEN 1 ELSE 0 END) as criticos
    FROM produtos")->row();
$sem_saida = $this->db->query("SELECT p.descricao,p.estoque,p.precoVenda FROM produtos p
    WHERE p.idProdutos NOT IN (
        SELECT DISTINCT po.produtos_id FROM produtos_os po
        LEFT JOIN os ON os.idOs=po.os_id WHERE os.dataInicial BETWEEN '$de' AND '$ate'
    ) AND p.estoque>0 ORDER BY p.estoque DESC LIMIT 15")->result();
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
        <div class="rel-title"><i class='bx bx-package' style="color:#8b5cf6;"></i><h2>Relatório de Produtos</h2></div>
        <a href="<?= site_url('relatorios/produtosRapid') ?>" target="_blank" class="rel-btn rel-btn-print"><i class='bx bx-file-pdf'></i> Gerar PDF/Imprimir</a>
    </div>

    <form method="get" class="rel-filters">
        <div class="rel-filter-item"><label class="rel-filter-label">De</label><input type="date" name="de" class="rel-input" value="<?= $de ?>"></div>
        <div class="rel-filter-item"><label class="rel-filter-label">Até</label><input type="date" name="ate" class="rel-input" value="<?= $ate ?>"></div>
        <button type="submit" class="rel-btn rel-btn-filter"><i class='bx bx-filter-alt'></i> Filtrar</button>
    </form>

    <!-- KPIs -->
    <?php $tp = $totais_prod; ?>
    <div class="rel-kpis">
        <div class="rel-kpi" style="border-color:rgba(139,92,246,0.3);">
            <div class="rel-kpi-icon" style="background:rgba(139,92,246,0.15);"><i class='bx bx-package' style="color:#8b5cf6;"></i></div>
            <div><div class="rel-kpi-val"><?= number_format($tp->total??0) ?></div><div class="rel-kpi-label">Total Produtos</div></div>
        </div>
        <div class="rel-kpi" style="border-color:rgba(34,197,94,0.3);">
            <div class="rel-kpi-icon" style="background:rgba(34,197,94,0.15);"><i class='bx bx-dollar' style="color:#22c55e;"></i></div>
            <div><div class="rel-kpi-val" style="font-size:14px;color:#4ade80;">R$ <?= number_format($tp->valor_estoque??0,2,',','.') ?></div><div class="rel-kpi-label">Valor em Estoque</div></div>
        </div>
        <div class="rel-kpi" style="border-color:rgba(239,68,68,0.3);">
            <div class="rel-kpi-icon" style="background:rgba(239,68,68,0.15);"><i class='bx bx-error' style="color:#ef4444;"></i></div>
            <div><div class="rel-kpi-val" style="color:#f87171;"><?= $tp->zerados??0 ?></div><div class="rel-kpi-label">Zerados</div></div>
        </div>
        <div class="rel-kpi" style="border-color:rgba(245,158,11,0.3);">
            <div class="rel-kpi-icon" style="background:rgba(245,158,11,0.15);"><i class='bx bx-alarm' style="color:#f59e0b;"></i></div>
            <div><div class="rel-kpi-val" style="color:#fbbf24;"><?= $tp->criticos??0 ?></div><div class="rel-kpi-label">Estoque Crítico</div></div>
        </div>
    </div>

    <!-- Mais usados em OS -->
    <div class="rel-card" style="margin-bottom:14px;">
        <div class="rel-card-head">
            <i class='bx bx-trending-up' style="color:#8b5cf6;"></i><span>Produtos Mais Usados em OS no Período</span>
            <button onclick="exportarCSV('tblProd','produtos_<?= date('Y-m-d') ?>')" class="rel-btn-export"><i class='bx bx-export'></i> CSV</button>
        </div>
        <div class="rel-card-body" style="padding:0;">
            <table class="rel-tbl" id="tblProd">
                <thead><tr><th>#</th><th>Produto</th><th>Preço Venda</th><th>Estoque</th><th>Usos em OS</th><th>Qtd Total</th><th>Receita Gerada</th></tr></thead>
                <tbody>
                <?php if (!empty($mais_usados)): foreach ($mais_usados as $i => $r): ?>
                <tr>
                    <td style="color:#fbbf24;font-weight:700;"><?= $i+1 ?>º</td>
                    <td style="font-weight:600;color:#e8eaf0;"><?= htmlspecialchars($r->descricao??'—') ?></td>
                    <td style="color:#4ade80;">R$ <?= number_format($r->precoVenda??0,2,',','.') ?></td>
                    <td>
                        <span class="rel-badge <?= ($r->estoque??0) <= 0 ? 'rb-red' : (($r->estoque??0) <= 5 ? 'rb-amber' : 'rb-green') ?>">
                            <?= $r->estoque??0 ?>
                        </span>
                    </td>
                    <td><span class="rel-badge rb-purple"><?= $r->vezes_usado ?></span></td>
                    <td style="color:#9ca3af;"><?= number_format($r->qtd_total??0) ?></td>
                    <td style="font-weight:700;color:#fbbf24;">R$ <?= number_format($r->receita_gerada??0,2,',','.') ?></td>
                </tr>
                <?php endforeach; else: ?>
                <tr><td colspan="7" class="rel-empty">Nenhum produto usado em OS no período.</td></tr>
                <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Estoque crítico -->
    <?php if (!empty($estoque_critico)): ?>
    <div class="rel-card" style="margin-bottom:14px;">
        <div class="rel-card-head"><i class='bx bx-error-circle' style="color:#f87171;"></i><span>Estoque Crítico (abaixo do mínimo)</span></div>
        <div class="rel-card-body" style="padding:0;">
            <table class="rel-tbl">
                <thead><tr><th>Produto</th><th>Estoque Atual</th><th>Mínimo</th><th>Preço Venda</th><th>Margem</th></tr></thead>
                <tbody>
                <?php foreach ($estoque_critico as $r): ?>
                <tr>
                    <td style="font-weight:600;color:#e8eaf0;"><?= htmlspecialchars($r->descricao) ?></td>
                    <td>
                        <span class="rel-badge <?= $r->estoque <= 0 ? 'rb-red' : 'rb-amber' ?>">
                            <?= $r->estoque ?>
                        </span>
                    </td>
                    <td style="color:#9ca3af;"><?= $r->estoqueMinimo ?></td>
                    <td style="color:#4ade80;">R$ <?= number_format($r->precoVenda,2,',','.') ?></td>
                    <td style="color:<?= ($r->margem??0) > 0 ? '#4ade80' : '#f87171' ?>;">
                        R$ <?= number_format($r->margem??0,2,',','.') ?>
                    </td>
                </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
    <?php endif; ?>

    <!-- Sem saída -->
    <?php if (!empty($sem_saida)): ?>
    <div class="rel-card">
        <div class="rel-card-head"><i class='bx bx-time' style="color:#9ca3af;"></i><span>Produtos Sem Saída no Período</span></div>
        <div class="rel-card-body" style="padding:0;">
            <table class="rel-tbl">
                <thead><tr><th>Produto</th><th>Estoque</th><th>Preço Venda</th><th>Valor Parado</th></tr></thead>
                <tbody>
                <?php foreach ($sem_saida as $r): ?>
                <tr>
                    <td style="font-weight:600;color:#e8eaf0;"><?= htmlspecialchars($r->descricao) ?></td>
                    <td><?= $r->estoque ?></td>
                    <td style="color:#4ade80;">R$ <?= number_format($r->precoVenda,2,',','.') ?></td>
                    <td style="color:#fbbf24;font-weight:700;">R$ <?= number_format($r->estoque * $r->precoVenda,2,',','.') ?></td>
                </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
    <?php endif; ?>

</div>

<script>
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
