<style>
/* ── Layout geral ── */
.rel-wrap{max-width:1100px;margin:0 auto;padding:20px;}
.rel-header{display:flex;align-items:center;justify-content:space-between;margin-bottom:20px;flex-wrap:wrap;gap:10px;}
.rel-title{font-size:20px;font-weight:800;color:#e8eaf0;display:flex;align-items:center;gap:10px;}

/* ── Filtros ── */
.rel-filtros{background:#1a1d2e;border:1px solid rgba(255,255,255,0.07);border-radius:14px;padding:18px 20px;margin-bottom:20px;}
.rel-filtros-title{font-size:11px;font-weight:700;color:#6b7280;text-transform:uppercase;letter-spacing:.7px;margin-bottom:14px;}
.rel-filtros-grid{display:grid;grid-template-columns:repeat(auto-fill,minmax(180px,1fr));gap:12px;}
.rel-filtros-grid label{font-size:10px;font-weight:700;color:#6b7280;text-transform:uppercase;letter-spacing:.5px;display:block;margin-bottom:5px;}
.rel-filtros-grid input,
.rel-filtros-grid select{background:#252a3a;border:1px solid #444860;color:#e8eaf0;border-radius:8px;padding:8px 10px;font-size:13px;width:100%;box-sizing:border-box;}
.rel-filtros-grid input:focus,
.rel-filtros-grid select:focus{outline:none;border-color:#f97316;}
.rel-filtros-actions{display:flex;gap:10px;margin-top:14px;flex-wrap:wrap;}
.btn-filtrar{display:flex;align-items:center;gap:6px;padding:9px 16px;border-radius:8px;background:linear-gradient(135deg,#f97316,#ea580c);color:#fff;font-size:13px;font-weight:700;border:none;cursor:pointer;}
.btn-limpar{display:flex;align-items:center;gap:6px;padding:9px 16px;border-radius:8px;background:rgba(255,255,255,0.06);color:#9ca3af;font-size:13px;font-weight:700;border:1px solid rgba(255,255,255,0.1);cursor:pointer;text-decoration:none;}
.btn-imprimir{display:flex;align-items:center;gap:6px;padding:9px 16px;border-radius:8px;background:rgba(34,197,94,0.15);color:#4ade80;font-size:13px;font-weight:700;border:1px solid rgba(34,197,94,0.3);cursor:pointer;}

/* ── Cards de totais ── */
.rel-totais{display:flex;gap:12px;margin-bottom:20px;flex-wrap:wrap;}
.rel-total-card{flex:1;min-width:160px;background:#1a1d2e;border:1px solid rgba(255,255,255,0.07);border-radius:12px;padding:14px 16px;}
.rel-total-card small{font-size:10px;font-weight:700;color:#6b7280;text-transform:uppercase;letter-spacing:.7px;display:block;margin-bottom:4px;}
.rel-total-card strong{font-size:18px;font-weight:800;}
.c-green{color:#4ade80;} .c-red{color:#f87171;} .c-blue{color:#60a5fa;} .c-amber{color:#fbbf24;}

/* ── Tabela ── */
.rel-tbl-wrap{background:#1a1d2e;border:1px solid rgba(255,255,255,0.07);border-radius:14px;overflow:hidden;}
.rel-tbl{width:100%;border-collapse:collapse;}
.rel-tbl thead th{background:#252a3a;color:#9ca3af;font-size:11px;font-weight:700;text-transform:uppercase;letter-spacing:.5px;padding:11px 12px;border-bottom:1px solid rgba(255,255,255,0.07);text-align:left;white-space:nowrap;}
.rel-tbl tbody tr{border-bottom:1px solid rgba(255,255,255,0.04);}
.rel-tbl tbody tr:hover{background:rgba(255,255,255,0.02);}
.rel-tbl tbody td{padding:10px 12px;font-size:13px;color:#c4c6d0;vertical-align:middle;}
.sp-rec{color:#4ade80;font-weight:700;font-size:11px;}
.sp-desp{color:#f87171;font-weight:700;font-size:11px;}
.badge-pago{background:rgba(74,222,128,0.15);color:#4ade80;border-radius:6px;padding:3px 8px;font-size:10px;font-weight:700;}
.badge-pend{background:rgba(251,191,36,0.15);color:#fbbf24;border-radius:6px;padding:3px 8px;font-size:10px;font-weight:700;}
.sem-reg{text-align:center;color:#6b7280;padding:40px!important;}

/* ── Impressão ── */
@media print {
    .rel-filtros, .rel-filtros-actions, .btn-imprimir, .btn-filtrar, .btn-limpar,
    .rel-header .btn-imprimir, header, nav, footer, .sidebar,
    [class*="menu"], [class*="topo"], [class*="rodape"] { display:none!important; }
    body, .rel-wrap { background:#fff!important; color:#000!important; }
    .rel-total-card { border:1px solid #ccc!important; background:#f9f9f9!important; }
    .rel-tbl thead th { background:#eee!important; color:#333!important; }
    .rel-tbl tbody tr { border-bottom:1px solid #eee!important; }
    .rel-tbl tbody td, .rel-title { color:#000!important; }
    .sp-rec { color:#16a34a!important; }
    .sp-desp { color:#dc2626!important; }
    .badge-pago { color:#16a34a!important; background:none!important; }
    .badge-pend { color:#d97706!important; background:none!important; }
    .print-header { display:block!important; }
}
.print-header { display:none; }
</style>

<?php
$f       = $filtros;
$meses   = ['','Janeiro','Fevereiro','Março','Abril','Maio','Junho','Julho','Agosto','Setembro','Outubro','Novembro','Dezembro'];
$formasPgto = ['Dinheiro','Pix','Boleto','Cartão de Crédito','Cartão de Débito','Cheque','Cheque Pré-datado','Depósito','Transferência DOC','Transferência TED','Promissória'];
$t = $totais;
?>

<div class="rel-wrap">

    <!-- Cabeçalho de impressão (só aparece ao imprimir) -->
    <div class="print-header" style="margin-bottom:18px;border-bottom:2px solid #333;padding-bottom:10px;">
        <strong style="font-size:18px;">Relatório Financeiro</strong><br>
        <small>Gerado em <?= date('d/m/Y H:i') ?> — Período: <?= $f['vencimento_de'] ?> a <?= $f['vencimento_ate'] ?></small>
    </div>

    <!-- Header -->
    <div class="rel-header">
        <div class="rel-title">
            <i class='bx bx-bar-chart-alt-2' style="color:#f97316;font-size:22px;"></i>
            Relatório Financeiro
        </div>
        <button class="btn-imprimir" onclick="window.print()">
            <i class='bx bx-printer'></i> Imprimir / Exportar PDF
        </button>
    </div>

    <!-- Filtros -->
    <div class="rel-filtros">
        <div class="rel-filtros-title"><i class='bx bx-filter-alt'></i> Filtros</div>
        <form method="get" action="<?= site_url('financeiro/relatorio') ?>">
            <div class="rel-filtros-grid">

                <div>
                    <label>Data Vencimento — De</label>
                    <input type="text" name="vencimento_de" class="datepicker" autocomplete="off"
                           value="<?= htmlspecialchars($f['vencimento_de']) ?>" placeholder="dd/mm/aaaa" />
                </div>

                <div>
                    <label>Data Vencimento — Até</label>
                    <input type="text" name="vencimento_ate" class="datepicker" autocomplete="off"
                           value="<?= htmlspecialchars($f['vencimento_ate']) ?>" placeholder="dd/mm/aaaa" />
                </div>

                <div>
                    <label>Tipo</label>
                    <select name="tipo">
                        <option value="">Todos</option>
                        <option value="receita" <?= strtolower($f['tipo'])==='receita'?'selected':'' ?>>Receita</option>
                        <option value="despesa" <?= strtolower($f['tipo'])==='despesa'?'selected':'' ?>>Despesa</option>
                    </select>
                </div>

                <div>
                    <label>Status</label>
                    <select name="status">
                        <option value="">Todos</option>
                        <option value="1" <?= $f['status']==='1'?'selected':'' ?>>Pago / Recebido</option>
                        <option value="0" <?= $f['status']==='0'?'selected':'' ?>>Pendente</option>
                    </select>
                </div>

                <div>
                    <label>Forma de Pagamento</label>
                    <select name="forma_pgto">
                        <option value="">Todas</option>
                        <?php foreach ($formasPgto as $fp): ?>
                        <option value="<?= $fp ?>" <?= $f['forma_pgto']===$fp?'selected':'' ?>><?= $fp ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div>
                    <label>Cliente / Fornecedor</label>
                    <input type="text" name="cliente"
                           value="<?= htmlspecialchars($f['cliente']) ?>" placeholder="Nome do cliente..." />
                </div>

                <div>
                    <label>Descrição</label>
                    <input type="text" name="descricao"
                           value="<?= htmlspecialchars($f['descricao']) ?>" placeholder="Palavra-chave..." />
                </div>

            </div>
            <div class="rel-filtros-actions">
                <button type="submit" class="btn-filtrar"><i class='bx bx-search'></i> Filtrar</button>
                <a href="<?= site_url('financeiro/relatorio') ?>" class="btn-limpar"><i class='bx bx-x'></i> Limpar filtros</a>
            </div>
        </form>
    </div>

    <!-- Totais -->
    <div class="rel-totais">
        <div class="rel-total-card">
            <small>Receitas Pagas</small>
            <strong class="c-green">R$ <?= number_format(floatval($t->receitas_pagas ?? 0), 2, ',', '.') ?></strong>
        </div>
        <div class="rel-total-card">
            <small>Despesas Pagas</small>
            <strong class="c-red">R$ <?= number_format(floatval($t->despesas_pagas ?? 0), 2, ',', '.') ?></strong>
        </div>
        <div class="rel-total-card">
            <small>Saldo Líquido</small>
            <?php $saldo = floatval($t->receitas_pagas ?? 0) - floatval($t->despesas_pagas ?? 0); ?>
            <strong class="<?= $saldo >= 0 ? 'c-green' : 'c-red' ?>">R$ <?= number_format($saldo, 2, ',', '.') ?></strong>
        </div>
        <div class="rel-total-card">
            <small>Receitas Pendentes</small>
            <strong class="c-amber">R$ <?= number_format(floatval($t->receitas_pendentes ?? 0), 2, ',', '.') ?></strong>
        </div>
        <div class="rel-total-card">
            <small>Despesas Pendentes</small>
            <strong class="c-amber">R$ <?= number_format(floatval($t->despesas_pendentes ?? 0), 2, ',', '.') ?></strong>
        </div>
        <div class="rel-total-card">
            <small>Total de Registros</small>
            <strong class="c-blue"><?= intval($t->total_registros ?? 0) ?></strong>
        </div>
    </div>

    <!-- Tabela -->
    <div class="rel-tbl-wrap">
        <table class="rel-tbl">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Tipo</th>
                    <th>Descrição</th>
                    <th>Cliente / Fornecedor</th>
                    <th>Vencimento</th>
                    <th>Forma Pgto</th>
                    <th>Valor</th>
                    <th>Desconto</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
            <?php if (empty($lancamentos)): ?>
                <tr><td colspan="9" class="sem-reg"><i class='bx bx-search-alt'></i><br>Nenhum lançamento encontrado com os filtros selecionados.</td></tr>
            <?php else: ?>
                <?php foreach ($lancamentos as $l): ?>
                <tr>
                    <td style="color:#6b7280;"><?= $l->idLancamentos ?></td>
                    <td><span class="<?= strtolower($l->tipo)==='receita'?'sp-rec':'sp-desp' ?>"><?= ucfirst(strtolower($l->tipo)) ?></span></td>
                    <td><?= htmlspecialchars($l->descricao) ?></td>
                    <td><?= htmlspecialchars($l->cliente_fornecedor ?? '—') ?></td>
                    <td style="white-space:nowrap;"><?= $l->data_vencimento ? date('d/m/Y', strtotime($l->data_vencimento)) : '—' ?></td>
                    <td><?= htmlspecialchars($l->forma_pgto ?? '—') ?></td>
                    <td style="font-weight:700;color:<?= strtolower($l->tipo)==='receita'?'#4ade80':'#f87171' ?>;">
                        R$ <?= number_format(floatval($l->valor), 2, ',', '.') ?>
                    </td>
                    <td><?= floatval($l->desconto??0) > 0 ? '- R$ '.number_format(floatval($l->desconto),2,',','.') : '—' ?></td>
                    <td>
                        <?php if ($l->baixado): ?>
                            <span class="badge-pago">Pago</span>
                        <?php else: ?>
                            <span class="badge-pend">Pendente</span>
                        <?php endif; ?>
                    </td>
                </tr>
                <?php endforeach; ?>
            <?php endif; ?>
            </tbody>
        </table>
    </div>

</div>

<script>
$(document).ready(function() {
    $(".datepicker").datepicker({ dateFormat: 'dd/mm/yy', changeMonth: true, changeYear: true });
});
</script>
