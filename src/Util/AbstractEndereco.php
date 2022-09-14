<?php

namespace Util;

use App\Modulos\Localizacoes\Entidades\Logradouro;

class AbstractEndereco
{
    private null|string $numero = null;
    private null|string $apartamento = null;
    private null|string $complemento = null;

    protected function __construct(
        private readonly string $descricao,
        private readonly Logradouro $logradouro
    ) {
    }

    public function getNumero(): ?string
    {
        return $this->numero;
    }

    public function getDescricao(): string
    {
        return $this->descricao;
    }

    public function getLogradouro(): Logradouro
    {
        return $this->logradouro;
    }

    public function setNumero(?string $numero): void
    {
        $this->numero = $numero;
    }

    public function getApartamento(): ?string
    {
        return $this->apartamento;
    }

    public function setApartamento(?string $apartamento): void
    {
        $this->apartamento = $apartamento;
    }

    public function getComplemento(): ?string
    {
        return $this->complemento;
    }

    public function setComplemento(?string $complemento): void
    {
        $this->complemento = $complemento;
    }
}