<?php
$totalServico  = 0;
$totalProdutos = 0;

// A logo salva no banco às vezes vem como caminho relativo (ex:
// "assets/uploads/arquivo.png"), o que quebra dependendo da URL da página
// atual. Se não começar com http(s):// ou //, completa com o endereço do site.
$logoSrc = $emitente->url_logo ?? '';
if ($logoSrc && !preg_match('#^(https?:)?//#i', $logoSrc)) {
    $logoSrc = base_url() . ltrim($logoSrc, '/');
}
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <title><?= $this->config->item('app_name') ?> - <?= $result->idOs ?> - <?= $result->nomeCliente ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="<?= base_url() ?>assets/css/bootstrap5.3.2.min.css" />
    <link rel="stylesheet" href="<?= base_url() ?>assets/font-awesome/css/font-awesome.css" />
    <link rel="stylesheet" href="<?= base_url() ?>assets/css/imprimir.css">
</head>
<body>
    <div class="main-page">
        <div class="sub-page">
            <header>
                <?php if ($emitente == null) : ?>
                    <div class="alert alert-danger" role="alert">
                        Você precisa configurar os dados do emitente. >>> <a href="<?=base_url()?>index.php/sisos/emitente">Configurar</a>
                    </div>
                <?php else : ?>
                    <div class="imgLogo" class="align-middle">
                        <img src="<?= $logoSrc ?>" class="img-fluid" style="width:140px;">
                    </div>
                    <div class="emitente">
                        <span style="font-size: 16px;"><b><?= $emitente->nome ?></b></span></br>
                        <?php if ($emitente->cnpj != "00.000.000/0000-00") : ?>
                            <span class="align-middle">CNPJ: <?= $emitente->cnpj ?></span></br>
                        <?php endif; ?>
                        <span class="align-middle">
                            Endereço: <?= $emitente->rua.', '.$emitente->numero.', '.$emitente->bairro ?><br>
                            <?= $emitente->cidade.' - '.$emitente->uf.' - '.$emitente->cep ?>
                        </span>
                    </div>
                    <div class="contatoEmitente">
                        <span style="font-weight: bold;">Tel: <?= $emitente->telefone ?></span></br>
                        <span style="font-weight: bold;"><?= $emitente->email ?></span></br>
                        <span style="word-break: break-word;">Responsável: <b><?= $result->nome ?></b></span>
                    </div>
                <?php endif; ?>
            </header>
            <section>
                <div class="title">
                    <?php if ($configuration['control_2vias']) : ?><span class="via">Via cliente</span><?php endif; ?>
                    ORDEM DE SERVIÇO #<?= str_pad($result->idOs, 4, 0, STR_PAD_LEFT) ?>
                    <span class="emissao">Emissão: <?= date('d/m/Y H:i:s') ?></span>
                </div>

                <?php if ($result->dataInicial != null): ?>
                    <div class="tabela">
                        <table class="table table-bordered">
                            <thead>
                                <tr class="table-secondary">
                                    <th class="text-center">STATUS</th>
                                    <th class="text-center">DATA INICIAL</th>
                                    <th class="text-center">DATA FINAL</th>
                                    <?php if ($result->garantia) : ?>
                                        <th class="text-center">GARANTIA</th>
                                    <?php endif; ?>
                                    <?php if (in_array($result->status, ['Finalizado', 'Faturado'])) : ?>
                                        <th class="text-center">VENC. GARANTIA</th>
                                    <?php endif; ?>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td class="text-center"><?= $result->status ?></td>
                                    <td class="text-center"><?= date('d/m/Y', strtotime($result->dataInicial)) ?></td>
                                    <td class="text-center"><?= $result->dataFinal ? date('d/m/Y', strtotime($result->dataFinal)) : '' ?></td>
                                    <?php if ($result->garantia) : ?>
                                        <td class="text-center"><?= $result->garantia . ' dia(s)' ?></td>
                                    <?php endif; ?>
                                    <?php if (in_array($result->status, ['Finalizado', 'Faturado'])) : ?>
                                        <td class="text-center"><?= dateInterval($result->dataFinal, $result->garantia) ?></td>
                                    <?php endif; ?>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                <?php endif; ?>

                <div class="subtitle">DADOS DO CLIENTE</div>
                <div class="dados">
                    <div>
                        <span><b><?= $result->nomeCliente ?></b></span><br />
                        <span>CPF/CNPJ: <?= $result->documento ?></span><br />
                        <span>Contato: <?= trim($result->contato_cliente.' '.$result->telefone.($result->telefone && $result->celular ? ' / '.$result->celular : $result->celular)) ?></span><br />
                        <span>E-mail: <?= $result->email ?></span><br />
                    </div>
                    <div style="text-align: right;">
                        <span>Endereço: <?= $result->rua.', '.$result->numero.', '.$result->bairro ?></span><br />
                        <span><?= $result->complemento.' - '.$result->cidade.' - '.$result->estado ?></span><br />
                        <span>CEP: <?= $result->cep ?></span><br />
                    </div>
                </div>

                <?php if (!empty($result->equipamento) || !empty($result->numeroSerie)) : ?>
                    <div class="subtitle">EQUIPAMENTO</div>
                    <div class="dados">
                        <div style="display:flex;gap:20px;flex-wrap:wrap;">
                            <?php if (!empty($result->equipamento)) : ?>
                            <div>
                                <b>Equipamento / Produto:</b> <?= htmlspecialchars((string)$result->equipamento) ?>
                            </div>
                            <?php endif; ?>
                            <?php if (!empty($result->numeroSerie)) : ?>
                            <div>
                                <b>Nº de Série / IMEI:</b> <?= htmlspecialchars((string)$result->numeroSerie) ?>
                            </div>
                            <?php endif; ?>
                        </div>
                    </div>
                <?php endif; ?>



                <?php
                // ── Senha do Celular ──────────────────────────────────────
                $tipoLabelA4 = [
                    'pin'    => 'PIN / Código Numérico',
                    'padrao' => 'Padrão de Desbloqueio (Android)',
                ];
                if (!empty($result->senha_tipo)):
                    $labelSenha = $tipoLabelA4[$result->senha_tipo] ?? $result->senha_tipo;
                ?>
                <div class="subtitle">SENHA DO CELULAR</div>
                <div class="dados">
                    <div style="display:flex;gap:20px;flex-wrap:wrap;align-items:center;">
                        <div><b>Tipo:</b> <?= htmlspecialchars($labelSenha) ?></div>
                        <?php if (!empty($result->senha_valor)): ?>
                        <div>
                            <b>Código:</b>
                            <span style="font-family:monospace;font-size:14px;font-weight:700;
                                         background:#f1f5f9;padding:2px 10px;border-radius:4px;
                                         border:1.5px solid #cbd5e1;">
                                <?= htmlspecialchars($result->senha_valor) ?>
                            </span>
                        </div>
                        <?php endif; ?>
                    </div>
                </div>
                <?php endif; ?>

                <?php
                // ── Checklist de Entrada (só imprime se ?checklist=1) ─────
                $exibirChecklist = ($this->input->get('checklist') == '1');
                if ($exibirChecklist && !empty($result->checklist)):
                    $_ckA4  = json_decode($result->checklist, true) ?: [];
                    $_ckA4v = $_ckA4['v'] ?? 1;
                    if (!empty($_ckA4['itens']) || !empty($_ckA4['obs'])):
                ?>
                <div class="subtitle">CHECKLIST DE ENTRADA</div>
                <div class="dados">
                    <?php if (!empty($_ckA4['itens'])): ?>
                    <?php if ($_ckA4v == 2): ?>
                    <!-- Formato novo v2: item => estado -->
                    <div style="display:grid;grid-template-columns:1fr 1fr;gap:3px 16px;margin-bottom:6px;">
                        <?php foreach($_ckA4['itens'] as $_itNome => $_itEst):
                            $s   = $_itEst==='ok' ? '✓' : ($_itEst==='defeito' ? '⚠' : '—');
                            $cor = $_itEst==='ok' ? '#16a34a' : ($_itEst==='defeito' ? '#dc2626' : '#9ca3af');
                            $lbl = $_itEst==='ok' ? 'OK' : ($_itEst==='defeito' ? 'DEFEITO' : 'N/V');
                        ?>
                        <div style="display:flex;align-items:center;gap:4px;font-size:11px;padding:2px 0;">
                            <span style="color:<?= $cor ?>;font-weight:700;min-width:10px;"><?= $s ?></span>
                            <span style="flex:1;"><?= htmlspecialchars($_itNome) ?></span>
                            <span style="font-size:9px;font-weight:700;color:<?= $cor ?>;background:<?= $_itEst==='defeito' ? '#fef2f2' : ($_itEst==='ok' ? '#f0fdf4' : '#f9fafb') ?>;padding:1px 5px;border-radius:3px;"><?= $lbl ?></span>
                        </div>
                        <?php endforeach; ?>
                    </div>
                    <?php else: ?>
                    <!-- Formato legado v1: array simples -->
                    <div style="display:flex;flex-wrap:wrap;gap:3px 22px;margin-bottom:6px;">
                        <?php foreach($_ckA4['itens'] as $_itNome => $_itEst): ?>
                        <div style="font-size:11px;"><span style="color:#16a34a;font-weight:700;">✓</span> <?= htmlspecialchars($_itEst) ?></div>
                        <?php endforeach; ?>
                    </div>
                    <?php endif; ?>
                    <?php endif; ?>
                    <?php if (!empty($_ckA4['obs'])): ?>
                    <div style="font-size:11px;color:#555;border-top:1px solid #e5e7eb;padding-top:4px;margin-top:4px;">
                        <b>Obs.:</b> <?= nl2br(htmlspecialchars($_ckA4['obs'])) ?>
                    </div>
                    <?php endif; ?>
                </div>
                <?php endif; endif; ?>

                <?php if ($result->descricaoProduto) : ?>
                    <div class="subtitle">DESCRIÇÃO</div>
                    <div class="dados">
                        <div style="text-align: justify;">
                            <?= printSafeHtml($result->descricaoProduto) ?>
                        </div>
                    </div>
                <?php endif; ?>

                <?php if ($result->defeito) : ?>
                    <div class="subtitle">DEFEITO APRESENTADO</div>
                    <div class="dados">
                        <div style="text-align: justify;">
                            <?= printSafeHtml($result->defeito) ?>
                        </div>
                    </div>
                <?php endif; ?>

                <?php if ($result->observacoes) : ?>
                    <div class="subtitle">OBSERVAÇÕES</div>
                    <div class="dados">
                        <div style="text-align: justify;">
                            <?= printSafeHtml($result->observacoes) ?>
                        </div>
                    </div>
                <?php endif; ?>

                <?php if ($result->laudoTecnico) : ?>
					<div class="subtitle">PARECER TÉCNICO</div>
                    <div class="dados">
                        <div style="text-align: justify;">
    						<?= printSafeHtml($result->laudoTecnico) ?>
						</div>
                    </div>
                <?php endif; ?>

                <?php if ($result->garantias_id) : ?>
                    <div class="subtitle">TERMO DE GARANTIA</div>
                    <div class="dados">
                        <div style="text-align: justify;"><?= printSafeHtml($result->textoGarantia) ?></div>
                    </div>
                <?php endif; ?>

                <?php if ($produtos) : ?>
                    <div class="tabela">
                        <table class="table table-bordered">
                            <thead>
                                <tr class="table-secondary">
                                    <th>PRODUTO(S)</th>
                                    <th class="text-center" width="10%">QTD</th>
                                    <th class="text-center" width="10%">UNT</th>
                                    <th class="text-end" width="15%" >SUBTOTAL</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($produtos as $p) :
                                    $totalProdutos = $totalProdutos + $p->subTotal;
                                    echo '<tr>';
                                    echo '  <td>' . htmlspecialchars($p->descricao ?? '') . '</td>';
                                    echo '  <td class="text-center">' . $p->quantidade . '</td>';
                                    echo '  <td class="text-center">' . number_format($p->preco ?: $p->precoVenda, 2, ',', '.') . '</td>';
                                    echo '  <td class="text-end">R$ ' . number_format($p->subTotal, 2, ',', '.') . '</td>';
                                    echo '</tr>';
                                endforeach; ?>
                                <tr>
                                    <td colspan="3" class="text-end"><b>TOTAL PRODUTOS:</b></td>
                                    <td class="text-end"><b>R$ <?= number_format($totalProdutos, 2, ',', '.') ?></b></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                <?php endif; ?>

                <?php if ($servicos) : ?>
                    <div class="tabela">
                        <table class="table table-bordered">
                            <thead>
                                <tr class="table-secondary">
                                    <th>SERVIÇO(S)</th>
                                    <th class="text-center" width="10%">QTD</th>
                                    <th class="text-center" width="10%">UNT</th>
                                    <th class="text-end" width="15%" >SUBTOTAL</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                    setlocale(LC_MONETARY, 'en_US');
                    foreach ($servicos as $s) :
                        $preco = $s->preco ?: $s->precoVenda;
                        $subtotal = $preco * ($s->quantidade ?: 1);
                        $totalServico = $totalServico + $subtotal;
                        echo '<tr>';
                        echo '  <td>' . htmlspecialchars($s->nome ?? '') . '</td>';
                        echo '  <td class="text-center">' . ($s->quantidade ?: 1) . '</td>';
                        echo '  <td class="text-center">' . number_format($preco, 2, ',', '.') . '</td>';
                        echo '  <td class="text-end">R$ ' . number_format($subtotal, 2, ',', '.') . '</td>';
                        echo '</tr>';
                    endforeach; ?>
                                <tr>
                                    <td colspan="3" class="text-end"><b>TOTAL SERVIÇOS:</b></td>
                                    <td class="text-end"><b>R$ <?= number_format($totalServico, 2, ',', '.') ?></b></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                <?php endif; ?>

                <?php if ($totalProdutos != 0 || $totalServico != 0) : ?>
                    <div class="pagamento">
                        <div class="qrcode">
                            <?php if ($this->data['configuration']['pix_key']) : ?>
                                <div><img width="130px" src="<?= $qrCode ?>" alt="QR Code de Pagamento" /></div>
                                <div style="display: flex; flex-wrap: wrap; align-content: center;">
                                    <div style="width: 100%; text-align:center;"><i class="fas fa-camera"></i><br />Escaneie o QRCode ao lado para pagar por Pix</div>
                                    <div class="chavePix">Chave Pix: <b><?= $chaveFormatada ?></b></div>
                                </div>
                            <?php else: ?>
                                <div></div>
                                <div></div>
                            <?php endif; ?>
                        </div>
                        <div>
                            <div class="tabela">
                                <table class="table table-bordered">
                                    <thead>
                                        <tr class="table-secondary">
                                            <th colspan="2">RESUMO DOS VALORES</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php if ($result->valor_desconto != 0) : ?>
                                            <tr>
                                                <td width="65%">SUBTOTAL</td>
                                                <td>R$ <b><?= number_format($totalProdutos + $totalServico, 2, ',', '.') ?></b></td>
                                            </tr>
                                            <tr>
                                                <td>DESCONTO</td>
                                                <td>R$ <b><?= number_format($result->valor_desconto != 0 ? $result->valor_desconto - ($totalProdutos + $totalServico) : 0.00, 2, ',', '.') ?></b></td>
                                            </tr>
                                            <tr>
                                                <td>TOTAL</td>
                                                <td>R$ <?= number_format($result->valor_desconto, 2, ',', '.') ?></td>
                                            </tr>
                                        <?php else : ?>
                                            <tr>
                                                <td style="width:290px">TOTAL</td>
                                                <td>R$ <?= number_format($totalProdutos + $totalServico, 2, ',', '.') ?></td>
                                            </tr>
                                        <?php endif; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>

                <?php
                // ── Checklist de Saída ────────────────────────────────────
                if (!empty($result->checklist_saida)):
                    $_ckS = json_decode($result->checklist_saida, true) ?: [];
                    if (!empty($_ckS['itens']) || !empty($_ckS['obs'])):
                ?>
                <div class="subtitle">CHECKLIST DE SAÍDA</div>
                <div class="dados">
                    <?php if (!empty($_ckS['itens'])): ?>
                    <div style="display:grid;grid-template-columns:1fr 1fr;gap:3px 16px;margin-bottom:6px;">
                        <?php foreach($_ckS['itens'] as $_sNome => $_sEst):
                            $ss   = $_sEst==='ok' ? '✓' : ($_sEst==='defeito' ? '⚠' : '—');
                            $sc   = $_sEst==='ok' ? '#16a34a' : ($_sEst==='defeito' ? '#dc2626' : '#9ca3af');
                            $sl   = $_sEst==='ok' ? 'OK' : ($_sEst==='defeito' ? 'DEFEITO' : 'N/V');
                        ?>
                        <div style="display:flex;align-items:center;gap:4px;font-size:11px;padding:2px 0;">
                            <span style="color:<?= $sc ?>;font-weight:700;min-width:10px;"><?= $ss ?></span>
                            <span style="flex:1;"><?= htmlspecialchars($_sNome) ?></span>
                            <span style="font-size:9px;font-weight:700;color:<?= $sc ?>;background:<?= $_sEst==='defeito' ? '#fef2f2' : ($_sEst==='ok' ? '#f0fdf4' : '#f9fafb') ?>;padding:1px 5px;border-radius:3px;"><?= $sl ?></span>
                        </div>
                        <?php endforeach; ?>
                    </div>
                    <?php endif; ?>
                    <?php if (!empty($_ckS['obs'])): ?>
                    <div style="font-size:11px;color:#555;border-top:1px solid #e5e7eb;padding-top:4px;margin-top:4px;">
                        <b>Obs.:</b> <?= nl2br(htmlspecialchars($_ckS['obs'])) ?>
                    </div>
                    <?php endif; ?>
                </div>
                <?php endif; endif; ?>

            </section>
            <footer>
                <div class="detalhes">
                    <span>Data inicial: <b><?= date('d/m/Y', strtotime($result->dataInicial)) ?></b></span>
                    <span>ORDEM DE SERVIÇO <b>#<?= str_pad($result->idOs, 4, 0, STR_PAD_LEFT) ?></b></span>
                    <span>Data final: <b><?= $result->dataFinal ? date('d/m/Y', strtotime($result->dataFinal)) : '' ?></b></span>
                </div>
                <div class="assinaturas">
                    <span>Assinatura do cliente</span>
                    <span>Assinatura do técnico</span>
                </div>
            </footer>
        </div>

        <?php if ($configuration['control_2vias']) : ?>
            <div class="sub-page novaPagina" style="display:none;">
                <header>
                    <?php if ($emitente == null) : ?>
                        <div class="alert alert-danger" role="alert">
                            Você precisa configurar os dados do emitente. >>> <a href="<?=base_url()?>index.php/sisos/emitente">Configurar</a>
                        </div>
                    <?php else : ?>
                        <div class="imgLogo" class="align-middle">
                            <img src="<?= $logoSrc ?>" class="img-fluid" style="width:140px;">
                        </div>
                        <div class="emitente">
                            <span style="font-size: 16px;"><b><?= $emitente->nome ?></b></span></br>
                            <?php if ($emitente->cnpj != "00.000.000/0000-00") : ?>
                                <span class="align-middle">CNPJ: <?= $emitente->cnpj ?></span></br>
                            <?php endif; ?>
                            <span class="align-middle">
                                Endereço: <?= $emitente->rua.', '.$emitente->numero.', '.$emitente->bairro ?><br>
                                <?= $emitente->cidade.' - '.$emitente->uf.' - '.$emitente->cep ?>
                            </span>
                        </div>
                        <div class="contatoEmitente">
                            <span style="font-weight: bold;">Tel: <?= $emitente->telefone ?></span></br>
                            <span style="font-weight: bold;"><?= $emitente->email ?></span></br>
                            <span style="word-break: break-word;">Responsável: <b><?= $result->nome ?></b></span>
                        </div>
                    <?php endif; ?>
                </header>
                <section>
                    <div class="title">
                        <!-- VIA EMPRESA  -->
                        <?php $totalServico = 0;
