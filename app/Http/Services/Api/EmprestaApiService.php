<?php

namespace App\Http\Services\Api;

use Illuminate\Support\Facades\Storage;

class EmprestaApiService
{
    private $arqConvenios;
    private $arqInstituicoes;
    private $arqTaxasInstituicoes;

    public function __construct()
    {
        $this->arqConvenios         = json_decode(Storage::disk('local')->get('public\arquivosEmpresta\convenios.json'));
        $this->arqInstituicoes      = json_decode(Storage::disk('local')->get('public\arquivosEmpresta\instituicoes.json'));
        $this->arqTaxasInstituicoes = json_decode(Storage::disk('local')->get('public\arquivosEmpresta\taxas_instituicoes.json'));
    }

    public function conveniosService()
    {
        return $this->arqConvenios;
    }

    public function instituicoesService()
    {
        return $this->arqInstituicoes;
    }

    public function simuladorCreditoService($data)
    {
        $jsonValores        = [];
        $jsonResponse       = [];
        $instituicoesFiltro = false;

        $collection = collect($this->arqTaxasInstituicoes);

        if(!empty($data['instituicoes']))
        {
            $collection         = $collection->where('instituicao', $data['instituicoes']);
            $instituicoesFiltro = true;
        }

        if(!empty($data['convenios']))
            $collection = $collection->where('convenio', $data['convenios']);

        if(!empty($data['parcela']))
            $collection = $collection->where('parcelas', $data['parcela']);

        if(!$instituicoesFiltro)
        {
            foreach ($this->arqInstituicoes as $key => $Instituicoes) {
                if($collection->where('instituicao', $Instituicoes->chave)->count() > 0)
                    $jsonValores = array_merge($jsonValores, $this->montaArrayFiltro($collection->where('instituicao', $Instituicoes->chave), $data));
            }

        }else{
            if($collection->count() > 0)
                $jsonValores = $this->montaArrayFiltro($collection, $data);
        }

        $jsonResponse = json_decode(json_encode($jsonValores));

        return $jsonResponse;
    }

    public function montaArrayFiltro($collection, $data)
    {
        foreach ($collection as $key => $collectionData) {

            $valor_parcela = floatval(round($data['valor_emprestimo'] * $collectionData->coeficiente, 2));

            $jsonValores[] = ['taxa'          => $collectionData->taxaJuros,
                              'parcelas'      => $collectionData->parcelas,
                              'valor_parcela' => $valor_parcela,
                              'convenio'      => $collectionData->convenio];

            $jsonResponse[$collectionData->instituicao] = array_values($jsonValores);
        }

        return $jsonResponse;
    }
}
