<?php

namespace App\Modulos\Compras\Entidades\Fornecedor;

use App\Modulos\Compras\Entidades\Fornecedor;
use App\Modulos\Localizacoes\Entidades\Logradouro;
use Util\AbstractEndereco;
use Util\EntityCommon\IdentificadorTrait;

class Endereco extends AbstractEndereco
{
    private Fornecedor $fornecedor;

    use IdentificadorTrait;

    public static function criar(string $descricao, Logradouro $logradouro): self
    {
        return new static($descricao, $logradouro);
    }

    public function getFornecedor(): Fornecedor
    {
        return $this->fornecedor;
    }

    public function setFornecedor(Fornecedor $fornecedor): void
    {
        $this->fornecedor = $fornecedor;
    }
}