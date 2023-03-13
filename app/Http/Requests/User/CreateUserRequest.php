<?php

namespace App\Http\Requests\User;

use App\Enums\UserRole;
use App\Enums\UserStatus;
use App\Http\Requests\FormRequest;
use Illuminate\Validation\Rules\In;
use Illuminate\Validation\Rules\RequiredIf;

class CreateUserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'id' => [
                'integer',
                new RequiredIf(in_array($this->user()->role, [UserRole::PM, UserRole::LEADER])),
                'exists:users,id'
            ],
            'role' => [
                'nullable',
                'numeric',
                new In([UserRole::PM, UserRole::LEADER, UserRole::MEMBER])
            ],
            'name' => [
                'nullable',
                'string',
                'max:255'
            ],
            'display_name' => [
                'nullable',
                'string',
                'max:255'
            ],
            'email' => [
                'nullable',
                'string',
                'max:190',
                'email:rfc,dns'
            ],
            'avatar' => [
                'nullable',
                'image'
            ],
            'status' => [
                'nullable',
                new In([UserStatus::ACTIVE, UserStatus::INACTIVE])
            ]
        ];
    }

    public function attributes()
    {
        return [

        ];
    }

    /**
     * Get the validation messages that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function messages()
    {
        return [

        ];
    }
}
