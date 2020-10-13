<?php

namespace App\Validations\Rules;

use App\Validations\CNPJValidator;
use Illuminate\Contracts\Validation\Rule;

class CNPJRule implements Rule
{
    use CNPJValidator;

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        return $this->validate($value);
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return __('validation.cnpj');
    }
}
