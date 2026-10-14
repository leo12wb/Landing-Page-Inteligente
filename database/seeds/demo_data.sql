-- ─────────────────────────────────────────────────────────────────────────
-- Seeds de demonstração — NÃO USE EM PRODUÇÃO
--
-- Popula `devflow` com dados fictícios para demonstrar o painel admin.
-- Execute manualmente apenas em ambiente de desenvolvimento:
--
--   docker exec -i devflow-db mysql -u devflow -pdevflow_pass devflow \
--     < database/seeds/demo_data.sql
-- ─────────────────────────────────────────────────────────────────────────

-- ── Leads ─────────────────────────────────────────────────────────────────

INSERT IGNORE INTO `leads`
    (public_id, name, email, user_type, plan, ab_variant,
     marketing_consent, email_status, created_at)
VALUES
    -- Plano Starter
    ('demo0001aaaaaaaaa', 'Ana Rodrigues',     'ana.rodrigues@example.com',    'freelancer', 'starter', 'A', 0, 'skipped',  NOW() - INTERVAL 10 DAY),
    ('demo0002bbbbbbbbb', 'Bruno Carvalho',    'bruno.carvalho@example.com',   'developer',  'starter', 'B', 1, 'sent',     NOW() - INTERVAL  9 DAY),
    ('demo0003ccccccccc', 'Camila Souza',      'camila.souza@example.com',     'freelancer', 'starter', 'A', 0, 'skipped',  NOW() - INTERVAL  8 DAY),
    ('demo0004ddddddddd', 'Diego Lima',        'diego.lima@example.com',       'developer',  'starter', 'B', 1, 'sent',     NOW() - INTERVAL  7 DAY),
    ('demo0005eeeeeeeee', 'Eduarda Martins',   'eduarda.martins@example.com',  'freelancer', 'starter', 'A', 0, 'skipped',  NOW() - INTERVAL  6 DAY),

    -- Plano Pro
    ('demo0006fffffffff', 'Felipe Torres',     'felipe.torres@example.com',    'developer',  'pro',     'B', 1, 'sent',     NOW() - INTERVAL  8 DAY),
    ('demo0007ggggggggg', 'Gabriela Costa',    'gabriela.costa@example.com',   'developer',  'pro',     'A', 0, 'skipped',  NOW() - INTERVAL  7 DAY),
    ('demo0008hhhhhhhhh', 'Henrique Alves',    'henrique.alves@example.com',   'developer',  'pro',     'B', 1, 'sent',     NOW() - INTERVAL  5 DAY),
    ('demo0009iiiiiiiii', 'Isabela Ferreira',  'isabela.ferreira@example.com', 'freelancer', 'pro',     'A', 1, 'sent',     NOW() - INTERVAL  4 DAY),
    ('demo0010jjjjjjjjj', 'João Pereira',     'joao.pereira@example.com',     'developer',  'pro',     'B', 0, 'skipped',  NOW() - INTERVAL  3 DAY),
    ('demo0011kkkkkkkkk', 'Karen Nascimento',  'karen.nascimento@example.com', 'developer',  'pro',     'A', 1, 'sent',     NOW() - INTERVAL  2 DAY),

    -- Plano Team
    ('demo0012lllllllll', 'Lucas Barbosa',     'lucas.barbosa@example.com',    'team',       'team',    'B', 1, 'sent',     NOW() - INTERVAL  6 DAY),
    ('demo0013mmmmmmmmm', 'Mariana Oliveira',  'mariana.oliveira@example.com', 'team',       'team',    'A', 1, 'sent',     NOW() - INTERVAL  5 DAY),
    ('demo0014nnnnnnnnn', 'Nicolas Araujo',    'nicolas.araujo@example.com',   'team',       'team',    'B', 0, 'failed',   NOW() - INTERVAL  4 DAY),
    ('demo0015ooooooooo', 'Olivia Mendes',     'olivia.mendes@example.com',    'team',       'team',    'A', 1, 'sent',     NOW() - INTERVAL  2 DAY),
    ('demo0016ppppppppp', 'Pedro Gomes',       'pedro.gomes@example.com',      'team',       'team',    'B', 1, 'sent',     NOW() - INTERVAL  1 DAY);

-- ── Eventos A/B ────────────────────────────────────────────────────────────
-- Simula 7 dias de tráfego: variante B mostra taxa de conversão ligeiramente maior

