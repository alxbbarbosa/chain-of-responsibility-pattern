<?php

namespace App\Modulos\Localizacoes;

use App\Modulos\Localizacoes\Entidades\Logradouro;
use App\Modulos\Localizacoes\Entidades\LogradouroCollection;
use App\Modulos\Localizacoes\Repositorios\LogradouroRepositoryInterface;

class LogradouroService implements LogradouroServiceInterface
{

    public function __construct(
        private readonly LogradouroRepositoryInterface $logradouroRepository
    ) {
    }

    public function salvar(Logradouro $logradouro): ?Logradouro
    {
        return $this->logradouroRepository->salvar($logradouro);
    }

    public function obterPorId(int $id): ?Logradouro
    {
        return $this->logradouroRepository->obterPorId($id);
    }

    public function obterPorCep(string $cep): LogradouroCollection
    {
        return $this->logradouroRepository->obterPorCep($cep);
    }

    public function obterPorBairro(string $bairro): LogradouroCollection
    {
        return $this->logradouroRepository->obterPorBairro($bairro);
    }

    public function obterPorCidade(string $cidade): LogradouroCollection
    {
        return $this->logradouroRepository->obterPorCidade($cidade);
    }

    public function obterTodos(): LogradouroCollection
    {
        return $this->logradouroRepository->obterTodos();
    }

    public function removerPorEntidade(Logradouro $logradouro, bool $recursivo = false): bool
    {
        return $this->logradouroRepository->removerPorEntidade($logradouro, $recursivo);
    }
}