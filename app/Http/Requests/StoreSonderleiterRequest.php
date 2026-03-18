<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreSonderleiterRequest extends FormRequest
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
            'beginn' => 'required|date',
            'ende' => 'nullable|date|after_or_equal:beginn',
            //'status_id' => 'required|exists:optionen_ausbilder_stati,id', // Temporär, bis Sonderleiter-Status-Tabelle existiert
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
            'person_id.required' => 'Eine Person muss ausgewählt werden.',
            'person_id.exists' => 'Die ausgewählte Person existiert nicht.',
            'beginn.required' => 'Ein Beginndatum ist erforderlich.',
            'beginn.date' => 'Das Beginndatum muss ein gültiges Datum sein.',
            'ende.date' => 'Das Enddatum muss ein gültiges Datum sein.',
            'ende.after_or_equal' => 'Das Enddatum muss nach oder gleich dem Beginndatum liegen.',
            // 'status_id.required' => 'Ein Status muss ausgewählt werden.',
            // 'status_id.exists' => 'Der ausgewählte Status existiert nicht.',
        ];
    }
}
