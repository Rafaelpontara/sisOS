<?php

if (! defined('BASEPATH')) {
    exit('No direct script access allowed');
}

// ══════════════════════════════════════════════════════════════════════
// SISOS API v1 — Rotas completas
// ══════════════════════════════════════════════════════════════════════

// ── Auth & Conta ──────────────────────────────────────────────────────
$route['api/v1']              = 'api/v1/ApiController/index';
$route['api/v1/audit']        = 'api/v1/ApiController/audit';
$route['api/v1/emitente']     = 'api/v1/ApiController/emitente';
$route['api/v1/calendario']   = 'api/v1/ApiController/calendario';
$route['api/v1/login']        = 'api/v1/UsuariosController/login';
$route['api/v1/reGenToken']   = 'api/v1/UsuariosController/reGenToken';
$route['api/v1/conta']        = 'api/v1/UsuariosController/conta';

// ── Usuários ──────────────────────────────────────────────────────────
$route['api/v1/usuarios']         = 'api/v1/UsuariosController/index';
$route['api/v1/usuarios/(:num)']  = 'api/v1/UsuariosController/index/$1';

// ── Clientes ──────────────────────────────────────────────────────────
$route['api/v1/clientes']         = 'api/v1/ClientesController/index';
$route['api/v1/clientes/(:num)']  = 'api/v1/ClientesController/index/$1';

// ── Produtos ──────────────────────────────────────────────────────────
$route['api/v1/produtos']         = 'api/v1/ProdutosController/index';
$route['api/v1/produtos/(:num)']  = 'api/v1/ProdutosController/index/$1';

// ── Serviços ──────────────────────────────────────────────────────────
$route['api/v1/servicos']         = 'api/v1/ServicosController/index';
$route['api/v1/servicos/(:num)']  = 'api/v1/ServicosController/index/$1';

// ── OS + Agenda ───────────────────────────────────────────────────────
$route['api/v1/os']                          = 'api/v1/OsController/index';
$route['api/v1/os/(:num)']                   = 'api/v1/OsController/index/$1';
$route['api/v1/agenda']                      = 'api/v1/OsController/agenda';
$route['api/v1/os/(:num)/produtos']          = 'api/v1/OsController/produtos/$1';
$route['api/v1/os/(:num)/produtos/(:num)']   = 'api/v1/OsController/produtos/$1/$2';
$route['api/v1/os/(:num)/servicos']          = 'api/v1/OsController/servicos/$1';
$route['api/v1/os/(:num)/servicos/(:num)']   = 'api/v1/OsController/servicos/$1/$2';
$route['api/v1/os/(:num)/anotacoes']         = 'api/v1/OsController/anotacoes/$1';
$route['api/v1/os/(:num)/anotacoes/(:num)']  = 'api/v1/OsController/anotacoes/$1/$2';
$route['api/v1/os/(:num)/anexos']            = 'api/v1/OsController/anexos/$1';
$route['api/v1/os/(:num)/anexos/(:num)']     = 'api/v1/OsController/anexos/$1/$2';
$route['api/v1/os/(:num)/desconto']          = 'api/v1/OsController/desconto/$1';
$route['api/v1/os/(:num)/checklist']         = 'api/v1/OsController/checklist/$1';
$route['api/v1/os/(:num)/checklist-saida']   = 'api/v1/OsController/checklistSaida/$1';
$route['api/v1/os/(:num)/faturar']           = 'api/v1/OsController/faturar/$1';
$route['api/v1/os/(:num)/cancelar']          = 'api/v1/OsController/cancelar/$1';

// ── Vendas ────────────────────────────────────────────────────────────
$route['api/v1/vendas']                  = 'api/v1/VendasController/index';
$route['api/v1/vendas/(:num)']           = 'api/v1/VendasController/index/$1';
$route['api/v1/vendas/(:num)/cancelar']  = 'api/v1/VendasController/cancelar/$1';

// ── PDV (app mobile) ──────────────────────────────────────────────────
$route['api/v1/pdv/buscar-produto']  = 'api/v1/PdvController/buscarProduto';
$route['api/v1/pdv/buscar-codigo']   = 'api/v1/PdvController/buscarCodigo';
$route['api/v1/pdv/finalizar']       = 'api/v1/PdvController/finalizar';

// ── Financeiro ────────────────────────────────────────────────────────
$route['api/v1/financeiro/dashboard']              = 'api/v1/FinanceiroController/dashboard';
$route['api/v1/financeiro/resumo-anual']           = 'api/v1/FinanceiroController/resumoAnual';
$route['api/v1/financeiro/lancamentos']            = 'api/v1/FinanceiroController/lancamentos';
$route['api/v1/financeiro/lancamentos/(:num)']     = 'api/v1/FinanceiroController/lancamentos/$1';
$route['api/v1/financeiro/baixar/(:num)']          = 'api/v1/FinanceiroController/baixar/$1';

// ── Garantias ─────────────────────────────────────────────────────────
$route['api/v1/garantias']      = 'api/v1/GarantiasController/index';

// ── Permissões ────────────────────────────────────────────────────────
$route['api/v1/permissoes']         = 'api/v1/PermissoesController/index';
$route['api/v1/permissoes/(:num)']  = 'api/v1/PermissoesController/index/$1';

// ── Busca Global ─────────────────────────────────────────────────────
$route['api/v1/busca']          = 'api/v1/BuscaController/index';

// ── Arquivos ─────────────────────────────────────────────────────────
$route['api/v1/arquivos']         = 'api/v1/ArquivosController/index';
$route['api/v1/arquivos/(:num)']  = 'api/v1/ArquivosController/index/$1';

// ── API Client (área do cliente) ──────────────────────────────────────
$route['api/v1/client']                    = 'api/v1/client/ClientOsController/index';
$route['api/v1/client/auth']               = 'api/v1/client/ClientLoginController/login';
$route['api/v1/client/os']                 = 'api/v1/client/ClientOsController/os';
$route['api/v1/client/os/(:num)']          = 'api/v1/client/ClientOsController/os/$1';
$route['api/v1/client/compras']            = 'api/v1/client/ClientComprasController/index';
$route['api/v1/client/compras/(:num)']     = 'api/v1/client/ClientComprasController/index/$1';
$route['api/v1/client/cobrancas']          = 'api/v1/client/ClientCobrancasController/index';
