<?php

namespace App\Modulos\Comercial\Entidades\Cliente\Contatos;

use Util\AbstractCollection;

class TelefoneCollection extends AbstractCollection
{
    public function adicionar(Telefone $telefone): void
    {
        $this->add($telefone);
    }
}