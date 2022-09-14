<?php

namespace App\Modulos\Compras\Repository;

use App\Modulos\Compras\Entidades\Fornecedor;
use App\Modulos\Compras\Entidades\FornecedorCollection;

interface FornecedorRepositoryInterface
{
    public function salvar(Fornecedor $fornecedor): Fornecedor;

    public function obterPorId(int $id): ?Fornecedor;

    public function obterTodos(): FornecedorCollection;

    public function removerPorId(int $id): bool;
}