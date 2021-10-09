<?php

namespace App\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;

class EmprestaRequests extends FormRequest
{
    public $validator = null;
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

        if(!empty($_REQUEST['instituicoes']))
        {
            return [
                'instituicoes'     => 'string',
                'valor_emprestimo' => 'required|regex:/^\d+(\.\d{1,2})?$/',
            ];
        }

        if(!empty($_REQUEST['convenios']))
        {
            return [
                'convenios'        => 'string',
                'valor_emprestimo' => 'required|regex:/^\d+(\.\d{1,2})?$/',
            ];
        }

        if(!empty($_REQUEST['parcela']))
        {
            return [
                'parcela'          => 'numeric',
                'valor_emprestimo' => 'required|regex:/^\d+(\.\d{1,2})?$/',
            ];
        }

        return [
            'valor_emprestimo' => 'required|regex:/^\d+(\.\d{1,2})?$/',
        ];
    }

    public function messages()
    {
        return [
            'valor_emprestimo.required' => 'valor_emprestimo obrigatório',
            'valor_emprestimo.regex'    => 'valor_emprestimo obrigatório ser do tipo float',
            'convenios.string'          => 'convenios obrigatório ser do typo string',
            'instituicoes.string'       => 'instituicoes obrigatório ser do typo string',
            'parcela.numeric'           => 'parcela obrigatório ser do typo string',
        ];
    }

    protected function failedValidation($validator)
    {
        $this->validator = $validator;
    }
}
