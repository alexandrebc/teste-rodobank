<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreTruckRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'driver_id' => 'required',
            'license_plate' => 'required|regex:/[A-Z]{3}[0-9][0-9A-Z][0-9]{2}/|unique:trucks',
            'model' => 'required|max:50',
            'color' => 'required|max:50'
        ];
    }

    public function messages()
    {
        return [
            'driver_id.required' => 'Caminhão deve ser associado a um motorista',
            'license_plate.regex' => 'Informe uma placa válida',
            'license_plate.required' => 'Placa do caminhão não pode ficar em branco',
            'license_plate.unique' => 'Placa do caminhão já registrada',
            'model.required' => 'O modelo do caminhão deve ser informado',
            'model.max' => 'O tamanho máximo do nome do modelo é de 50 caracteres',
            'color.required' => 'A cor do caminhão deve ser informada',
            'color.max' => 'O tamanho máximo do nome da cor é de 50 caracteres'
        ];

    }
}
