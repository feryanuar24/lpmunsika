<?php

namespace App\Http\Requests\Auth;

use App\Rules\RecaptchaRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Validation\Rule;
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
        $rules = [
            'name' => ['required', 'string', 'max:255'],
            'email' => [
                'required',
                'email',
                'max:255',
                Rule::unique('users')->whereNull('deleted_at'),
            ],
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
            $rules['g-recaptcha-response'] = ['required', new RecaptchaRule('register')];
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
            'name.required' => 'Nama wajib diisi.',
            'name.string' => 'Nama harus berupa teks.',
            'name.max' => 'Panjang nama tidak boleh lebih dari :max karakter.',
            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'email.max' => 'Panjang email tidak boleh lebih dari :max karakter.',
            'email.unique' => 'Email sudah terdaftar.',
            'password.required' => 'Password wajib diisi.',
            'password.string' => 'Password harus berupa teks.',
            'password.max' => 'Panjang password tidak boleh lebih dari :max karakter.',
            'password.confirmed' => 'Konfirmasi password tidak sesuai.',
            'password.min' => 'Panjang password minimal :min karakter.',
            'password.regex' => 'Password harus mengandung huruf besar, huruf kecil, angka, dan karakter khusus.',
            'g-recaptcha-response.required' => 'Verifikasi reCAPTCHA wajib diisi.',
        ];
    }

    /**
     * Prepare the data for validation.
     */
    protected function prepareForValidation(): void
    {
        $ip = $this->ip();
        $throttleKey = 'register:' . $ip;
        $maxAttempts = 3;
        $decaySeconds = 3600; // 1 hour

        if (RateLimiter::tooManyAttempts($throttleKey, $maxAttempts)) {
            $seconds = RateLimiter::availableIn($throttleKey);
            $minutes = ceil($seconds / 60);

            throw ValidationException::withMessages([
                'email' => 'Terlalu banyak permintaan. Silakan coba lagi dalam ' . $minutes . ' menit.'
            ]);
        }

        RateLimiter::hit($throttleKey, $decaySeconds);
    }
}
