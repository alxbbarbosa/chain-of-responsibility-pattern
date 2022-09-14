<?php

namespace App\Modulos\Comercial;

use App\Modulos\Comercial\Entidades\Cliente;
use App\Modulos\Comercial\Entidades\ClienteCollection;

interface ClienteServiceInterface
{
    public function salvar(Cliente $cliente): Cliente;

    public function obterPorId(int $id): ?Cliente;

    public function obterTodos(): ClienteCollection;

    public function removerPorId(int $id): bool;
}