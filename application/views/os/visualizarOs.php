<link href="<?= base_url('assets/css/custom.css'); ?>" rel="stylesheet">
<?php
$totalGeral = $totalProdutos + $totalServico;
$totalFinal = $result->valor_desconto != 0 ? $result->valor_desconto : $totalGeral;
$desconto   = $result->valor_desconto != 0 ? abs($result->valor_desconto - $totalGeral) : 0;

// Status color map
$statusColors = [
    'Aberto'      => ['bg'=>'rgba(59,130,246,0.15)',  'color'=>'#60a5fa',  'icon'=>'bx-folder-open'],
    'Em andamento'=> ['bg'=>'rgba(245,158,11,0.15)', 'color'=>'#fbbf24',  'icon'=>'bx-loader-alt'],
    'Aguardando'  => ['bg'=>'rgba(168,85,247,0.15)', 'color'=>'#c084fc',  'icon'=>'bx-time-five'],
    'Orçamento'   => ['bg'=>'rgba(251,191,36,0.15)', 'color'=>'#fde68a',  'icon'=>'bx-file'],
    'Finalizado'  => ['bg'=>'rgba(34,197,94,0.15)',  'color'=>'#4ade80',  'icon'=>'bx-check-circle'],
    'Faturado'    => ['bg'=>'rgba(34,197,94,0.15)',  'color'=>'#4ade80',  'icon'=>'bx-dollar-circle'],
    'Cancelado'   => ['bg'=>'rgba(239,68,68,0.15)',  'color'=>'#f87171',  'icon'=>'bx-x-circle'],
];
$sc = $statusColors[$result->status] ?? ['bg'=>'rgba(156,163,175,0.15)','color'=>'#9ca3af','icon'=>'bx-circle'];
?>
<style>
/* ── Layout geral ── */
.vos-wrap{max-width:1200px;margin:0 auto;}
.vos-header{display:flex;justify-content:space-between;align-items:flex-start;margin-bottom:18px;flex-wrap:wrap;gap:12px;}
.vos-title{display:flex;align-items:center;gap:10px;}
.vos-title h2{font-size:20px;font-weight:800;color:#e8eaf0;margin:0;}
.vos-title span{font-size:13px;color:#6b7280;}
.vos-num{font-size:26px;font-weight:900;color:#fbbf24;}

/* ── Barra de ações ── */
.vos-actions{display:flex;gap:6px;flex-wrap:wrap;align-items:center;}
.vos-btn{display:inline-flex;align-items:center;gap:5px;padding:7px 13px;border-radius:8px;font-size:12px;font-weight:700;text-decoration:none;border:none;cursor:pointer;transition:all .15s;white-space:nowrap;}
.vos-btn:hover{transform:translateY(-1px);text-decoration:none;}
.vos-btn i{font-size:15px;}
.vb-edit  {background:linear-gradient(135deg,#22c55e,#16a34a);color:#fff;box-shadow:0 3px 10px rgba(34,197,94,0.3);}
.vb-print {background:#252a3a;color:#9ca3af;border:1px solid #444860;}
.vb-print:hover{background:#2d3247;color:#e8eaf0;}
.vb-whats {background:linear-gradient(135deg,#25d366,#128c7e);color:#fff;box-shadow:0 3px 10px rgba(37,211,102,0.3);}
.vb-email {background:linear-gradient(135deg,#f59e0b,#b45309);color:#fff;}
.vb-pay   {background:linear-gradient(135deg,#6366f1,#4f46e5);color:#fff;box-shadow:0 3px 10px rgba(99,102,241,0.3);}
.vb-pix   {background:linear-gradient(135deg,#06b6d4,#0891b2);color:#fff;}
.vb-nfe   {background:linear-gradient(135deg,#22c55e,#15803d);color:#fff;}
.vb-ret   {background:linear-gradient(135deg,#f59e0b,#b45309);color:#fff;}
.vb-ia    {background:linear-gradient(135deg,#8b5cf6,#6d28d9);color:#fff;}
.vb-aprov {background:linear-gradient(135deg,#25d366,#128c7e);color:#fff;}
.vb-drop  {position:relative;display:inline-flex;}
.vb-drop-menu{display:none;position:absolute;top:110%;left:0;z-index:999;background:#1e2133;border:1px solid #444860;border-radius:10px;padding:6px;min-width:180px;flex-direction:column;gap:4px;box-shadow:0 8px 24px rgba(0,0,0,0.4);}
.vb-drop:hover .vb-drop-menu{display:flex;}
.vb-drop-menu a{display:flex;align-items:center;gap:7px;padding:7px 10px;border-radius:7px;color:#c9cad6;font-size:12px;font-weight:600;text-decoration:none;transition:background .12s;}
.vb-drop-menu a:hover{background:rgba(255,255,255,0.07);color:#e8eaf0;}

/* ── Cards de info ── */
.vos-cards{display:flex;gap:12px;margin-bottom:16px;flex-wrap:wrap;}
.vos-card{flex:1;min-width:180px;background:#1a1d2e;border:1px solid rgba(255,255,255,0.07);border-radius:12px;padding:14px 16px;}
.vos-card-label{font-size:10px;font-weight:700;color:#6b7280;text-transform:uppercase;letter-spacing:.8px;margin-bottom:5px;}
.vos-card-val{font-size:15px;font-weight:700;color:#e8eaf0;}
.vos-card-sub{font-size:11px;color:#9ca3af;margin-top:2px;}
.vos-status-badge{display:inline-flex;align-items:center;gap:5px;padding:4px 12px;border-radius:20px;font-size:12px;font-weight:700;}

/* ── Seções ── */
.vos-section{background:#1a1d2e;border:1px solid rgba(255,255,255,0.07);border-radius:14px;margin-bottom:14px;overflow:hidden;}
.vos-section-head{display:flex;align-items:center;gap:8px;padding:12px 16px;border-bottom:1px solid rgba(255,255,255,0.06);background:#252a3a;}
.vos-section-head i{font-size:16px;color:#fbbf24;}
.vos-section-head span{font-size:12px;font-weight:700;color:#9ca3af;text-transform:uppercase;letter-spacing:.8px;}
.vos-section-body{padding:16px;}

/* ── Grid cliente/responsável ── */
.vos-info-grid{display:flex;gap:16px;flex-wrap:wrap;}
.vos-info-col{flex:1;min-width:220px;}
.vos-info-label{font-size:10px;font-weight:700;color:#6b7280;text-transform:uppercase;letter-spacing:.8px;margin-bottom:8px;display:flex;align-items:center;gap:5px;}
.vos-info-name{font-size:15px;font-weight:800;color:#e8eaf0;margin-bottom:6px;}
.vos-info-row{display:flex;align-items:center;gap:6px;font-size:12px;color:#9ca3af;margin-bottom:4px;}
.vos-info-row i{font-size:14px;color:#6b7280;}

/* ── Campos de texto (defeito, laudo, etc) ── */
.vos-field{margin-bottom:12px;}
.vos-field-label{font-size:10px;font-weight:700;color:#6b7280;text-transform:uppercase;letter-spacing:.8px;margin-bottom:6px;display:flex;align-items:center;gap:5px;}
.vos-field-label i{font-size:13px;}
.vos-field-body{background:#13151f;border:1px solid rgba(255,255,255,0.06);border-radius:8px;padding:10px 14px;font-size:13px;color:#c9cad6;line-height:1.6;}

/* ── Tabelas ── */
.vos-table{width:100%;border-collapse:collapse;}
.vos-table thead th{background:#252a3a;color:#9ca3af;font-size:11px;font-weight:700;text-transform:uppercase;letter-spacing:.5px;padding:9px 12px;border-bottom:1px solid rgba(255,255,255,0.07);}
.vos-table tbody tr{border-bottom:1px solid rgba(255,255,255,0.04);transition:background .12s;}
.vos-table tbody tr:hover{background:rgba(255,255,255,0.03);}
.vos-table tbody td{padding:9px 12px;font-size:13px;color:#c9cad6;vertical-align:middle;}
.vos-table tfoot td{padding:9px 12px;font-size:13px;font-weight:700;border-top:1px solid rgba(255,255,255,0.08);}
.vos-total-row td{color:#e8eaf0;background:rgba(251,191,36,0.05);}
.vos-grand-total{font-size:16px;color:#fbbf24!important;}

/* ── Anexos ── */
.vos-anexos-grid{display:flex;gap:10px;flex-wrap:wrap;}
.vos-anexo-item{width:100px;height:100px;border-radius:10px;overflow:hidden;border:2px solid rgba(255,255,255,0.08);cursor:pointer;transition:border-color .15s;}
.vos-anexo-item:hover{border-color:#6366f1;}
.vos-anexo-item img{width:100%;height:100%;object-fit:cover;}

/* ── Alert vinculo ── */
.vos-alert{display:flex;align-items:center;gap:8px;background:rgba(245,158,11,0.1);border:1px solid rgba(245,158,11,0.3);border-radius:8px;padding:10px 14px;font-size:13px;color:#fbbf24;margin-bottom:12px;}
.vos-alert a{color:#fde68a;font-weight:700;}

/* ── Modais dark ── */
.modal-dark .modal-header{background:#1a1d2e;border-bottom:1px solid rgba(255,255,255,0.08);padding:14px 18px;display:flex;align-items:center;justify-content:space-between;}
.modal-dark .modal-header h4{margin:0;font-size:15px;font-weight:800;color:#e8eaf0;display:flex;align-items:center;gap:8px;}
.modal-dark .modal-header .close{color:#9ca3af;font-size:20px;background:none;border:none;cursor:pointer;}
.modal-dark .modal-body{background:#13151f;padding:18px;}
.modal-dark .modal-footer{background:#1a1d2e;border-top:1px solid rgba(255,255,255,0.08);padding:10px 18px;display:flex;justify-content:flex-end;gap:8px;}
</style>

<div class="vos-wrap">

    <!-- ── Header ── -->
    <div class="vos-header">
        <div class="vos-title">
            <div>
                <div style="display:flex;align-items:center;gap:8px;margin-bottom:2px;">
                    <i class='bx bx-file' style="font-size:22px;color:#fbbf24;"></i>
                    <h2>Ordem de Serviço <span class="vos-num">#<?= sprintf('%04d', $result->idOs) ?></span></h2>
                </div>
                <span style="font-size:12px;color:#6b7280;">
                    Aberta em <?= date('d/m/Y', strtotime($result->dataInicial)) ?>
                    <?php if ($result->dataFinal): ?>
                        · Prazo <?= date('d/m/Y', strtotime($result->dataFinal)) ?>
                    <?php endif; ?>
                </span>
            </div>
        </div>

        <!-- Barra de ações -->
        <div class="vos-actions">

            <?php if ($editavel): ?>
            <a href="<?= base_url() ?>index.php/os/editar/<?= $result->idOs ?>" class="vos-btn vb-edit">
                <i class='bx bx-edit'></i> Editar
            </a>
            <?php endif; ?>

            <!-- Dropdown Imprimir -->
            <div class="vb-drop">
                <button class="vos-btn vb-print"><i class='bx bx-printer'></i> Imprimir <i class='bx bx-chevron-down'></i></button>
                <div class="vb-drop-menu">
                    <a href="<?= site_url() ?>/os/imprimir/<?= $result->idOs ?>" target="_blank">
                        <i class='bx bx-file'></i> Papel A4
                    </a>
                    <a href="<?= site_url() ?>/os/imprimirTermica/<?= $result->idOs ?>" target="_blank">
                        <i class='bx bx-receipt'></i> Cupom 80mm
                    </a>
                    <?php if ($result->garantias_id): ?>
                    <a href="<?= site_url() ?>/garantias/imprimirGarantiaOs/<?= $result->idOs ?>" target="_blank">
                        <i class='bx bx-paperclip'></i> Termo de Garantia
                    </a>
                    <?php endif; ?>
                </div>
            </div>

            <?php
            if ($this->permission->checkPermission($this->session->userdata('permissao'), 'vOs')):
                $this->load->model('os_model');
                $zapnumber = preg_replace("/[^0-9]/", "", $result->celular_cliente);
                $troca = [$result->nomeCliente, $result->idOs, $result->status,
                    'R$ ' . ($result->desconto != 0 && $result->valor_desconto != 0
                        ? number_format($result->valor_desconto, 2, ',', '.')
                        : number_format($totalProdutos + $totalServico, 2, ',', '.')),
                    strip_tags($result->descricaoProduto),
                    ($emitente ? $emitente->nome : ''), ($emitente ? $emitente->telefone : ''),
                    strip_tags($result->observacoes), strip_tags($result->defeito),
                    strip_tags($result->laudoTecnico),
                    date('d/m/Y', strtotime($result->dataFinal)),
                    date('d/m/Y', strtotime($result->dataInicial)),
                    $result->garantia . ' dias'];
                $texto_de_notificacao = $this->os_model->criarTextoWhats($texto_de_notificacao, $troca);
                if (!empty($zapnumber)):
            ?>
            <a href="https://api.whatsapp.com/send?phone=55<?= $zapnumber ?>&text=<?= $texto_de_notificacao ?>"
               target="_blank" class="vos-btn vb-whats">
                <i class='bx bxl-whatsapp'></i> WhatsApp
            </a>
            <?php endif; endif; ?>

            <a href="<?= site_url() ?>/os/enviar_email/<?= $result->idOs ?>" class="vos-btn vb-email">
                <i class='bx bx-envelope'></i> E-mail
            </a>

            <a href="#modal-gerar-pagamento" data-toggle="modal" class="vos-btn vb-pay">
                <i class='bx bx-dollar'></i> Pagamento
            </a>

            <?php if (!empty($configuration['nfe_enabled']) && $configuration['nfe_enabled'] == '1'): ?>
            <button class="vos-btn vb-nfe" id="btnEmitirNfeOs" data-id="<?= $result->idOs ?>">
                <i class='bx bx-receipt'></i> NF-e
            </button>
            <?php endif; ?>

            <a href="<?= site_url('os/adicionar') ?>?os_origem=<?= $result->idOs ?>" class="vos-btn vb-ret">
                <i class='bx bx-revision'></i> Retorno
            </a>

            <?php
            $geminiAtivo = $this->db->where('config','gemini_feat_diagnostico')->get('configuracoes')->row();
            $geminiKey   = $this->db->where('config','gemini_api_key')->get('configuracoes')->row();
            if (!empty($geminiAtivo->valor) && !empty($geminiKey->valor)):
            ?>
            <button class="vos-btn vb-ia" id="btnGeminiDiag" data-os="<?= $result->idOs ?>">
                <i class='bx bx-bot'></i> IA
            </button>
            <?php endif; ?>

            <?php if ($qrCode): ?>
            <a href="#modal-pix" data-toggle="modal" class="vos-btn vb-pix">
                <i class='bx bx-qr'></i> PIX
            </a>
            <?php endif; ?>

            <?php if ($result->status == 'Orçamento' && !empty($result->celular_cliente)):
                $approval_url   = site_url('os/aprovar/' . $result->idOs);
                $whats_approval = urlencode('Olá ' . $result->nomeCliente . '! Seu orçamento OS #' . $result->idOs . ' está pronto. Clique para aprovar ou recusar: ' . $approval_url);
            ?>
            <a href="https://wa.me/55<?= preg_replace('/[^0-9]/', '', $result->celular_cliente) ?>?text=<?= $whats_approval ?>"
               target="_blank" class="vos-btn vb-aprov">
                <i class='bx bxl-whatsapp'></i> Enviar Aprovação
            </a>
            <?php endif; ?>

        </div>
    </div>

    <!-- ── Aviso emitente não configurado ── -->
    <?php if ($emitente == null): ?>
    <div class="vos-alert" style="background:rgba(239,68,68,0.1);border-color:rgba(239,68,68,0.3);color:#f87171;margin-bottom:14px;">
        <i class='bx bx-error-circle'></i>
        Emitente não configurado.
        <a href="<?= base_url() ?>index.php/sisos/emitente" style="color:#fca5a5;">Configurar agora →</a>
    </div>
    <?php endif; ?>

    <!-- ── Vínculo com OS de origem ── -->
    <?php if (!empty($result->os_origem_id)): ?>
    <div class="vos-alert">
        <i class='bx bx-link'></i>
        <strong>Retorno em Garantia</strong> — Esta OS está vinculada à
        <a href="<?= site_url('os/visualizar/'.$result->os_origem_id) ?>">
            OS #<?= str_pad($result->os_origem_id,4,'0',STR_PAD_LEFT) ?>
        </a>
    </div>
    <?php endif; ?>

    <!-- ── OSs de retorno ── -->
    <?php
    $retornos = $this->db->where('os_origem_id', $result->idOs)->select('idOs,status,dataInicial')->get('os')->result();
    if ($retornos):
    ?>
    <div class="vos-alert" style="background:rgba(99,102,241,0.1);border-color:rgba(99,102,241,0.3);color:#a5b4fc;">
        <i class='bx bx-revision'></i>
        <strong>OSs de Retorno vinculadas:</strong>
        <?php foreach($retornos as $ret): ?>
        <a href="<?= site_url('os/visualizar/'.$ret->idOs) ?>"
           style="background:rgba(245,158,11,0.2);color:#fbbf24;padding:2px 10px;border-radius:12px;font-size:11px;font-weight:700;text-decoration:none;margin-left:4px;">
            OS #<?= str_pad($ret->idOs,4,'0',STR_PAD_LEFT) ?> — <?= $ret->status ?>
        </a>
        <?php endforeach; ?>
    </div>
    <?php endif; ?>

    <!-- ── Cards de status ── -->
    <div class="vos-cards">
        <div class="vos-card">
            <div class="vos-card-label"><i class='bx bx-info-circle'></i> Status</div>
            <div>
                <span class="vos-status-badge" style="background:<?= $sc['bg'] ?>;color:<?= $sc['color'] ?>;">
                    <i class='bx <?= $sc['icon'] ?>'></i> <?= $result->status ?>
                </span>
            </div>
        </div>
        <div class="vos-card">
            <div class="vos-card-label"><i class='bx bx-calendar'></i> Data Inicial</div>
            <div class="vos-card-val"><?= date('d/m/Y', strtotime($result->dataInicial)) ?></div>
        </div>
        <?php if ($result->dataFinal): ?>
        <div class="vos-card">
            <div class="vos-card-label"><i class='bx bx-calendar-check'></i> Data Final / Prazo</div>
            <div class="vos-card-val"><?= date('d/m/Y', strtotime($result->dataFinal)) ?></div>
        </div>
        <?php endif; ?>
        <?php if (!empty($result->dataEntrega) && $result->dataEntrega != '0000-00-00'): ?>
        <div class="vos-card">
            <div class="vos-card-label"><i class='bx bx-package'></i> Entrega do Aparelho</div>
            <div class="vos-card-val" style="color:#60a5fa;"><?= date('d/m/Y', strtotime($result->dataEntrega)) ?></div>
        </div>
        <?php endif; ?>
        <?php if ($result->garantia): ?>
        <div class="vos-card">
            <div class="vos-card-label"><i class='bx bx-shield-check'></i> Garantia</div>
            <div class="vos-card-val"><?= $result->garantia ?> dia(s)</div>
            <?php if (in_array($result->status, ['Finalizado','Faturado','Orçamento','Aberto'])): ?>
            <div class="vos-card-sub">Vence: <?= dateInterval($result->dataFinal, $result->garantia) ?></div>
            <?php endif; ?>
        </div>
        <?php endif; ?>
        <?php if ($totalGeral > 0): ?>
        <div class="vos-card" style="border-color:rgba(251,191,36,0.3);">
            <div class="vos-card-label"><i class='bx bx-dollar'></i> Total da OS</div>
            <div class="vos-card-val" style="color:#fbbf24;font-size:20px;">
                R$ <?= number_format($totalFinal, 2, ',', '.') ?>
            </div>
            <?php if ($desconto > 0): ?>
            <div class="vos-card-sub" style="color:#f87171;">Desc: R$ <?= number_format($desconto,2,',','.') ?></div>
            <?php endif; ?>
        </div>
        <?php endif; ?>
    </div>

    <!-- ── Cliente + Responsável ── -->
    <div class="vos-section">
        <div class="vos-section-head">
            <i class='bx bx-user'></i>
            <span>Cliente & Responsável</span>
        </div>
        <div class="vos-section-body">
            <div class="vos-info-grid">
                <!-- Cliente -->
                <div class="vos-info-col">
                    <div class="vos-info-label"><i class='bx bxs-business'></i> Cliente</div>
                    <div class="vos-info-name"><?= htmlspecialchars($result->nomeCliente) ?></div>
                    <?php if (!empty($result->contato_cliente) || !empty($result->celular_cliente) || !empty($result->telefone_cliente)): ?>
                    <div class="vos-info-row">
                        <i class='bx bxs-phone'></i>
                        <?= !empty($result->contato_cliente) ? htmlspecialchars($result->contato_cliente) . ' · ' : '' ?>
                        <?php if ($result->celular_cliente == $result->telefone_cliente): ?>
                            <?= htmlspecialchars($result->celular_cliente) ?>
                        <?php else: ?>
                            <?= !empty($result->telefone_cliente) ? htmlspecialchars($result->telefone_cliente) : '' ?>
                            <?= !empty($result->celular_cliente) && !empty($result->telefone_cliente) ? ' / ' : '' ?>
                            <?= !empty($result->celular_cliente) ? htmlspecialchars($result->celular_cliente) : '' ?>
                        <?php endif; ?>
                    </div>
                    <?php endif; ?>
                    <?php if (!empty($result->email)): ?>
                    <div class="vos-info-row"><i class='bx bx-envelope'></i> <?= htmlspecialchars($result->email) ?></div>
                    <?php endif; ?>
                    <?php
                    $endParts = array_filter([$result->rua, $result->numero, $result->complemento, $result->bairro]);
                    $end = implode(', ', $endParts);
                    if ($end || $result->cidade || $result->estado):
                    ?>
                    <div class="vos-info-row">
                        <i class='bx bx-map'></i>
                        <?= htmlspecialchars($end) ?>
                        <?= $end && ($result->cidade || $result->estado) ? ' — ' : '' ?>
                        <?= htmlspecialchars($result->cidade ?? '') ?>
                        <?= !empty($result->estado) ? '/' . $result->estado : '' ?>
                        <?= !empty($result->cep) ? ' · ' . $result->cep : '' ?>
                    </div>
                    <?php endif; ?>
                </div>

                <!-- Responsável -->
                <div class="vos-info-col" style="border-left:1px solid rgba(255,255,255,0.06);padding-left:16px;">
                    <div class="vos-info-label"><i class='bx bx-wrench'></i> Técnico / Responsável</div>
                    <div class="vos-info-name"><?= htmlspecialchars($result->nome) ?></div>
                    <?php if (!empty($result->telefone_usuario)): ?>
                    <div class="vos-info-row"><i class='bx bxs-phone'></i> <?= htmlspecialchars($result->telefone_usuario) ?></div>
                    <?php endif; ?>
                    <?php if (!empty($result->email_usuario)): ?>
                    <div class="vos-info-row"><i class='bx bx-envelope'></i> <?= htmlspecialchars($result->email_usuario) ?></div>
                    <?php endif; ?>
                </div>

                <!-- Equipamento -->
                <?php if (!empty($result->equipamento) || !empty($result->numeroSerie)): ?>
                <div class="vos-info-col" style="border-left:1px solid rgba(255,255,255,0.06);padding-left:16px;">
                    <div class="vos-info-label"><i class='bx bx-devices'></i> Equipamento</div>
                    <?php if (!empty($result->equipamento)): ?>
                    <div class="vos-info-name"><?= htmlspecialchars($result->equipamento) ?></div>
                    <?php endif; ?>
                    <?php if (!empty($result->numeroSerie)): ?>
                    <div class="vos-info-row"><i class='bx bx-barcode'></i> Série: <?= htmlspecialchars($result->numeroSerie) ?></div>
                    <?php endif; ?>
                </div>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <!-- ── Detalhes da OS ── -->
    <?php if ($result->descricaoProduto || $result->defeito || $result->observacoes || $result->laudoTecnico || $result->garantias_id): ?>
    <div class="vos-section">
        <div class="vos-section-head">
            <i class='bx bx-detail'></i>
            <span>Detalhes da OS</span>
        </div>
        <div class="vos-section-body">

            <?php if ($result->descricaoProduto): ?>
            <div class="vos-field">
                <div class="vos-field-label"><i class='bx bx-cube' style="color:#60a5fa;"></i> Descrição do Produto / Equipamento</div>
                <div class="vos-field-body"><?= printSafeHtml($result->descricaoProduto) ?></div>
            </div>
            <?php endif; ?>

            <?php if ($result->defeito): ?>
            <div class="vos-field">
                <div class="vos-field-label"><i class='bx bx-error' style="color:#f87171;"></i> Defeito Apresentado</div>
                <div class="vos-field-body"><?= printSafeHtml($result->defeito) ?></div>
            </div>
            <?php endif; ?>

            <?php if ($result->observacoes): ?>
            <div class="vos-field">
                <div class="vos-field-label"><i class='bx bx-note' style="color:#fbbf24;"></i> Observações</div>
                <div class="vos-field-body"><?= printSafeHtml($result->observacoes) ?></div>
            </div>
            <?php endif; ?>

            <?php if ($result->laudoTecnico): ?>
            <div class="vos-field">
                <div class="vos-field-label"><i class='bx bx-search-alt' style="color:#a78bfa;"></i> Laudo Técnico</div>
                <div class="vos-field-body"><?= printSafeHtml($result->laudoTecnico) ?></div>
            </div>
            <?php endif; ?>

            <?php if ($result->garantias_id): ?>
            <div class="vos-field">
                <div class="vos-field-label"><i class='bx bx-shield' style="color:#4ade80;"></i> Termo de Garantia</div>
                <div class="vos-field-body"><?= printSafeHtml($result->textoGarantia) ?></div>
            </div>
            <?php endif; ?>

        </div>
    </div>
    <?php endif; ?>

    <!-- ── Anotações / Histórico ── -->
    <?php if ($anotacoes): ?>
    <div class="vos-section">
        <div class="vos-section-head">
            <i class='bx bx-history'></i>
            <span>Histórico / Anotações</span>
        </div>
        <div class="vos-section-body" style="padding:0;">
            <table class="vos-table">
                <thead>
                    <tr>
                        <th>Anotação</th>
                        <th style="width:150px;">Data / Hora</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($anotacoes as $a): ?>
                    <tr>
                        <td><?= htmlspecialchars($a->anotacao) ?></td>
                        <td style="color:#6b7280;font-size:12px;"><?= date('d/m/Y H:i', strtotime($a->data_hora)) ?></td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
    <?php endif; ?>

    <!-- ── Anexos ── -->
    <?php if ($anexos): ?>
    <div class="vos-section">
        <div class="vos-section-head">
            <i class='bx bx-paperclip'></i>
            <span>Anexos</span>
        </div>
        <div class="vos-section-body">
            <div class="vos-anexos-grid">
                <?php foreach ($anexos as $a):
                    $thumb = ($a->thumb == null) ? base_url() . 'assets/img/icon-file.png' : $a->url . '/thumbs/' . $a->thumb;
                    $link  = ($a->thumb == null) ? base_url() . 'assets/img/icon-file.png' : $a->url . '/' . $a->anexo;
                ?>
                <a href="#modal-anexo" imagem="<?= $a->idAnexos ?>" link="<?= $link ?>"
                   role="button" class="vos-anexo-item anexo" data-toggle="modal">
                    <img src="<?= $thumb ?>" alt="Anexo">
                </a>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
    <?php endif; ?>

    <!-- ── Produtos ── -->
    <?php if ($produtos): ?>
    <div class="vos-section">
        <div class="vos-section-head">
            <i class='bx bx-cube' style="color:#a78bfa;"></i>
            <span>Produtos Utilizados</span>
        </div>
        <div class="vos-section-body" style="padding:0;">
            <table class="vos-table">
                <thead>
                    <tr>
                        <th>Produto</th>
                        <th style="width:80px;">Qtd</th>
                        <th style="width:120px;">Unit.</th>
                        <th style="width:130px;">Subtotal</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($produtos as $p): ?>
                    <tr>
                        <td><?= htmlspecialchars($p->descricao) ?></td>
                        <td><?= $p->quantidade ?></td>
                        <td>R$ <?= number_format($p->preco ?: $p->precoVenda, 2, ',', '.') ?></td>
                        <td>R$ <?= number_format($p->subTotal, 2, ',', '.') ?></td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
                <tfoot>
                    <tr class="vos-total-row">
                        <td colspan="3" style="text-align:right;color:#9ca3af;">Total Produtos:</td>
                        <td>R$ <?= number_format($totalProdutos, 2, ',', '.') ?></td>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
    <?php endif; ?>

    <!-- ── Serviços ── -->
    <?php if ($servicos): ?>
    <div class="vos-section">
        <div class="vos-section-head">
            <i class='bx bx-wrench' style="color:#4ade80;"></i>
            <span>Serviços Realizados</span>
        </div>
        <div class="vos-section-body" style="padding:0;">
            <table class="vos-table">
                <thead>
                    <tr>
                        <th>Serviço</th>
                        <th style="width:80px;">Qtd</th>
                        <th style="width:120px;">Unit.</th>
                        <th style="width:130px;">Subtotal</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($servicos as $s):
                        $preco    = $s->preco ?: $s->precoVenda;
                        $qtd      = $s->quantidade ?: 1;
                        $subtotal = $preco * $qtd;
                    ?>
                    <tr>
                        <td><?= htmlspecialchars($s->nome) ?></td>
                        <td><?= $qtd ?></td>
                        <td>R$ <?= number_format($preco, 2, ',', '.') ?></td>
                        <td>R$ <?= number_format($subtotal, 2, ',', '.') ?></td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
                <tfoot>
                    <tr class="vos-total-row">
                        <td colspan="3" style="text-align:right;color:#9ca3af;">Total Serviços:</td>
                        <td>R$ <?= number_format($totalServico, 2, ',', '.') ?></td>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
    <?php endif; ?>

    <!-- ── Totais Finais ── -->
    <?php if ($totalGeral > 0): ?>
    <div class="vos-section" style="border-color:rgba(251,191,36,0.2);">
        <div class="vos-section-body" style="padding:0;">
            <table class="vos-table">
                <tfoot>
                    <?php if ($produtos && $servicos): ?>
                    <tr>
                        <td style="text-align:right;color:#9ca3af;">Subtotal (Prod + Serv):</td>
                        <td style="width:160px;">R$ <?= number_format($totalGeral, 2, ',', '.') ?></td>
                    </tr>
                    <?php endif; ?>
                    <?php if ($desconto > 0): ?>
                    <tr>
                        <td style="text-align:right;color:#f87171;">Desconto:</td>
                        <td style="color:#f87171;">- R$ <?= number_format($desconto, 2, ',', '.') ?></td>
                    </tr>
                    <?php endif; ?>
                    <tr class="vos-total-row">
                        <td style="text-align:right;font-size:15px;font-weight:800;">TOTAL FINAL:</td>
                        <td class="vos-grand-total">R$ <?= number_format($totalFinal, 2, ',', '.') ?></td>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
    <?php endif; ?>

</div><!-- /.vos-wrap -->

<?= $modalGerarPagamento ?>

<!-- ── Modal Visualizar Anexo ── -->
<div id="modal-anexo" class="modal hide fade modal-dark" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-header">
        <h4><i class='bx bx-image'></i> Visualizar Anexo</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
    </div>
    <div class="modal-body" style="text-align:center;">
        <div id="div-visualizar-anexo">
            <div class='progress progress-info progress-striped active'><div class='bar' style='width:100%'></div></div>
        </div>
    </div>
    <div class="modal-footer">
        <a href="" id="download" class="vos-btn vb-print"><i class='bx bx-download'></i> Download</a>
        <a href="" link="" id="excluir-anexo" class="vos-btn" style="background:rgba(239,68,68,0.15);color:#f87171;border:1px solid rgba(239,68,68,0.3);">
            <i class='bx bx-trash'></i> Excluir
        </a>
        <button class="vos-btn vb-print" data-dismiss="modal">Fechar</button>
    </div>
</div>

<!-- ── Modal PIX ── -->
<div id="modal-pix" class="modal hide fade modal-dark" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-header">
        <h4><i class='bx bx-qr' style="color:#06b6d4;"></i> Pagamento via PIX</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
    </div>
    <div class="modal-body" style="text-align:center;padding:24px;">
        <img src="<?= base_url() ?>assets/img/logo_pix.png" alt="PIX" style="height:40px;margin-bottom:12px;"><br>
        <img id="qrCodeImage" src="<?= $qrCode ?>" alt="QR Code" style="width:200px;border-radius:12px;border:3px solid rgba(6,182,212,0.4);margin-bottom:12px;"><br>
        <div style="background:#1e2133;border:1px solid #444860;border-radius:8px;padding:10px;margin-bottom:10px;font-size:13px;color:#e8eaf0;">
            <strong>Chave PIX:</strong> <?= $chaveFormatada ?>
        </div>
        <?php if ($totalGeral > 0): ?>
        <div style="font-size:18px;font-weight:800;color:#fbbf24;">
            R$ <?= number_format($totalFinal, 2, ',', '.') ?>
        </div>
        <?php endif; ?>
    </div>
    <div class="modal-footer">
        <?php if (!empty($zapnumber)): ?>
        <button id="pixWhatsApp" class="vos-btn vb-whats"><i class='bx bxl-whatsapp'></i> WhatsApp</button>
        <?php endif; ?>
        <button id="copyButton" class="vos-btn vb-pix"><i class='bx bx-copy'></i> Copia e Cola</button>
        <button class="vos-btn vb-print" data-dismiss="modal">Fechar</button>
    </div>
</div>

<!-- ── Modal IA Diagnóstico ── -->
<div id="modalGeminiDiag" class="modal hide fade modal-dark" tabindex="-1" role="dialog">
    <div class="modal-header">
        <h4><i class='bx bx-bot' style="color:#a78bfa;"></i> Sugestão de Diagnóstico — IA</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
    </div>
    <div class="modal-body">
        <div id="geminiDiagLoading" style="text-align:center;padding:30px;">
            <i class='bx bx-loader-alt bx-spin' style="font-size:36px;color:#8b5cf6;"></i><br>
            <span style="color:#9ca3af;font-size:13px;margin-top:10px;display:block;">Analisando a OS com IA...</span>
        </div>
        <div id="geminiDiagResult" style="display:none;white-space:pre-wrap;line-height:1.7;font-size:13px;color:#c9cad6;background:#1e2133;border-radius:10px;padding:16px;"></div>
    </div>
    <div class="modal-footer">
        <button class="vos-btn vb-print" data-dismiss="modal">Fechar</button>
    </div>
</div>

<script src="https://cdn.rawgit.com/cozmo/jsQR/master/dist/jsQR.js"></script>
<script>
$(document).ready(function() {

    // Anexos
    $(document).on('click', '.anexo', function(e) {
        e.preventDefault();
        var link = $(this).attr('link');
        var id   = $(this).attr('imagem');
        var url  = '<?= base_url() ?>index.php/os/excluirAnexo/';
        $('#div-visualizar-anexo').html('<img src="' + link + '" style="max-width:100%;border-radius:8px;">');
        $('#excluir-anexo').attr('link', url + id);
        $('#download').attr('href', '<?= base_url() ?>index.php/os/downloadanexo/' + id);
    });

    $(document).on('click', '#excluir-anexo', function(e) {
        e.preventDefault();
        var link = $(this).attr('link');
        var idOS = '<?= $result->idOs ?>';
        $('#modal-anexo').modal('hide');
        $.ajax({
            type: 'POST', url: link, dataType: 'json', data: 'idOs=' + idOS,
            success: function(data) {
                if (data.result == true) {
                    location.reload();
                } else {
                    swal({ type:'error', title:'Atenção', text: data.mensagem });
                }
            }
        });
    });

    // PIX — Copia e cola
    $('#copyButton').on('click', function() {
        var $img = $('#qrCodeImage');
        var canvas = document.createElement('canvas');
        canvas.width = $img.width(); canvas.height = $img.height();
        canvas.getContext('2d').drawImage($img[0], 0, 0, $img.width(), $img.height());
        var imgData = canvas.getContext('2d').getImageData(0, 0, canvas.width, canvas.height);
        var code = jsQR(imgData.data, imgData.width, imgData.height);
        if (code) {
            navigator.clipboard.writeText(code.data).then(function() {
                $('#modal-pix').modal('hide');
                swal({ type:'success', title:'Copiado!', text: code.data, timer:3000, showConfirmButton:false });
            });
        } else {
            swal({ type:'error', title:'Atenção', text:'Não foi possível decodificar o QR Code.' });
        }
    });

    // PIX — WhatsApp
    $('#pixWhatsApp').on('click', function() {
        var $img = $('#qrCodeImage');
        var canvas = document.createElement('canvas');
        canvas.width = $img.width(); canvas.height = $img.height();
        canvas.getContext('2d').drawImage($img[0], 0, 0, $img.width(), $img.height());
        var imgData = canvas.getContext('2d').getImageData(0, 0, canvas.width, canvas.height);
        var code = jsQR(imgData.data, imgData.width, imgData.height);
        if (code) {
            window.open('https://api.whatsapp.com/send?phone=55<?= isset($zapnumber) ? $zapnumber : "" ?>&text=' + code.data, '_blank');
        } else {
            swal({ type:'error', title:'Atenção', text:'Não foi possível decodificar o QR Code.' });
        }
    });

    // IA Gemini
    $(document).on('click','#btnGeminiDiag', function(){
        var osId = $(this).data('os');
        $('#geminiDiagLoading').show();
        $('#geminiDiagResult').hide().text('');
        $('#modalGeminiDiag').modal('show');
        $.post('<?= site_url('sisos/sugestaoGemini') ?>', {
            os_id: osId,
            '<?= $this->security->get_csrf_token_name() ?>': '<?= $this->security->get_csrf_hash() ?>'
        }, function(res){
            $('#geminiDiagLoading').hide();
            if (res.ok) {
                $('#geminiDiagResult').text(res.resposta).show();
            } else {
                $('#geminiDiagResult').html('<div style="color:#f87171;">' + res.erro + '</div>').show();
            }
        }, 'json');
    });

});
</script>
