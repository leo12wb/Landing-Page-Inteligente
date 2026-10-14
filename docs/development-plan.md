# Plano de Desenvolvimento — DevFlow

## Status geral

| Etapa | Status |
|-------|--------|
| Etapa 1 — Fundação | ✅ Concluída |
| Etapa 2 — Landing page | ✅ Concluída |
| Etapa 3 — Backend | ✅ Concluída |
| Etapa 4 — Integrações | ✅ Concluída |
| Etapa 5 — Qualidade | ✅ Concluída |
| Etapa 6 — Performance e entrega | 🔄 Parcial (Lighthouse pendente de execução manual) |

## Funcionalidades implementadas

- [x] Landing page responsiva (mobile-first)
- [x] Header fixo com menu mobile
- [x] Seção Hero com teste A/B de títulos
- [x] Seção de benefícios (6 cards)
- [x] Seção de funcionalidades (4 mockups CSS)
- [x] Seção "Como funciona" (3 passos)
- [x] Planos e preços (3 cards com CTA → formulário)
- [x] Depoimentos (claramente marcados como fictícios)
- [x] FAQ com accordion acessível
- [x] Formulário de conversão com validação frontend
- [x] Footer com aviso de projeto demonstrativo
- [x] API REST: POST /api/leads (cadastro)
- [x] API REST: GET /api/leads (admin com Bearer token)
- [x] API REST: GET /api/health
- [x] Validação no backend (LeadValidator)
- [x] Persistência MySQL com migrations versionadas
- [x] Rate limiting por IP (3/hora)
- [x] Bloqueio de e-mail duplicado (HTTP 409)
- [x] Integração Resend API (com flag MAIL_ENABLED)
- [x] Teste A/B com cookie persistente 30 dias
- [x] Registro de visualizações A/B (sem dados pessoais)
- [x] Testes unitários (LeadValidator, AbTestService, LeadService)
- [x] Testes de integração (LeadApiTest)
- [x] Docker Compose (app + db)
- [x] Multi-stage Dockerfile (Node → PHP+Apache)
- [x] Cabeçalhos de segurança
- [x] Logs sem secrets/dados pessoais
- [x] Documentação (README, docs/)

## Pendências / Próximos passos

- [ ] Executar auditoria Lighthouse e registrar métricas reais em `docs/performance.md`
- [ ] Configurar Resend API com domínio verificado para habilitar envio real
- [x] Criar banco de dados de teste separado (`devflow_test`) — `database/migrations/000_create_test_database.sql`
- [x] Adicionar compressão gzip/brotli no Apache — `docker/apache.conf` + `Dockerfile`
- [ ] Implementar sitemap.xml quando houver mais de uma página
- [x] Seed expandido para demonstração do painel admin — `database/seeds/demo_data.sql` (16 leads, 7 dias de eventos A/B)
