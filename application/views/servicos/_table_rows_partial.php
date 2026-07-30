<?php if (!$results): ?>
    <?php if (empty($semResultadosOculto)): ?>
    <tr><td colspan="5" class="tbl-empty"><i class='bx bx-wrench'></i>Nenhum serviço cadastrado</td></tr>
    <?php endif; ?>
<?php else: foreach ($results as $r): ?>
<tr data-id="<?= $r->idServicos ?>">
    <td style="color:#6b7280;font-size:12px;"><?= $r->idServicos ?></td>
    <td style="color:#e8eaf0;font-weight:600;"><?= htmlspecialchars($r->nome) ?></td>
    <td style="color:#34d399;font-weight:700;">R$ <?= number_format($r->preco, 2, ',', '.') ?></td>
    <td class="td-desc"><?= htmlspecialchars($r->descricao) ?></td>
    <td>
        <div class="act-btns">
            <?php if ($this->permission->checkPermission($this->session->userdata('permissao'), 'eServico')): ?>
            <a href="<?= base_url() ?>index.php/servicos/editar/<?= $r->idServicos ?>" class="act-btn act-btn-edit" title="Editar"><i class='bx bx-edit'></i></a>
            <?php endif; ?>
            <?php if ($this->permission->checkPermission($this->session->userdata('permissao'), 'dServico')): ?>
            <a href="#modal-excluir" role="button" data-toggle="modal" servico="<?= $r->idServicos ?>" class="act-btn act-btn-del" title="Excluir"><i class='bx bx-trash-alt'></i></a>
            <?php endif; ?>
        </div>
    </td>
</tr>
<?php endforeach; endif; ?>
