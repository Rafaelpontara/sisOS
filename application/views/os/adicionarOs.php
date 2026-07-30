<link rel="stylesheet" href="<?= base_url() ?>assets/js/jquery-ui/css/smoothness/jquery-ui-1.9.2.custom.css" />
<link rel="stylesheet" href="<?= base_url() ?>assets/trumbowyg/ui/trumbowyg.css">
<link rel="stylesheet" href="<?= base_url() ?>assets/css/custom.css" />
<script src="<?= base_url() ?>assets/js/jquery-ui/js/jquery-ui-1.9.2.custom.js"></script>
<script src="<?= base_url() ?>assets/js/jquery.validate.js"></script>
<script src="<?= base_url() ?>assets/trumbowyg/trumbowyg.js"></script>
<script src="<?= base_url() ?>assets/trumbowyg/langs/pt_br.js"></script>


    <style>
    .sd-card { background:#161925; border-radius:16px; padding:22px; text-align:center; }
    .sd-sub { font-size:12px; color:#6b7280; margin:-6px 0 18px; }
    .sd-toggle { display:inline-flex; background:#1e2235; border-radius:12px; padding:4px; gap:4px; margin-bottom:22px; }
    .sd-toggle-btn {
        padding:9px 20px; border-radius:9px; font-size:13px; font-weight:700;
        color:#6b7280; cursor:pointer; border:none; background:transparent; transition:all .15s;
    }
    .sd-toggle-btn.ativo { background:#2e3447; color:#e8eaf0; box-shadow:0 2px 8px rgba(0,0,0,0.3); }
    .sd-pin-input {
        width:100%; max-width:280px; margin:0 auto; display:block;
        background:#1e2235; border:1.5px solid #444860; border-radius:12px;
        padding:16px; font-size:22px; font-weight:700; letter-spacing:8px;
        text-align:center; color:#e8eaf0;
    }
    .sd-pin-input:focus { outline:none; border-color:#a78bfa; }
    .sd-hint { font-size:11.5px; color:#6b7280; margin-top:10px; }
    .sd-grid-wrap { display:flex; flex-direction:column; align-items:center; position:relative; }
    .sd-grid-badge {
        position:absolute; top:-6px; right:calc(50% - 100px); background:#2563eb; color:#fff;
        font-size:10.5px; font-weight:700; padding:2px 9px; border-radius:20px;
    }
    .sd-grid { display:grid; grid-template-columns:repeat(3,1fr); gap:14px; background:#12141d; border-radius:16px; padding:22px; position:relative; }
    .sd-dot {
        width:16px; height:16px; border-radius:50%; background:#374151;
        cursor:pointer; transition:background .1s, box-shadow .1s; margin:0 auto;
        position:relative; z-index:2;
    }
    .sd-dot.selecionado { background:#3b82f6; box-shadow:0 0 0 5px rgba(59,130,246,0.25); }
    .sd-dot.inicio::after {
        content:''; position:absolute; inset:-9px; border:2px solid #22c55e; border-radius:50%;
    }
    </style>

    <style>
/* ── Layout ── */
.aos-wrap{max-width:1100px;margin:0 auto;}
.aos-header{display:flex;align-items:center;justify-content:space-between;margin-bottom:20px;flex-wrap:wrap;gap:10px;}
.aos-title{display:flex;align-items:center;gap:10px;}
.aos-title i{font-size:24px;color:#fbbf24;}
.aos-title h2{font-size:20px;font-weight:800;color:#e8eaf0;margin:0;}

/* ── Tabs ── */
.aos-tabs{display:flex;gap:4px;border-bottom:2px solid rgba(255,255,255,0.07);margin-bottom:20px;}
.aos-tab{display:flex;align-items:center;gap:6px;padding:10px 18px;font-size:13px;font-weight:700;color:#6b7280;cursor:pointer;border-bottom:3px solid transparent;margin-bottom:-2px;transition:all .15s;text-decoration:none;background:none;border-top:none;border-left:none;border-right:none;}
.aos-tab:hover{color:#e8eaf0;}
.aos-tab.active{color:#fbbf24;border-bottom-color:#fbbf24;}
.aos-tab i{font-size:16px;}
.aos-tab-pane{display:none;}
.aos-tab-pane.active{display:block;}

/* ── Seções do formulário ── */
.aos-section{background:#1a1d2e;border:1px solid rgba(255,255,255,0.07);border-radius:14px;margin-bottom:14px;overflow:hidden;}
.aos-section-head{display:flex;align-items:center;gap:8px;padding:11px 16px;border-bottom:1px solid rgba(255,255,255,0.06);background:#252a3a;}
.aos-section-head i{font-size:15px;color:#fbbf24;}
.aos-section-head span{font-size:11px;font-weight:700;color:#9ca3af;text-transform:uppercase;letter-spacing:.8px;}
.aos-section-body{padding:16px;}

/* ── Grid de campos ── */
.aos-grid{display:flex;gap:12px;flex-wrap:wrap;}
.aos-col{flex:1;min-width:180px;}
.aos-col-2{flex:2;min-width:260px;}
.aos-col-full{flex:0 0 100%;}

/* ── Campos ── */
.aos-label{font-size:11px;font-weight:700;color:#9ca3af;text-transform:uppercase;letter-spacing:.5px;display:block;margin-bottom:5px;}
.aos-label .req{color:#f87171;margin-left:2px;}
.aos-input, .aos-select, .aos-textarea{width:100%;background:#13151f;border:1px solid #444860;color:#e8eaf0;border-radius:8px;padding:8px 12px;font-size:13px;box-sizing:border-box;transition:border-color .15s;}
.aos-input:focus, .aos-select:focus, .aos-textarea:focus{border-color:#6366f1;outline:none;}
.aos-select{height:36px;}
.aos-textarea{min-height:110px;resize:vertical;}
.aos-input-group{display:flex;gap:6px;align-items:center;}
.aos-input-group .aos-input{flex:1;}
.aos-hint{font-size:11px;color:#6b7280;margin-top:3px;}

/* ── Alert vínculo OS ── */
.aos-alert-link{display:flex;align-items:center;gap:8px;background:rgba(245,158,11,0.1);border:1px solid rgba(245,158,11,0.3);border-radius:8px;padding:10px 14px;font-size:13px;color:#fbbf24;margin-bottom:14px;}
.aos-alert-link a{color:#fde68a;font-weight:700;}
.aos-alert-err{background:rgba(239,68,68,0.1);border:1px solid rgba(239,68,68,0.3);border-radius:8px;padding:10px 14px;font-size:13px;color:#f87171;margin-bottom:14px;display:flex;gap:8px;align-items:flex-start;}

/* ── Checklist ── */
.aos-check-item{display:flex;align-items:center;gap:8px;padding:8px 10px;border-radius:8px;transition:background .12s;cursor:pointer;}
.aos-check-item:hover{background:rgba(255,255,255,0.04);}
.aos-check-item input[type=checkbox]{width:16px;height:16px;accent-color:#6366f1;flex-shrink:0;}
.aos-check-item label{font-size:13px;color:#c9cad6;margin:0;cursor:pointer;}
.aos-check-grid{display:grid;grid-template-columns:repeat(auto-fill,minmax(220px,1fr));gap:4px;margin-bottom:14px;}

/* ── Foto preview ── */
.aos-foto-preview{display:flex;gap:8px;flex-wrap:wrap;margin-top:8px;}
.aos-foto-preview img{height:80px;width:80px;object-fit:cover;border-radius:8px;border:2px solid rgba(255,255,255,0.1);}

/* ── Recorrência ── */
.aos-rec-box{background:rgba(99,102,241,0.08);border:1px solid rgba(99,102,241,0.25);border-radius:10px;padding:14px;margin-top:10px;}
.aos-info-box{background:rgba(59,130,246,0.08);border:1px solid rgba(59,130,246,0.25);border-radius:8px;padding:10px 14px;font-size:12px;color:#93c5fd;display:flex;gap:8px;align-items:flex-start;}

/* ── Botões de ação ── */
.aos-footer{display:flex;align-items:center;justify-content:flex-end;gap:8px;padding:16px;border-top:1px solid rgba(255,255,255,0.06);background:#1a1d2e;border-radius:0 0 14px 14px;}
.aos-btn{display:inline-flex;align-items:center;gap:6px;padding:9px 20px;border-radius:8px;font-size:13px;font-weight:700;text-decoration:none;border:none;cursor:pointer;transition:all .15s;}
.aos-btn:hover{transform:translateY(-1px);text-decoration:none;}
.aos-btn-save{background:linear-gradient(135deg,#22c55e,#16a34a);color:#fff;box-shadow:0 4px 12px rgba(34,197,94,0.3);}
.aos-btn-back{background:rgba(255,255,255,0.07);color:#9ca3af;border:1px solid rgba(255,255,255,0.1);}
.aos-btn-back:hover{background:rgba(255,255,255,0.12);color:#e8eaf0;}
.aos-btn-new-client{display:inline-flex;align-items:center;gap:4px;padding:7px 12px;background:linear-gradient(135deg,#22c55e,#16a34a);color:#fff;border-radius:8px;font-size:12px;font-weight:700;text-decoration:none;border:none;cursor:pointer;white-space:nowrap;flex-shrink:0;}

/* ── Modal dark ── */
.modal-dark .modal-header{background:#1a1d2e;border-bottom:1px solid rgba(255,255,255,0.08);padding:14px 18px;display:flex;align-items:center;justify-content:space-between;}
.modal-dark .modal-header h4{margin:0;font-size:15px;font-weight:800;color:#e8eaf0;display:flex;align-items:center;gap:8px;}
.modal-dark .modal-header .close{color:#9ca3af;font-size:20px;background:none;border:none;cursor:pointer;}
.modal-dark .modal-body{background:#13151f;padding:18px;}
.modal-dark .modal-footer{background:#1a1d2e;border-top:1px solid rgba(255,255,255,0.08);padding:10px 18px;display:flex;justify-content:flex-end;gap:8px;}
.modal-dark .form-group{margin-bottom:12px;}
.modal-dark label{font-size:11px;font-weight:700;color:#9ca3af;text-transform:uppercase;letter-spacing:.5px;display:block;margin-bottom:4px;}
.modal-dark input[type=text]{width:100%;background:#1e2133;border:1px solid #444860;color:#e8eaf0;border-radius:8px;padding:8px 12px;font-size:13px;box-sizing:border-box;}
.modal-dark input:focus{border-color:#6366f1;outline:none;}
.modal-dark .hint{font-size:11px;color:#6b7280;margin-top:4px;}

/* ── Trumbowyg dark override ── */
.trumbowyg-box,.trumbowyg-editor{background:#13151f!important;color:#e8eaf0!important;border-color:#444860!important;border-radius:0 0 8px 8px!important;}
.trumbowyg-button-pane{background:#252a3a!important;border-color:#444860!important;border-radius:8px 8px 0 0!important;}
.trumbowyg-button-pane button{color:#9ca3af!important;}
.trumbowyg-button-pane button:hover,.trumbowyg-button-pane button.trumbowyg-active{background:rgba(255,255,255,0.08)!important;color:#e8eaf0!important;}
</style>

<div class="aos-wrap">

    <!-- Header -->
    <div class="aos-header">
        <div class="aos-title">
            <i class='bx bx-plus-circle'></i>
            <h2><?= isset($result) && $result ? 'Editar OS #'.sprintf('%04d',$result->idOs) : 'Nova Ordem de Serviço' ?></h2>
        </div>
        <a href="<?= base_url() ?>index.php/os" class="aos-btn aos-btn-back">
            <i class='bx bx-arrow-back'></i> Voltar à lista
        </a>
    </div>

    <!-- Erro de validação -->
    <?php if ($custom_error == true): ?>
    <div class="aos-alert-err">
        <i class='bx bx-error-circle' style="font-size:16px;flex-shrink:0;margin-top:1px;"></i>
        <span>Dados incompletos. Verifique os campos obrigatórios (*), se o cliente foi selecionado corretamente e se há ao menos um cliente e um termo de garantia cadastrados.</span>
    </div>
    <?php endif; ?>

    <!-- Tabs -->
    <div class="aos-tabs">
        <button class="aos-tab active" data-tab="tab-detalhes">
            <i class='bx bx-file'></i> Detalhes da OS
        </button>
        <button class="aos-tab" data-tab="tab-checklist">
            <i class='bx bx-list-check'></i> Checklist de Entrada
        </button>
        <button class="aos-tab" data-tab="tab-recorrente">
            <i class='bx bx-refresh'></i> Recorrência
        </button>
    </div>

    <form action="<?= current_url() ?>" method="post" id="formOs" enctype="multipart/form-data">
    <?php $osOrigem = $this->input->get('os_origem'); ?>
    <?php if ($osOrigem): ?>
        <input type="hidden" name="os_origem_id" value="<?= (int)$osOrigem ?>">
        <div class="aos-alert-link">
            <i class='bx bx-link'></i>
            <span><strong>Retorno em Garantia</strong> — Esta OS está vinculada à OS #<?= str_pad($osOrigem,4,'0',STR_PAD_LEFT) ?>.
            <a href="<?= site_url('os/visualizar/'.$osOrigem) ?>" target="_blank">Ver OS original →</a></span>
        </div>
    <?php endif; ?>

    <!-- ══ TAB 1 — Detalhes da OS ══ -->
    <div class="aos-tab-pane active" id="tab-detalhes">

        <!-- Cliente + Técnico -->
        <div class="aos-section">
            <div class="aos-section-head">
                <i class='bx bx-user'></i><span>Cliente, Técnico & Atendente</span>
            </div>
            <div class="aos-section-body">
                <div class="aos-grid">
                    <div class="aos-col-2">
                        <label class="aos-label">Cliente <span class="req">*</span></label>
                        <div class="aos-input-group">
                            <input id="cliente" type="text" name="cliente" class="aos-input"
                                   placeholder="Digite para buscar..." autocomplete="off" />
                            <input id="clientes_id" type="hidden" name="clientes_id" />
                            <a href="#modal-cliente-rapido" data-toggle="modal" class="aos-btn-new-client">
                                <i class='bx bx-plus'></i> Novo
                            </a>
                        </div>
                    </div>
                    <div class="aos-col">
                        <label class="aos-label">Técnico Responsável <span class="req">*</span></label>
                        <input id="tecnico" type="text" name="tecnico" class="aos-input"
                               placeholder="Digite para buscar..." autocomplete="off"
                               value="<?= $this->session->userdata('nome_admin') ?>" />
                        <input id="usuarios_id" type="hidden" name="usuarios_id"
                               value="<?= $this->session->userdata('id_admin') ?>" />
                    </div>
                    <div class="aos-col">
                        <label class="aos-label">Atendente / Vendedor</label>
                        <input id="atendente" type="text" name="atendente" class="aos-input"
                               placeholder="Digite para buscar..." autocomplete="off"
                               value="<?= $this->session->userdata('nome_admin') ?>" />
                        <input id="atendente_id" type="hidden" name="atendente_id"
                               value="<?= $this->session->userdata('id_admin') ?>" />
                    </div>
                </div>
            </div>
        </div>

        <!-- Status + Datas + Garantia -->
        <div class="aos-section">
            <div class="aos-section-head">
                <i class='bx bx-calendar'></i><span>Status & Datas</span>
            </div>
            <div class="aos-section-body">
                <div class="aos-grid">
                    <div class="aos-col">
                        <label class="aos-label">Status <span class="req">*</span></label>
                        <select class="aos-select" name="status" id="status">
                            <option value="Aberto">Aberto</option>
                            <option value="Orçamento">Orçamento</option>
                            <option value="Negociação">Negociação</option>
                            <option value="Aprovado">Aprovado</option>
                            <option value="Aguardando Peças">Aguardando Peças</option>
                            <option value="Em Andamento">Em Andamento</option>
                            <option value="Aguardando Autorização">Aguardando Autorização</option>
                            <option value="Em Teste">Em Teste</option>
                            <option value="Finalizado">Finalizado</option>
                            <option value="Faturado">Faturado</option>
                            <option value="Sem Conserto">Sem Conserto</option>
                            <option value="Não foi Possível">Não foi Possível</option>
                            <option value="Não temos Peças">Não temos Peças</option>
                            <option value="Recusado">Recusado</option>
                            <option value="Cancelado">Cancelado</option>
                        </select>
                    </div>
                    <div class="aos-col">
                        <label class="aos-label">Data Inicial <span class="req">*</span></label>
                        <input id="dataInicial" type="text" name="dataInicial" class="aos-input datepicker"
                               value="<?= date('d/m/Y') ?>" autocomplete="off" />
                    </div>
                    <div class="aos-col">
                        <label class="aos-label">Data Final <span id="dataFinalReq"></span></label>
                        <input id="dataFinal" type="text" name="dataFinal" class="aos-input datepicker"
                               value="" autocomplete="off" />
                    </div>
                    <div class="aos-col">
                        <label class="aos-label">Previsão de Entrega</label>
                        <input id="dataEntrega" type="text" name="dataEntrega" class="aos-input datepicker"
                               placeholder="dd/mm/aaaa" autocomplete="off" />
                    </div>
                </div>
                <div class="aos-grid" style="margin-top:12px;">
                    <div class="aos-col">
                        <label class="aos-label">Garantia (dias)</label>
                        <input id="garantia" type="number" name="garantia" class="aos-input"
                               placeholder="0" min="0" max="9999" />
                    </div>
                    <div class="aos-col-2">
                        <label class="aos-label">Termo de Garantia</label>
                        <input id="termoGarantia" type="text" name="termoGarantia" class="aos-input"
                               placeholder="Digite para buscar..." autocomplete="off" />
                        <input id="garantias_id" type="hidden" name="garantias_id" />
                    </div>
                </div>
            </div>
        </div>

        <!-- Equipamento -->
        <div class="aos-section">
            <div class="aos-section-head">
                <i class='bx bx-devices'></i><span>Equipamento</span>
            </div>
            <div class="aos-section-body">
                <div class="aos-grid">
                    <div class="aos-col">
                        <label class="aos-label">Equipamento</label>
                        <input id="equipamento" type="text" name="equipamento" class="aos-input"
                               placeholder="Ex: iPhone 13, Samsung A52..." />
                    </div>
                    <div class="aos-col">
                        <label class="aos-label">Nº de Série / IMEI</label>
                        <input id="numeroSerie" type="text" name="numeroSerie" class="aos-input"
                               placeholder="Ex: 354812..." />
                    </div>
                    <div class="aos-col">
                        <label class="aos-label">Foto do Equipamento</label>
                        <input type="file" name="foto_equipamento" accept=".jpg,.jpeg,.png,.webp" class="aos-input"
                               style="padding:5px;" />
                        <div class="aos-hint">JPG/PNG — Máx 5MB</div>
                    </div>
                </div>
            </div>
        </div>


        <!-- Senha do Celular -->
        <div class="aos-section">
            <div class="aos-section-head">
                <i class='bx bx-lock-alt' style="color:#a78bfa;"></i><span>Segurança do Dispositivo</span>
            </div>
            <div class="aos-section-body">

                <!-- Input oculto único enviado no submit -->
                <input type="hidden" name="senha_tipo"  id="senhaTipoFinal"  value="">
                <input type="hidden" name="senha_valor" id="senhaValorFinal" value="">

                <div class="sd-card">
                    <div class="sd-sub">Informe a senha para que o técnico possa testar todas as funções.</div>

                    <div class="sd-toggle" id="senhaTipoChips">
                        <button type="button" class="sd-toggle-btn ativo" data-tipo=""
                                onclick="sisosToggleSenha('')">Sem senha</button>
                        <button type="button" class="sd-toggle-btn" data-tipo="pin"
                                onclick="sisosToggleSenha('pin')">Senha Padrão</button>
                        <button type="button" class="sd-toggle-btn" data-tipo="padrao"
                                onclick="sisosToggleSenha('padrao')">Desenho</button>
                    </div>

                    <!-- PIN / Senha Padrão -->
                    <div id="wrapSenhaPin" style="display:none;">
                        <div style="font-size:10.5px;font-weight:700;color:#6b7280;text-transform:uppercase;letter-spacing:.6px;margin-bottom:10px;">Senha Numérica ou Alfanumérica</div>
                        <input type="text" id="senhaValorPin"
                               class="sd-pin-input" maxlength="8" inputmode="numeric" pattern="[0-9]*"
                               placeholder="••••"
                               oninput="document.getElementById('senhaValorFinal').value=this.value">
                        <div class="sd-hint">Caso não tenha senha, deixe em branco.</div>
                    </div>

                    <!-- Desenho / Padrão Android -->
                    <div id="wrapSenhaPadrao" style="display:none;">
                        <input type="hidden" id="senhaValorPadrao" value="">
                        <div class="sd-grid-wrap">
                            <span class="sd-grid-badge" id="padraoContagem">0 pontos</span>
                            <div class="sd-grid" id="padraoGrid">
                                <svg id="padraoSvg" style="position:absolute;top:0;left:0;width:100%;height:100%;pointer-events:none;overflow:visible;">
                                    <defs>
                                        <marker id="setaPadrao" markerWidth="10" markerHeight="10" refX="6" refY="3" orient="auto">
                                            <path d="M0,0 L6,3 L0,6 Z" fill="#3b82f6"></path>
                                        </marker>
                                    </defs>
                                </svg>
                                <?php for($pi=1;$pi<=9;$pi++): ?>
                                <div class="sd-dot" data-n="<?= $pi ?>"></div>
                                <?php endfor; ?>
                            </div>
                        </div>
                        <div class="sd-hint" id="padraoInicioFim" style="min-height:15px;"></div>
                        <button type="button" onclick="sisosPatternClear()"
                                style="margin-top:14px;background:rgba(239,68,68,0.12);color:#f87171;
                                       border:1px solid rgba(239,68,68,0.25);border-radius:8px;
                                       padding:6px 16px;font-size:12px;font-weight:700;cursor:pointer;">
                            <i class='bx bx-refresh'></i> Limpar
                        </button>
                        <div class="sd-hint">Clique nos pontos na ordem do padrão.</div>
                    </div>
                </div>

            </div>
        </div>

        <!-- Textos da OS -->
        <div class="aos-section">
            <div class="aos-section-head">
                <i class='bx bx-detail'></i><span>Detalhes Técnicos</span>
            </div>
            <div class="aos-section-body">
                <div class="aos-grid">
                    <div class="aos-col">
                        <label class="aos-label"><i class='bx bx-cube' style="color:#60a5fa;"></i> Descrição do Produto / Serviço</label>
                        <textarea class="aos-textarea editor" name="descricaoProduto" id="descricaoProduto"></textarea>
                    </div>
                    <div class="aos-col">
                        <label class="aos-label"><i class='bx bx-error' style="color:#f87171;"></i> Defeito Apresentado</label>
                        <textarea class="aos-textarea editor" name="defeito" id="defeito"></textarea>
                    </div>
                    <div class="aos-col">
                        <label class="aos-label"><i class='bx bx-note' style="color:#fbbf24;"></i> Observações</label>
                        <textarea class="aos-textarea editor" name="observacoes" id="observacoes"></textarea>
                    </div>
                    <div class="aos-col">
                        <label class="aos-label"><i class='bx bx-search-alt' style="color:#a78bfa;"></i> Laudo Técnico</label>
                        <textarea class="aos-textarea editor" name="laudoTecnico" id="laudoTecnico"></textarea>
                    </div>
                </div>
            </div>
        </div>

        <!-- Footer de ação -->
        <div class="aos-footer">
            <a href="<?= base_url() ?>index.php/os" class="aos-btn aos-btn-back">
                <i class='bx bx-x'></i> Cancelar
            </a>
            <button type="submit" class="aos-btn aos-btn-save" id="btnContinuar">
                <i class='bx bx-save'></i> Salvar OS
            </button>
        </div>

    </div><!-- /#tab-detalhes -->

    <!-- ══ TAB 2 — Checklist de Entrada ══ -->
    <div class="aos-tab-pane" id="tab-checklist">
        <div class="aos-section">
            <div class="aos-section-head">
                <i class='bx bx-list-check'></i><span>Checklist de Entrada do Equipamento</span>
            </div>
            <div class="aos-section-body">

                <p style="font-size:12px;color:#9ca3af;margin-bottom:16px;">
                    Para cada item, informe a condição encontrada: <strong style="color:#4ade80;">OK</strong>,
                    <strong style="color:#f87171;">Com Defeito/Detalhe</strong> ou
                    <strong style="color:#6b7280;">Não Verificado</strong>.
                </p>

                <?php
                // Itens fixos do checklist de assistência técnica
                $checklistGrupos = [
                    'Tela & Display' => [
                        'Tela sem trincas',
                        'Tela sem manchas ou pixels mortos',
                        'Touch funcionando',
                        'Brilho funcionando',
                    ],
                    'Estrutura & Corpo' => [
                        'Tampa traseira sem trincas',
                        'Bordas sem amassados',
                        'Sem sinais de queda',
                        'Sem sinais de líquido / oxidação',
                    ],
                    'Botões & Conectores' => [
                        'Botão power funcionando',
                        'Botão volume funcionando',
                        'Botão home / biometria funcionando',
                        'Entrada de carga sem danos',
                        'Entrada de fone sem danos',
                        'Slot de chip / SD sem danos',
                    ],
                    'Câmera & Áudio' => [
                        'Câmera traseira sem danos',
                        'Câmera frontal sem danos',
                        'Auto-falante funcionando',
                        'Microfone funcionando',
                        'Fone de ouvido funcionando',
                    ],
                    'Bateria & Sistema' => [
                        'Aparelho ligando',
                        'Bateria carregando',
                        'Sem superaquecimento',
                        'Wi-Fi funcionando',
                        'Bluetooth funcionando',
                        'Sinal de rede funcionando',
                    ],
                    'Acessórios Entregues' => [
                        'Carregador entregue',
                        'Cabo entregue',
                        'Fone entregue',
                        'Capa/película entregue',
                        'Caixa entregue',
                    ],
                ];
                ?>

                <style>
                .ck-grupo-titulo{
                    font-size:10px;font-weight:800;color:#6b7280;
                    text-transform:uppercase;letter-spacing:.8px;
                    padding:8px 0 6px;border-bottom:1px solid rgba(255,255,255,0.05);
                    margin-bottom:8px;display:flex;align-items:center;gap:6px;
                }
                .ck-grid{
                    display:grid;grid-template-columns:repeat(auto-fill,minmax(260px,1fr));
                    gap:6px;margin-bottom:16px;
                }
                .ck-item{
                    display:flex;align-items:center;justify-content:space-between;
                    background:#13151f;border:1px solid rgba(255,255,255,0.05);
                    border-radius:8px;padding:8px 10px;gap:8px;
                    transition:border-color .15s;
                }
                .ck-item:hover{ border-color:rgba(255,255,255,0.1); }
                .ck-item-nome{
                    font-size:12px;color:#c9cad6;flex:1;
                }
                .ck-btns{ display:flex;gap:4px;flex-shrink:0; }
                .ck-btn{
                    width:28px;height:24px;border-radius:5px;border:1px solid transparent;
                    font-size:10px;font-weight:700;cursor:pointer;
                    display:flex;align-items:center;justify-content:center;
                    transition:all .15s;background:rgba(255,255,255,0.05);color:#6b7280;
                }
                .ck-btn:hover{ opacity:.85; }
                .ck-btn.ok-ativo{    background:rgba(74,222,128,0.15);border-color:#4ade80;color:#4ade80; }
                .ck-btn.def-ativo{   background:rgba(248,113,113,0.15);border-color:#f87171;color:#f87171; }
                .ck-btn.nvf-ativo{   background:rgba(107,114,128,0.15);border-color:#6b7280;color:#9ca3af; }
                .ck-resumo{
                    display:flex;gap:12px;flex-wrap:wrap;
                    padding:10px 14px;background:#13151f;
                    border:1px solid rgba(255,255,255,0.06);border-radius:8px;
                    margin-bottom:14px;font-size:12px;
                }
                .ck-resumo-item{ display:flex;align-items:center;gap:5px;font-weight:700; }
                </style>

                <!-- Resumo dinâmico -->
                <div class="ck-resumo" id="ckResumo">
                    <span class="ck-resumo-item" style="color:#4ade80;"><i class='bx bx-check-circle'></i> <span id="rOk">0</span> OK</span>
                    <span class="ck-resumo-item" style="color:#f87171;"><i class='bx bx-error-circle'></i> <span id="rDef">0</span> Com defeito</span>
                    <span class="ck-resumo-item" style="color:#6b7280;"><i class='bx bx-minus-circle'></i> <span id="rNvf">0</span> Não verificado</span>
                </div>

                <!-- Campo oculto que guarda o JSON do checklist -->
                <input type="hidden" name="checklist_json" id="checklistJson" value="">

                <?php foreach ($checklistGrupos as $grupo => $itens): ?>
                <div class="ck-grupo-titulo">
                    <i class='bx bx-chevron-right'></i> <?= $grupo ?>
                </div>
                <div class="ck-grid">
                    <?php foreach ($itens as $item): ?>
                    <div class="ck-item" data-item="<?= htmlspecialchars($item) ?>">
                        <span class="ck-item-nome"><?= htmlspecialchars($item) ?></span>
                        <div class="ck-btns">
                            <button type="button" class="ck-btn" data-estado="ok"
                                    onclick="ckSetEstado(this,'ok')" title="OK">OK</button>
                            <button type="button" class="ck-btn" data-estado="defeito"
                                    onclick="ckSetEstado(this,'defeito')" title="Com defeito">⚠</button>
                            <button type="button" class="ck-btn" data-estado="nvf"
                                    onclick="ckSetEstado(this,'nvf')" title="Não verificado">—</button>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
                <?php endforeach; ?>

                <div style="margin-bottom:14px;margin-top:4px;">
                    <label class="aos-label">Observações gerais / Acessórios / Anotações</label>
                    <textarea name="checklist_obs" id="checklistObs" class="aos-textarea" rows="3"
                              placeholder="Riscos visíveis, avarias específicas, itens extras entregues..."></textarea>
                </div>

                <div>
                    <label class="aos-label">Fotos de Entrada (até 4 fotos)</label>
                    <input type="file" name="checklist_fotos[]" multiple accept="image/*"
                           id="inputChecklistFotos" class="aos-input" style="padding:5px;" />
                    <div id="previewChecklistFotos" class="aos-foto-preview"></div>
                </div>

            </div>
        </div>

        <div class="aos-footer">
            <a href="<?= base_url() ?>index.php/os" class="aos-btn aos-btn-back">
                <i class='bx bx-x'></i> Cancelar
            </a>
            <button type="submit" class="aos-btn aos-btn-save" onclick="ckSerializar()">
                <i class='bx bx-save'></i> Salvar OS
            </button>
        </div>
    </div><!-- /#tab-checklist -->

    <script>
    // ── Checklist novo ────────────────────────────────────────────────────
    var _ckEstados = {}; // { 'item': 'ok'|'defeito'|'nvf' }

    function ckSetEstado(btn, estado) {
        var item = btn.closest('.ck-item');
        var nome = item.dataset.item;
        _ckEstados[nome] = estado;

        // Reset visual dos 3 botões do item
        item.querySelectorAll('.ck-btn').forEach(function(b) {
            b.classList.remove('ok-ativo','def-ativo','nvf-ativo');
        });
        // Ativa o clicado
        if (estado === 'ok')     btn.classList.add('ok-ativo');
        if (estado === 'defeito') btn.classList.add('def-ativo');
        if (estado === 'nvf')    btn.classList.add('nvf-ativo');

        // Borda do item
        item.style.borderColor = estado==='ok' ? 'rgba(74,222,128,0.3)'
                               : estado==='defeito' ? 'rgba(248,113,113,0.3)'
                               : 'rgba(107,114,128,0.2)';
        ckAtualizarResumo();
        ckSerializar();
    }

    function ckAtualizarResumo() {
        var ok=0, def=0, nvf=0;
        Object.values(_ckEstados).forEach(function(v){
            if(v==='ok') ok++;
            else if(v==='defeito') def++;
            else if(v==='nvf') nvf++;
        });
        document.getElementById('rOk').textContent  = ok;
        document.getElementById('rDef').textContent = def;
        document.getElementById('rNvf').textContent = nvf;
    }

    function ckSerializar() {
        var obs = document.getElementById('checklistObs');
        var data = {
            itens: _ckEstados,
            obs: obs ? obs.value : ''
        };
        var el = document.getElementById('checklistJson');
        if (el) el.value = JSON.stringify(data);
    }

    // Serializar antes de qualquer submit do form
    document.addEventListener('submit', function(){ ckSerializar(); });
    </script>

    <!-- ══ TAB 3 — Recorrência ══ -->
    <div class="aos-tab-pane" id="tab-recorrente">
        <div class="aos-section">
            <div class="aos-section-head">
                <i class='bx bx-refresh'></i><span>Ordem de Serviço Recorrente</span>
            </div>
            <div class="aos-section-body">
                <div class="aos-check-item" style="margin-bottom:12px;">
                    <input type="checkbox" name="is_recorrente" value="1" id="chkRecorrente">
                    <label for="chkRecorrente" style="font-size:13px;color:#c9cad6;margin:0;cursor:pointer;">
                        Esta é uma OS recorrente (preventiva, contrato, manutenção periódica, etc.)
                    </label>
                </div>

                <div id="divRecorrencia" style="display:none;">
                    <div class="aos-rec-box">
                        <div class="aos-grid">
                            <div class="aos-col">
                                <label class="aos-label">Periodicidade</label>
                                <select name="recorrencia_tipo" class="aos-select">
                                    <option value="mensal">Mensal</option>
                                    <option value="bimestral">Bimestral (2 meses)</option>
                                    <option value="trimestral">Trimestral (3 meses)</option>
                                    <option value="semestral">Semestral (6 meses)</option>
                                    <option value="anual">Anual</option>
                                </select>
                            </div>
                            <div class="aos-col">
                                <label class="aos-label">Data da Próxima Execução</label>
                                <input type="text" name="recorrencia_proxima" class="aos-input datepicker"
                                       placeholder="dd/mm/aaaa" autocomplete="off" />
                            </div>
                        </div>
                        <div class="aos-info-box" style="margin-top:12px;">
                            <i class='bx bx-info-circle' style="flex-shrink:0;margin-top:1px;"></i>
                            O sistema lembrará de criar a próxima OS automaticamente na data definida.
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="aos-footer">
            <a href="<?= base_url() ?>index.php/os" class="aos-btn aos-btn-back">
                <i class='bx bx-x'></i> Cancelar
            </a>
            <button type="submit" class="aos-btn aos-btn-save">
                <i class='bx bx-save'></i> Salvar OS
            </button>
        </div>
    </div><!-- /#tab-recorrente -->

    </form>
</div><!-- /.aos-wrap -->

<!-- ── Modal Cadastro Rápido de Cliente ── -->
<div id="modal-cliente-rapido" class="modal hide fade modal-dark" tabindex="-1" role="dialog">
    <div class="modal-header">
        <h4><i class='bx bx-user-plus' style="color:#4ade80;"></i> Novo Cliente — Cadastro Rápido</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
    </div>
    <form id="formClienteRapido">
        <div class="modal-body">
            <div class="modal-dark">
                <div class="form-group">
                    <label>Nome <span style="color:#f87171;">*</span></label>
                    <input type="text" id="crNome" placeholder="Nome completo do cliente" />
                </div>
                <div class="form-group">
                    <label>Telefone / WhatsApp</label>
                    <input type="text" id="crTelefone" placeholder="(00) 00000-0000" />
                </div>
                <div class="form-group">
                    <label>CPF / CNPJ</label>
                    <input type="text" id="crCpf" placeholder="Opcional" />
                </div>
                <div class="form-group">
                    <label>Data de Nascimento</label>
                    <input type="text" id="crDataNascimento" class="datepicker" placeholder="dd/mm/aaaa" autocomplete="off" />
                </div>
                <div class="form-group" style="display:flex;align-items:center;gap:8px;">
                    <input type="checkbox" id="crNotifAniversario" checked style="width:auto;" />
                    <label for="crNotifAniversario" style="margin:0;">Notificar aniversário deste cliente</label>
                </div>
                <div class="hint">Demais dados podem ser completados depois em <strong style="color:#c9cad6;">Clientes</strong>.</div>
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="aos-btn aos-btn-back" data-dismiss="modal">
                <i class='bx bx-x'></i> Cancelar
            </button>
            <button type="submit" class="aos-btn aos-btn-save">
                <i class='bx bx-save'></i> Salvar Cliente
            </button>
        </div>
    </form>
</div>

<script>
$(document).ready(function() {

    // ── Tabs ──────────────────────────────────────────────────
    $('.aos-tab').on('click', function() {
        var target = $(this).data('tab');
        $('.aos-tab').removeClass('active');
        $('.aos-tab-pane').removeClass('active');
        $(this).addClass('active');
        $('#' + target).addClass('active');
    });

    // ── Autocompletes ─────────────────────────────────────────
    $('#cliente').autocomplete({
        source: '<?= base_url() ?>index.php/os/autoCompleteCliente',
        minLength: 1,
        select: function(e, ui) { $('#clientes_id').val(ui.item.id); }
    });
    $('#tecnico').autocomplete({
        source: '<?= base_url() ?>index.php/os/autoCompleteUsuario',
        minLength: 1,
        select: function(e, ui) { $('#usuarios_id').val(ui.item.id); }
    });
    $('#atendente').autocomplete({
        source: '<?= base_url() ?>index.php/os/autoCompleteUsuario',
        minLength: 1,
        select: function(e, ui) { $('#atendente_id').val(ui.item.id); }
    });
    $('#termoGarantia').autocomplete({
        source: '<?= base_url() ?>index.php/os/autoCompleteTermoGarantia',
        minLength: 1,
        select: function(e, ui) { $('#garantias_id').val(ui.item.id); }
    });

    // ── Datepickers ───────────────────────────────────────────
    $('.datepicker').datepicker({ dateFormat: 'dd/mm/yy' });

    // ── Editor WYSIWYG ────────────────────────────────────────
    // Inicializa editor Trumbowyg
    $('.editor').trumbowyg({ lang: 'pt_br', semantic: { 'strikethrough': 's' } });

    // Sincroniza o conteúdo dos editores de volta para os textareas ANTES de submeter
    $('form').on('submit', function() {
        $('.editor').each(function() {
            var $ta = $(this);
            var html = $ta.trumbowyg('html');
            $ta.val(html);
        });
        // Serializar checklist antes de submeter
        if (typeof ckSerializar === 'function') ckSerializar();
        if (typeof ckSaidaSerializar === 'function') ckSaidaSerializar();
    });

    // ── Status → Data Final obrigatória ──────────────────────
    function atualizarDataFinal() {
        if ($('#status').val() === 'Em Andamento') {
            $('#dataFinalReq').html('<span style="color:#f87171;margin-left:2px;">*</span>');
        } else {
            $('#dataFinalReq').html('');
        }
    }
    $('#status').on('change', atualizarDataFinal);
    atualizarDataFinal();

    // ── Validação ─────────────────────────────────────────────
    $('#formOs').validate({
        rules: {
            cliente:     { required: true },
            tecnico:     { required: true },
            atendente:   { required: false },
            dataInicial: { required: true },
            dataFinal: {
                required: function() {
                    return $('#status').val() === 'Em Andamento';
                }
            }
        },
        messages: {
            cliente:     { required: 'Campo obrigatório.' },
            tecnico:     { required: 'Campo obrigatório.' },
            dataInicial: { required: 'Campo obrigatório.' },
            dataFinal:   { required: 'Obrigatório quando status é Em Andamento.' }
        },
        submitHandler: function(form) {
            // Garante que o checklist e a senha estejam sincronizados ANTES
            // de enviar. O listener 'submit' mais abaixo no arquivo não
            // dispara aqui, porque form.submit() chamado via JavaScript não
            // aciona o evento "submit" do navegador (só clique direto do
            // usuário aciona). Por isso chamamos direto, garantido.
            if (typeof ckSerializar === 'function') { ckSerializar(); }
            var pinEl = document.getElementById('senhaValorPin');
            var tipoEl = document.getElementById('senhaTipoFinal');
            var finalEl = document.getElementById('senhaValorFinal');
            if (pinEl && tipoEl && finalEl && tipoEl.value === 'pin') {
                finalEl.value = pinEl.value;
            }

            $('#btnContinuar').attr('disabled', true).html('<i class="bx bx-loader-alt bx-spin"></i> Salvando...');
            form.submit();
        }
    });

    // ── Recorrência toggle ────────────────────────────────────
    $('#chkRecorrente').on('change', function() {
        $('#divRecorrencia').toggle(this.checked);
    });

    // ── Foto preview checklist ────────────────────────────────
    $('#inputChecklistFotos').on('change', function() {
        $('#previewChecklistFotos').html('');
        Array.from(this.files).slice(0, 4).forEach(function(file) {
            var r = new FileReader();
            r.onload = function(e) {
                $('#previewChecklistFotos').append(
                    '<img src="' + e.target.result + '" style="height:80px;width:80px;object-fit:cover;border-radius:8px;border:2px solid rgba(255,255,255,0.1);">'
                );
            };
            r.readAsDataURL(file);
        });
    });

    // ── Cadastro rápido de cliente ────────────────────────────
    $('#formClienteRapido').on('submit', function(e) {
        e.preventDefault();
        var nome = $('#crNome').val().trim();
        if (!nome) { alert('Nome é obrigatório.'); return; }
        $.post('<?= site_url('clientes/adicionarRapido') ?>', {
            nomeCliente:       nome,
            telefone:          $('#crTelefone').val().trim(),
            cpf:               $('#crCpf').val().trim(),
            dataNascimento:    $('#crDataNascimento').val().trim(),
            notif_aniversario: $('#crNotifAniversario').is(':checked') ? 1 : 0,
            '<?= $this->security->get_csrf_token_name() ?>': '<?= $this->security->get_csrf_hash() ?>'
        }, function(res) {
            if (res.sucesso) {
                $('#cliente').val(res.nome);
                $('#clientes_id').val(res.id);
                $('#modal-cliente-rapido').modal('hide');
                $('#crNome, #crTelefone, #crCpf, #crDataNascimento').val('');
                $('#crNotifAniversario').prop('checked', true);
            } else {
                alert('Erro: ' + (res.erro || 'Não foi possível cadastrar.'));
            }
        }, 'json');
    });

    // ── Máscara de telefone (organiza sozinho: (63) 99992-0348) ─────
    var crTelefoneEl = document.getElementById('crTelefone');
    if (crTelefoneEl) {
        crTelefoneEl.addEventListener('input', function(e) {
            var v = e.target.value.replace(/\D/g, '').slice(0, 11);
            if (v.length > 10) {
                v = v.replace(/^(\d{2})(\d{5})(\d{0,4}).*/, '($1) $2-$3');
            } else if (v.length > 6) {
                v = v.replace(/^(\d{2})(\d{4})(\d{0,4}).*/, '($1) $2-$3');
            } else if (v.length > 2) {
                v = v.replace(/^(\d{2})(\d{0,5})/, '($1) $2');
            } else if (v.length > 0) {
                v = v.replace(/^(\d*)/, '($1');
            }
            e.target.value = v;
        });
    }

});
</script>

<script>
// ── Senha do celular ─────────────────────────────────────────────────────
function sisosToggleSenha(tipo) {
    var tipoEl = document.getElementById('senhaTipoFinal');
    var tipoAnterior = tipoEl ? tipoEl.value : '';
    if (tipoEl) tipoEl.value = tipo;

    document.getElementById('wrapSenhaPin').style.display    = tipo === 'pin'    ? 'block' : 'none';
    document.getElementById('wrapSenhaPadrao').style.display = tipo === 'padrao' ? 'block' : 'none';

    // Só limpa o valor se REALMENTE mudou de tipo
    if (tipo !== tipoAnterior) {
        var elFinal = document.getElementById('senhaValorFinal');
        if (tipo === 'pin') {
            var pinEl = document.getElementById('senhaValorPin');
            if (pinEl) pinEl.value = '';
            if (elFinal) elFinal.value = '';
        } else if (tipo === 'padrao') {
            _padraoSeq = [];
            sisosPatternRender();
        } else {
            if (elFinal) elFinal.value = '';
        }
    }

    document.querySelectorAll('.sd-toggle-btn').forEach(function(btn) {
        btn.classList.toggle('ativo', btn.dataset.tipo === tipo);
    });
}

var _padraoSeq = [];

function sisosPatternRender() {
    document.querySelectorAll('.sd-dot').forEach(function(el) {
        var n   = parseInt(el.dataset.n);
        var idx = _padraoSeq.indexOf(n);
        el.classList.toggle('selecionado', idx >= 0);
        el.classList.toggle('inicio', idx === 0);
    });

    var contadorEl = document.getElementById('padraoContagem');
    if (contadorEl) contadorEl.textContent = _padraoSeq.length + ' ponto' + (_padraoSeq.length === 1 ? '' : 's');

    var infoEl = document.getElementById('padraoInicioFim');
    if (infoEl) {
        infoEl.innerHTML = _padraoSeq.length
            ? '<span style="color:#4ade80;">● Início: ponto ' + _padraoSeq[0] + '</span>' +
              (_padraoSeq.length > 1 ? ' &nbsp;→&nbsp; <span style="color:#3b82f6;">Fim: ponto ' + _padraoSeq[_padraoSeq.length - 1] + '</span>' : '')
            : '';
    }

    var svg = document.getElementById('padraoSvg');
    var grid = document.getElementById('padraoGrid');
    if (svg && grid) {
        var defs = svg.querySelector('defs');
        svg.innerHTML = '';
        svg.appendChild(defs);

        if (_padraoSeq.length > 1) {
            var gridRect = grid.getBoundingClientRect();
            var pontos = _padraoSeq.map(function(n) {
                var dot = grid.querySelector('.sd-dot[data-n="' + n + '"]');
                var r = dot.getBoundingClientRect();
                return {
                    x: r.left + r.width / 2 - gridRect.left,
                    y: r.top + r.height / 2 - gridRect.top
                };
            });

            for (var i = 0; i < pontos.length - 1; i++) {
                var linha = document.createElementNS('http://www.w3.org/2000/svg', 'line');
                linha.setAttribute('x1', pontos[i].x);
                linha.setAttribute('y1', pontos[i].y);
                linha.setAttribute('x2', pontos[i + 1].x);
                linha.setAttribute('y2', pontos[i + 1].y);
                linha.setAttribute('stroke', '#3b82f6');
                linha.setAttribute('stroke-width', '3');
                linha.setAttribute('stroke-linecap', 'round');
                if (i === pontos.length - 2) {
                    linha.setAttribute('marker-end', 'url(#setaPadrao)');
                }
                svg.appendChild(linha);
            }
        }
    }

    var v = _padraoSeq.join('-');
    var elVis   = document.getElementById('senhaValorPadrao');
    var elFinal = document.getElementById('senhaValorFinal');
    if (elVis)   elVis.value   = v;
    if (elFinal) elFinal.value = v;
}

function sisosPatternClear() {
    _padraoSeq = [];
    sisosPatternRender();
}

(function() {
    var grid = document.getElementById('padraoGrid');
    if (!grid) return;
    var arrastando = false;

    function pontoNoEvento(clientX, clientY) {
        var el = document.elementFromPoint(clientX, clientY);
        return el && el.classList.contains('sd-dot') ? parseInt(el.dataset.n) : null;
    }
    function iniciar(clientX, clientY) {
        var n = pontoNoEvento(clientX, clientY);
        if (n === null) return;
        arrastando = true;
        _padraoSeq = [n];
        sisosPatternRender();
    }
    function continuar(clientX, clientY) {
        if (!arrastando) return;
        var n = pontoNoEvento(clientX, clientY);
        if (n !== null && !_padraoSeq.includes(n)) {
            _padraoSeq.push(n);
            sisosPatternRender();
        }
    }
    function finalizar() { arrastando = false; }

    grid.addEventListener('mousedown', function(e) { iniciar(e.clientX, e.clientY); });
    document.addEventListener('mousemove', function(e) { if (arrastando) continuar(e.clientX, e.clientY); });
    document.addEventListener('mouseup', finalizar);

    grid.addEventListener('touchstart', function(e) {
        var t = e.touches[0];
        iniciar(t.clientX, t.clientY);
        e.preventDefault();
    }, { passive: false });
    grid.addEventListener('touchmove', function(e) {
        var t = e.touches[0];
        continuar(t.clientX, t.clientY);
        e.preventDefault();
    }, { passive: false });
    grid.addEventListener('touchend', finalizar);

    window.addEventListener('resize', function() { if (_padraoSeq.length) sisosPatternRender(); });
})();
</script>
