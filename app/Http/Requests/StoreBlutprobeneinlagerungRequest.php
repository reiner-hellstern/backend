<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreBlutprobeneinlagerungRequest extends FormRequest
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
            'hund_id' => 'required|integer|exists:hunde,id',
            'datum_blutentnahme' => 'nullable|date',
            'datum_einlagerung' => 'nullable|date',
            'labornummer' => 'nullable|string|max:255',
            'erster_anfall' => 'nullable|integer|min:0',
            'anzahl_anfaelle' => 'nullable|integer|min:0',
            'ausschlussdiagnostik_am' => 'nullable|date',
            'anmerkungen' => 'nullable|string',
            'arzt' => 'nullable|array',
            'arzt.id' => 'nullable|integer|exists:aerzte,id',
            'arzt.vorname' => 'nullable|string|max:255',
            'arzt.nachname' => 'nullable|string|max:255',
            'arzt.praxisname' => 'nullable|string|max:255',
            'arzt.postleitzahl' => 'nullable|string|max:10',
            'arzt.ort' => 'nullable|string|max:255',
            'verwandte_hunde' => 'nullable|array',
            'verwandte_hunde.*.hund_id' => 'required|integer|exists:hunde,id',
            'verwandte_hunde.*.ausschlussdiagnostik_am' => 'nullable|date',
            'verwandte_hunde.*.arzt' => 'nullable|array',
            'verwandte_hunde.*.arzt.id' => 'nullable|integer|exists:aerzte,id',
            'verwandte_hunde.*.arzt.vorname' => 'nullable|string|max:255',
            'verwandte_hunde.*.arzt.nachname' => 'nullable|string|max:255',
            'verwandte_hunde.*.arzt.praxisname' => 'nullable|string|max:255',
            'verwandte_hunde.*.arzt.postleitzahl' => 'nullable|string|max:10',
            'verwandte_hunde.*.arzt.ort' => 'nullable|string|max:255',
        ];
    }

    /**
     * Get custom messages for validator errors.
     */
    public function messages(): array
    {
        return [
            'hund_id.required' => 'Die Hund-ID ist erforderlich.',
            'hund_id.exists' => 'Der angegebene Hund existiert nicht.',
            'datum_blutentnahme.date' => 'Das Datum der Blutentnahme muss ein gültiges Datum sein.',
            'datum_einlagerung.date' => 'Das Datum der Einlagerung muss ein gültiges Datum sein.',
            'ausschlussdiagnostik_am.date' => 'Das Datum der Ausschlussdiagnostik muss ein gültiges Datum sein.',
            'erster_anfall.integer' => 'Das Alter beim ersten Anfall muss eine Zahl sein.',
            'erster_anfall.min' => 'Das Alter beim ersten Anfall muss mindestens 0 sein.',
            'anzahl_anfaelle.integer' => 'Die Anzahl der Anfälle muss eine Zahl sein.',
            'anzahl_anfaelle.min' => 'Die Anzahl der Anfälle muss mindestens 0 sein.',
            'verwandte_hunde.*.hund_id.required' => 'Die Hund-ID ist für verwandte Hunde erforderlich.',
            'verwandte_hunde.*.hund_id.exists' => 'Ein angegebener verwandter Hund existiert nicht.',
            'verwandte_hunde.*.ausschlussdiagnostik_am.date' => 'Das Datum der Ausschlussdiagnostik für verwandte Hunde muss ein gültiges Datum sein.',
        ];
    }
}
