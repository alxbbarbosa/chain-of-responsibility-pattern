<?php

namespace App\Modulos\Estoque;

use App\Modulos\Estoque\Entidades\Produto;
use App\Modulos\Estoque\Entidades\ProdutoCollection;
use App\Modulos\Estoque\Repository\ProdutoRepositoryInterface;

class ProdutoService implements ProdutoServiceInterface
{
    public function __construct(
        private readonly ProdutoRepositoryInterface $produtoRepository
    ) {
    }

    public function salvar(Produto $produto): ?Produto
    {
        return $this->produtoRepository->salvar($produto);
    }

    public function obterPorId(int $id): ?Produto
    {
        return $this->produtoRepository->obterPorId($id);
    }

    public function obterTodos(): ProdutoCollection
    {
        return $this->produtoRepository->obterTodos();
    }

    public function removerPorId(int $id): bool
    {
        return $this->produtoRepository->removerPorId($id);
    }
}