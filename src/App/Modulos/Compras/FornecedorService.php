<?php

namespace App\Modulos\Compras;

use App\Modulos\Compras\Entidades\FornecedorCollection;
use App\Modulos\Compras\Entidades\Fornecedor;
use App\Modulos\Compras\Repository\FornecedorRepositoryInterface;

class FornecedorService implements FornecedorServiceInterface
{
    public function __construct(
        private readonly FornecedorRepositoryInterface $fornecedorRepository
    ) {
    }

    public function salvar(Fornecedor $fornecedor): Fornecedor
    {
        return $this->fornecedorRepository->salvar($fornecedor);
    }

    public function obterPorId(int $id): ?Fornecedor
    {
        return $this->fornecedorRepository->obterPorId($id);
    }

    public function obterTodos(): FornecedorCollection
    {
        return $this->fornecedorRepository->obterTodos();
    }

    public function removerPorId(int $id): bool
    {
        return $this->fornecedorRepository->removerPorId($id);
    }
}