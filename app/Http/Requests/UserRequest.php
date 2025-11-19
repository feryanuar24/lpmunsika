<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UserRequest extends FormRequest
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
        $isUpdate = (bool) $this->route('user');

        $emailRule = $isUpdate
            ? [
                'required',
                'string',
                'email',
                'max:255',
                Rule::unique('users', 'email')->ignore($this->route('user')->id ?? null),
            ]
            : [
                'required',
                'string',
                'email',
                'max:255',
                'unique:users',
            ];

        $passwordRule = $isUpdate
            ? ['nullable', 'min:8', 'confirmed', 'regex:/[a-z]/', 'regex:/[A-Z]/', 'regex:/[0-9]/', 'regex:/[@$!%*#?&]/']
            : ['required', 'min:8', 'confirmed', 'regex:/[a-z]/', 'regex:/[A-Z]/', 'regex:/[0-9]/', 'regex:/[@$!%*#?&]/'];

        return [
            'name' => ['required', 'string', 'max:255'],
            'email' => $emailRule,
            'roles' => ['required', 'array'],
            'roles.*' => ['exists:roles,name'],
            'password' => $passwordRule,
            'avatar' => ['required', 'string', 'max:255']
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
            'email.string' => 'Email harus berupa teks.',
            'email.email' => 'Format email tidak valid.',
            'email.max' => 'Email maksimal :max karakter.',
            'email.unique' => 'Email sudah digunakan.',
            'roles.required' => 'Role wajib dipilih.',
            'roles.array' => 'Format role tidak valid.',
            'roles.*.exists' => 'Role tidak valid.',
            'password.required' => 'Password wajib diisi.',
            'password.min' => 'Password minimal :min karakter.',
            'password.confirmed' => 'Konfirmasi password tidak cocok.',
            'password.regex' => 'Password harus mengandung setidaknya satu huruf besar, satu huruf kecil, satu angka, dan satu karakter khusus.',
            'avatar.required' => 'Avatar wajib diisi.',
            'avatar.string' => 'Avatar harus berupa teks.',
            'avatar.max' => 'Avatar maksimal :max karakter.',
        ];
    }
}
