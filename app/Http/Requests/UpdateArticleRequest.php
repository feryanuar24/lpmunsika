<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateArticleRequest extends FormRequest
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
            'title' => [
                'sometimes',
                'required',
                'string',
                'max:255',
                Rule::unique('articles')->whereNull('deleted_at')->ignore($this->article)
            ],
            'category_id' => [
                'sometimes',
                'required',
                Rule::exists('categories', 'id')->whereNull('deleted_at')
            ],
            'tags' => ['sometimes', 'nullable', 'array'],
            'tags.*' => [
                'sometimes',
                'nullable',
                Rule::exists('tags', 'id')->whereNull('deleted_at')
            ],
            'content' => ['sometimes', 'required', 'string', 'max:65535'],
            'embed' => ['sometimes', 'nullable', 'string', 'max:1000'],
            'thumbnail' => ['sometimes', 'nullable', 'image', 'max:5120'],
            'is_active' => ['sometimes', 'required', 'boolean'],
            'is_pinned' => ['sometimes', 'required', 'boolean'],
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
            'title.required' => 'Judul artikel wajib diisi.',
            'title.string' => 'Judul artikel harus berupa teks.',
            'title.max' => 'Judul artikel tidak boleh lebih dari :max karakter.',
            'title.unique' => 'Judul artikel sudah digunakan.',
            'category_id.required' => 'Kategori wajib dipilih.',
            'category_id.exists' => 'Kategori yang dipilih tidak valid.',
            'tags.array' => 'Tag harus berupa array.',
            'tags.*.exists' => 'Tag yang dipilih tidak valid.',
            'content.required' => 'Konten artikel wajib diisi.',
            'content.string' => 'Konten artikel harus berupa teks.',
            'content.max' => 'Konten artikel tidak boleh lebih dari :max karakter.',
            'embed.string' => 'Embed harus berupa teks.',
            'embed.max' => 'Embed tidak boleh lebih dari :max karakter.',
            'thumbnail.required' => 'Thumbnail wajib diunggah.',
            'thumbnail.image' => 'Thumbnail harus berupa gambar.',
            'thumbnail.max' => 'Ukuran thumbnail tidak boleh lebih dari :max KB.',
            'is_active.required' => 'Status aktif wajib dipilih.',
            'is_active.boolean' => 'Status aktif harus berupa boolean.',
            'is_pinned.required' => 'Status pin wajib dipilih.',
            'is_pinned.boolean' => 'Status pin harus berupa boolean.',
        ];
    }
}
