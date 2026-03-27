<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StorePermissionRoleRequest extends FormRequest
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
        return [
            'permission_id' => [
                'required',
                Rule::exists('permissions', 'id')->whereNull('deleted_at')
            ],
            'role_id' => [
                'required',
                Rule::exists('roles', 'id')->whereNull('deleted_at')
            ],
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'permission_id.required' => 'Permission wajib dipilih.',
            'permission_id.exists' => 'Permission tidak valid.',
            'role_id.required' => 'Role wajib dipilih.',
            'role_id.exists' => 'Role tidak valid.',
        ];
    }
}
