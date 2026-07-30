<?php if (!$results): ?>
    <?php if (empty($semResultadosOculto)): ?>
    <div class="os-empty">
        <i class="bx bx-file-blank"></i>
        Nenhuma OS encontrada
    </div>
    <?php endif; ?>
<?php else: foreach ($results as $r):
    $dataInicial = $r->dataInicial ? date('d/m/Y', strtotime($r->dataInicial)) : '-';
    $hoje = date('Y-m-d');

    // Vencimento da garantia = dataFinal + garantia(dias) — mesma regra da tabela original
    $diasGarantia = (int)($r->garantia ?? 0);
    if ($r->dataFinal && $diasGarantia > 0) {
        $vencTs        = strtotime($r->dataFinal . ' + ' . $diasGarantia . ' days');
        $vencData      = date('Y-m-d', $vencTs);
        $vencDataFmt   = date('d/m/Y', $vencTs);
        $diasRestantes = (int)ceil(($vencTs - strtotime($hoje)) / 86400);

        if (in_array($r->status, ['Cancelado', 'Recusado', 'Sem Conserto'])) {
            $corGarantia = '#6b7280'; $vencGarantia = 'N/A';
        } elseif ($vencData < $hoje) {
            $corGarantia = '#ef4444'; $vencGarantia = 'Vencida (' . $vencDataFmt . ')';
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
    $total = $r->totalProdutos + $r->totalServicos;
?>
<div class="os-card" data-search="<?= htmlspecialchars(mb_strtolower($r->idOs . ' ' . $r->nomeCliente . ' ' . $r->nome . ' ' . $r->status)) ?>">
    <div class="os-card-top">
        <span class="os-num">#<?= str_pad($r->idOs, 4, '0', STR_PAD_LEFT) ?></span>
        <span class="sp <?= $spC ?>"><?= htmlspecialchars($r->status) ?></span>
    </div>

    <a href="<?= base_url() ?>index.php/clientes/visualizar/<?= $r->idClientes ?>" class="os-cliente"><?= htmlspecialchars($r->nomeCliente) ?></a>
    <div class="os-tecnico"><i class='bx bx-wrench'></i> <?= htmlspecialchars($r->nome) ?></div>

    <div class="os-row">
        <div><span class="os-row-label">Aberta em</span><span class="os-row-val"><?= $dataInicial ?></span></div>
        <div style="text-align:right;"><span class="os-row-label">Venc. Garantia</span><span class="os-row-val" style="color:<?= $corGarantia ?>;"><?= $vencGarantia ?></span></div>
    </div>

    <?php if (!empty($r->senha_tipo) && $r->senha_tipo !== 'sem_senha'):
        $tipoLabels = [
            'pin' => 'PIN', 'padrao' => 'Padrão', 'face' => 'Face ID',
            'digital' => 'Digital', 'iphone_face' => 'Face ID (iPhone)', 'iphone_digital' => 'Touch ID (iPhone)',
        ];
        $tipoLabel = $tipoLabels[$r->senha_tipo] ?? $r->senha_tipo;
    ?>
    <div class="os-row" style="border-top:1px solid rgba(255,255,255,0.06);">
        <span class="os-row-label"><i class='bx bx-lock-alt'></i> Senha (<?= htmlspecialchars($tipoLabel) ?>)</span>
        <?php if (!empty($r->senha_valor)): ?>
        <span class="os-row-val" style="font-family:monospace;background:rgba(167,139,250,0.12);color:#a78bfa;padding:2px 8px;border-radius:6px;"><?= htmlspecialchars($r->senha_valor) ?></span>
        <?php endif; ?>
    </div>
    <?php endif; ?>

    <div class="os-financeiro">
        <div>
            <span class="os-total">R$ <?= number_format($total, 2, ',', '.') ?></span>
            <?php if ($r->desconto > 0): ?>
            <span class="os-desconto">- R$ <?= number_format(floatval($r->desconto), 2, ',', '.') ?> desc.</span>
            <?php endif; ?>
        </div>
        <span class="sp <?= !empty($r->entregue) ? 'sp-fi' : 'sp-ot' ?>"><?= !empty($r->entregue) ? 'Entregue' : 'Não entregue' ?></span>
    </div>

    <div class="os-card-footer">
        <?php if ($this->permission->checkPermission($this->session->userdata('permissao'), 'vOs')): ?>
        <a href="<?= base_url() ?>index.php/os/visualizar/<?= $r->idOs ?>" class="act-btn ab-v" title="Ver"><i class="bx bx-show"></i></a>
        <a href="<?= base_url() ?>index.php/os/imprimir/<?= $r->idOs ?>" target="_blank" class="act-btn ab-p" title="Imprimir A4"><i class="bx bx-printer"></i></a>
        <a href="<?= base_url() ?>index.php/os/imprimirTermica/<?= $r->idOs ?>" target="_blank" class="act-btn ab-t" title="Cupom 80mm"><i class="bx bx-receipt"></i></a>
        <?php endif; ?>
        <?php if ($this->permission->checkPermission($this->session->userdata('permissao'), 'eOs')): ?>
        <a href="<?= base_url() ?>index.php/os/editar/<?= $r->idOs ?>" class="act-btn ab-e" title="Editar"><i class="bx bx-edit"></i></a>
        <?php endif; ?>
        <?php if ($this->permission->checkPermission($this->session->userdata('permissao'), 'dOs')): ?>
        <a href="#modal-excluir" role="button" data-toggle="modal" os="<?= $r->idOs ?>" class="act-btn ab-d" title="Excluir" style="margin-left:auto;"><i class="bx bx-trash-alt"></i></a>
        <?php endif; ?>
    </div>
</div>
<?php endforeach; endif; ?>
