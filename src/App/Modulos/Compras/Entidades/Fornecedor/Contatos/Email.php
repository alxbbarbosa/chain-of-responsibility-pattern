<?php

namespace App\Modulos\Compras\Entidades\Fornecedor\Contatos;

use App\Modulos\Compras\Entidades\Fornecedor;
use Util\EntityCommon\IdentificadorTrait;

class Email
{
    private string $descricao;
    private string $contato;

    use IdentificadorTrait;

    private function __construct(
        private readonly string $mail,
        private readonly Fornecedor $fornecedor,
    ) {
    }

    public static function criar(string $email, Fornecedor $fornecedor): self
    {
        return new static($email, $fornecedor);
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