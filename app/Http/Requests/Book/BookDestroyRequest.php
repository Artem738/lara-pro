<?php

namespace App\Http\Requests\Book;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Validator;

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
}
