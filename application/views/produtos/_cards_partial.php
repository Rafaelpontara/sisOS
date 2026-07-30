<?php if (!$results): ?>
    <?php if (empty($semResultadosOculto)): ?>
    <div class="prd-empty">
        <i class='bx bx-package'></i>
        Nenhum produto cadastrado
    </div>
    <?php endif; ?>
<?php else: foreach ($results as $r):
    $estq = (int)$r->estoque;
    $min  = (int)($r->estoqueMinimo ?? 0);
    if ($estq <= 0) { $stockCls = 'stock-low'; }
    elseif ($min > 0 && $estq <= $min) { $stockCls = 'stock-warn'; }
    else { $stockCls = 'stock-ok'; }
?>
<div class="prd-card" data-search="<?= htmlspecialchars(mb_strtolower($r->descricao . ' ' . $r->codDeBarra)) ?>">
    <div class="prd-card-top">
        <div class="prd-icon"><i class='bx bx-cube'></i></div>
        <div style="flex:1;min-width:0;">
            <div class="prd-name"><?= htmlspecialchars($r->descricao) ?></div>
            <?php if ($r->codDeBarra): ?>
            <div class="prd-cod"><?= htmlspecialchars($r->codDeBarra) ?></div>
            <?php endif; ?>
        </div>
    </div>

    <div class="prd-row">
        <span class="prd-row-label">Estoque</span>
        <span class="stock-badge <?= $stockCls ?>"><?= $estq ?> un.</span>
    </div>
    <div class="prd-row">
        <span class="prd-row-label">Preço</span>
        <span class="prd-preco">R$ <?= number_format($r->precoVenda, 2, ',', '.') ?></span>
    </div>

    <div class="prd-card-footer">
        <?php if ($this->permission->checkPermission($this->session->userdata('permissao'), 'vProduto')): ?>
        <a href="<?= base_url() ?>index.php/produtos/visualizar/<?= $r->idProdutos ?>" class="act-btn act-btn-view" title="Visualizar"><i class='bx bx-show'></i></a>
        <?php endif; ?>
        <?php if ($this->permission->checkPermission($this->session->userdata('permissao'), 'eProduto')): ?>
        <a href="<?= base_url() ?>index.php/produtos/editar/<?= $r->idProdutos ?>" class="act-btn act-btn-edit" title="Editar"><i class='bx bx-edit'></i></a>
        <a href="#atualizar-estoque" role="button" data-toggle="modal" produto="<?= $r->idProdutos ?>" estoque="<?= $r->estoque ?>" class="act-btn act-btn-stock" title="Atualizar Estoque"><i class='bx bx-plus-circle'></i></a>
        <?php endif; ?>
        <?php if ($this->permission->checkPermission($this->session->userdata('permissao'), 'dProduto')): ?>
        <a href="#modal-excluir" role="button" data-toggle="modal" produto="<?= $r->idProdutos ?>" class="act-btn act-btn-del" title="Excluir" style="margin-left:auto;"><i class='bx bx-trash-alt'></i></a>
        <?php endif; ?>
    </div>
</div>
<?php endforeach; endif; ?>
