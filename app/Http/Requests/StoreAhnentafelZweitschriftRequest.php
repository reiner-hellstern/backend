<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreAhnentafelZweitschriftRequest extends FormRequest
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
            'hund_id' => 'required|integer|exists:hunde,id',
            'antragsteller_id' => 'required|integer|exists:personen,id',
            'bemerkungen_antragsteller' => 'nullable|string|max:1000',
            'bestaetigung_angaben' => 'required|boolean|accepted',
            'bestaetigung_verlust' => 'required|boolean|accepted',
            'bestaetigung_gebuehren' => 'required|boolean|accepted',
            'eigentuemer_ids' => 'nullable|array',
            'eigentuemer_ids.*' => 'integer|exists:personen,id',
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
            'hund_id.required' => 'Die Hunde-ID ist erforderlich.',
            'hund_id.exists' => 'Der ausgewählte Hund existiert nicht.',
            'antragsteller_id.required' => 'Die Antragsteller-ID ist erforderlich.',
            'antragsteller_id.exists' => 'Der ausgewählte Antragsteller existiert nicht.',
            'bemerkungen_antragsteller.max' => 'Die Bemerkungen dürfen maximal 1000 Zeichen lang sein.',
            'bestaetigung_angaben.required' => 'Die Bestätigung der Angaben ist erforderlich.',
            'bestaetigung_angaben.accepted' => 'Sie müssen die Richtigkeit der Angaben bestätigen.',
            'bestaetigung_verlust.required' => 'Die Bestätigung des Verlusts ist erforderlich.',
            'bestaetigung_verlust.accepted' => 'Sie müssen den Verlust der Ahnentafel bestätigen.',
            'bestaetigung_gebuehren.required' => 'Die Bestätigung der Gebühren ist erforderlich.',
            'bestaetigung_gebuehren.accepted' => 'Sie müssen die Gebühren akzeptieren.',
        ];
    }
}
