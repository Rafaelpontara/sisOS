<?php $totalServico = 0;
$totalProdutos = 0;

// Mesma correção do imprimirOs.php — caminho relativo da logo quebra
// dependendo da URL da página atual.
$logoSrc = $emitente->url_logo ?? '';
if ($logoSrc && !preg_match('#^(https?:)?//#i', $logoSrc)) {
    $logoSrc = base_url() . ltrim($logoSrc, '/');
}
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <title><?= $this->config->item('app_name') ?> - OS #<?php echo $result->idOs ?> - <?php echo $result->nomeCliente ?></title>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/bootstrap.min.css" />
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/matrix-style.css" />
    <link href="<?php echo base_url(); ?>assets/font-awesome/css/font-awesome.css" rel="stylesheet" />
    <link href="<?= base_url('assets/css/custom.css'); ?>" rel="stylesheet">
    <link href='http://fonts.googleapis.com/css?family=Open+Sans:400,700,800' rel='stylesheet' type='text/css'>
    <style>
        .table {

            width: 72mm;
            margin: auto;
        }

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
            width: 80mm;
            min-height: 30cm;
            padding: 2mm;
            margin: 1mm auto;
            border: 1px #D3D3D3 solid;
            border-radius: 5px;
            background: white;
            box-shadow: 0 0 5px rgba(0, 0, 0, 0.1);
        }

        .subpage {
            padding: 0cm;
            border: 0px red solid;
            outline: 2cm #FFEAEA solid;
        }

        @page {
            size: auto;
            margin: 0;
        }

        @media print {

            html,
            body {
                width: 80mm;
                height: 30cm;
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
    </style>
</head>

<body id=body class="body" style="background-color: rgba(0,0,0,.4)">
<div id ="principal">
    <div class="container-fluid page">
        <div class="row-fluid subpage">
            <div class="span12">
                <div class="invoice-content">
                    <div class="invoice-head" style="margin-bottom: 0">
                        <table class="table table-condensed">
                            <tbody>
                                <?php if ($emitente == null) { ?>
                                    <tr>
                                        <td colspan="5" class="alert">Você precisa configurar os dados do emitente. >>><a href="<?php echo base_url(); ?>index.php/sisos/emitente">Configurar</a>
                                            <<<</td> </tr> <?php } else { ?>
                                    <td style="width: 25% ;text-align: center" ><img src="<?php echo $logoSrc; ?>" style="max-height: 100px"></td>
                                    <tr>
                                        <td colspan="5" style="text-align: center; font-size: 11px;" >
                                            <span style="font-size: 12px; text-transform: uppercase"><b><?php echo $emitente->nome; ?></b></br></span>
                                            <?php if ($emitente->cnpj != "00.000.000/0000-00") { ?><span class="icon"><i class="fas fa-fingerprint" style="margin:5px 1px"></i> <?php echo $emitente->cnpj; ?></span></br><?php } ?>
                                            <span>Endereço: <?php echo $emitente->rua . ', ' . $emitente->numero . '</br>' . $emitente->bairro . ', ' . $emitente->cidade . ' - ' . $emitente->uf; ?></span></br>
                                            <span><?php echo $emitente->email; ?> - <?php echo $emitente->telefone; ?></span>
                                        </td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                        <table class="table table-condensend">
                            <tbody>
                                <tr>
                                    <td style="width: 50%; padding-left: 0; font-size: 11px;">
                                        <ul>
                                            <li>
                                                <span><b>CLIENTE</b></br></span>
                                                <span><?php echo $result->nomeCliente ?></br></span>
                                                <?= !empty($result->contato_cliente) ? '<span>Contato: ' . $result->contato_cliente . ' </span>' : '<span>Contato: </span>' ?>
                                                    <?php if ($result->celular_cliente == $result->telefone_cliente) { ?>
                                                        <span><?= $result->celular_cliente ?></span></br>
                                                    <?php } else { ?>
                                                        <?= !empty($result->telefone_cliente) ? $result->telefone_cliente : "" ?>
                                                        <?= !empty($result->celular_cliente) && !empty($result->telefone_cliente) ? ' / ' : "" ?>
                                                        <?= !empty($result->celular_cliente) ? $result->celular_cliente : "" ?></br>
                                                    <?php } ?>
                                                </span>
                                                <?php if (!empty($result->email)) : ?>
                                                        <span>E-mail: <?php echo $result->email ?></span><br>
                                                <?php endif; ?>
                                                <span><?php
                                                    $retorno_end = array_filter([$result->rua, $result->numero, $result->complemento, $result->bairro]);
$endereco = implode(', ', $retorno_end);
if (!empty($endereco)) {
    echo 'Endereço: ' . $endereco . '<br>';
}
if (!empty($result->cidade) || !empty($result->estado) || !empty($result->cep)) {
    echo "<span>{$result->cidade} - {$result->estado}, {$result->cep}</span><br>";
}
?></span>
                                            </li>
                                        </ul>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="text-align: center; width: 100%; font-size: 12px;">
                                        <b>N° OS: </b><span><?php echo $result->idOs ?></span>
                                        <span style="padding-left: 5%;"><b>Status: </b><?php echo $result->status ?></span></br>
                                        <b>Emissão:</b> <?php echo date('d/m/Y H:i:s') ?>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div style="margin-top: 0; padding-top: 0; font-size: 12px;">
                        <table class="table table-condensed">
                            <tbody>
                                <?php if ($result->dataInicial != null) { ?>
                                    <tr>
                                        <td><b>Inicial: </b><?php echo date('d/m/Y', strtotime($result->dataInicial)); ?></td>
                                        <td><b>Final: </b><?php echo $result->dataFinal ? date('d/m/Y', strtotime($result->dataFinal)) : ''; ?></td>
                                        <?php if ($result->garantia != null) { ?><td><b>Garantia:</b></br><?php echo $result->garantia . ' dia(s)'; ?><?php } ?></td>
                                    </tr>
                                <?php } ?>

                                <?php if (!empty($result->equipamento) || !empty($result->numeroSerie) || !empty($result->modelo)): ?>
                                    <tr>
                                        <td colspan="5" style="background:#f5f5f5;"><b>EQUIPAMENTO</b></td>
                                    </tr>
                                    <?php if (!empty($result->equipamento)): ?>
                                    <tr>
                                        <td colspan="5"><b>Equipamento: </b><?= htmlspecialchars((string)$result->equipamento) ?></td>
                                    </tr>
                                    <?php endif; ?>
                                    <?php if (!empty($result->modelo)): ?>
                                    <tr>
                                        <td colspan="5"><b>Modelo: </b><?= htmlspecialchars((string)$result->modelo) ?></td>
                                    </tr>
                                    <?php endif; ?>
                                    <?php if (!empty($result->numeroSerie)): ?>
                                    <tr>
                                        <td colspan="5"><b>Nº Série / IMEI: </b><?= htmlspecialchars((string)$result->numeroSerie) ?></td>
                                    </tr>
                                    <?php endif; ?>
                                <?php endif; ?>



                                <?php
                                // ── Checklist resumido (só se ?checklist=1) ──────────────
                                $exibirChecklistT = ($this->input->get('checklist') == '1');
                                if ($exibirChecklistT && !empty($result->checklist)):
                                    $_ckT2 = json_decode($result->checklist, true) ?: [];
                                    $_ckT2v = $_ckT2['v'] ?? 1;
                                    if (!empty($_ckT2['itens'])):
                                ?>
                                <tr><td colspan="5" style="background:#f5f5f5;font-size:11px;"><b>CHECKLIST DE ENTRADA</b></td></tr>
                                <?php if ($_ckT2v == 2): ?>
                                <?php foreach($_ckT2['itens'] as $_itN => $_itE):
                                    $s = $_itE==='ok' ? '✓' : ($_itE==='defeito' ? '⚠' : '—'); ?>
                                <tr><td colspan="5" style="font-size:10px;"><?= $s ?> <?= htmlspecialchars($_itN) ?><?= $_itE==='defeito' ? ' <b style="color:#dc2626">[DEFEITO]</b>' : '' ?></td></tr>
                                <?php endforeach; ?>
                                <?php else: ?>
                                <?php foreach($_ckT2['itens'] as $_ckT2i): ?>
                                <tr><td colspan="5" style="font-size:10px;">✓ <?= htmlspecialchars($_ckT2i) ?></td></tr>
                                <?php endforeach; ?>
                                <?php endif; ?>
                                <?php if (!empty($_ckT2['obs'])): ?>
                                <tr><td colspan="5" style="font-size:10px;color:#555;"><b>Obs:</b> <?= htmlspecialchars($_ckT2['obs']) ?></td></tr>
                                <?php endif; endif; endif; ?>

                                <?php
                                // Senha do celular
                                $tipoLabelT = ['pin'=>'PIN','padrao'=>'Padrão Android','face'=>'Rec. Facial','digital'=>'Digital','iphone_face'=>'Face ID','iphone_digital'=>'Touch ID'];
                                if (!empty($result->senha_tipo)):
                                    $labelT = $tipoLabelT[$result->senha_tipo] ?? $result->senha_tipo;
                                ?>
                                <tr><td colspan="5" style="background:#f5f5f5;font-size:11px;"><b>SENHA DO CELULAR</b></td></tr>
                                <tr>
                                    <td colspan="5" style="font-size:11px;">
                                        <b>Tipo:</b> <?= htmlspecialchars($labelT) ?>
                                        <?php if (!empty($result->senha_valor)): ?>
                                        &nbsp;&nbsp;<b>Código:</b> <span style="font-family:monospace;font-weight:700;"><?= htmlspecialchars($result->senha_valor) ?></span>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                                <?php endif; ?>


                                <?php if ($result->descricaoProduto != null) { ?>
                                    <tr>
                                        <td colspan="5"><b>Descrição: </b><?php echo printSafeHtml($result->descricaoProduto) ?></td>
                                    </tr>
                                <?php } ?>
                                <?php if ($result->defeito != null) { ?>
                                    <tr>
                                        <td colspan="5"><b>Defeito Apresentado: </b><?php echo printSafeHtml($result->defeito) ?></td>
                                    </tr>
                                <?php } ?>
                                <?php if ($result->observacoes != null) { ?>
                                    <tr>
                                        <td colspan="5"><b>Observações: </b><?php echo printSafeHtml($result->observacoes) ?></td>
                                    </tr>
                                <?php } ?>
                                <?php if ($result->status != 'Aberto') { ?>
                                    <?php if ($result->laudoTecnico != null) { ?>
                                        <tr>
                                            <td colspan="5"><b>Laudo Técnico: </b><?php echo printSafeHtml($result->laudoTecnico) ?></td>
                                        </tr>
                                    <?php } ?>
                                <?php } ?>
                                <?php if ($result->garantias_id != null) { ?>
                                    <tr>
                                        <td colspan="5">
                                            <strong>Termo de Garantia: </strong><br>
                                            <?php echo printSafeHtml($result->textoGarantia) ?>
                                        </td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    <?php if ($produtos != null) { ?>
                        <table style='font-size: 11px;' class="table table-bordered table-condensed" id="tblProdutos">
                            <thead>
                                <tr>
                                    <th>Qtd</th>
                                    <th>Produto</th>
                                    <th>Unitário</th>
                                    <th>Subtotal</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                foreach ($produtos as $p) {
                                    $totalProdutos = $totalProdutos + $p->subTotal;
                                    echo '<tr>';
                                    echo '<td>' . $p->quantidade . '</td>';
                                    echo '<td>' . htmlspecialchars($p->descricao ?? '') . '</td>';
                                    echo '<td>R$ ' . $p->preco ?: $p->precoVenda . '</td>';
                                    echo '<td>R$ ' . number_format($p->subTotal, 2, ',', '.') . '</td>';
                                    echo '</tr>';
                                } ?>

                                <tr>
                                    <td colspan="3" style="text-align: right"><strong>Total:</strong></td>
                                    <td><strong>R$ <?php echo number_format($totalProdutos, 2, ',', '.'); ?></strong></td>
                                </tr>
                            </tbody>
                        </table>
                    <?php } ?>
                    <?php if ($servicos != null) { ?>
                        <table style='font-size: 11px;' class="table table-bordered table-condensed">
                            <thead>
                                <tr>
                                    <th>Qtd</th>
                                    <th>Serviço</th>
                                    <th>Unitário</th>
                                    <th>Subtotal</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php setlocale(LC_MONETARY, 'en_US');
                        foreach ($servicos as $s) {
                            $preco = $s->preco ?: $s->precoVenda;
                            $subtotal = $preco * ($s->quantidade ?: 1);
                            $totalServico = $totalServico + $subtotal;
                            echo '<tr>';
                            echo '<td>' . ($s->quantidade ?: 1) . '</td>';
                            echo '<td>' . htmlspecialchars($s->nome ?? '') . '</td>';
                            echo '<td>R$ ' . $preco . '</td>';
                            echo '<td>R$ ' . number_format($subtotal, 2, ',', '.') . '</td>';
                            echo '</tr>';
                        } ?>
                                <tr>
                                    <td colspan="3" style="text-align: right"><strong>Total:</strong></td>
                                    <td><strong>R$ <?php echo number_format($totalServico, 2, ',', '.'); ?></strong></td>
                                </tr>
                            </tbody>
                        </table>
                    <?php } ?>
                    <table class="table table-bordered table-condensed">
                        <tbody>
                            <tr>
                                <td colspan="5"> <?php
                            if ($totalProdutos != 0 || $totalServico != 0) {
                                if ($result->valor_desconto != 0) {
                                    echo "<h4 style='text-align: right; font-size: 13px;'>Subtotal: R$ " . number_format($totalProdutos + $totalServico, 2, ',', '.') . "</h4>";
                                    echo $result->valor_desconto != 0 ? "<h4 style='text-align: right; font-size: 13px;'> Desconto: R$ " . number_format($result->valor_desconto != 0 ? $result->valor_desconto - ($totalProdutos + $totalServico) : 0.00, 2, ',', '.') . "</h4>" : "";
                                    echo $result->valor_desconto != 0 ? "<h4 style='text-align: right; font-size: 13px;'> Total: R$ " . number_format($result->valor_desconto, 2, ',', '.') . "</h4>" : "";
                                } else {
                                    echo "<h4 style='text-align: right; font-size: 13px;'>Total: R$ " . number_format($totalProdutos + $totalServico, 2, ',', '.') . "</h4>";
                                }
                            } ?>
                                </td>
                            </tr>
                        </tbody>
                        <?php if ($result->status == 'Finalizado' || $result->status == 'Orçamento') { ?>
                            <?php if ($qrCode) : ?>
                                <td style="width: 15%; padding: 0;text-align:center;">
                                    <img style="margin:12px 0px 0px 0px" src="<?php echo base_url(); ?>assets/img/logo_pix.png" width="64px" alt="QR Code de Pagamento" /></br>
                                    <img style="margin:5px 0px 0px 0px" width="94px" src="<?= $qrCode ?>" alt="QR Code de Pagamento" /></br>
                                    <?php echo '<span style="margin:0px;font-size: 80%;text-align:center;">Chave PIX: ' . $chaveFormatada . '</span><hr>' ;?>
                                </td>
                            <?php endif ?>
                        <?php } ?>
                    </table>
                    <table class="table table-bordered table-condensed" style="font-size: 15px">
                        <tbody>
                            <tr>
                                <td colspan="5">
                                    <b><p class="text-center">Assinatura do Cliente</p></b><br />
                                    <hr>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <!-- Via Da Empresa  -->
                <?php $totalServico = 0;
$totalProdutos = 0; ?>
                    <div id="ViaEmpresa" <?php echo (!$configuration['control_2vias']) ? "style='display: none;'" : "style='display: block;'" ?>>
                        <div class="invoice-head" style="margin-bottom: 0">
                            <table class="table table-condensed">
                                <tbody>
                                    <?php if ($emitente == null) { ?>
                                        <tr>
                                            <td colspan="5" class="alert">Você precisa configurar os dados do emitente. >>><a href="<?php echo base_url(); ?>index.php/sisos/emitente">Configurar</a><<<</td>
                                        </tr>
                                    <?php } else { ?>
                                        <td style="width: 25% ;text-align: center" ><img src="<?php echo $logoSrc; ?>" style="max-height: 100px"></td>
                                    <tr>
                                        <td colspan="5" style="text-align: center; font-size: 11px;" >
                                            <span style="font-size: 12px; text-transform: uppercase"><b><?php echo $emitente->nome; ?></b></br></span>
                                            <?php if ($emitente->cnpj != "00.000.000/0000-00") { ?><span class="icon"><i class="fas fa-fingerprint" style="margin:5px 1px"></i> <?php echo $emitente->cnpj; ?></span></br><?php } ?>
                                            <span>Endereço: <?php echo $emitente->rua . ', ' . $emitente->numero . '</br>' . $emitente->bairro . ', ' . $emitente->cidade . ' - ' . $emitente->uf; ?></span></br>
                                            <span><?php echo $emitente->email; ?> - <?php echo $emitente->telefone; ?></span>
                                        </td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                        <table class="table table-condensend">
                            <tbody>
                                <tr>
                                    <td style="width: 50%; padding-left: 0; font-size: 11px;">
                                        <ul>
                                            <li>
                                                <span><b>CLIENTE</b></br></span>
                                                <span><?php echo $result->nomeCliente ?></br></span>
                                                <?= !empty($result->contato_cliente) ? '<span>Contato: ' . $result->contato_cliente . ' </span>' : '<span>Contato: </span>' ?>
                                                    <?php if ($result->celular_cliente == $result->telefone_cliente) { ?>
                                                        <span><?= $result->celular_cliente ?></span></br>
                                                    <?php } else { ?>
                                                        <?= !empty($result->telefone_cliente) ? $result->telefone_cliente : "" ?>
                                                        <?= !empty($result->celular_cliente) && !empty($result->telefone_cliente) ? ' / ' : "" ?>
                                                        <?= !empty($result->celular_cliente) ? $result->celular_cliente : "" ?></br>
                                                    <?php } ?>
                                                </span>
                                                <?php if (!empty($result->email)) : ?>
                                                        <span>E-mail: <?php echo $result->email ?></span><br>
                                                <?php endif; ?>
                                                <span><?php
                                    $retorno_end = array_filter([$result->rua, $result->numero, $result->complemento, $result->bairro]);
$endereco = implode(', ', $retorno_end);
if (!empty($endereco)) {
    echo 'Endereço: ' . $endereco . '<br>';
}
if (!empty($result->cidade) || !empty($result->estado) || !empty($result->cep)) {
    echo "<span>{$result->cidade} - {$result->estado}, {$result->cep}</span><br>";
}
?></span>
                                            </li>
                                        </ul>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="text-align: center; width: 100%; font-size: 12px;">
                                        <b>N° OS: </b><span><?php echo $result->idOs ?></span>
                                        <span style="padding-left: 5%;"><b>Status: </b><?php echo $result->status ?></span></br>
                                        <b>Emissão:</b> <?php echo date('d/m/Y') ?>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                        <div style="margin-top: 0; padding-top: 0">
                                <table class="table table-condensed">
                                    <tbody>
                                        <?php if ($result->dataInicial != null) { ?>
                                            <tr>
                                                <td>
                                                    <b>Inicial: </b>
                                                    <?php echo date('d/m/Y', strtotime($result->dataInicial)); ?>
                                                </td>
                                                <td>
                                                    <b>Final: </b>
                                                    <?php echo $result->dataFinal ? date('d/m/Y', strtotime($result->dataFinal)) : ''; ?>
                                                </td>
                                                <td>
                                                    <?php if ($result->garantia != null) { ?>
                                                        <b>Garantia: </b><?php echo $result->garantia . ' dia(s)'; ?>
                                                    <?php } ?>
                                                </td>
                                        <?php } ?>
                                        <?php if ($result->descricaoProduto != null) { ?>
                                            <tr>
                                                <td colspan="5">
                                                    <b>Descrição: </b><?php echo printSafeHtml($result->descricaoProduto) ?>
                                                </td>
                                            </tr>
                                        <?php } ?>
                                        <?php if ($result->defeito != null) { ?>
                                            <tr>
                                                <td colspan="5">
                                                    <b>Defeito Apresentado: </b><?php echo printSafeHtml($result->defeito) ?>
                                                </td>
                                            </tr>
                                        <?php } ?>
                                        <?php if ($result->observacoes != null) { ?>
                                            <tr>
                                                <td colspan="5">
                                                    <b>Observações: </b><?php echo printSafeHtml($result->observacoes) ?>
                                                </td>
                                            </tr>
                                        <?php } ?>
                                    <?php if ($result->status != 'Aberto') { ?>
                                        <?php if ($result->laudoTecnico != null) { ?>
                                            <tr>
                                                <td colspan="5">
                                                    <b>Laudo Técnico: </b><?php echo printSafeHtml($result->laudoTecnico) ?>
                                                </td>
                                            </tr>
                                        <?php } ?>
                                    <?php } ?>
                                    <?php if ($result->garantias_id != null) { ?>
                                    <tr>
                                        <td colspan="5">
                                            <strong>Termo de Garantia: </strong><br><?php echo printSafeHtml($result->textoGarantia) ?>
                                        </td>
                                    </tr>
                                <?php } ?>
                                    </tbody>
                                </table>
                                <?php if ($produtos != null) { ?>
                            <table style='font-size: 11px;' class="table table-bordered table-condensed" id="tblProdutos">
                                <thead>
                                    <tr>
                                        <th>Qtd</th>
                                        <th>Produto</th>
                                        <th>Unitário</th>
                                        <th>Subtotal</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    foreach ($produtos as $p) {
                                        $totalProdutos = $totalProdutos + $p->subTotal;
                                        echo '<tr>';
                                        echo '<td>' . $p->quantidade . '</td>';
                                        echo '<td>' . htmlspecialchars($p->descricao ?? '') . '</td>';
                                        echo '<td>R$ ' . $p->preco ?: $p->precoVenda . '</td>';
                                        echo '<td>R$ ' . number_format($p->subTotal, 2, ',', '.') . '</td>';
                                        echo '</tr>';
                                    } ?>

                                    <tr>
                                        <td colspan="3" style="text-align: right"><strong>Total:</strong></td>
                                        <td><strong>R$ <?php echo number_format($totalProdutos, 2, ',', '.'); ?></strong></td>
                                    </tr>
                                </tbody>
                            </table>
                        <?php } ?>

                        <?php if ($servicos != null) { ?>
                            <table style='font-size: 11px;' class="table table-bordered table-condensed">
                                <thead>
                                    <tr>
                                        <th>Qtd</th>
                                        <th>Serviço</th>
                                        <th>Unitário</th>
                                        <th>Subtotal</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php setlocale(LC_MONETARY, 'en_US');
                            foreach ($servicos as $s) {
                                $preco = $s->preco ?: $s->precoVenda;
                                $subtotal = $preco * ($s->quantidade ?: 1);
                                $totalServico = $totalServico + $subtotal;
                                echo '<tr>';
                                echo '<td>' . ($s->quantidade ?: 1) . '</td>';
                                echo '<td>' . htmlspecialchars($s->nome ?? '') . '</td>';
                                echo '<td>R$ ' . $preco . '</td>';
                                echo '<td>R$ ' . number_format($subtotal, 2, ',', '.') . '</td>';
                                echo '</tr>';
                            } ?>
                                    <tr>
                                        <td colspan="3" style="text-align: right"><strong>Total:</strong></td>
                                        <td><strong>R$ <?php echo number_format($totalServico, 2, ',', '.'); ?></strong></td>
                                    </tr>
                                </tbody>
                            </table>
                        <?php } ?>

                        <table class="table table-bordered table-condensed">
                            <tbody>
                                <tr>
                                    <td colspan="5"> <?php
                                if ($totalProdutos != 0 || $totalServico != 0) {
                                    if ($result->valor_desconto != 0) {
                                        echo "<h4 style='text-align: right; font-size: 13px;'>Subtotal: R$ " . number_format($totalProdutos + $totalServico, 2, ',', '.') . "</h4>";
                                        echo $result->valor_desconto != 0 ? "<h4 style='text-align: right; font-size: 13px;'> Desconto: R$ " . number_format($result->valor_desconto != 0 ? $result->valor_desconto - ($totalProdutos + $totalServico) : 0.00, 2, ',', '.') . "</h4>" : "";
                                        echo $result->valor_desconto != 0 ? "<h4 style='text-align: right; font-size: 13px;'> Total: R$ " . number_format($result->valor_desconto, 2, ',', '.') . "</h4>" : "";
                                    } else {
                                        echo "<h4 style='text-align: right; font-size: 13px;'>Total: R$ " . number_format($totalProdutos + $totalServico, 2, ',', '.') . "</h4>";
                                    }
                                } ?>
                                    </td>
                                </tr>
                            </tbody>
                            <?php if ($result->status == 'Finalizado' || $result->status == 'Orçamento') { ?>
                                <?php if ($qrCode) : ?>
                                    <td style="width: 15%; padding: 0;text-align:center;">
                                        <img style="margin:12px 0px 0px 0px" src="<?php echo base_url(); ?>assets/img/logo_pix.png" width="64px" alt="QR Code de Pagamento" /></br>
                                        <img style="margin:5px 0px 0px 0px" width="94px" src="<?= $qrCode ?>" alt="QR Code de Pagamento" /></br>
                                        <?php echo '<span style="margin:0px;font-size: 80%;text-align:center;">Chave PIX: ' . $chaveFormatada . '</span><hr>' ;?>
                                    </td>
                                <?php endif ?>
                            <?php } ?>
                        </table>
                        <table class="table table-bordered table-condensed" style="font-size: 15px">
                            <tbody>
                                <tr>

                                    <td colspan="5">
                                        <b><p class="text-center">Assinatura do Recebedor</p></b><br />
                                        <hr>
                                    </td>

                                </tr>
                            
                                <?php
                                // ── Checklist de Saída ─────────────────────
                                if (!empty($result->checklist_saida)):
                                    $_ckSt = json_decode($result->checklist_saida, true) ?: [];
                                    if (!empty($_ckSt['itens'])):
                                ?>
                                <tr><td colspan="5" style="background:#f5f5f5;font-size:11px;"><b>CHECKLIST DE SAÍDA</b></td></tr>
                                <?php foreach($_ckSt['itens'] as $_stN => $_stE):
                                    $stS = $_stE==='ok' ? '✓' : ($_stE==='defeito' ? '⚠' : '—'); ?>
                                <tr><td colspan="5" style="font-size:10px;"><?= $stS ?> <?= htmlspecialchars($_stN) ?><?= $_stE==='defeito' ? ' <b style="color:#dc2626">[DEFEITO]</b>' : '' ?></td></tr>
                                <?php endforeach; ?>
                                <?php if (!empty($_ckSt['obs'])): ?>
                                <tr><td colspan="5" style="font-size:10px;color:#555;"><b>Obs:</b> <?= htmlspecialchars($_ckSt['obs']) ?></td></tr>
                                <?php endif; endif; endif; ?>
</tbody>
                        </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
  window.print();
</script>
</body>
    <script src="<?php echo base_url(); ?>assets/js/bootstrap.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/js/matrix.js"></script>

</html>
