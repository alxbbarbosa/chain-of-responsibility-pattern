<?php

namespace App\Modulos\Localizacoes\Entidades;

use Util\EntityCommon\IdentificadorTrait;

class Estado
{

    use IdentificadorTrait;

    private function __construct(
        private readonly string $sigla,
        private readonly string $nome
    ) {
    }

    public static function criar($sigla, $nome): self
    {
        return new static($sigla, $nome);
    }

    public function getSigla(): string
    {
        return $this->sigla;
    }

    public function getNome(): string
    {
        return $this->nome;
    }
}