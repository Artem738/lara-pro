<?php

namespace App\Http\Requests\Book;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Date;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;

class BookStoreRequest extends FormRequest
{
    public function rules()
    {
        $currentYear = Date::now()->year;

        return [
            'name' => ['required', 'string', 'min:3', 'max:255', Rule::unique('books')],
            'year' => ['required', 'integer', 'min:1970', 'max:' . $currentYear],
            'lang' => ['required', 'string', Rule::in(['en', 'ua', 'pl', 'de'])],
            'pages' => ['required', 'integer', 'min:10', 'max:55000'],
        ];
    }

    protected function failedValidation($validator)
    {
        $errors = $validator->errors();
        $response = response()->json($errors, 422);
        throw new ValidationException($validator, $response);
    }
}
