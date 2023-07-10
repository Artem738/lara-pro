<?php

namespace App\Http\Requests\Book;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Date;
use Illuminate\Validation\ValidationException;


class BookUpdateRequest extends FormRequest
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
        $currentYear = Date::now()->year;

        return [
            'id' => ['required', 'integer', 'numeric'],
            'name' => ['required', 'string', 'max:255'],
            'author' => ['required', 'string', 'max:255', 'regex:/^[\p{L}0-9\-"\s]+$/u'],
            'year' => ['required', 'integer', 'max:' . $currentYear, 'min:0'],
            'countPages' => ['required', 'integer', 'max:5000'],
        ];
    }

    protected function failedValidation($validator)
    {
        $errors = $validator->errors();
        $response = response()->json($errors, 422);
        throw new ValidationException($validator, $response);
    }

}
