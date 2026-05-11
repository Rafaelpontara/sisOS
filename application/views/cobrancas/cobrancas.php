<style>
/* ── Layout ── */
.cob-header{display:flex;justify-content:space-between;align-items:center;margin-bottom:18px;flex-wrap:wrap;gap:10px;}
.cob-title{display:flex;align-items:center;gap:10px;}
.cob-title i{font-size:24px;color:#f59e0b;}
.cob-title h2{font-size:22px;font-weight:800;color:#e8eaf0;margin:0;}

/* ── Tabela ── */
.cob-tbl-wrap{background:#1a1d2e;border:1px solid rgba(255,255,255,0.07);border-radius:14px;overflow:hidden;margin-bottom:14px;}
.cob-tbl-wrap table{width:100%;border-collapse:collapse;}
.cob-tbl-wrap thead th{background:#252a3a;color:#9ca3af;font-size:11px;font-weight:700;text-transform:uppercase;letter-spacing:.5px;padding:11px 14px;border-bottom:1px solid rgba(255,255,255,0.07);white-space:nowrap;}
.cob-tbl-wrap tbody tr{border-bottom:1px solid rgba(255,255,255,0.04);transition:background .12s;}
.cob-tbl-wrap tbody tr:hover{background:rgba(245,158,11,0.04);}
.cob-tbl-wrap tbody td{padding:10px 14px;font-size:13px;color:#c9cad6;vertical-align:middle;}

/* ── Badges ── */
.cob-badge{display:inline-flex;align-items:center;gap:4px;padding:3px 10px;border-radius:20px;font-size:11px;font-weight:700;}
.cob-method{background:rgba(99,102,241,0.15);color:#a5b4fc;}
.cob-gw{background:rgba(96,165,250,0.15);color:#60a5fa;font-size:11px;padding:2px 8px;border-radius:5px;font-family:monospace;}

/* ── Status cores ── */
.st-pago{background:rgba(34,197,94,0.15);color:#4ade80;}
.st-pend{background:rgba(245,158,11,0.15);color:#fbbf24;}
.st-cancel{background:rgba(239,68,68,0.15);color:#f87171;}
.st-proc{background:rgba(99,102,241,0.15);color:#a5b4fc;}
.st-exp{background:rgba(156,163,175,0.15);color:#9ca3af;}

/* ── Link referência ── */
.cob-ref-link{display:inline-flex;align-items:center;gap:5px;padding:3px 10px;border-radius:6px;background:rgba(251,191,36,0.1);color:#fbbf24;font-size:12px;font-weight:600;text-decoration:none;border:1px solid rgba(251,191,36,0.2);transition:background .15s;}
.cob-ref-link:hover{background:rgba(251,191,36,0.2);color:#fbbf24;}

/* ── Ações ── */
.cob-acts{display:flex;gap:4px;flex-wrap:wrap;}
.act-btn{width:30px;height:30px;border-radius:7px;display:inline-flex;align-items:center;justify-content:center;font-size:14px;text-decoration:none;transition:all .12s;border:none;cursor:pointer;}
.act-btn:hover{transform:scale(1.1);}
.ab-v  {background:rgba(96,165,250,0.15); color:#60a5fa;} .ab-v:hover  {background:rgba(96,165,250,0.3);}
.ab-e  {background:rgba(34,197,94,0.15);  color:#4ade80;} .ab-e:hover  {background:rgba(34,197,94,0.3);}
.ab-ok {background:rgba(34,197,94,0.15);  color:#4ade80;} .ab-ok:hover {background:rgba(34,197,94,0.3);}
.ab-ref{background:rgba(99,102,241,0.15); color:#a5b4fc;} .ab-ref:hover{background:rgba(99,102,241,0.3);}
.ab-em {background:rgba(245,158,11,0.15); color:#fbbf24;} .ab-em:hover {background:rgba(245,158,11,0.3);}
.ab-bc {background:rgba(6,182,212,0.15);  color:#67e8f9;} .ab-bc:hover {background:rgba(6,182,212,0.3);}
.ab-x  {background:rgba(245,158,11,0.15); color:#fbbf24;} .ab-x:hover  {background:rgba(245,158,11,0.3);}
.ab-d  {background:rgba(239,68,68,0.15);  color:#f87171;} .ab-d:hover  {background:rgba(239,68,68,0.3);}

/* ── Modal dark ── */
.modal-dark .modal-header{background:#1a1d2e;border-bottom:1px solid rgba(255,255,255,0.08);padding:14px 18px;display:flex;align-items:center;justify-content:space-between;}
.modal-dark .modal-header h4{margin:0;font-size:15px;font-weight:800;color:#e8eaf0;display:flex;align-items:center;gap:8px;}
.modal-dark .modal-header .close{color:#9ca3af;font-size:20px;background:none;border:none;cursor:pointer;}
.modal-dark .modal-body{background:#13151f;padding:24px;text-align:center;}
.modal-dark .modal-footer{background:#1a1d2e;border-top:1px solid rgba(255,255,255,0.08);padding:10px 18px;display:flex;justify-content:flex-end;gap:8px;}
.modal-dark .modal-body p{color:#c9cad6;font-size:14px;margin:0;}
.modal-dark .modal-body i.modal-icon{font-size:40px;display:block;margin-bottom:12px;}

/* ── Btn modal ── */
.m-btn{display:inline-flex;align-items:center;gap:6px;padding:8px 18px;border-radius:8px;font-size:13px;font-weight:700;border:none;cursor:pointer;transition:all .15s;}
.m-btn-cancel{background:rgba(255,255,255,0.07);color:#9ca3af;border:1px solid rgba(255,255,255,0.1);}
.m-btn-danger {background:linear-gradient(135deg,#ef4444,#dc2626);color:#fff;box-shadow:0 4px 12px rgba(239,68,68,0.3);}
.m-btn-success{background:linear-gradient(135deg,#22c55e,#16a34a);color:#fff;box-shadow:0 4px 12px rgba(34,197,94,0.3);}
.m-btn-warn   {background:linear-gradient(135deg,#f59e0b,#b45309);color:#fff;}

#tabela_length,.dataTables_length,#tabela_info,.dataTables_info,
#tabela_filter,.dataTables_filter,.dataTables_paginate{display:none!important;}
</style>

<div class="new122">

    <!-- Header -->
    <div class="cob-header">
        <div class="cob-title">
            <i class='bx bx-dollar-circle'></i>
            <h2>Cobranças</h2>
        </div>
    </div>

    <!-- Tabela -->
    <div class="cob-tbl-wrap">
        <table id="tabela" class="table">
            <thead>
                <tr>
                    <th style="width:50px;">#</th>
                    <th>Gateway</th>
                    <th>Método</th>
                    <th style="width:130px;">Vencimento</th>
                    <th>Referência</th>
                    <th style="width:120px;">Status</th>
                    <th style="width:110px;">Valor</th>
                    <th style="width:140px;">Ações</th>
                </tr>
            </thead>
            <tbody>
            <?php if (empty($results)): ?>
                <tr>
                    <td colspan="8" style="text-align:center;padding:40px;color:#6b7280;">
                        <i class='bx bx-dollar-circle' style="font-size:32px;display:block;margin-bottom:8px;"></i>
                        Nenhuma cobrança cadastrada
                    </td>
                </tr>
            <?php else: foreach ($results as $r):
                $dataVenc = date('d/m/Y', strtotime($r->expire_at));
                $cobrancaStatus = getCobrancaTransactionStatus(
                    $this->config->item('payment_gateways'),
                    $r->payment_gateway,
                    $r->status
                );
                // Define classe do status
                $stLower = strtolower($r->status ?? '');
                $stClass = 'st-pend';
                if (in_array($stLower, ['paid','pago','approved'])) $stClass = 'st-pago';
                elseif (in_array($stLower, ['canceled','cancelled','cancelado'])) $stClass = 'st-cancel';
                elseif (in_array($stLower, ['processing','processando'])) $stClass = 'st-proc';
                elseif (in_array($stLower, ['expired','expirado'])) $stClass = 'st-exp';
            ?>
                <tr>
                    <td style="color:#6b7280;font-size:12px;"><?= $r->idCobranca ?></td>
                    <td><span class="cob-gw"><?= htmlspecialchars($r->payment_gateway) ?></span></td>
                    <td>
                        <span class="cob-badge cob-method">
                            <i class='bx bx-credit-card'></i>
                            <?= htmlspecialchars($r->payment_method) ?>
                        </span>
                    </td>
                    <td style="font-size:12px;"><?= $dataVenc ?></td>
                    <td>
                        <?php if (!empty($r->os_id)): ?>
                        <a href="<?= base_url() ?>index.php/os/visualizar/<?= $r->os_id ?>" class="cob-ref-link">
                            <i class='bx bx-file'></i> OS #<?= str_pad($r->os_id, 4, '0', STR_PAD_LEFT) ?>
                        </a>
                        <?php elseif (!empty($r->vendas_id)): ?>
                        <a href="<?= base_url() ?>index.php/vendas/visualizar/<?= $r->vendas_id ?>" class="cob-ref-link">
                            <i class='bx bx-shopping-bag'></i> Venda #<?= str_pad($r->vendas_id, 4, '0', STR_PAD_LEFT) ?>
                        </a>
                        <?php else: ?>
                        <span style="color:#6b7280;">—</span>
                        <?php endif; ?>
                    </td>
                    <td>
                        <span class="cob-badge <?= $stClass ?>">
                            <?= htmlspecialchars($cobrancaStatus) ?>
                        </span>
                    </td>
                    <td style="font-weight:700;color:#fbbf24;">
                        R$ <?= number_format($r->total / 100, 2, ',', '.') ?>
                    </td>
                    <td>
                        <div class="cob-acts">
                            <?php if ($this->permission->checkPermission($this->session->userdata('permissao'), 'vCobranca')): ?>
                            <a href="<?= base_url() ?>index.php/cobrancas/visualizar/<?= $r->idCobranca ?>"
                               class="act-btn ab-v" title="Ver detalhes">
                                <i class='bx bx-show'></i>
                            </a>
                            <a href="<?= base_url() ?>index.php/cobrancas/atualizar/<?= $r->idCobranca ?>"
                               class="act-btn ab-ref" title="Atualizar status">
                                <i class='bx bx-refresh'></i>
                            </a>
                            <a href="#modal-confirmar" data-toggle="modal" role="button"
                               data-confirma="<?= $r->idCobranca ?>" class="act-btn ab-ok confirmar-cob"
                               title="Confirmar pagamento">
                                <i class='bx bx-check'></i>
                            </a>
                            <a href="<?= base_url() ?>index.php/cobrancas/enviarEmail/<?= $r->idCobranca ?>"
                               class="act-btn ab-em" title="Enviar por e-mail">
                                <i class='bx bx-envelope'></i>
                            </a>
                            <a href="#modal-cancelar" data-toggle="modal" role="button"
                               data-cancela="<?= $r->idCobranca ?>" class="act-btn ab-x cancelar-cob"
                               title="Cancelar cobrança">
                                <i class='bx bx-block'></i>
                            </a>
                            <?php endif; ?>
                            <?php if ($this->permission->checkPermission($this->session->userdata('permissao'), 'eCobranca') && !empty($r->barcode)): ?>
                            <a href="<?= $r->link ?>" target="_blank" class="act-btn ab-bc" title="Ver boleto">
                                <i class='bx bx-barcode'></i>
                            </a>
                            <?php endif; ?>
                            <?php if ($this->permission->checkPermission($this->session->userdata('permissao'), 'dCobranca')): ?>
                            <a href="#modal-excluir" data-toggle="modal" role="button"
                               data-excluir="<?= $r->idCobranca ?>" class="act-btn ab-d excluir-cob"
                               title="Excluir cobrança">
                                <i class='bx bx-trash-alt'></i>
                            </a>
                            <?php endif; ?>
                        </div>
                    </td>
                </tr>
            <?php endforeach; endif; ?>
            </tbody>
        </table>
    </div>

    <?= $this->pagination->create_links() ?>

</div>

<!-- ── Modal Excluir ── -->
<div id="modal-excluir" class="modal hide fade modal-dark" tabindex="-1" role="dialog" aria-hidden="true">
    <form action="<?= base_url() ?>index.php/cobrancas/excluir" method="post">
        <input type="hidden" id="excluir_id" name="excluir_id" value="" />
        <div class="modal-header">
            <h4><i class='bx bx-trash' style="color:#f87171;"></i> Excluir Cobrança</h4>
            <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        <div class="modal-body">
            <i class='bx bx-error-circle modal-icon' style="color:#f87171;"></i>
            <p>Deseja realmente excluir esta cobrança?<br>
            <span style="font-size:12px;color:#6b7280;">A cobrança será cancelada e não poderá ser desfeita.</span></p>
        </div>
        <div class="modal-footer">
            <button type="button" class="m-btn m-btn-cancel" data-dismiss="modal">
                <i class='bx bx-x'></i> Cancelar
            </button>
            <button type="submit" class="m-btn m-btn-danger">
                <i class='bx bx-trash'></i> Excluir
            </button>
        </div>
    </form>
</div>

<!-- ── Modal Confirmar Pagamento ── -->
<div id="modal-confirmar" class="modal hide fade modal-dark" tabindex="-1" role="dialog" aria-hidden="true">
    <form action="<?= base_url() ?>index.php/cobrancas/confirmarpagamento" method="post">
        <input type="hidden" id="confirma_id" name="confirma_id" value="" />
        <div class="modal-header">
            <h4><i class='bx bx-check-circle' style="color:#4ade80;"></i> Confirmar Pagamento</h4>
            <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        <div class="modal-body">
            <i class='bx bx-check-circle modal-icon' style="color:#4ade80;"></i>
            <p>Deseja confirmar o pagamento desta cobrança?<br>
            <span style="font-size:12px;color:#6b7280;">O status será atualizado para pago.</span></p>
        </div>
        <div class="modal-footer">
            <button type="button" class="m-btn m-btn-cancel" data-dismiss="modal">
                <i class='bx bx-x'></i> Cancelar
            </button>
            <button type="submit" class="m-btn m-btn-success">
                <i class='bx bx-check'></i> Confirmar Pagamento
            </button>
        </div>
    </form>
</div>

<!-- ── Modal Cancelar Cobrança ── -->
<div id="modal-cancelar" class="modal hide fade modal-dark" tabindex="-1" role="dialog" aria-hidden="true">
    <form action="<?= base_url() ?>index.php/cobrancas/cancelar" method="post">
        <input type="hidden" id="cancela_id" name="cancela_id" value="" />
        <div class="modal-header">
            <h4><i class='bx bx-block' style="color:#fbbf24;"></i> Cancelar Cobrança</h4>
            <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        <div class="modal-body">
            <i class='bx bx-block modal-icon' style="color:#fbbf24;"></i>
            <p>Deseja realmente cancelar esta cobrança?<br>
            <span style="font-size:12px;color:#6b7280;">Esta ação notificará o gateway de pagamento.</span></p>
        </div>
        <div class="modal-footer">
            <button type="button" class="m-btn m-btn-cancel" data-dismiss="modal">
                <i class='bx bx-x'></i> Voltar
            </button>
            <button type="submit" class="m-btn m-btn-warn">
                <i class='bx bx-block'></i> Confirmar Cancelamento
            </button>
        </div>
    </form>
</div>

<script>
$(document).ready(function() {
    $(document).on('click', '.excluir-cob', function() {
        $('#excluir_id').val($(this).data('excluir'));
    });
    $(document).on('click', '.confirmar-cob', function() {
        $('#confirma_id').val($(this).data('confirma'));
    });
    $(document).on('click', '.cancelar-cob', function() {
        $('#cancela_id').val($(this).data('cancela'));
    });
});
</script>
