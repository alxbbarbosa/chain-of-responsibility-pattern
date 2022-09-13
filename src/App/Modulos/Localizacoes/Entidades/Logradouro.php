<?php

namespace App\Modulos\Localizacoes\Entidades;

use Util\EntityCommon\IdentificadorTrait;

class Logradouro
{
    use IdentificadorTrait;

    private function __construct(
        private readonly string $cep,
        private readonly string $logradouro,
        private readonly Bairro $bairro,
    ) {
    }

    public static function criar(string $cep, string $logradouro, Bairro $bairro): self
    {
        return new static($cep, $logradouro, $bairro);
    }

    public function getCep(): string
    {
        return $this->cep;
    }

    public function getLogradouro(): string
    {
        return $this->logradouro;
    }

    public function getBairro(): Bairro
    {
        return $this->bairro;
    }
}