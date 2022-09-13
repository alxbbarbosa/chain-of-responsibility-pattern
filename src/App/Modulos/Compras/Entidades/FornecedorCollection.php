<?php

namespace App\Modulos\Compras\Entidades;

use Util\AbstractCollection;

class FornecedorCollection extends AbstractCollection
{
    public function adicionar(Fornecedor $fornecedor): void
    {
        $this->add($fornecedor);
    }
}