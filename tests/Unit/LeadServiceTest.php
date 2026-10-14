<?php

declare(strict_types=1);

namespace Tests\Unit;

use App\Models\Lead;
use App\Repositories\LeadRepository;
use App\Services\EmailService;
use App\Services\LeadService;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

class LeadServiceTest extends TestCase
{
    private LeadRepository&MockObject $repository;
    private EmailService&MockObject   $emailService;
    private LeadService               $service;

    protected function setUp(): void
    {
        $this->repository   = $this->createMock(LeadRepository::class);
        $this->emailService = $this->createMock(EmailService::class);
        $this->service      = new LeadService($this->repository, $this->emailService);
    }

    private function validPayload(array $overrides = []): array
    {
        return array_merge([
            'name'             => 'Leonardo Teste',
            'email'            => 'leonardo@example.com',
            'user_type'        => 'developer',
            'plan'             => 'pro',
            'contact_consent'  => true,
            'marketing_consent'=> false,
            'ab_variant'       => 'A',
        ], $overrides);
    }

    private function makeLead(): Lead
    {
        return new Lead(
            name:      'Leonardo Teste',
            email:     'leonardo@example.com',
            userType:  'developer',
            plan:      'pro',
            abVariant: 'A',
            id:        1,
            publicId:  'abc123abc123abc1',
        );
    }

    // ── Cadastro bem-sucedido ─────────────────────────────────────────────────

    public function testRegisterSuccessfully(): void
    {
        $this->repository->method('countRecentByIp')->willReturn(0);
        $this->repository->method('findByEmail')->willReturn(null);
        $this->repository->method('create')->willReturn($this->makeLead());
        $this->emailService->method('sendConfirmation')->willReturn(true);

        $result = $this->service->register($this->validPayload(), '127.0.0.1');

        $this->assertTrue($result['success']);
        $this->assertEquals(201, $result['code']);
        $this->assertNotEmpty($result['public_id']);
    }

    // ── E-mail duplicado ──────────────────────────────────────────────────────

    public function testRegisterDuplicateEmailReturns409(): void
    {
        $this->repository->method('countRecentByIp')->willReturn(0);
        $this->repository->method('findByEmail')->willReturn($this->makeLead());

        $result = $this->service->register($this->validPayload(), '127.0.0.1');

        $this->assertFalse($result['success']);
        $this->assertEquals(409, $result['code']);
    }

    // ── Rate limiting ─────────────────────────────────────────────────────────

    public function testRegisterRateLimitedReturns429(): void
    {
        $this->repository->method('countRecentByIp')->willReturn(3);

        $result = $this->service->register($this->validPayload(), '10.0.0.1');

        $this->assertFalse($result['success']);
        $this->assertEquals(429, $result['code']);
    }

    // ── Falha do banco não expõe detalhes internos ────────────────────────────

    public function testDatabaseFailureReturns500(): void
    {
        $this->repository->method('countRecentByIp')->willReturn(0);
        $this->repository->method('findByEmail')->willReturn(null);
        $this->repository->method('create')->willThrowException(new \RuntimeException('DB down'));

        $result = $this->service->register($this->validPayload(), '127.0.0.1');

        $this->assertFalse($result['success']);
        $this->assertEquals(500, $result['code']);
        $this->assertStringNotContainsString('DB down', $result['message']);
    }

    // ── Falha de e-mail NÃO cancela o cadastro ───────────────────────────────

    public function testEmailFailureDoesNotCancelRegistration(): void
    {
        $this->repository->method('countRecentByIp')->willReturn(0);
        $this->repository->method('findByEmail')->willReturn(null);
        $this->repository->method('create')->willReturn($this->makeLead());
        $this->emailService->method('sendConfirmation')->willReturn(false);
        $this->repository->expects($this->once())->method('updateEmailStatus');

        $result = $this->service->register($this->validPayload(), '127.0.0.1');

        $this->assertTrue($result['success']);
        $this->assertEquals(201, $result['code']);
        $this->assertFalse($result['email_sent']);
    }

    // ── Variante A/B inválida é normalizada ──────────────────────────────────

    public function testInvalidAbVariantDefaultsToA(): void
    {
        $this->repository->method('countRecentByIp')->willReturn(0);
        $this->repository->method('findByEmail')->willReturn(null);

        $this->repository->expects($this->once())
            ->method('create')
            ->with($this->callback(fn(Lead $lead) => $lead->abVariant === 'A'))
            ->willReturn($this->makeLead());

        $this->emailService->method('sendConfirmation')->willReturn(false);

        $this->service->register($this->validPayload(['ab_variant' => 'Z']), '127.0.0.1');
    }
}
