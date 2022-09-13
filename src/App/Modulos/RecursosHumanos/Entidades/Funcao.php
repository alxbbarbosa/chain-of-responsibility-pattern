<?php

namespace App\Modulos\RecursosHumanos\Entidades;

class Funcao
{
    private ?int $id;

    private function __construct(
        private readonly string $nome
    ) {
    }

    public static function criar(string $nome): self
    {
        return new static($nome);
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(?int $id): void
    {
        $this->id = $id;
    }

    public function getNome(): string
    {
        return $this->nome;
    }
}