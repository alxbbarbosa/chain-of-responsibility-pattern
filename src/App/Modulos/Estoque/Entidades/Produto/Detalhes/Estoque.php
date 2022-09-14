<?php

namespace App\Modulos\Estoque\Entidades\Produto\Detalhes;

class Estoque
{
    private string $sku = '';
    private int $nivelAtual = 0;
    private int $nivelMinimo = 0;

    public function getSku(): string
    {
        return $this->sku;
    }

    public function setSku(string $sku): void
    {
        $this->sku = $sku;
    }

    public function getNivelAtual(): int
    {
        return $this->nivelAtual;
    }

    public function setNivelAtual(int $nivelAtual): void
    {
        $this->nivelAtual = $nivelAtual;
    }

    public function getNivelMinimo(): int
    {
        return $this->nivelMinimo;
    }

    public function setNivelMinimo(int $nivelMinimo): void
    {
        $this->nivelMinimo = $nivelMinimo;
    }
}