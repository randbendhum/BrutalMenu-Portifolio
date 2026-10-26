# Neobrutalist Portfolio Main Menu — Laravel 11 + MySQL 8 + Docker (Oracle ARM Ready)

Um site de portfólio no estilo **Neobrutalista** (fundo creme `#FFF4E0`, acentos em amarelo `#FFD23F`, rosa `#FF6B9D` e azul ciano `#4CC9F0`, bordas pretas grossas e sombras sólidas), projetado como o **Menu Principal** interativo do seu portfólio.

Construído com:
- **PHP 8.3 & Laravel 11**
- **MySQL 8.0** (projetos + caixa de entrada de mensagens de contato)
- **CSS Grid & Flexbox Puro** (`public/css/` — zero Tailwind, zero etapa de build pesada)
- **Docker Multi-Arch (`amd64` + `arm64`)** pronto para **Oracle Cloud Ampere A1 ARM** + HTTPS automático via **Caddy**

---

## 1. Como Rodar Localmente (Docker)

Basta ter o [Docker Desktop](https://www.docker.com/products/docker-desktop/) instalado e rodar:

```bash
docker compose up -d --build
```

O container `app` (`docker/php/entrypoint.sh`) faz **tudo sozinho** na primeira inicialização:
1. Cria o arquivo `.env` a partir do `.env.example` (se não existir)
2. Instala as dependências do Composer (`vendor/`)
3. Gera a `APP_KEY` do Laravel
4. Aguarda o MySQL ficar pronto, roda as migrations (`php artisan migrate`) e popula os projetos iniciais (`php artisan db:seed`)

Acesse:
- **Site (Menu Principal):** http://localhost:8080
- **Painel Admin (Adicionar/Editar Projetos e Ler Mensagens):** http://localhost:8080/admin
  - Usuário padrão: `admin`
  - Senha padrão: `changeme123` *(altere no `.env` antes de ir para produção!)*

---

## 2. Como Hospedar na sua VM Oracle Cloud ARM + Seu Domínio

A arquitetura Docker usa imagens oficiais multi-arquitetura (`linux/arm64/v8`), funcionando nativamente nas instâncias **Ampere A1 ARM** da Oracle Cloud.

### Passo 1 — Liberar Portas 80 e 443 no Painel da Oracle Cloud
1. No painel da Oracle Cloud, vá em **Networking → Virtual Cloud Networks (VCN) → sua VCN → Subnets → Default Security List**.
2. Adicione uma **Ingress Rule** para `0.0.0.0/0`, protocolo **TCP**, Destination Port Range: `80, 443` (e opcionalmente **UDP** `443` para HTTP/3).

### Passo 2 — Apontar o DNS do Seu Domínio
No painel onde você comprou o domínio (Registro.br, Cloudflare, Namecheap, etc.), crie dois registros **Tipo A** apontando para o **IP Público** da sua VM Oracle:
- `@` → `SEU_IP_PUBLICO_ORACLE`
- `www` → `SEU_IP_PUBLICO_ORACLE`

*(Se usar Cloudflare, você pode deixar com proxy desativado "DNS Only" para o Caddy gerar o certificado Let's Encrypt automático, ou com proxy ativado no modo SSL "Full").*

### Passo 3 — Rodar o Script Automático na VM Oracle ARM
Conecte via SSH na sua VM Ubuntu ARM da Oracle e rode:

```bash
git clone <URL_DO_SEU_REPOSITORIO> portfolio
cd portfolio

# Edite o .env.example ou crie seu .env com sua senha do Admin e seus dados:
cp .env.example .env
nano .env

# Dê permissão e execute o instalador passando o seu domínio:
chmod +x deploy-oracle-arm.sh
./deploy-oracle-arm.sh seudominio.com.br
```

O script [`deploy-oracle-arm.sh`](deploy-oracle-arm.sh) faz automaticamente:
1. Instala o Docker e Docker Compose para ARM64 (caso ainda não estejam instalados).
2. **Desbloqueia as portas 80 e 443 no `iptables` nativo do Ubuntu da Oracle** (que bloqueia conexões HTTP/HTTPS por padrão mesmo com a Security List aberta).
3. Configura `DOMAIN=seudominio.com.br` e `APP_URL=https://seudominio.com.br` no `.env`.
4. Sobe `docker-compose.yml` + `docker-compose.prod.yml` com o **Caddy** gerando HTTPS gratuito (Let's Encrypt) automaticamente!

> **Quer testar antes de comprar o domínio (usando só o IP da VM)?**
> Basta rodar `./deploy-oracle-arm.sh` sem argumentos. Ele subirá em `http://SEU_IP_ORACLE` na porta 80!

---

## 3. Como Colocar Seus Projetos e Editar Seus Dados Depois

Você tem **duas formas super práticas** de personalizar tudo:

### A) Adicionar / Editar Projetos pelo Navegador (`/admin`)
Não precisa mexer em código nem banco de dados para cadastrar projetos novos:
1. Acesse `https://seudominio.com.br/admin` (ou `http://localhost:8080/admin`).
2. Faça login com `ADMIN_USERNAME` e `ADMIN_PASSWORD` definidos no seu `.env`.
3. Clique em **`+ ADD NEW PROJECT`**:
   - Preencha título, resumo curto, descrição completa, tags separadas por vírgula (`PHP 8.3, Laravel 11, CSS Grid`), cor do card (`Yellow`, `Pink`, `Cyan`, `White`), link do GitHub, link do projeto ao vivo e faça upload de um print/capa!
   - Marque **`★ FEATURE ON HOME BENTO MAIN MENU`** para o projeto aparecer em destaque no Menu Principal da Home.
4. No mesmo painel `/admin`, você também lê todas as mensagens enviadas pelo formulário de **Contato** (`/contact`).

### B) Editar Nome, Bio, Links Sociais, Habilidades e Experiência
- **Edição rápida via `.env`**:
  Altere `PORTFOLIO_NAME`, `PORTFOLIO_HANDLE`, `PORTFOLIO_ROLE`, `PORTFOLIO_TAGLINE`, `PORTFOLIO_EMAIL`, `PORTFOLIO_GITHUB`, `PORTFOLIO_LINKEDIN` diretamente no arquivo `.env`.
- **Edição completa via [`config/portfolio.php`](config/portfolio.php)**:
  Abra `config/portfolio.php` para editar os textos da página **About Me**, os cards de estatísticas, as listas de tecnologias por categoria (`Front-End`, `Back-End`, `DevOps & Tools`), a linha do tempo de experiência e os itens da faixa animada (marquee).

---

## 4. Estrutura Principal do Projeto

```text
├── config/portfolio.php              # Dados do perfil, bio, skills, timeline e links sociais
├── docker/
│   ├── php/Dockerfile                # PHP 8.3-FPM multi-arch (x86_64 + ARM64) + extensões + Composer
│   ├── php/entrypoint.sh             # Bootstrap automático (composer, key, migrate, seed, storage:link)
│   └── nginx/default.conf            # Configuração Nginx FastCGI
├── docker-compose.yml                # Stack padrão (app + nginx + mysql 8.0)
├── docker-compose.prod.yml           # Override de produção com Caddy (HTTPS automático)
├── Caddyfile                         # Reverse proxy HTTPS para seu domínio
├── deploy-oracle-arm.sh              # Script de deploy 1-comando para Ubuntu ARM na Oracle Cloud
├── public/css/
│   ├── tokens.css                    # Variáveis CSS Neobrutalistas (cores, bordas, sombras)
│   ├── base.css                      # Reset, tipografia Space Grotesk & IBM Plex Mono
│   ├── components.css                # Navbar, botões, cards, tags, marquee, formulários
│   └── layout.css                    # Bento Grid do Menu Principal + layouts responsivos
└── resources/views/
    ├── layouts/app.blade.php         # Layout mestre
    ├── pages/                        # Home (Bento Menu), About, Projects, Project Detail, Contact
    └── admin/                        # Login, Dashboard e Formulário de Projetos
```

---

## 5. Rodando os Testes Automatizados

Com os containers rodando:

```bash
docker compose exec app php artisan test
```
