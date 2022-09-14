<?php

namespace App\Modulos\RecursosHumanos;

use App\Modulos\RecursosHumanos\Entidades\Funcao;
use App\Modulos\RecursosHumanos\Entidades\FuncaoCollection;
use App\Modulos\RecursosHumanos\Repository\FuncaoRepositoryInterface;

class FuncaoService implements FuncaoServiceInterface
{
    public function __construct(
        private readonly FuncaoRepositoryInterface $funcaoRepository
    ) {
    }

    public function salvar(Funcao $funcao): Funcao
    {
        return $this->funcaoRepository->salvar($funcao);
    }

    public function obterPorId(int $id): Funcao
    {
        return $this->funcaoRepository->obterPorId($id);
    }

    public function obterTodos(): FuncaoCollection
    {
        return $this->funcaoRepository->obterTodos();
    }

    public function removerPorId(int $id): bool
    {
        return $this->funcaoRepository->removerPorId($id);
    }
}