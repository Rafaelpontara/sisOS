<style>
.pg-header{display:flex;justify-content:space-between;align-items:flex-start;margin-bottom:20px;flex-wrap:wrap;gap:14px;}
.pg-title{font-size:22px;font-weight:800;color:#e8eaf0;display:flex;align-items:center;gap:10px;}
.pg-title i{font-size:24px;color:#a78bfa;}
.pg-subtitle{font-size:13px;color:#6b7280;margin-top:2px;}
.search-bar{display:flex;gap:0;}
.search-bar input{padding:9px 14px;border-radius:8px 0 0 8px;border:1px solid #444860;border-right:none;background:#1e2133;color:#e8eaf0;font-size:13px;width:240px;}
.search-bar input:focus{outline:none;border-color:#a78bfa;}
.search-bar button{padding:9px 14px;border-radius:0 8px 8px 0;background:#a78bfa;border:none;color:#fff;cursor:pointer;font-size:15px;}
.btn-add{display:flex;align-items:center;gap:7px;padding:9px 16px;border-radius:8px;background:linear-gradient(135deg,#22c55e,#16a34a);color:#fff;font-size:13px;font-weight:700;text-decoration:none;border:none;box-shadow:0 4px 14px rgba(34,197,94,0.3);}
.btn-add:hover{color:#fff;}

.sol-stat{background:#1a1d2e;border:1px solid rgba(255,255,255,0.07);border-radius:14px;padding:16px 18px;display:flex;align-items:center;gap:14px;margin-bottom:18px;max-width:260px;}
.sol-stat-icon{width:44px;height:44px;border-radius:12px;background:rgba(167,139,250,0.15);display:flex;align-items:center;justify-content:center;font-size:20px;color:#a78bfa;}
.sol-stat-val{font-size:20px;font-weight:800;color:#e8eaf0;line-height:1;}
.sol-stat-label{font-size:10.5px;font-weight:700;color:#6b7280;text-transform:uppercase;letter-spacing:.6px;margin-top:3px;}

.sol-grid{display:grid;grid-template-columns:repeat(auto-fill,minmax(260px,1fr));gap:14px;}
.sol-card{background:#1a1d2e;border:1px solid rgba(255,255,255,0.07);border-radius:14px;padding:16px;display:flex;flex-direction:column;gap:8px;text-decoration:none;transition:transform .15s,border-color .15s,box-shadow .15s;}
.sol-card:hover{transform:translateY(-3px);border-color:rgba(167,139,250,0.3);box-shadow:0 10px 24px rgba(0,0,0,0.25);color:inherit;}
.sol-icon{width:38px;height:38px;border-radius:10px;background:rgba(251,191,36,0.15);color:#fbbf24;display:flex;align-items:center;justify-content:center;font-size:18px;}
.sol-titulo{font-size:14px;font-weight:700;color:#e8eaf0;}
.sol-equip{font-size:11.5px;color:#9ca3af;display:flex;align-items:center;gap:5px;}
.sol-resumo{font-size:12px;color:#9ca3af;line-height:1.4;border-top:1px solid rgba(255,255,255,0.06);padding-top:8px;}
.sol-foot{display:flex;justify-content:space-between;font-size:11px;color:#6b7280;margin-top:auto;padding-top:8px;}

.sol-empty{grid-column:1/-1;text-align:center;padding:60px 20px;color:#6b7280;}
.sol-empty i{font-size:44px;display:block;margin-bottom:10px;opacity:.3;color:#fbbf24;}
</style>

<div class="new122">
    <div class="pg-header">
        <div>
            <div class="pg-title"><i class='bx bx-bulb'></i> Soluções Técnicas</div>
            <div class="pg-subtitle">Base de conhecimento — problemas e soluções já resolvidas pela equipe</div>
        </div>
        <div style="display:flex;gap:10px;">
            <?php if ($this->permission->checkPermission($this->session->userdata('permissao'), 'dOs')): ?>
            <a href="<?= base_url() ?>index.php/solucoes/adicionar" class="btn-add"><i class='bx bx-plus-circle'></i> Nova Solução</a>
            <?php endif; ?>
            <form method="get" action="<?= base_url() ?>index.php/solucoes" class="search-bar">
                <input type="text" name="pesquisa" placeholder="Buscar problema, equipamento..." value="<?= htmlspecialchars($this->input->get('pesquisa') ?? '') ?>">
                <button type="submit"><i class='bx bx-search'></i></button>
            </form>
        </div>
    </div>

    <div class="sol-stat">
        <div class="sol-stat-icon"><i class='bx bx-bulb'></i></div>
        <div><div class="sol-stat-val"><?= (int)($statTotal ?? 0) ?></div><div class="sol-stat-label">Soluções Cadastradas</div></div>
    </div>

    <div class="sol-grid" id="sol-grid">
        <?php echo $this->load->view('solucoes/_cards_partial', ['results' => $results], true); ?>

        <div id="sol-sentinel" style="grid-column:1/-1;display:flex;justify-content:center;padding:24px 0;">
            <div id="sol-loading" style="display:none;align-items:center;gap:8px;color:#9ca3af;font-size:13px;">
                <i class='bx bx-loader-alt bx-spin'></i> Carregando mais...
            </div>
            <div id="sol-fim" style="display:none;color:#6b7280;font-size:12px;">Isso é tudo.</div>
        </div>
    </div>
</div>

<script>
(function() {
    var grid = document.getElementById('sol-grid');
    var loadingEl = document.getElementById('sol-loading');
    var fimEl = document.getElementById('sol-fim');
    var pesquisaAtual = <?= json_encode($pesquisa ?? '') ?>;
    var totalGeral = <?= (int)($statTotal ?? 0) ?>;
    var qtdCarregada = <?= (int)count($results) ?>;
    var carregando = false;
    var acabou = qtdCarregada >= totalGeral;

    function ultimoIdCarregado() {
        var cards = grid.querySelectorAll('.sol-card');
        if (!cards.length) return 0;
        var href = cards[cards.length - 1].getAttribute('href');
        return parseInt(href.split('/').pop(), 10) || 0;
    }

    function carregarMais() {
        if (carregando || acabou) return;
        carregando = true;
        loadingEl.style.display = 'flex';
        var url = '<?= site_url("solucoes/carregarMais") ?>?antes_de=' + ultimoIdCarregado() + '&pesquisa=' + encodeURIComponent(pesquisaAtual);
        fetch(url).then(function(r) { return r.text(); }).then(function(html) {
            if (html.trim() === '') { acabou = true; fimEl.style.display = 'block'; return; }
            var temp = document.createElement('div');
            temp.innerHTML = html;
            var novos = temp.querySelectorAll('.sol-card');
            novos.forEach(function(c) { grid.insertBefore(c, document.getElementById('sol-sentinel')); });
            qtdCarregada += novos.length;
            if (novos.length < 24) { acabou = true; fimEl.style.display = 'block'; }
        }).catch(function() {}).finally(function() { carregando = false; loadingEl.style.display = 'none'; });
    }

    if (acabou) fimEl.style.display = 'block';
    var sentinel = document.getElementById('sol-sentinel');
    if (sentinel && 'IntersectionObserver' in window) {
        new IntersectionObserver(function(entries) {
            entries.forEach(function(e) { if (e.isIntersecting) carregarMais(); });
        }, { rootMargin: '200px' }).observe(sentinel);
    }
})();
</script>
