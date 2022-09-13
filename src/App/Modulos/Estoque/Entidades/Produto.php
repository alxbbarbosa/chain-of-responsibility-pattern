<?php

namespace App\Modulos\Estoque\Entidades;

use App\Modulos\Estoque\Entidades\Produto\Categoria;
use App\Modulos\Estoque\Entidades\Produto\Detalhes;
use App\Modulos\Estoque\Entidades\Produto\Detalhes\Estoque;
use Util\EntityCommon\FuncionarioGerenciadorTrait;
use Util\EntityCommon\IdentificadorTrait;
use Util\EntityCommon\TimestampTrait;

class Produto
{
    private float $valorCompra = 0.0;
    private float $valorVenda = 0.0;
    private readonly Categoria $categoria;
    private Detalhes $detalhes;
    private Estoque $estoque;

    use TimestampTrait;
    use FuncionarioGerenciadorTrait;
    use IdentificadorTrait;

    private function __construct(
        string $descricao,
        Categoria $categoria,
    ) {
        $this->categoria = $categoria;
        $this->detalhes = new Detalhes($descricao);
        $this->estoque = new Estoque();
    }

    public static function criar(string $descricao, Categoria $categoria): self
    {
        return new static($descricao, $categoria);
    }

    public function setDetalhes(Detalhes $detalhes): void
    {
        $this->detalhes = $detalhes;
    }

    public function setEstoque(Estoque $estoque): void
    {
        $this->estoque = $estoque;
    }

    public function getDescricao(): string
    {
        return $this->detalhes->getDescricao();
    }

    public function getValorCompra(): float
    {
        return $this->valorCompra;
    }

    public function getValorVenda(): float
    {
        return $this->valorVenda;
    }

    public function categoria(): Categoria
    {
        return $this->categoria;
    }

    public function estoque(): Estoque
    {
        return $this->estoque;
    }

    public function detalhes(): Detalhes
    {
        return $this->detalhes;
    }

    public function setValorCompra(float $valorCompra): void
    {
        $this->valorCompra = $valorCompra;
    }

    public function setValorVenda(float $valorVenda): void
    {
        $this->valorVenda = $valorVenda;
    }
}