<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreMessageRequest extends FormRequest
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
            'contents' => 'required|string',
            'recipient_id' => 'nullable|integer|exists:recipients,id',
            'name' => 'nullable|string',
            'email_address' => 'nullable|email'
        ];
    }

    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            $hasRecipientId = $this->filled('recipient_id');
            $hasName = $this->filled('name');
            $hasEmail = $this->filled('email_address');

            if ($hasRecipientId && ($hasName || $hasEmail)) {
                $validator->errors()->add('recipient_id', 'Provide either a colleague or a name and an email_address, not both.');
            }

            if (!$hasRecipientId && (!$hasName || !$hasEmail)) {
                $validator->errors()->add('recipient_id', 'You must provide either a colleague or a name and an email_address.');
            }
        });
    }
}
