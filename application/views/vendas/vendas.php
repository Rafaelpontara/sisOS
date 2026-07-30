<style>
.pg-header{display:flex;justify-content:space-between;align-items:center;margin-bottom:16px;flex-wrap:wrap;gap:10px;}
.pg-title{font-size:22px;font-weight:800;color:#e8eaf0;display:flex;align-items:center;gap:10px;}
.pg-title i{font-size:24px;color:#a78bfa;}
.btn-add{display:flex;align-items:center;gap:7px;padding:9px 16px;border-radius:8px;background:linear-gradient(135deg,#22c55e,#16a34a);color:#fff;font-size:13px;font-weight:700;text-decoration:none;border:none;box-shadow:0 4px 14px rgba(34,197,94,0.3);transition:transform .15s;}
.btn-add:hover{transform:translateY(-2px);color:#fff;}
.filter-bar{display:flex;gap:6px;align-items:center;flex-wrap:wrap;margin-bottom:14px;padding:12px 16px;background:#1a1d2e;border:1px solid rgba(255,255,255,0.07);border-radius:14px;}
.filter-bar input,.filter-bar select{padding:8px 10px;border-radius:7px;border:1px solid #444860;background:#252a3a;color:#e8eaf0;font-size:13px;}
.filter-bar input:focus,.filter-bar select:focus{outline:none;border-color:#a78bfa;}
.btn-filter{padding:8px 18px;border-radius:7px;background:#a78bfa;border:none;color:#fff;font-size:13px;font-weight:700;cursor:pointer;}
.tbl-wrap{background:#1a1d2e;border:1px solid rgba(255,255,255,0.07);border-radius:14px;overflow:hidden;margin-bottom:14px;}
.tbl-wrap table{width:100%;border-collapse:collapse;}
.tbl-wrap thead th{background:#252a3a;color:#9ca3af;font-size:11px;font-weight:700;text-transform:uppercase;letter-spacing:.5px;padding:11px 12px;border-bottom:1px solid rgba(255,255,255,0.07);white-space:nowrap;}
.tbl-wrap tbody tr{border-bottom:1px solid rgba(255,255,255,0.04);transition:background .12s;}
.tbl-wrap tbody tr:hover{background:rgba(167,139,250,0.04);}
.tbl-wrap tbody td{padding:10px 12px;font-size:13px;color:#c9cad6;vertical-align:middle;}
.act-btns{display:flex;gap:4px;}
.act-btn{width:28px;height:28px;border-radius:6px;display:inline-flex;align-items:center;justify-content:center;font-size:14px;text-decoration:none;transition:background .15s,transform .12s;border:none;cursor:pointer;}
.act-btn:hover{transform:scale(1.1);}
.ab-v{background:rgba(96,165,250,0.15);color:#60a5fa;}.ab-v:hover{background:rgba(96,165,250,0.3);color:#60a5fa;}
.ab-e{background:rgba(34,197,94,0.15);color:#4ade80;}.ab-e:hover{background:rgba(34,197,94,0.3);color:#4ade80;}
.ab-d{background:rgba(239,68,68,0.15);color:#f87171;}.ab-d:hover{background:rgba(239,68,68,0.3);color:#f87171;}
.ab-p{background:rgba(167,139,250,0.15);color:#a78bfa;}.ab-p:hover{background:rgba(167,139,250,0.3);color:#a78bfa;}
.ab-c{background:rgba(251,146,60,0.15);color:#fb923c;}.ab-c:hover{background:rgba(251,146,60,0.3);color:#fb923c;}
.sp{padding:3px 9px;border-radius:20px;font-size:11px;font-weight:700;display:inline-block;}
.sp-ab{background:rgba(96,165,250,0.15);color:#60a5fa;}.sp-fi{background:rgba(34,197,94,0.15);color:#4ade80;}
.sp-ca{background:rgba(239,68,68,0.15);color:#f87171;}.sp-or{background:rgba(245,158,11,0.15);color:#fbbf24;}
.sp-ot{background:rgba(255,255,255,0.08);color:#9ca3af;}
#tabela_length,.dataTables_length,#tabela_info,.dataTables_info,#tabela_filter,.dataTables_filter,.dataTables_paginate{display:none!important;}
</style>

<div class="new122">
    <div class="pg-header">
        <div class="pg-title"><i class='bx bx-cart-alt'></i> Vendas</div>
        <?php if (!empty($permissao_aVenda)): ?>
        <a href="<?= base_url() ?>index.php/vendas/adicionar" class="btn-add"><i class='bx bx-plus-circle'></i> Nova Venda</a>
        <?php endif; ?>
    </div>

    <form method="get" action="<?= base_url() ?>index.php/vendas" class="filter-bar">
        <input type="text" name="pesquisa" placeholder="Nome do cliente..." value="<?= htmlspecialchars($_GET['pesquisa'] ?? '') ?>" style="width:200px;">
        <select name="status">
            <option value="">Todos os status</option>
            <?php foreach(["Orçamento","Aberto","Faturado","Em Andamento","Finalizado","Cancelado","Aguardando Peças","Aprovado"] as $s): ?>
            <option value="<?=$s?>" <?=($_GET['status'] ?? '')==$s?'selected':''?>><?=$s?></option>
            <?php endforeach; ?>
        </select>
        <input type="date" name="data" value="<?= htmlspecialchars($_GET['data'] ?? '') ?>" style="width:140px;">
        <input type="date" name="data2" value="<?= htmlspecialchars($_GET['data2'] ?? '') ?>" style="width:140px;">
        <button type="submit" class="btn-filter"><i class='bx bx-filter-alt'></i> Filtrar</button>
    </form>

    <div style="margin-bottom:10px;font-size:12px;color:#9ca3af;">
        <span id="vd-count-label" style="color:#e8eaf0;font-weight:600;"><?= count($results ?? []) ?> de <?= (int)($statTotalFiltrado ?? 0) ?> vendas carregadas</span>
    </div>

    <div class="tbl-wrap">
        <table id="tabela" class="table">
            <thead>
                <tr>
                    <th>#</th><th>Cliente</th><th>Vendedor</th><th>Produto(s)</th>
                    <th>Data</th><th>Venc. Garantia</th><th>Total</th><th>Desconto</th>
                    <th>C/ Desconto</th><th>Faturado</th><th>Status</th><th>Ações</th>
                </tr>
            </thead>
            <tbody id="vd-tbody">
            <?php echo $this->load->view('vendas/_table_rows_partial', ['results' => $results ?? [], 'permissao_vVenda' => $permissao_vVenda ?? false, 'permissao_eVenda' => $permissao_eVenda ?? false, 'permissao_dVenda' => $permissao_dVenda ?? false], true); ?>
            </tbody>
        </table>
    </div>
    <div id="vd-sentinel" style="display:flex;justify-content:center;padding:24px 0;">
        <div id="vd-loading" style="display:none;align-items:center;gap:8px;color:#9ca3af;font-size:13px;">
            <i class='bx bx-loader-alt bx-spin'></i> Carregando mais vendas...
        </div>
        <div id="vd-fim" style="display:none;color:#6b7280;font-size:12px;">
            Isso é tudo — não há mais vendas para carregar com esses filtros.
        </div>
    </div>
</div>
<!-- Modal -->
<div id="modal-excluir" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <form action="<?php echo base_url() ?>index.php/vendas/excluir" method="post">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            <h5 id="myModalLabel">Excluir Venda</h5>
        </div>
        <div class="modal-body">
            <input type="hidden" id="idVenda" name="id" value="" />
            <h5 style="text-align: center">Deseja realmente excluir esta Venda?</h5>
        </div>
        <div class="modal-footer" style="display:flex;justify-content: center">
            <button class="button btn btn-warning" data-dismiss="modal" aria-hidden="true">
              <span class="button__icon"><i class="bx bx-x"></i></span><span class="button__text2">Cancelar</span></button>
            <button class="button btn btn-danger"><span class="button__icon"><i class='bx bx-trash'></i></span> <span class="button__text2">Excluir</span></button>
        </div>
    </form>
</div>

<!-- Modal Cancelar Venda -->
<div id="modal-cancelar" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabelCancelar" aria-hidden="true">
    <form action="<?php echo base_url() ?>index.php/vendas/cancelar" method="post">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            <h5 id="myModalLabelCancelar">Cancelar Venda</h5>
        </div>
        <div class="modal-body">
            <input type="hidden" id="idVendaCancelar" name="id" value="" />
            <h5 style="text-align: center">Deseja realmente cancelar esta venda?</h5>
            <p style="text-align:center;color:#9ca3af;font-size:12.5px;margin-top:8px;">
                O estoque dos produtos será <strong>devolvido automaticamente</strong>
                e o lançamento financeiro vinculado será <strong>excluído</strong>.
            </p>
            <div style="margin-top:14px;">
                <label style="font-size:12px;font-weight:600;color:#9ca3af;text-transform:uppercase;letter-spacing:.5px;display:block;margin-bottom:5px;">Motivo (opcional)</label>
                <input type="text" name="motivo" class="ev-input" style="width:100%;background:#1e2133;border:1px solid #444860;color:#e8eaf0;border-radius:8px;padding:8px 12px;box-sizing:border-box;" placeholder="Ex: cliente desistiu, erro de lançamento...">
            </div>
        </div>
        <div class="modal-footer" style="display:flex;justify-content: center">
            <button type="button" class="button btn btn-warning" data-dismiss="modal" aria-hidden="true">
              <span class="button__icon"><i class="bx bx-x"></i></span><span class="button__text2">Voltar</span></button>
            <button class="button btn btn-danger" style="background:#fb923c;border-color:#fb923c;">
              <span class="button__icon"><i class='bx bx-x-circle'></i></span> <span class="button__text2">Confirmar Cancelamento</span></button>
        </div>
    </form>
</div>

<script type="text/javascript">
    $(document).ready(function() {
        $(document).on('click', 'a', function(event) {
            var venda = $(this).attr('venda');
            $('#idVenda').val(venda);
            $('#idVendaCancelar').val(venda);
        });
    });

    // ── Rolagem infinita ─────────────────────────────────────────────
    (function() {
        var tbody = document.getElementById('vd-tbody');
        var loadingEl = document.getElementById('vd-loading');
        var fimEl = document.getElementById('vd-fim');
        var countLabel = document.getElementById('vd-count-label');
        var perPage = <?= (int)($perPage ?? 24) ?>;
        var totalGeral = <?= (int)($statTotalFiltrado ?? 0) ?>;
        var qtdCarregada = <?= (int)count($results ?? []) ?>;
        var carregando = false;
        var acabou = qtdCarregada >= totalGeral;

        var filtros = {
            pesquisa: <?= json_encode($this->input->get('pesquisa') ?? '') ?>,
            status: <?= json_encode($this->input->get('status') ?? '') ?>,
            data: <?= json_encode($this->input->get('data') ?? '') ?>,
            data2: <?= json_encode($this->input->get('data2') ?? '') ?>
        };

        function ultimoIdCarregado() {
            var linhas = tbody.querySelectorAll('tr[data-id]');
            if (!linhas.length) return 0;
            return parseInt(linhas[linhas.length - 1].getAttribute('data-id'), 10) || 0;
        }

        function carregarMais() {
            if (carregando || acabou) return;
            carregando = true;
            loadingEl.style.display = 'flex';

            var params = new URLSearchParams(filtros);
            params.set('antes_de', ultimoIdCarregado());
            var url = '<?= site_url("vendas/carregarMais") ?>?' + params.toString();

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
                        if (countLabel) countLabel.textContent = qtdCarregada + ' de ' + totalGeral + ' vendas carregadas';
                    }
                })
                .catch(function() {})
                .finally(function() {
                    carregando = false;
                    loadingEl.style.display = 'none';
                });
        }

        if (acabou) fimEl.style.display = 'block';

        var sentinel = document.getElementById('vd-sentinel');
        if (sentinel && 'IntersectionObserver' in window) {
            new IntersectionObserver(function(entries) {
                entries.forEach(function(e) { if (e.isIntersecting) carregarMais(); });
            }, { rootMargin: '200px' }).observe(sentinel);
        }
    })();
</script>
