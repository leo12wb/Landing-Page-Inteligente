<?php
/**
 * @var string $abVariant  'A' ou 'B'
 * @var string $heroTitle  Título da hero section (variante A/B)
 */
$cssVersion = file_exists(__DIR__ . '/../public/assets/css/app.css')
    ? filemtime(__DIR__ . '/../public/assets/css/app.css')
    : '1';
?>
<!DOCTYPE html>
<html lang="pt-BR" class="scroll-smooth">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>DevFlow — Organize seus projetos. Foque no que importa.</title>
  <meta name="description" content="DevFlow é uma plataforma demonstrativa de organização de projetos para desenvolvedores. Gerencie tarefas e acompanhe o progresso. Projeto de portfólio em PHP + MySQL + Docker.">

  <!-- Open Graph -->
  <meta property="og:title"       content="DevFlow — Plataforma de organização para desenvolvedores">
  <meta property="og:description" content="Organize projetos, acompanhe tarefas e foque no que importa. Projeto demonstrativo de portfólio.">
  <meta property="og:type"        content="website">

  <!-- Favicon -->
  <link rel="icon" type="image/svg+xml" href="/favicon.svg">

  <!-- Fonts -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap">

  <!-- CSS (construído pelo Tailwind) -->
  <link rel="stylesheet" href="/assets/css/app.css?v=<?= $cssVersion ?>">
</head>
<body class="bg-slate-950 text-slate-100 font-sans antialiased">

<!-- ═══════════════════════════════════════════════════════ HEADER -->
<header id="site-header"
        class="fixed top-0 left-0 right-0 z-50 bg-slate-950/95 backdrop-blur-sm
               border-b border-slate-800 transition-shadow duration-200">
  <nav class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex items-center justify-between h-16"
       aria-label="Navegação principal">

    <!-- Logo -->
    <a href="/" class="flex items-center gap-2.5 text-white font-extrabold text-xl tracking-tight">
      <svg class="w-7 h-7 shrink-0" viewBox="0 0 32 32" fill="none" aria-hidden="true">
        <rect width="32" height="32" rx="7" fill="#4f46e5"/>
        <path d="M8 10h10a6 6 0 0 1 0 12H8V10z" stroke="white" stroke-width="2.5" stroke-linejoin="round"/>
        <line x1="8" y1="16" x2="20" y2="16" stroke="white" stroke-width="2.5" stroke-linecap="round"/>
      </svg>
      DevFlow
    </a>

    <!-- Nav desktop -->
    <div class="hidden md:flex items-center gap-8">
      <a href="#funcionalidades" class="text-slate-400 hover:text-white text-sm font-medium transition-colors">Funcionalidades</a>
      <a href="#beneficios"      class="text-slate-400 hover:text-white text-sm font-medium transition-colors">Benefícios</a>
      <a href="#planos"          class="text-slate-400 hover:text-white text-sm font-medium transition-colors">Planos</a>
      <a href="#faq"             class="text-slate-400 hover:text-white text-sm font-medium transition-colors">FAQ</a>
    </div>

    <div class="flex items-center gap-3">
      <a href="#cadastro" class="btn-primary hidden sm:inline-flex text-sm px-5 py-2.5">
        Cadastrar interesse
      </a>
      <!-- Mobile toggle -->
      <button id="menu-btn"
              aria-expanded="false"
              aria-controls="mobile-menu"
              aria-label="Abrir menu"
              class="md:hidden p-2 rounded-lg text-slate-400 hover:text-white hover:bg-slate-800 transition-colors">
        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
        </svg>
      </button>
    </div>
  </nav>

  <!-- Mobile menu -->
  <div id="mobile-menu" class="hidden md:hidden border-t border-slate-800 bg-slate-950" role="dialog" aria-label="Menu mobile">
    <div class="px-4 py-4 flex flex-col gap-3">
      <a href="#funcionalidades" class="text-slate-300 hover:text-white py-2 text-sm font-medium transition-colors">Funcionalidades</a>
      <a href="#beneficios"      class="text-slate-300 hover:text-white py-2 text-sm font-medium transition-colors">Benefícios</a>
      <a href="#planos"          class="text-slate-300 hover:text-white py-2 text-sm font-medium transition-colors">Planos</a>
      <a href="#faq"             class="text-slate-300 hover:text-white py-2 text-sm font-medium transition-colors">FAQ</a>
      <a href="#cadastro"        class="btn-primary text-center mt-1">Cadastrar interesse</a>
    </div>
  </div>
</header>


