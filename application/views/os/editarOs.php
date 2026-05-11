<link rel="stylesheet" href="<?= base_url() ?>assets/js/jquery-ui/css/smoothness/jquery-ui-1.9.2.custom.css" />
<script src="<?= base_url() ?>assets/js/jquery-ui/js/jquery-ui-1.9.2.custom.js"></script>
<script src="<?= base_url() ?>assets/js/jquery.validate.js"></script>
<script src="<?= base_url() ?>assets/js/sweetalert2.all.min.js"></script>
<link rel="stylesheet" href="<?= base_url() ?>assets/trumbowyg/ui/trumbowyg.css">
<script src="<?= base_url() ?>assets/trumbowyg/trumbowyg.js"></script>
<script src="<?= base_url() ?>assets/trumbowyg/langs/pt_br.js"></script>
<script src="<?= base_url() ?>assets/js/maskmoney.js"></script>
<link rel="stylesheet" href="<?= base_url() ?>assets/css/custom.css" />

<style>
/* ── Reset Bootstrap 2 ── */
.eos-wrap *,.eos-wrap *::before,.eos-wrap *::after{box-sizing:border-box;}
.eos-wrap .widget-box,.eos-wrap .row-fluid,.eos-wrap .span12,
.eos-wrap .span6,.eos-wrap .span4,.eos-wrap .span3,.eos-wrap .span2{all:unset;display:block;}

/* ── Layout ── */
.eos-wrap{font-family:inherit;}

