<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateCourtRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->check() && auth()->user()->hasAnyRole(['admin', 'super_admin']);
    }

    public function rules(): array
    {
        return [
            'name'      => ['required', 'string', 'max:255'],
            'type'      => ['required', 'in:supreme,high,district,session,civil,criminal,family,consumer,tribunal'],
            'city'      => ['required', 'string', 'max:100'],
            'state'     => ['required', 'string', 'max:100'],
            'pincode'   => ['nullable', 'digits:6'],
            'address'   => ['nullable', 'string', 'max:500'],
            'phone'     => ['nullable', 'string', 'max:20'],
            'email'     => ['nullable', 'email', 'max:255'],
            'is_active' => ['nullable', 'boolean'],
        ];
    }

    public function messages(): array
    {
        return [
            'name.required'  => 'Court name is required.',
            'type.required'  => 'Please select a court type.',
            'type.in'        => 'Selected court type is invalid.',
            'city.required'  => 'City is required.',
            'state.required' => 'State is required.',
            'pincode.digits' => 'Pincode must be exactly 6 digits.',
            'email.email'    => 'Please enter a valid email address.',
        ];
    }
}
