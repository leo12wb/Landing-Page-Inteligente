<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\Lead;
use App\Repositories\LeadRepository;
use App\Support\Logger;

class LeadService
{
    private LeadRepository $repository;
    private EmailService   $emailService;

    public function __construct(
        ?LeadRepository $repository   = null,
        ?EmailService   $emailService = null,
    ) {
        $this->repository   = $repository   ?? new LeadRepository();
        $this->emailService = $emailService ?? new EmailService();
    }

    public function register(array $data, string $ipAddress = ''): array
    {
        // Rate limiting: máx. 3 cadastros por IP por hora
        if (!empty($ipAddress)) {
            $recentCount = $this->repository->countRecentByIp($ipAddress, 60);
            if ($recentCount >= 3) {
                return [
                    'success' => false,
                    'code'    => 429,
                    'message' => 'Muitas tentativas. Aguarde um momento e tente novamente.',
                ];
            }
        }

        // Verificar e-mail duplicado
        $existing = $this->repository->findByEmail($data['email'] ?? '');
        if ($existing !== null) {
            return [
                'success' => false,
                'code'    => 409,
                'message' => 'Este e-mail já foi cadastrado.',
            ];
        }

        $abVariant = strtoupper($data['ab_variant'] ?? 'A');
        if (!in_array($abVariant, ['A', 'B'], true)) {
            $abVariant = 'A';
        }

        $lead = new Lead(
            name:             trim($data['name']),
            email:            strtolower(trim($data['email'])),
            userType:         strtolower(trim($data['user_type'])),
            plan:             strtolower(trim($data['plan'])),
            abVariant:        $abVariant,
            marketingConsent: filter_var($data['marketing_consent'] ?? false, FILTER_VALIDATE_BOOLEAN),
        );

        try {
            $saved = $this->repository->create($lead, $ipAddress);
        } catch (\Throwable $e) {
            Logger::error('Falha ao criar lead', ['message' => $e->getMessage()]);
            return [
                'success' => false,
                'code'    => 500,
                'message' => 'Erro ao processar o cadastro. Tente novamente.',
            ];
        }

        // Envio de e-mail: falha não cancela o cadastro
        $emailSent   = $this->emailService->sendConfirmation($saved);
        $emailStatus = $emailSent ? 'sent' : 'pending';

        try {
            $this->repository->updateEmailStatus($saved->id, $emailStatus);
        } catch (\Throwable $e) {
            Logger::warning('Falha ao atualizar status do e-mail', ['message' => $e->getMessage()]);
        }

        Logger::info('Lead cadastrado com sucesso.', ['public_id' => $saved->publicId]);

        return [
            'success'    => true,
            'code'       => 201,
            'message'    => 'Cadastro recebido com sucesso!',
            'public_id'  => $saved->publicId,
            'email_sent' => $emailSent,
        ];
    }

    public function getPaginated(int $page, int $perPage, array $filters): array
    {
        $leads = $this->repository->findAll($page, $perPage, $filters);
        $total = $this->repository->countAll($filters);

        return [
            'items' => $leads,
            'meta'  => [
                'page'     => $page,
                'per_page' => $perPage,
                'total'    => $total,
                'pages'    => $total > 0 ? (int) ceil($total / $perPage) : 0,
            ],
        ];
    }
}
