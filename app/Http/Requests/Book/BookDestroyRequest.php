<?php

namespace App\Http\Requests\Book;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class BookDestroyRequest extends FormRequest
{


    public function rules(): array
    {
        $id = $this->route('id');

        $idValidator = Validator::make(
            ['id' => $id],
            ['id' => 'required|integer']
        );

        if ($idValidator->fails()) {
            exit($idValidator->errors()) . PHP_EOL;

        }

        return [];
    }

//    public function rules(): array
//    {
//        echo "FKN VALIDATOR REQUEST" . PHP_EOL;
//        $id = $this->route('id');
//
//        $idValidator = Validator::make(
//            ['id' => $id], ['id' => 'required', 'integer'],  //exists:books,id'
//        );
//        /**  Не зрозумів як об'єднати помилки в одну...  */
//        if ($idValidator->fails()) {
//            exit($idValidator->errors()) . PHP_EOL;
//        }
//
//        return $idValidator->errors()->toArray();
//    }


//    protected function failedValidation($validator)
//    {
//        throw new ValidationException($validator, response()->json($this->jsonResponse($validator), 422));
//    }
//
//    protected function jsonResponse($validator)
//    {
//        return $validator->errors();
//    }
}
