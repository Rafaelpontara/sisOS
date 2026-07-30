<style>
.suc-wrap { max-width:480px; margin:30px auto; }
.suc-icone { width:70px; height:70px; border-radius:50%; background:rgba(34,197,94,0.15); display:flex; align-items:center; justify-content:center; margin:0 auto 16px; }
.suc-icone i { font-size:36px; color:#4ade80; }
.suc-titulo { text-align:center; font-size:20px; font-weight:800; color:#e8eaf0; margin-bottom:4px; }
.suc-sub { text-align:center; font-size:13px; color:#9ca3af; margin-bottom:26px; }
.suc-sub strong { color:#a78bfa; }

.suc-grid { display:grid; grid-template-columns:1fr 1fr 1fr; gap:10px; margin-bottom:14px; }
.suc-opcao {
    background:#1a1d2e; border:1px solid rgba(255,255,255,0.07); border-radius:14px;
    padding:18px 10px; text-align:center; text-decoration:none; transition:transform .15s,border-color .15s;
}
.suc-opcao:hover { transform:translateY(-3px); border-color:rgba(167,139,250,0.3); color:inherit; }
.suc-opcao-icon { width:42px; height:42px; border-radius:12px; display:flex; align-items:center; justify-content:center; font-size:20px; margin:0 auto 10px; }
.suc-opcao-titulo { font-size:12.5px; font-weight:700; color:#e8eaf0; }
.suc-opcao-sub { font-size:10.5px; color:#6b7280; margin-top:3px; line-height:1.3; }

.suc-whats {
    display:flex; align-items:center; justify-content:center; gap:9px;
    background:linear-gradient(135deg,#22c55e,#16a34a); color:#fff; text-decoration:none;
    padding:14px; border-radius:14px; font-size:14px; font-weight:700; margin-bottom:14px;
    transition:transform .15s;
}
.suc-whats:hover { transform:translateY(-2px); color:#fff; }
.suc-whats i { font-size:20px; }

.suc-continuar {
    display:block; text-align:center; padding:12px; border-radius:12px;
    background:#1e2235; color:#c9cad6; text-decoration:none; font-size:13px; font-weight:700;
}
.suc-continuar:hover { background:#252a3a; color:#e8eaf0; }
</style>

<div class="new122">
    <div class="suc-wrap">
        <div class="suc-icone"><i class='bx bx-check'></i></div>
        <div class="suc-titulo">OS Criada com Sucesso!</div>
        <div class="suc-sub">A ordem de serviço <strong>#<?= str_pad($os->idOs, 4, '0', STR_PAD_LEFT) ?></strong> foi registrada.</div>

        <div class="suc-grid">
            <a href="<?= site_url('os/imprimir/' . $os->idOs) ?>" target="_blank" class="suc-opcao">
                <div class="suc-opcao-icon" style="background:rgba(167,139,250,0.15);color:#a78bfa;"><i class='bx bx-file'></i></div>
                <div class="suc-opcao-titulo">Padrão A4</div>
                <div class="suc-opcao-sub">PDF completo</div>
            </a>
            <a href="<?= site_url('os/imprimirTermica/' . $os->idOs) ?>" target="_blank" class="suc-opcao">
                <div class="suc-opcao-icon" style="background:rgba(96,165,250,0.15);color:#60a5fa;"><i class='bx bx-receipt'></i></div>
                <div class="suc-opcao-titulo">Cupom 80mm</div>
                <div class="suc-opcao-sub">Comprovante</div>
            </a>
            <a href="<?= site_url('os/etiqueta/' . $os->idOs) ?>" target="_blank" class="suc-opcao">
                <div class="suc-opcao-icon" style="background:rgba(245,158,11,0.15);color:#f59e0b;"><i class='bx bx-qr'></i></div>
                <div class="suc-opcao-titulo">Etiqueta</div>
                <div class="suc-opcao-sub">Pra colar no aparelho</div>
            </a>
        </div>

        <?php if (!empty($telefone)): ?>
        <a href="<?= $linkWhats ?>" target="_blank" class="suc-whats">
            <i class='bx bxl-whatsapp'></i> Avisar Cliente pelo WhatsApp
        </a>
        <?php endif; ?>

        <a href="<?= site_url('os/editar/' . $os->idOs) ?>" class="suc-continuar">
            Continuar editando esta OS (adicionar produtos/serviços) →
        </a>
    </div>
</div>
