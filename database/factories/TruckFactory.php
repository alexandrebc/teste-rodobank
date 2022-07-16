<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Driver;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Truck>
 */
class TruckFactory extends Factory
{
    public function withFaker()
    {
        return \Faker\Factory::create('pt_BR');
    }

    public function plateGenerator()
    {
        $plate = [chr(rand(65,90)), chr(rand(65,90)), chr(rand(65,90)), chr(rand(48,57)),
                    chr(rand(65,90)), chr(rand(48,57)), chr(rand(48,57))];
        $plate = implode("", $plate);

        return $plate;
    }
    public function definition()
    {
        return [
            'model' => $this->faker->word(),
            'color' => $this->faker->colorName(),
            'license_plate'=> $this->plateGenerator(),
            'driver_id' => Driver::factory()
        ];
    }
}
