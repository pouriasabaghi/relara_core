<?php

namespace App\Http\Requests\v1;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UserRequest extends FormRequest
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
        $userId = $this->route('user');

        $rules = [
            'email' => [
                'required',
                'string',
                'email',
                Rule::unique('users')->ignore($userId), // ignore current user in update
            ],
            'role' => 'required|string|in:user,admin',
        ];

        if ($this->method() === 'POST')
            $rules['password'] = 'required|min:8';

        return $rules;
    }
}
