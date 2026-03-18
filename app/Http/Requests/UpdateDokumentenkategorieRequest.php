<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateDokumentenkategorieRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true; // Authorization will be handled by middleware/policies
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => [
                'sometimes',
                'required',
                'string',
                'max:255',
                Rule::unique('dokumentenkategorien', 'name')->ignore($this->route('dokumentenkategorie')),
            ],
            'beschreibung' => ['sometimes', 'nullable', 'string', 'max:65535'],
            'reihenfolge' => ['sometimes', 'integer', 'min:0'],
            'aktiv' => ['sometimes', 'boolean'],
            'assigned_roles' => ['sometimes', 'array'],
            'assigned_roles.*' => ['integer', 'exists:roles,id'],
        ];
    }

    /**
     * Get custom error messages for validator errors.
     */
    public function messages(): array
    {
        return [
            'name.required' => 'Der Name der Dokumentenkategorie ist erforderlich.',
            'name.string' => 'Der Name muss ein Text sein.',
            'name.max' => 'Der Name darf maximal 255 Zeichen lang sein.',
            'name.unique' => 'Eine Dokumentenkategorie mit diesem Namen existiert bereits.',
            'beschreibung.string' => 'Die Beschreibung muss ein Text sein.',
            'beschreibung.max' => 'Die Beschreibung ist zu lang.',
            'reihenfolge.integer' => 'Die Reihenfolge muss eine Zahl sein.',
            'reihenfolge.min' => 'Die Reihenfolge darf nicht negativ sein.',
            'aktiv.boolean' => 'Der Aktiv-Status muss wahr oder falsch sein.',
            'assigned_roles.array' => 'Die zugewiesenen Rollen müssen ein Array sein.',
            'assigned_roles.*.integer' => 'Jede Rollen-ID muss eine Zahl sein.',
            'assigned_roles.*.exists' => 'Eine oder mehrere der angegebenen Rollen existieren nicht.',
        ];
    }
}
