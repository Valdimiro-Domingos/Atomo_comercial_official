<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BancoRequest extends FormRequest
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
     * @return array
     */
    public function rules()
    {
        return [
            'nome' => 'required|unique:bancos,nome',
            'iban' => 'required|unique:bancos,iban|digits:21',
            'swift' => 'sometimes|unique:bancos,swift'
        ];
    }

    /**
     * Get the validation messages to show to user.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'required' => 'O campo :attribute é obrigatório',
            'unique' => 'Já existe um banco com este :attribute',
            'digits' => 'O campo :attribute deve conter 21 digitos',
        ];
    }
}
