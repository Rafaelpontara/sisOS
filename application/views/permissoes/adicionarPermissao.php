<script src="<?= base_url() ?>assets/js/validate.js"></script>

<style>
.fp-wrap { max-width: 900px; }
.fp-header { display: flex; align-items: center; justify-content: space-between; margin-bottom: 20px; }
.fp-title { display: flex; align-items: center; gap: 10px; }
.fp-title i { font-size: 22px; color: #f59e0b; }
.fp-title h4 { margin: 0; font-size: 16px; font-weight: 700; color: #e2e4f0; }

/* Nome da permissão */
.fp-top-card { background: #181b2a; border: 1px solid rgba(255,255,255,.07); border-radius: 14px; padding: 18px 20px; margin-bottom: 16px; display: flex; align-items: center; gap: 16px; flex-wrap: wrap; }
.fp-nome-field { flex: 1; min-width: 220px; }
.fp-label { font-size: 11px; font-weight: 700; color: #6b7280; text-transform: uppercase; letter-spacing: .5px; display: block; margin-bottom: 5px; }
.fp-input { background: #13151f; border: 1px solid #3b3f58; color: #e2e4f0; border-radius: 8px; padding: 10px 14px; font-size: 14px; font-weight: 600; width: 100%; box-sizing: border-box; transition: border-color .15s; }
.fp-input:focus { border-color: #f59e0b; outline: none; box-shadow: 0 0 0 3px rgba(245,158,11,.1); }
.fp-input::placeholder { color: #4b5563; font-weight: 400; }
.fp-input.error { border-color: #f87171; }

/* Marcar todos */
.fp-mark-all { display: flex; align-items: center; gap: 8px; padding: 10px 16px; background: rgba(245,158,11,.08); border: 1px solid rgba(245,158,11,.2); border-radius: 8px; cursor: pointer; white-space: nowrap; }
.fp-mark-all input[type=checkbox] { display: none; }
.fp-mark-all .fp-toggle { width: 36px; height: 20px; background: #3b3f58; border-radius: 20px; position: relative; transition: background .2s; flex-shrink: 0; }
.fp-mark-all .fp-toggle::after { content: ''; width: 14px; height: 14px; background: #fff; border-radius: 50%; position: absolute; top: 3px; left: 3px; transition: left .2s; }
.fp-mark-all.checked .fp-toggle { background: #f59e0b; }
.fp-mark-all.checked .fp-toggle::after { left: 19px; }
.fp-mark-all span { font-size: 12px; font-weight: 700; color: #d97706; }

/* Módulos */
.fp-module { background: #181b2a; border: 1px solid rgba(255,255,255,.07); border-radius: 12px; overflow: hidden; margin-bottom: 10px; }
.fp-module-head { display: flex; align-items: center; justify-content: space-between; padding: 13px 18px; cursor: pointer; transition: background .15s; user-select: none; }
.fp-module-head:hover { background: rgba(255,255,255,.03); }
.fp-module-head-left { display: flex; align-items: center; gap: 10px; }
.fp-module-icon { width: 32px; height: 32px; border-radius: 8px; display: flex; align-items: center; justify-content: center; flex-shrink: 0; }
.fp-module-icon i { font-size: 16px; }
.fp-module-name { font-size: 13px; font-weight: 700; color: #e2e4f0; }
.fp-module-count { font-size: 11px; color: #6b7280; background: rgba(255,255,255,.06); padding: 2px 8px; border-radius: 10px; }
.fp-chevron { font-size: 16px; color: #6b7280; transition: transform .2s; }
.fp-module.open .fp-chevron { transform: rotate(180deg); }
.fp-module-body { display: none; padding: 16px 18px; border-top: 1px solid rgba(255,255,255,.05); }
.fp-module.open .fp-module-body { display: block; }
.fp-perms-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(180px, 1fr)); gap: 8px; }
.fp-perm-item { display: flex; align-items: center; gap: 8px; padding: 8px 12px; background: #13151f; border: 1px solid rgba(255,255,255,.06); border-radius: 8px; cursor: pointer; transition: all .15s; }
.fp-perm-item:hover { border-color: rgba(255,255,255,.15); background: #1a1e30; }
.fp-perm-item input[type=checkbox] { display: none; }
.fp-perm-box { width: 16px; height: 16px; border: 2px solid #3b3f58; border-radius: 4px; flex-shrink: 0; display: flex; align-items: center; justify-content: center; transition: all .15s; }
.fp-perm-box i { font-size: 11px; color: #fff; opacity: 0; transition: opacity .1s; }
.fp-perm-item.checked .fp-perm-box { background: #f59e0b; border-color: #f59e0b; }
.fp-perm-item.checked .fp-perm-box i { opacity: 1; }
.fp-perm-label { font-size: 12px; color: #c9cad6; font-weight: 500; }
.fp-perm-item.checked .fp-perm-label { color: #fbbf24; font-weight: 600; }

/* Ações */
.fp-actions { display: flex; gap: 10px; margin-top: 4px; }
.fp-btn-save { display: inline-flex; align-items: center; gap: 7px; padding: 10px 22px; background: linear-gradient(135deg,#f59e0b,#d97706); color: #fff; border: none; border-radius: 8px; font-size: 13px; font-weight: 700; cursor: pointer; transition: opacity .15s; }
.fp-btn-save:hover { opacity: .85; }
.fp-btn-back { display: inline-flex; align-items: center; gap: 7px; padding: 10px 18px; background: rgba(255,255,255,.06); color: #9ca3af; border: 1px solid rgba(255,255,255,.1); border-radius: 8px; font-size: 13px; font-weight: 600; text-decoration: none; transition: all .15s; }
.fp-btn-back:hover { background: rgba(255,255,255,.1); color: #e2e4f0; }
span.error { color: #f87171; font-size: 11px; margin-top: 3px; display: block; }
</style>

<div class="fp-wrap">
    <div class="fp-header">
        <div class="fp-title">
            <i class='bx bx-shield-quarter'></i>
            <h4>Cadastro de Permissão</h4>
        </div>
        <a href="<?= site_url() ?>/permissoes" class="fp-btn-back">
            <i class='bx bx-arrow-back'></i> Voltar
        </a>
    </div>

    <form action="<?= base_url() ?>index.php/permissoes/adicionar" id="formPermissao" method="post">

        <!-- Nome + Marcar todos -->
        <div class="fp-top-card">
            <div class="fp-nome-field">
                <label class="fp-label">Nome da Permissão *</label>
                <input type="text" name="nome" id="nome" class="fp-input" placeholder="Ex: Técnico, Atendente, Gerente...">
            </div>
            <div class="fp-mark-all" id="markAllToggle">
                <input type="checkbox" id="marcarTodos" name="marcarTodos" value="1">
                <div class="fp-toggle"></div>
                <span>Marcar Todos</span>
            </div>
        </div>

        <!-- Módulos de permissão -->
        <?php
        $modulos = [
            ['id'=>'mod-clientes',   'icon'=>'bx-group',            'color'=>'#3b82f6', 'bg'=>'rgba(59,130,246,.12)',  'nome'=>'Clientes',              'perms'=>[
                ['vCliente','Visualizar','checked'], ['aCliente','Adicionar',''], ['eCliente','Editar',''], ['dCliente','Excluir','']
            ]],
            ['id'=>'mod-produtos',   'icon'=>'bx-package',          'color'=>'#8b5cf6', 'bg'=>'rgba(139,92,246,.12)', 'nome'=>'Produtos',              'perms'=>[
                ['vProduto','Visualizar','checked'], ['aProduto','Adicionar',''], ['eProduto','Editar',''], ['dProduto','Excluir','']
            ]],
            ['id'=>'mod-servicos',   'icon'=>'bx-wrench',           'color'=>'#06b6d4', 'bg'=>'rgba(6,182,212,.12)',  'nome'=>'Serviços',              'perms'=>[
                ['vServico','Visualizar','checked'], ['aServico','Adicionar',''], ['eServico','Editar',''], ['dServico','Excluir','']
            ]],
            ['id'=>'mod-os',         'icon'=>'bx-file',             'color'=>'#f59e0b', 'bg'=>'rgba(245,158,11,.12)', 'nome'=>'Ordens de Serviço (OS)', 'perms'=>[
                ['vOs','Visualizar','checked'], ['aOs','Adicionar',''], ['eOs','Editar',''], ['dOs','Excluir','']
            ]],
            ['id'=>'mod-solucoes',   'icon'=>'bx-bulb',             'color'=>'#fb923c', 'bg'=>'rgba(251,146,60,.12)', 'nome'=>'Soluções Técnicas',      'perms'=>[
                ['vSolucao','Visualizar','checked'], ['aSolucao','Adicionar',''], ['eSolucao','Editar',''], ['dSolucao','Excluir','']
            ]],
            ['id'=>'mod-pedidos',    'icon'=>'bx-cart-alt',         'color'=>'#a78bfa', 'bg'=>'rgba(167,139,250,.12)', 'nome'=>'Pedidos & Anotações',    'perms'=>[
                ['vPedido','Visualizar','checked'], ['aPedido','Adicionar',''], ['ePedido','Editar',''], ['dPedido','Excluir','']
            ]],
            ['id'=>'mod-vendas',     'icon'=>'bx-cart-alt',         'color'=>'#22c55e', 'bg'=>'rgba(34,197,94,.12)',  'nome'=>'Vendas',                'perms'=>[
                ['vVenda','Visualizar','checked'], ['aVenda','Adicionar',''], ['eVenda','Editar',''], ['dVenda','Excluir','']
            ]],
            ['id'=>'mod-cobrancas',  'icon'=>'bx-credit-card-front','color'=>'#ef4444', 'bg'=>'rgba(239,68,68,.12)',  'nome'=>'Cobranças',             'perms'=>[
                ['vCobranca','Visualizar','checked'], ['aCobranca','Adicionar',''], ['eCobranca','Editar',''], ['dCobranca','Excluir','']
            ]],
            ['id'=>'mod-garantias',  'icon'=>'bx-shield-check',     'color'=>'#a78bfa', 'bg'=>'rgba(167,139,250,.12)','nome'=>'Garantias',             'perms'=>[
                ['vGarantia','Visualizar','checked'], ['aGarantia','Adicionar',''], ['eGarantia','Editar',''], ['dGarantia','Excluir','']
            ]],
            ['id'=>'mod-arquivos',   'icon'=>'bx-folder',           'color'=>'#fb923c', 'bg'=>'rgba(251,146,60,.12)', 'nome'=>'Arquivos',              'perms'=>[
                ['vArquivo','Visualizar','checked'], ['aArquivo','Adicionar',''], ['eArquivo','Editar',''], ['dArquivo','Excluir','']
            ]],
            ['id'=>'mod-financeiro', 'icon'=>'bx-bar-chart-alt-2',  'color'=>'#34d399', 'bg'=>'rgba(52,211,153,.12)', 'nome'=>'Financeiro',            'perms'=>[
                ['vPagamento','Ver Pagamento','checked'], ['aPagamento','Add Pagamento',''], ['ePagamento','Editar Pgto',''], ['dPagamento','Excluir Pgto',''],
                ['vLancamento','Ver Lançamento','checked'],['aLancamento','Add Lançamento',''],['eLancamento','Editar Lanç.',''],['dLancamento','Excluir Lanç.','']
            ]],
            ['id'=>'mod-relatorios', 'icon'=>'bx-chart',            'color'=>'#60a5fa', 'bg'=>'rgba(96,165,250,.12)', 'nome'=>'Relatórios',            'perms'=>[
                ['rCliente','Rel. Clientes',''], ['rServico','Rel. Serviços',''], ['rOs','Rel. OS',''], ['rProduto','Rel. Produtos',''],
                ['rVenda','Rel. Vendas',''],     ['rFinanceiro','Rel. Financeiro','']
            ]],
            ['id'=>'mod-sistema',    'icon'=>'bx-cog',              'color'=>'#9ca3af', 'bg'=>'rgba(156,163,175,.12)','nome'=>'Configurações e Sistema','perms'=>[
                ['cUsuario','Usuários',''], ['cEmitente','Emitente',''], ['cPermissao','Permissões',''], ['cBackup','Backup',''],
                ['cAuditoria','Auditoria',''], ['cEmail','E-mails',''],  ['cSistema','Sistema','']
            ]],
        ];
        ?>

        <?php foreach ($modulos as $i => $mod): ?>
        <div class="fp-module <?= $i === 0 ? 'open' : '' ?>" id="<?= $mod['id'] ?>">
            <div class="fp-module-head" onclick="toggleMod('<?= $mod['id'] ?>')">
                <div class="fp-module-head-left">
                    <div class="fp-module-icon" style="background:<?= $mod['bg'] ?>">
                        <i class='bx <?= $mod['icon'] ?>' style="color:<?= $mod['color'] ?>;"></i>
                    </div>
                    <span class="fp-module-name"><?= $mod['nome'] ?></span>
                    <span class="fp-module-count"><?= count($mod['perms']) ?> permissões</span>
                </div>
                <i class='bx bx-chevron-down fp-chevron'></i>
            </div>
            <div class="fp-module-body">
                <div class="fp-perms-grid">
                    <?php foreach ($mod['perms'] as $perm): ?>
                        <label class="fp-perm-item <?= $perm[2] ? 'checked' : '' ?>" onclick="togglePerm(this)">
                            <input type="checkbox" name="<?= $perm[0] ?>" class="marcar" value="1" <?= $perm[2] ? 'checked' : '' ?>>
                            <div class="fp-perm-box"><i class='bx bx-check'></i></div>
                            <span class="fp-perm-label"><?= $perm[1] ?></span>
                        </label>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
        <?php endforeach; ?>

        <div class="fp-actions">
            <button type="submit" class="fp-btn-save">
                <i class='bx bx-shield-plus'></i> Criar Permissão
            </button>
            <a href="<?= site_url() ?>/permissoes" class="fp-btn-back">
                <i class='bx bx-x'></i> Cancelar
            </a>
        </div>

    </form>
</div>

<script>
$(document).ready(function() {

    // Toggle módulo
    window.toggleMod = function(id) {
        var el = document.getElementById(id);
        el.classList.toggle('open');
    };

    // Toggle permissão individual
    window.togglePerm = function(label) {
        var cb = label.querySelector('input[type=checkbox]');
        cb.checked = !cb.checked;
        label.classList.toggle('checked', cb.checked);
        atualizarMarkAll();
    };

    // Marcar todos toggle
    $('#markAllToggle').click(function(e) {
        if ($(e.target).is('input')) return;
        var cb = $('#marcarTodos');
        var novoEstado = !cb.prop('checked');
        cb.prop('checked', novoEstado);
        $(this).toggleClass('checked', novoEstado);
        $('.marcar').each(function() {
            $(this).prop('checked', novoEstado);
            $(this).closest('.fp-perm-item').toggleClass('checked', novoEstado);
        });
    });

    function atualizarMarkAll() {
        var total   = $('.marcar').length;
        var checked = $('.marcar:checked').length;
        var todos   = total === checked;
        $('#marcarTodos').prop('checked', todos);
        $('#markAllToggle').toggleClass('checked', todos);
    }

    // Abrir todos os módulos com itens marcados
    $('.marcar:checked').each(function() {
        $(this).closest('.fp-module').addClass('open');
    });

    // Validação
    $('#formPermissao').validate({
        rules: { nome: { required: true } },
        messages: { nome: { required: 'Informe o nome da permissão' } },
        errorClass: 'error',
        errorElement: 'span'
    });
});
</script>
