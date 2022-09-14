<?php

namespace App\Modulos\Compras\Entidades\Fornecedor\Contatos;

use App\Modulos\Compras\Entidades\Fornecedor;
use Util\EntityCommon\IdentificadorTrait;

class Telefone
{
    private string $descricao;
    private string $ramal;
    private string $contato;

    use IdentificadorTrait;

    private function __construct(
        private readonly string $ddd,
        private readonly string $numero,
        private readonly Fornecedor $fornecedor,
    ) {
    }

    public static function criar(string $ddd, string $numero, Fornecedor $fornecedor): self
    {
        return new static($ddd, $numero, $fornecedor);
    }

    public function getDescricao(): string
    {
        return $this->descricao;
    }

    public function getRamal(): string
    {
        return $this->ramal;
    }

    public function getContato(): string
    {
        return $this->contato;
    }

    public function setDescricao(string $descricao): void
    {
        $this->descricao = $descricao;
    }

    public function setRamal(string $ramal): void
    {
        $this->ramal = $ramal;
    }

    public function setContato(string $contato): void
    {
        $this->contato = $contato;
    }
}