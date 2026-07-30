<?php
$de        = $this->input->get('de')        ?: date('Y-m-01');
$ate       = $this->input->get('ate')       ?: date('Y-m-d');
$tipo_raw  = $this->input->get('tipo');
$tipo      = in_array($tipo_raw, ['receita', 'despesa', ''], true) ? $tipo_raw : '';
$situacao  = $this->input->get('situacao'); // '' = todos | '1' = pago | '0' = pendente
$forma     = $this->input->get('forma_pgto') ?: '';
$cliente_f = trim($this->input->get('cliente_fornecedor') ?: '');
$categoria = $this->input->get('categoria_id') ?: '';

// Where base
$wb = "data_vencimento BETWEEN '$de' AND '$ate'";
if ($tipo)      $wb .= " AND tipo='" . $this->db->escape_str($tipo) . "'";
if ($situacao !== null && $situacao !== '') $wb .= " AND baixado=" . ($situacao === '1' ? 1 : 0);
if ($forma)     $wb .= " AND forma_pgto='" . $this->db->escape_str($forma) . "'";
if ($cliente_f) $wb .= " AND cliente_fornecedor LIKE '%" . $this->db->escape_like_str($cliente_f) . "%'";
if ($categoria) $wb .= " AND categorias_id=" . intval($categoria);

// Listas para os selects
$formas_pgto = $this->db->query("SELECT DISTINCT forma_pgto FROM lancamentos WHERE forma_pgto IS NOT NULL AND forma_pgto<>'' ORDER BY forma_pgto")->result();
$categorias  = $this->db->query("SELECT idCategorias, categoria FROM categorias ORDER BY categoria")->result();

