<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Support\Database;
use App\Support\Response;

class HealthController
{
    public function index(): void
    {
        $status = 'ok';
        $checks = [];

        try {
            Database::getConnection()->query('SELECT 1');
            $checks['database'] = 'ok';
        } catch (\Throwable) {
            $checks['database'] = 'error';
            $status             = 'degraded';
        }

        Response::json([
            'status'  => $status,
            'checks'  => $checks,
            'version' => $_ENV['APP_VERSION'] ?? '1.0.0',
        ], $status === 'ok' ? 200 : 503);
    }
}
