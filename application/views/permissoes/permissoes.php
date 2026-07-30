<style>
.perm-header { display: flex; align-items: center; justify-content: space-between; margin-bottom: 20px; padding: 0 2px; }
.perm-title { display: flex; align-items: center; gap: 10px; }
.perm-title i { font-size: 20px; color: #f59e0b; }
.perm-title h4 { margin: 0; font-size: 16px; font-weight: 700; color: #e2e4f0; }
.perm-table-wrap { background: #181b2a; border: 1px solid rgba(255,255,255,.07); border-radius: 12px; overflow: hidden; }
.perm-table { width: 100%; border-collapse: collapse; font-size: 13px; }
.perm-table thead tr { background: #21253a; border-bottom: 1px solid rgba(255,255,255,.08); }
.perm-table thead th { padding: 12px 16px; text-align: left; font-size: 11px; font-weight: 700; color: #6b7280; text-transform: uppercase; letter-spacing: .7px; }
.perm-table tbody tr { border-bottom: 1px solid rgba(255,255,255,.04); transition: background .1s; }
.perm-table tbody tr:last-child { border-bottom: none; }
.perm-table tbody tr:hover { background: rgba(255,255,255,.03); }
.perm-table td { padding: 13px 16px; color: #c9cad6; vertical-align: middle; }
.perm-icon { width: 34px; height: 34px; border-radius: 8px; background: rgba(245,158,11,.12); display: inline-flex; align-items: center; justify-content: center; margin-right: 10px; }
.perm-icon i { font-size: 16px; color: #f59e0b; }
.perm-name { font-weight: 600; color: #e2e4f0; display: flex; align-items: center; }
.badge-ativo-p { padding: 3px 10px; background: rgba(34,197,94,.15); color: #4ade80; border-radius: 20px; font-size: 11px; font-weight: 700; display: inline-flex; align-items: center; gap: 4px; }
.badge-ativo-p::before { content:''; width:5px; height:5px; border-radius:50%; background:#4ade80; }
.badge-inativo-p { padding: 3px 10px; background: rgba(107,114,128,.15); color: #9ca3af; border-radius: 20px; font-size: 11px; font-weight: 700; display: inline-flex; align-items: center; gap: 4px; }
.badge-inativo-p::before { content:''; width:5px; height:5px; border-radius:50%; background:#9ca3af; }
.perm-actions { display: flex; gap: 6px; }
.btn-perm-edit { display: inline-flex; align-items: center; gap: 4px; padding: 5px 10px; background: rgba(124,106,247,.12); color: #a79cf7; border: 1px solid rgba(124,106,247,.25); border-radius: 6px; font-size: 11px; font-weight: 600; text-decoration: none; transition: all .15s; }
.btn-perm-edit:hover { background: rgba(124,106,247,.25); color: #c4bfff; }
.btn-perm-del { display: inline-flex; align-items: center; gap: 4px; padding: 5px 10px; background: rgba(239,68,68,.1); color: #f87171; border: 1px solid rgba(239,68,68,.2); border-radius: 6px; font-size: 11px; font-weight: 600; cursor: pointer; transition: all .15s; }
.btn-perm-del:hover { background: rgba(239,68,68,.2); }
</style>

<div class="pg-wrap">
    <div class="perm-header">
        <div class="perm-title">
            <i class='bx bx-shield-quarter'></i>
            <h4>Permissões</h4>
        </div>
        <a href="<?= base_url() ?>index.php/permissoes/adicionar" class="btn-add-usr" style="background:linear-gradient(135deg,#f59e0b,#d97706);">
            <i class='bx bx-plus'></i> Nova Permissão
        </a>
    </div>

    <div class="perm-table-wrap">
        <table class="perm-table" id="tabela">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Nome</th>
                    <th>Criação</th>
                    <th>Situação</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!$results): ?>
                    <tr>
                        <td colspan="5" style="text-align:center;padding:40px;color:#4b5563;">
                            <i class='bx bx-shield-x' style="font-size:36px;display:block;margin-bottom:8px;"></i>
                            Nenhuma permissão cadastrada
                        </td>
                    </tr>
                <?php else: ?>
                    <?php foreach ($results as $r): ?>
                        <?php $situacao = ($r->situacao == 1) ? 'Ativo' : 'Inativo'; ?>
                        <tr>
                            <td style="color:#4b5563;font-size:12px;">#<?= $r->idPermissao ?></td>
                            <td>
                                <div class="perm-name">
                                    <div class="perm-icon"><i class='bx bx-lock-alt'></i></div>
                                    <?= htmlspecialchars($r->nome) ?>
                                </div>
                            </td>
                            <td style="font-size:12px;color:#6b7280;"><?= date('d/m/Y', strtotime($r->data)) ?></td>
                            <td>
                                <span class="<?= $r->situacao == 1 ? 'badge-ativo-p' : 'badge-inativo-p' ?>">
                                    <?= $situacao ?>
                                </span>
                            </td>
                            <td>
                                <div class="perm-actions">
                                    <a href="<?= base_url() ?>index.php/permissoes/editar/<?= $r->idPermissao ?>" class="btn-perm-edit">
                                        <i class='bx bx-edit-alt'></i> Editar
                                    </a>
                                    <a href="#modal-excluir" role="button" data-toggle="modal" permissao="<?= $r->idPermissao ?>" class="btn-perm-del">
                                        <i class='bx bx-notification-off'></i> Desativar
                                    </a>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <div style="margin-top:12px;"><?= $this->pagination->create_links(); ?></div>
</div>

<!-- Modal Desativar -->
<div id="modal-excluir" class="modal hide fade" tabindex="-1" role="dialog" aria-hidden="true">
    <form action="<?= base_url() ?>index.php/permissoes/desativar" method="post">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            <h5>Desativar Permissão</h5>
        </div>
        <div class="modal-body" style="text-align:center;padding:24px;">
            <i class='bx bx-error-circle' style="font-size:40px;color:#f59e0b;display:block;margin-bottom:10px;"></i>
            <input type="hidden" id="idPermissao" name="id" value="" />
            <p style="color:#c9cad6;margin:0;">Deseja realmente desativar esta permissão?</p>
        </div>
        <div class="modal-footer" style="display:flex;justify-content:center;gap:8px;">
            <button class="button btn btn-warning" data-dismiss="modal" aria-hidden="true">
                <span class="button__icon"><i class="bx bx-x"></i></span><span class="button__text2">Cancelar</span>
            </button>
            <button class="button btn btn-danger">
                <span class="button__icon"><i class='bx bx-trash'></i></span><span class="button__text2">Desativar</span>
            </button>
        </div>
    </form>
</div>

<script>
$(document).on('click', '[permissao]', function() {
    $('#idPermissao').val($(this).attr('permissao'));
});
</script>
