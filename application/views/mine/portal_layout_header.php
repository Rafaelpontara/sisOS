<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($config['app_name'] ?? 'Portal do Cliente') ?></title>
    <?php if (!empty($config['app_favicon'])): ?>
    <link rel="icon" href="<?= $config['app_favicon'] ?>">
    <?php endif; ?>
    <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet">
    <style>
    *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
    :root {
        --bg:      #0f1117;
        --surface: #1a1d2e;
        --surface2:#252a3a;
        --border:  rgba(255,255,255,0.08);
        --text:    #e8eaf0;
        --muted:   #9ca3af;
        --accent:  #6366f1;
        --green:   #22c55e;
        --amber:   #fbbf24;
        --red:     #ef4444;
        --blue:    #3b82f6;
    }
    html, body { height: 100%; font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif; background: var(--bg); color: var(--text); }

    /* ── Topbar ── */
    .portal-top {
        position: sticky; top: 0; z-index: 100;
        background: var(--surface); border-bottom: 1px solid var(--border);
        display: flex; align-items: center; justify-content: space-between;
        padding: 0 24px; height: 58px;
    }
    .portal-top-brand { display: flex; align-items: center; gap: 10px; text-decoration: none; }
    .portal-top-brand img { height: <?= $config['app_logo_height'] ?? 36 ?>px; }
    .portal-top-brand span { font-size: 15px; font-weight: 800; color: var(--text); }
    .portal-top-right { display: flex; align-items: center; gap: 14px; }
    .portal-top-user { font-size: 13px; color: var(--muted); }
    .portal-top-user strong { color: var(--text); }
    .portal-top-logout {
        display: inline-flex; align-items: center; gap: 5px;
        padding: 6px 12px; border-radius: 8px;
        background: rgba(239,68,68,0.12); color: #f87171;
        text-decoration: none; font-size: 12px; font-weight: 700;
        transition: background .15s;
    }
    .portal-top-logout:hover { background: rgba(239,68,68,0.25); }

    /* ── Nav ── */
    .portal-nav {
        background: var(--surface2); border-bottom: 1px solid var(--border);
        display: flex; gap: 2px; padding: 0 20px; overflow-x: auto;
    }
    .portal-nav-item {
        display: inline-flex; align-items: center; gap: 6px;
        padding: 12px 16px; font-size: 13px; font-weight: 600;
        color: var(--muted); text-decoration: none;
        border-bottom: 3px solid transparent; white-space: nowrap;
        transition: all .15s;
    }
    .portal-nav-item:hover { color: var(--text); }
    .portal-nav-item.active { color: var(--accent); border-bottom-color: var(--accent); }
    .portal-nav-item i { font-size: 16px; }

    /* ── Content ── */
    .portal-content { max-width: 1100px; margin: 0 auto; padding: 24px 20px; }

    /* ── Cards ── */
    .p-card { background: var(--surface); border: 1px solid var(--border); border-radius: 14px; overflow: hidden; margin-bottom: 16px; }
    .p-card-head { display: flex; align-items: center; justify-content: space-between; gap: 8px; padding: 12px 18px; border-bottom: 1px solid var(--border); background: var(--surface2); }
    .p-card-head-left { display: flex; align-items: center; gap: 8px; }
    .p-card-head i { font-size: 16px; }
    .p-card-head span { font-size: 11px; font-weight: 700; color: var(--muted); text-transform: uppercase; letter-spacing: .8px; }
    .p-card-body { padding: 18px; }

    /* ── KPIs ── */
    .p-kpis { display: grid; grid-template-columns: repeat(auto-fill, minmax(180px, 1fr)); gap: 12px; margin-bottom: 18px; }
    .p-kpi { background: var(--surface); border: 1px solid var(--border); border-radius: 14px; padding: 16px; display: flex; align-items: center; gap: 14px; }
    .p-kpi-icon { width: 44px; height: 44px; border-radius: 12px; display: flex; align-items: center; justify-content: center; font-size: 20px; flex-shrink: 0; }
    .p-kpi-val { font-size: 24px; font-weight: 800; color: var(--text); line-height: 1; }
    .p-kpi-label { font-size: 11px; color: var(--muted); font-weight: 600; margin-top: 3px; }

    /* ── Tabelas ── */
    .p-tbl { width: 100%; border-collapse: collapse; }
    .p-tbl thead th { background: var(--surface2); color: var(--muted); font-size: 11px; font-weight: 700; text-transform: uppercase; letter-spacing: .5px; padding: 10px 14px; border-bottom: 1px solid var(--border); }
    .p-tbl tbody tr { border-bottom: 1px solid rgba(255,255,255,0.04); transition: background .12s; }
    .p-tbl tbody tr:hover { background: rgba(255,255,255,0.03); }
    .p-tbl tbody td { padding: 10px 14px; font-size: 13px; color: #c9cad6; vertical-align: middle; }
    .p-empty { text-align: center; padding: 30px !important; color: var(--muted) !important; }

    /* ── Badges ── */
    .p-badge { display: inline-block; padding: 3px 10px; border-radius: 20px; font-size: 11px; font-weight: 700; }
    .pb-blue   { background: rgba(59,130,246,0.15);  color: #60a5fa; }
    .pb-green  { background: rgba(34,197,94,0.15);   color: #4ade80; }
    .pb-amber  { background: rgba(245,158,11,0.15);  color: #fbbf24; }
    .pb-red    { background: rgba(239,68,68,0.15);   color: #f87171; }
    .pb-purple { background: rgba(168,85,247,0.15);  color: #c084fc; }
    .pb-gray   { background: rgba(156,163,175,0.15); color: #9ca3af; }

    /* ── Botões ── */
    .p-btn { display: inline-flex; align-items: center; gap: 6px; padding: 9px 18px; border-radius: 8px; font-size: 13px; font-weight: 700; text-decoration: none; border: none; cursor: pointer; transition: all .15s; }
    .p-btn:hover { transform: translateY(-1px); text-decoration: none; }
    .pb-indigo { background: linear-gradient(135deg, #6366f1, #4f46e5); color: #fff; box-shadow: 0 4px 12px rgba(99,102,241,0.3); }
    .pb-green-btn { background: linear-gradient(135deg, #22c55e, #16a34a); color: #fff; box-shadow: 0 4px 12px rgba(34,197,94,0.3); }
    .pb-red-btn { background: linear-gradient(135deg, #ef4444, #dc2626); color: #fff; }
    .pb-ghost { background: rgba(255,255,255,0.07); color: var(--muted); border: 1px solid var(--border); }
    .pb-ghost:hover { color: var(--text); }

    /* ── Formulários ── */
    .p-label { font-size: 11px; font-weight: 700; color: var(--muted); text-transform: uppercase; letter-spacing: .5px; display: block; margin-bottom: 5px; }
    .p-input { width: 100%; background: #13151f; border: 1px solid #444860; color: var(--text); border-radius: 8px; padding: 9px 13px; font-size: 13px; box-sizing: border-box; transition: border-color .15s; }
    .p-input:focus { border-color: var(--accent); outline: none; }
    .p-field { margin-bottom: 14px; }
    .p-pass-wrap { position: relative; }
    .p-pass-wrap .p-input { padding-right: 40px; }
    .p-pass-eye { position: absolute; right: 10px; top: 50%; transform: translateY(-50%); cursor: pointer; color: var(--muted); font-size: 18px; }

    /* ── Alert ── */
    .p-alert { border-radius: 8px; padding: 10px 14px; font-size: 13px; margin-bottom: 14px; display: flex; align-items: center; gap: 8px; }
    .p-alert-err  { background: rgba(239,68,68,0.1); border: 1px solid rgba(239,68,68,0.3); color: #f87171; }
    .p-alert-ok   { background: rgba(34,197,94,0.1); border: 1px solid rgba(34,197,94,0.3); color: #4ade80; }
    .p-alert-warn { background: rgba(245,158,11,0.1); border: 1px solid rgba(245,158,11,0.3); color: #fbbf24; }

    /* ── OS detail sections ── */
    .p-section { margin-bottom: 14px; }
    .p-info-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 14px; }
    @media(max-width:600px) { .p-info-grid { grid-template-columns: 1fr; } }
    .p-field-view { margin-bottom: 12px; }
    .p-field-view .lbl { font-size: 10px; font-weight: 700; color: var(--muted); text-transform: uppercase; letter-spacing: .6px; display: block; margin-bottom: 3px; }
    .p-field-view .val { font-size: 13px; color: var(--text); }
    .p-text-box { background: #13151f; border: 1px solid var(--border); border-radius: 8px; padding: 10px 14px; font-size: 13px; color: #c9cad6; line-height: 1.6; }

    /* ── Login page ── */
    .portal-login-wrap { min-height: 100vh; display: flex; align-items: center; justify-content: center; padding: 20px; background: radial-gradient(ellipse at 30% 20%, rgba(99,102,241,0.08) 0%, transparent 60%), var(--bg); }
    .portal-login-box { width: 100%; max-width: 420px; background: var(--surface); border: 1px solid var(--border); border-radius: 20px; padding: 36px 32px; box-shadow: 0 20px 60px rgba(0,0,0,0.5); }
    .portal-login-logo { text-align: center; margin-bottom: 28px; }
    .portal-login-logo img { max-height: 52px; }
    .portal-login-logo h1 { font-size: 18px; font-weight: 800; color: var(--text); margin-top: 10px; }
    .portal-login-logo p { font-size: 12px; color: var(--muted); margin-top: 4px; }
    .portal-login-footer { text-align: center; margin-top: 20px; font-size: 12px; color: var(--muted); }

    /* ── Responsive ── */
    @media(max-width:600px) {
        .portal-top { padding: 0 14px; }
        .portal-content { padding: 16px 14px; }
        .p-kpis { grid-template-columns: 1fr 1fr; }
    }
    </style>
</head>
<body>

<?php if ($pagina !== 'login'): ?>
<!-- Topbar -->
<div class="portal-top">
    <a href="<?= site_url('mine/dashboard') ?>" class="portal-top-brand">
        <?php if (!empty($config['app_logo'])): ?>
        <img src="<?= $config['app_logo'] ?>" alt="Logo">
        <?php else: ?>
        <i class='bx bx-user-circle' style="font-size:26px;color:#6366f1;"></i>
        <span><?= htmlspecialchars($config['app_name'] ?? 'Portal') ?></span>
        <?php endif; ?>
    </a>
    <div class="portal-top-right">
        <span class="portal-top-user">Olá, <strong><?= htmlspecialchars($mine_nome) ?></strong></span>
        <a href="<?= site_url('mine/sair') ?>" class="portal-top-logout">
            <i class='bx bx-log-out'></i> Sair
        </a>
    </div>
</div>

<!-- Nav -->
<nav class="portal-nav">
    <a href="<?= site_url('mine/dashboard') ?>" class="portal-nav-item <?= $pagina=='dashboard'?'active':'' ?>">
        <i class='bx bx-home'></i> Início
    </a>
    <a href="<?= site_url('mine/os') ?>" class="portal-nav-item <?= $pagina=='os'?'active':'' ?>">
        <i class='bx bx-file'></i> Minhas OS
    </a>
    <a href="<?= site_url('mine/perfil') ?>" class="portal-nav-item <?= $pagina=='perfil'?'active':'' ?>">
        <i class='bx bx-user'></i> Meu Perfil
    </a>
</nav>

<div class="portal-content">
<?php endif; ?>
