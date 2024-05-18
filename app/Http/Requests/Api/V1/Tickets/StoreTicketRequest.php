<?php

namespace App\Http\Requests\Api\V1\Tickets;

use Illuminate\Contracts\Validation\ValidationRule;

class StoreTicketRequest extends BaseTicketRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array|string>
     */
    public function rules(): array
    {
        $rules = [
            'data.attributes.title' => ['required', 'string'],
            'data.attributes.description' => ['required', 'string'],
            'data.attributes.status' => ['required', 'string', 'in:A,C,H,X'],
        ];

        if ($this->routeIs('tickets.store')) {
            $rules['data.relationships.user.data.id'] = ['required', 'integer', 'exists:users,id'];
        }

        return $rules;
    }
}
