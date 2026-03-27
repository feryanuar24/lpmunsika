<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreTagRequest extends FormRequest
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
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            'name' => [
                'required',
                'string',
                'max:255',
                Rule::unique('tags')->whereNull('deleted_at'),
            ],
            'description' => ['nullable', 'string', 'max:1000'],
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
            'name.required' => 'Nama tag wajib diisi.',
            'name.string' => 'Nama tag harus berupa teks.',
            'name.max' => 'Nama tag tidak boleh lebih dari :max karakter.',
            'name.unique' => 'Nama tag sudah digunakan.',
            'description.string' => 'Deskripsi tag harus berupa teks.',
            'description.max' => 'Deskripsi tag tidak boleh lebih dari :max karakter.',
        ];
    }
}
