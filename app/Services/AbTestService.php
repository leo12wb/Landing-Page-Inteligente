<?php

declare(strict_types=1);

namespace App\Services;

class AbTestService
{
    private const COOKIE_NAME = 'devflow_ab';
    private const VARIANTS    = ['A', 'B'];
    private const COOKIE_TTL  = 30 * 24 * 60 * 60; // 30 dias

    public function getVariant(): string
    {
        if (isset($_COOKIE[self::COOKIE_NAME])) {
            $v = strtoupper($_COOKIE[self::COOKIE_NAME]);
            if (in_array($v, self::VARIANTS, true)) {
                return $v;
            }
        }

        $variant = self::VARIANTS[random_int(0, 1)];
        $this->persistCookie($variant);

        return $variant;
    }

    public function getTitleForVariant(string $variant): string
    {
        return match (strtoupper($variant)) {
            'B'     => 'Menos tarefas perdidas. Mais projetos concluídos.',
            default => 'Seus projetos organizados. Seu foco no que importa.',
        };
    }

    private function persistCookie(string $variant): void
    {
        $isProduction = ($_ENV['APP_ENV'] ?? 'development') === 'production';

        setcookie(self::COOKIE_NAME, $variant, [
            'expires'  => time() + self::COOKIE_TTL,
            'path'     => '/',
            'secure'   => $isProduction,
            'httponly' => true,
            'samesite' => 'Lax',
        ]);

        $_COOKIE[self::COOKIE_NAME] = $variant;
    }
}
