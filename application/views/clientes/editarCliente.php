<script src="<?= base_url() ?>assets/js/jquery.mask.min.js"></script>
<script src="<?= base_url() ?>assets/js/sweetalert2.all.min.js"></script>
<script src="<?= base_url() ?>assets/js/funcoes.js"></script>
<script src="<?= base_url() ?>assets/js/jquery.validate.js"></script>

<style>
/* ── Layout ── */
.cli-wrap{max-width:960px;margin:0 auto;}
.cli-header{display:flex;align-items:center;justify-content:space-between;margin-bottom:20px;flex-wrap:wrap;gap:10px;}
.cli-title{display:flex;align-items:center;gap:10px;}
.cli-title i{font-size:24px;color:#3b82f6;}
.cli-title h2{font-size:20px;font-weight:800;color:#e8eaf0;margin:0;}
.cli-title span{font-size:13px;color:#6b7280;font-weight:400;}

/* ── Seções ── */
.cli-section{background:#1a1d2e;border:1px solid rgba(255,255,255,0.07);border-radius:14px;margin-bottom:14px;overflow:hidden;}
.cli-section-head{display:flex;align-items:center;gap:8px;padding:11px 16px;border-bottom:1px solid rgba(255,255,255,0.06);background:#252a3a;}
.cli-section-head i{font-size:15px;color:#3b82f6;}
.cli-section-head span{font-size:11px;font-weight:700;color:#9ca3af;text-transform:uppercase;letter-spacing:.8px;}
.cli-section-body{padding:18px;}

/* ── Grid ── */
.cli-grid{display:grid;grid-template-columns:repeat(auto-fill,minmax(200px,1fr));gap:14px;}
.cli-grid-2{display:grid;grid-template-columns:1fr 1fr;gap:14px;}
@media(max-width:600px){.cli-grid-2{grid-template-columns:1fr;}}

/* ── Campos ── */
.cli-label{font-size:11px;font-weight:700;color:#9ca3af;text-transform:uppercase;letter-spacing:.5px;display:block;margin-bottom:5px;}
.cli-label .req{color:#f87171;margin-left:2px;}
.cli-input,.cli-select{width:100%;background:#13151f;border:1px solid #444860;color:#e8eaf0;border-radius:8px;padding:8px 12px;font-size:13px;box-sizing:border-box;transition:border-color .15s;}
.cli-input:focus,.cli-select:focus{border-color:#3b82f6;outline:none;}
.cli-select{height:36px;}
.cli-input-group{display:flex;gap:6px;align-items:stretch;}
.cli-input-group .cli-input{flex:1;}
.cli-btn-cnpj{display:inline-flex;align-items:center;gap:5px;padding:7px 12px;background:rgba(59,130,246,0.15);color:#60a5fa;border:1px solid rgba(59,130,246,0.3);border-radius:8px;font-size:12px;font-weight:700;cursor:pointer;white-space:nowrap;transition:all .15s;}
.cli-btn-cnpj:hover{background:rgba(59,130,246,0.25);}

/* ── Toggle Fornecedor ── */
.cli-toggle-wrap{display:flex;align-items:center;gap:10px;padding:10px 14px;background:#13151f;border:1px solid #444860;border-radius:8px;cursor:pointer;transition:border-color .15s;}
.cli-toggle-wrap:hover{border-color:#3b82f6;}
.cli-toggle{position:relative;width:40px;height:22px;flex-shrink:0;}
.cli-toggle input{opacity:0;width:0;height:0;}
.cli-toggle-slider{position:absolute;inset:0;background:#444860;border-radius:22px;transition:.3s;}
.cli-toggle-slider:before{content:'';position:absolute;width:16px;height:16px;left:3px;bottom:3px;background:#fff;border-radius:50%;transition:.3s;}
.cli-toggle input:checked + .cli-toggle-slider{background:#3b82f6;}
.cli-toggle input:checked + .cli-toggle-slider:before{transform:translateX(18px);}
.cli-toggle-label{font-size:13px;color:#c9cad6;font-weight:600;}

/* ── Senha ── */
.cli-pass-wrap{position:relative;}
.cli-pass-wrap .cli-input{padding-right:40px;}
.cli-pass-eye{position:absolute;right:10px;top:50%;transform:translateY(-50%);cursor:pointer;color:#6b7280;font-size:18px;transition:color .15s;}
.cli-pass-eye:hover{color:#e8eaf0;}

/* ── CEP ── */
.cli-cep-group{display:flex;gap:6px;}
.cli-cep-group .cli-input{flex:1;}

/* ── TAGs ── */
.cli-tags-grid{display:flex;flex-wrap:wrap;gap:8px;min-height:36px;}
.cli-tag-btn{display:inline-flex;align-items:center;gap:5px;padding:5px 14px;border-radius:20px;font-size:12px;font-weight:700;border:none;cursor:pointer;transition:all .2s;opacity:.5;}
.cli-tag-btn.ativa{opacity:1;box-shadow:0 3px 10px rgba(0,0,0,0.3);}
.cli-tag-btn i{font-size:13px;}
.cli-tags-hint{font-size:11px;color:#6b7280;margin-top:6px;}

/* ── Botões footer ── */
.cli-footer{display:flex;justify-content:flex-end;gap:8px;padding:16px;border-top:1px solid rgba(255,255,255,0.06);background:#1a1d2e;border-radius:0 0 14px 14px;}
.cli-btn{display:inline-flex;align-items:center;gap:6px;padding:9px 20px;border-radius:8px;font-size:13px;font-weight:700;text-decoration:none;border:none;cursor:pointer;transition:all .15s;}
.cli-btn:hover{transform:translateY(-1px);text-decoration:none;}
.cli-btn-save{background:linear-gradient(135deg,#6366f1,#4f46e5);color:#fff;box-shadow:0 4px 12px rgba(99,102,241,0.3);}
.cli-btn-back{background:rgba(255,255,255,0.07);color:#9ca3af;border:1px solid rgba(255,255,255,0.1);}
.cli-btn-back:hover{color:#e8eaf0;background:rgba(255,255,255,0.12);}

/* ── Erro ── */
.cli-alert-err{background:rgba(239,68,68,0.1);border:1px solid rgba(239,68,68,0.3);border-radius:8px;padding:10px 14px;font-size:13px;color:#f87171;margin-bottom:14px;display:flex;gap:8px;align-items:center;}
</style>

<div class="cli-wrap">

    <!-- Header -->
    <div class="cli-header">
        <div class="cli-title">
            <i class='bx bx-edit'></i>
            <h2>Editar Cliente <span>— <?= htmlspecialchars($result->nomeCliente) ?></span></h2>
        </div>
        <a href="<?= site_url() ?>/clientes" class="cli-btn cli-btn-back">
            <i class='bx bx-arrow-back'></i> Voltar
        </a>
    </div>

    <?php if ($custom_error != ''): ?>
    <div class="cli-alert-err">
        <i class='bx bx-error-circle'></i> <?= $custom_error ?>
    </div>
    <?php endif; ?>

    <form action="<?= current_url() ?>" id="formCliente" method="post">
        <?= form_hidden('idClientes', $result->idClientes) ?>

        <!-- ── Dados Pessoais ── -->
        <div class="cli-section">
            <div class="cli-section-head">
                <i class='bx bx-id-card'></i><span>Dados Pessoais</span>
            </div>
            <div class="cli-section-body">
                <div class="cli-grid-2" style="margin-bottom:14px;">
                    <div>
                        <label class="cli-label">CPF / CNPJ</label>
                        <div class="cli-input-group">
                            <input id="documento" type="text" name="documento" class="cli-input cpfcnpj"
                                   value="<?= htmlspecialchars($result->documento) ?>" placeholder="000.000.000-00" />
                            <button id="buscar_info_cnpj" type="button" class="cli-btn-cnpj">
                                <i class='bx bx-search'></i> Buscar CNPJ
                            </button>
                        </div>
                    </div>
                    <div>
                        <label class="cli-label">Nome / Razão Social <span class="req">*</span></label>
                        <input id="nomeCliente" type="text" name="nomeCliente" class="cli-input"
                               value="<?= htmlspecialchars($result->nomeCliente) ?>" />
                    </div>
                </div>

                <div class="cli-grid" style="margin-bottom:14px;">
                    <div>
                        <label class="cli-label">Contato</label>
                        <input type="text" name="contato" class="cli-input contato"
                               value="<?= htmlspecialchars($result->contato) ?>" />
                    </div>
                    <div>
                        <label class="cli-label">Telefone</label>
                        <input id="telefone" type="text" name="telefone" class="cli-input"
                               value="<?= htmlspecialchars($result->telefone) ?>" placeholder="(00) 0000-0000" />
                    </div>
                    <div>
                        <label class="cli-label">Celular / WhatsApp</label>
                        <input id="celular" type="text" name="celular" class="cli-input"
                               value="<?= htmlspecialchars($result->celular) ?>" placeholder="(00) 00000-0000" />
                    </div>
                    <div>
                        <label class="cli-label">E-mail</label>
                        <input id="email" type="text" name="email" class="cli-input"
                               value="<?= htmlspecialchars($result->email) ?>" />
                    </div>
                </div>

                <div class="cli-grid-2">
                    <div>
                        <label class="cli-label">Senha (Acesso ao Portal)</label>
                        <div class="cli-pass-wrap">
                            <input id="senha" type="password" name="senha" class="cli-input"
                                   placeholder="Deixe em branco para não alterar" autocomplete="new-password" />
                            <i class='bx bx-show cli-pass-eye' id="toggleSenha"></i>
                        </div>
                    </div>
                    <div>
                        <label class="cli-label">Tipo de Cliente</label>
                        <label class="cli-toggle-wrap">
                            <div class="cli-toggle">
                                <input type="checkbox" id="fornecedor" name="fornecedor" value="1"
                                       <?= ($result->fornecedor == 1) ? 'checked' : '' ?>>
                                <span class="cli-toggle-slider"></span>
                            </div>
                            <span class="cli-toggle-label">Este cliente também é Fornecedor</span>
                        </label>
                    </div>
                </div>
            </div>
        </div>

        <!-- ── Endereço ── -->
        <div class="cli-section">
            <div class="cli-section-head">
                <i class='bx bx-map'></i><span>Endereço</span>
            </div>
            <div class="cli-section-body">
                <div style="margin-bottom:14px;">
                    <label class="cli-label">CEP</label>
                    <div class="cli-cep-group">
                        <input id="cep" type="text" name="cep" class="cli-input"
                               value="<?= htmlspecialchars($result->cep) ?>"
                               placeholder="00000-000" style="max-width:160px;" />
                        <button type="button" id="btnBuscarCep" class="cli-btn-cnpj">
                            <i class='bx bx-map-pin'></i> Buscar CEP
                        </button>
                    </div>
                </div>

                <div class="cli-grid" style="margin-bottom:14px;">
                    <div style="grid-column:span 2;">
                        <label class="cli-label">Rua / Logradouro</label>
                        <input id="rua" type="text" name="rua" class="cli-input"
                               value="<?= htmlspecialchars($result->rua) ?>" />
                    </div>
                    <div>
                        <label class="cli-label">Número</label>
                        <input id="numero" type="text" name="numero" class="cli-input"
                               value="<?= htmlspecialchars($result->numero) ?>" />
                    </div>
                    <div>
                        <label class="cli-label">Complemento</label>
                        <input id="complemento" type="text" name="complemento" class="cli-input"
                               value="<?= htmlspecialchars($result->complemento) ?>" />
                    </div>
                </div>

                <div class="cli-grid">
                    <div>
                        <label class="cli-label">Bairro</label>
                        <input id="bairro" type="text" name="bairro" class="cli-input"
                               value="<?= htmlspecialchars($result->bairro) ?>" />
                    </div>
                    <div>
                        <label class="cli-label">Cidade</label>
                        <input id="cidade" type="text" name="cidade" class="cli-input"
                               value="<?= htmlspecialchars($result->cidade) ?>" />
                    </div>
                    <div>
                        <label class="cli-label">Estado</label>
                        <select id="estado" name="estado" class="cli-select">
                            <option value="">Selecione...</option>
                        </select>
                    </div>
                </div>
            </div>
        </div>

        <!-- ── TAGs do Cliente ── -->
        <div class="cli-section">
            <div class="cli-section-head">
                <i class='bx bx-purchase-tag'></i><span>TAGs do Cliente</span>
            </div>
            <div class="cli-section-body">
                <div class="cli-tags-grid" id="divTagsCliente">
                    <?php
                    try {
                        $this->db->select('ct.*');
                        $this->db->from('cliente_tags ct');
                        $this->db->join('clientes_tags clt', 'clt.cliente_tags_id = ct.idTag');
                        $this->db->where('clt.clientes_id', $result->idClientes);
                        $r1 = $this->db->get();
                        $tagsAtivas = $r1 ? $r1->result() : [];
                    } catch (Exception $e) { $tagsAtivas = []; }
                    $tagsAtivasIds = array_column((array)$tagsAtivas, 'idTag');
                    try {
                        $r2 = $this->db->order_by('tag')->get('cliente_tags');
                        $todasTags = $r2 ? $r2->result() : [];
                    } catch (Exception $e) { $todasTags = []; }

                    foreach ($todasTags as $t):
                        $ativa = in_array($t->idTag, $tagsAtivasIds);
                    ?>
                    <button type="button"
                        class="cli-tag-btn <?= $ativa ? 'ativa' : '' ?>"
                        data-id="<?= $t->idTag ?>"
                        data-cliente="<?= $result->idClientes ?>"
                        data-cor="<?= htmlspecialchars($t->cor) ?>"
                        data-ativo="<?= $ativa ? 1 : 0 ?>"
                        style="background:<?= $ativa ? htmlspecialchars($t->cor) : '#2d3247' ?>;color:#fff;">
                        <i class="bx <?= $ativa ? 'bxs-purchase-tag' : 'bx-purchase-tag' ?>"></i>
                        <?= htmlspecialchars($t->tag) ?>
                    </button>
                    <?php endforeach; ?>

                    <?php if (empty($todasTags)): ?>
                    <span style="font-size:13px;color:#6b7280;">Nenhuma tag cadastrada.</span>
                    <?php endif; ?>
                </div>
                <div class="cli-tags-hint">
                    <i class='bx bx-info-circle'></i> Clique nas tags para ativar ou desativar
                </div>
            </div>
        </div>

        <!-- Footer -->
        <div class="cli-footer">
            <a href="<?= site_url() ?>/clientes" class="cli-btn cli-btn-back">
                <i class='bx bx-x'></i> Cancelar
            </a>
            <button type="submit" class="cli-btn cli-btn-save" id="btnSalvarCliente">
                <i class='bx bx-sync'></i> Atualizar Cliente
            </button>
        </div>

    </form>
</div>

<script>
$(document).ready(function() {

    // ── Toggle senha ─────────────────────────────────────────
    $('#toggleSenha').on('click', function() {
        var input = $('#senha');
        var isPass = input.attr('type') === 'password';
        input.attr('type', isPass ? 'text' : 'password');
        $(this).toggleClass('bx-show bx-hide');
    });

    // ── Estados ──────────────────────────────────────────────
    $.getJSON('<?= base_url() ?>assets/json/estados.json', function(data) {
        $.each(data.estados, function(i, e) {
            $('#estado').append(new Option(e.nome, e.sigla));
        });
        var cur = '<?= $result->estado ?>';
        if (cur) $('#estado option[value=' + cur + ']').prop('selected', true);
    });

    // ── Busca CEP ─────────────────────────────────────────────
    $('#btnBuscarCep, #cep').on('blur', function() {
        var cep = $('#cep').val().replace(/\D/g, '');
        if (cep.length !== 8) return;
        $.getJSON('https://viacep.com.br/ws/' + cep + '/json/', function(d) {
            if (d.erro) return;
            $('#rua').val(d.logradouro);
            $('#bairro').val(d.bairro);
            $('#cidade').val(d.localidade);
            $('#estado option[value=' + d.uf + ']').prop('selected', true);
        });
    });

    // ── Validação ─────────────────────────────────────────────
    $('#formCliente').validate({
        rules: { nomeCliente: { required: true } },
        messages: { nomeCliente: { required: 'Campo obrigatório.' } },
        errorClass: 'help-inline',
        errorElement: 'span',
        submitHandler: function(form) {
            $('#btnSalvarCliente').attr('disabled', true)
                .html('<i class="bx bx-loader-alt bx-spin"></i> Salvando...');
            form.submit();
        }
    });

    // ── TAGs: toggle via AJAX ─────────────────────────────────
    $(document).on('click', '.cli-tag-btn', function() {
        var btn    = $(this);
        var tagId  = btn.data('id');
        var cliId  = btn.data('cliente');
        var ativo  = parseInt(btn.data('ativo'));
        var cor    = btn.data('cor');
        var acao   = ativo ? 'remove' : 'add';

        $.post('<?= site_url('clientes/toggleTag') ?>', {
            clientes_id:     cliId,
            cliente_tags_id: tagId,
            acao:            acao,
            '<?= $this->security->get_csrf_token_name() ?>': '<?= $this->security->get_csrf_hash() ?>'
        }, function(res) {
            if (!res.result) return;
            var novoAtivo = ativo ? 0 : 1;
            btn.data('ativo', novoAtivo);
            if (novoAtivo) {
                btn.addClass('ativa').css('background', cor)
                   .find('i').removeClass('bx-purchase-tag').addClass('bxs-purchase-tag');
            } else {
                btn.removeClass('ativa').css('background', '#2d3247')
                   .find('i').removeClass('bxs-purchase-tag').addClass('bx-purchase-tag');
            }
        }, 'json');
    });

});
</script>
