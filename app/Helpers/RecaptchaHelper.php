<?php

namespace App\Helpers;

use Exception;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Throwable;

class RecaptchaHelper
{
    /**
     * Verify reCAPTCHA response with Google API
     *
     * @param string $recaptchaResponse The g-recaptcha-response token
     * @param string $remoteIp The user's IP address
     * @param float $minScore Minimum score required (default: 0.5)
     * @return array ['success' => bool, 'message' => string, 'score' => float|null]
     */
    public static function verify(string $recaptchaResponse, string $remoteIp, float $minScore = 0.5): array
    {
        try {
            $response = Http::timeout(10)->asForm()->post('https://www.google.com/recaptcha/api/siteverify', [
                'secret' => config('services.recaptcha.secret_key', env('RECAPTCHA_SECRET_KEY')),
                'response' => $recaptchaResponse,
                'remoteip' => $remoteIp,
            ]);

            if (!$response->successful()) {
                return [
                    'success' => false,
                    'message' => 'Gagal memverifikasi reCAPTCHA. Silakan coba lagi.',
                    'score' => null
                ];
            }

            $responseData = $response->json();
            $success = $responseData['success'] ?? false;
            $score = $responseData['score'] ?? 0;

            if (!$success || $score < $minScore) {
                return [
                    'success' => false,
                    'message' => 'Verifikasi reCAPTCHA gagal. Silakan coba lagi.',
                    'score' => $score
                ];
            }

            return [
                'success' => true,
                'message' => 'Verifikasi reCAPTCHA berhasil.',
                'score' => $score
            ];
        } catch (Throwable $th) {
            Log::error('reCAPTCHA verification error: ' . $th->getMessage());

            return [
                'success' => false,
                'message' => 'Verifikasi reCAPTCHA gagal karena kesalahan server. Silakan coba lagi nanti.',
                'score' => null
            ];
        }
    }
}
