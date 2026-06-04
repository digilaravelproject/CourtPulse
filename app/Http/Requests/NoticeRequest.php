<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class NoticeRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return Auth::check() && Auth::user()->hasAnyRole(['admin', 'super_admin']);
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        $isUpdate = $this->route('notice') !== null;

        return [
            'title'          => ['required', 'string', 'max:150'],
            'court_id'       => ['nullable', 'exists:courts,id'],
            'pdf_file'       => [
                $isUpdate ? 'nullable' : 'required',
                'file',
                'mimes:pdf',
                'max:10240', // 10 MB
            ],
            'show_new_badge' => ['nullable'],
        ];
    }

    /**
     * Get custom messages for validator errors.
     */
    public function messages(): array
    {
        return [
            'title.required'     => 'The notice title is required.',
            'title.max'          => 'The title must not exceed 150 characters.',
            'court_id.exists'    => 'The selected court is invalid.',
            'pdf_file.required'  => 'Please upload a PDF document for the notice.',
            'pdf_file.mimes'     => 'Only PDF files are allowed for notices & circulars.',
            'pdf_file.max'       => 'The PDF file size must not exceed 10 MB.',
        ];
    }
}