$totalProdutos = 0; ?>
                        <?php if ($configuration['control_2vias']) : ?><span class="via">Via Empresa</span><?php endif; ?>
                        ORDEM DE SERVIÇO #<?= str_pad($result->idOs, 4, 0, STR_PAD_LEFT) ?>
                        <span class="emissao">Emissão: <?= date('d/m/Y') ?></span>
                    </div>

                    <?php if ($result->dataInicial != null): ?>
                        <div class="tabela">
                            <table class="table table-bordered">
                                <thead>
                                    <tr class="table-secondary">
                                        <th class="text-center">STATUS</th>
                                        <th class="text-center">DATA INICIAL</th>
                                        <th class="text-center">DATA FINAL</th>
                                        <?php if ($result->garantia) : ?>
                                            <th class="text-center">GARANTIA</th>
                                        <?php endif; ?>
                                        <?php if (in_array($result->status, ['Finalizado', 'Faturado'])) : ?>
                                            <th class="text-center">VENC. GARANTIA</th>
                                        <?php endif; ?>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td class="text-center"><?= $result->status ?></td>
                                        <td class="text-center"><?= date('d/m/Y', strtotime($result->dataInicial)) ?></td>
                                        <td class="text-center"><?= $result->dataFinal ? date('d/m/Y', strtotime($result->dataFinal)) : '' ?></td>
                                        <?php if ($result->garantia) : ?>
                                            <td class="text-center"><?= $result->garantia . ' dia(s)' ?></td>
                                        <?php endif; ?>
                                        <?php if (in_array($result->status, ['Finalizado', 'Faturado'])) : ?>
                                            <td class="text-center"><?= dateInterval($result->dataFinal, $result->garantia) ?></td>
                                        <?php endif; ?>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    <?php endif; ?>

                    <div class="subtitle">DADOS DO CLIENTE</div>
                    <div class="dados">
                        <div>
                            <span><b><?= $result->nomeCliente ?></b></span><br />
                            <span>CPF/CNPJ: <?= $result->documento ?></span><br />
                            <span>Contato: <?= trim($result->contato_cliente.' '.$result->telefone.($result->telefone && $result->celular ? ' / '.$result->celular : $result->celular)) ?></span><br />
                            <span>E-mail: <?= $result->email ?></span><br />
                        </div>
                        <div style="text-align: right;">
                            <span>Endereço: <?= $result->rua.', '.$result->numero.', '.$result->bairro ?></span><br />
                            <span><?= $result->complemento.' - '.$result->cidade.' - '.$result->estado ?></span><br />
                            <span>CEP: <?= $result->cep ?></span><br />
                        </div>
                    </div>

                    <?php if (!empty($result->equipamento) || !empty($result->numeroSerie)) : ?>
                        <div class="subtitle">EQUIPAMENTO</div>
                        <div class="dados">
                            <div style="display:flex;gap:20px;flex-wrap:wrap;">
                                <?php if (!empty($result->equipamento)) : ?>
                                <div><b>Equipamento / Produto:</b> <?= htmlspecialchars((string)$result->equipamento) ?></div>
                                <?php endif; ?>
                                <?php if (!empty($result->numeroSerie)) : ?>
                                <div><b>Nº de Série / IMEI:</b> <?= htmlspecialchars((string)$result->numeroSerie) ?></div>
                                <?php endif; ?>
                            </div>
                        </div>
                    <?php endif; ?>


                    <?php
                // ── Senha do Celular ──────────────────────────────────────
                $tipoLabelA4 = [
                    'pin'            => 'PIN / Código Numérico',
                    'padrao'         => 'Padrão de Desbloqueio (Android)',
                    'face'           => 'Reconhecimento Facial',
                    'digital'        => 'Digital (Fingerprint)',
                    'iphone_face'    => 'Face ID (iPhone)',
                    'iphone_digital' => 'Touch ID (iPhone)',
                ];
                if (!empty($result->senha_tipo)):
                    $labelSenha = $tipoLabelA4[$result->senha_tipo] ?? $result->senha_tipo;
                ?>
                    <div class="subtitle">SENHA DO CELULAR</div>
                    <div class="dados">
                        <div style="display:flex;gap:20px;flex-wrap:wrap;align-items:center;">
                            <div><b>Tipo:</b> <?= htmlspecialchars($labelSenha) ?></div>
                            <?php if (!empty($result->senha_valor)): ?>
                            <div>
                            <b>Código:</b>
                            <span style="font-family:monospace;font-size:14px;font-weight:700;
                                         background:#f1f5f9;padding:2px 10px;border-radius:4px;
                                         border:1.5px solid #cbd5e1;">
                                    <?= htmlspecialchars($result->senha_valor) ?>
                            </span>
                        </div>
                            <?php endif; ?>
                    </div>
                </div>
                    <?php endif; ?>

                    <?php
                // ── Checklist de Entrada ──────────────────────────────────
                $_ckA4 = null;
                if ($exibirChecklist && !empty($result->checklist)) $_ckA4 = json_decode($result->checklist, true);
                $_ckA4v2 = isset($_ckA4['v']) ? $_ckA4['v'] : 1;
                if ($_ckA4 && (!empty($_ckA4['itens']) || !empty($_ckA4['obs']))):
                ?>
                    <div class="subtitle">CHECKLIST DE ENTRADA</div>
                    <div class="dados">
                        <?php if (!empty($_ckA4['itens'])): ?>
                        <?php if ($_ckA4v2 == 2): ?>
                        <!-- Formato novo v2: item => estado -->
                        <div style="display:grid;grid-template-columns:1fr 1fr;gap:3px 16px;margin-bottom:6px;">
                            <?php foreach($_ckA4['itens'] as $_itNome => $_itEst):
                                $s2   = $_itEst==='ok' ? '✓' : ($_itEst==='defeito' ? '⚠' : '—');
                                $cor2 = $_itEst==='ok' ? '#16a34a' : ($_itEst==='defeito' ? '#dc2626' : '#9ca3af');
                                $lbl2 = $_itEst==='ok' ? 'OK' : ($_itEst==='defeito' ? 'DEFEITO' : 'N/V');
                            ?>
                            <div style="display:flex;align-items:center;gap:4px;font-size:11px;padding:2px 0;">
                                <span style="color:<?= $cor2 ?>;font-weight:700;min-width:10px;"><?= $s2 ?></span>
                                <span style="flex:1;"><?= htmlspecialchars($_itNome) ?></span>
                                <span style="font-size:9px;font-weight:700;color:<?= $cor2 ?>;background:<?= $_itEst==='defeito' ? '#fef2f2' : ($_itEst==='ok' ? '#f0fdf4' : '#f9fafb') ?>;padding:1px 5px;border-radius:3px;"><?= $lbl2 ?></span>
                            </div>
                            <?php endforeach; ?>
                        </div>
                        <?php else: ?>
                        <!-- Formato legado v1: array simples -->
                        <div style="display:flex;flex-wrap:wrap;gap:4px 24px;margin-bottom:6px;">
                            <?php foreach($_ckA4['itens'] as $_itEst): ?>
                            <div style="display:flex;align-items:center;gap:5px;font-size:12px;">
                                <span style="color:#22c55e;font-size:13px;font-weight:700;">✓</span>
                                <?= htmlspecialchars($_itEst) ?>
                            </div>
                            <?php endforeach; ?>
                        </div>
                        <?php endif; ?>
                        <?php endif; ?>
                        <?php if (!empty($_ckA4['obs'])): ?>
                        <div style="font-size:12px;color:#555;border-top:1px solid #e5e7eb;padding-top:5px;margin-top:4px;">
                            <b>Obs.:</b> <?= nl2br(htmlspecialchars($_ckA4['obs'])) ?>
                        </div>
                        <?php endif; ?>
                    </div>
                    <?php endif; ?>

                    <?php if ($result->descricaoProduto) : ?>
                        <div class="subtitle">DESCRIÇÃO</div>
                        <div class="dados">
                            <div>
                                <?= printSafeHtml($result->descricaoProduto) ?>
                            </div>
                        </div>
                    <?php endif; ?>

                    <?php if ($result->defeito) : ?>
                        <div class="subtitle">DEFEITO APRESENTADO</div>
                        <div class="dados">
                            <div>
                                <?= printSafeHtml($result->defeito) ?>
                            </div>
                        </div>
                    <?php endif; ?>

                    <?php if ($result->observacoes) : ?>
                        <div class="subtitle">OBSERVAÇÕES</div>
                        <div class="dados">
                            <div>
                                <?= printSafeHtml($result->observacoes) ?>
                            </div>
                        </div>
                    <?php endif; ?>

                    <?php if ($result->laudoTecnico) : ?>
                        <div class="subtitle">PARECER TÉCNICO</div>
                        <div class="dados">
                            <div>
                                <?= printSafeHtml($result->laudoTecnico) ?>
                            </div>
                        </div>
                    <?php endif; ?>

                    <?php if ($result->garantias_id) : ?>
                        <div class="subtitle">TERMO DE GARANTIA</div>
                        <div class="dados">
                            <div style="text-align: justify;"><?= printSafeHtml($result->textoGarantia) ?></div>
                        </div>
                    <?php endif; ?>

                    <?php if ($produtos) : ?>
                        <div class="tabela">
                            <table class="table table-bordered">
                                <thead>
                                    <tr class="table-secondary">
                                        <th>PRODUTO(S)</th>
                                        <th class="text-center" width="10%">QTD</th>
                                        <th class="text-center" width="10%">UNT</th>
                                        <th class="text-end" width="15%" >SUBTOTAL</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($produtos as $p) :
                                        $totalProdutos = $totalProdutos + $p->subTotal;
                                        echo '<tr>';
                                        echo '  <td>' . htmlspecialchars($p->descricao ?? '') . '</td>';
                                        echo '  <td class="text-center">' . $p->quantidade . '</td>';
                                        echo '  <td class="text-center">' . number_format($p->preco ?: $p->precoVenda, 2, ',', '.') . '</td>';
                                        echo '  <td class="text-end">R$ ' . number_format($p->subTotal, 2, ',', '.') . '</td>';
                                        echo '</tr>';
                                    endforeach; ?>
                                    <tr>
                                        <td colspan="3" class="text-end"><b>TOTAL PRODUTOS:</b></td>
                                        <td class="text-end"><b>R$ <?= number_format($totalProdutos, 2, ',', '.') ?></b></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    <?php endif; ?>

                    <?php if ($servicos) : ?>
                        <div class="tabela">
                            <table class="table table-bordered">
                                <thead>
                                    <tr class="table-secondary">
                                        <th>SERVIÇO(S)</th>
                                        <th class="text-center" width="10%">QTD</th>
                                        <th class="text-center" width="10%">UNT</th>
                                        <th class="text-end" width="15%" >SUBTOTAL</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                        setlocale(LC_MONETARY, 'en_US');
                        foreach ($servicos as $s) :
                            $preco = $s->preco ?: $s->precoVenda;
                            $subtotal = $preco * ($s->quantidade ?: 1);
                            $totalServico = $totalServico + $subtotal;
                            echo '<tr>';
                            echo '  <td>' . htmlspecialchars($s->nome ?? '') . '</td>';
                            echo '  <td class="text-center">' . ($s->quantidade ?: 1) . '</td>';
                            echo '  <td class="text-center">' . number_format($preco, 2, ',', '.') . '</td>';
                            echo '  <td class="text-end">R$ ' . number_format($subtotal, 2, ',', '.') . '</td>';
                            echo '</tr>';
                        endforeach; ?>
                                    <tr>
                                        <td colspan="3" class="text-end"><b>TOTAL SERVIÇOS:</b></td>
                                        <td class="text-end"><b>R$ <?= number_format($totalServico, 2, ',', '.') ?></b></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    <?php endif; ?>

                    <?php if ($totalProdutos != 0 || $totalServico != 0) : ?>
                        <div class="pagamento">
                            <div class="qrcode">
                                <?php if ($this->data['configuration']['pix_key']) : ?>
                                    <div><img width="130px" src="<?= $qrCode ?>" alt="QR Code de Pagamento" /></div>
                                    <div style="display: flex; flex-wrap: wrap; align-content: center;">
                                        <div style="width: 100%; text-align:center;"><i class="fas fa-camera"></i><br />Escaneie o QRCode ao lado para pagar por Pix</div>
                                        <div class="chavePix">Chave Pix: <b><?= $chaveFormatada ?></b></div>
                                    </div>
                                <?php else: ?>
                                    <div></div>
                                    <div></div>
                                <?php endif; ?>
                            </div>
                            <div>
                                <div class="tabela">
                                    <table class="table table-bordered">
                                        <thead>
                                            <tr class="table-secondary">
                                                <th colspan="2">RESUMO DOS VALORES</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php if ($result->valor_desconto != 0) : ?>
                                                <tr>
                                                    <td width="65%">SUBTOTAL</td>
                                                    <td>R$ <b><?= number_format($totalProdutos + $totalServico, 2, ',', '.') ?></b></td>
                                                </tr>
                                                <tr>
                                                    <td>DESCONTO</td>
                                                    <td>R$ <b><?= number_format($result->valor_desconto != 0 ? $result->valor_desconto - ($totalProdutos + $totalServico) : 0.00, 2, ',', '.') ?></b></td>
                                                </tr>
                                                <tr>
                                                    <td>TOTAL</td>
                                                    <td>R$ <?= number_format($result->valor_desconto, 2, ',', '.') ?></td>
                                                </tr>
                                            <?php else : ?>
                                                <tr>
                                                    <td style="width:290px">TOTAL</td>
                                                    <td>R$ <?= number_format($totalProdutos + $totalServico, 2, ',', '.') ?></td>
                                                </tr>
                                            <?php endif; ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    <?php endif; ?>

                    <?php
                // ── Checklist de Saída ────────────────────────────────────
                if (!empty($result->checklist_saida)):
                    $_ckS = json_decode($result->checklist_saida, true) ?: [];
                    if (!empty($_ckS['itens']) || !empty($_ckS['obs'])):
                ?>
                    <div class="subtitle">CHECKLIST DE SAÍDA</div>
                    <div class="dados">
                        <?php if (!empty($_ckS['itens'])): ?>
                        <div style="display:grid;grid-template-columns:1fr 1fr;gap:3px 16px;margin-bottom:6px;">
                            <?php foreach($_ckS['itens'] as $_sNome => $_sEst):
                            $ss   = $_sEst==='ok' ? '✓' : ($_sEst==='defeito' ? '⚠' : '—');
                            $sc   = $_sEst==='ok' ? '#16a34a' : ($_sEst==='defeito' ? '#dc2626' : '#9ca3af');
                            $sl   = $_sEst==='ok' ? 'OK' : ($_sEst==='defeito' ? 'DEFEITO' : 'N/V');
                        ?>
                            <div style="display:flex;align-items:center;gap:4px;font-size:11px;padding:2px 0;">
                            <span style="color:<?= $sc ?>;font-weight:700;min-width:10px;"><?= $ss ?></span>
                            <span style="flex:1;"><?= htmlspecialchars($_sNome) ?></span>
                            <span style="font-size:9px;font-weight:700;color:<?= $sc ?>;background:<?= $_sEst==='defeito' ? '#fef2f2' : ($_sEst==='ok' ? '#f0fdf4' : '#f9fafb') ?>;padding:1px 5px;border-radius:3px;"><?= $sl ?></span>
                        </div>
                            <?php endforeach; ?>
                    </div>
                        <?php endif; ?>
                        <?php if (!empty($_ckS['obs'])): ?>
                        <div style="font-size:11px;color:#555;border-top:1px solid #e5e7eb;padding-top:4px;margin-top:4px;">
                        <b>Obs.:</b> <?= nl2br(htmlspecialchars($_ckS['obs'])) ?>
                    </div>
                        <?php endif; ?>
                </div>
                    <?php endif; endif; ?>

                </section>
                <footer>
                    <div class="detalhes">
                        <span>Data inicial: <b><?= date('d/m/Y', strtotime($result->dataInicial)) ?></b></span>
                        <span>ORDEM DE SERVIÇO <b>#<?= str_pad($result->idOs, 4, 0, STR_PAD_LEFT) ?></b></span>
                        <span>Data final: <b><?= $result->dataFinal ? date('d/m/Y', strtotime($result->dataFinal)) : '' ?></b></span>
                    </div>
                    <div class="assinaturas">
                        <span>Assinatura do cliente</span>
                        <span>Assinatura do técnico</span>
                    </div>
                </footer>
            </div>
        <?php endif; ?>

        <?php if ($anexos && $imprimirAnexo) : ?>
            <div class="sub-page" id="anexos">
                <header style="border: 1px solid #cdcdcd">
                    <?php if ($emitente == null) : ?>
                        <div class="alert alert-danger" role="alert">
                            Você precisa configurar os dados do emitente. >>> <a href="<?= base_url() ?>index.php/sisos/emitente">Configurar</a>
                        </div>
                    <?php else : ?>
                        <div id="imgLogo" class="align-middle">
                            <img src="<?= $logoSrc ?>" class="img-fluid" style="width:140px;">
                        </div>
                        <div style="padding-left: 10px; padding-right: 10px; margin-top: 3px;">
                            <span style="font-size: 16px;"><b><?= $emitente->nome ?></b></span></br>
                            <?php if ($emitente->cnpj != "00.000.000/0000-00") : ?>
                                <span class="align-middle">CNPJ: <?= $emitente->cnpj ?></span></br>
                            <?php endif; ?>
                            <span class="align-middle">
                                Endereço: <?= $emitente->rua.', '.$emitente->numero.', '.$emitente->bairro ?><br>
                                <?= $emitente->cidade.' - '.$emitente->uf.' - '.$emitente->cep ?>
                            </span>
                        </div>
                        <div style="text-align: right; max-width: 230px; margin-top: 10px;">
                            <span style="font-weight: bold;">Tel: <?= $emitente->telefone ?></span></br>
                            <span style="font-weight: bold;"><?= $emitente->email ?></span></br>
                            <span style="word-break: break-word;">Responsável: <b><?= $result->nome ?></b></span>
                        </div>
                    <?php endif; ?>
                </header>
                <section>
                    <div class="title">
                        ORDEM DE SERVIÇO #<?= str_pad($result->idOs, 4, 0, STR_PAD_LEFT) ?>
                        <span class="emissao">Emissão: <?= date('d/m/Y') ?></span>
                    </div>
                    <div class="subtitle">ANEXO(S)</div>
                    <div class="dados">
                        <div style="width: 100%; display: flex; justify-content: space-around; align-items: center; flex-wrap: wrap;">
                            <?php
                                $contaAnexos = 0;
