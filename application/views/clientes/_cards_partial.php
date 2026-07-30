<?php
// Reaproveitado tanto pelo carregamento inicial (clientes.php) quanto pelo
// endpoint AJAX da rolagem infinita (Clientes::carregarMais()) — por isso
// fica sozinho neste arquivo, sem cabeçalho/menu/rodapé.
$avatarCores = [
    ['bg' => '#a78bfa', 'text' => '#fff'],
    ['bg' => '#60a5fa', 'text' => '#fff'],
    ['bg' => '#22c55e', 'text' => '#fff'],
    ['bg' => '#f59e0b', 'text' => '#fff'],
    ['bg' => '#f87171', 'text' => '#fff'],
    ['bg' => '#7c3aed', 'text' => '#fff'],
];
?>
<?php if (!$results): ?>
    <?php if (empty($semResultadosOculto)): ?>
    <div class="cli-empty">
        <i class='bx bx-user-x'></i>
        <p>Nenhum cliente cadastrado ainda.<br>Clique em "Novo Cliente" para começar.</p>
    </div>
    <?php endif; ?>
<?php else: foreach ($results as $r):
    $cor = $avatarCores[$r->idClientes % count($avatarCores)];
    $inicial = mb_strtoupper(mb_substr(trim($r->nomeCliente), 0, 1));
?>
<div class="cli-card" data-id="<?= $r->idClientes ?>" data-search="<?= htmlspecialchars(mb_strtolower($r->nomeCliente . ' ' . $r->documento . ' ' . $r->email . ' ' . $r->telefone . ' ' . $r->celular)) ?>">
    <div class="cli-card-top">
        <div class="cli-avatar" style="background:<?= $cor['bg'] ?>;color:<?= $cor['text'] ?>;"><?= $inicial ?: '?' ?></div>
        <div style="flex:1;min-width:0;">
            <div class="cli-card-name">
                <a href="<?= base_url() ?>index.php/clientes/visualizar/<?= $r->idClientes ?>"><?= htmlspecialchars($r->nomeCliente) ?></a>
            </div>
            <div class="cli-card-badges">
                <?php if ($r->fornecedor == 1): ?>
                <span class="badge-fornecedor">Fornecedor</span>
                <?php else: ?>
                <span class="badge-cliente">Cliente</span>
                <?php endif; ?>
                <?php if (!empty($r->bloqueado)): ?>
                <span class="badge-bloqueado">Bloqueado</span>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <div class="cli-card-info">
        <?php if ($r->celular): ?>
        <div><i class='bx bxl-whatsapp'></i><span><?= htmlspecialchars($r->celular) ?></span></div>
        <?php elseif ($r->telefone): ?>
        <div><i class='bx bx-phone'></i><span><?= htmlspecialchars($r->telefone) ?></span></div>
        <?php endif; ?>
        <?php if ($r->email): ?>
        <div><i class='bx bx-envelope'></i><span><?= htmlspecialchars($r->email) ?></span></div>
        <?php endif; ?>
        <?php if ($r->documento): ?>
        <div><i class='bx bx-id-card'></i><span style="font-family:monospace;"><?= htmlspecialchars($r->documento) ?></span></div>
        <?php endif; ?>
    </div>

    <div class="cli-card-footer">
        <?php if ($this->permission->checkPermission($this->session->userdata('permissao'), 'vCliente')): ?>
        <a href="<?= base_url() ?>index.php/clientes/visualizar/<?= $r->idClientes ?>" class="cli-btn-ficha">Ver Ficha</a>
        <a href="<?= base_url() ?>index.php/mine?e=<?= $r->email ?>" target="_blank" class="act-btn act-btn-key" title="Área do Cliente"><i class='bx bx-key'></i></a>
        <a href="#" data-id="<?= $r->idClientes ?>" data-bloqueado="<?= !empty($r->bloqueado) ? 1 : 0 ?>"
           class="act-btn act-btn-lock btn-bloquear"
           title="<?= !empty($r->bloqueado) ? 'Desbloquear' : 'Bloquear' ?>">
           <i class='bx <?= !empty($r->bloqueado) ? 'bx-lock-open' : 'bx-lock' ?>'></i>
        </a>
        <?php endif; ?>
        <?php if ($this->permission->checkPermission($this->session->userdata('permissao'), 'eCliente')): ?>
        <a href="<?= base_url() ?>index.php/clientes/editar/<?= $r->idClientes ?>" class="act-btn act-btn-edit" title="Editar"><i class='bx bx-edit'></i></a>
        <?php endif; ?>
        <?php if ($this->permission->checkPermission($this->session->userdata('permissao'), 'dCliente')): ?>
        <a href="#modal-excluir" role="button" data-toggle="modal" cliente="<?= $r->idClientes ?>" class="act-btn act-btn-del" title="Excluir"><i class='bx bx-trash-alt'></i></a>
        <?php endif; ?>
    </div>
</div>
<?php endforeach; endif; ?>
