<?php

namespace App\Modulos\Estoque\Entidades\Produto;

use Util\EntityCommon\IdentificadorTrait;

class Categoria
{
    use IdentificadorTrait;

    private function __construct(private readonly string $descricao)
    {
    }

    public static function criar(string $descricao): self
    {
        return new static($descricao);
    }

    public function getDescricao(): string
    {
        return $this->descricao;
    }

}