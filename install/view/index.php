<!DOCTYPE html>
<html lang="pt-BR">

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=Edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="description" content="<?php echo $settings['title']; ?>">
  <link rel="shortcut icon" href="<?php echo $dashboard_url; ?>install/assets/images/favicon.ico" type="image/x-icon" />

  <title><?php echo $settings['title']; ?></title>

  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link href="https://fonts.googleapis.com/css2?family=Rajdhani:wght@600;700&family=Inter:wght@400;500;600&display=swap" rel="stylesheet">
  <link rel='stylesheet' type='text/css' href='<?php echo $dashboard_url; ?>install/assets/css/bootstrap.min.css' />
  <link rel='stylesheet' type='text/css' href='https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css' />
  <link rel='stylesheet' type='text/css' href='<?php echo $dashboard_url; ?>install/assets/css/install.css' />
  <link rel='stylesheet' type='text/css' href='<?php echo $dashboard_url; ?>install/assets/css/custom.css' />

  <script type='text/javascript' src='<?php echo $dashboard_url; ?>install/assets/js/jquery.min.js'></script>
  <script type='text/javascript' src='<?php echo $dashboard_url; ?>install/assets/js/jquery.validate.min.js'></script>
  <script type='text/javascript' src='<?php echo $dashboard_url; ?>install/assets/js/jquery.form.js'></script>
</head>

<body>
  <div class="install-box">
    <div class="panel panel-install">

      <div class="panel-heading text-center">
        <img id="logo" src="<?php echo $dashboard_url; ?>assets/img/logo-sisos.png" title="SISOS" onerror="this.style.display='none'" />
        <h3 style="font-family:'Rajdhani',sans-serif;font-size:1.5rem;letter-spacing:0.1em;">
          SISOS <span style="color:#f5a623;">|</span>
          <span style="font-weight:400;font-size:1rem;color:#7a7f9a;">Sistema de Ordens de Serviço</span>
        </h3>
      </div>

      <div class="panel-body no-padding">

        <?php if (! $installed) { ?>
          <div class="tab-container clearfix">
            <div id="pre-installation" class="tab-title col-sm-4 active">
              <i class="fa fa-list-ul"></i>
              <strong> Pré-Instalação</strong>
            </div>
            <div id="configuration" class="tab-title col-sm-4">
              <i class="fa fa-cog"></i>
              <strong> Configuração</strong>
            </div>
            <div id="finished" class="tab-title col-sm-4">
              <i class="fa fa-check"></i>
              <strong> Finalização</strong>
            </div>
          </div>
        <?php } ?>

        <div id="alert-container"></div>

        <div class="tab-content">
          <div role="tabpanel" class="tab-pane active" id="pre-installation-tab">
            <?php include_once 'pre-installation.php'; ?>
          </div>
          <div role="tabpanel" class="tab-pane" id="configuration-tab">
            <?php include_once 'configuration.php'; ?>
          </div>
          <div role="tabpanel" class="tab-pane" id="finished-tab">
            <?php include_once 'finished.php'; ?>
          </div>
        </div>

      </div>
    </div>
  </div>

  <footer class="footer">
    <div class="container">
      <p class="text-muted" style="font-size:12px;">
        SISOS &copy; <?php echo date('Y'); ?> &mdash;
        <a href="<?php echo $dashboard_url; ?>">Ir para o sistema</a>
      </p>
    </div>
  </footer>

  <script type="text/javascript">
    <?php if ($installed) { ?>
      $("#pre-installation-tab").removeClass('active');
      $("#finished-tab").addClass('active');
    <?php } ?>
  </script>
  <script src="assets/js/main.js"></script>
</body>
</html>
