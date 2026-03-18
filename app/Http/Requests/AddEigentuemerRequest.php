<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AddEigentuemerRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true; // Hier könnten weitere Autorisierungsregeln implementiert werden
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'hund_id' => 'required|exists:hunde,id',
            'eigentuemer' => 'required|array',
            'eigentuemer.vorname' => 'required|string|max:255',
            'eigentuemer.nachname' => 'required|string|max:255',
            'eigentuemer.strasse' => 'required|string|max:255',
            'eigentuemer.postleitzahl' => 'required|string|max:10',
            'eigentuemer.ort' => 'required|string|max:255',
            'eigentuemer.anrede' => 'nullable|array',
            'eigentuemer.anrede.id' => 'nullable|exists:optionen_anreden,id',
            'eigentuemer.adelstitel' => 'nullable|string|max:255',
            'eigentuemer.akademischetitel' => 'nullable|string|max:255',
            'eigentuemer.email_1' => 'nullable|email|max:255',
            'eigentuemer.telefon' => 'nullable|string|max:255',
            'eigentuemer.adresszusatz' => 'nullable|string|max:255',
            'eigentuemer.land' => 'nullable|string|max:255',
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
            'hund_id.required' => 'Die Hund-ID ist erforderlich.',
            'hund_id.exists' => 'Der angegebene Hund wurde nicht gefunden.',
            'eigentuemer.required' => 'Die Daten des neuen Miteigentümers sind erforderlich.',
            'eigentuemer.vorname.required' => 'Der Vorname ist erforderlich.',
            'eigentuemer.nachname.required' => 'Der Nachname ist erforderlich.',
            'eigentuemer.strasse.required' => 'Die Straße ist erforderlich.',
            'eigentuemer.postleitzahl.required' => 'Die Postleitzahl ist erforderlich.',
            'eigentuemer.ort.required' => 'Der Ort ist erforderlich.',
            'eigentuemer.email_1.email' => 'Die E-Mail-Adresse muss ein gültiges Format haben.',
            'eigentuemer.anrede.id.exists' => 'Die gewählte Anrede ist ungültig.',
        ];
    }
}
