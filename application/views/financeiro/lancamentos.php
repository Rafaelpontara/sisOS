<link rel="stylesheet" href="<?php echo base_url(); ?>assets/js/jquery-ui/css/smoothness/jquery-ui-1.9.2.custom.css" />
<script src="<?php echo base_url() ?>assets/js/jquery-ui/js/jquery-ui-1.9.2.custom.js"></script>
<script src="<?php echo base_url() ?>assets/js/sweetalert2.all.min.js"></script>
<script src="<?php echo base_url() ?>assets/js/dayjs.min.js"></script>

<?php $situacao = $this->input->get('situacao'); $periodo = $this->input->get('periodo'); ?>

<style>
.pg-header{display:flex;justify-content:space-between;align-items:center;margin-bottom:20px;flex-wrap:wrap;gap:10px;}
.pg-title{font-size:22px;font-weight:800;color:#e8eaf0;display:flex;align-items:center;gap:10px;}
.pg-title i{font-size:24px;color:#fbbf24;}
.btn-add{display:flex;align-items:center;gap:7px;padding:9px 16px;border-radius:8px;background:linear-gradient(135deg,#22c55e,#16a34a);color:#fff;font-size:13px;font-weight:700;text-decoration:none;border:none;cursor:pointer;box-shadow:0 4px 14px rgba(34,197,94,0.3);transition:transform .15s;}
.btn-add:hover{transform:translateY(-2px);color:#fff;}
.btn-add i{font-size:18px;}
.filter-card{background:#1a1d2e;border:1px solid rgba(255,255,255,0.07);border-radius:14px;padding:14px 18px;margin-bottom:16px;}
.filter-row{display:flex;gap:10px;align-items:flex-end;flex-wrap:wrap;}
.filter-col{display:flex;flex-direction:column;gap:5px;}
.filter-lbl{font-size:10px;font-weight:700;color:#6b7280;text-transform:uppercase;letter-spacing:.6px;}
.filter-col input,.filter-col select{padding:8px 10px;border-radius:7px;border:1px solid #444860;background:#252a3a;color:#e8eaf0;font-size:13px;min-width:120px;}
.filter-col input:focus,.filter-col select:focus{outline:none;border-color:#fbbf24;}
.btn-filter{padding:8px 20px;border-radius:7px;background:#fbbf24;border:none;color:#111;font-size:13px;font-weight:700;cursor:pointer;transition:background .15s;height:37px;align-self:flex-end;}
.btn-filter:hover{background:#f59e0b;}
/* Table */
.tbl-wrap{background:#1a1d2e;border:1px solid rgba(255,255,255,0.07);border-radius:14px;overflow:hidden;margin-bottom:14px;}
.tbl-wrap table{width:100%;border-collapse:collapse;}
.tbl-wrap thead th{background:#252a3a;color:#9ca3af;font-size:11px;font-weight:700;text-transform:uppercase;letter-spacing:.5px;padding:11px 12px;border-bottom:1px solid rgba(255,255,255,0.07);white-space:nowrap;}
.tbl-wrap tbody tr{border-bottom:1px solid rgba(255,255,255,0.04);transition:background .12s;}
.tbl-wrap tbody tr:hover{background:rgba(251,191,36,0.04);}
.tbl-wrap tbody td{padding:10px 12px;font-size:13px;color:#c9cad6;vertical-align:middle;}
.tipo-r{color:#4ade80;font-weight:700;font-size:11px;}.tipo-d{color:#f87171;font-weight:700;font-size:11px;}
.pago-pill{padding:2px 9px;border-radius:20px;font-size:11px;font-weight:700;}
.pago-sim{background:rgba(34,197,94,0.15);color:#4ade80;}
.pago-nao{background:rgba(245,158,11,0.15);color:#fbbf24;}
.act-btns{display:flex;gap:4px;}
.act-btn{width:28px;height:28px;border-radius:6px;display:inline-flex;align-items:center;justify-content:center;font-size:14px;text-decoration:none;transition:all .12s;border:none;cursor:pointer;}
.act-btn:hover{transform:scale(1.1);}
.ab-e{background:rgba(34,197,94,0.15);color:#4ade80;}.ab-e:hover{background:rgba(34,197,94,0.3);color:#4ade80;}
.ab-d{background:rgba(239,68,68,0.15);color:#f87171;}.ab-d:hover{background:rgba(239,68,68,0.3);color:#f87171;}
.ab-b{background:rgba(96,165,250,0.15);color:#60a5fa;}.ab-b:hover{background:rgba(96,165,250,0.3);color:#60a5fa;}
/* Totals */
.totals-row{display:flex;gap:12px;padding:14px 16px;border-top:1px solid rgba(255,255,255,0.06);}
.total-card{flex:1;background:#252a3a;border-radius:10px;padding:10px 14px;}
.total-card .t-label{font-size:11px;color:#6b7280;font-weight:600;text-transform:uppercase;letter-spacing:.5px;}
.total-card .t-value{font-size:18px;font-weight:800;margin-top:4px;}
.t-green{color:#4ade80;}.t-red{color:#f87171;}.t-white{color:#e8eaf0;}
/* Stats section */
.stats-card{background:#1a1d2e;border:1px solid rgba(255,255,255,0.07);border-radius:14px;padding:16px 20px;margin-top:14px;}
.stats-title{font-size:12px;font-weight:700;color:#6b7280;text-transform:uppercase;letter-spacing:.8px;margin-bottom:12px;padding-bottom:8px;border-bottom:1px solid rgba(255,255,255,0.06);}
.stats-row{display:flex;justify-content:space-between;align-items:center;padding:7px 0;border-bottom:1px solid rgba(255,255,255,0.04);}
.stats-row:last-child{border-bottom:none;}
.stats-row .s-label{font-size:13px;color:#9ca3af;}
.stats-row .s-value{font-size:13px;font-weight:700;}
label.error{color:#f87171;} input.error{border-color:#f87171;} input.valid{border-color:#4ade80;} textarea{resize:vertical;}

/* ── OVERRIDE Bootstrap 2 modal azul ── */
#modalReceita,#modalReceitaParcelada,#modalEditar,#modalExcluir{
    border-radius:14px!important;overflow:hidden!important;
    border:1px solid rgba(255,255,255,0.1)!important;
    box-shadow:0 24px 60px rgba(0,0,0,0.7)!important;
}
#modalReceita .modal-header,
#modalReceitaParcelada .modal-header,
#modalEditar .modal-header,
#modalExcluir .modal-header{
    background:#1a1d2e!important;background-image:none!important;
    border-bottom:1px solid rgba(255,255,255,0.08)!important;
    padding:16px 20px!important;
    display:flex!important;align-items:center!important;justify-content:space-between!important;
}
#modalReceita .modal-header h4,
#modalReceitaParcelada .modal-header h4,
#modalEditar .modal-header h4,
#modalExcluir .modal-header h4{
    margin:0!important;font-size:15px!important;font-weight:800!important;
    color:#e8eaf0!important;text-shadow:none!important;
    display:flex!important;align-items:center!important;gap:8px!important;
}
#modalReceita .modal-header .close,
#modalReceitaParcelada .modal-header .close,
#modalEditar .modal-header .close,
#modalExcluir .modal-header .close{
    color:#9ca3af!important;opacity:1!important;text-shadow:none!important;
    font-size:20px!important;margin-top:0!important;float:none!important;
}
#modalReceita .modal-body,
#modalReceitaParcelada .modal-body,
#modalEditar .modal-body,
#modalExcluir .modal-body{background:#13151f!important;padding:20px!important;}
#modalReceita .modal-footer,
#modalReceitaParcelada .modal-footer,
#modalEditar .modal-footer,
#modalExcluir .modal-footer{
    background:#1a1d2e!important;background-image:none!important;
    border-top:1px solid rgba(255,255,255,0.08)!important;
    padding:12px 20px!important;
    display:flex!important;justify-content:flex-end!important;gap:8px!important;
}
/* inputs/selects/textareas dentro dos modais */
#modalReceita input, #modalReceita select, #modalReceita textarea,
#modalReceitaParcelada input, #modalReceitaParcelada select, #modalReceitaParcelada textarea,
#modalEditar input, #modalEditar select, #modalEditar textarea{
    background:#1e2133!important;border:1px solid #444860!important;
    color:#e8eaf0!important;border-radius:8px!important;
    padding:8px 12px!important;font-size:13px!important;
    box-sizing:border-box!important;width:100%!important;
    -webkit-appearance:none!important;
}
#modalReceita input[type=checkbox],
#modalReceitaParcelada input[type=checkbox],
#modalEditar input[type=checkbox]{
    width:16px!important;height:16px!important;padding:0!important;
    accent-color:#6366f1!important;flex-shrink:0!important;
}
#modalReceita select,#modalReceitaParcelada select,#modalEditar select{height:36px!important;}
#modalReceita textarea,#modalReceitaParcelada textarea,#modalEditar textarea{min-height:70px!important;resize:vertical!important;}
#modalReceita input:focus,#modalReceita select:focus,#modalReceita textarea:focus,
#modalReceitaParcelada input:focus,#modalReceitaParcelada select:focus,
#modalEditar input:focus,#modalEditar select:focus,#modalEditar textarea:focus{
    border-color:#6366f1!important;outline:none!important;
}
</style>

<div class="new122">
    <div class="pg-header">
        <div class="pg-title"><i class='bx bx-bar-chart-alt-2'></i> Lançamentos Financeiros</div>
        <?php if ($this->permission->checkPermission($this->session->userdata('permissao'), 'aLancamento')): ?>
        <a href="#modalReceita" data-toggle="modal" role="button" class="btn-add">
            <i class='bx bx-plus-circle'></i> Receita/Despesa
        </a>
        <?php endif; ?>
    </div>

    <!-- Filtros -->
    <div class="filter-card">
        <form action="<?= current_url() ?>" method="get">
            <div class="filter-row">
                <div class="filter-col">
                    <span class="filter-lbl">Período</span>
                    <select id="periodo" name="periodo">
                        <option value="dia" <?= $this->input->get('periodo')=='dia'?'selected':'' ?>>Dia</option>
                        <option value="semana" <?= $this->input->get('periodo')=='semana'?'selected':'' ?>>Semana</option>
                        <option value="mesAnterior" <?= $this->input->get('periodo')=='mesAnterior'?'selected':'' ?>>Mês Anterior</option>
                        <option value="mes" <?= $this->input->get('periodo')=='mes'?'selected':'' ?>>Mês</option>
                        <option value="mesPosterior" <?= $this->input->get('periodo')=='mesPosterior'?'selected':'' ?>>Mês Posterior</option>
                        <option value="ano" <?= $this->input->get('periodo')=='ano'?'selected':'' ?>>Ano</option>
                        <option value="personalizado" <?= $this->input->get('periodo')=='personalizado'?'selected':'' ?>>Personalizado</option>
                    </select>
                </div>
                <div class="filter-col">
                    <span class="filter-lbl">Vencimento (de)</span>
                    <input id="vencimento_de" type="text" class="datepicker" name="vencimento_de" value="<?= $this->input->get('vencimento_de') ?: date('d/m/Y') ?>">
                </div>
                <div class="filter-col">
                    <span class="filter-lbl">Vencimento (até)</span>
                    <input id="vencimento_ate" type="text" class="datepicker" name="vencimento_ate" value="<?= $this->input->get('vencimento_ate') ?: date('d/m/Y') ?>">
                </div>
                <div class="filter-col">
                    <span class="filter-lbl">Tipo</span>
                    <select name="tipo">
                        <option value="">Todos</option>
                        <option value="receita" <?= $this->input->get('tipo')=='receita'?'selected':'' ?>>Receita</option>
                        <option value="despesa" <?= $this->input->get('tipo')=='despesa'?'selected':'' ?>>Despesa</option>
                    </select>
                </div>
                <div class="filter-col">
                    <span class="filter-lbl">Status</span>
                    <select name="status">
                        <option value="">Todos (Pendente e Pago)</option>
                        <option value="0" <?= $this->input->get('status')=='0'?'selected':'' ?>>Pendente</option>
                        <option value="1" <?= $this->input->get('status')=='1'?'selected':'' ?>>Pago</option>
                    </select>
                </div>
                <div class="filter-col">
                    <span class="filter-lbl">Cliente/Fornecedor</span>
                    <input id="cliente_busca" type="text" name="cliente" value="<?= $this->input->get('cliente') ?>">
                </div>
                <button type="submit" class="btn-filter"><i class='bx bx-filter-alt'></i> Filtrar</button>
            </div>
        </form>
    </div>

    <!-- Tabela -->
    <div class="tbl-wrap">
        <table id="divLancamentos" class="table">
            <thead>
                <tr>
                    <th>#</th><th>Tipo</th><th>Cliente/Fornecedor</th><th>Descrição</th>
                    <th>Vencimento</th><th>Status</th><th>Observações</th>
                    <th>Forma Pgto</th><th>Valor (+)</th><th>Desconto (-)</th>
                    <th>Valor Total (=)</th><th>Ações</th>
                </tr>
            </thead>
            <tbody>
            <?php
            if (isset($lancamentos) && $lancamentos) {
                foreach ($lancamentos as $r) {
                    $data_pagamento = $r->data_pagamento ? date('d/m/Y', strtotime($r->data_pagamento)) : '-';
                    echo '<tr>';
                    echo '<td style="color:#6b7280;font-size:12px;">' . $r->idLancamentos . '</td>';
                    echo '<td><span class="' . ($r->tipo=='receita'?'tipo-r':'tipo-d') . '">' . ucfirst($r->tipo) . '</span></td>';
                    echo '<td style="font-weight:600;color:#e8eaf0;">' . htmlspecialchars($r->cliente_fornecedor ?? '-') . '</td>';
                    echo '<td style="max-width:150px;overflow:hidden;text-overflow:ellipsis;white-space:nowrap;">' . htmlspecialchars($r->descricao) . '</td>';
                    echo '<td style="font-size:12px;">' . date('d/m/Y', strtotime($r->data_vencimento)) . '</td>';
                    echo '<td><span class="pago-pill ' . ($r->baixado?'pago-sim':'pago-nao') . '">' . ($r->baixado?'Pago':'Pendente') . '</span></td>';
                    echo '<td style="font-size:12px;color:#9ca3af;">' . htmlspecialchars($r->observacoes ?? '') . '</td>';
                    echo '<td style="font-size:12px;color:#9ca3af;">' . htmlspecialchars($r->forma_pgto ?? '') . '</td>';
                    echo '<td style="color:#4ade80;font-weight:600;">R$ ' . number_format($r->valor, 2, ',', '.') . '</td>';
                    echo '<td style="color:#f87171;">R$ ' . number_format($r->desconto ?? 0, 2, ',', '.') . '</td>';
                    echo '<td style="font-weight:700;color:#e8eaf0;">R$ ' . number_format($r->valor_desconto ?? $r->valor, 2, ',', '.') . '</td>';
                    echo '<td><div class="act-btns">';
                    if ($this->permission->checkPermission($this->session->userdata('permissao'), 'eLancamento'))
                        echo '<a href="#modalEditar" data-toggle="modal" role="button" idLancamento="' . $r->idLancamentos . '" descricao="' . htmlspecialchars($r->descricao) . '" valor="' . $r->valor . '" vencimento="' . date('d/m/Y', strtotime($r->data_vencimento)) . '" pagamento="' . $data_pagamento . '" baixado="' . $r->baixado . '" cliente="' . htmlspecialchars($r->cliente_fornecedor ?? '') . '" formaPgto="' . htmlspecialchars($r->forma_pgto ?? '') . '" tipo="' . $r->tipo . '" observacoes="' . htmlspecialchars($r->observacoes ?? '') . '" descontos_editar="' . ($r->desconto ?? 0) . '" valor_desconto_editar="' . ($r->valor_desconto != 0 ? $r->valor_desconto : $r->valor) . '" usuario="' . htmlspecialchars($r->nome ?? '') . '" class="act-btn ab-e editar" title="Editar"><i class="bx bx-edit"></i></a>';
                    if (!$r->baixado && $this->permission->checkPermission($this->session->userdata('permissao'), 'eLancamento'))
                        echo '<a href="#modalBaixar" data-toggle="modal" role="button" idLancamento="' . $r->idLancamentos . '" class="act-btn ab-b baixar" title="Dar Baixa"><i class="bx bx-check"></i></a>';
                    if ($this->permission->checkPermission($this->session->userdata('permissao'), 'dLancamento'))
                        echo '<a href="#modalExcluir" data-toggle="modal" role="button" idLancamento="' . $r->idLancamentos . '" class="act-btn ab-d excluir" title="Excluir"><i class="bx bx-trash-alt"></i></a>';
                    echo '</div></td></tr>';
                }
            } else {
                echo '<tr><td colspan="12" style="text-align:center;padding:30px;color:#6b7280;">Nenhum lançamento encontrado</td></tr>';
            } ?>
            </tbody>
        </table>

        <!-- Totais -->
        <?php if (isset($total_receitas) || isset($total_despesas)): ?>
        <div class="totals-row">
            <div class="total-card">
                <div class="t-label">Total Receitas</div>
                <div class="t-value t-green">R$ <?= number_format($total_receitas ?? 0, 2, ',', '.') ?></div>
            </div>
            <div class="total-card">
                <div class="t-label">Total Despesas</div>
                <div class="t-value t-red">R$ <?= number_format($total_despesas ?? 0, 2, ',', '.') ?></div>
            </div>
            <div class="total-card">
                <div class="t-label">Saldo</div>
                <?php $saldo = ($total_receitas ?? 0) - ($total_despesas ?? 0); ?>
                <div class="t-value <?= $saldo >= 0 ? 't-green' : 't-red' ?>">R$ <?= number_format($saldo, 2, ',', '.') ?></div>
            </div>
        </div>
        <?php endif; ?>
    </div>

    <!-- Estatísticas -->
    <?php if (isset($estatisticas_financeiro)): ?>
    <?php
        $e = $estatisticas_financeiro;
        $rec   = floatval($e->total_receita ?? 0);
        $desp  = floatval($e->total_despesa ?? 0);
        $recP  = floatval($e->total_receita_pendente ?? 0);
        $despP = floatval($e->total_despesa_pendente ?? 0);
        $saldo = $rec - $desp;
        $somaRD = $rec + $desp;
        $subPend = $recP - $despP;
        $somaPend = $recP + $despP;
        $descPago = floatval($e->total_valor_desconto ?? 0);
        $descPend = floatval($e->total_valor_desconto_pendente ?? 0);
        $descTotal = $descPago + $descPend;
        $recSemDesc = floatval($e->total_receita_sem_desconto ?? 0);
        $despSemDesc = floatval($e->total_despesa_sem_desconto ?? 0);
    ?>
    <div class="stats-card">
        <div class="stats-title"><i class='bx bx-stats'></i> Estatísticas Gerais do Financeiro</div>

        <div class="stats-row">
            <span class="s-label">Total Receitas (Pagas)</span>
            <span class="s-value t-green">R$ <?= number_format($rec, 2, ',', '.') ?></span>
        </div>
        <div class="stats-row">
            <span class="s-label">Total Despesas (Pagas)</span>
            <span class="s-value t-red">R$ <?= number_format($desp, 2, ',', '.') ?></span>
        </div>
        <div class="stats-row" style="background:rgba(255,255,255,0.03);border-radius:6px;padding:8px 6px;">
            <span class="s-label" style="font-weight:700;color:#e8eaf0;">Total Receitas (-) Despesas = Saldo Líquido</span>
            <span class="s-value <?= $saldo >= 0 ? 't-green' : 't-red' ?>" style="font-size:15px;">R$ <?= number_format($saldo, 2, ',', '.') ?></span>
        </div>
        <div class="stats-row">
            <span class="s-label">Total Receitas (+) Despesas</span>
            <span class="s-value t-white">R$ <?= number_format($somaRD, 2, ',', '.') ?></span>
        </div>
        <div class="stats-row">
            <span class="s-label">Total Receitas Pendentes</span>
            <span class="s-value" style="color:#fbbf24;">R$ <?= number_format($recP, 2, ',', '.') ?></span>
        </div>
        <div class="stats-row">
            <span class="s-label">Total Despesas Pendentes</span>
            <span class="s-value" style="color:#fbbf24;">R$ <?= number_format($despP, 2, ',', '.') ?></span>
        </div>
        <div class="stats-row">
            <span class="s-label">Total de Receitas Pendentes (-) Despesas Pendentes</span>
            <span class="s-value <?= $subPend >= 0 ? 't-green' : 't-red' ?>">R$ <?= number_format($subPend, 2, ',', '.') ?></span>
        </div>
        <div class="stats-row" style="background:rgba(255,255,255,0.03);border-radius:6px;padding:8px 6px;">
            <span class="s-label" style="font-weight:700;color:#e8eaf0;">Total de Receitas Pendentes (+) Despesas Pendentes</span>
            <span class="s-value" style="color:#fbbf24;font-size:15px;">R$ <?= number_format($somaPend, 2, ',', '.') ?></span>
        </div>
        <div class="stats-row">
            <span class="s-label">Total de Descontos aplicados á lançamentos Pagos</span>
            <span class="s-value" style="color:#a78bfa;">R$ <?= number_format($descPago, 2, ',', '.') ?></span>
        </div>
        <div class="stats-row">
            <span class="s-label">Total de Descontos aplicados á lançamentos Pendentes</span>
            <span class="s-value" style="color:#a78bfa;">R$ <?= number_format($descPend, 2, ',', '.') ?></span>
        </div>
        <div class="stats-row" style="background:rgba(255,255,255,0.03);border-radius:6px;padding:8px 6px;">
            <span class="s-label" style="font-weight:700;color:#e8eaf0;">Total de descontos aplicados (pagos + pendentes)</span>
            <span class="s-value" style="color:#a78bfa;font-size:15px;">R$ <?= number_format($descTotal, 2, ',', '.') ?></span>
        </div>
        <div class="stats-row">
            <span class="s-label">Total de Receitas sem descontos aplicados (pagos + pendentes)</span>
            <span class="s-value t-green">R$ <?= number_format($recSemDesc, 2, ',', '.') ?></span>
        </div>
        <div class="stats-row">
            <span class="s-label">Total de Despesas sem descontos aplicados (pagos + pendentes)</span>
            <span class="s-value t-red">R$ <?= number_format($despSemDesc, 2, ',', '.') ?></span>
        </div>
    </div>
    <?php endif; ?>

</div>

<style>
/* ── Modal dark shared ── */
.md-dark{background:#13151f!important;}
.md-dark .modal-header{background:#1a1d2e!important;border-bottom:1px solid rgba(255,255,255,0.08)!important;padding:16px 20px!important;display:flex!important;align-items:center!important;justify-content:space-between!important;}
.md-dark .modal-header h4{margin:0!important;font-size:16px!important;font-weight:800!important;color:#e8eaf0!important;display:flex!important;align-items:center!important;gap:8px!important;}
.md-dark .modal-header .close{color:#9ca3af!important;font-size:20px!important;opacity:1!important;}
.md-dark .modal-body{background:#13151f!important;padding:20px!important;}
.md-dark .modal-footer{background:#1a1d2e!important;border-top:1px solid rgba(255,255,255,0.08)!important;padding:12px 20px!important;display:flex!important;justify-content:flex-end!important;gap:8px!important;}
.md-label{font-size:11px!important;font-weight:700!important;color:#9ca3af!important;text-transform:uppercase!important;letter-spacing:.5px!important;display:block!important;margin-bottom:5px!important;margin-top:0!important;}
.md-input,.md-select,.md-textarea{width:100%!important;background:#1e2133!important;border:1px solid #444860!important;color:#e8eaf0!important;border-radius:8px!important;padding:8px 12px!important;font-size:13px!important;box-sizing:border-box!important;transition:border-color .15s!important;float:none!important;}
.md-input:focus,.md-select:focus,.md-textarea:focus{border-color:#6366f1!important;outline:none!important;}
.md-select{height:36px!important;}
.md-textarea{min-height:70px!important;resize:vertical!important;}
.md-row{display:flex!important;gap:12px!important;flex-wrap:wrap!important;margin-bottom:12px!important;}
.md-row > .md-col{flex:1!important;min-width:140px!important;}
.md-info{background:rgba(99,102,241,0.1);border:1px solid rgba(99,102,241,0.3);border-radius:8px;padding:9px 13px;font-size:12px;color:#a5b4fc;margin-bottom:14px;display:flex;align-items:center;gap:7px;}
.md-check-row{display:flex!important;align-items:center!important;gap:8px!important;padding:8px 0!important;}
.md-check-row input[type=checkbox]{width:16px!important;height:16px!important;accent-color:#6366f1!important;margin:0!important;}
.md-check-row label{font-size:13px!important;color:#c9cad6!important;font-weight:500!important;margin:0!important;text-transform:none!important;letter-spacing:0!important;}
.md-divider{border:none!important;border-top:1px solid rgba(255,255,255,0.06)!important;margin:12px 0!important;}
.md-parc-summary{background:#1e2133;border:1px solid #444860;border-radius:8px;padding:10px 14px;font-size:13px;font-weight:700;color:#fbbf24;text-align:center;margin:8px 0 0;}
.md-input-group{display:flex!important;gap:6px!important;align-items:stretch!important;}
.md-input-group .md-input{flex:1!important;}
.md-btn-apply{display:inline-flex;align-items:center;padding:8px 14px;background:rgba(99,102,241,0.2);color:#a5b4fc;border:1px solid rgba(99,102,241,0.35);border-radius:8px;font-size:12px;font-weight:700;cursor:pointer;white-space:nowrap;transition:all .15s;}
.md-btn-apply:hover{background:rgba(99,102,241,0.35);}
.md-btn-cancel{display:inline-flex;align-items:center;gap:6px;padding:9px 18px;border-radius:8px;background:rgba(255,255,255,0.07);color:#9ca3af;border:1px solid rgba(255,255,255,0.1);font-size:13px;font-weight:700;cursor:pointer;}
.md-btn-rec{display:inline-flex;align-items:center;gap:6px;padding:9px 18px;border-radius:8px;background:linear-gradient(135deg,#22c55e,#16a34a);color:#fff;border:none;font-size:13px;font-weight:700;cursor:pointer;box-shadow:0 4px 12px rgba(34,197,94,0.3);}
.md-btn-desp{display:inline-flex;align-items:center;gap:6px;padding:9px 18px;border-radius:8px;background:linear-gradient(135deg,#ef4444,#dc2626);color:#fff;border:none;font-size:13px;font-weight:700;cursor:pointer;box-shadow:0 4px 12px rgba(239,68,68,0.3);}
.md-btn-parc{display:inline-flex;align-items:center;gap:6px;padding:9px 18px;border-radius:8px;background:linear-gradient(135deg,#6366f1,#4f46e5);color:#fff;border:none;font-size:13px;font-weight:700;cursor:pointer;box-shadow:0 4px 12px rgba(99,102,241,0.3);}
.md-val-desc-hint{font-size:11px;color:#6b7280;margin-top:3px;}
</style>

<div id="modalReceita" class="modal hide fade" tabindex="-1" role="dialog" aria-hidden="true">
    <form id="formReceita" action="<?= base_url() ?>index.php/financeiro/adicionarReceita" method="post">
        <div class="modal-header md-dark">
            <h4><i class='bx bx-trending-up' style="color:#4ade80;"></i> Adicionar Receita/Despesa</h4>
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        </div>
        <div class="modal-body md-dark">
            <input type="hidden" id="urlAtual" name="urlAtual" value="<?= current_url() ?>" />

            <div class="md-info"><i class='bx bx-info-circle'></i> Campos com * são obrigatórios.</div>

            <div class="md-row">
                <div class="md-col" style="max-width:140px;">
                    <label class="md-label">Tipo</label>
                    <select name="tipo" id="tipo" class="md-select">
                        <option value="receita">Receita</option>
                        <option value="despesa">Despesa</option>
                    </select>
                </div>
                <div class="md-col">
                    <label class="md-label">Descrição / Referência *</label>
                    <input class="md-input" id="descricao" type="text" name="descricao" required placeholder="Ex: Pagamento OS #123" />
                </div>
            </div>

            <div style="margin-bottom:12px;">
                <label class="md-label">Cliente / Fornecedor *</label>
                <input class="md-input" id="cliente" type="text" name="cliente" value="" required placeholder="Digite para buscar..." />
                <input id="idCliente" type="hidden" name="idCliente" value="" />
            </div>

            <div style="margin-bottom:12px;">
                <label class="md-label">Observações</label>
                <textarea class="md-textarea" id="observacoes" name="observacoes" placeholder="Informações adicionais..."></textarea>
            </div>

            <div class="md-row">
                <div class="md-col">
                    <label class="md-label">Valor (R$) *</label>
                    <input class="md-input money" id="valor" type="text" name="valor" data-affixes-stay="true" data-thousands="" data-decimal="." required placeholder="0,00" />
                </div>
                <div class="md-col">
                    <label class="md-label">Desconto (R$)</label>
                    <div class="md-input-group">
                        <input class="md-input money" id="descontos" type="text" name="descontos" placeholder="0,00" />
                        <button type="button" class="md-btn-apply" onclick="mostrarValores()"><i class='bx bx-check'></i> Aplicar</button>
                    </div>
                </div>
                <div class="md-col" style="max-width:140px;">
                    <label class="md-label">Val. c/ Desconto</label>
                    <input class="md-input money" id="valor_desconto" readonly type="text" name="valor_desconto" value="<?= number_format(0, 2, ',', '.') ?>" style="color:#fbbf24;font-weight:700;" />
                    <div class="md-val-desc-hint">Calculado automaticamente</div>
                </div>
            </div>

            <div class="md-row">
                <div class="md-col">
                    <label class="md-label">Data de Vencimento *</label>
                    <input class="md-input datepicker" autocomplete="off" id="vencimento" type="text" name="vencimento" required placeholder="dd/mm/aaaa" />
                </div>
                <div class="md-col">
                    <label class="md-label">Qtd. Parcelas</label>
                    <select name="qtdparcelas" id="qtdparcelas" class="md-select">
                        <option value="0">Pagamento à vista</option>
                        <?php for($p=1;$p<=12;$p++): ?>
                        <option value="<?=$p?>"><?=$p?>x</option>
                        <?php endfor; ?>
                    </select>
                    <a href="#modalReceitaParcelada" id="abrirmodalreceitaparcelada" data-toggle="modal" style="display:none;" role="button"></a>
                </div>
                <div class="md-col" style="max-width:130px;display:flex;align-items:flex-end;padding-bottom:2px;">
                    <div class="md-check-row">
                        <input id="recebido" type="checkbox" name="recebido" value="1" />
                        <label for="recebido">Já recebido?</label>
                    </div>
                </div>
            </div>

            <div id="divRecebimento" style="display:none;">
                <hr class="md-divider" />
                <div class="md-row">
                    <div class="md-col">
                        <label class="md-label">Data do Recebimento</label>
                        <input class="md-input datepicker" autocomplete="off" id="recebimento" type="text" name="recebimento" placeholder="dd/mm/aaaa" />
                    </div>
                    <div class="md-col">
                        <label class="md-label">Forma de Pagamento</label>
                        <select name="formaPgto" id="formaPgto" class="md-select">
                            <option value="Dinheiro">Dinheiro</option>
                            <option value="Pix">Pix</option>
                            <option value="Boleto">Boleto</option>
                            <option value="Cartão de Crédito" selected>Cartão de Crédito</option>
                            <option value="Cartão de Débito">Cartão de Débito</option>
                            <option value="Cheque">Cheque</option>
                            <option value="Cheque Pré-datado">Cheque Pré-datado</option>
                            <option value="Depósito">Depósito</option>
                            <option value="Transferência DOC">Transferência DOC</option>
                            <option value="Transferência TED">Transferência TED</option>
                            <option value="Promissória">Promissória</option>
                        </select>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal-footer md-dark">
            <button type="button" class="md-btn-cancel" id="cancelar_nova_receita" data-dismiss="modal">
                <i class='bx bx-x'></i> Cancelar
            </button>
            <button type="submit" class="md-btn-rec">
                <i class='bx bx-save'></i> Adicionar Registro
            </button>
        </div>
    </form>
</div>

<!-- Modal nova receita e despesa parcelada -->
<!-- Modal nova receita e despesa parcelada -->
<div id="modalReceitaParcelada" class="modal hide fade" tabindex="-1" role="dialog" aria-hidden="true">
  <form id="formReceita_parc" action="<?= base_url() ?>index.php/financeiro/adicionarReceita_parc" method="post">
    <div class="modal-header md-dark">
        <h4><i class='bx bx-credit-card' style="color:#a5b4fc;"></i> Adicionar Parcelado</h4>
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
    </div>
    <div class="modal-body md-dark">
        <input id="urlAtual" type="hidden" name="urlAtual" value="<?= current_url() ?>" />
        <div class="md-info"><i class='bx bx-info-circle'></i> Campos com * são obrigatórios.</div>
        <div class="md-row">
            <div class="md-col" style="max-width:130px;">
                <label class="md-label">Tipo</label>
                <select name="tipo_parc" id="tipo_parc" class="md-select">
                    <option value="receita">Receita</option>
                    <option value="despesa">Despesa</option>
                </select>
            </div>
            <div class="md-col">
                <label class="md-label">Descrição / Referência *</label>
                <input class="md-input" id="descricao_parc" type="text" name="descricao_parc" required placeholder="Ex: Parcelamento..." />
            </div>
        </div>
        <div class="md-row">
            <div class="md-col">
                <label class="md-label">Cliente / Fornecedor *</label>
                <input class="md-input" id="cliente_parc" type="text" name="cliente_parc" required placeholder="Digite para buscar..." />
                <input id="idCliente_parc" type="hidden" name="idCliente_parc" value="" />
            </div>
            <div class="md-col">
                <label class="md-label">Observações</label>
                <textarea class="md-textarea" id="observacoes_parc" name="observacoes_parc" style="min-height:36px;" placeholder="..."></textarea>
            </div>
        </div>
        <div class="md-row">
            <div class="md-col">
                <label class="md-label">Valor Total *</label>
                <input class="md-input money" id="valor_parc" type="text" name="valor_parc" required placeholder="0,00" />
            </div>
            <div class="md-col">
                <label class="md-label">Desconto (R$)</label>
                <div class="md-input-group">
                    <input class="md-input money" id="descontos_parc" type="text" name="descontos_parc" placeholder="0,00" />
                    <button type="button" class="md-btn-apply" onclick="mostrarValoresParc()"><i class='bx bx-check'></i> Aplicar</button>
                </div>
            </div>
            <div class="md-col" style="max-width:130px;">
                <label class="md-label">Val. c/ Desconto</label>
                <input class="md-input money" id="desconto_parc" readonly type="text" name="desconto_parc" value="0,00" style="color:#fbbf24;font-weight:700;" />
            </div>
        </div>
        <div class="md-row">
            <div class="md-col" style="max-width:100px;">
                <label class="md-label">Parcelas</label>
                <select name="qtdparcelas_parc" id="qtdparcelas_parc" class="md-select">
                    <?php for($p=1;$p<=12;$p++): ?><option value="<?=$p?>"><?=$p?>x</option><?php endfor; ?>
                </select>
            </div>
            <div class="md-col">
                <label class="md-label">Forma de Pagamento</label>
                <select name="formaPgto_parc" id="formaPgto_parc" class="md-select">
                    <option value="Dinheiro">Dinheiro</option><option value="Pix">Pix</option>
                    <option value="Boleto">Boleto</option><option value="Cartão de Crédito">Cartão de Crédito</option>
                    <option value="Cartão de Débito">Cartão de Débito</option><option value="Cheque">Cheque</option>
                    <option value="Cheque Pré-datado">Cheque Pré-datado</option><option value="Depósito">Depósito</option>
                    <option value="Transferência DOC">Transferência DOC</option><option value="Transferência TED">Transferência TED</option>
                    <option value="Promissória">Promissória</option>
                </select>
            </div>
        </div>
        <hr class="md-divider" />
        <div class="md-row">
            <div class="md-col">
                <label class="md-label">Entrada (R$)</label>
                <input class="md-input money" id="entrada" type="text" name="entrada" value="0" placeholder="0,00" />
            </div>
            <div class="md-col">
                <label class="md-label">Data da Entrada *</label>
                <input class="md-input datepicker" id="dia_pgto" type="text" name="dia_pgto" value="<?= date('d/m/Y') ?>" autocomplete="off" required placeholder="dd/mm/aaaa" />
            </div>
            <div class="md-col">
                <label class="md-label" title="Dia base das parcelas mensais">Data Base Pgto *</label>
                <input class="md-input datepicker" id="dia_base_pgto" type="text" autocomplete="off" name="dia_base_pgto" required placeholder="dd/mm/aaaa" />
            </div>
        </div>
        <input id="valorparcelas" type="hidden" name="valorparcelas" readonly />
        <div class="md-parc-summary" id="string_parc"></div>
    </div>
    <div class="modal-footer md-dark">
        <button type="button" class="md-btn-cancel" data-dismiss="modal"><i class='bx bx-x'></i> Cancelar</button>
        <button type="submit" class="md-btn-parc" id="submitReceita"><i class='bx bx-save'></i> Adicionar Parcelado</button>
    </div>
  </form>
</div>

<!-- Modal nova despesa (NAO É UTILIZADO MAIS ESSE MODAL)
<div id="modalDespesa" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <form id="formDespesa" action="<?php // echo base_url()?>index.php/financeiro/adicionarDespesa" method="post">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            <h3 id="myModalLabel">Sisos - Adicionar Despesa</h3>
        </div>
        <div class="modal-body">
            <div class="span12 alert alert-info" style="margin-left: 0"> Obrigatório o preenchimento dos campos com
                asterisco.
            </div>
            <div class="span12" style="margin-left: 0">
                <label for="descricao">Descrição*</label>
                <input class="span12" id="descricao" type="text" name="descricao" />
                <input id="urlAtual" type="hidden" name="urlAtual" value="<?php  // echo current_url()?>" />
            </div>
            <div class="span12" style="margin-left: 0">
                <div class="span12" style="margin-left: 0">
                    <label for="fornecedor">Fornecedor / Empresa*</label>
                    <input class="span12" id="fornecedor" type="text" name="fornecedor" />
                    <input class="span12" id="idFornecedor" type="hidden" name="idFornecedor" />
                </div>

                <div class="span12" style="margin-left: 0">
                    <label for="observacoes">Observações</label>
                    <textarea class="span12" id="observacoes" name="observacoes"></textarea>
                </div>

            </div>
            <div class="span12" style="margin-left: 0">
                <div class="span4" style="margin-left: 0">
                    <label for="valor">Valor*</label>
                    <input type="hidden" name="tipo" value="despesa" />
                    <input class="span12 money" type="text" name="valor" data-affixes-stay="true" data-thousands="" data-decimal="." />
                </div>
                <div class="span4">
                    <label for="vencimento">Data Vencimento*</label>
                    <input class="span12 datepicker" autocomplete="off" type="text" name="vencimento" />
                </div>

            </div>
            <div class="span12" style="margin-left: 0">
                <div class="span4" style="margin-left: 0">
                    <label for="pago">Foi Pago?</label>
                    &nbsp &nbsp &nbsp &nbsp<input id="pago" type="checkbox" name="pago" value="1" />
                </div>
                <div id="divPagamento" class="span8" style=" display: none">
                    <div class="span6">
                        <label for="pagamento">Data Pagamento</label>
                        <input class="span12 datepicker" autocomplete="off" id="pagamento" type="text" name="pagamento" />
                    </div>

                    <div class="span6">
                        <label for="formaPgto">Forma Pgto</label>
                        <select name="formaPgto" class="span12">
                            <option value="Dinheiro">Dinheiro</option>
                            <option value="Cartão de Crédito">Cartão de Crédito</option>
                            <option value="Cheque">Cheque</option>
                            <option value="Boleto">Boleto</option>
                            <option value="Depósito">Depósito</option>
                            <option value="Débito">Débito</option>
                            <option value="Pix">Pix</option>
                        </select>
                    </div>
                </div>

            </div>

        </div>
        <div class="modal-footer" style="display:flex;justify-content: center">
            <button class="button btn btn-warning" data-dismiss="modal" aria-hidden="true">
                <span class="button__icon"><i class="bx bx-x"></i></span><span class="button__text2">Cancelar</span></button>
            <button class="button btn btn-danger" id="submitDespesa">
                <span class="button__icon"><i class='bx bx-plus-circle'></i></span><span class="button__text2">Adicionar Despesa</span></button>
        </div>
    </form>
</div>
 -->

<!-- Modal editar lançamento -->
<div id="modalEditar" class="modal hide fade" tabindex="-1" role="dialog" aria-hidden="true">
    <form id="formEditar" action="<?= base_url() ?>index.php/financeiro/editar" method="post">
        <div class="modal-header md-dark">
            <h4><i class='bx bx-edit' style="color:#fbbf24;"></i> Editar Lançamento</h4>
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        </div>
        <div class="modal-body md-dark">
            <input id="urlAtualEditar" type="hidden" name="urlAtual" value="" />
            <div class="md-info"><i class='bx bx-info-circle'></i> Campos com * são obrigatórios.</div>
            <div class="md-row">
                <div class="md-col">
                    <label class="md-label">Descrição / Referência *</label>
                    <input class="md-input" id="descricaoEditar" type="text" name="descricao" required />
                </div>
                <div class="md-col" style="max-width:130px;">
                    <label class="md-label">Tipo *</label>
                    <select class="md-select" name="tipo" id="tipoEditar">
                        <option value="receita">Receita</option>
                        <option value="despesa">Despesa</option>
                    </select>
                </div>
            </div>
            <div style="margin-bottom:12px;">
                <label class="md-label">Cliente / Fornecedor *</label>
                <input class="md-input" id="fornecedorEditar" type="text" name="fornecedor" required />
                <input type="hidden" id="idEditar" name="id" value="" />
            </div>
            <div style="margin-bottom:12px;">
                <label class="md-label">Observações</label>
                <textarea class="md-textarea" id="observacoes_edit" name="observacoes"></textarea>
            </div>
            <div class="md-row">
                <div class="md-col">
                    <label class="md-label">Valor (R$) *</label>
                    <input class="md-input money" type="text" name="valor" id="valorEditar" required />
                </div>
                <div class="md-col">
                    <label class="md-label">Desconto (R$)</label>
                    <div class="md-input-group">
                        <input class="md-input money" id="descontos_editar" type="text" name="descontos_editar" placeholder="0,00" />
                        <button type="button" class="md-btn-apply" onclick="mostrarValoresEditar()"><i class='bx bx-check'></i> Aplicar</button>
                    </div>
                </div>
                <div class="md-col" style="max-width:130px;">
                    <label class="md-label">Val. c/ Desconto</label>
                    <input class="md-input money" id="descontoEditar" name="valor_desconto_editar" type="text" style="color:#fbbf24;font-weight:700;" />
                </div>
            </div>
            <div class="md-row">
                <div class="md-col">
                    <label class="md-label">Data Vencimento *</label>
                    <input class="md-input datepicker2" type="text" name="vencimento" id="vencimentoEditar" autocomplete="off" required placeholder="dd/mm/aaaa" />
                </div>
                <div class="md-col" style="display:flex;align-items:flex-end;padding-bottom:2px;">
                    <div class="md-check-row">
                        <input id="pagoEditar" type="checkbox" name="pago" value="1" />
                        <label for="pagoEditar">Já foi pago?</label>
                    </div>
                </div>
            </div>
            <div id="divPagamentoEditar" style="display:none;">
                <hr class="md-divider" />
                <div class="md-row">
                    <div class="md-col">
                        <label class="md-label">Data do Pagamento</label>
                        <input class="md-input datepicker2" id="pagamentoEditar" type="text" name="pagamento" autocomplete="off" placeholder="dd/mm/aaaa" />
                    </div>
                    <div class="md-col">
                        <label class="md-label">Forma de Pagamento</label>
                        <select name="formaPgto" id="formaPgtoEditar" class="md-select">
                            <option value="Dinheiro">Dinheiro</option><option value="Pix">Pix</option>
                            <option value="Boleto">Boleto</option><option value="Cartão de Crédito">Cartão de Crédito</option>
                            <option value="Cartão de Débito">Cartão de Débito</option><option value="Cheque">Cheque</option>
                            <option value="Cheque Pré-datado">Cheque Pré-datado</option><option value="Depósito">Depósito</option>
                            <option value="Transferência DOC">Transferência DOC</option><option value="Transferência TED">Transferência TED</option>
                            <option value="Promissória">Promissória</option>
                        </select>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal-footer md-dark" style="justify-content:space-between!important;">
            <span style="font-size:12px;color:#6b7280;">Modificado por: <span id="usuarioEditar" style="color:#9ca3af;font-weight:600;"></span></span>
            <div style="display:flex;gap:8px;">
                <button type="button" class="md-btn-cancel" data-dismiss="modal" id="btnCancelarEditar"><i class='bx bx-x'></i> Cancelar</button>
                <button type="submit" class="md-btn-rec"><i class='bx bx-save'></i> Salvar</button>
            </div>
        </div>
    </form>
</div>


<!-- Modal Excluir lançamento -->
<div id="modalExcluir" class="modal hide fade" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-header md-dark">
        <h4><i class='bx bx-trash' style="color:#f87171;"></i> Excluir Lançamento</h4>
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
    </div>
    <div class="modal-body md-dark" style="text-align:center;padding:28px 20px;">
        <i class='bx bx-error-circle' style="font-size:42px;color:#f87171;display:block;margin-bottom:10px;"></i>
        <p style="color:#c9cad6;font-size:14px;margin:0 0 6px;">Deseja realmente excluir este lançamento?</p>
        <p style="color:#6b7280;font-size:12px;margin:0;">Esta ação não pode ser desfeita.</p>
        <input name="id" id="idExcluir" type="hidden" value="" />
    </div>
    <div class="modal-footer md-dark">
        <button type="button" class="md-btn-cancel" data-dismiss="modal" id="btnCancelExcluir"><i class='bx bx-x'></i> Cancelar</button>
        <button type="button" class="md-btn-desp" id="btnExcluir"><i class='bx bx-trash'></i> Excluir</button>
    </div>
</div>


<script src="<?php echo base_url() ?>assets/js/jquery.validate.js"></script>
<script src="<?php echo base_url(); ?>assets/js/maskmoney.js"></script>
<script type="text/javascript">

    function mostrarValor() {
		if (document.getElementById('valor').value == "" || document.getElementById('desconto').value == ""){
			
		}else{
			
			var valor = parseFloat(document.getElementById('valor').value);
			var desconto = parseInt(document.getElementById('desconto').value); 
			var valor_desconto = parseFloat(document.getElementById('valor_desconto').value);
			var resultado, total;
			resultado = valor/100;
			total = valor-(desconto*resultado);
			
			resultdesc = total ;
			totaldesc = valor-(resultdesc);	
			
			document.getElementById('valor').value = total.toFixed(2);
			document.getElementById('valor_desconto').value = totaldesc.toFixed(2);
			}
	}
	
    function mostrarValores() {
		if (document.getElementById('valor').value == "" || document.getElementById('descontos').value == "" || document.getElementById('valor_desconto').value == ""){
			
		}else{
			var valor = parseFloat(document.getElementById('valor').value);
			var desconto = parseFloat(document.getElementById('descontos').value); 
			var valor_desconto = parseFloat(document.getElementById('valor_desconto').value);
			var resultado, total;
			resultado = valor;
			total = valor-desconto;
			
			resultdesc = total ;
			totaldesc = valor-(resultdesc);	
			
			document.getElementById('valor').value = total.toFixed(2);
			document.getElementById('valor_desconto').value = totaldesc.toFixed(2);
			}
	}

    function mostrarValoresEditar() {
		if (document.getElementById('valorEditar').value == "" || document.getElementById('descontos_editar').value == ""){
		}else{
			var valor = parseFloat(document.getElementById('valorEditar').value);
			var desconto = parseFloat(document.getElementById('descontos_editar').value);

			if (isNaN(valor) || isNaN(desconto)) {
				return;
			}

			var valorComDesconto = valor - desconto;
			if (valorComDesconto < 0) {
				valorComDesconto = 0;
			}

			// Mantém "Valor" como total original e atualiza apenas "Val.Desc".
			document.getElementById('descontoEditar').value = valorComDesconto.toFixed(2);
			}
	}

    function mostrarValoresParc() {
		if (document.getElementById('valor_parc').value == "" || document.getElementById('descontos_parc').value == "" || document.getElementById('desconto_parc').value == ""){
			
		}else{
			var valor = parseFloat(document.getElementById('valor_parc').value);
			var desconto = parseFloat(document.getElementById('descontos_parc').value); 
			var valor_desconto = parseFloat(document.getElementById('desconto_parc').value);
			var resultado, total;
			resultado = valor;
			total = valor-desconto;
			
			resultdesc = total ;
			totaldesc = valor-(resultdesc);	
			
			document.getElementById('valor_parc').value = total.toFixed(2);
			document.getElementById('desconto_parc').value = totaldesc.toFixed(2);
			}
        }

    jQuery(document).ready(function($) {

        $(".money").maskMoney();

        $('#pago').click(function(event) {
            var flag = $(this).is(':checked');
            if (flag == true) {
                $('#divPagamento').show();
            } else {
                $('#divPagamento').hide();
            }
        });


        $('#recebido').click(function(event) {
            var flag = $(this).is(':checked');
            if (flag == true) {
                $('#divRecebimento').show();
            } else {
                $('#divRecebimento').hide();
            }
        });

        $('#pagoEditar').click(function(event) {
            var flag = $(this).is(':checked');
            if (flag == true) {
                $('#divPagamentoEditar').show();
            } else {
                $('#divPagamentoEditar').hide();
            }
        });


        $("#formReceita").validate({
            rules: {
                descricao: {
                    required: true
                },
                cliente: {
                    required: true
                },
                valor: {
                    required: true
                },
                vencimento: {
                    required: true
                }

            },
            messages: {
                descricao: {
                    required: 'Campo Requerido.'
                },
                cliente: {
                    required: 'Campo Requerido.'
                },
                valor: {
                    required: 'Campo Requerido.'
                },
                vencimento: {
                    required: 'Campo Requerido.'
                }
            },
            submitHandler: function(form) {
                $("#submitReceita").attr("disabled", true);
                form.submit();
            }
        });


        $("#formDespesa").validate({
            rules: {
                descricao: {
                    required: true
                },
                fornecedor: {
                    required: true
                },
                valor: {
                    required: true
                },
                vencimento: {
                    required: true
                }

            },
            messages: {
                descricao: {
                    required: 'Campo Requerido.'
                },
                fornecedor: {
                    required: 'Campo Requerido.'
                },
                valor: {
                    required: 'Campo Requerido.'
                },
                vencimento: {
                    required: 'Campo Requerido.'
                }
            },
            submitHandler: function(form) {
                $("#submitDespesa").attr("disabled", true);
                form.submit();
            }
        });


        $(document).on('click', '.excluir', function(event) {
            $("#idExcluir").val($(this).attr('idLancamento'));
        });


        $(document).on('click', '.editar', function(event) {
            $("#idEditar").val($(this).attr('idLancamento'));
            $("#descricaoEditar").val($(this).attr('descricao'));
            $("#usuarioEditar").val($(this).attr('usuario'));
            $("#fornecedorEditar").val($(this).attr('cliente'));
            $("#observacoes_edit").val($(this).attr('observacoes'));
            $("#valorEditar").val($(this).attr('valor'));
            $("#vencimentoEditar").val($(this).attr('vencimento'));
            $("#pagamentoEditar").val($(this).attr('pagamento'));
            $("#formaPgtoEditar").val($(this).attr('formaPgto'));
            $("#tipoEditar").val($(this).attr('tipo'));
            $("#descontos_editar").val($(this).attr('descontos_editar'));
            $("#descontoEditar").val($(this).attr('valor_desconto_editar'));
            $("#urlAtualEditar").val($(location).attr('href'));
            var baixado = $(this).attr('baixado');
            if (baixado == 1) {
                $("#pagoEditar").prop('checked', true);
                $("#divPagamentoEditar").show();
            } else {
                $("#pagoEditar").prop('checked', false);
                $("#divPagamentoEditar").hide();
            }


        });

        $(document).on('click', '#btnExcluir', function(event) {
            var id = $("#idExcluir").val();

            $.ajax({
                type: "POST",
                url: "<?php echo base_url(); ?>index.php/financeiro/excluirLancamento",
                data: "id=" + id,
                dataType: 'json',
                success: function(data) {
                    if (data.result == true) {
                        $("#btnCancelExcluir").trigger('click');
                        $("#divLancamentos").html('<div class="progress progress-striped active"><div class="bar" style="width: 100%;"></div></div>');
                        $("#divLancamentos").load($(location).attr('href') + " #divLancamentos");

                    } else {
                        $("#btnCancelExcluir").trigger('click');
                        Swal.fire({
                            type: "error",
                            title: "Atenção",
                            text: "Ocorreu um erro ao tentar excluir lançamento."
                        });
                    }
                }
            });
            return false;
        });
        let controlBaixa = "<?php echo $configuration['control_baixa']; ?>";
        let datePickerOptions = {
            dateFormat: 'dd/mm/yy',
        };
        if (controlBaixa === '1') {
            datePickerOptions.minDate = 0;
            datePickerOptions.maxDate = 0;
        }
        $(".datepicker2").datepicker(
            datePickerOptions
        );
        $(".datepicker").datepicker();
        $('#periodo').on('change', function(event) {
            const period = $('#periodo').val();
            const today = dayjs().locale('pt-br');

            switch (period) {
                case 'dia':
                    $('#vencimento_de').val(today.format('DD/MM/YYYY'));
                    $('#vencimento_ate').val(today.format('DD/MM/YYYY'));
                    break;
                case 'semana':
                    $('#vencimento_de').val(today.startOf('week').format('DD/MM/YYYY'));
                    $('#vencimento_ate').val(today.endOf('week').format('DD/MM/YYYY'));
                    break;
                case 'mesAnterior':
                    const startOfPreviousMonth = today.subtract(1, 'month').startOf('month');
                    const endOfPreviousMonth = today.subtract(1, 'month').endOf('month');

                    $('#vencimento_de').val(startOfPreviousMonth.format('DD/MM/YYYY'));
                    $('#vencimento_ate').val(endOfPreviousMonth.format('DD/MM/YYYY'));
                    break;
                case 'mes':
                    const startOfCurrentMonth = today.startOf('month');
                    const endOfCurrentMonth = today.endOf('month');

                    $('#vencimento_de').val(startOfCurrentMonth.format('DD/MM/YYYY'));
                    $('#vencimento_ate').val(endOfCurrentMonth.format('DD/MM/YYYY'));
                    break;
                case 'mesPosterior':
                    const startOfNextMonth = today.add(1, 'month').startOf('month');
                    const endOfNextMonth = today.add(1, 'month').endOf('month');

                    $('#vencimento_de').val(startOfNextMonth.format('DD/MM/YYYY'));
                    $('#vencimento_ate').val(endOfNextMonth.format('DD/MM/YYYY'));
                    break;
                case 'ano':
                    $('#vencimento_de').val(today.startOf('year').format('DD/MM/YYYY'));
                    $('#vencimento_ate').val(today.endOf('year').format('DD/MM/YYYY'));
                    break;
                case 'personalizado':
                    $('#vencimento_de').val('00/00/0000');
                    $('#vencimento_ate').val('00/00/0000');
                    break;
            }
        });

        $("#fornecedorEditar").autocomplete({
            source: "<?php echo base_url(); ?>index.php/financeiro/autoCompleteClienteAddReceita",
            minLength: 1,
            select: function(event, ui) {
                $("#fornecedorEditar").val(ui.item.label);
            }
        });
    
        $("#cliente").autocomplete({
            source: "<?php echo base_url(); ?>index.php/financeiro/autoCompleteClienteAddReceita",
            minLength: 1,
            select: function(event, ui) {
                $("#cliente").val(ui.item.label);
                $("#idCliente").val(ui.item.id);
            }
        });

          $("#cliente_busca").autocomplete({
            source: "<?php echo base_url(); ?>index.php/financeiro/autoCompleteClienteAddReceita",
            minLength: 1,
            select: function(event, ui) {
                $("#cliente_busca").val(ui.item.label);
            }
        });

        $("#cliente_parc").autocomplete({
            source: "<?php echo base_url(); ?>index.php/financeiro/autoCompleteClienteAddReceita",
            minLength: 1,
            select: function(event, ui) {
                $("#cliente_parc").val(ui.item.label);
                $("#idCliente_parc").val(ui.item.id);
            }
        });

        $("#fornecedor").autocomplete({
            source: "<?php echo base_url(); ?>index.php/financeiro/autoCompleteClienteAddReceita",
            minLength: 1,
            select: function(event, ui) {
                $("#fornecedor").val(ui.item.label);
                $("#idFornecedor").val(ui.item.id);
            }
        });

        function valorParcelas(){
			var valor_parc = $("#valor_parc").val();
			var qtdparc = $("#qtdparcelas_parc").val();
			var entrada = $("#entrada").val();
			var result = (valor_parc - entrada) / qtdparc;
			
			if(qtdparc > 1){
				if(entrada > 0){
					$("#string_parc").text('R$ '+entrada+' de entrada mais '+qtdparc+' parcelas de R$ '+parseFloat(Math.round(result * 100) / 100).toFixed(2));
				$("#valorparcelas").val(parseFloat(Math.round(result * 100) / 100).toFixed(2));
				}else{
					$("#string_parc").text(qtdparc+' parcelas de R$ '+parseFloat(Math.round(result * 100) / 100).toFixed(2));
				$("#valorparcelas").val(parseFloat(Math.round(result * 100) / 100).toFixed(2));
				}
			}else{
				if(entrada > 0){
					$("#string_parc").text('R$ '+entrada+' de entrada mais '+qtdparc+' parcela de R$ '+parseFloat(Math.round(result * 100) / 100).toFixed(2));
				$("#valorparcelas").val(parseFloat(Math.round(result * 100) / 100).toFixed(2));
				}else{
					$("#string_parc").text(qtdparc+' parcela de R$ '+parseFloat(Math.round(result * 100) / 100).toFixed(2));
				$("#valorparcelas").val(parseFloat(Math.round(result * 100) / 100).toFixed(2));
				}
			}
		}

		$('#qtdparcelas').change(function(event) {
			var parcelas = $("#qtdparcelas").val();
			if(parcelas > 1){
				$('#cancelar_nova_receita').trigger('click');
				$('#abrirmodalreceitaparcelada').trigger('click');
				$("#descricao_parc").val($("#descricao").val());
				$("#cliente_parc").val($("#cliente").val());
                $("#idCliente_parc").val($("#idCliente").val());
                $("#tipo_parc").val($("#tipo").val());
                $("#formaPgto_parc").val($("#formaPgto").val());
				$("#pcontas_parc").val($("#pcontas").val());
				$("#categoria_parc").val($("#categoria").val());
				$("#observacoes_parc").val($("#observacoes").val());
				$("#valor_parc").val($("#valor").val());
				$("#desconto_parc").val($("#valor_desconto").val());
				$("#qtdparcelas_parc").val($("#qtdparcelas").val());		
			valorParcelas();
			}
			else{
				if(parcelas == 1){
					$('#cancelar_nova_receita').trigger('click');
					$('#abrirmodalreceitaparcelada').trigger('click');
					$("#descricao_parc").val($("#descricao").val());
					$("#cliente_parc").val($("#cliente").val());
                    $("#idCliente_parc").val($("#idCliente").val());
                    $("#tipo_parc").val($("#tipo").val());
                    $("#formaPgto_parc").val($("#formaPgto").val());
					$("#pcontas_parc").val($("#pcontas").val());
					$("#categoria_parc").val($("#categoria").val());
					$("#observacoes_parc").val($("#observacoes").val());
					$("#desconto_parc").val($("#valor_desconto").val());
					$("#valor_parc").val($("#valor").val());
					$("#qtdparcelas_parc").val(1);		
					valorParcelas();
				}
			}
		});
							
		$('#valor_parc').keypress(function(event) {
			valorParcelas();
		});

		$('#qtdparcelas_parc').change(function(event) {
			valorParcelas();
		});
		
		$('#entrada').keypress(function(event){
			valorParcelas();
			var entrada = $("#entrada").val();
			if(entrada > 0){
				$('#dia_pgto').css("color", "#444444");
			}else{
				$('#dia_pgto').css("color", "#eeeeee");
			}
		});
		
		$('#valor_parc, #qtdparcelas_parc, #formaPgto_parc, #entrada, #dia_pgto, #dia_base_pgto').click(function(event){
			valorParcelas();
		});
		
		$('#add_receita').mouseover(function(event){
			valorParcelas();
		});
		
		$('#entrada').keypress(function(event){
			valorParcelas();
			var entrada = $("#entrada").val();
			if(entrada > 0){
				$('#dia_pgto').css("color", "#444444");
			}else{
				$('#dia_pgto').css("color", "#eeeeee");
			}
		});
		$('#valor_parc, #qtdparcela_parc, #formaPgto_parc, #entrada, #dia_pgto, #dia_base_pgto').click(function(event){
			valorParcelas();
		});
		
		$('#add_receita').mouseover(function(event){
			valorParcelas();
		});
    });
</script>
