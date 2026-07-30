<style>
.cx-wrap{max-width:480px;margin:60px auto;padding:0 16px;}
.cx-card{background:#1a1d2e;border:1px solid rgba(255,255,255,0.08);border-radius:18px;overflow:hidden;}
.cx-head{padding:20px 24px;background:#252a3a;border-bottom:1px solid rgba(255,255,255,0.06);display:flex;align-items:center;gap:10px;}
.cx-head i{font-size:22px;color:#22c55e;}
.cx-head h2{font-size:16px;font-weight:800;color:#e8eaf0;margin:0;}
.cx-body{padding:28px 24px;}
.cx-field{margin-bottom:18px;}
.cx-label{font-size:11px;font-weight:700;color:#9ca3af;text-transform:uppercase;letter-spacing:.6px;display:block;margin-bottom:6px;}
.cx-input{width:100%;background:#252a3a;border:1px solid #444860;color:#e8eaf0;border-radius:10px;padding:12px 16px;font-size:16px;font-weight:700;transition:border-color .15s;}
.cx-input:focus{outline:none;border-color:#22c55e;box-shadow:0 0 0 3px rgba(34,197,94,0.12);}
.cx-input::placeholder{color:#6b7280;font-weight:400;}
.cx-info{background:rgba(34,197,94,0.08);border:1px solid rgba(34,197,94,0.2);border-radius:10px;padding:12px 16px;font-size:13px;color:#4ade80;display:flex;align-items:flex-start;gap:8px;margin-bottom:20px;}
.cx-btn{display:flex;align-items:center;justify-content:center;gap:8px;width:100%;padding:14px;background:linear-gradient(135deg,#22c55e,#16a34a);color:#fff;border:none;border-radius:10px;font-size:15px;font-weight:800;cursor:pointer;transition:all .15s;box-shadow:0 4px 14px rgba(34,197,94,0.3);}
.cx-btn:hover{transform:translateY(-1px);}
.cx-footer{text-align:center;margin-top:16px;font-size:12px;color:#6b7280;}
.cx-footer a{color:#6366f1;text-decoration:none;}
</style>

<div class="cx-wrap">

    <?php if ($this->session->flashdata('error')): ?>
    <div style="background:rgba(239,68,68,0.12);border:1px solid rgba(239,68,68,0.3);border-radius:10px;padding:12px 16px;color:#f87171;font-size:13px;display:flex;align-items:center;gap:8px;margin-bottom:16px;">
        <i class='bx bx-error-circle'></i> <?= htmlspecialchars($this->session->flashdata('error')) ?>
    </div>
    <?php endif; ?>

    <div class="cx-card">
        <div class="cx-head">
            <i class='bx bx-door-open'></i>
            <div>
                <h2>Abrir Caixa</h2>
                <span style="font-size:12px;color:#9ca3af;"><?= date('d/m/Y') ?> — <?= $this->session->userdata('nome_admin') ?? $this->session->userdata('nome') ?></span>
            </div>
        </div>
        <div class="cx-body">
            <div class="cx-info">
                <i class='bx bx-info-circle' style="flex-shrink:0;font-size:18px;"></i>
                <span>Informe o valor em caixa no início do dia (troco, fundo de caixa, etc.). Deixe 0,00 se não houver saldo inicial.</span>
            </div>

            <form action="<?= site_url('caixa/abrir') ?>" method="post">
                <div class="cx-field">
                    <label class="cx-label">Saldo Inicial (R$)</label>
                    <input type="text" name="saldo_inicial" class="cx-input" placeholder="0,00"
                           value="0,00" id="saldoInicial">
                </div>
                <div class="cx-field">
                    <label class="cx-label">Observações (opcional)</label>
                    <input type="text" name="observacoes" class="cx-input" placeholder="Ex: Caixa do dia, turno manhã...">
                </div>
                <button type="submit" class="cx-btn">
                    <i class='bx bx-play-circle'></i> Abrir Caixa
                </button>
            </form>
        </div>
    </div>

    <div class="cx-footer">
        <a href="<?= site_url('caixa/historico') ?>"><i class='bx bx-history'></i> Ver histórico de caixas</a>
        &nbsp;|&nbsp;
        <a href="<?= site_url('pdv') ?>"><i class='bx bx-store'></i> Ir para o PDV</a>
    </div>
</div>

<script>
// Máscara simples de valor
document.getElementById('saldoInicial').addEventListener('blur', function() {
    var v = parseFloat(this.value.replace(',','.')) || 0;
    this.value = v.toFixed(2).replace('.',',');
});
</script>
