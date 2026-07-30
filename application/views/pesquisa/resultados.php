<?php
$emojiPorNota = ['', '😞', '😕', '😐', '🙂', '🤩'];
if (! function_exists('pqEmoji')) {
    function pqEmoji($media)
    {
        global $emojiPorNota;
        if (! $media) {
            return '—';
        }
        return $emojiPorNota[(int) round($media)] ?? '—';
    }
}
$totalRespondidas = (int) ($medias->total ?? 0);
$taxaResposta = $totalEnviadas > 0 ? round(($totalRespondidas / $totalEnviadas) * 100) : 0;
?>
<style>
.pq-header{display:flex;justify-content:space-between;align-items:flex-start;margin-bottom:20px;flex-wrap:wrap;gap:14px;}
.pq-title{font-size:22px;font-weight:800;color:#e8eaf0;display:flex;align-items:center;gap:10px;}
.pq-title i{font-size:24px;color:#a78bfa;}
.pq-subtitle{font-size:13px;color:#6b7280;margin-top:2px;}

.pq-cards{display:flex;gap:14px;margin-bottom:20px;flex-wrap:wrap;}
.pq-card{flex:1;min-width:190px;background:#1a1d2e;border:1px solid rgba(255,255,255,0.07);border-radius:14px;padding:18px 20px;}
.pq-card-label{font-size:11px;font-weight:700;color:#6b7280;text-transform:uppercase;letter-spacing:.6px;margin-bottom:8px;display:flex;align-items:center;gap:6px;}
.pq-card-label i{font-size:14px;color:#a78bfa;}
.pq-card-val{display:flex;align-items:baseline;gap:8px;}
.pq-card-val .num{font-size:28px;font-weight:800;color:#e8eaf0;}
.pq-card-val .emoji{font-size:26px;}
.pq-bar{height:6px;border-radius:4px;background:#252a3a;margin-top:10px;overflow:hidden;}
.pq-bar-fill{height:100%;border-radius:4px;background:linear-gradient(90deg,#a78bfa,#7c3aed);}

.pq-stats-row{background:#1a1d2e;border:1px solid rgba(255,255,255,0.07);border-radius:14px;padding:16px 20px;margin-bottom:20px;display:flex;gap:24px;flex-wrap:wrap;}
.pq-stat{display:flex;flex-direction:column;}
.pq-stat .lbl{font-size:11px;color:#6b7280;text-transform:uppercase;letter-spacing:.5px;}
.pq-stat .val{font-size:18px;font-weight:800;color:#e8eaf0;margin-top:2px;}

.pq-section{background:#1a1d2e;border:1px solid rgba(255,255,255,0.07);border-radius:14px;overflow:hidden;}
.pq-section-head{padding:14px 18px;border-bottom:1px solid rgba(255,255,255,0.06);background:#252a3a;font-size:12px;font-weight:700;color:#9ca3af;text-transform:uppercase;letter-spacing:.6px;}
.pq-table{width:100%;border-collapse:collapse;}
.pq-table thead th{background:#1e2235;color:#9ca3af;font-size:11px;font-weight:700;text-transform:uppercase;letter-spacing:.5px;padding:10px 14px;text-align:left;border-bottom:1px solid rgba(255,255,255,0.07);}
.pq-table tbody tr{border-bottom:1px solid rgba(255,255,255,0.04);}
.pq-table tbody tr:hover{background:rgba(255,255,255,0.02);}
.pq-table tbody td{padding:10px 14px;font-size:13px;color:#c9cad6;vertical-align:top;}
.pq-notas-mini{display:flex;gap:6px;font-size:16px;}
.pq-notas-mini span{opacity:.55;font-size:11px;}
.pq-comentario{max-width:280px;color:#9ca3af;font-size:12.5px;line-height:1.4;}
.pq-empty{text-align:center;padding:50px 20px;color:#6b7280;}
.pq-empty i{font-size:44px;display:block;margin-bottom:10px;opacity:.3;color:#a78bfa;}
</style>

<div class="new122">
    <div class="pq-header">
        <div>
            <div class="pq-title"><i class='bx bx-happy-heart-eyes'></i> Pesquisa de Satisfação</div>
            <div class="pq-subtitle">Avaliações de atendimento, serviço e ambiente enviadas pelos clientes</div>
        </div>
    </div>

    <div class="pq-cards">
        <div class="pq-card">
            <div class="pq-card-label"><i class='bx bx-headphone'></i> Atendimento</div>
            <div class="pq-card-val">
                <span class="num"><?= $medias->media_atendimento ? number_format($medias->media_atendimento, 1) : '—' ?></span>
                <span class="emoji"><?= pqEmoji($medias->media_atendimento) ?></span>
            </div>
            <div class="pq-bar"><div class="pq-bar-fill" style="width:<?= $medias->media_atendimento ? ($medias->media_atendimento / 5 * 100) : 0 ?>%;"></div></div>
        </div>
        <div class="pq-card">
            <div class="pq-card-label"><i class='bx bx-wrench'></i> Serviço Realizado</div>
            <div class="pq-card-val">
                <span class="num"><?= $medias->media_servico ? number_format($medias->media_servico, 1) : '—' ?></span>
                <span class="emoji"><?= pqEmoji($medias->media_servico) ?></span>
            </div>
            <div class="pq-bar"><div class="pq-bar-fill" style="width:<?= $medias->media_servico ? ($medias->media_servico / 5 * 100) : 0 ?>%;"></div></div>
        </div>
        <div class="pq-card">
            <div class="pq-card-label"><i class='bx bx-store-alt'></i> Ambiente da Loja</div>
            <div class="pq-card-val">
                <span class="num"><?= $medias->media_ambiente ? number_format($medias->media_ambiente, 1) : '—' ?></span>
                <span class="emoji"><?= pqEmoji($medias->media_ambiente) ?></span>
            </div>
            <div class="pq-bar"><div class="pq-bar-fill" style="width:<?= $medias->media_ambiente ? ($medias->media_ambiente / 5 * 100) : 0 ?>%;"></div></div>
        </div>
    </div>

    <div class="pq-stats-row">
        <div class="pq-stat"><span class="lbl">Pesquisas Enviadas</span><span class="val"><?= $totalEnviadas ?></span></div>
        <div class="pq-stat"><span class="lbl">Respondidas</span><span class="val"><?= $totalRespondidas ?></span></div>
        <div class="pq-stat"><span class="lbl">Taxa de Resposta</span><span class="val"><?= $taxaResposta ?>%</span></div>
    </div>

    <div class="pq-section">
        <div class="pq-section-head">Últimas respostas</div>
        <?php if (empty($respostas)): ?>
        <div class="pq-empty">
            <i class='bx bx-message-square-dots'></i>
            Nenhuma pesquisa respondida ainda.
        </div>
        <?php else: ?>
        <table class="pq-table">
            <thead>
                <tr>
                    <th>Cliente</th>
                    <th>OS</th>
                    <th>Notas</th>
                    <th>Comentário</th>
                    <th style="width:130px;">Respondida em</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($respostas as $r): ?>
                <tr>
                    <td><?= htmlspecialchars($r->nomeCliente ?? '—') ?></td>
                    <td><?= $r->idOs ? '#' . str_pad($r->idOs, 4, '0', STR_PAD_LEFT) : '—' ?></td>
                    <td>
                        <div class="pq-notas-mini" title="Atendimento / Serviço / Ambiente">
                            <?= $emojiPorNota[(int) $r->nota_atendimento] ?? '—' ?>
                            <?= $emojiPorNota[(int) $r->nota_servico] ?? '—' ?>
                            <?= $emojiPorNota[(int) $r->nota_ambiente] ?? '—' ?>
                        </div>
                    </td>
                    <td class="pq-comentario"><?= $r->comentario ? htmlspecialchars($r->comentario) : '<span style="opacity:.4;">sem comentário</span>' ?></td>
                    <td style="color:#6b7280;font-size:12px;"><?= date('d/m/Y H:i', strtotime($r->data_resposta)) ?></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <?php endif; ?>
    </div>
</div>
