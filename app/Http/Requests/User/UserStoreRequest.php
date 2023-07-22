<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;

class UserStoreRequest extends FormRequest
{
    public function rules()
    {

        return [
            'name' => ['required','string'],
            'email' => ['required','string'],
            'password' => ['required','string'],
        ];
    }

    protected function failedValidation($validator)
    {
        $errors = $validator->errors();
        $response = response()->json($errors, 422);
        throw new ValidationException($validator, $response);
    }
}
