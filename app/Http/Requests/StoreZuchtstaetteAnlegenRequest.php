<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreZuchtstaetteAnlegenRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            // Zuchtstätten-Daten
            'zuchtstaette' => ['required', 'array'],
            'zuchtstaette.strasse' => ['required', 'string', 'max:255'],
            'zuchtstaette.adresszusatz' => ['nullable', 'string', 'max:255'],
            'zuchtstaette.postleitzahl' => ['required', 'string', 'max:10'],
            'zuchtstaette.ort' => ['required', 'string', 'max:255'],
            'zuchtstaette.land' => ['required', 'string', 'max:255'],
            'zuchtstaette.laenderkuerzel' => ['nullable', 'string', 'max:10'],
            'zuchtstaette.status_id' => ['required', 'integer', Rule::exists('optionen_zuchtstaette_stati', 'id')],
            'zuchtstaette.anleger_id' => ['required', 'integer', Rule::exists('personen', 'id')],
            'zuchtstaette.zwinger_id' => ['nullable', 'integer', Rule::exists('zwinger', 'id')],

            // Miteigentümer
            'miteigentuemer_ids' => ['nullable', 'array'],
            'miteigentuemer_ids.*' => ['integer', Rule::exists('personen', 'id')],

            // Bestätigungen
            'bestaetigung_angaben' => ['required', 'boolean'],

            // Zuchtstättenbesichtigung (optional)
            'zuchtstaettenbesichtigung' => ['nullable', 'array'],
            'zuchtstaettenbesichtigung.status_id' => ['required_with:zuchtstaettenbesichtigung', 'integer', Rule::exists('optionen_zst_besichtigung_stati', 'id')],
            'zuchtstaettenbesichtigung.grund_id' => ['required_with:zuchtstaettenbesichtigung', 'integer', Rule::exists('optionen_zst_besichtigung_grund', 'id')],
            'zuchtstaettenbesichtigung.antragsteller_id' => ['required_with:zuchtstaettenbesichtigung', 'integer', Rule::exists('personen', 'id')],
            'zuchtstaettenbesichtigung.zuchtwart_id' => ['required_with:zuchtstaettenbesichtigung', 'integer', Rule::exists('zuchtwarte', 'id')],
            'zuchtstaettenbesichtigung.termin_am' => ['required_with:zuchtstaettenbesichtigung', 'date_format:d.m.Y'],
            'zuchtstaettenbesichtigung.bestaetigung_angaben' => ['required_with:zuchtstaettenbesichtigung', 'boolean'],
            'zuchtstaettenbesichtigung.aktivierung_automatisch' => ['nullable', 'boolean'],
            'zuchtstaettenbesichtigung.aktivierung_am' => ['nullable', 'date_format:d.m.Y'],
        ];
    }

    public function messages(): array
    {
        return [
            'zuchtstaette.strasse.required' => 'Die Straße der Zuchtstätte ist erforderlich.',
            'zuchtstaette.postleitzahl.required' => 'Die Postleitzahl der Zuchtstätte ist erforderlich.',
            'zuchtstaette.ort.required' => 'Der Ort der Zuchtstätte ist erforderlich.',
            'zuchtstaettenbesichtigung.zuchtwart_id.required_with' => 'Ein Zuchtwart muss ausgewählt werden.',
            'zuchtstaettenbesichtigung.termin_am.required_with' => 'Das Datum der Besichtigung ist erforderlich.',
        ];
    }
}
