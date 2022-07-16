<?php

namespace App\Http\Requests;

use Carbon\Carbon;
use Illuminate\Foundation\Http\FormRequest;

class StoreDriverRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }
    public function rules()
    {
        return [
            'name' => 'required|max:100',
            'cpf' => 'required|digits:11|unique:drivers',
            'birth_date' => 'required|date|before:'.Carbon::now()->subYears(18),
            'email' => 'nullable|email',
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'Nome do motorista não pode ficar em branco',
            'name.max' => 'Tamanho máximo do nome do motorista é de 100 caracteres',
            'cpf.unique' => 'CPF já cadastrado',
            'cpf.digits' => 'Informe um CPF válido',
            'cpf.required' => 'CPF do motorista não pode ficar em branco',
            'birth_date.required' => 'Data de nascimento não pode ficar em branco',
            'birth_date.data' => 'Informe uma data de nascimento válida',
            'birth_date.before' => 'Motorista não pode ter menos de 18 anos',
            'email.email' => 'Informe um email válido'
        ];

    }
}
