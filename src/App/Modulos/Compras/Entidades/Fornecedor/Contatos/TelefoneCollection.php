<?php

namespace App\Modulos\Compras\Entidades\Fornecedor\Contatos;

use Util\AbstractCollection;

class TelefoneCollection extends AbstractCollection
{
    public function adicionar(Telefone $telefone): void
    {
        $this->add($telefone);
    }
}