<style>
/* ══════════════════════════════════════════════════════════
   CLIENTES — redesign em grade de cards (mesma paleta do SISOS:
   fundo #1a1d2e, superfície #1e2235, acento violeta #a78bfa/#7c3aed)
   ══════════════════════════════════════════════════════════ */

.pg-header { display:flex; justify-content:space-between; align-items:flex-start; margin-bottom:20px; flex-wrap:wrap; gap:14px; }
.pg-title { font-size:22px; font-weight:800; color:#e8eaf0; display:flex; align-items:center; gap:10px; }
.pg-title i { font-size:24px; color:#a78bfa; }
.pg-subtitle { font-size:13px; color:#6b7280; margin-top:2px; }
.pg-actions { display:flex; gap:10px; align-items:center; flex-wrap:wrap; }

.search-bar { display:flex; gap:0; }
.search-bar input {
    padding:9px 14px; border-radius:8px 0 0 8px;
    border:1px solid #444860; border-right:none;
    background:#1e2133; color:#e8eaf0; font-size:13px; width:240px;
}
.search-bar input:focus { outline:none; border-color:#a78bfa; }
.search-bar button {
    padding:9px 14px; border-radius:0 8px 8px 0;
    background:#a78bfa; border:none; color:#fff; cursor:pointer;
    font-size:15px; transition:background .15s;
}
.search-bar button:hover { background:#7c3aed; }

.btn-add {
    display:flex; align-items:center; gap:7px;
    padding:9px 16px; border-radius:8px;
    background:linear-gradient(135deg,#22c55e,#16a34a);
    color:#fff; font-size:13px; font-weight:700;
    text-decoration:none; border:none; cursor:pointer;
    box-shadow:0 4px 14px rgba(34,197,94,0.3);
    transition:transform .15s, box-shadow .15s;
}
.btn-add:hover { transform:translateY(-2px); box-shadow:0 6px 20px rgba(34,197,94,0.4); color:#fff; }
.btn-add i { font-size:18px; }

/* ── Estatísticas ─────────────────────────────────────────── */
.cli-stats { display:grid; grid-template-columns:repeat(auto-fit,minmax(200px,1fr)); gap:12px; margin-bottom:18px; }
.cli-stat { background:#1a1d2e; border:1px solid rgba(255,255,255,0.07); border-radius:14px; padding:16px 18px; display:flex; align-items:center; gap:14px; transition:transform .15s; }
.cli-stat:hover { transform:translateY(-2px); }
.cli-stat-icon { width:44px; height:44px; border-radius:12px; display:flex; align-items:center; justify-content:center; font-size:20px; flex-shrink:0; }
.cli-stat-val { font-size:22px; font-weight:800; color:#e8eaf0; line-height:1; }
.cli-stat-label { font-size:10.5px; font-weight:700; color:#6b7280; text-transform:uppercase; letter-spacing:.6px; margin-top:3px; }

/* ── Toolbar ──────────────────────────────────────────────── */
.cli-toolbar { display:flex; align-items:center; justify-content:space-between; padding:10px 4px; margin-bottom:12px; flex-wrap:wrap; gap:10px; }
.cli-toolbar-left { font-size:12px; color:#6b7280; display:flex; align-items:center; gap:8px; }
.cli-toolbar-left select { background:#1e2235; border:1px solid #444860; color:#e8eaf0; padding:5px 9px; border-radius:6px; font-size:12px; }
.cli-quickfilter input { background:#1e2235; border:1px solid #444860; color:#e8eaf0; padding:7px 12px; border-radius:7px; font-size:12px; width:200px; }
.cli-quickfilter input:focus { outline:none; border-color:#a78bfa; }

/* ── Grade de cards ───────────────────────────────────────── */
.cli-grid { display:grid; grid-template-columns:repeat(auto-fill,minmax(280px,1fr)); gap:14px; }

.cli-card {
    background:#1a1d2e; border:1px solid rgba(255,255,255,0.07); border-radius:14px;
    padding:18px; display:flex; flex-direction:column; gap:12px;
    transition:transform .15s, border-color .15s, box-shadow .15s;
    position:relative; overflow:hidden;
}
.cli-card::before {
    content:''; position:absolute; top:0; left:0; right:0; height:3px;
    background:linear-gradient(90deg,#a78bfa,#7c3aed);
    opacity:0; transition:opacity .15s;
}
.cli-card:hover { transform:translateY(-3px); border-color:rgba(167,139,250,0.3); box-shadow:0 10px 24px rgba(0,0,0,0.25); }
.cli-card:hover::before { opacity:1; }

.cli-card-top { display:flex; align-items:flex-start; gap:12px; }
.cli-avatar {
    width:46px; height:46px; border-radius:12px; flex-shrink:0;
    display:flex; align-items:center; justify-content:center;
    font-size:17px; font-weight:800; color:#fff;
}
.cli-card-name { font-size:14.5px; font-weight:700; color:#e8eaf0; line-height:1.3; }
.cli-card-name a { color:inherit; text-decoration:none; }
.cli-card-name a:hover { color:#a78bfa; }
.cli-card-badges { display:flex; gap:5px; margin-top:5px; flex-wrap:wrap; }

.badge-cliente    { background:rgba(34,197,94,0.15); color:#4ade80; border:1px solid rgba(34,197,94,0.25); padding:2px 9px; border-radius:20px; font-size:10.5px; font-weight:700; }
.badge-fornecedor { background:rgba(167,139,250,0.15); color:#a78bfa; border:1px solid rgba(167,139,250,0.25); padding:2px 9px; border-radius:20px; font-size:10.5px; font-weight:700; }
.badge-bloqueado  { background:rgba(239,68,68,0.15); color:#f87171; border:1px solid rgba(239,68,68,0.25); padding:2px 9px; border-radius:20px; font-size:10.5px; font-weight:700; }

.cli-card-info { display:flex; flex-direction:column; gap:6px; font-size:12.5px; color:#9ca3af; }
.cli-card-info div { display:flex; align-items:center; gap:8px; overflow:hidden; }
.cli-card-info i { font-size:14px; color:#6b7280; flex-shrink:0; }
.cli-card-info span { overflow:hidden; text-overflow:ellipsis; white-space:nowrap; }

.cli-card-footer { display:flex; align-items:center; gap:8px; margin-top:auto; padding-top:12px; border-top:1px solid rgba(255,255,255,0.06); }
.cli-btn-ficha {
    flex:1; text-align:center; padding:8px 12px; border-radius:8px;
    background:rgba(167,139,250,0.12); color:#a78bfa; border:1px solid rgba(167,139,250,0.25);
    font-size:12.5px; font-weight:700; text-decoration:none; transition:background .15s;
}
.cli-btn-ficha:hover { background:rgba(167,139,250,0.22); color:#a78bfa; }

.act-btn {
    width:30px; height:30px; border-radius:7px; display:inline-flex; flex-shrink:0;
    align-items:center; justify-content:center; font-size:14px;
    text-decoration:none; transition:background .15s, transform .12s; border:none; cursor:pointer;
}
.act-btn:hover { transform:scale(1.1); }
.act-btns { display:flex; gap:5px; align-items:center; }
.act-btn-view  { background:rgba(96,165,250,0.15); color:#60a5fa; }
.act-btn-view:hover { background:rgba(96,165,250,0.3); color:#60a5fa; }
.act-btn-key   { background:rgba(251,191,36,0.15); color:#fbbf24; }
.act-btn-key:hover { background:rgba(251,191,36,0.3); color:#fbbf24; }
.act-btn-lock  { background:rgba(96,165,250,0.15); color:#60a5fa; }
.act-btn-lock:hover { background:rgba(96,165,250,0.3); color:#60a5fa; }
.act-btn-edit  { background:rgba(34,197,94,0.15); color:#4ade80; }
.act-btn-edit:hover { background:rgba(34,197,94,0.3); color:#4ade80; }
.act-btn-del   { background:rgba(239,68,68,0.15); color:#f87171; }
.act-btn-del:hover { background:rgba(239,68,68,0.3); color:#f87171; }

.cli-empty { text-align:center; padding:60px 20px; color:#6b7280; grid-column:1/-1; }
.cli-empty i { font-size:44px; display:block; margin-bottom:10px; opacity:.3; }
.cli-empty p { font-size:13px; }
</style>

<div class="new122">

    <!-- Header -->
    <div class="pg-header">
        <div>
            <div class="pg-title"><i class='bx bx-group'></i> Clientes</div>
            <div class="pg-subtitle">Gerencie sua base de clientes e fornecedores</div>
        </div>
        <div class="pg-actions">
            <?php if ($this->permission->checkPermission($this->session->userdata('permissao'), 'aCliente')): ?>
            <a href="<?= base_url() ?>index.php/clientes/adicionar" class="btn-add">
                <i class='bx bx-user-plus'></i> Novo Cliente
            </a>
            <?php endif; ?>
            <form method="get" action="<?= base_url() ?>index.php/clientes" class="search-bar">
                <input type="text" name="pesquisa" placeholder="Buscar nome, doc, email..." value="<?= htmlspecialchars($this->input->get('pesquisa') ?? '') ?>">
                <button type="submit"><i class='bx bx-search'></i></button>
            </form>
            <div class="cli-view-toggle">
                <button type="button" class="cvt-btn <?= $visualizacaoAtual === 'grade' ? 'ativo' : '' ?>" onclick="cliTrocarVisualizacao('grade')" title="Ver em grade"><i class='bx bx-grid-alt'></i></button>
                <button type="button" class="cvt-btn <?= $visualizacaoAtual === 'lista' ? 'ativo' : '' ?>" onclick="cliTrocarVisualizacao('lista')" title="Ver em lista"><i class='bx bx-list-ul'></i></button>
            </div>
        </div>
    </div>

    <style>
    .cli-view-toggle{display:flex;background:#1a1d2e;border:1px solid rgba(255,255,255,0.08);border-radius:9px;padding:3px;gap:2px;}
    .cvt-btn{width:34px;height:32px;border:none;background:transparent;color:#6b7280;border-radius:6px;cursor:pointer;font-size:16px;display:flex;align-items:center;justify-content:center;transition:all .15s;}
    .cvt-btn.ativo{background:rgba(167,139,250,0.15);color:#a78bfa;}
    .tbl-wrap{background:#1a1d2e;border:1px solid rgba(255,255,255,0.07);border-radius:14px;overflow:hidden;margin-bottom:14px;}
    .tbl-wrap table{width:100%;border-collapse:collapse;}
    .tbl-wrap thead th{background:#252a3a;color:#9ca3af;font-size:11px;font-weight:700;text-transform:uppercase;letter-spacing:.6px;padding:11px 14px;border-bottom:1px solid rgba(255,255,255,0.07);white-space:nowrap;}
    .tbl-wrap tbody tr{border-bottom:1px solid rgba(255,255,255,0.04);transition:background .12s;}
    .tbl-wrap tbody tr:hover{background:rgba(96,165,250,0.05);}
    .tbl-wrap tbody td{padding:11px 14px;font-size:13px;color:#c9cad6;vertical-align:middle;}
    .tbl-empty{text-align:center;padding:40px;color:#6b7280;}
    .tbl-empty i{font-size:40px;display:block;margin-bottom:8px;opacity:.3;}
    .td-name a{color:#e8eaf0;font-weight:600;text-decoration:none;}
    .td-name a:hover{color:#a78bfa;}
    </style>
    <script>
    function cliTrocarVisualizacao(modo) {
        var params = new URLSearchParams(window.location.search);
        params.set('visualizacao', modo);
        window.location.href = '<?= site_url('clientes') ?>?' + params.toString();
    }
    </script>

    <!-- Estatísticas -->
    <div class="cli-stats">
        <div class="cli-stat">
            <div class="cli-stat-icon" style="background:rgba(167,139,250,0.15);"><i class='bx bx-group' style="color:#a78bfa;"></i></div>
            <div><div class="cli-stat-val"><?= (int)($statTotalClientes ?? 0) ?></div><div class="cli-stat-label">Total de Clientes</div></div>
        </div>
        <div class="cli-stat">
            <div class="cli-stat-icon" style="background:rgba(34,197,94,0.15);"><i class='bx bx-user-plus' style="color:#4ade80;"></i></div>
            <div><div class="cli-stat-val"><?= (int)($statNovosMes ?? 0) ?></div><div class="cli-stat-label">Novos Este Mês</div></div>
        </div>
        <div class="cli-stat">
            <div class="cli-stat-icon" style="background:rgba(96,165,250,0.15);"><i class='bx bx-store' style="color:#60a5fa;"></i></div>
            <div><div class="cli-stat-val"><?= (int)($statFornecedores ?? 0) ?></div><div class="cli-stat-label">Fornecedores</div></div>
        </div>
    </div>

    <?php if ($visualizacaoAtual === 'lista'): ?>
    <!-- ── Visualização em Lista (tabela + rolagem infinita) ── -->
    <div class="cli-toolbar">
        <div class="cli-toolbar-left">
            <span id="cli-count-label-lista" style="color:#e8eaf0;font-weight:600;"><?= count($results) ?> de <?= (int)($statTotalClientes ?? 0) ?> clientes carregados</span>
        </div>
        <div class="cli-quickfilter">
            <input type="text" placeholder="Filtrar o que já carregou..." oninput="cliFilterLista(this.value)">
        </div>
    </div>
    <div class="tbl-wrap">
        <table id="tabelaClientes" class="table">
            <thead>
                <tr>
                    <th>#</th><th>Nome</th><th>Contato</th><th>CPF/CNPJ</th>
                    <th>Telefone</th><th>Celular</th><th>Email</th><th>Tipo</th><th>Ações</th>
                </tr>
            </thead>
            <tbody id="cli-lista-tbody">
                <?php echo $this->load->view('clientes/_table_rows_partial', ['results' => $results], true); ?>
            </tbody>
        </table>
    </div>
    <div id="cli-sentinel-lista" style="display:flex;justify-content:center;padding:24px 0;">
        <div id="cli-loading-lista" style="display:none;align-items:center;gap:8px;color:#9ca3af;font-size:13px;">
            <i class='bx bx-loader-alt bx-spin'></i> Carregando mais clientes...
        </div>
        <div id="cli-fim-lista" style="display:none;color:#6b7280;font-size:12px;">
            Isso é tudo — não há mais clientes para carregar.
        </div>
    </div>
    <script>
    function cliFilterLista(q) {
        q = q.toLowerCase();
        document.querySelectorAll('#tabelaClientes tbody tr').forEach(function(tr) {
            tr.style.display = tr.textContent.toLowerCase().indexOf(q) > -1 ? '' : 'none';
        });
    }
    (function() {
        var tbody = document.getElementById('cli-lista-tbody');
        var loadingEl = document.getElementById('cli-loading-lista');
        var fimEl = document.getElementById('cli-fim-lista');
        var countLabel = document.getElementById('cli-count-label-lista');
        var perPage = <?= (int)($perPage ?? 24) ?>;
        var pesquisaAtual = <?= json_encode($pesquisa ?? '') ?>;
        var totalGeral = <?= (int)($statTotalClientes ?? 0) ?>;
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

            var url = '<?= site_url("clientes/carregarMais") ?>?antes_de=' + ultimoIdCarregado() + '&pesquisa=' + encodeURIComponent(pesquisaAtual) + '&modo=lista';
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
                        if (countLabel) countLabel.textContent = qtdCarregada + ' de ' + totalGeral + ' clientes carregados';
                    }
                })
                .catch(function() {})
                .finally(function() {
                    carregando = false;
                    loadingEl.style.display = 'none';
                });
        }

        if (acabou) fimEl.style.display = 'block';
        var sentinel = document.getElementById('cli-sentinel-lista');
        if (sentinel && 'IntersectionObserver' in window) {
            new IntersectionObserver(function(entries) {
                entries.forEach(function(e) { if (e.isIntersecting) carregarMais(); });
            }, { rootMargin: '200px' }).observe(sentinel);
        }
    })();
    </script>

    <?php else: ?>
    <!-- Toolbar -->
    <div class="cli-toolbar">
        <div class="cli-toolbar-left">
            <span id="cli-count-label" style="color:#e8eaf0;font-weight:600;"><?= count($results) ?> de <?= (int)($statTotalClientes ?? 0) ?> clientes carregados</span>
        </div>
        <div class="cli-quickfilter">
            <input type="text" id="cli-filter" placeholder="Filtrar o que já carregou..." oninput="cliFilter(this.value)">
        </div>
    </div>

    <!-- Grade de clientes -->
    <div class="cli-grid" id="cli-grid">
        <?php echo $this->load->view('clientes/_cards_partial', ['results' => $results], true); ?>

        <!-- Sentinela da rolagem infinita — fica dentro da grade, ocupando
             a linha inteira, pra o observer conseguir detectar quando ela
             entra na tela mesmo com o layout em colunas. -->
        <div id="cli-sentinel" style="grid-column:1/-1;display:flex;justify-content:center;padding:24px 0;">
            <div id="cli-loading" style="display:none;align-items:center;gap:8px;color:#9ca3af;font-size:13px;">
                <i class='bx bx-loader-alt bx-spin'></i> Carregando mais clientes...
            </div>
            <div id="cli-fim" style="display:none;color:#6b7280;font-size:12px;">
                Isso é tudo — não há mais clientes para carregar.
            </div>
        </div>
    </div>
    <?php endif; ?>

</div>

<!-- Modal Excluir -->
<div id="modal-excluir" class="modal hide fade" tabindex="-1">
    <form action="<?= base_url() ?>index.php/clientes/excluir" method="post">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h5><i class='bx bx-trash' style="color:#f87171;"></i> Excluir Cliente</h5>
        </div>
        <div class="modal-body" style="text-align:center;padding:20px;">
            <div style="width:60px;height:60px;background:rgba(239,68,68,0.15);border-radius:50%;display:flex;align-items:center;justify-content:center;margin:0 auto 16px;">
                <i class='bx bx-user-x' style="font-size:28px;color:#f87171;"></i>
            </div>
            <p style="color:#e8eaf0;font-size:14px;margin-bottom:6px;font-weight:600;">Deseja excluir este cliente?</p>
            <p style="color:#6b7280;font-size:12px;">Todos os dados associados (OS, Vendas, Receitas) também serão removidos.</p>
            <input type="hidden" id="idCliente" name="id" value="">
        </div>
        <div class="modal-footer" style="display:flex;justify-content:center;gap:10px;">
            <button type="button" class="button btn btn-warning" data-dismiss="modal">
                <span class="button__icon"><i class="bx bx-x"></i></span><span class="button__text2">Cancelar</span>
            </button>
            <button type="submit" class="button btn btn-danger">
                <span class="button__icon"><i class='bx bx-trash'></i></span><span class="button__text2">Excluir</span>
            </button>
        </div>
    </form>
</div>

<script>
$(document).ready(function() {
    $(document).on('click', 'a[cliente]', function() {
        $('#idCliente').val($(this).attr('cliente'));
    });
});

// Filtro rápido — busca no texto já embutido em cada card carregado (data-search)
function cliFilter(q) {
    q = q.toLowerCase();
    document.querySelectorAll('#cli-grid .cli-card').forEach(function(card) {
        var alvo = card.getAttribute('data-search') || '';
        card.style.display = alvo.indexOf(q) > -1 ? '' : 'none';
    });
}

// ── Rolagem infinita ─────────────────────────────────────────────
// Conforme o usuário rola até perto do fim da grade, carrega mais
// clientes via AJAX (clientes/carregarMais) e "gruda" no final.
(function() {
    var grid = document.getElementById('cli-grid');
    var loadingEl = document.getElementById('cli-loading');
    var fimEl = document.getElementById('cli-fim');
    var countLabel = document.getElementById('cli-count-label');
    var perPage = <?= (int)($perPage ?? 24) ?>;
    var pesquisaAtual = <?= json_encode($pesquisa ?? '') ?>;
    var totalGeral = <?= (int)($statTotalClientes ?? 0) ?>;
    var qtdCarregada = <?= (int)count($results) ?>;
    var carregando = false;
    var acabou = qtdCarregada >= totalGeral;

    function ultimoIdCarregado() {
        var cards = grid.querySelectorAll('.cli-card');
        if (!cards.length) return 0;
        return parseInt(cards[cards.length - 1].getAttribute('data-id'), 10) || 0;
    }

    function atualizarContador() {
        var qtd = document.querySelectorAll('#cli-grid .cli-card').length;
        if (countLabel) countLabel.textContent = qtd + ' de ' + totalGeral + ' clientes carregados';
    }

    function carregarMais() {
        if (carregando || acabou) return;
        carregando = true;
        loadingEl.style.display = 'flex';

        var url = '<?= site_url("clientes/carregarMais") ?>?antes_de=' + ultimoIdCarregado() + '&pesquisa=' + encodeURIComponent(pesquisaAtual);
        fetch(url)
            .then(function(res) { return res.text(); })
            .then(function(html) {
                if (html.trim() === '') {
                    acabou = true;
                    fimEl.style.display = 'block';
                } else {
                    var temp = document.createElement('div');
                    temp.innerHTML = html;
                    var novosCards = temp.querySelectorAll('.cli-card');
                    novosCards.forEach(function(card) { grid.insertBefore(card, document.getElementById('cli-sentinel')); });
                    qtdCarregada += novosCards.length;
                    if (novosCards.length < perPage) {
                        acabou = true;
                        fimEl.style.display = 'block';
                    }
                    atualizarContador();
                }
            })
            .catch(function() { /* falha silenciosa — tenta de novo na próxima rolagem */ })
            .finally(function() {
                carregando = false;
                loadingEl.style.display = 'none';
            });
    }

    if (acabou) { fimEl.style.display = 'block'; }

    var sentinel = document.getElementById('cli-sentinel');
    if (sentinel && 'IntersectionObserver' in window) {
        var observer = new IntersectionObserver(function(entries) {
            entries.forEach(function(entry) {
                if (entry.isIntersecting) carregarMais();
            });
        }, { rootMargin: '200px' });
        observer.observe(sentinel);
    }
})();

// Bloquear/Desbloquear
$(document).on('click', '.btn-bloquear', function(e) {
    e.preventDefault();
    var id = $(this).data('id');
    var bloqueado = $(this).data('bloqueado');
    var motivo = '';
    if (!bloqueado) {
        motivo = prompt('Motivo do bloqueio:');
        if (motivo === null) return;
    }
    $.post('<?= site_url("clientes/bloquear") ?>', {
        id: id, acao: bloqueado ? 'desbloquear' : 'bloquear', motivo: motivo,
        '<?= $this->security->get_csrf_token_name() ?>': '<?= $this->security->get_csrf_hash() ?>'
    }, function(res) { if (res.result) location.reload(); }, 'json');
});
</script>
