<?php

namespace App\Modulos\Compras\Repository;

use App\Modulos\Compras\Entidades\Orcamento\Aprovador;
use App\Modulos\Compras\Entidades\Orcamento\AprovadorCollection;

interface AprovadorRepositoryInterface
{
    public function salvar(Aprovador $aprovador): Aprovador;

    public function obterPorId(int $id): ?Aprovador;

    public function obterTodos(): AprovadorCollection;

    public function removerPorId(int $id): bool;
}