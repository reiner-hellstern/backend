<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateZwingerKontaktdatenRequest extends FormRequest
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
            'telefon_1' => 'required|string|max:255',
            'telefon_2' => 'nullable|string|max:255',
            'email_1' => 'required|email|max:255',
            'email_2' => 'nullable|email|max:255',
            'website_1' => 'nullable|url|max:255',
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
            'telefon_1.required' => 'Telefonnummer 1 ist erforderlich.',
            'email_1.required' => 'E-Mail-Adresse 1 ist erforderlich.',
            'email_1.email' => 'Die E-Mail-Adresse 1 muss eine gültige E-Mail-Adresse sein.',
            'email_2.email' => 'Die E-Mail-Adresse 2 muss eine gültige E-Mail-Adresse sein.',
            'website_1.url' => 'Die Website-URL muss eine gültige URL sein.',
        ];
    }
}
