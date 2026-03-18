<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateAusbilderRequest extends FormRequest
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
            // New payload structure
            'person_id' => 'sometimes|nullable|exists:personen,id',
            'status_id' => 'sometimes|nullable|exists:optionen_ausbilder_stati,id',
            'ausweis_status_id' => 'sometimes|nullable|exists:optionen_ausbilderausweis_stati,id',

            // Dates
            'beginn' => 'sometimes|nullable|date',
            'ende' => 'nullable|date|after_or_equal:beginn',

            // Arrays
            'ausbildertypen' => 'sometimes|array',
            'ausbildertypen.*' => 'exists:ausbildertypen,id',

            // Other fields
            'fortbildung_gueltig' => 'sometimes|nullable|boolean',
            'fortbildung_bestaetigt_am' => 'nullable|date',
            'ausweisnummer' => 'nullable|string|max:50',
            'anmerkungen' => 'nullable|string',
            'ausbildertypen' => 'sometimes|array',
            'ausbildertypen.*' => 'exists:ausbildertypen,id',
        ];
    }

    /**
     * Get custom messages for validator errors.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            // ID Messages
            'person_id.exists' => 'Die ausgewählte Person existiert nicht.',
            'status_id.exists' => 'Der ausgewählte Status existiert nicht.',
            'ausweis_status_id.exists' => 'Der ausgewählte Ausweisstatus existiert nicht.',

            // Datum Messages
            'beginn.date' => 'Das Beginndatum muss ein gültiges Datum sein.',
            'ende.date' => 'Das Enddatum muss ein gültiges Datum sein.',
            'ende.after_or_equal' => 'Das Enddatum muss nach oder gleich dem Beginndatum liegen.',

            // Array Messages
            'ausbildertypen.array' => 'Ausbildertypen müssen als Array übermittelt werden.',
            'ausbildertypen.*.exists' => 'Ein oder mehrere ausgewählte Ausbildertypen existieren nicht.',

            // Other Messages
            'fortbildung_gueltig.boolean' => 'Fortbildung gültig muss ein Wahrheitswert sein.',
            'fortbildung_bestaetigt_am.date' => 'Das Fortbildungsdatum muss ein gültiges Datum sein.',
            'ausweisnummer.max' => 'Die Ausweisnummer darf maximal 50 Zeichen lang sein.',
        ];
    }
}
