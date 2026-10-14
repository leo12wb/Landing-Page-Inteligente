# Arquitetura — DevFlow

## Visão geral

```
Navegador
  │  HTTP
  ▼
public/index.php          ← Entry point, carrega .env e autoload
  │
routes/web.php            ← Define mapeamento URL → Controller
  │
Router (Support)          ← Despacha para o handler correto
  │
Controllers/
  ├── LandingController   ← Serve o HTML da landing page
  ├── LeadController      ← POST /api/leads, GET /api/leads
  └── HealthController    ← GET /api/health
  │
Services/
  ├── LeadService         ← Regras de negócio (rate limit, dedup, orq.)
  ├── EmailService        ← Integração Resend API (HTTP com cURL)
  └── AbTestService       ← Atribuição e persistência de variante A/B
  │
Repositories/
  └── LeadRepository      ← SQL via PDO + prepared statements
  │
Models/
  └── Lead                ← DTO imutável de domínio
  │
Support/
  ├── Database            ← Singleton PDO
  ├── Response            ← Helpers JSON padronizados
  └── Logger              ← Log em arquivo (sem secrets)
  │
MySQL (contêiner db)
```

## Fluxo de uma requisição POST /api/leads

1. `public/index.php` despacha para `routes/web.php`
2. `Router` instancia `LeadController::store()`
3. Controller valida Content-Type e tamanho do body
4. `LeadValidator` valida e retorna erros se houver
5. `LeadService::register()` verifica rate limit e duplicidade
6. `LeadRepository::create()` persiste no MySQL com prepared statement
7. `EmailService::sendConfirmation()` envia via Resend API (falha não cancela)
8. Controller retorna JSON padronizado (`Response::json`)

## Decisões técnicas

| Decisão | Justificativa |
|---------|---------------|
| PHP puro sem framework | Escopo adequado ao nível iniciante/intermediário; demonstra o entendimento das camadas sem abstração excessiva |
| PDO com prepared statements | Proteção contra SQL injection; padrão de mercado |
| Singleton Database | Evita múltiplas conexões desnecessárias no ciclo de vida de uma requisição |
| `never` como retorno de `Response::json` | Garante que o fluxo termina após qualquer resposta da API |
| Multi-stage Dockerfile | Imagem de produção sem Node.js; CSS compilado no build |
| Sem CSRF token na API JSON | CSRF protege formulários com cookies de sessão; a API usa Content-Type: application/json como mitigação CSRF implícita |
