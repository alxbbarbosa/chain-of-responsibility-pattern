<?php

namespace App\Modulos\Compras\Entidades\Orcamento;

use App\Modulos\Compras\Entidades\Orcamento;
use App\Modulos\Estoque\Entidades\Produto;
use Util\EntityCommon\IdentificadorTrait;

class Item
{
    private Orcamento $orcamento;

    use IdentificadorTrait;

    private function __construct(
        private readonly Produto $produto,
        private readonly int $quantidade,
        private float $valorUnitario = 0.0
    ) {
    }

    public static function criar(Produto $produto, int $quantidade, float $valorUnitario = 0.0): self
    {
        return new static($produto, $quantidade, $valorUnitario);
    }

    public function getProduto(): Produto
    {
        return $this->produto;
    }

    public function getQuantidade(): int
    {
        return $this->quantidade;
    }

    public function getValorUnitario(): float
    {
        return $this->valorUnitario;
    }

    public function setValorUnitario(float $valorUnitario): void
    {
        $this->valorUnitario = $valorUnitario;
    }

    public function getValorTotal(): float
    {
        return $this->valorUnitario * (float)$this->quantidade;
    }

    public function getOrcamento(): Orcamento
    {
        return $this->orcamento;
    }

    public function setOrcamento(Orcamento $orcamento): void
    {
        $this->orcamento = $orcamento;
    }
}