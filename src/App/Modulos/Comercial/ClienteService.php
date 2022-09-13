<?php

namespace App\Modulos\Comercial;

use App\Modulos\Comercial\Entidades\Cliente;
use App\Modulos\Comercial\Entidades\ClienteCollection;
use App\Modulos\Comercial\Repository\ClienteRepositoryInterface;

class ClienteService implements ClienteServiceInterface
{
    public function __construct(
        private readonly ClienteRepositoryInterface $clienteRepository
    ) {
    }

    public function salvar(Cliente $cliente): Cliente
    {
        return $this->clienteRepository->salvar($cliente);
    }

    public function obterPorId(int $id): ?Cliente
    {
        return $this->clienteRepository->obterPorId($id);
    }

    public function obterTodos(): ClienteCollection
    {
        return $this->clienteRepository->obterTodos();
    }

    public function removerPorId(int $id): bool
    {
        return $this->clienteRepository->removerPorId($id);
    }
}