<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdatePermissionRequest extends FormRequest
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
                Rule::unique('permissions')->whereNull('deleted_at')->ignore($this->permission),
            ],
            'display_name' => ['sometimes', 'required', 'string', 'max:255'],
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
