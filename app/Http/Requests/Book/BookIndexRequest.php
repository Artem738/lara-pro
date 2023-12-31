<?php

namespace App\Http\Requests\Book;

use App\Enum\LangEnum;
use App\Enum\LimitEnum;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Date;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;

class BookIndexRequest extends FormRequest
{
    public function rules()
    {
        $currentYear = Date::now()->year;
        return [
            'startDate' => ['required', 'date', 'before:endDate'],
            'endDate' => ['required', 'date', 'after:startDate'],
            'year' => ['nullable','integer', 'min:1970', 'max:' . $currentYear],
            'lang' => ['nullable','string', Rule::in(array_column(LangEnum::cases(), 'value'))],
            'lastId' => ['nullable', 'integer', 'exists:books,id'],
            'limit' => ['nullable', 'integer', Rule::in(array_column(LimitEnum::cases(), 'value'))],
        ];
    }

    protected function failedValidation($validator)
    {
        $errors = $validator->errors();
        $response = response()->json($errors, 422);
        throw new ValidationException($validator, $response);
    }
}
