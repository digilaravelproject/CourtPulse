<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BlogRequest extends FormRequest
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
        $rules = [
            'title'    => 'required|string|max:200',
            'category' => 'required|string|max:50',
            'content'  => 'required|string|min:10',
        ];

        // Image validation: required on create, optional on update
        if ($this->isMethod('POST') && !$this->route('blog')) {
            $rules['image'] = 'required|file|image|mimes:jpg,jpeg,png,webp|max:5120';
        } else {
            $rules['image'] = 'nullable|file|image|mimes:jpg,jpeg,png,webp|max:5120';
        }

        return $rules;
    }

    /**
     * Get custom error messages for validator errors.
     */
    public function messages(): array
    {
        return [
            'title.required'    => 'Please provide a blog title.',
            'category.required' => 'Please specify a blog category.',
            'content.required'  => 'Blog content is required.',
            'content.min'       => 'Blog content must be at least 10 characters long.',
            'image.required'    => 'Please upload a blog thumbnail image.',
            'image.image'       => 'The file must be an image.',
            'image.mimes'       => 'Supported image formats are: JPG, JPEG, PNG, WEBP.',
            'image.max'         => 'The image size must not exceed 5MB.',
        ];
    }
}
