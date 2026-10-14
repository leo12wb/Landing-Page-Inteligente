# DevFlow — Landing Page Inteligente

Projeto de portfólio técnico: landing page completa com PHP 8.2, MySQL, Docker e Tailwind CSS.

> **Aviso:** DevFlow é um produto fictício criado exclusivamente para demonstração de habilidades técnicas.

---

## O que foi construído

- Landing page responsiva com teste A/B de títulos
- Backend PHP puro (sem Laravel) em arquitetura Controller / Service / Repository / Model
- API REST para cadastro e listagem de leads
- Banco de dados MySQL com migrations versionadas
- Integração com Resend API para e-mail de confirmação
- Testes unitários e de integração com PHPUnit
- Ambiente completo em Docker Compose

---

## Requisitos

- [Docker](https://docs.docker.com/get-docker/) e [Docker Compose](https://docs.docker.com/compose/) (única dependência para rodar)

---

## Início rápido

```bash
# 1. Clone o repositório
git clone <url-do-repo>
cd Landing-Page-Inteligente

# 2. Crie o arquivo de ambiente
cp .env.example .env

# 3. Suba tudo com Docker
docker compose up --build
```

Acesse: **http://localhost:8080**

O Docker irá:
- Compilar o CSS com Tailwind (Node.js no build)
- Instalar dependências PHP com Composer
- Criar o banco de dados e executar as migrations automaticamente
- Iniciar o servidor Apache com PHP 8.2

---

## Configuração do `.env`

| Variável | Descrição | Padrão |
|----------|-----------|--------|
| `DB_PASSWORD` | Senha do MySQL | `devflow_pass` |
| `MYSQL_ROOT_PASSWORD` | Senha root do MySQL | `root_pass_change_me` |
| `ADMIN_TOKEN` | Token para `GET /api/leads` | *altere antes de usar* |
| `MAIL_ENABLED` | Habilita envio real de e-mail | `false` |
| `RESEND_API_KEY` | Chave da Resend API | vazio |
| `MAIL_FROM` | E-mail remetente verificado | — |

---

## Comandos úteis

```bash
# Subir em background
docker compose up -d --build

# Ver logs em tempo real
docker compose logs -f app

# Parar tudo
docker compose down

# Apagar banco e recriar do zero
docker compose down -v && docker compose up --build

# Executar testes unitários
docker exec devflow-app vendor/bin/phpunit --testsuite Unit

# Executar testes de integração (requer banco ativo)
docker exec devflow-app vendor/bin/phpunit --testsuite Integration

# Carregar dados de demonstração (opcional)
docker exec -i devflow-db mysql -u devflow -pdevflow_pass devflow \
  < database/seeds/demo_data.sql

# Acessar o banco MySQL
docker exec -it devflow-db mysql -u devflow -pdevflow_pass devflow
```

---

## Configurar a Resend API (e-mail real)

1. Crie uma conta em [resend.com](https://resend.com)
2. Verifique seu domínio remetente
3. Gere uma API key
4. No `.env`:
   ```
   RESEND_API_KEY=re_xxxxxxxxxxxx
   MAIL_FROM=noreply@seudominio.com
   MAIL_ENABLED=true
   ```
5. Reinicie: `docker compose up -d --build`

Quando `MAIL_ENABLED=false` (padrão), o cadastro funciona normalmente e o envio é ignorado com log informativo.

---

## Endpoints da API

| Método | Endpoint | Descrição | Auth |
|--------|----------|-----------|------|
| `POST` | `/api/leads` | Cadastra um lead | — |
| `GET`  | `/api/leads` | Lista leads (paginado) | Bearer token |
| `GET`  | `/api/health` | Health check | — |

Exemplo de cadastro:
```bash
curl -X POST http://localhost:8080/api/leads \
  -H "Content-Type: application/json" \
  -d '{"name":"Teste","email":"teste@ex.com","user_type":"developer","plan":"pro","contact_consent":true}'
```

Exemplo de listagem admin:
```bash
curl http://localhost:8080/api/leads \
  -H "Authorization: Bearer SEU_ADMIN_TOKEN"
```

---

## Estrutura do projeto

```
├── app/
│   ├── Controllers/     # Recebem requisições HTTP
│   ├── Services/        # Regras de negócio
│   ├── Repositories/    # Acesso ao banco (PDO)
│   ├── Models/          # DTOs imutáveis
│   ├── Validators/      # Validação dos dados de entrada
│   ├── Mail/            # Templates de e-mail
│   └── Support/         # Router, Database, Response, Logger
├── config/              # Configurações
├── database/
│   ├── migrations/      # SQLs versionados (executados pelo MySQL na 1ª vez)
│   └── seeds/           # Dados de demonstração (execução manual)
├── docs/                # Documentação técnica
├── public/              # Raiz pública do Apache
│   ├── index.php        # Entry point
│   └── assets/          # CSS (compilado), JS
├── routes/web.php        # Mapeamento de rotas
├── storage/logs/        # Logs da aplicação
├── tests/
│   ├── Unit/            # Testes sem dependências externas
│   └── Integration/     # Testes com banco de dados real
├── views/landing.php    # Template HTML da landing page
├── Dockerfile           # Multi-stage: Node (CSS) + PHP/Apache
└── compose.yaml         # App + MySQL
```

---

## Tecnologias

| Tecnologia | Uso |
|------------|-----|
| PHP 8.2 | Backend, API REST, servidor Apache |
| MySQL 8 | Persistência de leads |
| Tailwind CSS 3 | Estilização (build local, sem CDN em prod) |
| JavaScript | Interações, validação, fetch |
| Docker + Compose | Ambiente de desenvolvimento e build |
| PHPUnit 11 | Testes automatizados |
| Resend API | Envio de e-mail de confirmação |
| Composer | Autoload e dependências PHP |

---

## Auditoria de performance (Lighthouse)

```bash
# Com Chrome instalado
npx lighthouse http://localhost:8080 \
  --output=html \
  --output-path=./lighthouse-report.html \
  --chrome-flags="--headless"
```

Consulte `docs/performance.md` para referência de métricas e resultados.
