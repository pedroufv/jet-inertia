<?php

namespace App\Validations;

use App\Helpers\Sanitizer;

trait CPFValidator
{
    /**
     * @param $digitos
     * @param int $posicoes
     * @param int $somaDigitos
     * @return string
     */
    public function calculatePositions($digitos, $posicoes = 10, $somaDigitos = 0)
    {
        for ($i = 0; $i < strlen($digitos); $i++) {
            $somaDigitos = $somaDigitos + ($digitos[$i] * $posicoes);
            $posicoes--;
            if ($posicoes < 2) {
                $posicoes = 9;
            }
        }
        $somaDigitos = $somaDigitos % 11;

        if ($somaDigitos < 2) {
            $somaDigitos = 0;
        } else {
            $somaDigitos = 11 - $somaDigitos;
        }
        return $digitos . $somaDigitos;
    }

    /**
     * @param $value
     * @return bool
     */
    public function checkEquality($value): bool
    {
        $caracteres = str_split($value);
        $todosIguais = true;
        $lastVal = $caracteres[0];
        foreach ($caracteres as $val) {
            if ($lastVal != $val) {
                $todosIguais = false;
            }
            $lastVal = $val;
        }
        return $todosIguais;
    }

    /**
     * @param string $value
     * @return bool
     */
    public function validate(string $value): bool
    {
        $value = Sanitizer::onlyDigits($value);
        $digitos = substr($value, 0, 9);
        $novoCpf = $this->calculatePositions($digitos);
        $novoCpf = $this->calculatePositions($novoCpf, 11);

        if ($this->checkEquality($value)) {
            return false;
        }

        if ($novoCpf === $value) {
            return true;
        }

        return false;
    }
}
