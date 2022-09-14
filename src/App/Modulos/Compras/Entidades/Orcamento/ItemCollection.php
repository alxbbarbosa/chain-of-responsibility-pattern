<?php

namespace App\Modulos\Compras\Entidades\Orcamento;

use Util\AbstractCollection;

class ItemCollection extends AbstractCollection
{
    public function adicionar(Item $item)
    {
        $this->add($item);
    }

    public function obterValorTotal(): float
    {
        return array_reduce($this->collection, function ($acc, $item) {
            $acc += $item->getValorTotal();
            return $acc;
        }, 0.0);
    }
}