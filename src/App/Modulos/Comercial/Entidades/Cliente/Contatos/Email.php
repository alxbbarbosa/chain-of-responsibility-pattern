<?php

namespace App\Modulos\Comercial\Entidades\Cliente\Contatos;

use App\Modulos\Comercial\Entidades\Cliente;
use Util\EntityCommon\IdentificadorTrait;

class Email
{
    private string $descricao;
    private string $contato;

    use IdentificadorTrait;

    private function __construct(
        private readonly string $mail,
        private readonly Cliente $cliente,
    ) {
    }

    public static function criar(string $email, Cliente $cliente): self
    {
        return new static($email, $cliente);
    }

    public function getDescricao(): string
    {
        return $this->descricao;
    }

    public function setDescricao(string $descricao): void
    {
        $this->descricao = $descricao;
    }

    public function getContato(): string
    {
        return $this->contato;
    }

    public function setContato(string $contato): void
    {
        $this->contato = $contato;
    }
}