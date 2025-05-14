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
            'email_address' => 'nullable|email',
            'delete_after_read' => 'nullable|boolean',
            'expire_in_hours' => 'nullable|integer'
        ];
    }

    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            $hasRecipientId = $this->filled('recipient_id');
            $hasName = $this->filled('name');
            $hasEmail = $this->filled('email_address');

            if ($hasRecipientId && ($hasName || $hasEmail)){
                $validator->errors()->add('recipient_id', 'Provide either a colleague or a name and an email_address, not both.');
            }

            if (!$hasRecipientId && (!$hasName || !$hasEmail)){
                $validator->errors()->add('recipient_id', 'You must provide either a colleague or a name and an email_address.');
            }

            $hasDeleteAfterRead = $this->filled('delete_after_read');
            $hasExpireInHours = $this->filled('expire_in_hours');

            if (!$hasDeleteAfterRead && !$hasExpireInHours){
                $validator->errors()->add('expire_in_hours', 'Either set the expire in hours or select the delete message after read checkbox.');
            }
        });
    }
}
