<?php

namespace App\Modulos\RecursosHumanos\Repository;

use App\Modulos\RecursosHumanos\Entidades\Funcao;
use App\Modulos\RecursosHumanos\Entidades\FuncaoCollection;

interface FuncaoRepositoryInterface
{
    public function salvar(Funcao $funcao): Funcao;

    public function obterPorId(int $id): ?Funcao;

    public function obterTodos(): FuncaoCollection;

    public function removerPorId(int $id): bool;
}