<?php

namespace App\Http\Requests\Auth;

use App\Rules\RecaptchaRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;

class ForgotPasswordRequest extends FormRequest
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
            'email' => [
                'required',
                Rule::exists('users')->whereNull('deleted_at')
            ],
        ];

        if (!app()->environment('testing')) {
            $rules['g-recaptcha-response'] = ['required', new RecaptchaRule('forgot_password')];
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
            'g-recaptcha-response.required' => 'Verifikasi reCAPTCHA wajib diisi.',
        ];
    }

    /**
     * Prepare the data for validation.
     */
    protected function prepareForValidation(): void
    {
        $email = $this->input('email');
        $throttleKey = 'forgot-password:' . $email;
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
