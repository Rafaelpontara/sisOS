<?php if (!$results): ?>
    <?php if (empty($semResultadosOculto)): ?>
    <tr><td colspan="12" style="text-align:center;padding:40px;color:#6b7280;"><i class="bx bx-file-blank" style="font-size:40px;display:block;margin-bottom:8px;opacity:.3;"></i>Nenhuma OS encontrada</td></tr>
    <?php endif; ?>
<?php else:
foreach ($results as $r):
    $dataInicial = $r->dataInicial ? date('d/m/Y', strtotime($r->dataInicial)) : '-';
    $hoje = date('Y-m-d');

    $diasGarantia = (int)($r->garantia ?? 0);
    if ($r->dataFinal && $diasGarantia > 0) {
        $vencTs        = strtotime($r->dataFinal . ' + ' . $diasGarantia . ' days');
        $vencData      = date('Y-m-d', $vencTs);
        $vencDataFmt   = date('d/m/Y', $vencTs);
        $diasRestantes = (int)ceil(($vencTs - strtotime($hoje)) / 86400);

        if (in_array($r->status, ['Cancelado', 'Recusado', 'Sem Conserto'])) {
            $corGarantia = '#6b7280'; $vencGarantia = 'N/A';
        } elseif ($vencData < $hoje) {
            $corGarantia = '#ef4444'; $vencGarantia = 'VENCIDA (' . $vencDataFmt . ')';
        } elseif ($diasRestantes <= 7) {
            $corGarantia = '#fbbf24'; $vencGarantia = $vencDataFmt . ' (' . $diasRestantes . 'd)';
        } else {
            $corGarantia = '#22c55e'; $vencGarantia = $vencDataFmt . ' (' . $diasRestantes . 'd)';
        }
    } elseif ($r->dataFinal && $diasGarantia === 0) {
        $corGarantia = '#6b7280'; $vencGarantia = 'Sem garantia';
    } else {
        $corGarantia = '#6b7280'; $vencGarantia = 'Sem prazo';
    }
    $spMap = ['Aberto'=>'ab','Orçamento'=>'or','Finalizado'=>'fi','Faturado'=>'fat','Cancelado'=>'ca','Recusado'=>'ca','Em Andamento'=>'an','Aprovado'=>'an'];
    $spC = isset($spMap[$r->status]) ? 'sp-'.$spMap[$r->status] : 'sp-ot';
?>
<tr data-id="<?= $r->idOs ?>">
    <td style="color:#6b7280;font-size:12px;"><?= $r->idOs ?></td>
    <td><a href="<?= base_url() ?>index.php/clientes/visualizar/<?= $r->idClientes ?>" style="color:#e8eaf0;font-weight:600;text-decoration:none;"><?= htmlspecialchars($r->nomeCliente) ?></a></td>
    <td style="color:#9ca3af;font-size:12px;"><?= htmlspecialchars($r->nome) ?></td>
    <td style="font-size:12px;"><?= $dataInicial ?></td>
    <td><span style="color:<?= $corGarantia ?>;font-size:12px;"><?= $vencGarantia ?></span></td>
    <td style="font-weight:600;">R$ <?= number_format($r->totalProdutos + $r->totalServicos, 2, ',', '.') ?></td>
    <td style="color:#f87171;">R$ <?= number_format(floatval($r->desconto), 2, ',', '.') ?></td>
    <td style="font-weight:600;color:#e8eaf0;">R$ <?= number_format(floatval($r->valor_desconto), 2, ',', '.') ?></td>
    <td style="color:#4ade80;">R$ <?= number_format($r->faturado ? floatval($r->valor_desconto) : 0, 2, ',', '.') ?></td>
    <td><?= !empty($r->entregue) ? '<span class="sp sp-fi">Sim</span>' : '<span class="sp sp-ot">Não</span>' ?></td>
    <td><span class="sp <?= $spC ?>"><?= htmlspecialchars($r->status) ?></span></td>
    <td>
        <div class="act-btns" style="display:flex;gap:5px;">
        <?php if ($this->permission->checkPermission($this->session->userdata('permissao'), 'vOs')): ?>
            <a href="<?= base_url() ?>index.php/os/visualizar/<?= $r->idOs ?>" class="act-btn ab-v" title="Ver"><i class="bx bx-show"></i></a>
            <a href="<?= base_url() ?>index.php/os/imprimir/<?= $r->idOs ?>" target="_blank" class="act-btn ab-p" title="Imprimir A4"><i class="bx bx-printer"></i></a>
            <a href="<?= base_url() ?>index.php/os/imprimirTermica/<?= $r->idOs ?>" target="_blank" class="act-btn ab-t" title="Cupom 80mm"><i class="bx bx-receipt"></i></a>
        <?php endif; ?>
        <?php if ($this->permission->checkPermission($this->session->userdata('permissao'), 'eOs')): ?>
            <a href="<?= base_url() ?>index.php/os/editar/<?= $r->idOs ?>" class="act-btn ab-e" title="Editar"><i class="bx bx-edit"></i></a>
        <?php endif; ?>
        <?php if ($this->permission->checkPermission($this->session->userdata('permissao'), 'dOs')): ?>
            <a href="#modal-excluir" role="button" data-toggle="modal" os="<?= $r->idOs ?>" class="act-btn ab-d" title="Excluir"><i class="bx bx-trash-alt"></i></a>
        <?php endif; ?>
        </div>
    </td>
</tr>
<?php endforeach; endif; ?>
