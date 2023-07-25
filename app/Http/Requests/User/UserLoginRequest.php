<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;

class UserLoginRequest extends FormRequest
{
    public function rules()
    {

        return [
            'email' => ['required','email:rfc,dns','string','min:4', 'max:255', Rule::exists('users')],
            'password' => ['required','string','min:6', 'max:255'],
        ];
    }

    protected function failedValidation($validator)
    {
        $errors = $validator->errors();
        $response = response()->json($errors, 422);
        throw new ValidationException($validator, $response);
    }
}
