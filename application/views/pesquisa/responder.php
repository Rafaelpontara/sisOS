<!DOCTYPE html>
<html lang="pt-br">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Pesquisa de Satisfação<?= $os ? ' — OS #' . str_pad($os->idOs, 4, '0', STR_PAD_LEFT) : '' ?></title>
<link href='https://fonts.googleapis.com/css?family=Open+Sans:400,600,700,800' rel='stylesheet'>
<style>
* { box-sizing:border-box; margin:0; padding:0; }
body {
    font-family:'Open Sans', Arial, sans-serif; background:#0f1117; color:#e8eaf0;
    min-height:100vh; padding:24px 16px; display:flex; justify-content:center;
}
.wrap { width:100%; max-width:480px; }

.logo-row { display:flex; align-items:center; justify-content:center; gap:10px; margin-bottom:20px; }
.logo-row img { max-height:40px; max-width:160px; object-fit:contain; }

.card {
    background:#1a1d2e; border:1px solid rgba(255,255,255,0.07); border-radius:18px;
    padding:26px 22px; margin-bottom:16px;
}

.hdr { text-align:center; margin-bottom:24px; }
.hdr .icon { font-size:38px; margin-bottom:8px; }
.hdr h1 { font-size:19px; font-weight:800; color:#e8eaf0; margin-bottom:6px; }
.hdr p { font-size:13px; color:#9ca3af; line-height:1.5; }
.hdr .num { font-size:11px; color:#6b7280; font-weight:700; letter-spacing:.5px; margin-top:6px; display:block; }

.criterio { margin-bottom:26px; }
.criterio-label { font-size:13.5px; font-weight:700; color:#c9cad6; margin-bottom:12px; display:flex; align-items:center; gap:7px; }
.criterio-label i { font-size:16px; color:#a78bfa; }

.emoji-row { display:flex; justify-content:space-between; gap:6px; }
.emoji-btn {
    flex:1; background:#161925; border:2px solid transparent; border-radius:14px;
    padding:10px 4px 8px; font-size:26px; cursor:pointer; transition:all .2s;
    display:flex; flex-direction:column; align-items:center; gap:4px; opacity:.55;
}
.emoji-btn:hover { opacity:.85; transform:translateY(-2px); }
.emoji-btn.selecionado {
    opacity:1; border-color:#a78bfa; background:rgba(167,139,250,0.12);
    transform:translateY(-4px) scale(1.08);
    box-shadow:0 4px 16px rgba(167,139,250,0.25);
}
.emoji-btn span { font-size:9px; font-weight:700; color:#6b7280; text-align:center; line-height:1.2; }
.emoji-btn.selecionado span { color:#a78bfa; }

.comentario-box { margin-top:4px; }
.comentario-box label { font-size:12.5px; color:#9ca3af; margin-bottom:8px; display:block; }
.comentario-box textarea {
    width:100%; background:#161925; border:1px solid #2e3447; border-radius:10px;
    padding:12px 14px; color:#e8eaf0; font-family:inherit; font-size:13px; resize:vertical;
    min-height:70px;
}
.comentario-box textarea:focus { outline:none; border-color:#a78bfa; }

.btn-enviar {
    width:100%; margin-top:20px; padding:14px; border:none; border-radius:12px;
    background:linear-gradient(135deg,#a78bfa,#7c3aed); color:#fff; font-size:14.5px; font-weight:800;
    cursor:pointer; display:flex; align-items:center; justify-content:center; gap:8px;
    transition:transform .15s, opacity .15s;
}
.btn-enviar:hover { transform:translateY(-1px); }
.btn-enviar:disabled { opacity:.45; cursor:not-allowed; transform:none; }

.rodape { text-align:center; font-size:11px; color:#4b5563; margin-top:20px; }

/* ── Tela de agradecimento ── */
.sucesso { text-align:center; padding:20px 0; }
.sucesso .check {
    width:70px; height:70px; border-radius:50%; background:rgba(74,222,128,0.12);
    display:flex; align-items:center; justify-content:center; margin:0 auto 18px;
    font-size:36px; animation:pop .4s ease;
}
@keyframes pop { 0%{transform:scale(0);} 70%{transform:scale(1.15);} 100%{transform:scale(1);} }
.sucesso h2 { font-size:18px; font-weight:800; color:#e8eaf0; margin-bottom:8px; }
.sucesso p { font-size:13px; color:#9ca3af; line-height:1.5; }

.spin { animation:spin .8s linear infinite; display:inline-block; }
@keyframes spin { to { transform:rotate(360deg); } }
</style>
</head>
<body>
<div class="wrap">

    <?php if (!empty($emitente->url_logo)): ?>
    <div class="logo-row"><img src="<?= $emitente->url_logo ?>" alt="Logo"></div>
    <?php endif; ?>

    <div class="card">
        <?php if ($pesquisa->respondida): ?>
            <div class="sucesso">
                <div class="check">🙏</div>
                <h2>Você já avaliou este atendimento</h2>
                <p>Muito obrigado pelo seu tempo! Sua opinião já foi registrada.</p>
            </div>
        <?php else: ?>
            <div id="formPesquisa">
                <div class="hdr">
                    <div class="icon">⭐</div>
                    <h1>Como foi sua experiência?</h1>
                    <p>Sua opinião ajuda a <?= htmlspecialchars($emitente->nome ?? 'nossa loja') ?> a melhorar cada vez mais.</p>
                    <?php if ($os): ?>
                    <span class="num">OS #<?= str_pad($os->idOs, 4, '0', STR_PAD_LEFT) ?><?php if (!empty($os->descricaoProduto)): ?> — <?= htmlspecialchars(trim(strip_tags($os->descricaoProduto))) ?><?php endif; ?></span>
                    <?php endif; ?>
                </div>

                <div class="criterio" data-criterio="atendimento">
                    <div class="criterio-label"><i class='bx bx-headphone'></i> Atendimento</div>
                    <div class="emoji-row">
                        <button type="button" class="emoji-btn" data-nota="1">😞<span>Péssimo</span></button>
                        <button type="button" class="emoji-btn" data-nota="2">😕<span>Ruim</span></button>
                        <button type="button" class="emoji-btn" data-nota="3">😐<span>Regular</span></button>
                        <button type="button" class="emoji-btn" data-nota="4">🙂<span>Bom</span></button>
                        <button type="button" class="emoji-btn" data-nota="5">🤩<span>Ótimo</span></button>
                    </div>
                </div>

                <div class="criterio" data-criterio="servico">
                    <div class="criterio-label"><i class='bx bx-wrench'></i> Serviço Realizado</div>
                    <div class="emoji-row">
                        <button type="button" class="emoji-btn" data-nota="1">😞<span>Péssimo</span></button>
                        <button type="button" class="emoji-btn" data-nota="2">😕<span>Ruim</span></button>
                        <button type="button" class="emoji-btn" data-nota="3">😐<span>Regular</span></button>
                        <button type="button" class="emoji-btn" data-nota="4">🙂<span>Bom</span></button>
                        <button type="button" class="emoji-btn" data-nota="5">🤩<span>Ótimo</span></button>
                    </div>
                </div>

                <div class="criterio" data-criterio="ambiente">
                    <div class="criterio-label"><i class='bx bx-store-alt'></i> Ambiente da Loja</div>
                    <div class="emoji-row">
                        <button type="button" class="emoji-btn" data-nota="1">😞<span>Péssimo</span></button>
                        <button type="button" class="emoji-btn" data-nota="2">😕<span>Ruim</span></button>
                        <button type="button" class="emoji-btn" data-nota="3">😐<span>Regular</span></button>
                        <button type="button" class="emoji-btn" data-nota="4">🙂<span>Bom</span></button>
                        <button type="button" class="emoji-btn" data-nota="5">🤩<span>Ótimo</span></button>
                    </div>
                </div>

                <div class="comentario-box">
                    <label>Quer deixar mais algum comentário? (opcional)</label>
                    <textarea id="comentario" placeholder="Conte pra gente..."></textarea>
                </div>

                <button type="button" class="btn-enviar" id="btnEnviar" disabled>Avalie os três critérios acima</button>
            </div>

            <div id="telaSucesso" style="display:none;">
                <div class="sucesso">
                    <div class="check">🎉</div>
                    <h2>Avaliação enviada!</h2>
                    <p>Muito obrigado por avaliar nosso atendimento. Isso nos ajuda demais a melhorar.</p>
                </div>
            </div>
        <?php endif; ?>
    </div>

    <div class="rodape">Pesquisa de satisfação — resposta 100% anônima pra nossa equipe interna.</div>
</div>

<link href='https://unpkg.com/boxicons@2.1.1/css/boxicons.min.css' rel='stylesheet'>
<script>
function sisosLerCookieCsrf() {
    var m = document.cookie.match('(^|;)\\s*<?= $this->config->item('csrf_cookie_name') ?>\\s*=\\s*([^;]+)');
    return m ? decodeURIComponent(m.pop()) : '<?= $this->security->get_csrf_hash() ?>';
}

(function() {
    var notas = { atendimento: null, servico: null, ambiente: null };
    var btnEnviar = document.getElementById('btnEnviar');
    if (!btnEnviar) return; // já respondida, nem monta o form

    document.querySelectorAll('.criterio').forEach(function(bloco) {
        var criterio = bloco.getAttribute('data-criterio');
        bloco.querySelectorAll('.emoji-btn').forEach(function(btn) {
            btn.addEventListener('click', function() {
                bloco.querySelectorAll('.emoji-btn').forEach(function(b) { b.classList.remove('selecionado'); });
                btn.classList.add('selecionado');
                notas[criterio] = parseInt(btn.getAttribute('data-nota'), 10);
                atualizarBotao();
            });
        });
    });

    function atualizarBotao() {
        var completo = notas.atendimento && notas.servico && notas.ambiente;
        btnEnviar.disabled = !completo;
        btnEnviar.textContent = completo ? 'Enviar Avaliação' : 'Avalie os três critérios acima';
    }

    btnEnviar.addEventListener('click', function() {
        btnEnviar.disabled = true;
        btnEnviar.innerHTML = "<i class='bx bx-loader-alt spin'></i> Enviando...";

        fetch('<?= site_url("pesquisa/salvar") ?>', {
            method: 'POST',
            headers: {'Content-Type': 'application/x-www-form-urlencoded'},
            body: 'token=<?= urlencode($token) ?>'
                + '&nota_atendimento=' + notas.atendimento
                + '&nota_servico=' + notas.servico
                + '&nota_ambiente=' + notas.ambiente
                + '&comentario=' + encodeURIComponent(document.getElementById('comentario').value)
                + '&<?= $this->security->get_csrf_token_name() ?>=' + encodeURIComponent(sisosLerCookieCsrf())
        })
        .then(function(res) { return res.json(); })
        .then(function(data) {
            if (data.sucesso) {
                document.getElementById('formPesquisa').style.display = 'none';
                document.getElementById('telaSucesso').style.display = 'block';
            } else {
                alert(data.erro || 'Não foi possível enviar. Tente novamente.');
                btnEnviar.disabled = false;
                atualizarBotao();
            }
        })
        .catch(function() {
            alert('Erro de conexão. Tente novamente em instantes.');
            btnEnviar.disabled = false;
            atualizarBotao();
        });
    });
})();
</script>
</body>
</html>
