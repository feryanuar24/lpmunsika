<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateFooterRequest extends FormRequest
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
            'name' => [
                'sometimes',
                'required',
                'string',
                'max:255',
                Rule::unique('footers')->whereNull('deleted_at')->ignore($this->footer),
            ],
            'url' => ['sometimes', 'required', 'string', 'max:255'],
            'description' => ['sometimes', 'nullable', 'string', 'max:1000'],
        ];
    }

    /**
     * Custom messages for validation errors.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'name.required' => 'Nama footer wajib diisi.',
            'name.string' => 'Nama footer harus berupa teks.',
            'name.max' => 'Nama footer maksimal :max karakter.',
            'name.unique' => 'Nama footer sudah digunakan.',
            'url.required' => 'URL wajib diisi.',
            'url.string' => 'URL harus berupa teks.',
            'url.max' => 'URL maksimal :max karakter.',
            'description.string' => 'Deskripsi harus berupa teks.',
            'description.max' => 'Deskripsi maksimal :max karakter.',
        ];
    }
}