<!-- ═══════════════════════════════════════════════════════ HERO -->
<section id="inicio" class="relative min-h-screen flex items-center pt-16 overflow-hidden">
  <!-- Gradiente de fundo -->
  <div class="absolute inset-0 bg-gradient-to-br from-slate-950 via-slate-900 to-indigo-950/40 pointer-events-none" aria-hidden="true"></div>
  <!-- Brilho decorativo -->
  <div class="absolute top-1/4 right-1/4 w-96 h-96 bg-indigo-600/10 rounded-full blur-3xl pointer-events-none" aria-hidden="true"></div>

  <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-20 lg:py-28 w-full">
    <div class="grid lg:grid-cols-2 gap-12 lg:gap-16 items-center">

      <!-- Conteúdo textual -->
      <div class="text-center lg:text-left">
        <span class="inline-flex items-center gap-2 px-3 py-1 rounded-full
                     bg-indigo-500/10 border border-indigo-500/20 text-indigo-400
                     text-xs font-semibold uppercase tracking-wide mb-6">
          <span class="w-1.5 h-1.5 rounded-full bg-indigo-400 animate-pulse" aria-hidden="true"></span>
          Projeto Demonstrativo · Portfólio
        </span>

        <h1 id="hero-title"
            class="text-4xl sm:text-5xl lg:text-6xl font-extrabold text-white leading-tight tracking-tight mb-6"
            data-ab-variant="<?= htmlspecialchars($abVariant, ENT_QUOTES, 'UTF-8') ?>">
          <?= htmlspecialchars($heroTitle, ENT_QUOTES, 'UTF-8') ?>
        </h1>

        <p class="text-lg text-slate-400 leading-relaxed mb-8 max-w-xl mx-auto lg:mx-0">
          DevFlow é uma plataforma demonstrativa para organização de projetos e tarefas.
          Construída com <strong class="text-slate-300">PHP 8.2</strong>,
          <strong class="text-slate-300">MySQL</strong>,
          <strong class="text-slate-300">Docker</strong> e
          <strong class="text-slate-300">Tailwind CSS</strong> como projeto de portfólio.
        </p>

        <div class="flex flex-col sm:flex-row gap-4 justify-center lg:justify-start">
          <a href="#cadastro" class="btn-primary">
            Começar agora
            <svg class="w-4 h-4" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
              <path fill-rule="evenodd" d="M3 10a.75.75 0 01.75-.75h10.638L10.23 5.29a.75.75 0 111.04-1.08l5.5 5.25a.75.75 0 010 1.08l-5.5 5.25a.75.75 0 11-1.04-1.08l4.158-3.96H3.75A.75.75 0 013 10z" clip-rule="evenodd"/>
            </svg>
          </a>
          <a href="#funcionalidades" class="btn-secondary">Conhecer funcionalidades</a>
        </div>

        <p class="mt-6 text-slate-500 text-sm">Cadastro gratuito · Sem cartão de crédito · Dados fictícios para demonstração</p>
      </div>

      <!-- Mockup do dashboard (CSS puro) -->
      <div class="hidden lg:block" aria-hidden="true">
        <div class="bg-slate-800/80 rounded-2xl border border-slate-700 shadow-2xl overflow-hidden">
          <!-- Barra de título da janela -->
          <div class="flex items-center gap-1.5 px-4 py-3 bg-slate-900 border-b border-slate-700">
            <span class="w-3 h-3 rounded-full bg-red-500/80"></span>
            <span class="w-3 h-3 rounded-full bg-yellow-500/80"></span>
            <span class="w-3 h-3 rounded-full bg-green-500/80"></span>
            <div class="ml-3 flex-1 bg-slate-700 rounded h-5 max-w-xs"></div>
          </div>
          <!-- Layout do app -->
          <div class="flex">
            <!-- Sidebar -->
            <div class="w-48 bg-slate-900 border-r border-slate-700 p-3 space-y-1 shrink-0">
              <div class="bg-indigo-600 rounded-lg px-3 py-2 flex items-center gap-2">
                <div class="w-4 h-4 rounded bg-indigo-300/50"></div>
                <div class="h-2 bg-indigo-300/50 rounded flex-1"></div>
              </div>
              <div class="bg-slate-800 rounded-lg px-3 py-2 flex items-center gap-2">
                <div class="w-4 h-4 rounded bg-slate-600"></div>
                <div class="h-2 bg-slate-600 rounded flex-1"></div>
              </div>
              <div class="bg-slate-800 rounded-lg px-3 py-2 flex items-center gap-2">
                <div class="w-4 h-4 rounded bg-slate-600"></div>
                <div class="h-2 bg-slate-600 rounded flex-1"></div>
              </div>
              <div class="mt-4 pt-3 border-t border-slate-700 space-y-1">
                <div class="h-2 bg-slate-700 rounded w-16 mb-2"></div>
                <div class="bg-slate-800 rounded-lg px-3 py-2"><div class="h-2 bg-slate-600 rounded w-20"></div></div>
                <div class="bg-slate-800 rounded-lg px-3 py-2"><div class="h-2 bg-slate-600 rounded w-24"></div></div>
                <div class="bg-slate-800 rounded-lg px-3 py-2"><div class="h-2 bg-slate-600 rounded w-16"></div></div>
              </div>
            </div>
            <!-- Main content -->
            <div class="flex-1 p-4 space-y-3">
              <div class="flex items-center justify-between mb-2">
                <div class="h-3 bg-white/10 rounded w-28"></div>
                <div class="h-6 bg-indigo-600/50 rounded-lg w-20"></div>
              </div>
              <!-- Kanban columns mini -->
              <div class="grid grid-cols-3 gap-2">
                <div class="bg-slate-900 rounded-xl p-2 space-y-2">
                  <div class="h-2 bg-slate-600 rounded w-12 mb-2"></div>
                  <div class="bg-slate-800 rounded-lg p-2 border-l-2 border-blue-500">
                    <div class="h-2 bg-slate-500 rounded w-full mb-1"></div>
                    <div class="h-2 bg-slate-600 rounded w-3/4"></div>
                  </div>
                  <div class="bg-slate-800 rounded-lg p-2 border-l-2 border-blue-500">
                    <div class="h-2 bg-slate-500 rounded w-full mb-1"></div>
                    <div class="h-2 bg-slate-600 rounded w-1/2"></div>
                  </div>
                </div>
                <div class="bg-slate-900 rounded-xl p-2 space-y-2">
                  <div class="h-2 bg-slate-600 rounded w-16 mb-2"></div>
                  <div class="bg-slate-800 rounded-lg p-2 border-l-2 border-yellow-500">
                    <div class="h-2 bg-slate-500 rounded w-full mb-1"></div>
                    <div class="h-2 bg-slate-600 rounded w-2/3"></div>
                  </div>
                </div>
                <div class="bg-slate-900 rounded-xl p-2 space-y-2">
                  <div class="h-2 bg-slate-600 rounded w-14 mb-2"></div>
                  <div class="bg-slate-800 rounded-lg p-2 border-l-2 border-green-500">
                    <div class="h-2 bg-slate-500 rounded w-full mb-1"></div>
                    <div class="h-2 bg-slate-600 rounded w-3/4"></div>
                  </div>
                  <div class="bg-slate-800 rounded-lg p-2 border-l-2 border-green-500">
                    <div class="h-2 bg-slate-500 rounded w-full mb-1"></div>
                    <div class="h-2 bg-slate-600 rounded w-1/2"></div>
                  </div>
                </div>
              </div>
              <!-- Progress bar -->
              <div class="bg-slate-900 rounded-xl p-3">
                <div class="flex justify-between mb-2">
                  <div class="h-2 bg-slate-600 rounded w-24"></div>
                  <div class="h-2 bg-indigo-400/50 rounded w-8"></div>
                </div>
                <div class="h-2 bg-slate-700 rounded-full">
                  <div class="h-2 bg-indigo-600 rounded-full w-3/4"></div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>

    </div>
  </div>
