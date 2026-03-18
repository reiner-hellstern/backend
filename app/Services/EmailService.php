<?php

namespace App\Services;

use App\Mail\TemplatedEmail;
use App\Models\EmailTemplate;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class EmailService
{
    public function __construct(
        private EmailTemplateRenderer $renderer
    ) {}

    /**
     * Email-Template an mehrere Empfänger senden
     *
     * @param  string  $templateSlug  Slug des Email-Templates
     * @param  array  $variables  Variablen für Template-Rendering
     * @param  array|string|null  $recipients  Email-Adressen (optional, nutzt Template-Persons wenn null)
     * @param  array  $options  Zusätzliche Optionen (from_name, from_email, reply_to, etc.)
     * @return array ['success' => bool, 'sent' => int, 'failed' => int, 'errors' => array]
     */
    public function sendTemplatedEmail(
        string $templateSlug,
        array $variables = [],
        array|string|null $recipients = null,
        array $options = []
    ): array {
        // Template laden
        $template = EmailTemplate::where('slug', $templateSlug)->first();

        if (! $template) {
            return [
                'success' => false,
                'sent' => 0,
                'failed' => 0,
                'errors' => ["Email-Template '{$templateSlug}' nicht gefunden"],
            ];
        }

        // Empfänger bestimmen
        $emailAddresses = $this->resolveRecipients($template, $recipients);

        if (empty($emailAddresses)) {
            return [
                'success' => false,
                'sent' => 0,
                'failed' => 0,
                'errors' => ['Keine Empfänger gefunden'],
            ];
        }

        // Subject und Content rendern
        try {
            $renderedSubject = $this->renderer->compile($template->subject, $variables);
            $renderedHtml = $this->renderer->compile($template->content, $variables);
        } catch (\Exception $e) {
            Log::error('Email-Template Rendering fehlgeschlagen', [
                'template' => $templateSlug,
                'error' => $e->getMessage(),
            ]);

            return [
                'success' => false,
                'sent' => 0,
                'failed' => count($emailAddresses),
                'errors' => ['Template-Rendering fehlgeschlagen: ' . $e->getMessage()],
            ];
        }

        // Emails versenden
        $sent = 0;
        $failed = 0;
        $errors = [];

        foreach ($emailAddresses as $email) {
            try {
                Mail::to($email)->send(new TemplatedEmail(
                    subject: $renderedSubject,
                    htmlContent: $renderedHtml,
                    fromName: $options['from_name'] ?? $template->from_name ?? config('mail.from.name'),
                    fromEmail: $options['from_email'] ?? $template->from_email ?? config('mail.from.address'),
                    replyToEmail: $options['reply_to_email'] ?? null,
                    replyToName: $options['reply_to_name'] ?? null,
                ));

                $sent++;

                Log::info('Email erfolgreich versendet', [
                    'template' => $templateSlug,
                    'recipient' => $email,
                ]);

            } catch (\Exception $e) {
                $failed++;
                $errors[] = "Fehler beim Senden an {$email}: " . $e->getMessage();

                Log::error('Email-Versand fehlgeschlagen', [
                    'template' => $templateSlug,
                    'recipient' => $email,
                    'error' => $e->getMessage(),
                ]);
            }
        }

        return [
            'success' => $sent > 0,
            'sent' => $sent,
            'failed' => $failed,
            'errors' => $errors,
        ];
    }

    /**
     * Empfänger-Liste auflösen
     */
    private function resolveRecipients(EmailTemplate $template, array|string|null $recipients): array
    {
        // Explizite Empfänger übergeben
        if ($recipients !== null) {
            if (is_string($recipients)) {
                return [$recipients];
            }

            return array_filter($recipients, fn ($email) => filter_var($email, FILTER_VALIDATE_EMAIL));
        }

        // Template-zugewiesene Personen
        if ($template->relationLoaded('persons')) {
            return $template->persons
                ->pluck('email')
                ->filter()
                ->unique()
                ->values()
                ->toArray();
        }

        // Personen nachladen
        return $template->persons()
            ->whereNotNull('email')
            ->pluck('email')
            ->unique()
            ->values()
            ->toArray();
    }

    /**
     * Email an Template-Personen UND zusätzliche Empfänger
     */
    public function sendToTemplateAndAdditional(
        string $templateSlug,
        array $variables = [],
        array|string $additionalRecipients = [],
        array $options = []
    ): array {
        $template = EmailTemplate::where('slug', $templateSlug)->first();

        if (! $template) {
            return [
                'success' => false,
                'sent' => 0,
                'failed' => 0,
                'errors' => ["Email-Template '{$templateSlug}' nicht gefunden"],
            ];
        }

        // Template-Personen + zusätzliche Empfänger kombinieren
        $templateRecipients = $this->resolveRecipients($template, null);
        $additionalArray = is_string($additionalRecipients) ? [$additionalRecipients] : $additionalRecipients;

        $allRecipients = array_unique(array_merge($templateRecipients, $additionalArray));

        return $this->sendTemplatedEmail($templateSlug, $variables, $allRecipients, $options);
    }
}
