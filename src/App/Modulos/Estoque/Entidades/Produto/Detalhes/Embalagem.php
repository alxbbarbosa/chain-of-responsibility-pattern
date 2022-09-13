<?php

namespace App\Modulos\Estoque\Entidades\Produto\Detalhes;

class Embalagem
{
    private float $peso = 0.0;
    private float $dimensaoAltura = 0.0;
    private float $dimensaoLargura = 0.0;
    private float $dimensaoProfundidade = 0.0;

    public function getPeso(): float
    {
        return $this->peso;
    }

    public function setPeso(float $peso): void
    {
        $this->peso = $peso;
    }

    public function getDimensaoAltura(): float
    {
        return $this->dimensaoAltura;
    }

    public function setDimensaoAltura(float $dimensaoAltura): void
    {
        $this->dimensaoAltura = $dimensaoAltura;
    }

    public function getDimensaoLargura(): float
    {
        return $this->dimensaoLargura;
    }

    public function setDimensaoLargura(float $dimensaoLargura): void
    {
        $this->dimensaoLargura = $dimensaoLargura;
    }

    public function getDimensaoProfundidade(): float
    {
        return $this->dimensaoProfundidade;
    }

    public function setDimensaoProfundidade(float $dimensaoProfundidade): void
    {
        $this->dimensaoProfundidade = $dimensaoProfundidade;
    }
}