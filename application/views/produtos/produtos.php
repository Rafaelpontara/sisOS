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
                Exibir
                <select onchange="filterTableSize(this.value)">
                    <option>10</option><option>25</option><option>50</option><option>100</option>
                </select>
                registros &nbsp;·&nbsp;
                <span style="color:#e8eaf0;font-weight:600;"><?= count($results) ?> produtos</span>
            </div>
            <div class="tbl-search">
                <input type="text" placeholder="Filtrar tabela..." oninput="filterTable(this.value)">
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
            <tbody>
                <?php if (!$results): ?>
                <tr><td colspan="6" class="tbl-empty"><i class='bx bx-package'></i>Nenhum produto cadastrado</td></tr>
                <?php else: foreach ($results as $r): ?>
                <tr>
                    <td style="color:#6b7280;font-size:12px;"><?= $r->idProdutos ?></td>
                    <td style="font-family:monospace;font-size:12px;color:#9ca3af;"><?= htmlspecialchars($r->codDeBarra) ?></td>
                    <td class="td-name"><?= htmlspecialchars($r->descricao) ?></td>
                    <td>
                        <?php
                        $estq = (int)$r->estoque;
                        $min  = (int)($r->estoqueMinimo ?? 0);
                        $cls  = $estq <= 0 ? 'stock-low' : ($min > 0 && $estq <= $min ? 'stock-warn' : 'stock-ok');
                        ?>
                        <span class="<?= $cls ?>"><?= $estq ?></span>
                    </td>
                    <td style="font-weight:600;color:#e8eaf0;">R$ <?= number_format($r->precoVenda, 2, ',', '.') ?></td>
                    <td>
                        <div class="act-btns">
                            <?php if ($this->permission->checkPermission($this->session->userdata('permissao'), 'vProduto')): ?>
                            <a href="<?= base_url() ?>index.php/produtos/visualizar/<?= $r->idProdutos ?>" class="act-btn act-btn-view" title="Visualizar"><i class='bx bx-show'></i></a>
                            <?php endif; ?>
                            <?php if ($this->permission->checkPermission($this->session->userdata('permissao'), 'eProduto')): ?>
                            <a href="<?= base_url() ?>index.php/produtos/editar/<?= $r->idProdutos ?>" class="act-btn act-btn-edit" title="Editar"><i class='bx bx-edit'></i></a>
                            <?php endif; ?>
                            <?php if ($this->permission->checkPermission($this->session->userdata('permissao'), 'dProduto')): ?>
                            <a href="#modal-excluir" role="button" data-toggle="modal" produto="<?= $r->idProdutos ?>" class="act-btn act-btn-del" title="Excluir"><i class='bx bx-trash-alt'></i></a>
                            <?php endif; ?>
                            <?php if ($this->permission->checkPermission($this->session->userdata('permissao'), 'eProduto')): ?>
                            <a href="#atualizar-estoque" role="button" data-toggle="modal" produto="<?= $r->idProdutos ?>" estoque="<?= $r->estoque ?>" class="act-btn act-btn-stock" title="Atualizar Estoque"><i class='bx bx-plus-circle'></i></a>
                            <?php endif; ?>
                        </div>
                    </td>
                </tr>
                <?php endforeach; endif; ?>
            </tbody>
        </table>
    </div>

    <div style="margin-top:12px;"><?= $this->pagination->create_links() ?></div>
</div>

<!-- Modal Excluir -->
<div id="modal-excluir" class="modal hide fade" tabindex="-1">
    <form action="<?= base_url() ?>index.php/produtos/excluir" method="post">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h5><i class='bx bx-trash' style="color:#f87171;"></i> Excluir Produto</h5>
        </div>
        <div class="modal-body" style="text-align:center;padding:20px;">
            <div style="width:60px;height:60px;background:rgba(239,68,68,0.15);border-radius:50%;display:flex;align-items:center;justify-content:center;margin:0 auto 14px;">
                <i class='bx bx-package' style="font-size:28px;color:#f87171;"></i>
            </div>
            <p style="color:#e8eaf0;font-weight:600;margin-bottom:6px;">Deseja excluir este produto?</p>
            <input type="hidden" id="idProduto" class="idProduto" name="id" value="">
        </div>
        <div class="modal-footer" style="display:flex;justify-content:center;gap:10px;">
            <button type="button" class="button btn btn-warning" data-dismiss="modal"><span class="button__icon"><i class="bx bx-x"></i></span><span class="button__text2">Cancelar</span></button>
            <button type="submit" class="button btn btn-danger"><span class="button__icon"><i class='bx bx-trash'></i></span><span class="button__text2">Excluir</span></button>
        </div>
    </form>
</div>

<!-- Modal Estoque -->
<div id="atualizar-estoque" class="modal hide fade" tabindex="-1">
    <form action="<?= base_url() ?>index.php/produtos/atualizar_estoque" method="post" id="formEstoque">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h5><i class='bx bx-sync' style="color:#fbbf24;"></i> Atualizar Estoque</h5>
        </div>
        <div class="modal-body">
            <div class="control-group">
                <label class="control-label">Estoque Atual</label>
                <div class="controls"><input id="estoqueAtual" type="text" name="estoqueAtual" value="" readonly></div>
            </div>
            <div class="control-group">
                <label class="control-label">Adicionar Quantidade <span class="required">*</span></label>
                <div class="controls">
                    <input type="hidden" id="idProduto2" class="idProduto" name="id" value="">
                    <input id="estoque" type="text" name="estoque" value="" placeholder="Quantidade a adicionar">
                </div>
            </div>
        </div>
        <div class="modal-footer" style="display:flex;justify-content:center;gap:10px;">
            <button type="submit" class="button btn btn-primary"><span class="button__icon"><i class="bx bx-sync"></i></span><span class="button__text2">Atualizar</span></button>
            <button type="button" class="button btn btn-warning" data-dismiss="modal"><span class="button__icon"><i class="bx bx-x"></i></span><span class="button__text2">Cancelar</span></button>
        </div>
    </form>
</div>

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
function filterTableSize(n) {
    var rows = $('#tabela tbody tr'); var i = 0;
    rows.each(function() { i++; $(this).toggle(i <= n); });
}
</script>
