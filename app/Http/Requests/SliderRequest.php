<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class SliderRequest extends FormRequest
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
        $sliderId = null;
        $routeSlider = $this->route('slider');
        if ($routeSlider && is_object($routeSlider)) {
            $sliderId = $routeSlider->id ?? null;
        }

        $bannerRule = $this->isMethod('post') ? ['required', 'image', 'max:5120'] : ['nullable', 'image', 'max:5120'];

        return [
            'name' => [
                'required',
                'string',
                'max:255',
                Rule::unique('sliders', 'name')->ignore($sliderId),
            ],
            'banner' => $bannerRule,
            'description' => ['nullable', 'string'],
        ];
    }

    /**
     * Custom messages for validation errors.
     */
    public function messages(): array
    {
        return [
            'name.required' => 'Nama wajib diisi.',
            'name.string' => 'Nama harus berupa teks.',
            'name.max' => 'Nama maksimal :max karakter.',
            'name.unique' => 'Nama sudah digunakan.',
            'banner.required' => 'Banner wajib diunggah.',
            'banner.image' => 'File banner harus berupa gambar.',
            'banner.max' => 'Banner maksimal :max kilobita.',
            'description.string' => 'Deskripsi harus berupa teks.',
        ];
    }
}
