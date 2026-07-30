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