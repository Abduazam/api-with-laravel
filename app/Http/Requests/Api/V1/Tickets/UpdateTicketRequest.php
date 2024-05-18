<?php

namespace App\Http\Requests\Api\V1\Tickets;

use Illuminate\Contracts\Validation\ValidationRule;

class UpdateTicketRequest extends BaseTicketRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'data.attributes.title' => ['sometimes', 'string'],
            'data.relationships.user.data.id' => ['sometimes', 'integer', 'exists:users,id'],
            'data.attributes.description' => ['sometimes', 'string'],
            'data.attributes.status' => ['sometimes', 'string', 'in:A,C,H,X'],
        ];
    }
}
