<?php

declare(strict_types=1);

namespace App\Validators;

class LeadValidator
{
    private const VALID_USER_TYPES = ['freelancer', 'developer', 'team'];
    private const VALID_PLANS      = ['starter', 'pro', 'team'];
    private const MAX_NAME_LENGTH  = 100;
    private const MAX_EMAIL_LENGTH = 254;

    private array $errors = [];

    public function validate(array $data): bool
    {
        $this->errors = [];

        $this->validateName($data['name'] ?? null);
        $this->validateEmail($data['email'] ?? null);
        $this->validateUserType($data['user_type'] ?? null);
        $this->validatePlan($data['plan'] ?? null);
        $this->validateContactConsent($data['contact_consent'] ?? null);

        return empty($this->errors);
    }

    private function validateName(mixed $name): void
    {
        if (!is_string($name) || trim($name) === '') {
            $this->errors['name'] = 'O nome é obrigatório.';
            return;
        }

        $trimmed = trim($name);

        if (strlen($trimmed) < 2) {
            $this->errors['name'] = 'O nome deve ter pelo menos 2 caracteres.';
            return;
        }

        if (strlen($trimmed) > self::MAX_NAME_LENGTH) {
            $this->errors['name'] = 'O nome deve ter no máximo ' . self::MAX_NAME_LENGTH . ' caracteres.';
        }
    }

    private function validateEmail(mixed $email): void
    {
        if (!is_string($email) || trim($email) === '') {
            $this->errors['email'] = 'O e-mail é obrigatório.';
            return;
        }

        $trimmed = trim($email);

        if (strlen($trimmed) > self::MAX_EMAIL_LENGTH) {
            $this->errors['email'] = 'O e-mail é muito longo.';
            return;
        }

        if (!filter_var($trimmed, FILTER_VALIDATE_EMAIL)) {
            $this->errors['email'] = 'Informe um e-mail válido.';
        }
    }

    private function validateUserType(mixed $userType): void
    {
        if (!is_string($userType) || trim($userType) === '') {
            $this->errors['user_type'] = 'Selecione o tipo de usuário.';
            return;
        }

        if (!in_array(strtolower(trim($userType)), self::VALID_USER_TYPES, true)) {
            $this->errors['user_type'] = 'Tipo de usuário inválido.';
        }
    }

    private function validatePlan(mixed $plan): void
    {
        if (!is_string($plan) || trim($plan) === '') {
            $this->errors['plan'] = 'Selecione um plano.';
            return;
        }

        if (!in_array(strtolower(trim($plan)), self::VALID_PLANS, true)) {
            $this->errors['plan'] = 'Plano inválido.';
        }
    }

    private function validateContactConsent(mixed $consent): void
    {
        $value = filter_var($consent, FILTER_VALIDATE_BOOLEAN, FILTER_NULL_ON_FAILURE);
        if ($value !== true) {
            $this->errors['contact_consent'] = 'Você precisa aceitar os termos para prosseguir.';
        }
    }

    public function getErrors(): array
    {
        return $this->errors;
    }
}
