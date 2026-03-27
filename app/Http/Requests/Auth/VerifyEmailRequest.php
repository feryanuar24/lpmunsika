<?php

namespace App\Http\Requests\Auth;

use App\Rules\RecaptchaRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Validation\ValidationException;

class VerifyEmailRequest extends FormRequest
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
        if (!app()->environment('testing')) {
            return [
                'g-recaptcha-response' => ['required', new RecaptchaRule('verify_email')],
            ];
        }

        return [];
    }

    /**
     * Custom messages for validation errors.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'g-recaptcha-response.required' => 'Verifikasi reCAPTCHA wajib diisi.',
        ];
    }

    /**
     * Prepare the data for validation.
     */
    protected function prepareForValidation(): void
    {
        $user = $this->user();
        $throttleKey = 'verify-email:' . $user->id;
        $maxAttempts = 1;
        $decaySeconds = 60; // 1 minute

        if (RateLimiter::tooManyAttempts($throttleKey, $maxAttempts)) {
            $seconds = RateLimiter::availableIn($throttleKey);
            $minutes = ceil($seconds / 60);

            throw ValidationException::withMessages([
                'email' => "Terlalu banyak percobaan verifikasi email. Silakan coba lagi dalam {$minutes} menit."
            ]);
        }

        RateLimiter::hit($throttleKey, $decaySeconds);
    }
}
