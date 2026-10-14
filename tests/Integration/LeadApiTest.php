<?php

declare(strict_types=1);

namespace Tests\Integration;

use App\Support\Database;
use PHPUnit\Framework\TestCase;

/**
 * Testes de integração da API de leads.
 *
 * Requerem banco de dados ativo (devflow_test).
 * Execute dentro do contêiner: docker exec devflow-app vendor/bin/phpunit --testsuite Integration
 *
 * O banco de teste é limpo antes de cada teste para garantir isolamento.
 */
class LeadApiTest extends TestCase
{
    protected function setUp(): void
    {
        // Limpa tabela de leads e eventos entre testes
        try {
            $db = Database::getConnection();
            $db->exec('DELETE FROM ab_events');
            $db->exec('DELETE FROM leads');
        } catch (\Throwable $e) {
            $this->markTestSkipped('Banco de dados não disponível: ' . $e->getMessage());
        }
    }

    // ── POST /api/leads — Cadastro válido ─────────────────────────────────────

    public function testPostLeadsSuccessReturns201(): void
    {
        $repo    = new \App\Repositories\LeadRepository();
        $service = new \App\Services\LeadService($repo, $this->mockEmail());

        $result = $service->register([
            'name'             => 'Integration Test',
            'email'            => 'integration@test.com',
            'user_type'        => 'developer',
            'plan'             => 'pro',
            'contact_consent'  => true,
            'marketing_consent'=> false,
            'ab_variant'       => 'B',
        ], '127.0.0.1');

        $this->assertTrue($result['success']);
        $this->assertEquals(201, $result['code']);
        $this->assertNotEmpty($result['public_id']);
        $this->assertEquals(16, strlen($result['public_id']));
    }

    // ── E-mail duplicado ──────────────────────────────────────────────────────

    public function testDuplicateEmailReturns409(): void
    {
        $repo    = new \App\Repositories\LeadRepository();
        $service = new \App\Services\LeadService($repo, $this->mockEmail());

        $data = [
            'name'            => 'Duplicate Test',
            'email'           => 'duplicate@test.com',
            'user_type'       => 'freelancer',
            'plan'            => 'starter',
            'contact_consent' => true,
            'ab_variant'      => 'A',
        ];

        $first  = $service->register($data, '127.0.0.1');
        $second = $service->register($data, '127.0.0.2');

        $this->assertTrue($first['success']);
        $this->assertFalse($second['success']);
        $this->assertEquals(409, $second['code']);
    }

    // ── Persistência no banco ─────────────────────────────────────────────────

    public function testLeadIsPersistedInDatabase(): void
    {
        $repo    = new \App\Repositories\LeadRepository();
        $service = new \App\Services\LeadService($repo, $this->mockEmail());

        $result = $service->register([
            'name'            => 'Persistence Test',
            'email'           => 'persist@test.com',
            'user_type'       => 'team',
            'plan'            => 'team',
            'contact_consent' => true,
            'ab_variant'      => 'A',
        ], '10.0.0.1');

        $this->assertTrue($result['success']);

        $found = $repo->findByEmail('persist@test.com');
        $this->assertNotNull($found);
        $this->assertEquals('Persistence Test', $found->name);
        $this->assertEquals('team', $found->plan);
        $this->assertEquals($result['public_id'], $found->publicId);
    }

    // ── Rate limiting ─────────────────────────────────────────────────────────

    public function testRateLimitingBlocksExcessRequests(): void
    {
        $repo    = new \App\Repositories\LeadRepository();
        $service = new \App\Services\LeadService($repo, $this->mockEmail());
        $ip      = '192.168.1.100';

        // 3 cadastros do mesmo IP (limite)
        for ($i = 1; $i <= 3; $i++) {
            $service->register([
                'name'            => "User {$i}",
                'email'           => "ratelimit{$i}@test.com",
                'user_type'       => 'developer',
                'plan'            => 'starter',
                'contact_consent' => true,
                'ab_variant'      => 'A',
            ], $ip);
        }

        // 4º do mesmo IP deve ser bloqueado
        $blocked = $service->register([
            'name'            => 'Blocked User',
            'email'           => 'blocked@test.com',
            'user_type'       => 'developer',
            'plan'            => 'starter',
            'contact_consent' => true,
            'ab_variant'      => 'A',
        ], $ip);

        $this->assertFalse($blocked['success']);
        $this->assertEquals(429, $blocked['code']);
    }

    // ── Health check ──────────────────────────────────────────────────────────

    public function testDatabaseConnectionHealthy(): void
    {
        $db = Database::getConnection();
        $result = $db->query('SELECT 1')->fetchColumn();
        $this->assertEquals('1', (string) $result);
    }

    private function mockEmail(): \App\Services\EmailService
    {
        $mock = $this->createMock(\App\Services\EmailService::class);
        $mock->method('sendConfirmation')->willReturn(false);
        return $mock;
    }
}