</section>


<!-- ═══════════════════════════════════════════════════════ BENEFÍCIOS -->
<section id="beneficios" class="py-20 lg:py-28 bg-slate-900/50">
  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="text-center mb-16">
      <h2 class="section-title mb-4">Por que usar o DevFlow?</h2>
      <p class="section-subtitle max-w-2xl mx-auto">
        Tudo o que você precisa para manter seus projetos organizados e seu foco no lugar certo.
      </p>
    </div>

    <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-6">
      <!-- Card 1 -->
      <div class="card group">
        <div class="w-12 h-12 rounded-xl bg-indigo-500/10 border border-indigo-500/20 flex items-center justify-center mb-5 group-hover:bg-indigo-500/20 transition-colors">
          <svg class="w-6 h-6 text-indigo-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16M4 14h16M4 18h16"/>
          </svg>
        </div>
        <h3 class="text-white font-semibold text-base mb-2">Organização centralizada</h3>
        <p class="text-slate-400 text-sm leading-relaxed">Todos os seus projetos e tarefas em um único lugar, sem perder nada de vista.</p>
      </div>
      <!-- Card 2 -->
      <div class="card group">
        <div class="w-12 h-12 rounded-xl bg-green-500/10 border border-green-500/20 flex items-center justify-center mb-5 group-hover:bg-green-500/20 transition-colors">
          <svg class="w-6 h-6 text-green-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
          </svg>
        </div>
        <h3 class="text-white font-semibold text-base mb-2">Acompanhamento de tarefas</h3>
        <p class="text-slate-400 text-sm leading-relaxed">Crie, priorize e conclua tarefas com visibilidade clara do que está em andamento.</p>
      </div>
      <!-- Card 3 -->
      <div class="card group">
        <div class="w-12 h-12 rounded-xl bg-blue-500/10 border border-blue-500/20 flex items-center justify-center mb-5 group-hover:bg-blue-500/20 transition-colors">
          <svg class="w-6 h-6 text-blue-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
          </svg>
        </div>
        <h3 class="text-white font-semibold text-base mb-2">Visão do progresso</h3>
        <p class="text-slate-400 text-sm leading-relaxed">Métricas visuais que mostram o avanço de cada projeto em tempo real.</p>
      </div>
      <!-- Card 4 -->
      <div class="card group">
        <div class="w-12 h-12 rounded-xl bg-violet-500/10 border border-violet-500/20 flex items-center justify-center mb-5 group-hover:bg-violet-500/20 transition-colors">
          <svg class="w-6 h-6 text-violet-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
          </svg>
        </div>
        <h3 class="text-white font-semibold text-base mb-2">Clareza de prioridades</h3>
        <p class="text-slate-400 text-sm leading-relaxed">Identifique o que é urgente e o que pode esperar sem perder contexto.</p>
      </div>
      <!-- Card 5 -->
      <div class="card group">
        <div class="w-12 h-12 rounded-xl bg-orange-500/10 border border-orange-500/20 flex items-center justify-center mb-5 group-hover:bg-orange-500/20 transition-colors">
          <svg class="w-6 h-6 text-orange-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>
          </svg>
        </div>
        <h3 class="text-white font-semibold text-base mb-2">Colaboração em equipe</h3>
        <p class="text-slate-400 text-sm leading-relaxed">Compartilhe projetos e mantenha toda a equipe alinhada sem e-mails intermináveis.</p>
      </div>
      <!-- Card 6 -->
      <div class="card group">
        <div class="w-12 h-12 rounded-xl bg-teal-500/10 border border-teal-500/20 flex items-center justify-center mb-5 group-hover:bg-teal-500/20 transition-colors">
          <svg class="w-6 h-6 text-teal-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4"/>
          </svg>
        </div>
        <h3 class="text-white font-semibold text-base mb-2">Totalmente flexível</h3>
        <p class="text-slate-400 text-sm leading-relaxed">Adapte o fluxo de trabalho ao seu jeito — freelancer, equipe pequena ou projetos pessoais.</p>
      </div>
    </div>
  </div>
</section>


