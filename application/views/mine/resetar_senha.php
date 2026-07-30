<!DOCTYPE html>
<html lang="pt-br">
<head>
    <title>Recuperar Senha — <?= $this->config->item('app_name') ?></title>
    <meta charset="UTF-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <meta name="csrf-token-name" content="<?= config_item('csrf_token_name') ?>">
    <meta name="csrf-cookie-name" content="<?= config_item('csrf_cookie_name') ?>">
    <link rel="shortcut icon" type="image/png" href="<?= base_url() ?>assets/img/favicon.png"/>
    <link href='https://unpkg.com/boxicons@2.1.1/css/boxicons.min.css' rel='stylesheet'>
    <script src="<?= base_url() ?>assets/js/jquery-1.12.4.min.js"></script>
    <script src="<?= base_url() ?>assets/js/sweetalert2.all.min.js"></script>
    <script src="<?= base_url() ?>assets/js/jquery.validate.js"></script>
    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
        body {
            font-family: 'Segoe UI', Arial, sans-serif;
            background: #0f1117;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 24px 16px;
        }

        .rs-wrap {
            width: 100%;
            max-width: 420px;
        }

        /* Logo */
        .rs-logo {
            text-align: center;
            margin-bottom: 28px;
        }
        .rs-logo img {
            max-height: 56px;
            max-width: 180px;
            object-fit: contain;
            margin-bottom: 12px;
        }
        .rs-logo-icon {
            width: 72px;
            height: 72px;
            background: rgba(99,102,241,0.15);
            border-radius: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 14px;
            border: 1px solid rgba(99,102,241,0.3);
        }
        .rs-logo-icon i { font-size: 36px; color: #a5b4fc; }
        .rs-logo h1 { font-size: 22px; font-weight: 800; color: #e8eaf0; margin-bottom: 6px; }
        .rs-logo p { font-size: 13px; color: #6b7280; line-height: 1.5; }

        /* Card */
        .rs-card {
            background: #1a1d2e;
            border: 1px solid rgba(255,255,255,0.08);
            border-radius: 18px;
            overflow: hidden;
        }
        .rs-card-head {
            padding: 14px 22px;
            background: #252a3a;
            border-bottom: 1px solid rgba(255,255,255,0.06);
            display: flex;
            align-items: center;
            gap: 9px;
        }
        .rs-card-head i { font-size: 18px; color: #fbbf24; }
        .rs-card-head span { font-size: 13px; font-weight: 700; color: #e8eaf0; }
        .rs-card-body { padding: 28px 24px; }

        /* Info box */
        .rs-info {
            background: rgba(99,102,241,0.08);
            border: 1px solid rgba(99,102,241,0.2);
            border-radius: 10px;
            padding: 12px 16px;
            font-size: 13px;
            color: #a5b4fc;
            display: flex;
            align-items: flex-start;
            gap: 9px;
            margin-bottom: 20px;
            line-height: 1.5;
        }
        .rs-info i { font-size: 18px; flex-shrink: 0; margin-top: 1px; }

        /* Alerta */
        .rs-alert {
            padding: 11px 14px;
            border-radius: 9px;
            font-size: 13px;
            display: flex;
            align-items: center;
            gap: 8px;
            margin-bottom: 18px;
        }
        .rs-alert-err { background: rgba(239,68,68,0.12); border: 1px solid rgba(239,68,68,0.3); color: #f87171; }
        .rs-alert-ok  { background: rgba(34,197,94,0.12);  border: 1px solid rgba(34,197,94,0.3);  color: #4ade80; }

        /* Campo */
        .rs-field { display: flex; flex-direction: column; gap: 6px; margin-bottom: 16px; }
        .rs-label {
            font-size: 11px;
            font-weight: 700;
            color: #9ca3af;
            text-transform: uppercase;
            letter-spacing: .5px;
        }
        .rs-input {
            background: #252a3a;
            border: 1px solid #444860;
            color: #e8eaf0;
            border-radius: 10px;
            padding: 12px 16px;
            font-size: 14px;
            width: 100%;
            transition: border-color .15s;
        }
        .rs-input:focus {
            outline: none;
            border-color: #6366f1;
            box-shadow: 0 0 0 3px rgba(99,102,241,0.12);
        }
        .rs-input::placeholder { color: #6b7280; }

        /* Botões */
        .rs-actions {
            display: flex;
            flex-direction: column;
            gap: 10px;
            margin-top: 8px;
        }
        .rs-btn {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            padding: 13px;
            border-radius: 10px;
            font-size: 14px;
            font-weight: 700;
            border: none;
            cursor: pointer;
            text-decoration: none;
            transition: all .15s;
            width: 100%;
        }
        .rs-btn:hover { transform: translateY(-1px); }
        .rs-btn-primary {
            background: linear-gradient(135deg, #6366f1, #4f46e5);
            color: #fff;
            box-shadow: 0 4px 14px rgba(99,102,241,0.35);
        }
        .rs-btn-ghost {
            background: rgba(255,255,255,0.05);
            color: #9ca3af;
            border: 1px solid rgba(255,255,255,0.1);
        }
        .rs-btn-ghost:hover { background: rgba(255,255,255,0.09); color: #e8eaf0; }

        /* Divider */
        .rs-or {
            text-align: center;
            font-size: 12px;
            color: #4b5563;
            position: relative;
            margin: 4px 0;
        }
        .rs-or::before, .rs-or::after {
            content: '';
            position: absolute;
            top: 50%;
            width: 42%;
            height: 1px;
            background: rgba(255,255,255,0.07);
        }
        .rs-or::before { left: 0; }
        .rs-or::after  { right: 0; }

        /* Rodapé */
        .rs-footer {
            text-align: center;
            margin-top: 20px;
            font-size: 12px;
            color: #4b5563;
        }
        .rs-footer a { color: #6366f1; text-decoration: none; }
    </style>
</head>
<body>

<div class="rs-wrap">

    <!-- Logo -->
    <div class="rs-logo">
        <?php
        $cfg = $this->config->item('app_logo');
        if (!empty($cfg)): ?>
        <img src="<?= base_url($cfg) ?>" alt="Logo">
        <?php else: ?>
        <div class="rs-logo-icon"><i class='bx bx-lock-open-alt'></i></div>
        <?php endif; ?>
        <h1>Recuperar Senha</h1>
        <p>Informe seu e-mail cadastrado e enviaremos<br>as instruções para redefinir sua senha.</p>
    </div>

    <!-- Card -->
    <div class="rs-card">
        <div class="rs-card-head">
            <i class='bx bx-envelope'></i>
            <span>Recuperação de Acesso</span>
        </div>
        <div class="rs-card-body">

            <div class="rs-info">
                <i class='bx bx-info-circle'></i>
                <span>Digite o e-mail associado à sua conta. Você receberá um link para criar uma nova senha.</span>
            </div>

            <?php if ($this->session->flashdata('error')): ?>
            <div class="rs-alert rs-alert-err">
                <i class='bx bx-error-circle'></i>
                <?= htmlspecialchars($this->session->flashdata('error')) ?>
            </div>
            <?php endif; ?>

            <?php if ($this->session->flashdata('success')): ?>
            <div class="rs-alert rs-alert-ok">
                <i class='bx bx-check-circle'></i>
                <?= htmlspecialchars($this->session->flashdata('success')) ?>
            </div>
            <?php endif; ?>

            <form action="<?= base_url() ?>index.php/mine/gerarTokenResetarSenha" id="formReset" method="post">

                <div class="rs-field">
                    <label class="rs-label" for="email">E-mail <span style="color:#f87171">*</span></label>
                    <input id="email" type="email" name="email" class="rs-input"
                           placeholder="seu@email.com"
                           value="<?= htmlspecialchars($this->input->post('email') ?? '') ?>"
                           autofocus required>
                </div>

                <div class="rs-actions">
                    <button type="submit" class="rs-btn rs-btn-primary">
                        <i class='bx bx-mail-send'></i> Enviar instruções
                    </button>
                    <div class="rs-or">ou</div>
                    <a href="<?= site_url('mine') ?>" class="rs-btn rs-btn-ghost">
                        <i class='bx bx-log-in'></i> Voltar ao login
                    </a>
                </div>

            </form>
        </div>
    </div>

    <div class="rs-footer">
        <?= date('Y') ?> &copy; Rafael — <?= $this->config->item('app_name') ?> v<?= $this->config->item('app_version') ?>
    </div>

</div>

<script>
$('#formReset').validate({
    rules: { email: { required: true, email: true } },
    messages: { email: { required: 'Informe seu e-mail.', email: 'E-mail inválido.' } },
    errorClass: 'rs-err',
    errorElement: 'span',
    errorPlacement: function(error, element) {
        error.css({ color: '#f87171', fontSize: '11px', marginTop: '4px', display: 'block' });
        error.insertAfter(element);
    },
    highlight: function(el) { $(el).css('border-color', '#f87171'); },
    unhighlight: function(el) { $(el).css('border-color', '#444860'); }
});

<?php if ($this->session->flashdata('success')): ?>
Swal.fire({ icon: 'success', title: '<?= addslashes($this->session->flashdata('success')) ?>', timer: 5000, showConfirmButton: false });
<?php endif; ?>
<?php if ($this->session->flashdata('error')): ?>
Swal.fire({ icon: 'error', title: '<?= addslashes($this->session->flashdata('error')) ?>', timer: 4000, showConfirmButton: false });
<?php endif; ?>
</script>
</body>
</html>
