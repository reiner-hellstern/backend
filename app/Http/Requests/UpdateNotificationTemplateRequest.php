<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateNotificationTemplateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true; // TODO: Add proper authorization logic
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'section_id' => 'sometimes|required|exists:sections,id',
            'thema' => 'sometimes|required|string|max:255',
            'position' => 'sometimes|required|string|max:255',
            'vue_komponente' => 'sometimes|nullable|string|max:255',
            'text' => 'nullable|string',
            'active' => 'sometimes|boolean',
            'assignables' => 'nullable|array',
            'assignables.*.type' => 'required_with:assignables|string',
            'assignables.*.id' => 'required_with:assignables|integer',
        ];
    }

    /**
     * Get custom error messages for validator errors.
     */
    public function messages(): array
    {
        return [
            'section_id.required' => 'Bitte wählen Sie eine Section aus.',
            'section_id.exists' => 'Die gewählte Section existiert nicht.',
            'thema.required' => 'Das Thema ist erforderlich.',
            'thema.max' => 'Das Thema darf maximal 255 Zeichen lang sein.',
            'position.required' => 'Die Position ist erforderlich.',
            'position.integer' => 'Die Position muss eine Zahl sein.',
            'position.min' => 'Die Position muss mindestens 1 sein.',
            'vue_komponente.max' => 'Die Vue-Komponente darf maximal 255 Zeichen lang sein.',
            'assignables.*.type.required_with' => 'Der Typ der Zuordnung ist erforderlich.',
            'assignables.*.id.required_with' => 'Die ID der Zuordnung ist erforderlich.',
            'assignables.*.id.integer' => 'Die ID der Zuordnung muss eine Zahl sein.',
        ];
    }
}