<!-- ═══════════════════════════════════════════════════════ FUNCIONALIDADES -->
<section id="funcionalidades" class="py-20 lg:py-28">
  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="text-center mb-16">
      <h2 class="section-title mb-4">Funcionalidades principais</h2>
      <p class="section-subtitle max-w-2xl mx-auto">
        Mockups demonstrativos das interfaces da plataforma. Conteúdo fictício para fins de portfólio.
      </p>
    </div>

    <div class="grid md:grid-cols-2 gap-8">

      <!-- Funcionalidade 1: Lista de tarefas -->
      <div class="card" aria-label="Demonstração: Lista de Tarefas">
        <div class="flex items-center justify-between mb-4">
          <h3 class="text-white font-semibold">Lista de Tarefas</h3>
          <span class="text-xs text-slate-500 bg-slate-700 px-2 py-1 rounded">Demo</span>
        </div>
        <div class="space-y-2.5" aria-hidden="true">
          <div class="flex items-center gap-3 bg-slate-900 rounded-lg p-3">
            <div class="w-4 h-4 rounded border-2 border-green-500 bg-green-500 flex items-center justify-center shrink-0">
              <svg class="w-2.5 h-2.5 text-white" viewBox="0 0 10 10" fill="currentColor"><path d="M1 5l3 3 5-5"/></svg>
            </div>
            <span class="text-slate-400 line-through text-sm">Configurar ambiente Docker</span>
            <span class="ml-auto text-xs text-green-400 bg-green-500/10 px-2 py-0.5 rounded">Concluída</span>
          </div>
          <div class="flex items-center gap-3 bg-slate-900 rounded-lg p-3">
            <div class="w-4 h-4 rounded border-2 border-yellow-500 shrink-0"></div>
            <span class="text-slate-200 text-sm">Implementar autenticação JWT</span>
            <span class="ml-auto text-xs text-yellow-400 bg-yellow-500/10 px-2 py-0.5 rounded">Em andamento</span>
          </div>
          <div class="flex items-center gap-3 bg-slate-900 rounded-lg p-3">
            <div class="w-4 h-4 rounded border-2 border-slate-600 shrink-0"></div>
            <span class="text-slate-400 text-sm">Criar testes unitários</span>
            <span class="ml-auto text-xs text-slate-500 bg-slate-700 px-2 py-0.5 rounded">Pendente</span>
          </div>
          <div class="flex items-center gap-3 bg-slate-900 rounded-lg p-3">
            <div class="w-4 h-4 rounded border-2 border-slate-600 shrink-0"></div>
            <span class="text-slate-400 text-sm">Deploy em produção</span>
            <span class="ml-auto text-xs text-slate-500 bg-slate-700 px-2 py-0.5 rounded">Pendente</span>
          </div>
        </div>
      </div>

      <!-- Funcionalidade 2: Kanban -->
      <div class="card" aria-label="Demonstração: Quadro Kanban">
        <div class="flex items-center justify-between mb-4">
          <h3 class="text-white font-semibold">Quadro Kanban</h3>
          <span class="text-xs text-slate-500 bg-slate-700 px-2 py-1 rounded">Demo</span>
        </div>
        <div class="grid grid-cols-3 gap-3" aria-hidden="true">
          <div>
            <p class="text-xs font-semibold text-slate-500 uppercase tracking-wider mb-2">A fazer</p>
            <div class="space-y-2">
              <div class="bg-slate-900 border border-slate-700 rounded-lg p-2.5">
                <div class="h-1.5 bg-blue-500 rounded-full mb-2"></div>
                <p class="text-slate-300 text-xs">Revisar PR #42</p>
              </div>
              <div class="bg-slate-900 border border-slate-700 rounded-lg p-2.5">
                <div class="h-1.5 bg-blue-500 rounded-full mb-2"></div>
                <p class="text-slate-300 text-xs">Atualizar docs</p>
              </div>
            </div>
          </div>
          <div>
            <p class="text-xs font-semibold text-slate-500 uppercase tracking-wider mb-2">Em progresso</p>
            <div class="space-y-2">
              <div class="bg-slate-900 border border-yellow-500/30 rounded-lg p-2.5">
                <div class="h-1.5 bg-yellow-500 rounded-full mb-2"></div>
                <p class="text-slate-300 text-xs">API de leads</p>
              </div>
            </div>
          </div>
          <div>
            <p class="text-xs font-semibold text-slate-500 uppercase tracking-wider mb-2">Concluído</p>
            <div class="space-y-2">
              <div class="bg-slate-900 border border-green-500/30 rounded-lg p-2.5">
                <div class="h-1.5 bg-green-500 rounded-full mb-2"></div>
                <p class="text-slate-400 text-xs line-through">Setup inicial</p>
              </div>
              <div class="bg-slate-900 border border-green-500/30 rounded-lg p-2.5">
                <div class="h-1.5 bg-green-500 rounded-full mb-2"></div>
                <p class="text-slate-400 text-xs line-through">Banco de dados</p>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- Funcionalidade 3: Progresso do projeto -->
      <div class="card" aria-label="Demonstração: Progresso do Projeto">
        <div class="flex items-center justify-between mb-4">
          <h3 class="text-white font-semibold">Visão geral do projeto</h3>
          <span class="text-xs text-slate-500 bg-slate-700 px-2 py-1 rounded">Demo</span>
        </div>
        <div class="space-y-4" aria-hidden="true">
          <div>
            <div class="flex justify-between text-xs mb-1.5">
              <span class="text-slate-300">Backend PHP</span>
              <span class="text-indigo-400">78%</span>
            </div>
            <div class="h-2 bg-slate-700 rounded-full"><div class="h-2 bg-indigo-600 rounded-full" style="width:78%"></div></div>
          </div>
          <div>
            <div class="flex justify-between text-xs mb-1.5">
              <span class="text-slate-300">Frontend</span>
              <span class="text-green-400">92%</span>
            </div>
            <div class="h-2 bg-slate-700 rounded-full"><div class="h-2 bg-green-500 rounded-full" style="width:92%"></div></div>
          </div>
          <div>
            <div class="flex justify-between text-xs mb-1.5">
              <span class="text-slate-300">Testes</span>
              <span class="text-yellow-400">45%</span>
            </div>
            <div class="h-2 bg-slate-700 rounded-full"><div class="h-2 bg-yellow-500 rounded-full" style="width:45%"></div></div>
          </div>
          <div>
            <div class="flex justify-between text-xs mb-1.5">
              <span class="text-slate-300">Documentação</span>
              <span class="text-blue-400">60%</span>
            </div>
            <div class="h-2 bg-slate-700 rounded-full"><div class="h-2 bg-blue-500 rounded-full" style="width:60%"></div></div>
          </div>
        </div>
      </div>

      <!-- Funcionalidade 4: Atividade recente -->
      <div class="card" aria-label="Demonstração: Atividade Recente">
        <div class="flex items-center justify-between mb-4">
          <h3 class="text-white font-semibold">Atividade recente</h3>
          <span class="text-xs text-slate-500 bg-slate-700 px-2 py-1 rounded">Demo</span>
        </div>
        <div class="space-y-3" aria-hidden="true">
          <div class="flex items-start gap-3">
            <div class="w-8 h-8 rounded-full bg-indigo-600 flex items-center justify-center text-xs font-bold text-white shrink-0">A</div>
            <div>
              <p class="text-slate-300 text-xs"><span class="text-white font-medium">Ana</span> concluiu a tarefa <em>Configurar CI/CD</em></p>
              <p class="text-slate-500 text-xs mt-0.5">há 2 min</p>
            </div>
          </div>
          <div class="flex items-start gap-3">
            <div class="w-8 h-8 rounded-full bg-green-600 flex items-center justify-center text-xs font-bold text-white shrink-0">C</div>
            <div>
              <p class="text-slate-300 text-xs"><span class="text-white font-medium">Carlos</span> criou 3 novas tarefas no sprint</p>
              <p class="text-slate-500 text-xs mt-0.5">há 15 min</p>
            </div>
          </div>
          <div class="flex items-start gap-3">
            <div class="w-8 h-8 rounded-full bg-violet-600 flex items-center justify-center text-xs font-bold text-white shrink-0">M</div>
            <div>
              <p class="text-slate-300 text-xs"><span class="text-white font-medium">Marina</span> comentou em <em>PR #38</em></p>
              <p class="text-slate-500 text-xs mt-0.5">há 1h</p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>


