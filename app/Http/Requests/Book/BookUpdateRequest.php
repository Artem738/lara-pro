<?php

namespace App\Http\Requests\Book;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;


class BookUpdateRequest extends FormRequest
{
    public function rules()
    {

        $currentYear = Date::now()->year;

        $id = $this->route('id');

        $idValidator = Validator::make(
            ['id' => $id], ['id' => 'required|integer'],
        );
        /**  Не зрозумів як об'єднати помилки в одну...  */
        if ($idValidator->fails()) {
            exit($idValidator->errors()) . PHP_EOL;
        }

        return [
            'name' => ['required', 'string', 'max:255'],
            'author' => ['required', 'string', 'max:255', 'regex:/^[\p{L}0-9\-"\s]+$/u'],
            'year' => ['required', 'integer', 'max:' . $currentYear, 'min:0'],
            'countPages' => ['required', 'integer', 'max:5000'],
        ];
    }

    protected function failedValidation($validator)
    {
        throw new ValidationException($validator, response()->json($this->jsonResponse($validator), 422));
    }

    protected function jsonResponse($validator)
    {
        return $validator->errors();
    }

}
