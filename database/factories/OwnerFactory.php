<?php

namespace Database\Factories;

use App\Models\Owner;
use Illuminate\Database\Eloquent\Factories\Factory;

class OwnerFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Owner::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->name,
            'email' => $this->faker->safeEmail,
            'type' => $type = $this->faker->randomElement(['legal', 'private']),
            'identifier' => $type === 'legal'
                ? $this->faker->numerify('##############') // 14
                : $this->faker->numerify('###########'), // 11
        ];
    }
}
