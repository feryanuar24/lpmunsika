<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class RoleRequest extends FormRequest
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
        $roleId = null;
        $routeRole = $this->route('role');
        if ($routeRole && is_object($routeRole)) {
            $roleId = $routeRole->id ?? null;
        }

        return [
            'display_name' => [
                'required',
                'string',
                'max:255',
                Rule::unique('roles', 'display_name')->ignore($roleId),
            ],
            'description' => ['nullable', 'string', 'max:255'],
        ];
    }

    /**
     * Custom messages for validation errors.
     */
    public function messages(): array
    {
        return [
            'display_name.required' => 'Nama role wajib diisi.',
            'display_name.string' => 'Nama role harus berupa teks.',
            'display_name.max' => 'Nama role maksimal :max karakter.',
            'display_name.unique' => 'Nama role sudah digunakan.',
            'description.string' => 'Deskripsi harus berupa teks.',
            'description.max' => 'Deskripsi maksimal :max karakter.',
        ];
    }
}
