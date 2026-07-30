<?php if (!$results): ?>
    <?php if (empty($semResultadosOculto)): ?>
    <div class="srv-empty">
        <i class='bx bx-wrench'></i>
        Nenhum serviço cadastrado
    </div>
    <?php endif; ?>
<?php else: foreach ($results as $r): ?>
<div class="srv-card" data-search="<?= htmlspecialchars(mb_strtolower($r->nome . ' ' . $r->descricao)) ?>">
    <div class="srv-card-top">
        <div class="srv-icon"><i class='bx bx-wrench'></i></div>
        <div style="flex:1;min-width:0;">
            <div class="srv-name"><?= htmlspecialchars($r->nome) ?></div>
            <div class="srv-preco">R$ <?= number_format($r->preco, 2, ',', '.') ?></div>
        </div>
    </div>

    <?php if ($r->descricao): ?>
    <div class="srv-desc"><?= htmlspecialchars($r->descricao) ?></div>
    <?php endif; ?>

    <div class="srv-card-footer">
        <?php if ($this->permission->checkPermission($this->session->userdata('permissao'), 'eServico')): ?>
        <a href="<?= base_url() ?>index.php/servicos/editar/<?= $r->idServicos ?>" class="act-btn act-btn-edit" title="Editar"><i class='bx bx-edit'></i></a>
        <?php endif; ?>
        <?php if ($this->permission->checkPermission($this->session->userdata('permissao'), 'dServico')): ?>
        <a href="#modal-excluir" role="button" data-toggle="modal" servico="<?= $r->idServicos ?>" class="act-btn act-btn-del" title="Excluir" style="margin-left:auto;"><i class='bx bx-trash-alt'></i></a>
        <?php endif; ?>
    </div>
</div>
<?php endforeach; endif; ?>
