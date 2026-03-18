<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreVerstorbeneRequest extends FormRequest
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
            'hund_id' => 'required|integer|exists:hunde,id',
            'verstorben_am' => 'required|date_format:d.m.Y',
            'todesursache_id' => 'nullable|integer|exists:optionen_todesursache,id',
            'todesursache_text' => 'nullable|string|max:255',
            'einschlaeferung' => 'nullable|boolean',
            'arzt_id' => 'nullable|integer|exists:personen,id',
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
            'hund_id.required' => 'Die Hunde-ID ist erforderlich.',
            'hund_id.exists' => 'Der ausgewählte Hund existiert nicht.',
            'verstorben_am.required' => 'Das Sterbedatum ist erforderlich.',
            'verstorben_am.date_format' => 'Das Sterbedatum muss im Format TT.MM.JJJJ angegeben werden.',
            'todesursache_id.integer' => 'Die Todesursache muss eine gültige ID sein.',
            'todesursache_id.exists' => 'Die ausgewählte Todesursache existiert nicht.',
            'todesursache_text.max' => 'Die Todesursache darf maximal 255 Zeichen lang sein.',
            'einschlaeferung.boolean' => 'Die Angabe zur Einschläferung muss wahr oder falsch sein.',
            'arzt_id.exists' => 'Der ausgewählte Arzt existiert nicht.',
        ];
    }
}
