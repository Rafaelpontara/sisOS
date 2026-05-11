<link rel="stylesheet" href="<?= base_url() ?>assets/js/jquery-ui/css/smoothness/jquery-ui-1.9.2.custom.css" />
<script src="<?= base_url() ?>assets/js/jquery-ui/js/jquery-ui-1.9.2.custom.js"></script>
<script src="<?= base_url() ?>assets/js/jquery.validate.js"></script>
<link rel="stylesheet" href="<?= base_url() ?>assets/trumbowyg/ui/trumbowyg.css">
<script src="<?= base_url() ?>assets/trumbowyg/trumbowyg.js"></script>
<script src="<?= base_url() ?>assets/trumbowyg/langs/pt_br.js"></script>
<link rel="stylesheet" href="<?= base_url() ?>assets/css/custom.css" />

<style>
.vnd-wrap *, .vnd-wrap *::before, .vnd-wrap *::after { box-sizing: border-box; }
/* Reset Bootstrap 2 containers */
.vnd-wrap .widget-box, .vnd-wrap .widget-title, .vnd-wrap .widget-content,
.vnd-wrap .row-fluid, .vnd-wrap .span12, .vnd-wrap .span6,
.vnd-wrap .span3, .vnd-wrap .span2 { all: unset; display: block; }

.vnd-wrap { max-width: 1100px; margin: 0 auto; font-family: inherit; }

