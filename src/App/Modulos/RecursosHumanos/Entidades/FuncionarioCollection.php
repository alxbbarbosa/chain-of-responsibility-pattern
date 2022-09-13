<?php

namespace App\Modulos\RecursosHumanos\Entidades;

use Util\AbstractCollection;

class FuncionarioCollection extends AbstractCollection
{
    public function adicionar(Funcionario $funcionario): void
    {
        $this->add($funcionario);
    }
}