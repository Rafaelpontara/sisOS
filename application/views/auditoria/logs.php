<style>
.log-header { display: flex; align-items: center; justify-content: space-between; margin-bottom: 20px; padding: 0 2px; }
.log-title { display: flex; align-items: center; gap: 10px; }
.log-title i { font-size: 20px; color: #06b6d4; }
.log-title h4 { margin: 0; font-size: 16px; font-weight: 700; color: #e2e4f0; }
.log-table-wrap { background: #181b2a; border: 1px solid rgba(255,255,255,.07); border-radius: 12px; overflow: hidden; }
.log-table { width: 100%; border-collapse: collapse; font-size: 13px; }
.log-table thead tr { background: #21253a; border-bottom: 1px solid rgba(255,255,255,.08); }
.log-table thead th { padding: 12px 16px; text-align: left; font-size: 11px; font-weight: 700; color: #6b7280; text-transform: uppercase; letter-spacing: .7px; }
.log-table tbody tr { border-bottom: 1px solid rgba(255,255,255,.04); transition: background .1s; }
.log-table tbody tr:last-child { border-bottom: none; }
.log-table tbody tr:hover { background: rgba(255,255,255,.03); }
.log-table td { padding: 11px 16px; color: #c9cad6; vertical-align: middle; }
.log-user { display: flex; align-items: center; gap: 8px; }
.log-avatar { width: 28px; height: 28px; border-radius: 50%; background: rgba(6,182,212,.15); display: flex; align-items: center; justify-content: center; font-size: 11px; font-weight: 700; color: #22d3ee; flex-shrink: 0; }
.log-username { font-weight: 600; color: #e2e4f0; font-size: 13px; }
.log-date-cell { font-size: 12px; color: #6b7280; white-space: nowrap; }
.log-ip { font-family: monospace; font-size: 12px; color: #6b7280; background: rgba(255,255,255,.05); padding: 2px 7px; border-radius: 4px; }
.log-tarefa { color: #c9cad6; font-size: 13px; }
.btn-del-log { display: inline-flex; align-items: center; gap: 6px; padding: 7px 14px; background: rgba(239,68,68,.1); color: #f87171; border: 1px solid rgba(239,68,68,.2); border-radius: 8px; font-size: 12px; font-weight: 600; text-decoration: none; cursor: pointer; transition: all .15s; }
.btn-del-log:hover { background: rgba(239,68,68,.2); color: #fca5a5; }
.log-stats { display: flex; gap: 12px; margin-bottom: 16px; }
.log-stat { background: rgba(6,182,212,.08); border: 1px solid rgba(6,182,212,.15); border-radius: 8px; padding: 8px 14px; display: flex; align-items: center; gap: 8px; }
.log-stat i { font-size: 16px; color: #22d3ee; }
.log-stat span { font-size: 12px; color: #9ca3af; }
.log-stat strong { font-size: 14px; color: #e2e4f0; display: block; }
</style>

<div class="pg-wrap">
    <div class="log-header">
        <div class="log-title">
            <i class='bx bx-history'></i>
            <h4>Auditoria — Logs do Sistema</h4>
        </div>
        <a href="#modal-excluir" role="button" data-toggle="modal" class="btn-del-log">
            <i class='bx bx-trash'></i> Remover logs ≥ 30 dias
        </a>
    </div>

    <div class="log-table-wrap">
        <table class="log-table" id="tabela">
            <thead>
                <tr>
                    <th>Usuário</th>
                    <th>Data</th>
                    <th>Hora</th>
                    <th>IP</th>
                    <th>Tarefa</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!$results): ?>
                    <tr>
                        <td colspan="5" style="text-align:center;padding:40px;color:#4b5563;">
                            <i class='bx bx-check-shield' style="font-size:36px;display:block;margin-bottom:8px;color:#4b5563;"></i>
                            Nenhum registro de log encontrado
                        </td>
                    </tr>
                <?php else: ?>
                    <?php foreach ($results as $r): ?>
                        <?php $initial = strtoupper(substr($r->usuario, 0, 1)); ?>
                        <tr>
                            <td>
                                <div class="log-user">
                                    <div class="log-avatar"><?= $initial ?></div>
                                    <span class="log-username"><?= htmlspecialchars($r->usuario) ?></span>
                                </div>
                            </td>
                            <td class="log-date-cell"><?= date('d/m/Y', strtotime($r->data)) ?></td>
                            <td class="log-date-cell"><?= $r->hora ?></td>
                            <td><span class="log-ip"><?= htmlspecialchars($r->ip) ?></span></td>
                            <td class="log-tarefa"><?= htmlspecialchars($r->tarefa) ?></td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <div style="margin-top:12px;"><?= $this->pagination->create_links(); ?></div>
</div>

<!-- Modal Limpar Logs -->
<div id="modal-excluir" class="modal hide fade" tabindex="-1" role="dialog" aria-hidden="true">
    <form action="<?= site_url('auditoria/clean') ?>" method="post">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            <h5>Limpeza de Logs</h5>
        </div>
        <div class="modal-body" style="text-align:center;padding:24px;">
            <i class='bx bx-trash' style="font-size:40px;color:#f87171;display:block;margin-bottom:10px;"></i>
            <p style="color:#c9cad6;margin:0;">Deseja remover todos os logs com <strong>30 dias ou mais</strong>?</p>
            <p style="color:#6b7280;font-size:12px;margin-top:6px;">Esta ação não pode ser desfeita.</p>
        </div>
        <div class="modal-footer" style="display:flex;justify-content:center;gap:8px;">
            <button class="button btn btn-warning" data-dismiss="modal" aria-hidden="true">
                <span class="button__icon"><i class="bx bx-x"></i></span><span class="button__text2">Cancelar</span>
            </button>
            <button class="button btn btn-danger">
                <span class="button__icon"><i class='bx bx-trash'></i></span><span class="button__text2">Remover Logs</span>
            </button>
        </div>
    </form>
</div>
