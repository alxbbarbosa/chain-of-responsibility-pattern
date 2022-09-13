<?php

namespace App\Modulos\Compras\Servicos\Orcamento;

use App\Modulos\Compras\Entidades\Orcamento\Aprovador;
use App\Modulos\Compras\Entidades\Orcamento\AprovadorCollection;

interface AprovadorServiceInterface
{
    public function salvar(Aprovador $aprovador): Aprovador;

    public function obterPorId(int $id): ?Aprovador;

    public function obterTodos(): AprovadorCollection;

    public function removerPorId(int $id): bool;
}