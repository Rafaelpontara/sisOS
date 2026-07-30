<?php $totalProdutos = 0; ?>

<style>
.vv*,.vv *::before,.vv *::after{box-sizing:border-box;}
.vv{max-width:960px;margin:0 auto;font-family:inherit;}

/* Header */
.vv-header{display:flex;align-items:center;justify-content:space-between;margin-bottom:18px;flex-wrap:wrap;gap:10px;}
.vv-title{font-size:20px;font-weight:800;color:#e8eaf0;display:flex;align-items:center;gap:10px;}
.vv-title i{color:#fbbf24;font-size:22px;}
.vv-badge{padding:4px 12px;border-radius:20px;font-size:12px;font-weight:700;}
.vv-actions{display:flex;gap:7px;flex-wrap:wrap;align-items:center;}

/* Buttons */
.vv-btn{display:inline-flex;align-items:center;gap:6px;padding:8px 15px;border-radius:8px;font-size:12px;font-weight:700;text-decoration:none;border:none;cursor:pointer;transition:all .15s;white-space:nowrap;}
.vv-btn:hover{transform:translateY(-1px);text-decoration:none;}
.vv-btn-success{background:linear-gradient(135deg,#22c55e,#16a34a);color:#fff;}
.vv-btn-primary{background:linear-gradient(135deg,#3b82f6,#2563eb);color:#fff;}
.vv-btn-amber{background:linear-gradient(135deg,#fbbf24,#d97706);color:#111;}
.vv-btn-purple{background:linear-gradient(135deg,#a78bfa,#7c3aed);color:#fff;}
.vv-btn-ghost{background:rgba(255,255,255,0.07);color:#9ca3af;border:1px solid rgba(255,255,255,0.1);}
.vv-btn-danger{background:linear-gradient(135deg,#ef4444,#dc2626);color:#fff;}

/* Dropdown print */
.vv-print-wrap{position:relative;display:inline-block;}
.vv-print-menu{display:none;position:absolute;top:calc(100% + 4px);right:0;background:#1e2133;border:1px solid rgba(255,255,255,0.1);border-radius:10px;z-index:99;min-width:180px;overflow:hidden;box-shadow:0 8px 24px rgba(0,0,0,0.5);}
.vv-print-menu.open{display:block;}
.vv-print-menu a{display:flex;align-items:center;gap:8px;padding:9px 14px;font-size:13px;color:#c9cad6;text-decoration:none;transition:background .12s;}
.vv-print-menu a:hover{background:rgba(255,255,255,0.06);color:#e8eaf0;}

/* Cards */
.vv-card{background:#1a1d2e;border:1px solid rgba(255,255,255,0.07);border-radius:14px;overflow:hidden;margin-bottom:14px;}
.vv-card-head{display:flex;align-items:center;gap:8px;padding:11px 16px;border-bottom:1px solid rgba(255,255,255,0.06);background:#252a3a;}
.vv-card-head i{font-size:15px;}
.vv-card-head span{font-size:11px;font-weight:700;color:#9ca3af;text-transform:uppercase;letter-spacing:.8px;}
.vv-card-body{padding:16px;}

/* Info grid */
.vv-info-grid{display:grid;grid-template-columns:repeat(3,1fr);gap:12px;}
@media(max-width:640px){.vv-info-grid{grid-template-columns:1fr 1fr;}}
.vv-info-item{background:#13151f;border-radius:8px;padding:10px 12px;}
.vv-info-label{font-size:10px;font-weight:700;color:#6b7280;text-transform:uppercase;letter-spacing:.5px;margin-bottom:3px;}
.vv-info-value{font-size:13px;font-weight:600;color:#e8eaf0;}

/* Client / Resp grid */
.vv-parties{display:grid;grid-template-columns:1fr 1fr;gap:14px;}
@media(max-width:580px){.vv-parties{grid-template-columns:1fr;}}
.vv-party{background:#13151f;border-radius:10px;padding:12px 14px;}
.vv-party-title{font-size:10px;font-weight:700;color:#6b7280;text-transform:uppercase;letter-spacing:.6px;margin-bottom:8px;}
.vv-party-name{font-size:15px;font-weight:800;color:#e8eaf0;margin-bottom:4px;}
.vv-party-row{font-size:12px;color:#9ca3af;display:flex;align-items:center;gap:5px;margin-bottom:2px;}
.vv-party-row i{font-size:13px;}

/* Table */
.vv-tbl{width:100%;border-collapse:collapse;font-size:13px;}
.vv-tbl thead th{background:#252a3a;color:#9ca3af;font-size:11px;font-weight:700;text-transform:uppercase;letter-spacing:.4px;padding:10px 12px;border-bottom:1px solid rgba(255,255,255,0.07);}
.vv-tbl tbody tr{border-bottom:1px solid rgba(255,255,255,0.04);transition:background .12s;}
.vv-tbl tbody tr:hover{background:rgba(255,255,255,0.02);}
.vv-tbl tbody td{padding:10px 12px;color:#c9cad6;}
.vv-tbl tfoot td{padding:10px 12px;background:#252a3a;font-weight:700;}

/* Totals */
.vv-totals{display:flex;flex-direction:column;align-items:flex-end;gap:4px;padding:12px 16px;}
.vv-total-row{display:flex;gap:20px;align-items:center;}
.vv-total-label{font-size:12px;color:#9ca3af;min-width:130px;text-align:right;}
.vv-total-val{font-size:14px;font-weight:700;min-width:100px;text-align:right;}
.vv-total-main .vv-total-label{font-size:14px;color:#e8eaf0;}
.vv-total-main .vv-total-val{font-size:20px;color:#fbbf24;}

/* Status badges */
.badge-status{padding:3px 10px;border-radius:20px;font-size:11px;font-weight:700;}
.bs-orcamento{background:rgba(251,191,36,0.15);color:#fbbf24;}
.bs-aberto{background:rgba(59,130,246,0.15);color:#60a5fa;}
.bs-faturado{background:rgba(34,197,94,0.15);color:#4ade80;}
.bs-finalizado{background:rgba(34,197,94,0.15);color:#4ade80;}
.bs-cancelado{background:rgba(239,68,68,0.15);color:#f87171;}
.bs-andamento{background:rgba(167,139,250,0.15);color:#a78bfa;}
.bs-negociacao{background:rgba(251,191,36,0.15);color:#fbbf24;}
.bs-aprovado{background:rgba(34,197,94,0.15);color:#4ade80;}
.bs-aguardando{background:rgba(245,158,11,0.15);color:#fbbf24;}
.bs-default{background:rgba(107,114,128,0.15);color:#9ca3af;}

/* Obs */
.vv-obs{background:#13151f;border-radius:8px;padding:10px 14px;font-size:13px;color:#c9cad6;line-height:1.6;}

/* PIX modal */
.vv-modal{display:none;position:fixed;inset:0;background:rgba(0,0,0,0.7);z-index:1050;align-items:center;justify-content:center;padding:16px;}
.vv-modal.show{display:flex;}
.vv-modal-box{background:#1a1d2e;border:1px solid rgba(255,255,255,0.1);border-radius:16px;width:100%;max-width:400px;overflow:hidden;}
.vv-modal-head{background:#252a3a;border-bottom:1px solid rgba(255,255,255,0.08);padding:14px 18px;display:flex;align-items:center;justify-content:space-between;}
.vv-modal-head h3{margin:0;font-size:15px;font-weight:800;color:#e8eaf0;display:flex;align-items:center;gap:8px;}
.vv-modal-close{background:none;border:none;color:#6b7280;font-size:20px;cursor:pointer;}
.vv-modal-body{padding:20px;text-align:center;}
.vv-modal-foot{padding:12px 18px;background:#252a3a;border-top:1px solid rgba(255,255,255,0.08);display:flex;justify-content:flex-end;gap:8px;}
</style>

<?php
// Compute status badge class
$statusMap = ['Orçamento'=>'bs-orcamento','Aberto'=>'bs-aberto','Faturado'=>'bs-faturado',
    'Finalizado'=>'bs-finalizado','Cancelado'=>'bs-cancelado','Em Andamento'=>'bs-andamento',
    'Negociação'=>'bs-negociacao','Aprovado'=>'bs-aprovado','Aguardando Peças'=>'bs-aguardando'];
$statusClass = $statusMap[$result->status] ?? 'bs-default';
$editavel = $this->vendas_model->isEditable($result->idVendas);
?>

<div class="vv new122">

    <!-- Header -->
    <div class="vv-header">
        <div class="vv-title">
            <i class='bx bx-cart-alt'></i>
            Venda <span style="color:#fbbf24;">#<?= sprintf('%04d', $result->idVendas) ?></span>
            <span class="badge-status <?= $statusClass ?>"><?= $result->status ?></span>
        </div>
        <div class="vv-actions">
            <?php if (($result->faturado != 1 || $editavel) && $this->permission->checkPermission($this->session->userdata('permissao'), 'eVenda')): ?>
            <a href="<?= base_url() ?>index.php/vendas/editar/<?= $result->idVendas ?>" class="vv-btn vv-btn-success">
                <i class='bx bx-edit'></i> Editar
            </a>
            <?php endif; ?>

            <?php if ($this->permission->checkPermission($this->session->userdata('permissao'), 'eVenda') && !in_array($result->status, ['Cancelado'])): ?>
            <button onclick="document.getElementById('modalCancelarVenda').style.display='flex'"
                class="vv-btn vv-btn-danger">
                <i class='bx bx-x-circle'></i> Cancelar Venda
            </button>
            <?php endif; ?>

            <!-- Print dropdown -->
            <div class="vv-print-wrap">
                <button class="vv-btn vv-btn-ghost" onclick="this.nextElementSibling.classList.toggle('open')">
                    <i class='bx bx-printer'></i> Imprimir <i class='bx bx-chevron-down'></i>
                </button>
                <div class="vv-print-menu">
                    <a href="<?= site_url() ?>/vendas/imprimirVendaOrcamento/<?= $result->idVendas ?>" target="_blank">
                        <i class='bx bx-file-blank'></i> Orçamento A4
                    </a>
                    <a href="<?= site_url() ?>/vendas/imprimir/<?= $result->idVendas ?>" target="_blank">
                        <i class='bx bx-file'></i> Papel A4
                    </a>
                    <a href="<?= site_url() ?>/vendas/imprimirTermica/<?= $result->idVendas ?>" target="_blank">
                        <i class='bx bx-receipt'></i> Cupom 80mm
                    </a>
                    <a href="<?= site_url() ?>/vendas/imprimirPromissoria/<?= $result->idVendas ?>" target="_blank">
                        <i class='bx bx-file-blank'></i> Promissória
                    </a>
                </div>
            </div>

            <a href="#" id="btn-forma-pagamento" data-toggle="modal" data-target="#modal-gerar-pagamento" class="vv-btn vv-btn-primary">
                <i class='bx bx-dollar'></i> Gerar Pagamento
            </a>

            <?php if ($qrCode): ?>
            <button class="vv-btn vv-btn-amber" onclick="document.getElementById('modalPix').classList.add('show')">
                <i class='bx bx-qr'></i> PIX
            </button>
            <?php endif; ?>
        </div>
    </div>

    <!-- Alerta emitente -->
    <?php if ($emitente == null): ?>
    <div style="background:rgba(239,68,68,0.1);border:1px solid rgba(239,68,68,0.3);border-radius:10px;padding:12px 16px;margin-bottom:14px;font-size:13px;color:#fca5a5;display:flex;align-items:center;gap:8px;">
        <i class='bx bx-error-circle'></i>
        Configure os dados do emitente. <a href="<?= base_url() ?>index.php/sisos/emitente" style="color:#f87171;text-decoration:underline;margin-left:4px;">Configurar agora</a>
    </div>
    <?php endif; ?>

    <!-- Info da Venda -->
    <div class="vv-card">
        <div class="vv-card-head"><i class='bx bx-info-circle' style="color:#fbbf24;"></i><span>Informações da Venda</span></div>
        <div class="vv-card-body">
            <div class="vv-info-grid" style="margin-bottom:14px;">
                <div class="vv-info-item">
                    <div class="vv-info-label">Data da Venda</div>
                    <div class="vv-info-value"><?= $result->dataVenda ? date('d/m/Y', strtotime($result->dataVenda)) : '—' ?></div>
                </div>
                <div class="vv-info-item">
                    <div class="vv-info-label">Garantia</div>
                    <div class="vv-info-value"><?= $result->garantia ? $result->garantia . ' dia(s)' : '—' ?></div>
                </div>
                <div class="vv-info-item">
                    <div class="vv-info-label">Venc. Garantia</div>
                    <div class="vv-info-value">
                        <?php if ($result->garantia && in_array($result->status, ['Finalizado','Faturado','Orçamento','Aberto','Em Andamento','Aguardando Peças'])): ?>
                            <?= dateInterval($result->dataVenda, $result->garantia) ?>
                        <?php else: ?>—<?php endif; ?>
                    </div>
                </div>
            </div>

            <!-- Observações -->
            <?php if ($result->observacoes): ?>
            <div style="margin-bottom:10px;">
                <div class="vv-info-label" style="margin-bottom:5px;">Observações Internas</div>
                <div class="vv-obs"><?= printSafeHtml($result->observacoes) ?></div>
            </div>
            <?php endif; ?>
            <?php if ($result->observacoes_cliente): ?>
            <div>
                <div class="vv-info-label" style="margin-bottom:5px;">Observações ao Cliente</div>
                <div class="vv-obs"><?= printSafeHtml($result->observacoes_cliente) ?></div>
            </div>
            <?php endif; ?>
        </div>
    </div>

    <!-- Cliente + Responsável -->
    <div class="vv-card">
        <div class="vv-card-head"><i class='bx bx-user' style="color:#60a5fa;"></i><span>Partes Envolvidas</span></div>
        <div class="vv-card-body">
            <div class="vv-parties">
                <div class="vv-party">
                    <div class="vv-party-title">Cliente</div>
                    <div class="vv-party-name"><?= htmlspecialchars($result->nomeCliente) ?></div>
                    <?php if ($result->celular || $result->telefone): ?>
                    <div class="vv-party-row"><i class='bx bx-phone'></i>
                        <?= $result->celular == $result->telefone ? $result->celular : trim($result->telefone . ($result->telefone && $result->celular ? ' / ' : '') . $result->celular) ?>
                    </div>
                    <?php endif; ?>
                    <?php $end = implode(', ', array_filter([$result->rua, $result->numero, $result->bairro])); ?>
                    <?php if ($end): ?>
                    <div class="vv-party-row"><i class='bx bx-map'></i> <?= htmlspecialchars($end) ?><?= $result->cidade ? ', '.$result->cidade.'/'.$result->estado : '' ?></div>
                    <?php endif; ?>
                    <?php if ($result->email): ?>
                    <div class="vv-party-row"><i class='bx bx-envelope'></i> <?= htmlspecialchars($result->email) ?></div>
                    <?php endif; ?>
                </div>
                <div class="vv-party">
                    <div class="vv-party-title">Responsável / Vendedor</div>
                    <div class="vv-party-name"><?= htmlspecialchars($result->nome) ?></div>
                    <?php if ($result->telefone_usuario): ?>
                    <div class="vv-party-row"><i class='bx bx-phone'></i> <?= $result->telefone_usuario ?></div>
                    <?php endif; ?>
                    <?php if ($result->email_usuario): ?>
                    <div class="vv-party-row"><i class='bx bx-envelope'></i> <?= $result->email_usuario ?></div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>

    <!-- Produtos -->
    <?php if ($produtos): ?>
    <div class="vv-card">
        <div class="vv-card-head"><i class='bx bx-package' style="color:#a78bfa;"></i><span>Produtos</span></div>
        <div style="overflow-x:auto;">
            <table class="vv-tbl">
                <thead>
                    <tr>
                        <th>Cód. Barras</th>
                        <th>Produto</th>
                        <th style="text-align:center;">Qtd</th>
                        <th style="text-align:right;">Unit.</th>
                        <th style="text-align:right;">Subtotal</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($produtos as $p):
                        $totalProdutos += $p->subTotal; ?>
                    <tr>
                        <td style="color:#6b7280;font-size:12px;"><?= $p->codDeBarra ?: '—' ?></td>
                        <td style="font-weight:600;color:#e8eaf0;"><?= htmlspecialchars($p->descricao) ?></td>
                        <td style="text-align:center;"><?= $p->quantidade ?></td>
                        <td style="text-align:right;">R$ <?= number_format($p->preco ?: $p->precoVenda, 2, ',', '.') ?></td>
                        <td style="text-align:right;color:#fbbf24;font-weight:700;">R$ <?= number_format($p->subTotal, 2, ',', '.') ?></td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
        <div class="vv-totals">
            <?php if ($result->valor_desconto != 0 && $result->desconto != 0): ?>
            <div class="vv-total-row">
                <div class="vv-total-label">Subtotal</div>
                <div class="vv-total-val" style="color:#9ca3af;">R$ <?= number_format($totalProdutos, 2, ',', '.') ?></div>
            </div>
            <div class="vv-total-row">
                <div class="vv-total-label">Desconto</div>
                <div class="vv-total-val" style="color:#f87171;">- R$ <?= number_format($totalProdutos - $result->valor_desconto, 2, ',', '.') ?></div>
            </div>
            <div class="vv-total-row vv-total-main" style="border-top:1px solid rgba(255,255,255,0.07);padding-top:8px;margin-top:4px;">
                <div class="vv-total-label">Total</div>
                <div class="vv-total-val">R$ <?= number_format($result->valor_desconto, 2, ',', '.') ?></div>
            </div>
            <?php else: ?>
            <div class="vv-total-row vv-total-main">
                <div class="vv-total-label">Total</div>
                <div class="vv-total-val">R$ <?= number_format($totalProdutos, 2, ',', '.') ?></div>
            </div>
            <?php endif; ?>
        </div>
    </div>
    <?php endif; ?>

</div>

<?= $modalGerarPagamento ?>

<!-- Modal PIX -->
<?php if ($qrCode): ?>
<div id="modalPix" class="vv-modal">
    <div class="vv-modal-box">
        <div class="vv-modal-head">
            <h3><i class='bx bx-qr' style="color:#fbbf24;"></i> Pagamento via PIX</h3>
            <button class="vv-modal-close" onclick="document.getElementById('modalPix').classList.remove('show')">×</button>
        </div>
        <div class="vv-modal-body">
            <img src="<?= base_url() ?>assets/img/logo_pix.png" style="height:32px;margin-bottom:10px;"><br>
            <img id="qrCodeImage" src="<?= $qrCode ?>" style="width:60%;border-radius:10px;margin-bottom:10px;">
            <div style="font-size:13px;color:#9ca3af;margin-bottom:4px;">Chave PIX: <b style="color:#e8eaf0;"><?= $chaveFormatada ?></b></div>
            <?php if ($totalProdutos != 0): ?>
            <div style="font-size:16px;font-weight:800;color:#fbbf24;">
                R$ <?= number_format($result->valor_desconto ?: $totalProdutos, 2, ',', '.') ?>
            </div>
            <?php endif; ?>
        </div>
        <div class="vv-modal-foot">
            <?php if (!empty($zapnumber)): ?>
            <button id="pixWhatsApp" class="vv-btn vv-btn-success"><i class='bx bxl-whatsapp'></i> WhatsApp</button>
            <?php endif; ?>
            <button id="copyButton" class="vv-btn vv-btn-primary"><i class='bx bx-copy'></i> Copia e Cola</button>
            <button class="vv-btn vv-btn-ghost" onclick="document.getElementById('modalPix').classList.remove('show')">Fechar</button>
        </div>
    </div>
</div>
<?php endif; ?>

<script src="https://cdn.rawgit.com/cozmo/jsQR/master/dist/jsQR.js"></script>
<script>
// Close print dropdown on outside click
document.addEventListener('click', function(e){
    if (!e.target.closest('.vv-print-wrap')) {
        document.querySelectorAll('.vv-print-menu').forEach(function(m){ m.classList.remove('open'); });
    }
});

<?php if ($qrCode): ?>
function decodeQR(cb) {
    var img = document.getElementById('qrCodeImage');
    var c = document.createElement('canvas');
    c.width = img.naturalWidth || img.width;
    c.height = img.naturalHeight || img.height;
    c.getContext('2d').drawImage(img, 0, 0, c.width, c.height);
    var d = c.getContext('2d').getImageData(0, 0, c.width, c.height);
    var code = jsQR(d.data, d.width, d.height);
    cb(code ? code.data : null);
}

document.getElementById('copyButton').addEventListener('click', function(){
    decodeQR(function(data){
        if (data) {
            navigator.clipboard.writeText(data).then(function(){
                document.getElementById('modalPix').classList.remove('show');
                Swal.fire({icon:'success',title:'Copiado!',text:'Chave PIX copiada com sucesso.',timer:2000,showConfirmButton:false});
            });
        } else {
            Swal.fire({icon:'error',title:'Erro',text:'Não foi possível decodificar o QR Code.'});
        }
    });
});

<?php if (!empty($zapnumber)): ?>
document.getElementById('pixWhatsApp').addEventListener('click', function(){
    decodeQR(function(data){
        if (data) {
            window.open('https://api.whatsapp.com/send?phone=55<?= $zapnumber ?>&text='+encodeURIComponent(data), '_blank');
        }
    });
});
<?php endif; ?>
<?php endif; ?>
</script>

<!-- Modal Cancelar Venda -->
<div id="modalCancelarVenda" style="display:none;position:fixed;inset:0;background:rgba(0,0,0,0.7);z-index:1050;align-items:center;justify-content:center;padding:16px;">
    <div style="background:#1a1d2e;border:1px solid rgba(255,255,255,0.1);border-radius:16px;width:100%;max-width:420px;">
        <div style="background:#252a3a;padding:14px 18px;border-bottom:1px solid rgba(255,255,255,0.07);display:flex;align-items:center;gap:8px;">
            <i class='bx bx-x-circle' style="color:#f87171;font-size:18px;"></i>
            <span style="font-size:15px;font-weight:800;color:#f87171;">Cancelar Venda #<?= sprintf('%04d', $result->idVendas) ?></span>
        </div>
        <form action="<?= base_url() ?>index.php/vendas/cancelar" method="post">
            <input type="hidden" name="id" value="<?= $result->idVendas ?>">
            <div style="padding:18px;">
                <p style="color:#c9cad6;margin-bottom:12px;font-size:13px;">
                    Tem certeza que deseja cancelar esta venda?
                </p>
                <div style="background:rgba(251,191,36,0.08);border:1px solid rgba(251,191,36,0.2);border-radius:8px;padding:10px 12px;font-size:12px;color:#fbbf24;margin-bottom:14px;">
                    <i class='bx bx-info-circle'></i>
                    O estoque dos produtos será <strong>devolvido automaticamente</strong> e o lançamento financeiro vinculado será <strong>excluído</strong>.
                </div>
                <label style="font-size:12px;color:#9ca3af;margin-bottom:4px;display:block;">Motivo (opcional)</label>
                <textarea name="motivo" rows="2" placeholder="Descreva o motivo do cancelamento..."
                    style="width:100%;padding:8px 10px;border-radius:8px;border:1px solid #444860;background:#13151f;color:#e8eaf0;font-size:13px;resize:none;box-sizing:border-box;"></textarea>
            </div>
            <div style="padding:12px 18px;background:#252a3a;border-top:1px solid rgba(255,255,255,0.07);display:flex;justify-content:flex-end;gap:8px;">
                <button type="button" onclick="document.getElementById('modalCancelarVenda').style.display='none'"
                    style="padding:8px 16px;border-radius:8px;background:rgba(255,255,255,0.07);color:#9ca3af;border:1px solid rgba(255,255,255,0.1);cursor:pointer;font-size:13px;">
                    Voltar
                </button>
                <button type="submit"
                    style="padding:8px 18px;border-radius:8px;background:linear-gradient(135deg,#ef4444,#dc2626);color:#fff;border:none;cursor:pointer;font-size:13px;font-weight:700;">
                    <i class='bx bx-x-circle'></i> Confirmar Cancelamento
                </button>
            </div>
        </form>
    </div>
</div>
<script>
document.getElementById('modalCancelarVenda').addEventListener('click', function(e){
    if(e.target===this) this.style.display='none';
});
</script>
