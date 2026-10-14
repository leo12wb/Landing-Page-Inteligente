<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Models\Lead;
use App\Support\Database;
use App\Support\Encryption;
use App\Support\Logger;
use PDO;

class LeadRepository
{
    private PDO $db;

    public function __construct()
    {
        $this->db = Database::getConnection();
    }

    public function findByEmail(string $email): ?Lead
    {
        $hash = Encryption::hash($email);
        $stmt = $this->db->prepare('SELECT * FROM leads WHERE email_hash = ? LIMIT 1');
        $stmt->execute([$hash]);
        $row = $stmt->fetch();

        return $row ? Lead::fromArray($this->decryptRow($row)) : null;
    }

    public function create(Lead $lead, string $ipAddress = ''): Lead
    {
        $publicId           = bin2hex(random_bytes(8));
        $marketingConsentAt = $lead->marketingConsent ? date('Y-m-d H:i:s') : null;

        $normalizedEmail = strtolower(trim($lead->email));

        $stmt = $this->db->prepare(
            'INSERT INTO leads
             (public_id, name, email, email_hash, user_type, plan, ab_variant, ip_address,
              marketing_consent, marketing_consent_at, email_status)
             VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)'
        );

        $stmt->execute([
            $publicId,
            trim($lead->name),
            Encryption::encrypt($normalizedEmail),
            Encryption::hash($normalizedEmail),
            $lead->userType,
            $lead->plan,
            $lead->abVariant,
            $ipAddress ?: null,
            $lead->marketingConsent ? 1 : 0,
            $marketingConsentAt,
            'pending',
        ]);

        return new Lead(
            name:             $lead->name,
            email:            $lead->email,
            userType:         $lead->userType,
            plan:             $lead->plan,
            abVariant:        $lead->abVariant,
            marketingConsent: $lead->marketingConsent,
            id:               (int) $this->db->lastInsertId(),
            publicId:         $publicId,
            emailStatus:      'pending',
        );
    }

    public function updateEmailStatus(int $id, string $status): void
    {
        $stmt = $this->db->prepare(
            'UPDATE leads SET email_status = ?, updated_at = NOW() WHERE id = ?'
        );
        $stmt->execute([$status, $id]);
    }

    public function findAll(int $page = 1, int $perPage = 20, array $filters = []): array
    {
        $offset = ($page - 1) * $perPage;
        [$where, $params] = $this->buildWhereClause($filters);

        $stmt = $this->db->prepare(
            "SELECT id, public_id, name, email, user_type, plan,
                    ab_variant, email_status, created_at
             FROM leads
             WHERE {$where}
             ORDER BY created_at DESC
             LIMIT ? OFFSET ?"
        );

        $stmt->execute([...$params, $perPage, $offset]);
        return array_map([$this, 'decryptRow'], $stmt->fetchAll());
    }

    public function countAll(array $filters = []): int
    {
        [$where, $params] = $this->buildWhereClause($filters);
        $stmt = $this->db->prepare("SELECT COUNT(*) FROM leads WHERE {$where}");
        $stmt->execute($params);
        return (int) $stmt->fetchColumn();
    }

    public function countRecentByIp(string $ip, int $minutes = 60): int
    {
        $stmt = $this->db->prepare(
            'SELECT COUNT(*) FROM leads
             WHERE ip_address = ? AND created_at > DATE_SUB(NOW(), INTERVAL ? MINUTE)'
        );
        $stmt->execute([$ip, $minutes]);
        return (int) $stmt->fetchColumn();
    }

    public function recordAbView(string $variant): void
    {
        try {
            $stmt = $this->db->prepare(
                'INSERT INTO ab_events (variant, event_type) VALUES (?, ?)'
            );
            $stmt->execute([$variant, 'view']);
        } catch (\Throwable $e) {
            Logger::warning('Failed to record AB view', ['error' => $e->getMessage()]);
        }
    }

    /** Descriptografa o campo email em uma linha retornada pelo banco. */
    private function decryptRow(array $row): array
    {
        if (isset($row['email'])) {
            try {
                $row['email'] = Encryption::decrypt($row['email']);
            } catch (\Throwable) {
                $row['email'] = '[erro ao descriptografar]';
            }
        }
        return $row;
    }

    private function buildWhereClause(array $filters): array
    {
        $conditions = ['1=1'];
        $params     = [];

        if (!empty($filters['plan'])) {
            $conditions[] = 'plan = ?';
            $params[]     = $filters['plan'];
        }

        if (!empty($filters['user_type'])) {
            $conditions[] = 'user_type = ?';
            $params[]     = $filters['user_type'];
        }

        return [implode(' AND ', $conditions), $params];
    }
}
