<style>
/* ── Reset e base ─────────────────────────────── */
#pdv-overlay {
    position: fixed; top: 0; left: 0; right: 0; bottom: 0;
    background: #0f1117; z-index: 9999;
    display: flex; flex-direction: column;
    font-family: 'Segoe UI', sans-serif;
}

/* ── Topbar ───────────────────────────────────── */
#pdv-topbar {
    display: flex; align-items: center; justify-content: space-between;
    background: #1a1d27; border-bottom: 1px solid #2a2d3a;
    padding: 0 20px; height: 52px; flex-shrink: 0;
}
#pdv-topbar .logo { font-size: 18px; font-weight: 700; color: #fff; display: flex; align-items: center; gap: 8px; }
#pdv-topbar .logo i { color: #3ecf8e; font-size: 22px; }
#pdv-topbar .info { display: flex; gap: 20px; align-items: center; }
#pdv-topbar .info span { color: #8b8fa8; font-size: 13px; }
#pdv-topbar .info strong { color: #fff; }
#pdv-topbar .actions { display: flex; gap: 8px; }
.pdv-topbtn {
    padding: 6px 14px; border-radius: 6px; border: 1px solid #2a2d3a;
    background: #1e2130; color: #8b8fa8; font-size: 12px; cursor: pointer;
    display: flex; align-items: center; gap: 5px; transition: .15s;
}
.pdv-topbtn:hover { background: #2a2d3a; color: #fff; }
.pdv-topbtn.danger { border-color: #e74c3c; color: #e74c3c; }
.pdv-topbtn.danger:hover { background: #e74c3c; color: #fff; }

/* ── Body ─────────────────────────────────────── */
#pdv-body { display: flex; flex: 1; overflow: hidden; }

/* ── Lado esquerdo ────────────────────────────── */
#pdv-left {
    flex: 1; display: flex; flex-direction: column;
    padding: 14px 16px; gap: 12px; background: #0f1117; overflow: hidden;
}

/* Busca */
#pdv-search-row { display: flex; gap: 10px; align-items: center; }
#pdv-search {
    flex: 1; padding: 11px 16px; font-size: 15px;
    background: #1a1d27; border: 1.5px solid #2a2d3a; border-radius: 8px;
    color: #fff; outline: none; transition: .2s;
}
#pdv-search:focus { border-color: #3ecf8e; box-shadow: 0 0 0 3px rgba(62,207,142,.12); }
#pdv-search::placeholder { color: #4a4d5e; }
.pdv-icon-btn {
    width: 44px; height: 44px; border-radius: 8px; border: 1.5px solid #2a2d3a;
    background: #1a1d27; color: #8b8fa8; font-size: 20px; cursor: pointer;
    display: flex; align-items: center; justify-content: center; transition: .15s;
}
.pdv-icon-btn:hover { background: #3ecf8e; border-color: #3ecf8e; color: #fff; }
#pdv-search-info { font-size: 12px; color: #4a4d5e; padding: 2px 0; }

/* Grade de produtos */
#pdv-produtos {
    flex: 1; overflow-y: auto; display: grid;
    grid-template-columns: repeat(auto-fill, minmax(160px, 1fr));
    gap: 10px; align-content: start; padding-right: 4px;
}
#pdv-produtos::-webkit-scrollbar { width: 4px; }
#pdv-produtos::-webkit-scrollbar-track { background: #1a1d27; }
#pdv-produtos::-webkit-scrollbar-thumb { background: #2a2d3a; border-radius: 2px; }

.pdv-card {
    background: #1a1d27; border: 1.5px solid #2a2d3a; border-radius: 10px;
    padding: 14px 12px; cursor: pointer; transition: .15s; text-align: center;
    position: relative; user-select: none;
}
.pdv-card:hover { border-color: #3ecf8e; background: #1e2432; transform: translateY(-1px); }
.pdv-card:active { transform: scale(.97); }
.pdv-card.sem-estoque { opacity: .5; border-color: #e74c3c; }
.pdv-card.sem-estoque:hover { border-color: #e74c3c; transform: none; }

.pdv-card-img { width: 70px; height: 70px; object-fit: cover; border-radius: 8px; margin: 0 auto 8px; display: block; }
.pdv-card-icon {
    width: 70px; height: 70px; background: #0f1117; border-radius: 8px;
    display: flex; align-items: center; justify-content: center;
    font-size: 30px; color: #3ecf8e; margin: 0 auto 8px;
}
.pdv-card-nome { font-size: 12px; font-weight: 600; color: #e0e0e0; line-height: 1.3; margin-bottom: 6px; }
.pdv-card-preco { font-size: 15px; font-weight: 700; color: #3ecf8e; }
.pdv-card-estoque { font-size: 10px; color: #4a4d5e; margin-top: 3px; }
.pdv-card-badge {
    position: absolute; top: 6px; right: 6px; background: #3ecf8e; color: #000;
    font-size: 10px; font-weight: 700; padding: 1px 6px; border-radius: 10px;
}

/* ── Lado direito — carrinho ──────────────────── */
#pdv-right {
    width: 400px; background: #1a1d27; border-left: 1px solid #2a2d3a;
    display: flex; flex-direction: column; flex-shrink: 0;
}

/* Cliente */
#pdv-cliente-area { padding: 12px 16px; border-bottom: 1px solid #2a2d3a; }
#pdv-cliente-area label { font-size: 11px; color: #4a4d5e; text-transform: uppercase; letter-spacing: .5px; display: block; margin-bottom: 5px; }
#pdv-cliente-row { display: flex; gap: 6px; }
#pdv-cliente-txt {
    flex: 1; padding: 8px 12px; background: #0f1117; border: 1.5px solid #2a2d3a;
    border-radius: 7px; color: #fff; font-size: 13px; outline: none;
}
#pdv-cliente-txt:focus { border-color: #3ecf8e; }
#pdv-cliente-txt::placeholder { color: #4a4d5e; }
#btn-novo-cliente-pdv {
    padding: 8px 10px; background: #3ecf8e; border: none; border-radius: 7px;
    color: #000; font-size: 11px; font-weight: 700; cursor: pointer; white-space: nowrap;
}

/* Itens do carrinho */
#pdv-cart-header {
    display: flex; justify-content: space-between; align-items: center;
    padding: 10px 16px; border-bottom: 1px solid #2a2d3a;
}
#pdv-cart-header span { font-size: 12px; color: #4a4d5e; text-transform: uppercase; letter-spacing: .5px; }
#pdv-cart-count { background: #3ecf8e; color: #000; font-size: 11px; font-weight: 700; padding: 1px 8px; border-radius: 10px; }

#pdv-carrinho { flex: 1; overflow-y: auto; }
#pdv-carrinho::-webkit-scrollbar { width: 3px; }
#pdv-carrinho::-webkit-scrollbar-thumb { background: #2a2d3a; }

.cart-empty-state {
    display: flex; flex-direction: column; align-items: center; justify-content: center;
    height: 100%; color: #2a2d3a; padding: 30px;
}
.cart-empty-state i { font-size: 48px; margin-bottom: 10px; }
.cart-empty-state p { font-size: 13px; text-align: center; }

.cart-row {
    display: flex; align-items: center; gap: 8px;
    padding: 10px 16px; border-bottom: 1px solid #1e2130; transition: .1s;
}
.cart-row:hover { background: #1e2130; }
.cart-info { flex: 1; min-width: 0; }
.cart-nome { font-size: 13px; font-weight: 600; color: #e0e0e0; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
.cart-unit { font-size: 11px; color: #4a4d5e; }
.cart-controls { display: flex; align-items: center; gap: 4px; }
.cart-btn { width: 26px; height: 26px; border-radius: 5px; border: 1px solid #2a2d3a; background: #0f1117; color: #fff; font-size: 14px; font-weight: 700; cursor: pointer; display: flex; align-items: center; justify-content: center; }
.cart-btn:hover { background: #3ecf8e; border-color: #3ecf8e; color: #000; }
.cart-qtd-input { width: 40px; text-align: center; background: #0f1117; border: 1px solid #2a2d3a; border-radius: 5px; color: #fff; font-size: 13px; font-weight: 700; padding: 3px; }
.cart-sub { font-size: 13px; font-weight: 700; color: #3ecf8e; min-width: 70px; text-align: right; }
.cart-del { background: none; border: none; color: #2a2d3a; font-size: 18px; cursor: pointer; padding: 0 2px; line-height: 1; }
.cart-del:hover { color: #e74c3c; }

/* Totais */
#pdv-totais { padding: 12px 16px; border-top: 1px solid #2a2d3a; background: #15182a; }
.tot-row { display: flex; justify-content: space-between; font-size: 13px; color: #8b8fa8; padding: 3px 0; }
.tot-row.main { font-size: 20px; font-weight: 800; color: #fff; padding: 8px 0 4px; }
.tot-row.main span:last-child { color: #3ecf8e; }

/* Desconto */
#pdv-desc-row { display: flex; gap: 6px; margin: 6px 0; }
#pdv-desconto {
    flex: 1; padding: 7px 10px; background: #0f1117; border: 1.5px solid #2a2d3a;
    border-radius: 6px; color: #fff; font-size: 13px; outline: none;
}
#pdv-desconto:focus { border-color: #f39c12; }
#pdv-tipo-desc {
    padding: 7px 6px; background: #0f1117; border: 1.5px solid #2a2d3a;
    border-radius: 6px; color: #fff; font-size: 12px; outline: none; cursor: pointer;
}

/* Pagamento */
#pdv-pgto { padding: 10px 16px; border-top: 1px solid #2a2d3a; }
#pdv-pgto-label { font-size: 11px; color: #4a4d5e; text-transform: uppercase; letter-spacing: .5px; margin-bottom: 8px; }
#pdv-pgto-btns { display: flex; gap: 5px; flex-wrap: wrap; margin-bottom: 8px; }
.pgto-btn {
    flex: 1; min-width: 80px; padding: 8px 5px; border-radius: 7px;
    border: 1.5px solid #2a2d3a; background: #0f1117; color: #8b8fa8;
    font-size: 12px; font-weight: 600; cursor: pointer; text-align: center; transition: .15s;
}
.pgto-btn:hover { border-color: #3ecf8e; color: #3ecf8e; }
.pgto-btn.ativo { border-color: #3ecf8e; background: rgba(62,207,142,.1); color: #3ecf8e; }

#pdv-recebido-row { display: flex; gap: 8px; align-items: center; }
#pdv-recebido-row label { font-size: 12px; color: #4a4d5e; white-space: nowrap; }
#pdv-recebido {
    flex: 1; padding: 7px 10px; background: #0f1117; border: 1.5px solid #2a2d3a;
    border-radius: 6px; color: #fff; font-size: 14px; font-weight: 700; outline: none;
}
#pdv-recebido:focus { border-color: #3ecf8e; }
#pdv-troco { font-size: 13px; color: #f39c12; font-weight: 600; padding: 4px 0; }

/* Botões de ação */
#pdv-actions { padding: 10px 16px 14px; display: flex; flex-direction: column; gap: 6px; border-top: 1px solid #2a2d3a; }
#btn-finalizar {
    padding: 14px; font-size: 16px; font-weight: 700;
    background: linear-gradient(135deg, #3ecf8e, #2ecc71);
    color: #000; border: none; border-radius: 10px; cursor: pointer;
    display: flex; align-items: center; justify-content: center; gap: 8px; transition: .2s;
}
#btn-finalizar:hover { transform: translateY(-1px); box-shadow: 0 4px 20px rgba(62,207,142,.3); }
#btn-finalizar:disabled { background: #2a2d3a; color: #4a4d5e; cursor: not-allowed; transform: none; box-shadow: none; }
#btn-cancelar {
    padding: 9px; font-size: 13px; background: transparent;
    border: 1.5px solid #e74c3c; color: #e74c3c; border-radius: 8px; cursor: pointer; transition: .15s;
}
#btn-cancelar:hover { background: #e74c3c; color: #fff; }

/* Atalhos */
#pdv-shortcuts { display: flex; gap: 10px; justify-content: center; padding: 6px 0 0; }
.shortcut { font-size: 10px; color: #2a2d3a; }
.shortcut kbd { background: #1e2130; border: 1px solid #2a2d3a; border-radius: 3px; padding: 1px 5px; color: #4a4d5e; font-size: 10px; }

/* Modal sucesso */
#modal-pdv-sucesso {
    display: none; position: fixed; inset: 0; background: rgba(0,0,0,.7);
    z-index: 10000; align-items: center; justify-content: center;
}
#modal-pdv-sucesso.show { display: flex; }
.modal-pdv-box {
    background: #1a1d27; border: 1.5px solid #3ecf8e; border-radius: 16px;
    padding: 32px; text-align: center; width: 360px; animation: popIn .2s ease;
}
@keyframes popIn { from { transform: scale(.8); opacity: 0; } to { transform: scale(1); opacity: 1; } }
.modal-pdv-icon { font-size: 56px; color: #3ecf8e; margin-bottom: 10px; }
.modal-pdv-total { font-size: 32px; font-weight: 800; color: #fff; margin: 8px 0; }
.modal-pdv-troco { font-size: 20px; font-weight: 700; color: #f39c12; margin-bottom: 16px; }
.modal-pdv-id { font-size: 13px; color: #4a4d5e; margin-bottom: 20px; }
.modal-pdv-btns { display: flex; gap: 10px; }
.modal-pdv-btns button { flex: 1; padding: 12px; border-radius: 8px; font-size: 13px; font-weight: 700; cursor: pointer; border: none; }
.btn-imprimir { background: #2a2d3a; color: #fff; }
.btn-nova { background: #3ecf8e; color: #000; }

/* Modal cliente rápido PDV */
#modal-cliente-pdv {
    display: none; position: fixed; inset: 0; background: rgba(0,0,0,.7);
    z-index: 10001; align-items: center; justify-content: center;
}
#modal-cliente-pdv.show { display: flex; }
.modal-cliente-box {
    background: #1a1d27; border: 1.5px solid #2a2d3a; border-radius: 14px;
    padding: 24px; width: 380px;
}
.modal-cliente-box h4 { color: #fff; margin-bottom: 16px; font-size: 16px; }
.mc-field { margin-bottom: 12px; }
.mc-field label { font-size: 11px; color: #4a4d5e; text-transform: uppercase; letter-spacing: .5px; display: block; margin-bottom: 4px; }
.mc-field input {
    width: 100%; padding: 9px 12px; background: #0f1117; border: 1.5px solid #2a2d3a;
    border-radius: 7px; color: #fff; font-size: 13px; outline: none; box-sizing: border-box;
}
.mc-field input:focus { border-color: #3ecf8e; }
.mc-btns { display: flex; gap: 8px; margin-top: 16px; }
.mc-btns button { flex: 1; padding: 10px; border-radius: 7px; font-size: 13px; font-weight: 700; cursor: pointer; border: none; }
.mc-cancel { background: #2a2d3a; color: #fff; }
.mc-save { background: #3ecf8e; color: #000; }
</style>

<!-- PDV Overlay Tela Cheia -->
<div id="pdv-overlay">

    <!-- Topbar -->
    <div id="pdv-topbar">
        <div class="logo">
            <i class='bx bx-store-alt'></i>
            <?= $configuration['app_name'] ?? 'SISOS' ?> — PDV
        </div>
        <div class="info">
            <span><?= date('l, d/m/Y') ?></span>
            <span>Operador: <strong><?= $this->session->userdata('nome') ?? 'Admin' ?></strong></span>
            <span id="pdv-clock" style="color:#3ecf8e;font-weight:700;font-size:15px"></span>
        </div>
        <div class="actions">
            <button class="pdv-topbtn" onclick="window.open('<?= site_url('pdv/relatorio') ?>','_blank')">
                <i class='bx bx-bar-chart-alt'></i> Relatório
            </button>
            <button class="pdv-topbtn" onclick="window.location='<?= site_url('sisos') ?>'">
                <i class='bx bx-home'></i> Voltar ao sistema
            </button>
        </div>
    </div>

    <!-- Body -->
    <div id="pdv-body">

        <!-- Esquerdo: busca + produtos -->
        <div id="pdv-left">
            <div id="pdv-search-row">
                <input type="text" id="pdv-search" placeholder="🔍  Buscar produto por nome, código ou use o leitor de barras..." autofocus>
                <button class="pdv-icon-btn" id="pdv-barcode-btn" title="Foco no leitor (F2)">
                    <i class='bx bx-barcode-reader'></i>
                </button>
            </div>
            <div id="pdv-search-info">Digite para buscar ou pressione F2 para focar na busca por código de barras</div>

            <div id="pdv-produtos">
                <div style="grid-column:1/-1;display:flex;flex-direction:column;align-items:center;justify-content:center;padding:60px 20px;color:#2a2d3a">
                    <i class='bx bx-search-alt' style="font-size:52px;margin-bottom:12px"></i>
                    <p style="font-size:14px;text-align:center">Digite para buscar produtos<br>ou escaneie um código de barras</p>
                </div>
            </div>
        </div>

        <!-- Direito: carrinho -->
        <div id="pdv-right">

            <!-- Cliente -->
            <div id="pdv-cliente-area">
                <label>Cliente (opcional)</label>
                <div id="pdv-cliente-row">
                    <input type="text" id="pdv-cliente-txt" placeholder="Buscar cliente...">
                    <input type="hidden" id="pdv-cliente-id">
                    <button id="btn-novo-cliente-pdv" title="Cadastrar novo cliente">+ Novo</button>
                </div>
            </div>

            <!-- Header carrinho -->
            <div id="pdv-cart-header">
                <span>Carrinho</span>
                <span id="pdv-cart-count">0 itens</span>
            </div>

            <!-- Itens -->
            <div id="pdv-carrinho">
                <div class="cart-empty-state">
                    <i class='bx bx-cart'></i>
                    <p>Carrinho vazio<br><small style="color:#1e2130">Adicione produtos clicando ou escaneando</small></p>
                </div>
            </div>

            <!-- Totais -->
            <div id="pdv-totais">
                <div class="tot-row"><span>Subtotal</span><span id="pdv-subtotal">R$ 0,00</span></div>
                <div id="pdv-desc-row" style="display:flex;gap:6px;margin:5px 0">
                    <input type="number" id="pdv-desconto" placeholder="Desconto" min="0" step="0.01" style="flex:1;padding:7px 10px;background:#0f1117;border:1.5px solid #2a2d3a;border-radius:6px;color:#fff;font-size:13px;outline:none;">
                    <select id="pdv-tipo-desc" style="padding:7px 6px;background:#0f1117;border:1.5px solid #2a2d3a;border-radius:6px;color:#fff;font-size:12px;outline:none;cursor:pointer;">
                        <option value="percent">%</option>
                        <option value="fixed">R$</option>
                    </select>
                </div>
                <div class="tot-row" id="pdv-desc-display" style="display:none;color:#f39c12"><span>Desconto</span><span id="pdv-desc-val">-R$ 0,00</span></div>
                <div class="tot-row main"><span>TOTAL</span><span id="pdv-total-display">R$ 0,00</span></div>
            </div>

            <!-- Pagamento -->
            <div id="pdv-pgto">
                <div id="pdv-pgto-label">Forma de Pagamento</div>
                <div id="pdv-pgto-btns">
                    <button class="pgto-btn ativo" data-forma="Dinheiro">💵 Dinheiro</button>
                    <button class="pgto-btn" data-forma="PIX">📱 PIX</button>
                    <button class="pgto-btn" data-forma="Cartão de Débito">💳 Débito</button>
                    <button class="pgto-btn" data-forma="Cartão de Crédito">💳 Crédito</button>
                </div>
                <div id="pdv-recebido-row">
                    <label>Recebido R$:</label>
                    <input type="number" id="pdv-recebido" placeholder="0,00" min="0" step="0.01">
                </div>
                <div id="pdv-troco">Troco: R$ 0,00</div>
            </div>

            <!-- Ações -->
            <div id="pdv-actions">
                <button id="btn-finalizar" disabled>
                    <i class='bx bx-check-circle'></i> Finalizar Venda <small style="opacity:.7">(F12)</small>
                </button>
                <button id="btn-cancelar"><i class='bx bx-x'></i> Cancelar / Limpar</button>
                <div id="pdv-shortcuts">
                    <span class="shortcut"><kbd>F2</kbd> Busca</span>
                    <span class="shortcut"><kbd>F12</kbd> Finalizar</span>
                    <span class="shortcut"><kbd>Esc</kbd> Limpar</span>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Sucesso -->
<div id="modal-pdv-sucesso">
    <div class="modal-pdv-box">
        <div class="modal-pdv-icon"><i class='bx bx-check-circle'></i></div>
        <div style="color:#8b8fa8;font-size:13px">Venda finalizada com sucesso!</div>
        <div class="modal-pdv-total" id="modal-total-final">R$ 0,00</div>
        <div class="modal-pdv-troco" id="modal-troco-final" style="display:none"></div>
        <div class="modal-pdv-id">Venda #<span id="modal-id-venda"></span></div>
        <div class="modal-pdv-btns">
            <button class="btn-imprimir" id="btn-imprimir-cupom"><i class='bx bx-printer'></i> Cupom</button>
            <button class="btn-nova" id="btn-nova-venda"><i class='bx bx-refresh'></i> Nova Venda</button>
        </div>
    </div>
</div>

<!-- Modal Novo Cliente PDV -->
<div id="modal-cliente-pdv">
    <div class="modal-cliente-box">
        <h4><i class='bx bx-user-plus'></i> Novo Cliente Rápido</h4>
        <div class="mc-field">
            <label>Nome *</label>
            <input type="text" id="mc-nome" placeholder="Nome completo">
        </div>
        <div class="mc-field">
            <label>Telefone</label>
            <input type="text" id="mc-tel" placeholder="(00) 00000-0000">
        </div>
        <div class="mc-field">
            <label>CPF</label>
            <input type="text" id="mc-cpf" placeholder="000.000.000-00">
        </div>
        <div class="mc-btns">
            <button class="mc-cancel" onclick="fecharModalCliente()">Cancelar</button>
            <button class="mc-save" id="mc-salvar">Salvar Cliente</button>
        </div>
    </div>
</div>

<link rel="stylesheet" href="<?= base_url() ?>assets/js/jquery-ui/css/smoothness/jquery-ui-1.9.2.custom.css">
<script src="<?= base_url() ?>assets/js/jquery-ui/js/jquery-ui-1.9.2.custom.js"></script>
<script>
var CSRF_NAME  = '<?= $this->security->get_csrf_token_name() ?>';
var CSRF_HASH  = '<?= $this->security->get_csrf_hash() ?>';
var carrinho   = [];
var formaPgto  = 'Dinheiro';
var ultimaVendaId = null;

// Relógio
function atualizarRelogio() {
    var d = new Date();
    var h = d.getHours().toString().padStart(2,'0');
    var m = d.getMinutes().toString().padStart(2,'0');
    var s = d.getSeconds().toString().padStart(2,'0');
    document.getElementById('pdv-clock').textContent = h+':'+m+':'+s;
}
setInterval(atualizarRelogio, 1000);
atualizarRelogio();

// Esconder menu lateral e header quando PDV está ativo
document.addEventListener('DOMContentLoaded', function(){
    var sidebar = document.querySelector('.sidebar, #sidebar, .nav-side-menu, aside');
    var header  = document.querySelector('header, .navbar, #header, .top-header');
    if (sidebar) sidebar.style.display = 'none';
    if (header)  header.style.display  = 'none';
    document.body.style.overflow = 'hidden';
    document.body.style.margin = '0';
    document.body.style.padding = '0';
    // Remover padding do container principal
    var main = document.querySelector('.main-content, #main-content, .content-area');
    if (main) { main.style.margin = '0'; main.style.padding = '0'; }
});

// ── Busca ──────────────────────────────────────
var buscaTimer;
$('#pdv-search').on('input', function(){
    clearTimeout(buscaTimer);
    var q = $(this).val().trim();
    if (!q) {
        $('#pdv-produtos').html('<div style="grid-column:1/-1;display:flex;flex-direction:column;align-items:center;justify-content:center;padding:60px 20px;color:#2a2d3a"><i class="bx bx-search-alt" style="font-size:52px;margin-bottom:12px"></i><p style="font-size:14px;text-align:center">Digite para buscar produtos</p></div>');
        return;
    }
    buscaTimer = setTimeout(function(){ buscarProdutos(q); }, 200);
});

$('#pdv-search').on('keypress', function(e){
    if (e.key === 'Enter') {
        var q = $(this).val().trim();
        $.get('<?= site_url('pdv/buscarCodigo') ?>', {codigo: q}, function(p){
            if (p && p.id) {
                adicionarAoCarrinho(p);
                $('#pdv-search').val('').focus();
                $('#pdv-search-info').text('✅ Produto adicionado: ' + p.descricao);
                setTimeout(function(){ $('#pdv-search-info').text('Digite para buscar ou pressione F2'); }, 2000);
            } else {
                buscarProdutos(q);
            }
        }, 'json');
    }
});

function buscarProdutos(q) {
    $('#pdv-search-info').text('Buscando...');
    $.get('<?= site_url('pdv/buscarProduto') ?>', {q: q}, function(prods){
        $('#pdv-search-info').text(prods.length + ' produto(s) encontrado(s)');
        if (!prods.length) {
            $('#pdv-produtos').html('<div style="grid-column:1/-1;text-align:center;padding:40px;color:#2a2d3a"><i class="bx bx-search-alt" style="font-size:40px"></i><p style="margin-top:8px">Nenhum produto encontrado</p></div>');
            return;
        }
        var html = '';
        prods.forEach(function(p){
            var semEst = parseFloat(p.estoque) <= 0;
            var img = p.foto
                ? '<img class="pdv-card-img" src="'+p.foto+'" alt="">'
                : '<div class="pdv-card-icon"><i class="bx bx-package"></i></div>';
            var estBadge = semEst
                ? '<div style="position:absolute;top:6px;right:6px;background:#e74c3c;color:#fff;font-size:10px;font-weight:700;padding:1px 6px;border-radius:10px;">Sem estoque</div>'
                : '<div class="pdv-card-badge">'+parseFloat(p.estoque).toFixed(0)+'</div>';
            html += '<div class="pdv-card'+(semEst?' sem-estoque':'')+'" data-id="'+p.id+'" data-nome="'+encodeURIComponent(p.descricao)+'" data-preco="'+p.preco+'" data-estoque="'+p.estoque+'">'
                + img + estBadge
                + '<div class="pdv-card-nome">'+p.descricao+'</div>'
                + '<div class="pdv-card-preco">R$ '+parseFloat(p.preco).toLocaleString('pt-BR',{minimumFractionDigits:2})+'</div>'
                + (p.codDeBarra ? '<div class="pdv-card-estoque">'+p.codDeBarra+'</div>' : '')
                + '</div>';
        });
        $('#pdv-produtos').html(html);
    }, 'json');
}

$(document).on('click', '.pdv-card', function(){
    adicionarAoCarrinho({
        id: $(this).data('id'),
        descricao: decodeURIComponent($(this).data('nome')),
        preco: parseFloat($(this).data('preco')),
        estoque: parseFloat($(this).data('estoque'))
    });
});

// ── Carrinho ───────────────────────────────────
function adicionarAoCarrinho(p) {
    var idx = carrinho.findIndex(function(i){ return i.id == p.id; });
    if (idx >= 0) {
        carrinho[idx].qtd = Math.round((carrinho[idx].qtd + 1) * 1000) / 1000;
    } else {
        carrinho.push({ id: p.id, descricao: p.descricao, preco: parseFloat(p.preco), qtd: 1, estoque: parseFloat(p.estoque||0) });
    }
    renderCarrinho();
}

function renderCarrinho() {
    var total = carrinho.reduce(function(s,i){ return s+i.qtd; }, 0);
    $('#pdv-cart-count').text(total + (total===1?' item':' itens'));

    if (!carrinho.length) {
        $('#pdv-carrinho').html('<div class="cart-empty-state"><i class="bx bx-cart"></i><p>Carrinho vazio<br><small style="color:#1e2130">Adicione produtos clicando ou escaneando</small></p></div>');
        $('#btn-finalizar').prop('disabled', true);
        calcTotais();
        return;
    }

    var html = '';
    carrinho.forEach(function(item, i){
        html += '<div class="cart-row" data-idx="'+i+'">'
            + '<div class="cart-info"><div class="cart-nome" title="'+item.descricao+'">'+item.descricao+'</div>'
            + '<div class="cart-unit">R$ '+item.preco.toFixed(2).replace('.',',')+'</div></div>'
            + '<div class="cart-controls">'
            + '<button class="cart-btn cart-minus">−</button>'
            + '<input class="cart-qtd-input" type="number" value="'+item.qtd+'" min="0.001" step="1">'
            + '<button class="cart-btn cart-plus">+</button>'
            + '</div>'
            + '<div class="cart-sub">R$ '+(item.preco*item.qtd).toFixed(2).replace('.',',')+'</div>'
            + '<button class="cart-del">×</button>'
            + '</div>';
    });
    $('#pdv-carrinho').html(html);
    $('#btn-finalizar').prop('disabled', false);
    calcTotais();
}

function calcTotais() {
    var sub  = carrinho.reduce(function(s,i){ return s+i.preco*i.qtd; }, 0);
    var desc = parseFloat($('#pdv-desconto').val()||0);
    var tipo = $('#pdv-tipo-desc').val();
    var dv   = tipo==='percent' ? sub*(desc/100) : desc;
    var tot  = Math.max(0, sub - dv);
    var rec  = parseFloat($('#pdv-recebido').val()||0);
    var troco= Math.max(0, rec - tot);

    $('#pdv-subtotal').text('R$ '+sub.toFixed(2).replace('.',','));
    $('#pdv-total-display').text('R$ '+tot.toFixed(2).replace('.',','));

    if (dv > 0) {
        $('#pdv-desc-display').show();
        $('#pdv-desc-val').text('- R$ '+dv.toFixed(2).replace('.',','));
    } else {
        $('#pdv-desc-display').hide();
    }
    $('#pdv-troco').text('Troco: R$ '+troco.toFixed(2).replace('.',','));
    if (troco > 0) $('#pdv-troco').css('color','#f39c12');
    else $('#pdv-troco').css('color','#4a4d5e');
}

// Eventos carrinho
$(document).on('click','.cart-plus', function(){
    var idx=$(this).closest('.cart-row').data('idx');
    carrinho[idx].qtd=Math.round((carrinho[idx].qtd+1)*1000)/1000;
    renderCarrinho();
});
$(document).on('click','.cart-minus', function(){
    var idx=$(this).closest('.cart-row').data('idx');
    if(carrinho[idx].qtd<=1) { carrinho.splice(idx,1); } else { carrinho[idx].qtd=Math.round((carrinho[idx].qtd-1)*1000)/1000; }
    renderCarrinho();
});
$(document).on('change','.cart-qtd-input', function(){
    var idx=$(this).closest('.cart-row').data('idx');
    var v=parseFloat($(this).val());
    if(!v||v<=0) carrinho.splice(idx,1); else carrinho[idx].qtd=v;
    renderCarrinho();
});
$(document).on('click','.cart-del', function(){
    var idx=$(this).closest('.cart-row').data('idx');
    carrinho.splice(idx,1);
    renderCarrinho();
});

$('#pdv-desconto,#pdv-tipo-desc,#pdv-recebido').on('input change', calcTotais);

// Formas de pagamento
$('.pgto-btn').on('click', function(){
    $('.pgto-btn').removeClass('ativo');
    $(this).addClass('ativo');
    formaPgto=$(this).data('forma');
});

// ── Autocomplete cliente ───────────────────────
$('#pdv-cliente-txt').autocomplete({
    source: '<?= site_url('clientes/autoCompleteCliente') ?>',
    minLength: 2,
    select: function(e,ui){ $('#pdv-cliente-id').val(ui.item.id); }
});

// ── Modal novo cliente ─────────────────────────
$('#btn-novo-cliente-pdv').on('click', function(){
    $('#mc-nome,#mc-tel,#mc-cpf').val('');
    $('#modal-cliente-pdv').addClass('show');
    setTimeout(function(){ $('#mc-nome').focus(); }, 100);
});
function fecharModalCliente(){ $('#modal-cliente-pdv').removeClass('show'); }
$('#mc-salvar').on('click', function(){
    var nome=$('#mc-nome').val().trim();
    if(!nome){ alert('Nome é obrigatório.'); return; }
    var d={nomeCliente:nome,telefone:$('#mc-tel').val(),cpf:$('#mc-cpf').val()};
    d[CSRF_NAME]=CSRF_HASH;
    $.post('<?= site_url('clientes/adicionarRapido') ?>',d,function(res){
        if(res.sucesso){
            $('#pdv-cliente-id').val(res.id);
            $('#pdv-cliente-txt').val(res.nome);
            fecharModalCliente();
        } else { alert(res.erro||'Erro ao salvar.'); }
    },'json');
});

// ── Finalizar ──────────────────────────────────
$('#btn-finalizar').on('click', function(){
    if(!carrinho.length) return;
    $(this).prop('disabled',true).html('<i class="bx bx-loader-alt bx-spin"></i> Processando...');

    var sub=carrinho.reduce(function(s,i){return s+i.preco*i.qtd;},0);
    var desc=parseFloat($('#pdv-desconto').val()||0);
    var tipo=$('#pdv-tipo-desc').val();
    var dv=tipo==='percent'?sub*(desc/100):desc;
    var tot=Math.max(0,sub-dv);
    var rec=parseFloat($('#pdv-recebido').val()||0);
    var troco=Math.max(0,rec-tot);

    var d={itens:JSON.stringify(carrinho),clientes_id:$('#pdv-cliente-id').val(),forma_pgto:formaPgto,desconto:desc,tipo_desconto:tipo,valor_recebido:rec};
    d[CSRF_NAME]=CSRF_HASH;

    $.post('<?= site_url('pdv/finalizar') ?>',d,function(res){
        $('#btn-finalizar').prop('disabled',false).html('<i class="bx bx-check-circle"></i> Finalizar Venda <small style="opacity:.7">(F12)</small>');
        if(res.result){
            ultimaVendaId=res.idVenda;
            $('#modal-total-final').text('R$ '+res.total);
            if(parseFloat(res.troco)>0){
                $('#modal-troco-final').show().text('Troco: R$ '+res.troco);
            } else {
                $('#modal-troco-final').hide();
            }
            $('#modal-id-venda').text(res.idVenda);
            $('#modal-pdv-sucesso').addClass('show');
        } else {
            alert('Erro: '+(res.messages||'Não foi possível finalizar.'));
        }
    },'json');
});

$('#btn-nova-venda').on('click', function(){
    $('#modal-pdv-sucesso').removeClass('show');
    carrinho=[];
    $('#pdv-cliente-txt,#pdv-cliente-id,#pdv-desconto,#pdv-recebido').val('');
    $('.pgto-btn').removeClass('ativo');
    $('[data-forma="Dinheiro"]').addClass('ativo');
    formaPgto='Dinheiro';
    $('#pdv-search').val('').focus();
    renderCarrinho();
    $('#pdv-produtos').html('<div style="grid-column:1/-1;display:flex;flex-direction:column;align-items:center;justify-content:center;padding:60px 20px;color:#2a2d3a"><i class="bx bx-search-alt" style="font-size:52px;margin-bottom:12px"></i><p style="font-size:14px;text-align:center">Digite para buscar produtos</p></div>');
    calcTotais();
});

$('#btn-imprimir-cupom').on('click', function(){
    if(ultimaVendaId) window.open('<?= site_url('pdv/cupom') ?>/'+ultimaVendaId,'_blank');
});

$('#btn-cancelar').on('click', function(){
    if(!carrinho.length||confirm('Cancelar e limpar o carrinho?')){
        carrinho=[];
        $('#pdv-search').val('').focus();
        $('#pdv-cliente-txt,#pdv-cliente-id,#pdv-desconto,#pdv-recebido').val('');
        formaPgto='Dinheiro';
        $('.pgto-btn').removeClass('ativo');
        $('[data-forma="Dinheiro"]').addClass('ativo');
        renderCarrinho();
        calcTotais();
    }
});

// Atalhos
$(document).on('keydown', function(e){
    if($('#modal-pdv-sucesso').hasClass('show')||$('#modal-cliente-pdv').hasClass('show')) return;
    if(e.key==='F2'){ $('#pdv-search').focus(); e.preventDefault(); }
    if(e.key==='F12'){ if(!$('#btn-finalizar').prop('disabled')) $('#btn-finalizar').click(); e.preventDefault(); }
    if(e.key==='Escape'){ $('#btn-cancelar').click(); }
});
</script>
