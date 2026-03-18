<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreLinkRequest extends FormRequest
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
            'linkkategorie_id' => 'required|exists:linkkategorien,id',
            'name' => 'required|string|max:255',
            'url' => 'required|url|max:500',
            'beschreibung' => 'nullable|string|max:1000',
        ];
    }

    /**
     * Get custom messages for validator errors.
     */
    public function messages(): array
    {
        return [
            'linkkategorie_id.required' => 'Eine Kategorie ist erforderlich.',
            'linkkategorie_id.exists' => 'Die ausgewählte Kategorie existiert nicht.',
            'name.required' => 'Der Name ist erforderlich.',
            'name.string' => 'Der Name muss ein Text sein.',
            'name.max' => 'Der Name darf maximal 255 Zeichen lang sein.',
            'url.required' => 'Die URL ist erforderlich.',
            'url.url' => 'Die URL muss eine gültige Web-Adresse sein.',
            'url.max' => 'Die URL darf maximal 500 Zeichen lang sein.',
            'beschreibung.string' => 'Die Beschreibung muss ein Text sein.',
            'beschreibung.max' => 'Die Beschreibung darf maximal 1000 Zeichen lang sein.',
        ];
    }
}