<!-- ═══════════════════════════════════════════════════════ COMO FUNCIONA -->
<section id="como-funciona" class="py-20 lg:py-28 bg-slate-900/50">
  <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="text-center mb-16">
      <h2 class="section-title mb-4">Como funciona</h2>
      <p class="section-subtitle">
        Três passos para começar a organizar seus projetos. Esta landing page está demonstrando
        uma proposta de produto — nenhum produto real está disponível ainda.
      </p>
    </div>

    <div class="grid md:grid-cols-3 gap-8 relative">
      <!-- Linha conectora (desktop) -->
      <div class="hidden md:block absolute top-10 left-[calc(16.66%+24px)] right-[calc(16.66%+24px)] h-px bg-slate-700" aria-hidden="true"></div>

      <div class="text-center">
        <div class="w-20 h-20 rounded-2xl bg-indigo-600/20 border-2 border-indigo-500/40 flex items-center justify-center mx-auto mb-5 relative">
          <span class="text-3xl font-extrabold text-indigo-400">1</span>
        </div>
        <h3 class="text-white font-semibold mb-2">Cadastre seu interesse</h3>
        <p class="text-slate-400 text-sm leading-relaxed">Preencha o formulário abaixo para demonstrar interesse na plataforma.</p>
      </div>

      <div class="text-center">
        <div class="w-20 h-20 rounded-2xl bg-indigo-600/20 border-2 border-indigo-500/40 flex items-center justify-center mx-auto mb-5">
          <span class="text-3xl font-extrabold text-indigo-400">2</span>
        </div>
        <h3 class="text-white font-semibold mb-2">Organize seus projetos</h3>
        <p class="text-slate-400 text-sm leading-relaxed">Crie projetos, adicione tarefas e configure seu fluxo de trabalho ideal.</p>
      </div>

      <div class="text-center">
        <div class="w-20 h-20 rounded-2xl bg-indigo-600/20 border-2 border-indigo-500/40 flex items-center justify-center mx-auto mb-5">
          <span class="text-3xl font-extrabold text-indigo-400">3</span>
        </div>
        <h3 class="text-white font-semibold mb-2">Acompanhe o progresso</h3>
        <p class="text-slate-400 text-sm leading-relaxed">Visualize métricas, identifique gargalos e entregue mais projetos com mais qualidade.</p>
      </div>
    </div>
  </div>
</section>


