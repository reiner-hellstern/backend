<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EndSonderleiterRequest extends FormRequest
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
            'ende' => 'required|date',
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
            'ende.required' => 'Ein Enddatum ist erforderlich.',
            'ende.date' => 'Das Enddatum muss ein gültiges Datum sein.',
        ];
    }
}
