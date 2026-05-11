# SISOS — Sistema de Ordens de Serviço

![version](https://img.shields.io/badge/version-4.53.2-blue.svg?longCache=true&style=flat-square)
![license](https://img.shields.io/badge/license-Apache-green.svg?longCache=true&style=flat-square)
![theme](https://img.shields.io/badge/theme-Matrix--Admin-lightgrey.svg?longCache=true&style=flat-square)
![issues](https://img.shields.io/github/issues/Rafaelpontara/sisOS.svg?longCache=true&style=flat-square)
![contributors](https://img.shields.io/github/contributors/Rafaelpontara/sisOS.svg?longCache=true&style=flat-square)

### Contato: techcelbalsas@gmail.com
### [Feedback](https://github.com/Rafaelpontara/sisOS/discussions) - Vote ou sugira melhorias

---

## O que é o SISOS?

O **SISOS** é um sistema web open source para **gerenciamento de ordens de serviço**, desenvolvido para assistências técnicas, oficinas e prestadores de serviço. Controle clientes, OS, estoque, financeiro, cobranças, compras e muito mais em um único sistema.

---

## 🤖 IA Multi-Provedor

O SISOS possui integração nativa com **múltiplos provedores de Inteligência Artificial**, configuráveis diretamente no painel em **Configurações → IA / Assistente**.

### Provedores suportados:

| Provedor | Modelos disponíveis |
|---|---|
| 🔵 **Google Gemini** | gemini-2.5-flash, gemini-2.0-flash, gemini-1.5-flash e outros |
| 🟢 **ChatGPT (OpenAI)** | gpt-4o, gpt-4o-mini, gpt-4-turbo, gpt-3.5-turbo |
| 🟠 **Claude (Anthropic)** | claude-opus-4-6, claude-sonnet-4-6, claude-haiku-4-5 |
| 🔴 **Perplexity AI** | sonar-small, sonar-large, sonar-huge |
| 🟣 **DeepSeek** | deepseek-chat, deepseek-reasoner |
| ⚪ **Mistral AI** | mistral-small, mistral-medium, mistral-large |

### Funcionalidades da IA:

- 🔧 **Sugestão de diagnóstico em OS** — sugere diagnósticos ao abrir/editar uma ordem de serviço
- 📧 **Rascunho de e-mail ao cliente** — gera e-mail automático para comunicar o cliente
- 💬 **Assistente para funcionários** — chat interno com IA para tirar dúvidas
- 📊 **Análise de relatórios e gestão** — analisa dados e sugere melhorias para o negócio

Para configurar, acesse **Configurações → IA / Assistente**, selecione o provedor desejado, insira a chave de API e salve.

---

## Requerimentos

- PHP >= 8.2 (recomendado 8.4)
- Extensões PHP: `cURL`, `MySQLi`, `GD`, `zip`
- MySQL >= 5.7 ou >= 8.0
- Composer >= 2

---

## Instalação Manual

1. Faça o download dos arquivos pela [página de releases](https://github.com/Rafaelpontara/sisOS/releases) ou clone o repositório:
```bash
git clone https://github.com/Rafaelpontara/sisOS.git
```

2. Copie os arquivos para a pasta do seu servidor web:
   - **Windows (XAMPP):** `C:\xampp\htdocs\sisos`
   - **Linux:** `/var/www/html/sisos`

3. *(Somente XAMPP)* Ative o `mod_rewrite` no Apache — abra `C:\xampp\apache\conf\httpd.conf`, localize `#LoadModule rewrite_module` e remova o `#`. Reinicie o Apache.

4. Na raiz do projeto, instale as dependências via Composer:
```bash
cd sisos
composer install --no-dev
```
> As dependências serão instaladas em `application/vendor/`.

4. Acesse o assistente de instalação no navegador:
   - **Windows (XAMPP):** `http://localhost/sisos/install/`
   - **Linux:** `http://seudominio.com/sisos/install/`

5. Preencha as informações do banco de dados, usuário administrador e URL do sistema e clique em **Instalar**.

6. Após a instalação, configure o e-mail em **Configurações → Sistema → E-mail**.

7. *(Opcional)* Configure os cron jobs para envio de e-mail automático:
```
# Enviar e-mails pendentes a cada 2 minutos
*/2 * * * * php /var/www/html/sisos/index.php email/process

# Enviar e-mails com falha a cada 5 minutos
*/5 * * * * php /var/www/html/sisos/index.php email/retry
```
> ⚠️ Ajuste o caminho conforme seu ambiente.

---

## Instalação via Docker

1. Faça o download ou clone o repositório.

2. Instale o [Docker](https://docs.docker.com/install/) e o [Docker Compose](https://docs.docker.com/compose/install/).

3. Entre na pasta `docker` e execute:
```bash
docker-compose up --force-recreate
```

4. Acesse `http://localhost:8000/` e siga o assistente com as configurações:
```
Host:           mysql
Usuário:        sisos
Senha:          sisos
Banco de Dados: sisos
URL:            http://localhost:8000/
```

5. Configure o e-mail em **Configurações → Sistema → E-mail**.

> ⚠️ A pasta `docker/data` contém os dados do MySQL — não a delete ou perderá o banco.
> O PhpMyAdmin fica disponível em `http://localhost:8080/`.

---

## Atualização

### Manual

1. Faça backup dos arquivos e banco em **Configurações → Backup**.
2. Salve as pastas `anexos`, `arquivos`, `uploads`, `userimage` de dentro de `assets/`.
3. Salve o arquivo `application/.env`.
4. Substitua os arquivos pela nova versão.
5. Execute `composer install --no-dev`.
6. Restaure os backups nos locais originais.
7. Acesse **Configurações → Sistema** e clique em **Atualizar Banco de Dados**.

> Também é possível atualizar o banco via terminal:
> ```bash
> php index.php tools migrate
> ```

### Via Docker

1. Pare o Docker.
2. Faça backup conforme acima.
3. Substitua os arquivos.
4. Execute `docker-compose up --force-recreate` na pasta `docker`.
5. Clique em **Atualizar Banco de Dados** nas configurações.

### Via Sistema

1. Acesse **Configurações → Sistema** e clique em **Atualizar Sisos**.
2. Todos os arquivos serão atualizados automaticamente, exceto `config.php`, `database.php` e `email.php`.

---

## Comandos de Terminal

Para listar todos os comandos disponíveis, execute na raiz do projeto:
```bash
php index.php tools
```

---

## Hospedagem Parceira

A **SysGO** oferece hospedagem de qualidade e suporte personalizado com custo justo e confiabilidade.

[Solicite sua hospedagem aqui!](https://sysgo.com.br/sisos)

<p><img src="https://sysgo.com.br" alt="SysGO - SISOS Cloud Hosting" style="width:50%;"></p>

---

## Frameworks e Bibliotecas

- [bcit-ci/CodeIgniter](https://github.com/bcit-ci/CodeIgniter)
- [twbs/bootstrap](https://github.com/twbs/bootstrap)
- [jquery/jquery](https://github.com/jquery/jquery)
- [jquery/jquery-ui](https://github.com/jquery/jquery-ui)
- [mpdf/mpdf](https://github.com/mpdf/mpdf)
- [Matrix Admin](http://wrappixel.com/demos/free-admin-templates/matrix-admin/index.html)
- [filp/whoops](https://github.com/filp/whoops)
- [ezyang/htmlpurifier](https://github.com/ezyang/htmlpurifier)

---


---

## Contribuidores

[![Contribuidores](https://contrib.rocks/image?repo=Rafaelpontara/sisOS)](https://github.com/Rafaelpontara/sisOS/graphs/contributors)

---

## Autor

| [<img src="https://avatars.githubusercontent.com/Rafaelpontara?s=115"><br><sub>Rafael Pontara</sub>](https://github.com/Rafaelpontara) |
| :---: |
