<?php
// Helper para verificar se permissão está ativa
function permAtiva($permissoes, $key) {
    return isset($permissoes[$key]) && $permissoes[$key] == '1';
}
function permCheck($permissoes, $key) {
    return permAtiva($permissoes, $key) ? 'checked' : '';
}
// Deserializar permissões do banco
$permissoes = [];
if (!empty($result->permissoes)) {
    $perm = unserialize($result->permissoes);
    if (is_array($perm)) $permissoes = $perm;
}
?>

<style>
/* ── Permissões — Design Moderno ─────────────────────────── */
.perm-wrap        { padding: 0 8px 40px; }
.perm-header      { display:flex;align-items:center;justify-content:space-between;
                    flex-wrap:wrap;gap:12px;margin-bottom:24px;
                    padding:18px 20px;background:#1e2235;border-radius:14px;
                    border:1px solid rgba(255,255,255,0.07); }
.perm-title       { font-size:18px;font-weight:800;color:#e8eaf0;
                    display:flex;align-items:center;gap:8px; }
.perm-meta        { display:flex;align-items:center;gap:12px;flex-wrap:wrap; }
.perm-meta input[type=text] {
                    background:#252a3a;border:1px solid #444860;color:#e8eaf0;
                    border-radius:8px;padding:8px 12px;font-size:13px;min-width:200px; }
.perm-meta select { background:#252a3a;border:1px solid #444860;color:#e8eaf0;
                    border-radius:8px;padding:8px 12px;font-size:13px;cursor:pointer; }
