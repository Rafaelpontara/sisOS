# SISOS — Guia de Instalação e Changelog Completo

## ═══════════════════════════════════════════════
## PARTE 1 — INSTALAÇÃO DO SISTEMA
## ═══════════════════════════════════════════════

### PRÉ-REQUISITOS

Você precisa de um servidor com:
- **PHP** 7.4 ou superior (recomendado 8.1+)
- **MySQL** 5.7 ou superior (ou MariaDB 10.3+)
- **Apache** ou **Nginx**
- Extensões PHP: `pdo`, `pdo_mysql`, `mysqli`, `curl`, `mbstring`, `gd`, `zip`, `openssl`
- **Composer** (para dependências, se houver)

---

### OPÇÃO A — INSTALAÇÃO LOCAL (XAMPP / WAMP)

**Passo 1 — Instalar o XAMPP**
1. Baixe o XAMPP em https://www.apachefriends.org
2. Instale e inicie os serviços **Apache** e **MySQL**

**Passo 2 — Copiar os arquivos**
1. Extraia o arquivo `sisos-completo-final.zip`
2. Copie a pasta `sisos-master` para `C:\xampp\htdocs\sisos` (Windows) ou `/opt/lampp/htdocs/sisos` (Linux)

**Passo 3 — Criar o banco de dados**
1. Acesse `http://localhost/phpmyadmin`
2. Clique em **Novo** e crie um banco chamado `sisos`
3. Selecione o banco `sisos`
4. Clique em **Importar** → selecione o arquivo `banco.sql` da pasta raiz do projeto
5. Clique em **Executar**

**Passo 4 — Configurar a conexão**
1. Abra o arquivo: `application/config/database.php`
2. Edite as linhas:
```php
$db['default']['hostname'] = 'localhost';
$db['default']['username'] = 'root';       // seu usuário MySQL
$db['default']['password'] = '';           // sua senha MySQL (padrão XAMPP = vazio)
$db['default']['database'] = 'sisos';
```

**Passo 5 — Configurar a URL base**
1. Abra o arquivo: `application/config/config.php`
2. Edite:
```php
$config['base_url'] = 'http://localhost/sisos/';
```

**Passo 6 — Permissões de pastas (Linux/Mac)**
```bash
chmod -R 777 application/logs/
chmod -R 777 assets/img/
chmod -R 777 assets/img/produtos/
chmod -R 777 assets/img/sistema/
chmod -R 777 assets/img/checklist/
```

**Passo 7 — Acessar o sistema**
1. Abra o navegador em: `http://localhost/sisos`
2. Login padrão: **admin@admin.com** / **admin**
3. ⚠️ **Troque a senha imediatamente após o primeiro acesso!**

---

### OPÇÃO B — INSTALAÇÃO EM SERVIDOR VPS / HOSPEDAGEM

**Passo 1 — Enviar os arquivos**
Use FTP (FileZilla) ou SSH para enviar os arquivos para o servidor:
```bash
# Via SCP (SSH)
scp -r sisos-master/ usuario@seuservidor.com:/var/www/html/sisos/
```
Ou use o gerenciador de arquivos do painel de controle (cPanel, Plesk, etc.)

**Passo 2 — Criar banco de dados**
- No cPanel: acesse **MySQL Databases** → crie um banco e um usuário
- Importe o arquivo `banco.sql` via phpMyAdmin

**Passo 3 — Configurar o arquivo `.htaccess`**
Verifique se o arquivo `.htaccess` na raiz está assim:
```apache
<IfModule mod_rewrite.c>
    RewriteEngine On
    RewriteBase /sisos/
    RewriteCond %{REQUEST_FILENAME} !-f
    RewriteCond %{REQUEST_FILENAME} !-d
    RewriteRule ^(.*)$ index.php/$1 [L]
</IfModule>
```
> Se o sistema estiver na raiz do domínio, mude `RewriteBase /sisos/` para `RewriteBase /`

**Passo 4 — Configurar database.php e config.php**
```php
// database.php
$db['default']['hostname'] = 'localhost';
$db['default']['username'] = 'usuario_do_banco';
$db['default']['password'] = 'senha_do_banco';
$db['default']['database'] = 'nome_do_banco';

// config.php
$config['base_url'] = 'https://seudominio.com.br/';
```

