<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreRichterRequest extends FormRequest
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
     */
    public function rules(): array
    {
        $rules = [
            'beginn' => 'required|date',
            'ende' => 'nullable|date|after:beginn',
            'status_id' => 'required|exists:optionen_richterstatus,id',
            'fcinummer' => 'nullable|string|max:255',
            'verein' => 'nullable|string|max:255',
            'richtertypen' => 'nullable|array',
            'richtertypen.*' => 'exists:richtertypen,id',
        ];

        // Either existing person_id OR new person data required
        if ($this->has('person_id') && $this->person_id) {
            $rules['person_id'] = 'required|exists:personen,id';
        } else {
            // Required person fields
            $rules['person.vorname'] = 'required|string|max:255';
            $rules['person.nachname'] = 'required|string|max:255';
            $rules['person.strasse'] = 'required|string|max:255';
            $rules['person.postleitzahl'] = 'required|string|max:10';
            $rules['person.ort'] = 'required|string|max:255';

            // Optional person fields
            $rules['person.id'] = 'nullable|integer';
            $rules['person.personenadresse_id'] = 'nullable|integer';
            $rules['person.anrede_id'] = 'nullable|integer';
            $rules['person.adelstitel'] = 'nullable|string|max:255';
            $rules['person.akademischetitel'] = 'nullable|string|max:255';
            $rules['person.adresszusatz'] = 'nullable|string|max:255';
            $rules['person.land'] = 'nullable|string|max:255';
            $rules['person.mitgliedsnummer'] = 'nullable|string|max:255';
            $rules['person.telefon_1'] = 'nullable|string|max:255';
            $rules['person.telefon_2'] = 'nullable|string|max:255';
            $rules['person.email_1'] = 'nullable|email|max:255';
            $rules['person.email_2'] = 'nullable|email|max:255';
            $rules['person.website_1'] = 'nullable|url|max:255';
            $rules['person.website_2'] = 'nullable|url|max:255';
        }

        return $rules;
    }

    /**
     * Get custom validation messages.
     */
    public function messages(): array
    {
        return [
            // Required field messages
            'beginn.required' => 'Ein Beginndatum ist erforderlich.',
            'beginn.date' => 'Das Beginndatum muss ein gültiges Datum sein.',
            'status_id.required' => 'Ein Status muss ausgewählt werden.',
            'status_id.exists' => 'Der ausgewählte Status existiert nicht.',

            // Optional field messages
            'ende.date' => 'Das Enddatum muss ein gültiges Datum sein.',
            'ende.after' => 'Das Enddatum muss nach dem Beginndatum liegen.',
            'fcinummer.max' => 'Die FCI-Nummer darf maximal 255 Zeichen lang sein.',
            'verein.max' => 'Der Vereinsname darf maximal 255 Zeichen lang sein.',

            // Person validation messages
            'person_id.required' => 'Eine Person muss ausgewählt werden.',
            'person_id.exists' => 'Die ausgewählte Person existiert nicht.',
            'person.vorname.required' => 'Der Vorname ist erforderlich.',
            'person.vorname.max' => 'Der Vorname darf maximal 255 Zeichen lang sein.',
            'person.nachname.required' => 'Der Nachname ist erforderlich.',
            'person.nachname.max' => 'Der Nachname darf maximal 255 Zeichen lang sein.',
            'person.strasse.required' => 'Die Straße ist erforderlich.',
            'person.strasse.max' => 'Die Straße darf maximal 255 Zeichen lang sein.',
            'person.postleitzahl.required' => 'Die Postleitzahl ist erforderlich.',
            'person.postleitzahl.max' => 'Die Postleitzahl darf maximal 10 Zeichen lang sein.',
            'person.ort.required' => 'Der Ort ist erforderlich.',
            'person.ort.max' => 'Der Ort darf maximal 255 Zeichen lang sein.',
            'person.email_1.email' => 'Die E-Mail-Adresse muss gültig sein.',
            'person.email_2.email' => 'Die zweite E-Mail-Adresse muss gültig sein.',
            'person.website_1.url' => 'Die Website-URL muss gültig sein.',
            'person.website_2.url' => 'Die zweite Website-URL muss gültig sein.',

            // Array messages
            'richtertypen.array' => 'Richtertypen müssen als Array übermittelt werden.',
            'richtertypen.*.exists' => 'Ein oder mehrere ausgewählte Richtertypen existieren nicht.',
        ];
    }
}
