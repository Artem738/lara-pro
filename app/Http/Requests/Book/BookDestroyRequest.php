<?php

namespace App\Http\Requests\Book;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\ValidationException;

class BookDestroyRequest extends FormRequest
{
    protected function prepareForValidation(): void
    {
        $this->merge(
            [
                'id' => $this->route('id'),
            ]
        );
    }

    public function rules(): array
    {
        return [
            'id' => ['required', 'integer', 'numeric']
        ];
    }

    protected function failedValidation($validator)
    {
        $errors = $validator->errors();
        $response = response()->json($errors, 422);
        throw new ValidationException($validator, $response);
    }
}
