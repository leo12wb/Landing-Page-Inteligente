<?php

declare(strict_types=1);

namespace App\Services;

use App\Mail\LeadConfirmationEmail;
use App\Models\Lead;
use App\Support\Logger;

class EmailService
{
    private bool   $enabled;
    private string $apiKey;
    private string $fromAddress;
    private string $fromName;

    public function __construct()
    {
        $this->enabled     = filter_var($_ENV['MAIL_ENABLED'] ?? 'false', FILTER_VALIDATE_BOOLEAN);
        $this->apiKey      = $_ENV['RESEND_API_KEY']  ?? '';
        $this->fromAddress = $_ENV['MAIL_FROM']       ?? 'noreply@devflow.demo';
        $this->fromName    = $_ENV['MAIL_FROM_NAME']  ?? 'DevFlow';
    }

    /**
     * Envia e-mail de confirmação.
     * Retorna true = enviado, false = não enviado (desabilitado ou falha).
     * Uma falha NÃO cancela o cadastro.
     */
    public function sendConfirmation(Lead $lead): bool
    {
        if (!$this->enabled) {
            Logger::info('Email desabilitado (MAIL_ENABLED=false). Envio ignorado.', [
                'lead_public_id' => $lead->publicId,
            ]);
            return false;
        }

        if (empty($this->apiKey)) {
            Logger::warning('RESEND_API_KEY não configurada. Não é possível enviar e-mail.', [
                'lead_public_id' => $lead->publicId,
            ]);
            return false;
        }

        $template = new LeadConfirmationEmail($lead);
        $payload  = json_encode([
            'from'    => "{$this->fromName} <{$this->fromAddress}>",
            'to'      => [$lead->email],
            'subject' => 'Cadastro recebido — DevFlow',
            'html'    => $template->toHtml(),
            'text'    => $template->toText(),
        ], JSON_UNESCAPED_UNICODE | JSON_THROW_ON_ERROR);

        $ch = curl_init('https://api.resend.com/emails');
        curl_setopt_array($ch, [
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_POST           => true,
            CURLOPT_POSTFIELDS     => $payload,
            CURLOPT_TIMEOUT        => 10,
            CURLOPT_CONNECTTIMEOUT => 5,
            CURLOPT_HTTPHEADER     => [
                'Authorization: Bearer ' . $this->apiKey,
                'Content-Type: application/json',
            ],
        ]);

        $response  = curl_exec($ch);
        $httpCode  = (int) curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $curlError = curl_error($ch);
        curl_close($ch);

        if ($curlError) {
            Logger::error('Falha no envio de e-mail (cURL)', ['error' => $curlError]);
            return false;
        }

        if ($httpCode < 200 || $httpCode >= 300) {
            Logger::error('Falha no envio de e-mail (HTTP)', [
                'http_code'      => $httpCode,
                'lead_public_id' => $lead->publicId,
            ]);
            return false;
        }

        Logger::info('E-mail de confirmação enviado.', ['lead_public_id' => $lead->publicId]);
        return true;
    }
}
