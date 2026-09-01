<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

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
        $secretKey = config('services.recaptcha.secret_key');

        if (empty($secretKey)) {
            Log::warning('reCAPTCHA secret key is missing. Skipping verification.');
            return;
        }

        try {
            $response = Http::asForm()->post(
                'https://www.google.com/recaptcha/api/siteverify',
                [
                    'secret' => $secretKey,
                    'response' => $value,
                    'remoteip' => request()->ip(),
                ]
            );

            if (!$response->successful()) {
                Log::error('reCAPTCHA API HTTP request failed', [
                    'status' => $response->status(),
                    'body' => $response->body(),
                ]);
                $fail('Verifikasi reCAPTCHA gagal. Silakan coba lagi.');
                return;
            }

            $result = $response->json();

            $success = $result['success'] ?? false;
            $action = $result['action'] ?? null;
            $score = (float) ($result['score'] ?? 0);

            if (
                !$success ||
                (isset($result['action']) && $result['action'] !== $this->action) ||
                (isset($result['score']) && $score < 0.5)
            ) {
                Log::warning('reCAPTCHA verification failed', [
                    'expected_action' => $this->action,
                    'response_action' => $action,
                    'score' => $score,
                    'success' => $success,
                    'error_codes' => $result['error-codes'] ?? [],
                    'ip' => request()->ip(),
                ]);

                $fail('Verifikasi reCAPTCHA gagal. Silakan coba lagi.');
            }
        } catch (\Throwable $e) {
            Log::error('reCAPTCHA exception: ' . $e->getMessage());
            $fail('Verifikasi reCAPTCHA gagal. Silakan coba lagi.');
        }
    }
}
