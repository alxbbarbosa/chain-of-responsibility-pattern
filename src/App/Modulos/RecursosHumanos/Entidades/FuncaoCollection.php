<?php

namespace App\Modulos\RecursosHumanos\Entidades;

use Util\AbstractCollection;

class FuncaoCollection extends AbstractCollection
{
    public function adicionar(Funcao $funcao): void
    {
        $this->add($funcao);
    }
}