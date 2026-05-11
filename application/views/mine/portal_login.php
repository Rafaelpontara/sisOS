<div class="portal-login-wrap">
    <div class="portal-login-box">
        <div class="portal-login-logo">
            <?php if (!empty($config['app_logo'])): ?>
            <img src="<?= $config['app_logo'] ?>" alt="Logo">
            <?php else: ?>
            <i class='bx bx-user-circle' style="font-size:52px;color:#6366f1;"></i>
            <?php endif; ?>
            <h1><?= htmlspecialchars($config['app_name'] ?? 'Portal do Cliente') ?></h1>
            <p>Acesse para acompanhar suas Ordens de Serviço</p>
        </div>

        <?php if (!empty($erro)): ?>
        <div class="p-alert p-alert-err">
            <i class='bx bx-error-circle'></i> <?= htmlspecialchars($erro) ?>
        </div>
        <?php endif; ?>

        <form method="post" action="<?= site_url('mine/login') ?>">
            <div class="p-field">
                <label class="p-label">E-mail</label>
                <input type="email" name="email" class="p-input" placeholder="seu@email.com"
                       value="<?= htmlspecialchars($this->input->post('email') ?? '') ?>" required autofocus>
            </div>
            <div class="p-field">
                <label class="p-label">Senha</label>
                <div class="p-pass-wrap">
                    <input type="password" name="senha" id="senhaInput" class="p-input"
                           placeholder="Sua senha" required>
                    <i class='bx bx-show p-pass-eye' id="toggleSenha"></i>
                </div>
            </div>
            <button type="submit" name="entrar" value="1" class="p-btn pb-indigo" style="width:100%;justify-content:center;padding:12px;">
                <i class='bx bx-log-in'></i> Entrar no Portal
            </button>
        </form>

        <div class="portal-login-footer">
            Não tem senha? Entre em contato com a assistência técnica.
        </div>
    </div>
</div>

<script>
document.getElementById('toggleSenha').addEventListener('click', function() {
    var input = document.getElementById('senhaInput');
    input.type = input.type === 'password' ? 'text' : 'password';
    this.classList.toggle('bx-show');
    this.classList.toggle('bx-hide');
});
</script>
