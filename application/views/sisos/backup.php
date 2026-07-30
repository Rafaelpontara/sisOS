<style>
.bk-header { display: flex; align-items: center; gap: 10px; margin-bottom: 20px; }
.bk-header i { font-size: 20px; color: #fb923c; }
.bk-header h4 { margin: 0; font-size: 16px; font-weight: 700; color: #e2e4f0; }
.bk-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 16px; margin-bottom: 20px; }
@media(max-width:640px){ .bk-grid { grid-template-columns: 1fr; } }
.bk-card { background: #181b2a; border: 1px solid rgba(255,255,255,.07); border-radius: 12px; overflow: hidden; }
.bk-card-head { display: flex; align-items: center; gap: 10px; padding: 14px 18px; background: #21253a; border-bottom: 1px solid rgba(255,255,255,.06); }
.bk-card-head i { font-size: 18px; }
.bk-card-head span { font-size: 12px; font-weight: 700; color: #9ca3af; text-transform: uppercase; letter-spacing: .6px; }
.bk-card-body { padding: 18px; }
.bk-desc { font-size: 13px; color: #6b7280; margin-bottom: 16px; line-height: 1.6; }
.bk-info-row { display: flex; align-items: center; gap: 8px; font-size: 12px; color: #9ca3af; margin-bottom: 8px; }
.bk-info-row i { font-size: 14px; color: #fb923c; }
.bk-btn { display: inline-flex; align-items: center; gap: 7px; padding: 10px 20px; border-radius: 8px; font-size: 13px; font-weight: 700; cursor: pointer; text-decoration: none; border: none; transition: all .15s; width: 100%; justify-content: center; margin-top: 4px; }
.bk-btn-db { background: linear-gradient(135deg, #fb923c, #ea580c); color: #fff; }
.bk-btn-db:hover { opacity: .88; color: #fff; }
.bk-btn-files { background: linear-gradient(135deg, #7c6af7, #5b4de0); color: #fff; }
.bk-btn-files:hover { opacity: .88; color: #fff; }
.bk-btn-full { background: linear-gradient(135deg, #059669, #047857); color: #fff; }
.bk-btn-full:hover { opacity: .88; color: #fff; }
.bk-warning { background: rgba(245,158,11,.08); border: 1px solid rgba(245,158,11,.2); border-radius: 10px; padding: 14px 16px; display: flex; gap: 10px; align-items: flex-start; margin-bottom: 20px; }
.bk-warning i { font-size: 18px; color: #f59e0b; flex-shrink: 0; margin-top: 1px; }
.bk-warning p { margin: 0; font-size: 13px; color: #d97706; line-height: 1.5; }
.bk-history { background: #181b2a; border: 1px solid rgba(255,255,255,.07); border-radius: 12px; overflow: hidden; }
.bk-history-head { display: flex; align-items: center; justify-content: space-between; padding: 14px 18px; background: #21253a; border-bottom: 1px solid rgba(255,255,255,.06); }
.bk-history-head span { font-size: 12px; font-weight: 700; color: #9ca3af; text-transform: uppercase; letter-spacing: .6px; display: flex; align-items: center; gap: 8px; }
.bk-history-head i { font-size: 16px; color: #fb923c; }
.bk-history-empty { text-align: center; padding: 30px; color: #4b5563; font-size: 13px; }
</style>

<div class="pg-wrap">
    <div class="bk-header">
        <i class='bx bx-cloud-download'></i>
        <h4>Backup do Sistema</h4>
    </div>

    <div class="bk-warning">
        <i class='bx bx-info-circle'></i>
        <p>Recomendamos realizar backups regularmente. Faça sempre um backup antes de atualizar o sistema ou o banco de dados.</p>
    </div>

    <div class="bk-grid">
        <!-- Backup do Banco -->
        <div class="bk-card">
            <div class="bk-card-head">
                <i class='bx bx-data' style="color:#fb923c;"></i>
                <span>Banco de Dados</span>
            </div>
            <div class="bk-card-body">
                <p class="bk-desc">Exporta todas as tabelas e dados do banco de dados em formato <strong style="color:#e2e4f0;">.SQL</strong>, pronto para restauração.</p>
                <div class="bk-info-row"><i class='bx bx-check-circle'></i> Inclui estrutura e dados</div>
                <div class="bk-info-row"><i class='bx bx-check-circle'></i> Formato compatível com phpMyAdmin</div>
                <div class="bk-info-row"><i class='bx bx-time-five'></i> Rápido — gerado instantaneamente</div>
                <a href="<?= site_url('sisos/backup') ?>" class="bk-btn bk-btn-db" style="margin-top:16px;">
                    <i class='bx bx-download'></i> Baixar Backup SQL
                </a>
            </div>
        </div>

        <!-- Backup de Arquivos -->
        <div class="bk-card">
            <div class="bk-card-head">
                <i class='bx bx-folder-open' style="color:#7c6af7;"></i>
                <span>Arquivos &amp; Anexos</span>
            </div>
            <div class="bk-card-body">
                <p class="bk-desc">Compacta os arquivos enviados (anexos, imagens de OS, uploads de clientes) em um <strong style="color:#e2e4f0;">.ZIP</strong>.</p>
                <div class="bk-info-row"><i class='bx bx-check-circle'></i> Diretório <code style="font-size:11px;color:#a79cf7;">/assets/uploads</code></div>
                <div class="bk-info-row"><i class='bx bx-check-circle'></i> Diretório <code style="font-size:11px;color:#a79cf7;">/assets/anexos</code></div>
                <div class="bk-info-row"><i class='bx bx-error-circle' style="color:#f59e0b;"></i> Pode demorar dependendo do volume</div>
                <a href="<?= site_url('sisos/backupArquivos') ?>" class="bk-btn bk-btn-files" style="margin-top:16px;">
                    <i class='bx bx-archive'></i> Baixar Arquivos ZIP
                </a>
            </div>
        </div>
    </div>

    <!-- Seção de atualização do sistema -->
    <div class="bk-card" style="margin-bottom:16px;">
        <div class="bk-card-head">
            <i class='bx bx-sync' style="color:#34d399;"></i>
            <span>Atualizações do Sistema</span>
        </div>
        <div class="bk-card-body">
            <div class="bk-grid" style="margin-bottom:0;">
                <div>
                    <p class="bk-desc">Atualiza o <strong style="color:#e2e4f0;">banco de dados</strong> para a versão mais recente do SISOS, aplicando migrações pendentes.</p>
                    <button href="#modal-confirmabanco" data-toggle="modal" type="button" class="bk-btn" style="background:rgba(245,158,11,.15);color:#fbbf24;border:1px solid rgba(245,158,11,.25);margin-top:0;">
                        <i class='bx bx-data'></i> Atualizar Banco de Dados
                    </button>
                </div>
                <div>
                    <p class="bk-desc">Atualiza os <strong style="color:#e2e4f0;">arquivos do sistema</strong> para a versão mais recente. Faça backup antes de continuar.</p>
                    <button href="#modal-confirmaratualiza" data-toggle="modal" type="button" class="bk-btn" style="background:rgba(239,68,68,.1);color:#f87171;border:1px solid rgba(239,68,68,.2);margin-top:0;">
                        <i class='bx bx-sync'></i> Atualizar Sistema
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Atualizar Sistema -->
<div id="modal-confirmaratualiza" class="modal hide fade" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
        <h5>Atualização do Sistema</h5>
    </div>
    <div class="modal-body" style="text-align:center;padding:24px;">
        <i class='bx bx-error' style="font-size:40px;color:#f87171;display:block;margin-bottom:10px;"></i>
        <p style="color:#c9cad6;margin:0 0 8px;">Deseja realmente atualizar o sistema?</p>
        <p style="color:#6b7280;font-size:12px;margin:0;">Os seguintes diretórios serão removidos durante a atualização:</p>
        <code style="font-size:12px;color:#f87171;display:block;margin-top:8px;">./assets/anexos &nbsp; ./assets/arquivos</code>
    </div>
    <div class="modal-footer" style="display:flex;justify-content:center;gap:8px;">
        <button class="button btn btn-danger" data-dismiss="modal">
            <span class="button__icon"><i class='bx bx-x'></i></span><span class="button__text2">Cancelar</span>
        </button>
        <button id="update-sisos" type="button" class="button btn btn-warning">
            <span class="button__icon"><i class="bx bx-sync"></i></span><span class="button__text2">Atualizar</span>
        </button>
    </div>
</div>

<!-- Modal Atualizar Banco -->
<div id="modal-confirmabanco" class="modal hide fade" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
        <h5>Atualização do Banco de Dados</h5>
    </div>
    <div class="modal-body" style="text-align:center;padding:24px;">
        <i class='bx bx-data' style="font-size:40px;color:#fbbf24;display:block;margin-bottom:10px;"></i>
        <p style="color:#c9cad6;margin:0 0 8px;">Deseja atualizar o banco de dados?</p>
        <p style="color:#6b7280;font-size:12px;margin:0;">Recomendamos fazer um backup antes de prosseguir.</p>
        <a href="<?= site_url('sisos/backup') ?>" class="bk-btn bk-btn-db" style="margin-top:14px;max-width:200px;display:inline-flex;">
            <i class='bx bx-download'></i> Fazer Backup Agora
        </a>
    </div>
    <div class="modal-footer" style="display:flex;justify-content:center;gap:8px;">
        <button class="button btn btn-danger" data-dismiss="modal">
            <span class="button__icon"><i class='bx bx-x'></i></span><span class="button__text2">Cancelar</span>
        </button>
        <button id="update-database" type="button" class="button btn btn-warning">
            <span class="button__icon"><i class="bx bx-sync"></i></span><span class="button__text2">Atualizar Banco</span>
        </button>
    </div>
</div>

<script>
$('#update-database').click(function() { window.location = "<?= site_url('sisos/atualizarBanco') ?>"; });
$('#update-sisos').click(function() { window.location = "<?= site_url('sisos/atualizarSisos') ?>"; });
</script>
