<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateEmailTemplateRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'section_id' => 'sometimes|required|exists:sections,id',
            'thema' => 'sometimes|required|string|max:255',
            'position' => 'nullable|string|max:255',
            'vue_component' => 'nullable|string|max:255',
            'file' => 'nullable|string|max:255',
            'subject' => 'nullable|string|max:255',
            'body' => 'nullable|string',
            'aktiv' => 'sometimes|boolean',
        ];
    }
}
