<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateDokumentenkategorienOrderRequest extends FormRequest
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
            'order' => ['required', 'array'],
            'order.*.id' => ['required', 'integer', 'exists:dokumentenkategorien,id'],
            'order.*.reihenfolge' => ['required', 'integer', 'min:0'],
        ];
    }

    /**
     * Get custom error messages for validator errors.
     */
    public function messages(): array
    {
        return [
            'order.required' => 'Die Reihenfolgen-Daten sind erforderlich.',
            'order.array' => 'Die Reihenfolgen-Daten müssen ein Array sein.',
            'order.*.id.required' => 'Jeder Eintrag muss eine ID haben.',
            'order.*.id.integer' => 'Die ID muss eine Zahl sein.',
            'order.*.id.exists' => 'Eine oder mehrere Dokumentenkategorien existieren nicht.',
            'order.*.reihenfolge.required' => 'Jeder Eintrag muss eine Reihenfolge haben.',
            'order.*.reihenfolge.integer' => 'Die Reihenfolge muss eine Zahl sein.',
            'order.*.reihenfolge.min' => 'Die Reihenfolge darf nicht negativ sein.',
        ];
    }
}
