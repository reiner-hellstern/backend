<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateGebuehrenordnungRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true; // TODO: Implement proper authorization
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'name' => 'sometimes|required|string|max:255',
            'gueltig_ab' => 'sometimes|required|string', // String da deutsche Formate
            'gueltig_bis' => 'nullable|string',
            'stand' => 'nullable|string',
        ];
    }

    /**
     * Get custom messages for validator errors.
     */
    public function messages(): array
    {
        return [
            'name.required' => 'Der Name der Gebührenordnung ist erforderlich.',
            'name.max' => 'Der Name darf maximal 255 Zeichen lang sein.',
            'gueltig_ab.required' => 'Das Gültigkeitsdatum ist erforderlich.',
            'gueltig_ab.string' => 'Bitte geben Sie ein gültiges Datum ein.',
            'gueltig_bis.string' => 'Bitte geben Sie ein gültiges Enddatum ein.',
            'stand.string' => 'Bitte geben Sie ein gültiges Datum für den Stand ein.',
        ];
    }
}
