<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class UploadCourtMapRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        // Admin or super_admin are allowed. Route middleware also protects this, but we can verify role.
        return Auth::check() && Auth::user()->hasAnyRole(['admin', 'super_admin']);
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'map_file' => [
                'required',
                'file',
                'mimes:pdf',
                'max:10240', // 10 MB
            ],
        ];
    }

    /**
     * Get custom messages for validator errors.
     */
    public function messages(): array
    {
        return [
            'map_file.required' => 'Please select a PDF map file to upload.',
            'map_file.file'     => 'The uploaded file is invalid.',
            'map_file.mimes'    => 'Only PDF files are allowed for court maps.',
            'map_file.max'      => 'The PDF map size must not exceed 10 MB.',
        ];
    }
}