**Passo 5 — Permissões**
```bash
chmod -R 755 /var/www/html/sisos/
chmod -R 777 /var/www/html/sisos/application/logs/
chmod -R 777 /var/www/html/sisos/assets/img/
```

---

### OPÇÃO C — INSTALAÇÃO VIA DOCKER (mais fácil)

**Passo 1 — Instalar Docker**
- Windows/Mac: instale o Docker Desktop em https://www.docker.com/products/docker-desktop
- Linux: `sudo apt install docker.io docker-compose`

**Passo 2 — Executar o projeto**
```bash
cd sisos-master
docker-compose up -d
```

**Passo 3 — Acessar**
- Sistema: `http://localhost:8080`
- phpMyAdmin: `http://localhost:8081`
- Login padrão: **admin@admin.com** / **admin**

---

### PÓS-INSTALAÇÃO — CONFIGURAÇÕES OBRIGATÓRIAS

Após o primeiro acesso, vá em **Configurações** e faça:

1. **Gerais**: altere o nome do sistema, faça upload da logo e favicon
2. **Emitente**: preencha os dados da sua empresa (CNPJ, endereço, etc.)
3. **Financeiro**: configure as categorias de receita e despesa
4. **Atualizar Banco**: vá em **Configurações → Atualizações → Atualizar Banco** para rodar todas as migrations das melhorias

---

### PROBLEMAS COMUNS

| Problema | Solução |
|---|---|
| Tela em branco | Verifique `application/logs/` — habilite `display_errors` no PHP |
| Erro 404 nas páginas | Verifique se o `mod_rewrite` está ativo no Apache |
| Erro de conexão com banco | Confira as credenciais em `database.php` |
| Imagens não aparecem | Verifique permissões das pastas `assets/img/` |
| Sessão expirando | Aumente `sess_expiration` em `config.php` |

---

## ═══════════════════════════════════════════════
## PARTE 2 — CHANGELOG COMPLETO DE MELHORIAS
## ═══════════════════════════════════════════════

Todas as melhorias implementadas desde o projeto original (Sisos) até a versão SISOS atual.

---

### BLOCO 1 — INTEGRAÇÃO DE API E NOTA FISCAL

**API Focus NF-e (gratuita)**
- Library `FocusNfe.php` com emissão, consulta e cancelamento de NF-e
- Controller `Notafiscal.php` com rotas para emitir via OS e Venda
- Nova aba "Nota Fiscal" nas Configurações: token, ambiente (homologação/produção), CNPJ emitente, natureza da operação
- Botão "Emitir NF-e" aparece nas telas de OS e Vendas quando módulo ativo
- Links diretos para DANFE (PDF) e XML da nota
- Migration criada para adicionar configurações no banco

---

### BLOCO 2 — CONFIGURAÇÕES DO SISTEMA

**Logo e Favicon personalizáveis**
- Upload de logo (PNG/JPG/SVG, até 2MB) via aba Gerais
- Upload de favicon (PNG/ICO, até 2MB) via aba Gerais
- Logo personalizada exibida no menu lateral e portal do cliente
- Favicon dinâmico na aba do navegador

**Renomeação: MAPOS → SISOS / RAMON → RAFAEL**
- Substituição global em todos os arquivos PHP, CSS, JS e HTML
- Rodapé, login, portal do cliente, e-mails, títulos e créditos
- Token CSRF renomeado: `MAPOS_TOKEN` → `SISOS_TOKEN`
- Repositório GitHub atualizado: `RamonSilva20/sisos` → `Rafaelpontara/sisos`

---

### BLOCO 3 — RELATÓRIOS

**Novos filtros nos relatórios**
- **OS**: campo "Descrição / Defeito" (busca em `os.descricao` e `os.defeito`) e "Equipamento / Referência" (busca em `equipamento` e `numeroSerie`)
- **Vendas**: campo "Descrição / Referência" (busca em `observacoes`)
- **Financeiro**: campo "Cliente / Fornecedor" com autocomplete + campo "Descrição / Referência"
- Controllers e Models atualizados para receber e filtrar os novos parâmetros via GET

---

### BLOCO 4 — ORDENS DE SERVIÇO

**Pesquisa por número**
- Campo "Nº OS" na listagem — busca exata pelo `idOs`

**Novos status**
- Adicionados em listagem, editar OS e configurações: Recusado, Aguardando Autorização, Não foi Possível, Sem Conserto, Não temos Peças, Em Teste

