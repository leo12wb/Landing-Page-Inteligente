-- ─────────────────────────────────────────────────────────────────────────
-- Migration 002: Tabela de eventos A/B
-- Registra visualizações e conversões para comparar as variantes do título.
--
-- Limitações documentadas:
--   - Cada page refresh pode registrar uma nova visualização (sem deduplicação por sessão).
--   - O volume de dados nesta tabela pode crescer rapidamente; considere TTL/purga periódica.
--   - Não vincule eventos de visualização a dados pessoais.
-- ─────────────────────────────────────────────────────────────────────────

CREATE TABLE IF NOT EXISTS `ab_events` (
    `id`         BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
    `variant`    ENUM('A','B')   NOT NULL,
    `event_type` ENUM('view','conversion') NOT NULL DEFAULT 'view',
    `created_at` DATETIME        NOT NULL DEFAULT CURRENT_TIMESTAMP,

    PRIMARY KEY (`id`),
    INDEX `idx_ab_variant_event` (`variant`, `event_type`),
    INDEX `idx_ab_created_at`   (`created_at`)
) ENGINE=InnoDB
  DEFAULT CHARSET=utf8mb4
  COLLATE=utf8mb4_unicode_ci
  COMMENT='Eventos do teste A/B (sem dados pessoais)';
