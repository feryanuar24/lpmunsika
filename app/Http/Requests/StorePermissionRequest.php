<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StorePermissionRequest extends FormRequest
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
            'name' => [
                'required',
                'string',
                'max:255',
                Rule::unique('permissions')->whereNull('deleted_at'),
            ],
            'display_name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string', 'max:1000'],
        ];
    }

    /**
     * Custom messages for validation errors.
     */
    public function messages(): array
    {
        return [
            'name.required' => 'Nama permission wajib diisi.',
            'name.string' => 'Nama permission harus berupa teks.',
            'name.max' => 'Nama permission maksimal :max karakter.',
            'name.unique' => 'Nama permission sudah digunakan.',
            'display_name.required' => 'Nama permission wajib diisi.',
            'display_name.string' => 'Nama permission harus berupa teks.',
            'display_name.max' => 'Nama permission maksimal :max karakter.',
            'description.string' => 'Deskripsi harus berupa teks.',
            'description.max' => 'Deskripsi maksimal :max karakter.',
        ];
    }
}
