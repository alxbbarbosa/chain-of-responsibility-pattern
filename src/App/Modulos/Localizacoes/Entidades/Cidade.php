<?php

namespace App\Modulos\Localizacoes\Entidades;

use Util\EntityCommon\IdentificadorTrait;

class Cidade
{
    use IdentificadorTrait;

    private function __construct(
        private readonly string $nome,
        private readonly Estado $estado,
    ) {
    }

    public static function criar(string $nome, Estado $estado): self
    {
        return new static($nome, $estado);
    }

    public function getNome(): string
    {
        return $this->nome;
    }

    public function getEstado(): Estado
    {
        return $this->estado;
    }
}