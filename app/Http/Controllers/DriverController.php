<?php

namespace App\Http\Controllers;

use App\Models\Driver;
use Illuminate\Http\Request;
use App\Http\Resources\DriverResource;
use App\Http\Requests\StoreDriverRequest;

class DriverController extends Controller
{
    protected $entity;

    public function __construct(Driver $model)
    {
        $this->entity = $model;
    }

    private function findDriver($id)
    {
        return $this->entity->with(['trucks', 'contracts'])->findOrFail($id);
    }

    private function cpfValidator($cpf)
    {
       $cpf = (string) $cpf;

       // Verifica se foi informada uma sequência de digitos repetidos. Ex: 111.111.111-11
       if (preg_match('/(\d)\1{10}/', $cpf)) {
           return false;
       }

       // Faz o calculo para validar o CPF
       for ($t = 9; $t < 11; $t++) {
           for ($d = 0, $c = 0; $c < $t; $c++) {
               $d += $cpf[$c] * (($t + 1) - $c);
           }
           $d = ((10 * $d) % 11) % 10;
           if ($cpf[$c] != $d) {
               return false;
           }
       }
       return true;
    }


    public function index()
    {
        $drivers = $this->entity->with(['trucks', 'contracts'])->get();

        return DriverResource::collection($drivers);
    }

    public function store(StoreDriverRequest $request)
    {
        $data = $request->validated();

        if($this->cpfValidator($data['cpf'])){
           if($request->email != null){
                $response = $this->entity->create([
                    'name' => $data['name'],
                    'cpf' => $data['cpf'],
                    'birth_date' => $data['birth_date'],
                    'email' => $data['email'],
                ]);

                return response()->json($response, 200);
           }

            $response = $this->entity->create([
                'name' => $data['name'],
                'cpf' => $data['cpf'],
                'birth_date' => $data['birth_date'],
            ]);

            return response()->json($response, 200);
        };

        return response()->json(['message' => 'Informe um cpf válido'], 400);
    }
    public function show($id)
    {
        $driver = $this->findDriver($id);

        return new DriverResource($driver);
    }

    public function update(StoreDriverRequest $request, $id)
    {
        $data = $request->validated();
        $driver = $this->findDriver($id);

        if($this->cpfValidator($data['cpf'])){
            $driver->update([
                'name' => $data['name'],
                'cpf' => $data['cpf'],
                'birth_date' => $data['birth_date'],
                'email' => $data['email'],
            ]);

            return response()->json(['message'=>'Motorista atualizado com sucesso'], 200);
        };

        return response()->json(['message' => 'Informe um cpf válido'], 400);
    }

    public function destroy($id)
    {
        $driver = $this->findDriver($id);

        $driver->delete();

        return response()->json(['message'=>'Driver deleted successfully'], 204);
    }
}
