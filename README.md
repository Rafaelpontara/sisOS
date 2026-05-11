
![SISOS](https://raw.githubusercontent.com/Rafaelpontara/sisOS/main/assets/img/logo.png)

![version](https://img.shields.io/badge/version-4.53.2-blue.svg?longCache=true&style=flat-square)
![license](https://img.shields.io/badge/license-Apache-green.svg?longCache=true&style=flat-square)
![theme](https://img.shields.io/badge/theme-Matrix--Admin-lightgrey.svg?longCache=true&style=flat-square)
![issues](https://img.shields.io/github/issues/Rafaelpontara/sisOS.svg?longCache=true&style=flat-square)
![contributors](https://img.shields.io/github/contributors/Rafaelpontara/sisOS.svg?longCache=true&style=flat-square)

### Contato: contato@sisos.com.br
### [Feedback](https://github.com/Rafaelpontara/sisOS/discussions) - Vote ou sugira melhorias

![SISOS Dashboard](https://raw.githubusercontent.com/Rafaelpontara/sisOS/main/docs/dashboard.png)

---

## O que é o SISOS?

O **SISOS** é um sistema web open source para **gerenciamento de ordens de serviço**, desenvolvido para assistências técnicas, oficinas e prestadores de serviço. Controle clientes, OS, estoque, financeiro, cobranças, compras e muito mais em um único sistema.

---

### Apoie o Projeto SISOS

O **SISOS** é um projeto open source mantido com muito esforço, dedicação e tempo.
Se ele te ajuda no dia a dia, considere apoiar o desenvolvimento para que o sistema continue evoluindo, recebendo melhorias, correções e novos recursos.

**Faça uma doação:** https://donate.sisos.com.br

Toda contribuição, independente do valor, faz a diferença. Obrigado por apoiar o SISOS!

---

### Comunidade no WhatsApp

Participe da comunidade oficial do **SISOS** no WhatsApp para tirar dúvidas, trocar experiências e acompanhar novidades do projeto:

**Entre na comunidade:** https://chat.whatsapp.com/GVSg8tPQzXy0grfYpRfQps

---

### Manutenção do Projeto

O **SISOS** é um projeto de código aberto **mantido e desenvolvido pela empresa [MountBit](https://mountbit.com.br)**, responsável pela sua evolução contínua, correções e apoio à comunidade.

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

## Instalação

### Instalação Manual

1. Faça o download dos arquivos.
2. Extraia o pacote e copie para seu webserver.
3. Rode o comando `composer install --no-dev` a partir da raiz do projeto.
4. Acesse sua URL e inicie a instalação pelo assistente.
5. Configure o e-mail de envio em **Configurações → Sistema → E-mail**.
6. Configure os cron jobs para envio de e-mail:

```
# Enviar e-mails pendentes a cada 2 minutos
*/2 * * * * php /var/www/index.php email/process

# Enviar e-mails com falha a cada 5 minutos
*/5 * * * * php /var/www/index.php email/retry
```
> O path `/var/www/` deve ser ajustado conforme seu ambiente.

---

### Instalação via Docker

1. Faça o download dos arquivos.
2. Instale o [Docker](https://docs.docker.com/install/) e o [Docker Compose](https://docs.docker.com/compose/install/).
3. Entre na pasta `docker` e rode `docker-compose up --force-recreate`.
4. Acesse `http://localhost:8000/` e inicie a instalação com as configurações abaixo:

```
Host: mysql
Usuário: sisos
Senha: sisos
Banco de Dados: sisos
URL: http://localhost:8000/
```

5. Configure o e-mail em **Configurações → Sistema → E-mail**.

> A pasta `docker/data` contém os dados do MySQL — não a delete.
> O PhpMyAdmin fica disponível em `http://localhost:8080/`.

---

### Instalação Automatizada

#### Windows 10/11
1. Abra o Prompt de Comando ou PowerShell como Administrador.
2. Execute:
```powershell
PowerShell -command "& { iwr https://raw.githubusercontent.com/Rafaelpontara/sisOS/main/install.bat -OutFile SISOS_Install.bat }; .\SISOS_Install.bat"
```
3. Siga as instruções na tela.

#### Linux (Ubuntu/Debian)
1. Abra o terminal ou acesse via SSH.
2. Execute:
```bash
curl -o SISOS_Install.sh -L https://raw.githubusercontent.com/Rafaelpontara/sisOS/main/install.sh && chmod +x SISOS_Install.sh && ./SISOS_Install.sh
```
3. Siga as instruções na tela.

---

## Atualização

### Manual
1. Faça backup dos arquivos e do banco de dados em **Configurações → Backup**.
2. Copie as pastas `anexos`, `arquivos`, `uploads`, `userimage` de dentro de `Assets`.
3. Copie o arquivo `application/.env`.
4. Substitua os arquivos pela nova versão.
5. Rode `composer install --no-dev`.
6. Restaure os backups.
7. Acesse **Configurações → Sistema** e clique em **Atualizar Banco de Dados**.

### Via Docker
1. Pare o Docker.
2. Faça backup conforme acima.
3. Substitua os arquivos.
4. Rode `docker-compose up --force-recreate` na pasta `docker`.
5. Clique em **Atualizar Banco de Dados** nas configurações.

### Via Sistema
1. Atualize manualmente para a versão v4.4.0 ou superior.
2. Acesse **Sistema → Configurações** e clique em **Atualizar Sisos**.
3. Todos os arquivos serão atualizados automaticamente, exceto `config.php`, `database.php` e `email.php`.

---

## Comandos de Terminal

Para listar todos os comandos disponíveis, execute a partir da raiz do projeto:
```bash
php index.php tools
```

---

## Hospedagem Parceira

Em parceria com o Projeto SISOS, a **SysGO** oferece hospedagem de qualidade e suporte personalizado com custo justo e confiabilidade.

[Solicite sua hospedagem aqui!](https://sysgo.com.br/sisos)

<p><img src="https://sysgo.com.br/img-externo/sisos-github.jpg" alt="SysGO - SISOS Cloud Hosting" style="width:50%;"></p>

---

## Frameworks e Bibliotecas

* [bcit-ci/CodeIgniter](https://github.com/bcit-ci/CodeIgniter)
* [twbs/bootstrap](https://github.com/twbs/bootstrap)
* [jquery/jquery](https://github.com/jquery/jquery)
* [jquery/jquery-ui](https://github.com/jquery/jquery-ui)
* [mpdf/mpdf](https://github.com/mpdf/mpdf)
* [Matrix Admin](http://wrappixel.com/demos/free-admin-templates/matrix-admin/index.html)
* [filp/whoops](https://github.com/filp/whoops)
* [ezyang/htmlpurifier](https://github.com/ezyang/htmlpurifier)

---

## Requerimentos

* PHP >= 8.4
* MySQL >= 5.7 ou >= 8.0
* Composer >= 2

---

## Estrelas

[![Estrelas](https://api.star-history.com/svg?repos=Rafaelpontara/sisOS&type=Date)](https://star-history.com/#Rafaelpontara/sisOS&Date)

---

## Contribuidores

[![Contribuidores](https://contrib.rocks/image?repo=Rafaelpontara/sisOS)](https://github.com/Rafaelpontara/sisOS/graphs/contributors)

---

## Autor

| [<img src="https://avatars.githubusercontent.com/Rafaelpontara?s=115"><br><sub>Rafael Pontara</sub>](https://github.com/Rafaelpontara) |
| :---: |
