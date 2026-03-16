<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ReviewDocumentRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->check() && auth()->user()->hasAnyRole(['admin', 'super_admin']);
    }

    public function rules(): array
    {
        return [
            'status'           => ['required', 'in:approved,rejected'],
            'rejection_reason' => ['nullable', 'required_if:status,rejected', 'string', 'max:500'],
        ];
    }

    public function messages(): array
    {
        return [
            'status.required'                => 'A review decision is required.',
            'status.in'                      => 'Status must be approved or rejected.',
            'rejection_reason.required_if'   => 'Please provide a reason for rejection.',
        ];
    }
}
