<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Services\LeadService;
use App\Support\Response;
use App\Validators\LeadValidator;

class LeadController
{
    public function store(): void
    {
        // Valida Content-Type
        $contentType = $_SERVER['CONTENT_TYPE'] ?? '';
        if (!str_contains($contentType, 'application/json')) {
            Response::error('Content-Type deve ser application/json.', [], 415);
        }

        // Limita tamanho do body
        $rawBody = file_get_contents('php://input');
        if (strlen($rawBody) > 10_240) {
            Response::error('Requisição muito grande.', [], 413);
        }

        $data = json_decode($rawBody, true);
        if (!is_array($data)) {
            Response::error('JSON inválido.', [], 400);
        }

        $validator = new LeadValidator();
        if (!$validator->validate($data)) {
            Response::error('Verifique os dados informados.', $validator->getErrors(), 422);
        }

        $ip      = $this->resolveIp();
        $service = new LeadService();
        $result  = $service->register($data, $ip);

        Response::json([
            'success' => $result['success'],
            'message' => $result['message'],
            'data'    => $result['success'] ? ['id' => $result['public_id']] : new \stdClass(),
        ], $result['code']);
    }

    public function index(): void
    {
        $adminToken = $_ENV['ADMIN_TOKEN'] ?? '';
        $provided   = $this->extractBearerToken();

        if (empty($adminToken) || !hash_equals($adminToken, $provided)) {
            header('WWW-Authenticate: Bearer realm="DevFlow Admin"');
            Response::error('Acesso não autorizado.', [], 401);
        }

        $page    = max(1, (int) ($_GET['page']     ?? 1));
        $perPage = min(100, max(1, (int) ($_GET['per_page'] ?? 20)));
        $filters = [
            'plan'      => $_GET['plan']      ?? null,
            'user_type' => $_GET['user_type'] ?? null,
        ];

        $service = new LeadService();
        $result  = $service->getPaginated($page, $perPage, $filters);

        Response::success('Leads obtidos com sucesso.', $result);
    }

    private function extractBearerToken(): string
    {
        $header = $_SERVER['HTTP_AUTHORIZATION'] ?? '';
        if (str_starts_with($header, 'Bearer ')) {
            return substr($header, 7);
        }
        return '';
    }

    private function resolveIp(): string
    {
        $forwarded = $_SERVER['HTTP_X_FORWARDED_FOR'] ?? '';
        if ($forwarded) {
            return trim(explode(',', $forwarded)[0]);
        }
        return $_SERVER['REMOTE_ADDR'] ?? '';
    }
}
