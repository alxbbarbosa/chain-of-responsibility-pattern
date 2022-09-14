<?php

namespace App\Modulos\Comercial\Repository;

use App\Modulos\Comercial\Entidades\Cliente;
use App\Modulos\Comercial\Entidades\ClienteCollection;

interface ClienteRepositoryInterface
{
    public function salvar(Cliente $fornecedor): Cliente;

    public function obterPorId(int $id): ?Cliente;

    public function obterTodos(): ClienteCollection;

    public function removerPorId(int $id): bool;
}