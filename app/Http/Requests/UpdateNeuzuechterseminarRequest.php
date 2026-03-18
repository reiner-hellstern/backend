<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateNeuzuechterseminarRequest extends FormRequest
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
            'person_id' => 'sometimes|required|exists:personen,id',
            'datum' => 'sometimes|required|date_format:d.m.Y',
            'ort' => 'sometimes|required|string|max:255',
            'bemerkungen' => 'nullable|string',
            'event_id' => 'nullable|exists:veranstaltungen,id',
            'aktiv' => 'sometimes|boolean',
            'status' => 'sometimes|boolean',
            'bestaetigt_am' => 'nullable|date_format:d.m.Y H:i',
            'bestaetigt_von' => 'nullable|exists:personen,id',
        ];
    }

    /**
     * Get custom error messages for validation rules.
     */
    public function messages(): array
    {
        return [
            'person_id.required' => 'Person ist erforderlich.',
            'person_id.exists' => 'Die ausgewählte Person existiert nicht.',
            'datum.required' => 'Datum ist erforderlich.',
            'datum.date_format' => 'Datum muss im Format TT.MM.JJJJ angegeben werden.',
            'ort.required' => 'Ort ist erforderlich.',
            'ort.string' => 'Ort muss ein Text sein.',
            'ort.max' => 'Ort darf maximal 255 Zeichen lang sein.',
            'bemerkungen.string' => 'Bemerkungen müssen ein Text sein.',
            'event_id.exists' => 'Die ausgewählte Veranstaltung existiert nicht.',
            'aktiv.boolean' => 'Aktiv muss wahr oder falsch sein.',
            'status.boolean' => 'Status muss wahr oder falsch sein.',
            'bestaetigt_am.date_format' => 'Bestätigungsdatum muss im Format TT.MM.JJJJ HH:MM angegeben werden.',
            'bestaetigt_von.exists' => 'Die bestätigende Person existiert nicht.',
        ];
    }
}
