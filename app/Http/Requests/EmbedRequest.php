<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EmbedRequest extends FormRequest
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
            'platform_id' => ['required', 'exists:platforms,id'],
            'title' => ['required', 'string', 'max:255'],
            'embed_code' => ['required', 'string'],
            'description' => ['nullable', 'string'],
        ];
    }

    /**
     * Custom messages for validation errors.
     */
    public function messages(): array
    {
        return [
            'platform_id.required' => 'Platform wajib dipilih.',
            'platform_id.exists' => 'Platform tidak valid.',
            'title.required' => 'Judul wajib diisi.',
            'title.string' => 'Judul harus berupa teks.',
            'title.max' => 'Judul maksimal :max karakter.',
            'embed_code.required' => 'Embed code wajib diisi.',
            'embed_code.string' => 'Embed code harus berupa teks.',
            'description.string' => 'Deskripsi harus berupa teks.',
        ];
    }
}
