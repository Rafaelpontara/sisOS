<div class="row-fluid" style="margin-top:0">
    <div class="span12">
        <div class="widget-box">
            <div class="widget-title" style="margin: -20px 0 0">
                <span class="icon">
                    <i class="fas fa-wrench"></i>
                </span>
                <h5>Configurações do Sistema</h5>
            </div>
            <ul class="nav nav-tabs">
                <li class="active"><a data-toggle="tab" href="#home">Gerais</a></li>
                <li><a data-toggle="tab" href="#menu1">Financeiro</a></li>
                <li><a data-toggle="tab" href="#menu2">Produtos</a></li>
                <li><a data-toggle="tab" href="#menu3">Notificações</a></li>
                <li><a data-toggle="tab" href="#menu4">Atualizações</a></li>
                <li><a data-toggle="tab" href="#menu5">OS</a></li>
                <li><a data-toggle="tab" href="#menu6">API</a></li>
                <li><a data-toggle="tab" href="#menu7">E-mail</a></li>
                <li><a data-toggle="tab" href="#menu8">Nota Fiscal</a></li>
                <li><a data-toggle="tab" href="#tabCatDespesa">Categorias de Despesa</a></li>
                <li><a data-toggle="tab" href="#tabCatReceita">Categorias de Receita</a></li>
            </ul>
            <form action="<?php echo current_url(); ?>" id="formConfigurar" method="post" class="form-horizontal">
                <div class="widget-content nopadding tab-content">
                    <?php echo $custom_error; ?>
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
                                <form action="<?= site_url('notafiscal/uploadLogo') ?>" method="post" enctype="multipart/form-data" style="display:inline;">
                                    <input type="file" name="arquivo" accept=".png,.jpg,.jpeg,.svg,.webp" style="display:inline-block;">
                                    <button type="submit" class="button btn btn-info btn-mini">
                                        <span class="button__icon"><i class='bx bx-upload'></i></span>
                                        <span class="button__text2">Enviar Logo</span>
                                    </button>
                                </form>
                                <span class="help-inline">PNG, JPG ou SVG. Máx 2MB. Usada no menu lateral e cabeçalho.</span>
                            </div>
                        </div>

                        <!-- Favicon do Sistema -->
                        <div class="control-group">
                            <label class="control-label">Favicon do Sistema</label>
                            <div class="controls">
                                <?php if (!empty($configuration['app_favicon'])): ?>
                                    <div style="margin-bottom:8px;">
                                        <img src="<?= $configuration['app_favicon'] ?>" alt="Favicon atual" style="height:32px; border:1px solid #ddd; padding:4px; border-radius:4px;">
                                        <small class="help-inline">Favicon atual</small>
                                    </div>
                                <?php endif; ?>
                                <form action="<?= site_url('notafiscal/uploadFavicon') ?>" method="post" enctype="multipart/form-data" style="display:inline;">
                                    <input type="file" name="arquivo" accept=".png,.ico" style="display:inline-block;">
                                    <button type="submit" class="button btn btn-info btn-mini">
                                        <span class="button__icon"><i class='bx bx-upload'></i></span>
                                        <span class="button__text2">Enviar Favicon</span>
                                    </button>
                                </form>
                                <span class="help-inline">PNG ou ICO. Máx 2MB. Ícone exibido na aba do navegador.</span>
                            </div>
                        </div>
                        <div class="control-group">
                            <label for="app_theme" class="control-label">Tema do Sistema</label>
                            <div class="controls">
                                <select name="app_theme" id="app_theme">
                                    <option value="default">Escuro</option>
                                    <option value="white" <?= $configuration['app_theme'] == 'white' ? 'selected' : ''; ?>>Claro</option>
                                    <option value="puredark" <?= $configuration['app_theme'] == 'puredark' ? 'selected' : ''; ?>>Pure dark</option>
                                    <option value="darkorange" <?= $configuration['app_theme'] == 'darkorange' ? 'selected' : ''; ?>>Dark orange</option>
                                    <option value="darkviolet" <?= $configuration['app_theme'] == 'darkviolet' ? 'selected' : ''; ?>>Dark violet</option>
                                    <option value="whitegreen" <?= $configuration['app_theme'] == 'whitegreen' ? 'selected' : ''; ?>>White green</option>
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
                                      <span class="button__icon"><i class="bx bx-sync"></i></span><span class="button__text2">Atualizar Mapos</span></button>
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
                    <div id="menu8" class="tab-pane fade in" style="display:none">
                        <div style="padding: 10px 15px;">
                            <div class="alert alert-info" style="margin-bottom:15px;">
                                <strong><i class='bx bx-info-circle'></i> Focus NF-e</strong> &mdash;
                                Provedor gratuito para emissão de NF-e/NFS-e.
                                Crie sua conta gratuita em <a href="https://focusnfe.com.br" target="_blank" rel="noopener">focusnfe.com.br</a>
                                e obtenha seu token de acesso. O plano gratuito inclui 50 documentos/mês em ambiente de homologação (testes).
                            </div>

                            <form action="<?= site_url('mapos/salvarConfigNfe') ?>" method="post" class="form-horizontal">
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
                    <div id="tabCatDespesa" class="tab-pane fade in" style="display:none">
                        <div style="padding:10px 15px">
                            <button class="button btn btn-success btn-mini" onclick="abrirModalCategoria('despesa', null)">
                                <i class='bx bx-plus'></i> Adicionar mais categoria
                            </button>
                            <div id="arvore-despesa" style="margin-top:15px">
                                <?php
                                $this->load->model('categorias_model');
                                $gruposDespesa = $this->categorias_model->getGrupos('despesa');
                                foreach ($gruposDespesa as $g):
                                    $filhos = $this->categorias_model->getFilhos($g->idCategorias);
                                ?>
                                <div class="widget-box" style="margin-bottom:10px">
                                    <div class="widget-title" style="padding:8px 15px;display:flex;justify-content:space-between;align-items:center">
                                        <strong><i class='bx bx-folder'></i> <?= htmlspecialchars($g->categoria) ?></strong>
                                        <div>
                                            <button class="btn btn-mini btn-success" onclick="abrirModalCategoria('despesa', <?= $g->idCategorias ?>)" title="Adicionar subcategoria"><i class="bx bx-plus"></i></button>
                                            <button class="btn btn-mini btn-info btn-editar-cat" data-id="<?=$g->idCategorias?>" data-nome="<?=htmlspecialchars($g->categoria)?>"><i class="bx bx-edit"></i></button>
                                            <button class="btn btn-mini btn-danger btn-excluir-cat" data-id="<?=$g->idCategorias?>"><i class="bx bx-trash"></i></button>
                                        </div>
                                    </div>
                                    <div class="widget-content nopadding">
                                    <?php foreach ($filhos as $f): ?>
                                        <div style="display:flex;justify-content:space-between;padding:6px 20px;border-bottom:1px solid #f0f0f0">
                                            <span><?= htmlspecialchars($f->categoria) ?></span>
                                            <div>
                                                <button class="btn btn-mini btn-info btn-editar-cat" data-id="<?=$f->idCategorias?>" data-nome="<?=htmlspecialchars($f->categoria)?>"><i class="bx bx-edit"></i></button>
                                                <button class="btn btn-mini btn-danger btn-excluir-cat" data-id="<?=$f->idCategorias?>"><i class="bx bx-trash"></i></button>
                                            </div>
                                        </div>
                                    <?php endforeach; ?>
                                    </div>
                                </div>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    </div>

                    <!-- Categorias de Receita -->
                    <div id="tabCatReceita" class="tab-pane fade in" style="display:none"
                        <div style="padding:10px 15px">
                            <button class="button btn btn-success btn-mini" onclick="abrirModalCategoria('receita', null)">
                                <i class='bx bx-plus'></i> Adicionar mais categoria
                            </button>
                            <div id="arvore-receita" style="margin-top:15px">
                                <?php
                                $gruposReceita = $this->categorias_model->getGrupos('receita');
                                foreach ($gruposReceita as $g):
                                    $filhos = $this->categorias_model->getFilhos($g->idCategorias);
                                ?>
                                <div class="widget-box" style="margin-bottom:10px">
                                    <div class="widget-title" style="padding:8px 15px;display:flex;justify-content:space-between;align-items:center">
                                        <strong><i class='bx bx-folder'></i> <?= htmlspecialchars($g->categoria) ?></strong>
                                        <div>
                                            <button class="btn btn-mini btn-success" onclick="abrirModalCategoria('receita', <?= $g->idCategorias ?>)" title="Adicionar subcategoria"><i class="bx bx-plus"></i></button>
                                            <button class="btn btn-mini btn-info btn-editar-cat" data-id="<?=$g->idCategorias?>" data-nome="<?=htmlspecialchars($g->categoria)?>"><i class="bx bx-edit"></i></button>
                                            <button class="btn btn-mini btn-danger btn-excluir-cat" data-id="<?=$g->idCategorias?>"><i class="bx bx-trash"></i></button>
                                        </div>
                                    </div>
                                    <div class="widget-content nopadding">
                                    <?php foreach ($filhos as $f): ?>
                                        <div style="display:flex;justify-content:space-between;padding:6px 20px;border-bottom:1px solid #f0f0f0">
                                            <span><?= htmlspecialchars($f->categoria) ?></span>
                                            <div>
                                                <button class="btn btn-mini btn-info btn-editar-cat" data-id="<?=$f->idCategorias?>" data-nome="<?=htmlspecialchars($f->categoria)?>"><i class="bx bx-edit"></i></button>
                                                <button class="btn btn-mini btn-danger btn-excluir-cat" data-id="<?=$f->idCategorias?>"><i class="bx bx-trash"></i></button>
                                            </div>
                                        </div>
                                    <?php endforeach; ?>
                                    </div>
                                </div>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    </div>

        </div>
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
          <button id="update-mapos" type="button" class="button btn btn-warning"><span class="button__icon"><i class="bx bx-sync"></i></span><span class="button__text2">Atualizar</span></button>
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
                <a target="_blank" title="Fazer Bakup" class="btn btn-mini btn-inverse" href="<?php echo site_url() ?>/mapos/backup">Fazer Backup</a>
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
        window.location = "<?= site_url('mapos/atualizarBanco') ?>"
    });
    $('#update-mapos').click(function() {
        window.location = "<?= site_url('mapos/atualizarMapos') ?>"
    });
    $(document).ready(function() {
        $('#notifica_whats_select').change(function() {
            if ($(this).val() != "0")
                document.getElementById("notifica_whats").value += $(this).val();
            $(this).prop('selectedIndex', 0);
        });
    });
<script>
document.addEventListener('DOMContentLoaded', function(){
    var abas = ['#menu8','#tabCatDespesa','#tabCatReceita'];
    
    abas.forEach(function(id){
        var link = document.querySelector('a[href="'+id+'"]');
        if(link){
            link.addEventListener('click', function(e){
                e.preventDefault();
                e.stopPropagation();
                
                // Esconde todas as tab-panes
                document.querySelectorAll('.tab-content .tab-pane').forEach(function(p){
                    p.style.display = 'none';
                });
                
                // Remove active de todos os li
                document.querySelectorAll('.nav-tabs li').forEach(function(li){
                    li.classList.remove('active');
                });
                
                // Mostra a aba correta
                var target = document.querySelector(id);
                if(target) target.style.display = 'block';
                
                // Ativa o li
                link.closest('li').classList.add('active');
            });
        }
    });
});
</script>
