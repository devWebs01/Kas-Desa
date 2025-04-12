<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TransactionUpdateRequest extends FormRequest
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
     */
    public function rules(): array
    {
        return [
            'title' => ['required', 'string'],
            'category' => ['required', 'in:credit,debit'],
            'amount' => ['required', 'numeric', 'between:-999999.99,999999.99'],
            'invoice' => ['nullable', 'string', 'unique:transactions,invoice'],
            'date' => ['required', 'date'],
            'description' => ['required', 'string'],
            'recipient_id' => ['required', 'integer', 'exists:recipients,id'],
        ];
    }
}
