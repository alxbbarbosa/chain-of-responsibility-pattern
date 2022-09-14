<?php

namespace App\Modulos\Compras\Entidades;

use Util\AbstractCollection;

class OrcamentoCollection extends AbstractCollection
{
    public function adicionar(Orcamento $orcamento): void
    {
        $this->add($orcamento);
    }

    public function obterValorTotal(): float
    {
        return array_reduce($this->collection, function ($acc, $item) {
            $acc += $item->getValorTotal();
            return $acc;
        }, 0.0);
    }
}