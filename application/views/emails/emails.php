<style>
.email-header { display: flex; align-items: center; justify-content: space-between; margin-bottom: 20px; padding: 0 2px; }
.email-title { display: flex; align-items: center; gap: 10px; }
.email-title i { font-size: 20px; color: #34d399; }
.email-title h4 { margin: 0; font-size: 16px; font-weight: 700; color: #e2e4f0; }
.email-table-wrap { background: #181b2a; border: 1px solid rgba(255,255,255,.07); border-radius: 12px; overflow: hidden; }
.email-table { width: 100%; border-collapse: collapse; font-size: 13px; }
.email-table thead tr { background: #21253a; border-bottom: 1px solid rgba(255,255,255,.08); }
.email-table thead th { padding: 12px 16px; text-align: left; font-size: 11px; font-weight: 700; color: #6b7280; text-transform: uppercase; letter-spacing: .7px; }
.email-table tbody tr { border-bottom: 1px solid rgba(255,255,255,.04); transition: background .1s; }
.email-table tbody tr:last-child { border-bottom: none; }
.email-table tbody tr:hover { background: rgba(255,255,255,.03); }
.email-table td { padding: 12px 16px; color: #c9cad6; vertical-align: middle; }
.email-to { display: flex; align-items: center; gap: 8px; }
.email-to i { font-size: 16px; color: #34d399; }
.email-to span { font-weight: 500; color: #e2e4f0; }
.status-pending { padding: 3px 10px; background: rgba(107,114,128,.15); color: #9ca3af; border-radius: 20px; font-size: 11px; font-weight: 700; display: inline-block; }
.status-sending { padding: 3px 10px; background: rgba(6,182,212,.15); color: #22d3ee; border-radius: 20px; font-size: 11px; font-weight: 700; display: inline-block; }
.status-sent { padding: 3px 10px; background: rgba(34,197,94,.15); color: #4ade80; border-radius: 20px; font-size: 11px; font-weight: 700; display: inline-block; }
.status-failed { padding: 3px 10px; background: rgba(245,158,11,.15); color: #fbbf24; border-radius: 20px; font-size: 11px; font-weight: 700; display: inline-block; }
.btn-del-email { display: inline-flex; align-items: center; padding: 5px 9px; background: rgba(239,68,68,.1); color: #f87171; border: 1px solid rgba(239,68,68,.2); border-radius: 6px; font-size: 12px; text-decoration: none; transition: all .15s; cursor: pointer; }
.btn-del-email:hover { background: rgba(239,68,68,.2); }
</style>

<div class="pg-wrap">
    <div class="email-header">
        <div class="email-title">
            <i class='bx bx-mail-send'></i>
            <h4>Fila de Envio de E-mails</h4>
        </div>
    </div>

    <div class="email-table-wrap">
        <table class="email-table" id="tabela">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Destinatário</th>
                    <th>Status</th>
                    <th>Data/Hora</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!$results): ?>
                    <tr>
                        <td colspan="5" style="text-align:center;padding:40px;color:#4b5563;">
                            <i class='bx bx-check-circle' style="font-size:36px;display:block;margin-bottom:8px;color:#4b5563;"></i>
                            Nenhum e-mail na fila
                        </td>
                    </tr>
                <?php else: ?>
                    <?php
                    $statusMap = [
                        'pending' => ['label' => 'Pendente', 'class' => 'status-pending'],
                        'sending' => ['label' => 'Enviando', 'class' => 'status-sending'],
                        'sent'    => ['label' => 'Enviado',  'class' => 'status-sent'],
                        'failed'  => ['label' => 'Falhou',   'class' => 'status-failed'],
                    ];
                    foreach ($results as $r):
                        $st = $statusMap[$r->status] ?? ['label' => $r->status, 'class' => 'status-pending'];
                    ?>
                    <tr>
                        <td style="color:#4b5563;font-size:12px;">#<?= $r->id ?></td>
                        <td>
                            <div class="email-to">
                                <i class='bx bx-at'></i>
                                <span><?= htmlspecialchars($r->to) ?></span>
                            </div>
                        </td>
                        <td><span class="<?= $st['class'] ?>"><?= $st['label'] ?></span></td>
                        <td style="font-size:12px;color:#6b7280;white-space:nowrap;">
                            <?= date('d/m/Y H:i', strtotime($r->date)) ?>
                        </td>
                        <td>
                            <a href="#modal-excluir" role="button" data-toggle="modal" email="<?= $r->id ?>" class="btn-del-email" title="Excluir">
                                <i class='bx bx-trash'></i>
                            </a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <div style="margin-top:12px;"><?= $this->pagination->create_links(); ?></div>
</div>

<!-- Modal Excluir E-mail -->
<div id="modal-excluir" class="modal hide fade" tabindex="-1" role="dialog" aria-hidden="true">
    <form action="<?= site_url('sisos/excluirEmail') ?>" method="post">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            <h5>Excluir E-mail da Fila</h5>
        </div>
        <div class="modal-body" style="text-align:center;padding:24px;">
            <i class='bx bx-envelope' style="font-size:40px;color:#f87171;display:block;margin-bottom:10px;"></i>
            <input type="hidden" id="idEmail" name="id" value="" />
            <p style="color:#c9cad6;margin:0;">Deseja excluir este e-mail da lista de envio?</p>
        </div>
        <div class="modal-footer" style="display:flex;justify-content:center;gap:8px;">
            <button class="button btn btn-warning" data-dismiss="modal">
                <span class="button__icon"><i class="bx bx-x"></i></span><span class="button__text2">Cancelar</span>
            </button>
            <button class="button btn btn-danger">
                <span class="button__icon"><i class='bx bx-trash'></i></span><span class="button__text2">Excluir</span>
            </button>
        </div>
    </form>
</div>

<script>
$(document).on('click', '[email]', function() {
    $('#idEmail').val($(this).attr('email'));
});
</script>