<!-- ═══════════════════════════════════════════════════════ PLANOS -->
<section id="planos" class="py-20 lg:py-28">
  <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="text-center mb-4">
      <h2 class="section-title mb-4">Planos e preços</h2>
      <p class="section-subtitle max-w-2xl mx-auto">
        Preços ilustrativos para fins de demonstração. Nenhuma cobrança real está ativa.
      </p>
      <p class="mt-3 text-xs text-amber-400/80 bg-amber-500/10 border border-amber-500/20 rounded-lg inline-block px-4 py-2">
        ⚠ Valores fictícios para demonstração de portfólio
      </p>
    </div>

    <div class="grid md:grid-cols-3 gap-6 mt-12">

      <!-- Starter -->
      <div class="card flex flex-col">
        <div class="mb-6">
          <h3 class="text-lg font-bold text-white mb-1">Starter</h3>
          <p class="text-slate-400 text-sm">Para desenvolvedores individuais e projetos pessoais.</p>
        </div>
        <div class="mb-6">
          <span class="text-4xl font-extrabold text-white">R$&nbsp;0</span>
          <span class="text-slate-400 text-sm">/mês</span>
        </div>
        <ul class="space-y-3 mb-8 flex-1">
          <li class="flex items-center gap-2 text-slate-300 text-sm"><svg class="w-4 h-4 text-green-400 shrink-0" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/></svg>Até 3 projetos</li>
          <li class="flex items-center gap-2 text-slate-300 text-sm"><svg class="w-4 h-4 text-green-400 shrink-0" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/></svg>Tarefas ilimitadas</li>
          <li class="flex items-center gap-2 text-slate-300 text-sm"><svg class="w-4 h-4 text-green-400 shrink-0" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/></svg>Quadro Kanban</li>
          <li class="flex items-center gap-2 text-slate-400 text-sm"><svg class="w-4 h-4 text-slate-600 shrink-0" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true"><path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"/></svg>Colaboração em equipe</li>
        </ul>
        <button data-plan="starter" class="btn-secondary w-full">Escolher Starter</button>
      </div>

      <!-- Pro (destaque) -->
      <div class="relative bg-indigo-600/10 border-2 border-indigo-500 rounded-2xl p-6 flex flex-col">
        <div class="absolute -top-3 left-1/2 -translate-x-1/2">
          <span class="bg-indigo-600 text-white text-xs font-bold px-4 py-1 rounded-full">RECOMENDADO</span>
        </div>
        <div class="mb-6">
          <h3 class="text-lg font-bold text-white mb-1">Pro</h3>
          <p class="text-slate-400 text-sm">Para freelancers e profissionais que trabalham em múltiplos projetos.</p>
        </div>
        <div class="mb-6">
          <span class="text-4xl font-extrabold text-white">R$&nbsp;49</span>
          <span class="text-slate-400 text-sm">/mês</span>
        </div>
        <ul class="space-y-3 mb-8 flex-1">
          <li class="flex items-center gap-2 text-slate-300 text-sm"><svg class="w-4 h-4 text-indigo-400 shrink-0" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/></svg>Projetos ilimitados</li>
          <li class="flex items-center gap-2 text-slate-300 text-sm"><svg class="w-4 h-4 text-indigo-400 shrink-0" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/></svg>Tarefas ilimitadas</li>
          <li class="flex items-center gap-2 text-slate-300 text-sm"><svg class="w-4 h-4 text-indigo-400 shrink-0" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/></svg>Relatórios de progresso</li>
          <li class="flex items-center gap-2 text-slate-300 text-sm"><svg class="w-4 h-4 text-indigo-400 shrink-0" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/></svg>Integrações GitHub/GitLab</li>
        </ul>
        <button data-plan="pro" class="btn-primary w-full">Escolher Pro</button>
      </div>

      <!-- Team -->
      <div class="card flex flex-col">
        <div class="mb-6">
          <h3 class="text-lg font-bold text-white mb-1">Team</h3>
          <p class="text-slate-400 text-sm">Para equipes de desenvolvimento que precisam colaborar.</p>
        </div>
        <div class="mb-6">
          <span class="text-4xl font-extrabold text-white">R$&nbsp;129</span>
          <span class="text-slate-400 text-sm">/mês</span>
        </div>
        <ul class="space-y-3 mb-8 flex-1">
          <li class="flex items-center gap-2 text-slate-300 text-sm"><svg class="w-4 h-4 text-green-400 shrink-0" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/></svg>Tudo do Pro</li>
          <li class="flex items-center gap-2 text-slate-300 text-sm"><svg class="w-4 h-4 text-green-400 shrink-0" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/></svg>Até 15 membros</li>
          <li class="flex items-center gap-2 text-slate-300 text-sm"><svg class="w-4 h-4 text-green-400 shrink-0" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/></svg>Permissões avançadas</li>
          <li class="flex items-center gap-2 text-slate-300 text-sm"><svg class="w-4 h-4 text-green-400 shrink-0" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/></svg>Suporte prioritário</li>
        </ul>
        <button data-plan="team" class="btn-secondary w-full">Escolher Team</button>
      </div>
    </div>
  </div>
</section>


<!-- ═══════════════════════════════════════════════════════ DEPOIMENTOS -->
<section class="py-20 lg:py-28 bg-slate-900/50">
  <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="text-center mb-4">
      <h2 class="section-title mb-4">O que dizem sobre o DevFlow</h2>
      <p class="inline-block text-xs text-amber-400/80 bg-amber-500/10 border border-amber-500/20 rounded-lg px-4 py-2">
        ⚠ Depoimentos fictícios criados exclusivamente para demonstração de portfólio
      </p>
    </div>

    <div class="grid md:grid-cols-3 gap-6 mt-10">
      <div class="card">
        <div class="flex items-center gap-3 mb-4">
          <div class="w-10 h-10 rounded-full bg-indigo-600 flex items-center justify-center text-sm font-bold text-white">PA</div>
          <div>
            <p class="text-white text-sm font-semibold">Pedro A. <span class="text-slate-500 font-normal">(Demo)</span></p>
            <p class="text-slate-500 text-xs">Desenvolvedor freelancer</p>
          </div>
        </div>
        <p class="text-slate-400 text-sm leading-relaxed">"Consegui organizar meus 6 projetos simultâneos sem perder prazos. A visão kanban fez toda a diferença."</p>
      </div>
      <div class="card">
        <div class="flex items-center gap-3 mb-4">
          <div class="w-10 h-10 rounded-full bg-green-600 flex items-center justify-center text-sm font-bold text-white">JS</div>
          <div>
            <p class="text-white text-sm font-semibold">Juliana S. <span class="text-slate-500 font-normal">(Demo)</span></p>
            <p class="text-slate-500 text-xs">Tech lead, startup</p>
          </div>
        </div>
        <p class="text-slate-400 text-sm leading-relaxed">"Minha equipe de 5 devs adotou em uma semana. A visibilidade do progresso reduziu as reuniões de status."</p>
      </div>
      <div class="card">
        <div class="flex items-center gap-3 mb-4">
          <div class="w-10 h-10 rounded-full bg-violet-600 flex items-center justify-center text-sm font-bold text-white">RL</div>
          <div>
            <p class="text-white text-sm font-semibold">Rafael L. <span class="text-slate-500 font-normal">(Demo)</span></p>
            <p class="text-slate-500 text-xs">Dev independente</p>
          </div>
        </div>
        <p class="text-slate-400 text-sm leading-relaxed">"Uso para projetos pessoais e profissionais. O plano gratuito já atende minha necessidade do dia a dia."</p>
      </div>
    </div>
  </div>
