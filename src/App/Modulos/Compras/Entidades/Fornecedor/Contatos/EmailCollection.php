<?php

namespace App\Modulos\Compras\Entidades\Fornecedor\Contatos;

use Util\AbstractCollection;

class EmailCollection extends AbstractCollection
{
    public function adicionar(Email $email): void
    {
        $this->add($email);
    }
}