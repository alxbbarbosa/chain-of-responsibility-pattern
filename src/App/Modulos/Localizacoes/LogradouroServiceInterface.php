<?php

namespace App\Modulos\Localizacoes;

use App\Modulos\Localizacoes\Entidades\Logradouro;
use App\Modulos\Localizacoes\Entidades\LogradouroCollection;

interface LogradouroServiceInterface
{
    public function salvar(Logradouro $logradouro): ?Logradouro;

    public function obterPorId(int $id): ?Logradouro;

    public function obterPorCep(string $cep): LogradouroCollection;

    public function obterPorBairro(string $bairro): LogradouroCollection;

    public function obterPorCidade(string $cidade): LogradouroCollection;

    public function obterTodos(): LogradouroCollection;

    public function removerPorEntidade(Logradouro $logradouro, bool $recursivo = false): bool;
}