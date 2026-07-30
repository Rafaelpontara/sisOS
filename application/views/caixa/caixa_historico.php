<style>
.cx-wrap{max-width:1000px;margin:0 auto;}
.cx-header{display:flex;align-items:center;justify-content:space-between;margin-bottom:18px;flex-wrap:wrap;gap:10px;}
.cx-title{font-size:20px;font-weight:800;color:#e8eaf0;display:flex;align-items:center;gap:10px;}
.cx-card{background:#1a1d2e;border:1px solid rgba(255,255,255,0.07);border-radius:14px;overflow:hidden;}
.cx-card-head{display:flex;align-items:center;gap:8px;padding:11px 16px;background:#252a3a;border-bottom:1px solid rgba(255,255,255,0.06);}
.cx-card-head i{font-size:16px;}.cx-card-head span{font-size:11px;font-weight:700;color:#9ca3af;text-transform:uppercase;letter-spacing:.8px;}
.cx-tbl{width:100%;border-collapse:collapse;}
.cx-tbl thead th{background:#252a3a;color:#9ca3af;font-size:11px;font-weight:700;text-transform:uppercase;padding:9px 14px;border-bottom:1px solid rgba(255,255,255,0.07);}
.cx-tbl thead th.r{text-align:right;}
.cx-tbl tbody tr{border-bottom:1px solid rgba(255,255,255,0.04);transition:background .12s;}
.cx-tbl tbody tr:hover{background:rgba(255,255,255,0.02);}
.cx-tbl tbody td{padding:9px 14px;font-size:13px;color:#c9cad6;}
.cx-tbl tbody td.r{text-align:right;}
.badge{display:inline-block;padding:2px 10px;border-radius:20px;font-size:11px;font-weight:700;}
.b-open{background:rgba(34,197,94,0.15);color:#4ade80;}
.b-closed{background:rgba(156,163,175,0.15);color:#9ca3af;}
.cx-btn{display:inline-flex;align-items:center;gap:5px;padding:5px 12px;border-radius:7px;font-size:12px;font-weight:700;text-decoration:none;transition:all .15s;}
.cx-btn-view{background:rgba(96,165,250,0.15);color:#60a5fa;border:1px solid rgba(96,165,250,0.3);}
</style>

<div class="cx-wrap new122">
    <div class="cx-header">
        <div class="cx-title"><i class='bx bx-history' style="color:#6366f1;"></i> Histórico de Caixas</div>
        <a href="<?= site_url('caixa') ?>" class="cx-btn cx-btn-view">
            <i class='bx bx-store'></i> Caixa Atual
        </a>
    </div>

    <div class="cx-card">
        <div class="cx-card-head">
            <i class='bx bx-list-ul' style="color:#6366f1;"></i>
            <span>Últimas 50 sessões</span>
        </div>
        <div style="overflow-x:auto;">
        <table class="cx-tbl">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Operador</th>
                    <th>Abertura</th>
                    <th>Fechamento</th>
                    <th>Status</th>
                    <th class="r">Saldo Inicial</th>
                    <th class="r">Vendas</th>
                    <th class="r">Sangrias</th>
                    <th class="r">Saldo Final</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
            <?php if (!empty($sessoes)): foreach ($sessoes as $s): ?>
            <tr>
                <td style="color:#6b7280;font-size:12px;">#<?= $s->id ?></td>
                <td style="font-weight:600;color:#e8eaf0;"><?= htmlspecialchars($s->operador ?? '—') ?></td>
                <td style="font-size:12px;white-space:nowrap;"><?= date('d/m/Y H:i', strtotime($s->data_abertura)) ?></td>
                <td style="font-size:12px;white-space:nowrap;color:#9ca3af;">
                    <?= $s->data_fechamento ? date('d/m/Y H:i', strtotime($s->data_fechamento)) : '—' ?>
                </td>
                <td>
                    <span class="badge <?= $s->status === 'aberto' ? 'b-open' : 'b-closed' ?>">
                        <?= $s->status === 'aberto' ? 'Aberto' : 'Fechado' ?>
                    </span>
                </td>
                <td class="r">R$ <?= number_format($s->saldo_inicial,2,',','.') ?></td>
                <td class="r" style="color:#4ade80;">R$ <?= number_format($s->total_vendas??0,2,',','.') ?></td>
                <td class="r" style="color:#fb923c;">R$ <?= number_format($s->total_sangrias??0,2,',','.') ?></td>
                <td class="r" style="font-weight:700;color:#fbbf24;">
                    <?= $s->saldo_final !== null ? 'R$ '.number_format($s->saldo_final,2,',','.') : '—' ?>
                </td>
                <td>
                    <a href="<?= site_url('caixa/detalhe/'.$s->id) ?>" class="cx-btn cx-btn-view">
                        <i class='bx bx-show'></i> Ver
                    </a>
                </td>
            </tr>
            <?php endforeach; else: ?>
            <tr><td colspan="10" style="text-align:center;padding:40px;color:#6b7280;">Nenhuma sessão de caixa encontrada.</td></tr>
            <?php endif; ?>
            </tbody>
        </table>
        </div>
    </div>
</div>
