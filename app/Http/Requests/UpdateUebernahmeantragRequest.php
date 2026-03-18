<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateUebernahmeantragRequest extends FormRequest
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
            'senden' => 'boolean',
            'eigentuemer_ids' => 'array',
            'dokumente' => 'array',
            'bezahlt' => 'boolean',
            'angenommen' => 'boolean',
            'bemerkungen_antragsteller' => 'string|nullable',
            'bemerkungen_drc' => 'string|nullable',
            'bemerkungen_intern' => 'string|nullable',
            'ablehnung_begruendung' => 'string|nullable',
            'status_id' => 'integer',
        ];
    }
}
