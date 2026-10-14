<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Repositories\LeadRepository;
use App\Services\AbTestService;
use App\Support\Logger;

class LandingController
{
    public function index(): void
    {
        $abService = new AbTestService();
        $abVariant = $abService->getVariant();
        $heroTitle = $abService->getTitleForVariant($abVariant);

        // Registra visualização para A/B (sem dados pessoais)
        try {
            (new LeadRepository())->recordAbView($abVariant);
        } catch (\Throwable $e) {
            Logger::warning('Falha ao registrar AB view', ['error' => $e->getMessage()]);
        }

        // Headers de segurança (complementam o .htaccess)
        header('X-Content-Type-Options: nosniff');
        header('X-Frame-Options: DENY');
        header('Referrer-Policy: strict-origin-when-cross-origin');

        include __DIR__ . '/../../views/landing.php';
    }
}
