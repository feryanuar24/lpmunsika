<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateEmbedRequest extends FormRequest
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
            'platform_id' => [
                'sometimes',
                'required',
                Rule::exists('platforms', 'id')->whereNull('deleted_at')
            ],
            'title' => [
                'sometimes',
                'required',
                'string',
                'max:255',
                Rule::unique('embeds')->where(function ($query) {
                    return $query->where('platform_id', $this->input('platform_id'));
                })->whereNull('deleted_at')->ignore($this->embed)
            ],
            'embed_code' => ['sometimes', 'required', 'string', 'max:1000'],
            'description' => ['sometimes', 'nullable', 'string', 'max:1000'],
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
            'title.unique' => 'Judul sudah digunakan untuk platform yang sama.',
            'embed_code.required' => 'Embed code wajib diisi.',
            'embed_code.string' => 'Embed code harus berupa teks.',
            'embed_code.max' => 'Embed code maksimal :max karakter.',
            'description.string' => 'Deskripsi harus berupa teks.',
            'description.max' => 'Deskripsi maksimal :max karakter.',
        ];
    }
}
