<?php

namespace App\Modulos\Comercial\Entidades;

use App\Modulos\Comercial\Entidades\Cliente\Contatos;
use App\Modulos\Comercial\Entidades\Cliente\Contatos\EnderecoCollection;
use Util\EntityCommon\IdentificadorTrait;

class Cliente
{
    private ?string $nomeFantasia = null;
    private EnderecoCollection $enderecoCollection;
    private Contatos $contatos;

    use IdentificadorTrait;
    private function __construct(
        private readonly string $nomeRazaoSocial,
        private ?string         $cnpjCpf = null,
    ) {
        $this->enderecoCollection = new EnderecoCollection();
        $this->contatos = new Contatos();
    }

    public static function criar(string $nome, string $telefone): self
    {
        return new static($nome, $telefone);
    }

    public function getNomeRazaoSocial(): string
    {
        return $this->nomeRazaoSocial;
    }

    public function getCnpjCpf(): ?string
    {
        return $this->cnpjCpf;
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