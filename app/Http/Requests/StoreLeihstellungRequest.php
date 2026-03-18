<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreLeihstellungRequest extends FormRequest
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
            'hund_id' => 'required|exists:hunde,id',
            'zwinger_id' => 'required|exists:zwinger,id',
            'leihsteller_id' => 'required|exists:personen,id',
            // 'leihnehmer_id' => 'required|exists:personen,id',
            'von' => 'nullable|date',
            'bis' => 'nullable|date|after_or_equal:von',
        ];
    }

    /**
     * Get custom messages for validator errors.
     */
    public function messages(): array
    {
        return [
            'hund_id.required' => 'Die Hunde-ID ist erforderlich.',
            'hund_id.exists' => 'Der ausgewählte Hund existiert nicht.',
            'zwinger_id.required' => 'Die Zwinger-ID ist erforderlich.',
            'zwinger_id.exists' => 'Der ausgewählte Zwinger existiert nicht.',
            'leihsteller_id.required' => 'Die Leihsteller-ID ist erforderlich.',
            'leihsteller_id.exists' => 'Der ausgewählte Leihsteller existiert nicht.',
            // 'leihnehmer_id.required' => 'Die Leihnehmer-ID ist erforderlich.',
            // 'leihnehmer_id.exists' => 'Der ausgewählte Leihnehmer existiert nicht.',
            'von.date' => 'Das Von-Datum muss ein gültiges Datum sein.',
            'bis.date' => 'Das Bis-Datum muss ein gültiges Datum sein.',
            'bis.after_or_equal' => 'Das Bis-Datum muss nach oder gleich dem Von-Datum liegen.',
        ];
    }
}
