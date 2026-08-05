<?php $temaClaro = in_array($configuration['app_theme'] ?? '', ['white','whitegreen','whiteblack']); ?>
<?php if ($temaClaro): ?>
<style>
/* ══════════════════════════════════════════════════════════════════
   TEMA CLARO — Dashboard (sisos/painel.php)
   Esta view usa paleta escura fixa (#1a1d2e/#1e2235/#e8eaf0) direto
   nos elementos, sem depender das variáveis do tema. Este bloco
   sobrescreve só quando o tema ativo é claro (white/whitegreen/
   whiteblack) — não altera nada do tema escuro.
   ══════════════════════════════════════════════════════════════════ */

/* KPIs do topo (OS abertas hoje / Receita / Vencidas / Estoque baixo) */
.sisos-kpi-card{ background:#ffffff !important; border-color:rgba(0,0,0,0.08) !important; }
.sisos-kpi-value{ color:#1f2937 !important; }

/* Atalhos (Clientes/Produtos/PDV/Ordens/Vendas/Assistente IA) */
.cardBox .card{ background:#ffffff !important; border-color:rgba(0,0,0,0.08) !important; }
.cardBox .numbers{ color:#1f2937 !important; }
.cardBox .cardName{ color:#6b7280 !important; opacity:1 !important; }

/* Agenda de OS (calendário) */
.sisos-agenda-card{ background:#ffffff !important; border-color:rgba(0,0,0,0.08) !important; }
.sisos-agenda-header{ background:rgba(249,115,22,0.04) !important; border-bottom-color:rgba(0,0,0,0.06) !important; }
.sisos-agenda-title{ color:#1f2937 !important; }
.sisos-agenda-select-wrap select{ background:#f9fafb !important; border-color:#d1d5db !important; color:#1f2937 !important; }
.sisos-agenda-legenda{ background:rgba(0,0,0,0.02) !important; border-bottom-color:rgba(0,0,0,0.05) !important; }
.sisos-leg{ background:#f3f4f6 !important; border-color:rgba(0,0,0,0.07) !important; color:#4b5563 !important; }
.sisos-fullcalendar-wrap .fc{ color:#1f2937 !important; }
.sisos-fullcalendar-wrap .fc-toolbar-title{ color:#1f2937 !important; }
.sisos-fullcalendar-wrap .fc-col-header-cell{ background:rgba(249,115,22,0.04) !important; color:#6b7280 !important; }
.sisos-fullcalendar-wrap .fc-daygrid-day-number{ color:#4b5563 !important; }
.sisos-fullcalendar-wrap .fc-scrollgrid{ border-color:rgba(0,0,0,0.08) !important; }
.sisos-fullcalendar-wrap .fc-scrollgrid td,.sisos-fullcalendar-wrap .fc-scrollgrid th{ border-color:rgba(0,0,0,0.06) !important; }

/* Estatísticas do Sistema (widget ao lado da agenda) */
.widget-box-new.widbox-blak{ background:#ffffff !important; border-color:rgba(0,0,0,0.08) !important; }
.cardHeader{ color:#1f2937 !important; }
.new-bottons .card{ background:#f9fafb !important; border-color:rgba(0,0,0,0.06) !important; }
.new-bottons .cardName2,.new-bottons .cardName1{ color:#1f2937 !important; }
.new-bottons .cardName{ color:#6b7280 !important; }

/* Tabelas (OS por status, Vendas, Lançamentos, Estoque mínimo, Técnico) */
.widget-box0{ background:#ffffff !important; border-color:rgba(0,0,0,0.08) !important; }
.widget-box0 table thead th{ background:#f3f4f6 !important; color:#6b7280 !important; border-color:rgba(0,0,0,0.08) !important; }
.widget-box0 table tbody td{ color:#374151 !important; border-color:rgba(0,0,0,0.05) !important; }
.widget-box0 table tbody tr:hover td{ background:rgba(0,0,0,0.02) !important; }
.widget-box0 .cli1{ color:#1f2937 !important; }
.widget-box-statist{ background:#ffffff !important; border-color:rgba(0,0,0,0.08) !important; }

/* Modal de detalhe da OS (clique num evento da agenda) */
.sisos-modal-box{ background:#ffffff !important; border-color:rgba(0,0,0,0.08) !important; }
.sisos-modal-head{ background:#f9fafb !important; border-bottom-color:rgba(0,0,0,0.08) !important; }
.sisos-modal-row{ color:#1f2937 !important; }
.sisos-modal-divider{ background:rgba(0,0,0,0.06) !important; }
.sisos-modal-info span{ color:#1f2937 !important; }
.sisos-modal-info-full p{ color:#4b5563 !important; }
.sisos-modal-foot{ background:#f9fafb !important; border-top-color:rgba(0,0,0,0.08) !important; }
</style>
<?php endif; ?>

<style>
/* ── Agenda Card ──────────────────────────────────────── */
.sisos-agenda-card{
    background:linear-gradient(135deg,#1a1d2e 0%,#1e2235 100%);
    border-radius:16px;
    border:1px solid rgba(249,115,22,0.15);
    overflow:hidden;
    margin-bottom:14px;
    box-shadow:0 4px 24px rgba(0,0,0,0.3);
}
.sisos-agenda-header{
    display:flex;align-items:center;justify-content:space-between;flex-wrap:wrap;gap:8px;
    padding:12px 16px;
    background:rgba(249,115,22,0.05);
    border-bottom:1px solid rgba(249,115,22,0.1);
}
.sisos-agenda-title{display:flex;align-items:center;gap:8px;font-size:13px;font-weight:800;color:#e8eaf0;letter-spacing:.3px;}
.sisos-agenda-title i{font-size:16px;color:#f97316;filter:drop-shadow(0 0 6px rgba(249,115,22,0.5));}
.sisos-agenda-filtro{display:flex;align-items:center;gap:6px;}
.sisos-agenda-select-wrap{position:relative;display:flex;align-items:center;}
.sisos-agenda-select-wrap i{position:absolute;left:8px;color:#6b7280;font-size:12px;pointer-events:none;}
.sisos-agenda-select-wrap select{
    appearance:none;background:#252a3a;border:1px solid rgba(249,115,22,0.2);border-radius:8px;
    color:#e8eaf0;font-size:12px;padding:6px 12px 6px 26px;cursor:pointer;min-width:145px;transition:border-color .2s;
}
.sisos-agenda-select-wrap select:focus{outline:none;border-color:#f97316;box-shadow:0 0 0 2px rgba(249,115,22,0.15);}
.sisos-agenda-btn-filtrar{
    display:flex;align-items:center;gap:4px;
    background:linear-gradient(135deg,#f97316,#ea580c);
    color:#fff;border:none;border-radius:8px;
    padding:6px 12px;font-size:12px;font-weight:700;cursor:pointer;
    transition:opacity .2s,transform .1s;
    box-shadow:0 2px 8px rgba(249,115,22,0.3);
}
.sisos-agenda-btn-filtrar:hover{opacity:.88;}
.sisos-agenda-btn-filtrar:active{transform:scale(.97);}
/* Legendas compactas */
.sisos-agenda-legenda{
    display:flex;flex-wrap:wrap;gap:4px 8px;
    padding:6px 16px;
    border-bottom:1px solid rgba(255,255,255,0.04);
    background:rgba(0,0,0,0.12);
}
.sisos-leg{
    display:inline-flex;align-items:center;gap:4px;
    font-size:10px;font-weight:700;color:#9ca3af;
    padding:2px 7px;border-radius:10px;
    background:rgba(255,255,255,0.03);border:1px solid rgba(255,255,255,0.06);
}
.sisos-leg::before{content:'';display:inline-block;width:6px;height:6px;border-radius:50%;background:var(--c,#888);}
.sisos-fullcalendar-wrap{padding:10px 12px 12px;}
/* FullCalendar overrides */
.sisos-fullcalendar-wrap .fc{font-family:'Inter','Segoe UI',sans-serif;font-size:12px;color:#e8eaf0;}
.sisos-fullcalendar-wrap .fc-toolbar{margin-bottom:10px!important;}
.sisos-fullcalendar-wrap .fc-toolbar-title{font-size:14px;font-weight:800;color:#e8eaf0;text-transform:capitalize;letter-spacing:.3px;}
.sisos-fullcalendar-wrap .fc-button,.sisos-fullcalendar-wrap .fc-button-primary{
    background:#252a3a!important;border:1px solid rgba(255,255,255,0.08)!important;
    color:#9ca3af!important;border-radius:7px!important;font-size:11px!important;
    padding:4px 10px!important;box-shadow:none!important;font-weight:600!important;}
.sisos-fullcalendar-wrap .fc-button:hover{background:#2e3447!important;color:#e8eaf0!important;}
.sisos-fullcalendar-wrap .fc-button-active,
.sisos-fullcalendar-wrap .fc-button-primary:not(:disabled).fc-button-active{
    background:linear-gradient(135deg,#f97316,#ea580c)!important;
    border-color:#f97316!important;color:#fff!important;
    box-shadow:0 2px 8px rgba(249,115,22,0.3)!important;}
.sisos-fullcalendar-wrap .fc-col-header-cell{
    background:rgba(249,115,22,0.06);border-color:rgba(255,255,255,0.06)!important;
    color:#6b7280;font-size:10px;font-weight:800;text-transform:uppercase;letter-spacing:.6px;padding:5px 0;}
.sisos-fullcalendar-wrap .fc-daygrid-day{border-color:rgba(255,255,255,0.04)!important;transition:background .15s;}
.sisos-fullcalendar-wrap .fc-daygrid-day:hover{background:rgba(249,115,22,0.05)!important;}
.sisos-fullcalendar-wrap .fc-daygrid-day-number{color:#6b7280;font-size:11px;padding:3px 6px;font-weight:600;}
.sisos-fullcalendar-wrap .fc-day-today{background:rgba(249,115,22,0.08)!important;}
.sisos-fullcalendar-wrap .fc-day-today .fc-daygrid-day-number{
    background:linear-gradient(135deg,#f97316,#ea580c);color:#fff;border-radius:50%;
    width:22px;height:22px;display:flex;align-items:center;justify-content:center;
    margin:3px;padding:0;font-weight:800;font-size:10px;
    box-shadow:0 2px 6px rgba(249,115,22,0.4);}
.sisos-fullcalendar-wrap .fc-event{
    border-radius:5px!important;border:none!important;border-left-width:3px!important;
    padding:1px 5px;font-size:10px;font-weight:700;cursor:pointer;
    transition:transform .15s,opacity .15s;letter-spacing:.1px;}
.sisos-fullcalendar-wrap .fc-event:hover{transform:translateY(-1px);opacity:1;box-shadow:0 2px 8px rgba(0,0,0,0.3);}
.sisos-fullcalendar-wrap .fc-more-link{color:#f97316;font-size:10px;font-weight:800;padding:1px 4px;}
.sisos-fullcalendar-wrap .fc-scrollgrid{border-color:rgba(255,255,255,0.04)!important;border-radius:10px;overflow:hidden;}
.sisos-fullcalendar-wrap .fc-scrollgrid td,.sisos-fullcalendar-wrap .fc-scrollgrid th{border-color:rgba(255,255,255,0.04)!important;}
.sisos-fullcalendar-wrap .fc-daygrid-body{background:transparent!important;}
/* ── Modal Moderno ─────────────────────────────────────── */
.sisos-modal-overlay{position:fixed;inset:0;z-index:9999;background:rgba(0,0,0,.65);
    display:flex;align-items:center;justify-content:center;padding:16px;animation:sisosOvIn .15s ease;}
@keyframes sisosOvIn{from{opacity:0}to{opacity:1}}
.sisos-modal-box{background:#1e2235;border:1px solid #252a3a;border-radius:18px;width:100%;max-width:480px;
    box-shadow:0 24px 60px rgba(0,0,0,.5);animation:sisosBoxIn .2s ease;overflow:hidden;}
@keyframes sisosBoxIn{from{transform:translateY(20px);opacity:0}to{transform:none;opacity:1}}
.sisos-modal-head{display:flex;align-items:center;justify-content:space-between;
    padding:16px 18px;background:#1a1d2e;border-bottom:1px solid #252a3a;}
.sisos-modal-badge-id{background:rgba(249,115,22,.15);color:#f97316;font-size:13px;font-weight:800;
    padding:4px 12px;border-radius:20px;border:1px solid rgba(249,115,22,.3);}
.sisos-modal-status-badge{font-size:11px;font-weight:700;padding:3px 10px;border-radius:20px;}
.sisos-modal-close{background:rgba(255,255,255,.06);border:none;color:#9ca3af;width:30px;height:30px;
    border-radius:50%;cursor:pointer;display:flex;align-items:center;justify-content:center;font-size:18px;transition:all .15s;}
.sisos-modal-close:hover{background:rgba(248,113,113,.15);color:#f87171;}
.sisos-modal-body{padding:16px 18px;}
.sisos-modal-row{display:flex;align-items:center;gap:8px;font-size:14px;font-weight:700;color:#e8eaf0;margin-bottom:12px;}
.sisos-modal-row i{color:#f97316;font-size:16px;}
.sisos-modal-divider{height:1px;background:#252a3a;margin:12px 0;}
.sisos-modal-grid2{display:grid;grid-template-columns:1fr 1fr;gap:12px;margin-bottom:4px;}
.sisos-modal-info label{display:block;font-size:10px;font-weight:700;color:#6b7280;text-transform:uppercase;letter-spacing:.5px;margin-bottom:2px;}
.sisos-modal-info span{font-size:13px;font-weight:600;color:#e8eaf0;}
.sisos-modal-info-full{margin-bottom:10px;}
.sisos-modal-info-full label{display:block;font-size:10px;font-weight:700;color:#6b7280;text-transform:uppercase;letter-spacing:.5px;margin-bottom:3px;}
.sisos-modal-info-full p{font-size:13px;color:#9ca3af;margin:0;line-height:1.5;}
.sisos-modal-total{display:flex;align-items:center;gap:8px;background:rgba(74,222,128,.07);
    border:1px solid rgba(74,222,128,.2);border-radius:10px;padding:10px 14px;
    font-size:15px;font-weight:800;color:#4ade80;margin-top:6px;}
.sisos-modal-foot{display:flex;gap:8px;flex-wrap:wrap;padding:12px 18px;border-top:1px solid #252a3a;background:#1a1d2e;}
.vos-btn{display:inline-flex;align-items:center;gap:5px;padding:7px 13px;border-radius:8px;
    font-size:12px;font-weight:700;text-decoration:none;border:none;cursor:pointer;transition:all .15s;white-space:nowrap;}
.vos-btn:hover{transform:translateY(-1px);text-decoration:none;opacity:.85;}
</style>
<style>
/* ── Action Cards: compact, side-by-side layout ── */
.cardBox {
    display: grid !important;
    grid-template-columns: repeat(6, 1fr) !important;
    gap: 10px !important;
    padding: 0 0 16px 0 !important;
    list-style: none !important;
    margin: 0 !important;
}
.cardBox .card {
    border-radius: 14px !important;
    transition: transform .2s cubic-bezier(.34,1.56,.64,1), box-shadow .2s ease, border-color .2s ease !important;
    border: 1px solid rgba(255,255,255,0.07) !important;
    overflow: hidden !important;
}
.cardBox .card:hover {
    transform: translateY(-5px) !important;
    border-color: rgba(249,115,22,0.5) !important;
    box-shadow: 0 12px 30px rgba(0,0,0,0.5), 0 0 0 1px rgba(249,115,22,0.2) !important;
}
.cardBox .cardLink {
    display: flex !important;
    flex-direction: row !important;
    align-items: center !important;
    justify-content: space-between !important;
    padding: 14px 14px !important;
    height: 70px !important;
    text-decoration: none !important;
    gap: 8px !important;
    min-height: unset !important;
}
.cardBox .grid-blak {
    display: flex !important;
    flex-direction: column !important;
    gap: 3px !important;
    margin: 0 !important;
}
.cardBox .card .numbers {
    font-size: 14px !important;
    font-weight: 800 !important;
    line-height: 1 !important;
    white-space: nowrap !important;
}
.cardBox .card .cardName {
    font-size: 10px !important;
    font-weight: 700 !important;
    letter-spacing: 1px !important;
    opacity: 0.45 !important;
    text-transform: uppercase !important;
    line-height: 1 !important;
}
.lord-icon01, .lord-icon02, .lord-icon03,
.lord-icon04, .lord-icon05, .lord-icon06 {
    border-radius: 10px !important;
    border: none !important;
    width: 38px !important;
    height: 38px !important;
    flex-shrink: 0 !important;
    transition: transform .2s cubic-bezier(.34,1.56,.64,1) !important;
    align-self: unset !important;
}
.cardBox .card:hover .lord-icon01,
.cardBox .card:hover .lord-icon02,
.cardBox .card:hover .lord-icon03,
.cardBox .card:hover .lord-icon04,
.cardBox .card:hover .lord-icon05,
.cardBox .card:hover .lord-icon06 {
    transform: scale(1.18) rotate(-8deg) !important;
}
.cardBox .iconBx02, .cardBox .iconBx03,
.cardBox .iconBx04, .cardBox .iconBx05, .cardBox .iconBx06 {
    font-size: 18px !important;
}

/* ── Sidebar: modern look ── */
#sidebar > ul > li > a {
    border-radius: 8px !important;
    margin: 1px 6px !important;
    padding: 9px 10px !important;
    display: flex !important;
    align-items: center !important;
    gap: 9px !important;
    font-size: 13px !important;
    font-weight: 500 !important;
    transition: all .18s ease !important;
    position: relative !important;
}
#sidebar > ul > li > a:hover {
    background: rgba(249,115,22,0.12) !important;
    color: #f97316 !important;
    border-radius: 8px !important;
    padding-left: 14px !important;
}
#sidebar > ul > li > a:hover .icon,
#sidebar > ul > li > a:hover .title,
#sidebar > ul > li > a:hover i {
    color: #f97316 !important;
    opacity: 1 !important;
}
#sidebar > ul > li.active > a {
    background: linear-gradient(135deg, rgba(249,115,22,0.22), rgba(251,146,60,0.08)) !important;
    border-left: 3px solid #f97316 !important;
    color: #fb923c !important;
    border-radius: 8px !important;
}
#sidebar > ul > li.active > a .icon,
#sidebar > ul > li.active > a .title,
#sidebar > ul > li.active > a i {
    color: #fb923c !important;
    opacity: 1 !important;
}
#sidebar > ul > li {
    border: none !important;
    margin: 0 !important;
}
#sidebar li a i {
    font-size: 17px !important;
    min-width: 18px !important;
    text-align: center !important;
}
#sidebar .search-box {
    border-radius: 10px !important;
    margin: 6px 8px !important;
}

/* ── Tables ── */
.widbox-blak .table thead th,
.widget-box0 .table thead th {
    font-size: 11px !important;
    font-weight: 700 !important;
    text-transform: uppercase !important;
    letter-spacing: .6px !important;
    padding: 10px 12px !important;
    border-bottom: 1px solid rgba(255,255,255,0.07) !important;
}
.widbox-blak .table tbody td,
.widget-box0 .table tbody td {
    padding: 9px 12px !important;
    font-size: 13px !important;
    vertical-align: middle !important;
}
.widbox-blak .table tbody tr:hover td,
.widget-box0 .table tbody tr:hover td {
    background: rgba(249,115,22,0.05) !important;
}
</style>
<!--[if lt IE 9]><script language="javascript" type="text/javascript" src="<?php echo base_url(); ?>js/dist/excanvas.min.js"></script><![endif]-->

<script language="javascript" type="text/javascript" src="<?= base_url(); ?>assets/js/dist/jquery.jqplot.min.js"></script>
<script type="text/javascript" src="<?= base_url(); ?>assets/js/dist/plugins/jqplot.pieRenderer.min.js"></script>
<script type="text/javascript" src="<?= base_url(); ?>assets/js/dist/plugins/jqplot.donutRenderer.min.js"></script>
<script src='<?= base_url(); ?>assets/js/fullcalendar.min.js'></script>
<script src='<?= base_url(); ?>assets/js/fullcalendar/locales/pt-br.js'></script>

<link href='<?= base_url(); ?>assets/css/fullcalendar.min.css' rel='stylesheet' />
<link rel="stylesheet" type="text/css" href="<?= base_url(); ?>assets/js/dist/jquery.jqplot.min.css" />
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/custom.css?v=1777861749" />

<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400&display=swap" rel="stylesheet">
<link href="https://fonts.googleapis.com/css2?family=Orbitron:wght@400;500;600;700&display=swap" rel="stylesheet">

<script src="https://cdn.jsdelivr.net/npm/chart.js@3.7.0/dist/chart.min.js"></script>

<!-- New Bem-vindos -->
<div id="content-bemv">
    <div class="bemv">Dashboard</div>
    <div></div>
</div>


<?php
// Calcula variação percentual "vs ontem" com segurança (sem divisão por zero)
if (!function_exists('sisosPctVsOntem')) {
    function sisosPctVsOntem($hoje, $ontem)
    {
        $hoje = floatval($hoje);
        $ontem = floatval($ontem);
        if ($ontem == 0) {
            return $hoje == 0 ? 0 : 100;
        }
        return round((($hoje - $ontem) / $ontem) * 100);
    }
}
$pctOs       = sisosPctVsOntem($os_hoje ?? 0, $os_ontem ?? 0);
$pctReceita  = sisosPctVsOntem($receita_hoje ?? 0, $receita_ontem ?? 0);
$pctVencidas = sisosPctVsOntem($os_vencidas ?? 0, $os_vencidas_ontem ?? 0);
?>

<!-- KPI Cards Row -->
<div class="sisos-kpi-row" style="display:grid;grid-template-columns:repeat(4,1fr);gap:12px;margin-bottom:16px;">

    <div class="sisos-kpi-card" style="background:#1e2235;border:1px solid rgba(255,255,255,0.07);border-radius:14px;padding:16px 18px;display:flex;align-items:center;gap:14px;">
        <div style="width:46px;height:46px;border-radius:12px;background:rgba(249,115,22,0.15);display:flex;align-items:center;justify-content:center;flex-shrink:0;">
            <i class='bx bx-file' style="font-size:22px;color:#f97316;"></i>
        </div>
        <div>
            <div class="sisos-kpi-value" style="font-size:26px;font-weight:800;color:#e8eaf0;line-height:1;"><?= $os_hoje ?? 0 ?></div>
            <div style="font-size:11px;color:#6b7280;font-weight:600;text-transform:uppercase;letter-spacing:.5px;margin-top:3px;">OS abertas hoje</div>
            <div style="font-size:11px;color:#6b7280;margin-top:4px;">
                <span style="color:<?= $pctOs > 0 ? '#4ade80' : ($pctOs < 0 ? '#f87171' : '#6b7280') ?>;">●</span>
                <?= ($pctOs > 0 ? '+' : '') . $pctOs ?>% vs ontem
            </div>
        </div>
    </div>

    <div class="sisos-kpi-card" style="background:#1e2235;border:1px solid rgba(255,255,255,0.07);border-radius:14px;padding:16px 18px;display:flex;align-items:center;gap:14px;">
        <div style="width:46px;height:46px;border-radius:12px;background:rgba(34,197,94,0.15);display:flex;align-items:center;justify-content:center;flex-shrink:0;">
            <i class='bx <?= ($pode_ver_financeiro ?? false) ? "bx-trending-up" : "bx-lock-alt" ?>' style="font-size:22px;color:#22c55e;"></i>
        </div>
        <?php if ($pode_ver_financeiro ?? false): ?>
        <div>
            <div class="sisos-kpi-value" style="font-size:22px;font-weight:800;color:#e8eaf0;line-height:1;">R$ <?= number_format($receita_hoje ?? 0, 2, ',', '.') ?></div>
            <div style="font-size:11px;color:#6b7280;font-weight:600;text-transform:uppercase;letter-spacing:.5px;margin-top:3px;">Receita de hoje</div>
            <div style="font-size:11px;color:#6b7280;margin-top:4px;">
                <span style="color:<?= $pctReceita > 0 ? '#4ade80' : ($pctReceita < 0 ? '#f87171' : '#6b7280') ?>;">●</span>
                <?= ($pctReceita > 0 ? '+' : '') . $pctReceita ?>% vs ontem
            </div>
        </div>
        <?php else: ?>
        <div>
            <div style="font-size:16px;font-weight:700;color:#6b7280;line-height:1;">Sem permissão</div>
            <div style="font-size:11px;color:#6b7280;font-weight:600;text-transform:uppercase;letter-spacing:.5px;margin-top:3px;">Receita de hoje</div>
        </div>
        <?php endif; ?>
    </div>

    <div class="sisos-kpi-card" style="background:#1e2235;border:1px solid <?= ($os_vencidas ?? 0) > 0 ? 'rgba(239,68,68,0.3)' : 'rgba(255,255,255,0.07)' ?>;border-radius:14px;padding:16px 18px;display:flex;align-items:center;gap:14px;">
        <div style="width:46px;height:46px;border-radius:12px;background:rgba(239,68,68,0.15);display:flex;align-items:center;justify-content:center;flex-shrink:0;">
            <i class='bx bx-time-five' style="font-size:22px;color:#ef4444;"></i>
        </div>
        <div>
            <div class="sisos-kpi-value" style="font-size:26px;font-weight:800;color:<?= ($os_vencidas ?? 0) > 0 ? '#ef4444' : '#e8eaf0' ?>;line-height:1;"><?= $os_vencidas ?? 0 ?></div>
            <div style="font-size:11px;color:#6b7280;font-weight:600;text-transform:uppercase;letter-spacing:.5px;margin-top:3px;">OS vencidas</div>
            <div style="font-size:11px;color:#6b7280;margin-top:4px;">
                <span style="color:<?= $pctVencidas > 0 ? '#f87171' : ($pctVencidas < 0 ? '#4ade80' : '#6b7280') ?>;">●</span>
                <?= ($pctVencidas > 0 ? '+' : '') . $pctVencidas ?>% vs ontem
            </div>
        </div>
    </div>

    <div class="sisos-kpi-card" style="background:#1e2235;border:1px solid <?= ($estoque_baixo ?? 0) > 0 ? 'rgba(245,158,11,0.3)' : 'rgba(255,255,255,0.07)' ?>;border-radius:14px;padding:16px 18px;display:flex;align-items:center;gap:14px;">
        <div style="width:46px;height:46px;border-radius:12px;background:rgba(245,158,11,0.15);display:flex;align-items:center;justify-content:center;flex-shrink:0;">
            <i class='bx bx-package' style="font-size:22px;color:#f59e0b;"></i>
        </div>
        <div>
            <div class="sisos-kpi-value" style="font-size:26px;font-weight:800;color:<?= ($estoque_baixo ?? 0) > 0 ? '#f59e0b' : '#e8eaf0' ?>;line-height:1;"><?= $estoque_baixo ?? 0 ?></div>
            <div style="font-size:11px;color:#6b7280;font-weight:600;text-transform:uppercase;letter-spacing:.5px;margin-top:3px;">Estoque baixo</div>
            <div style="font-size:11px;color:#6b7280;margin-top:4px;">
                <span style="color:<?= ($estoque_zerado ?? 0) > 0 ? '#f59e0b' : '#6b7280' ?>;">●</span>
                <?= $estoque_zerado ?? 0 ?> itens críticos
            </div>
        </div>
    </div>

</div>

<!-- Action boxes -->
<ul class="cardBox">
    <?php if ($this->permission->checkPermission($this->session->userdata('permissao'), 'vCliente')) : ?>
        <li class="card">
            <a class="cardLink" href="<?= site_url('clientes') ?>">
                <div class="grid-blak">
                    <div class="numbers">Clientes</div>
                    <div class="cardName">F1</div>
                </div>
                <div class="lord-icon02">
                    <i class='bx bx-user iconBx02'></i>
                </div>
            </a>
        </li>
    <?php endif ?>

    <?php if ($this->permission->checkPermission($this->session->userdata('permissao'), 'vProduto')) : ?>
        <li class="card">
            <a class="cardLink" href="<?= site_url('produtos') ?>">
                <div class="grid-blak">
                    <div class="numbers">Produtos</div>
                    <div class="cardName">F2</div>
                </div>
                <div class="lord-icon02">
                    <i class='bx bx-basket iconBx02'></i>
                </div>
            </a>
        </li>
    <?php endif ?>

    <?php if (($this->data['configuration']['pdv_enabled'] ?? '0') == '1' && $this->permission->checkPermission($this->session->userdata('permissao'), 'aVenda')): ?>
        <li class="card">
            <a class="cardLink" href="<?= site_url('pdv') ?>">
                <div class="grid-blak">
                    <div class="numbers">PDV</div>
                    <div class="cardName">F3</div>
                </div>
                <div class="lord-icon03">
                    <i class='bx bx-store iconBx03' style="color:#22c55e;"></i>
                </div>
            </a>
        </li>
    <?php else: ?>
        <li class="card">
            <a class="cardLink" href="<?= site_url('promissoria') ?>">
                <div class="grid-blak">
                    <div class="numbers">Promissória</div>
                    <div class="cardName">F3</div>
                </div>
                <div class="lord-icon03">
                    <i class='bx bx-file-blank iconBx03'></i>
                </div>
            </a>
        </li>
    <?php endif; ?>

    <?php if ($this->permission->checkPermission($this->session->userdata('permissao'), 'vOs')) : ?>
        <li class="card">
            <a class="cardLink" href="<?= site_url('os') ?>">
                <div class="grid-blak">
                    <div class="numbers N-tittle">Ordens</div>
                    <div class="cardName">F4</div>
                </div>
                <div class="lord-icon04">
                    <i class='bx bx-file iconBx04'></i>
                </div>
            </a>
        </li>
    <?php endif ?>

    <?php if ($this->permission->checkPermission($this->session->userdata('permissao'), 'vVenda')) : ?>
        <li class="card">
            <a class="cardLink" href="<?= site_url('vendas/') ?>">
                <div class="grid-blak">
                    <div class="numbers N-tittle">Vendas</div>
                    <div class="cardName">F6</div>
                </div>
                <div class="lord-icon05">
                    <i class='bx bx-cart-alt iconBx05'></i>
                </div>
            </a>
        </li>
    <?php endif ?>

    <?php
    $iaOn = $this->db->where('config','gemini_enabled')->get('configuracoes')->row();
    if ($iaOn && $iaOn->valor == '1') : ?>
        <li class="card">
            <a class="cardLink" href="<?= site_url('sisos/ia') ?>">
                <div class="grid-blak">
                    <div class="numbers N-tittle">Assistente IA</div>
                    <div class="cardName">F7</div>
                </div>
                <div class="lord-icon06">
                    <i class="bx bx-bot iconBx06" style="color:#a78bfa;"></i>
                </div>
            </a>
        </li>
    <?php elseif ($this->permission->checkPermission($this->session->userdata('permissao'), 'vLancamento')) : ?>
        <li class="card">
            <a class="cardLink" href="<?= site_url('financeiro/lancamentos') ?>">
                <div class="grid-blak">
                    <div class="numbers N-tittle">Lançamentos</div>
                    <div class="cardName">F7</div>
                </div>
                <div class="lord-icon06">
                    <i class="bx bx-bar-chart-alt-2 iconBx06"></i>
                </div>
            </a>
        </li>
    <?php endif ?>
</ul>
<!-- End-Action boxes -->

<div class="row-fluid" style="margin-top: 0; display: flex">
    <div class="Sspan12">
        <div class="sisos-agenda-card">
            <div class="sisos-agenda-header">
                <div class="sisos-agenda-title">
                    <i class='bx bx-calendar-check'></i>
                    <span>Agenda de OS</span>
                </div>
                <div class="sisos-agenda-filtro">
                    <div class="sisos-agenda-select-wrap">
                        <i class='bx bx-filter-alt'></i>
                        <select id="statusOsGet" name="statusOsGet">
                            <option value="">Todos os Status</option>
                            <option value="Aberto">Aberto</option>
                            <option value="Faturado">Faturado</option>
                            <option value="Negociação">Negociação</option>
                            <option value="Orçamento">Orçamento</option>
                            <option value="Em Andamento">Em Andamento</option>
                            <option value="Finalizado">Finalizado</option>
                            <option value="Cancelado">Cancelado</option>
                            <option value="Aguardando Peças">Aguardando Peças</option>
                            <option value="Aprovado">Aprovado</option>
                        </select>
                    </div>
                    <button type="button" id="btn-calendar" class="sisos-agenda-btn-filtrar" title="Filtrar">
                        <i class='bx bx-search'></i> Filtrar
                    </button>
                </div>
            </div>

            <!-- Legenda resumida de status -->
            <div class="sisos-agenda-legenda">
                <span class="sisos-leg" style="--c:#22c55e">Aberto</span>
                <span class="sisos-leg" style="--c:#436eee">Em Andamento</span>
                <span class="sisos-leg" style="--c:#f97316">Ag. Peças</span>
                <span class="sisos-leg" style="--c:#a78bfa">Faturado</span>
                <span class="sisos-leg" style="--c:#22d3ee">Aprovado</span>
                <span class="sisos-leg" style="--c:#4ade80">Finalizado</span>
                <span class="sisos-leg" style="--c:#f87171">Cancelado</span>
                <span class="sisos-leg" style="--c:#CDB380">Orçamento</span>
            </div>

            <div id='source-calendar' class="sisos-fullcalendar-wrap"></div>
        </div>

        <!-- New widget right -->
        <div class="new-statisc">
            <div class="widget-box-new widbox-blak" style="height:100%">
                <div>
                    <h5 class="cardHeader">Estatísticas do Sistema</h5>
                </div>

                <div class="new-bottons">
                    <a href="<?php echo base_url(); ?>index.php/clientes/adicionar" class="card tip-top" title="Add Clientes e Fornecedores">
                        <div><i class='bx bxs-group iconBx'></i></div>
                        <div>
                            <div class="cardName2"><?= $this->db->count_all('clientes'); ?></div>
                            <div class="cardName">Clientes</div>
                        </div>
                    </a>

                    <a href="<?php echo base_url(); ?>index.php/produtos/adicionar" class="card tip-top" title="Adicionar Produtos">
                        <div><i class='bx bxs-package iconBx2'></i></div>
                        <div>
                            <div class="cardName2"><?= $this->db->count_all('produtos'); ?></div>
                            <div class="cardName">Produtos</div>
                        </div>
                    </a>

                    <a href="<?php echo base_url() ?>index.php/servicos/adicionar" class="card tip-top" title="Adicionar serviços">
                        <div><i class='bx bxs-stopwatch iconBx3'></i></div>
                        <div>
                            <div class="cardName2"><?= $this->db->count_all('servicos'); ?></div>
                            <div class="cardName">Serviços</div>
                        </div>
                    </a>

                    <a href="<?php echo base_url(); ?>index.php/os/adicionar" class="card tip-top" title="Adicionar OS">
                        <div><i class='bx bxs-spreadsheet iconBx4'></i></div>
                        <div>
                            <div class="cardName2"><?= $this->db->count_all('os'); ?></div>
                            <div class="cardName">Ordens</div>
                        </div>
                    </a>

                    <a href="<?php echo base_url(); ?>index.php/garantias" class="card tip-top" title="Adicionar garantia">
                        <div><i class='bx bxs-receipt iconBx6'></i></div>
                        <div>
                            <div class="cardName2"><?= $this->db->count_all('garantias'); ?></div>
                            <div class="cardName">Garantias</div>
                        </div>
                    </a>

                    <a href="<?php echo base_url() ?>index.php/vendas/adicionar" class="card tip-top" title="Adicionar Vendas">
                        <div><i class='bx bxs-cart-alt iconBx5'></i></div>
                        <div>
                            <div class="cardName2"><?= $this->db->count_all('vendas'); ?></div>
                            <div class="cardName">Vendas</div>
                        </div>
                    </a>

                    <!-- responsavel por fazer complementar a variavel "$financeiro_mes_dia->" de receita e despesa -->
                    <?php if ($estatisticas_financeiro != null) {
                        if ($estatisticas_financeiro->total_receita != null || $estatisticas_financeiro->total_despesa != null || $estatisticas_financeiro->total_receita_pendente != null || $estatisticas_financeiro->total_despesa_pendente != null) {  ?>

                            <?php if ($this->permission->checkPermission($this->session->userdata('permissao'), 'rFinanceiro')) : ?>
                                <?php $diaRec = "VALOR_" . date('m') . "_REC";
                                $diaDes = "VALOR_" . date('m') . "_DES"; ?>

                                <a href="<?php echo base_url() ?>index.php/financeiro/lancamentos" class="card tip-top" title="Adicionar receita">
                                    <div><i class='bx bxs-up-arrow-circle iconBx7'></i></div>
                                    <div>
                                        <div class="cardName1 cardName2">R$ <?php echo number_format(($financeiro_mes_dia->$diaRec - $financeiro_mes_dia->$diaDes), 2, ',', '.'); ?></div>
                                        <div class="cardName">Receita do dia</div>
                                    </div>
                                </a>

                                <a href="<?php echo base_url() ?>index.php/financeiro/lancamentos" class="card tip-top" title="Adiciona despesa">
                                    <div><i class='bx bxs-down-arrow-circle iconBx8'></i></div>
                                    <div>
                                        <div class="cardName1 cardName2">R$ <?php echo number_format(($financeiro_mes_dia->$diaDes ? $financeiro_mes_dia->$diaDes : 0), 2, ',', '.'); ?></div>
                                        <div class="cardName">Despesa do dia</div>
                                    </div>
                                </a>
                            <?php endif ?>

                    <?php  }
                    } ?>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Fim new widget right -->

<?php if ($estatisticas_financeiro != null) {
    if ($estatisticas_financeiro->total_receita != null || $estatisticas_financeiro->total_despesa != null || $estatisticas_financeiro->total_receita_pendente != null || $estatisticas_financeiro->total_despesa_pendente != null) {  ?>

        <?php if ($this->permission->checkPermission($this->session->userdata('permissao'), 'rFinanceiro')) : ?>
            <!-- Start Charts -->
            <div class="new-balance">
                <div class="widget-box0">
                    <div class="widget-title2">
                        <h5 class="cardHeader">Balanço Mensal do Ano</h5>
                        <form method="get" style="display:flex;margin-right:18px;justify-content:flex-end">
                            <input type="number" name="year" style="width:65px;margin-left:17px;margin-bottom:25px;margin-top:10px;padding-left: 35px" value="<?php echo intval(preg_replace('/[^0-9]/', '', $this->input->get('year'))) ?: date('Y') ?>">
                            <button type="submit" class="btn-xsx"><i class='bx bx-search iconX'></i></button>
                        </form>
                    </div>
                    <div class="widget-content" style="padding:10px 25px 5px 25px">
                        <div class="row-fluid" style="margin-top:-35px;">
                            <div class="span12">
                                <canvas id="myChart" style="overflow-x: scroll;margin-left: -14px"></canvas>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="widget-box-statist">
                    <h5 class="cardHeader">Estatísticas Financeira</h5>
                    <div class="widget-content" style="padding:10px;margin:25px 0 0">
                        <canvas id="statusOS"> </canvas>
                    </div>
                </div>
            </div>
        <?php endif ?>

<script type="text/javascript">
    if (window.outerWidth > 2000) {
        Chart.defaults.font.size = 15;
    };
    if (window.outerWidth < 2000 && window.outerWidth > 1367) {
        Chart.defaults.font.size = 11;
    };
    if (window.outerWidth < 1367 && window.outerWidth > 480) {
        Chart.defaults.font.size = 9.5;
    };
    if (window.outerWidth < 480) {
        Chart.defaults.font.size = 8.5;
    };

    var ctx = document.getElementById('myChart').getContext('2d');
    var StatusOS = document.getElementById('statusOS').getContext('2d');

    var myChart = new Chart(ctx, {
        data: {
            labels: ['Jan', 'Fev', 'Mar', 'Abr', 'Mai', 'Jun', 'Jul', 'Ago', 'Set', 'Out', 'Nov', 'Dez'],
            datasets: [{
                    label: 'Receita Líquida',
                    data: [<?php echo($financeiro_mes->VALOR_JAN_REC - $financeiro_mes->VALOR_JAN_DES); ?>,
                        <?php echo($financeiro_mes->VALOR_FEV_REC - $financeiro_mes->VALOR_FEV_DES); ?>,
                        <?php echo($financeiro_mes->VALOR_MAR_REC - $financeiro_mes->VALOR_MAR_DES); ?>,
                        <?php echo($financeiro_mes->VALOR_ABR_REC - $financeiro_mes->VALOR_ABR_DES); ?>,
                        <?php echo($financeiro_mes->VALOR_MAI_REC - $financeiro_mes->VALOR_MAI_DES); ?>,
                        <?php echo($financeiro_mes->VALOR_JUN_REC - $financeiro_mes->VALOR_JUN_DES); ?>,
                        <?php echo($financeiro_mes->VALOR_JUL_REC - $financeiro_mes->VALOR_JUL_DES); ?>,
                        <?php echo($financeiro_mes->VALOR_AGO_REC - $financeiro_mes->VALOR_AGO_DES); ?>,
                        <?php echo($financeiro_mes->VALOR_SET_REC - $financeiro_mes->VALOR_SET_DES); ?>,
                        <?php echo($financeiro_mes->VALOR_OUT_REC - $financeiro_mes->VALOR_OUT_DES); ?>,
                        <?php echo($financeiro_mes->VALOR_NOV_REC - $financeiro_mes->VALOR_NOV_DES); ?>,
                        <?php echo($financeiro_mes->VALOR_DEZ_REC - $financeiro_mes->VALOR_DEZ_DES); ?>
                    ],

                    backgroundColor: 'rgba(16, 185, 129, 0.75)',
                    hoverBackgroundColor: 'rgba(16, 185, 129, 1)',
                    borderRadius: 15,
                },

                {
                    label: 'Receita Bruta',
                    data: [<?php echo($financeiro_mes->VALOR_JAN_REC); ?>,
                        <?php echo($financeiro_mes->VALOR_FEV_REC); ?>,
                        <?php echo($financeiro_mes->VALOR_MAR_REC); ?>,
                        <?php echo($financeiro_mes->VALOR_ABR_REC); ?>,
                        <?php echo($financeiro_mes->VALOR_MAI_REC); ?>,
                        <?php echo($financeiro_mes->VALOR_JUN_REC); ?>,
                        <?php echo($financeiro_mes->VALOR_JUL_REC); ?>,
                        <?php echo($financeiro_mes->VALOR_AGO_REC); ?>,
                        <?php echo($financeiro_mes->VALOR_SET_REC); ?>,
                        <?php echo($financeiro_mes->VALOR_OUT_REC); ?>,
                        <?php echo($financeiro_mes->VALOR_NOV_REC); ?>,
                        <?php echo($financeiro_mes->VALOR_DEZ_REC); ?>
                    ],

                    backgroundColor: 'rgba(245, 158, 11, 0.75)',
                    hoverBackgroundColor: 'rgba(245, 158, 11, 1)',
                    borderRadius: 15,
                },

                {
                    label: 'Despesas',
                    data: [<?php echo($financeiro_mes->VALOR_JAN_DES); ?>,
                        <?php echo($financeiro_mes->VALOR_FEV_DES); ?>,
                        <?php echo($financeiro_mes->VALOR_MAR_DES); ?>,
                        <?php echo($financeiro_mes->VALOR_ABR_DES); ?>,
                        <?php echo($financeiro_mes->VALOR_MAI_DES); ?>,
                        <?php echo($financeiro_mes->VALOR_JUN_DES); ?>,
                        <?php echo($financeiro_mes->VALOR_JUL_DES); ?>,
                        <?php echo($financeiro_mes->VALOR_AGO_DES); ?>,
                        <?php echo($financeiro_mes->VALOR_SET_DES); ?>,
                        <?php echo($financeiro_mes->VALOR_OUT_DES); ?>,
                        <?php echo($financeiro_mes->VALOR_NOV_DES); ?>,
                        <?php echo($financeiro_mes->VALOR_DEZ_DES); ?>
                    ],

                    backgroundColor: 'rgba(239, 68, 68, 0.75)',
                    hoverBackgroundColor: 'rgba(239, 68, 68, 1)',
                    borderRadius: 15,
                },

                {
                    label: 'Inadimplência',
                    data: [<?php echo($financeiro_mesinadipl->VALOR_JAN_REC); ?>,
                        <?php echo($financeiro_mesinadipl->VALOR_FEV_REC); ?>,
                        <?php echo($financeiro_mesinadipl->VALOR_MAR_REC); ?>,
                        <?php echo($financeiro_mesinadipl->VALOR_ABR_REC); ?>,
                        <?php echo($financeiro_mesinadipl->VALOR_MAI_REC); ?>,
                        <?php echo($financeiro_mesinadipl->VALOR_JUN_REC); ?>,
                        <?php echo($financeiro_mesinadipl->VALOR_JUL_REC); ?>,
                        <?php echo($financeiro_mesinadipl->VALOR_AGO_REC); ?>,
                        <?php echo($financeiro_mesinadipl->VALOR_SET_REC); ?>,
                        <?php echo($financeiro_mesinadipl->VALOR_OUT_REC); ?>,
                        <?php echo($financeiro_mesinadipl->VALOR_NOV_REC); ?>,
                        <?php echo($financeiro_mesinadipl->VALOR_DEZ_REC); ?>
                    ],

                    backgroundColor: 'rgba(96, 165, 250, 0.75)',
                    hoverBackgroundColor: 'rgba(96, 165, 250, 1)',
                    borderRadius: 15,
                }
            ]

        },
        // configuração
        type: 'bar',
        options: {
            locale: 'pt-BR',
            animation: {
                duration: 800,
                easing: 'easeOutQuart'
            },
            scales: {
                y: {
                    ticks: {
                        color: '#9ca3af',
                        callback: (value, index, values) => {
                            return new Intl.NumberFormat('pt-BR', {
                                style: 'currency',
                                currency: 'BRL',
                                maximumSignificantDidits: 1
                            }).format(value);
                        }
                    },
                    grid: {
                        color: 'rgba(255,255,255,0.06)'
                    }
                },
                x: {
                    beginAtZero: true,
                    title: {
                        display: true,
                        text: 'Meses',
                        color: '#9ca3af'
                    },
                    ticks: {
                        color: '#9ca3af'
                    },
                    grid: {
                        display: false
                    }
                }
            },

            plugins: {
                tooltip: {
                    backgroundColor: '#1e2235',
                    titleColor: '#e8eaf0',
                    bodyColor: '#c9cad6',
                    borderColor: 'rgba(16,185,129,0.35)',
                    borderWidth: 1,
                    cornerRadius: 10,
                    padding: 12,
                    usePointStyle: true,
                    callbacks: {
                        beforeTitle: function(context) {
                            return 'Referente ao mês de';
                        }
                    }
                },

                legend: {
                    position: "bottom",
                    labels: {
                        usePointStyle: true,
                        color: '#9ca3af',
                        padding: 16
                    }
                }
            }
        }
    });

    var myChart = new Chart(statusOS, {
        data: {
            labels: [
                'Receita total', 'Receita pendente',
                'Previsto em caixa', 'Despesa total',
                'Despesa pendente', 'Previsto a entrar'
            ],
            datasets: [{
                label: 'Total',
                data: [
                    <?php echo ($estatisticas_financeiro->total_receita != null) ?  $estatisticas_financeiro->total_receita : '0.00'; ?>,
                    <?php echo ($estatisticas_financeiro->total_receita_pendente != null) ?  $estatisticas_financeiro->total_receita_pendente : '0.00'; ?>,
                    <?php echo($estatisticas_financeiro->total_receita - $estatisticas_financeiro->total_despesa); ?>,
                    <?php echo ($estatisticas_financeiro->total_despesa != null) ?  $estatisticas_financeiro->total_despesa : '0.00'; ?>,
                    <?php echo ($estatisticas_financeiro->total_despesa_pendente != null) ?  $estatisticas_financeiro->total_despesa_pendente : '0.00'; ?>,
                    <?php echo($estatisticas_financeiro->total_receita_pendente - $estatisticas_financeiro->total_despesa_pendente); ?>
                ],

                backgroundColor: [
                    'rgba(16, 185, 129, 0.75)',
                    'rgba(96, 165, 250, 0.75)',
                    'rgba(245, 158, 11, 0.75)',
                    'rgba(239, 68, 68, 0.75)',
                    'rgba(251, 146, 60, 0.75)',
                    'rgba(5, 150, 105, 0.75)'
                ],
                hoverBackgroundColor: [
                    'rgba(16, 185, 129, 1)',
                    'rgba(96, 165, 250, 1)',
                    'rgba(245, 158, 11, 1)',
                    'rgba(239, 68, 68, 1)',
                    'rgba(251, 146, 60, 1)',
                    'rgba(5, 150, 105, 1)'
                ],
                borderWidth: 1,
                borderColor: 'rgba(255,255,255,0.15)',
                hoverOffset: 10
            }]
        },

        // configuração
        type: 'polarArea',
        options: {
            locale: 'pt-BR',
            animation: {
                duration: 800,
                easing: 'easeOutQuart'
            },
            scales: {
                r: {
                    ticks: {
                        callback: (value, index, values) => {
                            return new Intl.NumberFormat('pt-BR', {
                                style: 'currency',
                                currency: 'BRL',
                                maximumSignificantDidits: 1
                            }).format(value);
                        },
                        backdropColor: 'rgba(0,0,0,0)',
                        color: '#9ca3af',
                        count: 5
                    },
                    beginAtZero: true,
                    grid: {
                        color: 'rgba(255,255,255,0.08)'
                    },
                    angleLines: {
                        color: 'rgba(255,255,255,0.08)'
                    }
                }
            },
            plugins: {
                tooltip: {
                    backgroundColor: '#1e2235',
                    titleColor: '#e8eaf0',
                    bodyColor: '#c9cad6',
                    borderColor: 'rgba(16,185,129,0.35)',
                    borderWidth: 1,
                    cornerRadius: 10,
                    padding: 12,
                    usePointStyle: true
                },
                legend: {
                    position: "bottom",
                    labels: {
                        usePointStyle: true,
                        color: '#9ca3af',
                        padding: 14

                    }
                }
            }
        }
    });

    function responsiveFonts() {
        myChart.update();
    }
</script>
<?php  }
} ?>
</div>
</div>

<!-- Start Staus OS -->
<div class="span12A" style="margin-left: 0">
    <div class="widget-box0 widbox-blak">
        <div>
            <h5 class="cardHeader">Ordens de Serviços Em Orçamento.</h5>
        </div>
        <div class="widget-content">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>N°</th>
                        <th>Cliente</th>
                        <th>Data Final</th>
                        <th>Status</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if ($ordens_orcamentos != null) : ?>
                        <?php foreach ($ordens_orcamentos as $o) : ?>
                            <?php
                                    switch ($o->status) {
                                        case 'Aberto':
                                            $cor = '#00cd00';
                                            break;
                                        case 'Em Andamento':
                                            $cor = '#436eee';
                                            break;
                                        case 'Orçamento':
                                            $cor = '#CDB380';
                                            break;
                                        case 'Negociação':
                                            $cor = '#AEB404';
                                            break;
                                        case 'Cancelado':
                                            $cor = '#CD0000';
                                            break;
                                        case 'Finalizado':
                                            $cor = '#256';
                                            break;
                                        case 'Faturado':
                                            $cor = '#B266FF';
                                            break;
                                        case 'Aguardando Peças':
                                            $cor = '#FF7F00';
                                            break;
                                        case 'Aprovado':
                                            $cor = '#808080';
                                            break;
                                        default:
                                            $cor = '#E0E4CC';
                                            break;
                                    }
                            ?>
                            <tr>
                                <td>
                                    <?= $o->idOs ?>
                                </td>

                                <td class="cli1">
                                    <?= $o->nomeCliente ?>
                                </td>

                                <td><?php if ($o->dataFinal != null) {
                                    echo date('d/m/Y', strtotime($o->dataFinal));
                                } else {
                                    echo "";
                                } ?></td>

                                <td>
                                    <span class="badge" style="background-color: <?= $cor ?>; border-color: <?= $cor ?>;"><?= $o->status ?></span>
                                </td>

                                <td>
                                    <?php if ($this->permission->checkPermission($this->session->userdata('permissao'), 'vOs')) : ?>
                                        <a href="<?= base_url() ?>index.php/os/visualizar/<?= $o->idOs ?>" class="btn-nwe tip-top" title="Visualizar OS" style="margin-right:3px;">
                                            <i class="bx bx-show"></i>
                                        </a>

                                    <?php endif ?>
                                </td>
                            </tr>
                        <?php endforeach ?>
                    <?php else : ?>
                        <tr>
                            <td colspan="5">Nenhuma OS em Orçamento.</td>
                        </tr>
                    <?php endif ?>
                </tbody>
            </table>
        </div>
    </div>
    
    <div class="widget-box0 widbox-blak">
        <div>
            <h5 class="cardHeader">Ordens de Serviços Em Aberto</h5>
        </div>
        <div class="widget-content">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>N°</th>
                        <th>Cliente</th>
                        <th>Data Final</th>
                        <th>Status</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if ($ordens_abertas != null) : ?>
                        <?php foreach ($ordens_abertas as $o) : ?>
                            <?php
                                    switch ($o->status) {
                                        case 'Aberto':
                                            $cor = '#00cd00';
                                            break;
                                        case 'Em Andamento':
                                            $cor = '#436eee';
                                            break;
                                        case 'Orçamento':
                                            $cor = '#CDB380';
                                            break;
                                        case 'Negociação':
                                            $cor = '#AEB404';
                                            break;
                                        case 'Cancelado':
                                            $cor = '#CD0000';
                                            break;
                                        case 'Finalizado':
                                            $cor = '#256';
                                            break;
                                        case 'Faturado':
                                            $cor = '#B266FF';
                                            break;
                                        case 'Aguardando Peças':
                                            $cor = '#FF7F00';
                                            break;
                                        case 'Aprovado':
                                            $cor = '#808080';
                                            break;
                                        default:
                                            $cor = '#E0E4CC';
                                            break;
                                    }
                            ?>
                            <tr>
                                <td>
                                    <?= $o->idOs ?>
                                </td>

                                <td class="cli1">
                                    <?= $o->nomeCliente ?>
                                </td>

                                <td><?php if ($o->dataFinal != null) {
                                    echo date('d/m/Y', strtotime($o->dataFinal));
                                } else {
                                    echo "";
                                } ?></td>
                                
                                <td>
                                    <span class="badge" style="background-color: <?= $cor ?>; border-color: <?= $cor ?>;"><?= $o->status ?></span>
                                </td>

                                <td>
                                    <?php if ($this->permission->checkPermission($this->session->userdata('permissao'), 'vOs')) : ?>
                                        <a href="<?= base_url() ?>index.php/os/visualizar/<?= $o->idOs ?>" class="btn-nwe tip-top" title="Visualizar OS" style="margin-right:3px;">
                                            <i class="bx bx-show"></i>
                                        </a>

                                    <?php endif ?>
                                </td>
                            </tr>
                        <?php endforeach ?>
                    <?php else : ?>
                        <tr>
                            <td colspan="5">Nenhuma OS em aberto.</td>
                        </tr>
                    <?php endif ?>
                </tbody>
            </table>
        </div>
    </div>


    <div class="widget-box0 widbox-blak">
        <div>
            <h5 class="cardHeader">Ordens de Serviços Aprovadas</h5>
        </div>
        <div class="widget-content">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>N°</th>
                        <th>Cliente</th>
                        <th>Data Final</th>
                        <th>Status</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if ($ordens_aprovadas != null) : ?>
                        <?php foreach ($ordens_aprovadas as $o) : ?>
                            <?php
                                    switch ($o->status) {
                                        case 'Aberto':
                                            $cor = '#00cd00';
                                            break;
                                        case 'Em Andamento':
                                            $cor = '#436eee';
                                            break;
                                        case 'Orçamento':
                                            $cor = '#CDB380';
                                            break;
                                        case 'Negociação':
                                            $cor = '#AEB404';
                                            break;
                                        case 'Cancelado':
                                            $cor = '#CD0000';
                                            break;
                                        case 'Finalizado':
                                            $cor = '#256';
                                            break;
                                        case 'Faturado':
                                            $cor = '#B266FF';
                                            break;
                                        case 'Aguardando Peças':
                                            $cor = '#FF7F00';
                                            break;
                                        case 'Aprovado':
                                            $cor = '#808080';
                                            break;
                                        default:
                                            $cor = '#E0E4CC';
                                            break;
                                    }
                            ?>
                            <tr>
                                <td>
                                    <?= $o->idOs ?>
                                </td>

                                <td class="cli1">
                                    <?= $o->nomeCliente ?>
                                </td>

                                <td><?php if ($o->dataFinal != null) {
                                    echo date('d/m/Y', strtotime($o->dataFinal));
                                } else {
                                    echo "";
                                } ?></td>
                                
                                <td>
                                    <span class="badge" style="background-color: <?= $cor ?>; border-color: <?= $cor ?>;"><?= $o->status ?></span>
                                </td>

                                <td>
                                    <?php if ($this->permission->checkPermission($this->session->userdata('permissao'), 'vOs')) : ?>
                                        <a href="<?= base_url() ?>index.php/os/visualizar/<?= $o->idOs ?>" class="btn-nwe tip-top" title="Visualizar OS" style="margin-right:3px;">
                                            <i class="bx bx-show"></i>
                                        </a>

                                    <?php endif ?>
                                </td>
                            </tr>
                        <?php endforeach ?>
                    <?php else : ?>
                        <tr>
                            <td colspan="5">Nenhuma OS Aprovada.</td>
                        </tr>
                    <?php endif ?>
                </tbody>
            </table>
        </div>
    </div>

    <div class="widget-box0 widbox-blak">
        <div>
            <h5 class="cardHeader">Ordens de Serviços Finalizadas</h5>
        </div>
        <div class="widget-content">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>N°</th>
                        <th>Cliente</th>
                        <th>Data Final</th>
                        <th>Status</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if ($ordens_finalizadas != null) : ?>
                        <?php foreach ($ordens_finalizadas as $o) : ?>
                            <?php
                                    switch ($o->status) {
                                        case 'Aberto':
                                            $cor = '#00cd00';
                                            break;
                                        case 'Em Andamento':
                                            $cor = '#436eee';
                                            break;
                                        case 'Orçamento':
                                            $cor = '#CDB380';
                                            break;
                                        case 'Negociação':
                                            $cor = '#AEB404';
                                            break;
                                        case 'Cancelado':
                                            $cor = '#CD0000';
                                            break;
                                        case 'Finalizado':
                                            $cor = '#256';
                                            break;
                                        case 'Faturado':
                                            $cor = '#B266FF';
                                            break;
                                        case 'Aguardando Peças':
                                            $cor = '#FF7F00';
                                            break;
                                        case 'Aprovado':
                                            $cor = '#808080';
                                            break;
                                        default:
                                            $cor = '#E0E4CC';
                                            break;
                                    }
                            ?>
                            <tr>
                                <td>
                                    <?= $o->idOs ?>
                                </td>

                                <td class="cli1">
                                    <?= $o->nomeCliente ?>
                                </td>

                                <td><?php if ($o->dataFinal != null) {
                                    echo date('d/m/Y', strtotime($o->dataFinal));
                                } else {
                                    echo "";
                                } ?></td>
                                
                                <td>
                                    <span class="badge" style="background-color: <?= $cor ?>; border-color: <?= $cor ?>;"><?= $o->status ?></span>
                                </td>

                                <td>
                                    <?php if ($this->permission->checkPermission($this->session->userdata('permissao'), 'vOs')) : ?>
                                        <a href="<?= base_url() ?>index.php/os/visualizar/<?= $o->idOs ?>" class="btn-nwe tip-top" title="Visualizar OS" style="margin-right:3px;">
                                            <i class="bx bx-show"></i>
                                        </a>

                                    <?php endif ?>
                                </td>
                            </tr>
                        <?php endforeach ?>
                    <?php else : ?>
                        <tr>
                            <td colspan="5">Nenhuma OS Finalizada.</td>
                        </tr>
                    <?php endif ?>
                </tbody>
            </table>
        </div>
    </div>

    <div class="widget-box0 widbox-blak">
        <div>
            <h5 class="cardHeader">Ordens de Serviços Em Andamento e Aguardando Peças</h5>
        </div>
        <div class="widget-content">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>N°</th>
                        <th>Cliente</th>
                        <th>Data Final</th>
                        <th>Status</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if ($ordens_status != null) : ?>
                        <?php foreach ($ordens_status as $o) : ?>
                                <?php
                                    switch ($o->status) {
                                        case 'Aberto':
                                            $cor = '#00cd00';
                                            break;
                                        case 'Em Andamento':
                                            $cor = '#436eee';
                                            break;
                                        case 'Orçamento':
                                            $cor = '#CDB380';
                                            break;
                                        case 'Negociação':
                                            $cor = '#AEB404';
                                            break;
                                        case 'Cancelado':
                                            $cor = '#CD0000';
                                            break;
                                        case 'Finalizado':
                                            $cor = '#256';
                                            break;
                                        case 'Faturado':
                                            $cor = '#B266FF';
                                            break;
                                        case 'Aguardando Peças':
                                            $cor = '#FF7F00';
                                            break;
                                        case 'Aprovado':
                                            $cor = '#808080';
                                            break;
                                        default:
                                            $cor = '#E0E4CC';
                                            break;
                                    }
                            ?>
                            <tr>
                                <td>
                                    <?= $o->idOs ?>
                                </td>
                                <td class="cli1">
                                    <?= $o->nomeCliente ?>
                                </td>

                                <td><?php if ($o->dataFinal != null) {
                                    echo date('d/m/Y', strtotime($o->dataFinal));
                                } else {
                                    echo "";
                                } ?></td>

                                    <td>
                                        <span class="badge" style="background-color: <?= $cor ?>; border-color: <?= $cor ?>;"><?= $o->status ?></span>
                                    </td>
                                <td>
                                    <?php if ($this->permission->checkPermission($this->session->userdata('permissao'), 'vOs')) : ?>
                                        <a href="<?= base_url() ?>index.php/os/visualizar/<?= $o->idOs ?>" class="btn-nwe tip-top" title="Visualizar OS" style="margin-right:3px;">
                                            <i class="bx bx-show"></i>
                                        </a>

                                    <?php endif ?>
                                </td>
                            </tr>
                        <?php endforeach ?>
                    <?php else : ?>
                        <tr>
                            <td colspan="5">Nenhuma OS em Orçamento.</td>
                        </tr>
                    <?php endif ?>
                </tbody>
            </table>
        </div>
    </div>

    <div class="widget-box0 widbox-blak">
        <div>
            <h5 class="cardHeader">Status de Vendas</h5>
        </div>
        <div class="widget-content">
            <table class="table table-bordered lanc-table">
                <thead>
                    <tr>
                        <th class="numero-col">N°</th>
                        <th class="cliente-col">Cliente</th>
                        <th class="data-final-col">Data da Venda</th>
                        <th class="status-col">Status</th>
                        <th class="acoes-col">Ações</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if ($vendasstatus != null) : ?>
                        <?php foreach ($vendasstatus as $v) : ?>
                            <?php
                                    switch ($v->status) {
                                        case 'Aberto':
                                            $cor = '#00cd00';
                                            break;
                                        case 'Em Andamento':
                                            $cor = '#436eee';
                                            break;
                                        case 'Orçamento':
                                            $cor = '#CDB380';
                                            break;
                                        case 'Negociação':
                                            $cor = '#AEB404';
                                            break;
                                        case 'Cancelado':
                                            $cor = '#CD0000';
                                            break;
                                        case 'Finalizado':
                                            $cor = '#256';
                                            break;
                                        case 'Faturado':
                                            $cor = '#B266FF';
                                            break;
                                        case 'Aguardando Peças':
                                            $cor = '#FF7F00';
                                            break;
                                        case 'Aprovado':
                                            $cor = '#808080';
                                            break;
                                        default:
                                            $cor = '#E0E4CC';
                                            break;
                                    }
                            ?>
                            <tr>
                                <td>
                                    <?= $v->idVendas ?>
                                </td>

                                <td class="cli1">
                                    <?= $v->nomeCliente ?>
                                </td>
                                <td>
                                    <?= date('d/m/Y', strtotime($v->dataVenda)) ?>
                                </td>
                                
                                    <td>
                                        <span class="badge" style="background-color: <?= $cor ?>; border-color: <?= $cor ?>;"><?= $v->status ?></span>
                                    </td>
                                <td>
                                    <?php if ($this->permission->checkPermission($this->session->userdata('permissao'), 'vVenda')) : ?>
                                        <a href="<?= base_url() ?>index.php/vendas/visualizar/<?= $v->idVendas ?>" class="btn-nwe tip-top" title="Visualizar Venda" style="margin-right:3px;">
                                            <i class="bx bx-show"></i>
                                        </a>
                                        <a href="<?= base_url() ?>index.php/vendas/imprimirPromissoria/<?= $v->idVendas ?>" target="_blank" class="btn-nwe tip-top" title="Imprimir Promissória" style="background:#1e3a5f;border-color:#2563eb;">
                                            <i class="bx bx-file-blank"></i>
                                        </a>
                                    <?php endif ?>
                                </td>
                            </tr>
                        <?php endforeach ?>
                    <?php else : ?>
                        <tr>
                            <td colspan="5">Nenhuma Venda.</td>
                        </tr>
                    <?php endif ?>
                </tbody>
            </table>
        </div>
    </div>

    <div class="widget-box0 widbox-blak">
        <div>
            <h5 class="cardHeader">Últimos Lançamentos Pendentes</h5>
        </div>
        <div class="widget-content">
            <table class="table table-bordered lanc-table">
                <thead>
                    <tr>
                        <th class="tipo-col">Tipo</th>
                        <th class="cliente-col">Cliente/Fornecedor</th>
                        <th class="descricao-col">Descrição</th>
                        <th class="vencimento-col">Vencimento</th>
                        <th class="valor-col">V.T. Faturado</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($lancamentos)): ?>
                        <?php foreach ($lancamentos as $lancamento): ?>
                            <tr>
                                <td>
                                    <?php if ($lancamento->tipo == 'receita'): ?>
                                        <span class="label label-success"><b><?php echo ucfirst($lancamento->tipo); ?></b></span>
                                    <?php elseif ($lancamento->tipo == 'despesa'): ?>
                                        <span class="label label-important"><b><?php echo ucfirst($lancamento->tipo); ?></b></span>
                                    <?php else: ?>
                                        <?php echo ucfirst($lancamento->tipo); ?>
                                    <?php endif; ?>
                                </td>
                                <td class="text-truncate"><?php echo $lancamento->cliente_fornecedor; ?></td>
                                <td class="text-truncate"><?php echo $lancamento->descricao; ?></td>
                                <td><?php echo date_format(date_create($lancamento->data_vencimento), 'd/m/Y'); ?></td>
                                <td>R$ <?php echo number_format($lancamento->valor_desconto, 2, ',', '.'); ?></td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="5">Nenhum lançamento encontrado.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>

    <div class="AAA">
        <div class="widget-box0 widbox-blak">
            <div>
                <h5 class="cardHeader">Produtos Com Estoque Mínimo</h5>
            </div>
            <div class="widget-content">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Cod.</th>
                            <th>Produto</th>
                            <th>Preço de Venda</th>
                            <th>Estoque</th>
                            <th class="ph3">Estoque Mínimo</th>
                            <th>Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if ($produtos != null) : ?>
                            <?php foreach ($produtos as $p) : ?>
                                <tr>
                                    <td>
                                        <?= $p->idProdutos ?>
                                    </td>
                                    <td class="cli1">
                                        <?= $p->descricao ?>
                                    </td>
                                    <td>R$
                                        <?= $p->precoVenda ?>
                                    </td>
                                    <td>
                                        <?= $p->estoque ?>
                                    </td>
                                    <td class="ph3">
                                        <?= $p->estoqueMinimo ?>
                                    </td>
                                    <td>
                                        <?php if ($this->permission->checkPermission($this->session->userdata('permissao'), 'eProduto')) : ?>
                                            <a href="<?= base_url() ?>index.php/produtos/editar/<?= $p->idProdutos ?>" class="btn-nwe3 tip-top" title="Editar">
                                                <i class="bx bx-edit"></i>
                                            </a>
                                            <a href="#atualizar-estoque" role="button" data-toggle="modal" produto="<?= $p->idProdutos ?>" estoque="<?= $p->estoque ?>" class="btn-nwe5 tip-top" title="Atualizar Estoque">
                                                <i class="bx bx-plus-circle"></i></a>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                            <?php endforeach ?>
                        <?php else : ?>
                            <tr>
                                <td colspan="6">Nenhum produto com estoque baixo.</td>
                            </tr>
                        <?php endif ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
                        
</div>
<!-- Relatório por Técnico -->
<div class="span12A" style="margin-left:0">
    <div class="widget-box0 widbox-blak">
        <div><h5 class="cardHeader">OS por Técnico — Últimos 30 dias</h5></div>
        <div class="widget-content">
            <table class="table table-bordered">
                <thead>
                    <tr><th>Técnico</th><th>Total OS</th><th>Finalizadas</th><th>Tempo Médio (dias)</th><th>Taxa de Conclusão</th></tr>
                </thead>
                <tbody>
                    <?php if (!empty($os_por_tecnico)): ?>
                        <?php foreach ($os_por_tecnico as $t): ?>
                        <tr>
                            <td><strong><?= htmlspecialchars($t->tecnico ?? 'Não atribuído') ?></strong></td>
                            <td><?= $t->total ?></td>
                            <td><?= $t->finalizadas ?></td>
                            <td><?= $t->media_dias ? number_format($t->media_dias, 1) . ' dias' : '—' ?></td>
                            <td>
                                <?php $taxa = $t->total > 0 ? round(($t->finalizadas / $t->total) * 100) : 0; ?>
                                <div style="display:flex;align-items:center;gap:8px;">
                                    <div style="flex:1;background:rgba(255,255,255,0.07);border-radius:4px;height:6px;">
                                        <div style="width:<?= $taxa ?>%;background:<?= $taxa >= 70 ? '#22c55e' : ($taxa >= 40 ? '#f59e0b' : '#ef4444') ?>;height:6px;border-radius:4px;"></div>
                                    </div>
                                    <span style="font-size:12px;font-weight:700;color:<?= $taxa >= 70 ? '#22c55e' : ($taxa >= 40 ? '#f59e0b' : '#ef4444') ?>;"><?= $taxa ?>%</span>
                                </div>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr><td colspan="5" style="text-align:center;color:#6b7280;">Nenhum dado disponível.</td></tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Fim Staus OS -->

<!-- ════ Agenda: Modal Moderno ════ -->
<div id="sisosCalModal" class="sisos-modal-overlay" style="display:none;" onclick="if(event.target===this)sisosCloseModal()">
    <div class="sisos-modal-box">
        <div class="sisos-modal-head">
            <div style="display:flex;align-items:center;gap:8px;">
                <span class="sisos-modal-badge-id">OS #<span id="modalId"></span></span>
                <span id="modalStatusBadge" class="sisos-modal-status-badge"></span>
            </div>
            <button onclick="sisosCloseModal()" class="sisos-modal-close" title="Fechar"><i class='bx bx-x'></i></button>
        </div>
        <div class="sisos-modal-body">
            <div class="sisos-modal-row"><i class='bx bxs-user-circle'></i><span id="modalCliente"></span></div>
            <div class="sisos-modal-divider"></div>
            <div class="sisos-modal-grid2">
                <div class="sisos-modal-info"><label>Data Inicial</label><span id="modalDataInicial"></span></div>
                <div class="sisos-modal-info"><label>Prev. Entrega</label><span id="modalDataFinal"></span></div>
                <div class="sisos-modal-info"><label>Garantia</label><span id="modalGarantia"></span></div>
                <div class="sisos-modal-info"><label>Faturado</label><span id="modalFaturado"></span></div>
            </div>
            <div class="sisos-modal-divider"></div>
            <div class="sisos-modal-info-full"><label>Descrição</label><p id="modalDescription"></p></div>
            <div class="sisos-modal-info-full"><label>Defeito</label><p id="modalDefeito"></p></div>
            <div class="sisos-modal-info-full" id="wrapObs" style="display:none"><label>Observações</label><p id="modalObservacoes"></p></div>
            <div class="sisos-modal-divider"></div>
            <div class="sisos-modal-grid2">
                <div class="sisos-modal-info"><label>Subtotal</label><span id="modalSubtotal" style="color:#9ca3af;"></span></div>
                <div class="sisos-modal-info"><label>Desconto</label><span id="modalDesconto" style="color:#f87171;"></span></div>
            </div>
            <div class="sisos-modal-total"><i class='bx bx-money'></i><span id="modalTotal"></span></div>
        </div>
        <div class="sisos-modal-foot">
            <?php if ($this->permission->checkPermission($this->session->userdata('permissao'), 'vOs')): ?>
            <a id="modalIdVisualizar" href="" class="vos-btn" style="background:#252a3a;color:#e8eaf0;">
                <i class='bx bx-show'></i> Ver OS
            </a>
            <?php endif; ?>
            <?php if ($this->permission->checkPermission($this->session->userdata('permissao'), 'eOs')): ?>
            <a id="modalIdEditar" href="" class="vos-btn" style="display:none;background:rgba(251,191,36,0.15);color:#fbbf24;">
                <i class='bx bx-edit'></i> Editar
            </a>
            <?php endif; ?>
            <?php if ($this->permission->checkPermission($this->session->userdata('permissao'), 'dOs')): ?>
            <form id="formExcluirCal" method="post" action="<?= base_url() ?>index.php/os/excluir" style="display:none;">
                <input type="hidden" name="id" id="modalIdExcluir">
                <button type="submit" class="vos-btn" style="background:rgba(248,113,113,0.12);color:#f87171;"
                    onclick="return confirm('Excluir esta OS?')">
                    <i class='bx bx-trash'></i> Excluir
                </button>
            </form>
            <?php endif; ?>
        </div>
    </div>
</div></div>

<!-- Modal Excluir Os -->
<div id="modal-excluir-os" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <form action="<?php echo base_url() ?>index.php/os/excluir" method="post">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            <h5 id="myModalLabel">Excluir OS</h5>
        </div>
        <div class="modal-body">
            <input type="hidden" id="modalIdExcluir" name="id" value="" />
            <h5 style="text-align: center">Deseja realmente excluir esta OS?</h5>
        </div>
        <div class="modal-footer" style="display:flex;justify-content: center">
            <button class="button btn btn-warning" data-dismiss="modal" aria-hidden="true"><span class="button__icon"><i class="bx bx-x"></i></span><span class="button__text2">Cancelar</span></button>
            <button class="button btn btn-danger"><span class="button__icon"><i class='bx bx-trash'></i></span> <span class="button__text2">Excluir</span></button>
        </div>
    </form>
</div>

<!-- Modal Estoque -->
<div id="atualizar-estoque" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <form action="<?php echo base_url() ?>index.php/produtos/atualizar_estoque" method="post" id="formEstoque">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            <h5 id="myModalLabel"><i class="fas fa-plus-square"></i> Atualizar Estoque</h5>
        </div>
        <div class="modal-body">
            <div class="control-group">
                <label for="estoqueAtual" class="control-label">Estoque Atual</label>
                <div class="controls">
                    <input id="estoqueAtual" type="text" name="estoqueAtual" value="" readonly />
                </div>
            </div>

            <div class="control-group">
                <label for="estoque" class="control-label">Adicionar Produtos<span class="required">*</span></label>
                <div class="controls">
                    <input type="hidden" id="idProduto" class="idProduto" name="id" value="" />
                    <input id="estoque" type="text" name="estoque" value="" />
                </div>
            </div>
        </div>
        <div class="modal-footer" style="display:flex;justify-content: center">
            <button class="button btn btn-warning" data-dismiss="modal" aria-hidden="true"><span class="button__icon"><i class="bx bx-x"></i></span><span class="button__text2">Cancelar</span></button>
            <button class="button btn btn-primary"><span class="button__icon"><i class="bx bx-sync"></i></span><span class="button__text2">Atualizar</span></button>
        </div>
    </form>
</div>

<script src="<?php echo base_url() ?>assets/js/jquery.validate.js"></script>
<!-- Modal Estoque-->
<script type="text/javascript">
    $(document).ready(function() {
        $(document).on('click', 'a', function(event) {
            var produto = $(this).attr('produto');
            var estoque = $(this).attr('estoque');
            $('.idProduto').val(produto);
            $('#estoqueAtual').val(estoque);
        });

        $('#formEstoque').validate({
            rules: {
                estoque: {
                    required: true,
                    number: true
                }
            },
            messages: {
                estoque: {
                    required: 'Campo Requerido.',
                    number: 'Informe um número válido.'
                }
            },
            errorClass: "help-inline",
            errorElement: "span",
            highlight: function(element, errorClass, validClass) {
                $(element).parents('.control-group').addClass('error');
            },
            unhighlight: function(element, errorClass, validClass) {
                $(element).parents('.control-group').removeClass('error');
                $(element).parents('.control-group').addClass('success');
            }
        });

        // ── Agenda Moderna ──────────────────────────────────────
        var STATUS_COLORS = {
            'Aberto':'#22c55e','Negociação':'#AEB404','Em Andamento':'#436eee',
            'Orçamento':'#CDB380','Cancelado':'#f87171','Finalizado':'#4ade80',
            'Faturado':'#a78bfa','Aguardando Peças':'#f97316','Aprovado':'#22d3ee'
        };
        function getStatusColor(s){ return STATUS_COLORS[s]||'#9ca3af'; }

        var srcCalendarEl = document.getElementById('source-calendar');
        var srcCalendar = new FullCalendar.Calendar(srcCalendarEl, {
            locale: 'pt-br',
            height: 420,
            editable: false,
            selectable: false,
            businessHours: true,
            dayMaxEvents: true,
            displayEventTime: false,
            headerToolbar: { left:'prev,next today', center:'title', right:'dayGridMonth,dayGridWeek' },
            buttonText: { today:'Hoje', month:'Mês', week:'Semana' },
            events: {
                url: "<?= base_url() . 'index.php/sisos/calendario'; ?>",
                method: 'GET',
                extraParams: function() { return { status: document.getElementById('statusOsGet').value }; },
                failure: function() { console.warn('Falha ao buscar eventos do calendário.'); },
            },
            eventDidMount: function(info) {
                var status = (info.event.extendedProps.status||'').replace('<b>Status da OS:</b> ','').trim();
                var cor = getStatusColor(status) || info.event.backgroundColor;
                info.el.style.backgroundColor = cor+'22';
                info.el.style.borderLeft = '3px solid '+cor;
                info.el.style.color = cor;
                info.el.style.borderRadius = '6px';
            },
            eventClick: function(info) {
                var ep = info.event.extendedProps;
                document.getElementById('modalId').textContent = ep.id;
                document.getElementById('modalIdVisualizar').href = "<?= base_url(); ?>index.php/os/visualizar/" + ep.id;
                var rawStatus = (ep.status||'').replace('<b>Status da OS:</b> ','').trim();
                var badge = document.getElementById('modalStatusBadge');
                badge.textContent = rawStatus;
                var cor = getStatusColor(rawStatus);
                badge.style.background = cor+'22'; badge.style.color = cor; badge.style.border = '1px solid '+cor+'55';
                document.getElementById('modalCliente').innerHTML = ep.cliente||'—';
                document.getElementById('modalDataInicial').innerHTML = ep.dataInicial||'—';
                document.getElementById('modalDataFinal').innerHTML   = ep.dataFinal||'—';
                document.getElementById('modalGarantia').innerHTML    = ep.garantia||'—';
                document.getElementById('modalFaturado').innerHTML    = ep.faturado||'—';
                document.getElementById('modalDescription').innerHTML = ep.description||'—';
                document.getElementById('modalDefeito').innerHTML     = ep.defeito||'—';
                var obsText = (ep.observacoes||'').replace('<b>Observações:</b> ','').trim();
                var obsWrap = document.getElementById('wrapObs');
                if(obsText&&obsText!=='null'){ document.getElementById('modalObservacoes').innerHTML=ep.observacoes; obsWrap.style.display=''; }
                else{ obsWrap.style.display='none'; }
                document.getElementById('modalSubtotal').innerHTML = ep.subtotal||'R$ 0,00';
                document.getElementById('modalDesconto').innerHTML  = ep.desconto||'R$ 0,00';
                document.getElementById('modalTotal').innerHTML     = ep.total||'R$ 0,00';
                var btnEditar   = document.getElementById('modalIdEditar');
                var formExcluir = document.getElementById('formExcluirCal');
                if(ep.editar){
                    if(btnEditar){ btnEditar.href="<?= base_url(); ?>index.php/os/editar/"+ep.id; btnEditar.style.display=''; }
                    if(formExcluir){ document.getElementById('modalIdExcluir').value=ep.id; formExcluir.style.display=''; }
                }else{
                    if(btnEditar)   btnEditar.style.display='none';
                    if(formExcluir) formExcluir.style.display='none';
                }
                document.getElementById('sisosCalModal').style.display='flex';
                document.body.style.overflow='hidden';
            },
        });
        srcCalendar.render();

        document.getElementById('btn-calendar').addEventListener('click', function(){ srcCalendar.refetchEvents(); });

        window.sisosCloseModal = function(){
            document.getElementById('sisosCalModal').style.display='none';
            document.body.style.overflow='';
        };
        document.addEventListener('keydown', function(e){ if(e.key==='Escape') window.sisosCloseModal(); });
    });
</script>
