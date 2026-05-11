<style>
.pg-header{display:flex;justify-content:space-between;align-items:center;margin-bottom:20px;}
.pg-title{font-size:22px;font-weight:800;color:#e8eaf0;display:flex;align-items:center;gap:10px;}
.pg-title i{font-size:24px;color:#34d399;}
.btn-add{display:flex;align-items:center;gap:7px;padding:9px 16px;border-radius:8px;background:linear-gradient(135deg,#22c55e,#16a34a);color:#fff;font-size:13px;font-weight:700;text-decoration:none;border:none;box-shadow:0 4px 14px rgba(34,197,94,0.3);transition:transform .15s;}
.btn-add:hover{transform:translateY(-2px);color:#fff;}
.tbl-wrap{background:#1a1d2e;border:1px solid rgba(255,255,255,0.07);border-radius:14px;overflow:hidden;margin-bottom:14px;}
.tbl-wrap table{width:100%;border-collapse:collapse;}
.tbl-wrap thead th{background:#252a3a;color:#9ca3af;font-size:11px;font-weight:700;text-transform:uppercase;letter-spacing:.5px;padding:11px 14px;border-bottom:1px solid rgba(255,255,255,0.07);white-space:nowrap;}
.tbl-wrap tbody tr{border-bottom:1px solid rgba(255,255,255,0.04);transition:background .12s;}
.tbl-wrap tbody tr:hover{background:rgba(52,211,153,0.04);}
.tbl-wrap tbody td{padding:11px 14px;font-size:13px;color:#c9cad6;vertical-align:middle;}
.act-btns{display:flex;gap:5px;}
.act-btn{width:30px;height:30px;border-radius:7px;display:inline-flex;align-items:center;justify-content:center;font-size:15px;text-decoration:none;transition:background .15s,transform .12s;border:none;cursor:pointer;}
.act-btn:hover{transform:scale(1.1);}
.ab-v{background:rgba(96,165,250,0.15);color:#60a5fa;}.ab-v:hover{background:rgba(96,165,250,0.3);color:#60a5fa;}
.ab-e{background:rgba(34,197,94,0.15);color:#4ade80;}.ab-e:hover{background:rgba(34,197,94,0.3);color:#4ade80;}
.ab-d{background:rgba(239,68,68,0.15);color:#f87171;}.ab-d:hover{background:rgba(239,68,68,0.3);color:#f87171;}
.ab-p{background:rgba(167,139,250,0.15);color:#a78bfa;}.ab-p:hover{background:rgba(167,139,250,0.3);color:#a78bfa;}
#tabela_length,.dataTables_length,#tabela_info,.dataTables_info,#tabela_filter,.dataTables_filter,.dataTables_paginate{display:none!important;}
</style>
<div class="new122">
    <div class="pg-header">
        <div class="pg-title"><i class='bx bx-shield-check'></i> Termos de Garantia</div>
        <?php if ($this->permission->checkPermission($this->session->userdata('permissao'), 'aGarantia')): ?>
        <a href="<?= base_url() ?>index.php/garantias/adicionar" class="btn-add"><i class='bx bx-plus-circle'></i> Novo Termo</a>
        <?php endif; ?>
    </div>
    <div class="tbl-wrap">
        <table id="tabela" class="table">
            <thead><tr><th>#</th><th>Data</th><th>Ref. Garantia</th><th>Termo de Garantia</th><th>Usuário</th><th>Ações</th></tr></thead>
            <tbody>
            <?php if (!$results): ?>
            <tr><td colspan="6" style="text-align:center;padding:40px;color:#6b7280;">Nenhum termo cadastrado</td></tr>
            <?php else: foreach ($results as $r): ?>
            <tr>
                <td style="color:#6b7280;font-size:12px;"><?= $r->idGarantias ?></td>
                <td style="font-size:12px;"><?= date('d/m/Y', strtotime($r->dataGarantia)) ?></td>
                <td style="font-weight:600;color:#e8eaf0;"><?= htmlspecialchars($r->refGarantia) ?></td>
                <td style="max-width:300px;overflow:hidden;text-overflow:ellipsis;white-space:nowrap;color:#9ca3af;font-size:12px;"><?= strip_tags($r->textoGarantia) ?></td>
                <td style="font-size:12px;color:#9ca3af;"><?= htmlspecialchars($r->usuarios_id) ?></td>
                <td><div class="act-btns">
                    <?php if ($this->permission->checkPermission($this->session->userdata('permissao'), 'vGarantia')): ?>
                    <a href="<?= base_url() ?>index.php/garantias/visualizar/<?= $r->idGarantias ?>" class="act-btn ab-v" title="Ver"><i class='bx bx-show'></i></a>
                    <a href="<?= base_url() ?>index.php/garantias/imprimir/<?= $r->idGarantias ?>" target="_blank" class="act-btn ab-p" title="Imprimir"><i class='bx bx-printer'></i></a>
                    <?php endif; ?>
                    <?php if ($this->permission->checkPermission($this->session->userdata('permissao'), 'eGarantia')): ?>
                    <a href="<?= base_url() ?>index.php/garantias/editar/<?= $r->idGarantias ?>" class="act-btn ab-e" title="Editar"><i class='bx bx-edit'></i></a>
                    <?php endif; ?>
                    <?php if ($this->permission->checkPermission($this->session->userdata('permissao'), 'dGarantia')): ?>
                    <a href="#modal-excluir" data-toggle="modal" role="button" garantia="<?= $r->idGarantias ?>" class="act-btn ab-d" title="Excluir"><i class='bx bx-trash-alt'></i></a>
                    <?php endif; ?>
                </div></td>
            </tr>
            <?php endforeach; endif; ?>
            </tbody>
        </table>
    </div>
    <?= $this->pagination->create_links() ?>
</div>

<script type="text/javascript">
    $(document).ready(function() {
        $(document).on('click', 'a', function(event) {
            var garantia = $(this).attr('garantia');
            $('#idGarantias').val(garantia);
        });
    });
</script>
