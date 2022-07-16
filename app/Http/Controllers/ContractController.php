<?php

namespace App\Http\Controllers;

use App\Models\Contract;
use Illuminate\Http\Request;

class ContractController extends Controller
{
    protected $entity;

    public function __construct(Contract $model)
    {
        $this->entity = $model;
    }
    public function create($shipping_id, $driver_id)
    {
        $response = $this->entity
                        ->create([
                            'driver_id' => $driver_id,
                            'shipping_id' => $shipping_id,
                        ]);
        return response()->json($response, 200);
    }

    public function delete($shipping_id, $driver_id)
    {
        Contract::Select('*')
                ->where('driver_id', $driver_id)
                ->where('shipping_id', $shipping_id)
                ->delete();

        return response()->json(['message' => 'Contrato excluído com sucesso'], 204);
    }
}
