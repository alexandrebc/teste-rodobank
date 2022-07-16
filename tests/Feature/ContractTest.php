<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Driver;
use App\Models\Shipping;
use App\Models\Contract;

class ContractTest extends TestCase
{
    protected $endpoint = '/contracts';

    public function test_new_Contract()
    {
        $driver_id = Driver::Select('*')->inRandomOrder()->first()->id;
        $shipping_id = Shipping::Select('*')->inRandomOrder()->first()->id;

        $response = $this->getJson("{$this->endpoint}/{$shipping_id}/{$driver_id}");

        $response->assertStatus(200);
    }

    public function test_delete_Contract()
    {
        $contract = Contract::factory()->create();

        $response = $this->deleteJson("{$this->endpoint}/{$contract->shipping_id}/{$contract->driver_id}");

        $response->assertStatus(204);
    }
}
