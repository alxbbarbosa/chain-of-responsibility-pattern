<?php

namespace App\Modulos\RecursosHumanos;

use App\Modulos\RecursosHumanos\Entidades\Departamento;
use App\Modulos\RecursosHumanos\Entidades\DepartamentoCollection;
use App\Modulos\RecursosHumanos\Repository\DepartamentoRepositoryInterface;

class DepartamentoService implements DepartamentoServiceInterface
{
    public function __construct(
        private readonly DepartamentoRepositoryInterface $departamentoRepository
    ) {
    }

    public function salvar(Departamento $departamento): Departamento
    {
        return $this->departamentoRepository->salvar($departamento);
    }

    public function obterPorId(int $id): Departamento
    {
        return $this->departamentoRepository->obterPorId($id);
    }

    public function obterTodos(): DepartamentoCollection
    {
        return $this->departamentoRepository->obterTodos();
    }

    public function removerPorId(int $id): bool
    {
        return $this->departamentoRepository->removerPorId($id);
    }
}