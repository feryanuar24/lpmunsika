<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateProfileRequest extends FormRequest
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
     */
    public function rules(): array
    {
        return [
            'name' => ['sometimes', 'required', 'string', 'max:255'],
            'email' => [
                'sometimes',
                'required',
                'email',
                'max:255',
                Rule::unique('users')
                    ->whereNull('deleted_at')
                    ->ignore($this->user()->id),
            ],
            'password' => [
                'sometimes',
                'nullable',
                'string',
                'max:255',
                'min:8',
                'confirmed',
                'regex:/[a-z]/',
                'regex:/[A-Z]/',
                'regex:/[0-9]/',
                'regex:/[@$!%*#?&]/',
            ],
        ];
    }

    /**
     * Custom messages for validation errors.
     */
    public function messages(): array
    {
        return [
            'name.required' => 'Nama wajib diisi.',
            'name.string' => 'Nama harus berupa teks.',
            'name.max' => 'Nama maksimal :max karakter.',
            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'email.max' => 'Email maksimal :max karakter.',
            'email.unique' => 'Email sudah digunakan.',
            'password.string' => 'Password harus berupa teks.',
            'password.max' => 'Password maksimal :max karakter.',
            'password.min' => 'Password minimal :min karakter.',
            'password.confirmed' => 'Konfirmasi password tidak cocok.',
            'password.regex' => 'Password harus mengandung setidaknya satu huruf besar, satu huruf kecil, satu angka, dan satu karakter khusus.',
        ];
    }
}
