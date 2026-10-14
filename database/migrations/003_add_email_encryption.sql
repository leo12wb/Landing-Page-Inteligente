-- ─────────────────────────────────────────────────────────────────────────
-- Migration 003: Criptografia de e-mail (LGPD)
--
-- Adiciona `email_hash` (HMAC-SHA256, determinístico) para manter unicidade
-- e lookup sem expor o valor em texto plano.
-- O campo `email` passa a armazenar o valor criptografado (AES-256-GCM)
-- e cresce para VARCHAR(400) para comportar o payload base64.
--
-- IMPORTANTE: execute este script ANTES de inserir dados de produção.
-- Dados já existentes precisam ser re-cifrados via script de migração.
-- ─────────────────────────────────────────────────────────────────────────

ALTER TABLE `leads`
    -- Adiciona coluna de hash para unicidade e busca
    ADD COLUMN `email_hash` CHAR(64) NOT NULL DEFAULT ''
        COMMENT 'HMAC-SHA256 do e-mail normalizado — para UNIQUE e lookup'
        AFTER `email`,

    -- Expande email para comportar o payload criptografado base64
    MODIFY COLUMN `email` VARCHAR(400) NOT NULL
        COMMENT 'E-mail criptografado (AES-256-GCM, base64)',

    -- Move a chave única de email → email_hash
    DROP INDEX  `uq_leads_email`,
    ADD  UNIQUE KEY `uq_leads_email_hash` (`email_hash`);
