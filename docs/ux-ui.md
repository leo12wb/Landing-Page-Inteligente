# UX/UI — DevFlow

## Decisões de design

- **Tema escuro** (slate-950/slate-900): coerente com o público-alvo de desenvolvedores.
- **Cor primária**: Indigo (#4f46e5) — associada a produtividade e tecnologia.
- **Tipografia**: Inter — legível, moderna, amplamente usada em produtos SaaS.
- **Hierarquia visual**: seções alternando entre `slate-950` e `slate-900/50` para separação sem uso de borders rígidas.

## Responsividade

- Abordagem mobile-first com breakpoints Tailwind: `sm:`, `md:`, `lg:`.
- Header: menu hamburger em mobile, nav horizontal em desktop.
- Hero: stack vertical em mobile, grid 2 colunas em desktop (mockup oculto em mobile).
- Planos: stack em mobile, 3 colunas em desktop.
- Formulário: 1 coluna em todos os breakpoints (máx-largura 2xl centrado).

## Acessibilidade

- `aria-label` em botões e formulários.
- `aria-expanded` + `aria-controls` no menu mobile e FAQ accordion.
- `aria-live="polite"` nas mensagens de erro dos campos.
- `aria-live="assertive"` no erro global do formulário.
- `tabindex="-1"` + `focus()` na mensagem de sucesso para anunciar ao screen reader.
- `prefers-reduced-motion`: desabilita animações via CSS.
- `focus-visible` para navegação por teclado.
- Contraste: texto primário slate-100 sobre slate-950 (ratio > 4.5:1).
- HTML semântico: `<header>`, `<nav>`, `<main>` (implícito), `<section>`, `<footer>`.

## Formulário e conversão

- Campos obrigatórios indicados com `*` e `aria-label="obrigatório"`.
- Mensagens de erro associadas ao campo via `id` + `role="alert"`.
- Estado de carregamento com spinner + texto "Enviando…".
- Prevenção de duplo envio: botão desabilitado durante a requisição.
- Seleção de plano nos cards de preço rola e pré-seleciona o campo no formulário.
- Mensagem de sucesso substitui o formulário e recebe foco automático.
- Consentimento de marketing separado do consentimento de contato (opcional).
