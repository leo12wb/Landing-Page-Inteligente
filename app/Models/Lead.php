<?php

declare(strict_types=1);

namespace App\Models;

class Lead
{
    public function __construct(
        public readonly string  $name,
        public readonly string  $email,
        public readonly string  $userType,
        public readonly string  $plan,
        public readonly string  $abVariant,
        public readonly bool    $marketingConsent = false,
        public readonly ?int    $id          = null,
        public readonly ?string $publicId    = null,
        public readonly string  $emailStatus = 'pending',
        public readonly ?string $createdAt   = null,
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            name:             $data['name'],
            email:            $data['email'],
            userType:         $data['user_type'],
            plan:             $data['plan'],
            abVariant:        $data['ab_variant'],
            marketingConsent: (bool) ($data['marketing_consent'] ?? false),
            id:               isset($data['id']) ? (int) $data['id'] : null,
            publicId:         $data['public_id'] ?? null,
            emailStatus:      $data['email_status'] ?? 'pending',
            createdAt:        $data['created_at'] ?? null,
        );
    }
}
