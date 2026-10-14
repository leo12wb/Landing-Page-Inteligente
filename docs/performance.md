# Performance — DevFlow

## Otimizações implementadas

| Área | Otimização |
|------|-----------|
| CSS | Build local do Tailwind com purge (remove classes não usadas); sem CDN em produção |
| JavaScript | Vanilla JS sem framework; arquivo único `main.js` |
| Fontes | `rel="preconnect"` para Google Fonts; `display=swap` para FOUT controlado |
| Imagens | Mockups em CSS puro — zero imagens externas na seção de funcionalidades |
| Cache | `Cache-Control: max-age=31536000, immutable` para assets estáticos com versionamento via `?v=timestamp` |
| Lazy loading | Não aplicado — não há imagens LCP que necessitem; mockups são renderizados em CSS |
| SQL | Índices em `email`, `ip_address`, `created_at`, `plan`; paginação na listagem admin |
| Composer | `--optimize-autoloader` no Dockerfile de produção |

## Como medir com Lighthouse

1. Inicie o projeto: `docker compose up --build`
2. Acesse `http://localhost:8080` no Chrome
3. Abra DevTools → aba **Lighthouse**
4. Selecione **Desktop** e **Mobile**
5. Execute a auditoria

Ou via CLI:
```bash
npx lighthouse http://localhost:8080 --output=html --output-path=./lighthouse-report.html
```

## Métricas alvo (Core Web Vitals)

| Métrica | Meta |
|---------|------|
| LCP     | ≤ 2,5s |
| INP     | ≤ 200ms |
| CLS     | ≤ 0,1 |

## Resultados

> Métricas reais devem ser medidas após o build e registradas aqui.
> Não foram fabricadas pontuações Lighthouse nesta documentação.
>
> Para registrar: execute o Lighthouse, copie os valores reais e atualize esta seção.

| Métrica      | Resultado | Data | Ambiente |
|--------------|-----------|------|----------|
| Performance  | —         | —    | —        |
| Accessibility| —         | —    | —        |
| Best Practices| —        | —    | —        |
| SEO          | —         | —    | —        |
| LCP          | —         | —    | —        |
| CLS          | —         | —    | —        |
