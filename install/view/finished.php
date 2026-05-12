<div class="section text-center" style="padding: 40px 24px;">
  <div class="clearfix">

    <?php if (! $installed) { ?>

      <div style="margin-bottom: 20px;">
        <i class="status fa fa-check-circle-o" style="font-size: 56px; color: #4ade80;"></i>
      </div>

      <h4 style="color: #e8eaf0; font-family: 'Rajdhani', sans-serif; font-size: 1.4rem; margin-bottom: 8px;">
        Instalação concluída com sucesso!
      </h4>
      <p style="color: #7a7f9a; font-size: 13px; margin-bottom: 6px;">
        O <strong style="color:#f5a623;"><?php echo $settings['title']; ?></strong> está pronto para uso.
      </p>

      <div style="margin: 20px auto; padding: 12px 20px; background: rgba(248,113,113,0.10); border-radius: 10px; max-width: 480px; border: 1px solid rgba(248,113,113,0.2);">
        <i class="fa fa-exclamation-triangle" style="color:#f87171; margin-right:6px;"></i>
        <span style="color: #fca5a5; font-size: 13px;">
          Por segurança, <strong>delete a pasta <code style="background:rgba(255,255,255,0.08);padding:2px 6px;border-radius:4px;">install/</code></strong> do servidor após concluir.
        </span>
      </div>

    <?php } else { ?>

      <div style="margin-bottom: 20px;">
        <i class="fa fa-close" style="font-size: 56px; color: #f87171;"></i>
      </div>

      <h4 style="color: #e8eaf0; font-family: 'Rajdhani', sans-serif; font-size: 1.4rem; margin-bottom: 8px;">
        Sistema já instalado
      </h4>
      <p style="color: #7a7f9a; font-size: 13px;">
        O SISOS já foi instalado anteriormente. Não é possível reinstalar.
      </p>

    <?php } ?>

    <a class="go-to-login-page" href="<?php echo $dashboard_url; ?>">
      <div>
        <div><i class="fa fa-desktop"></i></div>
        <div style="font-size: 14px; font-weight: 600; letter-spacing: 0.06em;">IR PARA O SISTEMA</div>
      </div>
    </a>

  </div>
</div>
