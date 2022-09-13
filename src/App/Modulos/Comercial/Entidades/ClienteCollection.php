<?php

namespace App\Modulos\Comercial\Entidades;

use Util\AbstractCollection;

class ClienteCollection extends AbstractCollection
{
    public function adicionar(Cliente $cliente): void
    {
        $this->add($cliente);
    }
}