<?php

declare(strict_types=1);

// Nunca exibir erros ao visitante
ini_set('display_errors', '0');
error_reporting(E_ALL);

// Autoload
require_once __DIR__ . '/../vendor/autoload.php';

// Carrega variáveis de ambiente
$envPath = __DIR__ . '/..';
if (file_exists($envPath . '/.env')) {
    $dotenv = Dotenv\Dotenv::createImmutable($envPath);
    $dotenv->load();
}

// Handler global de exceções não capturadas
set_exception_handler(static function (\Throwable $e): void {
    App\Support\Logger::error('Exceção não capturada', [
        'message' => $e->getMessage(),
        'file'    => $e->getFile(),
        'line'    => $e->getLine(),
    ]);

    http_response_code(500);
    $isApi = str_starts_with($_SERVER['REQUEST_URI'] ?? '', '/api/');
    if ($isApi) {
        header('Content-Type: application/json; charset=utf-8');
        echo json_encode(['success' => false, 'message' => 'Erro interno do servidor.']);
    } else {
        echo '<h1>Erro interno do servidor.</h1><p>Tente novamente mais tarde.</p>';
    }
    exit;
});

// Roteamento
require_once __DIR__ . '/../routes/web.php';
