<?php

namespace App\Http\Requests\Book;

use Illuminate\Foundation\Http\FormRequest;

class BookShowRequest extends FormRequest
{

    public function rules()
    {
        return [
            'id' => 'required|integer',
        ];
    }
}
