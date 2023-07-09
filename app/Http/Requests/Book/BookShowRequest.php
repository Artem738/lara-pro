<?php

namespace App\Http\Requests\Book;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class BookShowRequest extends FormRequest
{


    public function rules(): array
    {
        $id = $this->route('id');

        $idValidator = Validator::make(
            ['id' => $id],
            ['id' => 'required|integer']
        );

        if ($idValidator->fails()) {
            $this->failedValidation($idValidator);
        }

        return [];
    }

    protected function failedValidation($validator)
    {
        $errors = $validator->errors();
        $response = response()->json($errors, 422);
        throw new ValidationException($validator, $response);
    }

}