/* ── Topbar da OS ── */
.eos-header{display:flex;align-items:center;justify-content:space-between;margin-bottom:16px;flex-wrap:wrap;gap:8px;}
.eos-header-left{display:flex;align-items:center;gap:10px;}
.eos-title{font-size:18px;font-weight:800;color:#e8eaf0;display:flex;align-items:center;gap:8px;}
.eos-title i{font-size:20px;color:#fbbf24;}
.eos-badge{display:inline-block;padding:3px 10px;border-radius:20px;font-size:11px;font-weight:700;}
.eos-actions{display:flex;gap:6px;flex-wrap:wrap;}
.eos-btn{display:inline-flex;align-items:center;gap:5px;padding:7px 14px;border-radius:8px;font-size:12px;font-weight:700;text-decoration:none;border:none;cursor:pointer;transition:all .15s;white-space:nowrap;}
.eos-btn:hover{transform:translateY(-1px);text-decoration:none;}
.eos-btn-primary{background:linear-gradient(135deg,#6366f1,#4f46e5);color:#fff;box-shadow:0 4px 10px rgba(99,102,241,0.3);}
.eos-btn-success{background:linear-gradient(135deg,#22c55e,#16a34a);color:#fff;box-shadow:0 4px 10px rgba(34,197,94,0.3);}
.eos-btn-danger{background:linear-gradient(135deg,#ef4444,#dc2626);color:#fff;}
.eos-btn-amber{background:rgba(245,158,11,0.15);color:#fbbf24;border:1px solid rgba(245,158,11,0.3);}
.eos-btn-amber:hover{background:rgba(245,158,11,0.25);color:#fbbf24;}
.eos-btn-ghost{background:rgba(255,255,255,0.07);color:#9ca3af;border:1px solid rgba(255,255,255,0.1);}
.eos-btn-ghost:hover{color:#e8eaf0;}
.eos-btn-wpp{background:linear-gradient(135deg,#25d366,#128c7e);color:#fff;}
.eos-btn-print{background:#252a3a;color:#9ca3af;border:1px solid #444860;}
/* Dropdown imprimir */
.eos-dropdown{position:relative;display:inline-flex;}
.eos-dropdown-menu{display:none;position:absolute;top:calc(100% + 4px);right:0;background:#1e2133;border:1px solid #444860;border-radius:10px;box-shadow:0 8px 24px rgba(0,0,0,0.5);z-index:999;min-width:180px;overflow:hidden;}
.eos-dropdown:hover .eos-dropdown-menu{display:block;}
.eos-dropdown-item{display:flex;align-items:center;gap:8px;padding:9px 14px;font-size:13px;color:#c9cad6;text-decoration:none;transition:background .12s;white-space:nowrap;}
.eos-dropdown-item:hover{background:rgba(255,255,255,0.07);color:#e8eaf0;}

/* ── Tabs ── */
.eos-tabs-bar{display:flex;gap:2px;border-bottom:2px solid rgba(255,255,255,0.07);margin-bottom:0;overflow-x:auto;}
.eos-tabs-bar::-webkit-scrollbar{height:3px;}
.eos-tabs-bar::-webkit-scrollbar-thumb{background:#444860;border-radius:3px;}
.eos-tab{display:inline-flex;align-items:center;gap:6px;padding:10px 16px;font-size:12px;font-weight:700;color:#6b7280;cursor:pointer;border:none;background:none;border-bottom:3px solid transparent;margin-bottom:-2px;transition:all .15s;white-space:nowrap;}
.eos-tab:hover{color:#e8eaf0;}
.eos-tab.active{color:#fbbf24;border-bottom-color:#fbbf24;}
.eos-tab i{font-size:14px;}
.eos-pane{display:none;padding:18px 0;}
.eos-pane.active{display:block;}

/* ── Cards dentro das abas ── */
.eos-card{background:#1a1d2e;border:1px solid rgba(255,255,255,0.07);border-radius:14px;overflow:hidden;margin-bottom:14px;}
.eos-card-head{display:flex;align-items:center;gap:8px;padding:11px 16px;border-bottom:1px solid rgba(255,255,255,0.06);background:#252a3a;}
.eos-card-head i{font-size:15px;color:#fbbf24;}
.eos-card-head span{font-size:11px;font-weight:700;color:#9ca3af;text-transform:uppercase;letter-spacing:.8px;}
.eos-card-body{padding:16px;}

/* ── Grid de campos ── */
.eos-grid{display:grid;grid-template-columns:1fr 1fr 1fr 1fr;gap:12px;}
.eos-grid-2{display:grid;grid-template-columns:1fr 1fr;gap:12px;}
@media(max-width:900px){.eos-grid{grid-template-columns:1fr 1fr;}.eos-grid-2{grid-template-columns:1fr;}}
@media(max-width:600px){.eos-grid{grid-template-columns:1fr;}}
.eos-field{margin-bottom:0;}
.eos-label{font-size:11px;font-weight:700;color:#9ca3af;text-transform:uppercase;letter-spacing:.5px;display:block;margin-bottom:5px;}
.eos-label .req{color:#f87171;margin-left:2px;}
.eos-input,.eos-select{width:100%;background:#13151f;border:1px solid #444860;color:#e8eaf0;border-radius:8px;padding:8px 12px;font-size:13px;box-sizing:border-box;transition:border-color .15s;display:block;-webkit-appearance:none;}
.eos-input:focus,.eos-select:focus{border-color:#fbbf24;outline:none;}
.eos-select{height:38px;}
.eos-input-group{display:flex;gap:6px;}
.eos-input-group .eos-input{flex:1;}
/* Trumbowyg dark */
.trumbowyg-box{border-radius:10px!important;overflow:hidden;border:1px solid #444860!important;}
.trumbowyg-button-pane{background:#252a3a!important;border-bottom:1px solid #444860!important;border-radius:10px 10px 0 0!important;}
.trumbowyg-button-pane button,.trumbowyg-button-pane .trumbowyg-button-group::before{color:#9ca3af!important;}
.trumbowyg-button-pane button:hover,.trumbowyg-button-pane button.trumbowyg-active{background:rgba(255,255,255,0.08)!important;color:#e8eaf0!important;}
.trumbowyg-editor{background:#13151f!important;color:#e8eaf0!important;border:none!important;border-radius:0 0 10px 10px!important;min-height:140px!important;padding:10px 12px!important;font-size:13px!important;}

/* ── Tabelas (produtos/serviços/anotações) ── */
.eos-tbl-wrap{background:#1a1d2e;border:1px solid rgba(255,255,255,0.07);border-radius:14px;overflow:hidden;}
.eos-tbl{width:100%;border-collapse:collapse;}
.eos-tbl thead th{background:#252a3a;color:#9ca3af;font-size:11px;font-weight:700;text-transform:uppercase;letter-spacing:.5px;padding:10px 12px;border-bottom:1px solid rgba(255,255,255,0.07);}
.eos-tbl tbody tr{border-bottom:1px solid rgba(255,255,255,0.04);transition:background .12s;}
.eos-tbl tbody tr:hover{background:rgba(255,255,255,0.03);}
.eos-tbl tbody td{padding:9px 12px;font-size:13px;color:#c9cad6;vertical-align:middle;}
.eos-tbl tfoot td{padding:9px 12px;font-size:13px;font-weight:700;color:#fbbf24;background:#252a3a;}
.eos-tbl .btn-del{width:28px;height:28px;border-radius:6px;background:rgba(239,68,68,0.15);color:#f87171;display:inline-flex;align-items:center;justify-content:center;font-size:14px;cursor:pointer;border:none;transition:all .12s;}
.eos-tbl .btn-del:hover{background:rgba(239,68,68,0.3);}

/* ── Add form (produtos/serviços) ── */
.eos-add-row{display:flex;gap:10px;align-items:flex-end;flex-wrap:wrap;background:#1a1d2e;border:1px solid rgba(255,255,255,0.07);border-radius:14px;padding:14px 16px;margin-bottom:14px;}
.eos-add-field{flex:1;min-width:160px;}
.eos-add-field-sm{flex:0 0 120px;}
.eos-add-field-xs{flex:0 0 90px;}

/* ── Desconto ── */
.eos-desc-wrap{background:#1a1d2e;border:1px solid rgba(255,255,255,0.07);border-radius:14px;padding:18px;}
.eos-desc-row{display:flex;gap:12px;align-items:flex-end;flex-wrap:wrap;}

/* ── Anexos ── */
.eos-anexos-grid{display:flex;flex-wrap:wrap;gap:10px;padding:14px;}
.eos-anexo-item{width:140px;height:130px;border-radius:10px;overflow:hidden;background:#252a3a;border:1px solid #444860;cursor:pointer;position:relative;display:flex;align-items:center;justify-content:center;}
.eos-anexo-item img{width:100%;height:100%;object-fit:cover;}
.eos-anexo-item:hover .eos-anexo-overlay{opacity:1;}
.eos-anexo-overlay{position:absolute;inset:0;background:rgba(0,0,0,0.5);opacity:0;transition:opacity .15s;display:flex;align-items:center;justify-content:center;color:#fff;font-size:22px;}

/* ── Anotações ── */
.eos-anotacao-item{display:flex;gap:12px;padding:12px 16px;border-bottom:1px solid rgba(255,255,255,0.04);align-items:flex-start;}
.eos-anotacao-item:last-child{border-bottom:none;}
.eos-anotacao-dot{width:8px;height:8px;border-radius:50%;background:#6366f1;flex-shrink:0;margin-top:5px;}
.eos-anotacao-text{flex:1;font-size:13px;color:#c9cad6;}
.eos-anotacao-date{font-size:11px;color:#6b7280;margin-top:2px;}

/* ── Modais dark ── */
.eos-modal.modal .modal-header{background:#1a1d2e!important;background-image:none!important;border-bottom:1px solid rgba(255,255,255,0.08)!important;padding:14px 18px!important;display:flex!important;align-items:center!important;justify-content:space-between!important;}
.eos-modal.modal .modal-header h4{margin:0!important;font-size:15px!important;font-weight:800!important;color:#e8eaf0!important;text-shadow:none!important;display:flex!important;align-items:center!important;gap:8px!important;}
.eos-modal.modal .modal-header .close{color:#9ca3af!important;opacity:1!important;text-shadow:none!important;float:none!important;font-size:20px!important;}
.eos-modal.modal .modal-body{background:#13151f!important;padding:18px!important;}
.eos-modal.modal .modal-footer{background:#1a1d2e!important;background-image:none!important;border-top:1px solid rgba(255,255,255,0.08)!important;padding:12px 18px!important;display:flex!important;justify-content:flex-end!important;gap:8px!important;}
.eos-modal.modal input[type=text],.eos-modal.modal input[type=number],.eos-modal.modal select,.eos-modal.modal textarea{background:#1e2133!important;border:1px solid #444860!important;color:#e8eaf0!important;border-radius:8px!important;padding:8px 12px!important;font-size:13px!important;width:100%!important;box-sizing:border-box!important;}
.eos-modal.modal input:focus,.eos-modal.modal select:focus,.eos-modal.modal textarea:focus{border-color:#6366f1!important;outline:none!important;}
.eos-modal.modal select{height:36px!important;}
.eos-modal.modal label{font-size:11px!important;font-weight:700!important;color:#9ca3af!important;text-transform:uppercase!important;letter-spacing:.5px!important;display:block!important;margin-bottom:5px!important;}
.eos-modal.modal .form-group{margin-bottom:14px!important;}
.eos-modal.modal .alert-info{background:rgba(99,102,241,0.1)!important;border:1px solid rgba(99,102,241,0.3)!important;color:#a5b4fc!important;border-radius:8px!important;padding:8px 12px!important;font-size:12px!important;}
.md-btn-cancel{display:inline-flex;align-items:center;gap:6px;padding:9px 18px;border-radius:8px;background:rgba(255,255,255,0.07);color:#9ca3af;border:1px solid rgba(255,255,255,0.1);font-size:13px;font-weight:700;cursor:pointer;}
.md-btn-save{display:inline-flex;align-items:center;gap:6px;padding:9px 18px;border-radius:8px;background:linear-gradient(135deg,#6366f1,#4f46e5);color:#fff;border:none;font-size:13px;font-weight:700;cursor:pointer;}
.md-btn-green{background:linear-gradient(135deg,#22c55e,#16a34a)!important;}
.md-btn-danger{background:linear-gradient(135deg,#ef4444,#dc2626)!important;}

label.error{color:#f87171!important;font-size:11px!important;}
input.error,select.error,textarea.error{border-color:#f87171!important;}

/* Faturado badge */
.faturado-badge{display:inline-flex;align-items:center;gap:5px;padding:4px 12px;background:rgba(251,191,36,0.15);color:#fbbf24;border-radius:20px;font-size:11px;font-weight:700;border:1px solid rgba(251,191,36,0.3);}
</style>

<?php
// Pre-calculate totals
$total  = 0; foreach ($produtos as $p) $total += $p->subTotal;
$totals = 0; foreach ($servicos as $s) { $pr=$s->preco?:$s->precoVenda; $totals += $pr*($s->quantidade?:1); }
$totalGeral = $total + $totals;

// Status badge color
$statusClasses = [
    'Aberto'=>'rgba(59,130,246,0.15);color:#60a5fa',
    'Em Andamento'=>'rgba(99,102,241,0.15);color:#a5b4fc',
    'Orçamento'=>'rgba(251,191,36,0.15);color:#fbbf24',
    'Finalizado'=>'rgba(34,197,94,0.15);color:#4ade80',
    'Faturado'=>'rgba(34,197,94,0.15);color:#4ade80',
    'Cancelado'=>'rgba(239,68,68,0.15);color:#f87171',
    'Aguardando Peças'=>'rgba(245,158,11,0.15);color:#fbbf24',
    'Aprovado'=>'rgba(34,197,94,0.15);color:#4ade80',
];
$statusColor = $statusClasses[$result->status] ?? 'rgba(156,163,175,0.15);color:#9ca3af';

$zapnumber = '';
if ($this->permission->checkPermission($this->session->userdata('permissao'), 'eOs')) {
    $this->load->model('os_model');
    $zapnumber = preg_replace("/[^0-9]/", "", $result->celular_cliente ?? '');
    $troca = [$result->nomeCliente, $result->idOs, $result->status,
        'R$ '.($result->desconto!=0&&$result->valor_desconto!=0 ? number_format($result->valor_desconto,2,',','.') : number_format($totalGeral,2,',','.')),
        strip_tags($result->descricaoProduto), ($emitente?$emitente->nome:''), ($emitente?$emitente->telefone:''),
        strip_tags($result->observacoes), strip_tags($result->defeito), strip_tags($result->laudoTecnico),
        date('d/m/Y',strtotime($result->dataFinal)), date('d/m/Y',strtotime($result->dataInicial)), $result->garantia.' dias'];
    $texto_de_notificacao = $this->os_model->criarTextoWhats($texto_de_notificacao, $troca);
}
?>

<div class="eos-wrap new122">

    <!-- ── Header ── -->
    <div class="eos-header">
        <div class="eos-header-left">
            <div class="eos-title">
                <i class='bx bx-file'></i>
                OS #<?= str_pad($result->idOs,4,'0',STR_PAD_LEFT) ?>
            </div>
            <span class="eos-badge" style="background:<?= $statusColor ?>;"><?= htmlspecialchars($result->status) ?></span>
            <?php if ($result->faturado): ?>
            <span class="faturado-badge"><i class='bx bx-check-circle'></i> Faturada</span>
            <?php endif; ?>
        </div>
        <div class="eos-actions">
            <?php if ($result->faturado == 0): ?>
            <a href="#modal-faturar" data-toggle="modal" class="eos-btn eos-btn-danger">
                <i class='bx bx-dollar'></i> Faturar
            </a>
            <?php endif; ?>
            <a href="<?= site_url('os/visualizar/'.$result->idOs) ?>" class="eos-btn eos-btn-primary">
                <i class='bx bx-show'></i> Visualizar
            </a>
            <div class="eos-dropdown">
                <button class="eos-btn eos-btn-print"><i class='bx bx-printer'></i> Imprimir <i class='bx bx-chevron-down'></i></button>
                <div class="eos-dropdown-menu">
                    <a target="_blank" href="<?= site_url('os/imprimir/'.$result->idOs) ?>" class="eos-dropdown-item"><i class='bx bx-file'></i> Papel A4</a>
                    <a target="_blank" href="<?= site_url('os/imprimirTermica/'.$result->idOs) ?>" class="eos-dropdown-item"><i class='bx bx-receipt'></i> Cupom 80mm</a>
                    <?php if ($result->garantias_id): ?>
                    <a target="_blank" href="<?= site_url('garantias/imprimirGarantiaOs/'.$result->idOs) ?>" class="eos-dropdown-item"><i class='bx bx-paperclip'></i> Termo Garantia</a>
                    <?php endif; ?>
                </div>
            </div>
            <?php if (!empty($zapnumber)): ?>
            <a href="https://wa.me/send?phone=55<?= $zapnumber ?>&text=<?= $texto_de_notificacao ?>" target="_blank" class="eos-btn eos-btn-wpp">
                <i class='bx bxl-whatsapp'></i> WhatsApp
            </a>
            <?php endif; ?>
            <a href="<?= site_url('os/enviar_email/'.$result->idOs) ?>" class="eos-btn eos-btn-amber">
                <i class='bx bx-envelope'></i> E-mail
            </a>
            <a href="<?= base_url() ?>index.php/os" class="eos-btn eos-btn-ghost">
                <i class='bx bx-arrow-back'></i>
            </a>
        </div>
    </div>

    <!-- ── Tabs ── -->
    <div class="eos-tabs-bar">
        <button class="eos-tab active" data-tab="eosTab1"><i class='bx bx-detail'></i> Detalhes</button>
        <button class="eos-tab" data-tab="eosTab2"><i class='bx bx-purchase-tag'></i> Desconto</button>
        <button class="eos-tab" data-tab="eosTab3"><i class='bx bx-package'></i> Produtos <span id="qtdProd" style="background:rgba(251,191,36,0.15);color:#fbbf24;font-size:10px;padding:1px 6px;border-radius:10px;font-weight:700;margin-left:2px;"><?= count($produtos) ?></span></button>
        <button class="eos-tab" data-tab="eosTab4"><i class='bx bx-wrench'></i> Serviços <span id="qtdServ" style="background:rgba(99,102,241,0.15);color:#a5b4fc;font-size:10px;padding:1px 6px;border-radius:10px;font-weight:700;margin-left:2px;"><?= count($servicos) ?></span></button>
        <button class="eos-tab" data-tab="eosTab5"><i class='bx bx-paperclip'></i> Anexos <span style="background:rgba(96,165,250,0.15);color:#60a5fa;font-size:10px;padding:1px 6px;border-radius:10px;font-weight:700;margin-left:2px;"><?= count($anexos) ?></span></button>
        <button class="eos-tab" data-tab="eosTab6"><i class='bx bx-note'></i> Anotações <span style="background:rgba(168,85,247,0.15);color:#c084fc;font-size:10px;padding:1px 6px;border-radius:10px;font-weight:700;margin-left:2px;"><?= count($anotacoes) ?></span></button>
    </div>

    <!-- ══════════════════════════════
         TAB 1: DETALHES
    ══════════════════════════════ -->
    <div class="eos-pane active" id="eosTab1">
        <form action="<?= current_url() ?>" method="post" id="formOs">
            <?= form_hidden('idOs', $result->idOs) ?>

            <!-- Pessoas -->
            <div class="eos-card">
                <div class="eos-card-head"><i class='bx bx-user'></i><span>Cliente & Responsável</span></div>
                <div class="eos-card-body">
                    <div class="eos-grid-2">
                        <div class="eos-field">
                            <label class="eos-label">Cliente <span class="req">*</span></label>
                            <div class="eos-input-group">
                                <input id="cliente" class="eos-input" type="text" name="cliente" value="<?= htmlspecialchars($result->nomeCliente) ?>" autocomplete="off" />
                                <input id="clientes_id" type="hidden" name="clientes_id" value="<?= $result->clientes_id ?>" />
                                <input type="hidden" name="valor" value="" />
                            </div>
                        </div>
                        <div class="eos-field">
                            <label class="eos-label">Técnico / Responsável <span class="req">*</span></label>
                            <input id="tecnico" class="eos-input" type="text" name="tecnico" value="<?= htmlspecialchars($result->nome) ?>" autocomplete="off" />
                            <input id="usuarios_id" type="hidden" name="usuarios_id" value="<?= $result->usuarios_id ?>" />
                        </div>
                    </div>
                </div>
            </div>

            <!-- Status & Datas -->
            <div class="eos-card">
                <div class="eos-card-head"><i class='bx bx-calendar'></i><span>Status & Datas</span></div>
                <div class="eos-card-body">
                    <div class="eos-grid">
                        <div class="eos-field">
                            <label class="eos-label">Status <span class="req">*</span></label>
                            <select class="eos-select" name="status" id="status">
                                <?php
                                $statuses = ['Aberto','Orçamento','Negociação','Aprovado','Aguardando Peças','Em Andamento','Finalizado','Faturado','Cancelado','Recusado','Aguardando Autorização','Não foi Possível','Sem Conserto','Não temos Peças','Em Teste'];
                                foreach ($statuses as $st):
                                ?>
                                <option value="<?= $st ?>" <?= $result->status==$st?'selected':'' ?>><?= $st ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="eos-field">
                            <label class="eos-label">Situação Financeira</label>
                            <select name="situacao_financeira" id="situacao_financeira" class="eos-select">
                                <option value="pendente" <?= ($result->situacao_financeira??'pendente')=='pendente'?'selected':'' ?>>Pendente</option>
                                <option value="parcial"  <?= ($result->situacao_financeira??'')=='parcial'?'selected':'' ?>>Parcialmente Pago</option>
                                <option value="pago"     <?= ($result->situacao_financeira??'')=='pago'?'selected':'' ?>>Pago</option>
                                <option value="isento"   <?= ($result->situacao_financeira??'')=='isento'?'selected':'' ?>>Isento</option>
                            </select>
                        </div>
                        <div class="eos-field">
                            <label class="eos-label">Data Inicial <span class="req">*</span></label>
                            <input id="dataInicial" autocomplete="off" class="eos-input datepicker" type="text" name="dataInicial" value="<?= date('d/m/Y',strtotime($result->dataInicial)) ?>" />
                        </div>
                        <div class="eos-field">
                            <label class="eos-label">Data Final <span id="dataFinalLabel"></span></label>
                            <input id="dataFinal" autocomplete="off" class="eos-input datepicker" type="text" name="dataFinal"
                                value="<?= $result->dataFinal&&$result->dataFinal!='0000-00-00'?date('d/m/Y',strtotime($result->dataFinal)):'' ?>" />
                        </div>
                        <div class="eos-field">
                            <label class="eos-label">Data Retirada</label>
                            <input id="data_retirada" autocomplete="off" class="eos-input datepicker" type="text" name="data_retirada"
                                value="<?= !empty($result->data_retirada)&&$result->data_retirada!='0000-00-00'?date('d/m/Y',strtotime($result->data_retirada)):'' ?>" />
                        </div>
                        <div class="eos-field">
                            <label class="eos-label">Prev. Entrega do Aparelho</label>
                            <input id="dataEntrega" autocomplete="off" class="eos-input datepicker" type="text" name="dataEntrega"
                                value="<?= !empty($result->dataEntrega)&&$result->dataEntrega!='0000-00-00'?date('d/m/Y',strtotime($result->dataEntrega)):'' ?>" placeholder="dd/mm/aaaa" />
                        </div>
                        <div class="eos-field">
                            <label class="eos-label">Garantia (dias)</label>
                            <input id="garantia" type="number" min="0" max="9999" class="eos-input" name="garantia" value="<?= $result->garantia ?>" placeholder="0" />
                        </div>
                        <div class="eos-field">
                            <label class="eos-label">Termo de Garantia</label>
                            <input id="termoGarantia" class="eos-input" type="text" name="termoGarantia" value="<?= htmlspecialchars($result->refGarantia??'') ?>" autocomplete="off" />
                            <input id="garantias_id" type="hidden" name="garantias_id" value="<?= $result->garantias_id ?>" />
                        </div>
                    </div>
                </div>
            </div>

            <!-- Equipamento -->
            <div class="eos-card">
                <div class="eos-card-head"><i class='bx bx-devices'></i><span>Equipamento</span></div>
                <div class="eos-card-body">
                    <div class="eos-grid-2">
                        <div class="eos-field">
                            <label class="eos-label">Equipamento / Produto</label>
                            <input type="text" name="equipamento" class="eos-input" value="<?= htmlspecialchars($result->equipamento??'') ?>" placeholder="Ex: Notebook Dell, Celular Samsung..." />
                        </div>
                        <div class="eos-field">
                            <label class="eos-label">Nº de Série / IMEI</label>
                            <input type="text" name="numeroSerie" class="eos-input" value="<?= htmlspecialchars($result->numeroSerie??'') ?>" placeholder="Ex: SN12345, IMEI 356..." />
                        </div>
                    </div>
                </div>
            </div>

            <!-- Textos -->
            <div class="eos-card">
                <div class="eos-card-head"><i class='bx bx-align-left'></i><span>Descrição & Detalhes Técnicos</span></div>
                <div class="eos-card-body">
                    <div class="eos-grid-2" style="gap:16px;">
                        <div>
                            <label class="eos-label" style="margin-bottom:8px;">Descrição do Produto/Serviço</label>
                            <textarea class="editor" name="descricaoProduto" id="descricaoProduto"><?= $result->descricaoProduto ?></textarea>
                        </div>
                        <div>
                            <label class="eos-label" style="margin-bottom:8px;"><span style="color:#f87171;">●</span> Defeito Apresentado</label>
                            <textarea class="editor" name="defeito" id="defeito"><?= $result->defeito ?></textarea>
                        </div>
                        <div>
                            <label class="eos-label" style="margin-bottom:8px;">Observações</label>
                            <textarea class="editor" name="observacoes" id="observacoes"><?= $result->observacoes ?></textarea>
                        </div>
                        <div>
                            <label class="eos-label" style="margin-bottom:8px;"><span style="color:#a78bfa;">●</span> Laudo Técnico</label>
                            <textarea class="editor" name="laudoTecnico" id="laudoTecnico"><?= $result->laudoTecnico ?></textarea>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Botões salvar -->
            <div style="display:flex;justify-content:flex-end;gap:8px;padding:4px 0;">
                <a href="<?= base_url() ?>index.php/os" class="eos-btn eos-btn-ghost">
                    <i class='bx bx-undo'></i> Voltar
                </a>
                <button type="submit" class="eos-btn eos-btn-success" id="btnContinuar">
                    <i class='bx bx-save'></i> Salvar Alterações
                </button>
            </div>
        </form>
    </div>

    <!-- ══════════════════════════════
         TAB 2: DESCONTO
    ══════════════════════════════ -->
    <div class="eos-pane" id="eosTab2">
        <div class="eos-card">
            <div class="eos-card-head"><i class='bx bx-purchase-tag'></i><span>Aplicar Desconto na OS</span></div>
            <div class="eos-card-body">
                <form id="formDesconto" action="<?= base_url() ?>index.php/os/adicionarDesconto" method="POST">
                    <input type="hidden" name="idOs" id="idOs" value="<?= $result->idOs ?>" />
                    <div style="display:flex;gap:12px;align-items:flex-end;flex-wrap:wrap;">
                        <div>
                            <label class="eos-label">Valor Total da OS</label>
                            <input class="eos-input money" id="valorTotal" name="valorTotal" type="text"
                                data-affixes-stay="true" data-thousands="" data-decimal="."
                                value="<?= number_format($totalGeral,2,'.','') ?>" readonly
                                style="max-width:130px;color:#fbbf24;font-weight:700;" />
                        </div>
                        <div>
                            <label class="eos-label">Tipo</label>
                            <select style="width:70px;" name="tipoDesconto" id="tipoDesconto" class="eos-select" style="height:38px;">
                                <option value="real">R$</option>
                                <option value="porcento" <?= $result->tipo_desconto=="porcento"?"selected":"" ?>>%</option>
                            </select>
                        </div>
                        <div>
                            <label class="eos-label">Desconto</label>
                            <input style="width:90px;" id="desconto" name="desconto" type="text" class="eos-input"
                                placeholder="0" maxlength="6" value="<?= $result->desconto ?>" />
                            <span style="color:#f87171;font-size:11px;display:block;" id="errorAlert"></span>
                        </div>
                        <div>
                            <label class="eos-label">Total com Desconto</label>
                            <input class="eos-input money" id="resultado" type="text" data-affixes-stay="true" data-thousands="" data-decimal="."
                                name="resultado" value="<?= $result->valor_desconto ?>" readonly
                                style="max-width:130px;color:#4ade80;font-weight:700;" />
                        </div>
                        <button type="submit" class="eos-btn eos-btn-success" id="btnAdicionarDesconto">
                            <i class='bx bx-check'></i> Aplicar
                        </button>
                    </div>
                </form>
                <?php if ($result->valor_desconto): ?>
                <div style="margin-top:14px;padding:10px 14px;background:rgba(34,197,94,0.08);border:1px solid rgba(34,197,94,0.2);border-radius:8px;font-size:13px;color:#4ade80;">
                    <i class='bx bx-check-circle'></i>
                    Desconto aplicado: <strong>R$ <?= number_format($totalGeral - $result->valor_desconto,2,',','.') ?></strong>
                    — Total final: <strong>R$ <?= number_format($result->valor_desconto,2,',','.') ?></strong>
                </div>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <!-- ══════════════════════════════
         TAB 3: PRODUTOS
    ══════════════════════════════ -->
    <div class="eos-pane" id="eosTab3">
        <?php if (strtolower($result->status) != 'cancelado'): ?>
        <form id="formProdutos" action="<?= base_url() ?>index.php/os/adicionarProduto" method="post">
            <div class="eos-add-row">
                <input type="hidden" name="idProduto" id="idProduto" />
                <input type="hidden" name="idOsProduto" id="idOsProduto" value="<?= $result->idOs ?>" />
                <input type="hidden" name="estoque" id="estoque" value="" />
                <div class="eos-add-field">
                    <label class="eos-label">Produto</label>
                    <input type="text" class="eos-input" name="produto" id="produto" placeholder="Digite para buscar..." autocomplete="off" />
                </div>
                <div class="eos-add-field-sm">
                    <label class="eos-label">Preço (R$)</label>
                    <input type="text" id="preco" name="preco" class="eos-input money" data-affixes-stay="true" data-thousands="" data-decimal="." placeholder="0,00" />
                </div>
                <div class="eos-add-field-xs">
                    <label class="eos-label">Qtd</label>
                    <input type="text" placeholder="1" id="quantidade" name="quantidade" class="eos-input" />
                </div>
                <button type="submit" class="eos-btn eos-btn-success" id="btnAdicionarProduto" style="align-self:flex-end;">
                    <i class='bx bx-plus'></i> Adicionar
                </button>
            </div>
        </form>
        <?php endif; ?>

        <div class="eos-tbl-wrap" id="divProdutos">
            <table class="eos-tbl" id="tblProdutos">
                <thead>
                    <tr><th>Produto</th><th style="width:80px;text-align:center;">Qtd</th><th style="width:110px;text-align:center;">Preço Unit.</th><th style="width:50px;"></th><th style="width:120px;text-align:right;">Subtotal</th></tr>
                </thead>
                <tbody>
                    <?php
                    $total = 0;
                    foreach ($produtos as $p) {
                        $total += $p->subTotal;
                        echo '<tr>';
                        echo '<td style="font-weight:600;color:#e8eaf0;">'.htmlspecialchars($p->descricao).'</td>';
                        echo '<td style="text-align:center;">'.$p->quantidade.'</td>';
                        echo '<td style="text-align:center;">R$ '.number_format($p->preco?:$p->precoVenda,2,',','.').'</td>';
                        if (strtolower($result->status) != 'cancelado')
                            echo '<td><button type="button" class="eos-tbl btn-del btn-nwe4" idAcao="'.$p->idProdutos_os.'" prodAcao="'.$p->idProdutos.'" quantAcao="'.$p->quantidade.'" title="Remover"><i class="bx bx-trash-alt"></i></button></td>';
                        else echo '<td></td>';
                        echo '<td style="text-align:right;color:#fbbf24;font-weight:700;">R$ '.number_format($p->subTotal,2,',','.').'</td>';
                        echo '</tr>';
                    }
                    if (!$produtos) echo '<tr><td colspan="5" style="text-align:center;padding:20px;color:#6b7280;">Nenhum produto adicionado.</td></tr>';
                    ?>
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="4" style="text-align:right;color:#9ca3af;font-weight:700;">Total Produtos:</td>
                        <td style="text-align:right;font-weight:800;color:#fbbf24;">
                            R$ <?= number_format($total,2,',','.') ?>
                            <input type="hidden" id="total-venda" value="<?= number_format($total,2) ?>">
                        </td>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>

    <!-- ══════════════════════════════
         TAB 4: SERVIÇOS
    ══════════════════════════════ -->
    <div class="eos-pane" id="eosTab4">
        <form id="formServicos" action="<?= base_url() ?>index.php/os/adicionarServico" method="post">
            <div class="eos-add-row">
                <input type="hidden" name="idServico" id="idServico" />
                <input type="hidden" name="idOsServico" id="idOsServico" value="<?= $result->idOs ?>" />
                <div class="eos-add-field">
                    <label class="eos-label">Serviço</label>
                    <input type="text" class="eos-input" name="servico" id="servico" placeholder="Digite para buscar..." autocomplete="off" />
                </div>
                <div class="eos-add-field-sm">
                    <label class="eos-label">Preço (R$)</label>
                    <input type="text" id="preco_servico" name="preco" class="eos-input money" data-affixes-stay="true" data-thousands="" data-decimal="." placeholder="0,00" />
                </div>
                <div class="eos-add-field-xs">
                    <label class="eos-label">Qtd</label>
                    <input type="text" placeholder="1" id="quantidade_servico" name="quantidade" class="eos-input" />
                </div>
                <button type="submit" class="eos-btn eos-btn-success" style="align-self:flex-end;">
                    <i class='bx bx-plus'></i> Adicionar
                </button>
            </div>
        </form>

        <div class="eos-tbl-wrap" id="divServicos">
            <table class="eos-tbl" id="tblServicos">
                <thead>
                    <tr><th>Serviço</th><th style="width:80px;text-align:center;">Qtd</th><th style="width:110px;text-align:center;">Preço</th><th style="width:50px;"></th><th style="width:120px;text-align:right;">Subtotal</th></tr>
                </thead>
                <tbody>
                    <?php
                    $totals = 0;
                    foreach ($servicos as $s) {
                        $preco = $s->preco ?: $s->precoVenda;
                        $sub   = $preco * ($s->quantidade ?: 1);
                        $totals += $sub;
                        echo '<tr>';
                        echo '<td style="font-weight:600;color:#e8eaf0;">'.htmlspecialchars($s->nome).'</td>';
                        echo '<td style="text-align:center;">'.($s->quantidade?:1).'</td>';
                        echo '<td style="text-align:center;">R$ '.number_format($preco,2,',','.').'</td>';
                        echo '<td><button type="button" class="eos-tbl btn-del btn-nwe4 servico" idAcao="'.$s->idServicos_os.'" title="Remover"><i class="bx bx-trash-alt"></i></button></td>';
                        echo '<td style="text-align:right;color:#fbbf24;font-weight:700;">R$ '.number_format($sub,2,',','.').'</td>';
                        echo '</tr>';
                    }
                    if (!$servicos) echo '<tr><td colspan="5" style="text-align:center;padding:20px;color:#6b7280;">Nenhum serviço adicionado.</td></tr>';
                    ?>
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="4" style="text-align:right;color:#9ca3af;font-weight:700;">Total Serviços:</td>
                        <td style="text-align:right;font-weight:800;color:#fbbf24;">
                            R$ <?= number_format($totals,2,',','.') ?>
                            <input type="hidden" id="total-servico" value="<?= number_format($totals,2) ?>">
                        </td>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>

    <!-- ══════════════════════════════
         TAB 5: ANEXOS
    ══════════════════════════════ -->
    <div class="eos-pane" id="eosTab5">
        <div class="eos-add-row" id="form-anexos">
            <form id="formAnexos" enctype="multipart/form-data" action="javascript:;" accept-charset="utf-8" method="post" style="display:flex;gap:10px;align-items:flex-end;flex-wrap:wrap;width:100%;">
                <input type="hidden" name="idOsServico" id="idOsServico" value="<?= $result->idOs ?>" />
                <div style="flex:1;min-width:200px;">
                    <label class="eos-label">Selecionar Arquivos</label>
                    <input type="file" name="userfile[]" multiple="multiple" id="userfile"
                        style="background:#13151f;border:1px solid #444860;color:#e8eaf0;border-radius:8px;padding:7px 12px;font-size:13px;width:100%;" />
                </div>
                <button type="submit" class="eos-btn eos-btn-success">
                    <i class='bx bx-paperclip'></i> Anexar
                </button>
            </form>
        </div>

        <div class="eos-tbl-wrap">
            <div class="eos-anexos-grid" id="divAnexos">
                <?php foreach ($anexos as $a):
                    if ($a->thumb == null) {
                        $thumb = base_url().'assets/img/icon-file.png';
                        $link  = base_url().'assets/img/icon-file.png';
                    } else {
                        $thumb = $a->url.'/thumbs/'.$a->thumb;
                        $link  = $a->url.'/'.$a->anexo;
                    }
                ?>
                <a href="#modal-anexo" imagem="<?= $a->idAnexos ?>" link="<?= $link ?>" role="button" class="eos-anexo-item anexo" data-toggle="modal">
                    <img src="<?= $thumb ?>" alt="">
                    <div class="eos-anexo-overlay"><i class='bx bx-show'></i></div>
                </a>
                <?php endforeach; ?>
                <?php if (!$anexos): ?>
                <div style="padding:24px;color:#6b7280;font-size:13px;width:100%;text-align:center;">
                    <i class='bx bx-paperclip' style="font-size:28px;display:block;margin-bottom:8px;opacity:.3;"></i>
                    Nenhum anexo cadastrado.
                </div>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <!-- ══════════════════════════════
         TAB 6: ANOTAÇÕES
    ══════════════════════════════ -->
    <div class="eos-pane" id="eosTab6">
        <div style="margin-bottom:12px;">
            <a href="#modal-anotacao" data-toggle="modal" class="eos-btn eos-btn-success">
                <i class='bx bx-plus'></i> Nova Anotação
            </a>
        </div>
        <div class="eos-tbl-wrap" id="divAnotacoes">
            <?php if ($anotacoes): foreach ($anotacoes as $a): ?>
            <div class="eos-anotacao-item">
                <div class="eos-anotacao-dot"></div>
                <div style="flex:1;">
                    <div class="eos-anotacao-text"><?= htmlspecialchars($a->anotacao) ?></div>
                    <div class="eos-anotacao-date"><?= date('d/m/Y H:i:s',strtotime($a->data_hora)) ?></div>
                </div>
                <button type="button" class="eos-tbl btn-del anotacao" idAcao="<?= $a->idAnotacoes ?>" title="Excluir">
                    <i class='bx bx-trash-alt'></i>
                </button>
            </div>
            <?php endforeach; else: ?>
            <div style="padding:24px;color:#6b7280;text-align:center;font-size:13px;">
                <i class='bx bx-note' style="font-size:28px;display:block;margin-bottom:8px;opacity:.3;"></i>
                Nenhuma anotação cadastrada.
            </div>
            <?php endif; ?>
        </div>
    </div>

</div><!-- /.eos-wrap -->

<!-- ── Modal Visualizar Anexo ── -->
<div id="modal-anexo" class="modal hide fade eos-modal" tabindex="-1" role="dialog">
    <div class="modal-header">
        <h4><i class='bx bx-image'></i> Visualizar Anexo</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
    </div>
    <div class="modal-body">
        <div id="div-visualizar-anexo" style="text-align:center;"></div>
    </div>
    <div class="modal-footer">
        <button class="md-btn-cancel" data-dismiss="modal"><i class='bx bx-x'></i> Fechar</button>
        <a href="" id-imagem="" class="md-btn-cancel" id="download" style="background:rgba(99,102,241,0.15);color:#a5b4fc;border-color:rgba(99,102,241,0.3);">
            <i class='bx bx-download'></i> Download
        </a>
        <a href="" link="" class="md-btn-save md-btn-danger" id="excluir-anexo">
            <i class='bx bx-trash'></i> Excluir
        </a>
    </div>
</div>

<!-- ── Modal Anotação ── -->
<div id="modal-anotacao" class="modal hide fade eos-modal" tabindex="-1" role="dialog">
    <form action="#" method="POST" id="formAnotacao">
        <div class="modal-header">
            <h4><i class='bx bx-note' style="color:#a78bfa;"></i> Nova Anotação</h4>
            <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        <div class="modal-body">
            <div id="divFormAnotacoes"></div>
            <div class="form-group">
                <label>Anotação *</label>
                <textarea name="anotacao" id="anotacao" rows="4"></textarea>
                <input type="hidden" name="os_id" value="<?= $result->idOs ?>">
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="md-btn-cancel" id="btn-close-anotacao" data-dismiss="modal"><i class='bx bx-x'></i> Cancelar</button>
            <button type="submit" class="md-btn-save md-btn-green"><i class='bx bx-plus'></i> Adicionar</button>
        </div>
    </form>
</div>

<!-- ── Modal Faturar ── -->
<div id="modal-faturar" class="modal hide fade eos-modal" tabindex="-1" role="dialog">
    <form id="formFaturar" action="<?= current_url() ?>" method="post">
        <div class="modal-header">
            <h4><i class='bx bx-dollar' style="color:#fbbf24;"></i> Faturar OS #<?= str_pad($result->idOs,4,'0',STR_PAD_LEFT) ?></h4>
            <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        <div class="modal-body">
            <div class="alert-info" style="margin-bottom:14px;">Campos com * são obrigatórios.</div>
            <div class="form-group">
                <label>Descrição</label>
                <input type="text" id="descricao" name="descricao" value="Fatura OS Nº: <?= $result->idOs ?>" />
            </div>
            <div class="form-group">
                <label>Cliente *</label>
                <input type="text" name="cliente" value="<?= htmlspecialchars($result->nomeCliente) ?>" />
                <input type="hidden" name="clientes_id" value="<?= $result->clientes_id ?>">
                <input type="hidden" name="os_id" value="<?= $result->idOs ?>">
                <input type="hidden" name="tipoDesconto" value="<?= $result->tipo_desconto ?>">
                <input type="hidden" name="tipo" value="receita">
            </div>
            <div style="display:grid;grid-template-columns:1fr 1fr;gap:12px;">
                <div class="form-group">
                    <label>Valor Total</label>
                    <input class="money" id="valor" name="valor" type="text" data-affixes-stay="true" data-thousands="" data-decimal="." value="<?= number_format($totalGeral,2,'.',') ?>" />
                </div>
                <div class="form-group">
                    <label>Valor com Desconto</label>
                    <input class="money" id="faturar-desconto" name="faturar-desconto" type="text" value="<?= number_format($result->valor_desconto,2,'.',') ?>" />
                </div>
                <div class="form-group">
                    <label>Data de Entrada *</label>
                    <input class="datepicker" autocomplete="off" id="vencimento" name="vencimento" type="text" />
                </div>
            </div>
            <div style="display:flex;align-items:center;gap:10px;padding:8px 0;">
                <input type="checkbox" id="recebido" name="recebido" value="1" style="width:16px;height:16px;accent-color:#6366f1;">
                <label style="font-size:13px;color:#c9cad6;font-weight:500;margin:0;text-transform:none;letter-spacing:0;">Já recebido?</label>
            </div>
            <div id="divRecebimento" style="display:none;margin-top:10px;">
                <div style="display:grid;grid-template-columns:1fr 1fr;gap:12px;">
                    <div class="form-group">
                        <label>Data Recebimento</label>
                        <input class="datepicker" autocomplete="off" id="recebimento" name="recebimento" type="text" />
                    </div>
                    <div class="form-group">
                        <label>Forma de Pagamento</label>
                        <select name="formaPgto" id="formaPgto">
                            <option value="Dinheiro">Dinheiro</option>
                            <option value="Pix">Pix</option>
                            <option value="Cartão de Crédito">Cartão de Crédito</option>
                            <option value="Cartão de Débito">Cartão de Débito</option>
                            <option value="Boleto">Boleto</option>
                            <option value="Depósito">Depósito</option>
                            <option value="Cheque">Cheque</option>
                        </select>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="md-btn-cancel" id="btn-cancelar-faturar" data-dismiss="modal"><i class='bx bx-x'></i> Cancelar</button>
            <button type="submit" class="md-btn-save md-btn-danger"><i class='bx bx-dollar'></i> Confirmar Faturamento</button>
        </div>
    </form>
</div>

<script>
$(document).ready(function() {
    // ── Tabs ───────────────────────────────────────────────
    $('.eos-tab').on('click', function() {
        var t = $(this).data('tab');
        $('.eos-tab').removeClass('active');
        $('.eos-pane').removeClass('active');
        $(this).addClass('active');
        $('#'+t).addClass('active');
    });

    // ── Datepicker ─────────────────────────────────────────
    $('.datepicker').datepicker({ dateFormat: 'dd/mm/yy' });

    // ── WYSIWYG dark ───────────────────────────────────────
    $('.editor').trumbowyg({ lang: 'pt_br', semantic: { 'strikethrough': 's' } });

    // ── MaskMoney ──────────────────────────────────────────
    $('.money').maskMoney();

    // ── Desconto ───────────────────────────────────────────
    function calcDesconto(valor, desconto, tipo) {
        return tipo === 'porcento' ? (valor - desconto * valor / 100).toFixed(2) : valor - desconto;
    }
    function validarDesconto(res, valor) {
        return res == valor ? '' : parseFloat(res).toFixed(2);
    }
    var valorBackup = $('#valorTotal').val();

    $('#tipoDesconto').on('change', function() {
        var res = calcDesconto(+$('#valorTotal').val(), +$('#desconto').val(), $(this).val());
        $('#resultado').val(validarDesconto(res, +$('#valorTotal').val()));
    });
    $('#desconto').keyup(function() {
        this.value = this.value.replace(/[^0-9.]/g,'');
        var res = calcDesconto(+$('#valorTotal').val(), +$(this).val(), $('#tipoDesconto').val());
        $('#resultado').val(validarDesconto(res, +$('#valorTotal').val()));
    });

    // ── Recebido toggle ────────────────────────────────────
    $('#recebido').on('change', function() {
        $(this).is(':checked') ? $('#divRecebimento').slideDown() : $('#divRecebimento').slideUp();
    });

    // ── Status → label dataFinal ───────────────────────────
    function atualizarDataFinal() {
        var s = $('#status').val();
        $('#dataFinalLabel').html(s==='Em Andamento' ? '<span style="color:#f87171;">*</span>' : '');
    }
    $('#status').on('change', atualizarDataFinal);
    atualizarDataFinal();

    // ── Autocompletes ──────────────────────────────────────
    $('#produto').autocomplete({
        source: '<?= base_url() ?>index.php/os/autoCompleteProduto', minLength: 2,
        select: function(e, ui) {
            $('#idProduto').val(ui.item.id);
            $('#estoque').val(ui.item.estoque);
            $('#preco').val(ui.item.preco);
            $('#quantidade').focus();
        }
    });
    $('#servico').autocomplete({
        source: '<?= base_url() ?>index.php/os/autoCompleteServico', minLength: 2,
        select: function(e, ui) { $('#idServico').val(ui.item.id); $('#preco_servico').val(ui.item.preco); $('#quantidade_servico').focus(); }
    });
    $('#cliente').autocomplete({
        source: '<?= base_url() ?>index.php/os/autoCompleteCliente', minLength: 2,
        select: function(e, ui) { $('#clientes_id').val(ui.item.id); }
    });
    $('#tecnico').autocomplete({
        source: '<?= base_url() ?>index.php/os/autoCompleteUsuario', minLength: 2,
        select: function(e, ui) { $('#usuarios_id').val(ui.item.id); }
    });
    $('#termoGarantia').autocomplete({
        source: '<?= base_url() ?>index.php/os/autoCompleteTermoGarantia', minLength: 1,
        select: function(e, ui) { if (ui.item.id) $('#garantias_id').val(ui.item.id); }
    });
    $('#termoGarantia').on('change', function() {
        if (!$(this).val() && $('#garantias_id').val()) {
            $('#garantias_id').val('');
            Swal.fire({ icon:'success', title:'Sucesso', text:'Termo de garantia removido' });
        }
    });

    // ── Validação formOs ───────────────────────────────────
    $('#formOs').validate({
        rules: {
            cliente:    { required: true },
            tecnico:    { required: true },
            dataInicial:{ required: true },
            dataFinal:  { required: function() { return $('#status').val()==='Em Andamento'; } }
        },
        messages: {
            cliente:    { required: 'Campo obrigatório.' },
            tecnico:    { required: 'Campo obrigatório.' },
            dataInicial:{ required: 'Campo obrigatório.' },
            dataFinal:  { required: 'Obrigatório quando status é Em Andamento.' }
        },
        submitHandler: function(form) {
            $('#btnContinuar').attr('disabled',true).html('<i class="bx bx-loader-alt bx-spin"></i> Salvando...');
            form.submit();
        }
    });

    // ── Desconto form ──────────────────────────────────────
    $('#formDesconto').on('submit', function(e) {
        e.preventDefault();
        $.ajax({
            url: $(this).attr('action'), type: 'POST', data: $(this).serialize(),
            beforeSend: function() { Swal.fire({ title:'Processando', text:'Aplicando desconto...', icon:'info', showConfirmButton:false, allowOutsideClick:false }); },
            success: function(res) {
                if (res.result) {
                    Swal.fire({ icon:'success', title:'Sucesso', text:res.messages });
                    setTimeout(function(){ window.location.href=window.BaseUrl+'index.php/os/editar/<?= $result->idOs ?>'; }, 1500);
                } else {
                    Swal.fire({ icon:'error', title:'Atenção', text:res.messages });
                }
            }
        });
    });

    // ── Faturar form ───────────────────────────────────────
    $('#formFaturar').validate({
        rules: { descricao:{required:true}, vencimento:{required:true} },
        submitHandler: function(form) {
            var qtd = $('#tblProdutos tbody tr').length + $('#tblServicos tbody tr').length;
            $('#btn-cancelar-faturar').trigger('click');
            if (qtd <= 0) {
                Swal.fire({ icon:'error', title:'Atenção', text:'Não é possível faturar sem produtos/serviços.' });
                return;
            }
            $.ajax({
                type:'POST', url:'<?= base_url() ?>index.php/os/faturar',
                data:$(form).serialize(), dataType:'json',
                success: function(d) {
                    if (d.result) window.location.reload(true);
                    else Swal.fire({ icon:'error', title:'Atenção', text:'Erro ao faturar OS.' });
                }
            });
        }
    });

    // ── Adicionar produto ──────────────────────────────────
    $('#formProdutos').validate({
        rules: { preco:{required:true}, quantidade:{required:true} },
        submitHandler: function(form) {
            var qtd = parseInt($('#quantidade').val());
            var est = parseInt($('#estoque').val());
            <?php if (!$configuration['control_estoque']) echo 'est = 1000000;'; ?>
            if (est < qtd) { Swal.fire({ icon:'error', title:'Atenção', text:'Estoque insuficiente.' }); return; }
            $('#divProdutos').html('<div style="padding:20px;text-align:center;color:#6b7280;"><i class=\'bx bx-loader-alt bx-spin\' style=\'font-size:24px;\'></i></div>');
            $.ajax({
                type:'POST', url:'<?= base_url() ?>index.php/os/adicionarProduto',
                data:$(form).serialize(), dataType:'json',
                success: function(d) {
                    if (d.result) {
                        $('#divProdutos').load('<?= current_url() ?> #divProdutos');
                        $('#divValorTotal').load('<?= current_url() ?> #divValorTotal');
                        $('#quantidade,#preco,#resultado,#desconto').val('');
                        $('#produto').val('').focus();
                    } else Swal.fire({ icon:'error', title:'Atenção', text:'Erro ao adicionar produto.' });
                }
            });
            return false;
        }
    });

    // ── Adicionar serviço ──────────────────────────────────
    $('#formServicos').validate({
        rules: { servico:{required:true}, preco:{required:true}, quantidade:{required:true} },
        submitHandler: function(form) {
            $('#divServicos').html('<div style="padding:20px;text-align:center;color:#6b7280;"><i class=\'bx bx-loader-alt bx-spin\' style=\'font-size:24px;\'></i></div>');
            $.ajax({
                type:'POST', url:'<?= base_url() ?>index.php/os/adicionarServico',
                data:$(form).serialize(), dataType:'json',
                success: function(d) {
                    if (d.result) {
                        $('#divServicos').load('<?= current_url() ?> #divServicos');
                        $('#divValorTotal').load('<?= current_url() ?> #divValorTotal');
                        $('#quantidade_servico,#preco_servico,#resultado,#desconto').val('');
                        $('#servico').val('').focus();
                    } else Swal.fire({ icon:'error', title:'Atenção', text:'Erro ao adicionar serviço.' });
                }
            });
            return false;
        }
    });

    // ── Adicionar anotação ─────────────────────────────────
    $('#formAnotacao').validate({
        rules: { anotacao:{required:true} },
        submitHandler: function(form) {
            $('#divFormAnotacoes').html('<div style="padding:10px;text-align:center;"><i class=\'bx bx-loader-alt bx-spin\'></i></div>');
            $.ajax({
                type:'POST', url:'<?= base_url() ?>index.php/os/adicionarAnotacao',
                data:$(form).serialize(), dataType:'json',
                success: function(d) {
                    if (d.result) {
                        $('#divAnotacoes').load('<?= current_url() ?> #divAnotacoes');
                        $('#anotacao').val('');
                        $('#btn-close-anotacao').trigger('click');
                        $('#divFormAnotacoes').html('');
                    } else Swal.fire({ icon:'error', title:'Atenção', text:'Erro ao adicionar anotação.' });
                }
            });
            return false;
        }
    });

    // ── Upload anexo ───────────────────────────────────────
    $('#formAnexos').validate({
        submitHandler: function(form) {
            var dados = new FormData(form);
            $('#form-anexos').hide();
            $('#divAnexos').html('<div style="padding:20px;text-align:center;"><i class=\'bx bx-loader-alt bx-spin\' style=\'font-size:24px;\'></i></div>');
            $.ajax({
                type:'POST', url:'<?= base_url() ?>index.php/os/anexar',
                data:dados, mimeType:'multipart/form-data', contentType:false, cache:false, processData:false, dataType:'json',
                success: function(d) {
                    if (d.result) { $('#divAnexos').load('<?= current_url() ?> #divAnexos'); }
                    else { $('#divAnexos').html('<div style="color:#f87171;padding:14px;">'+d.mensagem+'</div>'); }
                },
                error: function() { $('#divAnexos').html('<div style="color:#f87171;padding:14px;">Erro ao enviar arquivo.</div>'); }
            });
            $('#form-anexos').show();
            return false;
        }
    });

    // ── Excluir produto ────────────────────────────────────
    $(document).on('click', 'button.btn-nwe4:not(.servico):not(.anotacao)', function() {
        var idP = $(this).attr('idAcao'), qtd = $(this).attr('quantAcao'), prod = $(this).attr('prodAcao');
        var idOS = '<?= $result->idOs ?>';
        if (idP % 1 === 0) {
            $('#divProdutos').html('<div style="padding:20px;text-align:center;"><i class=\'bx bx-loader-alt bx-spin\' style=\'font-size:24px;\'></i></div>');
            $.ajax({
                type:'POST', url:'<?= base_url() ?>index.php/os/excluirProduto',
                data:'idProduto='+idP+'&quantidade='+qtd+'&produto='+prod+'&idOs='+idOS, dataType:'json',
                success: function(d) {
                    if (d.result) { $('#divProdutos').load('<?= current_url() ?> #divProdutos'); $('#divValorTotal').load('<?= current_url() ?> #divValorTotal'); }
                    else Swal.fire({ icon:'error', title:'Atenção', text:'Erro ao excluir produto.' });
                }
            });
        }
    });

    // ── Excluir serviço ────────────────────────────────────
    $(document).on('click', 'button.servico', function() {
        var idS = $(this).attr('idAcao'), idOS = '<?= $result->idOs ?>';
        $('#divServicos').html('<div style="padding:20px;text-align:center;"><i class=\'bx bx-loader-alt bx-spin\' style=\'font-size:24px;\'></i></div>');
        $.ajax({
            type:'POST', url:'<?= base_url() ?>index.php/os/excluirServico',
            data:'idServico='+idS+'&idOs='+idOS, dataType:'json',
            success: function(d) {
                if (d.result) { $('#divServicos').load('<?= current_url() ?> #divServicos'); $('#divValorTotal').load('<?= current_url() ?> #divValorTotal'); }
                else Swal.fire({ icon:'error', title:'Atenção', text:'Erro ao excluir serviço.' });
            }
        });
    });

    // ── Excluir anotação ───────────────────────────────────
    $(document).on('click', 'button.anotacao', function() {
        var idA = $(this).attr('idAcao'), idOS = '<?= $result->idOs ?>';
        $('#divAnotacoes').html('<div style="padding:20px;text-align:center;"><i class=\'bx bx-loader-alt bx-spin\' style=\'font-size:24px;\'></i></div>');
        $.ajax({
            type:'POST', url:'<?= base_url() ?>index.php/os/excluirAnotacao',
            data:'idAnotacao='+idA+'&idOs='+idOS, dataType:'json',
            success: function(d) {
                if (d.result) $('#divAnotacoes').load('<?= current_url() ?> #divAnotacoes');
                else Swal.fire({ icon:'error', title:'Atenção', text:'Erro ao excluir anotação.' });
            }
        });
    });

    // ── Visualizar/excluir anexo ───────────────────────────
    $(document).on('click', '.anexo', function(e) {
        e.preventDefault();
        var link = $(this).attr('link'), id = $(this).attr('imagem');
        $('#div-visualizar-anexo').html('<img src="'+link+'" style="max-width:100%;border-radius:8px;" alt="">');
        $('#excluir-anexo').attr('link','<?= base_url() ?>index.php/os/excluirAnexo/'+id);
        $('#download').attr('href','<?= base_url() ?>index.php/os/downloadanexo/'+id);
    });
    $(document).on('click', '#excluir-anexo', function(e) {
        e.preventDefault();
        var link = $(this).attr('link'), idOS = '<?= $result->idOs ?>';
        $('#modal-anexo').modal('hide');
        $('#divAnexos').html('<div style="padding:20px;text-align:center;"><i class=\'bx bx-loader-alt bx-spin\' style=\'font-size:24px;\'></i></div>');
        $.ajax({
            type:'POST', url:link, dataType:'json', data:'idOs='+idOS,
            success: function(d) {
                if (d.result) $('#divAnexos').load('<?= current_url() ?> #divAnexos');
                else Swal.fire({ icon:'error', title:'Atenção', text:d.mensagem });
            }
        });
    });

    // ── Qtd input only numbers ─────────────────────────────
    $('#quantidade,#quantidade_servico').on('keyup', function() {
        this.value = this.value.replace(/[^0-9]/g,'');
    });
});
</script>
