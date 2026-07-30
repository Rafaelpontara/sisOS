<style>
.cx-wrap{max-width:900px;margin:0 auto;padding:0 16px 40px;}
.cx-header{display:flex;align-items:center;justify-content:space-between;margin-bottom:18px;flex-wrap:wrap;gap:10px;}
.cx-title{font-size:20px;font-weight:800;color:#e8eaf0;display:flex;align-items:center;gap:10px;}
.cx-badge-open{padding:4px 12px;background:rgba(34,197,94,0.15);color:#4ade80;border:1px solid rgba(34,197,94,0.3);border-radius:20px;font-size:12px;font-weight:700;}
.cx-kpis{display:grid;grid-template-columns:repeat(auto-fill,minmax(170px,1fr));gap:12px;margin-bottom:18px;}
.cx-kpi{background:#1a1d2e;border:1px solid rgba(255,255,255,0.07);border-radius:14px;padding:14px 16px;}
.cx-kpi-label{font-size:10px;font-weight:700;color:#6b7280;text-transform:uppercase;letter-spacing:.6px;margin-bottom:6px;}
.cx-kpi-val{font-size:20px;font-weight:800;}
.cx-card{background:#1a1d2e;border:1px solid rgba(255,255,255,0.07);border-radius:14px;overflow:hidden;margin-bottom:14px;}
.cx-card-head{display:flex;align-items:center;gap:8px;padding:11px 16px;background:#252a3a;border-bottom:1px solid rgba(255,255,255,0.06);}
.cx-card-head i{font-size:16px;}.cx-card-head span{font-size:11px;font-weight:700;color:#9ca3af;text-transform:uppercase;letter-spacing:.8px;flex:1;}
/* Ações */
.cx-actions{display:flex;gap:10px;flex-wrap:wrap;margin-bottom:18px;}
.cx-btn{display:inline-flex;align-items:center;gap:7px;padding:10px 18px;border-radius:10px;font-size:13px;font-weight:700;border:none;cursor:pointer;transition:all .15s;text-decoration:none;}
.cx-btn:hover{transform:translateY(-1px);}
.cx-btn-sangria{background:rgba(251,146,60,0.15);color:#fb923c;border:1px solid rgba(251,146,60,0.3);}
.cx-btn-entrada{background:rgba(34,197,94,0.15);color:#4ade80;border:1px solid rgba(34,197,94,0.3);}
.cx-btn-fechar{background:rgba(239,68,68,0.15);color:#f87171;border:1px solid rgba(239,68,68,0.3);}
.cx-btn-pdv{background:linear-gradient(135deg,#6366f1,#4f46e5);color:#fff;box-shadow:0 4px 14px rgba(99,102,241,0.3);}
/* Tabela movimentos */
.cx-tbl{width:100%;border-collapse:collapse;}
.cx-tbl thead th{background:#252a3a;color:#9ca3af;font-size:11px;font-weight:700;text-transform:uppercase;padding:9px 14px;border-bottom:1px solid rgba(255,255,255,0.07);}
.cx-tbl thead th.r{text-align:right;}
.cx-tbl tbody tr{border-bottom:1px solid rgba(255,255,255,0.04);}
.cx-tbl tbody tr:hover{background:rgba(255,255,255,0.02);}
.cx-tbl tbody td{padding:9px 14px;font-size:13px;color:#c9cad6;}
.cx-tbl tbody td.r{text-align:right;}
/* Badges tipo */
.tip-abertura{background:rgba(99,102,241,0.15);color:#a5b4fc;}
.tip-venda   {background:rgba(34,197,94,0.15); color:#4ade80;}
.tip-sangria {background:rgba(251,146,60,0.15);color:#fb923c;}
.tip-entrada {background:rgba(96,165,250,0.15);color:#60a5fa;}
.tip-fechamento{background:rgba(239,68,68,0.15);color:#f87171;}
.tipo-badge{display:inline-block;padding:2px 10px;border-radius:20px;font-size:11px;font-weight:700;}
/* Modal */
.cx-modal-bg{display:none;position:fixed;inset:0;background:rgba(0,0,0,.7);z-index:9999;align-items:center;justify-content:center;}
.cx-modal-bg.show{display:flex;}
.cx-modal{background:#1a1d2e;border:1px solid rgba(255,255,255,0.1);border-radius:18px;padding:28px;width:100%;max-width:400px;}
.cx-modal h3{font-size:16px;font-weight:800;color:#e8eaf0;margin-bottom:18px;display:flex;align-items:center;gap:8px;}
.cx-field{margin-bottom:14px;}
.cx-label{font-size:11px;font-weight:700;color:#9ca3af;text-transform:uppercase;letter-spacing:.5px;display:block;margin-bottom:5px;}
.cx-input{width:100%;background:#252a3a;border:1px solid #444860;color:#e8eaf0;border-radius:9px;padding:10px 14px;font-size:14px;transition:border-color .15s;}
.cx-input:focus{outline:none;border-color:#6366f1;}
.cx-modal-actions{display:flex;gap:8px;margin-top:18px;}
.cx-modal-actions button,.cx-modal-actions a{flex:1;padding:11px;border-radius:9px;font-size:13px;font-weight:700;cursor:pointer;border:none;text-align:center;text-decoration:none;}
</style>

<div class="cx-wrap">

    <?php if ($this->session->flashdata('success')): ?>
    <div style="background:rgba(34,197,94,0.12);border:1px solid rgba(34,197,94,0.3);border-radius:10px;padding:12px 16px;color:#4ade80;font-size:13px;display:flex;align-items:center;gap:8px;margin-bottom:16px;">
        <i class='bx bx-check-circle'></i> <?= htmlspecialchars($this->session->flashdata('success')) ?>
    </div>
    <?php endif; ?>

    <!-- Header -->
    <div class="cx-header">
        <div class="cx-title">
            <i class='bx bx-store' style="color:#22c55e;"></i>
            Caixa do Dia
            <span class="cx-badge-open"><i class='bx bx-circle bx-flashing'></i> Aberto</span>
        </div>
        <span style="font-size:12px;color:#6b7280;">
            Aberto em: <?= date('d/m/Y H:i', strtotime($sessao->data_abertura)) ?>
            &nbsp;|&nbsp; <?= $this->session->userdata('nome_admin') ?? $this->session->userdata('nome') ?>
        </span>
    </div>

    <!-- KPIs -->
    <div class="cx-kpis">
        <div class="cx-kpi" style="border-color:rgba(99,102,241,0.3);">
            <div class="cx-kpi-label">Saldo Inicial</div>
            <div class="cx-kpi-val" style="color:#a5b4fc;">R$ <?= number_format($sessao->saldo_inicial,2,',','.') ?></div>
        </div>
        <div class="cx-kpi" style="border-color:rgba(34,197,94,0.3);">
            <div class="cx-kpi-label">Vendas (<?= $totais['qtd_vendas'] ?? 0 ?>)</div>
            <div class="cx-kpi-val" style="color:#22c55e;">R$ <?= number_format($totais['total_vendas']??0,2,',','.') ?></div>
        </div>
        <div class="cx-kpi" style="border-color:rgba(251,146,60,0.3);">
            <div class="cx-kpi-label">Sangrias</div>
            <div class="cx-kpi-val" style="color:#fb923c;">- R$ <?= number_format($totais['total_sangrias']??0,2,',','.') ?></div>
        </div>
        <div class="cx-kpi" style="border-color:rgba(96,165,250,0.3);">
            <div class="cx-kpi-label">Entradas</div>
            <div class="cx-kpi-val" style="color:#60a5fa;">R$ <?= number_format($totais['total_entradas']??0,2,',','.') ?></div>
        </div>
        <div class="cx-kpi" style="border-color:rgba(251,191,36,0.3);background:rgba(251,191,36,0.05);">
            <div class="cx-kpi-label">Saldo Esperado</div>
            <div class="cx-kpi-val" style="color:#fbbf24;">R$ <?= number_format($totais['saldo_esperado']??0,2,',','.') ?></div>
        </div>
    </div>

    <!-- Ações -->
    <div class="cx-actions">
        <a href="<?= site_url('pdv') ?>" class="cx-btn cx-btn-pdv">
            <i class='bx bx-store-alt'></i> Ir para o PDV
        </a>
        <button class="cx-btn cx-btn-sangria" onclick="abrirModal('modalSangria')">
            <i class='bx bx-minus-circle'></i> Sangria
        </button>
        <button class="cx-btn cx-btn-entrada" onclick="abrirModal('modalEntrada')">
            <i class='bx bx-plus-circle'></i> Entrada
        </button>
        <button class="cx-btn cx-btn-fechar" onclick="abrirModal('modalFechar')">
            <i class='bx bx-door-open'></i> Fechar Caixa
        </button>
    </div>

    <!-- Movimentos -->
    <div class="cx-card">
        <div class="cx-card-head">
            <i class='bx bx-list-ul' style="color:#6366f1;"></i>
            <span>Movimentos do Caixa</span>
        </div>
        <div style="overflow-x:auto;">
        <table class="cx-tbl">
            <thead>
                <tr>
                    <th>Hora</th>
                    <th>Tipo</th>
                    <th>Descrição</th>
                    <th>Forma Pgto</th>
                    <th class="r">Valor</th>
                </tr>
            </thead>
            <tbody>
            <?php if (!empty($movimentos)): foreach ($movimentos as $m): ?>
            <tr>
                <td style="font-size:12px;color:#9ca3af;white-space:nowrap;"><?= date('H:i', strtotime($m->created_at)) ?></td>
                <td><span class="tipo-badge tip-<?= $m->tipo ?>"><?= ucfirst($m->tipo) ?></span></td>
                <td style="color:#c9cad6;"><?= htmlspecialchars($m->descricao ?? '') ?></td>
                <td style="font-size:12px;color:#9ca3af;"><?= htmlspecialchars($m->forma_pgto ?? '—') ?></td>
                <td class="r" style="font-weight:700;color:<?= in_array($m->tipo, ['sangria']) ? '#fb923c' : '#4ade80' ?>;">
                    <?= in_array($m->tipo, ['sangria']) ? '- ' : '' ?>R$ <?= number_format($m->valor,2,',','.') ?>
                </td>
            </tr>
            <?php endforeach; else: ?>
            <tr><td colspan="5" style="text-align:center;padding:30px;color:#6b7280;">Nenhum movimento registrado ainda.</td></tr>
            <?php endif; ?>
            </tbody>
        </table>
        </div>
    </div>
</div>

<!-- Modal Sangria -->
<div class="cx-modal-bg" id="modalSangria">
    <div class="cx-modal">
        <h3><i class='bx bx-minus-circle' style="color:#fb923c;"></i> Registrar Sangria</h3>
        <div class="cx-field">
            <label class="cx-label">Valor (R$) *</label>
            <input type="text" class="cx-input" id="sangria_valor" placeholder="0,00">
        </div>
        <div class="cx-field">
            <label class="cx-label">Motivo</label>
            <input type="text" class="cx-input" id="sangria_desc" placeholder="Ex: Pagamento de fornecedor...">
        </div>
        <div class="cx-modal-actions">
            <button onclick="fecharModal('modalSangria')" style="background:rgba(255,255,255,0.07);color:#9ca3af;">Cancelar</button>
            <button onclick="registrarSangria()" style="background:linear-gradient(135deg,#fb923c,#ea580c);color:#fff;">Confirmar Sangria</button>
        </div>
    </div>
</div>

<!-- Modal Entrada -->
<div class="cx-modal-bg" id="modalEntrada">
    <div class="cx-modal">
        <h3><i class='bx bx-plus-circle' style="color:#4ade80;"></i> Registrar Entrada</h3>
        <div class="cx-field">
            <label class="cx-label">Valor (R$) *</label>
            <input type="text" class="cx-input" id="entrada_valor" placeholder="0,00">
        </div>
        <div class="cx-field">
            <label class="cx-label">Descrição</label>
            <input type="text" class="cx-input" id="entrada_desc" placeholder="Ex: Pagamento antecipado...">
        </div>
        <div class="cx-field">
            <label class="cx-label">Forma de Pagamento</label>
            <select class="cx-input" id="entrada_forma">
                <option>Dinheiro</option><option>PIX</option><option>Débito</option><option>Crédito</option><option>Transferência</option>
            </select>
        </div>
        <div class="cx-modal-actions">
            <button onclick="fecharModal('modalEntrada')" style="background:rgba(255,255,255,0.07);color:#9ca3af;">Cancelar</button>
            <button onclick="registrarEntrada()" style="background:linear-gradient(135deg,#22c55e,#16a34a);color:#fff;">Confirmar Entrada</button>
        </div>
    </div>
</div>

<!-- Modal Fechar Caixa -->
<div class="cx-modal-bg" id="modalFechar">
    <div class="cx-modal">
        <h3><i class='bx bx-door-open' style="color:#f87171;"></i> Fechar Caixa</h3>
        <div style="background:rgba(251,191,36,0.08);border:1px solid rgba(251,191,36,0.2);border-radius:10px;padding:12px;margin-bottom:16px;font-size:13px;color:#fbbf24;">
            <i class='bx bx-info-circle'></i>
            Saldo esperado em caixa: <strong>R$ <?= number_format($totais['saldo_esperado']??0,2,',','.') ?></strong>
        </div>
        <form action="<?= site_url('caixa/fechar') ?>" method="post">
            <div class="cx-field">
                <label class="cx-label">Saldo Contado em Caixa (R$) *</label>
                <input type="text" name="saldo_final" class="cx-input" placeholder="0,00"
                       value="<?= number_format($totais['saldo_esperado']??0,2,',','.') ?>">
            </div>
            <div class="cx-field">
                <label class="cx-label">Observações</label>
                <input type="text" name="observacoes" class="cx-input" placeholder="Opcional...">
            </div>
            <div class="cx-modal-actions">
                <button type="button" onclick="fecharModal('modalFechar')" style="background:rgba(255,255,255,0.07);color:#9ca3af;">Cancelar</button>
                <button type="submit" style="background:linear-gradient(135deg,#ef4444,#dc2626);color:#fff;">Confirmar Fechamento</button>
            </div>
        </form>
    </div>
</div>

<script>
function abrirModal(id) { document.getElementById(id).classList.add('show'); }
function fecharModal(id) { document.getElementById(id).classList.remove('show'); }

// Fechar ao clicar fora
document.querySelectorAll('.cx-modal-bg').forEach(function(m) {
    m.addEventListener('click', function(e) { if (e.target === m) m.classList.remove('show'); });
});

function registrarSangria() {
    var valor = document.getElementById('sangria_valor').value;
    var desc  = document.getElementById('sangria_desc').value;
    if (!valor) { alert('Informe o valor.'); return; }
    $.post('<?= site_url('caixa/sangria') ?>', {valor: valor, descricao: desc}, function(r) {
        if (r.status) { location.reload(); } else { alert(r.message); }
    }, 'json');
}

function registrarEntrada() {
    var valor = document.getElementById('entrada_valor').value;
    var desc  = document.getElementById('entrada_desc').value;
    var forma = document.getElementById('entrada_forma').value;
    if (!valor) { alert('Informe o valor.'); return; }
    $.post('<?= site_url('caixa/entrada') ?>', {valor: valor, descricao: desc, forma_pgto: forma}, function(r) {
        if (r.status) { location.reload(); } else { alert(r.message); }
    }, 'json');
}
</script>
