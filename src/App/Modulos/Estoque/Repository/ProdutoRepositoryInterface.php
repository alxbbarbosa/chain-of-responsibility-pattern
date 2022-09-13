<?php

namespace App\Modulos\Estoque\Repository;

use App\Modulos\Estoque\Entidades\Produto;
use App\Modulos\Estoque\Entidades\ProdutoCollection;

interface ProdutoRepositoryInterface
{
    public function salvar(Produto $produto): ?Produto;

    public function obterPorId(int $id): ?Produto;

    public function obterTodos(): ProdutoCollection;

    public function removerPorId(int $id): bool;
}