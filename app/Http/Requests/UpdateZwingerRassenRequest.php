<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateZwingerRassenRequest extends FormRequest
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
            'zwinger_id' => 'required|integer|exists:zwinger,id',
            'rassen' => 'required|array|min:1',
            'rassen.*' => 'required|integer|exists:rassen,id',
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
            'zwinger_id.required' => 'Die Zwinger-ID ist erforderlich.',
            'zwinger_id.exists' => 'Der ausgewählte Zwinger existiert nicht.',
            'rassen.required' => 'Es muss mindestens eine Rasse ausgewählt werden.',
            'rassen.array' => 'Die Rassen müssen als Array übergeben werden.',
            'rassen.min' => 'Es muss mindestens eine Rasse ausgewählt werden.',
            'rassen.*.required' => 'Jede Rasse muss eine ID haben.',
            'rassen.*.integer' => 'Die Rassen-ID muss eine Zahl sein.',
            'rassen.*.exists' => 'Eine der ausgewählten Rassen existiert nicht.',
        ];
    }
}
