<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreLeistungsheftRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'leistungsheft.hund_id' => 'required',
            'leistungsheft.besteller_id' => 'required',
            'leistungsheft.atstatus_id' => 'integer',
            'leistungsheft.at_versendet_am' => 'string',
            'leistungsheft.bezahlt_am' => 'date|nullable',
            'leistungsheft.gebuehr' => 'numeric',
            'leistungsheft.vollstaendig' => 'boolean',
            'leistungsheft.verlustmeldung' => 'boolean',
            'leistungsheft.dokumente' => 'array',
            'leistungsheft.bestellen' => 'boolean',
            'leistungsheft.anmerkungen_besteller' => 'string|nullable',
        ];
    }
}
