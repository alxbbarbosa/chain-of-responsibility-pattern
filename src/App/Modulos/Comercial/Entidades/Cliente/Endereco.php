<?php

namespace App\Modulos\Comercial\Entidades\Cliente;

use App\Modulos\Comercial\Entidades\Cliente;
use App\Modulos\Localizacoes\Entidades\Logradouro;
use Util\AbstractEndereco;
use Util\EntityCommon\IdentificadorTrait;

class Endereco extends AbstractEndereco
{
    private Cliente $cliente;

    use IdentificadorTrait;

    public static function criar(string $decricao, Logradouro $logradouro): self
    {
        return new static($decricao, $logradouro);
    }

    public function getCliente(): Cliente
    {
        return $this->cliente;
    }

    public function setCliente(Cliente $cliente): void
    {
        $this->cliente = $cliente;
    }
}