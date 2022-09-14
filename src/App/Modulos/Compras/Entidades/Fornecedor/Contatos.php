<?php

namespace App\Modulos\Compras\Entidades\Fornecedor;

use App\Modulos\Compras\Entidades\Fornecedor\Contatos\EmailCollection;
use App\Modulos\Compras\Entidades\Fornecedor\Contatos\TelefoneCollection;

class Contatos
{
    private TelefoneCollection $telefoneCollection;
    private EmailCollection $emailCollection;

    public function __construct()
    {
        $this->telefoneCollection = new TelefoneCollection();
        $this->emailCollection = new EmailCollection();
    }

    public function telefones(): TelefoneCollection
    {
        return $this->telefoneCollection;
    }

    public function emails(): EmailCollection
    {
        return $this->emailCollection;
    }
}