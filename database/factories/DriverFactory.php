<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Driver>
 */
class DriverFactory extends Factory
{
    public function withFaker()
    {
        return \Faker\Factory::create('pt_BR');
    }
    public function definition()
    {
        return [
            'name' => $this->faker->name(),
            'cpf' => $this->faker->unique->cpf(false),
            'birth_date' => $this->faker->dateTimeBetween('-80 years', '-18 years'),
            'email' => $this->faker->email()
        ];
    }
}
