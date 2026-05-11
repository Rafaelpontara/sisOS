<style>
/* ── Layout ── */
.arq-header{display:flex;justify-content:space-between;align-items:center;margin-bottom:18px;flex-wrap:wrap;gap:10px;}
.arq-title{display:flex;align-items:center;gap:10px;}
.arq-title i{font-size:24px;color:#60a5fa;}
.arq-title h2{font-size:22px;font-weight:800;color:#e8eaf0;margin:0;}

/* ── Filtros ── */
.arq-filter{display:flex;gap:8px;align-items:center;flex-wrap:wrap;margin-bottom:14px;padding:12px 16px;background:#1a1d2e;border:1px solid rgba(255,255,255,0.07);border-radius:14px;}
.arq-filter input{padding:8px 12px;border-radius:8px;border:1px solid #444860;background:#13151f;color:#e8eaf0;font-size:13px;transition:border-color .15s;}
.arq-filter input:focus{border-color:#60a5fa;outline:none;}
.arq-filter input[type=text]{flex:1;min-width:180px;}
.arq-filter-btn{display:inline-flex;align-items:center;gap:6px;padding:8px 16px;border-radius:8px;background:#60a5fa;color:#fff;font-size:13px;font-weight:700;border:none;cursor:pointer;transition:all .15s;}
.arq-filter-btn:hover{background:#3b82f6;}

/* ── Botão add ── */
.arq-btn-add{display:inline-flex;align-items:center;gap:6px;padding:9px 16px;border-radius:8px;background:linear-gradient(135deg,#22c55e,#16a34a);color:#fff;font-size:13px;font-weight:700;text-decoration:none;box-shadow:0 4px 14px rgba(34,197,94,0.3);transition:transform .15s;}
.arq-btn-add:hover{transform:translateY(-2px);color:#fff;}

/* ── Tabela ── */
.arq-tbl-wrap{background:#1a1d2e;border:1px solid rgba(255,255,255,0.07);border-radius:14px;overflow:hidden;margin-bottom:14px;}
.arq-tbl-wrap table{width:100%;border-collapse:collapse;}
.arq-tbl-wrap thead th{background:#252a3a;color:#9ca3af;font-size:11px;font-weight:700;text-transform:uppercase;letter-spacing:.5px;padding:11px 14px;border-bottom:1px solid rgba(255,255,255,0.07);white-space:nowrap;}
.arq-tbl-wrap tbody tr{border-bottom:1px solid rgba(255,255,255,0.04);transition:background .12s;}
.arq-tbl-wrap tbody tr:hover{background:rgba(96,165,250,0.04);}
.arq-tbl-wrap tbody td{padding:10px 14px;font-size:13px;color:#c9cad6;vertical-align:middle;}

/* ── Thumb ── */
.arq-thumb{width:44px;height:44px;object-fit:cover;border-radius:8px;border:1px solid rgba(255,255,255,0.08);}
.arq-thumb-icon{width:44px;height:44px;background:#252a3a;border-radius:8px;display:flex;align-items:center;justify-content:center;}

/* ── Badges ── */
.arq-ext{padding:2px 8px;border-radius:5px;font-size:10px;font-weight:700;background:rgba(96,165,250,0.15);color:#60a5fa;font-family:monospace;letter-spacing:.5px;}

/* ── Ações ── */
.arq-acts{display:flex;gap:5px;}
.act-btn{width:30px;height:30px;border-radius:7px;display:inline-flex;align-items:center;justify-content:center;font-size:15px;text-decoration:none;transition:all .12s;border:none;cursor:pointer;}
.act-btn:hover{transform:scale(1.1);}
.ab-v{background:rgba(96,165,250,0.15);color:#60a5fa;}
.ab-v:hover{background:rgba(96,165,250,0.3);}
.ab-d{background:rgba(239,68,68,0.15);color:#f87171;}
.ab-d:hover{background:rgba(239,68,68,0.3);}
.ab-e{background:rgba(251,191,36,0.15);color:#fbbf24;}
.ab-e:hover{background:rgba(251,191,36,0.3);}

/* ── Modal dark ── */
.modal-dark .modal-header{background:#1a1d2e;border-bottom:1px solid rgba(255,255,255,0.08);padding:14px 18px;display:flex;align-items:center;justify-content:space-between;}
.modal-dark .modal-header h4{margin:0;font-size:15px;font-weight:800;color:#e8eaf0;display:flex;align-items:center;gap:8px;}
.modal-dark .modal-header .close{color:#9ca3af;font-size:20px;background:none;border:none;cursor:pointer;}
.modal-dark .modal-body{background:#13151f;padding:24px;text-align:center;}
.modal-dark .modal-footer{background:#1a1d2e;border-top:1px solid rgba(255,255,255,0.08);padding:10px 18px;display:flex;justify-content:flex-end;gap:8px;}
.modal-dark .modal-body p{color:#c9cad6;font-size:14px;margin:0;}
.modal-dark .modal-body i{font-size:40px;color:#f87171;margin-bottom:12px;display:block;}

/* ── Btn modal ── */
.m-btn{display:inline-flex;align-items:center;gap:6px;padding:8px 18px;border-radius:8px;font-size:13px;font-weight:700;border:none;cursor:pointer;transition:all .15s;}
.m-btn-cancel{background:rgba(255,255,255,0.07);color:#9ca3af;border:1px solid rgba(255,255,255,0.1);}
.m-btn-danger{background:linear-gradient(135deg,#ef4444,#dc2626);color:#fff;box-shadow:0 4px 12px rgba(239,68,68,0.3);}

#tabela_length,.dataTables_length,#tabela_info,.dataTables_info,
#tabela_filter,.dataTables_filter,.dataTables_paginate{display:none!important;}
</style>

<div class="new122">

    <!-- Header -->
    <div class="arq-header">
        <div class="arq-title">
            <i class='bx bx-folder-open'></i>
            <h2>Arquivos</h2>
        </div>
        <?php if ($this->permission->checkPermission($this->session->userdata('permissao'), 'aArquivo')): ?>
        <a href="<?= base_url() ?>index.php/arquivos/adicionar" class="arq-btn-add">
            <i class='bx bx-upload'></i> Novo Arquivo
        </a>
        <?php endif; ?>
    </div>

    <!-- Filtros -->
    <form method="get" action="<?= base_url() ?>index.php/arquivos" class="arq-filter">
        <input type="text" name="pesquisa" placeholder="Buscar por nome..."
               value="<?= htmlspecialchars($this->input->get('pesquisa')) ?>" />
        <input type="date" name="de" value="<?= htmlspecialchars($this->input->get('de')) ?>"
               title="Data inicial" />
        <input type="date" name="ate" value="<?= htmlspecialchars($this->input->get('ate')) ?>"
               title="Data final" />
        <button type="submit" class="arq-filter-btn">
            <i class='bx bx-search'></i> Buscar
        </button>
    </form>

    <!-- Tabela -->
    <div class="arq-tbl-wrap">
        <table id="tabela" class="table">
            <thead>
                <tr>
                    <th style="width:50px;">#</th>
                    <th style="width:60px;">Preview</th>
                    <th>Nome</th>
                    <th style="width:110px;">Data</th>
                    <th>Descrição</th>
                    <th style="width:90px;">Tamanho</th>
                    <th style="width:70px;">Ext.</th>
                    <th style="width:100px;">Ações</th>
                </tr>
            </thead>
            <tbody>
            <?php if (empty($results)): ?>
                <tr>
                    <td colspan="8" style="text-align:center;padding:40px;color:#6b7280;">
                        <i class='bx bx-folder-open' style="font-size:32px;display:block;margin-bottom:8px;"></i>
                        Nenhum arquivo encontrado
                    </td>
                </tr>
            <?php else: foreach ($results as $r):
                $nomeArq = $r->nomeArquivo ?? $r->arquivo ?? $r->documento ?? '';
                $arquivo  = $r->arquivo ?? '';
                $idArq    = $r->idArquivos ?? $r->idDocumentos ?? '';
                $data     = $r->data ?? $r->cadastro ?? null;
                $tamanho  = isset($r->tamanho) ? round($r->tamanho / 1024, 1) . ' KB' : '-';
                $ext      = strtolower(pathinfo($arquivo, PATHINFO_EXTENSION));
                $urlBase  = base_url() . 'uploads/arquivos/' . $arquivo;
                $isImg    = in_array($ext, ['jpg','jpeg','png','gif','webp']);
            ?>
                <tr>
                    <td style="color:#6b7280;font-size:12px;"><?= $idArq ?></td>
                    <td>
                        <?php if ($isImg): ?>
                        <img src="<?= $urlBase ?>" class="arq-thumb" alt="preview">
                        <?php else: ?>
                        <div class="arq-thumb-icon">
                            <?php
                            $iconMap = ['pdf'=>'bxs-file-pdf','doc'=>'bxs-file-doc','docx'=>'bxs-file-doc',
                                        'xls'=>'bxs-spreadsheet','xlsx'=>'bxs-spreadsheet',
                                        'zip'=>'bxs-file-archive','rar'=>'bxs-file-archive'];
                            $ic = $iconMap[$ext] ?? 'bx-file';
                            ?>
                            <i class='bx <?= $ic ?>' style="color:#60a5fa;font-size:22px;"></i>
                        </div>
                        <?php endif; ?>
                    </td>
                    <td style="font-weight:600;color:#e8eaf0;"><?= htmlspecialchars($nomeArq) ?></td>
                    <td style="font-size:12px;color:#9ca3af;">
                        <?= $data ? date('d/m/Y', strtotime($data)) : '-' ?>
                    </td>
                    <td style="max-width:220px;overflow:hidden;text-overflow:ellipsis;white-space:nowrap;font-size:12px;color:#9ca3af;">
                        <?= htmlspecialchars($r->descricao ?? '') ?>
                    </td>
                    <td style="font-size:12px;color:#9ca3af;"><?= $tamanho ?></td>
                    <td>
                        <?php if ($ext): ?>
                        <span class="arq-ext"><?= strtoupper($ext) ?></span>
                        <?php else: ?>
                        <span style="color:#6b7280;">—</span>
                        <?php endif; ?>
                    </td>
                    <td>
                        <div class="arq-acts">
                            <?php if ($this->permission->checkPermission($this->session->userdata('permissao'), 'vArquivo')): ?>
                            <a href="<?= $isImg ? $urlBase : base_url().'index.php/arquivos/download/'.$idArq ?>"
                               target="_blank" class="act-btn ab-v" title="Download / Visualizar">
                                <i class='bx bx-download'></i>
                            </a>
                            <?php endif; ?>
                            <?php if ($this->permission->checkPermission($this->session->userdata('permissao'), 'eArquivo')): ?>
                            <a href="<?= base_url() ?>index.php/arquivos/editar/<?= $idArq ?>"
                               class="act-btn ab-e" title="Editar">
                                <i class='bx bx-edit'></i>
                            </a>
                            <?php endif; ?>
                            <?php if ($this->permission->checkPermission($this->session->userdata('permissao'), 'dArquivo')): ?>
                            <a href="#modal-excluir" data-toggle="modal" role="button"
                               data-arquivo="<?= $idArq ?>" class="act-btn ab-d excluir-arq" title="Excluir">
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

<!-- Modal Excluir -->
<div id="modal-excluir" class="modal hide fade modal-dark" tabindex="-1" role="dialog" aria-hidden="true">
    <form action="<?= base_url() ?>index.php/arquivos/excluir" method="post">
        <input type="hidden" id="idDocumento" name="id" value="" />
        <div class="modal-header">
            <h4><i class='bx bx-trash' style="color:#f87171;"></i> Excluir Arquivo</h4>
            <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        <div class="modal-body">
            <i class='bx bx-error-circle'></i>
            <p>Deseja realmente excluir este arquivo?<br>
            <span style="font-size:12px;color:#6b7280;">Esta ação não pode ser desfeita.</span></p>
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

<script>
$(document).ready(function() {
    $(document).on('click', '.excluir-arq', function() {
        $('#idDocumento').val($(this).data('arquivo'));
    });
});
</script>
