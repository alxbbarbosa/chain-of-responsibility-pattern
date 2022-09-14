<?php

namespace App\Modulos\Estoque\Produto;

use App\Modulos\Estoque\Entidades\Produto\Categoria;
use App\Modulos\Estoque\Entidades\Produto\CategoriaCollection;
use App\Modulos\Estoque\Repository\Produto\CategoriaRepositoryInterface;

class CategoriaService implements CategoriaServiceInterface
{

    public function __construct(
        private readonly CategoriaRepositoryInterface $categoriaRepository
    ) {
    }

    public function salvar(Categoria $categoria): Categoria
    {
        return $this->categoriaRepository->salvar($categoria);
    }

    public function obterPorId(int $id): ?Categoria
    {
        return $this->categoriaRepository->obterPorId($id);
    }

    public function obterTodos(): CategoriaCollection
    {
        return $this->categoriaRepository->obterTodos();
    }

    public function removerPorId(int $id): bool
    {
        return $this->categoriaRepository->removerPorId($id);
    }
}