<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreKastrationSterilisationRequest extends FormRequest
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
            'hund_id' => 'required|exists:hunde,id',
            'eingriff_am' => 'required|date',
            'eingriff' => 'required|in:kastration,sterilisation',
            'grund_id' => 'nullable|exists:optionen_kastration_sterilisation,id',
            'grund_text' => 'nullable|string|max:1000',
            'arzt' => 'nullable|array',
            'arzt.id' => 'nullable|exists:aerzte,id',
            'arzt.vorname' => 'nullable|string|max:255',
            'arzt.nachname' => 'nullable|string|max:255',
            'arzt.praxisname' => 'nullable|string|max:255',
            'arzt.postleitzahl' => 'nullable|string|max:10',
            'arzt.ort' => 'nullable|string|max:255',
        ];
    }

    /**
     * Get custom messages for validator errors.
     */
    public function messages(): array
    {
        return [
            'hund_id.required' => 'Die Hunde-ID ist erforderlich.',
            'hund_id.exists' => 'Der ausgewählte Hund existiert nicht.',
            'eingriff_am.required' => 'Das Datum des Eingriffs ist erforderlich.',
            'eingriff_am.date' => 'Das Datum muss ein gültiges Datum sein.',
            'eingriff.required' => 'Bitte wählen Sie den durchgeführten Eingriff aus.',
            'eingriff.in' => 'Der Eingriff muss entweder Kastration oder Sterilisation sein.',
        ];
    }
}
