<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateSonderleiterRequest extends FormRequest
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
            'person_id' => 'sometimes|exists:personen,id',
            'beginn' => 'sometimes|date',
            'ende' => 'nullable|date|after_or_equal:beginn',
            'anmerkungen' => 'nullable|string',
            'aktiv' => 'sometimes|boolean',
            // 'status_id' => 'sometimes|exists:optionen_sonderleiter_stati,id', // Später wenn Sonderleiter-Status-Tabelle existiert
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
            'person_id.exists' => 'Die ausgewählte Person existiert nicht.',
            'beginn.date' => 'Das Beginndatum muss ein gültiges Datum sein.',
            'ende.date' => 'Das Enddatum muss ein gültiges Datum sein.',
            'ende.after_or_equal' => 'Das Enddatum muss nach oder gleich dem Beginndatum liegen.',
            'aktiv.boolean' => 'Der Aktiv-Status muss ein boolescher Wert sein.',
            // 'status_id.exists' => 'Der ausgewählte Status existiert nicht.',
        ];
    }
}
