<?php $temaClaro = in_array($configuration['app_theme'] ?? '', ['white','whitegreen','whiteblack']); ?>
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/js/jquery-ui/css/smoothness/jquery-ui-1.9.2.custom.css" />
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/table-custom.css" />
<script src="<?php echo base_url() ?>assets/js/jquery-ui/js/jquery-ui-1.9.2.custom.js"></script>
<script src="<?php echo base_url() ?>assets/js/sweetalert2.all.min.js"></script>
<style>
.pg-header{display:flex;justify-content:space-between;align-items:center;margin-bottom:20px;flex-wrap:wrap;gap:10px;}
.pg-title{font-size:22px;font-weight:800;color:#e8eaf0;display:flex;align-items:center;gap:10px;}
.pg-title i{font-size:24px;color:#a78bfa;}
.pg-actions{display:flex;gap:8px;align-items:center;flex-wrap:wrap;}
.btn-add{display:flex;align-items:center;gap:7px;padding:9px 16px;border-radius:8px;background:linear-gradient(135deg,#22c55e,#16a34a);color:#fff;font-size:13px;font-weight:700;text-decoration:none;border:none;cursor:pointer;box-shadow:0 4px 14px rgba(34,197,94,0.3);transition:transform .15s;}
.btn-add:hover{transform:translateY(-2px);color:#fff;}
.btn-entrega{display:flex;align-items:center;gap:7px;padding:9px 14px;border-radius:8px;background:rgba(96,165,250,0.15);color:#60a5fa;font-size:13px;font-weight:700;text-decoration:none;border:1px solid rgba(96,165,250,0.25);transition:all .15s;}
.btn-entrega:hover{background:rgba(96,165,250,0.25);color:#60a5fa;}

/* Estatísticas */
.os-stats{display:grid;grid-template-columns:repeat(auto-fit,minmax(200px,1fr));gap:12px;margin-bottom:16px;}
.os-stat{background:#1a1d2e;border:1px solid rgba(255,255,255,0.07);border-radius:14px;padding:16px 18px;display:flex;align-items:center;gap:14px;transition:transform .15s;}
.os-stat:hover{transform:translateY(-2px);}
.os-stat-icon{width:44px;height:44px;border-radius:12px;display:flex;align-items:center;justify-content:center;font-size:20px;flex-shrink:0;}
.os-stat-val{font-size:20px;font-weight:800;color:#e8eaf0;line-height:1;}
.os-stat-label{font-size:10.5px;font-weight:700;color:#6b7280;text-transform:uppercase;letter-spacing:.6px;margin-top:3px;}

.filter-bar{display:flex;gap:6px;align-items:center;flex-wrap:wrap;margin-bottom:14px;padding:12px 16px;background:#1a1d2e;border:1px solid rgba(255,255,255,0.07);border-radius:14px;}
.filter-bar input,.filter-bar select{padding:8px 10px;border-radius:7px;border:1px solid #444860;background:#252a3a;color:#e8eaf0;font-size:13px;}
.filter-bar input:focus,.filter-bar select:focus{outline:none;border-color:#a78bfa;}
.btn-filter{padding:8px 18px;border-radius:7px;background:#a78bfa;border:none;color:#111;font-size:13px;font-weight:700;cursor:pointer;transition:background .15s;}
.btn-filter:hover{background:#8b5cf6;}

.tbl-toolbar{display:flex;align-items:center;justify-content:space-between;padding:10px 4px;margin-bottom:12px;flex-wrap:wrap;gap:8px;}
.tbl-tl{font-size:12px;color:#6b7280;}
.tbl-ts input{background:#1e2235;border:1px solid #444860;color:#e8eaf0;padding:7px 12px;border-radius:7px;font-size:12px;width:200px;}
.tbl-ts input:focus{outline:none;border-color:#a78bfa;}

/* Grade de OS */
.os-grid{display:grid;grid-template-columns:repeat(auto-fill,minmax(290px,1fr));gap:14px;}
.os-card{background:#1a1d2e;border:1px solid rgba(255,255,255,0.07);border-radius:14px;padding:16px;display:flex;flex-direction:column;gap:9px;transition:transform .15s,border-color .15s,box-shadow .15s;position:relative;overflow:hidden;}
.os-card::before{content:'';position:absolute;top:0;left:0;right:0;height:3px;background:linear-gradient(90deg,#a78bfa,#7c3aed);opacity:0;transition:opacity .15s;}
.os-card:hover{transform:translateY(-3px);border-color:rgba(167,139,250,0.3);box-shadow:0 10px 24px rgba(0,0,0,0.25);}
.os-card:hover::before{opacity:1;}

.os-card-top{display:flex;align-items:center;justify-content:space-between;}
.os-num{font-size:12px;color:#6b7280;font-weight:700;}
.os-cliente{color:#e8eaf0;font-weight:700;font-size:15px;text-decoration:none;}
.os-cliente:hover{color:#a78bfa;}
.os-tecnico{color:#9ca3af;font-size:12px;display:flex;align-items:center;gap:6px;}
.os-tecnico i{font-size:13px;}

.os-row{display:flex;align-items:center;justify-content:space-between;font-size:12px;padding:8px 0;border-top:1px solid rgba(255,255,255,0.06);}
.os-row-label{color:#6b7280;font-size:10.5px;font-weight:700;text-transform:uppercase;letter-spacing:.3px;display:block;}
.os-row-val{font-size:12.5px;font-weight:600;}

.os-financeiro{display:flex;align-items:center;justify-content:space-between;padding:8px 0;border-top:1px solid rgba(255,255,255,0.06);}
.os-total{font-size:16px;font-weight:800;color:#e8eaf0;}
.os-desconto{font-size:11px;color:#f87171;margin-left:6px;}

.os-card-footer{display:flex;align-items:center;gap:5px;margin-top:auto;padding-top:8px;border-top:1px solid rgba(255,255,255,0.06);}
.act-btn{width:30px;height:30px;border-radius:7px;display:inline-flex;align-items:center;justify-content:center;font-size:14px;text-decoration:none;transition:background .15s,transform .12s;border:none;cursor:pointer;}
.act-btn:hover{transform:scale(1.1);}
.ab-v{background:rgba(96,165,250,0.15);color:#60a5fa;}.ab-v:hover{background:rgba(96,165,250,0.3);color:#60a5fa;}
.ab-p{background:rgba(167,139,250,0.15);color:#a78bfa;}.ab-p:hover{background:rgba(167,139,250,0.3);color:#a78bfa;}
.ab-t{background:rgba(6,182,212,0.15);color:#22d3ee;}.ab-t:hover{background:rgba(6,182,212,0.3);color:#22d3ee;}
.ab-e{background:rgba(34,197,94,0.15);color:#4ade80;}.ab-e:hover{background:rgba(34,197,94,0.3);color:#4ade80;}
.ab-d{background:rgba(239,68,68,0.15);color:#f87171;}.ab-d:hover{background:rgba(239,68,68,0.3);color:#f87171;}

.sp{padding:3px 9px;border-radius:20px;font-size:10.5px;font-weight:700;display:inline-block;}
.sp-ab{background:rgba(96,165,250,0.15);color:#60a5fa;}
.sp-fi{background:rgba(34,197,94,0.15);color:#4ade80;}
.sp-fat{background:rgba(6,182,212,0.15);color:#22d3ee;}
.sp-ca{background:rgba(239,68,68,0.15);color:#f87171;}
.sp-or{background:rgba(245,158,11,0.15);color:#fbbf24;}
.sp-an{background:rgba(167,139,250,0.15);color:#a78bfa;}
.sp-ot{background:rgba(255,255,255,0.08);color:#9ca3af;}

.os-empty{grid-column:1/-1;text-align:center;padding:60px 20px;color:#6b7280;}
.os-empty i{font-size:44px;display:block;margin-bottom:10px;opacity:.3;}

.tbl-wrap{background:#1a1d2e;border:1px solid rgba(255,255,255,0.07);border-radius:14px;overflow:hidden;margin-bottom:14px;}
.tbl-wrap table{width:100%;border-collapse:collapse;}
.tbl-wrap thead th{background:#252a3a;color:#9ca3af;font-size:11px;font-weight:700;text-transform:uppercase;letter-spacing:.5px;padding:11px 12px;border-bottom:1px solid rgba(255,255,255,0.07);white-space:nowrap;}
.tbl-wrap tbody tr{border-bottom:1px solid rgba(255,255,255,0.04);transition:background .12s;}
.tbl-wrap tbody tr:hover{background:rgba(167,139,250,0.04);}
.tbl-wrap tbody td{padding:10px 12px;font-size:13px;color:#c9cad6;vertical-align:middle;}
</style>
<?php if ($temaClaro): ?>
<style>
/* ── Tema claro: sobrescreve a listagem de OS (paleta escura fixa) ── */
.pg-title{color:#1f2937;}
.os-stat{background:#ffffff;border-color:rgba(0,0,0,0.08);}
.os-stat-val{color:#1f2937;}
.filter-bar{background:#ffffff;border-color:rgba(0,0,0,0.08);}
.filter-bar input,.filter-bar select{background:#f9fafb;border-color:#d1d5db;color:#1f2937;}
.tbl-tl span{color:#1f2937 !important;}
.tbl-ts input{background:#f9fafb;border-color:#d1d5db;color:#1f2937;}
.os-card{background:#ffffff;border-color:rgba(0,0,0,0.08);}
.os-card:hover{box-shadow:0 10px 24px rgba(0,0,0,0.08);}
.os-cliente{color:#1f2937;}
.os-num{color:#9ca3af;}
.os-tecnico{color:#6b7280;}
.os-row{border-top-color:rgba(0,0,0,0.06);}
.os-row-label{color:#9ca3af;}
.os-financeiro{border-top-color:rgba(0,0,0,0.06);}
.os-total{color:#1f2937;}
.os-card-footer{border-top-color:rgba(0,0,0,0.06);}
.os-empty{color:#9ca3af;}
.tbl-wrap{background:#ffffff;border-color:rgba(0,0,0,0.08);}
.tbl-wrap thead th{background:#f3f4f6;color:#6b7280;border-bottom-color:rgba(0,0,0,0.08);}
.tbl-wrap tbody tr{border-bottom-color:rgba(0,0,0,0.05);}
.tbl-wrap tbody tr:hover{background:rgba(0,0,0,0.02);}
.tbl-wrap tbody td{color:#374151;}
.os-view-toggle{background:#ffffff;border-color:rgba(0,0,0,0.08);}
</style>
<?php endif; ?>


<div class="new122">
    <div class="pg-header">
        <div class="pg-title"><i class='bx bx-file-blank'></i> Ordens de Serviço</div>
        <div class="pg-actions">
            <?php if ($this->permission->checkPermission($this->session->userdata('permissao'), 'aOs')): ?>
            <a href="<?= base_url() ?>index.php/os/adicionar" class="btn-add"><i class='bx bx-plus-circle'></i> Nova OS</a>
            <?php endif; ?>
            <a href="<?= site_url('os/gerenciar?entrega_hoje=1') ?>" class="btn-entrega"><i class='bx bx-calendar-check'></i> Entregas Hoje</a>
            <div class="os-view-toggle">
                <button type="button" class="ovt-btn <?= $visualizacaoAtual === 'grade' ? 'ativo' : '' ?>" onclick="osTrocarVisualizacao('grade')" title="Ver em grade"><i class='bx bx-grid-alt'></i></button>
                <button type="button" class="ovt-btn <?= $visualizacaoAtual === 'lista' ? 'ativo' : '' ?>" onclick="osTrocarVisualizacao('lista')" title="Ver em lista"><i class='bx bx-list-ul'></i></button>
            </div>
        </div>
    </div>

    <style>
    .os-view-toggle{display:flex;background:#1a1d2e;border:1px solid rgba(255,255,255,0.08);border-radius:9px;padding:3px;gap:2px;}
    .ovt-btn{width:34px;height:32px;border:none;background:transparent;color:#6b7280;border-radius:6px;cursor:pointer;font-size:16px;display:flex;align-items:center;justify-content:center;transition:all .15s;}
    .ovt-btn.ativo{background:rgba(167,139,250,0.15);color:#a78bfa;}
    </style>
    <script>
    function osTrocarVisualizacao(modo) {
        var params = new URLSearchParams(window.location.search);
        params.set('visualizacao', modo);
        window.location.href = '<?= site_url('os/gerenciar') ?>?' + params.toString();
    }
    </script>
    <!-- Estatísticas -->
    <div class="os-stats">
        <div class="os-stat">
            <div class="os-stat-icon" style="background:rgba(167,139,250,0.15);"><i class='bx bx-file-blank' style="color:#a78bfa;"></i></div>
            <div><div class="os-stat-val"><?= (int)($statTotalOs ?? 0) ?></div><div class="os-stat-label">Total de OS</div></div>
        </div>
        <div class="os-stat">
            <div class="os-stat-icon" style="background:rgba(96,165,250,0.15);"><i class='bx bx-time' style="color:#60a5fa;"></i></div>
            <div><div class="os-stat-val"><?= (int)($statEmAberto ?? 0) ?></div><div class="os-stat-label">Em Aberto</div></div>
        </div>
        <div class="os-stat">
            <a href="<?= site_url('os/gerenciar') ?>?vencidas=1" style="text-decoration:none;display:flex;align-items:center;gap:14px;width:100%;">
                <div class="os-stat-icon" style="background:rgba(239,68,68,0.15);"><i class='bx bx-time-five' style="color:#f87171;"></i></div>
                <div><div class="os-stat-val"><?= (int)($statVencidas ?? 0) ?></div><div class="os-stat-label">Vencidas</div></div>
            </a>
        </div>
    </div>

    <!-- Filtros -->
    <form method="get" action="<?= base_url() ?>index.php/os/gerenciar" class="filter-bar">
        <input type="text" name="pesquisa" placeholder="Cliente ou Nº OS..." value="<?= htmlspecialchars($this->input->get('pesquisa') ?? '') ?>" style="width:180px;">
        <select name="status">
            <option value="">Todos os Status</option>
            <?php foreach(["Aberto","Orçamento","Negociação","Aprovado","Aguardando Peças","Em Andamento","Aguardando Autorização","Em Teste","Finalizado","Faturado","Sem Conserto","Não foi Possível","Não temos Peças","Recusado","Cancelado"] as $s): ?>
            <option value="<?=$s?>" <?=$this->input->get('status')==$s?'selected':''?>><?=$s?></option>
            <?php endforeach; ?>
        </select>
        <input type="text" name="data" autocomplete="off" class="datepicker" placeholder="Data inicial" value="<?= $this->input->get('data') ?>" style="width:130px;">
        <input type="text" name="data2" autocomplete="off" class="datepicker" placeholder="Data final" value="<?= $this->input->get('data2') ?>" style="width:130px;">
        <select name="entregue">
            <option value="">Entregue: Todos</option>
            <option value="1" <?= $this->input->get('entregue')==='1'?'selected':'' ?>>Entregue: Sim</option>
            <option value="0" <?= $this->input->get('entregue')==='0'?'selected':'' ?>>Entregue: Não</option>
        </select>
        <button type="submit" class="btn-filter"><i class='bx bx-filter-alt'></i> Filtrar</button>
    </form>

    <?php if ($visualizacaoAtual === 'lista'): ?>
    <!-- ── Visualização em Lista (tabela + rolagem infinita) ── -->
    <div class="tbl-toolbar">
        <div class="tbl-tl"><span id="os-count-label-lista" style="color:#e8eaf0;font-weight:600;"><?= isset($results) ? count($results) : 0 ?> de <?= (int)($configuration['total_rows'] ?? 0) ?> OS carregadas</span></div>
        <div class="tbl-ts"><input type="text" placeholder="Filtrar o que já carregou..." oninput="ftLista(this.value)"></div>
    </div>
    <div class="tbl-wrap">
        <table id="tabelaLista" class="table">
            <thead>
                <tr>
                    <th>#</th><th>Cliente</th><th>Técnico</th><th>Data</th>
                    <th>Venc. Garantia</th><th>Total</th><th>Desconto</th>
                    <th>C/ Desconto</th><th>Faturado</th><th>Entregue</th><th>Status</th><th>Ações</th>
                </tr>
            </thead>
            <tbody id="os-lista-tbody">
                <?php echo $this->load->view('os/_table_rows_partial', ['results' => $results ?? []], true); ?>
            </tbody>
        </table>
    </div>
    <div id="os-sentinel-lista" style="display:flex;justify-content:center;padding:24px 0;">
        <div id="os-loading-lista" style="display:none;align-items:center;gap:8px;color:#9ca3af;font-size:13px;">
            <i class='bx bx-loader-alt bx-spin'></i> Carregando mais OS...
        </div>
        <div id="os-fim-lista" style="display:none;color:#6b7280;font-size:12px;">
            Isso é tudo — não há mais OS para carregar com esses filtros.
        </div>
    </div>
    <script>
    function ftLista(q) {
        q = q.toLowerCase();
        document.querySelectorAll('#tabelaLista tbody tr').forEach(function(tr) {
            tr.style.display = tr.textContent.toLowerCase().indexOf(q) > -1 ? '' : 'none';
        });
    }

    (function() {
        var tbody = document.getElementById('os-lista-tbody');
        var loadingEl = document.getElementById('os-loading-lista');
        var fimEl = document.getElementById('os-fim-lista');
        var countLabel = document.getElementById('os-count-label-lista');
        var perPage = 24;
        var totalGeral = <?= (int)($configuration['total_rows'] ?? 0) ?>;
        var qtdCarregada = <?= (int)count($results ?? []) ?>;
        var carregando = false;
        var acabou = qtdCarregada >= totalGeral;

        var filtros = {
            pesquisa: <?= json_encode($this->input->get('pesquisa') ?? '') ?>,
            status: <?= json_encode($this->input->get('status') ?? '') ?>,
            data: <?= json_encode($this->input->get('data') ?? '') ?>,
            data2: <?= json_encode($this->input->get('data2') ?? '') ?>,
            numero_os: <?= json_encode($this->input->get('numero_os') ?? '') ?>,
            entregue: <?= json_encode($this->input->get('entregue') ?? '') ?>,
            entrega_hoje: <?= json_encode($this->input->get('entrega_hoje') ?? '') ?>,
            vencidas: <?= json_encode($this->input->get('vencidas') ?? '') ?>,
            modo: 'lista'
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
            var url = '<?= site_url("os/carregarMais") ?>?' + params.toString();

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
                        if (countLabel) countLabel.textContent = qtdCarregada + ' de ' + totalGeral + ' OS carregadas';
                    }
                })
                .catch(function() {})
                .finally(function() {
                    carregando = false;
                    loadingEl.style.display = 'none';
                });
        }

        if (acabou) fimEl.style.display = 'block';

        var sentinel = document.getElementById('os-sentinel-lista');
        if (sentinel && 'IntersectionObserver' in window) {
            new IntersectionObserver(function(entries) {
                entries.forEach(function(e) { if (e.isIntersecting) carregarMais(); });
            }, { rootMargin: '200px' }).observe(sentinel);
        }
    })();
    </script>

    <?php else: ?>
    <!-- ── Visualização em Grade (cards + rolagem infinita) ── -->
    <div class="tbl-toolbar">
        <div class="tbl-tl"><span id="os-count-label" style="color:#e8eaf0;font-weight:600;"><?= isset($results) ? count($results) : 0 ?> de <?= (int)($configuration['total_rows'] ?? 0) ?> OS carregadas</span></div>
        <div class="tbl-ts"><input type="text" placeholder="Filtrar o que já carregou..." oninput="filterCards(this.value)"></div>
    </div>

    <!-- Grade de OS -->
    <div class="os-grid" id="os-grid">
        <?php echo $this->load->view('os/_cards_partial', ['results' => $results ?? []], true); ?>

        <div id="os-sentinel" style="grid-column:1/-1;display:flex;justify-content:center;padding:24px 0;">
            <div id="os-loading" style="display:none;align-items:center;gap:8px;color:#9ca3af;font-size:13px;">
                <i class='bx bx-loader-alt bx-spin'></i> Carregando mais OS...
            </div>
            <div id="os-fim" style="display:none;color:#6b7280;font-size:12px;">
                Isso é tudo — não há mais OS para carregar com esses filtros.
            </div>
        </div>
    </div>
    <?php endif; ?>
</div>

<!-- Modal Excluir -->
<div id="modal-excluir" class="modal hide fade" tabindex="-1">
    <form action="<?= base_url() ?>index.php/os/excluir" method="post">
        <div class="oxm-wrap">
            <button type="button" class="oxm-close" data-dismiss="modal" aria-label="Fechar"><i class='bx bx-x'></i></button>

            <div class="oxm-icon-circle">
                <i class='bx bx-trash'></i>
            </div>

            <h5 class="oxm-title">Excluir Ordem de Serviço</h5>
            <p class="oxm-question">Tem certeza que deseja excluir esta OS?</p>
            <p class="oxm-hint"><i class='bx bx-error-circle'></i> Essa ação não pode ser desfeita.</p>

            <input type="hidden" id="idOS" name="id" value="">

            <div class="oxm-actions">
                <button type="button" class="oxm-btn oxm-btn-cancel" data-dismiss="modal">
                    <i class='bx bx-x'></i> Cancelar
                </button>
                <button type="submit" class="oxm-btn oxm-btn-danger">
                    <i class='bx bx-trash'></i> Excluir OS
                </button>
            </div>
        </div>
    </form>
</div>

<style>
/* Modal "Excluir OS" — redesenhado, escopado só a #modal-excluir para não
   afetar nenhum outro modal do sistema (que continuam usando .modal-header/
   .modal-body/.modal-footer/.close/.btn-warning/.btn-danger normalmente). */
#modal-excluir{
    background: transparent !important;
    border: none !important;
    box-shadow: none !important;
    padding: 0 !important;
}
#modal-excluir .oxm-wrap{
    max-width: 380px;
    margin: 0 auto;
    background: linear-gradient(180deg, #171922 0%, #12141c 100%);
    border: 1px solid rgba(255,255,255,0.08);
    border-radius: 18px;
    box-shadow: 0 24px 60px rgba(0,0,0,0.55), 0 2px 8px rgba(0,0,0,0.3);
    padding: 30px 26px 24px;
    text-align: center;
    position: relative;
}
#modal-excluir .oxm-close{
    position: absolute; top: 14px; right: 14px;
    width: 30px; height: 30px; border-radius: 8px;
    border: none; background: rgba(255,255,255,0.05);
    color: #8a90a2; font-size: 18px;
    display: flex; align-items: center; justify-content: center;
    cursor: pointer; transition: all .15s;
}
#modal-excluir .oxm-close:hover{ background: rgba(255,255,255,0.1); color:#e8eaf0; }
#modal-excluir .oxm-icon-circle{
    width: 68px; height: 68px; margin: 0 auto 18px;
    border-radius: 50%;
    background: radial-gradient(circle, rgba(248,113,113,0.18) 0%, rgba(248,113,113,0.06) 100%);
    border: 1px solid rgba(248,113,113,0.25);
    display: flex; align-items: center; justify-content: center;
}
#modal-excluir .oxm-icon-circle i{ font-size: 30px; color:#f87171; }
#modal-excluir .oxm-title{
    font-size: 16.5px; font-weight: 800; color:#e8eaf0; margin: 0 0 8px;
}
#modal-excluir .oxm-question{
    font-size: 13.5px; color:#c9cad6; margin: 0 0 6px; line-height: 1.5;
}
#modal-excluir .oxm-hint{
    display: flex; align-items: center; justify-content: center; gap: 5px;
    font-size: 11.5px; color:#f59e0b; margin: 0 0 22px;
}
#modal-excluir .oxm-actions{
    display: flex; gap: 10px;
}
#modal-excluir .oxm-btn{
    flex: 1; display: flex; align-items: center; justify-content: center; gap: 6px;
    padding: 11px 14px; border-radius: 10px; border: 1px solid transparent;
    font-size: 13px; font-weight: 700; cursor: pointer; transition: all .15s;
}
#modal-excluir .oxm-btn-cancel{
    background: rgba(255,255,255,0.05); color:#c9cad6; border-color: rgba(255,255,255,0.08);
}
#modal-excluir .oxm-btn-cancel:hover{ background: rgba(255,255,255,0.09); color:#e8eaf0; }
#modal-excluir .oxm-btn-danger{
    background: linear-gradient(135deg, #f87171 0%, #ef4444 100%);
    color: #fff; box-shadow: 0 6px 16px rgba(239,68,68,0.3);
}
#modal-excluir .oxm-btn-danger:hover{ filter: brightness(1.08); box-shadow: 0 8px 20px rgba(239,68,68,0.4); }
</style>

<script>
$(document).ready(function(){
    $(document).on("click","a[os]",function(){$("#idOS").val($(this).attr("os"));});
});

function filterCards(q) {
    q = q.toLowerCase();
    document.querySelectorAll('#os-grid .os-card').forEach(function(card) {
        var alvo = card.getAttribute('data-search') || '';
        card.style.display = alvo.indexOf(q) > -1 ? '' : 'none';
    });
}

// ── Rolagem infinita (paginação por cursor — mais rápida em bases grandes) ──
(function() {
    var grid = document.getElementById('os-grid');
    var loadingEl = document.getElementById('os-loading');
    var fimEl = document.getElementById('os-fim');
    var countLabel = document.getElementById('os-count-label');
    var perPage = 24;
    var totalGeral = <?= (int)($configuration['total_rows'] ?? 0) ?>;
    var qtdCarregada = <?= (int)count($results ?? []) ?>;
    var carregando = false;
    var acabou = qtdCarregada >= totalGeral;

    // Mesmos filtros da URL atual, repassados pra cada chamada de "carregar mais"
    var filtros = {
        pesquisa: <?= json_encode($this->input->get('pesquisa') ?? '') ?>,
        status: <?= json_encode($this->input->get('status') ?? '') ?>,
        data: <?= json_encode($this->input->get('data') ?? '') ?>,
        data2: <?= json_encode($this->input->get('data2') ?? '') ?>,
        numero_os: <?= json_encode($this->input->get('numero_os') ?? '') ?>,
        entregue: <?= json_encode($this->input->get('entregue') ?? '') ?>,
        entrega_hoje: <?= json_encode($this->input->get('entrega_hoje') ?? '') ?>,
        vencidas: <?= json_encode($this->input->get('vencidas') ?? '') ?>
    };

    function ultimoIdCarregado() {
        var cards = grid.querySelectorAll('.os-card');
        if (!cards.length) return 0;
        return parseInt(cards[cards.length - 1].getAttribute('data-id'), 10) || 0;
    }

    function atualizarContador() {
        var qtd = document.querySelectorAll('#os-grid .os-card').length;
        if (countLabel) countLabel.textContent = qtd + ' de ' + totalGeral + ' OS carregadas';
    }

    function carregarMais() {
        if (carregando || acabou) return;
        carregando = true;
        loadingEl.style.display = 'flex';

        var params = new URLSearchParams(filtros);
        params.set('antes_de', ultimoIdCarregado());
        var url = '<?= site_url("os/carregarMais") ?>?' + params.toString();

        fetch(url)
            .then(function(res) { return res.text(); })
            .then(function(html) {
                if (html.trim() === '') {
                    acabou = true;
                    fimEl.style.display = 'block';
                } else {
                    var temp = document.createElement('div');
                    temp.innerHTML = html;
                    var novosCards = temp.querySelectorAll('.os-card');
                    novosCards.forEach(function(card) { grid.insertBefore(card, document.getElementById('os-sentinel')); });
                    qtdCarregada += novosCards.length;
                    if (novosCards.length < perPage) {
                        acabou = true;
                        fimEl.style.display = 'block';
                    }
                    atualizarContador();
                }
            })
            .catch(function() {})
            .finally(function() {
                carregando = false;
                loadingEl.style.display = 'none';

            });
    }

    if (acabou) { fimEl.style.display = 'block'; }

    var sentinel = document.getElementById('os-sentinel');
    if (sentinel && 'IntersectionObserver' in window) {
        var observer = new IntersectionObserver(function(entries) {
            entries.forEach(function(entry) { if (entry.isIntersecting) carregarMais(); });
        }, { rootMargin: '200px' });
        observer.observe(sentinel);
    }
})();
</script>
