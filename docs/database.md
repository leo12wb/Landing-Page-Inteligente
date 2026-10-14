# Banco de Dados — DevFlow

## Tabelas

### `leads`

Armazena os cadastros de interesse do formulário.

| Coluna                  | Tipo                              | Descrição |
|-------------------------|-----------------------------------|-----------|
| id                      | BIGINT UNSIGNED AUTO_INCREMENT PK | ID interno |
| public_id               | CHAR(16) UNIQUE                   | ID exposto na API (hex aleatório) |
| name                    | VARCHAR(100)                      | Nome do lead |
| email                   | VARCHAR(254) UNIQUE               | E-mail (lowercase, único) |
| user_type               | ENUM(freelancer, developer, team) | Perfil |
| plan                    | ENUM(starter, pro, team)          | Plano de interesse |
| ab_variant              | ENUM(A, B)                        | Variante do teste A/B apresentada |
| ip_address              | VARCHAR(45)                       | IPv4/IPv6 para rate limiting |
| marketing_consent       | TINYINT(1)                        | Consentimento de marketing (opcional) |
| marketing_consent_at    | DATETIME                          | Timestamp do consentimento |
| email_status            | ENUM(pending, sent, failed, skipped) | Estado do envio de e-mail |
| created_at              | DATETIME DEFAULT NOW()            | Criação |
| updated_at              | DATETIME ON UPDATE NOW()          | Atualização |

**Índices:** public_id (UNIQUE), email (UNIQUE), created_at, plan, user_type, ip_address, email_status

**Decisão sobre duplicidade de e-mail:** um novo cadastro com e-mail já existente retorna HTTP 409. Os dados anteriores não são sobrescritos.

---

### `ab_events`

Registra visualizações e conversões do teste A/B sem dados pessoais.

| Coluna      | Tipo                      | Descrição |
|-------------|---------------------------|-----------|
| id          | BIGINT UNSIGNED PK        | ID interno |
| variant     | ENUM(A, B)                | Variante |
| event_type  | ENUM(view, conversion)    | Tipo de evento |
| created_at  | DATETIME DEFAULT NOW()    | Timestamp |

**Limitação documentada:** sem deduplicação por sessão; cada page load pode gerar um `view`. Não vincula eventos a dados pessoais.
