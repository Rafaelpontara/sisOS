<!DOCTYPE html>
<html lang="pt-br">
<head>
  <title><?= htmlspecialchars($configuration['app_name'] ?? 'Sisos') ?></title>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link rel="stylesheet" href="<?= base_url() ?>assets/css/bootstrap.min.css" />
  <link rel="stylesheet" href="<?= base_url() ?>assets/css/bootstrap-responsive.min.css" />
  <link href="<?= base_url(); ?>assets/font-awesome/css/font-awesome.css" rel="stylesheet" />
  <link rel="shortcut icon" type="image/png" href="<?= !empty($configuration['app_favicon']) ? $configuration['app_favicon'] : base_url() . 'assets/img/favicon.png' ?>" />
  <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
  <style>
    *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

    :root {
      --bg: #0f1117;
      --card: #181c27;
      --card2: #1e2235;
      --border: rgba(255,255,255,0.07);
      --accent: #f97316;
      --accent2: #fb923c;
      --text: #e8eaf0;
      --muted: #6b7280;
      --input-bg: #252a3a;
      --input-border: rgba(255,255,255,0.1);
    }

    body {
      font-family: 'Plus Jakarta Sans', sans-serif;
      background: var(--bg);
      min-height: 100vh;
      display: flex;
      align-items: stretch;
      overflow: hidden;
    }

    /* ── LEFT PANEL ── */
    .left-panel {
      flex: 1;
      display: flex;
      flex-direction: column;
      justify-content: center;
      padding: 60px 80px;
      position: relative;
      overflow: hidden;
    }

    .left-panel::before {
      content: '';
      position: absolute;
      inset: 0;
      background:
        radial-gradient(ellipse 80% 60% at 20% 50%, rgba(249,115,22,0.12) 0%, transparent 70%),
        radial-gradient(ellipse 60% 80% at 80% 20%, rgba(99,102,241,0.08) 0%, transparent 60%);
      pointer-events: none;
    }

    /* Decorative grid */
    .left-panel::after {
      content: '';
      position: absolute;
      inset: 0;
      background-image:
        linear-gradient(rgba(255,255,255,0.02) 1px, transparent 1px),
        linear-gradient(90deg, rgba(255,255,255,0.02) 1px, transparent 1px);
      background-size: 48px 48px;
      pointer-events: none;
    }

    .left-content { position: relative; z-index: 1; max-width: 520px; }

    .badge-pill {
      display: inline-flex;
      align-items: center;
      gap: 6px;
      background: rgba(249,115,22,0.12);
      border: 1px solid rgba(249,115,22,0.25);
      color: var(--accent2);
      font-size: 11px;
      font-weight: 700;
      letter-spacing: 1.5px;
      text-transform: uppercase;
      padding: 5px 12px;
      border-radius: 20px;
      margin-bottom: 28px;
    }

    .badge-pill span { width: 6px; height: 6px; background: var(--accent); border-radius: 50%; animation: pulse 2s ease-in-out infinite; }

    @keyframes pulse { 0%,100%{opacity:1;transform:scale(1)} 50%{opacity:.5;transform:scale(0.8)} }

    .left-headline {
      font-size: clamp(32px, 4vw, 52px);
      font-weight: 800;
      line-height: 1.1;
      color: var(--text);
      letter-spacing: -1.5px;
      margin-bottom: 18px;
    }

    .left-headline em {
      font-style: normal;
      background: linear-gradient(135deg, var(--accent), #fbbf24);
      -webkit-background-clip: text;
      -webkit-text-fill-color: transparent;
      background-clip: text;
    }

    .left-sub {
      font-size: 15px;
      color: var(--muted);
      line-height: 1.7;
      margin-bottom: 44px;
      max-width: 400px;
    }

    /* Feature pills */
    .features {
      display: flex;
      flex-wrap: wrap;
      gap: 10px;
      margin-bottom: 48px;
    }

    .feat {
      display: flex;
      align-items: center;
      gap: 8px;
      background: var(--card2);
      border: 1px solid var(--border);
      border-radius: 10px;
      padding: 8px 14px;
      font-size: 12px;
      color: #9ca3af;
      font-weight: 500;
    }

    .feat i { color: var(--accent); font-size: 13px; }

    /* Illustration */
    .illustration-wrap {
      position: relative;
      display: inline-block;
    }

    .illustration-wrap img {
      width: 100%;
      max-width: 420px;
      filter: drop-shadow(0 30px 60px rgba(0,0,0,0.5));
      animation: float 6s ease-in-out infinite;
    }

    @keyframes float {
      0%,100% { transform: translateY(0); }
      50% { transform: translateY(-12px); }
    }

    /* Floating stats cards */
    .stat-card {
      position: absolute;
      background: var(--card);
      border: 1px solid var(--border);
      border-radius: 12px;
      padding: 10px 14px;
      backdrop-filter: blur(10px);
      animation: float 6s ease-in-out infinite;
    }

    .stat-card.s1 { top: 10%; right: -20px; animation-delay: -2s; }
    .stat-card.s2 { bottom: 15%; left: -10px; animation-delay: -4s; }

    .stat-label { font-size: 10px; color: var(--muted); font-weight: 600; letter-spacing: .5px; text-transform: uppercase; margin-bottom: 3px; }
    .stat-value { font-size: 18px; font-weight: 800; color: var(--text); }
    .stat-badge { font-size: 10px; background: rgba(34,197,94,0.15); color: #4ade80; border-radius: 4px; padding: 1px 5px; margin-left: 4px; font-weight: 600; }

    /* ── RIGHT PANEL ── */
    .right-panel {
      width: 480px;
      flex-shrink: 0;
      background: var(--card);
      border-left: 1px solid var(--border);
      display: flex;
      align-items: center;
      justify-content: center;
      padding: 48px 40px;
      position: relative;
      overflow: hidden;
    }

    .right-panel::before {
      content: '';
      position: absolute;
      top: -100px;
      right: -100px;
      width: 300px;
      height: 300px;
      background: radial-gradient(circle, rgba(249,115,22,0.08) 0%, transparent 70%);
      pointer-events: none;
    }

    .login-box { width: 100%; max-width: 360px; position: relative; z-index: 1; }

    /* Logo area */
    .logo-area {
      text-align: center;
      margin-bottom: 36px;
    }

    .logo-area .logo-imgs {
      display: flex;
      align-items: center;
      justify-content: center;
      gap: 10px;
      margin-bottom: 10px;
      min-height: 56px;
    }

    .logo-area .sys-name {
      font-size: 22px;
      font-weight: 800;
      color: var(--text);
      letter-spacing: -0.5px;
    }

    .logo-area .version-tag {
      font-size: 11px;
      color: var(--muted);
      font-weight: 500;
      margin-top: 4px;
    }

    /* Form */
    .form-label {
      display: block;
      font-size: 11px;
      font-weight: 700;
      color: var(--muted);
      text-transform: uppercase;
      letter-spacing: .8px;
      margin-bottom: 6px;
    }

    .input-wrap {
      position: relative;
      margin-bottom: 16px;
    }

    .input-wrap i {
      position: absolute;
      left: 14px;
      top: 50%;
      transform: translateY(-50%);
      color: var(--muted);
      font-size: 14px;
      pointer-events: none;
    }

    .input-wrap input {
      width: 100%;
      height: 46px;
      background: var(--input-bg) !important;
      border: 1px solid var(--input-border) !important;
      border-radius: 10px !important;
      padding: 0 14px 0 40px !important;
      color: var(--text) !important;
      font-size: 14px !important;
      font-family: 'Plus Jakarta Sans', sans-serif !important;
      transition: border-color .2s, box-shadow .2s;
      box-shadow: none !important;
      -webkit-box-shadow: none !important;
      outline: none !important;
    }

    .input-wrap input:focus {
      border-color: var(--accent) !important;
      box-shadow: 0 0 0 3px rgba(249,115,22,0.12) !important;
    }

    .input-wrap input::placeholder { color: #4b5563 !important; }

    .btn-login {
      width: 100%;
      height: 48px;
      background: linear-gradient(135deg, var(--accent), var(--accent2));
      border: none;
      border-radius: 10px;
      color: #fff;
      font-size: 14px;
      font-weight: 700;
      letter-spacing: .5px;
      text-transform: uppercase;
      cursor: pointer;
      margin-top: 8px;
      transition: transform .15s, box-shadow .15s, opacity .15s;
      box-shadow: 0 4px 20px rgba(249,115,22,0.35);
      font-family: 'Plus Jakarta Sans', sans-serif;
    }

    .btn-login:hover { transform: translateY(-1px); box-shadow: 0 8px 28px rgba(249,115,22,0.45); }
    .btn-login:active { transform: translateY(0); }
    .btn-login.disabled { opacity: .6; cursor: not-allowed; }

    /* Alert */
    .alert-login {
      background: rgba(239,68,68,0.1);
      border: 1px solid rgba(239,68,68,0.25);
      color: #f87171;
      border-radius: 10px;
      padding: 10px 14px;
      font-size: 13px;
      margin-bottom: 20px;
      display: flex;
      align-items: center;
      gap: 8px;
    }

    /* Divider */
    .form-divider {
      height: 1px;
      background: var(--border);
      margin: 24px 0;
    }

    .footer-link {
      text-align: center;
      font-size: 12px;
      color: var(--muted);
      margin-top: 28px;
    }

    .footer-link a { color: var(--muted); text-decoration: none; }
    .footer-link a:hover { color: var(--accent); }

    /* Saudação no painel esquerdo - hora */
    .greeting-time {
      font-size: 13px;
      color: var(--muted);
      font-weight: 500;
      margin-bottom: 12px;
      display: flex;
      align-items: center;
      gap: 6px;
    }

    /* Responsive */
    @media (max-width: 900px) {
      .left-panel { display: none; }
      .right-panel { width: 100%; border-left: none; }
    }
  </style>
</head>

<body>

  <!-- LEFT -->
  <div class="left-panel">
    <div class="left-content">
      <div class="badge-pill"><span></span> Sistema Online</div>

      <div class="greeting-time">
        <?php
          $hora = (int)date('H');
          if ($hora < 12) echo '🌅 Bom dia!';
          elseif ($hora < 18) echo '☀️ Boa tarde!';
          else echo '🌙 Boa noite!';
        ?>
      </div>

      <h1 class="left-headline">
        Olá! Seja<br><em>Bem-vindo.</em>
      </h1>

      <p class="left-sub">Sistema de Controle de Ordens de Serviço, estoque e muito mais em um único sistema.</p>
      <p style="font-size:12px;color:#4b5563;margin-top:-10px;margin-bottom:20px;font-weight:500;letter-spacing:.3px;">Tudo sob controle, na palma da mão.</p>

      <div class="features">
        <div class="feat"><i class="fa fa-file-text-o"></i> Ordens de Serviço</div>
        <div class="feat"><i class="fa fa-users"></i> Clientes</div>
        <div class="feat"><i class="fa fa-cubes"></i> Estoque</div>
        <div class="feat"><i class="fa fa-bar-chart"></i> Financeiro</div>
        <div class="feat"><i class="fa fa-shopping-cart"></i> Vendas / PDV</div>
      </div>

      <!-- Illustration: modern tech service dashboard SVG -->
      <div class="illustration-wrap">
        <svg viewBox="0 0 480 320" xmlns="http://www.w3.org/2000/svg" style="width:100%;max-width:460px;filter:drop-shadow(0 24px 48px rgba(0,0,0,0.5))">
          <!-- Background card -->
          <rect x="20" y="20" width="440" height="280" rx="18" fill="#1e2235" stroke="rgba(255,255,255,0.07)" stroke-width="1"/>
          <!-- Header bar -->
          <rect x="20" y="20" width="440" height="48" rx="18" fill="#252a3a"/>
          <rect x="20" y="50" width="440" height="18" fill="#252a3a"/>
          <!-- Dots -->
          <circle cx="46" cy="44" r="5" fill="#ef4444" opacity=".8"/>
          <circle cx="62" cy="44" r="5" fill="#f59e0b" opacity=".8"/>
          <circle cx="78" cy="44" r="5" fill="#22c55e" opacity=".8"/>
          <!-- Title -->
          <rect x="100" y="37" width="80" height="8" rx="4" fill="rgba(255,255,255,0.12)"/>

          <!-- Left sidebar -->
          <rect x="28" y="76" width="90" height="216" rx="10" fill="#1a1d2e"/>
          <!-- Sidebar items -->
          <rect x="38" y="90" width="70" height="8" rx="4" fill="rgba(249,115,22,0.7)"/>
          <rect x="38" y="108" width="55" height="6" rx="3" fill="rgba(255,255,255,0.1)"/>
          <rect x="38" y="122" width="62" height="6" rx="3" fill="rgba(255,255,255,0.1)"/>
          <rect x="38" y="136" width="48" height="6" rx="3" fill="rgba(255,255,255,0.1)"/>
          <rect x="38" y="150" width="58" height="6" rx="3" fill="rgba(255,255,255,0.1)"/>
          <rect x="38" y="164" width="52" height="6" rx="3" fill="rgba(255,255,255,0.1)"/>

          <!-- Main content area -->
          <!-- Stat cards row -->
          <rect x="130" y="80" width="95" height="60" rx="10" fill="#252a3a"/>
          <rect x="235" y="80" width="95" height="60" rx="10" fill="#252a3a"/>
          <rect x="340" y="80" width="112" height="60" rx="10" fill="#252a3a"/>

          <!-- Stat card 1: OS Abertas -->
          <rect x="142" y="92" width="40" height="5" rx="2.5" fill="rgba(255,255,255,0.3)"/>
          <text x="142" y="124" font-family="monospace" font-size="20" font-weight="bold" fill="#f97316">24</text>
          <rect x="175" y="112" width="28" height="14" rx="4" fill="rgba(34,197,94,0.2)"/>
          <text x="180" y="123" font-family="monospace" font-size="8" fill="#4ade80">+3</text>

          <!-- Stat card 2: Finalizadas -->
          <rect x="247" y="92" width="40" height="5" rx="2.5" fill="rgba(255,255,255,0.3)"/>
          <text x="247" y="124" font-family="monospace" font-size="20" font-weight="bold" fill="#a78bfa">18</text>

          <!-- Stat card 3: Receita -->
          <rect x="352" y="92" width="50" height="5" rx="2.5" fill="rgba(255,255,255,0.3)"/>
          <text x="352" y="124" font-family="monospace" font-size="16" font-weight="bold" fill="#22c55e">R$4.2k</text>

          <!-- Chart area -->
          <rect x="130" y="150" width="210" height="130" rx="10" fill="#252a3a"/>
          <!-- Chart bars -->
          <rect x="148" y="230" width="18" height="30" rx="4" fill="rgba(249,115,22,0.4)"/>
          <rect x="174" y="210" width="18" height="50" rx="4" fill="rgba(249,115,22,0.6)"/>
          <rect x="200" y="195" width="18" height="65" rx="4" fill="rgba(249,115,22,0.8)"/>
          <rect x="226" y="215" width="18" height="45" rx="4" fill="rgba(249,115,22,0.6)"/>
          <rect x="252" y="200" width="18" height="60" rx="4" fill="#f97316"/>
          <rect x="278" y="220" width="18" height="40" rx="4" fill="rgba(249,115,22,0.5)"/>
          <rect x="304" y="205" width="18" height="55" rx="4" fill="rgba(249,115,22,0.7)"/>
          <!-- Chart label -->
          <rect x="142" y="160" width="60" height="6" rx="3" fill="rgba(255,255,255,0.2)"/>

          <!-- OS list -->
          <rect x="350" y="150" width="102" height="130" rx="10" fill="#252a3a"/>
          <rect x="360" y="162" width="60" height="5" rx="2.5" fill="rgba(255,255,255,0.25)"/>
          <!-- OS items -->
          <rect x="358" y="175" width="8" height="8" rx="2" fill="#f97316"/>
          <rect x="370" y="177" width="50" height="4" rx="2" fill="rgba(255,255,255,0.15)"/>
          <rect x="358" y="191" width="8" height="8" rx="2" fill="#a78bfa"/>
          <rect x="370" y="193" width="42" height="4" rx="2" fill="rgba(255,255,255,0.15)"/>
          <rect x="358" y="207" width="8" height="8" rx="2" fill="#22c55e"/>
          <rect x="370" y="209" width="55" height="4" rx="2" fill="rgba(255,255,255,0.15)"/>
          <rect x="358" y="223" width="8" height="8" rx="2" fill="#f59e0b"/>
          <rect x="370" y="225" width="46" height="4" rx="2" fill="rgba(255,255,255,0.15)"/>
          <rect x="358" y="239" width="8" height="8" rx="2" fill="#ef4444"/>
          <rect x="370" y="241" width="52" height="4" rx="2" fill="rgba(255,255,255,0.15)"/>

          <!-- Animated pulse dot -->
          <circle cx="448" cy="32" r="5" fill="#22c55e" opacity="0.9">
            <animate attributeName="r" values="5;7;5" dur="2s" repeatCount="indefinite"/>
            <animate attributeName="opacity" values="0.9;0.4;0.9" dur="2s" repeatCount="indefinite"/>
          </circle>
        </svg>
      </div>
    </div>
  </div>

  <!-- RIGHT -->
  <div class="right-panel">
    <div class="login-box">

      <!-- Logo -->
      <div class="logo-area">
        <?php
          $logoCustom = $configuration['app_logo'] ?? '';
          $iconCustom = $configuration['app_favicon'] ?? '';
        ?>
        <div class="logo-imgs">
          <?php if (!empty($iconCustom)): ?>
            <img src="<?= $iconCustom ?>" alt="icon" style="width:44px;height:44px;object-fit:contain;">
          <?php endif; ?>
          <?php if (!empty($logoCustom)): ?>
            <img src="<?= $logoCustom ?>" alt="logo" style="max-height:44px;max-width:160px;object-fit:contain;">
          <?php else: ?>
            <div class="sys-name"><?= htmlspecialchars($configuration['app_name'] ?? 'Sisos') ?></div>
          <?php endif; ?>
        </div>
        <div class="version-tag">Versão <?= $this->config->item('app_version') ?></div>
      </div>

      <!-- Erro -->
      <?php if ($this->session->flashdata('error')): ?>
      <div class="alert-login">
        <i class="fa fa-exclamation-circle"></i>
        <?= $this->session->flashdata('error') ?>
      </div>
      <?php endif; ?>

      <!-- Form -->
      <form id="formLogin" method="post" action="<?= site_url('login/verificarLogin') ?>">
        <input type="hidden" name="<?= $this->security->get_csrf_token_name() ?>" value="<?= $this->security->get_csrf_hash() ?>">

        <div>
          <label class="form-label">E-mail</label>
          <div class="input-wrap">
            <i class="fa fa-envelope-o"></i>
            <input id="email" name="email" type="email" placeholder="seu@email.com" autocomplete="email">
          </div>
        </div>

        <div>
          <label class="form-label">Senha</label>
          <div class="input-wrap">
            <i class="fa fa-lock"></i>
            <input name="senha" type="password" placeholder="••••••••" autocomplete="current-password">
          </div>
        </div>

        <button type="submit" class="btn-login" id="btn-acessar">Acessar</button>
      </form>

      <div class="form-divider"></div>

      <div class="footer-link">
        <a href="https://github.com/Rafaelpontara/sisos"><?= date('Y') ?> &copy; Rafael</a>
      </div>
    </div>
  </div>

  <!-- Modal erro -->
  <a href="#notification" id="call-modal" role="button" class="btn" data-toggle="modal" style="display:none">x</a>
  <div id="notification" class="modal hide fade" tabindex="-1" role="dialog">
    <div class="modal-header"><h4>Sisos</h4></div>
    <div class="modal-body">
      <h5 style="text-align:center" id="message">Os dados de acesso estão incorretos, por favor tente novamente!</h5>
    </div>
    <div class="modal-footer">
      <button class="btn btn-primary" data-dismiss="modal">Fechar</button>
    </div>
  </div>

  <script src="<?= base_url() ?>assets/js/jquery-1.12.4.min.js"></script>
  <script src="<?= base_url() ?>assets/js/bootstrap.min.js"></script>
  <script src="<?= base_url() ?>assets/js/validate.js"></script>
  <script>
  $(document).ready(function() {
    $('#email').focus();
    $('#formLogin').validate({
      rules: { email: { required: true }, senha: { required: true } },
      messages: { email: { required: '' }, senha: { required: 'Campos obrigatórios.' } },
      submitHandler: function(form) {
        var dados = $(form).serialize();
        $('#btn-acessar').addClass('disabled').text('Acessando...');
        $.ajax({
          type: 'POST',
          url: '<?= site_url('login/verificarLogin?ajax=true') ?>',
          data: dados,
          dataType: 'json',
          success: function(data) {
            if (data.result == true) {
              window.location.href = '<?= site_url('sisos') ?>';
            } else {
              $('#btn-acessar').removeClass('disabled').text('Acessar');
              $('#message').text(data.message || 'Os dados de acesso estão incorretos, por favor tente novamente!');
              $('#call-modal').trigger('click');
              $("input[name='<?= $this->security->get_csrf_token_name() ?>']").val(data.SISOS_TOKEN);
            }
          }
        });
        return false;
      },
      errorClass: 'help-inline', errorElement: 'span',
      highlight: function(el) { $(el).parents('.control-group').addClass('error'); },
      unhighlight: function(el) { $(el).parents('.control-group').removeClass('error').addClass('success'); }
    });
  });
  </script>
</body>
</html>