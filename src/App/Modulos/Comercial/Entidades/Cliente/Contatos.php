<?php

namespace App\Modulos\Comercial\Entidades\Cliente;

use App\Modulos\Comercial\Entidades\Cliente\Contatos\EmailCollection;
use App\Modulos\Comercial\Entidades\Cliente\Contatos\TelefoneCollection;

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