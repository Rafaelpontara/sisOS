<style>
.pg-header{display:flex;justify-content:space-between;align-items:center;margin-bottom:20px;}
.pg-title{font-size:22px;font-weight:800;color:#e8eaf0;display:flex;align-items:center;gap:10px;}
.pg-title i{font-size:24px;color:#34d399;}
.pg-actions{display:flex;gap:10px;align-items:center;}
.search-bar{display:flex;gap:0;}
.search-bar input{padding:9px 14px;border-radius:8px 0 0 8px;border:1px solid #444860;border-right:none;background:#1e2133;color:#e8eaf0;font-size:13px;width:260px;}
.search-bar input:focus{outline:none;border-color:#34d399;}
.search-bar button{padding:9px 14px;border-radius:0 8px 8px 0;background:#34d399;border:none;color:#111;cursor:pointer;font-size:15px;transition:background .15s;}
.search-bar button:hover{background:#10b981;}
.btn-add{display:flex;align-items:center;gap:7px;padding:9px 16px;border-radius:8px;background:linear-gradient(135deg,#22c55e,#16a34a);color:#fff;font-size:13px;font-weight:700;text-decoration:none;border:none;cursor:pointer;box-shadow:0 4px 14px rgba(34,197,94,0.3);transition:transform .15s,box-shadow .15s;}
.btn-add:hover{transform:translateY(-2px);box-shadow:0 6px 20px rgba(34,197,94,0.4);color:#fff;}
.btn-add i{font-size:18px;}
.tbl-wrap{background:#1a1d2e;border:1px solid rgba(255,255,255,0.07);border-radius:14px;overflow:hidden;}
.tbl-toolbar{display:flex;align-items:center;justify-content:space-between;padding:12px 16px;border-bottom:1px solid rgba(255,255,255,0.06);}
.tbl-toolbar-left{font-size:12px;color:#6b7280;display:flex;align-items:center;gap:8px;}
.tbl-toolbar-left select{background:#252a3a;border:1px solid #444860;color:#e8eaf0;padding:4px 8px;border-radius:6px;font-size:12px;}
.tbl-search input{background:#252a3a;border:1px solid #444860;color:#e8eaf0;padding:6px 10px;border-radius:6px;font-size:12px;width:180px;}
.tbl-search input:focus{outline:none;border-color:#34d399;}
.tbl-wrap table{width:100%;border-collapse:collapse;}
.tbl-wrap thead th{background:#252a3a;color:#9ca3af;font-size:11px;font-weight:700;text-transform:uppercase;letter-spacing:.6px;padding:11px 14px;border-bottom:1px solid rgba(255,255,255,0.07);white-space:nowrap;}
.tbl-wrap tbody tr{border-bottom:1px solid rgba(255,255,255,0.04);transition:background .12s;}
.tbl-wrap tbody tr:last-child{border-bottom:none;}
.tbl-wrap tbody tr:hover{background:rgba(52,211,153,0.05);}
.tbl-wrap tbody td{padding:11px 14px;font-size:13px;color:#c9cad6;vertical-align:middle;}
.td-desc{max-width:300px;overflow:hidden;text-overflow:ellipsis;white-space:nowrap;color:#9ca3af;font-size:12px;}
.act-btns{display:flex;gap:5px;align-items:center;}
.act-btn{width:30px;height:30px;border-radius:7px;display:inline-flex;align-items:center;justify-content:center;font-size:15px;text-decoration:none;transition:background .15s,transform .12s;border:none;cursor:pointer;}
.act-btn:hover{transform:scale(1.1);}
.act-btn-edit{background:rgba(34,197,94,0.15);color:#4ade80;}
.act-btn-edit:hover{background:rgba(34,197,94,0.3);color:#4ade80;}
.act-btn-del{background:rgba(239,68,68,0.15);color:#f87171;}
.act-btn-del:hover{background:rgba(239,68,68,0.3);color:#f87171;}
.tbl-empty{text-align:center;padding:40px;color:#6b7280;}
.tbl-empty i{font-size:40px;display:block;margin-bottom:8px;opacity:.3;}
#tabela_length,.dataTables_length,#tabela_info,.dataTables_info,#tabela_filter,.dataTables_filter,.dataTables_paginate{display:none!important;}
</style>

<div class="new122">
    <div class="pg-header">
        <div class="pg-title"><i class='bx bx-wrench'></i> Serviços</div>
        <div class="pg-actions">
            <?php if ($this->permission->checkPermission($this->session->userdata('permissao'), 'aServico')): ?>
            <a href="<?= base_url() ?>index.php/servicos/adicionar" class="btn-add">
                <i class='bx bx-plus-circle'></i> Novo Serviço
            </a>
            <?php endif; ?>
            <form method="get" action="<?= base_url() ?>index.php/servicos" class="search-bar">
                <input type="text" name="pesquisa" placeholder="Buscar nome ou descrição..." value="<?= $this->input->get('pesquisa') ?>">
                <button type="submit"><i class='bx bx-search'></i></button>
            </form>
        </div>
    </div>

    <div class="tbl-wrap">
        <div class="tbl-toolbar">
            <div class="tbl-toolbar-left">
                <span id="srv-count-label" style="color:#e8eaf0;font-weight:600;"><?= count($results) ?> de <?= (int)($statTotalFiltrado ?? 0) ?> serviços carregados</span>
            </div>
            <div class="tbl-search">
                <input type="text" placeholder="Filtrar o que já carregou..." oninput="filterTable(this.value)">
            </div>
        </div>

        <table id="tabela" class="table">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Nome</th>
                    <th>Preço</th>
                    <th>Descrição</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody id="srv-tbody">
                <?php echo $this->load->view('servicos/_table_rows_partial', ['results' => $results], true); ?>
            </tbody>
        </table>
    </div>
    <div id="srv-sentinel" style="display:flex;justify-content:center;padding:24px 0;">
        <div id="srv-loading" style="display:none;align-items:center;gap:8px;color:#9ca3af;font-size:13px;">
            <i class='bx bx-loader-alt bx-spin'></i> Carregando mais serviços...
        </div>
        <div id="srv-fim" style="display:none;color:#6b7280;font-size:12px;">
            Isso é tudo — não há mais serviços para carregar.
        </div>
    </div>

</div>

<!-- Modal Excluir -->
<div id="modal-excluir" class="modal hide fade" tabindex="-1">
    <form action="<?= base_url() ?>index.php/servicos/excluir" method="post">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h5><i class='bx bx-trash' style="color:#f87171;"></i> Excluir Serviço</h5>
        </div>
        <div class="modal-body" style="text-align:center;padding:20px;">
            <div style="width:60px;height:60px;background:rgba(239,68,68,0.15);border-radius:50%;display:flex;align-items:center;justify-content:center;margin:0 auto 14px;">
                <i class='bx bx-wrench' style="font-size:28px;color:#f87171;"></i>
            </div>
            <p style="color:#e8eaf0;font-weight:600;margin-bottom:6px;">Deseja excluir este serviço?</p>
            <input type="hidden" id="idServico" name="id" value="">
        </div>
        <div class="modal-footer" style="display:flex;justify-content:center;gap:10px;">
            <button type="button" class="button btn btn-warning" data-dismiss="modal"><span class="button__icon"><i class="bx bx-x"></i></span><span class="button__text2">Cancelar</span></button>
            <button type="submit" class="button btn btn-danger"><span class="button__icon"><i class='bx bx-trash'></i></span><span class="button__text2">Excluir</span></button>
        </div>
    </form>
</div>

<script>
$(document).ready(function() {
    $(document).on('click', 'a[servico]', function() {
        $('#idServico').val($(this).attr('servico'));
    });
});
function filterTable(q) {
    q = q.toLowerCase();
    $('#tabela tbody tr').each(function() { $(this).toggle($(this).text().toLowerCase().indexOf(q) > -1); });
}

// ── Rolagem infinita ─────────────────────────────────────────────
(function() {
    var tbody = document.getElementById('srv-tbody');
    var loadingEl = document.getElementById('srv-loading');
    var fimEl = document.getElementById('srv-fim');
    var countLabel = document.getElementById('srv-count-label');
    var perPage = <?= (int)($perPage ?? 24) ?>;
    var pesquisaAtual = <?= json_encode($pesquisa ?? '') ?>;
    var totalGeral = <?= (int)($statTotalFiltrado ?? 0) ?>;
    var qtdCarregada = <?= (int)count($results) ?>;
    var carregando = false;
    var acabou = qtdCarregada >= totalGeral;

    function ultimoIdCarregado() {
        var linhas = tbody.querySelectorAll('tr[data-id]');
        if (!linhas.length) return 0;
        return parseInt(linhas[linhas.length - 1].getAttribute('data-id'), 10) || 0;
    }

    function carregarMais() {
        if (carregando || acabou) return;
        carregando = true;
        loadingEl.style.display = 'flex';

        var url = '<?= site_url("servicos/carregarMais") ?>?antes_de=' + ultimoIdCarregado() + '&pesquisa=' + encodeURIComponent(pesquisaAtual);
        fetch(url)
            .then(function(res) { return res.text(); })
            .then(function(html) {
                if (html.trim() === '') {
                    acabou = true;
                    fimEl.style.display = 'block';
                } else {
                    var temp = document.createElement('tbody');
                    temp.innerHTML = html;
                    var novasLinhas = temp.querySelectorAll('tr');
                    novasLinhas.forEach(function(tr) { tbody.appendChild(tr); });
                    qtdCarregada += novasLinhas.length;
                    if (novasLinhas.length < perPage) {
                        acabou = true;
                        fimEl.style.display = 'block';
                    }
                    if (countLabel) countLabel.textContent = qtdCarregada + ' de ' + totalGeral + ' serviços carregados';
                }
            })
            .catch(function() {})
            .finally(function() {
                carregando = false;
                loadingEl.style.display = 'none';
            });
    }

    if (acabou) fimEl.style.display = 'block';

    var sentinel = document.getElementById('srv-sentinel');
    if (sentinel && 'IntersectionObserver' in window) {
        new IntersectionObserver(function(entries) {
            entries.forEach(function(e) { if (e.isIntersecting) carregarMais(); });
        }, { rootMargin: '200px' }).observe(sentinel);
    }
})();
</script>
