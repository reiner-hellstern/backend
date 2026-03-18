<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateHundRequest extends FormRequest
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
            // 'name' => 'required',
            // 'rasse' => 'required',
            // 'farbe' => 'required',
            // 'zuchtbuchnummer' => 'required',
            // 'wurfdatum' => 'required',
            // 'chipnummer' => 'required',
            // 'geschlecht' => 'required',
            // 'vater_zuchtbuchnummer' => 'required',
            // 'mutter_zuchtbuchnummer' => 'required',
            // 'zuchthund' => 'required',
            // 'zwinger_nr' => 'required',
            // 'mutter_name' => 'required',
            // 'vater_name' => 'required',
            // 'zwinger_name' => 'required',
            // 'zwinger_strasse' => 'required',
            // 'zwinger_plz' => 'required',
            // 'zwinger_ort' => 'required',
            // 'zwinger_fci' => 'required',
            // 'zwinger_nr' => 'required',
            // 'bemerkung' => 'required',
        ];
    }
}
