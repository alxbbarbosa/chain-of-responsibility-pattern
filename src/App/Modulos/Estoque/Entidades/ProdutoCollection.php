<?php

namespace App\Modulos\Estoque\Entidades;

use Util\AbstractCollection;

class ProdutoCollection extends AbstractCollection
{
    public function adicionar(Produto $produto)
    {
        $this->add($produto);
    }
}