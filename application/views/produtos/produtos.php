<style>
.pg-header{display:flex;justify-content:space-between;align-items:center;margin-bottom:20px;}
.pg-title{font-size:22px;font-weight:800;color:#e8eaf0;display:flex;align-items:center;gap:10px;}
.pg-title i{font-size:24px;color:#a78bfa;}
.pg-actions{display:flex;gap:10px;align-items:center;}
.search-bar{display:flex;gap:0;}
.search-bar input{padding:9px 14px;border-radius:8px 0 0 8px;border:1px solid #444860;border-right:none;background:#1e2133;color:#e8eaf0;font-size:13px;width:260px;}
.search-bar input:focus{outline:none;border-color:#a78bfa;}
.search-bar button{padding:9px 14px;border-radius:0 8px 8px 0;background:#a78bfa;border:none;color:#fff;cursor:pointer;font-size:15px;transition:background .15s;}
.search-bar button:hover{background:#8b5cf6;}
.btn-add{display:flex;align-items:center;gap:7px;padding:9px 16px;border-radius:8px;background:linear-gradient(135deg,#22c55e,#16a34a);color:#fff;font-size:13px;font-weight:700;text-decoration:none;border:none;cursor:pointer;box-shadow:0 4px 14px rgba(34,197,94,0.3);transition:transform .15s,box-shadow .15s;}
.btn-add:hover{transform:translateY(-2px);box-shadow:0 6px 20px rgba(34,197,94,0.4);color:#fff;}
.btn-add i{font-size:18px;}
.btn-etiq{display:flex;align-items:center;gap:7px;padding:9px 16px;border-radius:8px;background:linear-gradient(135deg,#f59e0b,#d97706);color:#fff;font-size:13px;font-weight:700;text-decoration:none;border:none;cursor:pointer;box-shadow:0 4px 14px rgba(245,158,11,0.3);transition:transform .15s;}
.btn-etiq:hover{transform:translateY(-2px);color:#fff;}
.btn-etiq i{font-size:18px;}
.tbl-wrap{background:#1a1d2e;border:1px solid rgba(255,255,255,0.07);border-radius:14px;overflow:hidden;}
.tbl-toolbar{display:flex;align-items:center;justify-content:space-between;padding:12px 16px;border-bottom:1px solid rgba(255,255,255,0.06);}
.tbl-toolbar-left{font-size:12px;color:#6b7280;display:flex;align-items:center;gap:8px;}
.tbl-toolbar-left select{background:#252a3a;border:1px solid #444860;color:#e8eaf0;padding:4px 8px;border-radius:6px;font-size:12px;}
.tbl-search input{background:#252a3a;border:1px solid #444860;color:#e8eaf0;padding:6px 10px;border-radius:6px;font-size:12px;width:180px;}
.tbl-search input:focus{outline:none;border-color:#a78bfa;}
.tbl-wrap table{width:100%;border-collapse:collapse;}
.tbl-wrap thead th{background:#252a3a;color:#9ca3af;font-size:11px;font-weight:700;text-transform:uppercase;letter-spacing:.6px;padding:11px 14px;border-bottom:1px solid rgba(255,255,255,0.07);white-space:nowrap;}
.tbl-wrap tbody tr{border-bottom:1px solid rgba(255,255,255,0.04);transition:background .12s;}
.tbl-wrap tbody tr:last-child{border-bottom:none;}
.tbl-wrap tbody tr:hover{background:rgba(167,139,250,0.05);}
.tbl-wrap tbody td{padding:11px 14px;font-size:13px;color:#c9cad6;vertical-align:middle;}
.td-name{color:#e8eaf0;font-weight:600;}
.stock-ok{color:#4ade80;font-weight:700;}
.stock-low{color:#f87171;font-weight:700;}
.stock-warn{color:#fbbf24;font-weight:700;}
.act-btns{display:flex;gap:5px;align-items:center;}
.act-btn{width:30px;height:30px;border-radius:7px;display:inline-flex;align-items:center;justify-content:center;font-size:15px;text-decoration:none;transition:background .15s,transform .12s;border:none;cursor:pointer;background:transparent;}
.act-btn:hover{transform:scale(1.1);}
.act-btn-view{background:rgba(96,165,250,0.15);color:#60a5fa;}
.act-btn-view:hover{background:rgba(96,165,250,0.3);color:#60a5fa;}
.act-btn-edit{background:rgba(34,197,94,0.15);color:#4ade80;}
.act-btn-edit:hover{background:rgba(34,197,94,0.3);color:#4ade80;}
.act-btn-del{background:rgba(239,68,68,0.15);color:#f87171;}
.act-btn-del:hover{background:rgba(239,68,68,0.3);color:#f87171;}
.act-btn-stock{background:rgba(245,158,11,0.15);color:#fbbf24;}
.act-btn-stock:hover{background:rgba(245,158,11,0.3);color:#fbbf24;}
.tbl-empty{text-align:center;padding:40px;color:#6b7280;}
.tbl-empty i{font-size:40px;display:block;margin-bottom:8px;opacity:.3;}
/* Hide DataTables defaults */
#tabela_length,.dataTables_length,#tabela_info,.dataTables_info,#tabela_filter,.dataTables_filter,.dataTables_paginate{display:none!important;}
</style>

<div class="new122">
    <div class="pg-header">
        <div class="pg-title"><i class='bx bx-basket'></i> Produtos</div>
        <div class="pg-actions">
            <?php if ($this->permission->checkPermission($this->session->userdata('permissao'), 'aProduto')): ?>
            <a href="<?= base_url() ?>index.php/produtos/adicionar" class="btn-add">
                <i class='bx bx-plus-circle'></i> Novo Produto
            </a>
            <a href="#modal-etiquetas" role="button" data-toggle="modal" class="btn-etiq">
                <i class='bx bx-barcode-reader'></i> Etiquetas
            </a>
            <?php endif; ?>
            <form method="get" action="<?= base_url() ?>index.php/produtos" class="search-bar">
                <input type="text" name="pesquisa" placeholder="Buscar nome ou código..." value="<?= $this->input->get('pesquisa') ?>">
                <button type="submit"><i class='bx bx-search'></i></button>
            </form>
        </div>
    </div>

    <div class="tbl-wrap">
        <div class="tbl-toolbar">
            <div class="tbl-toolbar-left">
                <span id="prod-count-label" style="color:#e8eaf0;font-weight:600;"><?= count($results) ?> de <?= (int)($statTotalFiltrado ?? 0) ?> produtos carregados</span>
            </div>
            <div class="tbl-search">
                <input type="text" placeholder="Filtrar o que já carregou..." oninput="filterTable(this.value)">
            </div>
        </div>

        <table id="tabela" class="table">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Cód. Barra</th>
                    <th>Nome</th>
                    <th>Estoque</th>
                    <th>Preço</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody id="prod-tbody">
                <?php echo $this->load->view('produtos/_table_rows_partial', ['results' => $results], true); ?>
            </tbody>
        </table>
    </div>
    <div id="prod-sentinel" style="display:flex;justify-content:center;padding:24px 0;">
        <div id="prod-loading" style="display:none;align-items:center;gap:8px;color:#9ca3af;font-size:13px;">
            <i class='bx bx-loader-alt bx-spin'></i> Carregando mais produtos...
        </div>
        <div id="prod-fim" style="display:none;color:#6b7280;font-size:12px;">
            Isso é tudo — não há mais produtos para carregar.
        </div>
    </div>

</div>

<!-- Modal Excluir -->
<div id="modal-excluir" class="modal hide fade" tabindex="-1">
    <form action="<?= base_url() ?>index.php/produtos/excluir" method="post">
        <div class="oxm-wrap">
            <button type="button" class="oxm-close" data-dismiss="modal" aria-label="Fechar"><i class='bx bx-x'></i></button>

            <div class="oxm-icon-circle">
                <i class='bx bx-package'></i>
            </div>

            <h5 class="oxm-title">Excluir Produto</h5>
            <p class="oxm-question">Tem certeza que deseja excluir este produto?</p>
            <p class="oxm-hint"><i class='bx bx-error-circle'></i> Essa ação não pode ser desfeita.</p>

            <input type="hidden" id="idProduto" class="idProduto" name="id" value="">

            <div class="oxm-actions">
                <button type="button" class="oxm-btn oxm-btn-cancel" data-dismiss="modal">
                    <i class='bx bx-x'></i> Cancelar
                </button>
                <button type="submit" class="oxm-btn oxm-btn-danger">
                    <i class='bx bx-trash'></i> Excluir
                </button>
            </div>
        </div>
    </form>
</div>

<!-- Modal Estoque -->
<div id="atualizar-estoque" class="modal hide fade" tabindex="-1">
    <form action="<?= base_url() ?>index.php/produtos/atualizar_estoque" method="post" id="formEstoque">
        <div class="fm-wrap">
            <button type="button" class="fm-close" data-dismiss="modal" aria-label="Fechar"><i class='bx bx-x'></i></button>

            <div class="fm-header">
                <div class="fm-header-icon fm-header-icon-amber"><i class='bx bx-sync'></i></div>
                <div>
                    <h5 class="fm-title">Atualizar Estoque</h5>
                    <span class="fm-subtitle">Adicione uma quantidade ao estoque atual</span>
                </div>
            </div>

            <div class="fm-field">
                <label class="fm-label">Estoque Atual</label>
                <input id="estoqueAtual" type="text" name="estoqueAtual" value="" readonly class="fm-input">
            </div>
            <div class="fm-field">
                <label class="fm-label">Adicionar Quantidade *</label>
                <input type="hidden" id="idProduto2" class="idProduto" name="id" value="">
                <input id="estoque" type="text" name="estoque" value="" placeholder="Quantidade a adicionar" class="fm-input">
            </div>

            <div class="fm-footer">
                <button type="button" class="fm-btn fm-btn-cancel" data-dismiss="modal">
                    <i class="bx bx-x"></i> Cancelar
                </button>
                <button type="submit" class="fm-btn fm-btn-primary">
                    <i class="bx bx-sync"></i> Atualizar
                </button>
            </div>
        </div>
    </form>
</div>

<style>
/* Modais "Excluir Produto" e "Atualizar Estoque" — redesenhados, cada um
   escopado só ao próprio id, sem tocar em .modal-header/.modal-body/
   .modal-footer/.close/.btn-warning/.btn-danger globais (usados pelo
   modal "Etiquetas" logo abaixo, que continua com o visual padrão). */
#modal-excluir{ background:transparent!important;border:none!important;box-shadow:none!important;padding:0!important; }
#modal-excluir .oxm-wrap{
    max-width:380px; margin:0 auto; position:relative;
    background:linear-gradient(180deg,#22263a 0%,#1a1d2e 100%);
    border:1px solid rgba(255,255,255,0.08); border-radius:18px;
    box-shadow:0 24px 60px rgba(0,0,0,0.55),0 2px 8px rgba(0,0,0,0.3);
    padding:30px 26px 24px; text-align:center;
}
#modal-excluir .oxm-close{
    position:absolute; top:14px; right:14px; width:30px; height:30px; border-radius:8px;
    border:none; background:rgba(255,255,255,0.05); color:#8a90a2; font-size:18px;
    display:flex; align-items:center; justify-content:center; cursor:pointer; transition:all .15s;
}
#modal-excluir .oxm-close:hover{ background:rgba(255,255,255,0.1); color:#e8eaf0; }
#modal-excluir .oxm-icon-circle{
    width:68px; height:68px; margin:0 auto 18px; border-radius:50%;
    background:radial-gradient(circle, rgba(248,113,113,0.18) 0%, rgba(248,113,113,0.06) 100%);
    border:1px solid rgba(248,113,113,0.25); display:flex; align-items:center; justify-content:center;
}
#modal-excluir .oxm-icon-circle i{ font-size:30px; color:#f87171; }
#modal-excluir .oxm-title{ font-size:16.5px; font-weight:800; color:#e8eaf0; margin:0 0 8px; }
#modal-excluir .oxm-question{ font-size:13.5px; color:#c9cad6; margin:0 0 6px; line-height:1.5; }
#modal-excluir .oxm-hint{ display:flex; align-items:center; justify-content:center; gap:5px; font-size:11.5px; color:#f59e0b; margin:0 0 22px; }
#modal-excluir .oxm-actions{ display:flex; gap:10px; }
#modal-excluir .oxm-btn{
    flex:1; display:flex; align-items:center; justify-content:center; gap:6px;
    padding:11px 14px; border-radius:10px; border:1px solid transparent;
    font-size:13px; font-weight:700; cursor:pointer; transition:all .15s;
}
#modal-excluir .oxm-btn-cancel{ background:rgba(255,255,255,0.05); color:#c9cad6; border-color:rgba(255,255,255,0.08); }
#modal-excluir .oxm-btn-cancel:hover{ background:rgba(255,255,255,0.09); color:#e8eaf0; }
#modal-excluir .oxm-btn-danger{ background:linear-gradient(135deg,#f87171 0%,#ef4444 100%); color:#fff; box-shadow:0 6px 16px rgba(239,68,68,0.3); }
#modal-excluir .oxm-btn-danger:hover{ filter:brightness(1.08); box-shadow:0 8px 20px rgba(239,68,68,0.4); }

#atualizar-estoque{ background:transparent!important;border:none!important;box-shadow:none!important;padding:0!important; }
#atualizar-estoque .fm-wrap{
    max-width:400px; margin:0 auto; position:relative;
    background:linear-gradient(180deg,#22263a 0%,#1a1d2e 100%);
    border:1px solid rgba(255,255,255,0.08); border-radius:18px;
    box-shadow:0 24px 60px rgba(0,0,0,0.55),0 2px 8px rgba(0,0,0,0.3);
    padding:26px 26px 22px;
}
#atualizar-estoque .fm-close{
    position:absolute; top:14px; right:14px; width:30px; height:30px; border-radius:8px;
    border:none; background:rgba(255,255,255,0.05); color:#8a90a2; font-size:18px;
    display:flex; align-items:center; justify-content:center; cursor:pointer; transition:all .15s;
}
#atualizar-estoque .fm-close:hover{ background:rgba(255,255,255,0.1); color:#e8eaf0; }
#atualizar-estoque .fm-header{ display:flex; align-items:center; gap:14px; margin-bottom:20px; padding-right:30px; }
#atualizar-estoque .fm-header-icon{ width:46px; height:46px; border-radius:12px; flex-shrink:0; display:flex; align-items:center; justify-content:center; }
#atualizar-estoque .fm-header-icon i{ font-size:22px; }
#atualizar-estoque .fm-header-icon-amber{ background:radial-gradient(circle, rgba(251,191,36,0.22) 0%, rgba(251,191,36,0.08) 100%); border:1px solid rgba(251,191,36,0.3); }
#atualizar-estoque .fm-header-icon-amber i{ color:#fbbf24; }
#atualizar-estoque .fm-title{ font-size:16.5px; font-weight:800; color:#e8eaf0; margin:0; }
#atualizar-estoque .fm-subtitle{ font-size:12px; color:#8a90a2; margin-top:2px; display:block; }
#atualizar-estoque .fm-field{ margin-bottom:16px; }
#atualizar-estoque .fm-field:last-of-type{ margin-bottom:0; }
#atualizar-estoque .fm-label{ display:block; font-size:10.5px; font-weight:800; color:#8a90a2; text-transform:uppercase; letter-spacing:.6px; margin-bottom:7px; }
#atualizar-estoque .fm-input{ width:100%; box-sizing:border-box; background:#1e2133; border:1px solid #444860; color:#e8eaf0; border-radius:8px; padding:10px 12px; font-size:13.5px; }
#atualizar-estoque .fm-input:focus{ outline:none; border-color:#a78bfa; }
#atualizar-estoque .fm-input[readonly]{ opacity:.65; cursor:not-allowed; }
#atualizar-estoque .fm-footer{ display:flex; gap:10px; margin-top:22px; }
#atualizar-estoque .fm-btn{
    flex:1; display:flex; align-items:center; justify-content:center; gap:6px;
    padding:11px 14px; border-radius:10px; border:1px solid transparent;
    font-size:13px; font-weight:700; cursor:pointer; transition:all .15s;
}
#atualizar-estoque .fm-btn-cancel{ background:rgba(255,255,255,0.05); color:#c9cad6; border-color:rgba(255,255,255,0.08); }
#atualizar-estoque .fm-btn-cancel:hover{ background:rgba(255,255,255,0.09); color:#e8eaf0; }
#atualizar-estoque .fm-btn-primary{ background:linear-gradient(135deg,#60a5fa 0%,#3b82f6 100%); color:#fff; box-shadow:0 6px 16px rgba(59,130,246,0.3); }
#atualizar-estoque .fm-btn-primary:hover{ filter:brightness(1.08); box-shadow:0 8px 20px rgba(59,130,246,0.4); }
</style>

<!-- Modal Etiquetas -->
<div id="modal-etiquetas" class="modal hide fade" tabindex="-1">
    <form action="<?= base_url() ?>index.php/relatorios/produtosEtiquetas" method="get">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h5><i class='bx bx-barcode' style="color:#fbbf24;"></i> Gerar Etiquetas</h5>
        </div>
        <div class="modal-body">
            <div class="alert alert-info">Escolha o intervalo de produtos para gerar as etiquetas.</div>
            <div class="span12" style="margin-left:0;">
                <div class="span6" style="margin-left:0;">
                    <label>De (ID)</label>
                    <input class="span9" style="margin-left:0" type="text" name="de_id" placeholder="ID do primeiro produto">
                </div>
                <div class="span6">
                    <label>Até (ID)</label>
                    <input class="span9" type="text" name="ate_id" placeholder="ID do último produto">
                </div>
                <div class="span4">
                    <label>Qtd. do Estoque</label>
                    <input type="checkbox" name="qtdEtiqueta" value="true">
                </div>
                <div class="span6">
                    <label>Formato</label>
                    <select class="span5" name="etiquetaCode">
                        <option value="EAN13">EAN-13</option>
                        <option value="UPCA">UPCA</option>
                        <option value="C93">CODE 93</option>
                        <option value="C128A">CODE 128</option>
                        <option value="CODABAR">CODABAR</option>
                        <option value="QR">QR-CODE</option>
                    </select>
                </div>
            </div>
        </div>
        <div class="modal-footer" style="display:flex;justify-content:center;gap:10px;">
            <button type="button" class="button btn btn-warning" data-dismiss="modal"><span class="button__icon"><i class="bx bx-x"></i></span><span class="button__text2">Cancelar</span></button>
            <button type="submit" class="button btn btn-success"><span class="button__icon"><i class='bx bx-barcode'></i></span><span class="button__text2">Gerar</span></button>
        </div>
    </form>
</div>

<script src="<?= base_url() ?>assets/js/jquery.validate.js"></script>
<script>
$(document).ready(function() {
    $(document).on('click', 'a[produto]', function() {
        var p = $(this).attr('produto'), e = $(this).attr('estoque');
        $('.idProduto').val(p);
        $('#estoqueAtual').val(e);
    });
    $('#formEstoque').validate({
        rules: { estoque: { required: true, number: true } },
        messages: { estoque: { required: 'Campo obrigatório.', number: 'Informe um número válido.' } },
        errorClass: 'help-inline', errorElement: 'span',
        highlight: function(el) { $(el).parents('.control-group').addClass('error'); },
        unhighlight: function(el) { $(el).parents('.control-group').removeClass('error').addClass('success'); }
    });
});

function filterTable(q) {
    q = q.toLowerCase();
    $('#tabela tbody tr').each(function() {
        $(this).toggle($(this).text().toLowerCase().indexOf(q) > -1);
    });
}

// ── Rolagem infinita ─────────────────────────────────────────────
(function() {
    var tbody = document.getElementById('prod-tbody');
    var loadingEl = document.getElementById('prod-loading');
    var fimEl = document.getElementById('prod-fim');
    var countLabel = document.getElementById('prod-count-label');
    var perPage = <?= (int)($perPage ?? 24) ?>;
    var pesquisaAtual = <?= json_encode($pesquisa ?? '') ?>;
    var estoqueBaixoAtual = <?= json_encode($estoqueBaixo ?? '') ?>;
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

        var url = '<?= site_url("produtos/carregarMais") ?>?antes_de=' + ultimoIdCarregado()
            + '&pesquisa=' + encodeURIComponent(pesquisaAtual)
            + '&estoqueBaixo=' + encodeURIComponent(estoqueBaixoAtual);

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
                    if (countLabel) countLabel.textContent = qtdCarregada + ' de ' + totalGeral + ' produtos carregados';
                }
            })
            .catch(function() {})
            .finally(function() {
                carregando = false;
                loadingEl.style.display = 'none';
            });
    }

    if (acabou) fimEl.style.display = 'block';

    var sentinel = document.getElementById('prod-sentinel');
    if (sentinel && 'IntersectionObserver' in window) {
        new IntersectionObserver(function(entries) {
            entries.forEach(function(e) { if (e.isIntersecting) carregarMais(); });
        }, { rootMargin: '200px' }).observe(sentinel);
    }
})();
</script>
