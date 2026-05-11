<?php
$valor = ($result->valor_desconto > 0 && $result->desconto > 0) ? $result->valor_desconto : $result->valorTotal;
$valorFormatado = 'R$ ' . number_format($valor, 2, ',', '.');

// Valor por extenso
function _num($n, $u, $d, $c) {
    if ($n === 0) return '';
    $r = '';
    if ($n >= 100) {
        $r = $c[(int)($n/100)];
        $n = $n % 100;
        if ($n > 0) { $r = str_replace('cem', 'cento', $r) . ' e '; }
    }
    if ($n >= 20) { $r .= $d[(int)($n/10)]; $n = $n%10; if ($n) $r .= ' e '; }
    if ($n > 0) $r .= $u[$n];
    return $r;
}
function valorPorExtenso($valor) {
    $u = ['','UM','DOIS','TRÊS','QUATRO','CINCO','SEIS','SETE','OITO','NOVE',
        'DEZ','ONZE','DOZE','TREZE','QUATORZE','QUINZE','DEZESSEIS','DEZESSETE','DEZOITO','DEZENOVE'];
    $d = ['','','VINTE','TRINTA','QUARENTA','CINQUENTA','SESSENTA','SETENTA','OITENTA','NOVENTA'];
    $c = ['','CEM','DUZENTOS','TREZENTOS','QUATROCENTOS','QUINHENTOS','SEISCENTOS','SETECENTOS','OITOCENTOS','NOVECENTOS'];
    $inteiro = (int)$valor;
    $cts = (int)round(($valor - $inteiro) * 100);
    $ext = '';
    if ($inteiro >= 1000) {
        $mil = (int)($inteiro / 1000);
        $ext .= ($mil === 1 ? 'MIL' : _num($mil,$u,$d,$c) . ' MIL');
        $inteiro %= 1000;
        if ($inteiro > 0) $ext .= ' E ';
    }
    $ext .= _num($inteiro, $u, $d, $c);
    $ext = trim($ext) ?: 'ZERO';
    $ext .= ($inteiro === 1 ? ' REAL' : ' REAIS');
    if ($cts > 0) $ext .= ' E ' . _num($cts,$u,$d,$c) . ' CENTAVO' . ($cts > 1 ? 'S' : '');
    return $ext;
}
$valorExtenso = valorPorExtenso((float)$valor);

$vencimento = $this->input->get('vencimento') ?: date('d/m/Y', strtotime('+30 days'));
// Vencimento por extenso
$vencParts = explode('/', $vencimento);
$meses = ['','JANEIRO','FEVEREIRO','MARÇO','ABRIL','MAIO','JUNHO','JULHO','AGOSTO','SETEMBRO','OUTUBRO','NOVEMBRO','DEZEMBRO'];
$vencExtenso = count($vencParts) === 3
    ? 'O DIA ' . (int)$vencParts[0] . ' DE ' . ($meses[(int)$vencParts[1]] ?? '') . ' DE ' . $vencParts[2]
    : $vencimento;

$nomeEmitente = $emitente ? $emitente->nome : 'N/D';
$cnpjEmitente = $emitente ? ($emitente->cnpj ?? ($emitente->cpf ?? '')) : '';
$endEmitente  = $emitente ? trim(($emitente->rua ?? '') . ($emitente->numero ? ', ' . $emitente->numero : '') . ($emitente->bairro ? ', ' . $emitente->bairro : '')) : '';
$cidEmitente  = $emitente ? (($emitente->cidade ?? '') . ($emitente->uf ? '/' . $emitente->uf : '')) : '';

$nomeDevedor  = $result->nomeCliente;
$cpfDevedor   = $result->documento ?? '';
$endDevedor   = trim(($result->rua ?? '') . ($result->numero ? ', ' . $result->numero : '') . ($result->bairro ? ', ' . $result->bairro : ''));
$cidDevedor   = ($result->cidade ?? '') . ($result->estado ? '/' . $result->estado : '');

