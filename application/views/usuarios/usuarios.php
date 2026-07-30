<style>
    select {
        width: 70px;
    }
    .situacao-ativo {
        background-color: #00cd00;
        color: white;
    }
    .situacao-inativo {
        background-color: #ff0000;
        color: white;
    }
</style>

<div class="new122">
    <div class="widget-title" style="margin:-15px -10px 0">
        <h5>Usuários</h5>
    </div>
    <a href="<?= base_url('index.php/usuarios/adicionar') ?>" class="button btn btn-success" style="max-width: 160px">
        <span class="button__icon"><i class='bx bx-plus-circle'></i></span><span class="button__text2">Adicionar Usuário</span>
    </a>

    <div class="widget-box">
        <div class="widget-title" style="margin: -20px 0 0">
            <span class="icon">
                <i class="fas fa-cash-register"></i>
            </span>
            <h5 style="padding: 3px 0"></h5>
        </div>
        <div class="widget-content nopadding tab-content">
            <table id="tabela" class="table table-bordered ">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Nome</th>
                        <th>CPF</th>
                        <th>Telefone</th>
                        <th>Nível</th>
                        <th>Situação</th>
                        <th>Validade</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($results)): ?>
                        <tr>
                            <td colspan="8">Nenhum Usuário Cadastrado</td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($results as $r): ?>
                            <tr>
                                <td><?= $r->idUsuarios ?></td>
                                <td><?= $r->nome ?></td>
                                <td><?= $r->cpf ?></td>
                                <td><?= $r->telefone ?></td>
                                <td><?= $r->permissao ?></td>
                                <?php
                                $situacao = ($r->situacao == 1) ? 'Ativo' : 'Inativo';
                            $situacaoClasse = ($r->situacao == 1) ? 'situacao-ativo' : 'situacao-inativo';
                            ?>
                                <td><span class="badge <?= $situacaoClasse ?>"><?= ucfirst($situacao) ?></span></td>
                                <td><?= $r->dataExpiracao ?></td>
                                <td style="display:flex;gap:5px;align-items:center;">
                                    <a href="<?= base_url('index.php/usuarios/editar/' . $r->idUsuarios) ?>" class="btn-nwe3" title="Editar usuário"><i class="bx bx-edit"></i></a>
                                    <?php if ($r->idUsuarios != $this->session->userdata('id_admin')): ?>
                                    <button onclick="confirmarExcluir(<?= $r->idUsuarios ?>, '<?= htmlspecialchars($r->nome, ENT_QUOTES) ?>')"
                                        class="btn-nwe3" title="Excluir usuário"
                                        style="background:rgba(239,68,68,0.15);color:#f87171;border:none;cursor:pointer;border-radius:6px;width:28px;height:28px;display:inline-flex;align-items:center;justify-content:center;">
                                        <i class="bx bx-trash"></i>
                                    </button>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?= $this->pagination->create_links(); ?>

<script>
function confirmarExcluir(id, nome) {
    Swal.fire({
        title: 'Excluir usuário?',
        html: 'Tem certeza que deseja excluir <strong>' + nome + '</strong>?<br><small style="color:#f87171;">Esta ação não pode ser desfeita.</small>',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#ef4444',
        cancelButtonColor: '#6b7280',
        confirmButtonText: '<i class="bx bx-trash"></i> Sim, excluir',
        cancelButtonText: 'Cancelar'
    }).then(function(result) {
        if (result.isConfirmed) {
            window.location.href = '<?= base_url("index.php/usuarios/excluir/") ?>' + id;
        }
    });
}
</script>
