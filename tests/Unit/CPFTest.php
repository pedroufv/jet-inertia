<?php

namespace Tests\Unit;

use App\Validations\Rules\CPFRule;
use PHPUnit\Framework\TestCase;

class CPFTest extends TestCase
{
    /**
     * @test
     */
    public function checkInvalidCPFRepeated09()
    {
        $validator = new CPFRule();

        foreach (range(0, 9) as $number) {
            // deveria ter usado a trait withFaker =D
            $args = array_map(fn() => $args[] = $number, range(0, 10));
            $cpf = vsprintf( "%s%s%s.%s%s%s.%s%s%s-%s%s", $args);

            $this->assertFalse($validator->passes('cpf', $cpf));
        }
    }

    /**
     * @test
     */
    public function checkValidCPF()
    {
        $validator = new CPFRule();

        $this->assertTrue($validator->passes('cpf', '696.334.600-34'));
        $this->assertTrue($validator->passes('cpf', '549.056.040-10'));
        $this->assertTrue($validator->passes('cpf', '696.334.600-34'));
    }
}
