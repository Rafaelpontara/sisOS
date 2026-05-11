<script src="<?= base_url() ?>assets/js/chart.js/Chart.min.js"></script>
<?php
$t = $totais;
$recPagas  = (float)($t->receitas_pagas    ?? 0);
$recPend   = (float)($t->receitas_pendentes ?? 0);
$despPagas = (float)($t->despesas_pagas    ?? 0);
$despPend  = (float)($t->despesas_pendentes ?? 0);
$saldo     = $recPagas - $despPagas;
$totalPend = $recPend + $despPend;
$meses = ['','Janeiro','Fevereiro','Março','Abril','Maio','Junho','Julho','Agosto','Setembro','Outubro','Novembro','Dezembro'];
$nomeMes = $meses[(int)$mes] . ' ' . $ano;
?>
<style>
/* ── Layout ── */
.fd-header{display:flex;justify-content:space-between;align-items:center;margin-bottom:20px;flex-wrap:wrap;gap:12px;}
.fd-title{font-size:22px;font-weight:800;color:#e8eaf0;display:flex;align-items:center;gap:10px;}
.fd-title i{font-size:24px;color:#fbbf24;}
.fd-nav{display:flex;align-items:center;gap:8px;flex-wrap:wrap;}
.fd-nav-btn{display:flex;align-items:center;gap:6px;padding:7px 14px;border-radius:8px;font-size:13px;font-weight:700;text-decoration:none;border:none;cursor:pointer;transition:all .15s;}
.fd-btn-lanc{background:rgba(255,255,255,0.07);color:#9ca3af;border:1px solid rgba(255,255,255,0.1);}
.fd-btn-lanc:hover{background:rgba(255,255,255,0.12);color:#e8eaf0;}
.fd-period{display:flex;align-items:center;gap:6px;}
.fd-period a{width:28px;height:28px;display:flex;align-items:center;justify-content:center;background:#252a3a;border:1px solid #444860;border-radius:6px;color:#e8eaf0;text-decoration:none;font-size:14px;font-weight:700;}
.fd-period a:hover{background:#3a3d4e;}
.fd-period span{background:#1e2133;border:1px solid #444860;padding:5px 16px;border-radius:7px;font-weight:700;font-size:13px;color:#e8eaf0;min-width:140px;text-align:center;}
.fd-period select{background:#1e2133;border:1px solid #444860;color:#e8eaf0;padding:5px 8px;border-radius:7px;font-size:13px;height:32px;}

/* ── Action buttons ── */
.fd-actions{display:flex;gap:8px;margin-bottom:16px;}
.fd-btn-rec{display:flex;align-items:center;gap:6px;padding:9px 18px;border-radius:8px;background:linear-gradient(135deg,#22c55e,#16a34a);color:#fff;font-size:13px;font-weight:700;text-decoration:none;border:none;cursor:pointer;box-shadow:0 4px 14px rgba(34,197,94,0.3);transition:transform .15s;}
.fd-btn-rec:hover{transform:translateY(-2px);color:#fff;}
.fd-btn-desp{display:flex;align-items:center;gap:6px;padding:9px 18px;border-radius:8px;background:linear-gradient(135deg,#ef4444,#dc2626);color:#fff;font-size:13px;font-weight:700;text-decoration:none;border:none;cursor:pointer;box-shadow:0 4px 14px rgba(239,68,68,0.3);transition:transform .15s;}
.fd-btn-desp:hover{transform:translateY(-2px);color:#fff;}

/* ── KPI Cards ── */
.fd-cards{display:flex;gap:12px;margin-bottom:16px;flex-wrap:wrap;}
.fd-card{flex:1;min-width:200px;border-radius:14px;padding:18px 20px;color:#fff;display:flex;align-items:center;gap:16px;transition:transform .15s,box-shadow .15s;}
.fd-card:hover{transform:translateY(-3px);}
.fd-card-icon{width:52px;height:52px;border-radius:50%;display:flex;align-items:center;justify-content:center;background:rgba(255,255,255,.2);font-size:24px;flex-shrink:0;}
.fd-card-info small{font-size:10px;text-transform:uppercase;letter-spacing:1px;opacity:.85;display:block;}
.fd-card-info h3{font-size:24px;font-weight:800;margin:4px 0 2px;line-height:1;}
.fd-card-info .sub{font-size:11px;opacity:.75;}
.fc-rec {background:linear-gradient(135deg,#22c55e,#15803d);box-shadow:0 8px 24px rgba(34,197,94,0.3);}
.fc-desp{background:linear-gradient(135deg,#ef4444,#b91c1c);box-shadow:0 8px 24px rgba(239,68,68,0.3);}
.fc-saldo{background:linear-gradient(135deg,#3b82f6,#1d4ed8);box-shadow:0 8px 24px rgba(59,130,246,0.3);}
.fc-pend{background:linear-gradient(135deg,#f59e0b,#b45309);box-shadow:0 8px 24px rgba(245,158,11,0.3);}

/* ── Main content ── */
.fd-main{display:flex;gap:14px;margin-bottom:14px;}
.fd-chart-box{flex:2;background:#1a1d2e;border:1px solid rgba(255,255,255,0.07);border-radius:14px;padding:18px;}
.fd-stats-box{flex:1;min-width:240px;background:#1a1d2e;border:1px solid rgba(255,255,255,0.07);border-radius:14px;padding:18px;}
.fd-box-title{font-size:12px;font-weight:700;color:#6b7280;text-transform:uppercase;letter-spacing:.8px;margin-bottom:14px;display:flex;align-items:center;gap:6px;}
.fd-stat-row{display:flex;justify-content:space-between;align-items:center;padding:8px 0;border-bottom:1px solid rgba(255,255,255,0.04);font-size:13px;}
.fd-stat-row:last-child{border:none;}
.fd-stat-row .lbl{color:#9ca3af;}
.fd-stat-row .val{font-weight:700;}

/* ── Filter + Table ── */
.fd-tipo-btns{display:flex;gap:6px;margin-bottom:10px;}
.fd-tipo-btn{border-radius:20px;padding:5px 16px;font-size:13px;border:2px solid;background:transparent;cursor:pointer;text-decoration:none;display:inline-flex;align-items:center;gap:5px;font-weight:600;transition:all .15s;}
.fd-tipo-todos {border-color:#444860;color:#9ca3af;} .fd-tipo-todos.active,.fd-tipo-todos:hover {background:#444860;color:#fff;}
.fd-tipo-rec   {border-color:#22c55e;color:#22c55e;} .fd-tipo-rec.active,.fd-tipo-rec:hover   {background:#22c55e;color:#fff;}
.fd-tipo-desp  {border-color:#ef4444;color:#ef4444;} .fd-tipo-desp.active,.fd-tipo-desp:hover  {background:#ef4444;color:#fff;}
.fd-tbl-wrap{background:#1a1d2e;border:1px solid rgba(255,255,255,0.07);border-radius:14px;overflow:hidden;}
.fd-tbl-wrap table{width:100%;border-collapse:collapse;}
.fd-tbl-wrap thead th{background:#252a3a;color:#9ca3af;font-size:11px;font-weight:700;text-transform:uppercase;letter-spacing:.5px;padding:11px 12px;border-bottom:1px solid rgba(255,255,255,0.07);white-space:nowrap;}
.fd-tbl-wrap tbody tr{border-bottom:1px solid rgba(255,255,255,0.04);transition:background .12s;}
.fd-tbl-wrap tbody tr:hover{background:rgba(251,191,36,0.04);}
.fd-tbl-wrap tbody td{padding:10px 12px;font-size:13px;color:#c9cad6;vertical-align:middle;}
.sp{padding:3px 9px;border-radius:20px;font-size:11px;font-weight:700;display:inline-block;}
.sp-rec{background:rgba(34,197,94,0.15);color:#4ade80;}
.sp-desp{background:rgba(239,68,68,0.15);color:#f87171;}
.sp-pago{background:rgba(34,197,94,0.15);color:#4ade80;}
.sp-pend{background:rgba(245,158,11,0.15);color:#fbbf24;}

/* ── Modais dark ── */
.modal-dark .modal-header{background:#1a1d2e;border-bottom:1px solid rgba(255,255,255,0.08);padding:16px 20px;display:flex;align-items:center;justify-content:space-between;}
.modal-dark .modal-header h3{margin:0;font-size:16px;font-weight:800;color:#e8eaf0;display:flex;align-items:center;gap:8px;}
.modal-dark .modal-header .close{color:#9ca3af;font-size:22px;background:none;border:none;cursor:pointer;line-height:1;}
.modal-dark .modal-body{background:#13151f;padding:20px;}
.modal-dark .modal-footer{background:#1a1d2e;border-top:1px solid rgba(255,255,255,0.08);padding:12px 20px;display:flex;justify-content:flex-end;gap:8px;}
.modal-dark .form-group{margin-bottom:14px;}
.modal-dark label{font-size:12px;font-weight:600;color:#9ca3af;text-transform:uppercase;letter-spacing:.5px;display:block;margin-bottom:5px;}
.modal-dark input[type=text],
.modal-dark input[type=number],
.modal-dark textarea,
.modal-dark select{background:#1e2133;border:1px solid #444860;color:#e8eaf0;border-radius:8px;padding:8px 12px;width:100%;font-size:13px;box-sizing:border-box;transition:border-color .15s;}
.modal-dark input[type=text]:focus,
.modal-dark textarea:focus,
.modal-dark select:focus{border-color:#6366f1;outline:none;}
.modal-dark textarea{min-height:70px;resize:vertical;}
.modal-dark .row-cols{display:flex;gap:12px;flex-wrap:wrap;}
.modal-dark .row-cols > div{flex:1;min-width:140px;}
.modal-dark .modal-title-rec{color:#4ade80;}
.modal-dark .modal-title-desp{color:#f87171;}
.modal-dark .check-row{display:flex;align-items:center;gap:8px;padding:8px 0;}
.modal-dark .check-row input[type=checkbox]{width:16px;height:16px;accent-color:#6366f1;}
.modal-dark .check-row label{margin:0;text-transform:none;font-size:13px;color:#c9cad6;}
.modal-dark .divider{border:none;border-top:1px solid rgba(255,255,255,0.06);margin:14px 0;}
.modal-dark .info-badge{background:rgba(99,102,241,0.12);border:1px solid rgba(99,102,241,0.3);border-radius:8px;padding:8px 12px;font-size:12px;color:#a5b4fc;margin-bottom:14px;}
.modal-dark .parc-summary{background:#1e2133;border:1px solid #444860;border-radius:8px;padding:10px 14px;font-size:13px;font-weight:700;color:#fbbf24;text-align:center;margin-top:8px;}
</style>

<div class="new122">

    <!-- Header -->
    <div class="fd-header">
        <div class="fd-title"><i class='bx bx-bar-chart-alt-2'></i> Dashboard Financeiro</div>
        <div class="fd-nav">
            <a href="<?= site_url('financeiro/lancamentos') ?>" class="fd-nav-btn fd-btn-lanc">
                <i class='bx bx-list-ul'></i> Lançamentos
            </a>
            <div class="fd-period">
                <a href="?tipo=<?=$tipo?>&mes=<?= $mes<=1?12:$mes-1 ?>&ano=<?= $mes<=1?$ano-1:$ano ?>">&lt;</a>
                <span><?= $nomeMes ?></span>
                <a href="?tipo=<?=$tipo?>&mes=<?= $mes>=12?1:$mes+1 ?>&ano=<?= $mes>=12?$ano+1:$ano ?>">&gt;</a>
                <select onchange="location.href='?tipo=<?=$tipo?>&mes='+this.value+'&ano=<?=$ano?>'">
                    <?php for ($m=1;$m<=12;$m++): ?>
                    <option value="<?=$m?>" <?=$m==$mes?'selected':''?>><?=$meses[$m]?></option>
                    <?php endfor; ?>
                </select>
                <select onchange="location.href='?tipo=<?=$tipo?>&mes=<?=$mes?>&ano='+this.value">
                    <?php for ($y=date('Y');$y>=date('Y')-5;$y--): ?>
                    <option value="<?=$y?>" <?=$y==$ano?'selected':''?>><?=$y?></option>
                    <?php endfor; ?>
                </select>
            </div>
        </div>
    </div>

    <!-- Botões Nova Receita / Nova Despesa -->
    <?php if ($this->permission->checkPermission($this->session->userdata('permissao'), 'aLancamento')): ?>
    <div class="fd-actions">
        <a href="#modalNovaReceita" data-toggle="modal" class="fd-btn-rec">
            <i class='bx bx-trending-up'></i> Nova Receita
        </a>
        <a href="#modalNovaDespesa" data-toggle="modal" class="fd-btn-desp">
            <i class='bx bx-trending-down'></i> Nova Despesa
        </a>
    </div>
    <?php endif; ?>

    <!-- KPI Cards -->
    <div class="fd-cards">
        <div class="fd-card fc-rec">
            <div class="fd-card-icon"><i class='bx bx-trending-up'></i></div>
            <div class="fd-card-info">
                <small>Receitas Pagas</small>
                <h3>R$ <?= number_format($recPagas,2,',','.') ?></h3>
                <div class="sub">Pendente: R$ <?= number_format($recPend,2,',','.') ?></div>
            </div>
        </div>
        <div class="fd-card fc-desp">
            <div class="fd-card-icon"><i class='bx bx-trending-down'></i></div>
            <div class="fd-card-info">
                <small>Despesas Pagas</small>
                <h3>R$ <?= number_format($despPagas,2,',','.') ?></h3>
                <div class="sub">Pendente: R$ <?= number_format($despPend,2,',','.') ?></div>
            </div>
        </div>
        <div class="fd-card fc-saldo">
            <div class="fd-card-icon"><i class='bx bx-wallet'></i></div>
            <div class="fd-card-info">
                <small>Saldo Líquido</small>
                <h3>R$ <?= number_format($saldo,2,',','.') ?></h3>
                <div class="sub">Receitas - Despesas pagas</div>
            </div>
        </div>
        <div class="fd-card fc-pend">
            <div class="fd-card-icon"><i class='bx bx-time'></i></div>
            <div class="fd-card-info">
                <small>Total Pendente</small>
                <h3>R$ <?= number_format($totalPend,2,',','.') ?></h3>
                <div class="sub">Receitas + Despesas pendentes</div>
            </div>
        </div>
    </div>

    <!-- Gráfico + Estatísticas -->
    <div class="fd-main">
        <div class="fd-chart-box">
            <div class="fd-box-title"><i class='bx bx-bar-chart'></i> Visão Geral do Período</div>
            <canvas id="graficoFinanceiro" height="140"></canvas>
        </div>
        <div class="fd-stats-box">
            <div class="fd-box-title"><i class='bx bx-stats'></i> Estatísticas</div>
            <div class="fd-stat-row"><span class="lbl">Receitas pagas</span><span class="val" style="color:#4ade80;">R$ <?= number_format($recPagas,2,',','.') ?></span></div>
            <div class="fd-stat-row"><span class="lbl">Despesas pagas</span><span class="val" style="color:#f87171;">R$ <?= number_format($despPagas,2,',','.') ?></span></div>
            <div class="fd-stat-row"><span class="lbl">Saldo líquido</span><span class="val" style="color:#60a5fa;">R$ <?= number_format($saldo,2,',','.') ?></span></div>
            <div class="fd-stat-row"><span class="lbl">Rec. pendentes</span><span class="val" style="color:#fbbf24;">R$ <?= number_format($recPend,2,',','.') ?></span></div>
            <div class="fd-stat-row"><span class="lbl">Desp. pendentes</span><span class="val" style="color:#fbbf24;">R$ <?= number_format($despPend,2,',','.') ?></span></div>
            <div class="fd-stat-row"><span class="lbl">Descontos aplicados</span><span class="val" style="color:#a78bfa;">R$ <?= number_format($t->descontos_aplicados??0,2,',','.') ?></span></div>
            <div class="fd-stat-row"><span class="lbl">Rec. s/ desconto</span><span class="val">R$ <?= number_format($t->receitas_sem_desconto??0,2,',','.') ?></span></div>
            <div class="fd-stat-row"><span class="lbl">Desp. s/ desconto</span><span class="val">R$ <?= number_format($t->despesas_sem_desconto??0,2,',','.') ?></span></div>
        </div>
    </div>

    <!-- Filtros tipo -->
    <div class="fd-tipo-btns">
        <a href="?tipo=&mes=<?=$mes?>&ano=<?=$ano?>" class="fd-tipo-btn fd-tipo-todos <?=$tipo===''?'active':''?>"><i class='bx bx-menu'></i> Todos</a>
        <a href="?tipo=receita&mes=<?=$mes?>&ano=<?=$ano?>" class="fd-tipo-btn fd-tipo-rec <?=$tipo==='receita'?'active':''?>"><i class='bx bx-trending-up'></i> Receitas</a>
        <a href="?tipo=despesa&mes=<?=$mes?>&ano=<?=$ano?>" class="fd-tipo-btn fd-tipo-desp <?=$tipo==='despesa'?'active':''?>"><i class='bx bx-trending-down'></i> Despesas</a>
    </div>

    <!-- Tabela -->
    <div class="fd-tbl-wrap">
        <table class="table">
            <thead>
                <tr>
                    <th>#</th><th>Tipo</th><th>Descrição</th><th>Categoria</th>
                    <th>Vencimento</th><th>Status</th><th>Forma Pg</th>
                    <th>Sub.Total</th><th>Desconto</th><th>V.Total</th><th></th>
                </tr>
            </thead>
            <tbody>
            <?php if (empty($lancamentos)): ?>
                <tr><td colspan="11" style="text-align:center;padding:30px;color:#6b7280;">Nenhum lançamento neste período.</td></tr>
            <?php else: foreach ($lancamentos as $i => $l):
                $valorTotal = $l->valor_desconto > 0 ? $l->valor_desconto : $l->valor;
                $catNome = '';
                if ($l->nome_grupo) $catNome = $l->nome_grupo . ' › ' . $l->nome_categoria;
                elseif ($l->nome_categoria) $catNome = $l->nome_categoria;
            ?>
            <tr>
                <td style="color:#6b7280;font-size:12px;"><?= $i+1 ?></td>
                <td><span class="sp <?= $l->tipo==='receita'?'sp-rec':'sp-desp' ?>"><?= ucfirst($l->tipo) ?></span></td>
                <td style="font-weight:600;color:#e8eaf0;"><?= htmlspecialchars($l->descricao) ?></td>
                <td style="font-size:12px;color:#9ca3af;"><?= htmlspecialchars($catNome ?: '—') ?></td>
                <td style="font-size:12px;"><?= date('d/m/Y', strtotime($l->data_vencimento)) ?></td>
                <td><span class="sp <?= $l->baixado?'sp-pago':'sp-pend' ?>"><?= $l->baixado?'Pago':'Pendente' ?></span></td>
                <td style="font-size:12px;color:#9ca3af;"><?= htmlspecialchars($l->forma_pgto ?: '—') ?></td>
                <td>R$ <?= number_format($l->valor,2,',','.') ?></td>
                <td style="color:#f87171;">R$ <?= number_format($l->desconto,2,',','.') ?></td>
                <td style="font-weight:700;color:#e8eaf0;">R$ <?= number_format($valorTotal,2,',','.') ?></td>
                <td>
                    <a href="<?= site_url('financeiro/lancamentos?id='.$l->idLancamentos) ?>" class="act-btn ab-v" style="width:28px;height:28px;border-radius:6px;display:inline-flex;align-items:center;justify-content:center;background:rgba(96,165,250,0.15);color:#60a5fa;text-decoration:none;">
                        <i class="bx bx-show"></i>
                    </a>
                </td>
            </tr>
            <?php endforeach; endif; ?>
            </tbody>
        </table>
    </div>

</div><!-- /.new122 -->

<!-- ══════════════════════════════════════════════════════════════
     MODAL — NOVA RECEITA
══════════════════════════════════════════════════════════════ -->
<div id="modalNovaReceita" class="modal hide fade modal-dark" tabindex="-1" role="dialog" aria-hidden="true">
    <form id="formNovaReceita" action="<?= base_url() ?>index.php/financeiro/adicionarReceita" method="post">
        <input type="hidden" name="urlAtual" value="<?= current_url() ?>" />

        <div class="modal-header">
            <h3><i class='bx bx-trending-up modal-title-rec'></i> Nova Receita</h3>
            <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>

        <div class="modal-body">
            <div class="info-badge"><i class='bx bx-info-circle'></i> Campos marcados com * são obrigatórios.</div>

            <div class="row-cols">
                <div style="flex:2">
                    <div class="form-group">
                        <label>Descrição / Referência *</label>
                        <input type="text" name="descricao" id="rec_descricao" required placeholder="Ex: Pagamento OS #123" />
                    </div>
                </div>
                <div style="flex:1">
                    <div class="form-group">
                        <label>Valor (R$) *</label>
                        <input type="text" name="valor" id="rec_valor" class="money-rec" required placeholder="0,00" />
                        <input type="hidden" name="valor_desconto" id="rec_valor_desconto" value="0" />
                    </div>
                </div>
            </div>

            <div class="form-group">
                <label>Cliente / Fornecedor *</label>
                <input type="text" name="cliente" id="rec_cliente" required placeholder="Digite para buscar..." />
                <input type="hidden" name="idCliente" id="rec_idCliente" />
            </div>

            <div class="row-cols">
                <div>
                    <div class="form-group">
                        <label>Data de Vencimento *</label>
                        <input type="text" name="vencimento" id="rec_vencimento" class="datepicker" autocomplete="off" required placeholder="dd/mm/aaaa" />
                    </div>
                </div>
                <div>
                    <div class="form-group">
                        <label>Qtd. Parcelas</label>
                        <select name="qtdparcelas" id="rec_qtdparcelas">
                            <option value="0">À vista</option>
                            <?php for($p=1;$p<=12;$p++): ?>
                            <option value="<?=$p?>"><?=$p?>x</option>
                            <?php endfor; ?>
                        </select>
                    </div>
                </div>
                <div>
                    <div class="form-group">
                        <label>Desconto (R$)</label>
                        <input type="text" name="descontos" id="rec_descontos" class="money-rec" placeholder="0,00" />
                    </div>
                </div>
            </div>

            <div class="check-row">
                <input type="checkbox" name="recebido" id="rec_recebido" value="1" />
                <label for="rec_recebido">Já foi recebido?</label>
            </div>

            <div id="rec_divRecebimento" style="display:none;">
                <hr class="divider" />
                <div class="row-cols">
                    <div>
                        <div class="form-group">
                            <label>Data do Recebimento</label>
                            <input type="text" name="recebimento" id="rec_recebimento" class="datepicker" autocomplete="off" placeholder="dd/mm/aaaa" />
                        </div>
                    </div>
                    <div>
                        <div class="form-group">
                            <label>Forma de Pagamento</label>
                            <select name="formaPgto" id="rec_formaPgto">
                                <option value="Dinheiro">Dinheiro</option>
                                <option value="Pix">Pix</option>
                                <option value="Boleto">Boleto</option>
                                <option value="Cartão de Crédito">Cartão de Crédito</option>
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

            <div class="form-group">
                <label>Observações</label>
                <textarea name="observacoes" id="rec_observacoes" placeholder="Informações adicionais..."></textarea>
            </div>
        </div>

        <div class="modal-footer">
            <button type="button" class="button btn btn-warning" data-dismiss="modal">
                <span class="button__icon"><i class="bx bx-x"></i></span>
                <span class="button__text2">Cancelar</span>
            </button>
            <button type="submit" class="button btn btn-success" id="btnSubmitReceita">
                <span class="button__icon"><i class='bx bx-save'></i></span>
                <span class="button__text2">Salvar Receita</span>
            </button>
        </div>
    </form>
</div>

<!-- ══════════════════════════════════════════════════════════════
     MODAL — NOVA RECEITA PARCELADA (disparado pelo select de parcelas)
══════════════════════════════════════════════════════════════ -->
<div id="modalNovaReceitaParc" class="modal hide fade modal-dark" tabindex="-1" role="dialog" aria-hidden="true">
    <form id="formNovaReceitaParc" action="<?= base_url() ?>index.php/financeiro/adicionarReceita_parc" method="post">
        <input type="hidden" name="urlAtual" value="<?= current_url() ?>" />
        <input type="hidden" name="tipo_parc" value="receita" />

        <div class="modal-header">
            <h3><i class='bx bx-trending-up modal-title-rec'></i> Nova Receita Parcelada</h3>
            <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>

        <div class="modal-body">
            <div class="info-badge"><i class='bx bx-info-circle'></i> Preencha os dados do parcelamento.</div>

            <div class="row-cols">
                <div style="flex:2">
                    <div class="form-group">
                        <label>Descrição *</label>
                        <input type="text" name="descricao_parc" id="parc_descricao" required />
                    </div>
                </div>
                <div style="flex:1">
                    <div class="form-group">
                        <label>Valor Total (R$) *</label>
                        <input type="text" name="valor_parc" id="parc_valor" class="money-parc" required />
                    </div>
                </div>
            </div>

            <div class="form-group">
                <label>Cliente *</label>
                <input type="text" name="cliente_parc" id="parc_cliente" required />
                <input type="hidden" name="idCliente_parc" id="parc_idCliente" />
            </div>

            <div class="row-cols">
                <div>
                    <div class="form-group">
                        <label>Nº de Parcelas</label>
                        <select name="qtdparcelas_parc" id="parc_qtd">
                            <?php for($p=1;$p<=12;$p++): ?>
                            <option value="<?=$p?>"><?=$p?>x</option>
                            <?php endfor; ?>
                        </select>
                    </div>
                </div>
                <div>
                    <div class="form-group">
                        <label>Forma de Pagamento</label>
                        <select name="formaPgto_parc" id="parc_formaPgto">
                            <option value="Dinheiro">Dinheiro</option>
                            <option value="Pix">Pix</option>
                            <option value="Boleto">Boleto</option>
                            <option value="Cartão de Crédito">Cartão de Crédito</option>
                            <option value="Cartão de Débito">Cartão de Débito</option>
                            <option value="Cheque">Cheque</option>
                            <option value="Depósito">Depósito</option>
                            <option value="Transferência TED">Transferência TED</option>
                        </select>
                    </div>
                </div>
                <div>
                    <div class="form-group">
                        <label>Desconto (R$)</label>
                        <input type="text" name="desconto_parc" id="parc_desconto" class="money-parc" placeholder="0,00" />
                    </div>
                </div>
            </div>

            <div class="row-cols">
                <div>
                    <div class="form-group">
                        <label>Entrada (R$)</label>
                        <input type="text" name="entrada" id="parc_entrada" class="money-parc" value="0" />
                    </div>
                </div>
                <div>
                    <div class="form-group">
                        <label>Data da Entrada *</label>
                        <input type="text" name="dia_pgto" id="parc_dia_pgto" class="datepicker" autocomplete="off" value="<?= date('d/m/Y') ?>" required />
                    </div>
                </div>
                <div>
                    <div class="form-group">
                        <label>Data Base das Parcelas *</label>
                        <input type="text" name="dia_base_pgto" id="parc_dia_base" class="datepicker" autocomplete="off" required />
                    </div>
                </div>
            </div>

            <div class="parc-summary" id="parc_resumo">Preencha valor e parcelas para calcular</div>

            <div class="form-group" style="margin-top:12px;">
                <label>Observações</label>
                <textarea name="observacoes_parc" id="parc_observacoes"></textarea>
            </div>
        </div>

        <div class="modal-footer">
            <button type="button" class="button btn btn-warning" data-dismiss="modal">
                <span class="button__icon"><i class="bx bx-x"></i></span>
                <span class="button__text2">Cancelar</span>
            </button>
            <button type="submit" class="button btn btn-success" id="btnSubmitParc">
                <span class="button__icon"><i class='bx bx-save'></i></span>
                <span class="button__text2">Salvar Parcelamento</span>
            </button>
        </div>
    </form>
</div>

<!-- ══════════════════════════════════════════════════════════════
     MODAL — NOVA DESPESA
══════════════════════════════════════════════════════════════ -->
<div id="modalNovaDespesa" class="modal hide fade modal-dark" tabindex="-1" role="dialog" aria-hidden="true">
    <form id="formNovaDespesa" action="<?= base_url() ?>index.php/financeiro/adicionarDespesa" method="post">
        <input type="hidden" name="urlAtual" value="<?= current_url() ?>" />

        <div class="modal-header">
            <h3><i class='bx bx-trending-down modal-title-desp'></i> Nova Despesa</h3>
            <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>

        <div class="modal-body">
            <div class="info-badge" style="background:rgba(239,68,68,0.08);border-color:rgba(239,68,68,0.3);color:#fca5a5;">
                <i class='bx bx-info-circle'></i> Campos marcados com * são obrigatórios.
            </div>

            <div class="row-cols">
                <div style="flex:2">
                    <div class="form-group">
                        <label>Descrição / Referência *</label>
                        <input type="text" name="descricao_desp" id="desp_descricao" required placeholder="Ex: Aluguel, Conta de luz..." />
                    </div>
                </div>
                <div style="flex:1">
                    <div class="form-group">
                        <label>Valor (R$) *</label>
                        <input type="text" name="valor_desp" id="desp_valor" class="money-desp" required placeholder="0,00" />
                    </div>
                </div>
            </div>

            <div class="form-group">
                <label>Fornecedor / Empresa *</label>
                <input type="text" name="fornecedor_desp" id="desp_fornecedor" required placeholder="Digite para buscar..." />
                <input type="hidden" name="idFornecedor_desp" id="desp_idFornecedor" />
            </div>

            <div class="row-cols">
                <div>
                    <div class="form-group">
                        <label>Data de Vencimento *</label>
                        <input type="text" name="vencimento_desp" id="desp_vencimento" class="datepicker" autocomplete="off" required placeholder="dd/mm/aaaa" />
                    </div>
                </div>
                <div>
                    <div class="form-group">
                        <label>Categoria</label>
                        <select name="categoria_desp" id="desp_categoria">
                            <option value="">— Sem categoria —</option>
                            <?php
                            // Carrega categorias de despesa se disponíveis
                            if (!empty($categorias)) {
                                foreach ($categorias as $cat):
                            ?>
                            <option value="<?= $cat->idCategorias ?>"><?= htmlspecialchars($cat->categoria) ?></option>
                            <?php endforeach; } ?>
                        </select>
                    </div>
                </div>
            </div>

            <div class="check-row">
                <input type="checkbox" name="pago_desp" id="desp_pago" value="1" />
                <label for="desp_pago">Já foi pago?</label>
            </div>

            <div id="desp_divPagamento" style="display:none;">
                <hr class="divider" />
                <div class="row-cols">
                    <div>
                        <div class="form-group">
                            <label>Data do Pagamento</label>
                            <input type="text" name="pagamento_desp" id="desp_pagamento" class="datepicker" autocomplete="off" placeholder="dd/mm/aaaa" />
                        </div>
                    </div>
                    <div>
                        <div class="form-group">
                            <label>Forma de Pagamento</label>
                            <select name="formaPgto_desp" id="desp_formaPgto">
                                <option value="Dinheiro">Dinheiro</option>
                                <option value="Pix">Pix</option>
                                <option value="Boleto">Boleto</option>
                                <option value="Cartão de Crédito">Cartão de Crédito</option>
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

            <div class="form-group">
                <label>Observações</label>
                <textarea name="observacoes_desp" id="desp_observacoes" placeholder="Informações adicionais..."></textarea>
            </div>
        </div>

        <div class="modal-footer">
            <button type="button" class="button btn btn-warning" data-dismiss="modal">
                <span class="button__icon"><i class="bx bx-x"></i></span>
                <span class="button__text2">Cancelar</span>
            </button>
            <button type="submit" class="button btn btn-danger" id="btnSubmitDespesa">
                <span class="button__icon"><i class='bx bx-save'></i></span>
                <span class="button__text2">Salvar Despesa</span>
            </button>
        </div>
    </form>
</div>

<!-- Gráfico -->
<script>
var ctx = document.getElementById('graficoFinanceiro').getContext('2d');
new Chart(ctx, {
    type: 'bar',
    data: {
        labels: ['Rec. Pagas','Desp. Pagas','Rec. Pendentes','Desp. Pendentes','Saldo'],
        datasets: [{
            data: [<?=$recPagas?>,<?=$despPagas?>,<?=$recPend?>,<?=$despPend?>,<?=max(0,$saldo)?>],
            backgroundColor: ['rgba(34,197,94,0.8)','rgba(239,68,68,0.8)','rgba(34,197,94,0.3)','rgba(239,68,68,0.3)','rgba(59,130,246,0.8)'],
            borderRadius: 8,
            borderSkipped: false,
        }]
    },
    options: {
        plugins: { legend: { display: false } },
        scales: {
            y: { beginAtZero: true, grid: { color: 'rgba(255,255,255,0.05)' }, ticks: { color: '#6b7280', callback: v => 'R$ '+v.toLocaleString('pt-BR') } },
            x: { grid: { display: false }, ticks: { color: '#6b7280' } }
        }
    }
});
</script>

<script src="<?php echo base_url() ?>assets/js/jquery.validate.js"></script>
<script src="<?php echo base_url(); ?>assets/js/maskmoney.js"></script>
<script>
jQuery(document).ready(function($) {

    // ── Máscaras de dinheiro ──────────────────────────────────────
    $(".money-rec, .money-desp, .money-parc").maskMoney({ thousands: '.', decimal: ',' });

    // ── Datepickers ───────────────────────────────────────────────
    $(".datepicker").datepicker({ dateFormat: 'dd/mm/yy' });

    // ── Autocomplete — Receita: cliente ──────────────────────────
    $("#rec_cliente").autocomplete({
        source: "<?= base_url() ?>index.php/financeiro/autoCompleteClienteAddReceita",
        minLength: 1,
        select: function(e, ui) {
            $("#rec_cliente").val(ui.item.label);
            $("#rec_idCliente").val(ui.item.id);
            return false;
        }
    });

    // ── Autocomplete — Parcelada: cliente ────────────────────────
    $("#parc_cliente").autocomplete({
        source: "<?= base_url() ?>index.php/financeiro/autoCompleteClienteAddReceita",
        minLength: 1,
        select: function(e, ui) {
            $("#parc_cliente").val(ui.item.label);
            $("#parc_idCliente").val(ui.item.id);
            return false;
        }
    });

    // ── Autocomplete — Despesa: fornecedor ───────────────────────
    $("#desp_fornecedor").autocomplete({
        source: "<?= base_url() ?>index.php/financeiro/autoCompleteClienteAddReceita",
        minLength: 1,
        select: function(e, ui) {
            $("#desp_fornecedor").val(ui.item.label);
            $("#desp_idFornecedor").val(ui.item.id);
            return false;
        }
    });

    // ── Receita: toggle "Já foi recebido?" ───────────────────────
    $('#rec_recebido').on('change', function() {
        $('#rec_divRecebimento').toggle(this.checked);
    });

    // ── Receita: parcelas — se > 0 abre modal de parcelamento ────
    $('#rec_qtdparcelas').on('change', function() {
        var qtd = parseInt($(this).val());
        if (qtd >= 1) {
            // Copia dados para o modal parcelado
            $('#parc_descricao').val($('#rec_descricao').val());
            $('#parc_cliente').val($('#rec_cliente').val());
            $('#parc_idCliente').val($('#rec_idCliente').val());
            $('#parc_valor').val($('#rec_valor').val());
            $('#parc_qtd').val(qtd);
            $('#parc_observacoes').val($('#rec_observacoes').val());
            // Fecha modal receita e abre parcelado
            $('#modalNovaReceita').modal('hide');
            setTimeout(function(){ $('#modalNovaReceitaParc').modal('show'); }, 400);
        }
    });

    // ── Parcelado: calcula resumo ─────────────────────────────────
    function calcularParcelas() {
        var valor = parseFloat($('#parc_valor').val().replace(/\./g,'').replace(',','.')) || 0;
        var desc  = parseFloat($('#parc_desconto').val().replace(/\./g,'').replace(',','.')) || 0;
        var ent   = parseFloat($('#parc_entrada').val().replace(/\./g,'').replace(',','.')) || 0;
        var qtd   = parseInt($('#parc_qtd').val()) || 1;
        var base  = valor - desc - ent;
        if (base <= 0) { $('#parc_resumo').text('Verifique os valores'); return; }
        var parc  = base / qtd;
        var txt   = qtd + 'x de R$ ' + parc.toFixed(2).replace('.',',');
        if (ent > 0) txt = 'Entrada R$ ' + ent.toFixed(2).replace('.',',') + ' + ' + txt;
        $('#parc_resumo').text(txt);
    }
    $('#parc_valor, #parc_desconto, #parc_entrada, #parc_qtd').on('input change keyup', calcularParcelas);

    // ── Despesa: toggle "Já foi pago?" ───────────────────────────
    $('#desp_pago').on('change', function() {
        $('#desp_divPagamento').toggle(this.checked);
    });

    // ── Validação Receita ─────────────────────────────────────────
    $("#formNovaReceita").validate({
        rules: {
            descricao: { required: true },
            cliente:   { required: true },
            valor:     { required: true },
            vencimento:{ required: true }
        },
        messages: {
            descricao:  { required: 'Campo obrigatório.' },
            cliente:    { required: 'Campo obrigatório.' },
            valor:      { required: 'Campo obrigatório.' },
            vencimento: { required: 'Campo obrigatório.' }
        },
        submitHandler: function(form) {
            $('#btnSubmitReceita').attr('disabled', true);
            form.submit();
        }
    });

    // ── Validação Despesa ─────────────────────────────────────────
    $("#formNovaDespesa").validate({
        rules: {
            descricao_desp:   { required: true },
            fornecedor_desp:  { required: true },
            valor_desp:       { required: true },
            vencimento_desp:  { required: true }
        },
        messages: {
            descricao_desp:   { required: 'Campo obrigatório.' },
            fornecedor_desp:  { required: 'Campo obrigatório.' },
            valor_desp:       { required: 'Campo obrigatório.' },
            vencimento_desp:  { required: 'Campo obrigatório.' }
        },
        submitHandler: function(form) {
            $('#btnSubmitDespesa').attr('disabled', true);
            form.submit();
        }
    });

    // ── Validação Parcelado ───────────────────────────────────────
    $("#formNovaReceitaParc").validate({
        rules: {
            descricao_parc: { required: true },
            cliente_parc:   { required: true },
            valor_parc:     { required: true },
            dia_base_pgto:  { required: true }
        },
        submitHandler: function(form) {
            $('#btnSubmitParc').attr('disabled', true);
            form.submit();
        }
    });

});
</script>