/* Header */
.vnd-header { display:flex; align-items:center; justify-content:space-between; margin-bottom:20px; flex-wrap:wrap; gap:10px; }
.vnd-title  { display:flex; align-items:center; gap:10px; }
.vnd-title i { font-size:24px; color:#a78bfa; }
.vnd-title h2 { font-size:20px; font-weight:800; color:#e8eaf0; margin:0; }

/* Cards */
.vnd-card { background:#1a1d2e; border:1px solid rgba(255,255,255,0.07); border-radius:14px; margin-bottom:14px; overflow:hidden; }
.vnd-card-head { display:flex; align-items:center; gap:8px; padding:12px 18px; border-bottom:1px solid rgba(255,255,255,0.06); background:#252a3a; }
.vnd-card-head i { font-size:16px; color:#a78bfa; }
.vnd-card-head span { font-size:11px; font-weight:700; color:#9ca3af; text-transform:uppercase; letter-spacing:.8px; }
.vnd-card-body { padding:18px; }

/* Grid */
.vnd-row { display:flex; gap:14px; flex-wrap:wrap; }
.vnd-field { flex:1; min-width:155px; }
.vnd-field-wide { flex:2; min-width:230px; }

/* Labels + inputs */
.vnd-label { font-size:11px; font-weight:700; color:#9ca3af; text-transform:uppercase; letter-spacing:.5px; display:block; margin-bottom:6px; }
.vnd-label .req { color:#f87171; margin-left:2px; }
.vnd-input, .vnd-select {
    width:100%; background:#13151f; border:1px solid #444860; color:#e8eaf0;
    border-radius:8px; padding:9px 13px; font-size:13px; display:block;
    transition:border-color .15s; -webkit-appearance:none; appearance:none;
}
.vnd-input:focus, .vnd-select:focus { border-color:#a78bfa; outline:none; }
.vnd-select { height:38px; }

/* Cliente input group */
.vnd-input-group { display:flex; gap:6px; align-items:center; }
.vnd-input-group .vnd-input { flex:1; }
.vnd-btn-new-client {
    width:38px; height:38px; background:linear-gradient(135deg,#22c55e,#16a34a);
    color:#fff; border-radius:8px; font-size:17px; text-decoration:none;
    display:inline-flex; align-items:center; justify-content:center;
    border:none; cursor:pointer; flex-shrink:0; transition:transform .15s;
}
.vnd-btn-new-client:hover { transform:scale(1.08); color:#fff; }

/* Observações grid */
.vnd-obs-grid { display:grid; grid-template-columns:1fr 1fr; gap:18px; }
@media(max-width:700px){ .vnd-obs-grid { grid-template-columns:1fr; } }
.vnd-obs-label { display:flex; align-items:center; gap:7px; font-size:13px; font-weight:700; color:#c9cad6; margin-bottom:8px; }
.vnd-obs-label i { font-size:16px; }

/* Trumbowyg dark */
.trumbowyg-box { border-radius:10px!important; overflow:hidden; border:1px solid #444860!important; }
.trumbowyg-button-pane { background:#252a3a!important; border-bottom:1px solid #444860!important; border-radius:10px 10px 0 0!important; }
.trumbowyg-button-pane button, .trumbowyg-button-pane .trumbowyg-button-group::before { color:#9ca3af!important; }
.trumbowyg-button-pane button:hover, .trumbowyg-button-pane button.trumbowyg-active { background:rgba(255,255,255,0.08)!important; color:#e8eaf0!important; }
.trumbowyg-editor { background:#13151f!important; color:#e8eaf0!important; border:none!important; border-radius:0 0 10px 10px!important; min-height:200px!important; padding:12px 14px!important; font-size:13px!important; line-height:1.7!important; }

/* Footer */
.vnd-footer { display:flex; justify-content:center; align-items:center; gap:12px; padding:20px 18px; border-top:1px solid rgba(255,255,255,0.06); background:#1a1d2e; border-radius:0 0 14px 14px; }
.vnd-btn { display:inline-flex; align-items:center; gap:8px; padding:11px 28px; border-radius:8px; font-size:14px; font-weight:700; text-decoration:none; border:none; cursor:pointer; transition:all .15s; }
.vnd-btn:hover { transform:translateY(-2px); text-decoration:none; }
.vnd-btn-continue { background:linear-gradient(135deg,#22c55e,#16a34a); color:#fff; box-shadow:0 4px 16px rgba(34,197,94,0.35); }
.vnd-btn-back { background:rgba(245,158,11,0.12); color:#fbbf24; border:1px solid rgba(245,158,11,0.3); }
.vnd-btn-back:hover { background:rgba(245,158,11,0.22); color:#fbbf24; }

/* Erro */
.vnd-alert { background:rgba(239,68,68,0.1); border:1px solid rgba(239,68,68,0.3); border-radius:10px; padding:11px 16px; font-size:13px; color:#f87171; margin-bottom:16px; display:flex; align-items:center; gap:8px; }

/* Modal cliente rápido overrides */
#modal-cliente-rapido-venda { border-radius:14px!important; overflow:hidden!important; border:1px solid rgba(255,255,255,0.1)!important; box-shadow:0 24px 60px rgba(0,0,0,0.7)!important; }
#modal-cliente-rapido-venda .modal-header { background:#1a1d2e!important; background-image:none!important; border-bottom:1px solid rgba(255,255,255,0.08)!important; padding:16px 20px!important; display:flex!important; align-items:center!important; justify-content:space-between!important; }
#modal-cliente-rapido-venda .modal-header h4 { margin:0!important; font-size:15px!important; font-weight:800!important; color:#e8eaf0!important; text-shadow:none!important; display:flex!important; align-items:center!important; gap:8px!important; }
#modal-cliente-rapido-venda .modal-header .close { color:#9ca3af!important; opacity:1!important; text-shadow:none!important; float:none!important; margin-top:0!important; }
#modal-cliente-rapido-venda .modal-body { background:#13151f!important; padding:20px!important; }
#modal-cliente-rapido-venda .modal-footer { background:#1a1d2e!important; background-image:none!important; border-top:1px solid rgba(255,255,255,0.08)!important; padding:12px 20px!important; display:flex!important; justify-content:flex-end!important; gap:8px!important; }
#modal-cliente-rapido-venda label { font-size:11px!important; font-weight:700!important; color:#9ca3af!important; text-transform:uppercase!important; letter-spacing:.5px!important; display:block!important; margin-bottom:5px!important; margin-top:12px!important; }
#modal-cliente-rapido-venda label:first-child { margin-top:0!important; }
#modal-cliente-rapido-venda input[type=text] { width:100%!important; background:#1e2133!important; border:1px solid #444860!important; color:#e8eaf0!important; border-radius:8px!important; padding:8px 12px!important; font-size:13px!important; box-sizing:border-box!important; display:block!important; }
#modal-cliente-rapido-venda input:focus { border-color:#a78bfa!important; outline:none!important; }
#modal-cliente-rapido-venda .hint { font-size:11px; color:#6b7280; margin-top:10px; }

.vnd-modal-btn-cancel { display:inline-flex; align-items:center; gap:6px; padding:9px 18px; border-radius:8px; background:rgba(255,255,255,0.07); color:#9ca3af; border:1px solid rgba(255,255,255,0.1); font-size:13px; font-weight:700; cursor:pointer; }
.vnd-modal-btn-save   { display:inline-flex; align-items:center; gap:6px; padding:9px 18px; border-radius:8px; background:linear-gradient(135deg,#22c55e,#16a34a); color:#fff; border:none; font-size:13px; font-weight:700; cursor:pointer; box-shadow:0 4px 12px rgba(34,197,94,0.3); }

label.error { color:#f87171!important; font-size:11px!important; }
input.error { border-color:#f87171!important; }
input.valid { border-color:#4ade80!important; }
</style>

<div class="vnd-wrap">

    <!-- Header -->
    <div class="vnd-header">
        <div class="vnd-title">
            <i class='bx bx-cart-alt'></i>
            <h2>Iniciar Venda</h2>
        </div>
        <a href="<?= base_url() ?>index.php/vendas" class="vnd-btn vnd-btn-back" style="padding:8px 16px;font-size:13px;">
            <i class='bx bx-arrow-back'></i> Voltar
        </a>
    </div>

    <?php if ($custom_error == true): ?>
    <div class="vnd-alert">
        <i class='bx bx-error-circle' style="font-size:18px;flex-shrink:0;"></i>
        Dados incompletos. Verifique os campos com * e se o cliente foi selecionado corretamente.
    </div>
    <?php endif; ?>

    <form action="<?= current_url() ?>" method="post" id="formVendas">

        <!-- ── Card: Dados da Venda ── -->
        <div class="vnd-card">
            <div class="vnd-card-head">
                <i class='bx bx-purchase-tag-alt'></i>
                <span>Dados da Venda</span>
            </div>
            <div class="vnd-card-body">
                <div class="vnd-row">
                    <div class="vnd-field" style="max-width:165px;">
                        <label class="vnd-label">Data da Venda <span class="req">*</span></label>
                        <input id="dataVenda" class="vnd-input datepicker" type="text"
                               name="dataVenda" value="<?= date('d/m/Y') ?>" autocomplete="off" />
                    </div>
                    <div class="vnd-field-wide">
                        <label class="vnd-label">Cliente <span class="req">*</span></label>
                        <div class="vnd-input-group">
                            <input id="cliente" class="vnd-input" type="text" name="cliente"
                                   value="" placeholder="Digite para buscar..." autocomplete="off" />
                            <input id="clientes_id" type="hidden" name="clientes_id" value="" />
                            <?php if ($this->permission->checkPermission($this->session->userdata('permissao'), 'aCliente')): ?>
                            <a href="#modal-cliente-rapido-venda" data-toggle="modal"
                               class="vnd-btn-new-client" title="Cadastrar novo cliente">
                                <i class='bx bx-user-plus'></i>
                            </a>
                            <?php endif; ?>
                        </div>
                    </div>
                    <div class="vnd-field">
                        <label class="vnd-label">Vendedor <span class="req">*</span></label>
                        <input id="tecnico" class="vnd-input" type="text" name="tecnico"
                               value="<?= $this->session->userdata('nome_admin') ?>" autocomplete="off" />
                        <input id="usuarios_id" type="hidden" name="usuarios_id"
                               value="<?= $this->session->userdata('id_admin') ?>" />
                    </div>
                    <div class="vnd-field">
                        <label class="vnd-label">Status <span class="req">*</span></label>
                        <select class="vnd-select" name="status" id="status">
                            <option value="Orçamento">Orçamento</option>
                            <option value="Aberto">Aberto</option>
                            <option value="Faturado">Faturado</option>
                            <option value="Em Andamento">Em Andamento</option>
                            <option value="Finalizado">Finalizado</option>
                            <option value="Cancelado">Cancelado</option>
                            <option value="Aguardando Peças">Aguardando Peças</option>
                            <option value="Aprovado">Aprovado</option>
                        </select>
                    </div>
                    <div class="vnd-field" style="max-width:150px;">
                        <label class="vnd-label">Garantia (dias)</label>
                        <input id="garantia" type="number" placeholder="0"
                               min="0" max="9999" class="vnd-input" name="garantia" value="" />
                    </div>
                </div>
            </div>
        </div>

        <!-- ── Card: Observações ── -->
        <div class="vnd-card">
            <div class="vnd-card-head">
                <i class='bx bx-notepad'></i>
                <span>Observações</span>
            </div>
            <div class="vnd-card-body">
                <div class="vnd-obs-grid">
                    <div>
                        <div class="vnd-obs-label">
                            <i class='bx bx-lock' style="color:#a78bfa;"></i>
                            Observações Internas
                        </div>
                        <textarea class="editor" name="observacoes" id="observacoes"></textarea>
                    </div>
                    <div>
                        <div class="vnd-obs-label">
                            <i class='bx bx-user' style="color:#60a5fa;"></i>
                            Observações ao Cliente
                        </div>
                        <textarea class="editor" name="observacoes_cliente" id="observacoes_cliente"></textarea>
                    </div>
                </div>
            </div>
        </div>

        <!-- ── Footer ── -->
        <div class="vnd-footer">
            <a href="<?= base_url() ?>index.php/vendas" class="vnd-btn vnd-btn-back">
                <i class='bx bx-undo'></i> Voltar
            </a>
            <button type="submit" class="vnd-btn vnd-btn-continue" id="btnContinuar">
                <i class='bx bx-chevrons-right'></i> Continuar
            </button>
        </div>

    </form>
</div>

<!-- Modal Cadastro Rápido de Cliente -->
<div id="modal-cliente-rapido-venda" class="modal hide fade" tabindex="-1" role="dialog">
    <div class="modal-header">
        <h4><i class='bx bx-user-plus' style="color:#4ade80;"></i> Novo Cliente — Rápido</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
    </div>
    <form id="formClienteRapidoVenda">
        <div class="modal-body">
            <label>Nome <span style="color:#f87171;">*</span></label>
            <input type="text" id="crNomeVenda" placeholder="Nome completo" />
            <label>Telefone / WhatsApp</label>
            <input type="text" id="crTelefoneVenda" placeholder="(00) 00000-0000" />
            <label>CPF / CNPJ</label>
            <input type="text" id="crCpfVenda" placeholder="Opcional" />
            <p class="hint">Demais dados podem ser completados depois em <strong style="color:#c9cad6;">Clientes</strong>.</p>
        </div>
        <div class="modal-footer">
            <button type="button" class="vnd-modal-btn-cancel" data-dismiss="modal">
                <i class='bx bx-x'></i> Cancelar
            </button>
            <button type="submit" class="vnd-modal-btn-save">
                <i class='bx bx-save'></i> Salvar Cliente
            </button>
        </div>
    </form>
</div>

<script>
$(document).ready(function() {

    $("#cliente").autocomplete({
        source: "<?= base_url() ?>index.php/vendas/autoCompleteCliente",
        minLength: 1,
        select: function(e, ui) { $("#clientes_id").val(ui.item.id); }
    });

    $("#tecnico").autocomplete({
        source: "<?= base_url() ?>index.php/vendas/autoCompleteUsuario",
        minLength: 1,
        select: function(e, ui) { $("#usuarios_id").val(ui.item.id); }
    });

    $(".datepicker").datepicker({ dateFormat: 'dd/mm/yy' });

    $('.editor').trumbowyg({ lang: 'pt_br', semantic: { strikethrough: 's' } });

    $("#formVendas").validate({
        rules: {
            cliente:   { required: true },
            tecnico:   { required: true },
            dataVenda: { required: true }
        },
        messages: {
            cliente:   { required: 'Campo obrigatório.' },
            tecnico:   { required: 'Campo obrigatório.' },
            dataVenda: { required: 'Campo obrigatório.' }
        },
        errorClass: 'help-inline',
        errorElement: 'span',
        submitHandler: function(form) {
            $('#btnContinuar').attr('disabled', true)
                .html('<i class="bx bx-loader-alt bx-spin"></i> Aguarde...');
            form.submit();
        }
    });

    $('#formClienteRapidoVenda').on('submit', function(e) {
        e.preventDefault();
        var nome = $('#crNomeVenda').val().trim();
        if (!nome) { alert('Nome é obrigatório.'); return; }
        $.post('<?= site_url('clientes/adicionarRapido') ?>', {
            nomeCliente: nome,
            telefone:    $('#crTelefoneVenda').val().trim(),
            cpf:         $('#crCpfVenda').val().trim(),
            '<?= $this->security->get_csrf_token_name() ?>': '<?= $this->security->get_csrf_hash() ?>'
        }, function(res) {
            if (res.sucesso) {
                $('#cliente').val(res.nome);
                $('#clientes_id').val(res.id);
                $('#modal-cliente-rapido-venda').modal('hide');
                $('#crNomeVenda, #crTelefoneVenda, #crCpfVenda').val('');
            } else {
                alert('Erro: ' + (res.erro || 'Não foi possível cadastrar.'));
            }
        }, 'json');
    });

});
</script>
