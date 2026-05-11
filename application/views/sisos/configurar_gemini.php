<div class="row-fluid" style="margin-top:0">
    <div class="span12">
        <div class="widget-box">
            <div class="widget-title" style="margin: -20px 0 0">
                <span class="icon">
                    <i class="fas fa-wrench"></i>
                </span>
                <h5>Configurações do Sistema</h5>
            </div>
            <ul class="nav nav-tabs" id="configTabs">
                <li class="active"><a href="javascript:void(0)" onclick="showConfigTab('home')">Gerais</a></li>
                <li><a href="javascript:void(0)" onclick="showConfigTab('menu1')">Financeiro</a></li>
                <li><a href="javascript:void(0)" onclick="showConfigTab('menu2')">Produtos</a></li>
                <li><a href="javascript:void(0)" onclick="showConfigTab('menu3')">Notificações</a></li>
                <li><a href="javascript:void(0)" onclick="showConfigTab('menu4')">Atualizações</a></li>
                <li><a href="javascript:void(0)" onclick="showConfigTab('menu5')">OS</a></li>
                <li><a href="javascript:void(0)" onclick="showConfigTab('menu6')">API</a></li>
                <li><a href="javascript:void(0)" onclick="showConfigTab('menu7')">E-mail</a></li>
                <li><a href="javascript:void(0)" onclick="showConfigTab('menu8')">Nota Fiscal</a></li>
                <li><a href="javascript:void(0)" onclick="showConfigTab('tabCatDespesa')">Categorias de Despesa</a></li>
                <li><a href="javascript:void(0)" onclick="showConfigTab('tabCatReceita')">Categorias de Receita</a></li>
                <li><a href="javascript:void(0)" onclick="showConfigTab('tabGemini')"><i class='bx bx-bot'></i> IA / Assistente</a></li>
            </ul>
            <div class="widget-content nopadding tab-content">
                <?php echo $custom_error; ?>
                <form action="<?php echo current_url(); ?>" id="formConfigurar" method="post" class="form-horizontal">
                    <!-- Menu Gerais -->
                    <div id="home" class="tab-pane fade in active">
                        <div class="control-group">
                            <label for="app_name" class="control-label">Nome do Sistema</label>
                            <div class="controls">
                                <input type="text" required name="app_name" value="<?= $configuration['app_name'] ?>">
                                <span class="help-inline">Nome do sistema</span>
                            </div>
                        </div>

                        <!-- Logo do Sistema -->
                        <div class="control-group">
                            <label class="control-label">Logo do Sistema</label>
                            <div class="controls">
                                <?php if (!empty($configuration['app_logo'])): ?>
                                    <div style="margin-bottom:8px;">
                                        <img src="<?= $configuration['app_logo'] ?>" alt="Logo atual" style="max-height:60px; border:1px solid #ddd; padding:4px; border-radius:4px;">
                                        <small class="help-inline">Logo atual</small>
                                    </div>
                                <?php endif; ?>
                                <div style="display:inline-flex;align-items:center;gap:8px;">
                                    <input type="file" id="inputLogo" name="arquivo" accept=".png,.jpg,.jpeg,.svg,.webp" style="display:inline-block;">
                                    <button type="button" onclick="uploadArquivo('inputLogo','<?= site_url('notafiscal/uploadLogo') ?>','msgLogo')" class="button btn btn-info btn-mini">
                                        <span class="button__icon"><i class='bx bx-upload'></i></span>
                                        <span class="button__text2">Enviar Logo</span>
                                    </button>
                                    <span id="msgLogo" style="font-size:12px;"></span>
                                </div>
                                <span class="help-inline">PNG, JPG ou SVG. Máx 2MB. Usada no menu lateral e cabeçalho.</span>
                            </div>
                        </div>

                        <!-- Tamanho da Logo -->
                        <div class="control-group">
                            <label class="control-label">Tamanho da Logo</label>
                            <div class="controls" style="display:flex;align-items:center;gap:12px;flex-wrap:wrap;">
                                <div style="display:flex;align-items:center;gap:8px;">
                                    <label style="margin:0;font-size:12px;color:#9ca0b8;">Altura</label>
                                    <input type="number" name="app_logo_height" min="20" max="120" step="5"
                                        value="<?= $configuration['app_logo_height'] ?? 50 ?>"
                                        style="width:70px;padding:4px 8px;border-radius:6px;border:1px solid #444860;background:#1e2133;color:#e8eaf0;font-size:13px;"
                                        oninput="document.getElementById('previewLogoSize').style.maxHeight=this.value+'px'">
                                    <span style="font-size:12px;color:#6b7280;">px</span>
                                </div>
                                <?php if (!empty($configuration['app_logo'])): ?>
                                <div style="background:#1a1d2e;border:1px solid #3a3d4e;border-radius:8px;padding:8px 14px;display:flex;align-items:center;gap:8px;">
                                    <span style="font-size:11px;color:#6b7280;">Prévia:</span>
                                    <img id="previewLogoSize" src="<?= $configuration['app_logo'] ?>"
                                        style="max-height:<?= $configuration['app_logo_height'] ?? 50 ?>px;max-width:200px;object-fit:contain;transition:max-height .2s;">
                                </div>
                                <?php endif; ?>
                                <span class="help-inline">Ajuste a altura da logo no menu lateral (20–120px).</span>
                            </div>
                        </div>

                        <!-- Favicon + Ícone do Menu -->
                        <div class="control-group">
                            <label class="control-label">Favicon / Ícone do Sistema</label>
                            <div class="controls">
                                <?php if (!empty($configuration['app_favicon'])): ?>
                                    <div style="margin-bottom:8px;display:flex;align-items:center;gap:12px;">
                                        <img src="<?= $configuration['app_favicon'] ?>" alt="Ícone atual" style="height:42px;width:42px;object-fit:contain;border:1px solid #ddd;padding:4px;border-radius:4px;">
                                        <span>
                                            <small class="help-inline">Ícone atual — usado na aba do navegador e no menu lateral</small>
                                        </span>
                                    </div>
                                <?php endif; ?>
                                <div style="display:inline-flex;align-items:center;gap:8px;">
                                    <input type="file" id="inputFavicon" name="arquivo" accept=".png,.ico,.jpg,.jpeg,.svg,.webp" style="display:inline-block;">
                                    <button type="button" onclick="uploadArquivo('inputFavicon','<?= site_url('notafiscal/uploadFavicon') ?>','msgFavicon')" class="button btn btn-info btn-mini">
                                        <span class="button__icon"><i class='bx bx-upload'></i></span>
                                        <span class="button__text2">Enviar Ícone</span>
                                    </button>
                                    <span id="msgFavicon" style="font-size:12px;"></span>
                                </div>
                                <span class="help-inline">PNG, ICO ou SVG. Quadrado. Máx 2MB. Aparece na aba do navegador e no menu lateral.</span>
                            </div>
                        </div>
                        <div class="control-group">
                            <label for="app_theme" class="control-label">Tema do Sistema</label>
                            <div class="controls">
                                <select name="app_theme" id="app_theme">
                                    <option value="default">Escuro</option>
                                    <option value="white" <?= $configuration['app_theme'] == 'white' ? 'selected' : ''; ?>>Claro</option>
                                    <option value="puredark" <?= $configuration['app_theme'] == 'puredark' ? 'selected' : ''; ?>>Pure dark</option>
                                    <option value="whiteblack" <?= $configuration['app_theme'] == 'whiteblack' ? 'selected' : ''; ?>>White black</option>
                                </select>
                                <span class="help-inline">Selecione o tema que que deseja usar no sistema</span>
                            </div>
                        </div>
                        <div class="control-group">
                            <label for="per_page" class="control-label">Registros por Página</label>
                            <div class="controls">
                                <select name="per_page" id="theme">
                                    <option value="10">10</option>
                                    <option value="20" <?= $configuration['per_page'] == '20' ? 'selected' : ''; ?>>20</option>
                                    <option value="50" <?= $configuration['per_page'] == '50' ? 'selected' : ''; ?>>50</option>
                                    <option value="100" <?= $configuration['per_page'] == '100' ? 'selected' : ''; ?>>100</option>
                                </select>
                                <span class="help-inline">Selecione quantos registros deseja exibir nas listas</span>
                            </div>
                        </div>
                        <div class="control-group">
                            <label for="control_datatable" class="control-label">Visualização em DataTables</label>
                            <div class="controls">
                                <select name="control_datatable" id="control_datatable">
                                    <option value="1">Sim</option>
                                    <option value="0" <?= $configuration['control_datatable'] == '0' ? 'selected' : ''; ?>>Não</option>
                                </select>
                                <span class="help-inline">Ativar ou desativar a visualização em tabelas dinâmicas</span>
                            </div>
                        </div>
                        <div class="form-actions">
                            <div class="span8">
                                <div class="span9">
                                    <button type="submit" class="button btn btn-primary">
                                    <span class="button__icon"><i class='bx bx-save'></i></span><span class="button__text2">Salvar Alterações</span></button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Menu Financeiro -->
                    <div id="menu1" class="tab-pane fade">
                        <div class="control-group">
                            <label for="control_baixa" class="control-label">Controle de baixa retroativa</label>
                            <div class="controls">
                                <select name="control_baixa" id="control_baixa">
                                    <option value="1">Ativar</option>
                                    <option value="0" <?= $configuration['control_baixa'] == '0' ? 'selected' : ''; ?>>Desativar</option>
                                </select>
                                <span class="help-inline">Ativar ou desativar o controle de baixa financeira, com data retroativa.</span>
                            </div>
                        </div>
                        <div class="control-group">
                            <label for="control_editos" class="control-label">Controle de edição de OS</label>
                            <div class="controls">
                                <select name="control_editos" id="control_editos">
                                    <option value="1" <?= $configuration['control_editos'] == '0' ? 'selected' : ''; ?>>Ativar</option>
                                    <option value="0" <?= $configuration['control_editos'] == '0' ? 'selected' : ''; ?>>Desativar</option>
                                </select>
                                <span class="help-inline">Ativar ou desativar a permissão para alterar ou excluir OS faturada e/ou cancelada.</span>
                            </div>
                        </div>
                        <div class="control-group">
                            <label for="control_edit_vendas" class="control-label">Controle de edição de Vendas</label>
                            <div class="controls">
                                <select name="control_edit_vendas" id="control_edit_vendas">
                                    <option value="1" <?= $configuration['control_edit_vendas'] == '0' ? 'selected' : ''; ?>>Ativar</option>
                                    <option value="0" <?= $configuration['control_edit_vendas'] == '0' ? 'selected' : ''; ?>>Desativar</option>
                                </select>
                                <span class="help-inline">Ativar ou desativar a permissão para alterar ou excluir vendas faturada.</span>
                            </div>
                        </div>
                        <div class="control-group">
                            <label for="mp_access_token" class="control-label">Mercado Pago Access Token <small class="muted">(opcional)</small></label>
                            <div class="controls">
                                <input type="text" name="mp_access_token" class="span8"
                                    value="<?= htmlspecialchars($configuration['mp_access_token'] ?? '') ?>"
                                    placeholder="APP_USR-..." autocomplete="off" />
                                <span class="help-inline">Token do Mercado Pago para cobranças online no portal do cliente</span>
                            </div>
                        </div>
                        <div class="control-group">
                            <label for="pix_key" class="control-label">Chave Pix para Recebimento de Pagamentos</label>
                            <div class="controls">
                                <input type="text" name="pix_key" value="<?= $configuration['pix_key'] ?>">
                                <span class="help-inline">Chave Pix para Recebimento de Pagamentos</span>
                            </div>
                        </div>

                        <!-- Configrações do EFI -->
                        <hr>
                        <h5 style="margin-left:10px;">Configrações do EFI (antiga GerenciaNet)</h5>
                        <div class="control-group">
                            <label for="EFI_PRODUCTION" class="control-label">Ambiente</label>
                            <div class="controls">
                                <select name="PAYMENT_GATEWAYS_EFI_PRODUCTION" id="EFI_PRODUCTION">
                                    <option value="false" <?= !filter_var($_ENV['PAYMENT_GATEWAYS_EFI_PRODUCTION'] ?? false, FILTER_VALIDATE_BOOLEAN) ? 'selected' : ''; ?>>Sandbox</option>
                                    <option value="true" <?= filter_var($_ENV['PAYMENT_GATEWAYS_EFI_PRODUCTION'] ?? false, FILTER_VALIDATE_BOOLEAN) ? 'selected' : ''; ?>>Produção</option>
                                </select>
                                <span class="help-inline">Sandbox é um ambiente para testes.</span>
                            </div>
                        </div>
                        <div class="control-group">
                            <label for="EFI_CREDENTIAIS_CLIENT_ID" class="control-label">CLIENT_ID</label>
                            <div class="controls">
                                <input type="text" name="PAYMENT_GATEWAYS_EFI_CREDENTIAIS_CLIENT_ID" value="<?= $_ENV['PAYMENT_GATEWAYS_EFI_CREDENTIAIS_CLIENT_ID'] ?>" id="EFI_CREDENTIAIS_CLIENT_ID">
                                <span class="help-inline">Pode ser encontrado no menu <a href="https://app.sejaefi.com.br/api/aplicacoes" target="_blank" rel="noopener noreferrer">"API" -> "Aplicações"</a></span>
                            </div>
                        </div>
                        <div class="control-group">
                            <label for="EFI_CREDENTIAIS_CLIENT_SECRET" class="control-label">CLIENT_SECRET</label>
                            <div class="controls">
                                <input type="text" name="PAYMENT_GATEWAYS_EFI_CREDENTIAIS_CLIENT_SECRET" value="<?= $_ENV['PAYMENT_GATEWAYS_EFI_CREDENTIAIS_CLIENT_SECRET'] ?>" id="EFI_CREDENTIAIS_CLIENT_SECRET">
                                <span class="help-inline">Pode ser encontrado no menu <a href="https://app.sejaefi.com.br/api/aplicacoes" target="_blank" rel="noopener noreferrer">"API" -> "Aplicações"</a></span>
                            </div>
                        </div>
                        <div class="control-group">
                            <label for="EFI_BOLETO_EXPIRATION" class="control-label">Dias para vencimento do boleto</label>
                            <div class="controls">
                                <select name="PAYMENT_GATEWAYS_EFI_BOLETO_EXPIRATION" id="EFI_BOLETO_EXPIRATION">
                                    <?php for ($i = 1; $i <= 30; $i++) :
                                        $diasEFI = "P{$i}D";
                                        ?>
                                        <option value="<?= $diasEFI ?>" <?= $diasEFI == $_ENV['PAYMENT_GATEWAYS_EFI_BOLETO_EXPIRATION'] ? 'selected' : '' ?>><?= $i ?> dia<?= $i > 1 ? 's' : '' ?></option>
                                    <?php endfor; ?>
                                </select>
                                <span class="help-inline">A quantidade de dias selecionado será somado a data que a cobrança for gerada.</span>
                            </div>
                        </div>

                        <!-- Configrações do Mercado Pago -->
                        <hr>
                        <h5 style="margin-left:10px;">Configrações do Mercado Pago</h5>
                        <div class="control-group">
                            <label for="MERCADO_PAGO_CREDENTIALS_PUBLIC_KEY" class="control-label">PUBLIC_KEY</label>
                            <div class="controls">
                                <input type="text" name="PAYMENT_GATEWAYS_MERCADO_PAGO_CREDENTIALS_PUBLIC_KEY" value="<?= $_ENV['PAYMENT_GATEWAYS_MERCADO_PAGO_CREDENTIALS_PUBLIC_KEY'] ?>" id="MERCADO_PAGO_CREDENTIALS_PUBLIC_KEY">
                                <span class="help-inline">Pode ser encontrado no menu <a href="https://www.mercadopago.com.br/settings/account/credentials" target="_blank" rel="noopener noreferrer">"Seu Negócio" -> "Configurações" -> "Credenciais"</a></span>
                            </div>
                        </div>
                        <div class="control-group">
                            <label for="MERCADO_PAGO_CREDENTIALS_ACCESS_TOKEN" class="control-label">ACCESS_TOKEN</label>
                            <div class="controls">
                                <input type="text" name="PAYMENT_GATEWAYS_MERCADO_PAGO_CREDENTIALS_ACCESS_TOKEN" value="<?= $_ENV['PAYMENT_GATEWAYS_MERCADO_PAGO_CREDENTIALS_ACCESS_TOKEN'] ?>" id="MERCADO_PAGO_CREDENTIALS_ACCESS_TOKEN">
                                <span class="help-inline">Pode ser encontrado no menu <a href="https://www.mercadopago.com.br/settings/account/credentials" target="_blank" rel="noopener noreferrer">"Seu Negócio" -> "Configurações" -> "Credenciais"</a></span>
                            </div>
                        </div>
                        <div class="control-group">
                            <label for="MERCADO_PAGO_CREDENTIALS_CLIENT_ID" class="control-label">CLIENT_ID</label>
                            <div class="controls">
                                <input type="text" name="PAYMENT_GATEWAYS_MERCADO_PAGO_CREDENTIALS_CLIENT_ID" value="<?= $_ENV['PAYMENT_GATEWAYS_MERCADO_PAGO_CREDENTIALS_CLIENT_ID'] ?>" id="MERCADO_PAGO_CREDENTIALS_CLIENT_ID">
                                <span class="help-inline">Pode ser encontrado no menu <a href="https://www.mercadopago.com.br/settings/account/credentials" target="_blank" rel="noopener noreferrer">"Seu Negócio" -> "Configurações" -> "Credenciais"</a></span>
                            </div>
                        </div>
                        <div class="control-group">
                            <label for="MERCADO_PAGO_CREDENTIALS_CLIENT_SECRET" class="control-label">CLIENT_SECRET</label>
                            <div class="controls">
                                <input type="text" name="PAYMENT_GATEWAYS_MERCADO_PAGO_CREDENTIALS_CLIENT_SECRET" value="<?= $_ENV['PAYMENT_GATEWAYS_MERCADO_PAGO_CREDENTIALS_CLIENT_SECRET'] ?>" id="MERCADO_PAGO_CREDENTIALS_CLIENT_SECRET">
                                <span class="help-inline">Pode ser encontrado no menu <a href="https://www.mercadopago.com.br/settings/account/credentials" target="_blank" rel="noopener noreferrer">"Seu Negócio" -> "Configurações" -> "Credenciais"</a></span>
                            </div>
                        </div>
                        <div class="control-group">
                            <label for="MERCADO_PAGO_BOLETO_EXPIRATION" class="control-label">Dias para vencimento do boleto</label>
                            <div class="controls">
                                <select name="PAYMENT_GATEWAYS_MERCADO_PAGO_BOLETO_EXPIRATION" id="MERCADO_PAGO_BOLETO_EXPIRATION">
                                    <?php for ($i = 1; $i <= 30; $i++) :
                                        $diasMP = "P{$i}D";
                                        ?>
                                        <option value="<?= $diasMP ?>" <?= $diasMP == $_ENV['PAYMENT_GATEWAYS_MERCADO_PAGO_BOLETO_EXPIRATION'] ? 'selected' : '' ?>><?= $i ?> dia<?= $i > 1 ? 's' : '' ?></option>
                                    <?php endfor; ?>
                                </select>
                                <span class="help-inline">A quantidade de dias selecionado será somado a data que a cobrança for gerada.</span>
                            </div>
                        </div>

                        <!-- Configrações do ASAAS -->
                        <hr>
                        <h5 style="margin-left:10px;">Configrações do ASAAS</h5>
                        <div class="control-group">
                            <label for="ASAAS_PRODUCTION" class="control-label">Ambiente</label>
                            <div class="controls">
                                <select name="PAYMENT_GATEWAYS_ASAAS_PRODUCTION" id="ASAAS_PRODUCTION">
                                    <option value="false" <?= !filter_var($_ENV['PAYMENT_GATEWAYS_ASAAS_PRODUCTION'] ?? false, FILTER_VALIDATE_BOOLEAN) ? 'selected' : ''; ?>>Sandbox</option>
                                    <option value="true" <?= filter_var($_ENV['PAYMENT_GATEWAYS_ASAAS_PRODUCTION'] ?? false, FILTER_VALIDATE_BOOLEAN) ? 'selected' : ''; ?>>Produção</option>
                                </select>
                                <span class="help-inline">Sandbox é um ambiente para testes.</span>
                            </div>
                        </div>
                        <div class="control-group">
                            <label for="ASAAS_NOTIFY" class="control-label">Notify</label>
                            <div class="controls">
                                <select name="PAYMENT_GATEWAYS_ASAAS_NOTIFY" id="ASAAS_NOTIFY">
                                    <option value="false" <?= !filter_var($_ENV['PAYMENT_GATEWAYS_ASAAS_NOTIFY'] ?? false, FILTER_VALIDATE_BOOLEAN) ? 'selected' : ''; ?>>Desativado</option>
                                    <option value="true" <?= filter_var($_ENV['PAYMENT_GATEWAYS_ASAAS_NOTIFY'] ?? false, FILTER_VALIDATE_BOOLEAN) ? 'selected' : ''; ?>>Ativado</option>
                                </select>
                                <span class="help-inline">Ativar ou desativar o Notify do Asaas.</span>
                            </div>
                        </div>
                        <div class="control-group">
                            <label for="ASAAS_CREDENTIAIS_API_KEY" class="control-label">API_KEY</label>
                            <div class="controls">
                                <input type="text" name="PAYMENT_GATEWAYS_ASAAS_CREDENTIAIS_API_KEY" value="<?= $_ENV['PAYMENT_GATEWAYS_ASAAS_CREDENTIAIS_API_KEY'] ?>" id="ASAAS_CREDENTIAIS_API_KEY">
                                <span class="help-inline">Pode ser encontrado no menu "Minha Conta", clique em "Integração" e depois em "Gerar API Key"</span>
                            </div>
                        </div>
                        <div class="control-group">
                            <label for="ASAAS_BOLETO_EXPIRATION" class="control-label">Dias para vencimento do boleto</label>
                            <div class="controls">
                                <select name="PAYMENT_GATEWAYS_ASAAS_BOLETO_EXPIRATION" id="ASAAS_BOLETO_EXPIRATION">
                                    <?php for ($i = 1; $i <= 30; $i++) :
                                        $diasASAAS = "P{$i}D";
                                        ?>
                                        <option value="<?= $diasASAAS ?>" <?= $diasASAAS == $_ENV['PAYMENT_GATEWAYS_ASAAS_BOLETO_EXPIRATION'] ? 'selected' : '' ?>><?= $i ?> dia<?= $i > 1 ? 's' : '' ?></option>
                                    <?php endfor; ?>
                                </select>
                                <span class="help-inline">A quantidade de dias selecionado será somado a data que a cobrança for gerada.</span>
                            </div>
                        </div>

                        <div class="form-actions">
                            <div class="span8">
                                <div class="span9">
                                  <button type="submit" class="button btn btn-primary">
                                  <span class="button__icon"><i class='bx bx-save'></i></span><span class="button__text2">Salvar Alterações</span></button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Menu Produtos -->
                    <div id="menu2" class="tab-pane fade">
                        <div class="control-group">
                            <label for="control_estoque" class="control-label">Controlar Estoque</label>
                            <div class="controls">
                                <select name="control_estoque" id="control_estoque">
                                    <option value="1">Ativar</option>
                                    <option value="0" <?= $configuration['control_estoque'] == '0' ? 'selected' : ''; ?>>Desativar</option>
                                </select>
                                <span class="help-inline">Ativar ou desativar o controle de estoque.</span>
                            </div>
                        </div>
                        <div class="control-group">
                            <label for="pdv_enabled" class="control-label">Módulo PDV (Ponto de Venda)</label>
                            <div class="controls">
                                <select name="pdv_enabled" id="pdv_enabled">
                                    <option value="0" <?= ($configuration['pdv_enabled'] ?? '0') == '0' ? 'selected' : ''; ?>>Desativado</option>
                                    <option value="1" <?= ($configuration['pdv_enabled'] ?? '0') == '1' ? 'selected' : ''; ?>>Ativado</option>
                                </select>
                                <span class="help-inline">Quando ativado, aparece o item "PDV" no menu lateral para vendas rápidas no balcão.</span>
                            </div>
                        </div>

                        <div class="control-group">
                            <label for="venda_sem_estoque" class="control-label">Venda sem Estoque</label>
                            <div class="controls">
                                <select name="venda_sem_estoque" id="venda_sem_estoque">
                                    <option value="0" <?= ($configuration['venda_sem_estoque'] ?? '0') == '0' ? 'selected' : ''; ?>>Bloquear (padrão)</option>
                                    <option value="1" <?= ($configuration['venda_sem_estoque'] ?? '0') == '1' ? 'selected' : ''; ?>>Permitir com aviso</option>
                                    <option value="2" <?= ($configuration['venda_sem_estoque'] ?? '0') == '2' ? 'selected' : ''; ?>>Permitir silenciosamente</option>
                                </select>
                                <span class="help-inline">
                                    <strong>Bloquear:</strong> impede adicionar produto sem estoque.<br>
                                    <strong>Permitir com aviso:</strong> vende e faz estoque negativo, exibindo alerta.<br>
                                    <strong>Permitir silenciosamente:</strong> vende e faz estoque negativo sem avisar.
                                </span>
                            </div>
                        </div>
                        <div class="form-actions">
                            <div class="span8">
                                <div class="span9">
                                  <button type="submit" class="button btn btn-primary">
                                  <span class="button__icon"><i class='bx bx-save'></i></span><span class="button__text2">Salvar Alterações</span></button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Menu Notificações -->
                    <div id="menu3" class="tab-pane fade">
                        <div class="control-group">
                            <label for="os_notification" class="control-label">Notificação de OS</label>
                            <div class="controls">
                                <select name="os_notification" id="os_notification">
                                    <option value="todos">Notificar a Todos</option>
                                    <option value="cliente" <?= $configuration['os_notification'] == 'cliente' ? 'selected' : ''; ?>>Somente o Cliente</option>
                                    <option value="tecnico" <?= $configuration['os_notification'] == 'tecnico' ? 'selected' : ''; ?>>Somente o Técnico</option>
                                    <option value="emitente" <?= $configuration['os_notification'] == 'emitente' ? 'selected' : ''; ?>>Somente o Emitente</option>
                                    <option value="nenhum" <?= $configuration['os_notification'] == 'nenhum' ? 'selected' : ''; ?>>Não Notificar</option>
                                </select>
                                <span class="help-inline">Selecione a opção de notificação por e-mail no cadastro de OS.</span>
                            </div>
                        </div>
                        <div class="control-group">
                            <label for="email_automatico" class="control-label">Enviar Email Automático</label>
                            <div class="controls">
                                <select name="email_automatico" id="email_automatico">
                                    <option value="1">Ativar</option>
                                    <option value="0" <?= $configuration['email_automatico'] == '0' ? 'selected' : ''; ?>>Desativar</option>
                                </select>
                                <span class="help-inline">Ativar ou Desativar a opção de envio de e-mail automático no cadastro de OS.</span>
                            </div>
                        </div>
                        <div class="control-group">
                            <label for="notifica_whats" class="control-label">Notificação do whatsapp</label>
                            <div class="controls">
                                <textarea rows="5" cols="20" name="notifica_whats" id="notifica_whats" placeholder="Use as tags abaixo para criar seu texto!" style="margin: 0px; width: 606px; height: 86px;"><?php echo $configuration['notifica_whats']; ?></textarea>
                            </div>
                            <div class="span3">
                                <label for="notifica_whats_select">Tags de preenchimento<span class="required"></span></label>
                                <select class="span12" name="notifica_whats_select" id="notifica_whats_select" value="">
                                    <option value="0">Selecione...</option>
                                    <option value="{CLIENTE_NOME}">Nome do Cliente</option>
                                    <option value="{NUMERO_OS}">Número da OS</option>
                                    <option value="{STATUS_OS}">Status da OS</option>
                                    <option value="{VALOR_OS}">Valor da OS</option>
                                    <option value="{DESCRI_PRODUTOS}">Descrição produtos</option>
                                    <option value="{EMITENTE}">Nome emitente</option>
                                    <option value="{TELEFONE_EMITENTE}">Telefone emitente</option>
                                    <option value="{OBS_OS}">Observações</option>
                                    <option value="{DEFEITO_OS}">Defeitos</option>
                                    <option value="{LAUDO_OS}">Laudo</option>
                                    <option value="{DATA_FINAL}">Data Final</option>
                                    <option value="{DATA_INICIAL}">Data Inicial</option>
                                    <option value="{DATA_GARANTIA}">Data da Garantia</option>
                                </select>
                            </div>
                            <span6 class="span10">
                                Para negrito use: *palavra*
                                Para itálico use: _palavra_
                                Para riscado use: ~palavra~
                                </span>
                        </div>
                        <div class="form-actions">
                            <div class="span8">
                                <div class="span9">
                                  <button type="submit" class="button btn btn-primary">
                                  <span class="button__icon"><i class='bx bx-save'></i></span><span class="button__text2">Salvar Alterações</span></button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Menu Atualização -->
                    <div id="menu4" class="tab-pane fade">
                        <div class="form-actions">
                            <div class="span8">
                                <div class="span9" style="display:flex">
                                    <button href="#modal-confirmabanco" data-toggle="modal" type="button" class="button btn btn-warning">
                                      <span class="button__icon"><i class="bx bx-sync"></i></span><span class="button__text2">Banco de Dados</span></button>
                                    <button href="#modal-confirmaratualiza" data-toggle="modal" type="button" class="button btn btn-danger">
                                      <span class="button__icon"><i class="bx bx-sync"></i></span><span class="button__text2">Atualizar Sisos</span></button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Menu OS -->
                    <div id="menu5" class="tab-pane fade">
                        <div class="control-group">
                            <div class="span8" style="margin-left: 3em;">
                                <label for="control_2vias" class="control-label">Controle de Impressão em 2 Vias</label>
                                <div class="controls">
                                    <select name="control_2vias" id="control_2vias">
                                        <option value="1">Ativar</option>
                                        <option value="0" <?= $configuration['control_2vias'] == '0' ? 'selected' : ''; ?>>Desativar</option>
                                    </select>
                                    <span class="help-inline">Ativar ou desativar impressão de OS em 2 vias.</span>
                                </div>
                            </div>
                            <div class="span8">
                                <span6 class="span10" style="margin-left: 2em;"> Defina a vizualização padrão, onde o que ficar checado será exibida na listagem de OS por padrão. </span6>
                                <div class="span10" style="margin-left: 3em;">
                                    <label> <input <?= @in_array("Aberto", json_decode($configuration['os_status_list'])) == 'true' ? 'checked' : ''; ?> name="os_status_list[]" class="marcar" type="checkbox" value="Aberto"> <span class="lbl"> Aberto</span> </label>
                                    <label> <input <?= @in_array("Orçamento", json_decode($configuration['os_status_list'])) == 'true' ? 'checked' : ''; ?> name="os_status_list[]" class="marcar" type="checkbox" value="Orçamento"> <span class="lbl"> Orçamento</span> </label>
                                    <label> <input <?= @in_array("Negociação", json_decode($configuration['os_status_list'])) == 'true' ? 'checked' : ''; ?> name="os_status_list[]" class="marcar" type="checkbox" value="Negociação"> <span class="lbl"> Negociação</span> </label>
                                    <label> <input <?= @in_array("Aprovado", json_decode($configuration['os_status_list'])) == 'true' ? 'checked' : ''; ?> name="os_status_list[]" class="marcar" type="checkbox" value="Aprovado"> <span class="lbl"> Aprovado </span> </label>
                                    <label> <input <?= @in_array("Aguardando Peças", json_decode($configuration['os_status_list'])) == 'true' ? 'checked' : ''; ?> name="os_status_list[]" class="marcar" type="checkbox" value="Aguardando Peças"> <span class="lbl"> Aguardando Peças </span> </label>
                                    <label> <input <?= @in_array("Em Andamento", json_decode($configuration['os_status_list'])) == 'true' ? 'checked' : ''; ?> name="os_status_list[]" class="marcar" type="checkbox" value="Em Andamento"> <span class="lbl"> Em Andamento</span> </label>
                                    <label> <input <?= @in_array("Finalizado", json_decode($configuration['os_status_list'])) == 'true' ? 'checked' : ''; ?> name="os_status_list[]" class="marcar" type="checkbox" value="Finalizado"> <span class="lbl"> Finalizado</span> </label>
                                    <label> <input <?= @in_array("Faturado", json_decode($configuration['os_status_list'])) == 'true' ? 'checked' : ''; ?> name="os_status_list[]" class="marcar" type="checkbox" value="Faturado"> <span class="lbl"> Faturado</span> </label>
                                    <label> <input <?= @in_array("Cancelado", json_decode($configuration['os_status_list'])) == 'true' ? 'checked' : ''; ?> name="os_status_list[]" class="marcar" type="checkbox" value="Cancelado"> <span class="lbl"> Cancelado</span> </label>
                                    <label> <input <?= @in_array("Recusado", json_decode($configuration['os_status_list'])) == 'true' ? 'checked' : ''; ?> name="os_status_list[]" class="marcar" type="checkbox" value="Recusado"> <span class="lbl"> Recusado</span> </label>
                                    <label> <input <?= @in_array("Aguardando Autorização", json_decode($configuration['os_status_list'])) == 'true' ? 'checked' : ''; ?> name="os_status_list[]" class="marcar" type="checkbox" value="Aguardando Autorização"> <span class="lbl"> Aguardando Autorização</span> </label>
                                    <label> <input <?= @in_array("Não foi Possível", json_decode($configuration['os_status_list'])) == 'true' ? 'checked' : ''; ?> name="os_status_list[]" class="marcar" type="checkbox" value="Não foi Possível"> <span class="lbl"> Não foi Possível</span> </label>
                                    <label> <input <?= @in_array("Sem Conserto", json_decode($configuration['os_status_list'])) == 'true' ? 'checked' : ''; ?> name="os_status_list[]" class="marcar" type="checkbox" value="Sem Conserto"> <span class="lbl"> Sem Conserto</span> </label>
                                    <label> <input <?= @in_array("Não temos Peças", json_decode($configuration['os_status_list'])) == 'true' ? 'checked' : ''; ?> name="os_status_list[]" class="marcar" type="checkbox" value="Não temos Peças"> <span class="lbl"> Não temos Peças</span> </label>
                                    <label> <input <?= @in_array("Em Teste", json_decode($configuration['os_status_list'])) == 'true' ? 'checked' : ''; ?> name="os_status_list[]" class="marcar" type="checkbox" value="Em Teste"> <span class="lbl"> Em Teste</span> </label>
                                </div>
                            </div>
                            <div class="span8">
                                <label for="imprmirAnexos" class="control-label">Imprimir Anexos na A4?</label>
                                <div class="controls">
                                    <select name="imprmirAnexos" id="imprmirAnexos">
                                        <option value="true">Sim</option>
                                        <option value="false" <?= !filter_var($_ENV['IMPRIMIR_ANEXOS'] ?? false, FILTER_VALIDATE_BOOLEAN) ? 'selected' : ''; ?>>Não</option>
                                    </select>
                                    <span class="help-inline">Gostaria de imprimir os Anexos na impressão A4?</span>
                                </div>
                            </div>
                        </div>
                        <div class="form-actions">
                            <div class="span8">
                                <div class="span9">
                                  <button type="submit" class="button btn btn-primary">
                                  <span class="button__icon"><i class='bx bx-save'></i></span><span class="button__text2">Salvar Alterações</span></button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Menu API -->
                    <div id="menu6" class="tab-pane fade">
                        <div class="control-group">
                            <label for="apiEnabled" class="control-label">Ativar acesso à API</label>
                            <div class="controls">
                                <select name="apiEnabled" id="apiEnabled">
                                    <option value="true">Ativar</option>
                                    <option value="false" <?= !filter_var($_ENV['API_ENABLED'] ?? false, FILTER_VALIDATE_BOOLEAN) ? 'selected' : ''; ?>>Desativar</option>
                                </select>
                                <span class="help-inline">Ativar ou desativar acesso à API.</span>
                            </div>
                        </div>
                        <div class="control-group">
                            <label for="apiEnabled" class="control-label">URL API</label>
                            <div class="controls">
                                <span class="span10" id="urlApi" style="margin-top:7px;"><?= trim($_ENV['APP_BASEURL'], '/') . '/' ?>index.php/api/v1</span>
                            </div>
                        </div>
                        <div class="control-group">
                            <label for="apiExpireTime" class="control-label">Tempo de expiração</label>
                            <div class="controls">
                                <select name="apiExpireTime" id="apiExpireTime">
                                    <option value="60" <?= $_ENV['API_TOKEN_EXPIRE_TIME'] == 60 ? 'selected' : '' ?>>1 minuto</option>
                                    <option value="3600" <?= $_ENV['API_TOKEN_EXPIRE_TIME'] == 3600 ? 'selected' : '' ?>>1 hora</option>
                                    <option value="86400" <?= $_ENV['API_TOKEN_EXPIRE_TIME'] == 86400 ? 'selected' : '' ?>>1 dia</option>
                                    <option value="604800" <?= $_ENV['API_TOKEN_EXPIRE_TIME'] == 604800 ? 'selected' : '' ?>>1 semana</option>
                                    <option value="2592000" <?= $_ENV['API_TOKEN_EXPIRE_TIME'] == 2592000 ? 'selected' : '' ?>>1 mês</option>
                                </select>
                                <span class="help-inline">Tempo de duração da sessão na API.</span>
                            </div>
                        </div>
                        <div class="control-group">
                            <label for="resetJwtToken" class="control-label">Resetar token JWT</label>
                            <div class="controls">
                                <select name="resetJwtToken" id="resetJwtToken">
                                    <option value="nao" selected>Não</option>
                                    <option value="sim">Sim</option>
                                </select>
                                <span class="help-inline">Gerar um novo token JWT.</span>
                            </div>
                        </div>
                        <div class="form-actions">
                            <div class="span8">
                                <div class="span9">
                                  <button type="submit" class="button btn btn-primary">
                                  <span class="button__icon"><i class='bx bx-save'></i></span><span class="button__text2">Salvar Alterações</span></button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Menu E-mail -->
                    <div id="menu7" class="tab-pane fade">
                        <div class="control-group">
                            <label for="EMAIL_PROTOCOL" class="control-label">Protocolo de E-mail</label>
                            <div class="controls">
                                <input type="text" name="EMAIL_PROTOCOL" value="<?= $_ENV['EMAIL_PROTOCOL'] ?>" id="EMAIL_PROTOCOL">
                                <span class="help-inline">Informe o protocolo que será utilizado</span>
                            </div>
                        </div>
                        <div class="control-group">
                            <label for="EMAIL_SMTP_HOST" class="control-label">Endereço do Host</label>
                            <div class="controls">
                                <input type="text" name="EMAIL_SMTP_HOST" value="<?= $_ENV['EMAIL_SMTP_HOST'] ?>" id="EMAIL_SMTP_HOST">
                                <span class="help-inline">Informe o endereço do host</span>
                            </div>
                        </div>
                        <div class="control-group">
                            <label for="EMAIL_SMTP_CRYPTO" class="control-label">Tipo de criptografia</label>
                            <div class="controls">
                                <select name="EMAIL_SMTP_CRYPTO" id="EMAIL_SMTP_CRYPTO">
                                    <option value="tls" <?= $_ENV['EMAIL_SMTP_CRYPTO'] == 'tls' ? 'selected' : ''; ?>>tls</option>
                                    <option value="ssl" <?= $_ENV['EMAIL_SMTP_CRYPTO'] == 'ssl' ? 'selected' : ''; ?>>ssl</option>
                                </select>
                                <span class="help-inline">Tipo de criptografia que será utilizada.</span>
                            </div>
                        </div>
                        <div class="control-group">
                            <label for="EMAIL_SMTP_PORT" class="control-label">Porta</label>
                            <div class="controls">
                                <input type="text" name="EMAIL_SMTP_PORT" value="<?= $_ENV['EMAIL_SMTP_PORT'] ?>" id="EMAIL_SMTP_PORT">
                                <span class="help-inline">Informe a porta que será utilizada.</span>
                            </div>
                        </div>
                        <div class="control-group">
                            <label for="EMAIL_SMTP_USER" class="control-label">Usuário</label>
                            <div class="controls">
                                <input type="text" name="EMAIL_SMTP_USER" value="<?= $_ENV['EMAIL_SMTP_USER'] ?>" id="EMAIL_SMTP_USER">
                                <span class="help-inline">Informe nome de usuáriodo e-mail.</span>
                            </div>
                        </div>
                        <div class="control-group">
                            <label for="EMAIL_SMTP_PASS" class="control-label">Senha</label>
                            <div class="controls">
                                <input type="password" name="EMAIL_SMTP_PASS" value="<?= $_ENV['EMAIL_SMTP_PASS'] ?>" id="EMAIL_SMTP_PASS">
                                <span class="help-inline">Informe a senha do e-mail.</span>
                            </div>
                        </div>
                        <div class="form-actions">
                            <div class="span8">
                                <div class="span9">
                                  <button type="submit" class="button btn btn-primary">
                                  <span class="button__icon"><i class='bx bx-save'></i></span><span class="button__text2">Salvar Alterações</span></button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </form>
                    <!-- Menu Nota Fiscal -->
                    <div id="menu8" class="tab-pane fade">
                        <div style="padding: 10px 15px;">
                            <div class="alert alert-info" style="margin-bottom:15px;">
                                <strong><i class='bx bx-info-circle'></i> Focus NF-e</strong> &mdash;
                                Provedor gratuito para emissão de NF-e/NFS-e.
                                Crie sua conta gratuita em <a href="https://focusnfe.com.br" target="_blank" rel="noopener">focusnfe.com.br</a>
                                e obtenha seu token de acesso. O plano gratuito inclui 50 documentos/mês em ambiente de homologação (testes).
                            </div>

                            <form action="<?= site_url('sisos/salvarConfigNfe') ?>" method="post" class="form-horizontal">
                                <div class="control-group">
                                    <label class="control-label">Ativar Módulo NF-e</label>
                                    <div class="controls">
                                        <select name="nfe_enabled" id="nfe_enabled">
                                            <option value="0" <?= ($configuration['nfe_enabled'] ?? '0') == '0' ? 'selected' : '' ?>>Desativado</option>
                                            <option value="1" <?= ($configuration['nfe_enabled'] ?? '0') == '1' ? 'selected' : '' ?>>Ativado</option>
                                        </select>
                                        <span class="help-inline">Ativa o botão de emissão de NF-e nas telas de OS e Vendas.</span>
                                    </div>
                                </div>

                                <div class="control-group">
                                    <label class="control-label">Ambiente</label>
                                    <div class="controls">
                                        <select name="nfe_ambiente" id="nfe_ambiente">
                                            <option value="homologacao" <?= ($configuration['nfe_ambiente'] ?? 'homologacao') == 'homologacao' ? 'selected' : '' ?>>Homologação (Testes)</option>
                                            <option value="producao" <?= ($configuration['nfe_ambiente'] ?? 'homologacao') == 'producao' ? 'selected' : '' ?>>Produção</option>
                                        </select>
                                        <span class="help-inline">Use <strong>Homologação</strong> para testes. Notas emitidas em homologação não têm validade fiscal.</span>
                                    </div>
                                </div>

                                <div class="control-group">
                                    <label class="control-label">Token de Acesso</label>
                                    <div class="controls">
                                        <input type="text" name="nfe_token" value="<?= htmlspecialchars($configuration['nfe_token'] ?? '') ?>" placeholder="Token gerado no painel Focus NF-e" style="width:400px;">
                                        <span class="help-inline">
                                            Encontre seu token em:
                                            <a href="https://app.focusnfe.com.br/#/tokens" target="_blank" rel="noopener">app.focusnfe.com.br → Tokens</a>
                                        </span>
                                    </div>
                                </div>

                                <div class="control-group">
                                    <label class="control-label">CNPJ do Emitente</label>
                                    <div class="controls">
                                        <input type="text" name="nfe_cnpj_emitente" value="<?= htmlspecialchars($configuration['nfe_cnpj_emitente'] ?? '') ?>" placeholder="00.000.000/0000-00">
                                        <span class="help-inline">CNPJ da empresa emissora das notas. Deve estar cadastrado na Focus NF-e.</span>
                                    </div>
                                </div>

                                <div class="control-group">
                                    <label class="control-label">Natureza da Operação</label>
                                    <div class="controls">
                                        <input type="text" name="nfe_natureza_operacao" value="<?= htmlspecialchars($configuration['nfe_natureza_operacao'] ?? 'Venda de mercadoria') ?>">
                                        <span class="help-inline">Ex: "Venda de mercadoria", "Prestação de Serviços", etc.</span>
                                    </div>
                                </div>

                                <div class="form-actions">
                                    <div class="span8">
                                        <div class="span9">
                                            <button type="submit" class="button btn btn-primary">
                                                <span class="button__icon"><i class='bx bx-save'></i></span>
                                                <span class="button__text2">Salvar Configurações NF-e</span>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </form>

                            <!-- Teste de conexão -->
                            <hr>
                            <h6 style="margin-left:10px;">Testar conexão com a Focus NF-e</h6>
                            <div style="padding:0 10px;">
                                <button type="button" class="button btn btn-warning" id="btnTestarNfe">
                                    <span class="button__icon"><i class='bx bx-wifi'></i></span>
                                    <span class="button__text2">Testar Conexão</span>
                                </button>
                                <span id="resultadoTesteNfe" style="margin-left:10px;"></span>
                            </div>
                        </div>
                    </div>
                    <!-- Fim Menu Nota Fiscal -->

                    <!-- Categorias de Despesa -->
                    <div id="tabCatDespesa" class="tab-pane fade">
                        
