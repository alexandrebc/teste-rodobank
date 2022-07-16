<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreShippingRequest extends FormRequest
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
                'name' => 'required|max:100',
                'cnpj' => 'required|digits:14|unique:shippings'
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'Nome da transportadora não pode ficar em branco',
            'name.max' => 'Tamanho máximo do nome da transportadora é de 100 caracteres',
            'cnpj.unique' => 'CNPJ já cadastrado',
            'cnpj.digits' => 'Informe um cnpj válido',
            'cnpj.required' => 'CNPJ da transportadora não pode ficar em branco'
        ];

    }
}
