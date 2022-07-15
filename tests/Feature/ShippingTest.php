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

    public function test_get_all_Shippings()
    {
        Shipping::factory()->count(6)->create();

        $response = $this->getJson($this->endpoint);

        $response->assertJsonCount(Shipping::count(), 'data');
        $response->assertStatus(200);
    }

    public function test_error_get_single_Shipping()
    {
        $shipping_id = 1918;

        $response = $this->getJson("{$this->endpoint}/{$shipping_id}");

        $response->assertStatus(404);
    }

    public function test_get_single_Shipping()
    {
        $shipping = Shipping::factory()->create();

        $response = $this->getJson("{$this->endpoint}/{$shipping->id}");

        $response->assertStatus(200);
    }

    public function test_validations_store_Shipping()
    {
        $response = $this->postJson($this->endpoint, [
            'name' => '',
            'cnpj' => ''
        ]);

        $response->assertStatus(422);
    }

    public function test_store_Shipping()
    {

        $response = $this->postJson($this->endpoint, [
            'name' => 'Caminhões Xande',
            'cnpj' => Generator::cnpj()
        ]);

        $response->assertStatus(200);
    }

    public function test_update_Shipping()
    {
        $shipping = Shipping::factory()->create();

        $data = [
            'name' => "Nova transportadora",
            'cnpj' => Generator::cnpj(),
        ];

        $response = $this->putJson("$this->endpoint/1918", $data);
        $response->assertStatus(404);

        $response = $this->putJson("$this->endpoint/{$shipping->id}", []);
        $response->assertStatus(422);

        $response = $this->putJson("$this->endpoint/{$shipping->id}", $data);
        $response->assertStatus(200);
    }

    public function test_delete_Shipping()
    {
        $shipping = Shipping::factory()->create();

        $response = $this->deleteJson("{$this->endpoint}/1918");
        $response->assertStatus(404);

        $response = $this->deleteJson("{$this->endpoint}/{$shipping->id}");
        $response->assertStatus(204);
    }
}
