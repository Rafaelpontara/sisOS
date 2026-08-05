<?php if (!$results): ?>
    <?php if (empty($semResultadosOculto)): ?>
    <tr><td colspan="9" class="tbl-empty">
        <i class='bx bx-user-x'></i>
        Nenhum cliente cadastrado
    </td></tr>
    <?php endif; ?>
<?php else: foreach ($results as $r): ?>
<tr data-id="<?= $r->idClientes ?>">
    <td style="color:#6b7280;font-size:12px;"><?= $r->idClientes ?></td>
    <td class="td-name">
        <a href="<?= base_url() ?>index.php/clientes/visualizar/<?= $r->idClientes ?>">
            <?= htmlspecialchars($r->nomeCliente) ?>
        </a>
        <?php if (!empty($r->bloqueado)): ?>
        <span class="badge-bloqueado">BLOQUEADO</span>
        <?php endif; ?>
    </td>
    <td><?= htmlspecialchars($r->contato) ?></td>
    <td style="font-family:monospace;font-size:12px;"><?= htmlspecialchars($r->documento) ?></td>
    <td><?= htmlspecialchars($r->telefone) ?></td>
    <td><?= htmlspecialchars($r->celular) ?></td>
    <td style="max-width:160px;overflow:hidden;text-overflow:ellipsis;white-space:nowrap;"><?= htmlspecialchars($r->email) ?></td>
    <td>
        <?php if ($r->fornecedor == 1): ?>
        <span class="badge-fornecedor">Fornecedor</span>
        <?php else: ?>
        <span class="badge-cliente">Cliente</span>
        <?php endif; ?>
        <?php foreach (($tagsPorCliente[$r->idClientes] ?? []) as $tg): ?>
        <span class="badge-tag" style="background:<?= htmlspecialchars($tg->cor) ?>22;color:<?= htmlspecialchars($tg->cor) ?>;border:1px solid <?= htmlspecialchars($tg->cor) ?>55;"><?= htmlspecialchars($tg->tag) ?></span>
        <?php endforeach; ?>
    </td>
    <td>
        <div class="act-btns">
        <?php if ($this->permission->checkPermission($this->session->userdata('permissao'), 'vCliente')): ?>
            <a href="<?= base_url() ?>index.php/clientes/visualizar/<?= $r->idClientes ?>" class="act-btn act-btn-view" title="Visualizar"><i class='bx bx-show'></i></a>
            <a href="<?= base_url() ?>index.php/mine?e=<?= $r->email ?>" target="_blank" class="act-btn act-btn-key" title="Área do Cliente"><i class='bx bx-key'></i></a>
            <a href="#" data-id="<?= $r->idClientes ?>" data-bloqueado="<?= !empty($r->bloqueado) ? 1 : 0 ?>"
               class="act-btn act-btn-lock btn-bloquear"
               title="<?= !empty($r->bloqueado) ? 'Desbloquear' : 'Bloquear' ?>">
               <i class='bx <?= !empty($r->bloqueado) ? 'bx-lock-open' : 'bx-lock' ?>'></i>
            </a>
        <?php endif; ?>
        <?php if ($this->permission->checkPermission($this->session->userdata('permissao'), 'eCliente')): ?>
            <a href="<?= base_url() ?>index.php/clientes/editar/<?= $r->idClientes ?>" class="act-btn act-btn-edit" title="Editar"><i class='bx bx-edit'></i></a>
            <a href="#" onclick="cliAbrirModalTags(<?= $r->idClientes ?>, '<?= htmlspecialchars(addslashes($r->nomeCliente)) ?>'); return false;" class="act-btn act-btn-tags" title="Tags / Categoria"><i class='bx bx-purchase-tag'></i></a>
        <?php endif; ?>
        <?php if ($this->permission->checkPermission($this->session->userdata('permissao'), 'dCliente')): ?>
            <a href="#modal-excluir" role="button" data-toggle="modal" cliente="<?= $r->idClientes ?>" class="act-btn act-btn-del" title="Excluir"><i class='bx bx-trash-alt'></i></a>
        <?php endif; ?>
        </div>
    </td>
</tr>
<?php endforeach; endif; ?>
