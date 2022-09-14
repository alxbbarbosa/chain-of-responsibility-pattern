<?php

namespace App\Modulos\RecursosHumanos\Entidades;

class Funcionario
{
    private ?int $id = null;
    private ?Departamento $departamento = null;
    private ?Funcao $funcao = null;

    private function __construct(
        private readonly string $nome,
        private readonly string $email,
    ) {
    }

    public static function criar(
        string $nome,
        string $email,
    ): self {
        return new static($nome, $email);
    }

    public function getNome(): string
    {
        return $this->nome;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(?int $id): void
    {
        $this->id = $id;
    }

    public function getDepartamento(): ?Departamento
    {
        return $this->departamento;
    }

    public function setDepartamento(?Departamento $departamento): void
    {
        $this->departamento = $departamento;
    }

    public function getFuncao(): ?Funcao
    {
        return $this->funcao;
    }

    public function setFuncao(?Funcao $funcao): void
    {
        $this->funcao = $funcao;
    }
}