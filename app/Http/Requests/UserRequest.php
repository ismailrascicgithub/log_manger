<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use App\Enums\UserRole;

class UserRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        $userId = $this->route('user')?->id;

        return [
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|max:255|unique:users,email,'.$userId,
            'password' => 'nullable|string|min:8',
            'role'     => ['required', Rule::enum(UserRole::class)],
        ];
    }

    public function messages()
    {
        return [
            'name.required'     => 'Name is required.',
            'email.required'    => 'Email is required.',
            'email.unique'      => 'This email is already taken.',
            'password.min'      => 'Password must be at least 8 characters.',
            'role.required'     => 'Role is required.',
            'role.enum'         => 'The selected role is invalid.',
        ];
    }
}