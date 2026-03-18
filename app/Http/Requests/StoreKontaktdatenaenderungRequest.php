<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreKontaktdatenaenderungRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'person_id' => 'required|exists:personen,id',

            // Namensdaten (optional)
            'vorname' => 'nullable|string|max:255',
            'nachname' => 'nullable|string|max:255',
            'nachname_ehemals' => 'nullable|string|max:255',
            'geboren' => 'nullable|date_format:d.m.Y',

            // Kontaktdaten (optional)
            'telefon_1' => 'nullable|string|max:50',
            'telefon_2' => 'nullable|string|max:50',
            'telefon_3' => 'nullable|string|max:50',
            'email_1' => 'nullable|email|max:255',
            'email_2' => 'nullable|email|max:255',
            'website_1' => 'nullable|url|max:255',
            'website_2' => 'nullable|url|max:255',

            // Adressdaten (optional)
            'strasse' => 'nullable|string|max:255',
            'adresszusatz' => 'nullable|string|max:255',
            'postleitzahl' => 'nullable|string|max:10',
            'ort' => 'nullable|string|max:255',
            'land' => 'nullable|string|max:255',
            'laenderkuerzel' => 'nullable|string|max:5',
            'postfach_plz' => 'nullable|string|max:10',
            'postfach_nummer' => 'nullable|string|max:50',

            // Status
            'bemerkungen' => 'nullable|string',
            'aktiv' => 'boolean',
        ];
    }

    /**
     * Custom error messages
     */
    public function messages(): array
    {
        return [
            'person_id.required' => 'Die Person-ID ist erforderlich.',
            'person_id.exists' => 'Die angegebene Person existiert nicht.',
            'email_1.email' => 'Bitte geben Sie eine gültige E-Mail-Adresse 1 ein.',
            'email_2.email' => 'Bitte geben Sie eine gültige E-Mail-Adresse 2 ein.',
            'website_1.url' => 'Bitte geben Sie eine gültige Website 1 ein.',
            'website_2.url' => 'Bitte geben Sie eine gültige Website 2 ein.',
            'geboren.date_format' => 'Das Geburtsdatum muss im Format TT.MM.JJJJ eingegeben werden.',
        ];
    }
}
