<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class PermissionRequest extends FormRequest
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
        $permissionId = null;
        $routePermission = $this->route('permission');
        if ($routePermission && is_object($routePermission)) {
            $permissionId = $routePermission->id ?? null;
        }

        return [
            'display_name' => [
                'required',
                'string',
                'max:255',
                Rule::unique('permissions', 'display_name')->ignore($permissionId),
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
            'display_name.required' => 'Nama permission wajib diisi.',
            'display_name.string' => 'Nama permission harus berupa teks.',
            'display_name.max' => 'Nama permission maksimal :max karakter.',
            'display_name.unique' => 'Nama permission sudah digunakan.',
            'description.string' => 'Deskripsi harus berupa teks.',
            'description.max' => 'Deskripsi maksimal :max karakter.',
        ];
    }
}
