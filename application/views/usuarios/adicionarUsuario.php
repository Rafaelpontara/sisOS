<script src="<?= base_url() ?>assets/js/jquery.mask.min.js"></script>
<script src="<?= base_url() ?>assets/js/sweetalert2.all.min.js"></script>
<script src="<?= base_url() ?>assets/js/funcoes.js"></script>
<script src="<?= base_url() ?>assets/js/jquery.validate.js"></script>

<style>
.fu-wrap { max-width: 860px; }
.fu-header { display: flex; align-items: center; justify-content: space-between; margin-bottom: 20px; }
.fu-title { display: flex; align-items: center; gap: 10px; }
.fu-title i { font-size: 22px; color: #7c6af7; }
.fu-title h4 { margin: 0; font-size: 16px; font-weight: 700; color: #e2e4f0; }
.fu-card { background: #181b2a; border: 1px solid rgba(255,255,255,.07); border-radius: 14px; overflow: hidden; margin-bottom: 14px; }
.fu-card-head { display: flex; align-items: center; gap: 9px; padding: 13px 18px; background: #21253a; border-bottom: 1px solid rgba(255,255,255,.06); }
.fu-card-head i { font-size: 16px; }
.fu-card-head span { font-size: 11px; font-weight: 700; color: #9ca3af; text-transform: uppercase; letter-spacing: .7px; }
.fu-card-body { padding: 20px; }
.fu-grid-2 { display: grid; grid-template-columns: 1fr 1fr; gap: 14px; }
.fu-grid-3 { display: grid; grid-template-columns: 2fr 1fr 1fr; gap: 14px; }
.fu-grid-1 { display: grid; grid-template-columns: 1fr; gap: 14px; }
@media(max-width:600px) { .fu-grid-2,.fu-grid-3 { grid-template-columns: 1fr; } }
.fu-field { display: flex; flex-direction: column; gap: 5px; }
.fu-label { font-size: 11px; font-weight: 700; color: #6b7280; text-transform: uppercase; letter-spacing: .5px; }
.fu-label .req { color: #f87171; margin-left: 2px; }
.fu-input { background: #13151f; border: 1px solid #3b3f58; color: #e2e4f0; border-radius: 8px; padding: 9px 12px; font-size: 13px; transition: border-color .15s; width: 100%; box-sizing: border-box; }
.fu-input:focus { border-color: #7c6af7; outline: none; box-shadow: 0 0 0 3px rgba(124,106,247,.1); }
.fu-input::placeholder { color: #4b5563; }
.fu-input.error { border-color: #f87171 !important; }
.fu-select { background: #13151f; border: 1px solid #3b3f58; color: #e2e4f0; border-radius: 8px; padding: 9px 12px; font-size: 13px; width: 100%; box-sizing: border-box; cursor: pointer; }
.fu-select:focus { border-color: #7c6af7; outline: none; }
.fu-eye-wrap { position: relative; }
.fu-eye-wrap .fu-input { padding-right: 38px; }
.fu-eye { position: absolute; right: 11px; top: 50%; transform: translateY(-50%); cursor: pointer; color: #6b7280; font-size: 16px; transition: color .15s; }
.fu-eye:hover { color: #e2e4f0; }
.fu-actions { display: flex; gap: 10px; padding: 16px 20px; background: #21253a; border-top: 1px solid rgba(255,255,255,.06); justify-content: flex-end; }
.fu-btn-save { display: inline-flex; align-items: center; gap: 7px; padding: 10px 22px; background: linear-gradient(135deg,#7c6af7,#5b4de0); color: #fff; border: none; border-radius: 8px; font-size: 13px; font-weight: 700; cursor: pointer; transition: opacity .15s; }
.fu-btn-save:hover { opacity: .85; }
.fu-btn-back { display: inline-flex; align-items: center; gap: 7px; padding: 10px 18px; background: rgba(255,255,255,.06); color: #9ca3af; border: 1px solid rgba(255,255,255,.1); border-radius: 8px; font-size: 13px; font-weight: 600; text-decoration: none; transition: all .15s; }
.fu-btn-back:hover { background: rgba(255,255,255,.1); color: #e2e4f0; }
.fu-alert-error { background: rgba(239,68,68,.1); border: 1px solid rgba(239,68,68,.25); border-radius: 10px; padding: 12px 16px; margin-bottom: 16px; color: #fca5a5; font-size: 13px; display: flex; align-items: center; gap: 8px; }
span.error { color: #f87171; font-size: 11px; margin-top: 3px; display: block; }
</style>

<div class="fu-wrap">
    <div class="fu-header">
        <div class="fu-title">
            <i class='bx bx-user-plus'></i>
            <h4>Cadastro de Usuário</h4>
        </div>
        <a href="<?= base_url() ?>index.php/usuarios" class="fu-btn-back">
            <i class='bx bx-arrow-back'></i> Voltar
        </a>
    </div>

    <?php if ($custom_error != ''): ?>
        <div class="fu-alert-error">
            <i class='bx bx-error-circle'></i> <?= $custom_error ?>
        </div>
    <?php endif; ?>

    <form action="<?= current_url() ?>" id="formUsuario" method="post">

        <!-- Dados Pessoais -->
        <div class="fu-card">
            <div class="fu-card-head">
                <i class='bx bx-id-card' style="color:#7c6af7;"></i>
                <span>Dados Pessoais</span>
            </div>
            <div class="fu-card-body">
                <div class="fu-grid-2" style="margin-bottom:14px;">
                    <div class="fu-field">
                        <label class="fu-label">Nome completo <span class="req">*</span></label>
                        <input type="text" name="nome" id="nome" class="fu-input" placeholder="Nome do usuário" value="<?= set_value('nome') ?>">
                    </div>
                    <div class="fu-field">
                        <label class="fu-label">E-mail <span class="req">*</span></label>
                        <input type="text" name="email" id="email" class="fu-input" placeholder="email@empresa.com" value="<?= set_value('email') ?>">
                    </div>
                </div>
                <div class="fu-grid-2" style="margin-bottom:14px;">
                    <div class="fu-field">
                        <label class="fu-label">CPF <span class="req">*</span></label>
                        <input type="text" name="cpf" id="cpfUser" class="fu-input" placeholder="000.000.000-00" value="<?= set_value('cpf') ?>">
                    </div>
                    <div class="fu-field">
                        <label class="fu-label">RG</label>
                        <input type="text" name="rg" id="rg" class="fu-input" placeholder="Documento RG" value="<?= set_value('rg') ?>">
                    </div>
                </div>
                <div class="fu-grid-2">
                    <div class="fu-field">
                        <label class="fu-label">Telefone <span class="req">*</span></label>
                        <input type="text" name="telefone" id="telefone" class="fu-input" placeholder="(00) 0000-0000" value="<?= set_value('telefone') ?>">
                    </div>
                    <div class="fu-field">
                        <label class="fu-label">Celular</label>
                        <input type="text" name="celular" id="celular" class="fu-input" placeholder="(00) 00000-0000" value="<?= set_value('celular') ?>">
                    </div>
                </div>
            </div>
        </div>

        <!-- Senha e Acesso -->
        <div class="fu-card">
            <div class="fu-card-head">
                <i class='bx bx-lock-alt' style="color:#f59e0b;"></i>
                <span>Acesso ao Sistema</span>
            </div>
            <div class="fu-card-body">
                <div class="fu-grid-2" style="margin-bottom:14px;">
                    <div class="fu-field">
                        <label class="fu-label">Senha <span class="req">*</span></label>
                        <div class="fu-eye-wrap">
                            <input type="password" name="senha" id="senha" class="fu-input" placeholder="Mínimo 6 caracteres" value="<?= set_value('senha') ?>">
                            <i class='bx bx-hide fu-eye' id="toggleSenha"></i>
                        </div>
                    </div>
                    <div class="fu-field">
                        <label class="fu-label">Expira em <span class="req">*</span></label>
                        <input type="date" name="dataExpiracao" id="dataExpiracao" class="fu-input" value="<?= set_value('dataExpiracao') ?>">
                    </div>
                </div>
                <div class="fu-grid-2">
                    <div class="fu-field">
                        <label class="fu-label">Situação <span class="req">*</span></label>
                        <select name="situacao" id="situacao" class="fu-select">
                            <option value="1">✅ Ativo</option>
                            <option value="0">❌ Inativo</option>
                        </select>
                    </div>
                    <div class="fu-field">
                        <label class="fu-label">Perfil de Permissões <span class="req">*</span></label>
                        <select name="permissoes_id" id="permissoes_id" class="fu-select">
                            <?php foreach ($permissoes as $p): ?>
                                <option value="<?= $p->idPermissao ?>"><?= htmlspecialchars($p->nome) ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
            </div>
        </div>

        <!-- Endereço -->
        <div class="fu-card">
            <div class="fu-card-head">
                <i class='bx bx-map-pin' style="color:#34d399;"></i>
                <span>Endereço</span>
            </div>
            <div class="fu-card-body">
                <div class="fu-grid-2" style="margin-bottom:14px;">
                    <div class="fu-field">
                        <label class="fu-label">CEP <span class="req">*</span></label>
                        <input type="text" name="cep" id="cep" class="fu-input" placeholder="00000-000" value="<?= set_value('cep') ?>">
                    </div>
                    <div class="fu-field">
                        <label class="fu-label">Número <span class="req">*</span></label>
                        <input type="text" name="numero" id="numero" class="fu-input" placeholder="Nº" value="<?= set_value('numero') ?>">
                    </div>
                </div>
                <div class="fu-grid-2" style="margin-bottom:14px;">
                    <div class="fu-field">
                        <label class="fu-label">Logradouro <span class="req">*</span></label>
                        <input type="text" name="rua" id="rua" class="fu-input" placeholder="Rua / Av." value="<?= set_value('rua') ?>">
                    </div>
                    <div class="fu-field">
                        <label class="fu-label">Bairro <span class="req">*</span></label>
                        <input type="text" name="bairro" id="bairro" class="fu-input" placeholder="Bairro" value="<?= set_value('bairro') ?>">
                    </div>
                </div>
                <div class="fu-grid-2">
                    <div class="fu-field">
                        <label class="fu-label">Cidade <span class="req">*</span></label>
                        <input type="text" name="cidade" id="cidade" class="fu-input" placeholder="Cidade" value="<?= set_value('cidade') ?>">
                    </div>
                    <div class="fu-field">
                        <label class="fu-label">Estado <span class="req">*</span></label>
                        <input type="text" name="estado" id="estado" class="fu-input" placeholder="Ex: MA" maxlength="2" value="<?= set_value('estado') ?>">
                    </div>
                </div>
            </div>
        </div>

        <div class="fu-actions" style="background:transparent;padding:0;justify-content:flex-start;margin-top:4px;">
            <button type="submit" class="fu-btn-save">
                <i class='bx bx-user-check'></i> Cadastrar Usuário
            </button>
            <a href="<?= base_url() ?>index.php/usuarios" class="fu-btn-back">
                <i class='bx bx-x'></i> Cancelar
            </a>
        </div>

    </form>
</div>

<script>
$(document).ready(function() {
    // Máscara
    $('#cpfUser').mask('000.000.000-00');
    $('#telefone').mask('(00) 0000-0000');
    $('#celular').mask('(00) 00000-0000');
    $('#cep').mask('00000-000');

    // Mostrar/ocultar senha
    $('#toggleSenha').click(function() {
        var s = $('#senha');
        if (s.attr('type') === 'password') {
            s.attr('type', 'text');
            $(this).removeClass('bx-hide').addClass('bx-show');
        } else {
            s.attr('type', 'password');
            $(this).removeClass('bx-show').addClass('bx-hide');
        }
    });

    // Busca CEP
    $('#cep').blur(function() {
        var cep = $(this).val().replace(/\D/g, '');
        if (cep.length === 8) {
            $.getJSON('https://viacep.com.br/ws/' + cep + '/json/', function(d) {
                if (!d.erro) {
                    $('#rua').val(d.logradouro);
                    $('#bairro').val(d.bairro);
                    $('#cidade').val(d.localidade);
                    $('#estado').val(d.uf);
                }
            });
        }
    });

    // Validação
    $('#formUsuario').validate({
        rules: {
            nome:          { required: true },
            email:         { required: true, email: true },
            cpf:           { required: true },
            telefone:      { required: true },
            senha:         { required: true, minlength: 6 },
            dataExpiracao: { required: true },
            cep:           { required: true },
            rua:           { required: true },
            numero:        { required: true },
            bairro:        { required: true },
            cidade:        { required: true },
            estado:        { required: true }
        },
        messages: {
            nome:          { required: 'Campo obrigatório' },
            email:         { required: 'Campo obrigatório', email: 'E-mail inválido' },
            cpf:           { required: 'Campo obrigatório' },
            telefone:      { required: 'Campo obrigatório' },
            senha:         { required: 'Campo obrigatório', minlength: 'Mínimo 6 caracteres' },
            dataExpiracao: { required: 'Campo obrigatório' },
            cep:           { required: 'Campo obrigatório' },
            rua:           { required: 'Campo obrigatório' },
            numero:        { required: 'Campo obrigatório' },
            bairro:        { required: 'Campo obrigatório' },
            cidade:        { required: 'Campo obrigatório' },
            estado:        { required: 'Campo obrigatório' }
        },
        errorClass: 'error',
        errorElement: 'span',
        highlight: function(el) { $(el).addClass('error'); },
        unhighlight: function(el) { $(el).removeClass('error'); }
    });
});
</script>
