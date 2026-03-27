<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Support\Facades\Http;

class RecaptchaRule implements ValidationRule
{
    /**
     * The expected action name for reCAPTCHA verification.
     */
    protected string $action;

    /**
     * Create a new rule instance.
     */
    public function __construct(string $action)
    {
        $this->action = $action;
    }

    /**
     * Run the validation rule.
     *
     * @param  \Closure(string, ?string=): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $response = Http::asForm()->post(
            'https://www.google.com/recaptcha/api/siteverify',
            [
                'secret' => config('services.recaptcha.secret_key', env('RECAPTCHA_SECRET_KEY')),
                'response' => $value,
                'remoteip' => request()->ip(),
            ]
        );

        $result = $response->json();

        if (
            !$result['success'] ||
            $result['action'] !== $this->action ||
            $result['score'] < 0.5
        ) {
            $fail('Verifikasi reCAPTCHA gagal. Silakan coba lagi.');
        }
    }
}
