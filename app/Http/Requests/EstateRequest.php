<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EstateRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'onwer_id' => ['sometimes', 'required', 'integer'],
            'state' => ['required', 'string'],
            'city' => ['required', 'string'],
            'neighborhood' => ['required', 'string'],
            'street' => ['required', 'string'],
            'number' => ['nullable', 'integer'],
            'details' => ['nullable', 'string'],
        ];
    }
}
