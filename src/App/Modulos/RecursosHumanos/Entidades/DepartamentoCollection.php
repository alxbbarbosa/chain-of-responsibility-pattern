<?php

namespace App\Modulos\RecursosHumanos\Entidades;

use Util\AbstractCollection;

class DepartamentoCollection extends AbstractCollection
{
    public function adicionar(Departamento $departamento): void
    {
        $this->add($departamento);
    }
}