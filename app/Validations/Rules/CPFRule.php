<?php

namespace App\Validations\Rules;

use App\Validations\CPFValidator;
use Illuminate\Contracts\Validation\Rule;

class CPFRule implements Rule
{
    use CPFValidator;

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
        return __('validation.cpf');
    }
}
