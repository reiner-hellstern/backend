<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreZuchtzulassungRequest extends FormRequest
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
            'antragsteller_id' => 'required',
            'eigentuemer_ids' => 'array',
            'dokumente' => 'array',
            'senden' => 'boolean',
            'bezahlt' => 'boolean',
            'angenommen' => 'boolean',
            'bemerkungen_antragsteller' => 'string|nullable',
            'bemerkungen_drc' => 'string|nullable',
            'bemerkungen_intern' => 'string|nullable',
            'ablehnung_begruendung' => 'string|nullable',
        ];
    }
}
