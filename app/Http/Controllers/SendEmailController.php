<?php

namespace App\Http\Controllers;

use App\Mail\SendMail;
use App\Mail\TestEmail;
use App\Models\EmailTemplate;
use App\Models\Hund;
use App\Models\Person;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Mail;
use PDF;

class SendEmailController extends Controller
{
    //
    public function index()
    {
        return view('send_email');
    }

    public function html_email(Request $request)
    {

        if (is_string($request->to) && is_string($request->name) && is_string($request->subject)) {

            $maildata = ['name' => $request->name, 'to' => $request->to, 'from' => $request->from, 'subject' => $request->subject, 'view' => $request->view];

            $pathToFile = '';
            $data = Hund::find(1000);

            view()->share('hunde', $data);
            $pdf = PDF::loadView('pdfs.hunde', $data);

            /*  Mail::send( new SendMail($data)); */

            Mail::send('mails.mail', $maildata, function ($message) use ($pdf) {
                $message->subject('DRC');
                $message->from('scanner@bloomproject.de');
                $message->to('goemmel@bloomproject.de');
                $message->attachData($pdf->output(), 'text.pdf', [
                    'mime' => 'application/pdf',
                ]);
            });

            echo 'HTML Email Sent. Check your inbox.';
        } else {
            echo 'HTML Email not sent.';
        }
    }

    public function deckschein_beantragt(Request $request)
    {

        $data = [];

        if (is_string($request->to) && is_string($request->name) && is_string($request->subject)) {

            $maildata = ['name' => $request->name, 'to' => $request->to, 'from' => $request->from, 'subject' => $request->subject, 'view' => $request->view];

            /*  Mail::send( new SendMail($data)); */

            // Mail::send('mail.mail', $maildata, function ($message) use ($pdf) {
            //    $message->subject('DRC');
            //    $message->from('scanner@bloomproject.de');
            //    $message->to('goemmel@bloomproject.de');
            //    $message->attachData($pdf->output(), 'text.pdf', [
            //        'mime' => 'application/pdf',
            //    ]);
            // });

            echo 'HTML Email Sent. Check your inbox.';
        } else {
            echo 'HTML Email not sent.';
        }
    }

    /**
     * Sendet Test-E-Mail für ein Template
     *
     * @param  int  $templateId
     * @return \Illuminate\Http\JsonResponse
     */
    public function sendTestEmail(Request $request, $templateId)
    {
        try {
            // Validierung
            $validated = $request->validate([
                'person_ids' => 'required|array|min:1',
                'person_ids.*' => 'required|integer|exists:personen,id',
            ]);

            // Template laden
            $template = EmailTemplate::findOrFail($templateId);

            // Personen laden
            $persons = Person::whereIn('id', $validated['person_ids'])->get();

            if ($persons->isEmpty()) {
                return response()->json([
                    'success' => false,
                    'error' => 'Keine gültigen Empfänger gefunden',
                ], 404);
            }

            $sentCount = 0;
            $errors = [];

            // E-Mail an jede Person senden
            foreach ($persons as $person) {
                try {
                    // Prüfen ob Person eine E-Mail-Adresse hat
                    if (empty($person->email)) {
                        $errors[] = "Person '{$person->name}' hat keine E-Mail-Adresse";
                        continue;
                    }

                    // Platzhalter im Body ersetzen
                    $body = $this->replacePlaceholders($template->body, $person);

                    // E-Mail senden
                    Mail::to($person->email)->send(new TestEmail(
                        subject: $template->subject ?: $template->thema,
                        body: $body
                    ));

                    $sentCount++;

                    Log::info('Test-E-Mail gesendet', [
                        'template_id' => $template->id,
                        'template_slug' => $template->slug,
                        'recipient' => $person->email,
                        'recipient_name' => $person->name,
                    ]);

                } catch (\Exception $e) {
                    $errors[] = "Fehler beim Senden an {$person->email}: " . $e->getMessage();
                    Log::error('Fehler beim Senden der Test-E-Mail', [
                        'template_id' => $template->id,
                        'recipient' => $person->email,
                        'error' => $e->getMessage(),
                    ]);
                }
            }

            // Response zusammenstellen
            if ($sentCount > 0) {
                $message = "Test-E-Mail erfolgreich an {$sentCount} " .
                          ($sentCount === 1 ? 'Person' : 'Personen') . ' gesendet';

                if (! empty($errors)) {
                    $message .= '. ' . count($errors) . ' Fehler aufgetreten.';
                }

                return response()->json([
                    'success' => true,
                    'message' => $message,
                    'sent_count' => $sentCount,
                    'errors' => $errors,
                ]);
            } else {
                return response()->json([
                    'success' => false,
                    'error' => 'Keine E-Mails konnten gesendet werden',
                    'errors' => $errors,
                ], 400);
            }

        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'error' => 'Validierungsfehler',
                'errors' => $e->errors(),
            ], 422);
        } catch (\Exception $e) {
            Log::error('Fehler beim Senden der Test-E-Mail', [
                'template_id' => $templateId,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);

            return response()->json([
                'success' => false,
                'error' => 'Fehler beim Senden der Test-E-Mail: ' . $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Ersetzt Platzhalter im E-Mail-Body
     */
    private function replacePlaceholders(string $body, Person $person): string
    {
        // Person-Platzhalter
        $placeholders = [
            '{person.name}' => $person->name ?? '',
            '{person.vorname}' => $person->vorname ?? '',
            '{person.nachname}' => $person->nachname ?? '',
            '{person.email}' => $person->email ?? '',
            '{person.telefon}' => $person->telefon ?? '',
            '{person.adresse}' => $person->adresse ?? '',
            '{person.plz}' => $person->plz ?? '',
            '{person.ort}' => $person->ort ?? '',
        ];

        // Mitglied-Daten wenn vorhanden
        if ($person->mitglied) {
            $placeholders['{mitglied.nummer}'] = $person->mitglied->mitglied_nummer ?? '';
            $placeholders['{mitglied.status}'] = $person->mitglied->status ?? '';
        }

        // Platzhalter ersetzen
        return str_replace(
            array_keys($placeholders),
            array_values($placeholders),
            $body
        );
    }
}
