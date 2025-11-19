<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UploadImageRequest extends FormRequest
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
            'upload' => ['required', 'image', 'max:5120'],
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
            'upload.required' => 'File gambar wajib diupload.',
            'upload.image' => 'File yang diupload harus berupa gambar.',
            'upload.max' => 'Ukuran gambar tidak boleh lebih dari :max KB.',
        ];
    }
}
