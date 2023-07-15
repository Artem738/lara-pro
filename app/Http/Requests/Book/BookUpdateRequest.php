<?php

namespace App\Http\Requests\Book;

use App\Enum\LangEnum;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Date;
use Illuminate\Validation\Rule;
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
            'id' => ['required', 'integer', 'numeric', Rule::exists('books', 'id')],
            'name' => ['required', 'string', 'min:3', 'max:255', Rule::unique('books')],
            'year' => ['required', 'integer', 'min:1970', 'max:' . $currentYear],
            'lang' => ['required', 'string', Rule::in(array_column(LangEnum::cases(), 'value'))],
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
