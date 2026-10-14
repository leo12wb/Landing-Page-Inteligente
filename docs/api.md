# API — DevFlow

## Base URL

`http://localhost:8080`

---

## POST /api/leads

Cadastra um lead de interesse.

### Request

```
Content-Type: application/json
```

```json
{
  "name":              "Leonardo",
  "email":             "leo@example.com",
  "user_type":         "developer",
  "plan":              "pro",
  "contact_consent":   true,
  "marketing_consent": false,
  "ab_variant":        "A"
}
```

| Campo               | Tipo    | Obrigatório | Valores válidos                        |
|---------------------|---------|-------------|----------------------------------------|
| name                | string  | sim         | 2–100 caracteres                       |
| email               | string  | sim         | e-mail válido, máx 254 chars           |
| user_type           | string  | sim         | `freelancer`, `developer`, `team`      |
| plan                | string  | sim         | `starter`, `pro`, `team`               |
| contact_consent     | boolean | sim         | `true`                                 |
| marketing_consent   | boolean | não         | `true` / `false`                       |
| ab_variant          | string  | não         | `A` / `B` (default: `A`)               |

### Respostas

**201 — Criado com sucesso**
```json
{
  "success": true,
  "message": "Cadastro recebido com sucesso!",
  "data": { "id": "a1b2c3d4e5f60011" }
}
```

**409 — E-mail já cadastrado**
```json
{
  "success": false,
  "message": "Este e-mail já foi cadastrado.",
  "errors": {}
}
```

**422 — Dados inválidos**
```json
{
  "success": false,
  "message": "Verifique os dados informados.",
  "errors": {
    "email": "Informe um e-mail válido.",
    "contact_consent": "Você precisa aceitar os termos para prosseguir."
  }
}
```

**429 — Rate limit excedido (3 cadastros/IP/hora)**
```json
{
  "success": false,
  "message": "Muitas tentativas. Aguarde um momento e tente novamente.",
  "errors": {}
}
```

---

## GET /api/leads

Lista leads cadastrados. **Requer autenticação.**

### Headers

```
Authorization: Bearer {ADMIN_TOKEN}
```

### Query params

| Param     | Tipo   | Descrição                  |
|-----------|--------|----------------------------|
| page      | int    | Página (default: 1)        |
| per_page  | int    | Itens por página (max 100) |
| plan      | string | Filtrar por plano          |
| user_type | string | Filtrar por tipo de usuário|

### Resposta 200

```json
{
  "success": true,
  "message": "Leads obtidos com sucesso.",
  "data": {
    "items": [
      {
        "id": 1,
        "public_id": "a1b2c3d4e5f60011",
        "name": "Leonardo",
        "email": "leo@example.com",
        "user_type": "developer",
        "plan": "pro",
        "ab_variant": "A",
        "email_status": "sent",
        "created_at": "2025-01-01 10:00:00"
      }
    ],
    "meta": {
      "page": 1,
      "per_page": 20,
      "total": 42,
      "pages": 3
    }
  }
}
```

**401 — Não autorizado**
```json
{
  "success": false,
  "message": "Acesso não autorizado.",
  "errors": {}
}
```

---

## GET /api/health

Verifica o estado da aplicação. Sem autenticação.

### Resposta 200

```json
{
  "status": "ok",
  "checks": { "database": "ok" },
  "version": "1.0.0"
}
```

**503 — Degradado**
```json
{
  "status": "degraded",
  "checks": { "database": "error" },
  "version": "1.0.0"
}
```
