<?php
/**
 * Partial de card do quadro de Pedidos.
 * Espera a variável $p (objeto vindo de Pedidos::_buscarPedidos) no escopo.
 */
$prioridadeClasse = [
    'Alta'   => 'ped-badge-alta',
    'Normal' => 'ped-badge-normal',
    'Baixa'  => 'ped-badge-baixa',
];
$corPrioridade = $prioridadeClasse[$p->prioridade] ?? 'ped-badge-normal';

$dadosEdit = [
    'id'          => (int) $p->id,
    'descricao'   => $p->descricao,
    'produtosId'  => $p->produtos_id,
    'clientesId'  => $p->clientes_id,
    'clienteNome' => $p->nomeCliente ?? '',
    'quantidade'  => (int) $p->quantidade,
    'prioridade'  => $p->prioridade,
    'observacao'  => $p->observacao,
    'foto'        => $p->foto ?? '',
];
?>
<div class="ped-card" draggable="true" data-id="<?= (int) $p->id ?>" data-status="<?= htmlspecialchars($p->status) ?>">
    <?php if (!empty($p->foto)): ?>
        <img src="<?= htmlspecialchars($p->foto) ?>" class="ped-card-foto" onclick="window.open('<?= htmlspecialchars($p->foto) ?>', '_blank')" alt="Foto do item">
    <?php endif; ?>
    <div class="ped-card-top">
        <span class="ped-badge <?= $corPrioridade ?>"><?= htmlspecialchars($p->prioridade) ?></span>
        <span class="ped-qtd"><?= (int) $p->quantidade ?>x</span>
    </div>

    <div class="ped-desc"><?= htmlspecialchars($p->descricao) ?></div>

    <?php if (!empty($p->produtos_id) && !empty($p->produto_cadastrado_desc)): ?>
        <div class="ped-linha"><i class='bx bx-cube'></i> Produto cadastrado: <?= htmlspecialchars($p->produto_cadastrado_desc) ?></div>
    <?php endif; ?>

    <?php if (!empty($p->clientes_id) && !empty($p->nomeCliente)): ?>
        <div class="ped-linha ped-cliente"><i class='bx bx-user'></i> <?= htmlspecialchars($p->nomeCliente) ?></div>
    <?php endif; ?>

    <?php if (!empty($p->observacao)): ?>
        <div class="ped-obs"><?= htmlspecialchars($p->observacao) ?></div>
    <?php endif; ?>

    <div class="ped-card-foot">
        <span class="ped-data">
            <?php if ($p->status === 'Entregue' && !empty($p->dataEntregue)): ?>
                Entregue em <?= date('d/m/Y', strtotime($p->dataEntregue)) ?>
            <?php elseif ($p->status === 'Comprado' && !empty($p->dataComprado)): ?>
                Comprado em <?= date('d/m/Y', strtotime($p->dataComprado)) ?>
            <?php else: ?>
                <?= date('d/m/Y', strtotime($p->dataCriacao)) ?>
            <?php endif; ?>
        </span>
        <div class="ped-acoes">
            <?php if ($this->permission->checkPermission($this->session->userdata('permissao'), 'ePedido')): ?>
                <?php if ($p->status === 'Pendente'): ?>
                    <button type="button" class="ped-acao ped-acao-avancar" data-id="<?= (int) $p->id ?>" title="Marcar como comprado"><i class='bx bx-cart-alt'></i></button>
                <?php elseif ($p->status === 'Comprado'): ?>
                    <?php if (!empty($p->clientes_id) && !empty($p->celular_cliente)):
                        $msgWhats = urlencode('Olá ' . $p->nomeCliente . '! O item que você aguardava (' . $p->descricao . ') já chegou na loja e está disponível para retirada. 😊');
                        $numeroWhats = preg_replace('/\D/', '', $p->celular_cliente ?: $p->telefone_cliente ?? '');
                    ?>
                        <a href="https://api.whatsapp.com/send?phone=55<?= $numeroWhats ?>&text=<?= $msgWhats ?>" target="_blank" class="ped-acao ped-acao-whats" title="Avisar cliente no WhatsApp"><i class='bx bxl-whatsapp'></i></a>
                    <?php endif; ?>
                    <button type="button" class="ped-acao ped-acao-entregar" data-id="<?= (int) $p->id ?>" title="Marcar como entregue"><i class='bx bx-check-circle'></i></button>
                <?php endif; ?>
                <button type="button" class="ped-acao ped-acao-editar"
                    data-id="<?= $dadosEdit['id'] ?>"
                    data-descricao="<?= htmlspecialchars($dadosEdit['descricao']) ?>"
                    data-produtos-id="<?= htmlspecialchars((string) $dadosEdit['produtosId']) ?>"
                    data-clientes-id="<?= htmlspecialchars((string) $dadosEdit['clientesId']) ?>"
                    data-cliente-nome="<?= htmlspecialchars($dadosEdit['clienteNome']) ?>"
                    data-quantidade="<?= $dadosEdit['quantidade'] ?>"
                    data-prioridade="<?= htmlspecialchars($dadosEdit['prioridade']) ?>"
                    data-observacao="<?= htmlspecialchars($dadosEdit['observacao'] ?? '') ?>"
                    data-foto="<?= htmlspecialchars($dadosEdit['foto']) ?>"
                    title="Editar"><i class='bx bx-edit'></i></button>
            <?php endif; ?>
            <?php if ($this->permission->checkPermission($this->session->userdata('permissao'), 'dPedido')): ?>
                <button type="button" class="ped-acao ped-acao-excluir" data-id="<?= (int) $p->id ?>" title="Excluir"><i class='bx bx-trash-alt'></i></button>
            <?php endif; ?>
        </div>
    </div>
</div>
