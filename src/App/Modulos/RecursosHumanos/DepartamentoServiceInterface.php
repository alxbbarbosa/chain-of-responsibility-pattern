<?php

namespace App\Modulos\RecursosHumanos;

use App\Modulos\RecursosHumanos\Entidades\Departamento;
use App\Modulos\RecursosHumanos\Entidades\DepartamentoCollection;

interface DepartamentoServiceInterface
{
    public function salvar(Departamento $departamento): Departamento;

    public function obterPorId(int $id): ?Departamento;

    public function obterTodos(): DepartamentoCollection;

    public function removerPorId(int $id): bool;
}