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
    'Faturado'    => ['bg'=>'rgba(6,182,212,0.15)',   'color'=>'#22d3ee',  'icon'=>'bx-dollar-circle'],
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
.vb-drop-menu{display:none;position:absolute;top:100%;left:0;z-index:999;background:#1e2133;border:1px solid #444860;border-radius:10px;padding:6px;min-width:180px;flex-direction:column;gap:4px;box-shadow:0 8px 24px rgba(0,0,0,0.4);margin-top:4px;}
/* Ponte invisível entre botão e menu para não perder o hover */
.vb-drop-menu::before{content:'';position:absolute;top:-8px;left:0;right:0;height:8px;}
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

            <?php if ($this->permission->checkPermission($this->session->userdata('permissao'), 'eOs') && !in_array($result->status, ['Cancelado','Recusado'])): ?>
            <button onclick="document.getElementById('modalCancelarOs').style.display='flex'"
                class="vos-btn" style="background:rgba(239,68,68,0.12);color:#f87171;border:1px solid rgba(239,68,68,0.2);cursor:pointer;">
                <i class='bx bx-x-circle'></i> Cancelar OS
            </button>
            <?php endif; ?>

            <!-- Dropdown Imprimir -->
            <div class="vb-drop">
                <button class="vos-btn vb-print"><i class='bx bx-printer'></i> Imprimir <i class='bx bx-chevron-down'></i></button>
                <div class="vb-drop-menu">
                    <a href="<?= site_url() ?>/os/imprimir/<?= $result->idOs ?>" target="_blank">
                        <i class='bx bx-file'></i> Papel A4
                    </a>
                    <?php if (!empty($result->checklist)): ?>
                    <a href="<?= site_url() ?>/os/imprimir/<?= $result->idOs ?>?checklist=1" target="_blank" style="color:#4ade80;">
                        <i class='bx bx-list-check'></i> A4 + Checklist
                    </a>
                    <?php endif; ?>
                    <a href="<?= site_url() ?>/os/imprimirTermica/<?= $result->idOs ?>" target="_blank">
                        <i class='bx bx-receipt'></i> Cupom 80mm
                    </a>
                    <?php if (!empty($result->checklist)): ?>
                    <a href="<?= site_url() ?>/os/imprimirTermica/<?= $result->idOs ?>?checklist=1" target="_blank" style="color:#4ade80;">
                        <i class='bx bx-list-check'></i> Cupom + Checklist
                    </a>
                    <?php endif; ?>
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

            <?php if (in_array($result->status, ['Finalizado','Faturado']) && $result->garantia): ?>
            <a href="<?= site_url('os/garantiaDigital/' . $result->idOs) ?>" target="_blank"
               class="vos-btn" style="background:rgba(34,197,94,0.15);color:#4ade80;border:1px solid rgba(34,197,94,0.3);">
                <i class='bx bx-shield-check'></i> Garantia Digital
            </a>
            <?php endif; ?>

            <?php if (!empty($result->tracking_token)): ?>
            <a href="#modal-acompanhamento" data-toggle="modal"
               class="vos-btn" style="background:rgba(167,139,250,0.15);color:#a78bfa;border:1px solid rgba(167,139,250,0.3);">
                <i class='bx bx-link'></i> Link de Acompanhamento
            </a>
            <?php endif; ?>
            <a href="<?= site_url('os/etiqueta/' . $result->idOs) ?>" target="_blank"
               class="vos-btn" style="background:rgba(96,165,250,0.15);color:#60a5fa;border:1px solid rgba(96,165,250,0.3);">
                <i class='bx bx-qr'></i> Etiqueta QR
            </a>
            <a href="#modal-assinatura" data-toggle="modal"
               class="vos-btn" style="background:rgba(34,197,94,0.15);color:#4ade80;border:1px solid rgba(34,197,94,0.3);">
                <i class='bx bx-pen'></i> <?= !empty($result->assinatura_entrega) ? 'Ver Assinatura' : 'Assinatura na Entrega' ?>
            </a>
            <?php if (in_array($result->status, ['Finalizado', 'Faturado'])): ?>
            <a href="#modal-pesquisa" data-toggle="modal" onclick="sisosAbrirPesquisa(<?= $result->idOs ?>)"
               class="vos-btn" style="background:rgba(251,191,36,0.15);color:#fbbf24;border:1px solid rgba(251,191,36,0.3);">
                <i class='bx bx-happy-heart-eyes'></i> Pesquisa de Satisfação
            </a>
            <?php endif; ?>
            <a href="<?= site_url('os/adicionar') ?>?os_origem=<?= $result->idOs ?>" class="vos-btn vb-ret">
                <i class='bx bx-revision'></i> Retorno
            </a>

            <?php
            // Verificar se algum provedor de IA está ativo
            $iaProvedor = $this->db->where('config','ia_provedor')->get('configuracoes')->row();
            $provedorAtivo = $iaProvedor->valor ?? 'gemini';
            $keyMap = [
                'gemini'=>'gemini_api_key','openai'=>'openai_api_key',
                'claude'=>'claude_api_key','deepseek'=>'deepseek_api_key',
                'mistral'=>'mistral_api_key','perplexity'=>'perplexity_api_key',
            ];
            $keyConfig = $keyMap[$provedorAtivo] ?? 'gemini_api_key';
            $iaKey = $this->db->where('config',$keyConfig)->get('configuracoes')->row();
            // Mostrar botão se tiver chave OU se gemini_enabled estiver ativo
            $geminiEnabled = $this->db->where('config','gemini_enabled')->get('configuracoes')->row();
            $iaDisponivel  = (!empty($iaKey->valor)) || (!empty($geminiEnabled->valor) && $geminiEnabled->valor == '1');
            if ($iaDisponivel):
            ?>
            <button class="vos-btn vb-ia" id="btnGeminiDiag" data-os="<?= $result->idOs ?>"
                    title="Diagnóstico por IA — <?= htmlspecialchars(strtoupper($provedorAtivo)) ?>">
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
            <div class="vos-card-label"><i class='bx bx-package'></i> Entregue ao Cliente</div>
            <div>
                <?php if (!empty($result->entregue)): ?>
                <span class="vos-status-badge" style="background:rgba(34,197,94,0.15);color:#4ade80;">
                    <i class='bx bx-check-circle'></i> Sim
                </span>
                <?php else: ?>
                <span class="vos-status-badge" style="background:rgba(156,163,175,0.15);color:#9ca3af;">
                    <i class='bx bx-circle'></i> Não
                </span>
                <?php endif; ?>
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

                <!-- Técnico -->
                <div class="vos-info-col" style="border-left:1px solid rgba(255,255,255,0.06);padding-left:16px;">
                    <div class="vos-info-label"><i class='bx bx-wrench'></i> Técnico Responsável</div>
                    <div class="vos-info-name"><?= htmlspecialchars($result->nome) ?></div>
                    <?php if (!empty($result->telefone_usuario)): ?>
                    <div class="vos-info-row"><i class='bx bxs-phone'></i> <?= htmlspecialchars($result->telefone_usuario) ?></div>
                    <?php endif; ?>
                    <?php if (!empty($result->email_usuario)): ?>
                    <div class="vos-info-row"><i class='bx bx-envelope'></i> <?= htmlspecialchars($result->email_usuario) ?></div>
                    <?php endif; ?>
                </div>

                <!-- Atendente -->
                <?php if (!empty($result->atendente_id)): ?>
                <div class="vos-info-col" style="border-left:1px solid rgba(255,255,255,0.06);padding-left:16px;">
                    <div class="vos-info-label"><i class='bx bx-headphone'></i> Atendente / Vendedor</div>
                    <?php
                        $atendente = $this->usuarios_model->getById($result->atendente_id);
                    ?>
                    <div class="vos-info-name"><?= htmlspecialchars($atendente->nome ?? '—') ?></div>
                </div>
                <?php endif; ?>

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


    <!-- ── Senha do Celular ── -->
    <?php if (!empty($result->senha_tipo)): ?>
    <div class="vos-section" style="border-color:rgba(167,139,250,0.2);">
        <div class="vos-section-head" style="background:rgba(167,139,250,0.07);">
            <i class='bx bx-lock-alt' style="color:#a78bfa;"></i>
            <span style="color:#a78bfa;">Senha do Celular</span>
            <?php
            $tipoLabels = [
                'pin'    => 'PIN / Código',
                'padrao' => 'Padrão Android',
            ];
            $tipoLabel = $tipoLabels[$result->senha_tipo] ?? $result->senha_tipo;
            ?>
            <span style="margin-left:auto;background:rgba(167,139,250,0.12);color:#a78bfa;
                         font-size:10px;font-weight:700;padding:2px 10px;border-radius:10px;
                         border:1px solid rgba(167,139,250,0.25);">
                <?= htmlspecialchars($tipoLabel) ?>
            </span>
        </div>
        <div class="vos-section-body">
            <div style="display:flex;align-items:center;gap:20px;flex-wrap:wrap;">
                <div>
                    <div class="vos-field-label"><i class='bx bx-category'></i> Tipo</div>
                    <div class="vos-field-body" style="padding:8px 14px;">
                        <?= htmlspecialchars($tipoLabel) ?>
                    </div>
                </div>
                <?php if (!empty($result->senha_valor)): ?>
                <div>
                    <div class="vos-field-label"><i class='bx bx-key'></i> Código / Sequência</div>
                    <div class="vos-field-body" style="padding:8px 14px;font-family:monospace;
                                font-size:18px;font-weight:800;color:#a78bfa;letter-spacing:3px;">
                        <?= htmlspecialchars($result->senha_valor) ?>
                    </div>
                </div>
                <?php endif; ?>
            </div>
            <?php if ($result->senha_tipo === 'padrao' && !empty($result->senha_valor)): ?>
            <!-- Visualização gráfica do padrão -->
            <div style="margin-top:14px;">
                <div class="vos-field-label"><i class='bx bx-grid-alt'></i> Visualização do Padrão</div>
                <?php
                $seq = array_map('intval', explode('-', $result->senha_valor));
                ?>
                <div style="display:flex;flex-wrap:wrap;gap:6px;max-width:130px;margin-top:6px;">
                    <?php for($pi=1; $pi<=9; $pi++):
                        $pos = array_search($pi, $seq);
                        $ativo = $pos !== false;
                    ?>
                    <div style="width:34px;height:34px;border-radius:50%;
                                background:<?= $ativo ? 'rgba(167,139,250,0.2)' : '#252a3a' ?>;
                                border:1.5px solid <?= $ativo ? '#a78bfa' : '#444860' ?>;
                                display:flex;align-items:center;justify-content:center;
                                font-size:12px;font-weight:700;
                                color:<?= $ativo ? '#a78bfa' : '#6b7280' ?>;">
                        <?= $ativo ? ($pos + 1) : '' ?>
                    </div>
                    <?php endfor; ?>
                </div>
                <div style="font-size:11px;color:#6b7280;margin-top:6px;">
                    Números indicam a ordem de entrada dos pontos.
                </div>
            </div>
            <?php endif; ?>
        </div>
    </div>
    <?php endif; ?>


    <!-- ── Checklist de Entrada ── -->
    <?php
    $_ck      = null;
    $_ck_v    = 1;
    $_ck_fotos = [];
    if (!empty($result->checklist)) {
        $_ck   = json_decode($result->checklist, true);
        $_ck_v = $_ck['v'] ?? 1;
    }
    if (!empty($result->checklist_fotos)) {
        $_ck_fotos = json_decode($result->checklist_fotos, true) ?: [];
    }
    ?>
    <?php if (!empty($_ck)): ?>
    <div class="vos-section" style="border-color:rgba(99,102,241,0.2);">
        <div class="vos-section-head" style="background:rgba(99,102,241,0.07);">
            <i class='bx bx-list-check' style="color:#818cf8;"></i>
            <span style="color:#818cf8;">Checklist de Entrada</span>
            <?php
            // Contar estados
            $_ckOk = $_ckDef = $_ckNvf = 0;
            if ($_ck_v == 2 && is_array($_ck['itens'] ?? null)) {
                foreach ($_ck['itens'] as $v) {
                    if ($v==='ok') $_ckOk++;
                    elseif ($v==='defeito') $_ckDef++;
                    else $_ckNvf++;
                }
            } elseif (is_array($_ck['itens'] ?? null)) {
                $_ckOk = count($_ck['itens']);
            }
            ?>
            <div style="margin-left:auto;display:flex;gap:8px;">
                <?php if ($_ckOk > 0): ?>
                <span style="background:rgba(74,222,128,0.12);color:#4ade80;font-size:10px;font-weight:700;padding:2px 8px;border-radius:10px;border:1px solid rgba(74,222,128,0.25);">
                    ✓ <?= $_ckOk ?> OK
                </span>
                <?php endif; ?>
                <?php if ($_ckDef > 0): ?>
                <span style="background:rgba(248,113,113,0.12);color:#f87171;font-size:10px;font-weight:700;padding:2px 8px;border-radius:10px;border:1px solid rgba(248,113,113,0.25);">
                    ⚠ <?= $_ckDef ?> Defeito
                </span>
                <?php endif; ?>
            </div>
        </div>
        <div class="vos-section-body">

            <?php if ($_ck_v == 2 && is_array($_ck['itens'] ?? null)): ?>
            <!-- Formato novo v2: com estados ok/defeito/nvf -->
            <div style="display:grid;grid-template-columns:repeat(auto-fill,minmax(240px,1fr));gap:6px;margin-bottom:14px;">
                <?php foreach ($_ck['itens'] as $_ckItem => $_ckEstado): ?>
                <?php
                    $cor = $_ckEstado==='ok'      ? '#4ade80'
                         : ($_ckEstado==='defeito' ? '#f87171' : '#6b7280');
                    $bg  = $_ckEstado==='ok'      ? 'rgba(74,222,128,0.08)'
                         : ($_ckEstado==='defeito' ? 'rgba(248,113,113,0.08)' : 'rgba(107,114,128,0.05)');
                    $icone = $_ckEstado==='ok'     ? 'bx-check-circle'
                           : ($_ckEstado==='defeito'? 'bx-error-circle' : 'bx-minus-circle');
                    $label = $_ckEstado==='ok'     ? 'OK'
                           : ($_ckEstado==='defeito'? 'Defeito/Detalhe' : 'Não verificado');
                ?>
                <div style="display:flex;align-items:center;justify-content:space-between;
                            background:<?= $bg ?>;border:1px solid <?= $cor ?>33;
                            border-radius:8px;padding:8px 10px;gap:8px;">
                    <span style="font-size:12px;color:#c9cad6;flex:1;"><?= htmlspecialchars($_ckItem) ?></span>
                    <span style="display:flex;align-items:center;gap:4px;font-size:10px;font-weight:700;color:<?= $cor ?>;white-space:nowrap;">
                        <i class='bx <?= $icone ?>'></i> <?= $label ?>
                    </span>
                </div>
                <?php endforeach; ?>
            </div>

            <?php else: ?>
            <!-- Formato legado v1: lista de itens marcados -->
            <div style="display:flex;flex-wrap:wrap;gap:6px 20px;margin-bottom:12px;">
                <?php foreach (($_ck['itens'] ?? []) as $_ckItem): ?>
                <div style="display:flex;align-items:center;gap:6px;font-size:13px;color:#c9cad6;">
                    <i class='bx bx-check-circle' style="color:#4ade80;font-size:15px;"></i>
                    <?= htmlspecialchars($_ckItem) ?>
                </div>
                <?php endforeach; ?>
            </div>
            <?php endif; ?>

            <?php if (!empty($_ck['obs'])): ?>
            <div style="background:#13151f;border:1px solid rgba(255,255,255,0.06);border-radius:8px;padding:10px 14px;margin-bottom:12px;">
                <div style="font-size:10px;font-weight:700;color:#6b7280;text-transform:uppercase;letter-spacing:.5px;margin-bottom:5px;">
                    <i class='bx bx-note'></i> Observações
                </div>
                <div style="font-size:13px;color:#9ca3af;line-height:1.5;white-space:pre-wrap;"><?= htmlspecialchars($_ck['obs']) ?></div>
            </div>
            <?php endif; ?>

            <?php if (!empty($_ck_fotos)): ?>
            <div>
                <div style="font-size:10px;font-weight:700;color:#6b7280;text-transform:uppercase;letter-spacing:.5px;margin-bottom:8px;">
                    <i class='bx bx-camera'></i> Fotos de Entrada (<?= count($_ck_fotos) ?>)
                </div>
                <div style="display:flex;flex-wrap:wrap;gap:8px;">
                    <?php foreach ($_ck_fotos as $_foto): ?>
                    <a href="<?= htmlspecialchars($_foto) ?>" target="_blank"
                       style="width:80px;height:80px;border-radius:8px;overflow:hidden;display:block;
                              border:2px solid rgba(255,255,255,0.08);transition:border-color .15s;"
                       onmouseover="this.style.borderColor='#818cf8'"
                       onmouseout="this.style.borderColor='rgba(255,255,255,0.08)'">
                        <img src="<?= htmlspecialchars($_foto) ?>" style="width:100%;height:100%;object-fit:cover;">
                    </a>
                    <?php endforeach; ?>
                </div>
            </div>
            <?php endif; ?>

        </div>
    </div>
    <?php endif; ?>


    <!-- ── Checklist de Saída ── -->
    <?php
    $_ckSaida = null;
    if (!empty($result->checklist_saida)) {
        $_ckSaida = json_decode($result->checklist_saida, true);
    }
    ?>
    <?php if (!empty($_ckSaida['itens'])): ?>
    <?php
    $_ckSOk = $_ckSDef = $_ckSNvf = 0;
    foreach ($_ckSaida['itens'] as $v) {
        if ($v==='ok') $_ckSOk++;
        elseif ($v==='defeito') $_ckSDef++;
        else $_ckSNvf++;
    }
    ?>
    <div class="vos-section" style="border-color:rgba(34,211,238,0.2);">
        <div class="vos-section-head" style="background:rgba(34,211,238,0.07);">
            <i class='bx bx-list-ul' style="color:#22d3ee;"></i>
            <span style="color:#22d3ee;">Checklist de Saída</span>
            <div style="margin-left:auto;display:flex;gap:8px;">
                <?php if ($_ckSOk > 0): ?>
                <span style="background:rgba(74,222,128,0.12);color:#4ade80;font-size:10px;font-weight:700;padding:2px 8px;border-radius:10px;border:1px solid rgba(74,222,128,0.25);">
                    ✓ <?= $_ckSOk ?> OK
                </span>
                <?php endif; ?>
                <?php if ($_ckSDef > 0): ?>
                <span style="background:rgba(248,113,113,0.12);color:#f87171;font-size:10px;font-weight:700;padding:2px 8px;border-radius:10px;border:1px solid rgba(248,113,113,0.25);">
                    ⚠ <?= $_ckSDef ?> Defeito
                </span>
                <?php endif; ?>
            </div>
        </div>
        <div class="vos-section-body">
            <div style="display:grid;grid-template-columns:repeat(auto-fill,minmax(240px,1fr));gap:6px;margin-bottom:12px;">
                <?php foreach ($_ckSaida['itens'] as $_ckSItem => $_ckSEst):
                    $sc = $_ckSEst==='ok'      ? '#4ade80'
                        : ($_ckSEst==='defeito' ? '#f87171' : '#6b7280');
                    $sb = $_ckSEst==='ok'      ? 'rgba(74,222,128,0.08)'
                        : ($_ckSEst==='defeito' ? 'rgba(248,113,113,0.08)' : 'rgba(107,114,128,0.05)');
                    $si = $_ckSEst==='ok'      ? 'bx-check-circle'
                        : ($_ckSEst==='defeito' ? 'bx-error-circle' : 'bx-minus-circle');
                    $sl = $_ckSEst==='ok'      ? 'OK'
                        : ($_ckSEst==='defeito' ? 'Defeito' : 'N/V');
                ?>
                <div style="display:flex;align-items:center;justify-content:space-between;
                            background:<?= $sb ?>;border:1px solid <?= $sc ?>33;
                            border-radius:8px;padding:8px 10px;gap:8px;">
                    <span style="font-size:12px;color:#c9cad6;flex:1;"><?= htmlspecialchars($_ckSItem) ?></span>
                    <span style="display:flex;align-items:center;gap:4px;font-size:10px;font-weight:700;color:<?= $sc ?>;white-space:nowrap;">
                        <i class='bx <?= $si ?>'></i> <?= $sl ?>
                    </span>
                </div>
                <?php endforeach; ?>
            </div>
            <?php if (!empty($_ckSaida['obs'])): ?>
            <div style="background:#13151f;border:1px solid rgba(255,255,255,0.06);border-radius:8px;padding:10px 14px;">
                <div style="font-size:10px;font-weight:700;color:#6b7280;text-transform:uppercase;letter-spacing:.5px;margin-bottom:5px;">
                    <i class='bx bx-note'></i> Observações da Entrega
                </div>
                <div style="font-size:13px;color:#9ca3af;line-height:1.5;white-space:pre-wrap;"><?= htmlspecialchars($_ckSaida['obs']) ?></div>
            </div>
            <?php endif; ?>
        </div>
    </div>
    <?php endif; ?>

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

<?php if (!empty($result->tracking_token)):
    $linkAcompanhamento = site_url('mine/acompanhar/' . $result->tracking_token);
    $msgWhats = 'Olá ' . ($result->nomeCliente ?? '') . '! Você pode acompanhar o status da sua OS #' . str_pad($result->idOs, 4, '0', STR_PAD_LEFT) . ' em tempo real por este link: ' . $linkAcompanhamento;
?>
<!-- ── Modal Link de Acompanhamento ── -->
<div id="modal-acompanhamento" class="modal hide fade modal-dark modal-acomp" tabindex="-1">
    <div class="modal-header" style="background:linear-gradient(135deg,#1a1d2e,#20172f);border-bottom:1px solid rgba(167,139,250,0.25);">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4>
            <span class="acomp-icon-badge"><i class='bx bx-link'></i></span>
            Link de Acompanhamento
        </h4>
    </div>
    <div class="modal-body" style="padding:22px;">
        <p style="color:#9ca3af;font-size:12.5px;line-height:1.6;margin-bottom:16px;">
            Envie este link pro cliente acompanhar o status da OS em tempo real, sem precisar de login.
        </p>
        <div class="acomp-link-box">
            <i class='bx bx-globe'></i>
            <input type="text" id="linkAcompInput" readonly value="<?= htmlspecialchars($linkAcompanhamento) ?>">
            <button type="button" id="btnCopiarAcomp" onclick="sisosCopiarLinkAcomp()">
                <i class='bx bx-copy'></i> <span>Copiar</span>
            </button>
        </div>
    </div>
    <div class="modal-footer" style="display:flex;justify-content:center;gap:10px;border-top:1px solid rgba(255,255,255,0.08);">
        <button type="button" class="vos-btn" style="background:#252a3a;color:#9ca3af;border:1px solid #444860;" data-dismiss="modal">
            <i class='bx bx-x'></i> Fechar
        </button>
        <a href="https://api.whatsapp.com/send?phone=55<?= preg_replace('/\D/', '', $result->celular ?? $result->telefone ?? '') ?>&text=<?= urlencode($msgWhats) ?>"
           target="_blank" class="vos-btn vb-whats">
            <i class='bx bxl-whatsapp'></i> Enviar no WhatsApp
        </a>
    </div>
</div>
<style>
.acomp-icon-badge{width:32px;height:32px;border-radius:9px;background:rgba(167,139,250,0.15);display:inline-flex;align-items:center;justify-content:center;flex-shrink:0;}
.acomp-icon-badge i{font-size:17px;color:#a78bfa;}
.acomp-link-box{display:flex;align-items:center;gap:8px;background:#13151f;border:1px solid rgba(255,255,255,0.08);border-radius:10px;padding:6px 6px 6px 14px;transition:border-color .15s;}
.acomp-link-box:focus-within{border-color:#a78bfa;}
.acomp-link-box i.bx-globe{font-size:16px;color:#6b7280;flex-shrink:0;}
.acomp-link-box input{flex:1;min-width:0;background:transparent;border:none;outline:none;color:#e8eaf0;font-size:12.5px;padding:8px 0;}
.acomp-link-box button{display:flex;align-items:center;gap:6px;background:linear-gradient(135deg,#8b5cf6,#6d28d9);color:#fff;border:none;border-radius:8px;padding:8px 14px;font-size:12px;font-weight:700;cursor:pointer;transition:all .15s;white-space:nowrap;}
.acomp-link-box button:hover{transform:translateY(-1px);box-shadow:0 4px 12px rgba(139,92,246,0.35);}
.acomp-link-box button.copiado{background:linear-gradient(135deg,#22c55e,#16a34a);}
</style>
<script>
function sisosCopiarLinkAcomp() {
    var el = document.getElementById('linkAcompInput');
    el.select();
    el.setSelectionRange(0, 99999);
    var btn = document.getElementById('btnCopiarAcomp');
    var original = btn.innerHTML;
    function feedback() {
        btn.classList.add('copiado');
        btn.innerHTML = "<i class='bx bx-check'></i> <span>Copiado!</span>";
        setTimeout(function () { btn.classList.remove('copiado'); btn.innerHTML = original; }, 1800);
    }
    navigator.clipboard.writeText(el.value).then(feedback).catch(function () {
        document.execCommand('copy');
        feedback();
    });
}
</script>
<?php endif; ?>

<!-- ── Modal Assinatura Digital na Entrega ── -->
<div id="modal-assinatura" class="modal hide fade modal-dark modal-assin" tabindex="-1">
    <div class="modal-header" style="background:linear-gradient(135deg,#1a1d2e,#132a1f);border-bottom:1px solid rgba(74,222,128,0.25);">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4>
            <span class="assin-icon-badge"><i class='bx bx-pen'></i></span>
            Assinatura na Entrega
        </h4>
    </div>
    <div class="modal-body" style="padding:22px;">
        <?php if (!empty($result->assinatura_entrega)): ?>
        <div id="assinaturaSalva">
            <div class="assin-status-row">
                <span class="assin-status-badge"><i class='bx bx-check-circle'></i> Assinatura Registrada</span>
                <span class="assin-status-date"><i class='bx bx-calendar'></i> <?= date('d/m/Y \à\s H:i', strtotime($result->assinatura_data)) ?></span>
            </div>
            <div class="assin-preview-card">
                <img src="<?= $result->assinatura_entrega ?>" alt="Assinatura do cliente">
            </div>
            <button type="button" class="vos-btn" style="background:rgba(74,222,128,0.12);color:#4ade80;border:1px solid rgba(74,222,128,0.3);margin-top:14px;" onclick="sisosRefazerAssinatura()">
                <i class='bx bx-refresh'></i> Colher Nova Assinatura
            </button>
        </div>
        <div id="assinaturaCapturaWrap" style="display:none;">
        <?php else: ?>
        <div id="assinaturaCapturaWrap">
        <?php endif; ?>
            <p style="color:#9ca3af;font-size:12.5px;line-height:1.6;margin-bottom:14px;">
                Peça pro cliente assinar abaixo, usando o dedo ou o mouse, confirmando o recebimento do aparelho.
            </p>
            <div class="assin-canvas-wrap">
                <canvas id="assinaturaCanvas" width="460" height="200"></canvas>
            </div>
            <div style="display:flex;gap:8px;margin-top:14px;">
                <button type="button" class="vos-btn" style="background:#252a3a;color:#9ca3af;border:1px solid #444860;" onclick="sisosLimparAssinatura()">
                    <i class='bx bx-eraser'></i> Limpar
                </button>
                <button type="button" class="vos-btn" style="flex:1;justify-content:center;background:linear-gradient(135deg,#22c55e,#16a34a);color:#fff;box-shadow:0 3px 10px rgba(34,197,94,0.3);" onclick="sisosSalvarAssinatura(<?= $result->idOs ?>)">
                    <i class='bx bx-save'></i> Salvar Assinatura
                </button>
            </div>
        </div>
    </div>
    <div class="modal-footer" style="display:flex;justify-content:center;border-top:1px solid rgba(255,255,255,0.08);">
        <button type="button" class="vos-btn" style="background:#252a3a;color:#9ca3af;border:1px solid #444860;" data-dismiss="modal">
            <i class='bx bx-x'></i> Fechar
        </button>
    </div>
</div>
<style>
.assin-icon-badge{width:32px;height:32px;border-radius:9px;background:rgba(74,222,128,0.15);display:inline-flex;align-items:center;justify-content:center;flex-shrink:0;}
.assin-icon-badge i{font-size:17px;color:#4ade80;}
.assin-status-row{display:flex;align-items:center;justify-content:space-between;flex-wrap:wrap;gap:8px;margin-bottom:14px;}
.assin-status-badge{display:inline-flex;align-items:center;gap:6px;background:rgba(74,222,128,0.12);color:#4ade80;border:1px solid rgba(74,222,128,0.3);font-size:12px;font-weight:700;padding:5px 12px;border-radius:20px;}
.assin-status-date{display:inline-flex;align-items:center;gap:6px;color:#6b7280;font-size:11.5px;}
.assin-preview-card{background:#fff;border-radius:10px;padding:12px;text-align:center;border:1px solid rgba(255,255,255,0.08);}
.assin-preview-card img{max-width:100%;max-height:180px;}
.assin-canvas-wrap{background:#0d0f18;border:1.5px dashed rgba(74,222,128,0.35);border-radius:12px;padding:10px;}
.assin-canvas-wrap canvas{background:#fff;border-radius:8px;width:100%;touch-action:none;cursor:crosshair;display:block;}
</style>
<script>
(function() {
    var canvas = document.getElementById('assinaturaCanvas');
    if (!canvas) return;
    var ctx = canvas.getContext('2d');
    ctx.strokeStyle = '#111';
    ctx.lineWidth = 2.2;
    ctx.lineCap = 'round';
    var desenhando = false;
    var vazio = true;

    function pos(e) {
        var rect = canvas.getBoundingClientRect();
        var escalaX = canvas.width / rect.width;
        var escalaY = canvas.height / rect.height;
        var t = e.touches ? e.touches[0] : e;
        return { x: (t.clientX - rect.left) * escalaX, y: (t.clientY - rect.top) * escalaY };
    }

    function iniciar(e) {
        desenhando = true;
        vazio = false;
        var p = pos(e);
        ctx.beginPath();
        ctx.moveTo(p.x, p.y);
        e.preventDefault();
    }
    function mover(e) {
        if (!desenhando) return;
        var p = pos(e);
        ctx.lineTo(p.x, p.y);
        ctx.stroke();
        e.preventDefault();
    }
    function soltar() { desenhando = false; }

    canvas.addEventListener('mousedown', iniciar);
    canvas.addEventListener('mousemove', mover);
    canvas.addEventListener('mouseup', soltar);
    canvas.addEventListener('mouseleave', soltar);
    canvas.addEventListener('touchstart', iniciar, { passive: false });
    canvas.addEventListener('touchmove', mover, { passive: false });
    canvas.addEventListener('touchend', soltar);

    window.sisosLimparAssinatura = function() {
        ctx.clearRect(0, 0, canvas.width, canvas.height);
        vazio = true;
    };

    window.sisosRefazerAssinatura = function() {
        document.getElementById('assinaturaSalva').style.display = 'none';
        document.getElementById('assinaturaCapturaWrap').style.display = 'block';
    };

    window.sisosSalvarAssinatura = function(idOs) {
        if (vazio) { alert('Peça pro cliente assinar antes de salvar.'); return; }
        var dataUrl = canvas.toDataURL('image/png');

        $.post('<?= site_url("os/salvarAssinatura") ?>', {
            id: idOs,
            assinatura: dataUrl,
            '<?= $this->security->get_csrf_token_name() ?>': '<?= $this->security->get_csrf_hash() ?>'
        }, function(res) {
            if (res.sucesso) {
                if (typeof swal === 'function') swal('Salvo!', 'Assinatura registrada com sucesso.', 'success');
                setTimeout(function() { location.reload(); }, 900);
            } else {
                alert('Erro ao salvar: ' + (res.erro || 'tente novamente.'));
            }
        }, 'json');
    };
})();
</script>

<!-- ── Modal Pesquisa de Satisfação ── -->
<div id="modal-pesquisa" class="modal hide fade modal-dark modal-acomp" tabindex="-1">
    <div class="modal-header" style="background:linear-gradient(135deg,#1a1d2e,#2e2410);border-bottom:1px solid rgba(251,191,36,0.25);">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4>
            <span class="pesq-icon-badge"><i class='bx bx-happy-heart-eyes'></i></span>
            Pesquisa de Satisfação
        </h4>
    </div>
    <div class="modal-body" style="padding:22px;">
        <p style="color:#9ca3af;font-size:12.5px;line-height:1.6;margin-bottom:16px;">
            Envie este link pro cliente avaliar o atendimento, o serviço e o ambiente da loja — sem precisar de login.
        </p>
        <div id="pesquisaLoading" style="text-align:center;padding:20px 0;color:#6b7280;font-size:13px;">
            <i class='bx bx-loader-alt bx-spin'></i> Gerando link...
        </div>
        <div id="pesquisaLinkBox" class="acomp-link-box" style="display:none;">
            <i class='bx bx-globe'></i>
            <input type="text" id="linkPesquisaInput" readonly value="">
            <button type="button" id="btnCopiarPesquisa" onclick="sisosCopiarLinkPesquisa()">
                <i class='bx bx-copy'></i> <span>Copiar</span>
            </button>
        </div>
        <div id="pesquisaErro" style="display:none;color:#f87171;font-size:12.5px;margin-top:8px;"></div>
    </div>
    <div class="modal-footer" style="display:flex;justify-content:center;gap:10px;border-top:1px solid rgba(255,255,255,0.08);">
        <button type="button" class="vos-btn" style="background:#252a3a;color:#9ca3af;border:1px solid #444860;" data-dismiss="modal">
            <i class='bx bx-x'></i> Fechar
        </button>
        <a href="#" id="btnWhatsPesquisa" target="_blank" class="vos-btn vb-whats" style="display:none;">
            <i class='bx bxl-whatsapp'></i> Enviar no WhatsApp
        </a>
    </div>
</div>
<style>
.pesq-icon-badge{width:32px;height:32px;border-radius:9px;background:rgba(251,191,36,0.15);display:inline-flex;align-items:center;justify-content:center;flex-shrink:0;}
.pesq-icon-badge i{font-size:17px;color:#fbbf24;}
</style>
<script>
// Lê o cookie do token CSRF na hora do clique — o CI regenera esse token a
// cada envio (csrf_regenerate=true), então reabrir o modal depois do 1º
// sucesso quebraria se a gente reusasse só o valor embutido no carregamento
// da página. Cai pro valor embutido apenas se o cookie ainda não existir.
function sisosLerCookieCsrf() {
    var m = document.cookie.match('(^|;)\\s*<?= $this->config->item('csrf_cookie_name') ?>\\s*=\\s*([^;]+)');
    return m ? decodeURIComponent(m.pop()) : '<?= $this->security->get_csrf_hash() ?>';
}

function sisosAbrirPesquisa(osId) {
    document.getElementById('pesquisaLoading').style.display = 'block';
    document.getElementById('pesquisaLinkBox').style.display = 'none';
    document.getElementById('pesquisaErro').style.display = 'none';
    document.getElementById('btnWhatsPesquisa').style.display = 'none';

    fetch('<?= site_url("pesquisa/gerarLink") ?>', {
        method: 'POST',
        headers: {'Content-Type': 'application/x-www-form-urlencoded'},
        body: 'os_id=' + osId
            + '&<?= $this->security->get_csrf_token_name() ?>=' + encodeURIComponent(sisosLerCookieCsrf())
    })
    .then(function(res) { return res.json(); })
    .then(function(data) {
        document.getElementById('pesquisaLoading').style.display = 'none';
        if (data.sucesso) {
            document.getElementById('linkPesquisaInput').value = data.link;
            document.getElementById('pesquisaLinkBox').style.display = 'flex';
            var msg = encodeURIComponent('Olá! Poderia avaliar nosso atendimento? É rapidinho: ' + data.link);
            var btnW = document.getElementById('btnWhatsPesquisa');
            btnW.href = 'https://api.whatsapp.com/send?phone=55<?= preg_replace('/\D/', '', $result->celular_cliente ?? '') ?>&text=' + msg;
            btnW.style.display = 'inline-flex';
        } else {
            document.getElementById('pesquisaErro').textContent = data.erro || 'Não foi possível gerar o link.';
            document.getElementById('pesquisaErro').style.display = 'block';
        }
    })
    .catch(function() {
        document.getElementById('pesquisaLoading').style.display = 'none';
        document.getElementById('pesquisaErro').textContent = 'Erro de conexão. Tente novamente.';
        document.getElementById('pesquisaErro').style.display = 'block';
    });
}

function sisosCopiarLinkPesquisa() {
    var el = document.getElementById('linkPesquisaInput');
    el.select();
    el.setSelectionRange(0, 99999);
    var btn = document.getElementById('btnCopiarPesquisa');
    var original = btn.innerHTML;
    function feedback() {
        btn.classList.add('copiado');
        btn.innerHTML = "<i class='bx bx-check'></i> <span>Copiado!</span>";
        setTimeout(function () { btn.classList.remove('copiado'); btn.innerHTML = original; }, 1800);
    }
    navigator.clipboard.writeText(el.value).then(feedback).catch(function () {
        document.execCommand('copy');
        feedback();
    });
}
</script>

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

<!-- Modal Cancelar OS -->
<div id="modalCancelarOs" style="display:none;position:fixed;inset:0;background:rgba(0,0,0,0.7);z-index:1050;align-items:center;justify-content:center;padding:16px;">
    <div style="background:#1a1d2e;border:1px solid rgba(255,255,255,0.1);border-radius:16px;width:100%;max-width:420px;overflow:hidden;">
        <div style="background:#252a3a;padding:16px 20px;border-bottom:1px solid rgba(255,255,255,0.07);display:flex;align-items:center;gap:10px;">
            <i class='bx bx-x-circle' style="color:#f87171;font-size:20px;"></i>
            <h4 style="margin:0;font-size:16px;font-weight:800;color:#f87171;">Cancelar OS</h4>
        </div>
        <form action="<?= base_url() ?>index.php/os/cancelar" method="post">
            <input type="hidden" name="id" id="cancelarOsId" value="<?= $result->idOs ?>">
            <div style="padding:20px;">
                <p style="color:#c9cad6;margin-bottom:14px;font-size:14px;">
                    Tem certeza que deseja cancelar esta OS?<br>
                    <small style="color:#fbbf24;"><i class='bx bx-info-circle'></i> O estoque será devolvido e o lançamento financeiro excluído.</small>
                </p>
                <label style="font-size:12px;color:#9ca3af;margin-bottom:4px;display:block;">Motivo do cancelamento (opcional)</label>
                <textarea name="motivo" rows="2" placeholder="Descreva o motivo..."
                    style="width:100%;padding:8px 10px;border-radius:8px;border:1px solid #444860;background:#13151f;color:#e8eaf0;font-size:13px;resize:none;"></textarea>
            </div>
            <div style="padding:12px 20px;background:#252a3a;border-top:1px solid rgba(255,255,255,0.07);display:flex;justify-content:flex-end;gap:8px;">
                <button type="button" onclick="document.getElementById('modalCancelarOs').style.display='none'"
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
function confirmarCancelarOs(id, status) {
    document.getElementById('cancelarOsId').value = id;
    document.getElementById('modalCancelarOs').style.display = 'flex';
}
document.getElementById('modalCancelarOs').addEventListener('click', function(e) {
    if (e.target === this) this.style.display = 'none';
});
</script>

<!-- Modal Cancelar OS -->
<div id="modalCancelarOs" style="display:none;position:fixed;inset:0;background:rgba(0,0,0,0.7);z-index:1050;align-items:center;justify-content:center;padding:16px;">
    <div style="background:#1a1d2e;border:1px solid rgba(255,255,255,0.1);border-radius:16px;width:100%;max-width:420px;">
        <div style="background:#252a3a;padding:14px 18px;border-bottom:1px solid rgba(255,255,255,0.07);display:flex;align-items:center;gap:8px;">
            <i class='bx bx-x-circle' style="color:#f87171;font-size:18px;"></i>
            <span style="font-size:15px;font-weight:800;color:#f87171;">Cancelar OS #<?= $result->idOs ?></span>
        </div>
        <form action="<?= base_url() ?>index.php/os/cancelar" method="post">
            <input type="hidden" name="id" value="<?= $result->idOs ?>">
            <div style="padding:18px;">
                <p style="color:#c9cad6;margin-bottom:12px;font-size:13px;">
                    Tem certeza que deseja cancelar esta OS?
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
                <button type="button" onclick="document.getElementById('modalCancelarOs').style.display='none'"
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
document.getElementById('modalCancelarOs').addEventListener('click', function(e){
    if(e.target===this) this.style.display='none';
});
</script>

<!-- ════ Modal Promissória ════════════════════════════════════════ -->
<div id="modalPromissoria" class="sisos-modal-overlay" style="display:none;"
     onclick="if(event.target===this)sisosFecharPromissoria()">
    <div class="sisos-prom-box">
        <div class="sisos-prom-head">
            <div style="display:flex;align-items:center;gap:8px;">
                <span style="font-size:15px;">📝</span>
                <div>
                    <div style="font-size:14px;font-weight:800;color:#e8eaf0;">Promissória</div>
                    <div style="font-size:11px;color:#6b7280;">OS #<?= $result->idOs ?> — <?= htmlspecialchars($result->nomeCliente) ?></div>
                </div>
            </div>
            <button onclick="sisosFecharPromissoria()" class="sisos-modal-close"><i class='bx bx-x'></i></button>
        </div>
        <div style="padding:16px;overflow-y:auto;max-height:calc(90vh - 120px);">
            <div style="background:rgba(251,191,36,0.07);border:1px solid rgba(251,191,36,0.2);border-radius:8px;
                        padding:10px 14px;margin-bottom:14px;font-size:12px;color:#fbbf24;display:flex;align-items:center;gap:6px;">
                <i class='bx bx-info-circle'></i> Dados pré-preenchidos da OS. Revise antes de imprimir.
            </div>
            <div style="display:grid;grid-template-columns:1fr 1fr;gap:12px;">
                <div style="grid-column:1/-1;"><div class="prom-lbl-sec">EMITENTE — QUEM DEVE</div></div>
                <div><label class="prom-lbl">Nome *</label><input id="pm_em_nome" class="prom-inp" value="<?= htmlspecialchars($result->nomeCliente) ?>"></div>
                <div><label class="prom-lbl">CPF / CNPJ</label><input id="pm_em_doc" class="prom-inp" value="<?= htmlspecialchars($result->cpf ?? $result->cnpj ?? '') ?>"></div>
                <div><label class="prom-lbl">Endereço</label><input id="pm_em_end" class="prom-inp" value="<?= htmlspecialchars(implode(', ', array_filter([$result->rua??'', $result->numero??'', $result->bairro??'']))) ?>"></div>
                <div><label class="prom-lbl">Cidade / Estado</label><input id="pm_em_cidade" class="prom-inp" value="<?= htmlspecialchars(trim(($result->cidade??'').(!empty($result->estado)?' / '.$result->estado:''))) ?>"></div>

                <div style="grid-column:1/-1;margin-top:4px;"><div class="prom-lbl-sec">BENEFICIÁRIO — QUEM RECEBE</div></div>
                <div><label class="prom-lbl">Nome *</label><input id="pm_bf_nome" class="prom-inp" value="<?= htmlspecialchars($emitente->nome ?? '') ?>"></div>
                <div><label class="prom-lbl">CPF / CNPJ</label><input id="pm_bf_doc" class="prom-inp" value="<?= htmlspecialchars($emitente->cnpj ?? '') ?>"></div>

                <div style="grid-column:1/-1;margin-top:4px;"><div class="prom-lbl-sec">VALOR & VENCIMENTO</div></div>
                <div><label class="prom-lbl">Valor R$ *</label><input id="pm_valor" class="prom-inp" placeholder="0,00" value="<?= $totalFinal>0 ? number_format($totalFinal,2,',','.') : '' ?>"></div>
                <div><label class="prom-lbl">Vencimento *</label><input id="pm_venc" class="prom-inp datepicker" value="<?= (!empty($result->dataFinal)&&$result->dataFinal!='0000-00-00') ? date('d/m/Y',strtotime($result->dataFinal)) : date('d/m/Y',strtotime('+30 days')) ?>"></div>
                <div style="grid-column:1/-1;"><label class="prom-lbl">Valor por Extenso *</label><input id="pm_extenso" class="prom-inp" placeholder="Ex: Dois mil reais"></div>
                <div><label class="prom-lbl">Nº da Promissória</label><input id="pm_numero" class="prom-inp" value="<?= str_pad($result->idOs,3,'0',STR_PAD_LEFT).'/'.date('Y') ?>"></div>
                <div><label class="prom-lbl">Juros (% a.m.)</label><input id="pm_juros" class="prom-inp" value="2%"></div>

                <div style="grid-column:1/-1;margin-top:4px;"><div class="prom-lbl-sec">DETALHES</div></div>
                <div><label class="prom-lbl">Local</label><input id="pm_local" class="prom-inp" value="<?= htmlspecialchars(($emitente->cidade??'').(!empty($emitente->estado??$emitente->uf??'')?' — '.($emitente->estado??$emitente->uf):'')) ?>"></div>
                <div><label class="prom-lbl">Data de Emissão</label><input id="pm_emissao" class="prom-inp datepicker" value="<?= date('d/m/Y') ?>"></div>
                <div style="grid-column:1/-1;"><label class="prom-lbl">Referência</label><input id="pm_obs" class="prom-inp" value="Referente à OS #<?= str_pad($result->idOs,4,'0',STR_PAD_LEFT) ?> — <?= htmlspecialchars(strip_tags($result->defeito??'')) ?>"></div>
            </div>
        </div>
        <div class="sisos-prom-foot">
            <button type="button" onclick="sisosFecharPromissoria()" class="vos-btn" style="background:rgba(255,255,255,0.06);color:#9ca3af;">Cancelar</button>
            <button type="button" onclick="sisosImprimirPromissoria()" class="vos-btn" style="background:linear-gradient(135deg,#fbbf24,#b45309);color:#111;">
                <i class='bx bx-printer'></i> Imprimir Promissória
            </button>
        </div>
    </div>
</div>

<div id="promOsPrintArea" style="display:none;"></div>

<style>
.sisos-prom-box{background:#1e2235;border:1px solid #252a3a;border-radius:18px;width:100%;max-width:580px;
    box-shadow:0 24px 60px rgba(0,0,0,.5);overflow:hidden;max-height:90vh;display:flex;flex-direction:column;}
.sisos-prom-head{display:flex;align-items:center;justify-content:space-between;
    padding:14px 18px;background:#1a1d2e;border-bottom:1px solid #252a3a;flex-shrink:0;}
.sisos-prom-foot{display:flex;gap:8px;justify-content:flex-end;
    padding:12px 18px;border-top:1px solid #252a3a;background:#1a1d2e;flex-shrink:0;}
.prom-lbl-sec{font-size:10px;font-weight:800;color:#6b7280;text-transform:uppercase;
    letter-spacing:.6px;padding-bottom:6px;border-bottom:1px solid #252a3a;margin-bottom:2px;}
.prom-lbl{display:block;font-size:10px;font-weight:700;color:#9ca3af;
    text-transform:uppercase;letter-spacing:.4px;margin-bottom:4px;}
.prom-inp{width:100%;background:#13151f;border:1px solid #444860;color:#e8eaf0;
    border-radius:8px;padding:8px 12px;font-size:13px;box-sizing:border-box;transition:border-color .15s;}
.prom-inp:focus{border-color:#fbbf24;outline:none;}
#promOsPrintArea{background:#fff;font-family:'Times New Roman',serif;font-size:12pt;color:#000;line-height:1.6;}
@media print{
    body *{visibility:hidden !important;}
    #promOsPrintArea,#promOsPrintArea *{visibility:visible !important;}
    #promOsPrintArea{position:fixed !important;top:0 !important;left:0 !important;
        width:210mm !important;min-height:297mm !important;padding:15mm !important;
        margin:0 !important;background:#fff !important;z-index:99999 !important;}
    @page{size:A4;margin:0;}
}
</style>

<script>
function sisosAbrirPromissoria(){
    setTimeout(function(){ try{$('#pm_venc,#pm_emissao').datepicker({dateFormat:'dd/mm/yy'});}catch(e){} },100);
    document.getElementById('modalPromissoria').style.display='flex';
    document.body.style.overflow='hidden';
}
function sisosFecharPromissoria(){
    document.getElementById('modalPromissoria').style.display='none';
    document.body.style.overflow='';
}
function sisosImprimirPromissoria(){
    var en=document.getElementById('pm_em_nome').value.trim();
    var bn=document.getElementById('pm_bf_nome').value.trim();
    var vl=document.getElementById('pm_valor').value.trim();
    var vc=document.getElementById('pm_venc').value.trim();
    var ex=document.getElementById('pm_extenso').value.trim();
    var erros=[];
    if(!en)erros.push('Nome do Emitente');
    if(!bn)erros.push('Nome do Beneficiário');
    if(!vl)erros.push('Valor');
    if(!vc)erros.push('Vencimento');
    if(!ex)erros.push('Valor por Extenso');
    if(erros.length){alert('Preencha os campos obrigatórios:
• '+erros.join('
• '));return;}
    var ed=document.getElementById('pm_em_doc').value;
    var ee=document.getElementById('pm_em_end').value;
    var ec=document.getElementById('pm_em_cidade').value;
    var bd=document.getElementById('pm_bf_doc').value;
    var nu=document.getElementById('pm_numero').value;
    var ju=document.getElementById('pm_juros').value||'2%';
    var lo=document.getElementById('pm_local').value;
    var em=document.getElementById('pm_emissao').value;
    var ob=document.getElementById('pm_obs').value;
    var html='<div style="text-align:center;border-bottom:2px solid #000;padding-bottom:8px;margin-bottom:12px;">'
        +'<div style="font-size:16pt;font-weight:700;text-transform:uppercase;letter-spacing:3px;">NOTA PROMISSÓRIA</div>'
        +'<div style="font-size:9pt;color:#555;">Nº '+(nu||'—')+'</div></div>'
        +'<div style="display:flex;justify-content:space-between;margin:10px 0 8px;">'
        +'<div><div style="font-size:9pt;color:#555;font-weight:700;margin-bottom:3px;">VALOR</div>'
        +'<div style="border:2px solid #000;padding:8px 16px;border-radius:4px;font-size:14pt;font-weight:700;">R$ '+vl+'</div></div>'
        +'<div style="text-align:right;font-size:10pt;"><strong style="display:block;font-size:9pt;color:#555;margin-bottom:2px;">VENCIMENTO</strong>'+vc+'</div></div>'
        +'<div style="text-align:justify;margin:10px 0;font-size:11pt;line-height:1.8;border:1px solid #e5e7eb;background:#fafafa;padding:12px;border-radius:4px;">'
        +'No dia <strong>'+vc+'</strong>, pagarei por esta única via de <strong>NOTA PROMISSÓRIA</strong> a <strong>'+bn+'</strong> ou à sua ordem, a quantia de <strong>R$ '+vl+'</strong> (<strong>'+ex+'</strong>), em moeda corrente nacional. Em caso de inadimplemento, incidirão juros de mora de <strong>'+ju+'</strong> ao mês.'
        +'</div>'
        +(ob?'<div style="font-size:9pt;color:#555;margin:6px 0;"><strong>Ref.:</strong> '+ob+'</div>':'')
        +'<div style="margin-top:12px;"><div style="font-size:9pt;color:#555;font-weight:700;margin-bottom:4px;">EMITENTE</div>'
        +'<div style="display:grid;grid-template-columns:1fr 1fr;gap:16px;margin-bottom:4px;">'
        +'<div><span style="font-size:9pt;color:#555;font-weight:700;">Nome:</span><div style="border-bottom:1px solid #333;min-height:20px;">'+en+'</div></div>'
        +'<div><span style="font-size:9pt;color:#555;font-weight:700;">CPF/CNPJ:</span><div style="border-bottom:1px solid #333;min-height:20px;">'+ed+'</div></div>'
        +'</div>'
        +'<span style="font-size:9pt;color:#555;font-weight:700;">Endereço:</span><div style="border-bottom:1px solid #333;min-height:20px;">'+ee+'</div>'
        +'<div style="display:grid;grid-template-columns:1fr 1fr;gap:16px;margin-top:4px;">'
        +'<div><span style="font-size:9pt;color:#555;font-weight:700;">Cidade:</span><div style="border-bottom:1px solid #333;min-height:20px;">'+ec+'</div></div>'
        +'<div><span style="font-size:9pt;color:#555;font-weight:700;">CPF/CNPJ Beneficiário:</span><div style="border-bottom:1px solid #333;min-height:20px;">'+bd+'</div></div>'
        +'</div></div>'
        +'<div style="text-align:right;margin:12px 0 8px;font-size:10pt;">'+lo+', '+em+'</div>'
        +'<div style="display:grid;grid-template-columns:1fr 1fr;gap:40px;margin-top:24px;">'
        +'<div style="text-align:center;"><div style="border-bottom:1px solid #000;height:40px;margin-bottom:4px;"></div><div style="font-size:9pt;color:#555;">'+en+'</div></div>'
        +'<div style="text-align:center;"><div style="border-bottom:1px solid #000;height:40px;margin-bottom:4px;"></div><div style="font-size:9pt;color:#555;">Beneficiário / Credor</div></div>'
        +'</div>'
        +'<div style="margin-top:12px;border-top:1px solid #ccc;padding-top:6px;font-size:8pt;color:#777;text-align:center;">'
        +'Documento gerado pelo SISOS · OS #<?= str_pad($result->idOs,4,'0',STR_PAD_LEFT) ?> · Esta promissória constitui título executivo extrajudicial (Art. 783, CPC)'
        +'</div>';
    document.getElementById('promOsPrintArea').innerHTML=html;
    document.getElementById('promOsPrintArea').style.display='block';
    sisosFecharPromissoria();
    setTimeout(function(){window.print();setTimeout(function(){document.getElementById('promOsPrintArea').style.display='none';},1500);},200);
}
document.addEventListener('keydown',function(e){if(e.key==='Escape')sisosFecharPromissoria();});
</script>
<!-- ════ FIM Modal Promissória ════════════════════════════════════ -->
