<?php

namespace Tests\Unit;

use App\Validations\Rules\CNPJRule;
use PHPUnit\Framework\TestCase;

class CNPJTest extends TestCase
{
    /**
     * @test
     */
    public function checkInvalidCNPJRepeated09()
    {
        $validator = new CNPJRule();

        foreach (range(0, 9) as $number) {
            // deveria ter usado a trait withFaker =D
            $args = array_map(fn() => $args[] = $number, range(0, 13));
            $cpf = vsprintf( "%s%s.%s%s%s.%s%s%s/%s%s%s%s-%s%s", $args);

            $this->assertFalse($validator->passes('cnpj', $cpf));
        }
    }

    /**
     * @test
     */
    public function checkValidCNPJ()
    {
        $validator = new CNPJRule();

        $this->assertTrue($validator->passes('cnpj', '53.113.726/0001-05'));
        $this->assertTrue($validator->passes('cnpj', '27.299.257/0001-42'));
        $this->assertTrue($validator->passes('cnpj', '48.358.520/0001-05'));
    }
}
