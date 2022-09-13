<?php

namespace App\Modulos\Compras\Entidades\Orcamento;

use Util\AbstractCollection;

class AprovadorCollection extends AbstractCollection
{
    public function adicionar(Aprovador $aprovador): void
    {
        $this->add($aprovador);
    }
}