<script src="<?= base_url() ?>assets/js/jquery.mask.min.js"></script>
<script src="<?= base_url() ?>assets/js/funcoes.js"></script>

<style>
.emit-wrap { padding: 0; }
.emit-header { display: flex; align-items: center; gap: 10px; margin-bottom: 20px; }
.emit-header i { font-size: 20px; color: #22d3ee; }
.emit-header h4 { margin: 0; font-size: 16px; font-weight: 700; color: #e2e4f0; }
.emit-card { background: #181b2a; border: 1px solid rgba(255,255,255,.07); border-radius: 14px; overflow: hidden; margin-bottom: 16px; }
.emit-card-head { display: flex; align-items: center; gap: 9px; padding: 13px 18px; background: #21253a; border-bottom: 1px solid rgba(255,255,255,.06); }
.emit-card-head i { font-size: 16px; }
.emit-card-head span { font-size: 11px; font-weight: 700; color: #9ca3af; text-transform: uppercase; letter-spacing: .7px; }
.emit-card-body { padding: 20px; }
.emit-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 14px; }
.emit-grid-3 { display: grid; grid-template-columns: 2fr 1fr 1fr; gap: 14px; }

/* ── Modais desta tela (Emitente) — escopado por ID, não mexe nos
   modais de outras telas do sistema que usam as mesmas classes. ── */
#modalEditar .modal-header, #modalCadastrar .modal-header{
    background:linear-gradient(135deg,#a78bfa,#7c3aed) !important;
    border-bottom:none !important;
}
#modalEditar .modal-header h5, #modalCadastrar .modal-header h5,
#modalEditar .modal-header .close, #modalCadastrar .modal-header .close{
    color:#fff !important;
}
#modalEditar .button.btn-success, #modalCadastrar .button.btn-success{
    background:linear-gradient(135deg,#a78bfa,#7c3aed) !important;
    border:none !important;
    border-radius:8px !important;
    box-shadow:0 4px 14px rgba(167,139,250,0.3);
    transition:transform .15s;
}
#modalEditar .button.btn-warning, #modalCadastrar .button.btn-warning{
    background:#252a3a !important;
    color:#e8eaf0 !important;
    border:1px solid rgba(255,255,255,0.1) !important;
    border-radius:8px !important;
    transition:transform .15s;
}
#modalEditar .button.btn-success:hover, #modalCadastrar .button.btn-success:hover,
#modalEditar .button.btn-warning:hover, #modalCadastrar .button.btn-warning:hover{
    transform:translateY(-1px);
}
.emit-grid-4 { display: grid; grid-template-columns: 1fr 1fr 1fr 1fr; gap: 14px; }
@media(max-width:600px){.emit-grid,.emit-grid-3,.emit-grid-4{grid-template-columns:1fr;}}
.emit-field { display: flex; flex-direction: column; gap: 5px; }
.emit-label { font-size: 11px; font-weight: 700; color: #6b7280; text-transform: uppercase; letter-spacing: .5px; }
.emit-input { background: #13151f; border: 1px solid #3b3f58; color: #e2e4f0; border-radius: 8px; padding: 9px 12px; font-size: 13px; transition: border-color .15s; width: 100%; box-sizing: border-box; }
.emit-input:focus { border-color: #22d3ee; outline: none; }
.emit-input::placeholder { color: #4b5563; }
.emit-logo-preview { display: flex; align-items: center; gap: 12px; padding: 10px 14px; background: #252a3a; border-radius: 10px; border: 1px dashed rgba(255,255,255,.1); margin-bottom: 10px; }
.emit-logo-preview img { max-height: 48px; max-width: 160px; object-fit: contain; }
.emit-logo-preview span { font-size: 11px; color: #6b7280; }
.emit-alert-empty { background: rgba(239,68,68,.08); border: 1px solid rgba(239,68,68,.2); border-radius: 10px; padding: 16px 18px; display: flex; align-items: center; gap: 10px; margin-bottom: 20px; }
.emit-alert-empty i { font-size: 20px; color: #f87171; flex-shrink: 0; }
.emit-alert-empty p { margin: 0; font-size: 13px; color: #f87171; }
.btn-emit-primary { display: inline-flex; align-items: center; gap: 7px; padding: 10px 22px; background: linear-gradient(135deg,#22d3ee,#0891b2); color: #fff; border: none; border-radius: 8px; font-size: 13px; font-weight: 700; cursor: pointer; transition: opacity .15s; }
.btn-emit-primary:hover { opacity: .85; color: #fff; }
.btn-emit-add { display: inline-flex; align-items: center; gap: 7px; padding: 9px 18px; background: linear-gradient(135deg,#22c55e,#16a34a); color: #fff; border: none; border-radius: 8px; font-size: 13px; font-weight: 700; cursor: pointer; text-decoration: none; transition: opacity .15s; }
.btn-emit-add:hover { opacity: .85; color: #fff; }
.emit-info-row { display: flex; align-items: center; justify-content: space-between; padding: 10px 0; border-bottom: 1px solid rgba(255,255,255,.04); }
.emit-info-row:last-child { border-bottom: none; }
.emit-info-label { font-size: 12px; color: #6b7280; display: flex; align-items: center; gap: 6px; }
.emit-info-label i { font-size: 14px; }
.emit-info-value { font-size: 13px; color: #e2e4f0; font-weight: 500; }
</style>

<div class="emit-wrap">
    <div class="emit-header">
        <i class='bx bx-building-house'></i>
        <h4>Dados do Emitente</h4>
    </div>

    <?php if (!isset($dados) || $dados == null): ?>

        <div class="emit-alert-empty">
            <i class='bx bx-error-circle'></i>
            <p>Nenhum dado cadastrado ainda. Essas informações são exibidas na impressão de OS e documentos.</p>
        </div>

        <a href="#modalCadastrar" data-toggle="modal" role="button" class="btn-emit-add">
            <i class='bx bx-plus-circle'></i> Cadastrar Dados do Emitente
        </a>

    <?php else: ?>

        <!-- Dados cadastrados: exibir cards -->
        <div class="emit-card">
            <div class="emit-card-head">
                <i class='bx bx-id-card' style="color:#22d3ee;"></i>
                <span>Identificação</span>
            </div>
            <div class="emit-card-body">
                <?php if (!empty($dados->url_logo)): ?>
                <div class="emit-logo-preview">
                    <img src="<?= strpos($dados->url_logo, 'http') === 0 ? $dados->url_logo : base_url($dados->url_logo) ?>" alt="Logo do emitente">
                    <span>Logo atual</span>
                </div>
                <?php endif; ?>
                <div class="emit-grid" style="margin-top:<?= !empty($dados->url_logo) ? '10px' : '0'; ?>">
                    <div>
                        <div class="emit-info-row">
                            <span class="emit-info-label"><i class='bx bx-buildings'></i> Razão Social</span>
                            <span class="emit-info-value"><?= htmlspecialchars($dados->nome) ?></span>
                        </div>
                        <div class="emit-info-row">
                            <span class="emit-info-label"><i class='bx bx-hash'></i> CNPJ</span>
                            <span class="emit-info-value"><?= htmlspecialchars($dados->cnpj) ?></span>
                        </div>
                        <div class="emit-info-row">
                            <span class="emit-info-label"><i class='bx bx-receipt'></i> IE</span>
                            <span class="emit-info-value"><?= htmlspecialchars($dados->ie) ?: '—' ?></span>
                        </div>
                    </div>
                    <div>
                        <div class="emit-info-row">
                            <span class="emit-info-label"><i class='bx bx-phone'></i> Telefone</span>
                            <span class="emit-info-value"><?= htmlspecialchars($dados->telefone) ?></span>
                        </div>
                        <div class="emit-info-row">
                            <span class="emit-info-label"><i class='bx bx-envelope'></i> E-mail</span>
                            <span class="emit-info-value"><?= htmlspecialchars($dados->email) ?></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="emit-card">
            <div class="emit-card-head">
                <i class='bx bx-map-pin' style="color:#fb923c;"></i>
                <span>Endereço</span>
            </div>
            <div class="emit-card-body">
                <div class="emit-grid">
                    <div class="emit-info-row">
                        <span class="emit-info-label"><i class='bx bx-road'></i> Logradouro</span>
                        <span class="emit-info-value"><?= htmlspecialchars($dados->rua) ?></span>
                    </div>
                    <div class="emit-info-row">
                        <span class="emit-info-label"><i class='bx bx-hash'></i> Número</span>
                        <span class="emit-info-value"><?= htmlspecialchars($dados->numero) ?></span>
                    </div>
                    <div class="emit-info-row">
                        <span class="emit-info-label"><i class='bx bx-map'></i> Bairro</span>
                        <span class="emit-info-value"><?= htmlspecialchars($dados->bairro) ?></span>
                    </div>
                    <div class="emit-info-row">
                        <span class="emit-info-label"><i class='bx bx-building'></i> Cidade</span>
                        <span class="emit-info-value"><?= htmlspecialchars($dados->cidade) ?></span>
                    </div>
                    <div class="emit-info-row">
                        <span class="emit-info-label"><i class='bx bx-flag'></i> UF</span>
                        <span class="emit-info-value"><?= htmlspecialchars($dados->uf) ?></span>
                    </div>
                    <div class="emit-info-row">
                        <span class="emit-info-label"><i class='bx bx-location-plus'></i> CEP</span>
                        <span class="emit-info-value"><?= htmlspecialchars($dados->cep) ?></span>
                    </div>
                </div>
            </div>
        </div>

        <a href="#modalEditar" data-toggle="modal" role="button" class="btn-emit-primary">
            <i class='bx bx-edit-alt'></i> Editar Dados
        </a>

    <?php endif; ?>
</div>

<!-- Modal Cadastrar -->
<div id="modalCadastrar" class="modal hide fade" tabindex="-1" role="dialog" aria-hidden="true">
    <form action="<?= site_url('sisos/cadastrarEmitente') ?>" id="formCadastrar" enctype="multipart/form-data" method="post">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            <h5>Cadastrar Dados do Emitente</h5>
        </div>
        <div class="modal-body" style="padding:20px;">
            <div class="emit-grid" style="margin-bottom:12px;">
                <div class="emit-field">
                    <label class="emit-label">Razão Social *</label>
                    <input type="text" name="nome" class="emit-input" placeholder="Nome da empresa" id="nomeEmitente" />
                </div>
                <div class="emit-field">
                    <label class="emit-label">CNPJ *</label>
                    <input type="text" name="cnpj" class="emit-input cnpjEmitente" id="documento" placeholder="00.000.000/0000-00" />
                </div>
            </div>
            <div class="emit-grid" style="margin-bottom:12px;">
                <div class="emit-field">
                    <label class="emit-label">IE</label>
                    <input type="text" name="ie" class="emit-input" placeholder="Inscrição Estadual" />
                </div>
                <div class="emit-field">
                    <label class="emit-label">CEP *</label>
                    <input type="text" name="cep" class="emit-input" id="cep" placeholder="00000-000" />
                </div>
            </div>
            <div class="emit-grid-3" style="margin-bottom:12px;">
                <div class="emit-field">
                    <label class="emit-label">Logradouro *</label>
                    <input type="text" name="logradouro" class="emit-input" id="rua" placeholder="Rua / Av." />
                </div>
                <div class="emit-field">
                    <label class="emit-label">Número *</label>
                    <input type="text" name="numero" class="emit-input" id="numero" placeholder="Nº" />
                </div>
                <div class="emit-field">
                    <label class="emit-label">UF *</label>
                    <input type="text" name="uf" class="emit-input" id="estado" placeholder="MA" maxlength="2" />
                </div>
            </div>
            <div class="emit-grid" style="margin-bottom:12px;">
                <div class="emit-field">
                    <label class="emit-label">Bairro *</label>
                    <input type="text" name="bairro" class="emit-input" id="bairro" placeholder="Bairro" />
                </div>
                <div class="emit-field">
                    <label class="emit-label">Cidade *</label>
                    <input type="text" name="cidade" class="emit-input" id="cidade" placeholder="Cidade" />
                </div>
            </div>
            <div class="emit-grid" style="margin-bottom:12px;">
                <div class="emit-field">
                    <label class="emit-label">Telefone *</label>
                    <input type="text" name="telefone" class="emit-input" id="telefone" placeholder="(00) 00000-0000" />
                </div>
                <div class="emit-field">
                    <label class="emit-label">E-mail *</label>
                    <input type="text" name="email" class="emit-input" id="email" placeholder="contato@empresa.com" />
                </div>
            </div>
            <div class="emit-field">
                <label class="emit-label">Logo da Empresa</label>
                <input type="file" name="userfile" class="emit-input" accept="image/*" />
            </div>
        </div>
        <div class="modal-footer" style="display:flex;justify-content:flex-end;gap:8px;">
            <button type="button" class="button btn btn-warning" data-dismiss="modal">
                <span class="button__icon"><i class="bx bx-x"></i></span><span class="button__text2">Cancelar</span>
            </button>
            <button type="submit" class="button btn btn-success">
                <span class="button__icon"><i class='bx bx-save'></i></span><span class="button__text2">Cadastrar</span>
            </button>
        </div>
    </form>
</div>

<!-- Modal Editar -->
<?php if (isset($dados) && $dados): ?>
<div id="modalEditar" class="modal hide fade" tabindex="-1" role="dialog" aria-hidden="true">
    <form action="<?= site_url('sisos/editarEmitente') ?>" id="formEditar" enctype="multipart/form-data" method="post">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            <h5>Editar Dados do Emitente</h5>
        </div>
        <div class="modal-body" style="padding:20px;">
            <input type="hidden" name="id" value="<?= $dados->id ?>" />
            <div class="emit-grid" style="margin-bottom:12px;">
                <div class="emit-field">
                    <label class="emit-label">Razão Social *</label>
                    <input type="text" name="nome" class="emit-input" value="<?= htmlspecialchars($dados->nome) ?>" id="nomeEmitente" />
                </div>
                <div class="emit-field">
                    <label class="emit-label">CNPJ *</label>
                    <input type="text" name="cnpj" class="emit-input cnpjEmitente" id="documento" value="<?= htmlspecialchars($dados->cnpj) ?>" />
                </div>
            </div>
            <div class="emit-grid" style="margin-bottom:12px;">
                <div class="emit-field">
                    <label class="emit-label">IE</label>
                    <input type="text" name="ie" class="emit-input" value="<?= htmlspecialchars($dados->ie) ?>" />
                </div>
                <div class="emit-field">
                    <label class="emit-label">CEP *</label>
                    <input type="text" name="cep" class="emit-input" id="cep" value="<?= htmlspecialchars($dados->cep) ?>" />
                </div>
            </div>
            <div class="emit-grid-3" style="margin-bottom:12px;">
                <div class="emit-field">
                    <label class="emit-label">Logradouro *</label>
                    <input type="text" name="logradouro" class="emit-input" id="rua" value="<?= htmlspecialchars($dados->rua) ?>" />
                </div>
                <div class="emit-field">
                    <label class="emit-label">Número *</label>
                    <input type="text" name="numero" class="emit-input" id="numero" value="<?= htmlspecialchars($dados->numero) ?>" />
                </div>
                <div class="emit-field">
                    <label class="emit-label">UF *</label>
                    <input type="text" name="uf" class="emit-input" id="estado" value="<?= htmlspecialchars($dados->uf) ?>" maxlength="2" />
                </div>
            </div>
            <div class="emit-grid" style="margin-bottom:12px;">
                <div class="emit-field">
                    <label class="emit-label">Bairro *</label>
                    <input type="text" name="bairro" class="emit-input" id="bairro" value="<?= htmlspecialchars($dados->bairro) ?>" />
                </div>
                <div class="emit-field">
                    <label class="emit-label">Cidade *</label>
                    <input type="text" name="cidade" class="emit-input" id="cidade" value="<?= htmlspecialchars($dados->cidade) ?>" />
                </div>
            </div>
            <div class="emit-grid" style="margin-bottom:12px;">
                <div class="emit-field">
                    <label class="emit-label">Telefone *</label>
                    <input type="text" name="telefone" class="emit-input" id="telefone" value="<?= htmlspecialchars($dados->telefone) ?>" />
                </div>
                <div class="emit-field">
                    <label class="emit-label">E-mail *</label>
                    <input type="text" name="email" class="emit-input" id="email" value="<?= htmlspecialchars($dados->email) ?>" />
                </div>
            </div>
            <div class="emit-field">
                <label class="emit-label">Nova Logo (opcional)</label>
                <?php if (!empty($dados->url_logo)): ?>
                    <div class="emit-logo-preview" style="margin-bottom:8px;">
                        <img src="<?= strpos($dados->url_logo, 'http') === 0 ? $dados->url_logo : base_url($dados->url_logo) ?>" alt="Logo atual">
                        <span>Logo atual — envie um novo arquivo para substituir</span>
                    </div>
                <?php endif; ?>
                <input type="file" name="userfile" class="emit-input" accept="image/*" />
            </div>
        </div>
        <div class="modal-footer" style="display:flex;justify-content:flex-end;gap:8px;">
            <button type="button" class="button btn btn-warning" data-dismiss="modal">
                <span class="button__icon"><i class="bx bx-x"></i></span><span class="button__text2">Cancelar</span>
            </button>
            <button type="submit" class="button btn btn-success">
                <span class="button__icon"><i class='bx bx-save'></i></span><span class="button__text2">Salvar</span>
            </button>
        </div>
    </form>
</div>
<?php endif; ?>
