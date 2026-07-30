<?php if (!$results): ?>
    <?php if (empty($semResultadosOculto)): ?>
    <tr><td colspan="6" class="tbl-empty"><i class='bx bx-package'></i>Nenhum produto cadastrado</td></tr>
    <?php endif; ?>
<?php else: foreach ($results as $r):
    $estq = (int)$r->estoque;
    $min  = (int)($r->estoqueMinimo ?? 0);
    $cls  = $estq <= 0 ? 'stock-low' : ($min > 0 && $estq <= $min ? 'stock-warn' : 'stock-ok');
?>
<tr data-id="<?= $r->idProdutos ?>">
    <td style="color:#6b7280;font-size:12px;"><?= $r->idProdutos ?></td>
    <td style="font-family:monospace;font-size:12px;color:#9ca3af;"><?= htmlspecialchars($r->codDeBarra) ?></td>
    <td class="td-name"><?= htmlspecialchars($r->descricao) ?></td>
    <td><span class="<?= $cls ?>"><?= $estq ?></span></td>
    <td style="font-weight:600;color:#e8eaf0;">R$ <?= number_format($r->precoVenda, 2, ',', '.') ?></td>
    <td>
        <div class="act-btns">
            <?php if ($this->permission->checkPermission($this->session->userdata('permissao'), 'vProduto')): ?>
            <a href="<?= base_url() ?>index.php/produtos/visualizar/<?= $r->idProdutos ?>" class="act-btn act-btn-view" title="Visualizar"><i class='bx bx-show'></i></a>
            <?php endif; ?>
            <?php if ($this->permission->checkPermission($this->session->userdata('permissao'), 'eProduto')): ?>
            <a href="<?= base_url() ?>index.php/produtos/editar/<?= $r->idProdutos ?>" class="act-btn act-btn-edit" title="Editar"><i class='bx bx-edit'></i></a>
            <?php endif; ?>
            <?php if ($this->permission->checkPermission($this->session->userdata('permissao'), 'dProduto')): ?>
            <a href="#modal-excluir" role="button" data-toggle="modal" produto="<?= $r->idProdutos ?>" class="act-btn act-btn-del" title="Excluir"><i class='bx bx-trash-alt'></i></a>
            <?php endif; ?>
            <?php if ($this->permission->checkPermission($this->session->userdata('permissao'), 'eProduto')): ?>
            <a href="#atualizar-estoque" role="button" data-toggle="modal" produto="<?= $r->idProdutos ?>" estoque="<?= $r->estoque ?>" class="act-btn act-btn-stock" title="Atualizar Estoque"><i class='bx bx-plus-circle'></i></a>
            <?php endif; ?>
        </div>
    </td>
</tr>
<?php endforeach; endif; ?>
