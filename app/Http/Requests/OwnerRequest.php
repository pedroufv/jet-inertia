<?php

namespace App\Http\Requests;

use App\Helpers\Sanitizer;
use App\Validations\Rules\CNPJRule;
use App\Validations\Rules\CPFRule;
use Illuminate\Foundation\Http\FormRequest;

class OwnerRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'name' => ['required', 'string'],
            'email' => ['required', 'email', 'unique:owners,email'],
            'type' => ['required'],
            'identifier' => ['required', 'string'],
        ];
    }

    protected function prepareForValidation()
    {
        if ($this->has('name')) {
            $this->merge(['name' => filter_var($this->get('name'), FILTER_SANITIZE_STRING)]);
        }

        if ($this->has('email')) {
            $this->merge(['email' => filter_var($this->get('email'),FILTER_SANITIZE_EMAIL)]);
        }

        if ($this->has('type')) {
            $this->merge(['type' => filter_var($this->get('type'),FILTER_SANITIZE_STRING)]);
        }

        if ($this->has('identifier')) {
            $this->merge(['identifier' => Sanitizer::onlyDigits($this->get('identifier'))]);
        }
    }

    public function withValidator($validator)
    {
        if ($this->request->get('type') === 'private') {
            $validator->addRules([
                'identifier' => ['min:11', 'max:11', new CPFRule()],
            ]);
        }

        if ($this->request->get('type') === 'legal') {
            $validator->addRules([
                'identifier' => ['min:14', 'max:14', new CNPJRule()],
            ]);
        }
    }
}