INSERT IGNORE INTO `ab_events` (variant, event_type, created_at) VALUES
    -- Dia 7 (mais antigo)
    ('A', 'view',       NOW() - INTERVAL 7 DAY), ('A', 'view',       NOW() - INTERVAL 7 DAY),
    ('A', 'view',       NOW() - INTERVAL 7 DAY), ('A', 'conversion', NOW() - INTERVAL 7 DAY),
    ('B', 'view',       NOW() - INTERVAL 7 DAY), ('B', 'view',       NOW() - INTERVAL 7 DAY),
    ('B', 'view',       NOW() - INTERVAL 7 DAY), ('B', 'view',       NOW() - INTERVAL 7 DAY),
    ('B', 'conversion', NOW() - INTERVAL 7 DAY), ('B', 'conversion', NOW() - INTERVAL 7 DAY),
    -- Dia 6
    ('A', 'view',       NOW() - INTERVAL 6 DAY), ('A', 'view',       NOW() - INTERVAL 6 DAY),
    ('A', 'view',       NOW() - INTERVAL 6 DAY), ('A', 'view',       NOW() - INTERVAL 6 DAY),
    ('A', 'conversion', NOW() - INTERVAL 6 DAY),
    ('B', 'view',       NOW() - INTERVAL 6 DAY), ('B', 'view',       NOW() - INTERVAL 6 DAY),
    ('B', 'view',       NOW() - INTERVAL 6 DAY), ('B', 'view',       NOW() - INTERVAL 6 DAY),
    ('B', 'view',       NOW() - INTERVAL 6 DAY),
    ('B', 'conversion', NOW() - INTERVAL 6 DAY), ('B', 'conversion', NOW() - INTERVAL 6 DAY),
    -- Dia 5
    ('A', 'view',       NOW() - INTERVAL 5 DAY), ('A', 'view',       NOW() - INTERVAL 5 DAY),
    ('A', 'view',       NOW() - INTERVAL 5 DAY), ('A', 'view',       NOW() - INTERVAL 5 DAY),
    ('A', 'view',       NOW() - INTERVAL 5 DAY),
    ('A', 'conversion', NOW() - INTERVAL 5 DAY), ('A', 'conversion', NOW() - INTERVAL 5 DAY),
    ('B', 'view',       NOW() - INTERVAL 5 DAY), ('B', 'view',       NOW() - INTERVAL 5 DAY),
    ('B', 'view',       NOW() - INTERVAL 5 DAY), ('B', 'view',       NOW() - INTERVAL 5 DAY),
    ('B', 'conversion', NOW() - INTERVAL 5 DAY), ('B', 'conversion', NOW() - INTERVAL 5 DAY),
    ('B', 'conversion', NOW() - INTERVAL 5 DAY),
    -- Dia 4
    ('A', 'view',       NOW() - INTERVAL 4 DAY), ('A', 'view',       NOW() - INTERVAL 4 DAY),
    ('A', 'view',       NOW() - INTERVAL 4 DAY),
    ('A', 'conversion', NOW() - INTERVAL 4 DAY),
    ('B', 'view',       NOW() - INTERVAL 4 DAY), ('B', 'view',       NOW() - INTERVAL 4 DAY),
    ('B', 'view',       NOW() - INTERVAL 4 DAY), ('B', 'view',       NOW() - INTERVAL 4 DAY),
    ('B', 'view',       NOW() - INTERVAL 4 DAY),
    ('B', 'conversion', NOW() - INTERVAL 4 DAY), ('B', 'conversion', NOW() - INTERVAL 4 DAY),
    -- Dia 3
    ('A', 'view',       NOW() - INTERVAL 3 DAY), ('A', 'view',       NOW() - INTERVAL 3 DAY),
    ('A', 'view',       NOW() - INTERVAL 3 DAY), ('A', 'view',       NOW() - INTERVAL 3 DAY),
    ('A', 'conversion', NOW() - INTERVAL 3 DAY), ('A', 'conversion', NOW() - INTERVAL 3 DAY),
    ('B', 'view',       NOW() - INTERVAL 3 DAY), ('B', 'view',       NOW() - INTERVAL 3 DAY),
    ('B', 'view',       NOW() - INTERVAL 3 DAY), ('B', 'view',       NOW() - INTERVAL 3 DAY),
    ('B', 'view',       NOW() - INTERVAL 3 DAY),
    ('B', 'conversion', NOW() - INTERVAL 3 DAY), ('B', 'conversion', NOW() - INTERVAL 3 DAY),
    ('B', 'conversion', NOW() - INTERVAL 3 DAY),
    -- Dia 2
    ('A', 'view',       NOW() - INTERVAL 2 DAY), ('A', 'view',       NOW() - INTERVAL 2 DAY),
    ('A', 'view',       NOW() - INTERVAL 2 DAY),
    ('A', 'conversion', NOW() - INTERVAL 2 DAY),
    ('B', 'view',       NOW() - INTERVAL 2 DAY), ('B', 'view',       NOW() - INTERVAL 2 DAY),
    ('B', 'view',       NOW() - INTERVAL 2 DAY), ('B', 'view',       NOW() - INTERVAL 2 DAY),
    ('B', 'conversion', NOW() - INTERVAL 2 DAY), ('B', 'conversion', NOW() - INTERVAL 2 DAY),
    -- Ontem
    ('A', 'view',       NOW() - INTERVAL 1 DAY), ('A', 'view',       NOW() - INTERVAL 1 DAY),
    ('A', 'view',       NOW() - INTERVAL 1 DAY), ('A', 'view',       NOW() - INTERVAL 1 DAY),
    ('A', 'view',       NOW() - INTERVAL 1 DAY),
    ('A', 'conversion', NOW() - INTERVAL 1 DAY), ('A', 'conversion', NOW() - INTERVAL 1 DAY),
    ('B', 'view',       NOW() - INTERVAL 1 DAY), ('B', 'view',       NOW() - INTERVAL 1 DAY),
    ('B', 'view',       NOW() - INTERVAL 1 DAY), ('B', 'view',       NOW() - INTERVAL 1 DAY),
    ('B', 'view',       NOW() - INTERVAL 1 DAY), ('B', 'view',       NOW() - INTERVAL 1 DAY),
    ('B', 'conversion', NOW() - INTERVAL 1 DAY), ('B', 'conversion', NOW() - INTERVAL 1 DAY),
    ('B', 'conversion', NOW() - INTERVAL 1 DAY);
