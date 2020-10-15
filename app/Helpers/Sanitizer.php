<?php

namespace App\Helpers;

class Sanitizer
{
    /**
     * @param string $value
     * @return mixed
     */
    public static function onlyDigits(string $value)
    {
        return preg_replace('/[^\d]/', '', $value);
    }
}
