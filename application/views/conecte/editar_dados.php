<script src="<?= base_url() ?>assets/js/jquery.mask.min.js"></script>
<script src="<?= base_url() ?>assets/js/sweetalert2.all.min.js"></script>
<script src="<?= base_url() ?>assets/js/funcoes.js"></script>
<script src="<?= base_url() ?>assets/js/jquery.validate.js"></script>

<div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:18px;flex-wrap:wrap;gap:10px;">
    <h2 style="font-size:18px;font-weight:800;color:#e8eaf0;display:flex;align-items:center;gap:8px;">
        <i class='bx bx-edit' style="color:#6366f1;"></i> Editar Meus Dados
    </h2>
    <a href="<?= base_url() ?>index.php/mine/conta" class="mc-btn mc-btn-ghost"><i class='bx bx-arrow-back'></i> Voltar</a>
</div>

<?php if (!empty($custom_error)): ?>
<div class="mc-alert mc-alert-err"><i class='bx bx-error-circle'></i> <?= $custom_error ?></div>
<?php endif; ?>

<form action="<?= current_url() ?>" id="formCliente" method="post">
    <input type="hidden" name="<?= $this->security->get_csrf_token_name() ?>" value="<?= $this->security->get_csrf_hash() ?>">
    <input type="hidden" name="idClientes" value="<?= $result->idClientes ?>">

    <!-- Dados Pessoais -->
    <div class="mc-card">
        <div class="mc-card-head"><div class="mc-card-head-left"><i class='bx bx-id-card' style="color:#6366f1;"></i><span>Dados Pessoais</span></div></div>
        <div class="mc-card-body">
            <div class="mc-grid-2">
                <div class="mc-form-group">
                    <label class="mc-label">Nome <span class="req">*</span></label>
                    <input id="nomeCliente" type="text" name="nomeCliente" class="mc-input" value="<?= htmlspecialchars($result->nomeCliente) ?>" required>
                </div>
                <div class="mc-form-group">
                    <label class="mc-label">Contato</label>
                    <input id="contato" type="text" name="contato" class="mc-input" value="<?= htmlspecialchars($result->contato??'') ?>">
                </div>
                <div class="mc-form-group">
                    <label class="mc-label">CPF / CNPJ</label>
                    <div style="display:flex;gap:8px;">
                        <input id="documento" class="mc-input cpfcnpjmine" type="text" name="documento" value="<?= htmlspecialchars($result->documento??'') ?>">
                        <button id="buscar_info_cnpj" class="mc-btn mc-btn-ghost" type="button" style="padding:8px 12px;flex-shrink:0;" title="Buscar dados do CNPJ">
                            <i class='bx bx-search'></i>
                        </button>
                    </div>
                </div>
                <div class="mc-form-group">
                    <label class="mc-label">Data de Nascimento</label>
                    <input type="text" name="nascimento" class="mc-input datepicker" autocomplete="off"
                        value="<?= !empty($result->nascimento)&&$result->nascimento!='0000-00-00'?date('d/m/Y',strtotime($result->nascimento)):'' ?>">
                </div>
            </div>
        </div>
    </div>

    <!-- Contatos -->
    <div class="mc-card">
        <div class="mc-card-head"><div class="mc-card-head-left"><i class='bx bx-phone' style="color:#22c55e;"></i><span>Contatos</span></div></div>
        <div class="mc-card-body">
            <div class="mc-grid-2">
                <div class="mc-form-group">
                    <label class="mc-label">Telefone <span class="req">*</span></label>
                    <input id="telefone" type="text" name="telefone" class="mc-input" value="<?= htmlspecialchars($result->telefone??'') ?>">
                </div>
                <div class="mc-form-group">
                    <label class="mc-label">Celular / WhatsApp</label>
                    <input id="celular" type="text" name="celular" class="mc-input" value="<?= htmlspecialchars($result->celular??'') ?>">
                </div>
                <div class="mc-form-group" style="grid-column:span 2;">
                    <label class="mc-label">E-mail</label>
                    <input type="email" name="email" class="mc-input" value="<?= htmlspecialchars($result->email??'') ?>">
                </div>
            </div>
        </div>
    </div>

    <!-- Endereço -->
    <div class="mc-card">
        <div class="mc-card-head"><div class="mc-card-head-left"><i class='bx bx-map' style="color:#60a5fa;"></i><span>Endereço</span></div></div>
        <div class="mc-card-body">
            <div class="mc-grid-2">
                <div class="mc-form-group" style="grid-column:span 2;">
                    <label class="mc-label">Rua / Logradouro</label>
                    <input type="text" name="rua" class="mc-input" value="<?= htmlspecialchars($result->rua??'') ?>">
                </div>
                <div class="mc-form-group">
                    <label class="mc-label">Número</label>
                    <input type="text" name="numero" class="mc-input" value="<?= htmlspecialchars($result->numero??'') ?>">
                </div>
                <div class="mc-form-group">
                    <label class="mc-label">Complemento</label>
                    <input type="text" name="complemento" class="mc-input" value="<?= htmlspecialchars($result->complemento??'') ?>">
                </div>
                <div class="mc-form-group">
                    <label class="mc-label">Bairro</label>
                    <input type="text" name="bairro" class="mc-input" value="<?= htmlspecialchars($result->bairro??'') ?>">
                </div>
                <div class="mc-form-group">
                    <label class="mc-label">CEP</label>
                    <input id="cep" type="text" name="cep" class="mc-input" value="<?= htmlspecialchars($result->cep??'') ?>">
                </div>
                <div class="mc-form-group">
                    <label class="mc-label">Cidade</label>
                    <input id="cidade" type="text" name="cidade" class="mc-input" value="<?= htmlspecialchars($result->cidade??'') ?>">
                </div>
                <div class="mc-form-group">
                    <label class="mc-label">Estado</label>
                    <input id="estado" type="text" name="estado" class="mc-input" value="<?= htmlspecialchars($result->estado??'') ?>" maxlength="2">
                </div>
            </div>
        </div>
    </div>

    <!-- Senha -->
    <div class="mc-card">
        <div class="mc-card-head"><div class="mc-card-head-left"><i class='bx bx-lock' style="color:#fbbf24;"></i><span>Senha de Acesso</span></div></div>
        <div class="mc-card-body">
            <div style="max-width:360px;">
                <div class="mc-form-group">
                    <label class="mc-label">Nova Senha <span style="color:#6b7280;font-weight:400;text-transform:none;letter-spacing:0;">(deixe vazio para não alterar)</span></label>
                    <input type="password" name="senha" class="mc-input" placeholder="Mínimo 6 caracteres" autocomplete="new-password">
                </div>
            </div>
            <div style="font-size:12px;color:#6b7280;"><i class='bx bx-info-circle'></i> Sua senha é usada para acessar esta área do cliente.</div>
        </div>
    </div>

    <div style="display:flex;gap:8px;justify-content:flex-end;padding:4px 0 8px;">
        <a href="<?= base_url() ?>index.php/mine/conta" class="mc-btn mc-btn-ghost"><i class='bx bx-x'></i> Cancelar</a>
        <button type="submit" class="mc-btn mc-btn-success" id="btnSalvar"><i class='bx bx-save'></i> Salvar Alterações</button>
    </div>
</form>

<script>
$(document).ready(function(){
    $('#telefone').mask('(00) 0000-0000');
    $('#celular').mask('(00) 00000-0000');
    $('.datepicker').datepicker({ dateFormat:'dd/mm/yy' });
    $('#formCliente').validate({
        rules:{ nomeCliente:{required:true}, telefone:{required:true} },
        messages:{ nomeCliente:{required:'Campo obrigatório.'}, telefone:{required:'Campo obrigatório.'} },
        submitHandler: function(f){ $('#btnSalvar').attr('disabled',true).html('<i class="bx bx-loader-alt bx-spin"></i> Salvando...'); f.submit(); }
    });
});
</script>