<style>
/* === Categorias === */
.cat-wrap        { display: flex; flex-direction: column; gap: 10px; }
.cat-section     { border-radius: 8px; overflow: hidden; border: 2px solid #444860; box-shadow: 0 2px 8px rgba(0,0,0,.35); }
.cat-grupo-header{ display: flex; justify-content: space-between; align-items: center;
                   padding: 12px 16px; background: #3b3f58; }
.cat-grupo-header:hover { background: #454966; }
.cat-grupo-nome  { font-weight: 700; font-size: 14px; color: #ffffff; display: flex; align-items: center; gap: 8px; letter-spacing:.2px; }
.cat-badge       { font-size: 11px; font-weight: 600; background: rgba(255,255,255,.18);
                   border-radius: 12px; padding: 2px 8px; color: #fff; }
.cat-grupo-acoes { display: flex; gap: 5px; }
.cat-grupo-acoes .btn { padding: 4px 10px; font-size: 12px; border-radius: 5px; }
.cat-filhos      { background: #22253a; }
.cat-filho-row   { display: flex; justify-content: space-between; align-items: center;
                   padding: 10px 16px 10px 38px; border-bottom: 1px solid #2e3150;
                   font-size: 13px; font-weight: 500; color: #d4d7ec; }
.cat-filho-row:last-child  { border-bottom: none; }
.cat-filho-row:hover       { background: #282b42; color: #fff; }
.cat-filho-acoes { display: flex; gap: 4px; opacity: 0; transition: opacity .15s; }
.cat-filho-row:hover .cat-filho-acoes { opacity: 1; }
.cat-filho-acoes .btn { padding: 2px 8px; font-size: 11px; border-radius: 4px; }
.cat-vazia       { color: #6e728f; font-size: 12px; padding: 10px 16px 10px 38px;
                   font-style: italic; background: #22253a; }
.cat-header-bar  { display: flex; justify-content: space-between; align-items: center;
                   margin-bottom: 16px; padding-bottom: 12px; border-bottom: 2px solid #3b3f58; }
.cat-header-bar h5 { margin: 0; font-size: 15px; font-weight: 700; color: #ffffff;
                     display: flex; align-items: center; gap: 8px; }
</style>

                        <div style="padding:14px 16px">
                            <div class="cat-header-bar">
                                <h5><i class='bx bx-trending-down' style="color:#e74c3c;"></i>Categorias de Despesa</h5>
                                <button class="button btn btn-success btn-mini" onclick="abrirModalCategoria('despesa', null)">
                                    <span class="button__icon"><i class='bx bx-plus'></i></span>
                                    <span class="button__text2">Nova Categoria</span>
                                </button>
                            </div>
                            <?php
                            $this->load->model('categorias_model');
                            $gruposDespesa = $this->categorias_model->getGrupos('despesa');
                            if (empty($gruposDespesa)):
                            ?>
                                <div class="alert alert-info">Nenhuma categoria cadastrada. Clique em <strong>Nova Categoria</strong> para começar.</div>
                            <?php else: foreach ($gruposDespesa as $g):
                                $filhos = $this->categorias_model->getFilhos($g->idCategorias);
                            ?>
                            <div class="cat-section">
                                <div class="cat-grupo-header">
                                    <div class="cat-grupo-nome">
                                        <i class='bx bx-folder-open' style="color:#e67e22;font-size:15px;"></i>
                                        <?= htmlspecialchars($g->categoria) ?>
                                        <span class="cat-badge"><?= count($filhos) ?></span>
                                    </div>
                                    <div class="cat-grupo-acoes">
                                        <button class="btn btn-mini btn-success" onclick="abrirModalCategoria('despesa', <?= $g->idCategorias ?>)" title="Adicionar subcategoria">
                                            <i class="bx bx-plus"></i>
                                        </button>
                                        <button class="btn btn-mini btn-info btn-editar-cat" data-id="<?=$g->idCategorias?>" data-nome="<?=htmlspecialchars($g->categoria)?>" title="Editar">
                                            <i class="bx bx-edit"></i>
                                        </button>
                                        <button class="btn btn-mini btn-danger btn-excluir-cat" data-id="<?=$g->idCategorias?>" title="Excluir">
                                            <i class="bx bx-trash"></i>
                                        </button>
                                    </div>
                                </div>
                                <?php if (!empty($filhos)): ?>
                                <div class="cat-filhos">
                                    <?php foreach ($filhos as $f): ?>
                                    <div class="cat-filho-row">
                                        <span><i class='bx bx-subdirectory-right' style="opacity:.35;margin-right:4px;"></i><?= htmlspecialchars($f->categoria) ?></span>
                                        <div class="cat-filho-acoes">
                                            <button class="btn btn-mini btn-info btn-editar-cat" data-id="<?=$f->idCategorias?>" data-nome="<?=htmlspecialchars($f->categoria)?>" title="Editar"><i class="bx bx-edit"></i></button>
                                            <button class="btn btn-mini btn-danger btn-excluir-cat" data-id="<?=$f->idCategorias?>" title="Excluir"><i class="bx bx-trash"></i></button>
                                        </div>
                                    </div>
                                    <?php endforeach; ?>
                                </div>
                                <?php else: ?>
                                <div class="cat-vazia">Nenhuma subcategoria</div>
                                <?php endif; ?>
                            </div>
                            <?php endforeach; endif; ?>
                        </div>
                    </div>

                    <!-- Categorias de Receita -->
                    <div id="tabCatReceita" class="tab-pane fade">
                        <div style="padding:14px 16px">
                            <div class="cat-header-bar">
                                <h5><i class='bx bx-trending-up' style="color:#27ae60;"></i>Categorias de Receita</h5>
                                <button class="button btn btn-success btn-mini" onclick="abrirModalCategoria('receita', null)">
                                    <span class="button__icon"><i class='bx bx-plus'></i></span>
                                    <span class="button__text2">Nova Categoria</span>
                                </button>
                            </div>
                            <?php
                            $gruposReceita = $this->categorias_model->getGrupos('receita');
                            if (empty($gruposReceita)):
                            ?>
                                <div class="alert alert-info">Nenhuma categoria cadastrada. Clique em <strong>Nova Categoria</strong> para começar.</div>
                            <?php else: foreach ($gruposReceita as $g):
                                $filhos = $this->categorias_model->getFilhos($g->idCategorias);
                            ?>
                            <div class="cat-section">
                                <div class="cat-grupo-header">
                                    <div class="cat-grupo-nome">
                                        <i class='bx bx-folder-open' style="color:#27ae60;font-size:15px;"></i>
                                        <?= htmlspecialchars($g->categoria) ?>
                                        <span class="cat-badge"><?= count($filhos) ?></span>
                                    </div>
                                    <div class="cat-grupo-acoes">
                                        <button class="btn btn-mini btn-success" onclick="abrirModalCategoria('receita', <?= $g->idCategorias ?>)" title="Adicionar subcategoria">
                                            <i class="bx bx-plus"></i>
                                        </button>
                                        <button class="btn btn-mini btn-info btn-editar-cat" data-id="<?=$g->idCategorias?>" data-nome="<?=htmlspecialchars($g->categoria)?>" title="Editar">
                                            <i class="bx bx-edit"></i>
                                        </button>
                                        <button class="btn btn-mini btn-danger btn-excluir-cat" data-id="<?=$g->idCategorias?>" title="Excluir">
                                            <i class="bx bx-trash"></i>
                                        </button>
                                    </div>
                                </div>
                                <?php if (!empty($filhos)): ?>
                                <div class="cat-filhos">
                                    <?php foreach ($filhos as $f): ?>
                                    <div class="cat-filho-row">
                                        <span><i class='bx bx-subdirectory-right' style="opacity:.35;margin-right:4px;"></i><?= htmlspecialchars($f->categoria) ?></span>
                                        <div class="cat-filho-acoes">
                                            <button class="btn btn-mini btn-info btn-editar-cat" data-id="<?=$f->idCategorias?>" data-nome="<?=htmlspecialchars($f->categoria)?>" title="Editar"><i class="bx bx-edit"></i></button>
                                            <button class="btn btn-mini btn-danger btn-excluir-cat" data-id="<?=$f->idCategorias?>" title="Excluir"><i class="bx bx-trash"></i></button>
                                        </div>
                                    </div>
                                    <?php endforeach; ?>
                                </div>
                                <?php else: ?>
                                <div class="cat-vazia">Nenhuma subcategoria</div>
                                <?php endif; ?>
                            </div>
                            <?php endforeach; endif; ?>
                        </div>
                    </div>

                    <!-- IA / Assistente -->
                    <div id="tabGemini" class="tab-pane fade">
                        <div style="padding:16px">

                            <!-- Header -->
                            <div class="cat-header-bar">
                                <h5><i class='bx bx-bot' style="color:#7c6af7;"></i> IA / Assistente</h5>
                            </div>

                            <form action="<?= site_url('sisos/salvarConfigGemini') ?>" method="post">

                                <!-- Campos extras multi-IA -->
                                <input type="hidden" name="ia_provedor"        id="ia_provedor_val"   value="<?= htmlspecialchars($configuration['ia_provedor']??'gemini') ?>">
                                <input type="hidden" name="openai_api_key"     value="<?= htmlspecialchars($configuration['openai_api_key']??'') ?>">
                                <input type="hidden" name="openai_model"       value="<?= htmlspecialchars($configuration['openai_model']??'gpt-4o-mini') ?>">
                                <input type="hidden" name="claude_api_key"     value="<?= htmlspecialchars($configuration['claude_api_key']??'') ?>">
                                <input type="hidden" name="claude_model"       value="<?= htmlspecialchars($configuration['claude_model']??'claude-haiku-4-5-20251001') ?>">
                                <input type="hidden" name="perplexity_api_key" value="<?= htmlspecialchars($configuration['perplexity_api_key']??'') ?>">
                                <input type="hidden" name="perplexity_model"   value="<?= htmlspecialchars($configuration['perplexity_model']??'llama-3.1-sonar-small-128k-online') ?>">
                                <input type="hidden" name="deepseek_api_key"   value="<?= htmlspecialchars($configuration['deepseek_api_key']??'') ?>">
                                <input type="hidden" name="deepseek_model"     value="<?= htmlspecialchars($configuration['deepseek_model']??'deepseek-chat') ?>">
                                <input type="hidden" name="mistral_api_key"    value="<?= htmlspecialchars($configuration['mistral_api_key']??'') ?>">
                                <input type="hidden" name="mistral_model"      value="<?= htmlspecialchars($configuration['mistral_model']??'mistral-small-latest') ?>">

                                <!-- Status -->
                                <div class="cat-section" style="margin-bottom:12px;">
                                    <div class="cat-grupo-header">
                                        <div class="cat-grupo-nome"><i class='bx bx-toggle-right' style="color:#7c6af7;"></i> Status</div>
                                    </div>
                                    <div class="cat-filhos" style="padding:12px 16px;">
                                        <select name="gemini_enabled" style="width:220px;padding:7px 10px;border-radius:6px;border:1px solid #444860;background:#2a2d3e;color:#e8eaf0;font-size:13px;">
                                            <option value="0" <?= ($configuration['gemini_enabled']??'0')=='0'?'selected':'' ?>>⭕ Desativado</option>
                                            <option value="1" <?= ($configuration['gemini_enabled']??'0')=='1'?'selected':'' ?>>✅ Ativado</option>
                                        </select>
                                    </div>
                                </div>

                                <!-- Seletor de provedor -->
                                <div class="cat-section" style="margin-bottom:14px;">
                                    <div class="cat-grupo-header">
                                        <div class="cat-grupo-nome"><i class='bx bx-network-chart' style="color:#7c6af7;"></i> Selecione o Provedor para Configurar</div>
                                    </div>
                                    <div class="cat-filhos" style="padding:14px 16px;">
                                        <div style="display:flex;gap:8px;flex-wrap:wrap;margin-bottom:10px;">
                                        <?php
                                        $cfgProvs=['gemini'=>['🔵','Google Gemini','#4285f4','gemini_api_key'],'openai'=>['🟢','ChatGPT','#10a37f','openai_api_key'],'claude'=>['🟠','Claude','#d97706','claude_api_key'],'perplexity'=>['🔴','Perplexity','#ef4444','perplexity_api_key'],'deepseek'=>['🟣','DeepSeek','#8b5cf6','deepseek_api_key'],'mistral'=>['⚪','Mistral','#9ca3af','mistral_api_key']];
                                        $curProv=$configuration['ia_provedor']??'gemini';
                                        foreach($cfgProvs as $pk=>[$pi,$pl,$pc,$pkc]):
                                            $hasK=!empty($configuration[$pkc]);
                                            $isA=($pk===$curProv);
                                            $dot=$hasK?'<span style="width:7px;height:7px;border-radius:50%;background:#4ade80;display:inline-block;margin-left:3px;" title="Chave configurada"></span>':'<span style="width:7px;height:7px;border-radius:50%;background:#4b5563;display:inline-block;margin-left:3px;" title="Sem chave"></span>';
                                        ?>
                                        <button type="button" id="cfgBtn-<?=$pk?>" data-prov="<?=$pk?>" data-color="<?=$pc?>"
                                            onclick="iaCfgSwitch('<?=$pk?>','<?=$pc?>')"
                                            style="display:inline-flex;align-items:center;gap:5px;padding:8px 14px;border-radius:8px;font-size:13px;font-weight:700;cursor:pointer;transition:all .15s;border:2px solid <?=$isA?$pc:'rgba(255,255,255,0.1)'?>;background:<?=$isA?$pc.'22':'rgba(255,255,255,0.04)'?>;color:<?=$isA?$pc:'#9ca3af'?>;">
                                            <?=$pi?> <?=$pl?> <?=$dot?>
                                        </button>
                                        <?php endforeach; ?>
                                        </div>
                                        <small style="color:#6e728f;">🟢 = chave configurada &nbsp; ⚫ = sem chave &nbsp;|&nbsp; Clique no provedor para editar sua configuração. O ativo é salvo ao clicar em Salvar.</small>
                                    </div>
                                </div>

                                <!-- Gemini -->
                                <div class="cat-section prov-cfg-sec" id="prov-gemini" style="margin-bottom:12px;">
                                    <div class="cat-grupo-header"><div class="cat-grupo-nome"><i class='bx bx-star' style="color:#4285f4;"></i> Google Gemini &nbsp;<a href="https://aistudio.google.com/app/apikey" target="_blank" style="color:#4285f4;font-size:11px;font-weight:400;">Obter chave</a></div></div>
                                    <div class="cat-filhos" style="padding:14px 16px;">
                                        <div style="display:grid;grid-template-columns:1fr 1fr;gap:14px;">
                                            <div>
                                                <label style="color:#9ca0b8;font-size:12px;margin-bottom:4px;display:block;">Modelo</label>
                                                <select name="gemini_model" style="width:100%;padding:7px 10px;border-radius:6px;border:1px solid #444860;background:#2a2d3e;color:#e8eaf0;font-size:13px;">
                                                    <option value="gemini-2.0-flash"     <?=($configuration['gemini_model']??'gemini-2.0-flash')=='gemini-2.0-flash'   ?'selected':''?>>🚀 gemini-2.0-flash (recomendado)</option>
                                                    <option value="gemini-2.0-flash-lite"<?=($configuration['gemini_model']??'')=='gemini-2.0-flash-lite'?'selected':''?>>⚡ gemini-2.0-flash-lite</option>
                                                    <option value="gemini-1.5-flash"     <?=($configuration['gemini_model']??'')=='gemini-1.5-flash'    ?'selected':''?>>🔥 gemini-1.5-flash (estável)</option>
                                                    <option value="gemini-1.5-flash-8b"  <?=($configuration['gemini_model']??'')=='gemini-1.5-flash-8b' ?'selected':''?>>💡 gemini-1.5-flash-8b (gratuito)</option>
                                                </select>
                                            </div>
                                            <div>
                                                <label style="color:#9ca0b8;font-size:12px;margin-bottom:4px;display:block;">🔑 Chave API</label>
                                                <input type="password" name="gemini_api_key" value="<?=htmlspecialchars($configuration['gemini_api_key']??'')?>" placeholder="AIza..." autocomplete="off" style="width:100%;padding:7px 10px;border-radius:6px;border:1px solid #444860;background:#2a2d3e;color:#e8eaf0;font-size:13px;" />
                                                <small style="color:#6e728f;font-size:11px;">Mantida em segurança no servidor</small>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- OpenAI -->
                                <div class="cat-section prov-cfg-sec" id="prov-openai" style="margin-bottom:12px;display:none;">
                                    <div class="cat-grupo-header"><div class="cat-grupo-nome"><i class='bx bx-brain' style="color:#10a37f;"></i> OpenAI (ChatGPT) &nbsp;<a href="https://platform.openai.com/api-keys" target="_blank" style="color:#10a37f;font-size:11px;font-weight:400;">Obter chave</a></div></div>
                                    <div class="cat-filhos" style="padding:14px 16px;">
                                        <div style="display:grid;grid-template-columns:1fr 1fr;gap:14px;">
                                            <div>
                                                <label style="color:#9ca0b8;font-size:12px;margin-bottom:4px;display:block;">Modelo</label>
                                                <select id="openai_model_sel" onchange="updateHidden('openai_model',this.value)" style="width:100%;padding:7px 10px;border-radius:6px;border:1px solid #444860;background:#2a2d3e;color:#e8eaf0;font-size:13px;">
                                                    <option value="gpt-4o-mini"  <?=($configuration['openai_model']??'gpt-4o-mini')=='gpt-4o-mini' ?'selected':''?>>⚡ gpt-4o-mini (rápido e barato)</option>
                                                    <option value="gpt-4o"       <?=($configuration['openai_model']??'')=='gpt-4o'      ?'selected':''?>>🚀 gpt-4o (mais capaz)</option>
                                                    <option value="gpt-4-turbo"  <?=($configuration['openai_model']??'')=='gpt-4-turbo' ?'selected':''?>>🔥 gpt-4-turbo</option>
                                                    <option value="gpt-3.5-turbo"<?=($configuration['openai_model']??'')=='gpt-3.5-turbo'?'selected':''?>>💡 gpt-3.5-turbo</option>
                                                </select>
                                            </div>
                                            <div>
                                                <label style="color:#9ca0b8;font-size:12px;margin-bottom:4px;display:block;">🔑 Chave API</label>
                                                <input type="text" id="openai_key_inp" onchange="updateHidden('openai_api_key',this.value)" value="<?=htmlspecialchars($configuration['openai_api_key']??'')?>" placeholder="sk-..." autocomplete="off" style="width:100%;padding:7px 10px;border-radius:6px;border:1px solid #444860;background:#2a2d3e;color:#e8eaf0;font-size:13px;" />
                                                <small style="color:#6e728f;font-size:11px;">Mantida em segurança no servidor</small>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Claude -->
                                <div class="cat-section prov-cfg-sec" id="prov-claude" style="margin-bottom:12px;display:none;">
                                    <div class="cat-grupo-header"><div class="cat-grupo-nome"><i class='bx bx-bot' style="color:#d97706;"></i> Anthropic Claude &nbsp;<a href="https://console.anthropic.com/settings/keys" target="_blank" style="color:#d97706;font-size:11px;font-weight:400;">Obter chave</a></div></div>
                                    <div class="cat-filhos" style="padding:14px 16px;">
                                        <div style="display:grid;grid-template-columns:1fr 1fr;gap:14px;">
                                            <div>
                                                <label style="color:#9ca0b8;font-size:12px;margin-bottom:4px;display:block;">Modelo</label>
                                                <select id="claude_model_sel" onchange="updateHidden('claude_model',this.value)" style="width:100%;padding:7px 10px;border-radius:6px;border:1px solid #444860;background:#2a2d3e;color:#e8eaf0;font-size:13px;">
                                                    <option value="claude-haiku-4-5-20251001"<?=($configuration['claude_model']??'claude-haiku-4-5-20251001')=='claude-haiku-4-5-20251001'?'selected':''?>>⚡ claude-haiku-4-5 (rápido)</option>
                                                    <option value="claude-sonnet-4-6"<?=($configuration['claude_model']??'')=='claude-sonnet-4-6'?'selected':''?>>🚀 claude-sonnet-4-6 (recomendado)</option>
                                                    <option value="claude-opus-4-6"  <?=($configuration['claude_model']??'')=='claude-opus-4-6'  ?'selected':''?>>🔥 claude-opus-4-6 (mais capaz)</option>
                                                </select>
                                            </div>
                                            <div>
                                                <label style="color:#9ca0b8;font-size:12px;margin-bottom:4px;display:block;">🔑 Chave API</label>
                                                <input type="text" id="claude_key_inp" onchange="updateHidden('claude_api_key',this.value)" value="<?=htmlspecialchars($configuration['claude_api_key']??'')?>" placeholder="sk-ant-..." autocomplete="off" style="width:100%;padding:7px 10px;border-radius:6px;border:1px solid #444860;background:#2a2d3e;color:#e8eaf0;font-size:13px;" />
                                                <small style="color:#6e728f;font-size:11px;">Mantida em segurança no servidor</small>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Perplexity -->
                                <div class="cat-section prov-cfg-sec" id="prov-perplexity" style="margin-bottom:12px;display:none;">
                                    <div class="cat-grupo-header"><div class="cat-grupo-nome"><i class='bx bx-search-alt' style="color:#ef4444;"></i> Perplexity AI &nbsp;<a href="https://www.perplexity.ai/settings/api" target="_blank" style="color:#ef4444;font-size:11px;font-weight:400;">Obter chave</a></div></div>
                                    <div class="cat-filhos" style="padding:14px 16px;">
                                        <div style="display:grid;grid-template-columns:1fr 1fr;gap:14px;">
                                            <div>
                                                <label style="color:#9ca0b8;font-size:12px;margin-bottom:4px;display:block;">Modelo</label>
                                                <select id="perplexity_model_sel" onchange="updateHidden('perplexity_model',this.value)" style="width:100%;padding:7px 10px;border-radius:6px;border:1px solid #444860;background:#2a2d3e;color:#e8eaf0;font-size:13px;">
                                                    <option value="llama-3.1-sonar-small-128k-online"<?=($configuration['perplexity_model']??'llama-3.1-sonar-small-128k-online')=='llama-3.1-sonar-small-128k-online'?'selected':''?>>⚡ sonar-small (com web)</option>
                                                    <option value="llama-3.1-sonar-large-128k-online"<?=($configuration['perplexity_model']??'')=='llama-3.1-sonar-large-128k-online'?'selected':''?>>🚀 sonar-large (com web)</option>
                                                    <option value="llama-3.1-sonar-huge-128k-online" <?=($configuration['perplexity_model']??'')=='llama-3.1-sonar-huge-128k-online' ?'selected':''?>>🔥 sonar-huge</option>
                                                </select>
                                            </div>
                                            <div>
                                                <label style="color:#9ca0b8;font-size:12px;margin-bottom:4px;display:block;">🔑 Chave API</label>
                                                <input type="text" id="perplexity_key_inp" onchange="updateHidden('perplexity_api_key',this.value)" value="<?=htmlspecialchars($configuration['perplexity_api_key']??'')?>" placeholder="pplx-..." autocomplete="off" style="width:100%;padding:7px 10px;border-radius:6px;border:1px solid #444860;background:#2a2d3e;color:#e8eaf0;font-size:13px;" />
                                                <small style="color:#6e728f;font-size:11px;">Mantida em segurança no servidor</small>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- DeepSeek -->
                                <div class="cat-section prov-cfg-sec" id="prov-deepseek" style="margin-bottom:12px;display:none;">
                                    <div class="cat-grupo-header"><div class="cat-grupo-nome"><i class='bx bx-chip' style="color:#8b5cf6;"></i> DeepSeek &nbsp;<a href="https://platform.deepseek.com/api_keys" target="_blank" style="color:#8b5cf6;font-size:11px;font-weight:400;">Obter chave</a></div></div>
                                    <div class="cat-filhos" style="padding:14px 16px;">
                                        <div style="display:grid;grid-template-columns:1fr 1fr;gap:14px;">
                                            <div>
                                                <label style="color:#9ca0b8;font-size:12px;margin-bottom:4px;display:block;">Modelo</label>
                                                <select id="deepseek_model_sel" onchange="updateHidden('deepseek_model',this.value)" style="width:100%;padding:7px 10px;border-radius:6px;border:1px solid #444860;background:#2a2d3e;color:#e8eaf0;font-size:13px;">
                                                    <option value="deepseek-chat"    <?=($configuration['deepseek_model']??'deepseek-chat')=='deepseek-chat'   ?'selected':''?>>🚀 deepseek-chat (recomendado)</option>
                                                    <option value="deepseek-reasoner"<?=($configuration['deepseek_model']??'')=='deepseek-reasoner'?'selected':''?>>🧠 deepseek-reasoner</option>
                                                </select>
                                            </div>
                                            <div>
                                                <label style="color:#9ca0b8;font-size:12px;margin-bottom:4px;display:block;">🔑 Chave API</label>
                                                <input type="text" id="deepseek_key_inp" onchange="updateHidden('deepseek_api_key',this.value)" value="<?=htmlspecialchars($configuration['deepseek_api_key']??'')?>" placeholder="sk-..." autocomplete="off" style="width:100%;padding:7px 10px;border-radius:6px;border:1px solid #444860;background:#2a2d3e;color:#e8eaf0;font-size:13px;" />
                                                <small style="color:#6e728f;font-size:11px;">Mantida em segurança no servidor</small>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Mistral -->
                                <div class="cat-section prov-cfg-sec" id="prov-mistral" style="margin-bottom:12px;display:none;">
                                    <div class="cat-grupo-header"><div class="cat-grupo-nome"><i class='bx bx-wind' style="color:#9ca3af;"></i> Mistral AI &nbsp;<a href="https://console.mistral.ai/api-keys/" target="_blank" style="color:#9ca3af;font-size:11px;font-weight:400;">Obter chave</a></div></div>
                                    <div class="cat-filhos" style="padding:14px 16px;">
                                        <div style="display:grid;grid-template-columns:1fr 1fr;gap:14px;">
                                            <div>
                                                <label style="color:#9ca0b8;font-size:12px;margin-bottom:4px;display:block;">Modelo</label>
                                                <select id="mistral_model_sel" onchange="updateHidden('mistral_model',this.value)" style="width:100%;padding:7px 10px;border-radius:6px;border:1px solid #444860;background:#2a2d3e;color:#e8eaf0;font-size:13px;">
                                                    <option value="mistral-small-latest" <?=($configuration['mistral_model']??'mistral-small-latest')=='mistral-small-latest'?'selected':''?>>⚡ mistral-small</option>
                                                    <option value="mistral-medium-latest"<?=($configuration['mistral_model']??'')=='mistral-medium-latest'?'selected':''?>>🚀 mistral-medium</option>
                                                    <option value="mistral-large-latest" <?=($configuration['mistral_model']??'')=='mistral-large-latest' ?'selected':''?>>🔥 mistral-large</option>
                                                </select>
                                            </div>
                                            <div>
                                                <label style="color:#9ca0b8;font-size:12px;margin-bottom:4px;display:block;">🔑 Chave API</label>
                                                <input type="text" id="mistral_key_inp" onchange="updateHidden('mistral_api_key',this.value)" value="<?=htmlspecialchars($configuration['mistral_api_key']??'')?>" placeholder="..." autocomplete="off" style="width:100%;padding:7px 10px;border-radius:6px;border:1px solid #444860;background:#2a2d3e;color:#e8eaf0;font-size:13px;" />
                                                <small style="color:#6e728f;font-size:11px;">Mantida em segurança no servidor</small>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Card: Contexto -->
                                <div class="cat-section" style="margin-bottom:12px;">
                                    <div class="cat-grupo-header">
                                        <div class="cat-grupo-nome"><i class='bx bx-buildings' style="color:#e67e22;"></i> Contexto do Negócio</div>
                                    </div>
                                    <div class="cat-filhos" style="padding:14px 16px;">
                                        <textarea name="gemini_contexto" rows="4"
                                            placeholder="Ex: Somos uma assistência técnica especializada em celulares e notebooks em Balsas-MA. Atendemos marcas Samsung, Apple e Positivo..."
                                            style="width:100%;padding:8px 10px;border-radius:6px;border:1px solid #444860;background:#2a2d3e;color:#e8eaf0;font-size:13px;resize:vertical;"
                                            ><?= htmlspecialchars($configuration['gemini_contexto']??'') ?></textarea>
                                        <small style="color:#6e728f;font-size:11px;">A IA usará este contexto para dar respostas mais precisas sobre seu negócio</small>
                                    </div>
                                </div>

                                <!-- Card: Funcionalidades -->
                                <div class="cat-section" style="margin-bottom:14px;">
                                    <div class="cat-grupo-header">
                                        <div class="cat-grupo-nome"><i class='bx bx-star' style="color:#f1c40f;"></i> Funcionalidades</div>
                                    </div>
                                    <div class="cat-filhos" style="padding:4px 0;">
                                        <?php
                                        $feats = [
                                            'gemini_feat_diagnostico' => ['🔧', 'Sugestão de diagnóstico em OS',          'Sugere diagnósticos ao abrir/editar uma OS'],
                                            'gemini_feat_email'       => ['📧', 'Rascunho de e-mail ao cliente',           'Gera e-mail automático para comunicar o cliente'],
                                            'gemini_feat_assistente'  => ['💬', 'Assistente para funcionários',            'Chat interno com IA para tirar dúvidas'],
                                            'gemini_feat_relatorio'   => ['📊', 'Análise de relatórios e gestão',          'Analisa dados e sugere melhorias para o negócio'],
                                        ];
                                        foreach ($feats as $key => [$icon, $label, $desc]): ?>
                                        <label class="cat-filho-row" style="cursor:pointer;margin:0;">
                                            <span style="display:flex;align-items:center;gap:10px;">
                                                <span style="font-size:16px;"><?= $icon ?></span>
                                                <span>
                                                    <span style="color:#e8eaf0;font-weight:600;font-size:13px;"><?= $label ?></span><br>
                                                    <small style="color:#6e728f;font-size:11px;"><?= $desc ?></small>
                                                </span>
                                            </span>
                                            <input type="checkbox" name="<?= $key ?>" value="1" <?= !empty($configuration[$key])?'checked':'' ?> style="width:16px;height:16px;cursor:pointer;">
                                        </label>
                                        <?php endforeach; ?>
                                    </div>
                                </div>

                                <!-- Ações -->
                                <div style="display:flex;gap:8px;">
                                    <button type="submit" class="button btn btn-success">
                                        <span class="button__icon"><i class='bx bx-save'></i></span>
                                        <span class="button__text2">Salvar</span>
                                    </button>
                                    <button type="button" id="btnTestarGemini" class="button btn btn-info">
                                        <span class="button__icon"><i class='bx bx-test-tube'></i></span>
                                        <span class="button__text2">Testar Conexão</span>
                                    </button>
                                </div>
                            </form>

                            <div id="geminiTestResult" style="margin-top:12px;display:none;"></div>

                            <!-- Chat assistente -->
                            <?php if (!empty($configuration['gemini_feat_assistente']) && !empty($configuration['gemini_api_key'])): ?>
                            <div class="cat-section" style="margin-top:16px;">
                                <div class="cat-grupo-header">
                                    <div class="cat-grupo-nome"><i class='bx bx-chat' style="color:#27ae60;"></i> Assistente Sisos IA</div>
                                </div>
                                <div class="cat-filhos" style="padding:12px 16px;">
                                    <div id="chatGemini" style="background:#1e2133;border:1px solid #3a3d4e;border-radius:6px;padding:10px;min-height:100px;max-height:280px;overflow-y:auto;margin-bottom:10px;font-size:13px;color:#c8cad6;">
                                        <div style="color:#6e728f;font-style:italic;">Olá! Sou o assistente Sisos com IA. Como posso ajudar?</div>
                                    </div>
                                    <div style="display:flex;gap:8px;">
                                        <input type="text" id="geminiInput" placeholder="Pergunte algo..."
                                            style="flex:1;padding:8px 12px;border-radius:6px;border:1px solid #444860;background:#2a2d3e;color:#e8eaf0;font-size:13px;" />
                                        <button class="button btn btn-info btn-mini" id="btnEnviarChat">
                                            <span class="button__icon"><i class='bx bx-send'></i></span>
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <?php endif; ?>

                        </div>
                    </div>
                    <!-- Fim IA / Gemini -->

        </div>
    </div>
</div>

<!-- Modal adicionar/editar categoria -->
<div id="modalCategoria" class="modal hide fade" tabindex="-1">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 id="modalCategoriaTitulo">Nova Categoria</h4>
    </div>
    <div class="modal-body">
        <input type="hidden" id="cat_tipo">
        <input type="hidden" id="cat_parent_id">
        <input type="hidden" id="cat_id">
        <div class="control-group">
            <label>Nome da Categoria</label>
            <input type="text" id="cat_nome" class="span12" placeholder="Ex: Aluguel, Peças, etc.">
        </div>
    </div>
    <div class="modal-footer">
        <button class="btn btn-success" id="btnSalvarCategoria">Salvar</button>
        <button class="btn" data-dismiss="modal">Cancelar</button>
    </div>
</div>

<script>
var CSRF_CAT_NAME = '<?= $this->security->get_csrf_token_name() ?>';
var CSRF_CAT_HASH = '<?= $this->security->get_csrf_hash() ?>';

function abrirModalCategoria(tipo, parentId) {
    $('#cat_tipo').val(tipo);
    $('#cat_parent_id').val(parentId || '');
    $('#cat_id').val('');
    $('#cat_nome').val('');
    $('#modalCategoriaTitulo').text(parentId ? 'Nova Subcategoria' : 'Novo Grupo');
    $('#modalCategoria').modal('show');
}

$('.btn-editar-cat').on('click', function(){
    $('#cat_id').val($(this).data('id'));
    $('#cat_nome').val($(this).data('nome'));
    $('#cat_parent_id').val('');
    $('#modalCategoriaTitulo').text('Editar Categoria');
    $('#modalCategoria').modal('show');
});

$('#btnSalvarCategoria').on('click', function(){
    var id       = $('#cat_id').val();
    var nome     = $('#cat_nome').val().trim();
    var tipo     = $('#cat_tipo').val();
    var parentId = $('#cat_parent_id').val();
    if (!nome) { alert('Informe o nome.'); return; }

    var url  = id ? '<?= site_url('categorias/editar') ?>' : '<?= site_url('categorias/adicionar') ?>';
    var dados = { categoria: nome, tipo: tipo, parent_id: parentId };
    if (id) dados.id = id;
    dados[CSRF_CAT_NAME] = CSRF_CAT_HASH;

    $.post(url, dados, function(res){
        if (res.result) {
            $('#modalCategoria').modal('hide');
            location.reload();
        } else { alert(res.messages || 'Erro ao salvar.'); }
    }, 'json');
});

$(document).on('click', '.btn-excluir-cat', function(){
    var id = $(this).data('id');
    if (!confirm('Excluir esta categoria?')) return;
    var d = {id: id}; d[CSRF_CAT_NAME] = CSRF_CAT_HASH;
    $.post('<?= site_url('categorias/excluir') ?>', d, function(res){
        if (res.result) location.reload();
        else alert('Erro ao excluir.');
    }, 'json');
});
</script>
<!-- Modal -->
<div id="modal-confirmaratualiza" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <form action="<?php echo base_url() ?>index.php/clientes/excluir" method="post">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            <h5 id="myModalLabel">Atualização de sistema</h5>
        </div>
        <div class="modal-body">
            <h5 style="text-align: left">Deseja realmente fazer a atualização de sistema?</h5>
            <h7 style="text-align: left">Recomendamos que faça um backup antes de prosseguir!</h7>
            <h7 style="text-align: left"><br>Faça o backup dos seguintes arquivos pois os mesmo serão excluídos:</h7>
            <h7 style="text-align: left"><br>* ./assets/anexos</h7>
            <h7 style="text-align: left"><br>* ./assets/arquivos</h7>
        </div>
        <div class="modal-footer" style="display:flex;justify-content: center">
          <button class="button btn btn-mini btn-danger" data-dismiss="modal" aria-hidden="true"><span class="button__icon"><i class='bx bx-x' ></i></span> <span class="button__text2">Cancelar</span></button>
          <button id="update-sisos" type="button" class="button btn btn-warning"><span class="button__icon"><i class="bx bx-sync"></i></span><span class="button__text2">Atualizar</span></button>
        </div>
    </form>
</div>
<!-- Modal -->
<div id="modal-confirmabanco" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <form action="<?php echo base_url() ?>index.php/clientes/excluir" method="post">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            <h5 id="myModalLabel">Atualização de sistema</h5>
        </div>
        <div class="modal-body">
            <h5 style="text-align: left">Deseja realmente fazer a atualização do banco de dados?</h5>
            <h7 style="text-align: left">Recomendamos que faça um backup antes de prosseguir!
                <a target="_blank" title="Fazer Bakup" class="btn btn-mini btn-inverse" href="<?php echo site_url() ?>/sisos/backup">Fazer Backup</a>
            </h7>
        </div>
        <div class="modal-footer" style="display:flex;justify-content: center">
          <button class="button btn btn-mini btn-danger" data-dismiss="modal" aria-hidden="true"><span class="button__icon"><i class='bx bx-x' ></i></span> <span class="button__text2">Cancelar</span></button>
          <button id="update-database" type="button" class="button btn btn-warning"><span class="button__icon"><i class="bx bx-sync"></i></span><span class="button__text2">Atualizar</span></button>
        </div>
    </form>
</div>
<script>
    $('#update-database').click(function() {
        window.location = "<?= site_url('sisos/atualizarBanco') ?>"
    });
    $('#update-sisos').click(function() {
        window.location = "<?= site_url('sisos/atualizarSisos') ?>"
    });
    $(document).ready(function() {
        $('#notifica_whats_select').change(function() {
            if ($(this).val() != "0")
                document.getElementById("notifica_whats").value += $(this).val();
            $(this).prop('selectedIndex', 0);
        });

        // As abas são controladas por showConfigTab() - ver função global abaixo

        // Testar conexão Gemini
        $('#btnTestarGemini').on('click', function(){
            $('#geminiTestResult').show().html('<div class="alert alert-info"><i class="bx bx-loader-alt bx-spin"></i> Testando conexão...</div>');
            $.post('<?= site_url('sisos/testarGemini') ?>', {
                '<?= $this->security->get_csrf_token_name() ?>': '<?= $this->security->get_csrf_hash() ?>'
            }, function(res){
                if (res.ok) {
                    $('#geminiTestResult').html('<div class="alert alert-success"><i class="bx bx-check-circle"></i> Conexão OK! Resposta: ' + res.resposta + '</div>');
                } else {
                    $('#geminiTestResult').html('<div class="alert alert-error"><i class="bx bx-x-circle"></i> Erro: ' + res.erro + '</div>');
                }
            }, 'json');
        });

        // Chat assistente
        $('#btnEnviarChat').on('click', function(){ enviarChatGemini(); });
        $('#geminiInput').on('keydown', function(e){ if(e.which===13) enviarChatGemini(); });

        function enviarChatGemini(){
            var msg = $('#geminiInput').val().trim();
            if (!msg) return;
            var chat = $('#chatGemini');
            chat.append('<div style="margin:4px 0"><strong>Você:</strong> ' + $('<span>').text(msg).html() + '</div>');
            chat.append('<div id="geminiTyping" style="color:#888;font-style:italic;"><i class="bx bx-loader-alt bx-spin"></i> Processando...</div>');
            chat.scrollTop(chat[0].scrollHeight);
            $('#geminiInput').val('');
            $.post('<?= site_url('sisos/chatGemini') ?>', {
                mensagem: msg,
                '<?= $this->security->get_csrf_token_name() ?>': '<?= $this->security->get_csrf_hash() ?>'
            }, function(res){
                $('#geminiTyping').remove();
                var cor = res.ok ? '#333' : '#c0392b';
                chat.append('<div style="margin:4px 0;color:' + cor + '"><strong>🤖 Sisos IA:</strong> ' + (res.resposta || res.erro) + '</div>');
                chat.scrollTop(chat[0].scrollHeight);
            }, 'json');
        }
    });
</script>

<script>
function uploadArquivo(inputId, url, msgId) {
    var input = document.getElementById(inputId);
    if (!input || !input.files || !input.files[0]) {
        alert('Selecione um arquivo primeiro.');
        return;
    }
    var msg = document.getElementById(msgId);
    if (msg) { msg.style.color = '#888'; msg.textContent = 'Enviando...'; }
    var fd = new FormData();
    fd.append('arquivo', input.files[0]);
    fd.append('<?= $this->security->get_csrf_token_name() ?>', '<?= $this->security->get_csrf_hash() ?>');
    fetch(url, { method: 'POST', body: fd })
        .then(function(r) { return r.text(); })
        .then(function() {
            if (msg) { msg.style.color = '#27ae60'; msg.textContent = '✓ Enviado! Recarregando...'; }
            setTimeout(function() { location.reload(); }, 1200);
        })
        .catch(function() {
            if (msg) { msg.style.color = '#e74c3c'; msg.textContent = 'Erro ao enviar.'; }
        });
}

var _allTabIds = ['home','menu1','menu2','menu3','menu4','menu5','menu6','menu7','menu8','tabCatDespesa','tabCatReceita','tabGemini'];

function _hideAllTabs() {
    _allTabIds.forEach(function(id) {
        var el = document.getElementById(id);
        if (el) { el.style.display = 'none'; el.style.visibility = 'hidden'; el.style.height = '0'; el.style.overflow = 'hidden'; }
    });
    document.querySelectorAll('#configTabs li').forEach(function(li) { li.classList.remove('active'); });
}

function showConfigTab(tabId) {
    _hideAllTabs();
    var target = document.getElementById(tabId);
    if (target) {
        target.style.display = 'block';
        target.style.visibility = 'visible';
        target.style.height = 'auto';
        target.style.overflow = 'visible';
        target.classList.add('active', 'in');
    }
    var link = document.querySelector('#configTabs a[onclick*="' + tabId + '"]');
    if (link) link.closest('li').classList.add('active');
}

document.addEventListener('DOMContentLoaded', function() {
    _hideAllTabs();
    var home = document.getElementById('home');
    if (home) {
        home.style.display = 'block';
        home.style.visibility = 'visible';
        home.style.height = 'auto';
        home.style.overflow = 'visible';
        home.classList.add('active', 'in');
    }
    var primeiro = document.querySelector('#configTabs li:first-child');
    if (primeiro) primeiro.classList.add('active');
});

function updateHidden(name, val) {
    var el = document.querySelector('input[name="'+name+'"]');
    if (el) el.value = val;
}

var _iaCfgColors = {gemini:'#4285f4',openai:'#10a37f',claude:'#d97706',perplexity:'#ef4444',deepseek:'#8b5cf6',mistral:'#9ca3af'};

function iaCfgSwitch(prov, color) {
    document.getElementById('ia_provedor_val').value = prov;
    document.querySelectorAll('[id^="cfgBtn-"]').forEach(function(b){
        b.style.border='2px solid rgba(255,255,255,0.1)';
        b.style.background='rgba(255,255,255,0.04)';
        b.style.color='#9ca3af';
    });
    var ab=document.getElementById('cfgBtn-'+prov);
    if(ab){ab.style.border='2px solid '+color;ab.style.background=color+'22';ab.style.color=color;}
    document.querySelectorAll('.prov-cfg-sec').forEach(function(s){s.style.display='none';});
    var sec=document.getElementById('prov-'+prov);
    if(sec) sec.style.display='block';
}

document.addEventListener('DOMContentLoaded',function(){
    var v=document.getElementById('ia_provedor_val');
    if(v) iaCfgSwitch(v.value,_iaCfgColors[v.value]||'#6366f1');
});
</script>
