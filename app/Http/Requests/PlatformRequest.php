<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class PlatformRequest extends FormRequest
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
        $platformId = null;
        $routePlatform = $this->route('platform');
        if ($routePlatform && is_object($routePlatform)) {
            $platformId = $routePlatform->id ?? null;
        }

        return [
            'name' => [
                'required',
                'string',
                'max:255',
                Rule::unique('platforms', 'name')->ignore($platformId),
            ],
            'url' => [
                'required',
                'url',
                'max:255',
                Rule::unique('platforms', 'url')->ignore($platformId),
            ],
            'description' => ['nullable', 'string'],
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
            'url.unique' => 'URL sudah digunakan.',
            'description.string' => 'Deskripsi harus berupa teks.',
        ];
    }
}
