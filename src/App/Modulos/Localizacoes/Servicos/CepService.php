<?php

namespace App\Modulos\Localizacoes\Servicos;

use App\Modulos\Localizacoes\Entidades\Bairro;
use App\Modulos\Localizacoes\Entidades\Cidade;
use App\Modulos\Localizacoes\Entidades\Estado;
use App\Modulos\Localizacoes\Entidades\Logradouro;

class CepService implements CepServiceInterface
{
    public function obterPorCep(string $cep): ?Logradouro
    {
        $cep = preg_filter('/\D/', '', $cep);
        $curl = curl_init();
        $timeout = 5;
        curl_setopt($curl, CURLOPT_URL, "http://viacep.com.br/ws/$cep/json");
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl, CURLOPT_CONNECTTIMEOUT, $timeout);
        $contents = curl_exec($curl);
        curl_close($curl);

        if ($contents) {
            $data = json_decode($contents, true);
            $estado = Estado::criar($data['uf'], $this->obterNomePorSigla($data['uf']));
            $cidade = Cidade::criar($data['localidade'], $estado);
            $bairro = Bairro::criar($data['bairro'], $cidade);
            return Logradouro::criar($data['cep'], $data['logradouro'], $bairro);
        }

        return null;
    }

    public function obterNomePorSigla(string $uf): string
    {
        return [
            'AC' => 'Acre',
            'AL' => 'Alagoas',
            'AP' => 'Amapá',
            'AM' => 'Amazonas',
            'BA' => 'Bahia',
            'CE' => 'Ceará',
            'DF' => 'Distrito Federal',
            'ES' => 'Espírito Santo',
            'GO' => 'Goiás',
            'MA' => 'Maranhão',
            'MT' => 'Mato Grosso',
            'MS' => 'Mato Grosso do Sul',
            'MG' => 'Minas Gerais',
            'PA' => 'Pará',
            'PB' => 'Paraíba',
            'PR' => 'Paraná',
            'PE' => 'Pernambuco',
            'PI' => 'Piauí',
            'RJ' => 'Rio de Janeiro',
            'RN' => 'Rio Grande do Norte',
            'RS' => 'Rio Grande do Sul',
            'RO' => 'Rondônia',
            'RR' => 'Roraima',
            'SC' => 'Santa Catarina',
            'SP' => 'São Paulo',
            'SE' => 'Sergipe',
            'TO' => 'Tocantins',
        ][$uf];
    }
}