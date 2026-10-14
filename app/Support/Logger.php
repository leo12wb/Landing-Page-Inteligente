<?php

declare(strict_types=1);

namespace App\Support;

class Logger
{
    private static function write(string $level, string $message, array $context = []): void
    {
        $logDir  = __DIR__ . '/../../storage/logs';
        $logFile = $logDir . '/app.log';

        if (!is_dir($logDir)) {
            mkdir($logDir, 0775, true);
        }

        $safe = self::sanitize($context);
        $line = sprintf(
            "[%s] [%s] %s%s\n",
            date('Y-m-d H:i:s'),
            strtoupper($level),
            $message,
            empty($safe) ? '' : ' ' . json_encode($safe, JSON_UNESCAPED_UNICODE)
        );

        file_put_contents($logFile, $line, FILE_APPEND | LOCK_EX);
    }

    /** Remove campos sensíveis antes de logar. */
    private static function sanitize(array $context): array
    {
        $sensitive = ['password', 'api_key', 'token', 'secret', 'resend_api_key', 'admin_token'];
        foreach ($sensitive as $key) {
            if (array_key_exists($key, $context)) {
                $context[$key] = '[REDACTED]';
            }
        }
        return $context;
    }

    public static function info(string $message, array $context = []): void
    {
        self::write('info', $message, $context);
    }

    public static function warning(string $message, array $context = []): void
    {
        self::write('warning', $message, $context);
    }

    public static function error(string $message, array $context = []): void
    {
        self::write('error', $message, $context);
    }
}
