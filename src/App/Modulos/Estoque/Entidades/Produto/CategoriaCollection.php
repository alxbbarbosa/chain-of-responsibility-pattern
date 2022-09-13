<?php

namespace App\Modulos\Estoque\Entidades\Produto;

use Util\AbstractCollection;

class CategoriaCollection extends AbstractCollection
{
    public function adicionar(Categoria $categoria): void
    {
        $this->add($categoria);
    }
}