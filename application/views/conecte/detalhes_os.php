<?php
// Calcular totais
$totalProdutos = 0;
$totalServicos = 0;
if ($produtos) foreach ($produtos as $p) $totalProdutos += $p->subTotal;
if ($servicos) foreach ($servicos as $s) $totalServicos += $s->subTotal;
$totalGeral = $totalProdutos + $totalServicos;
$totalFinal = ($result->valor_desconto ?? 0) > 0 ? $result->valor_desconto : $totalGeral;

// Status badge
$statusMap = [
    'Aberto'          => 'mb-blue',
    'Em Andamento'    => 'mb-indigo',
    'Orçamento'       => 'mb-amber',
    'Negociação'      => 'mb-amber',
    'Finalizado'      => 'mb-green',
    'Faturado'        => 'mb-green',
    'Cancelado'       => 'mb-red',
    'Aguardando Peças'=> 'mb-amber',
    'Aprovado'        => 'mb-purple',
];
$statusCls = $statusMap[$result->status] ?? 'mb-gray';
?>

<style>
/* Trumbowyg desabilitado dark */
.trumbowyg-disabled .trumbowyg-button-pane{display:none!important;}
.trumbowyg-disabled .trumbowyg-editor{background:#13151f!important;color:#c9cad6!important;border:1px solid #444860!important;border-radius:10px!important;padding:10px 14px!important;min-height:60px!important;font-size:13px!important;line-height:1.7!important;cursor:default!important;}

/* Tabs */
.dt-tabs{display:flex;gap:4px;border-bottom:2px solid rgba(255,255,255,0.07);margin-bottom:16px;overflow-x:auto;}
.dt-tab{display:inline-flex;align-items:center;gap:6px;padding:10px 16px;font-size:12px;font-weight:700;color:#6b7280;cursor:pointer;border:none;background:none;border-bottom:3px solid transparent;margin-bottom:-2px;transition:all .15s;white-space:nowrap;}
.dt-tab:hover{color:#e8eaf0;}
.dt-tab.active{color:#fbbf24;border-bottom-color:#fbbf24;}
.dt-tab i{font-size:14px;}
.dt-pane{display:none;}
.dt-pane.active{display:block;}

/* Modal dark */
#modal-anexo.modal .modal-header{background:#1a1d2e!important;background-image:none!important;border-bottom:1px solid rgba(255,255,255,0.08)!important;padding:14px 18px!important;display:flex!important;align-items:center!important;justify-content:space-between!important;}
#modal-anexo.modal .modal-header h4{margin:0!important;font-size:15px!important;font-weight:800!important;color:#e8eaf0!important;text-shadow:none!important;}
#modal-anexo.modal .modal-header .close{color:#9ca3af!important;opacity:1!important;text-shadow:none!important;float:none!important;}
#modal-anexo.modal .modal-body{background:#13151f!important;padding:16px!important;}
#modal-anexo.modal .modal-footer{background:#1a1d2e!important;background-image:none!important;border-top:1px solid rgba(255,255,255,0.08)!important;padding:10px 16px!important;display:flex!important;justify-content:flex-end!important;gap:8px!important;}

.anexo-grid{display:flex;flex-wrap:wrap;gap:10px;padding:16px;}
.anexo-item{width:130px;height:120px;border-radius:10px;overflow:hidden;background:#252a3a;border:1px solid #444860;cursor:pointer;position:relative;display:flex;align-items:center;justify-content:center;}
.anexo-item img{width:100%;height:100%;object-fit:cover;}
.anexo-overlay{position:absolute;inset:0;background:rgba(0,0,0,0.5);opacity:0;transition:opacity .15s;display:flex;align-items:center;justify-content:center;color:#fff;font-size:20px;}
.anexo-item:hover .anexo-overlay{opacity:1;}
.anexo-nome{font-size:10px;color:#6b7280;text-align:center;padding:4px;word-break:break-all;max-height:36px;overflow:hidden;}
</style>

<link rel="stylesheet" href="<?= base_url() ?>assets/trumbowyg/ui/trumbowyg.css">
<script src="<?= base_url() ?>assets/trumbowyg/trumbowyg.js"></script>
<script src="<?= base_url() ?>assets/trumbowyg/langs/pt_br.js"></script>

<!-- Header -->
<div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:20px;flex-wrap:wrap;gap:10px;">
    <div style="display:flex;align-items:center;gap:10px;">
        <a href="<?= base_url() ?>index.php/mine/os" class="mc-btn mc-btn-ghost" style="padding:7px 12px;">
            <i class='bx bx-arrow-back'></i>
        </a>
        <div>
            <h2 style="font-size:18px;font-weight:800;color:#e8eaf0;margin:0;">
                OS <span style="color:#fbbf24;">#<?= str_pad($result->idOs,4,'0',STR_PAD_LEFT) ?></span>
            </h2>
            <span style="font-size:12px;color:#9ca3af;">Protocolo de atendimento</span>
        </div>
    </div>
    <div style="display:flex;align-items:center;gap:8px;flex-wrap:wrap;">
        <span class="mc-badge <?= $statusCls ?>" style="padding:5px 14px;font-size:12px;">
            <?= htmlspecialchars($result->status) ?>
        </span>
        <a href="<?= base_url() ?>index.php/mine/imprimirOs/<?= $result->idOs ?>" target="_blank"
           class="mc-btn mc-btn-ghost" style="padding:7px 14px;font-size:12px;">
            <i class='bx bx-printer'></i> Imprimir
        </a>
        <?php if ($result->status === 'Orçamento'): ?>
        <a href="<?= site_url('os/aprovar/'.$result->idOs.'?acao=sim') ?>"
           class="mc-btn mc-btn-success" style="padding:7px 14px;font-size:12px;">
            <i class='bx bx-check'></i> Aprovar
        </a>
        <a href="<?= site_url('os/aprovar/'.$result->idOs.'?acao=nao') ?>"
           class="mc-btn mc-btn-danger" style="padding:7px 14px;font-size:12px;">
            <i class='bx bx-x'></i> Recusar
        </a>
        <?php endif; ?>
    </div>
</div>

<!-- Tabs -->
<div class="dt-tabs">
    <button class="dt-tab active" data-tab="dtTab1">
        <i class='bx bx-detail'></i> Detalhes
    </button>
    <button class="dt-tab" data-tab="dtTab2">
        <i class='bx bx-package'></i> Peças
        <?php if (!empty($produtos)): ?>
        <span style="background:rgba(251,191,36,0.15);color:#fbbf24;font-size:10px;padding:1px 6px;border-radius:10px;"><?= count($produtos) ?></span>
        <?php endif; ?>
    </button>
    <button class="dt-tab" data-tab="dtTab3">
        <i class='bx bx-wrench'></i> Serviços
        <?php if (!empty($servicos)): ?>
        <span style="background:rgba(99,102,241,0.15);color:#a5b4fc;font-size:10px;padding:1px 6px;border-radius:10px;"><?= count($servicos) ?></span>
        <?php endif; ?>
    </button>
    <button class="dt-tab" data-tab="dtTab4">
        <i class='bx bx-paperclip'></i> Anexos
        <?php if (!empty($anexos)): ?>
        <span style="background:rgba(96,165,250,0.15);color:#60a5fa;font-size:10px;padding:1px 6px;border-radius:10px;"><?= count($anexos) ?></span>
        <?php endif; ?>
    </button>
    <?php if ($totalGeral > 0): ?>
    <button class="dt-tab" data-tab="dtTab5">
        <i class='bx bx-receipt'></i> Resumo Financeiro
    </button>
    <?php endif; ?>
</div>

<!-- ══ TAB 1: DETALHES ══ -->
<div class="dt-pane active" id="dtTab1">

    <!-- Info principal -->
    <div class="mc-card" style="margin-bottom:14px;">
        <div class="mc-card-head">
            <div class="mc-card-head-left">
                <i class='bx bx-info-circle' style="color:#fbbf24;"></i>
                <span>Informações Gerais</span>
            </div>
        </div>
        <div class="mc-card-body">
            <div style="display:grid;grid-template-columns:1fr 1fr;gap:14px;">
                <div class="mc-info-row">
                    <span class="mc-info-lbl">Técnico / Responsável</span>
                    <span class="mc-info-val" style="font-weight:600;"><?= htmlspecialchars($result->nome ?? '—') ?></span>
                </div>
                <div class="mc-info-row">
                    <span class="mc-info-lbl">Status</span>
                    <div><span class="mc-badge <?= $statusCls ?>"><?= htmlspecialchars($result->status) ?></span></div>
                </div>
                <div class="mc-info-row">
                    <span class="mc-info-lbl">Data de Abertura</span>
                    <span class="mc-info-val"><?= date('d/m/Y', strtotime($result->dataInicial)) ?></span>
                </div>
                <div class="mc-info-row">
                    <span class="mc-info-lbl">Data Final / Prazo</span>
                    <span class="mc-info-val">
                        <?= (!empty($result->dataFinal) && $result->dataFinal != '0000-00-00')
                            ? date('d/m/Y', strtotime($result->dataFinal))
                            : '<span style="color:#6b7280;">—</span>' ?>
                    </span>
                </div>
                <?php if ($result->garantia): ?>
                <div class="mc-info-row">
                    <span class="mc-info-lbl">Garantia</span>
                    <span class="mc-info-val"><?= $result->garantia ?> dia(s)
                        <?php
                        if (in_array($result->status, ['Finalizado','Faturado']) && !empty($result->dataFinal) && $result->dataFinal != '0000-00-00') {
                            $venc = dateInterval($result->dataFinal, $result->garantia);
                            $p = explode('/', $venc);
                            if (count($p) == 3) {
                                $ts  = strtotime($p[2].'-'.$p[1].'-'.$p[0]);
                                $ok  = $ts >= strtotime('today');
                                $cls = $ok ? 'mb-green' : 'mb-red';
                                $txt = $ok ? 'Válida até '.$venc : 'Vencida em '.$venc;
                                echo ' — <span class="mc-badge '.$cls.'">'.$txt.'</span>';
                            }
                        }
                        ?>
                    </span>
                </div>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <!-- Textos -->
    <?php if ($result->descricaoProduto || $result->defeito || $result->observacoes || $result->laudoTecnico): ?>
    <div class="mc-card" style="margin-bottom:14px;">
        <div class="mc-card-head">
            <div class="mc-card-head-left">
                <i class='bx bx-align-left' style="color:#60a5fa;"></i>
                <span>Descrição & Detalhes</span>
            </div>
        </div>
        <div class="mc-card-body" style="display:flex;flex-direction:column;gap:16px;">
            <?php if ($result->descricaoProduto): ?>
            <div>
                <div class="mc-info-lbl" style="margin-bottom:6px;">Produto / Equipamento</div>
                <div class="mc-text-box"><?= printSafeHtml($result->descricaoProduto) ?></div>
            </div>
            <?php endif; ?>
            <?php if ($result->defeito): ?>
            <div>
                <div class="mc-info-lbl" style="color:#f87171;margin-bottom:6px;">Defeito Apresentado</div>
                <div class="mc-text-box"><?= printSafeHtml($result->defeito) ?></div>
            </div>
            <?php endif; ?>
            <?php if ($result->observacoes): ?>
            <div>
                <div class="mc-info-lbl" style="margin-bottom:6px;">Observações</div>
                <div class="mc-text-box"><?= printSafeHtml($result->observacoes) ?></div>
            </div>
            <?php endif; ?>
            <?php if ($result->laudoTecnico && in_array($result->status, ['Finalizado','Faturado','Em Andamento'])): ?>
            <div>
                <div class="mc-info-lbl" style="color:#a78bfa;margin-bottom:6px;">Laudo Técnico</div>
                <div class="mc-text-box"><?= printSafeHtml($result->laudoTecnico) ?></div>
            </div>
            <?php endif; ?>
        </div>
    </div>
    <?php endif; ?>

</div>

<!-- ══ TAB 2: PEÇAS ══ -->
<div class="dt-pane" id="dtTab2">
    <div class="mc-tbl-wrap">
        <table class="mc-tbl">
            <thead>
                <tr><th>Produto</th><th style="width:80px;text-align:center;">Qtd</th><th style="width:120px;">Preço Unit.</th><th style="width:130px;text-align:right;">Subtotal</th></tr>
            </thead>
            <tbody>
            <?php if (!empty($produtos)): foreach ($produtos as $p): ?>
            <tr>
                <td style="font-weight:600;color:#e8eaf0;"><?= htmlspecialchars($p->descricao ?? '—') ?></td>
                <td style="text-align:center;"><?= $p->quantidade ?></td>
                <td>R$ <?= number_format($p->preco ?? 0, 2, ',', '.') ?></td>
                <td style="text-align:right;font-weight:700;color:#fbbf24;">R$ <?= number_format($p->subTotal, 2, ',', '.') ?></td>
            </tr>
            <?php endforeach; else: ?>
            <tr><td colspan="4" class="mc-empty">Nenhuma peça adicionada.</td></tr>
            <?php endif; ?>
            </tbody>
            <?php if (!empty($produtos)): ?>
            <tfoot>
                <tr>
                    <td colspan="3" style="text-align:right;padding:10px 14px;color:#9ca3af;font-weight:700;">Total Peças:</td>
                    <td style="text-align:right;padding:10px 14px;font-weight:800;color:#fbbf24;">R$ <?= number_format($totalProdutos, 2, ',', '.') ?></td>
                </tr>
            </tfoot>
            <?php endif; ?>
        </table>
    </div>
</div>

<!-- ══ TAB 3: SERVIÇOS ══ -->
<div class="dt-pane" id="dtTab3">
    <div class="mc-tbl-wrap">
        <table class="mc-tbl">
            <thead>
                <tr><th>Serviço</th><th style="width:80px;text-align:center;">Qtd</th><th style="width:120px;">Preço Unit.</th><th style="width:130px;text-align:right;">Subtotal</th></tr>
            </thead>
            <tbody>
            <?php if (!empty($servicos)): foreach ($servicos as $s): ?>
            <tr>
                <td style="font-weight:600;color:#e8eaf0;"><?= htmlspecialchars($s->nome ?? '—') ?></td>
                <td style="text-align:center;"><?= $s->quantidade ?: 1 ?></td>
                <td>R$ <?= number_format($s->preco ?? 0, 2, ',', '.') ?></td>
                <td style="text-align:right;font-weight:700;color:#fbbf24;">R$ <?= number_format($s->subTotal, 2, ',', '.') ?></td>
            </tr>
            <?php endforeach; else: ?>
            <tr><td colspan="4" class="mc-empty">Nenhum serviço adicionado.</td></tr>
            <?php endif; ?>
            </tbody>
            <?php if (!empty($servicos)): ?>
            <tfoot>
                <tr>
                    <td colspan="3" style="text-align:right;padding:10px 14px;color:#9ca3af;font-weight:700;">Total Serviços:</td>
                    <td style="text-align:right;padding:10px 14px;font-weight:800;color:#fbbf24;">R$ <?= number_format($totalServicos, 2, ',', '.') ?></td>
                </tr>
            </tfoot>
            <?php endif; ?>
        </table>
    </div>
</div>

<!-- ══ TAB 4: ANEXOS ══ -->
<div class="dt-pane" id="dtTab4">
    <?php if ($this->session->userdata('cliente_anexa')): ?>
    <div class="mc-card" style="margin-bottom:14px;">
        <div class="mc-card-head">
            <div class="mc-card-head-left"><i class='bx bx-upload' style="color:#60a5fa;"></i><span>Enviar Arquivo</span></div>
        </div>
        <div class="mc-card-body">
            <form id="formAnexos" enctype="multipart/form-data" action="javascript:;" method="post" style="display:flex;gap:10px;align-items:flex-end;flex-wrap:wrap;">
                <input type="hidden" name="idOsServico" value="<?= $result->idOs ?>">
                <div style="flex:1;min-width:200px;">
                    <label class="mc-label">Selecionar arquivos</label>
                    <input type="file" name="userfile[]" multiple
                        style="background:#13151f;border:1px solid #444860;color:#e8eaf0;border-radius:8px;padding:7px 12px;font-size:13px;width:100%;">
                </div>
                <button type="submit" class="mc-btn mc-btn-primary">
                    <i class='bx bx-paperclip'></i> Anexar
                </button>
            </form>
        </div>
    </div>
    <?php endif; ?>

    <div class="mc-card">
        <div class="mc-card-head">
            <div class="mc-card-head-left"><i class='bx bx-images' style="color:#60a5fa;"></i><span>Arquivos Anexados</span></div>
        </div>
        <div class="anexo-grid" id="divAnexos">
            <?php if (!empty($anexos)): foreach ($anexos as $a):
                $thumb = $a->thumb ? $a->url.'/thumbs/'.$a->thumb : base_url().'assets/img/icon-file.png';
                $link  = $a->thumb ? $a->url.'/'.$a->anexo      : base_url().'assets/img/icon-file.png';
            ?>
            <div>
                <a href="#modal-anexo" imagem="<?= $a->idAnexos ?>" link="<?= $link ?>"
                   class="anexo-item anexo" data-toggle="modal" role="button">
                    <img src="<?= $thumb ?>" alt="">
                    <div class="anexo-overlay"><i class='bx bx-show'></i></div>
                </a>
                <div class="anexo-nome"><?= htmlspecialchars($a->anexo) ?></div>
            </div>
            <?php endforeach; else: ?>
            <div style="padding:24px;color:#6b7280;font-size:13px;text-align:center;width:100%;">
                <i class='bx bx-paperclip' style="font-size:28px;display:block;margin-bottom:8px;opacity:.3;"></i>
                Nenhum arquivo anexado.
            </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<!-- ══ TAB 5: RESUMO FINANCEIRO ══ -->
<?php if ($totalGeral > 0): ?>
<div class="dt-pane" id="dtTab5">
    <div class="mc-card">
        <div class="mc-card-head">
            <div class="mc-card-head-left"><i class='bx bx-receipt' style="color:#fbbf24;"></i><span>Resumo dos Valores</span></div>
        </div>
        <div class="mc-card-body" style="max-width:400px;">
            <?php if ($totalProdutos > 0): ?>
            <div style="display:flex;justify-content:space-between;padding:8px 0;border-bottom:1px solid rgba(255,255,255,0.05);">
                <span style="font-size:13px;color:#9ca3af;">Total Peças</span>
                <span style="font-size:13px;font-weight:600;">R$ <?= number_format($totalProdutos, 2, ',', '.') ?></span>
            </div>
            <?php endif; ?>
            <?php if ($totalServicos > 0): ?>
            <div style="display:flex;justify-content:space-between;padding:8px 0;border-bottom:1px solid rgba(255,255,255,0.05);">
                <span style="font-size:13px;color:#9ca3af;">Total Serviços</span>
                <span style="font-size:13px;font-weight:600;">R$ <?= number_format($totalServicos, 2, ',', '.') ?></span>
            </div>
            <?php endif; ?>
            <?php if (($result->valor_desconto ?? 0) > 0): ?>
            <div style="display:flex;justify-content:space-between;padding:8px 0;border-bottom:1px solid rgba(255,255,255,0.05);">
                <span style="font-size:13px;color:#9ca3af;">Subtotal</span>
                <span style="font-size:13px;">R$ <?= number_format($totalGeral, 2, ',', '.') ?></span>
            </div>
            <div style="display:flex;justify-content:space-between;padding:8px 0;border-bottom:1px solid rgba(255,255,255,0.05);">
                <span style="font-size:13px;color:#f87171;">Desconto</span>
                <span style="font-size:13px;color:#f87171;">- R$ <?= number_format($totalGeral - $result->valor_desconto, 2, ',', '.') ?></span>
            </div>
            <?php endif; ?>
            <div style="display:flex;justify-content:space-between;padding:14px 0 4px;border-top:2px solid rgba(255,255,255,0.08);margin-top:4px;">
                <span style="font-size:16px;font-weight:800;color:#e8eaf0;">TOTAL</span>
                <span style="font-size:20px;font-weight:800;color:#fbbf24;">R$ <?= number_format($totalFinal, 2, ',', '.') ?></span>
            </div>
        </div>
    </div>
</div>
<?php endif; ?>

<!-- Modal Visualizar Anexo -->
<div id="modal-anexo" class="modal hide fade" tabindex="-1" role="dialog">
    <div class="modal-header">
        <h4 style="margin:0;font-size:15px;font-weight:800;color:#e8eaf0;display:flex;align-items:center;gap:8px;">
            <i class='bx bx-image' style="color:#60a5fa;"></i> Visualizar Anexo
        </h4>
        <button type="button" class="close" data-dismiss="modal" style="color:#9ca3af;opacity:1;text-shadow:none;float:none;">&times;</button>
    </div>
    <div class="modal-body" style="background:#13151f;text-align:center;padding:16px;">
        <div id="div-visualizar-anexo"></div>
    </div>
    <div class="modal-footer" style="background:#1a1d2e;background-image:none;border-top:1px solid rgba(255,255,255,0.08);display:flex;justify-content:flex-end;gap:8px;">
        <button class="mc-btn mc-btn-ghost" data-dismiss="modal"><i class='bx bx-x'></i> Fechar</button>
        <a href="" id="download" class="mc-btn" style="background:rgba(99,102,241,0.15);color:#a5b4fc;border:1px solid rgba(99,102,241,0.3);">
            <i class='bx bx-download'></i> Download
        </a>
    </div>
</div>

<script>
$(document).ready(function() {
    // Tabs
    $('.dt-tab').on('click', function() {
        var t = $(this).data('tab');
        $('.dt-tab').removeClass('active');
        $('.dt-pane').removeClass('active');
        $(this).addClass('active');
        $('#'+t).addClass('active');
    });

    // Visualizar anexo
    $(document).on('click', '.anexo', function(e) {
        e.preventDefault();
        var link = $(this).attr('link');
        var id   = $(this).attr('imagem');
        $('#div-visualizar-anexo').html('<img src="'+link+'" style="max-width:100%;border-radius:8px;" alt="">');
        $('#download').attr('href', '<?= base_url() ?>index.php/mine/downloadanexo/'+id);
    });
});
</script>
