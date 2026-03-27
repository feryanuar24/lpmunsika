<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateSliderRequest extends FormRequest
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
            'sometimes',
            'name' => [
                'required',
                'string',
                'max:255',
                Rule::unique('sliders')->whereNull('deleted_at')->ignore($this->slider),
            ],
            'banner' => ['sometimes', 'nullable', 'image', 'max:5120'],
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
            'name.required' => 'Nama wajib diisi.',
            'name.string' => 'Nama harus berupa teks.',
            'name.max' => 'Nama maksimal :max karakter.',
            'name.unique' => 'Nama sudah digunakan.',
            'banner.image' => 'File banner harus berupa gambar.',
            'banner.max' => 'Banner maksimal :max kilobita.',
            'description.string' => 'Deskripsi harus berupa teks.',
            'description.max' => 'Deskripsi maksimal :max karakter.',
        ];
    }
}
