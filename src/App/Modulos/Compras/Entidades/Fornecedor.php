<?php

namespace App\Modulos\Compras\Entidades;

use App\Modulos\Compras\Entidades\Fornecedor\Contatos;
use App\Modulos\Compras\Entidades\Fornecedor\Contatos\EnderecoCollection;
use Util\EntityCommon\IdentificadorTrait;

class Fornecedor
{
    private ?string $nomeFantasia = null;
    private EnderecoCollection $enderecoCollection;
    private Contatos $contatos;

    use IdentificadorTrait;
    private function __construct(
        private readonly string $razaoSocial,
        private ?string $cnpj = null,
    ) {
        $this->enderecoCollection = new EnderecoCollection();
        $this->contatos = new Contatos();
    }

    public static function criar(string $nome, string $telefone): self
    {
        return new static($nome, $telefone);
    }

    public function getRazaoSocial(): string
    {
        return $this->razaoSocial;
    }

    public function getCnpj(): ?string
    {
        return $this->cnpj;
    }

    public function getNomeFantasia(): ?string
    {
        return $this->nomeFantasia;
    }

    public function setNomeFantasia(?string $nomeFantasia): void
    {
        $this->nomeFantasia = $nomeFantasia;
    }

    public function enderecos(): EnderecoCollection
    {
        return $this->enderecoCollection;
    }

    public function getContatos(): Contatos
    {
        return $this->contatos;
    }
}