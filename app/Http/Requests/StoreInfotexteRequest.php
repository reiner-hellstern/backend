<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreInfotexteRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'section_id' => 'required|exists:sections,id',
            'thema' => 'required|string|max:255',
            'position' => 'nullable|string|max:255',
            'vue_component' => 'nullable|string|max:255',
            'titel' => 'nullable|string|max:255',
            'text' => 'nullable|string',
            'aktiv' => 'sometimes|boolean',
        ];
    }
}
