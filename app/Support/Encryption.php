<?php

declare(strict_types=1);

namespace App\Support;

/**
 * Utilitários de criptografia para dados pessoais (LGPD).
 *
 * Algoritmo: AES-256-GCM (autenticado — detecta adulteração).
 * Formato armazenado: base64( IV[12] + Tag[16] + Ciphertext )
 *
 * Busca/unicidade: HMAC-SHA-256 com chave separada (determinístico,
 * não expõe o valor original mas permite comparação e índice UNIQUE).
 *
 * Variáveis de ambiente necessárias:
 *   ENCRYPTION_KEY      — 64 hex chars (32 bytes / 256 bits)
 *   ENCRYPTION_HMAC_KEY — 64 hex chars (32 bytes / 256 bits)
 */
class Encryption
{
    private const CIPHER    = 'aes-256-gcm';
    private const IV_BYTES  = 12;
    private const TAG_BYTES = 16;

    // ── Criptografia reversível ───────────────────────────────────────────────

    public static function encrypt(string $plaintext): string
    {
        $key = self::encKey();
        $iv  = random_bytes(self::IV_BYTES);
        $tag = '';

        $ciphertext = openssl_encrypt(
            $plaintext,
            self::CIPHER,
            $key,
            OPENSSL_RAW_DATA,
            $iv,
            $tag,
            '',
            self::TAG_BYTES,
        );

        if ($ciphertext === false) {
            throw new \RuntimeException('Falha ao criptografar dado.');
        }

        return base64_encode($iv . $tag . $ciphertext);
    }

    public static function decrypt(string $encoded): string
    {
        $key  = self::encKey();
        $raw  = base64_decode($encoded, strict: true);

        if ($raw === false || strlen($raw) < self::IV_BYTES + self::TAG_BYTES + 1) {
            throw new \RuntimeException('Payload de criptografia inválido.');
        }

        $iv         = substr($raw, 0, self::IV_BYTES);
        $tag        = substr($raw, self::IV_BYTES, self::TAG_BYTES);
        $ciphertext = substr($raw, self::IV_BYTES + self::TAG_BYTES);

        $plaintext = openssl_decrypt(
            $ciphertext,
            self::CIPHER,
            $key,
            OPENSSL_RAW_DATA,
            $iv,
            $tag,
        );

        if ($plaintext === false) {
            throw new \RuntimeException('Falha ao descriptografar dado — tag inválida ou chave incorreta.');
        }

        return $plaintext;
    }

    // ── Hash determinístico para lookup / índice UNIQUE ───────────────────────

    public static function hash(string $value): string
    {
        return hash_hmac('sha256', strtolower(trim($value)), self::hmacKey());
    }

    // ── Chaves ────────────────────────────────────────────────────────────────

    private static function encKey(): string
    {
        $hex = $_ENV['ENCRYPTION_KEY'] ?? '';
        if (strlen($hex) !== 64) {
            throw new \RuntimeException('ENCRYPTION_KEY inválida ou ausente no .env (esperado: 64 hex chars).');
        }
        return hex2bin($hex);
    }

    private static function hmacKey(): string
    {
        $hex = $_ENV['ENCRYPTION_HMAC_KEY'] ?? '';
        if (strlen($hex) !== 64) {
            throw new \RuntimeException('ENCRYPTION_HMAC_KEY inválida ou ausente no .env (esperado: 64 hex chars).');
        }
        return hex2bin($hex);
    }
}
