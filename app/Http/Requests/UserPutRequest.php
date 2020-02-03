<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UserPutRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'name' => 'string|min:3|max:15',
            'email' => 'string|email|max:255|unique:users',
            'password' => 'string|min:8|confirmed',
            'role' => [Rule::in([User::ROLE_ADMIN, User::ROLE_EDITOR, User::ROLE_USER])],
        ];
    }
}
