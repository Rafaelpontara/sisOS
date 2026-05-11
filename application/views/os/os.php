<link rel="stylesheet" href="<?php echo base_url(); ?>assets/js/jquery-ui/css/smoothness/jquery-ui-1.9.2.custom.css" />
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/table-custom.css" />
<script src="<?php echo base_url() ?>assets/js/jquery-ui/js/jquery-ui-1.9.2.custom.js"></script>
<script src="<?php echo base_url() ?>assets/js/sweetalert2.all.min.js"></script>
<style>
.pg-header{display:flex;justify-content:space-between;align-items:center;margin-bottom:20px;flex-wrap:wrap;gap:10px;}
.pg-title{font-size:22px;font-weight:800;color:#e8eaf0;display:flex;align-items:center;gap:10px;}
.pg-title i{font-size:24px;color:#f97316;}
.pg-actions{display:flex;gap:8px;align-items:center;flex-wrap:wrap;}
.btn-add{display:flex;align-items:center;gap:7px;padding:9px 16px;border-radius:8px;background:linear-gradient(135deg,#22c55e,#16a34a);color:#fff;font-size:13px;font-weight:700;text-decoration:none;border:none;cursor:pointer;box-shadow:0 4px 14px rgba(34,197,94,0.3);transition:transform .15s;}
.btn-add:hover{transform:translateY(-2px);color:#fff;}
.btn-entrega{display:flex;align-items:center;gap:7px;padding:9px 14px;border-radius:8px;background:rgba(96,165,250,0.15);color:#60a5fa;font-size:13px;font-weight:700;text-decoration:none;border:1px solid rgba(96,165,250,0.25);transition:all .15s;}
.btn-entrega:hover{background:rgba(96,165,250,0.25);color:#60a5fa;}
.filter-bar{display:flex;gap:6px;align-items:center;flex-wrap:wrap;margin-bottom:14px;padding:12px 16px;background:#1a1d2e;border:1px solid rgba(255,255,255,0.07);border-radius:14px;}
.filter-bar input,.filter-bar select{padding:8px 10px;border-radius:7px;border:1px solid #444860;background:#252a3a;color:#e8eaf0;font-size:13px;}
.filter-bar input:focus,.filter-bar select:focus{outline:none;border-color:#f97316;}
.btn-filter{padding:8px 18px;border-radius:7px;background:#f97316;border:none;color:#fff;font-size:13px;font-weight:700;cursor:pointer;transition:background .15s;}
.btn-filter:hover{background:#ea6a00;}
.tbl-wrap{background:#1a1d2e;border:1px solid rgba(255,255,255,0.07);border-radius:14px;overflow:hidden;margin-bottom:14px;}
.tbl-toolbar{display:flex;align-items:center;justify-content:space-between;padding:12px 16px;border-bottom:1px solid rgba(255,255,255,0.06);flex-wrap:wrap;gap:8px;}
.tbl-tl{font-size:12px;color:#6b7280;display:flex;align-items:center;gap:8px;}
.tbl-tl select{background:#252a3a;border:1px solid #444860;color:#e8eaf0;padding:4px 8px;border-radius:6px;font-size:12px;}
.tbl-ts input{background:#252a3a;border:1px solid #444860;color:#e8eaf0;padding:6px 10px;border-radius:6px;font-size:12px;width:180px;}
.tbl-wrap table{width:100%;border-collapse:collapse;}
.tbl-wrap thead th{background:#252a3a;color:#9ca3af;font-size:11px;font-weight:700;text-transform:uppercase;letter-spacing:.5px;padding:11px 12px;border-bottom:1px solid rgba(255,255,255,0.07);white-space:nowrap;}
.tbl-wrap tbody tr{border-bottom:1px solid rgba(255,255,255,0.04);transition:background .12s;}
.tbl-wrap tbody tr:hover{background:rgba(249,115,22,0.04);}
.tbl-wrap tbody td{padding:10px 12px;font-size:13px;color:#c9cad6;vertical-align:middle;}
.act-btns{display:flex;gap:4px;}
.act-btn{width:28px;height:28px;border-radius:6px;display:inline-flex;align-items:center;justify-content:center;font-size:14px;text-decoration:none;transition:background .15s,transform .12s;border:none;cursor:pointer;}
.act-btn:hover{transform:scale(1.1);}
.ab-v{background:rgba(96,165,250,0.15);color:#60a5fa;}.ab-v:hover{background:rgba(96,165,250,0.3);color:#60a5fa;}
.ab-p{background:rgba(167,139,250,0.15);color:#a78bfa;}.ab-p:hover{background:rgba(167,139,250,0.3);color:#a78bfa;}
.ab-e{background:rgba(34,197,94,0.15);color:#4ade80;}.ab-e:hover{background:rgba(34,197,94,0.3);color:#4ade80;}
.ab-d{background:rgba(239,68,68,0.15);color:#f87171;}.ab-d:hover{background:rgba(239,68,68,0.3);color:#f87171;}
.sp{padding:3px 9px;border-radius:20px;font-size:11px;font-weight:700;display:inline-block;}
.sp-ab{background:rgba(96,165,250,0.15);color:#60a5fa;}
.sp-fi{background:rgba(34,197,94,0.15);color:#4ade80;}
.sp-ca{background:rgba(239,68,68,0.15);color:#f87171;}
.sp-or{background:rgba(245,158,11,0.15);color:#fbbf24;}
.sp-an{background:rgba(167,139,250,0.15);color:#a78bfa;}
.sp-ot{background:rgba(255,255,255,0.08);color:#9ca3af;}
#tabela_length,.dataTables_length,#tabela_info,.dataTables_info,#tabela_filter,.dataTables_filter,.dataTables_paginate{display:none!important;}
</style>

<div class="new122">
    <div class="pg-header">
        <div class="pg-title"><i class='bx bx-file-blank'></i> Ordens de Serviço</div>
        <div class="pg-actions">
            <?php if ($this->permission->checkPermission($this->session->userdata('permissao'), 'aOs')): ?>
            <a href="<?= base_url() ?>index.php/os/adicionar" class="btn-add"><i class='bx bx-plus-circle'></i> Nova OS</a>
            <?php endif; ?>
            <a href="<?= site_url('os/gerenciar?entrega_hoje=1') ?>" class="btn-entrega"><i class='bx bx-calendar-check'></i> Entregas Hoje</a>
        </div>
    </div>

    <!-- Filtros -->
    <form method="get" action="<?= base_url() ?>index.php/os/gerenciar" class="filter-bar">
        <input type="text" name="pesquisa" placeholder="Cliente ou Nº OS..." value="<?= $this->input->get('pesquisa') ?>" style="width:180px;">
        <select name="status">
            <option value="">Todos os Status</option>
            <?php foreach(["Aberto","Orçamento","Negociação","Aprovado","Aguardando Peças","Em Andamento","Aguardando Autorização","Em Teste","Finalizado","Faturado","Sem Conserto","Não foi Possível","Não temos Peças","Recusado","Cancelado"] as $s): ?>
            <option value="<?=$s?>" <?=$this->input->get('status')==$s?'selected':''?>><?=$s?></option>
            <?php endforeach; ?>
        </select>
        <input type="text" name="data" autocomplete="off" class="datepicker" placeholder="Data inicial" value="<?= $this->input->get('data') ?>" style="width:130px;">
        <input type="text" name="data2" autocomplete="off" class="datepicker" placeholder="Data final" value="<?= $this->input->get('data2') ?>" style="width:130px;">
        <button type="submit" class="btn-filter"><i class='bx bx-filter-alt'></i> Filtrar</button>
    </form>

    <div class="tbl-wrap">
        <div class="tbl-toolbar">
            <div class="tbl-tl">
                Exibir <select onchange="fs(this.value)"><option>10</option><option>25</option><option>50</option><option>100</option></select>
                registros &nbsp;·&nbsp; <span style="color:#e8eaf0;font-weight:600;"><?= isset($results) ? count($results) : 0 ?> OS</span>
            </div>
            <div class="tbl-ts"><input type="text" placeholder="Filtrar..." oninput="ft(this.value)"></div>
        </div>
        <table id="tabela" class="table">
            <thead>
                <tr>
                    <th>#</th><th>Cliente</th><th>Técnico</th><th>Data</th>
                    <th>Venc. Garantia</th><th>Total</th><th>Desconto</th>
                    <th>C/ Desconto</th><th>Faturado</th><th>Status</th><th>Ações</th>
                </tr>
            </thead>
            <tbody>
            <?php
            if (!isset($results) || !$results) {
                echo '<tr><td colspan="11" style="text-align:center;padding:40px;color:#6b7280;"><i class="bx bx-file-blank" style="font-size:40px;display:block;margin-bottom:8px;opacity:.3;"></i>Nenhuma OS encontrada</td></tr>';
            } else {
                foreach ($results as $r) {
                    $dataInicial = $r->dataInicial ? date('d/m/Y', strtotime($r->dataInicial)) : '-';
                    $dataFinal   = $r->dataFinal   ? date('d/m/Y', strtotime($r->dataFinal))   : '-';
                    $hoje = date('Y-m-d');
                    if ($r->dataFinal && $r->dataFinal < $hoje && !in_array($r->status, ['Finalizado','Cancelado','Faturado'])) {
                        $corGarantia = '#ef4444'; $vencGarantia = 'VENCIDA';
                    } elseif ($r->dataFinal) {
                        $corGarantia = '#22c55e'; $vencGarantia = $dataFinal;
                    } else {
                        $corGarantia = '#6b7280'; $vencGarantia = 'Sem prazo';
                    }
                    $spMap = ['Aberto'=>'ab','Orçamento'=>'or','Finalizado'=>'fi','Faturado'=>'fi','Cancelado'=>'ca','Recusado'=>'ca','Em Andamento'=>'an','Aprovado'=>'an'];
                    $spC = isset($spMap[$r->status]) ? 'sp-'.$spMap[$r->status] : 'sp-ot';
                    echo '<tr>';
                    echo '<td style="color:#6b7280;font-size:12px;">' . $r->idOs . '</td>';
                    echo '<td><a href="' . base_url() . 'index.php/clientes/visualizar/' . $r->idClientes . '" style="color:#e8eaf0;font-weight:600;text-decoration:none;">' . htmlspecialchars($r->nomeCliente) . '</a></td>';
                    echo '<td style="color:#9ca3af;font-size:12px;">' . htmlspecialchars($r->nome) . '</td>';
                    echo '<td style="font-size:12px;">' . $dataInicial . '</td>';
                    echo '<td><span style="color:' . $corGarantia . ';font-size:12px;">' . $vencGarantia . '</span></td>';
                    echo '<td style="font-weight:600;">R$ ' . number_format($r->totalProdutos + $r->totalServicos, 2, ',', '.') . '</td>';
                    echo '<td style="color:#f87171;">R$ ' . number_format(floatval($r->desconto), 2, ',', '.') . '</td>';
                    echo '<td style="font-weight:600;color:#e8eaf0;">R$ ' . number_format(floatval($r->valor_desconto), 2, ',', '.') . '</td>';
                    echo '<td style="color:#4ade80;">R$ ' . number_format($r->faturado ? floatval($r->valor_desconto) : 0, 2, ',', '.') . '</td>';
                    echo '<td><span class="sp ' . $spC . '">' . $r->status . '</span></td>';
                    echo '<td><div class="act-btns">';
                    if ($this->permission->checkPermission($this->session->userdata('permissao'), 'vOs')) {
                        echo '<a href="' . base_url() . 'index.php/os/visualizar/' . $r->idOs . '" class="act-btn ab-v" title="Ver"><i class="bx bx-show"></i></a>';
                        echo '<a href="' . base_url() . 'index.php/os/imprimir/' . $r->idOs . '" target="_blank" class="act-btn ab-p" title="Imprimir A4"><i class="bx bx-printer"></i></a>';
                        echo '<a href="' . base_url() . 'index.php/os/imprimirTermica/' . $r->idOs . '" target="_blank" class="act-btn" style="background:rgba(6,182,212,0.15);color:#22d3ee;border-radius:8px;width:32px;height:32px;display:inline-flex;align-items:center;justify-content:center;" title="Cupom 80mm"><i class="bx bx-receipt"></i></a>';
                    }
                    if ($this->permission->checkPermission($this->session->userdata('permissao'), 'eOs')) {
                        echo '<a href="' . base_url() . 'index.php/os/editar/' . $r->idOs . '" class="act-btn ab-e" title="Editar"><i class="bx bx-edit"></i></a>';
                    }
                    if ($this->permission->checkPermission($this->session->userdata('permissao'), 'dOs')) {
                        echo '<a href="#modal-excluir" role="button" data-toggle="modal" os="' . $r->idOs . '" class="act-btn ab-d" title="Excluir"><i class="bx bx-trash-alt"></i></a>';
                    }
                    echo '</div></td></tr>';
                }
            } ?>
            </tbody>
        </table>
    </div>
    <?= $this->pagination->create_links() ?>
</div>

<!-- Modal Excluir -->
<div id="modal-excluir" class="modal hide fade" tabindex="-1">
    <form action="<?= base_url() ?>index.php/os/excluir" method="post">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h5><i class='bx bx-trash' style="color:#f87171;"></i> Excluir OS</h5>
        </div>
        <div class="modal-body" style="text-align:center;padding:20px;">
            <div style="width:60px;height:60px;background:rgba(239,68,68,0.15);border-radius:50%;display:flex;align-items:center;justify-content:center;margin:0 auto 14px;">
                <i class='bx bx-file-blank' style="font-size:28px;color:#f87171;"></i>
            </div>
            <p style="color:#e8eaf0;font-weight:600;">Deseja excluir esta OS?</p>
            <input type="hidden" id="idOS" name="id" value="">
        </div>
        <div class="modal-footer" style="display:flex;justify-content:center;gap:10px;">
            <button type="button" class="button btn btn-warning" data-dismiss="modal"><span class="button__icon"><i class="bx bx-x"></i></span><span class="button__text2">Cancelar</span></button>
            <button type="submit" class="button btn btn-danger"><span class="button__icon"><i class='bx bx-trash'></i></span><span class="button__text2">Excluir</span></button>
        </div>
    </form>
</div>

<script>
function ft(q){q=q.toLowerCase();$("#tabela tbody tr").each(function(){$(this).toggle($(this).text().toLowerCase().indexOf(q)>-1);});}
function fs(n){var i=0;$("#tabela tbody tr").each(function(){i++;$(this).toggle(i<=parseInt(n));});}
$(document).ready(function(){
    $(document).on("click","a[os]",function(){$("#idOS").val($(this).attr("os"));});
});
</script>
