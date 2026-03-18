<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateNotificationRequest extends FormRequest
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
            'message' => 'sometimes|required|string|max:255',
            'receiver_id' => 'sometimes|nullable|exists:users,id',
            'notifiable_id' => 'sometimes|nullable|integer',
            'notifiable_type' => 'sometimes|nullable|string|max:255',
            'path' => 'sometimes|nullable|string|max:255',
            'pathname' => 'sometimes|nullable|string|max:255',
            'read_at' => 'sometimes|nullable|date',
        ];
    }
}
