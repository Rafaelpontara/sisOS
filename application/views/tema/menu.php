<!--sidebar-menu-->
<nav id="sidebar">

    <!-- Logo -->
    <div id="newlog">
        <?php
        $logoCustom = $configuration['app_logo'] ?? '';
        $iconCustom = $configuration['app_favicon'] ?? '';
        ?>
        <div class="icon2">
            <img src="<?= $iconCustom ?>" alt="icone" style="width:42px;height:42px;object-fit:contain;">
        </div>
        <div class="title1">
            <img src="<?= $logoCustom ?>" alt="<?= htmlspecialchars($configuration['app_name'] ?? 'Sisos') ?>" style="max-height:<?= ($configuration['app_logo_height'] ?? 50) ?>px;max-width:210px;object-fit:contain;vertical-align:middle;transition:max-height .3s;">
        </div>
    </div>

    <a href="#" class="visible-phone">
        <div class="mode">
            <div class="moon-menu">
                <i class='bx bx-chevron-right iconX open-2'></i>
                <i class='bx bx-chevron-left iconX close-2'></i>
            </div>
        </div>
    </a>

    <!-- Search -->
    <li class="search-box" style="margin-top:10px;">
        <form style="display:flex" action="<?= site_url('sisos/pesquisar') ?>">
            <button style="background:transparent;border:transparent" type="submit">
                <i class='bx bx-search iconX'></i>
            </button>
            <input style="background:transparent;<?= $configuration['app_theme'] == 'white' ? 'color:#313030;' : 'color:#fff;' ?>border:transparent" type="search" name="termo" placeholder="Pesquise aqui...">
            <span class="title-tooltip">Pesquisar</span>
        </form>
    </li>

    <style>
    /* ── Sidebar scroll + compact ── */
    .menu-bar {
        display: flex !important;
        flex-direction: column !important;
        height: calc(100vh - 160px) !important;
        overflow: hidden !important;
    }
    .menu-bar .menu {
        flex: 1 !important;
        overflow-y: auto !important;
        overflow-x: hidden !important;
        scrollbar-width: thin !important;
        scrollbar-color: rgba(255,255,255,0.1) transparent !important;
    }
    .menu-bar .menu::-webkit-scrollbar { width: 3px; }
    .menu-bar .menu::-webkit-scrollbar-thumb { background: rgba(255,255,255,0.1); border-radius: 3px; }

    .menu-links { padding: 4px 0 2px !important; }
    #sidebar .menu-links > li { border: none !important; margin: 0 !important; }

    /* Group separator */
    .nav-sep {
        display: flex;
        align-items: center;
        gap: 8px;
        padding: 8px 12px 3px;
        font-size: 9px;
        font-weight: 800;
        letter-spacing: 1.5px;
        text-transform: uppercase;
        white-space: nowrap;
        overflow: hidden;
    }
    .nav-sep span {
        opacity: 0.5;
        white-space: nowrap;
    }
    .nav-sep::after {
        content: '';
        flex: 1;
        height: 1px;
        background: currentColor;
        opacity: 0.15;
        min-width: 8px;
    }
    .nav-sep i { font-size: 11px; opacity: 0.6; flex-shrink: 0; }
    .ns-blue   { color: #60a5fa; }
    .ns-green  { color: #34d399; }
    .ns-yellow { color: #fbbf24; }
    .ns-purple { color: #a78bfa; }
    .ns-red    { color: #f87171; }

    /* Menu items */
    #sidebar .menu-links > li > a {
        display: flex !important;
        align-items: center !important;
        gap: 9px !important;
        margin: 1px 6px !important;
        padding: 8px 10px !important;
        border-radius: 8px !important;
        font-size: 13px !important;
        font-weight: 500 !important;
        transition: background .15s, color .15s, padding-left .15s !important;
        position: relative !important;
        text-decoration: none !important;
    }
    #sidebar .menu-links > li > a i { font-size: 17px !important; min-width: 18px !important; }

    /* Active indicator */
    #sidebar .menu-links > li.active > a::before {
        content: '';
        position: absolute;
        left: 0; top: 20%; height: 60%; width: 3px;
        border-radius: 0 3px 3px 0;
        background: currentColor;
    }

    /* Hover/active by group using data attribute */
    #sidebar .menu-links > li > a[data-g="blue"]:hover,
    #sidebar .menu-links > li.active > a[data-g="blue"] {
        background: rgba(96,165,250,0.13) !important; color: #60a5fa !important;
    }
    #sidebar .menu-links > li > a[data-g="blue"]:hover i,
    #sidebar .menu-links > li > a[data-g="blue"]:hover .title,
    #sidebar .menu-links > li.active > a[data-g="blue"] i,
    #sidebar .menu-links > li.active > a[data-g="blue"] .title { color: #60a5fa !important; opacity:1 !important; }

    #sidebar .menu-links > li > a[data-g="green"]:hover,
    #sidebar .menu-links > li.active > a[data-g="green"] {
        background: rgba(52,211,153,0.13) !important; color: #34d399 !important;
    }
    #sidebar .menu-links > li > a[data-g="green"]:hover i,
    #sidebar .menu-links > li > a[data-g="green"]:hover .title,
    #sidebar .menu-links > li.active > a[data-g="green"] i,
    #sidebar .menu-links > li.active > a[data-g="green"] .title { color: #34d399 !important; opacity:1 !important; }

    #sidebar .menu-links > li > a[data-g="yellow"]:hover,
    #sidebar .menu-links > li.active > a[data-g="yellow"] {
        background: rgba(251,191,36,0.13) !important; color: #fbbf24 !important;
    }
    #sidebar .menu-links > li > a[data-g="yellow"]:hover i,
    #sidebar .menu-links > li > a[data-g="yellow"]:hover .title,
    #sidebar .menu-links > li.active > a[data-g="yellow"] i,
    #sidebar .menu-links > li.active > a[data-g="yellow"] .title { color: #fbbf24 !important; opacity:1 !important; }

    #sidebar .menu-links > li > a[data-g="purple"]:hover,
    #sidebar .menu-links > li.active > a[data-g="purple"] {
        background: rgba(167,139,250,0.13) !important; color: #a78bfa !important;
    }
    #sidebar .menu-links > li > a[data-g="purple"]:hover i,
    #sidebar .menu-links > li > a[data-g="purple"]:hover .title,
    #sidebar .menu-links > li.active > a[data-g="purple"] i,
    #sidebar .menu-links > li.active > a[data-g="purple"] .title { color: #a78bfa !important; opacity:1 !important; }

    #sidebar .menu-links > li > a[data-g="red"]:hover,
    #sidebar .menu-links > li.active > a[data-g="red"] {
        background: rgba(248,113,113,0.13) !important; color: #f87171 !important;
    }
    #sidebar .menu-links > li > a[data-g="red"]:hover i,
    #sidebar .menu-links > li > a[data-g="red"]:hover .title,
    #sidebar .menu-links > li.active > a[data-g="red"] i,
    #sidebar .menu-links > li.active > a[data-g="red"] .title { color: #f87171 !important; opacity:1 !important; }

    /* Hover slide */
    #sidebar .menu-links > li > a:hover { padding-left: 14px !important; }

    /* Sair */
    .botton-content { padding-bottom: 8px !important; }
    .botton-content li a {
        display: flex !important; align-items: center !important; gap: 9px !important;
        margin: 1px 6px !important; padding: 8px 10px !important;
        border-radius: 8px !important; font-size: 13px !important;
        transition: background .15s, color .15s !important; text-decoration: none !important;
    }
    .botton-content li a:hover { background: rgba(248,113,113,0.15) !important; color: #f87171 !important; }
    .botton-content li a:hover i { color: #f87171 !important; }
    </style>

    <div class="menu-bar">
        <div class="menu">
            <ul class="menu-links" style="position:relative;">

                <!-- GERAL -->
                <li class="nav-sep ns-blue"><i class='bx bx-grid-alt'></i><span>Geral</span></li>

                <li class="<?php if (isset($menuPainel)) echo 'active'; ?>">
                    <a data-g="blue" class="tip-bottom" href="<?= base_url() ?>">
                        <i class='bx bx-home-alt iconX'></i>
                        <span class="title nav-title">Home</span>
                        <span class="title-tooltip">Início</span>
                    </a>
                </li>
                <?php if ($this->permission->checkPermission($this->session->userdata('permissao'), 'vCliente')): ?>
                <li class="<?php if (isset($menuClientes)) echo 'active'; ?>">
                    <a data-g="blue" class="tip-bottom" href="<?= site_url('clientes') ?>">
                        <i class='bx bx-user iconX'></i>
                        <span class="title">Cliente / Fornecedor</span>
                        <span class="title-tooltip">Clientes</span>
                    </a>
                </li>
                <?php endif; ?>
                <?php if ($this->permission->checkPermission($this->session->userdata('permissao'), 'vProduto')): ?>
                <li class="<?php if (isset($menuProdutos)) echo 'active'; ?>">
                    <a data-g="blue" class="tip-bottom" href="<?= site_url('produtos') ?>">
                        <i class='bx bx-basket iconX'></i>
                        <span class="title">Produtos</span>
                        <span class="title-tooltip">Produtos</span>
                    </a>
                </li>
                <?php endif; ?>
                <?php if ($this->permission->checkPermission($this->session->userdata('permissao'), 'vServico')): ?>
                <li class="<?php if (isset($menuServicos)) echo 'active'; ?>">
                    <a data-g="blue" class="tip-bottom" href="<?= site_url('servicos') ?>">
                        <i class='bx bx-wrench iconX'></i>
                        <span class="title">Serviços</span>
                        <span class="title-tooltip">Serviços</span>
                    </a>
                </li>
                <?php endif; ?>

                <!-- ATENDIMENTO -->
                <li class="nav-sep ns-green"><i class='bx bx-headphone'></i><span>Atendimento</span></li>

                <?php if ($this->permission->checkPermission($this->session->userdata('permissao'), 'vOs')): ?>
                <li class="<?php if (isset($menuOs)) echo 'active'; ?>">
                    <a data-g="green" class="tip-bottom" href="<?= site_url('os') ?>">
                        <i class='bx bx-file iconX'></i>
                        <span class="title">Ordens de Serviço</span>
                        <span class="title-tooltip">Ordens</span>
                    </a>
                </li>
                <?php endif; ?>
                <?php if ($this->permission->checkPermission($this->session->userdata('permissao'), 'vVenda')): ?>
                <li class="<?php if (isset($menuVendas)) echo 'active'; ?>">
                    <a data-g="green" class="tip-bottom" href="<?= site_url('vendas') ?>">
                        <i class='bx bx-cart-alt iconX'></i>
                        <span class="title">Vendas</span>
                        <span class="title-tooltip">Vendas</span>
                    </a>
                </li>
                <?php endif; ?>
                <?php if ($this->permission->checkPermission($this->session->userdata('permissao'), 'vGarantia')): ?>
                <li class="<?php if (isset($menuGarantia)) echo 'active'; ?>">
                    <a data-g="green" class="tip-bottom" href="<?= site_url('garantias') ?>">
                        <i class='bx bx-receipt iconX'></i>
                        <span class="title">Termos de Garantias</span>
                        <span class="title-tooltip">Garantias</span>
                    </a>
                </li>
                <?php endif; ?>
                <?php if ($this->permission->checkPermission($this->session->userdata('permissao'), 'vArquivo')): ?>
                <li class="<?php if (isset($menuArquivos)) echo 'active'; ?>">
                    <a data-g="green" class="tip-bottom" href="<?= site_url('arquivos') ?>">
                        <i class='bx bx-box iconX'></i>
                        <span class="title">Arquivos</span>
                        <span class="title-tooltip">Arquivos</span>
                    </a>
                </li>
                <?php endif; ?>

                <!-- FINANCEIRO -->
                <li class="nav-sep ns-yellow"><i class='bx bx-dollar'></i><span>Financeiro</span></li>

                <?php if ($this->permission->checkPermission($this->session->userdata('permissao'), 'vLancamento')): ?>
                <li class="<?php if (isset($menuLancamentos)) echo 'active'; ?>">
                    <a data-g="yellow" class="tip-bottom" href="<?= site_url('financeiro/lancamentos') ?>">
                        <i class="bx bx-bar-chart-alt-2 iconX"></i>
                        <span class="title">Lançamentos</span>
                        <span class="title-tooltip">Lançamentos</span>
                    </a>
                </li>
                <?php endif; ?>
                <?php if ($this->permission->checkPermission($this->session->userdata('permissao'), 'vCobranca')): ?>
                <li class="<?php if (isset($menuCobrancas)) echo 'active'; ?>">
                    <a data-g="yellow" class="tip-bottom" href="<?= site_url('cobrancas/cobrancas') ?>">
                        <i class='bx bx-dollar-circle iconX'></i>
                        <span class="title">Cobranças</span>
                        <span class="title-tooltip">Cobranças</span>
                    </a>
                </li>
                <?php endif; ?>
                <?php if ($this->permission->checkPermission($this->session->userdata('permissao'), 'vLancamento')): ?>
                <li class="<?php if (isset($menuDashFinanceiro)) echo 'active'; ?>">
                    <a data-g="yellow" class="tip-bottom" href="<?= site_url('financeiro/dashboard') ?>">
                        <i class='bx bx-trending-up iconX'></i>
                        <span class="title">Fin. Dashboard</span>
                        <span class="title-tooltip">Dashboard Financeiro</span>
                    </a>
                </li>
                <?php endif; ?>

                <li class="<?php if (isset($menuPromissoria)) echo 'active'; ?>">
                    <a data-g="yellow" class="tip-bottom" href="<?= site_url('promissoria') ?>">
                        <i class='bx bx-pen iconX'></i>
                        <span class="title">Promissória</span>
                        <span class="title-tooltip">Promissória Avulsa</span>
                    </a>
                </li>

                <?php
                $gemini_enabled = $this->db->where('config','gemini_enabled')->get('configuracoes')->row();
                if ($gemini_enabled && $gemini_enabled->valor == '1'):
                ?>
                <li class="<?php if (isset($menuIa)) echo 'active'; ?>">
                    <a data-g="purple" class="tip-bottom" href="<?= site_url('sisos/ia') ?>">
                        <i class='bx bx-bot iconX'></i>
                        <span class="title">Assistente IA</span>
                        <span class="title-tooltip">Assistente Sisos IA</span>
                    </a>
                </li>
                <?php endif; ?>

                <!-- ESTOQUE -->
                <?php if ($this->permission->checkPermission($this->session->userdata('permissao'), 'vCompra')): ?>
                <li class="nav-sep ns-purple"><i class='bx bx-package'></i><span>Estoque</span></li>
                <li class="<?php if (isset($menuCompras)) echo 'active'; ?>">
                    <a data-g="purple" class="tip-bottom" href="<?= site_url('compras') ?>">
                        <i class='bx bx-purchase-tag-alt iconX'></i>
                        <span class="title">Compras</span>
                        <span class="title-tooltip">Compras</span>
                    </a>
                </li>
                <li class="<?php if (isset($menuEstoque)) echo 'active'; ?>">
                    <a data-g="purple" class="tip-bottom" href="<?= site_url('estoque/inventario') ?>">
                        <i class='bx bx-package iconX'></i>
                        <span class="title">Estoque</span>
                        <span class="title-tooltip">Estoque</span>
                    </a>
                </li>
                <li class="<?php if (isset($menuAvarias)) echo 'active'; ?>">
                    <a data-g="purple" class="tip-bottom" href="<?= site_url('estoque/avarias') ?>">
                        <i class='bx bx-error-alt iconX'></i>
                        <span class="title">Avarias</span>
                        <span class="title-tooltip">Avarias / Perdas</span>
                    </a>
                </li>
                <?php endif; ?>

                <!-- SISTEMA -->
                <li class="nav-sep ns-red"><i class='bx bx-cog'></i><span>Sistema</span></li>

                <?php if (($configuration['pdv_enabled'] ?? '0') == '1' && $this->permission->checkPermission($this->session->userdata('permissao'), 'aVenda')): ?>
                <li class="<?php if (isset($menuPdv)) echo 'active'; ?>">
                    <a data-g="red" class="tip-bottom" href="<?= site_url('pdv') ?>">
                        <i class='bx bx-store iconX'></i>
                        <span class="title">PDV</span>
                        <span class="title-tooltip">Ponto de Venda</span>
                    </a>
                </li>
                <?php endif; ?>

            </ul>
        </div>

        <div class="botton-content">
            <li>
                <a class="tip-bottom" href="<?= site_url('login/sair') ?>">
                    <i class='bx bx-log-out-circle iconX'></i>
                    <span class="title">Sair</span>
                    <span class="title-tooltip">Sair</span>
                </a>
            </li>
        </div>
    </div>
</nav>
<!--End sidebar-menu-->
