<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class UploadDocumentRequest extends FormRequest
{
    public function authorize(): bool
    {
        // Any authenticated user with a role can upload
        return Auth::check();
    }

    public function rules(): array
    {
        return [
            'document_type' => ['required', 'string', 'max:100'],
            'file'          => [
                'required',
                'file',
                'mimes:pdf,jpg,jpeg,png',
                'max:5120', // 5 MB
            ],
        ];
    }

    public function messages(): array
    {
        return [
            'document_type.required' => 'Please select a document type.',
            'file.required'          => 'Please choose a file to upload.',
            'file.mimes'             => 'Only PDF, JPG, and PNG files are allowed.',
            'file.max'               => 'File size must not exceed 5 MB.',
        ];
    }
}