$numPromissoria = '#' . str_pad($result->idVendas, 1, '0', STR_PAD_LEFT) . '/001#';
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Nota Promissória - Venda #<?= $result->idVendas ?></title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            font-family: Arial, Helvetica, sans-serif;
            font-size: 11px;
            background: #f0f0f0;
            color: #000;
        }
        .no-print {
            text-align: center;
            padding: 12px;
            background: #2c3e50;
            color: #fff;
        }
        .no-print button {
            padding: 8px 22px;
            font-size: 13px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            margin: 0 6px;
        }
        .btn-print { background: #27ae60; color: #fff; }
        .btn-close  { background: #7f8c8d; color: #fff; }

        .page {
            width: 210mm;
            margin: 8mm auto;
            background: #fff;
        }

        /* ── NOTA PROMISSÓRIA ── */
        .promissoria {
            width: 190mm;
            border: 2px solid #000;
            margin: 8mm auto;
            padding: 0;
            font-size: 11px;
        }

        /* Cabeçalho */
        .prom-header {
            display: flex;
            justify-content: space-between;
            align-items: stretch;
            border-bottom: 1.5px solid #000;
        }
        .prom-header-left {
            padding: 5mm 5mm 4mm;
            flex: 1;
        }
        .prom-titulo {
            font-size: 18px;
            font-weight: 900;
            letter-spacing: 3px;
            text-transform: uppercase;
        }
        .prom-numero {
            font-size: 11px;
            margin-top: 1mm;
        }
        .prom-header-right {
            border-left: 1.5px solid #000;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 4mm 6mm;
            min-width: 55mm;
            text-align: center;
        }
        .prom-venc-label {
            font-size: 9px;
            font-weight: bold;
            text-transform: uppercase;
            letter-spacing: 1px;
            margin-bottom: 2mm;
        }
        .prom-venc-value {
            font-size: 12px;
            font-weight: bold;
            border: 1.5px solid #000;
            padding: 2mm 5mm;
            min-width: 45mm;
            text-align: center;
        }

        /* Corpo */
        .prom-body {
            padding: 4mm 5mm;
        }

        .prom-valor-box {
            display: flex;
            justify-content: flex-end;
            margin-bottom: 3mm;
        }
        .prom-valor-label {
            font-size: 9px;
            font-weight: bold;
            letter-spacing: 1px;
            text-transform: uppercase;
            text-align: right;
            margin-right: 2mm;
            padding-top: 1mm;
        }
        .prom-valor-num {
            border: 2px solid #000;
            padding: 2mm 6mm;
            font-size: 16px;
            font-weight: bold;
            min-width: 55mm;
            text-align: center;
        }

        /* Texto principal */
        .prom-texto {
            margin: 2mm 0 4mm;
            line-height: 1.7;
            text-align: justify;
        }
        .prom-texto strong { text-transform: uppercase; }

        /* Campos com linha */
        .prom-row {
            display: flex;
            gap: 4mm;
            margin-bottom: 3mm;
        }
        .prom-campo {
            flex: 1;
            display: flex;
            flex-direction: column;
        }
        .prom-campo-label {
            font-size: 8px;
            font-weight: bold;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 1mm;
            color: #333;
        }
        .prom-campo-valor {
            border-bottom: 1px solid #000;
            min-height: 6mm;
            padding: 1mm 0 0;
            font-size: 11px;
            font-weight: bold;
        }

        /* Rodapé com local/data e assinatura */
        .prom-footer {
            border-top: 1.5px solid #000;
            display: flex;
            justify-content: space-between;
            align-items: stretch;
        }
        .prom-footer-loc {
            flex: 1;
            border-right: 1.5px solid #000;
            padding: 3mm 5mm;
        }
        .prom-footer-assin {
            flex: 1;
            padding: 3mm 5mm;
            text-align: center;
            display: flex;
            flex-direction: column;
            justify-content: flex-end;
        }
        .prom-assin-linha {
            border-top: 1px solid #000;
            padding-top: 1mm;
            font-size: 10px;
        }

        /* Linha separadora para 2ª via */
        .separador {
            border-top: 1px dashed #555;
            margin: 0 auto;
            width: 190mm;
            text-align: center;
            font-size: 9px;
            color: #666;
            padding: 1mm 0;
        }

        @media print {
            body { background: #fff; margin: 0; }
            .no-print { display: none !important; }
            .page { margin: 0; width: 100%; }
            .promissoria { margin: 5mm auto; }
        }
    </style>
</head>
<body>

<div class="no-print">
    <button class="btn-print" onclick="window.print()">🖨️ Imprimir Nota Promissória</button>
    <button class="btn-close" onclick="window.close()">✕ Fechar</button>
</div>

<div class="page">
    <?php for ($via = 1; $via <= 2; $via++): ?>

    <?php if ($via === 2): ?>
    <div class="separador">✂ ─────────────────────────────── 2ª VIA ─────────────────────────────── ✂</div>
    <?php endif; ?>

    <div class="promissoria">

        <!-- Cabeçalho -->
        <div class="prom-header">
            <div class="prom-header-left">
                <div class="prom-titulo">Nota Promissória</div>
                <div class="prom-numero">Nº <?= htmlspecialchars($numPromissoria) ?></div>
            </div>
            <div class="prom-header-right">
                <div class="prom-venc-label">Vencimento</div>
                <div class="prom-venc-value"><?= htmlspecialchars($vencimento) ?></div>
            </div>
        </div>

        <!-- Corpo -->
        <div class="prom-body">

            <!-- Valor em destaque -->
            <div class="prom-valor-box">
                <div class="prom-valor-label">Valor&nbsp;</div>
                <div class="prom-valor-num"><?= $valorFormatado ?></div>
            </div>

            <!-- Texto da nota -->
            <div class="prom-texto">
                No dia <strong><?= $vencExtenso ?></strong> pagaremos por esta única via de
                <strong>NOTA PROMISSÓRIA</strong> a
                <strong><?= htmlspecialchars($nomeEmitente) ?></strong>
                <?php if ($cnpjEmitente): ?>
                    CNPJ/CPF <?= htmlspecialchars($cnpjEmitente) ?>
                <?php endif; ?>
                ou à sua ordem a quantia de <strong><?= $valorExtenso ?></strong>
                em moeda corrente desse país.
            </div>

            <!-- Campos do devedor -->
            <div class="prom-row">
                <div class="prom-campo" style="flex:2">
                    <div class="prom-campo-label">Nome do Emitente</div>
                    <div class="prom-campo-valor"><?= htmlspecialchars($nomeDevedor) ?></div>
                </div>
                <div class="prom-campo">
                    <div class="prom-campo-label">CPF / CNPJ</div>
                    <div class="prom-campo-valor"><?= htmlspecialchars($cpfDevedor) ?></div>
                </div>
            </div>

            <div class="prom-row">
                <div class="prom-campo" style="flex:2">
                    <div class="prom-campo-label">Endereço</div>
                    <div class="prom-campo-valor"><?= htmlspecialchars($endDevedor) ?></div>
                </div>
                <div class="prom-campo">
                    <div class="prom-campo-label">Cidade / UF</div>
                    <div class="prom-campo-valor"><?= htmlspecialchars($cidDevedor) ?></div>
                </div>
            </div>

        </div>

        <!-- Rodapé: local de pagamento / assinatura -->
        <div class="prom-footer">
            <div class="prom-footer-loc">
                <div class="prom-campo-label">Local de pagamento</div>
                <div style="font-weight:bold;margin-bottom:2mm;"><?= htmlspecialchars($cidEmitente ?: ($cidDevedor ?: '')) ?></div>
                <div class="prom-campo-label">Data da Emissão</div>
                <div style="font-weight:bold;"><?= date('d/m/Y') ?></div>
            </div>
            <div class="prom-footer-assin">
                <div style="flex:1"></div>
                <div class="prom-assin-linha">
                    Assinatura do Emitente<br>
                    <small><?= htmlspecialchars($nomeDevedor) ?></small>
                </div>
            </div>
        </div>

    </div>

    <?php endfor; ?>
</div>

</body>
</html>
