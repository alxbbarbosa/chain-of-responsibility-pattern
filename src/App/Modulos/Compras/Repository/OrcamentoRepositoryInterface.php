<?php

namespace App\Modulos\Compras\Repository;

use App\Modulos\Compras\Entidades\Orcamento;
use App\Modulos\Compras\Entidades\OrcamentoCollection;

interface OrcamentoRepositoryInterface
{
    public function salvar(Orcamento $orcamento): ?Orcamento;

    public function obterPorId(int $id): ?Orcamento;

    public function obterTodos(): OrcamentoCollection;

    public function removerPorId(int $id): bool;
}