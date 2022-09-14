<?php

namespace App\Modulos\RecursosHumanos;

use App\Modulos\RecursosHumanos\Entidades\FuncionarioCollection;
use App\Modulos\RecursosHumanos\Entidades\Funcionario;
use App\Modulos\RecursosHumanos\Repository\FuncionarioRepositoryInterface;

class FuncionarioService implements FuncionarioServiceInterface
{
    public function __construct(
        private readonly FuncionarioRepositoryInterface $funcionarioRepository
    )
    {
    }

    public function salvar(Funcionario $funcionario): Funcionario
    {
        return $this->funcionarioRepository->salvar($funcionario);
    }

    public function obterPorId(int $id): ?Funcionario
    {
        return $this->funcionarioRepository->obterPorId($id);
    }

    public function obterTodos(): FuncionarioCollection
    {
        return $this->funcionarioRepository->obterTodos();
    }

    public function removerPorId(int $id): bool
    {
        return $this->funcionarioRepository->removerPorId($id);
    }

    public function obterPorFuncaoIdEDepartamentoId(int $funcaoId, int $departamentoId): ?Funcionario
    {
        return $this->funcionarioRepository->obterPorFuncaoIdEDepartamentoId($funcaoId, $departamentoId);
    }
}