<?php

namespace App\Modulos\Estoque\Produto;

use App\Modulos\Estoque\Entidades\Produto\Categoria;
use App\Modulos\Estoque\Entidades\Produto\CategoriaCollection;

interface CategoriaServiceInterface
{
    public function salvar(Categoria $produto): Categoria;

    public function obterPorId(int $id): ?Categoria;

    public function obterTodos(): CategoriaCollection;

    public function removerPorId(int $id): bool;
}