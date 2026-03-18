@include('mail.email-header', ['subject' => $subject])

<h2>Antrag auf Zweitschrift-Anlage</h2>

<p>Sehr geehrte/r {{ $person->vorname }} {{ $person->nachname }},</p>

<p>Ihr Antrag auf Ausstellung einer Zweitschrift wurde erfolgreich eingereicht.</p>

@if($hund ?? false)
    <div style="background-color: #f3f4f6; padding: 15px; border-radius: 8px; margin: 20px 0;">
        <h3 style="color: #002e7f; margin-top: 0;">Hund-Informationen</h3>
        <p style="margin: 5px 0;">
            <strong>Name:</strong> {{ $hund->rufname }}<br>
            <strong>Zuchtbuchnummer:</strong> {{ $hund->zuchtbuch_nummer }}<br>
            <strong>Rasse:</strong> {{ $hund->rasse->name ?? 'Unbekannt' }}
        </p>
    </div>
@endif

{{-- Laravel-Komponente verwenden --}}
<x-mail::panel>
    <strong>Wichtige Hinweise:</strong>
    <ul>
        <li>Die Bearbeitungszeit beträgt ca. 2-3 Wochen</li>
        <li>Die Gebühr wird automatisch abgebucht</li>
        <li>Sie erhalten eine separate Benachrichtigung</li>
    </ul>
</x-mail::panel>

<p>Bei Fragen stehen wir Ihnen gerne zur Verfügung.</p>

<p>
    Mit freundlichen Grüßen<br>
    <strong>Deutscher Retriever Club e.V.</strong>
</p>

@include('mail.email-footer')