</section>


<!-- ═══════════════════════════════════════════════════════ FAQ -->
<section id="faq" class="py-20 lg:py-28">
  <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="text-center mb-12">
      <h2 class="section-title mb-4">Perguntas frequentes</h2>
    </div>

    <div class="space-y-3">
      <?php
      $faqs = [
        ['q' => 'O que é o DevFlow?',
         'a' => 'DevFlow é uma plataforma demonstrativa de organização de projetos para desenvolvedores, criada como projeto de portfólio. Não é um produto real em operação comercial.'],
        ['q' => 'Para quem é indicado?',
         'a' => 'O conceito é voltado para desenvolvedores freelancers, pequenas equipes de desenvolvimento e profissionais que trabalham em projetos pessoais e precisam de organização clara de tarefas.'],
        ['q' => 'Como funciona o cadastro de interesse?',
         'a' => 'Você preenche o formulário abaixo com seu nome, e-mail, perfil e plano de interesse. Os dados são salvos em um banco de dados MySQL e, quando configurado, uma confirmação é enviada por e-mail via Resend API.'],
        ['q' => 'O produto já está disponível?',
         'a' => 'Não. Este é um projeto de portfólio técnico para demonstrar habilidades em PHP, MySQL, Docker, Tailwind CSS e integração de APIs. Nenhum produto real está disponível para uso.'],
        ['q' => 'Como meus dados são utilizados?',
         'a' => 'Os dados do formulário (nome, e-mail, plano e perfil) são usados exclusivamente para demonstração da integração backend → banco de dados. Não são compartilhados, não há finalidade comercial e podem ser excluídos mediante solicitação.'],
      ];
      foreach ($faqs as $i => $faq):
        $id = 'faq-panel-' . ($i + 1);
      ?>
      <div class="bg-slate-800/60 border border-slate-700/50 rounded-xl overflow-hidden">
        <button class="faq-question w-full flex items-center justify-between px-5 py-4 text-left
                       hover:bg-slate-700/30 transition-colors focus-visible:outline-none
                       focus-visible:ring-2 focus-visible:ring-inset focus-visible:ring-indigo-500"
                aria-expanded="false"
                aria-controls="<?= $id ?>">
          <span class="text-white text-sm font-medium pr-4"><?= htmlspecialchars($faq['q'], ENT_QUOTES, 'UTF-8') ?></span>
          <svg class="faq-icon w-5 h-5 text-slate-400 shrink-0 transition-transform duration-200" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
          </svg>
        </button>
        <div id="<?= $id ?>" class="hidden px-5 pb-4">
          <p class="text-slate-400 text-sm leading-relaxed"><?= htmlspecialchars($faq['a'], ENT_QUOTES, 'UTF-8') ?></p>
        </div>
      </div>
      <?php endforeach; ?>
    </div>
  </div>
</section>


