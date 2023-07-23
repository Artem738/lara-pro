<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;

class UserUpdateRequest extends FormRequest
{
    protected function prepareForValidation(): void
    {
        $this->merge(
            [
                'id' => $this->route('id'),
            ]
        );
    }
    public function rules()
    {

        return [
            'id' => ['required', 'integer', 'numeric', Rule::exists('users', 'id')],
            'name' => ['required','string','min:3', 'max:255', Rule::unique('users')],
        ];
    }

    protected function failedValidation($validator)
    {
        $errors = $validator->errors();
        $response = response()->json($errors, 422);
        throw new ValidationException($validator, $response);
    }
}
