<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <title>Área do Cliente — <?= $this->config->item('app_name') ?></title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token-name" content="<?= config_item('csrf_token_name') ?>">
    <meta name="csrf-cookie-name" content="<?= config_item('csrf_cookie_name') ?>">
    <link rel="shortcut icon" href="<?= base_url() ?>assets/img/favicon.png">
    <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet">
    <script src="<?= base_url() ?>assets/js/jquery-1.12.4.min.js"></script>
    <script src="<?= base_url() ?>assets/js/jquery.validate.js"></script>
    <script src="<?= base_url() ?>assets/js/sweetalert2.all.min.js"></script>
    <script src="<?= base_url() ?>assets/js/funcoesGlobal.js"></script>
    <script src="<?= base_url() ?>assets/js/csrf.js"></script>
    <style>
    *,*::before,*::after{box-sizing:border-box;margin:0;padding:0;}
    body{min-height:100vh;font-family:-apple-system,BlinkMacSystemFont,'Segoe UI',sans-serif;
         background:#0f1117;display:flex;align-items:center;justify-content:center;padding:20px;}
    body::before{content:'';position:fixed;inset:0;background:
        radial-gradient(ellipse at 20% 50%,rgba(99,102,241,0.12) 0%,transparent 50%),
        radial-gradient(ellipse at 80% 20%,rgba(34,197,94,0.06) 0%,transparent 50%);
        pointer-events:none;z-index:0;}
    .lw{position:relative;z-index:1;width:100%;max-width:420px;}
    .lcard{background:#1a1d2e;border:1px solid rgba(255,255,255,0.08);border-radius:20px;
           padding:36px 32px;box-shadow:0 24px 60px rgba(0,0,0,0.5);}
    .lbrand{text-align:center;margin-bottom:28px;}
    .lbrand img{max-height:54px;max-width:200px;object-fit:contain;margin-bottom:10px;display:block;margin-left:auto;margin-right:auto;}
    .lbrand-icon{width:64px;height:64px;border-radius:18px;background:linear-gradient(135deg,#6366f1,#4f46e5);
        display:flex;align-items:center;justify-content:center;font-size:28px;color:#fff;
        margin:0 auto 12px;box-shadow:0 8px 24px rgba(99,102,241,0.4);}
    .lbrand h1{font-size:20px;font-weight:800;color:#e8eaf0;margin-bottom:4px;}
    .lbrand p{font-size:12px;color:#9ca3af;}
    .lfield{margin-bottom:14px;}
    .llabel{font-size:11px;font-weight:700;color:#9ca3af;text-transform:uppercase;letter-spacing:.5px;display:block;margin-bottom:5px;}
    .liw{position:relative;}
    .linput{width:100%;background:#13151f;border:1px solid #444860;color:#e8eaf0;border-radius:10px;
            padding:11px 14px 11px 42px;font-size:14px;transition:border-color .15s;}
    .linput:focus{border-color:#6366f1;outline:none;}
    .licon{position:absolute;left:13px;top:50%;transform:translateY(-50%);color:#6b7280;font-size:18px;pointer-events:none;}
    .leye{position:absolute;right:12px;top:50%;transform:translateY(-50%);color:#6b7280;font-size:18px;cursor:pointer;}
    .leye:hover{color:#9ca3af;}
    .lbtn{width:100%;padding:12px;border:none;border-radius:10px;font-size:14px;font-weight:700;
          cursor:pointer;display:flex;align-items:center;justify-content:center;gap:8px;
          margin-bottom:10px;transition:all .15s;}
    .lbtn-primary{background:linear-gradient(135deg,#6366f1,#4f46e5);color:#fff;
        box-shadow:0 4px 16px rgba(99,102,241,0.4);}
    .lbtn-primary:hover{transform:translateY(-1px);box-shadow:0 8px 24px rgba(99,102,241,0.5);}
    .lbtn-secondary{background:rgba(34,197,94,0.1);color:#4ade80;border:1px solid rgba(34,197,94,0.3);
        text-decoration:none;}
    .lbtn-secondary:hover{background:rgba(34,197,94,0.2);text-decoration:none;}
    .ldivider{border:none;border-top:1px solid rgba(255,255,255,0.06);margin:16px 0;}
    .llinks{text-align:center;}
    .llinks a{font-size:12px;color:#6b7280;text-decoration:none;}
    .llinks a:hover{color:#9ca3af;}
    .lfooter{text-align:center;margin-top:16px;font-size:11px;color:#4b5563;}
    span.error{color:#f87171;font-size:11px;display:block;margin-top:3px;}
    .bx-spin{animation:sp .8s linear infinite;}
    @keyframes sp{to{transform:rotate(360deg);}}
    </style>
</head>
<body>
<?php
$parse_email = $this->input->get('e') ?? '';
try { $lr=$this->db->where('config','app_logo')->get('configuracoes')->row(); $logoUrl=$lr?$lr->valor:''; }
catch(Exception $e){$logoUrl='';}
?>
<div class="lw">
    <div class="lcard">
        <div class="lbrand">
            <?php if($logoUrl): ?>
            <img src="<?= $logoUrl ?>" alt="Logo">
            <?php else: ?>
            <div class="lbrand-icon"><i class='bx bx-wrench'></i></div>
            <?php endif; ?>
            <h1><?= htmlspecialchars($this->config->item('app_name')) ?></h1>
            <p>Área do Cliente — acesse sua conta</p>
        </div>

        <form id="formLogin" method="post" action="<?= site_url('mine/login') ?>">
            <input type="hidden" name="<?= $this->security->get_csrf_token_name() ?>" value="<?= $this->security->get_csrf_hash() ?>">

            <div class="lfield">
                <label class="llabel">E-mail</label>
                <div class="liw">
                    <i class='bx bx-envelope licon'></i>
                    <input id="email" name="email" type="email" class="linput"
                           placeholder="seu@email.com" value="<?= htmlspecialchars(trim($parse_email)) ?>" autofocus>
                </div>
            </div>

            <div class="lfield">
                <label class="llabel">Senha</label>
                <div class="liw">
                    <i class='bx bx-lock licon'></i>
                    <input id="senha" name="senha" type="password" class="linput"
                           placeholder="Sua senha" style="padding-right:42px;">
                    <i class='bx bx-show leye' id="toggleSenha"></i>
                </div>
            </div>

            <button type="submit" class="lbtn lbtn-primary" id="btnEntrar">
                <i class='bx bx-log-in'></i> Acessar
            </button>
        </form>

        <a href="<?= site_url('mine/cadastrar') ?>" class="lbtn lbtn-secondary">
            <i class='bx bx-user-plus'></i> Cadastrar-me
        </a>

        <hr class="ldivider">

        <div class="llinks">
            <a href="<?= site_url('mine/resetarSenha') ?>">Esqueceu a senha?</a>
        </div>

        <div class="lfooter">
            <?= date('Y') ?> &copy; <?= htmlspecialchars($this->config->item('app_name')) ?>
            — v<?= $this->config->item('app_version') ?>
        </div>
    </div>
</div>

<script>
$('#toggleSenha').on('click',function(){
    var i=$('#senha');
    i.attr('type',i.attr('type')==='password'?'text':'password');
    $(this).toggleClass('bx-show bx-hide');
});

$(document).ready(function(){
    $('#formLogin').validate({
        rules:{email:{required:true,email:true},senha:{required:true}},
        messages:{email:{required:'Campo obrigatório.',email:'E-mail inválido.'},senha:{required:'Campo obrigatório.'}},
        submitHandler:function(form){
            var btn=$('#btnEntrar');
            btn.attr('disabled',true).html('<i class="bx bx-loader bx-spin"></i> Entrando...');
            $.ajax({
                type:'POST',
                url:'<?= base_url() ?>index.php/mine/login?ajax=true',
                data:$(form).serialize(),
                dataType:'json',
                success:function(data){
                    if(data.result==true){
                        window.location.href='<?= base_url() ?>index.php/mine/painel';
                    } else {
                        Swal.fire({icon:'error',title:'Acesso negado',text:'E-mail ou senha incorretos.',confirmButtonColor:'#6366f1'});
                        if(data.SISOS_TOKEN) $("input[name='<?= $this->security->get_csrf_token_name() ?>']").val(data.SISOS_TOKEN);
                        btn.attr('disabled',false).html('<i class="bx bx-log-in"></i> Acessar');
                    }
                },
                error:function(){
                    Swal.fire({icon:'error',title:'Erro de conexão',text:'Tente novamente.'});
                    btn.attr('disabled',false).html('<i class="bx bx-log-in"></i> Acessar');
                }
            });
            return false;
        }
    });
    <?php if($this->session->flashdata('success')): ?>
    Swal.fire({icon:'success',title:'<?= addslashes($this->session->flashdata('success')) ?>',timer:3000,showConfirmButton:false});
    <?php endif; ?>
    <?php if($this->session->flashdata('error')): ?>
    Swal.fire({icon:'error',title:'<?= addslashes($this->session->flashdata('error')) ?>',timer:4000,showConfirmButton:false});
    <?php endif; ?>
});
</script>
</body>
</html>