foreach ($anexos as $a) :
    if ($a->thumb) :
        $thumb = $a->url.'/thumbs/'.$a->thumb;
        $link  = $a->url.'/'.$a->anexo;
        ?>
                                        <img src="<?= $link ?>" alt="">
                            <?php
    endif;
endforeach;
?>
                        </div>
                    </div>
                <section>
            </div>
        <?php endif; ?>
    </div>
    <script type="text/javascript">
    (function() {
        // ── Lógica inteligente de 2 vias ──────────────────────────
        // Uma folha A4 tem ~277mm de área útil de conteúdo (297mm - margens)
        // Convertemos para pixels (96dpi): 277mm * 3.7795 ≈ 1047px
        var ALTURA_UTIL_A4_PX = 1047;

        var via2 = document.querySelector('.novaPagina');
        if (!via2) {
            // Sem 2ª via, imprime direto
            window.print();
            return;
        }

        // Altura da 1ª via
        var via1 = document.querySelector('.sub-page:not(.novaPagina)');
        var alturaVia1 = via1 ? via1.offsetHeight : 0;

        // Altura da 2ª via (precisa estar visível para medir)
        via2.style.display = 'flex';
        via2.style.pageBreakBefore = 'auto';
        via2.style.breakBefore = 'auto';
        var alturaVia2 = via2.offsetHeight;

        var totalAltura = alturaVia1 + alturaVia2;

        if (totalAltura <= ALTURA_UTIL_A4_PX) {
            // ✅ Cabem na mesma folha — adiciona linha divisória entre as vias
            var divisor = document.createElement('div');
            divisor.style.cssText = [
                'border-top: 2px dashed #aaa',
                'margin: 8px 0',
                'position: relative',
                'text-align: center',
            ].join(';');
            var label = document.createElement('span');
            label.textContent = '✂ Recorte aqui';
            label.style.cssText = [
                'background: white',
                'padding: 0 10px',
                'font-size: 10px',
                'color: #aaa',
                'position: absolute',
                'top: -8px',
                'left: 50%',
                'transform: translateX(-50%)',
                'white-space: nowrap',
            ].join(';');
            divisor.appendChild(label);

            // Insere divisor entre as duas vias
            via2.parentNode.insertBefore(divisor, via2);

            // Remove quebra de página
            via2.classList.remove('novaPagina');
            via2.style.pageBreakBefore = 'avoid';
            via2.style.breakBefore = 'avoid';
        } else {
            // ❌ Não cabem — mantém quebra de página
            via2.style.display = '';
            // Garante a quebra via CSS
            via2.style.pageBreakBefore = 'always';
            via2.style.breakBefore = 'page';
        }

        window.print();
    })();
    </script>
</body>
</html>