$totais = $this->db->query("SELECT
    SUM(CASE WHEN tipo='receita' AND baixado=1 THEN IF(valor_desconto>0,valor_desconto,valor) ELSE 0 END) as rec_paga,
    SUM(CASE WHEN tipo='receita' AND baixado=0 THEN IF(valor_desconto>0,valor_desconto,valor) ELSE 0 END) as rec_pend,
    SUM(CASE WHEN tipo='despesa' AND baixado=1 THEN valor ELSE 0 END) as desp_paga,
    SUM(CASE WHEN tipo='despesa' AND baixado=0 THEN valor ELSE 0 END) as desp_pend,
    COUNT(CASE WHEN tipo='receita' THEN 1 END) as qt_rec,
    COUNT(CASE WHEN tipo='despesa' THEN 1 END) as qt_desp
    FROM lancamentos WHERE $wb")->row();
$por_categoria = $this->db->query("SELECT COALESCE(c.categoria,'Sem categoria') as categoria,
    SUM(l.valor) as total, COUNT(*) as qt
    FROM lancamentos l LEFT JOIN categorias c ON c.idCategorias=l.categorias_id
    WHERE $wb AND l.tipo='despesa' AND l.baixado=1
    GROUP BY l.categorias_id ORDER BY total DESC LIMIT 10")->result();
$por_mes = $this->db->query("SELECT DATE_FORMAT(data_vencimento,'%Y-%m') as mes,
    SUM(CASE WHEN tipo='receita' THEN IF(valor_desconto>0,valor_desconto,valor) ELSE 0 END) as receitas,
    SUM(CASE WHEN tipo='despesa' THEN valor ELSE 0 END) as despesas
    FROM lancamentos WHERE data_vencimento>=DATE_SUB(NOW(),INTERVAL 12 MONTH) AND baixado=1
    GROUP BY mes ORDER BY mes ASC")->result();
$maiores_receitas = $this->db->query("SELECT descricao,cliente_fornecedor,
    IF(valor_desconto>0,valor_desconto,valor) as valor,data_vencimento,forma_pgto
    FROM lancamentos WHERE $wb AND tipo='receita' AND baixado=1
    ORDER BY valor DESC LIMIT 10")->result();
$maiores_despesas = $this->db->query("SELECT descricao,cliente_fornecedor,
    valor,data_vencimento,forma_pgto
    FROM lancamentos WHERE $wb AND tipo='despesa' AND baixado=1
    ORDER BY valor DESC LIMIT 10")->result();
$inadimplentes = $this->db->query("SELECT cliente_fornecedor,descricao,valor,data_vencimento,
    DATEDIFF(NOW(),data_vencimento) as dias_atraso
    FROM lancamentos WHERE tipo='receita' AND baixado=0 AND data_vencimento<CURDATE()
    ORDER BY data_vencimento ASC LIMIT 20")->result();
?>
<script src="https://cdn.jsdelivr.net/npm/chart.js@3.7.0/dist/chart.min.js"></script>
<?php
$t = $totais;
$saldo = ($t->rec_paga ?? 0) - ($t->desp_paga ?? 0);
$emitente = $this->Sisos_model->getEmitente();
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
    .print-header{display:flex!important;}
}
.print-header{
    display:none;
    align-items:center;
    gap:16px;
    padding-bottom:14px;
    margin-bottom:16px;
    border-bottom:2px solid #ddd;
}
</style>

<div class="rel-wrap new122">

    <!-- Cabeçalho visível só na impressão -->
    <div class="print-header">
        <?php if (!empty($emitente->url_logo)): ?>
        <img src="<?= base_url($emitente->url_logo) ?>" alt="Logo" style="max-height:60px;max-width:160px;object-fit:contain;">
        <?php endif; ?>
        <div>
            <div style="font-size:16px;font-weight:800;color:#111;"><?= htmlspecialchars($emitente->nome ?? '') ?></div>
            <?php if (!empty($emitente->cnpj)): ?>
            <div style="font-size:12px;color:#555;">CNPJ: <?= htmlspecialchars($emitente->cnpj) ?></div>
            <?php endif; ?>
            <?php if (!empty($emitente->telefone)): ?>
            <div style="font-size:12px;color:#555;">Tel: <?= htmlspecialchars($emitente->telefone) ?></div>
            <?php endif; ?>
        </div>
        <div style="margin-left:auto;text-align:right;">
            <div style="font-size:13px;font-weight:700;color:#111;">Relatório Financeiro</div>
            <div style="font-size:11px;color:#555;">
                Período: <?= date('d/m/Y', strtotime($de)) ?> até <?= date('d/m/Y', strtotime($ate)) ?>
            </div>
            <div style="font-size:11px;color:#555;">Emitido em: <?= date('d/m/Y H:i') ?></div>
        </div>
    </div>

    <div class="rel-header">
        <div class="rel-title"><i class='bx bx-bar-chart-alt-2' style="color:#fbbf24;"></i><h2>Relatório Financeiro</h2></div>
        <a id="btnPdf" href="#" target="_blank" class="rel-btn rel-btn-print"><i class='bx bx-file-pdf'></i>Gerar PDF/Imprimir</a>
    </div>

    <!-- Filtros -->
    <form method="get" class="rel-filters" id="formFiltros">
        <!-- Linha 1: datas + tipo -->
        <div class="rel-filter-item">
            <label class="rel-filter-label">De</label>
            <input type="date" name="de" class="rel-input" value="<?= $de ?>">
        </div>
        <div class="rel-filter-item">
            <label class="rel-filter-label">Até</label>
            <input type="date" name="ate" class="rel-input" value="<?= $ate ?>">
        </div>
        <div class="rel-filter-item">
            <label class="rel-filter-label">Tipo</label>
            <select name="tipo" class="rel-select">
                <option value="">Todos</option>
                <option value="receita" <?= $tipo=='receita'?'selected':'' ?>>Receitas</option>
                <option value="despesa" <?= $tipo=='despesa'?'selected':'' ?>>Despesas</option>
            </select>
        </div>
        <div class="rel-filter-item">
            <label class="rel-filter-label">Situação</label>
            <select name="situacao" class="rel-select">
                <option value="">Todos</option>
                <option value="1" <?= $situacao==='1'?'selected':'' ?>>Pago</option>
                <option value="0" <?= $situacao==='0'?'selected':'' ?>>Pendente</option>
            </select>
        </div>
        <div class="rel-filter-item">
            <label class="rel-filter-label">Forma de Pgto</label>
            <select name="forma_pgto" class="rel-select">
                <option value="">Todas</option>
                <?php foreach ($formas_pgto as $f): ?>
                <option value="<?= htmlspecialchars($f->forma_pgto) ?>" <?= $forma===$f->forma_pgto?'selected':'' ?>>
                    <?= htmlspecialchars($f->forma_pgto) ?>
                </option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="rel-filter-item">
            <label class="rel-filter-label">Categoria</label>
            <select name="categoria_id" class="rel-select">
                <option value="">Todas</option>
                <?php foreach ($categorias as $c): ?>
                <option value="<?= $c->idCategorias ?>" <?= $categoria==$c->idCategorias?'selected':'' ?>>
                    <?= htmlspecialchars($c->categoria) ?>
                </option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="rel-filter-item" style="min-width:160px;position:relative;">
            <label class="rel-filter-label">Cliente / Fornecedor</label>
            <input type="text" id="inputClienteForn" name="cliente_fornecedor" class="rel-input" style="min-width:160px;"
                   placeholder="Digite para buscar..." value="<?= htmlspecialchars($cliente_f) ?>" autocomplete="off">
            <ul id="acListaClientes" style="display:none;position:absolute;top:100%;left:0;right:0;background:#252a3a;border:1px solid #444860;border-radius:0 0 8px 8px;z-index:999;margin:0;padding:0;list-style:none;max-height:200px;overflow-y:auto;"></ul>
        </div>
        <div style="display:flex;gap:8px;align-items:flex-end;margin-left:auto;">
            <button type="submit" class="rel-btn rel-btn-filter"><i class='bx bx-filter-alt'></i> Filtrar</button>
            <a href="<?= site_url('relatorios/financeiro') ?>" class="rel-btn rel-btn-print" title="Limpar filtros"><i class='bx bx-x'></i> Limpar</a>
        </div>
    </form>

    <!-- KPIs -->
    <div class="rel-kpis">
        <div class="rel-kpi" style="border-color:rgba(34,197,94,0.3);">
            <div class="rel-kpi-icon" style="background:rgba(34,197,94,0.15);"><i class='bx bx-trending-up' style="color:#22c55e;"></i></div>
            <div>
                <div class="rel-kpi-val" style="font-size:15px;color:#4ade80;">R$ <?= number_format($t->rec_paga??0,2,',','.') ?></div>
                <div class="rel-kpi-label">Receitas Pagas (<?= $t->qt_rec??0 ?>)</div>
            </div>
        </div>
        <div class="rel-kpi" style="border-color:rgba(239,68,68,0.3);">
            <div class="rel-kpi-icon" style="background:rgba(239,68,68,0.15);"><i class='bx bx-trending-down' style="color:#ef4444;"></i></div>
            <div>
                <div class="rel-kpi-val" style="font-size:15px;color:#f87171;">R$ <?= number_format($t->desp_paga??0,2,',','.') ?></div>
                <div class="rel-kpi-label">Despesas Pagas (<?= $t->qt_desp??0 ?>)</div>
            </div>
        </div>
        <div class="rel-kpi" style="border-color:<?= $saldo>=0?'rgba(34,197,94,0.3)':'rgba(239,68,68,0.3)' ?>;">
            <div class="rel-kpi-icon" style="background:rgba(59,130,246,0.15);"><i class='bx bx-wallet' style="color:#60a5fa;"></i></div>
            <div>
                <div class="rel-kpi-val" style="font-size:15px;color:<?= $saldo>=0?'#4ade80':'#f87171' ?>;">R$ <?= number_format($saldo,2,',','.') ?></div>
                <div class="rel-kpi-label">Saldo Líquido</div>
            </div>
        </div>
        <div class="rel-kpi" style="border-color:rgba(245,158,11,0.3);">
            <div class="rel-kpi-icon" style="background:rgba(245,158,11,0.15);"><i class='bx bx-time' style="color:#f59e0b;"></i></div>
            <div>
                <div class="rel-kpi-val" style="font-size:15px;color:#fbbf24;">R$ <?= number_format(($t->rec_pend??0)+($t->desp_pend??0),2,',','.') ?></div>
                <div class="rel-kpi-label">Total Pendente</div>
            </div>
        </div>
    </div>

    <!-- Gráficos -->
    <div class="rel-charts-grid">
        <div class="rel-card">
            <div class="rel-card-head"><i class='bx bx-bar-chart-alt-2' style="color:#fbbf24;"></i><span>Receitas vs Despesas — 12 meses</span></div>
            <div class="rel-card-body"><canvas id="chartFinMes" height="220"></canvas></div>
        </div>
        <div class="rel-card">
            <div class="rel-card-head"><i class='bx bx-pie-chart-alt-2' style="color:#a78bfa;"></i><span>Despesas por Categoria</span></div>
            <div class="rel-card-body"><canvas id="chartCat" height="220"></canvas></div>
        </div>
    </div>

    <!-- Maiores Receitas -->
    <div class="rel-card">
        <div class="rel-card-head">
            <i class='bx bx-trending-up' style="color:#4ade80;"></i><span>Maiores Receitas do Período</span>
            <button onclick="exportarCSV('tblRec','receitas_<?= date('Y-m-d') ?>')" class="rel-btn-export"><i class='bx bx-export'></i> CSV</button>
        </div>
        <div class="rel-card-body" style="padding:0;">
            <table class="rel-tbl" id="tblRec">
                <thead><tr><th>Descrição</th><th>Cliente/Fornecedor</th><th>Vencimento</th><th>Forma Pgto</th><th>Valor</th></tr></thead>
                <tbody>
                <?php if (!empty($maiores_receitas)): foreach ($maiores_receitas as $r): ?>
                <tr>
                    <td style="font-weight:600;color:#e8eaf0;"><?= htmlspecialchars($r->descricao) ?></td>
                    <td style="color:#9ca3af;font-size:12px;"><?= htmlspecialchars($r->cliente_fornecedor??'—') ?></td>
                    <td style="font-size:12px;"><?= date('d/m/Y',strtotime($r->data_vencimento)) ?></td>
                    <td style="font-size:12px;color:#9ca3af;"><?= htmlspecialchars($r->forma_pgto??'—') ?></td>
                    <td style="font-weight:700;color:#4ade80;">R$ <?= number_format($r->valor,2,',','.') ?></td>
                </tr>
                <?php endforeach; else: ?>
                <tr><td colspan="5" class="rel-empty">Nenhuma receita no período.</td></tr>
                <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Maiores Despesas -->
    <div class="rel-card">
        <div class="rel-card-head">
            <i class='bx bx-trending-down' style="color:#f87171;"></i><span>Maiores Despesas do Período</span>
            <button onclick="exportarCSV('tblDesp','despesas_<?= date('Y-m-d') ?>')" class="rel-btn-export"><i class='bx bx-export'></i> CSV</button>
        </div>
        <div class="rel-card-body" style="padding:0;">
            <table class="rel-tbl" id="tblDesp">
                <thead><tr><th>Descrição</th><th>Fornecedor</th><th>Vencimento</th><th>Forma Pgto</th><th>Valor</th></tr></thead>
                <tbody>
                <?php if (!empty($maiores_despesas)): foreach ($maiores_despesas as $r): ?>
                <tr>
                    <td style="font-weight:600;color:#e8eaf0;"><?= htmlspecialchars($r->descricao) ?></td>
                    <td style="color:#9ca3af;font-size:12px;"><?= htmlspecialchars($r->cliente_fornecedor??'—') ?></td>
                    <td style="font-size:12px;"><?= date('d/m/Y',strtotime($r->data_vencimento)) ?></td>
                    <td style="font-size:12px;color:#9ca3af;"><?= htmlspecialchars($r->forma_pgto??'—') ?></td>
                    <td style="font-weight:700;color:#f87171;">R$ <?= number_format($r->valor,2,',','.') ?></td>
                </tr>
                <?php endforeach; else: ?>
                <tr><td colspan="5" class="rel-empty">Nenhuma despesa no período.</td></tr>
                <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Inadimplência -->
    <?php if (!empty($inadimplentes)): ?>
    <div class="rel-card">
        <div class="rel-card-head"><i class='bx bx-error-circle' style="color:#f87171;"></i><span>Inadimplência — Receitas Vencidas</span></div>
        <div class="rel-card-body" style="padding:0;">
            <table class="rel-tbl">
                <thead><tr><th>Cliente</th><th>Descrição</th><th>Vencimento</th><th>Dias em Atraso</th><th>Valor</th></tr></thead>
                <tbody>
                <?php foreach ($inadimplentes as $r): ?>
                <tr>
                    <td style="font-weight:600;color:#e8eaf0;"><?= htmlspecialchars($r->cliente_fornecedor??'—') ?></td>
                    <td style="font-size:12px;color:#9ca3af;"><?= htmlspecialchars($r->descricao) ?></td>
                    <td style="font-size:12px;color:#f87171;"><?= date('d/m/Y',strtotime($r->data_vencimento)) ?></td>
                    <td>
                        <span class="rel-badge <?= $r->dias_atraso > 30 ? 'rb-red' : 'rb-amber' ?>">
                            <?= $r->dias_atraso ?> dias
                        </span>
                    </td>
                    <td style="font-weight:700;color:#f87171;">R$ <?= number_format($r->valor,2,',','.') ?></td>
                </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
    <?php endif; ?>

</div>

<script>
// Receitas vs Despesas por mês
var ctxM = document.getElementById('chartFinMes').getContext('2d');
new Chart(ctxM, {
    type: 'bar',
    data: {
        labels: [<?= implode(',', array_map(fn($r) => '"'.substr($r->mes,5).'/'.substr($r->mes,0,4).'"', $por_mes)) ?>],
        datasets: [
            { label:'Receitas', data:[<?= implode(',', array_map(fn($r) => round($r->receitas,2), $por_mes)) ?>], backgroundColor:'rgba(34,197,94,0.7)', borderRadius:6 },
            { label:'Despesas', data:[<?= implode(',', array_map(fn($r) => round($r->despesas,2), $por_mes)) ?>], backgroundColor:'rgba(239,68,68,0.7)', borderRadius:6 }
        ]
    },
    options: {
        scales: {
            y:{ beginAtZero:true, grid:{color:'rgba(255,255,255,0.05)'}, ticks:{color:'#6b7280', callback: v => 'R$'+v.toLocaleString('pt-BR')} },
            x:{ grid:{display:false}, ticks:{color:'#6b7280'} }
        },
        plugins:{ legend:{ position:'bottom', labels:{color:'#9ca3af',usePointStyle:true} } }
    }
});

// Categorias de despesa
var ctxC = document.getElementById('chartCat').getContext('2d');
new Chart(ctxC, {
    type: 'pie',
    data: {
        labels: [<?= implode(',', array_map(fn($r) => '"'.htmlspecialchars($r->categoria??'Sem categoria').'"', $por_categoria)) ?>],
        datasets: [{
            data: [<?= implode(',', array_map(fn($r) => round($r->total,2), $por_categoria)) ?>],
            backgroundColor: ['#ef4444','#f59e0b','#8b5cf6','#06b6d4','#f97316','#a78bfa','#34d399','#60a5fa','#fbbf24','#e879f9'],
            borderWidth: 0
        }]
    },
    options: { plugins:{ legend:{ position:'bottom', labels:{color:'#9ca3af',usePointStyle:true} } } }
});

// Autocomplete Cliente/Fornecedor
(function() {
    var input = document.getElementById('inputClienteForn');
    var lista = document.getElementById('acListaClientes');
    var timer = null;

    if (!input || !lista) return;

    input.addEventListener('input', function() {
        clearTimeout(timer);
        var term = this.value.trim();
        if (term.length < 2) { lista.style.display = 'none'; return; }
        timer = setTimeout(function() {
            fetch('<?= site_url('clientes/autoCompleteCliente') ?>?term=' + encodeURIComponent(term))
                .then(function(r) { return r.json(); })
                .then(function(data) {
                    lista.innerHTML = '';
                    if (!data || data.length === 0) { lista.style.display = 'none'; return; }
                    data.forEach(function(item) {
                        var li = document.createElement('li');
                        var nome = item.nomeCliente || item.label || item.value || '';
                        li.textContent = nome;
                        li.style.cssText = 'padding:8px 12px;cursor:pointer;color:#e8eaf0;font-size:13px;border-bottom:1px solid rgba(255,255,255,0.05);';
                        li.addEventListener('mouseenter', function() { this.style.background='rgba(251,191,36,0.1)'; });
                        li.addEventListener('mouseleave', function() { this.style.background=''; });
                        li.addEventListener('mousedown', function(e) {
                            e.preventDefault();
                            input.value = nome;
                            lista.style.display = 'none';
                            atualizarBtnPdf();
                        });
                        lista.appendChild(li);
                    });
                    lista.style.display = 'block';
                })
                .catch(function() { lista.style.display = 'none'; });
        }, 300);
    });

    document.addEventListener('click', function(e) {
        if (e.target !== input) lista.style.display = 'none';
    });

    input.addEventListener('blur', function() {
        setTimeout(function() { lista.style.display = 'none'; }, 200);
    });
})();

// Atualiza href do botão PDF com os filtros da tela
(function() {
    function atualizarBtnPdf() {
        var form   = document.getElementById('formFiltros');
        var btn    = document.getElementById('btnPdf');
        if (!form || !btn) return;
        var base   = '<?= site_url('relatorios/financeiroCustom') ?>';
        var params = new URLSearchParams();
        params.set('dataInicial',        form.querySelector('[name=de]').value);
        params.set('dataFinal',          form.querySelector('[name=ate]').value);
        params.set('tipo',               form.querySelector('[name=tipo]').value);
        params.set('situacao',           form.querySelector('[name=situacao]').value);
        params.set('forma_pgto',         form.querySelector('[name=forma_pgto]').value);
        params.set('categoria_id',       form.querySelector('[name=categoria_id]').value);
        params.set('cliente',            form.querySelector('[name=cliente_fornecedor]').value);
        btn.href = base + '?' + params.toString();
    }
    document.addEventListener('DOMContentLoaded', atualizarBtnPdf);
    // Também atualiza ao mudar qualquer campo do filtro
    document.addEventListener('DOMContentLoaded', function() {
        var form = document.getElementById('formFiltros');
        if (form) form.addEventListener('change', atualizarBtnPdf);
        if (form) form.addEventListener('input',  atualizarBtnPdf);
    });
})();

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
