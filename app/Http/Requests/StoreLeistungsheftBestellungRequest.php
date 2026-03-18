<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreLeistungsheftBestellungRequest extends FormRequest
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
            'besteller_id' => 'required|integer|exists:personen,id',
            'anmerkungen_besteller' => 'nullable|string|max:1000',
            'bestaetigung_richtigkeit' => 'required|boolean|accepted',

            // Für erstes Leistungsheft
            'at_versendet_am' => 'nullable|date',
            'bestaetigung_at_versendet' => 'nullable|boolean',

            // Für Folge-Leistungshefte
            'letztes_lh_vollstaendig' => 'nullable|boolean',
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
            'besteller_id.required' => 'Die Besteller-ID ist erforderlich.',
            'besteller_id.exists' => 'Der ausgewählte Besteller existiert nicht.',
            'anmerkungen_besteller.max' => 'Die Bemerkungen dürfen maximal 1000 Zeichen lang sein.',
            'bestaetigung_richtigkeit.required' => 'Die Bestätigung der Richtigkeit ist erforderlich.',
            'bestaetigung_richtigkeit.accepted' => 'Sie müssen die Richtigkeit der Angaben bestätigen.',
            'at_versendet_am.date' => 'Das Datum muss ein gültiges Datum sein.',
        ];
    }
}
