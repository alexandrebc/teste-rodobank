<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Shipping>
 */
class ShippingFactory extends Factory
{

    public function withFaker()
    {
        return \Faker\Factory::create('pt_BR');
    }


    public function definition()
    {
        return [
            'name' => $this->faker->company(),
            'cnpj' => $this->faker->unique->cnpj(false)
        ];
    }
}
