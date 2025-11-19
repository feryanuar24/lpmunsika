<?php

namespace App\Http\Requests;

use App\Helpers\RecaptchaHelper;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\ValidationException;

class UpdatePasswordResetRequest extends FormRequest
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
            'token' => ['required', 'string'],
            'email' => ['required', 'email', 'max:255'],
            'password' => [
                'required',
                'string',
                'min:8',
                'regex:/[a-z]/',
                'regex:/[A-Z]/',
                'regex:/[0-9]/',
                'regex:/[@$!%*#?&]/',
                'confirmed'
            ],
            'g-recaptcha-response' => ['required', 'string'],
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
            'token.required' => 'Token reset password wajib diisi.',
            'token.string' => 'Token reset password harus berupa teks.',
            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'email.max' => 'Panjang email tidak boleh lebih dari :max karakter.',
            'password.required' => 'Password baru wajib diisi.',
            'password.string' => 'Password baru harus berupa teks.',
            'password.min' => 'Password baru harus terdiri dari minimal :min karakter.',
            'password.regex' => 'Password baru harus mengandung huruf besar, huruf kecil, angka, dan simbol khusus.',
            'password.confirmed' => 'Konfirmasi password tidak sesuai.',
            'g-recaptcha-response.required' => 'Tanggapan reCAPTCHA diperlukan.',
            'g-recaptcha-response.string' => 'Tanggapan reCAPTCHA harus berupa teks.',
        ];
    }

    /**
     * Perform additional validation after the basic rules pass.
     *
     * @return void
     * @throws ValidationException
     */
    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            // Verify reCAPTCHA with Google API
            $recaptchaResult = RecaptchaHelper::verify(
                $this->input('g-recaptcha-response'),
                $this->ip(),
                0.5
            );

            if (!$recaptchaResult['success']) {
                $validator->errors()->add('g-recaptcha-response', $recaptchaResult['message']);
            }
        });
    }
}
