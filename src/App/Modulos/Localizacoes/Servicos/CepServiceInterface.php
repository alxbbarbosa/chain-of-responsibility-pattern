<?php

namespace App\Modulos\Localizacoes\Servicos;

use App\Modulos\Localizacoes\Entidades\Logradouro;

interface CepServiceInterface
{
    public function obterPorCep(string $cep): ?Logradouro;
}