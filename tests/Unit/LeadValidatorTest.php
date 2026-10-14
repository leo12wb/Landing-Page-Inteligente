<?php

declare(strict_types=1);

namespace Tests\Unit;

use App\Validators\LeadValidator;
use PHPUnit\Framework\TestCase;

class LeadValidatorTest extends TestCase
{
    private LeadValidator $validator;

    protected function setUp(): void
    {
        $this->validator = new LeadValidator();
    }

    private function validData(array $overrides = []): array
    {
        return array_merge([
            'name'             => 'Leonardo Teste',
            'email'            => 'leonardo@example.com',
            'user_type'        => 'developer',
            'plan'             => 'pro',
            'contact_consent'  => true,
        ], $overrides);
    }

    // ── Nome ────────────────────────────────────────────────────────────────

    public function testValidDataPasses(): void
    {
        $result = $this->validator->validate($this->validData());
        $this->assertTrue($result);
        $this->assertEmpty($this->validator->getErrors());
    }

    public function testEmptyNameFails(): void
    {
        $result = $this->validator->validate($this->validData(['name' => '']));
        $this->assertFalse($result);
        $this->assertArrayHasKey('name', $this->validator->getErrors());
    }

    public function testWhitespaceOnlyNameFails(): void
    {
        $result = $this->validator->validate($this->validData(['name' => '   ']));
        $this->assertFalse($result);
        $this->assertArrayHasKey('name', $this->validator->getErrors());
    }

    public function testShortNameFails(): void
    {
        $result = $this->validator->validate($this->validData(['name' => 'A']));
        $this->assertFalse($result);
        $this->assertArrayHasKey('name', $this->validator->getErrors());
    }

    public function testLongNameFails(): void
    {
        $result = $this->validator->validate($this->validData(['name' => str_repeat('A', 101)]));
        $this->assertFalse($result);
        $this->assertArrayHasKey('name', $this->validator->getErrors());
    }

    public function testNameAt100CharsPass(): void
    {
        $result = $this->validator->validate($this->validData(['name' => str_repeat('A', 100)]));
        $this->assertTrue($result);
    }

    // ── E-mail ───────────────────────────────────────────────────────────────

    public function testEmptyEmailFails(): void
    {
        $result = $this->validator->validate($this->validData(['email' => '']));
        $this->assertFalse($result);
        $this->assertArrayHasKey('email', $this->validator->getErrors());
    }

    public function testInvalidEmailFails(): void
    {
        $result = $this->validator->validate($this->validData(['email' => 'not-an-email']));
        $this->assertFalse($result);
        $this->assertArrayHasKey('email', $this->validator->getErrors());
    }

    public function testEmailMissingDomainFails(): void
    {
        $result = $this->validator->validate($this->validData(['email' => 'user@']));
        $this->assertFalse($result);
        $this->assertArrayHasKey('email', $this->validator->getErrors());
    }

    public function testValidEmailPasses(): void
    {
        $result = $this->validator->validate($this->validData(['email' => 'user@example.com.br']));
        $this->assertTrue($result);
    }

    // ── Tipo de usuário ──────────────────────────────────────────────────────

    public function testEmptyUserTypeFails(): void
    {
        $result = $this->validator->validate($this->validData(['user_type' => '']));
        $this->assertFalse($result);
        $this->assertArrayHasKey('user_type', $this->validator->getErrors());
    }

    public function testInvalidUserTypeFails(): void
    {
        $result = $this->validator->validate($this->validData(['user_type' => 'admin']));
        $this->assertFalse($result);
        $this->assertArrayHasKey('user_type', $this->validator->getErrors());
    }

    public function testValidUserTypesPass(): void
    {
        foreach (['freelancer', 'developer', 'team'] as $type) {
            $result = $this->validator->validate($this->validData(['user_type' => $type]));
            $this->assertTrue($result, "user_type '{$type}' should pass");
        }
    }

    // ── Plano ────────────────────────────────────────────────────────────────

    public function testEmptyPlanFails(): void
    {
        $result = $this->validator->validate($this->validData(['plan' => '']));
        $this->assertFalse($result);
        $this->assertArrayHasKey('plan', $this->validator->getErrors());
    }

    public function testInvalidPlanFails(): void
    {
        $result = $this->validator->validate($this->validData(['plan' => 'enterprise']));
        $this->assertFalse($result);
        $this->assertArrayHasKey('plan', $this->validator->getErrors());
    }

    public function testValidPlansPass(): void
    {
        foreach (['starter', 'pro', 'team'] as $plan) {
            $result = $this->validator->validate($this->validData(['plan' => $plan]));
            $this->assertTrue($result, "plan '{$plan}' should pass");
        }
    }

    // ── Consentimento ────────────────────────────────────────────────────────

    public function testFalseConsentFails(): void
    {
        $result = $this->validator->validate($this->validData(['contact_consent' => false]));
        $this->assertFalse($result);
        $this->assertArrayHasKey('contact_consent', $this->validator->getErrors());
    }

    public function testMissingConsentFails(): void
    {
        $data = $this->validData();
        unset($data['contact_consent']);
        $result = $this->validator->validate($data);
        $this->assertFalse($result);
        $this->assertArrayHasKey('contact_consent', $this->validator->getErrors());
    }

    public function testTrueConsentPasses(): void
    {
        $result = $this->validator->validate($this->validData(['contact_consent' => true]));
        $this->assertTrue($result);
    }

    // ── Múltiplos erros ──────────────────────────────────────────────────────

    public function testMultipleErrorsReturned(): void
    {
        $result = $this->validator->validate([
            'name'            => '',
            'email'           => 'invalid',
            'user_type'       => '',
            'plan'            => '',
            'contact_consent' => false,
        ]);
        $this->assertFalse($result);
        $errors = $this->validator->getErrors();
        $this->assertCount(5, $errors);
    }
}