**Data Final condicional**
- Label com asterisco (*) e validação jQuery aparecem somente quando status = "Em Andamento"

**Situação Financeira separada do Status**
- Novo campo "Situação Financeira": Pendente / Parcialmente Pago / Pago / Isento
- A OS pode estar "Em Andamento" e "Pago" simultaneamente

**Campo Data de Retirada**
- Separado da Data Final — registra quando o cliente retirou o equipamento

**Checklist de Entrada**
- Nova aba na abertura de OS com 12 itens padrão configuráveis
- Campo de observações livres
- Upload de até 4 fotos do equipamento na entrada (armazenadas em `assets/img/checklist/`)
- Tudo salvo em JSON na OS

**OS Recorrente**
- Nova aba "Recorrência" com periodicidade: mensal, bimestral, trimestral, semestral, anual
- Campo de data da próxima execução
- Campos `is_recorrente`, `recorrencia_tipo` e `recorrencia_proxima` no banco

**OS Retorno em Garantia**
- Botão "Retorno/Garantia" na visualização — abre nova OS vinculada à original via `os_origem_id`

**Cliente rápido na OS**
- Botão "+ Novo Cliente" com modal de cadastro rápido (nome, telefone, CPF) sem sair da OS
- Método `adicionarRapido()` no controller de Clientes
- Método `autoCompleteCliente()` para busca por nome/CPF/telefone

---

### BLOCO 5 — CLIENTES

**Bloqueio de cliente**
- Badge "BLOQUEADO" em vermelho na listagem
- Botão de cadeado: bloquear com campo de motivo obrigatório ou desbloquear
- Ao tentar abrir OS para cliente bloqueado: redireciona com mensagem de erro e motivo

**TAGs de identificação**
- Estrutura criada no banco: `cliente_tags` e `clientes_tags` (pivot)
- Tags padrão: Bronze, Prata, Ouro, VIP, Contrato, Inadimplente (com cores)
- Pronto para exibição e atribuição via interface

---

### BLOCO 6 — PRODUTOS

**Cadastro expandido**
- **Foto do produto**: upload com preview em tempo real, armazenada em `assets/img/produtos/`
- **Marca** e **Modelo**
- **Localização no estoque** (ex: "Prateleira A3, Gaveta 2")
- **Categoria** via dropdown hierárquico (Grupo → Subcategoria)
- **Garantia em dias** (0 = sem garantia)
- **NCM** para uso em NF-e
- **Observações** livres
- Campos disponíveis em adicionar e editar produto

**Estoque decimal**
- Campo `estoque` alterado para `DECIMAL(10,3)` — suporta frações

---

### BLOCO 7 — CONTROLE DE ESTOQUE

**Tabela de movimentações (`estoque_movimentacoes`)**
- Campos: produto, tipo (entrada/saida), origem (compra/venda/os/avaria/ajuste/inventario), ID da origem, quantidade, estoque antes, estoque depois, usuário, data/hora

**Registros automáticos**
- Estoque inicial ao cadastrar produto
- Entrada automática ao receber itens de compra vinculados a produto
- Saída automática ao vender produto (PDV e venda normal)

**Inventário** (`/estoque/inventario`)
- Cards: total de produtos, abaixo do mínimo, estoque negativo, valor total
- Tabela com entradas, saídas e estoque atual por produto
- Alerta visual para produtos abaixo do mínimo
- Botão de ajuste manual com modal
- Botão de histórico por produto (via AJAX)

**Movimentações** (`/estoque/movimentacoes`)
- Listagem completa com filtros: produto, tipo, origem, período
- Paginação

**Venda sem estoque configurável**
- Opções: Bloquear (padrão) / Permitir com aviso / Permitir silenciosamente
- Configurável em Configurações → Produtos

---

### BLOCO 8 — COMPRAS E SAÍDAS

**Módulo de Compras** (`/compras`)
- Controller, Model e Views completos
- Campos: descrição, fornecedor/cliente, datas, valor total, valor pago, forma de pagamento, status, nota fiscal, observações
- Status: pendente, parcialmente pago, pago, cancelado
- Itens da compra com busca de produto (autocomplete) e entrada automática no estoque

**Saídas de Estoque** (`/compras/saidas`)
- Registra saídas manuais: avaria, uso interno, devolução, ajuste, vencimento
- Baixa automática do estoque com movimentação registrada

