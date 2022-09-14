<?php

namespace App\Modulos\Estoque\Entidades\Produto;

use App\Modulos\Estoque\Entidades\Produto\Detalhes\Embalagem;
use Util\EntityCommon\IdentificadorTrait;

class Detalhes
{
    private ?int $produtoId = null;
    private string $codigoBarras = '';
    private string $fabricante = '';
    private string $unidadeMedida = '';
    private Embalagem $embalagem;

    use IdentificadorTrait;

    public function __construct(
        private readonly string $descricao)
    {
        $this->embalagem = new Embalagem();
    }

    public function getDescricao(): string
    {
        return $this->descricao;
    }

    public function getProdutoId(): ?int
    {
        return $this->produtoId;
    }

    public function setProdutoId(?int $produtoId): void
    {
        $this->produtoId = $produtoId;
    }

    public function getCodigoBarras(): string
    {
        return $this->codigoBarras;
    }

    public function setCodigoBarras(string $codigoBarras): void
    {
        $this->codigoBarras = $codigoBarras;
    }

    public function getFabricante(): string
    {
        return $this->fabricante;
    }

    public function setFabricante(string $fabricante): void
    {
        $this->fabricante = $fabricante;
    }

    public function getUnidadeMedida(): string
    {
        return $this->unidadeMedida;
    }

    public function setUnidadeMedida(string $unidadeMedida): void
    {
        $this->unidadeMedida = $unidadeMedida;
    }

    public function embalagem(): Embalagem
    {
        return $this->embalagem;
    }

    public function setEmbalagem(Embalagem $embalagem): void
    {
        $this->embalagem = $embalagem;
    }
}