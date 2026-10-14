<?php

declare(strict_types=1);

namespace App\Support;

class Router
{
    private array $routes = [];

    public function get(string $path, array|callable $handler): void
    {
        $this->routes['GET'][$path] = $handler;
    }

    public function post(string $path, array|callable $handler): void
    {
        $this->routes['POST'][$path] = $handler;
    }

    public function dispatch(): void
    {
        $method = $_SERVER['REQUEST_METHOD'] ?? 'GET';
        $uri    = parse_url($_SERVER['REQUEST_URI'] ?? '/', PHP_URL_PATH);
        $uri    = rtrim($uri ?: '/', '/') ?: '/';

        if (!isset($this->routes[$method][$uri])) {
            $this->notFound($uri);
            return;
        }

        $handler = $this->routes[$method][$uri];

        if (is_array($handler)) {
            [$class, $action] = $handler;
            (new $class())->$action();
        } else {
            $handler();
        }
    }

    private function notFound(string $uri): void
    {
        http_response_code(404);
        if (str_starts_with($uri, '/api/')) {
            header('Content-Type: application/json; charset=utf-8');
            echo json_encode(['success' => false, 'message' => 'Endpoint não encontrado.']);
        } else {
            echo '<h1>404 — Página não encontrada.</h1>';
        }
    }
}
