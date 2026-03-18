<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateZweitwohnsitznachweisRequest extends FormRequest
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
            'zuchtstaette_id' => [
                'required',
                'exists:zuchtstaetten,id',
            ],
            'bemerkungen' => 'nullable|string|max:1000',
            'aktiv' => 'boolean',
            'status' => 'boolean',
            'bestaetigt_am' => 'nullable|date',
            'bestaetigt_von' => 'nullable|exists:personen,id',
        ];
    }

    /**
     * Get custom messages for validator errors.
     */
    public function messages(): array
    {
        return [
            'person_id.required' => 'Die Person ist erforderlich.',
            'person_id.exists' => 'Die angegebene Person existiert nicht.',
            'zuchtstaette_id.required' => 'Die Zuchtstätte ist erforderlich.',
            'zuchtstaette_id.exists' => 'Die angegebene Zuchtstätte existiert nicht.',
            'bemerkungen.max' => 'Die Bemerkungen dürfen nicht länger als 1000 Zeichen sein.',
            'bestaetigt_von.exists' => 'Die bestätigende Person existiert nicht.',
        ];
    }
}
