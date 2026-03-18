<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreHundabgabeantragRequest extends FormRequest
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
            'abgabedatum' => 'required|date_format:d.m.Y',
            'bemerkungen_antragsteller' => 'nullable|string|max:1000',
            'bestaetigung_richtigkeit' => 'required|boolean|accepted',
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
            'abgabedatum.required' => 'Das Abgabedatum ist erforderlich.',
            'abgabedatum.date_format' => 'Das Abgabedatum muss im Format TT.MM.JJJJ angegeben werden.',
            'bemerkungen_antragsteller.max' => 'Die Bemerkungen dürfen maximal 1000 Zeichen lang sein.',
            'bestaetigung_richtigkeit.required' => 'Die Bestätigung der Richtigkeit ist erforderlich.',
            'bestaetigung_richtigkeit.accepted' => 'Sie müssen die Richtigkeit der Angaben bestätigen.',
        ];
    }
}
