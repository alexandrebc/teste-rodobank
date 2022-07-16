<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Shipping;
use App\Http\Resources\ShippingResource;
use App\Http\Requests\StoreShippingRequest;

class ShippingController extends Controller
{
    protected $entity;

    public function __construct(Shipping $model)
    {
        $this->entity = $model;
    }

    private function findShipping($id)
    {
        return $this->entity->with(['contracts'])->findOrFail($id);
    }

    private function cnpjValidator($cnpj)
    {
        // Verifica se todos os digitos são iguais
        if (preg_match('/(\d)\1{13}/', $cnpj))
            return false;

        $cnpj = array_map('intval', str_split($cnpj));

        // Valida primeiro dígito verificador
        for ($i = 0, $j = 5, $sum = 0; $i < 12; $i++)
        {
            $sum += $cnpj[$i] * $j;
            $j = ($j == 2) ? 9 : $j - 1;
        }

        $remainder = $sum % 11;

        if ($cnpj[12] != ($remainder < 2 ? 0 : 11 - $remainder))
            return false;

        // Valida segundo dígito verificador
        for ($i = 0, $j = 6, $sum = 0; $i < 13; $i++)
        {
            $sum += $cnpj[$i] * $j;
            $j = ($j == 2) ? 9 : $j - 1;
        }

        $remainder = $sum % 11;

        return $cnpj[13] == ($remainder < 2 ? 0 : 11 - $remainder);
    }


    public function index($quantity)
    {
        $shippings = $this->entity->with(['contracts'])->paginate($quantity);

        return ShippingResource::collection($shippings);
    }

    public function store(StoreShippingRequest $request)
    {
        $data = $request->validated();

        if($this->cnpjValidator($data['cnpj'])){
            $response = $this->entity->create([
                'name' => $data['name'],
                'cnpj' => $data['cnpj'],
            ]);

            return response()->json($response, 200);
        };

        return response()->json(['message' => 'Informe um cnpj válido'], 400);
    }
    public function show($id)
    {
        $shipping = $this->findShipping($id);

        return new ShippingResource($shipping);
    }

    public function update(StoreShippingRequest $request, $id)
    {
        $data = $request->validated();
        $shipping = $this->findShipping($id);

        if($this->cnpjValidator($data['cnpj'])){
            $shipping->update([
                'name' => $data['name'],
                'cnpj' => $data['cnpj'],
            ]);

            return response()->json(['message'=>'Transportadora atualizada com sucesso'], 200);
        };

        return response()->json(['message' => 'Informe um cnpj válido'], 400);
    }

    public function destroy($id)
    {
        $ids = explode(',', $id);

        $this->entity->whereIn('id', $ids)->delete();

        return response()->json(['message' => 'Transportadora(s) deletada(s) com sucesso'], 204);
    }

    public function status($id)
    {
        $shipping = $this->findShipping($id);

        if($shipping->status == 1){
            $shipping->status = 0;
            $shipping->save();

            return response()->json(['message' => 'Transportadora inativada com sucesso'], 200);
        }

        $shipping->status = 1;
        $shipping->save();

        return response()->json(['message' => 'Transportadora ativada com sucesso'], 200);

    }
}
