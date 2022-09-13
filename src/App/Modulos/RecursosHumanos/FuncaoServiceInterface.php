<?php

namespace App\Modulos\RecursosHumanos;

use App\Modulos\RecursosHumanos\Entidades\Funcao;
use App\Modulos\RecursosHumanos\Entidades\FuncaoCollection;

interface FuncaoServiceInterface
{
    public function salvar(Funcao $funcao): Funcao;

    public function obterPorId(int $id): ?Funcao;

    public function obterTodos(): FuncaoCollection;

    public function removerPorId(int $id): bool;
}