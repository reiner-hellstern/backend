<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreAusbilderRequest extends FormRequest
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
            // Required fields
            'person_id' => 'required|exists:personen,id',
            'status_id' => 'required|exists:optionen_ausbilder_stati,id',
            'beginn' => 'required|date',

            // Optional fields
            'ende' => 'nullable|date|after_or_equal:beginn',
            'ausweis_status_id' => 'nullable|exists:optionen_ausbilderausweis_stati,id',
            'ausweisnummer' => 'nullable|string|max:50',
            'fortbildung_gueltig' => 'nullable|boolean',
            'fortbildung_bestaetigt_am' => 'nullable|date',
            'anmerkungen' => 'nullable|string',

            // Arrays
            'ausbildertypen' => 'nullable|array',
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
            // Required field messages
            'person_id.required' => 'Eine Person muss ausgewählt werden.',
            'person_id.exists' => 'Die ausgewählte Person existiert nicht.',
            'status_id.required' => 'Ein Status muss ausgewählt werden.',
            'status_id.exists' => 'Der ausgewählte Status existiert nicht.',
            'beginn.required' => 'Ein Beginndatum ist erforderlich.',
            'beginn.date' => 'Das Beginndatum muss ein gültiges Datum sein.',

            // Optional field messages
            'ende.date' => 'Das Enddatum muss ein gültiges Datum sein.',
            'ende.after_or_equal' => 'Das Enddatum muss nach oder gleich dem Beginndatum liegen.',
            'ausweis_status_id.exists' => 'Der ausgewählte Ausweisstatus existiert nicht.',
            'ausweisnummer.max' => 'Die Ausweisnummer darf maximal 50 Zeichen lang sein.',
            'fortbildung_gueltig.boolean' => 'Fortbildung gültig muss ein Wahrheitswert sein.',
            'fortbildung_bestaetigt_am.date' => 'Das Fortbildungsdatum muss ein gültiges Datum sein.',

            // Array messages
            'ausbildertypen.array' => 'Ausbildertypen müssen als Array übermittelt werden.',
            'ausbildertypen.*.exists' => 'Ein oder mehrere ausgewählte Ausbildertypen existieren nicht.',
        ];
    }
}
