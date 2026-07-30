<style>
.ped-wrap{max-width:1400px;}
.ped-header{display:flex;justify-content:space-between;align-items:flex-start;margin-bottom:20px;flex-wrap:wrap;gap:14px;}
.ped-title-row{display:flex;align-items:center;gap:14px;}
.ped-icon-badge{width:46px;height:46px;border-radius:13px;background:rgba(167,139,250,0.15);display:flex;align-items:center;justify-content:center;font-size:22px;color:#a78bfa;flex-shrink:0;}
.ped-title{font-size:21px;font-weight:800;color:#e8eaf0;}
.ped-subtitle{font-size:12.5px;color:#6b7280;margin-top:2px;}
.ped-tools{display:flex;gap:10px;flex-wrap:wrap;}
.ped-search{display:flex;gap:0;}
.ped-search input{padding:9px 14px;border-radius:8px 0 0 8px;border:1px solid #444860;border-right:none;background:#1e2133;color:#e8eaf0;font-size:13px;width:220px;}
.ped-search input:focus{outline:none;border-color:#a78bfa;}
.ped-search button{padding:9px 14px;border-radius:0 8px 8px 0;background:#a78bfa;border:none;color:#fff;cursor:pointer;font-size:15px;}
.ped-btn-novo{display:flex;align-items:center;gap:7px;padding:9px 16px;border-radius:8px;background:linear-gradient(135deg,#a78bfa,#8b5cf6);color:#fff;font-size:13px;font-weight:700;text-decoration:none;border:none;cursor:pointer;box-shadow:0 4px 14px rgba(139,92,246,0.3);}
.ped-btn-novo:hover{color:#fff;}

.ped-board{display:grid;grid-template-columns:repeat(3,1fr);gap:16px;align-items:start;}
@media (max-width:960px){.ped-board{grid-template-columns:1fr;}}

.ped-col{background:#15182580;border:1px solid rgba(255,255,255,0.06);border-radius:16px;padding:14px;min-height:120px;}
.ped-col-head{display:flex;align-items:center;justify-content:space-between;margin-bottom:12px;padding:0 4px;}
.ped-col-head-left{display:flex;align-items:center;gap:8px;}
.ped-col-dot{width:9px;height:9px;border-radius:50%;}
.ped-col-nome{font-size:13px;font-weight:700;color:#e8eaf0;text-transform:uppercase;letter-spacing:.4px;}
.ped-col-count{font-size:11px;font-weight:700;color:#9ca3af;background:rgba(255,255,255,0.06);border-radius:20px;padding:2px 9px;}

.ped-col-lista{display:flex;flex-direction:column;gap:10px;min-height:60px;}
.ped-col-lista.ped-dragover{background:rgba(167,139,250,0.06);border-radius:12px;outline:2px dashed rgba(167,139,250,0.35);outline-offset:4px;}

.ped-card{background:#1a1d2e;border:1px solid rgba(255,255,255,0.07);border-radius:12px;padding:13px 14px;cursor:grab;transition:transform .12s, box-shadow .12s, border-color .12s;}
.ped-card:active{cursor:grabbing;}
.ped-card:hover{border-color:rgba(167,139,250,0.3);box-shadow:0 8px 18px rgba(0,0,0,0.25);}
.ped-card.ped-dragging{opacity:.4;}

.ped-card-top{display:flex;justify-content:space-between;align-items:center;margin-bottom:8px;gap:8px;}
.ped-badge{font-size:10px;font-weight:700;padding:2px 8px;border-radius:20px;text-transform:uppercase;letter-spacing:.3px;}
.ped-badge-alta{background:rgba(248,113,113,0.15);color:#f87171;}
.ped-badge-normal{background:rgba(96,165,250,0.15);color:#60a5fa;}
.ped-badge-baixa{background:rgba(156,163,175,0.15);color:#9ca3af;}
.ped-qtd{font-size:11px;font-weight:700;color:#e8eaf0;background:rgba(255,255,255,0.07);border-radius:20px;padding:2px 9px;}

.ped-desc{font-size:14px;font-weight:700;color:#e8eaf0;line-height:1.35;margin-bottom:6px;word-break:break-word;}
.ped-linha{display:flex;align-items:center;gap:6px;font-size:11.5px;color:#9ca3af;margin-bottom:4px;}
.ped-linha i{font-size:13px;flex-shrink:0;}
.ped-linha.ped-cliente{color:#c9cad6;}
.ped-obs{font-size:11.5px;color:#6b7280;line-height:1.4;margin-top:6px;padding-top:6px;border-top:1px solid rgba(255,255,255,0.06);white-space:pre-wrap;}

.ped-card-foot{display:flex;align-items:center;justify-content:space-between;margin-top:10px;padding-top:9px;border-top:1px solid rgba(255,255,255,0.06);gap:8px;flex-wrap:wrap;}
.ped-data{font-size:10.5px;color:#565b6e;}
.ped-acoes{display:flex;gap:6px;margin-left:auto;}
.ped-acao{width:28px;height:28px;border-radius:8px;display:flex;align-items:center;justify-content:center;font-size:14px;border:none;cursor:pointer;text-decoration:none;}
.ped-acao-avancar{background:rgba(96,165,250,0.15);color:#60a5fa;}
.ped-acao-entregar{background:rgba(52,211,153,0.15);color:#34d399;}
.ped-acao-whats{background:rgba(37,211,102,0.15);color:#25d366;}
.ped-acao-editar{background:rgba(251,191,36,0.15);color:#fbbf24;}
.ped-acao-excluir{background:rgba(239,68,68,0.15);color:#f87171;}
.ped-acao:hover{filter:brightness(1.2);}

.ped-empty{text-align:center;padding:28px 10px;color:#565b6e;font-size:12px;}
.ped-empty i{font-size:28px;display:block;margin-bottom:6px;opacity:.4;}

/* Modal */
.ped-modal .modal-header{background:linear-gradient(135deg,#8b5cf6,#7c3aed);border-bottom:none;padding:20px 24px;}
.ped-modal .modal-header h4{color:#fff;font-weight:800;display:flex;align-items:center;gap:10px;margin:0;}
.ped-modal .modal-header .close{color:#fff;opacity:.85;}
.ped-modal .modal-body{background:#161925;padding:22px 24px;}
.ped-modal .modal-footer{background:#161925;border-top:1px solid rgba(255,255,255,0.06);padding:16px 24px;}
.ped-field{margin-bottom:14px;}
.ped-field label{display:block;font-size:12.5px;font-weight:600;color:#c9cad6;margin-bottom:6px;}
.ped-field label .req{color:#f87171;margin-left:2px;}
.ped-field input[type=text],
.ped-field input[type=number],
.ped-field select,
.ped-field textarea{
    width:100%;background:#1e2133;border:1px solid rgba(255,255,255,0.1);border-radius:9px;
    padding:10px 12px;font-size:13.5px;color:#e8eaf0;box-sizing:border-box;
}
.ped-field textarea{resize:vertical;min-height:60px;}
.ped-field input:focus,.ped-field select:focus,.ped-field textarea:focus{outline:none;border-color:#a78bfa;box-shadow:0 0 0 3px rgba(167,139,250,0.15);}
.ped-row2{display:grid;grid-template-columns:1fr 1fr;gap:14px;}
.ped-cliente-chip{display:none;align-items:center;gap:8px;background:rgba(167,139,250,0.1);border:1px solid rgba(167,139,250,0.3);border-radius:9px;padding:7px 10px;margin-top:8px;font-size:12.5px;color:#e8eaf0;}
.ped-cliente-chip i{color:#a78bfa;}
.ped-cliente-chip .remover{margin-left:auto;cursor:pointer;color:#9ca3af;}

.ped-foto-box{border:2px dashed rgba(255,255,255,0.15);border-radius:10px;height:120px;display:flex;align-items:center;justify-content:center;cursor:pointer;overflow:hidden;background:#1e2133;position:relative;transition:border-color .15s;}
.ped-foto-box:hover{border-color:#a78bfa;}
.ped-foto-box img{width:100%;height:100%;object-fit:cover;display:none;}
.ped-foto-placeholder{display:flex;flex-direction:column;align-items:center;gap:6px;color:#6b7280;font-size:12px;}
.ped-foto-placeholder i{font-size:26px;}
.ped-remover-foto-row{display:none;align-items:center;gap:6px;font-size:12px;color:#f87171;margin-top:8px;cursor:pointer;}
.ped-remover-foto-row input{width:auto;}

.ped-card-foto{width:100%;height:90px;object-fit:cover;border-radius:9px;margin-bottom:9px;cursor:pointer;display:block;}

.ped-btn-salvar{background:linear-gradient(135deg,#a78bfa,#8b5cf6);color:#fff;border:none;padding:10px 20px;border-radius:9px;font-weight:700;font-size:13.5px;display:inline-flex;align-items:center;gap:8px;cursor:pointer;}
.ped-btn-cancelar{background:rgba(255,255,255,0.06);color:#c9cad6;border:1px solid rgba(255,255,255,0.1);padding:10px 20px;border-radius:9px;font-weight:700;font-size:13.5px;cursor:pointer;}

.ui-autocomplete{background:#1e2133;border:1px solid rgba(255,255,255,0.12);border-radius:9px;padding:4px;z-index:99999;max-height:220px;overflow-y:auto;}
.ui-autocomplete .ui-menu-item{padding:0;}
.ui-autocomplete .ui-menu-item-wrapper{padding:8px 10px;border-radius:6px;font-size:12.5px;color:#c9cad6;cursor:pointer;}
.ui-autocomplete .ui-menu-item-wrapper.ui-state-active{background:rgba(167,139,250,0.15);color:#e8eaf0;border:none;margin:0;}
</style>

<div class="new122 ped-wrap">

    <div class="ped-header">
        <div class="ped-title-row">
            <div class="ped-icon-badge"><i class='bx bx-cart-alt'></i></div>
            <div>
                <div class="ped-title">Pedidos &amp; Anotações</div>
                <div class="ped-subtitle">Controle de peças e produtos a comprar — com ou sem cliente vinculado</div>
            </div>
        </div>
        <div class="ped-tools">
            <?php if ($this->permission->checkPermission($this->session->userdata('permissao'), 'aPedido')): ?>
            <button type="button" class="ped-btn-novo" onclick="pedAbrirModalNovo()">
                <i class='bx bx-plus-circle'></i> Novo Pedido
            </button>
            <?php endif; ?>
            <form method="get" action="<?= site_url('pedidos') ?>" class="ped-search">
                <input type="text" name="pesquisa" placeholder="Buscar item, modelo, cliente..." value="<?= htmlspecialchars($pesquisa ?? '') ?>">
                <button type="submit"><i class='bx bx-search'></i></button>
            </form>
        </div>
    </div>

    <div class="ped-board">

        <!-- Coluna: Pendente -->
        <div class="ped-col">
            <div class="ped-col-head">
                <div class="ped-col-head-left">
                    <span class="ped-col-dot" style="background:#fbbf24;"></span>
                    <span class="ped-col-nome">Pendente</span>
                </div>
                <span class="ped-col-count"><?= count($pendentes) ?></span>
            </div>
            <div class="ped-col-lista" data-status="Pendente" id="colPendente">
                <?php if (empty($pendentes)): ?>
                    <div class="ped-empty"><i class='bx bx-check-shield'></i>Nada pendente por aqui.</div>
                <?php endif; ?>
                <?php foreach ($pendentes as $p): ?>
                    <?php include APPPATH . 'views/pedidos/_card_partial.php'; ?>
                <?php endforeach; ?>
            </div>
        </div>

        <!-- Coluna: Comprado -->
        <div class="ped-col">
            <div class="ped-col-head">
                <div class="ped-col-head-left">
                    <span class="ped-col-dot" style="background:#60a5fa;"></span>
                    <span class="ped-col-nome">Comprado</span>
                </div>
                <span class="ped-col-count"><?= count($comprados) ?></span>
            </div>
            <div class="ped-col-lista" data-status="Comprado" id="colComprado">
                <?php if (empty($comprados)): ?>
                    <div class="ped-empty"><i class='bx bx-cart'></i>Nenhum item comprado ainda.</div>
                <?php endif; ?>
                <?php foreach ($comprados as $p): ?>
                    <?php include APPPATH . 'views/pedidos/_card_partial.php'; ?>
                <?php endforeach; ?>
            </div>
        </div>

        <!-- Coluna: Entregue -->
        <div class="ped-col">
            <div class="ped-col-head">
                <div class="ped-col-head-left">
                    <span class="ped-col-dot" style="background:#34d399;"></span>
                    <span class="ped-col-nome">Entregue</span>
                </div>
                <span class="ped-col-count"><?= count($entregues) ?></span>
            </div>
            <div class="ped-col-lista" data-status="Entregue" id="colEntregue">
                <?php if (empty($entregues)): ?>
                    <div class="ped-empty"><i class='bx bx-package'></i>Nada entregue ainda.</div>
                <?php endif; ?>
                <?php foreach ($entregues as $p): ?>
                    <?php include APPPATH . 'views/pedidos/_card_partial.php'; ?>
                <?php endforeach; ?>
            </div>
        </div>

    </div>
</div>

<!-- Modal Novo/Editar Pedido -->
<div class="modal fade ped-modal" id="modal-pedido" tabindex="-1" role="dialog" style="display:none;">
    <div class="modal-dialog" role="document" style="max-width:520px;">
        <div class="modal-content">
            <form action="<?= site_url('pedidos/adicionar') ?>" method="post" id="formPedido" enctype="multipart/form-data">
                <input type="hidden" name="id" id="pedId">
                <input type="hidden" name="produtos_id" id="pedProdutosId">
                <input type="hidden" name="clientes_id" id="pedClientesId">

                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 id="pedModalTitulo"><i class='bx bx-cart-alt'></i> Novo Pedido</h4>
                </div>

                <div class="modal-body">
                    <div class="ped-field">
                        <label for="pedDescricao">O que precisa comprar?<span class="req">*</span></label>
                        <input type="text" name="descricao" id="pedDescricao" placeholder="Ex: Película 3D - iPhone 13, Bateria Moto G54..." autocomplete="off" required>
                    </div>

                    <div class="ped-field">
                        <label><i class='bx bx-camera'></i> Foto (opcional)</label>
                        <div class="ped-foto-box" id="pedFotoBox" onclick="document.getElementById('pedFoto').click()">
                            <img id="pedFotoPreview" alt="Prévia da foto">
                            <div id="pedFotoPlaceholder" class="ped-foto-placeholder">
                                <i class='bx bx-image-add'></i>
                                <span>Clique para adicionar uma foto</span>
                            </div>
                        </div>
                        <input type="file" name="foto" id="pedFoto" accept="image/*" style="display:none;">
                        <label class="ped-remover-foto-row" id="pedRemoverFotoRow">
                            <input type="checkbox" name="remover_foto" id="pedRemoverFoto" value="1"> Remover foto atual
                        </label>
                    </div>

                    <div class="ped-field">
                        <label for="pedClienteBusca"><i class='bx bx-user'></i> Vincular a um cliente (opcional)</label>
                        <input type="text" id="pedClienteBusca" placeholder="Buscar cliente por nome, telefone ou documento..." autocomplete="off">
                        <div class="ped-cliente-chip" id="pedClienteChip">
                            <i class='bx bx-user-check'></i>
                            <span id="pedClienteNome"></span>
                            <span class="remover" onclick="pedRemoverCliente()"><i class='bx bx-x'></i></span>
                        </div>
                    </div>

                    <div class="ped-row2">
                        <div class="ped-field">
                            <label for="pedQuantidade">Quantidade</label>
                            <input type="number" name="quantidade" id="pedQuantidade" min="1" value="1">
                        </div>
                        <div class="ped-field">
                            <label for="pedPrioridade">Prioridade</label>
                            <select name="prioridade" id="pedPrioridade">
                                <option value="Normal">Normal</option>
                                <option value="Alta">Alta</option>
                                <option value="Baixa">Baixa</option>
                            </select>
                        </div>
                    </div>

                    <div class="ped-field">
                        <label for="pedObservacao">Observação (opcional)</label>
                        <textarea name="observacao" id="pedObservacao" placeholder="Detalhes extras: cor, capacidade, fornecedor sugerido..."></textarea>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="submit" class="ped-btn-salvar"><i class='bx bx-save'></i> Salvar</button>
                    <button type="button" class="ped-btn-cancelar" data-dismiss="modal">Cancelar</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
function pedLerCookieCsrf() {
    var nomeCookie = '<?= $this->config->item('csrf_cookie_name') ?>';
    var match = document.cookie.match(new RegExp('(?:^|; )' + nomeCookie + '=([^;]*)'));
    return match ? decodeURIComponent(match[1]) : '<?= $this->security->get_csrf_hash() ?>';
}
var PED_CSRF_NAME = '<?= $this->security->get_csrf_token_name() ?>';

// ── Modal: novo pedido ──────────────────────────────────────────────
function pedAbrirModalNovo() {
    document.getElementById('formPedido').action = '<?= site_url('pedidos/adicionar') ?>';
    document.getElementById('pedModalTitulo').innerHTML = "<i class='bx bx-cart-alt'></i> Novo Pedido";
    document.getElementById('pedId').value = '';
    document.getElementById('pedDescricao').value = '';
    document.getElementById('pedProdutosId').value = '';
    document.getElementById('pedClientesId').value = '';
    document.getElementById('pedClienteBusca').value = '';
    document.getElementById('pedQuantidade').value = 1;
    document.getElementById('pedPrioridade').value = 'Normal';
    document.getElementById('pedObservacao').value = '';
    document.getElementById('pedClienteChip').style.display = 'none';
    document.getElementById('pedFoto').value = '';
    document.getElementById('pedFotoPreview').style.display = 'none';
    document.getElementById('pedFotoPreview').src = '';
    document.getElementById('pedFotoPlaceholder').style.display = 'flex';
    document.getElementById('pedRemoverFotoRow').style.display = 'none';
    document.getElementById('pedRemoverFoto').checked = false;
    $('#modal-pedido').modal('show');
}

// ── Modal: editar pedido (chamado pelos cards) ──────────────────────
function pedAbrirModalEditar(dados) {
    document.getElementById('formPedido').action = '<?= site_url('pedidos/editar') ?>';
    document.getElementById('pedModalTitulo').innerHTML = "<i class='bx bx-edit'></i> Editar Pedido";
    document.getElementById('pedId').value = dados.id;
    document.getElementById('pedDescricao').value = dados.descricao;
    document.getElementById('pedProdutosId').value = dados.produtosId || '';
    document.getElementById('pedQuantidade').value = dados.quantidade || 1;
    document.getElementById('pedPrioridade').value = dados.prioridade || 'Normal';
    document.getElementById('pedObservacao').value = dados.observacao || '';

    if (dados.clientesId) {
        document.getElementById('pedClientesId').value = dados.clientesId;
        document.getElementById('pedClienteNome').textContent = dados.clienteNome;
        document.getElementById('pedClienteChip').style.display = 'flex';
    } else {
        document.getElementById('pedClientesId').value = '';
        document.getElementById('pedClienteChip').style.display = 'none';
    }
    document.getElementById('pedClienteBusca').value = '';

    document.getElementById('pedFoto').value = '';
    document.getElementById('pedRemoverFoto').checked = false;
    if (dados.foto) {
        document.getElementById('pedFotoPreview').src = dados.foto;
        document.getElementById('pedFotoPreview').style.display = 'block';
        document.getElementById('pedFotoPlaceholder').style.display = 'none';
        document.getElementById('pedRemoverFotoRow').style.display = 'flex';
    } else {
        document.getElementById('pedFotoPreview').style.display = 'none';
        document.getElementById('pedFotoPreview').src = '';
        document.getElementById('pedFotoPlaceholder').style.display = 'flex';
        document.getElementById('pedRemoverFotoRow').style.display = 'none';
    }

    $('#modal-pedido').modal('show');
}

function pedRemoverCliente() {
    document.getElementById('pedClientesId').value = '';
    document.getElementById('pedClienteChip').style.display = 'none';
}

$(document).ready(function() {

    // Prévia da foto escolhida no input file
    document.getElementById('pedFoto').addEventListener('change', function(e) {
        var file = e.target.files[0];
        if (!file) return;
        var reader = new FileReader();
        reader.onload = function(ev) {
            document.getElementById('pedFotoPreview').src = ev.target.result;
            document.getElementById('pedFotoPreview').style.display = 'block';
            document.getElementById('pedFotoPlaceholder').style.display = 'none';
        };
        reader.readAsDataURL(file);
        document.getElementById('pedRemoverFoto').checked = false;
        document.getElementById('pedRemoverFotoRow').style.display = 'none';
    });

    // Autocomplete de produto já cadastrado
    $('#pedDescricao').autocomplete({
        source: '<?= base_url() ?>index.php/pedidos/autoCompleteProduto',
        minLength: 2,
        select: function(e, ui) {
            document.getElementById('pedProdutosId').value = ui.item.id;
            document.getElementById('pedDescricao').value = ui.item.descricao;
            return false;
        }
    });
    // Se o usuário editar manualmente a descrição depois de ter escolhido um produto,
    // desfaz o vínculo pra não salvar um produtos_id de um texto diferente.
    $('#pedDescricao').on('input', function() {
        document.getElementById('pedProdutosId').value = '';
    });

    // Autocomplete de cliente (reaproveita o endpoint que já existe em Os.php)
    $('#pedClienteBusca').autocomplete({
        source: '<?= base_url() ?>index.php/os/autoCompleteCliente',
        minLength: 1,
        select: function(e, ui) {
            document.getElementById('pedClientesId').value = ui.item.id;
            document.getElementById('pedClienteNome').textContent = ui.item.label;
            document.getElementById('pedClienteChip').style.display = 'flex';
            document.getElementById('pedClienteBusca').value = '';
            return false;
        }
    });

    // ── Ações rápidas nos cards (avançar status / excluir) ──────────
    $(document).on('click', '.ped-acao-avancar', function() {
        pedMoverStatus($(this).data('id'), 'Comprado', $(this));
    });
    $(document).on('click', '.ped-acao-entregar', function() {
        pedMoverStatus($(this).data('id'), 'Entregue', $(this));
    });
    $(document).on('click', '.ped-acao-excluir', function() {
        if (!confirm('Excluir este pedido/anotação?')) return;
        pedExcluir($(this).data('id'));
    });
    $(document).on('click', '.ped-acao-editar', function() {
        pedAbrirModalEditar($(this).data());
    });

    // ── Drag and drop nativo (sem depender de libs externas) ────────
    var arrastando = null;

    $(document).on('dragstart', '.ped-card', function(e) {
        arrastando = this;
        $(this).addClass('ped-dragging');
        e.originalEvent.dataTransfer.effectAllowed = 'move';
        e.originalEvent.dataTransfer.setData('text/plain', $(this).data('id'));
    });
    $(document).on('dragend', '.ped-card', function() {
        $(this).removeClass('ped-dragging');
        $('.ped-col-lista').removeClass('ped-dragover');
    });
    $('.ped-col-lista').on('dragover', function(e) {
        e.preventDefault();
        $(this).addClass('ped-dragover');
    });
    $('.ped-col-lista').on('dragleave', function() {
        $(this).removeClass('ped-dragover');
    });
    $('.ped-col-lista').on('drop', function(e) {
        e.preventDefault();
        $(this).removeClass('ped-dragover');
        if (!arrastando) return;
        var novoStatus = $(this).data('status');
        var statusAtual = $(arrastando).data('status');
        if (novoStatus === statusAtual) return;
        var id = $(arrastando).data('id');
        pedMoverStatus(id, novoStatus, null);
    });

});

function pedMoverStatus(id, novoStatus, $botao) {
    if ($botao) { $botao.prop('disabled', true); }
    var dados = { id: id, status: novoStatus };
    dados[PED_CSRF_NAME] = pedLerCookieCsrf();

    $.post('<?= site_url('pedidos/moverStatus') ?>', dados, function(resp) {
        if (resp && resp.sucesso) {
            window.location.reload();
        } else {
            alert((resp && resp.erro) ? resp.erro : 'Não foi possível mover o pedido.');
            if ($botao) { $botao.prop('disabled', false); }
        }
    }, 'json').fail(function() {
        alert('Erro de conexão ao mover o pedido.');
        if ($botao) { $botao.prop('disabled', false); }
    });
}

function pedExcluir(id) {
    var dados = { id: id };
    dados[PED_CSRF_NAME] = pedLerCookieCsrf();

    $.post('<?= site_url('pedidos/excluir') ?>', dados, function() {
        window.location.reload();
    }).fail(function() {
        alert('Erro de conexão ao excluir o pedido.');
    });
}
</script>
