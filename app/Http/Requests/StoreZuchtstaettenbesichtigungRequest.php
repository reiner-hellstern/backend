<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class StoreZuchtstaettenbesichtigungRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function prepareForValidation(): void
    {
        $grundId = $this->input('grund_id');
        $this->merge(['grund_id_original' => (int) $grundId]);
        if ($grundId === 0 || $grundId === '0') {
            $this->merge(['grund_id' => 1]);
        }

        if ($this->has('bestaetigung_angaben')) {
            $this->merge([
                'bestaetigung_angaben' => filter_var(
                    $this->input('bestaetigung_angaben'),
                    FILTER_VALIDATE_BOOLEAN,
                    FILTER_NULL_ON_FAILURE
                ) ?? false,
            ]);
        }

        if (is_array($this->input('maengel_bestaetigt'))) {
            $this->merge([
                'maengel_bestaetigt' => collect($this->input('maengel_bestaetigt'))
                    ->map(fn ($value) => filter_var($value, FILTER_VALIDATE_BOOLEAN))
                    ->all(),
            ]);
        }

        if (is_array($this->input('zuchtstaette'))) {
            $this->merge([
                'zuchtstaette' => collect($this->input('zuchtstaette'))
                    ->map(fn ($value) => is_string($value) ? trim($value) : $value)
                    ->mapWithKeys(function ($value, $key) {
                        if ($key === 'laenderkuerzel' && is_string($value)) {
                            return [$key => Str::upper($value)];
                        }

                        return [$key => $value];
                    })
                    ->all(),
            ]);
        }
    }

    public function rules(): array
    {
        return [
            'grund_id' => ['required', 'integer', Rule::exists('optionen_zst_besichtigung_grund', 'id')],
            'antragsteller_id' => ['required', 'integer', Rule::exists('personen', 'id')],
            'zuchtwart_id' => ['required', 'integer', Rule::exists('zuchtwarte', 'id')],
            'zwinger_id' => ['nullable', 'integer', Rule::exists('zwinger', 'id')],
            'zuchtstaette_id' => ['nullable', 'integer', Rule::exists('zuchtstaetten', 'id')],
            'termin_am' => ['required', 'date_format:d.m.Y'],
            'bestaetigung_angaben' => ['required', 'boolean'],
            'anmerkung' => ['nullable', 'string'],
            'rassen' => ['nullable', 'array'],
            'rassen.*' => ['integer', Rule::exists('rassen', 'id')],
            'maengel_bestaetigt' => ['nullable', 'array'],
            'maengel_bestaetigt.*' => ['boolean'],
            'zuchtstaette' => ['required_without:zuchtstaette_id', 'array'],
            'zuchtstaette.strasse' => ['required_without:zuchtstaette_id', 'string', 'max:255'],
            'zuchtstaette.adresszusatz' => ['nullable', 'string', 'max:255'],
            'zuchtstaette.postleitzahl' => ['required_without:zuchtstaette_id', 'string', 'max:10'],
            'zuchtstaette.ort' => ['required_without:zuchtstaette_id', 'string', 'max:255'],
            'zuchtstaette.land' => ['required_without:zuchtstaette_id', 'string', 'max:255'],
            'zuchtstaette.laenderkuerzel' => ['nullable', 'string', 'max:10'],
        ];
    }

    public function withValidator($validator): void
    {
        $validator->after(function ($validator) {
            if ((int) $this->input('grund_id') === 4) {
                $acknowledgements = $this->input('maengel_bestaetigt', []);
                if (empty($acknowledgements) || collect($acknowledgements)->contains(false)) {
                    $validator->errors()->add('maengel_bestaetigt', 'Alle bestehenden Mängel müssen bestätigt werden.');
                }
            }

            if (! $this->input('zuchtstaette_id') && ! $this->input('zuchtstaette')) {
                $validator->errors()->add('zuchtstaette', 'Für den Antrag muss entweder eine bestehende Zuchtstätte ausgewählt oder eine neue Adresse angegeben werden.');
            }
        });
    }
}
