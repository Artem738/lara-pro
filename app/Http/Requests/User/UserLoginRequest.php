<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\ValidationException;

class UserLoginRequest extends FormRequest
{
    public function rules()
    {

        return [
            'email' => ['required'],
            'password' => ['required'],
        ];
    }

    protected function failedValidation($validator)
    {
        $errors = $validator->errors();
        $response = response()->json($errors, 422);
        throw new ValidationException($validator, $response);
    }
}
