<?php

namespace App\Http\Requests;

use App\Helpers\RecaptchaHelper;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\ValidationException;

class RegisterRequest extends FormRequest
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
            'g-recaptcha-response' => ['required', 'string'],
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email'],
            'password' => [
                'required',
                'confirmed',
                'min:8',
                'regex:/[a-z]/',
                'regex:/[A-Z]/',
                'regex:/[0-9]/',
                'regex:/[@$!%*#?&]/',
            ],
            'avatar' => ['required', 'string', 'max:255'],
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
            'g-recaptcha-response.required' => 'Tanggapan reCAPTCHA diperlukan.',
            'g-recaptcha-response.string' => 'Tanggapan reCAPTCHA harus berupa teks.',
            'name.required' => 'Nama wajib diisi.',
            'name.string' => 'Nama harus berupa teks.',
            'name.max' => 'Panjang nama tidak boleh lebih dari :max karakter.',
            'email.required' => 'Email wajib diisi.',
            'email.string' => 'Email harus berupa teks.',
            'email.email' => 'Format email tidak valid.',
            'email.max' => 'Panjang email tidak boleh lebih dari :max karakter.',
            'email.unique' => 'Email sudah terdaftar.',
            'password.required' => 'Password wajib diisi.',
            'password.confirmed' => 'Konfirmasi password tidak sesuai.',
            'password.min' => 'Panjang password minimal :min karakter.',
            'password.regex' => 'Password harus mengandung huruf besar, huruf kecil, angka, dan karakter khusus.',
            'avatar.required' => 'Avatar wajib diisi.',
            'avatar.string' => 'Avatar harus berupa teks.',
            'avatar.max' => 'Panjang avatar tidak boleh lebih dari :max karakter.',
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
