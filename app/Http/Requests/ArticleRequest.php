<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ArticleRequest extends FormRequest
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
            'category_id' => ['required', 'exists:categories,id'],
            'tags' => ['nullable', 'array'],
            'tags.*' => ['exists:tags,name'],
            'title' => ['required', 'string', 'max:255'],
            'content' => ['required', 'string'],
            'embed' => ['nullable', 'string'],
            'thumbnail' => ['nullable', 'image', 'max:5120'],
            'is_active' => ['required', 'boolean'],
            'is_pinned' => ['required', 'boolean'],
            'remove_thumbnail' => ['nullable', 'in:0,1'],
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
            'category_id.required' => 'Kategori wajib dipilih.',
            'category_id.exists' => 'Kategori yang dipilih tidak valid.',
            'tags.array' => 'Tag harus berupa array.',
            'tags.*.exists' => 'Tag yang dipilih tidak valid.',
            'title.required' => 'Judul artikel wajib diisi.',
            'title.string' => 'Judul artikel harus berupa teks.',
            'title.max' => 'Judul artikel tidak boleh lebih dari :max karakter.',
            'content.required' => 'Konten artikel wajib diisi.',
            'content.string' => 'Konten artikel harus berupa teks.',
            'embed.string' => 'Embed harus berupa teks.',
            'thumbnail.image' => 'Thumbnail harus berupa gambar.',
            'thumbnail.max' => 'Ukuran thumbnail tidak boleh lebih dari :max KB.',
            'is_active.required' => 'Status aktif wajib dipilih.',
            'is_active.boolean' => 'Status aktif harus berupa boolean.',
            'is_pinned.required' => 'Status pin wajib dipilih.',
            'is_pinned.boolean' => 'Status pin harus berupa boolean.',
        ];
    }
}
