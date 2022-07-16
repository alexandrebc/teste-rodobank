<?php

namespace Tests\Feature;

use App\Models\Driver;
use Tests\TestCase;
use Avlima\PhpCpfCnpjGenerator\Generator;

class DriverTest extends TestCase
{
    protected $endpoint = '/drivers';

    public function test_get_all_Drivers()
    {
        Driver::factory()->count(6)->create();

        $response = $this->getJson($this->endpoint);

        $response->assertJsonCount(Driver::count(), 'data');
        $response->assertStatus(200);
    }

    public function test_error_get_single_Driver()
    {
        $driver_id = 1918;

        $response = $this->getJson("{$this->endpoint}/{$driver_id}");

        $response->assertStatus(404);
    }

    public function test_get_single_Driver()
    {
        $driver = Driver::factory()->create();

        $response = $this->getJson("{$this->endpoint}/{$driver->id}");

        $response->assertStatus(200);
    }

    public function test_validations_store_Driver()
    {
        $response = $this->postJson($this->endpoint, [
            'name' => '',
            'cpf' => '',
            'birth_date' => '',
            'email' => ''
        ]);

        $response->assertStatus(422);
    }

    public function test_store_Driver()
    {
        $response = $this->postJson($this->endpoint, [
            'name' => 'Takumi Fujiwara',
            'cpf' => Generator::cpf(),
            'birth_date' => '1996/05/24',
            'email' => 'takumi@initiald.jp'
        ]);

        $response->assertStatus(200);
    }

    public function test_update_Driver()
    {
        $driver = Driver::factory()->create();

        $data = [
            'name' => "Pierre Gasly",
            'cpf' => Generator::cpf(),
            'birth_date' => '1996/7/2',
            'email' => ' info@pierregasly.com'
        ];

        $response = $this->putJson("$this->endpoint/1918", $data);
        $response->assertStatus(404);

        $response = $this->putJson("$this->endpoint/{$driver->id}", []);
        $response->assertStatus(422);

        $response = $this->putJson("$this->endpoint/{$driver->id}", $data);
        $response->assertStatus(200);
    }

    public function test_delete_Driver()
    {
        $driver = Driver::factory()->create();

        $response = $this->deleteJson("{$this->endpoint}/1918");
        $response->assertStatus(404);

        $response = $this->deleteJson("{$this->endpoint}/{$driver->id}");
        $response->assertStatus(204);
    }
}
