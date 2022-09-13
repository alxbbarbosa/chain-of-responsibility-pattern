<?php

namespace App\Modulos\Compras\Servicos\Orcamento;

use App\Modulos\Compras\Entidades\Orcamento\Aprovador;
use App\Modulos\Compras\Entidades\Orcamento\AprovadorCollection;
use App\Modulos\Compras\Repository\AprovadorRepositoryInterface;

class AprovadorService implements AprovadorServiceInterface
{

    public function __construct(
        private readonly AprovadorRepositoryInterface $aprovadorRepository
    ) {
    }

    public function salvar(Aprovador $aprovador): Aprovador
    {
        return $this->aprovadorRepository->salvar($aprovador);
    }

    public function obterPorId(int $id): ?Aprovador
    {
        return $this->aprovadorRepository->obterPorId($id);
    }

    public function obterTodos(): AprovadorCollection
    {
        return $this->aprovadorRepository->obterTodos();
    }

    public function removerPorId(int $id): bool
    {
        return $this->aprovadorRepository->removerPorId($id);
    }
}