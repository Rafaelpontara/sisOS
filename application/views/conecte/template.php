<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <title>Área do Cliente — <?= $this->config->item('app_name') ?></title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token-name" content="<?= config_item('csrf_token_name') ?>">
    <meta name="csrf-cookie-name" content="<?= config_item('csrf_cookie_name') ?>">
    <link rel="shortcut icon" href="<?= base_url() ?>assets/img/favicon.png">
    <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet">
    <script src="<?= base_url() ?>assets/js/jquery-1.12.4.min.js"></script>
    <script src="<?= base_url() ?>assets/js/sweetalert.min.js"></script>
    <script src="<?= base_url() ?>assets/js/funcoesGlobal.js"></script>
    <script src="<?= base_url() ?>assets/js/csrf.js"></script>
    <style>
    *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
    :root {
        --bg:      #0f1117;
        --surf:    #1a1d2e;
        --surf2:   #252a3a;
        --border:  rgba(255,255,255,0.08);
        --text:    #e8eaf0;
        --muted:   #9ca3af;
        --accent:  #6366f1;
        --green:   #22c55e;
        --amber:   #fbbf24;
        --red:     #ef4444;
        --blue:    #3b82f6;
        --sidebar: 230px;
        --topbar:  56px;
    }
    html, body { height: 100%; font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif; background: var(--bg); color: var(--text); }

    /* ── Sidebar ── */
    .mc-sidebar {
        position: fixed; top: 0; left: 0; height: 100vh; width: var(--sidebar);
        background: var(--surf); border-right: 1px solid var(--border);
        display: flex; flex-direction: column; z-index: 300;
        transition: transform .25s ease;
    }
    .mc-brand {
        padding: 16px 14px; border-bottom: 1px solid var(--border);
        display: flex; align-items: center; gap: 10px; min-height: 64px;
    }
    .mc-brand img { max-height: 40px; max-width: 150px; object-fit: contain; }
    .mc-brand-text { font-size: 14px; font-weight: 800; color: var(--text); }
    .mc-user-box {
        padding: 12px 14px; border-bottom: 1px solid var(--border);
        display: flex; align-items: center; gap: 10px;
    }
    .mc-user-avatar {
        width: 36px; height: 36px; border-radius: 50%;
        background: linear-gradient(135deg, var(--accent), #4f46e5);
        display: flex; align-items: center; justify-content: center;
        font-size: 16px; color: #fff; font-weight: 700; flex-shrink: 0;
    }
    .mc-user-name { font-size: 13px; font-weight: 700; color: var(--text); }
    .mc-user-sub  { font-size: 11px; color: var(--muted); }
    .mc-nav { flex: 1; padding: 10px 8px; overflow-y: auto; }
    .mc-nav-section { font-size: 10px; font-weight: 700; color: var(--muted); text-transform: uppercase; letter-spacing: .8px; padding: 10px 8px 4px; }
    .mc-nav-item {
        display: flex; align-items: center; gap: 9px;
        padding: 9px 12px; border-radius: 9px;
        color: var(--muted); text-decoration: none; font-size: 13px; font-weight: 600;
        transition: all .15s; margin-bottom: 2px;
    }
    .mc-nav-item:hover { background: rgba(255,255,255,0.06); color: var(--text); text-decoration: none; }
    .mc-nav-item.active { background: rgba(99,102,241,0.15); color: #a5b4fc; }
    .mc-nav-item i { font-size: 18px; flex-shrink: 0; }
    .mc-sidebar-footer { padding: 10px 8px; border-top: 1px solid var(--border); }

    /* ── Topbar ── */
    .mc-topbar {
        position: fixed; top: 0; left: var(--sidebar); right: 0; height: var(--topbar);
        background: var(--surf); border-bottom: 1px solid var(--border);
        display: flex; align-items: center; justify-content: space-between;
        padding: 0 20px; z-index: 200;
    }
    .mc-topbar-left { display: flex; align-items: center; gap: 10px; }
    .mc-hamburger {
        display: none; width: 36px; height: 36px; border-radius: 8px;
        background: rgba(255,255,255,0.06); border: none; cursor: pointer;
        color: var(--muted); font-size: 20px; align-items: center; justify-content: center;
    }
    .mc-page-title { font-size: 15px; font-weight: 700; color: var(--text); }
    .mc-topbar-right { display: flex; align-items: center; gap: 10px; }
    .mc-topbar-greeting { font-size: 12px; color: var(--muted); }
    .mc-topbar-greeting strong { color: var(--text); }
    .mc-btn-logout {
        display: inline-flex; align-items: center; gap: 5px;
        padding: 6px 12px; border-radius: 8px;
        background: rgba(239,68,68,0.1); color: #f87171;
        text-decoration: none; font-size: 12px; font-weight: 700;
        transition: background .15s;
    }
    .mc-btn-logout:hover { background: rgba(239,68,68,0.2); text-decoration: none; }

    /* ── Content ── */
    .mc-content { margin-left: var(--sidebar); padding-top: var(--topbar); min-height: 100vh; }
    .mc-inner { padding: 20px; max-width: 1200px; margin: 0 auto; }

    /* ── Overlay mobile ── */
    .mc-overlay { display: none; position: fixed; inset: 0; background: rgba(0,0,0,0.5); z-index: 299; }

    /* ── Cards ── */
    .mc-card { background: var(--surf); border: 1px solid var(--border); border-radius: 14px; overflow: hidden; margin-bottom: 14px; }
    .mc-card-head { display: flex; align-items: center; justify-content: space-between; padding: 11px 16px; border-bottom: 1px solid var(--border); background: var(--surf2); }
    .mc-card-head-left { display: flex; align-items: center; gap: 8px; }
    .mc-card-head i { font-size: 16px; }
    .mc-card-head span { font-size: 11px; font-weight: 700; color: var(--muted); text-transform: uppercase; letter-spacing: .8px; }
    .mc-card-body { padding: 16px; }

    /* ── KPIs ── */
    .mc-kpis { display: grid; grid-template-columns: repeat(auto-fill, minmax(160px, 1fr)); gap: 12px; margin-bottom: 18px; }
    .mc-kpi { background: var(--surf); border: 1px solid var(--border); border-radius: 14px; padding: 14px 16px; display: flex; align-items: center; gap: 12px; transition: transform .15s; text-decoration: none; }
    .mc-kpi:hover { transform: translateY(-2px); text-decoration: none; }
    .mc-kpi-icon { width: 42px; height: 42px; border-radius: 11px; display: flex; align-items: center; justify-content: center; font-size: 20px; flex-shrink: 0; }
    .mc-kpi-val { font-size: 22px; font-weight: 800; color: var(--text); line-height: 1; }
    .mc-kpi-label { font-size: 11px; color: var(--muted); font-weight: 600; margin-top: 3px; }

    /* ── Tabelas ── */
    .mc-tbl-wrap { background: var(--surf); border: 1px solid var(--border); border-radius: 14px; overflow: hidden; margin-bottom: 14px; overflow-x: auto; }
    .mc-tbl { width: 100%; border-collapse: collapse; min-width: 500px; }
    .mc-tbl thead th { background: var(--surf2); color: var(--muted); font-size: 11px; font-weight: 700; text-transform: uppercase; letter-spacing: .5px; padding: 10px 14px; border-bottom: 1px solid var(--border); white-space: nowrap; }
    .mc-tbl tbody tr { border-bottom: 1px solid rgba(255,255,255,0.04); transition: background .12s; }
    .mc-tbl tbody tr:hover { background: rgba(255,255,255,0.03); }
    .mc-tbl tbody td { padding: 10px 14px; font-size: 13px; color: #c9cad6; vertical-align: middle; }
    .mc-empty { text-align: center !important; padding: 28px !important; color: var(--muted) !important; }

    /* ── Badges ── */
    .mc-badge { display: inline-block; padding: 3px 10px; border-radius: 20px; font-size: 11px; font-weight: 700; }
    .mb-blue   { background: rgba(59,130,246,0.15);  color: #60a5fa; }
    .mb-green  { background: rgba(34,197,94,0.15);   color: #4ade80; }
    .mb-amber  { background: rgba(245,158,11,0.15);  color: #fbbf24; }
    .mb-red    { background: rgba(239,68,68,0.15);   color: #f87171; }
    .mb-purple { background: rgba(168,85,247,0.15);  color: #c084fc; }
    .mb-gray   { background: rgba(156,163,175,0.15); color: #9ca3af; }
    .mb-indigo { background: rgba(99,102,241,0.15);  color: #a5b4fc; }

    /* ── Botões ── */
    .mc-btn { display: inline-flex; align-items: center; gap: 6px; padding: 8px 16px; border-radius: 8px; font-size: 13px; font-weight: 700; text-decoration: none; border: none; cursor: pointer; transition: all .15s; }
    .mc-btn:hover { transform: translateY(-1px); text-decoration: none; }
    .mc-btn-primary { background: linear-gradient(135deg,#6366f1,#4f46e5); color: #fff; box-shadow: 0 4px 12px rgba(99,102,241,0.3); }
    .mc-btn-success { background: linear-gradient(135deg,#22c55e,#16a34a); color: #fff; box-shadow: 0 4px 12px rgba(34,197,94,0.3); }
    .mc-btn-danger  { background: linear-gradient(135deg,#ef4444,#dc2626); color: #fff; }
    .mc-btn-ghost   { background: rgba(255,255,255,0.07); color: var(--muted); border: 1px solid var(--border); }
    .mc-btn-ghost:hover { color: var(--text); }
    .mc-btn-sm { padding: 5px 10px; font-size: 12px; }

    /* ── Ação icon ── */
    .mc-act { width: 30px; height: 30px; border-radius: 6px; display: inline-flex; align-items: center; justify-content: center; font-size: 15px; text-decoration: none; transition: all .12s; }
    .mc-act:hover { transform: scale(1.1); }
    .mc-act-view { background: rgba(99,102,241,0.15); color: #a5b4fc; }
    .mc-act-view:hover { background: rgba(99,102,241,0.3); }
    .mc-act-print { background: rgba(156,163,175,0.15); color: #9ca3af; }
    .mc-act-print:hover { background: rgba(156,163,175,0.3); color: var(--text); }
    .mc-act-detail { background: rgba(251,191,36,0.15); color: #fbbf24; }
    .mc-act-detail:hover { background: rgba(251,191,36,0.3); }
    .mc-act-ok { background: rgba(34,197,94,0.15); color: #4ade80; }
    .mc-act-ok:hover { background: rgba(34,197,94,0.3); }
    .mc-act-no { background: rgba(239,68,68,0.15); color: #f87171; }
    .mc-act-no:hover { background: rgba(239,68,68,0.3); }

    /* ── Formulários ── */
    .mc-form-group { margin-bottom: 14px; }
    .mc-label { font-size: 11px; font-weight: 700; color: var(--muted); text-transform: uppercase; letter-spacing: .5px; display: block; margin-bottom: 5px; }
    .mc-label .req { color: #f87171; margin-left: 2px; }
    .mc-input, .mc-select, .mc-textarea {
        width: 100%; background: #13151f; border: 1px solid #444860; color: var(--text);
        border-radius: 8px; padding: 9px 13px; font-size: 13px; box-sizing: border-box;
        transition: border-color .15s; display: block; -webkit-appearance: none;
    }
    .mc-input:focus, .mc-select:focus, .mc-textarea:focus { border-color: var(--accent); outline: none; }
    .mc-select { height: 38px; }
    .mc-textarea { min-height: 100px; resize: vertical; }
    .mc-grid-2 { display: grid; grid-template-columns: 1fr 1fr; gap: 14px; }
    @media(max-width:640px){ .mc-grid-2 { grid-template-columns: 1fr; } }

    /* ── Alertas ── */
    .mc-alert { border-radius: 8px; padding: 10px 14px; font-size: 13px; margin-bottom: 14px; display: flex; align-items: center; gap: 8px; }
    .mc-alert-err  { background: rgba(239,68,68,0.1); border: 1px solid rgba(239,68,68,0.3); color: #f87171; }
    .mc-alert-ok   { background: rgba(34,197,94,0.1); border: 1px solid rgba(34,197,94,0.3); color: #4ade80; }
    .mc-alert-warn { background: rgba(245,158,11,0.1); border: 1px solid rgba(245,158,11,0.3); color: #fbbf24; }
    .mc-alert-info { background: rgba(99,102,241,0.1); border: 1px solid rgba(99,102,241,0.3); color: #a5b4fc; }

    /* ── Info rows ── */
    .mc-info-row { margin-bottom: 12px; }
    .mc-info-lbl { font-size: 10px; font-weight: 700; color: var(--muted); text-transform: uppercase; letter-spacing: .6px; display: block; margin-bottom: 2px; }
    .mc-info-val { font-size: 13px; color: var(--text); }
    .mc-text-box { background: #13151f; border: 1px solid var(--border); border-radius: 8px; padding: 10px 14px; font-size: 13px; color: #c9cad6; line-height: 1.6; }

    /* ── Paginação ── */
    .pagination { display: flex; gap: 4px; padding: 12px 16px; border-top: 1px solid var(--border); flex-wrap: wrap; }
    .pagination a, .pagination span { display: inline-flex; align-items: center; justify-content: center; min-width: 32px; height: 32px; padding: 0 8px; border-radius: 8px; font-size: 13px; font-weight: 600; text-decoration: none; transition: all .15s; }
    .pagination a { background: rgba(255,255,255,0.07); color: var(--muted); border: 1px solid var(--border); }
    .pagination a:hover { background: rgba(99,102,241,0.15); color: #a5b4fc; }
    .pagination .current { background: rgba(99,102,241,0.2); color: #a5b4fc; border: 1px solid rgba(99,102,241,0.4); }

    /* ── Responsive ── */
    @media(max-width:768px){
        .mc-sidebar { transform: translateX(-100%); }
        .mc-sidebar.open { transform: translateX(0); box-shadow: 4px 0 24px rgba(0,0,0,0.5); }
        .mc-overlay.show { display: block; }
        .mc-content { margin-left: 0; }
        .mc-topbar { left: 0; }
        .mc-hamburger { display: inline-flex; }
        .mc-kpis { grid-template-columns: 1fr 1fr; }
        .mc-inner { padding: 14px; }
    }

    /* ── OS detalhe ── */
    .mc-detail-section { margin-bottom: 14px; }

    /* ── Timeline anotações ── */
    .mc-timeline-item { display: flex; gap: 12px; padding: 12px 0; border-bottom: 1px solid rgba(255,255,255,0.04); }
    .mc-timeline-item:last-child { border-bottom: none; }
    .mc-timeline-dot { width: 8px; height: 8px; border-radius: 50%; background: var(--accent); flex-shrink: 0; margin-top: 5px; }
    </style>
</head>
<body>

<div class="mc-overlay" id="mcOverlay"></div>

<!-- ── Sidebar ── -->
<aside class="mc-sidebar" id="mcSidebar">
    <div class="mc-brand">
        <?php
        // Mine.php não carrega sisos_model — busca direto do banco
        try {
            $logoRow = $this->db->where('config','app_logo')->get('configuracoes')->row();
            $logoUrl = $logoRow ? $logoRow->valor : '';
        } catch(Exception $e) { $logoUrl = ''; }
        if ($logoUrl):
        ?>
        <img src="<?= $logoUrl ?>" alt="Logo">
        <?php else: ?>
        <i class='bx bx-user-circle' style="font-size:30px;color:#6366f1;flex-shrink:0;"></i>
        <span class="mc-brand-text"><?= $this->config->item('app_name') ?></span>
        <?php endif; ?>
    </div>

    <div class="mc-user-box">
        <div class="mc-user-avatar"><?= strtoupper(substr($this->session->userdata('nome')?:'C', 0, 1)) ?></div>
        <div>
            <div class="mc-user-name"><?= htmlspecialchars($this->session->userdata('nome') ?: 'Cliente') ?></div>
            <div class="mc-user-sub">Área do Cliente</div>
        </div>
    </div>

    <nav class="mc-nav">
        <div class="mc-nav-section">Menu</div>
        <a href="<?= base_url() ?>index.php/mine/painel" class="mc-nav-item <?= isset($menuPainel)?'active':'' ?>">
            <i class='bx bx-home-alt'></i> Painel
        </a>
        <a href="<?= base_url() ?>index.php/mine/os" class="mc-nav-item <?= isset($menuOs)?'active':'' ?>">
            <i class='bx bx-file'></i> Ordens de Serviço
        </a>
        <a href="<?= base_url() ?>index.php/mine/compras" class="mc-nav-item <?= isset($menuVendas)?'active':'' ?>">
            <i class='bx bx-cart-alt'></i> Compras
        </a>
        <a href="<?= base_url() ?>index.php/mine/cobrancas" class="mc-nav-item <?= isset($menuCobrancas)?'active':'' ?>">
            <i class='bx bx-credit-card-front'></i> Cobranças
        </a>
        <div class="mc-nav-section">Conta</div>
        <a href="<?= base_url() ?>index.php/mine/conta" class="mc-nav-item <?= isset($menuConta)?'active':'' ?>">
            <i class='bx bx-user-circle'></i> Minha Conta
        </a>
        <?php if (!$this->session->userdata('cadastra_os')): ?>
        <a href="<?= base_url() ?>index.php/mine/adicionarOs" class="mc-nav-item <?= isset($menuNovaOs)?'active':'' ?>">
            <i class='bx bx-plus-circle'></i> Abrir OS
        </a>
        <?php endif; ?>
    </nav>

    <div class="mc-sidebar-footer">
        <a href="<?= base_url() ?>index.php/mine/sair" class="mc-nav-item" style="color:#f87171;">
            <i class='bx bx-log-out'></i> Sair
        </a>
    </div>
</aside>

<!-- ── Topbar ── -->
<header class="mc-topbar">
    <div class="mc-topbar-left">
        <button class="mc-hamburger" id="mcHamburger"><i class='bx bx-menu'></i></button>
        <span class="mc-page-title"><?= $this->config->item('app_name') ?></span>
    </div>
    <div class="mc-topbar-right">
        <span class="mc-topbar-greeting">Olá, <strong><?= htmlspecialchars($this->session->userdata('nome') ?: '') ?></strong></span>
        <a href="<?= base_url() ?>index.php/mine/sair" class="mc-btn-logout">
            <i class='bx bx-log-out'></i> Sair
        </a>
    </div>
</header>

<!-- ── Content ── -->
<main class="mc-content">
    <div class="mc-inner">

        <?php if ($var = $this->session->flashdata('success')): ?>
        <div class="mc-alert mc-alert-ok"><i class='bx bx-check-circle'></i> <?= htmlspecialchars($var) ?></div>
        <?php endif; ?>
        <?php if ($var = $this->session->flashdata('error')): ?>
        <div class="mc-alert mc-alert-err"><i class='bx bx-error-circle'></i> <?= htmlspecialchars($var) ?></div>
        <?php endif; ?>

        <?php if (isset($output)) { $this->load->view($output); } ?>

    </div>

    <!-- Footer -->
    <div style="padding:14px 20px;border-top:1px solid var(--border);font-size:11px;color:#6b7280;text-align:center;">
        <?= date('Y') ?> &copy; <?= $this->config->item('app_name') ?> — v<?= $this->config->item('app_version') ?>
    </div>
</main>

<script>
var mcSidebar  = document.getElementById('mcSidebar');
var mcOverlay  = document.getElementById('mcOverlay');
var mcHamburger= document.getElementById('mcHamburger');

mcHamburger.addEventListener('click', function() {
    mcSidebar.classList.toggle('open');
    mcOverlay.classList.toggle('show');
});
mcOverlay.addEventListener('click', function() {
    mcSidebar.classList.remove('open');
    mcOverlay.classList.remove('show');
});
</script>
</body>
</html>
