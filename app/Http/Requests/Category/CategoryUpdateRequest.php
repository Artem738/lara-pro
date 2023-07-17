<?php

namespace App\Http\Requests\Category;

use App\Enum\LangEnum;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Date;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;

class CategoryUpdateRequest extends FormRequest
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

        return [
            'id' => ['required', 'integer', 'numeric', Rule::exists('categories', 'id')],
            'name' => ['required', 'string', 'min:3', 'max:255', Rule::unique('categories')],
        ];
    }

    protected function failedValidation($validator)
    {
        $errors = $validator->errors();
        $response = response()->json($errors, 422);
        throw new ValidationException($validator, $response);
    }
}
