<!DOCTYPE html>
<html lang="pt-br">

<head>
    <title><?= $this->config->item("app_name") ?> - Garantia</title>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/bootstrap.min.css" />
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/matrix-style.css" />
    <link href="<?php echo base_url(); ?>assets/font-awesome/css/font-awesome.css" rel="stylesheet" />
    <link href="<?= base_url('assets/css/custom.css'); ?>" rel="stylesheet">
    <link href='http://fonts.googleapis.com/css?family=Open+Sans:400,700,800' rel='stylesheet' type='text/css'>
    <style>
        body {
            width: 100%;
            height: 100%;
            margin: 0;
            padding: 0;
            background-color: #FAFAFA;
        }

        * {
            box-sizing: border-box;
            -moz-box-sizing: border-box;
        }

        .page {
            width: 210mm;
            min-height: 297mm;
            padding: 4mm;
            margin: 1mm auto;
            border: 1px #D3D3D3 solid;
            border-radius: 5px;
            background: white;
            box-shadow: 0 0 5px rgba(0, 0, 0, 0.1);
        }

        .subpage {
            padding: 0.5cm;
            border: 0px red solid;
            height: 257mm;
            outline: 2cm #FFEAEA solid;
        }

        @page {
            size: A4;
            margin: 0;
        }

        @media print {

            html,
            body {
                width: 210mm;
                height: 297mm;
            }

            .page {
                margin: 0;
                border: initial;
                border-radius: initial;
                width: initial;
                min-height: initial;
                box-shadow: initial;
                background: initial;
                page-break-after: always;
            }
        }

        /* ══ Termo de Garantia — formatação moderna ══ */
        .tg-doc { font-family: 'Open Sans', Arial, sans-serif; color: #1f2430; }
        .tg-header {
            display: flex; align-items: center; justify-content: space-between; gap: 20px;
            padding-bottom: 16px; border-bottom: 2px solid #1f2430; margin-bottom: 26px;
        }
        .tg-header-left { display: flex; align-items: center; gap: 14px; }
        .tg-logo { max-width: 70px; max-height: 70px; object-fit: contain; }
        .tg-empresa-nome { font-size: 18px; font-weight: 800; margin: 0 0 3px; }
        .tg-empresa-info { font-size: 11px; color: #555; line-height: 1.55; }
        .tg-meta { text-align: right; font-size: 11.5px; color: #333; white-space: nowrap; }
        .tg-meta strong { display: block; font-size: 12.5px; margin-bottom: 2px; }

        .tg-alert {
            background: #fff3cd; border: 1px solid #ffe08a; color: #7a5b00;
            padding: 10px 14px; border-radius: 6px; font-size: 12.5px; margin-bottom: 20px;
        }
        .tg-alert a { color: #7a5b00; font-weight: 700; }

        .tg-titulo-wrap { text-align: center; margin: 4px 0 20px; }
        .tg-titulo {
            display: inline-block; font-size: 16px; font-weight: 800; letter-spacing: 1.5px;
            text-transform: uppercase; padding-bottom: 6px; border-bottom: 3px solid #1f2430; margin: 0;
        }

        .tg-corpo {
            background: #f8f9fb; border: 1px solid #e3e5eb; border-radius: 8px;
            padding: 20px 22px; font-size: 12.5px; line-height: 1.75; color: #2b2f3a;
            margin-bottom: 40px; text-align: justify;
        }

        .tg-assinaturas { display: flex; gap: 24px; margin-top: 40px; }
        .tg-assinatura { flex: 1; text-align: center; font-size: 11.5px; color: #333; }
        .tg-assinatura-linha { border-top: 1px solid #333; margin-bottom: 8px; padding-top: 6px; }
    </style>
</head>

<body>


    <div class="container-fluid page" id="viaCliente">
        <div class="subpage tg-doc">

            <?php if ($emitente == null) { ?>
            <div class="tg-alert">
                Você precisa configurar os dados do emitente. &raquo;&raquo;&raquo;
                <a href="<?php echo base_url(); ?>index.php/sisos/emitente">Configurar</a>
                &laquo;&laquo;&laquo;
            </div>
            <?php } else { ?>
            <div class="tg-header">
                <div class="tg-header-left">
                    <img class="tg-logo" src="<?php echo $emitente->url_logo; ?>" alt="Logo">
                    <div>
                        <p class="tg-empresa-nome"><?php echo $emitente->nome; ?></p>
                        <div class="tg-empresa-info">
                            <?php echo $emitente->cnpj; ?><br>
                            <?php echo $emitente->rua . ', nº ' . $emitente->numero . ', ' . $emitente->bairro . ' - ' . $emitente->cidade . ' - ' . $emitente->uf; ?><br>
                            <?php echo $emitente->email . ' · ' . $emitente->telefone; ?>
                        </div>
                    </div>
                </div>
                <div class="tg-meta">
                    <strong>Emissão: <?php echo date('d/m/Y'); ?></strong>
                </div>
            </div>
            <?php } ?>

            <div class="tg-titulo-wrap">
                <h1 class="tg-titulo">Termo de Garantia</h1>
            </div>

            <div class="tg-corpo"><?php echo printSafeHtml($result->textoGarantia) ?></div>

            <div class="tg-assinaturas">
                <div class="tg-assinatura"><div class="tg-assinatura-linha">&nbsp;</div>Data</div>
                <div class="tg-assinatura"><div class="tg-assinatura-linha">&nbsp;</div>Assinatura do Cliente</div>
                <div class="tg-assinatura"><div class="tg-assinatura-linha">&nbsp;</div>Assinatura do Técnico Responsável</div>
            </div>

        </div>
    </div>
    <script src="<?php echo base_url(); ?>assets/js/bootstrap.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/js/matrix.js"></script>
    <script>
        window.print();
    </script>
</body>

</html>
