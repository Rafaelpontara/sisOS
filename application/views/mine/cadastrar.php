<!DOCTYPE html>
<html lang="pt-br">
<head>
    <title>Cadastro — <?= $this->config->item('app_name') ?></title>
    <meta charset="UTF-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <meta name="csrf-token-name" content="<?= config_item('csrf_token_name') ?>">
    <meta name="csrf-cookie-name" content="<?= config_item('csrf_cookie_name') ?>">
    <link rel="shortcut icon" type="image/png" href="<?= base_url() ?>assets/img/favicon.png"/>
    <link href='https://unpkg.com/boxicons@2.1.1/css/boxicons.min.css' rel='stylesheet'>
    <script src="<?= base_url() ?>assets/js/jquery-1.12.4.min.js"></script>
    <script src="<?= base_url() ?>assets/js/jquery.mask.min.js"></script>
    <script src="<?= base_url() ?>assets/js/sweetalert2.all.min.js"></script>
    <script src="<?= base_url() ?>assets/js/jquery.validate.js"></script>
    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
        body {
            font-family: 'Segoe UI', Arial, sans-serif;
            background: #0f1117;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 24px 16px;
        }

        .cad-wrap {
            width: 100%;
            max-width: 640px;
        }

        /* Logo topo */
        .cad-logo {
            text-align: center;
            margin-bottom: 24px;
        }
        .cad-logo img {
            max-height: 56px;
            max-width: 180px;
            object-fit: contain;
            margin-bottom: 10px;
        }
        .cad-logo h1 {
            font-size: 22px;
            font-weight: 800;
            color: #e8eaf0;
            margin-bottom: 4px;
        }
        .cad-logo p {
            font-size: 13px;
            color: #6b7280;
        }

        /* Card */
        .cad-card {
            background: #1a1d2e;
            border: 1px solid rgba(255,255,255,0.08);
            border-radius: 18px;
            overflow: hidden;
        }
        .cad-card-head {
            padding: 16px 24px;
            background: #252a3a;
            border-bottom: 1px solid rgba(255,255,255,0.06);
            display: flex;
            align-items: center;
            gap: 10px;
        }
        .cad-card-head i { font-size: 20px; color: #6366f1; }
        .cad-card-head span {
            font-size: 14px;
            font-weight: 700;
            color: #e8eaf0;
        }
        .cad-card-body { padding: 24px; }

        /* Seção */
        .cad-section {
            font-size: 10px;
            font-weight: 700;
            color: #6b7280;
            text-transform: uppercase;
            letter-spacing: 1px;
            margin: 20px 0 12px;
            display: flex;
            align-items: center;
            gap: 8px;
        }
        .cad-section::after {
            content: '';
            flex: 1;
            height: 1px;
            background: rgba(255,255,255,0.06);
        }
        .cad-section:first-child { margin-top: 0; }

        /* Grid */
        .cad-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 12px;
        }
        .cad-grid.full { grid-template-columns: 1fr; }
        @media(max-width: 520px) { .cad-grid { grid-template-columns: 1fr; } }

        /* Campo */
        .cad-field { display: flex; flex-direction: column; gap: 5px; }
        .cad-label {
            font-size: 11px;
            font-weight: 700;
            color: #9ca3af;
            text-transform: uppercase;
            letter-spacing: .5px;
        }
        .cad-label .req { color: #f87171; margin-left: 2px; }
        .cad-input, .cad-select {
            background: #252a3a;
            border: 1px solid #444860;
            color: #e8eaf0;
            border-radius: 9px;
            padding: 10px 14px;
            font-size: 13px;
            transition: border-color .15s;
            width: 100%;
            -webkit-appearance: none;
        }
        .cad-input:focus, .cad-select:focus {
            outline: none;
            border-color: #6366f1;
            box-shadow: 0 0 0 3px rgba(99,102,241,0.12);
        }
        .cad-input::placeholder { color: #6b7280; }
        .cad-input.error { border-color: #f87171 !important; }

        /* Senha wrap */
        .cad-pass-wrap { position: relative; }
        .cad-pass-wrap .cad-input { padding-right: 40px; }
        .cad-pass-eye {
            position: absolute;
            right: 12px;
            top: 50%;
            transform: translateY(-50%);
            font-size: 18px;
            color: #6b7280;
            cursor: pointer;
            transition: color .15s;
        }
        .cad-pass-eye:hover { color: #a5b4fc; }

        /* CEP row */
        .cad-cep-row { display: flex; gap: 8px; }
        .cad-cep-row .cad-input { flex: 1; }
        .cad-cep-btn {
            background: rgba(99,102,241,0.15);
            border: 1px solid rgba(99,102,241,0.4);
            color: #a5b4fc;
            border-radius: 9px;
            padding: 0 14px;
            font-size: 18px;
            cursor: pointer;
            transition: all .15s;
            white-space: nowrap;
        }
        .cad-cep-btn:hover { background: rgba(99,102,241,0.3); }

        /* Captcha */
        .cad-captcha {
            display: flex;
            align-items: center;
            gap: 14px;
            margin-top: 4px;
        }
        .cad-captcha img {
            border-radius: 8px;
            border: 1px solid #444860;
            height: 44px;
        }
        .cad-captcha .cad-input { flex: 1; }

        /* Alerta */
        .cad-alert {
            padding: 10px 14px;
            border-radius: 9px;
            font-size: 13px;
            display: flex;
            align-items: center;
            gap: 8px;
            margin-bottom: 16px;
        }
        .cad-alert-err { background: rgba(239,68,68,0.12); border: 1px solid rgba(239,68,68,0.3); color: #f87171; }
        .cad-alert-ok  { background: rgba(34,197,94,0.12);  border: 1px solid rgba(34,197,94,0.3);  color: #4ade80; }

        /* Botões */
        .cad-actions {
            display: flex;
            gap: 10px;
            margin-top: 24px;
            justify-content: flex-end;
        }
        .cad-btn {
            display: inline-flex;
            align-items: center;
            gap: 7px;
            padding: 11px 22px;
            border-radius: 10px;
            font-size: 14px;
            font-weight: 700;
            border: none;
            cursor: pointer;
            text-decoration: none;
            transition: all .15s;
        }
        .cad-btn:hover { transform: translateY(-1px); }
        .cad-btn-primary {
            background: linear-gradient(135deg, #6366f1, #4f46e5);
            color: #fff;
            box-shadow: 0 4px 14px rgba(99,102,241,0.35);
        }
        .cad-btn-ghost {
            background: rgba(255,255,255,0.06);
            color: #9ca3af;
            border: 1px solid rgba(255,255,255,0.1);
        }
        .cad-btn-ghost:hover { background: rgba(255,255,255,0.1); color: #e8eaf0; }

        /* Rodapé */
        .cad-footer {
            text-align: center;
            margin-top: 20px;
            font-size: 12px;
            color: #4b5563;
        }
        .cad-footer a { color: #6366f1; text-decoration: none; }

        /* Spinner CEP */
        .cad-cep-spinner { display: none; font-size: 13px; color: #6b7280; margin-top: 4px; }
    </style>
</head>
<body>

<div class="cad-wrap">

    <!-- Logo -->
    <div class="cad-logo">
        <?php
        $cfg = $this->config->item('app_logo');
        if (!empty($cfg)):
        ?>
        <img src="<?= base_url($cfg) ?>" alt="Logo"><br>
        <?php endif; ?>
        <h1><?= htmlspecialchars($this->config->item('app_name') ?? 'Portal do Cliente') ?></h1>
        <p>Crie sua conta para acompanhar suas Ordens de Serviço</p>
    </div>

    <!-- Card -->
    <div class="cad-card">
        <div class="cad-card-head">
            <i class='bx bx-user-plus'></i>
            <span>Cadastre-se no Sistema</span>
        </div>
        <div class="cad-card-body">

            <?php if ($this->session->flashdata('error')): ?>
            <div class="cad-alert cad-alert-err">
                <i class='bx bx-error-circle'></i>
                <?= htmlspecialchars($this->session->flashdata('error')) ?>
            </div>
            <?php endif; ?>

            <?php if ($this->session->flashdata('success')): ?>
            <div class="cad-alert cad-alert-ok">
                <i class='bx bx-check-circle'></i>
                <?= htmlspecialchars($this->session->flashdata('success')) ?>
            </div>
            <?php endif; ?>

            <form action="<?= current_url() ?>" id="formCliente" method="post">
                <input type="hidden" name="<?= $this->security->get_csrf_token_name() ?>" value="<?= $this->security->get_csrf_hash() ?>">

                <!-- Dados pessoais -->
                <div class="cad-section"><i class='bx bx-user'></i> Dados Pessoais</div>
                <div class="cad-grid">
                    <div class="cad-field">
                        <label class="cad-label">Nome<span class="req">*</span></label>
                        <input id="nomeCliente" type="text" name="nomeCliente" class="cad-input" placeholder="Nome completo" value="<?= set_value('nomeCliente') ?>">
                    </div>
                    <div class="cad-field">
                        <label class="cad-label">CPF / CNPJ<span class="req">*</span></label>
                        <input id="documento" type="text" name="documento" class="cad-input cpfcnpj" placeholder="000.000.000-00" value="<?= set_value('documento') ?>">
                    </div>
                    <div class="cad-field">
                        <label class="cad-label">Telefone<span class="req">*</span></label>
                        <input id="telefone" type="text" name="telefone" class="cad-input" placeholder="(00) 0000-0000" value="<?= set_value('telefone') ?>">
                    </div>
                    <div class="cad-field">
                        <label class="cad-label">Celular / WhatsApp</label>
                        <input id="celular" type="text" name="celular" class="cad-input" placeholder="(00) 00000-0000" value="<?= set_value('celular') ?>">
                    </div>
                </div>

                <!-- Acesso -->
                <div class="cad-section"><i class='bx bx-lock'></i> Dados de Acesso</div>
                <div class="cad-grid">
                    <div class="cad-field">
                        <label class="cad-label">E-mail<span class="req">*</span></label>
                        <input id="email" type="email" name="email" class="cad-input" placeholder="seu@email.com" value="<?= set_value('email') ?>">
                    </div>
                    <div class="cad-field">
                        <label class="cad-label">Senha<span class="req">*</span></label>
                        <div class="cad-pass-wrap">
                            <input id="senha" type="password" name="senha" class="cad-input" placeholder="Mínimo 6 caracteres">
                            <i class='bx bx-show cad-pass-eye' id="toggleSenha"></i>
                        </div>
                    </div>
                </div>

                <!-- Endereço -->
                <div class="cad-section"><i class='bx bx-map'></i> Endereço</div>
                <div class="cad-grid">
                    <div class="cad-field">
                        <label class="cad-label">CEP<span class="req">*</span></label>
                        <div class="cad-cep-row">
                            <input id="cep" type="text" name="cep" class="cad-input" placeholder="00000-000" value="<?= set_value('cep') ?>">
                            <button type="button" class="cad-cep-btn" id="btnCep" title="Buscar CEP">
                                <i class='bx bx-search-alt'></i>
                            </button>
                        </div>
                        <span class="cad-cep-spinner" id="cepSpinner"><i class='bx bx-loader-alt bx-spin'></i> Buscando...</span>
                    </div>
                    <div class="cad-field">
                        <label class="cad-label">Rua<span class="req">*</span></label>
                        <input id="rua" type="text" name="rua" class="cad-input" placeholder="Nome da rua" value="<?= set_value('rua') ?>">
                    </div>
                    <div class="cad-field">
                        <label class="cad-label">Número<span class="req">*</span></label>
                        <input id="numero" type="text" name="numero" class="cad-input" placeholder="Nº" value="<?= set_value('numero') ?>">
                    </div>
                    <div class="cad-field">
                        <label class="cad-label">Complemento</label>
                        <input id="complemento" type="text" name="complemento" class="cad-input" placeholder="Apto, sala..." value="<?= set_value('complemento') ?>">
                    </div>
                    <div class="cad-field">
                        <label class="cad-label">Bairro<span class="req">*</span></label>
                        <input id="bairro" type="text" name="bairro" class="cad-input" placeholder="Bairro" value="<?= set_value('bairro') ?>">
                    </div>
                    <div class="cad-field">
                        <label class="cad-label">Cidade<span class="req">*</span></label>
                        <input id="cidade" type="text" name="cidade" class="cad-input" placeholder="Cidade" value="<?= set_value('cidade') ?>">
                    </div>
                    <div class="cad-field">
                        <label class="cad-label">Contato<span class="req">*</span></label>
                        <input id="contato" type="text" name="contato" class="cad-input" placeholder="Nome do contato" value="<?= set_value('contato') ?>">
                    </div>
                    <div class="cad-field">
                        <label class="cad-label">Estado<span class="req">*</span></label>
                        <select id="estado" name="estado" class="cad-select">
                            <option value="">Selecione o Estado...</option>
                        </select>
                    </div>
                </div>

                <!-- Captcha -->
                <div class="cad-section"><i class='bx bx-shield'></i> Verificação</div>
                <div class="cad-field">
                    <label class="cad-label">Digite o texto da imagem<span class="req">*</span></label>
                    <div class="cad-captcha">
                        <img src="<?= base_url() ?>index.php/mine/captcha" alt="Captcha" id="imgCaptcha">
                        <input id="captcha" type="text" name="captcha" class="cad-input" placeholder="Texto da imagem">
                    </div>
                    <span style="font-size:11px;color:#6b7280;margin-top:4px;">
                        <a href="#" onclick="document.getElementById('imgCaptcha').src='<?= base_url() ?>index.php/mine/captcha?r='+Math.random();return false;" style="color:#6366f1;">
                            <i class='bx bx-refresh'></i> Gerar novo
                        </a>
                    </span>
                </div>

                <!-- Ações -->
                <div class="cad-actions">
                    <a href="<?= site_url('mine') ?>" class="cad-btn cad-btn-ghost">
                        <i class='bx bx-arrow-back'></i> Voltar
                    </a>
                    <button type="submit" class="cad-btn cad-btn-primary">
                        <i class='bx bx-user-plus'></i> Cadastrar
                    </button>
                </div>

            </form>
        </div>
    </div>

    <div class="cad-footer">
        <?= date('Y') ?> &copy; Rafael — <?= $this->config->item('app_name') ?> v<?= $this->config->item('app_version') ?>
        &nbsp;|&nbsp; <a href="<?= site_url('mine') ?>">Voltar ao login</a>
    </div>
</div>

<script>
// Toggle senha
document.getElementById('toggleSenha').addEventListener('click', function() {
    var inp = document.getElementById('senha');
    inp.type = inp.type === 'password' ? 'text' : 'password';
    this.classList.toggle('bx-show');
    this.classList.toggle('bx-hide');
});

// Carregar estados
$.getJSON('<?= base_url() ?>assets/json/estados.json', function(data) {
    var curState = '<?= set_value('estado') ?>';
    for (var i in data.estados) {
        var opt = new Option(data.estados[i].nome, data.estados[i].sigla);
        if (data.estados[i].sigla === curState) opt.selected = true;
        $('#estado').append(opt);
    }
});

// Busca CEP
function buscarCep() {
    var cep = $('#cep').val().replace(/\D/g,'');
    if (cep.length !== 8) return;
    $('#cepSpinner').show();
    $.getJSON('https://viacep.com.br/ws/' + cep + '/json/', function(d) {
        $('#cepSpinner').hide();
        if (!d.erro) {
            $('#rua').val(d.logradouro);
            $('#bairro').val(d.bairro);
            $('#cidade').val(d.localidade);
            $('#estado option[value=' + d.uf + ']').prop('selected', true);
            $('#numero').focus();
        }
    }).fail(function() { $('#cepSpinner').hide(); });
}
$('#btnCep').on('click', buscarCep);
$('#cep').on('blur', buscarCep);

// Máscaras
$('#telefone').mask('(00) 0000-00009');
$('#celular').mask('(00) 00000-0000');
$('#cep').mask('00000-000');

// Validação
$('#formCliente').validate({
    rules: {
        nomeCliente: { required: true, minlength: 3 },
        documento:   { required: true },
        telefone:    { required: true },
        email:       { required: true, email: true },
        senha:       { required: true, minlength: 6 },
        cep:         { required: true },
        rua:         { required: true },
        numero:      { required: true },
        bairro:      { required: true },
        cidade:      { required: true },
        contato:     { required: true },
        estado:      { required: true },
        captcha:     { required: true },
    },
    messages: {
        nomeCliente: { required: 'Nome é obrigatório.', minlength: 'Mínimo 3 caracteres.' },
        documento:   { required: 'CPF/CNPJ é obrigatório.' },
        telefone:    { required: 'Telefone é obrigatório.' },
        email:       { required: 'E-mail é obrigatório.', email: 'E-mail inválido.' },
        senha:       { required: 'Senha é obrigatória.', minlength: 'Mínimo 6 caracteres.' },
        cep:         { required: 'CEP é obrigatório.' },
        rua:         { required: 'Rua é obrigatória.' },
        numero:      { required: 'Número é obrigatório.' },
        bairro:      { required: 'Bairro é obrigatório.' },
        cidade:      { required: 'Cidade é obrigatória.' },
        contato:     { required: 'Contato é obrigatório.' },
        estado:      { required: 'Estado é obrigatório.' },
        captcha:     { required: 'Digite o texto da imagem.' },
    },
    errorClass: 'error',
    errorElement: 'span',
    errorPlacement: function(error, element) {
        error.css({'color':'#f87171','font-size':'11px','margin-top':'3px','display':'block'});
        error.insertAfter(element.closest('.cad-pass-wrap, .cad-cep-row') || element);
    },
    highlight: function(el) { $(el).addClass('error'); },
    unhighlight: function(el) { $(el).removeClass('error'); }
});

<?php if ($this->session->flashdata('success')): ?>
Swal.fire({ icon: 'success', title: '<?= $this->session->flashdata('success') ?>', timer: 4000, showConfirmButton: false });
<?php endif; ?>
<?php if ($this->session->flashdata('error')): ?>
Swal.fire({ icon: 'error', title: '<?= $this->session->flashdata('error') ?>', timer: 4000, showConfirmButton: false });
<?php endif; ?>
</script>
</body>
</html>
