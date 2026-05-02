<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class UpdateCourtRequest extends FormRequest
{
    public function authorize(): bool
    {
        return Auth::check() && Auth::user()->hasAnyRole(['admin', 'super_admin']);
    }

    public function rules(): array
    {
        return [
            'name'    => ['required', 'string', 'max:255'],
            'area'    => ['nullable', 'string', 'max:255'],
            'city'    => ['nullable', 'string', 'max:100'],
            'pincode' => ['nullable', 'digits:6'],
        ];
    }

    public function messages(): array
    {
        return [
            'name.required'  => 'Court name is required.',
            'pincode.digits' => 'PIN Code must be exactly 6 digits.',
        ];
    }
}
