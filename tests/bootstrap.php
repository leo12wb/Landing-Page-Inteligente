<?php

declare(strict_types=1);

require_once __DIR__ . '/../vendor/autoload.php';

// Carrega .env de teste se existir
$envPath = __DIR__ . '/..';
if (file_exists($envPath . '/.env.testing')) {
    $dotenv = Dotenv\Dotenv::createImmutable($envPath, '.env.testing');
    $dotenv->load();
} elseif (file_exists($envPath . '/.env')) {
    $dotenv = Dotenv\Dotenv::createImmutable($envPath);
    $dotenv->safeLoad();
}

// As variáveis de phpunit.xml têm prioridade (sobrescrevem as do .env)
