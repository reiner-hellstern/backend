<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateAufgabenTemplateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'thema' => 'required|string|max:255',
            'beschreibung' => 'required|string',
            'path' => 'nullable|string|max:255',
            'section_id' => 'required|exists:sections,id',
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Der Name ist erforderlich.',
            'thema.required' => 'Das Thema ist erforderlich.',
            'beschreibung.required' => 'Die Beschreibung ist erforderlich.',
            'section_id.required' => 'Die Section ist erforderlich.',
            'section_id.exists' => 'Die gewählte Section ist ungültig.',
        ];
    }
}
