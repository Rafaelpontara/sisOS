<?php
function mcStatusBadge2($s){$m=['Aberto'=>'mb-blue','Em Andamento'=>'mb-indigo','Orçamento'=>'mb-amber','Negociação'=>'mb-amber','Finalizado'=>'mb-green','Faturado'=>'mb-green','Cancelado'=>'mb-red','Aguardando Peças'=>'mb-amber','Aprovado'=>'mb-purple'];$c=$m[$s]??'mb-gray';return '<span class="mc-badge '.$c.'">'.htmlspecialchars($s).'</span>';}
function mcGarantiaBadge2($v){if(!$v)return '—';$p=explode('/',$v);if(count($p)==3){$ts=strtotime($p[2].'-'.$p[1].'-'.$p[0]);$c=$ts>=strtotime('today')?'mb-green':'mb-red';return '<span class="mc-badge '.$c.'">'.$v.'</span>';}return '<span class="mc-badge mb-gray">'.$v.'</span>';}
?>
<div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:18px;flex-wrap:wrap;gap:10px;">
    <h2 style="font-size:18px;font-weight:800;color:#e8eaf0;display:flex;align-items:center;gap:8px;">
        <i class='bx bx-file' style="color:#f97316;"></i> Ordens de Serviço
    </h2>
    <?php if (!$this->session->userdata('cadastra_os')): ?>
    <a href="<?= base_url() ?>index.php/mine/adicionarOs" class="mc-btn mc-btn-success">
        <i class='bx bx-plus'></i> Abrir Nova OS
    </a>
    <?php endif; ?>
</div>

<div class="mc-tbl-wrap">
    <table class="mc-tbl">
        <thead><tr><th>#</th><th>Técnico</th><th>Data Inicial</th><th>Data Final</th><th>Venc. Garantia</th><th>Status</th><th style="text-align:right;">Ações</th></tr></thead>
        <tbody>
        <?php
        $lista = $results ?: [];
        if ($lista): foreach ($lista as $r):
            $venc = '';
            if ($r->garantia && is_numeric($r->garantia) && !empty($r->dataFinal) && $r->dataFinal!='0000-00-00')
                $venc = dateInterval($r->dataFinal, $r->garantia);
            elseif ($r->garantia=='0') $venc='Sem Garantia';
        ?>
        <tr>
            <td style="color:#9ca3af;font-size:12px;">#<?= str_pad($r->idOs,4,'0',STR_PAD_LEFT) ?></td>
            <td style="font-size:12px;color:#9ca3af;"><?= htmlspecialchars($r->nome??'—') ?></td>
            <td style="font-size:12px;"><?= date('d/m/Y',strtotime($r->dataInicial)) ?></td>
            <td style="font-size:12px;color:#9ca3af;"><?= (!empty($r->dataFinal)&&$r->dataFinal!='0000-00-00')?date('d/m/Y',strtotime($r->dataFinal)):'—' ?></td>
            <td><?= mcGarantiaBadge2($venc) ?></td>
            <td><?= mcStatusBadge2($r->status) ?></td>
            <td style="text-align:right;">
                <div style="display:inline-flex;gap:5px;">
                    <a href="<?= base_url() ?>index.php/mine/visualizarOs/<?= $r->idOs ?>" class="mc-act mc-act-view" title="Visualizar"><i class='bx bx-show'></i></a>
                    <a href="<?= base_url() ?>index.php/mine/imprimirOs/<?= $r->idOs ?>" class="mc-act mc-act-print" title="Imprimir" target="_blank"><i class='bx bx-printer'></i></a>
                    <a href="<?= base_url() ?>index.php/mine/detalhesOs/<?= $r->idOs ?>" class="mc-act mc-act-detail" title="Detalhes"><i class='bx bx-detail'></i></a>
                    <?php if ($r->status=='Orçamento'): ?>
                    <a href="<?= site_url('os/aprovar/'.$r->idOs.'?acao=sim') ?>" class="mc-act mc-act-ok" title="Aprovar"><i class='bx bx-check'></i></a>
                    <a href="<?= site_url('os/aprovar/'.$r->idOs.'?acao=nao') ?>" class="mc-act mc-act-no" title="Recusar"><i class='bx bx-x'></i></a>
                    <?php endif; ?>
                </div>
            </td>
        </tr>
        <?php endforeach; else: ?>
        <tr><td colspan="7" class="mc-empty"><i class='bx bx-file' style="font-size:24px;display:block;margin-bottom:6px;opacity:.3;"></i>Nenhuma OS encontrada.</td></tr>
        <?php endif; ?>
        </tbody>
    </table>
</div>
<?php echo $this->pagination->create_links(); ?>
