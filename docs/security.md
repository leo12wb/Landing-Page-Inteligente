# Segurança — DevFlow

## Proteções implementadas

| Risco | Proteção |
|-------|----------|
| SQL injection | PDO com prepared statements em todas as queries |
| XSS | `htmlspecialchars()` em toda saída HTML; Content-Type: application/json na API |
| Exposição de erros | `display_errors=0`; handler global de exceções sem stack trace para o usuário |
| Exposição de ID interno | public_id (hex aleatório) exposto na API; ID numérico nunca retornado |
| Rate limiting | Máx. 3 cadastros/IP/hora (via tabela de leads + ip_address) |
| Força bruta no admin | `hash_equals()` para comparação do ADMIN_TOKEN (constant-time) |
| Secrets em código | Todas as credenciais exclusivamente via variáveis de ambiente |
| Cabeçalhos HTTP | X-Content-Type-Options, X-Frame-Options, Referrer-Policy, X-XSS-Protection |
| Logs | Campos sensíveis redacted antes de logar; sem dados pessoais desnecessários |
| Usuário MySQL | Privilege mínimo: SELECT, INSERT, UPDATE na base `devflow` |

## Variáveis de ambiente obrigatórias

Nunca commitar o `.env` real. Use `.env.example` como referência.

```
ADMIN_TOKEN — deve ser um valor aleatório seguro (ex: openssl rand -hex 32)
DB_PASSWORD — não use a senha padrão em produção
RESEND_API_KEY — obtida em https://resend.com
```

## Limitações conhecidas

- Rate limiting é por IP; pode ser driblado com rotação de IPs (mitigação proporcional ao escopo do projeto).
- Sem HTTPS no ambiente local Docker (Apache sem TLS). Em produção, use nginx reverse proxy com Let's Encrypt.
- Sem proteção honeypot/CAPTCHA (proporcional ao projeto de portfólio).

## LGPD / Privacidade

- Os dados coletados (nome, e-mail, perfil, plano) são usados exclusivamente para demonstração técnica.
- Não há finalidade comercial.
- O visitante é informado claramente que o produto é fictício.
- Consentimento explícito é exigido antes de armazenar os dados.
- Consentimento de marketing é opcional e separado do consentimento para contato.
