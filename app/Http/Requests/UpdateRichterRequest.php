<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateRichterRequest extends FormRequest
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
        return [
            'person_id' => 'sometimes|exists:personen,id',
            'beginn' => 'sometimes|date',
            'ende' => 'nullable|date|after:beginn',
            'status_id' => 'sometimes|exists:optionen_richterstatus,id',
            'drc' => 'sometimes|boolean',
            'fcinummer' => 'nullable|string|max:255',
            'verein' => 'nullable|string|max:255',
            'telefon' => 'nullable|string|max:255',
            'mobil' => 'nullable|string|max:255',
            'email' => 'nullable|email|max:255',
            'richtertypen' => 'nullable|array',
            'richtertypen.*' => 'exists:richtertypen,id',
        ];
    }

    /**
     * Get custom validation messages.
     */
    public function messages(): array
    {
        return [
            // Person validation
            'person_id.exists' => 'Die ausgewählte Person existiert nicht.',

            // Date validation
            'beginn.date' => 'Das Beginndatum muss ein gültiges Datum sein.',
            'ende.date' => 'Das Enddatum muss ein gültiges Datum sein.',
            'ende.after' => 'Das Enddatum muss nach dem Beginndatum liegen.',

            // Status validation
            'status_id.exists' => 'Der ausgewählte Status existiert nicht.',

            // Field length validation
            'fcinummer.max' => 'Die FCI-Nummer darf maximal 255 Zeichen lang sein.',
            'verein.max' => 'Der Vereinsname darf maximal 255 Zeichen lang sein.',
            'telefon.max' => 'Die Telefonnummer darf maximal 255 Zeichen lang sein.',
            'mobil.max' => 'Die Mobilnummer darf maximal 255 Zeichen lang sein.',
            'email.email' => 'Die E-Mail-Adresse muss gültig sein.',
            'email.max' => 'Die E-Mail-Adresse darf maximal 255 Zeichen lang sein.',

            // Boolean validation
            'drc.boolean' => 'DRC-Mitgliedschaft muss ein Wahrheitswert sein.',

            // Array validation
            'richtertypen.array' => 'Richtertypen müssen als Array übermittelt werden.',
            'richtertypen.*.exists' => 'Ein oder mehrere ausgewählte Richtertypen existieren nicht.',
        ];
    }
}
