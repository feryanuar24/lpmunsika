<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class FooterRequest extends FormRequest
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
        $footerId = null;
        $routeFooter = $this->route('footer');
        if ($routeFooter && is_object($routeFooter)) {
            $footerId = $routeFooter->id ?? null;
        }

        return [
            'name' => [
                'required',
                'string',
                'max:255',
                Rule::unique('footers', 'name')->ignore($footerId),
            ],
            'url' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
        ];
    }

    /**
     * Custom messages for validation errors.
     */
    public function messages(): array
    {
        return [
            'name.required' => 'Nama footer wajib diisi.',
            'name.string' => 'Nama footer harus berupa teks.',
            'name.max' => 'Nama footer maksimal :max karakter.',
            'name.unique' => 'Nama footer sudah digunakan.',
            'url.required' => 'URL wajib diisi.',
            'url.string' => 'URL harus berupa teks.',
            'url.max' => 'URL maksimal :max karakter.',
            'description.string' => 'Deskripsi harus berupa teks.',
        ];
    }
}
