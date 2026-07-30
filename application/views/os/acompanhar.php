<!DOCTYPE html>
<html lang="pt-br">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Acompanhar Reparo — OS #<?= str_pad($os->idOs, 4, '0', STR_PAD_LEFT) ?></title>
<link href='https://fonts.googleapis.com/css?family=Open+Sans:400,600,700,800' rel='stylesheet'>
<link href='https://unpkg.com/boxicons@2.1.1/css/boxicons.min.css' rel='stylesheet'>
<style>
* { box-sizing:border-box; margin:0; padding:0; }
body {
    font-family:'Open Sans', Arial, sans-serif; background:#0f1117; color:#e8eaf0;
    min-height:100vh; padding:24px 16px; display:flex; justify-content:center;
}
.wrap { width:100%; max-width:480px; }

.logo-row { display:flex; align-items:center; justify-content:center; gap:10px; margin-bottom:22px; }
.logo-row img { max-height:40px; max-width:160px; object-fit:contain; }

.card {
    background:#1a1d2e; border:1px solid rgba(255,255,255,0.07); border-radius:18px;
    padding:24px; margin-bottom:16px;
}

.hdr { text-align:center; margin-bottom:6px; }
.hdr .num { font-size:12px; color:#6b7280; font-weight:700; letter-spacing:.5px; }
.hdr h1 { font-size:19px; font-weight:800; margin-top:4px; color:#e8eaf0; }
.hdr .equip { font-size:13px; color:#9ca3af; margin-top:3px; }

.status-badge {
    display:inline-flex; align-items:center; gap:7px; margin:16px auto 4px; padding:7px 16px;
    border-radius:20px; font-size:13px; font-weight:700;
}

/* ── Trilho de progresso ── */
.trilho { margin:26px 0 6px; }
.trilho-linha { position:relative; height:4px; background:#252a3a; border-radius:4px; margin:0 4px 18px; }
.trilho-progresso { position:absolute; top:0; left:0; height:100%; border-radius:4px; background:linear-gradient(90deg,#a78bfa,#7c3aed); transition:width .4s; }
.trilho-etapas { display:flex; justify-content:space-between; }
.trilho-etapa { display:flex; flex-direction:column; align-items:center; gap:6px; flex:1; }
.trilho-bola {
    width:26px; height:26px; border-radius:50%; display:flex; align-items:center; justify-content:center;
    font-size:13px; font-weight:800; background:#252a3a; color:#6b7280; border:2px solid #2e3447; flex-shrink:0;
    transition:all .3s;
}
.trilho-bola.feita { background:#a78bfa; border-color:#a78bfa; color:#fff; }
.trilho-bola.atual { background:linear-gradient(135deg,#a78bfa,#7c3aed); border-color:#a78bfa; color:#fff; box-shadow:0 0 0 4px rgba(167,139,250,0.2); }
.trilho-label { font-size:10px; color:#6b7280; text-align:center; font-weight:600; max-width:70px; }
.trilho-label.ativo { color:#c9cad6; }

.info-grid { display:grid; grid-template-columns:1fr 1fr; gap:12px; margin-top:20px; }
.info-item { background:#161925; border-radius:12px; padding:12px 14px; }
.info-item .lbl { font-size:9.5px; color:#6b7280; font-weight:700; text-transform:uppercase; letter-spacing:.5px; margin-bottom:4px; }
.info-item .val { font-size:13.5px; font-weight:700; color:#e8eaf0; }

.emitente-row { display:flex; align-items:center; gap:10px; padding-top:16px; margin-top:16px; border-top:1px solid rgba(255,255,255,0.06); }
.emitente-row i { font-size:18px; color:#a78bfa; }
.emitente-row div { font-size:12px; color:#9ca3af; }
.emitente-row strong { color:#e8eaf0; }

.rodape { text-align:center; font-size:11px; color:#4b5563; margin-top:20px; }
</style>
</head>
<body>
<div class="wrap">

    <?php if (!empty($emitente->url_logo)): ?>
    <div class="logo-row"><img src="<?= $emitente->url_logo ?>" alt="Logo"></div>
    <?php endif; ?>

    <div class="card">
        <div class="hdr">
            <div class="num">OS #<?= str_pad($os->idOs, 4, '0', STR_PAD_LEFT) ?></div>
            <h1><?= htmlspecialchars(trim(strip_tags($os->descricaoProduto ?? '')) ?: 'Seu aparelho') ?></h1>
            <?php if (!empty($os->numeroSerie)): ?>
            <div class="equip">Nº de série/IMEI: <?= htmlspecialchars($os->numeroSerie) ?></div>
            <?php endif; ?>
        </div>

        <div style="text-align:center;">
            <?php if ($cancelado): ?>
            <span class="status-badge" style="background:rgba(239,68,68,0.15);color:#f87171;"><i class='bx bx-x-circle'></i> <?= htmlspecialchars($os->status) ?></span>
            <?php else: ?>
            <span class="status-badge" style="background:rgba(167,139,250,0.15);color:#a78bfa;"><i class='bx bx-time-five'></i> <?= htmlspecialchars($os->status) ?></span>
            <?php endif; ?>
        </div>

        <?php if (!$cancelado): ?>
        <div class="trilho">
            <div class="trilho-linha">
                <div class="trilho-progresso" style="width:<?= $etapaAtual === 0 ? 5 : ($etapaAtual / (count($etapas) - 1)) * 100 ?>%;"></div>
            </div>
            <div class="trilho-etapas">
                <?php foreach ($etapas as $i => $et): ?>
                <div class="trilho-etapa">
                    <div class="trilho-bola <?= $i < $etapaAtual ? 'feita' : ($i === $etapaAtual ? 'atual' : '') ?>">
                        <?= $i < $etapaAtual ? '<i class="bx bx-check"></i>' : ($i + 1) ?>
                    </div>
                    <div class="trilho-label <?= $i <= $etapaAtual ? 'ativo' : '' ?>"><?= htmlspecialchars($et) ?></div>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
        <?php endif; ?>

        <?php if (!empty($aguardandoAprovacao)): ?>
        <div id="aprovacaoBox" style="background:#161925;border-radius:14px;padding:18px;margin-top:18px;text-align:center;">
            <div style="font-size:13.5px;font-weight:700;color:#e8eaf0;margin-bottom:4px;">Aguardando sua aprovação</div>
            <div style="font-size:12px;color:#9ca3af;margin-bottom:16px;">Confira o orçamento com a assistência e responda abaixo.</div>
            <div style="display:flex;gap:10px;">
                <button onclick="sisosDecidir('recusado')" id="btnRecusar"
                        style="flex:1;padding:12px;border-radius:10px;border:1px solid rgba(239,68,68,0.35);background:rgba(239,68,68,0.1);color:#f87171;font-weight:700;font-size:13px;cursor:pointer;">
                    <i class='bx bx-x'></i> Recusar
                </button>
                <button onclick="sisosDecidir('aprovado')" id="btnAprovar"
                        style="flex:1;padding:12px;border-radius:10px;border:none;background:linear-gradient(135deg,#22c55e,#16a34a);color:#fff;font-weight:700;font-size:13px;cursor:pointer;">
                    <i class='bx bx-check'></i> Aprovar Orçamento
                </button>
            </div>
        </div>
        <?php endif; ?>

        <div class="info-grid">
            <div class="info-item">
                <div class="lbl">Aberta em</div>
                <div class="val"><?= $os->dataInicial ? date('d/m/Y', strtotime($os->dataInicial)) : '-' ?></div>
            </div>
            <div class="info-item">
                <div class="lbl">Previsão de Entrega</div>
                <div class="val"><?= !empty($os->dataFinal) ? date('d/m/Y', strtotime($os->dataFinal)) : 'A definir' ?></div>
            </div>
        </div>

        <?php if (!empty($emitente)): ?>
        <div class="emitente-row">
            <i class='bx bx-store-alt'></i>
            <div><strong><?= htmlspecialchars($emitente->nome ?? '') ?></strong><br><?= htmlspecialchars($emitente->telefone ?? '') ?></div>
        </div>
        <?php endif; ?>
    </div>

    <div class="rodape">Página atualizada automaticamente conforme o andamento do seu reparo.</div>
</div>

<script>
function sisosDecidir(decisao) {
    if (decisao === 'recusado' && !confirm('Tem certeza que deseja recusar este orçamento?')) return;

    document.getElementById('btnAprovar').disabled = true;
    document.getElementById('btnRecusar').disabled = true;

    fetch('<?= site_url("mine/decidirOrcamento/" . $token) ?>', {
        method: 'POST',
        headers: {'Content-Type': 'application/x-www-form-urlencoded'},
        body: 'decisao=' + encodeURIComponent(decisao)
    })
    .then(function(res) { return res.json(); })
    .then(function(data) {
        if (data.sucesso) {
            var box = document.getElementById('aprovacaoBox');
            if (decisao === 'aprovado') {
                box.innerHTML = '<div style="color:#4ade80;font-weight:700;font-size:14px;"><i class="bx bx-check-circle"></i> Orçamento aprovado! Já avisamos a assistência, obrigado.</div>';
            } else {
                box.innerHTML = '<div style="color:#f87171;font-weight:700;font-size:14px;"><i class="bx bx-x-circle"></i> Orçamento recusado. Obrigado por avisar.</div>';
            }
        } else {
            alert(data.erro || 'Não foi possível registrar sua decisão. Tente novamente.');
            document.getElementById('btnAprovar').disabled = false;
            document.getElementById('btnRecusar').disabled = false;
        }
    })
    .catch(function() {
        alert('Erro de conexão. Tente novamente em instantes.');
        document.getElementById('btnAprovar').disabled = false;
        document.getElementById('btnRecusar').disabled = false;
    });
}
</script>
</body>
</html>
