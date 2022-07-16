<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Truck;
use Database\Factories\TruckFactory;
use App\Models\Driver;

class TruckTest extends TestCase
{
    protected $endpoint = '/trucks';

    use UtilsTrait;

    public function plateGenerator()
    {
        $plate = [chr(rand(65,90)), chr(rand(65,90)), chr(rand(65,90)), chr(rand(48,57)),
                    chr(rand(65,90)), chr(rand(48,57)), chr(rand(48,57))];
        $plate = implode("", $plate);

        return $plate;
    }

    public function test_get_all_Trucks()
    {
        Truck::factory()->count(6)->create();

        $response = $this->getJson($this->endpoint, $this->defaultHeaders());

        $response->assertJsonCount(Truck::count(), 'data');
        $response->assertStatus(200);
    }

    public function test_error_get_single_Truck()
    {
        $truck_id = 1918;

        $response = $this->getJson("{$this->endpoint}/{$truck_id}", $this->defaultHeaders());

        $response->assertStatus(404);
    }

    public function test_get_single_Truck()
    {
        $truck = Truck::factory()->create();

        $response = $this->getJson("{$this->endpoint}/{$truck->id}", $this->defaultHeaders());

        $response->assertStatus(200);
    }

    public function test_validations_store_Truck()
    {
        $response = $this->postJson($this->endpoint, [
            'name' => '',
            'cpf' => '',
            'birth_date' => '',
            'email' => ''
        ], $this->defaultHeaders());

        $response->assertStatus(422);
    }

    public function test_validations_Plate()
    {
        $response = $this->postJson($this->endpoint, [
            'model' => 'Mercedes',
            'color' => 'Blue',
            'license_plate' => 'AB12345',
            'email' => 5
        ], $this->defaultHeaders());

        $response->assertStatus(422);
    }

    public function test_store_Truck()
    {
        $faker = \Faker\Factory::create('pt_BR');

        $driver_id = Driver::Select('*')->inRandomOrder()->first()->id;

        $response = $this->postJson($this->endpoint, [
            'model' => $faker->word(),
            'color' => $faker->colorName(),
            'license_plate'=> $this->plateGenerator(),
            'driver_id' => $driver_id,
        ], $this->defaultHeaders());

        $response->assertStatus(200);
    }

    public function test_update_Truck()
    {
        $truck = Truck::factory()->create();

        $faker = \Faker\Factory::create('pt_BR');

        $driver_id = Driver::Select('*')->inRandomOrder()->first()->id;

        $data = [
            'model' => $faker->word(),
            'color' => $faker->colorName(),
            'license_plate'=> $this->plateGenerator(),
            'driver_id' => $driver_id
        ];

        $response = $this->putJson("$this->endpoint/1918", $data, $this->defaultHeaders());
        $response->assertStatus(404);

        $response = $this->putJson("$this->endpoint/{$truck->id}", [], $this->defaultHeaders());
        $response->assertStatus(422);

        $response = $this->putJson("$this->endpoint/{$truck->id}", $data, $this->defaultHeaders());
        $response->assertStatus(200);
    }

    public function test_delete_Truck()
    {
        $truck = Truck::factory()->create();

        $response = $this->deleteJson("{$this->endpoint}/{$truck->id}",[], $this->defaultHeaders());
        $response->assertStatus(204);
    }
}
