-- ─────────────────────────────────────────────────────────────────────────
-- Script de inicialização: cria o banco de dados de teste
--
-- Executado automaticamente pelo MySQL na primeira inicialização do contêiner
-- (todos os arquivos em /docker-entrypoint-initdb.d/ são executados em ordem).
--
-- O banco `devflow` é criado automaticamente via MYSQL_DATABASE no compose.yaml.
-- Este script cria `devflow_test` com o mesmo schema para os testes de integração.
-- ─────────────────────────────────────────────────────────────────────────

CREATE DATABASE IF NOT EXISTS `devflow_test`
    CHARACTER SET utf8mb4
    COLLATE utf8mb4_unicode_ci;

GRANT ALL PRIVILEGES ON `devflow_test`.* TO 'devflow'@'%';
FLUSH PRIVILEGES;

USE `devflow_test`;

-- ── Schema idêntico ao de produção ───────────────────────────────────────

CREATE TABLE IF NOT EXISTS `leads` (
    `id`                    BIGINT UNSIGNED      NOT NULL AUTO_INCREMENT,
    `public_id`             CHAR(16)             NOT NULL COMMENT 'Identificador público (sem expor ID interno)',
    `name`                  VARCHAR(100)         NOT NULL,
    `email`                 VARCHAR(400)         NOT NULL COMMENT 'E-mail criptografado (AES-256-GCM, base64)',
    `email_hash`            CHAR(64)             NOT NULL DEFAULT '' COMMENT 'HMAC-SHA256 do e-mail — para UNIQUE e lookup',
    `user_type`             ENUM('freelancer','developer','team') NOT NULL,
    `plan`                  ENUM('starter','pro','team')          NOT NULL,
    `ab_variant`            ENUM('A','B')        NOT NULL DEFAULT 'A',
    `ip_address`            VARCHAR(45)          NULL     COMMENT 'IPv4 ou IPv6 — apenas para rate limiting',
    `marketing_consent`     TINYINT(1)           NOT NULL DEFAULT 0,
    `marketing_consent_at`  DATETIME             NULL,
    `email_status`          ENUM('pending','sent','failed','skipped') NOT NULL DEFAULT 'pending',
    `created_at`            DATETIME             NOT NULL DEFAULT CURRENT_TIMESTAMP,
    `updated_at`            DATETIME             NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,

    PRIMARY KEY (`id`),
    UNIQUE KEY  `uq_leads_public_id`    (`public_id`),
    UNIQUE KEY  `uq_leads_email_hash`   (`email_hash`),
    INDEX       `idx_leads_created_at`   (`created_at`),
    INDEX       `idx_leads_plan`         (`plan`),
    INDEX       `idx_leads_user_type`    (`user_type`),
    INDEX       `idx_leads_ip_address`   (`ip_address`),
    INDEX       `idx_leads_email_status` (`email_status`)
) ENGINE=InnoDB
  DEFAULT CHARSET=utf8mb4
  COLLATE=utf8mb4_unicode_ci
  COMMENT='Cadastros de interesse da landing page';

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
