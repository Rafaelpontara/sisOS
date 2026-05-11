<!-- Título -->
<div style="margin-bottom:20px;">
    <h2 style="font-size:20px;font-weight:800;color:#e8eaf0;display:flex;align-items:center;gap:8px;">
        <i class='bx bx-user-circle' style="color:#6366f1;"></i> Meu Perfil
    </h2>
</div>

<!-- Dados do cliente (somente leitura) -->
<div class="p-card" style="margin-bottom:16px;">
    <div class="p-card-head">
        <div class="p-card-head-left">
            <i class='bx bx-id-card' style="color:#6366f1;"></i>
            <span>Dados Cadastrais</span>
        </div>
    </div>
    <div class="p-card-body">
        <div class="p-info-grid">
            <div class="p-field-view">
                <span class="lbl">Nome</span>
                <span class="val" style="font-weight:700;"><?= htmlspecialchars($cliente->nomeCliente) ?></span>
            </div>
            <div class="p-field-view">
                <span class="lbl">E-mail</span>
                <span class="val"><?= htmlspecialchars($cliente->email ?? '—') ?></span>
            </div>
            <div class="p-field-view">
                <span class="lbl">Telefone</span>
                <span class="val"><?= htmlspecialchars($cliente->telefone ?? '—') ?></span>
            </div>
            <div class="p-field-view">
                <span class="lbl">Celular / WhatsApp</span>
                <span class="val"><?= htmlspecialchars($cliente->celular ?? '—') ?></span>
            </div>
            <div class="p-field-view">
                <span class="lbl">CPF / CNPJ</span>
                <span class="val"><?= htmlspecialchars($cliente->documento ?? '—') ?></span>
            </div>
            <div class="p-field-view">
                <span class="lbl">Cliente desde</span>
                <span class="val"><?= !empty($cliente->dataCadastro) ? date('d/m/Y',strtotime($cliente->dataCadastro)) : '—' ?></span>
            </div>
        </div>
        <div style="margin-top:12px;padding:10px 14px;background:#13151f;border:1px solid rgba(255,255,255,0.06);border-radius:8px;font-size:12px;color:#6b7280;display:flex;align-items:center;gap:6px;">
            <i class='bx bx-info-circle'></i>
            Para alterar seus dados cadastrais, entre em contato com a assistência técnica.
        </div>
    </div>
</div>

<!-- Alterar senha -->
<div class="p-card">
    <div class="p-card-head">
        <div class="p-card-head-left">
            <i class='bx bx-lock' style="color:#fbbf24;"></i>
            <span>Alterar Senha de Acesso</span>
        </div>
    </div>
    <div class="p-card-body">

        <?php if (!empty($sucesso)): ?>
        <div class="p-alert p-alert-ok"><i class='bx bx-check-circle'></i> <?= htmlspecialchars($sucesso) ?></div>
        <?php endif; ?>
        <?php if (!empty($erro)): ?>
        <div class="p-alert p-alert-err"><i class='bx bx-error-circle'></i> <?= htmlspecialchars($erro) ?></div>
        <?php endif; ?>

        <?php if (empty($cliente->senha)): ?>
        <div class="p-alert p-alert-warn">
            <i class='bx bx-info-circle'></i>
            Você ainda não tem uma senha de acesso definida. Peça ao atendente para cadastrar uma.
        </div>
        <?php else: ?>
        <form method="post" action="<?= site_url('mine/perfil') ?>" style="max-width:400px;">
            <div class="p-field">
                <label class="p-label">Senha Atual</label>
                <div class="p-pass-wrap">
                    <input type="password" name="senha_atual" class="p-input" id="senhaAtual" required placeholder="Sua senha atual">
                    <i class='bx bx-show p-pass-eye' onclick="togglePass('senhaAtual',this)"></i>
                </div>
            </div>
            <div class="p-field">
                <label class="p-label">Nova Senha</label>
                <div class="p-pass-wrap">
                    <input type="password" name="nova_senha" class="p-input" id="novaSenha" required placeholder="Mínimo 6 caracteres">
                    <i class='bx bx-show p-pass-eye' onclick="togglePass('novaSenha',this)"></i>
                </div>
            </div>
            <div class="p-field">
                <label class="p-label">Confirmar Nova Senha</label>
                <div class="p-pass-wrap">
                    <input type="password" name="confirma_senha" class="p-input" id="confirmaSenha" required placeholder="Repita a nova senha">
                    <i class='bx bx-show p-pass-eye' onclick="togglePass('confirmaSenha',this)"></i>
                </div>
            </div>
            <button type="submit" name="salvar" value="1" class="p-btn pb-indigo">
                <i class='bx bx-lock-open'></i> Alterar Senha
            </button>
        </form>
        <?php endif; ?>
    </div>
</div>

<script>
function togglePass(id, icon) {
    var input = document.getElementById(id);
    input.type = input.type === 'password' ? 'text' : 'password';
    icon.classList.toggle('bx-show');
    icon.classList.toggle('bx-hide');
}
</script>