.perm-meta input:focus,.perm-meta select:focus { outline:none;border-color:#f97316; }
.perm-grid        { display:grid;grid-template-columns:repeat(auto-fill,minmax(340px,1fr));
                    gap:14px;margin-bottom:20px; }
.perm-card        { background:#1e2235;border-radius:14px;
                    border:1px solid rgba(255,255,255,0.07);overflow:hidden; }
.perm-card-head   { display:flex;align-items:center;justify-content:space-between;
                    padding:12px 16px;border-bottom:1px solid rgba(255,255,255,0.06);
                    background:#13151f; }
.perm-card-title  { display:flex;align-items:center;gap:8px;
                    font-size:12px;font-weight:800;color:#e8eaf0;
                    text-transform:uppercase;letter-spacing:.5px; }
.perm-card-body   { padding:12px 16px;display:grid;
                    grid-template-columns:1fr 1fr;gap:8px; }
.perm-item        { display:flex;align-items:center;gap:8px;cursor:pointer;
                    padding:7px 10px;border-radius:8px;
                    border:1px solid transparent;transition:all .15s;
                    background:rgba(255,255,255,0.02); }
.perm-item:hover  { background:rgba(255,255,255,0.05);border-color:rgba(255,255,255,0.08); }
.perm-item input[type=checkbox] { display:none; }
.perm-toggle      { width:36px;height:20px;border-radius:10px;background:#252a3a;
                    border:1px solid #444860;position:relative;flex-shrink:0;
                    transition:all .2s; }
.perm-toggle::after { content:'';position:absolute;top:3px;left:3px;
                      width:12px;height:12px;border-radius:50%;
                      background:#6b7280;transition:all .2s; }
.perm-item.ativo .perm-toggle { background:rgba(74,222,128,0.2);border-color:#4ade80; }
.perm-item.ativo .perm-toggle::after { background:#4ade80;transform:translateX(16px); }
.perm-item.ativo  { border-color:rgba(74,222,128,0.2);background:rgba(74,222,128,0.04); }
.perm-lbl         { font-size:12px;font-weight:600;color:#9ca3af;
                    transition:color .15s;user-select:none; }
.perm-item.ativo .perm-lbl { color:#e8eaf0; }
.perm-tipo-v .perm-item.ativo .perm-toggle { background:rgba(96,165,250,0.2);border-color:#60a5fa; }
.perm-tipo-v .perm-item.ativo .perm-toggle::after { background:#60a5fa; }
.perm-tipo-v .perm-item.ativo { border-color:rgba(96,165,250,0.2);background:rgba(96,165,250,0.04); }
.perm-tipo-a .perm-item.ativo .perm-toggle { background:rgba(167,139,250,0.2);border-color:#a78bfa; }
.perm-tipo-a .perm-item.ativo .perm-toggle::after { background:#a78bfa; }
.perm-tipo-a .perm-item.ativo { border-color:rgba(167,139,250,0.2);background:rgba(167,139,250,0.04); }
.perm-tipo-e .perm-item.ativo .perm-toggle { background:rgba(251,191,36,0.2);border-color:#fbbf24; }
.perm-tipo-e .perm-item.ativo .perm-toggle::after { background:#fbbf24; }
.perm-tipo-e .perm-item.ativo { border-color:rgba(251,191,36,0.2);background:rgba(251,191,36,0.04); }
.perm-tipo-d .perm-item.ativo .perm-toggle { background:rgba(248,113,113,0.2);border-color:#f87171; }
.perm-tipo-d .perm-item.ativo .perm-toggle::after { background:#f87171; }
.perm-tipo-d .perm-item.ativo { border-color:rgba(248,113,113,0.2);background:rgba(248,113,113,0.04); }
.perm-sel-all     { font-size:10px;font-weight:700;color:#6b7280;cursor:pointer;
                    padding:3px 8px;border-radius:6px;border:1px solid rgba(255,255,255,0.1);
                    background:rgba(255,255,255,0.04);transition:all .15s;user-select:none; }
.perm-sel-all:hover { color:#e8eaf0;border-color:rgba(255,255,255,0.2); }
.perm-footer      { display:flex;align-items:center;gap:10px;flex-wrap:wrap;
                    padding:16px 20px;background:#1e2235;border-radius:14px;
                    border:1px solid rgba(255,255,255,0.07);margin-top:8px; }
.perm-btn         { display:inline-flex;align-items:center;gap:6px;padding:9px 18px;
                    border-radius:8px;font-size:13px;font-weight:700;
                    text-decoration:none;border:none;cursor:pointer;transition:all .15s; }
.perm-btn-save    { background:linear-gradient(135deg,#4ade80,#16a34a);color:#000; }
.perm-btn-save:hover { opacity:.88; }
.perm-btn-back    { background:rgba(255,255,255,0.07);color:#9ca3af; }
.perm-btn-back:hover { background:rgba(255,255,255,0.12);color:#e8eaf0; }
.perm-marcar-todos{ background:rgba(249,115,22,0.12);color:#f97316;
                    border:1px solid rgba(249,115,22,0.25); }
.perm-marcar-todos:hover { background:rgba(249,115,22,0.2); }
.perm-legenda     { display:flex;gap:14px;flex-wrap:wrap;
                    padding:10px 0;margin-bottom:12px; }
.perm-leg-item    { display:flex;align-items:center;gap:5px;font-size:11px;
                    font-weight:700;color:#6b7280; }
.perm-leg-dot     { width:8px;height:8px;border-radius:50%; }
</style>

<div class="perm-wrap">
<form action="<?php echo base_url();?>index.php/permissoes/editar" id="formPermissao" method="post">
<input type="hidden" name="idPermissao" value="<?php echo $result->idPermissao; ?>">

    <!-- Header -->
    <div class="perm-header">
        <div class="perm-title">
            <i class='bx bx-lock-alt' style="color:#f97316;font-size:22px;"></i>
            Editar Permissão
        </div>
        <div class="perm-meta">
            <div>
                <label style="font-size:10px;font-weight:700;color:#6b7280;text-transform:uppercase;
                              letter-spacing:.5px;display:block;margin-bottom:4px;">Nome</label>
                <input name="nome" type="text" value="<?php echo htmlspecialchars($result->nome); ?>"
                       placeholder="Nome do perfil de acesso" />
            </div>
            <div>
                <label style="font-size:10px;font-weight:700;color:#6b7280;text-transform:uppercase;
                              letter-spacing:.5px;display:block;margin-bottom:4px;">Situação</label>
                <select name="situacao">
                    <option value="1" <?= $result->situacao == 1 ? 'selected' : '' ?>>✅ Ativo</option>
                    <option value="0" <?= $result->situacao != 1 ? 'selected' : '' ?>>⭕ Inativo</option>
                </select>
            </div>
        </div>
    </div>

    <!-- Legenda -->
    <div class="perm-legenda">
        <span class="perm-leg-item">
            <span class="perm-leg-dot" style="background:#60a5fa;"></span> Visualizar
        </span>
        <span class="perm-leg-item">
            <span class="perm-leg-dot" style="background:#a78bfa;"></span> Adicionar
        </span>
        <span class="perm-leg-item">
            <span class="perm-leg-dot" style="background:#fbbf24;"></span> Editar
        </span>
        <span class="perm-leg-item">
            <span class="perm-leg-dot" style="background:#f87171;"></span> Excluir
        </span>
        <span class="perm-leg-item">
            <span class="perm-leg-dot" style="background:#4ade80;"></span> Ativo
        </span>
        <div style="margin-left:auto;">
            <button type="button" class="perm-btn perm-marcar-todos" id="btnMarcarTodos">
                <i class='bx bx-check-double'></i> Marcar Todos
            </button>
            &nbsp;
            <button type="button" class="perm-btn perm-btn-back" id="btnDesmarcarTodos">
                <i class='bx bx-x'></i> Desmarcar Todos
            </button>
        </div>
    </div>

    <!-- Grid de Permissões -->
    <div class="perm-grid">

    <?php
    // Grupos de permissões
    $grupos = [
        ['Clientes',          'bx-group',                '#60a5fa',
         ['vCliente'=>'Visualizar','aCliente'=>'Adicionar','eCliente'=>'Editar','dCliente'=>'Excluir']],
        ['Produtos',          'bx-cube',                 '#a78bfa',
         ['vProduto'=>'Visualizar','aProduto'=>'Adicionar','eProduto'=>'Editar','dProduto'=>'Excluir']],
        ['Serviços',          'bx-stopwatch',            '#fbbf24',
         ['vServico'=>'Visualizar','aServico'=>'Adicionar','eServico'=>'Editar','dServico'=>'Excluir']],
        ['Ordens de Serviço', 'bx-clipboard',            '#34d399',
         ['vOs'=>'Visualizar','aOs'=>'Adicionar','eOs'=>'Editar','dOs'=>'Excluir']],
        ['Soluções Técnicas', 'bx-bulb',                 '#fb923c',
         ['vSolucao'=>'Visualizar','aSolucao'=>'Adicionar','eSolucao'=>'Editar','dSolucao'=>'Excluir']],
        ['Pedidos & Anotações', 'bx-cart-alt',            '#a78bfa',
         ['vPedido'=>'Visualizar','aPedido'=>'Adicionar','ePedido'=>'Editar','dPedido'=>'Excluir']],
        ['Vendas',            'bx-cart',                 '#f97316',
         ['vVenda'=>'Visualizar','aVenda'=>'Adicionar','eVenda'=>'Editar','dVenda'=>'Excluir']],
        ['Cobranças',         'bx-credit-card',          '#fb7185',
         ['vCobranca'=>'Visualizar','aCobranca'=>'Adicionar','eCobranca'=>'Editar','dCobranca'=>'Excluir']],
        ['Garantias',         'bx-shield-quarter',       '#22d3ee',
         ['vGarantia'=>'Visualizar','aGarantia'=>'Adicionar','eGarantia'=>'Editar','dGarantia'=>'Excluir']],
        ['Arquivos',          'bx-folder',               '#60a5fa',
         ['vArquivo'=>'Visualizar','aArquivo'=>'Adicionar','eArquivo'=>'Editar','dArquivo'=>'Excluir']],
        ['Financeiro',        'bx-wallet',               '#4ade80',
         ['vLancamento'=>'Visualizar','aLancamento'=>'Adicionar','eLancamento'=>'Editar','dLancamento'=>'Excluir']],
        ['Relatórios',        'bx-bar-chart-alt-2',      '#fbbf24',
         ['rCliente'=>'Clientes','rServico'=>'Serviços','rOs'=>'OS','rProduto'=>'Produtos','rVenda'=>'Vendas','rFinanceiro'=>'Financeiro']],
        ['Configurações',     'bx-cog',                  '#9ca3af',
         ['cUsuario'=>'Usuários','cEmitente'=>'Emitente','cPermissao'=>'Permissões','cBackup'=>'Backup','cAuditoria'=>'Auditoria','cEmail'=>'Emails','cSistema'=>'Sistema']],
    ];

    $tipoClass = ['v'=>'perm-tipo-v','a'=>'perm-tipo-a','e'=>'perm-tipo-e','d'=>'perm-tipo-d',
                  'r'=>'perm-tipo-v','c'=>'perm-tipo-e'];

    foreach ($grupos as [$titulo, $icon, $cor, $perms]):
    ?>
    <div class="perm-card">
        <div class="perm-card-head">
            <div class="perm-card-title">
                <i class='bx <?= $icon ?>' style="color:<?= $cor ?>;font-size:16px;"></i>
                <?= $titulo ?>
            </div>
            <span class="perm-sel-all" data-grupo="<?= strtolower(str_replace(' ','-',$titulo)) ?>">
                Sel. todos
            </span>
        </div>
        <div class="perm-card-body">
        <?php foreach ($perms as $key => $label):
            $ativo = permAtiva($permissoes, $key);
            $tipo  = $key[0]; // v, a, e, d, r, c
        ?>
            <label class="perm-item <?= $ativo ? 'ativo' : '' ?> <?= $tipoClass[$tipo] ?? '' ?>"
                   data-grupo="<?= strtolower(str_replace(' ','-',$titulo)) ?>">
                <input type="checkbox" name="<?= $key ?>" value="1"
                       class="marcar" <?= $ativo ? 'checked' : '' ?>>
                <span class="perm-toggle"></span>
                <span class="perm-lbl"><?= $label ?></span>
            </label>
        <?php endforeach; ?>
        </div>
    </div>
    <?php endforeach; ?>

    </div><!-- /.perm-grid -->

    <!-- Footer -->
    <div class="perm-footer">
        <button type="submit" class="perm-btn perm-btn-save">
            <i class='bx bx-save'></i> Salvar Permissões
        </button>
        <a href="<?= site_url('permissoes') ?>" class="perm-btn perm-btn-back">
            <i class='bx bx-undo'></i> Voltar
        </a>
        <span style="margin-left:auto;font-size:12px;color:#6b7280;" id="permCounter">
            Carregando...
        </span>
    </div>

</form>
</div>

<script>
// ── Toggle visual dos itens de permissão ──────────────────────────────────
document.querySelectorAll('.perm-item').forEach(function(item) {
    item.addEventListener('click', function() {
        var cb = this.querySelector('input[type=checkbox]');
        cb.checked = !cb.checked;
        this.classList.toggle('ativo', cb.checked);
        atualizarContador();
    });
});

// ── Marcar/desmarcar todos ────────────────────────────────────────────────
document.getElementById('btnMarcarTodos').addEventListener('click', function() {
    document.querySelectorAll('.perm-item input[type=checkbox]').forEach(function(cb) {
        cb.checked = true;
        cb.closest('.perm-item').classList.add('ativo');
    });
    atualizarContador();
});

document.getElementById('btnDesmarcarTodos').addEventListener('click', function() {
    document.querySelectorAll('.perm-item input[type=checkbox]').forEach(function(cb) {
        cb.checked = false;
        cb.closest('.perm-item').classList.remove('ativo');
    });
    atualizarContador();
});

// ── Selecionar todos de um grupo ──────────────────────────────────────────
document.querySelectorAll('.perm-sel-all').forEach(function(btn) {
    btn.addEventListener('click', function(e) {
        e.stopPropagation();
        var grupo = this.dataset.grupo;
        var items = document.querySelectorAll('[data-grupo="'+grupo+'"] input[type=checkbox]');
        var todosAtivos = Array.from(items).every(function(cb) { return cb.checked; });
        items.forEach(function(cb) {
            cb.checked = !todosAtivos;
            cb.closest('.perm-item').classList.toggle('ativo', !todosAtivos);
        });
        atualizarContador();
    });
});

// ── Contador de permissões ────────────────────────────────────────────────
function atualizarContador() {
    var total  = document.querySelectorAll('.perm-item input[type=checkbox]').length;
    var ativos = document.querySelectorAll('.perm-item input[type=checkbox]:checked').length;
    document.getElementById('permCounter').textContent =
        ativos + ' de ' + total + ' permissões ativas';
}
atualizarContador();
</script>