<!-- ═══════════════════════════════════════════════════════ FORMULÁRIO -->
<section id="cadastro" class="py-20 lg:py-28 bg-slate-900/50">
  <div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="text-center mb-10">
      <h2 class="section-title mb-4">Cadastre seu interesse</h2>
      <p class="section-subtitle">Demonstre interesse na plataforma. Todos os dados são para fins de demonstração do portfólio.</p>
    </div>

    <!-- Formulário -->
    <div id="lead-form-wrapper" class="card">
      <form id="lead-form" novalidate aria-label="Formulário de cadastro de interesse">

        <!-- Nome -->
        <div class="mb-5">
          <label for="name" class="form-label">
            Nome <span class="text-red-400" aria-label="obrigatório">*</span>
          </label>
          <input id="name" name="name" type="text" autocomplete="name"
                 class="form-input" placeholder="Seu nome completo" required>
          <p id="error-name" class="field-error" role="alert" aria-live="polite"></p>
        </div>

        <!-- E-mail -->
        <div class="mb-5">
          <label for="email" class="form-label">
            E-mail <span class="text-red-400" aria-label="obrigatório">*</span>
          </label>
          <input id="email" name="email" type="email" autocomplete="email"
                 class="form-input" placeholder="seu@email.com" required>
          <p id="error-email" class="field-error" role="alert" aria-live="polite"></p>
        </div>

        <!-- Tipo de usuário -->
        <div class="mb-5">
          <label for="user_type" class="form-label">
            Perfil <span class="text-red-400" aria-label="obrigatório">*</span>
          </label>
          <select id="user_type" name="user_type" class="form-input" required>
            <option value="">Selecione seu perfil…</option>
            <option value="freelancer">Freelancer</option>
            <option value="developer">Desenvolvedor (empresa)</option>
            <option value="team">Equipe / Tech lead</option>
          </select>
          <p id="error-user-type" class="field-error" role="alert" aria-live="polite"></p>
        </div>

        <!-- Plano de interesse -->
        <div class="mb-5">
          <label for="plan" class="form-label">
            Plano de interesse <span class="text-red-400" aria-label="obrigatório">*</span>
          </label>
          <select id="plan" name="plan" class="form-input" required>
            <option value="">Selecione um plano…</option>
            <option value="starter">Starter — Gratuito</option>
            <option value="pro">Pro — R$ 49/mês (ilustrativo)</option>
            <option value="team">Team — R$ 129/mês (ilustrativo)</option>
          </select>
          <p id="error-plan" class="field-error" role="alert" aria-live="polite"></p>
        </div>

        <!-- Consentimento para contato (obrigatório) -->
        <div class="mb-4">
          <label class="flex items-start gap-3 cursor-pointer group">
            <input id="contact_consent" name="contact_consent" type="checkbox"
                   class="mt-0.5 w-4 h-4 rounded border-slate-600 bg-slate-800 text-indigo-600
                          focus:ring-indigo-500 focus:ring-offset-slate-900 shrink-0" required>
            <span class="text-slate-300 text-sm leading-relaxed">
              Confirmo que li e aceito os <a href="#footer-privacy" class="text-indigo-400 hover:text-indigo-300 underline">termos de uso</a> e concordo que meus dados sejam armazenados para demonstração desta integração backend.
              <span class="text-red-400" aria-label="obrigatório">*</span>
            </span>
          </label>
          <p id="error-contact-consent" class="field-error ml-7" role="alert" aria-live="polite"></p>
        </div>

        <!-- Consentimento marketing (opcional) -->
        <div class="mb-6">
          <label class="flex items-start gap-3 cursor-pointer group">
            <input id="marketing_consent" name="marketing_consent" type="checkbox"
                   class="mt-0.5 w-4 h-4 rounded border-slate-600 bg-slate-800 text-indigo-600
                          focus:ring-indigo-500 focus:ring-offset-slate-900 shrink-0">
            <span class="text-slate-400 text-sm leading-relaxed">
              Aceito receber novidades sobre o DevFlow por e-mail. <span class="text-slate-500">(opcional)</span>
            </span>
          </label>
        </div>

        <!-- Erro geral -->
        <div id="form-error" class="hidden bg-red-500/10 border border-red-500/30 text-red-400 text-sm rounded-xl px-4 py-3 mb-4" role="alert" aria-live="assertive"></div>

        <!-- Submit -->
        <button type="submit" data-submit-btn
                class="btn-primary w-full py-3.5 relative">
          <svg data-btn-spinner class="hidden animate-spin w-4 h-4 shrink-0" viewBox="0 0 24 24" fill="none" aria-hidden="true">
            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"/>
            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"/>
          </svg>
          <span data-btn-text>Cadastrar meu interesse</span>
        </button>

        <p class="text-center text-slate-500 text-xs mt-4">
          Seus dados não serão compartilhados ou usados comercialmente.
        </p>
      </form>

      <!-- Mensagem de sucesso (oculta) -->
      <div id="form-success" class="hidden text-center py-8" tabindex="-1" aria-live="polite">
        <div class="w-16 h-16 rounded-full bg-green-500/20 flex items-center justify-center mx-auto mb-4">
          <svg class="w-8 h-8 text-green-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
          </svg>
        </div>
        <h3 class="text-white font-bold text-xl mb-2">Cadastro recebido!</h3>
        <p class="text-slate-400 text-sm leading-relaxed max-w-sm mx-auto">
          Seu interesse foi registrado com sucesso. Obrigado por conhecer o DevFlow!
        </p>
        <p class="text-slate-500 text-xs mt-4">Este é um projeto demonstrativo de portfólio.</p>
      </div>
    </div>
  </div>
</section>


<!-- ═══════════════════════════════════════════════════════ FOOTER -->
<footer id="footer-privacy" class="border-t border-slate-800 py-12">
  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="grid md:grid-cols-4 gap-8 mb-10">
      <!-- Logo + desc -->
      <div class="md:col-span-2">
        <a href="/" class="flex items-center gap-2 text-white font-extrabold text-lg mb-3">
          <svg class="w-6 h-6" viewBox="0 0 32 32" fill="none" aria-hidden="true">
            <rect width="32" height="32" rx="7" fill="#4f46e5"/>
            <path d="M8 10h10a6 6 0 0 1 0 12H8V10z" stroke="white" stroke-width="2.5" stroke-linejoin="round"/>
            <line x1="8" y1="16" x2="20" y2="16" stroke="white" stroke-width="2.5" stroke-linecap="round"/>
          </svg>
          DevFlow
        </a>
        <p class="text-slate-400 text-sm leading-relaxed max-w-xs">
          Projeto demonstrativo de portfólio técnico. Construído com PHP 8.2, MySQL, Docker e Tailwind CSS.
        </p>
      </div>

      <!-- Links -->
      <div>
        <h4 class="text-white text-sm font-semibold mb-3">Navegação</h4>
        <ul class="space-y-2">
          <li><a href="#funcionalidades" class="text-slate-400 hover:text-white text-sm transition-colors">Funcionalidades</a></li>
          <li><a href="#beneficios"      class="text-slate-400 hover:text-white text-sm transition-colors">Benefícios</a></li>
          <li><a href="#planos"          class="text-slate-400 hover:text-white text-sm transition-colors">Planos</a></li>
          <li><a href="#faq"             class="text-slate-400 hover:text-white text-sm transition-colors">FAQ</a></li>
        </ul>
      </div>

      <!-- Contato (demonstrativo) -->
      <div>
        <h4 class="text-white text-sm font-semibold mb-3">Contato <span class="text-slate-500 text-xs font-normal">(Demo)</span></h4>
        <ul class="space-y-2">
          <li class="text-slate-500 text-sm">contato@devflow.demo</li>
          <li class="text-slate-500 text-sm">github.com/devflow-demo</li>
        </ul>
        <p class="mt-3 text-slate-600 text-xs">Endereço fictício · Não utilize para contato real</p>
      </div>
    </div>

    <div class="border-t border-slate-800 pt-6 flex flex-col sm:flex-row items-center justify-between gap-4">
      <p class="text-slate-500 text-xs text-center sm:text-left">
        © <?= date('Y') ?> DevFlow · Projeto fictício para demonstração de portfólio técnico
      </p>
      <p class="text-amber-500/70 text-xs text-center bg-amber-500/5 border border-amber-500/20 rounded-lg px-3 py-1">
        ⚠ Nenhum produto real está sendo comercializado
      </p>
    </div>
  </div>
</footer>


<script src="/assets/js/main.js"></script>
</body>
</html>
