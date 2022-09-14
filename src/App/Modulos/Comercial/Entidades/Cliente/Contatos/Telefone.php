<?php

namespace App\Modulos\Comercial\Entidades\Cliente\Contatos;

use App\Modulos\Comercial\Entidades\Cliente;
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
        private readonly Cliente $cliente,
    ) {
    }

    public static function criar(string $ddd, string $numero, Cliente $cliente): self
    {
        return new static($ddd, $numero, $cliente);
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