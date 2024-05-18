<?php

namespace App\Http\Requests\Api\V1\Users;

use Illuminate\Contracts\Validation\ValidationRule;

class UpdateUserRequest extends BaseUserRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'data.attributes.name' => ['sometimes', 'string', 'min:3'],
            'data.attributes.email' => ['sometimes', 'email', 'unique:users,email'],
            'data.attributes.password' => ['sometimes', 'string', 'min:4'],
        ];
    }
}
