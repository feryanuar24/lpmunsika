<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StorePlatformRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Validation rules.
     */
    public function rules(): array
    {
        return [
            'name' => [
                'required',
                'string',
                'max:255',
                Rule::unique('platforms')->whereNull('deleted_at')
            ],
            'url' => [
                'required',
                'url',
                'max:255',
            ],
            'icon' => ['nullable', 'string', 'max:255'],
            'description' => ['nullable', 'string', 'max:1000'],
        ];
    }

    /**
     * Custom messages for validation errors.
     */
    public function messages(): array
    {
        return [
            'name.required' => 'Nama platform wajib diisi.',
            'name.string' => 'Nama platform harus berupa teks.',
            'name.max' => 'Nama platform maksimal :max karakter.',
            'name.unique' => 'Nama platform sudah digunakan.',
            'url.required' => 'URL wajib diisi.',
            'url.url' => 'Format URL tidak valid.',
            'url.max' => 'URL maksimal :max karakter.',
            'icon.string' => 'Ikon harus berupa teks.',
            'icon.max' => 'Ikon maksimal :max karakter.',
            'description.string' => 'Deskripsi harus berupa teks.',
            'description.max' => 'Deskripsi maksimal :max karakter.',
        ];
    }
}
