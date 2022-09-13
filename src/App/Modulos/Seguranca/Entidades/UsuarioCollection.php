<?php

namespace App\Modulos\Seguranca\Entidades;

use Util\AbstractCollection;

class UsuarioCollection extends AbstractCollection
{
    public function adicionar(Usuario $usuario): void
    {
        $this->add($usuario);
    }
}