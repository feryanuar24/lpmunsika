<?php

namespace App\Http\Requests\Auth;

use App\Rules\RecaptchaRule;
use Illuminate\Auth\Events\Lockout;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;

class LoginRequest extends FormRequest
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
            'email' => ['required', Rule::exists('users')->whereNull('deleted_at')],
            'password' => ['required', 'string', 'max:72'],
        ];

        if (!app()->environment('testing')) {
            $rules['g-recaptcha-response'] = ['required', new RecaptchaRule('login')];
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
            'email.required' => 'Email wajib diisi.',
            'email.exists' => 'Email tidak ditemukan dalam sistem.',
            'password.required' => 'Password wajib diisi.',
            'password.string' => 'Password harus berupa teks.',
            'password.max' => 'Panjang password tidak boleh lebih dari :max karakter.',
            'g-recaptcha-response.required' => 'Verifikasi reCAPTCHA wajib diisi.',
        ];
    }

    /**
     * Attempt to authenticate the request's credentials.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function authenticate(): void
    {
        $email = $this->string('email');
        $ip = $this->ip();
        $throttleKey = 'login:' . $email . '|' . $ip;
        $maxAttempts = 5;
        $decaySeconds = 300; // 5 minutes

        if (RateLimiter::tooManyAttempts($throttleKey, $maxAttempts)) {
            $seconds = RateLimiter::availableIn($throttleKey);
            $minutes = ceil($seconds / 60);

            throw ValidationException::withMessages([
                'email' => "Terlalu banyak percobaan login yang gagal. Akun Anda telah diblokir. Silakan coba lagi dalam {$minutes} menit.",
            ]);
        }

        if (!Auth::attempt($this->only('email', 'password'), $this->boolean('remember'))) {
            RateLimiter::hit($throttleKey, $decaySeconds);

            $attempts = RateLimiter::attempts($throttleKey);
            $remaining = max(0, $maxAttempts - $attempts);
            if ($remaining > 0) {
                throw ValidationException::withMessages([
                    'email' => "Email atau password salah. Anda memiliki {$remaining} percobaan lagi sebelum akun diblokir selama 5 menit.",
                ]);
            } else {
                throw ValidationException::withMessages([
                    'email' => 'Terlalu banyak percobaan login yang gagal. Akun Anda telah diblokir selama 5 menit.',
                ]);
            }
        }

        RateLimiter::clear($throttleKey);
    }
}
