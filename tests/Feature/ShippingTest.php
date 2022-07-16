<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Shipping;
use Avlima\PhpCpfCnpjGenerator\Generator;

class ShippingTest extends TestCase
{
    protected $endpoint = '/shippings';

    use UtilsTrait;

    public function test_get_all_Shippings()
    {
        Shipping::factory()->count(6)->create();

        $response = $this->getJson($this->endpoint, $this->defaultHeaders());

        $response->assertJsonCount(Shipping::count(), 'data');
        $response->assertStatus(200);
    }

    public function test_error_get_single_Shipping()
    {
        $shipping_id = 1918;

        $response = $this->getJson("{$this->endpoint}/{$shipping_id}", $this->defaultHeaders());

        $response->assertStatus(404);
    }

    public function test_get_single_Shipping()
    {
        $shipping = Shipping::factory()->create();

        $response = $this->getJson("{$this->endpoint}/{$shipping->id}", $this->defaultHeaders());

        $response->assertStatus(200);
    }

    public function test_validations_store_Shipping()
    {
        $response = $this->postJson($this->endpoint, [
            'name' => '',
            'cnpj' => ''
        ], $this->defaultHeaders());

        $response->assertStatus(422);
    }

    public function test_store_Shipping()
    {

        $response = $this->postJson($this->endpoint, [
            'name' => 'Caminhões Xande',
            'cnpj' => Generator::cnpj()
        ], $this->defaultHeaders());

        $response->assertStatus(200);
    }

    public function test_update_Shipping()
    {
        $shipping = Shipping::factory()->create();

        $data = [
            'name' => "Nova transportadora",
            'cnpj' => Generator::cnpj(),
        ];

        $response = $this->putJson("$this->endpoint/1918", $data, $this->defaultHeaders());
        $response->assertStatus(404);

        $response = $this->putJson("$this->endpoint/{$shipping->id}", [], $this->defaultHeaders());
        $response->assertStatus(422);

        $response = $this->putJson("$this->endpoint/{$shipping->id}", $data, $this->defaultHeaders());
        $response->assertStatus(200);
    }

    public function test_delete_Shipping()
    {
        $shipping = Shipping::factory()->create();

        $response = $this->deleteJson("{$this->endpoint}/{$shipping->id}",[], $this->defaultHeaders());
        $response->assertStatus(204);
    }

    public function test_change_status_Shipping()
    {
        $shipping = Shipping::factory()->create();

        $response = $this->getJson("{$this->endpoint}/{$shipping->id}/status", $this->defaultHeaders());

        $response->assertStatus(200);
    }
}
