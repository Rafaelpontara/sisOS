<?php
function _sDate($v, $d) { return ($v && preg_match('/^\d{4}-\d{2}-\d{2}$/', $v)) ? $v : $d; }

$de         = _sDate($this->input->get('de'),  date('Y-m-01'));
$ate        = _sDate($this->input->get('ate'), date('Y-m-d'));
$comissao_p = max(0, min(100, (float)($this->input->get('comissao') ?: 10)));
$tecnico_id = $this->input->get('tecnico_id') ?: '';

// Técnicos para filtro
$tecnicos = $this->db->select('idUsuarios, nome')->get('usuarios')->result();

// Query principal — OS finalizadas/faturadas por técnico no período
$wt = $tecnico_id ? " AND os.usuarios_id = '$tecnico_id'" : '';
$por_tecnico = $this->db->query("
    SELECT
        u.nome                                                                   AS tecnico,
        u.idUsuarios,
        COUNT(os.idOs)                                                           AS total_os,
        SUM(CASE WHEN os.status IN ('Finalizado','Faturado') THEN 1 ELSE 0 END) AS finalizadas,
        SUM(CASE WHEN os.status = 'Cancelado' THEN 1 ELSE 0 END)               AS canceladas,
        SUM(CASE WHEN os.status IN ('Finalizado','Faturado')
            THEN COALESCE(NULLIF(os.valor_desconto, 0),
                 (SELECT COALESCE(SUM(po.preco*po.quantidade),0) FROM produtos_os po WHERE po.os_id=os.idOs) +
                 (SELECT COALESCE(SUM(so.preco*so.quantidade),0) FROM servicos_os so WHERE so.os_id=os.idOs))
            ELSE 0 END)                                                          AS valor_total,
        SUM(CASE WHEN os.status IN ('Finalizado','Faturado')
            THEN (SELECT COALESCE(SUM(po.preco*po.quantidade),0) FROM produtos_os po WHERE po.os_id=os.idOs)
            ELSE 0 END)                                                          AS valor_produtos,
        SUM(CASE WHEN os.status IN ('Finalizado','Faturado')
            THEN (SELECT COALESCE(SUM(so.preco*so.quantidade),0) FROM servicos_os so WHERE so.os_id=os.idOs)
            ELSE 0 END)                                                          AS valor_servicos
    FROM os
    LEFT JOIN usuarios u ON u.idUsuarios = os.usuarios_id
    WHERE os.dataFinal BETWEEN '$de' AND '$ate' $wt
    GROUP BY os.usuarios_id
    ORDER BY valor_total DESC
")->result();

// OS individuais para detalhe
$os_detalhe = $this->db->query("
    SELECT os.idOs, os.status, os.dataFinal,
           c.nomeCliente,
           u.nome AS tecnico,
           os.valor_desconto,
           (SELECT COALESCE(SUM(po.preco*po.quantidade),0) FROM produtos_os po WHERE po.os_id=os.idOs) AS val_produtos,
           (SELECT COALESCE(SUM(so.preco*so.quantidade),0) FROM servicos_os so WHERE so.os_id=os.idOs) AS val_servicos
    FROM os
    LEFT JOIN clientes c  ON c.idClientes  = os.clientes_id
    LEFT JOIN usuarios u  ON u.idUsuarios  = os.usuarios_id
    WHERE os.status IN ('Finalizado','Faturado')
      AND os.dataFinal BETWEEN '$de' AND '$ate' $wt
    ORDER BY u.nome ASC, os.dataFinal DESC
    LIMIT 300
")->result();

$total_geral   = array_sum(array_column($por_tecnico, 'valor_total'));
$total_comissao = $total_geral * ($comissao_p / 100);
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
.rel-btn{display:inline-flex;align-items:center;gap:6px;padding:8px 16px;border-radius:8px;font-size:13px;font-weight:700;border:none;cursor:pointer;transition:all .15s;text-decoration:none;height:36px;}
.rel-btn-filter{background:linear-gradient(135deg,#fbbf24,#b45309);color:#111;}
.rel-btn-print{background:#252a3a;color:#9ca3af;border:1px solid #444860;}
.rel-kpis{display:grid;grid-template-columns:repeat(auto-fill,minmax(180px,1fr));gap:12px;margin-bottom:16px;}
.rel-kpi{background:#1a1d2e;border:1px solid rgba(255,255,255,0.07);border-radius:14px;padding:14px 16px;display:flex;align-items:center;gap:14px;}
.rel-kpi-icon{width:44px;height:44px;border-radius:12px;display:flex;align-items:center;justify-content:center;font-size:20px;flex-shrink:0;}
.rel-kpi-val{font-size:20px;font-weight:800;color:#e8eaf0;line-height:1;margin-bottom:3px;}
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
.rb-blue{background:rgba(96,165,250,0.15);color:#60a5fa;}
.rb-amber{background:rgba(251,191,36,0.15);color:#fbbf24;}
.rb-red{background:rgba(239,68,68,0.15);color:#f87171;}
.rb-purple{background:rgba(167,139,250,0.15);color:#a78bfa;}
.rel-btn-export{display:inline-flex;align-items:center;gap:5px;padding:5px 12px;background:rgba(34,197,94,0.15);color:#4ade80;border:1px solid rgba(34,197,94,0.3);border-radius:7px;font-size:12px;font-weight:700;cursor:pointer;}
/* Barra de progresso */
.bar-wrap{display:flex;align-items:center;gap:8px;}
.bar-track{flex:1;background:rgba(255,255,255,0.07);border-radius:4px;height:6px;min-width:60px;}
.bar-fill{height:6px;border-radius:4px;background:#a78bfa;}
/* Destaque comissão */
.comissao-chip{display:inline-block;padding:3px 10px;border-radius:20px;font-weight:800;font-size:13px;background:rgba(251,191,36,0.15);color:#fbbf24;border:1px solid rgba(251,191,36,0.3);}
@media print{
    .rel-filters,.rel-btn,.rel-btn-export,.new122>*:not(.rel-wrap){display:none!important;}
    .rel-wrap{max-width:100%;}
    .rel-card,.rel-kpi{background:#fff!important;border:1px solid #ddd!important;color:#111!important;}
    .rel-card-head{background:#f5f5f5!important;}
    .rel-tbl thead th,.rel-kpi-label,.rel-card-head span{color:#555!important;}
    .rel-tbl tbody td,.rel-kpi-val{color:#111!important;}
}
</style>

<div class="rel-wrap new122">

    <div class="rel-header">
        <div class="rel-title">
            <i class='bx bx-trophy' style="color:#fbbf24;font-size:24px;"></i>
            <h2>Comissão por Técnico</h2>
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
        <div class="rel-filter-item">
            <label class="rel-filter-label">% Comissão</label>
            <div style="display:flex;align-items:center;gap:6px;">
                <input type="number" name="comissao" class="rel-input" style="width:80px;"
                       min="0" max="100" step="0.5" value="<?= $comissao_p ?>">
                <span style="color:#9ca3af;font-size:13px;">%</span>
            </div>
        </div>
        <button type="submit" class="rel-btn rel-btn-filter">
            <i class='bx bx-filter-alt'></i> Calcular
        </button>
    </form>

    <!-- KPIs -->
    <div class="rel-kpis">
        <div class="rel-kpi" style="border-color:rgba(167,139,250,0.3);">
            <div class="rel-kpi-icon" style="background:rgba(167,139,250,0.15);"><i class='bx bx-user' style="color:#a78bfa;"></i></div>
            <div><div class="rel-kpi-val"><?= count($por_tecnico) ?></div><div class="rel-kpi-label">Técnicos</div></div>
        </div>
        <div class="rel-kpi" style="border-color:rgba(34,197,94,0.3);">
            <div class="rel-kpi-icon" style="background:rgba(34,197,94,0.15);"><i class='bx bx-check-circle' style="color:#22c55e;"></i></div>
            <div>
                <div class="rel-kpi-val"><?= array_sum(array_column($por_tecnico,'finalizadas')) ?></div>
                <div class="rel-kpi-label">OS Finalizadas</div>
            </div>
        </div>
        <div class="rel-kpi" style="border-color:rgba(96,165,250,0.3);">
            <div class="rel-kpi-icon" style="background:rgba(96,165,250,0.15);"><i class='bx bx-dollar-circle' style="color:#60a5fa;"></i></div>
            <div>
                <div class="rel-kpi-val" style="font-size:14px;">R$ <?= number_format($total_geral,2,',','.') ?></div>
                <div class="rel-kpi-label">Total Faturado</div>
            </div>
        </div>
        <div class="rel-kpi" style="border-color:rgba(251,191,36,0.3);">
            <div class="rel-kpi-icon" style="background:rgba(251,191,36,0.15);"><i class='bx bx-medal' style="color:#fbbf24;"></i></div>
            <div>
                <div class="rel-kpi-val" style="font-size:14px;color:#fbbf24;">R$ <?= number_format($total_comissao,2,',','.') ?></div>
                <div class="rel-kpi-label">Total Comissão (<?= $comissao_p ?>%)</div>
            </div>
        </div>
    </div>

    <!-- Tabela por técnico -->
    <?php if (!empty($por_tecnico)): ?>
    <div class="rel-card" style="margin-bottom:14px;">
        <div class="rel-card-head">
            <i class='bx bx-bar-chart-alt-2' style="color:#fbbf24;"></i>
            <span>Resumo por Técnico — Comissão de <?= $comissao_p ?>%</span>
            <button onclick="exportarCSV('tblComissao','comissao_<?= date('Y-m-d') ?>')" class="rel-btn-export">
                <i class='bx bx-export'></i> CSV
            </button>
        </div>
        <div style="overflow-x:auto;">
        <table class="rel-tbl" id="tblComissao" style="min-width:700px;">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Técnico</th>
                    <th class="c">OS Total</th>
                    <th class="c">Finalizadas</th>
                    <th class="r">Val. Serviços</th>
                    <th class="r">Val. Produtos</th>
                    <th class="r">Total Faturado</th>
                    <th class="r" style="color:#fbbf24;">Comissão (<?= $comissao_p ?>%)</th>
                    <th class="c">% do Total</th>
                </tr>
            </thead>
            <tbody>
            <?php foreach ($por_tecnico as $i => $t):
                $comissao_tecnico = $t->valor_total * ($comissao_p / 100);
                $pct = $total_geral > 0 ? round($t->valor_total / $total_geral * 100, 1) : 0;
            ?>
            <tr>
                <td style="color:#6b7280;font-size:12px;"><?= $i+1 ?>º</td>
                <td style="font-weight:700;color:#e8eaf0;"><?= htmlspecialchars($t->tecnico ?? 'N/A') ?></td>
                <td class="c"><span class="rel-badge rb-blue"><?= $t->total_os ?></span></td>
                <td class="c"><span class="rel-badge rb-green"><?= $t->finalizadas ?></span></td>
                <td class="r" style="color:#a78bfa;">R$ <?= number_format($t->valor_servicos,2,',','.') ?></td>
                <td class="r" style="color:#60a5fa;">R$ <?= number_format($t->valor_produtos,2,',','.') ?></td>
                <td class="r" style="font-weight:700;color:#e8eaf0;">R$ <?= number_format($t->valor_total,2,',','.') ?></td>
                <td class="r">
                    <span class="comissao-chip">R$ <?= number_format($comissao_tecnico,2,',','.') ?></span>
                </td>
                <td class="c">
                    <div class="bar-wrap">
                        <div class="bar-track">
                            <div class="bar-fill" style="width:<?= $pct ?>%;"></div>
                        </div>
                        <span style="font-size:11px;color:#9ca3af;min-width:32px;"><?= $pct ?>%</span>
                    </div>
                </td>
            </tr>
            <?php endforeach; ?>
            </tbody>
            <tfoot>
                <tr style="background:#252a3a;border-top:2px solid #4f46e5;">
                    <td colspan="2" style="padding:10px 14px;font-weight:800;color:#e8eaf0;font-size:11px;text-transform:uppercase;">Total Geral</td>
                    <td style="padding:10px 14px;text-align:center;font-weight:700;color:#e8eaf0;"><?= array_sum(array_column($por_tecnico,'total_os')) ?></td>
                    <td style="padding:10px 14px;text-align:center;font-weight:700;color:#e8eaf0;"><?= array_sum(array_column($por_tecnico,'finalizadas')) ?></td>
                    <td style="padding:10px 14px;text-align:right;color:#a78bfa;font-weight:700;">R$ <?= number_format(array_sum(array_column($por_tecnico,'valor_servicos')),2,',','.') ?></td>
                    <td style="padding:10px 14px;text-align:right;color:#60a5fa;font-weight:700;">R$ <?= number_format(array_sum(array_column($por_tecnico,'valor_produtos')),2,',','.') ?></td>
                    <td style="padding:10px 14px;text-align:right;color:#e8eaf0;font-weight:800;">R$ <?= number_format($total_geral,2,',','.') ?></td>
                    <td style="padding:10px 14px;text-align:right;"><span class="comissao-chip">R$ <?= number_format($total_comissao,2,',','.') ?></span></td>
                    <td></td>
                </tr>
            </tfoot>
        </table>
        </div>
    </div>

    <!-- Detalhe por OS -->
    <?php if (!empty($os_detalhe)): ?>
    <div class="rel-card">
        <div class="rel-card-head">
            <i class='bx bx-list-ul' style="color:#6366f1;"></i>
            <span>OS por Técnico — Detalhado</span>
            <button onclick="exportarCSV('tblDetalhe','comissao_detalhe_<?= date('Y-m-d') ?>')" class="rel-btn-export">
                <i class='bx bx-export'></i> CSV
            </button>
        </div>
        <div style="overflow-x:auto;">
        <table class="rel-tbl" id="tblDetalhe" style="min-width:700px;">
            <thead>
                <tr>
                    <th>OS</th>
                    <th>Técnico</th>
                    <th>Cliente</th>
                    <th class="c">Data Saída</th>
                    <th class="r">Serviços</th>
                    <th class="r">Produtos</th>
                    <th class="r">Total</th>
                    <th class="r" style="color:#fbbf24;">Comissão</th>
                </tr>
            </thead>
            <tbody>
            <?php foreach ($os_detalhe as $r):
                $total_os  = $r->valor_desconto > 0 ? $r->valor_desconto : ($r->val_servicos + $r->val_produtos);
                $com_os    = $total_os * ($comissao_p / 100);
            ?>
            <tr>
                <td style="color:#9ca3af;font-size:12px;">
                    <a href="<?= site_url('os/visualizar/'.$r->idOs) ?>" style="color:#60a5fa;text-decoration:none;">
                        #<?= str_pad($r->idOs,4,'0',STR_PAD_LEFT) ?>
                    </a>
                </td>
                <td style="font-weight:600;color:#e8eaf0;"><?= htmlspecialchars($r->tecnico ?? '—') ?></td>
                <td style="color:#c9cad6;"><?= htmlspecialchars($r->nomeCliente ?? '—') ?></td>
                <td class="c" style="font-size:12px;color:#9ca3af;"><?= $r->dataFinal ? date('d/m/Y',strtotime($r->dataFinal)) : '—' ?></td>
                <td class="r" style="color:#a78bfa;">R$ <?= number_format($r->val_servicos,2,',','.') ?></td>
                <td class="r" style="color:#60a5fa;">R$ <?= number_format($r->val_produtos,2,',','.') ?></td>
                <td class="r" style="font-weight:600;">R$ <?= number_format($total_os,2,',','.') ?></td>
                <td class="r"><span class="comissao-chip" style="font-size:12px;">R$ <?= number_format($com_os,2,',','.') ?></span></td>
            </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
        </div>
    </div>
    <?php endif; ?>
    <?php else: ?>
    <div style="text-align:center;padding:60px;color:#6b7280;">
        <i class='bx bx-bar-chart-alt-2' style="font-size:48px;display:block;margin-bottom:12px;"></i>
        Nenhuma OS finalizada no período selecionado.
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
    var a = document.createElement('a'); a.href=URL.createObjectURL(blob); a.download=nome+'.csv'; a.click();
}
</script>
