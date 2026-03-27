<?php

namespace App\Http\Requests\Auth;

use App\Rules\RecaptchaRule;
use Illuminate\Foundation\Http\FormRequest;

class UpdatePasswordRequest extends FormRequest
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
        $rules = [
            'password' => [
                'required',
                'string',
                'max:255',
                'confirmed',
                'min:8',
                'regex:/[a-z]/',
                'regex:/[A-Z]/',
                'regex:/[0-9]/',
                'regex:/[@$!%*#?&]/',
            ],
        ];

        if (!app()->environment('testing')) {
            $rules['g-recaptcha-response'] = ['required', new RecaptchaRule('update_password')];
        }

        return $rules;
    }

    /**
     * Custom messages for validation errors.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'password.required' => 'Password baru wajib diisi.',
            'password.string' => 'Password baru harus berupa string.',
            'password.max' => 'Password baru maksimal terdiri dari 255 karakter.',
            'password.confirmed' => 'Konfirmasi password baru tidak sesuai.',
            'password.min' => 'Password baru minimal terdiri dari 8 karakter.',
            'password.regex' => 'Password baru harus mengandung huruf besar, huruf kecil, angka, dan simbol.',
            'g-recaptcha-response.required' => 'Verifikasi reCAPTCHA wajib diisi.',
        ];
    }
}
