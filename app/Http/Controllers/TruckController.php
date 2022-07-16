<?php

namespace App\Http\Controllers;

use App\Models\Truck;
use Illuminate\Http\Request;
use App\Http\Resources\TruckResource;
use App\Http\Requests\StoreTruckRequest;

class TruckController extends Controller
{
    protected $entity;

    public function __construct(Truck $model)
    {
        $this->entity = $model;
    }

    private function findTruck($id)
    {
        return $this->entity->findOrFail($id);
    }

    public function index()
    {
        $trucks = $this->entity->get();

        return TruckResource::collection($trucks);
    }

    public function store(StoreTruckRequest $request)
    {
        $data = $request->validated();

        $response = $this->entity->create([
            'model' => $data['model'],
            'color' => $data['color'],
            'driver_id' => $data['driver_id'],
            'license_plate' => $data['license_plate'],
        ]);

        return response()->json($response, 200);

    }
    public function show($id)
    {
        $truck = $this->findTruck($id);

        return new TruckResource($truck);
    }

    public function update(StoreTruckRequest $request, $id)
    {
        $data = $request->validated();
        $truck = $this->findTruck($id);

        $truck->update([
            'model' => $data['model'],
            'color' => $data['color'],
            'driver_id' => $data['driver_id'],
            'license_plate' => $data['license_plate'],
        ]);

        return response()->json(['message'=>'Caminhão atualizado com sucesso'], 200);
    }

    public function destroy($id)
    {
        $ids = explode(',', $id);

        $this->entity->whereIn('id', $ids)->delete();

        return response()->json(['message' => 'Caminhão(ões) deletado(s) com sucesso'], 204);
    }
}
