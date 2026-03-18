<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SendEmailTemplateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'person_ids' => ['required', 'array', 'min:1'],
            'person_ids.*' => ['integer', 'exists:personen,id'],
            'context' => ['sometimes', 'array'],
            'recipient_override' => ['sometimes', 'array'],
            'recipient_override.mode' => ['sometimes', 'in:include,replace'],
            'recipient_override.emails' => ['sometimes', 'array', 'min:1'],
            'recipient_override.emails.*' => ['required', 'email'],
            'meta' => ['sometimes', 'array'],
        ];
    }

    protected function prepareForValidation(): void
    {
        $personIds = $this->input('person_ids');
        if (is_array($personIds)) {
            $personIds = array_values(array_unique(array_filter(array_map('intval', $personIds), fn ($value) => $value > 0)));
            $this->merge(['person_ids' => $personIds]);
        }

        $overrideEmails = data_get($this->input('recipient_override', []), 'emails');
        if (is_array($overrideEmails)) {
            $normalizedEmails = array_values(array_unique(array_filter(array_map(fn ($email) => trim((string) $email), $overrideEmails), fn ($email) => $email !== '')));
            $this->merge(['recipient_override' => array_merge($this->input('recipient_override', []), ['emails' => $normalizedEmails])]);
        }
    }
}
