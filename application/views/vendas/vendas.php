<style>
.pg-header{display:flex;justify-content:space-between;align-items:center;margin-bottom:16px;flex-wrap:wrap;gap:10px;}
.pg-title{font-size:22px;font-weight:800;color:#e8eaf0;display:flex;align-items:center;gap:10px;}
.pg-title i{font-size:24px;color:#a78bfa;}
.btn-add{display:flex;align-items:center;gap:7px;padding:9px 16px;border-radius:8px;background:linear-gradient(135deg,#22c55e,#16a34a);color:#fff;font-size:13px;font-weight:700;text-decoration:none;border:none;box-shadow:0 4px 14px rgba(34,197,94,0.3);transition:transform .15s;}
.btn-add:hover{transform:translateY(-2px);color:#fff;}
.filter-bar{display:flex;gap:6px;align-items:center;flex-wrap:wrap;margin-bottom:14px;padding:12px 16px;background:#1a1d2e;border:1px solid rgba(255,255,255,0.07);border-radius:14px;}
.filter-bar input,.filter-bar select{padding:8px 10px;border-radius:7px;border:1px solid #444860;background:#252a3a;color:#e8eaf0;font-size:13px;}
.filter-bar input:focus,.filter-bar select:focus{outline:none;border-color:#a78bfa;}
.btn-filter{padding:8px 18px;border-radius:7px;background:#a78bfa;border:none;color:#fff;font-size:13px;font-weight:700;cursor:pointer;}
.tbl-wrap{background:#1a1d2e;border:1px solid rgba(255,255,255,0.07);border-radius:14px;overflow:hidden;margin-bottom:14px;}
.tbl-wrap table{width:100%;border-collapse:collapse;}
.tbl-wrap thead th{background:#252a3a;color:#9ca3af;font-size:11px;font-weight:700;text-transform:uppercase;letter-spacing:.5px;padding:11px 12px;border-bottom:1px solid rgba(255,255,255,0.07);white-space:nowrap;}
.tbl-wrap tbody tr{border-bottom:1px solid rgba(255,255,255,0.04);transition:background .12s;}
.tbl-wrap tbody tr:hover{background:rgba(167,139,250,0.04);}
.tbl-wrap tbody td{padding:10px 12px;font-size:13px;color:#c9cad6;vertical-align:middle;}
.act-btns{display:flex;gap:4px;}
.act-btn{width:28px;height:28px;border-radius:6px;display:inline-flex;align-items:center;justify-content:center;font-size:14px;text-decoration:none;transition:background .15s,transform .12s;border:none;cursor:pointer;}
.act-btn:hover{transform:scale(1.1);}
.ab-v{background:rgba(96,165,250,0.15);color:#60a5fa;}.ab-v:hover{background:rgba(96,165,250,0.3);color:#60a5fa;}
.ab-e{background:rgba(34,197,94,0.15);color:#4ade80;}.ab-e:hover{background:rgba(34,197,94,0.3);color:#4ade80;}
.ab-d{background:rgba(239,68,68,0.15);color:#f87171;}.ab-d:hover{background:rgba(239,68,68,0.3);color:#f87171;}
.ab-p{background:rgba(167,139,250,0.15);color:#a78bfa;}.ab-p:hover{background:rgba(167,139,250,0.3);color:#a78bfa;}
.sp{padding:3px 9px;border-radius:20px;font-size:11px;font-weight:700;display:inline-block;}
.sp-ab{background:rgba(96,165,250,0.15);color:#60a5fa;}.sp-fi{background:rgba(34,197,94,0.15);color:#4ade80;}
.sp-ca{background:rgba(239,68,68,0.15);color:#f87171;}.sp-or{background:rgba(245,158,11,0.15);color:#fbbf24;}
.sp-ot{background:rgba(255,255,255,0.08);color:#9ca3af;}
#tabela_length,.dataTables_length,#tabela_info,.dataTables_info,#tabela_filter,.dataTables_filter,.dataTables_paginate{display:none!important;}
</style>

<div class="new122">
    <div class="pg-header">
        <div class="pg-title"><i class='bx bx-cart-alt'></i> Vendas</div>
        <?php if ($this->permission->checkPermission($this->session->userdata('permissao'), 'aVenda')): ?>
        <a href="<?= base_url() ?>index.php/vendas/adicionar" class="btn-add"><i class='bx bx-plus-circle'></i> Nova Venda</a>
        <?php endif; ?>
    </div>

    <form method="get" action="<?= base_url() ?>index.php/vendas" class="filter-bar">
        <input type="text" name="pesquisa" placeholder="Nome do cliente..." value="<?= $this->input->get('pesquisa') ?>" style="width:200px;">
        <select name="status">
            <option value="">Todos os status</option>
            <?php foreach(["Orçamento","Aberto","Faturado","Em Andamento","Finalizado","Cancelado","Aguardando Peças","Aprovado"] as $s): ?>
            <option value="<?=$s?>" <?=$this->input->get('status')==$s?'selected':''?>><?=$s?></option>
            <?php endforeach; ?>
        </select>
        <input type="date" name="data" value="<?= $this->input->get('data') ?>" style="width:140px;">
        <input type="date" name="data2" value="<?= $this->input->get('data2') ?>" style="width:140px;">
        <button type="submit" class="btn-filter"><i class='bx bx-filter-alt'></i> Filtrar</button>
    </form>

    <div class="tbl-wrap">
        <table id="tabela" class="table">
            <thead>
                <tr>
                    <th>#</th><th>Cliente</th><th>Vendedor</th><th>Produto(s)</th>
                    <th>Data</th><th>Venc. Garantia</th><th>Total</th><th>Desconto</th>
                    <th>C/ Desconto</th><th>Faturado</th><th>Status</th><th>Ações</th>
                </tr>
            </thead>
            <tbody>
            <?php
            if (!isset($results) || !$results) {
                echo '<tr><td colspan="12" style="text-align:center;padding:40px;color:#6b7280;">Nenhuma venda cadastrada</td></tr>';
            } else {
                foreach ($results as $r) {
                    $spMap = ['Aberto'=>'sp-ab','Orçamento'=>'sp-or','Finalizado'=>'sp-fi','Faturado'=>'sp-fi','Cancelado'=>'sp-ca'];
                    $spC = $spMap[$r->status] ?? 'sp-ot';
                    echo '<tr>';
                    echo '<td style="color:#6b7280;font-size:12px;">' . $r->idVendas . '</td>';
                    echo '<td style="font-weight:600;color:#e8eaf0;">' . htmlspecialchars($r->nomeCliente ?? '-') . '</td>';
                    echo '<td style="color:#9ca3af;font-size:12px;">' . htmlspecialchars($r->tecnico ?? '-') . '</td>';
                    echo '<td style="font-size:12px;color:#9ca3af;">' . htmlspecialchars(mb_substr($r->produtos ?? '-', 0, 30)) . '</td>';
                    echo '<td style="font-size:12px;">' . ($r->dataVenda ? date('d/m/Y', strtotime($r->dataVenda)) : '-') . '</td>';
                    echo '<td style="font-size:12px;">' . ($r->vencGarantia ?? '-') . '</td>';
                    echo '<td style="font-weight:600;">R$ ' . number_format(floatval($r->totalProdutos), 2, ',', '.') . '</td>';
                    echo '<td style="color:#f87171;">R$ ' . number_format(floatval($r->desconto), 2, ',', '.') . '</td>';
                    echo '<td style="font-weight:600;color:#e8eaf0;">R$ ' . number_format(floatval($r->valor_desconto), 2, ',', '.') . '</td>';
                    echo '<td style="color:#4ade80;">R$ ' . number_format($r->faturado ? floatval($r->valor_desconto) : 0, 2, ',', '.') . '</td>';
                    echo '<td><span class="sp ' . $spC . '">' . $r->status . '</span></td>';
                    echo '<td><div class="act-btns">';
                    if ($this->permission->checkPermission($this->session->userdata('permissao'), 'vVenda'))
                        echo '<a href="' . base_url() . 'index.php/vendas/visualizar/' . $r->idVendas . '" class="act-btn ab-v" title="Ver"><i class="bx bx-show"></i></a>';
                    if ($this->permission->checkPermission($this->session->userdata('permissao'), 'eVenda'))
                        echo '<a href="' . base_url() . 'index.php/vendas/editar/' . $r->idVendas . '" class="act-btn ab-e" title="Editar"><i class="bx bx-edit"></i></a>';
                    if ($this->permission->checkPermission($this->session->userdata('permissao'), 'dVenda'))
                        echo '<a href="#modal-excluir" role="button" data-toggle="modal" venda="' . $r->idVendas . '" class="act-btn ab-d" title="Excluir"><i class="bx bx-trash-alt"></i></a>';
                    echo '</div></td></tr>';
                }
            } ?>
            </tbody>
        </table>
    </div>
    <?= $this->pagination->create_links() ?>
</div>
<!-- Modal -->
<div id="modal-excluir" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <form action="<?php echo base_url() ?>index.php/vendas/excluir" method="post">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            <h5 id="myModalLabel">Excluir Venda</h5>
        </div>
        <div class="modal-body">
            <input type="hidden" id="idVenda" name="id" value="" />
            <h5 style="text-align: center">Deseja realmente excluir esta Venda?</h5>
        </div>
        <div class="modal-footer" style="display:flex;justify-content: center">
            <button class="button btn btn-warning" data-dismiss="modal" aria-hidden="true">
              <span class="button__icon"><i class="bx bx-x"></i></span><span class="button__text2">Cancelar</span></button>
            <button class="button btn btn-danger"><span class="button__icon"><i class='bx bx-trash'></i></span> <span class="button__text2">Excluir</span></button>
        </div>
    </form>
</div>

<script type="text/javascript">
    $(document).ready(function() {
        $(document).on('click', 'a', function(event) {
            var venda = $(this).attr('venda');
            $('#idVenda').val(venda);
        });
    });
</script>
