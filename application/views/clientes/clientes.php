<style>
.pg-header { display:flex; justify-content:space-between; align-items:center; margin-bottom:20px; }
.pg-title { font-size:22px; font-weight:800; color:#e8eaf0; display:flex; align-items:center; gap:10px; }
.pg-title i { font-size:24px; color:#60a5fa; }
.pg-actions { display:flex; gap:10px; align-items:center; }

/* Search bar */
.search-bar { display:flex; gap:0; }
.search-bar input {
    padding:9px 14px; border-radius:8px 0 0 8px;
    border:1px solid #444860; border-right:none;
    background:#1e2133; color:#e8eaf0; font-size:13px; width:280px;
}
.search-bar input:focus { outline:none; border-color:#60a5fa; }
.search-bar button {
    padding:9px 14px; border-radius:0 8px 8px 0;
    background:#60a5fa; border:none; color:#fff; cursor:pointer;
    font-size:15px; transition:background .15s;
}
.search-bar button:hover { background:#3b82f6; }

/* Add button */
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

/* Table */
.tbl-wrap { background:#1a1d2e; border:1px solid rgba(255,255,255,0.07); border-radius:14px; overflow:hidden; }

.tbl-toolbar { display:flex; align-items:center; justify-content:space-between; padding:12px 16px; border-bottom:1px solid rgba(255,255,255,0.06); }
.tbl-toolbar-left { font-size:12px; color:#6b7280; display:flex; align-items:center; gap:8px; }
.tbl-toolbar-left select { background:#252a3a; border:1px solid #444860; color:#e8eaf0; padding:4px 8px; border-radius:6px; font-size:12px; }
.tbl-search input { background:#252a3a; border:1px solid #444860; color:#e8eaf0; padding:6px 10px; border-radius:6px; font-size:12px; width:180px; }
.tbl-search input:focus { outline:none; border-color:#60a5fa; }

.tbl-wrap table { width:100%; border-collapse:collapse; }
.tbl-wrap thead th {
    background:#252a3a; color:#9ca3af; font-size:11px; font-weight:700;
    text-transform:uppercase; letter-spacing:.6px;
    padding:11px 14px; border-bottom:1px solid rgba(255,255,255,0.07);
    white-space:nowrap;
}
.tbl-wrap tbody tr { border-bottom:1px solid rgba(255,255,255,0.04); transition:background .12s; }
.tbl-wrap tbody tr:last-child { border-bottom:none; }
.tbl-wrap tbody tr:hover { background:rgba(96,165,250,0.05); }
.tbl-wrap tbody td { padding:11px 14px; font-size:13px; color:#c9cad6; vertical-align:middle; }

.td-name a { color:#e8eaf0; font-weight:600; text-decoration:none; }
.td-name a:hover { color:#60a5fa; }

.badge-cliente   { background:rgba(34,197,94,0.15); color:#4ade80; border:1px solid rgba(34,197,94,0.25); padding:3px 10px; border-radius:20px; font-size:11px; font-weight:700; }
.badge-fornecedor{ background:rgba(99,102,241,0.15); color:#a78bfa; border:1px solid rgba(99,102,241,0.25); padding:3px 10px; border-radius:20px; font-size:11px; font-weight:700; }
.badge-bloqueado { background:rgba(239,68,68,0.15); color:#f87171; border:1px solid rgba(239,68,68,0.25); padding:2px 7px; border-radius:20px; font-size:10px; font-weight:700; margin-left:6px; }

/* Action buttons */
.act-btns { display:flex; gap:5px; align-items:center; }
.act-btn {
    width:30px; height:30px; border-radius:7px; display:inline-flex;
    align-items:center; justify-content:center; font-size:15px;
    text-decoration:none; transition:background .15s, transform .12s; border:none; cursor:pointer;
}
.act-btn:hover { transform:scale(1.1); }
.act-btn-view  { background:rgba(96,165,250,0.15); color:#60a5fa; }
.act-btn-view:hover { background:rgba(96,165,250,0.3); color:#60a5fa; }
.act-btn-key   { background:rgba(251,191,36,0.15); color:#fbbf24; }
.act-btn-key:hover { background:rgba(251,191,36,0.3); color:#fbbf24; }
.act-btn-lock  { background:rgba(167,139,250,0.15); color:#a78bfa; }
.act-btn-lock:hover { background:rgba(167,139,250,0.3); color:#a78bfa; }
.act-btn-edit  { background:rgba(34,197,94,0.15); color:#4ade80; }
.act-btn-edit:hover { background:rgba(34,197,94,0.3); color:#4ade80; }
.act-btn-del   { background:rgba(239,68,68,0.15); color:#f87171; }
.act-btn-del:hover { background:rgba(239,68,68,0.3); color:#f87171; }

.tbl-empty { text-align:center; padding:40px; color:#6b7280; }
.tbl-empty i { font-size:40px; display:block; margin-bottom:8px; opacity:.3; }
/* Hide DataTables default controls */
#tabela_length, .dataTables_length { display:none !important; }
#tabela_info, .dataTables_info { display:none !important; }
#tabela_filter, .dataTables_filter { display:none !important; }
.dataTables_paginate { display:none !important; }
</style>

<div class="new122">

    <!-- Header -->
    <div class="pg-header">
        <div class="pg-title">
            <i class='bx bx-group'></i>
            Clientes
        </div>
        <div class="pg-actions">
            <?php if ($this->permission->checkPermission($this->session->userdata('permissao'), 'aCliente')): ?>
            <a href="<?= base_url() ?>index.php/clientes/adicionar" class="btn-add">
                <i class='bx bx-user-plus'></i> Novo Cliente
            </a>
            <?php endif; ?>
            <form method="get" action="<?= base_url() ?>index.php/clientes" class="search-bar">
                <input type="text" name="pesquisa" placeholder="Buscar nome, doc, email..." value="<?= $this->input->get('pesquisa') ?>">
                <button type="submit"><i class='bx bx-search'></i></button>
            </form>
        </div>
    </div>

    <!-- Table -->
    <div class="tbl-wrap">
        <div class="tbl-toolbar">
            <div class="tbl-toolbar-left">
                Exibir
                <select id="tbl-size" onchange="$('#tabela').DataTable().page.len(this.value).draw()">
                    <option value="10">10</option>
                    <option value="25">25</option>
                    <option value="50">50</option>
                    <option value="100">100</option>
                </select>
                registros
                &nbsp;·&nbsp;
                <span id="tbl-count" style="color:#e8eaf0;font-weight:600;">
                    <?= count($results) ?> clientes
                </span>
            </div>
            <div class="tbl-search">
                <input type="text" id="tbl-filter" placeholder="Filtrar tabela..." oninput="filterTable(this.value)">
            </div>
        </div>

        <table id="tabela" class="table">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Nome</th>
                    <th>Contato</th>
                    <th>CPF/CNPJ</th>
                    <th>Telefone</th>
                    <th>Celular</th>
                    <th>Email</th>
                    <th>Tipo</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!$results): ?>
                <tr><td colspan="9" class="tbl-empty">
                    <i class='bx bx-user-x'></i>
                    Nenhum cliente cadastrado
                </td></tr>
                <?php else: foreach ($results as $r): ?>
                <tr>
                    <td style="color:#6b7280;font-size:12px;"><?= $r->idClientes ?></td>
                    <td class="td-name">
                        <a href="<?= base_url() ?>index.php/clientes/visualizar/<?= $r->idClientes ?>">
                            <?= htmlspecialchars($r->nomeCliente) ?>
                        </a>
                        <?php if (!empty($r->bloqueado)): ?>
                        <span class="badge-bloqueado">BLOQUEADO</span>
                        <?php endif; ?>
                    </td>
                    <td><?= htmlspecialchars($r->contato) ?></td>
                    <td style="font-family:monospace;font-size:12px;"><?= htmlspecialchars($r->documento) ?></td>
                    <td><?= htmlspecialchars($r->telefone) ?></td>
                    <td><?= htmlspecialchars($r->celular) ?></td>
                    <td style="max-width:160px;overflow:hidden;text-overflow:ellipsis;white-space:nowrap;"><?= htmlspecialchars($r->email) ?></td>
                    <td>
                        <?php if ($r->fornecedor == 1): ?>
                        <span class="badge-fornecedor">Fornecedor</span>
                        <?php else: ?>
                        <span class="badge-cliente">Cliente</span>
                        <?php endif; ?>
                    </td>
                    <td>
                        <div class="act-btns">
                        <?php if ($this->permission->checkPermission($this->session->userdata('permissao'), 'vCliente')): ?>
                            <a href="<?= base_url() ?>index.php/clientes/visualizar/<?= $r->idClientes ?>" class="act-btn act-btn-view" title="Visualizar"><i class='bx bx-show'></i></a>
                            <a href="<?= base_url() ?>index.php/mine?e=<?= $r->email ?>" target="_blank" class="act-btn act-btn-key" title="Área do Cliente"><i class='bx bx-key'></i></a>
                            <a href="#" data-id="<?= $r->idClientes ?>" data-bloqueado="<?= !empty($r->bloqueado) ? 1 : 0 ?>"
                               class="act-btn act-btn-lock btn-bloquear"
                               title="<?= !empty($r->bloqueado) ? 'Desbloquear' : 'Bloquear' ?>">
                               <i class='bx <?= !empty($r->bloqueado) ? 'bx-lock-open' : 'bx-lock' ?>'></i>
                            </a>
                        <?php endif; ?>
                        <?php if ($this->permission->checkPermission($this->session->userdata('permissao'), 'eCliente')): ?>
                            <a href="<?= base_url() ?>index.php/clientes/editar/<?= $r->idClientes ?>" class="act-btn act-btn-edit" title="Editar"><i class='bx bx-edit'></i></a>
                        <?php endif; ?>
                        <?php if ($this->permission->checkPermission($this->session->userdata('permissao'), 'dCliente')): ?>
                            <a href="#modal-excluir" role="button" data-toggle="modal" cliente="<?= $r->idClientes ?>" class="act-btn act-btn-del" title="Excluir"><i class='bx bx-trash-alt'></i></a>
                        <?php endif; ?>
                        </div>
                    </td>
                </tr>
                <?php endforeach; endif; ?>
            </tbody>
        </table>
    </div>

    <!-- Paginação -->
    <div style="margin-top:12px;">
        <?php echo $this->pagination->create_links(); ?>
    </div>

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

// Quick filter
function filterTable(q) {
    q = q.toLowerCase();
    $('#tabela tbody tr').each(function() {
        $(this).toggle($(this).text().toLowerCase().indexOf(q) > -1);
    });
}

// Block/unblock
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
