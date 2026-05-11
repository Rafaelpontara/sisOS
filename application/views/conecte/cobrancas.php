<div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:18px;">
    <h2 style="font-size:18px;font-weight:800;color:#e8eaf0;display:flex;align-items:center;gap:8px;">
        <i class='bx bx-credit-card-front' style="color:#fbbf24;"></i> Cobranças
    </h2>
</div>
<div class="mc-tbl-wrap">
    <table class="mc-tbl">
        <thead><tr><th>#</th><th>Vencimento</th><th>Referência</th><th>Status</th><th>Valor</th><th style="text-align:right;">Ações</th></tr></thead>
        <tbody>
        <?php if (!empty($results)): foreach ($results as $r):
            $st=strtolower($r->status??'');
            $cls=in_array($st,['paid','pago'])?'mb-green':(in_array($st,['canceled','cancelado'])?'mb-red':'mb-amber');
        ?>
        <tr>
            <td style="color:#9ca3af;font-size:12px;"><?= $r->idCobranca ?? '—' ?></td>
            <td style="font-size:12px;"><?= !empty($r->expire_at)?date('d/m/Y',strtotime($r->expire_at)):'—' ?></td>
            <td style="font-size:12px;color:#9ca3af;"><?= htmlspecialchars($r->payment_method??'—') ?></td>
            <td><span class="mc-badge <?= $cls ?>"><?= htmlspecialchars($r->status??'—') ?></span></td>
            <td style="font-weight:700;color:#fbbf24;">R$ <?= number_format(($r->total??0)/100,2,',','.') ?></td>
            <td style="text-align:right;">
                <?php if (!empty($r->link)): ?>
                <a href="<?= $r->link ?>" target="_blank" class="mc-act mc-act-view" title="Ver cobrança"><i class='bx bx-link-external'></i></a>
                <?php endif; ?>
            </td>
        </tr>
        <?php endforeach; else: ?>
        <tr><td colspan="6" class="mc-empty">Nenhuma cobrança encontrada.</td></tr>
        <?php endif; ?>
        </tbody>
    </table>
</div>
