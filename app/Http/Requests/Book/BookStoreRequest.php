<?php

namespace App\Http\Requests\Book;



use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Date;

class BookStoreRequest extends FormRequest
{

    public function rules()
    {
        $currentYear = Date::now()->year;

        return [
            'name' => ['required', 'string', 'max:255'], //Rule::unique('books') - check in table!!!
            'author' => ['required', 'string', 'max:255', 'regex:/^[\p{L}0-9\-"\s]+$/u'],
            'year' => ['required', 'integer', 'max:' . $currentYear, 'min:0'],
            'countPages' => ['required', 'integer'],
        ];
    }
}
