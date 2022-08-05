<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class AddressFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->address,
            'number' => $this->faker->numberBetween(1, 200000),
            'city_id' => '1',
            'user_id' => '1',
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
