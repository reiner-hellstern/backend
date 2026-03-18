<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateLinkkategorieRequest extends FormRequest
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
            'name' => 'sometimes|required|string|max:100',
            'name_kurz' => 'sometimes|required|string|max:20',
            'beschreibung' => 'nullable|string|max:255',
        ];
    }

    /**
     * Get custom messages for validator errors.
     */
    public function messages(): array
    {
        return [
            'name.required' => 'Der Name ist erforderlich.',
            'name.string' => 'Der Name muss ein Text sein.',
            'name.max' => 'Der Name darf maximal 100 Zeichen lang sein.',
            'name_kurz.required' => 'Der Kurzname ist erforderlich.',
            'name_kurz.string' => 'Der Kurzname muss ein Text sein.',
            'name_kurz.max' => 'Der Kurzname darf maximal 20 Zeichen lang sein.',
            'name_kurz.unique' => 'Dieser Kurzname ist bereits vergeben.',
            'beschreibung.string' => 'Die Beschreibung muss ein Text sein.',
            'beschreibung.max' => 'Die Beschreibung darf maximal 255 Zeichen lang sein.',
            'aktiv.boolean' => 'Der Aktiv-Status muss wahr oder falsch sein.',
        ];
    }
}
