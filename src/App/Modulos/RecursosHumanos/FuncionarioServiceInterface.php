<?php

namespace App\Modulos\RecursosHumanos;

use App\Modulos\RecursosHumanos\Entidades\Funcionario;
use App\Modulos\RecursosHumanos\Entidades\FuncionarioCollection;

interface FuncionarioServiceInterface
{
    public function salvar(Funcionario $funcionario): Funcionario;

    public function obterPorId(int $id): ?Funcionario;

    public function obterTodos(): FuncionarioCollection;

    public function removerPorId(int $id): bool;

    public function obterPorFuncaoIdEDepartamentoId(int $funcaoId, int $departamentoId): ?Funcionario;
}