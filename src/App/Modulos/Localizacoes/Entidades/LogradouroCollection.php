<?php

namespace App\Modulos\Localizacoes\Entidades;

use Util\AbstractCollection;

class LogradouroCollection extends AbstractCollection
{
    public function adicionar(Logradouro $logradouro)
    {
        $this->add($logradouro);
    }
}