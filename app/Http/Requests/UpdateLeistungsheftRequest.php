<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateLeistungsheftRequest extends FormRequest
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
            'hund_id' => 'required',
            'besteller_id' => 'required',
            'atstatus_id' => 'integer',
            'bezahlstatus_id' => 'integer',
            'status_id' => 'integer',
            'at_versendet_am' => 'date|nullable',
            'bezahlt_am' => 'date|nullable',
            'gebuehr' => 'numeric',
            'vollstaendig' => 'boolean',
            'vollstaendig_drc' => 'boolean',
            'verlustmeldung' => 'boolean',
            'eigentuemer_ids' => 'array',
            'dokumente' => 'array',
            'bestellen' => 'boolean',
            'bezahlt' => 'boolean',
            'anmerkungen_besteller' => 'string|nullable',
            'anmerkungen_intern' => 'string|nullable',
        ];
    }
}
