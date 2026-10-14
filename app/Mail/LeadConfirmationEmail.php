<?php

declare(strict_types=1);

namespace App\Mail;

use App\Models\Lead;

class LeadConfirmationEmail
{
    public function __construct(private readonly Lead $lead) {}

    public function toHtml(): string
    {
        $name = htmlspecialchars($this->lead->name, ENT_QUOTES, 'UTF-8');
        $plan = ucfirst($this->lead->plan);
        $type = ucfirst($this->lead->userType);

        return <<<HTML
        <!DOCTYPE html>
        <html lang="pt-BR">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width,initial-scale=1">
            <title>Cadastro recebido — DevFlow</title>
        </head>
        <body style="margin:0;padding:0;background:#f1f5f9;font-family:ui-sans-serif,system-ui,sans-serif;">
          <table width="100%" cellpadding="0" cellspacing="0" style="padding:40px 20px;">
            <tr><td align="center">
              <table width="600" cellpadding="0" cellspacing="0"
                     style="background:#fff;border-radius:12px;overflow:hidden;
                            box-shadow:0 4px 24px rgba(0,0,0,.08);">
                <!-- Header -->
                <tr>
                  <td style="background:#4f46e5;padding:32px 40px;text-align:center;">
                    <h1 style="margin:0;color:#fff;font-size:26px;font-weight:800;">DevFlow</h1>
                    <p style="margin:6px 0 0;color:#c7d2fe;font-size:13px;">
                      Projeto demonstrativo de portfólio
                    </p>
                  </td>
                </tr>
                <!-- Body -->
                <tr>
                  <td style="padding:36px 40px;">
                    <h2 style="margin:0 0 12px;color:#1e293b;font-size:20px;">Olá, {$name}!</h2>
                    <p style="margin:0 0 14px;color:#475569;line-height:1.6;">
                      Recebemos seu cadastro de interesse. Obrigado por conhecer o <strong>DevFlow</strong>!
                    </p>
                    <div style="background:#f8fafc;border:1px solid #e2e8f0;border-radius:8px;
                                padding:20px;margin-bottom:20px;">
                      <p style="margin:0 0 6px;color:#64748b;font-size:14px;">
                        <strong>Resumo do cadastro:</strong>
                      </p>
                      <p style="margin:0;color:#64748b;font-size:14px;line-height:1.8;">
                        Plano de interesse: <strong>{$plan}</strong><br>
                        Perfil: <strong>{$type}</strong>
                      </p>
                    </div>
                    <p style="margin:0 0 14px;color:#94a3b8;font-size:13px;line-height:1.6;">
                      <strong>Aviso importante:</strong> DevFlow é um projeto fictício desenvolvido
                      como portfólio técnico. Nenhum produto real está sendo comercializado.
                    </p>
                  </td>
                </tr>
                <!-- Footer -->
                <tr>
                  <td style="background:#f8fafc;padding:16px 40px;border-top:1px solid #e2e8f0;">
                    <p style="margin:0;color:#94a3b8;font-size:12px;text-align:center;">
                      Projeto demonstrativo · Não responda este e-mail
                    </p>
                  </td>
                </tr>
              </table>
            </td></tr>
          </table>
        </body>
        </html>
        HTML;
    }

    public function toText(): string
    {
        $name = $this->lead->name;
        $plan = ucfirst($this->lead->plan);
        $type = ucfirst($this->lead->userType);

        return <<<TEXT
        Olá, {$name}!

        Recebemos seu cadastro de interesse no DevFlow.

        Resumo:
        - Plano: {$plan}
        - Perfil: {$type}

        AVISO: DevFlow é um projeto fictício de portfólio. Nenhum produto real está sendo comercializado.

        ---
        Projeto demonstrativo · Não responda este e-mail.
        TEXT;
    }
}
