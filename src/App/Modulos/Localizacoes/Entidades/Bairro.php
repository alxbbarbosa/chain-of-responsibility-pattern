<?php

namespace App\Modulos\Localizacoes\Entidades;

use Util\EntityCommon\IdentificadorTrait;

class Bairro
{
    use IdentificadorTrait;

    private function __construct(
        private readonly string $nome,
        private readonly Cidade $cidade,
    ) {
    }

    public static function criar(string $nome, Cidade $cidade): self
    {
        return new static($nome, $cidade);
    }

    public function getNome(): string
    {
        return $this->nome;
    }

    public function getCidade(): Cidade
    {
        return $this->cidade;
    }
}