**Menu lateral**: item "Compras" e item "Estoque" adicionados

---

### BLOCO 9 — FINANCEIRO

**Dashboard Financeiro** (`/financeiro/dashboard`)
- 4 cards coloridos: Receitas Pagas, Despesas Pagas, Saldo Líquido, Total Pendente
- Gráfico de barras (Chart.js): Rec. Pagas, Desp. Pagas, Rec. Pendentes, Desp. Pendentes, Saldo
- Painel de estatísticas com todos os totais
- Navegação por mês/ano com setas e selects
- Filtro por tipo: Todos / Receitas / Despesas
- Tabela de lançamentos com tipo, categoria, vencimento, status, forma de pagamento, subtotal, desconto e total
- Botões "Nova Receita" e "Nova Despesa"

**Categorias Hierárquicas** (Configurações → Categorias de Despesa/Receita)
- Grupos + Subcategorias (árvore 2 níveis)
- CRUD completo via modal AJAX: adicionar grupo, adicionar subcategoria, editar, excluir
- Categorias padrão de despesa: Conta da Empresa, Financeiro, Operacionais, Pessoal, Impostos, Avarias/Perdas
- Categorias padrão de receita: Serviços, Vendas, Contratos

---

### BLOCO 10 — NOTA PROMISSÓRIA

**Impressão de Nota Promissória** (`/vendas/imprimirPromissoria/{id}`)
- Layout profissional em 190mm × 90mm
- Valor por extenso automático (até 999.999,99)
- Campos: nome do devedor, CPF/CNPJ, endereço, referência da venda, data de emissão, vencimento
- 4 campos de assinatura: devedor, credor, 2 testemunhas
- Impressão direta pelo navegador
- Botão "Promissória" na tela de visualizar Venda

---

### BLOCO 11 — PORTAL DO CLIENTE (CONECTE)

**Melhorias**
- Menu do portal com novo item "Abrir OS" — cliente abre solicitação sem ligar
- Logo personalizada exibida no portal (usa a logo configurada no sistema)
- Método `adicionarOs()` já existente no controller Mine — fluxo completo funcional

---

### BLOCO 12 — PDV (PONTO DE VENDA)

**Módulo PDV** (`/pdv`) — opcional, ativado em Configurações → Produtos → Módulo PDV

**Interface**
- Layout full-screen dividido: grade de produtos (esquerda) + carrinho (direita)
- Busca de produto por texto (com debounce 250ms) e por código de barras (Enter ou leitor)
- Grade visual com foto, nome, preço e estoque disponível

**Carrinho**
- Adicionar produto por clique ou leitura de código
- Ajuste de quantidade com botões +/- ou digitação direta
- Remoção individual de item
- Desconto em % ou R$ com cálculo em tempo real

**Pagamento**
- Botões de forma de pagamento: Dinheiro, PIX, Débito, Crédito
- Campo de valor recebido com cálculo automático do troco
- Finalização via AJAX com verificação de estoque

**Pós-venda**
- Modal de sucesso com total e troco
- Impressão automática de cupom não fiscal (80mm)
- Botão "Nova Venda" para zerar o caixa

**Atalhos de teclado**
- `F2` — foco na busca
- `F12` — finalizar venda
- `Esc` — cancelar/limpar

**Relatório PDV** (`/pdv/relatorio`)
- Total do dia, nº de vendas, ticket médio
- Resumo por forma de pagamento
- Tabela de vendas com link para cupom e detalhes

---

### MIGRATIONS PARA RODAR (em ordem)

Acesse **Configurações → Atualizações → Atualizar Banco** após instalar:

1. `20240601000001_add_logo_favicon_to_configuracoes`
2. `20240601000002_create_compras_saidas`
3. `20240601000003_add_compras_permissions`
4. `20240602000001_add_all_features` ← principal, adiciona todas as colunas novas

---

### CREDENCIAIS PADRÃO DO SISTEMA

| Campo | Valor |
|---|---|
| URL de acesso | `http://localhost/sisos` |
| E-mail | admin@admin.com |
| Senha | admin |
| Permissão | Administrador |

> ⚠️ Troque a senha no primeiro acesso em **Minha Conta**

---

*SISOS — Sistema de Gestão de Ordens de Serviço*
*Desenvolvido por Rafael — github.com/Rafaelpontara/sisos*
