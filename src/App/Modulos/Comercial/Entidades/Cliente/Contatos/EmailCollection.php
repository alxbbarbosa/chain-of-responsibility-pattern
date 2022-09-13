<?php

namespace App\Modulos\Comercial\Entidades\Cliente\Contatos;

use Util\AbstractCollection;

class EmailCollection extends AbstractCollection
{
    public function adicionar(Email $email): void
    {
        $this->add($email);
    }
}