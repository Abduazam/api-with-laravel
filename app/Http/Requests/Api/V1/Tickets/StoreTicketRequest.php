<?php

namespace App\Http\Requests\Api\V1\Tickets;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreTicketRequest extends FormRequest
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

    public function messages(): array
    {
        return [
            'data.attributes.status.in' => 'The data.attributes.status value is invalid. Please use A, C, H, or X.',
            'data.relationships.user.data.id.exists' => 'The data.relationships.user.data.id does not exist on users.',
        ];
    }
}
