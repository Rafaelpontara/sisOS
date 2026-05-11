<?php
function mcSB3($s){$m=['Aberto'=>'mb-blue','Em Andamento'=>'mb-indigo','Orçamento'=>'mb-amber','Finalizado'=>'mb-green','Faturado'=>'mb-green','Cancelado'=>'mb-red','Aguardando Peças'=>'mb-amber','Aprovado'=>'mb-purple'];$c=$m[$s]??'mb-gray';return '<span class="mc-badge '.$c.'">'.htmlspecialchars($s).'</span>';}
?>
<div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:18px;">
    <h2 style="font-size:18px;font-weight:800;color:#e8eaf0;display:flex;align-items:center;gap:8px;">
        <i class='bx bx-cart-alt' style="color:#a78bfa;"></i> Minhas Compras
    </h2>
</div>
<div class="mc-tbl-wrap">
    <table class="mc-tbl">
        <thead><tr><th>#</th><th>Responsável</th><th>Data</th><th>Faturado</th><th>Status</th><th style="text-align:right;">Ações</th></tr></thead>
        <tbody>
        <?php if (!empty($results)): foreach ($results as $c): ?>
        <tr>
            <td style="color:#9ca3af;font-size:12px;">#<?= str_pad($c->idVendas,4,'0',STR_PAD_LEFT) ?></td>
            <td style="font-size:12px;color:#9ca3af;"><?= htmlspecialchars($c->nome??'—') ?></td>
            <td style="font-size:12px;"><?= date('d/m/Y',strtotime($c->dataVenda)) ?></td>
            <td><?= $c->faturado ? '<span class="mc-badge mb-green">Sim</span>' : '<span class="mc-badge mb-gray">Não</span>' ?></td>
            <td><?= mcSB3($c->status??'—') ?></td>
            <td style="text-align:right;">
                <div style="display:inline-flex;gap:5px;">
                    <a href="<?= base_url() ?>index.php/mine/visualizarCompra/<?= $c->idVendas ?>" class="mc-act mc-act-view" title="Visualizar"><i class='bx bx-show'></i></a>
                    <a href="<?= base_url() ?>index.php/mine/imprimirCompra/<?= $c->idVendas ?>" class="mc-act mc-act-print" title="Imprimir" target="_blank"><i class='bx bx-printer'></i></a>
                </div>
            </td>
        </tr>
        <?php endforeach; else: ?>
        <tr><td colspan="6" class="mc-empty">Nenhuma compra encontrada.</td></tr>
        <?php endif; ?>
        </tbody>
    </table>
</div>
<?php echo $this->pagination->create_links(); ?>
