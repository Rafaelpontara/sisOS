<?php $temaClaroRodape = in_array($configuration['app_theme'] ?? '', ['white','whitegreen','whiteblack']); ?>
<?php if ($temaClaroRodape): ?>
<style>
/* ══════════════════════════════════════════════════════════════════
   TEMA CLARO — bloco final. rodape.php é sempre o último arquivo
   carregado em toda página do sistema, então este bloco vence
   qualquer CSS carregado antes — inclusive assets/css/custom.css,
   que é carregado no meio da página do Dashboard e reafirmava cores
   escuras por cima dos ajustes já feitos em topo.php/menu.php/
   sisos/painel.php. Não altera nada do tema escuro.
   ══════════════════════════════════════════════════════════════════ */

/* Rodapé */
#footer{ background:#ffffff !important; border-top-color:rgba(0,0,0,0.08) !important; }
#footer, #footer .pecolor{ color:#6b7280 !important; }

/* Menu lateral */
#sidebar{ background:#ffffff !important; border-right:1px solid rgba(0,0,0,0.08) !important; }
#sidebar li a{ color:#374151 !important; }
#sidebar li .iconX,
#sidebar li .title{ color:#374151 !important; }
#sidebar li .title-tooltip{ color:#374151 !important; background:#ffffff !important; border:1px solid rgba(0,0,0,0.08) !important; }
#sidebar li a:hover{ background:#f3f4f6 !important; }
#sidebar li a:hover .iconX,
#sidebar li a:hover .title{ color:#111827 !important; }
.botton-content li a{ color:#374151 !important; }
.botton-content li a i{ color:#6b7280 !important; }
.search-box{ background:#f9fafb !important; border:1px solid rgba(0,0,0,0.08) !important; }
.search-box input{ color:#1f2937 !important; }

/* Cabeçalho / topo */
#user-nav.navbar.navbar-inverse{ background:#ffffff !important; border-color:rgba(0,0,0,0.08) !important; box-shadow:0 1px 3px rgba(0,0,0,0.06) !important; }
#user-nav .iconN{ color:#4b5563 !important; }
#user-nav .dropdown-toggle:hover .iconN{ color:#1f2937 !important; }
.dropdown-menu{ background:#ffffff !important; border-color:rgba(0,0,0,0.08) !important; box-shadow:0 12px 28px rgba(0,0,0,0.12) !important; }
.dropdown-menu li > a{ color:#374151 !important; }
.dropdown-menu li > a:hover{ background:rgba(0,0,0,0.04) !important; color:#1f2937 !important; }
.dropdown-menu .divider{ background:rgba(0,0,0,0.08) !important; }
.userT{ color:#1f2937 !important; }
.userT0{ color:#6b7280 !important; }
#mob-toggle{ background:#ffffff !important; color:#1f2937 !important; border-color:rgba(0,0,0,0.08) !important; }

/* Dashboard — atalhos, agenda, estatísticas e tabelas */
.sisos-kpi-card{ background:#ffffff !important; border-color:rgba(0,0,0,0.08) !important; }
.sisos-kpi-value{ color:#1f2937 !important; }
.cardBox .card{ background:#ffffff !important; border-color:rgba(0,0,0,0.08) !important; }
.cardBox .card .numbers{ color:#1f2937 !important; }
.cardBox .card .cardName{ color:#6b7280 !important; opacity:1 !important; }
.sisos-agenda-card{ background:#ffffff !important; border-color:rgba(0,0,0,0.08) !important; }
.widget-box-new,
.widget-box-new.widbox-blak{ background:#ffffff !important; border-color:rgba(0,0,0,0.08) !important; }
.cardHeader{ color:#1f2937 !important; }
.new-bottons .card{ background:#f9fafb !important; border-color:rgba(0,0,0,0.06) !important; }
.new-bottons .card .cardName2,
.new-bottons .card .cardName1{ color:#1f2937 !important; }
.new-bottons .card .cardName{ color:#6b7280 !important; }
.widget-box0,
.widget-box0.widbox-blak,
.widget-box2,
.widget-box-statist{ background:#ffffff !important; border-color:rgba(0,0,0,0.08) !important; }
.widget-box0 table thead th,
.widbox-blak .table thead th,
.widget-box0 .table thead th{ background:#f3f4f6 !important; color:#6b7280 !important; border-color:rgba(0,0,0,0.08) !important; }
.widget-box0 table tbody td,
.widbox-blak .table tbody td,
.widget-box0 .table tbody td{ color:#374151 !important; border-color:rgba(0,0,0,0.05) !important; }
.widget-box0 table tbody tr:hover td,
.widbox-blak .table tbody tr:hover td,
.widget-box0 .table tbody tr:hover td{ background:rgba(0,0,0,0.03) !important; }
.widget-box0 .cli1{ color:#1f2937 !important; }
</style>
<?php endif; ?>
<div class="row-fluid">
    <div id="footer" class="span12">
        <a class="pecolor" href="https://github.com/Rafaelpontara/sisos" target="_blank">
            <?= date('Y') ?> &copy; Rafael - SISOS - Versão: <?= $this->config->item('app_version') ?>
        </a>
    </div>
</div>
<!--end-Footer-part-->
<script src="<?= base_url() ?>assets/js/bootstrap.min.js"></script>
<script src="<?= base_url() ?>assets/js/matrix.js"></script>
</body>
<script type="text/javascript">
    $(document).ready(function() {
        var dataTableEnabled = '<?= $configuration['control_datatable'] ?>';
        if(dataTableEnabled == '1') {
            $('#tabela').dataTable( {
                "ordering": false,
                "info": false,
                "language": {
                    "url": "<?= base_url() ?>assets/js/dataTable_pt-br.json",
                },
                "oLanguage": {
                    "sSearch": "Pesquisa rápida na tabela abaixo:"
                }
            } );
        }
    } );
</script>

<script>
function mobToggle() {
    var sidebar = document.getElementById('sidebar');
    var overlay = document.getElementById('mob-overlay');
    var icon    = document.querySelector('#mob-toggle i');
    if (!sidebar) return;
    var isOpen = sidebar.classList.toggle('mob-open');
    if (overlay) overlay.classList.toggle('mob-open', isOpen);
    if (icon) icon.className = isOpen ? 'bx bx-x' : 'bx bx-menu';
}
function mobClose() {
    var sidebar = document.getElementById('sidebar');
    var overlay = document.getElementById('mob-overlay');
    var icon    = document.querySelector('#mob-toggle i');
    if (sidebar) sidebar.classList.remove('mob-open');
    if (overlay) overlay.classList.remove('mob-open');
    if (icon) icon.className = 'bx bx-menu';
}
document.addEventListener('DOMContentLoaded', function() {
    // Fechar menu ao navegar
    document.querySelectorAll('#sidebar a').forEach(function(a) {
        a.addEventListener('click', function() {
            if (window.innerWidth <= 992) mobClose();
        });
    });
});
</script>
</html>