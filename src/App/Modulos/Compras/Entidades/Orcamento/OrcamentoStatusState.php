<?php

namespace App\Modulos\Compras\Entidades\Orcamento;

use App\Modulos\Compras\Entidades\Orcamento;
use App\Modulos\Compras\Enums\Status;
use DomainException;

abstract class OrcamentoStatusState
{
    protected string $mensagem = '';

    /** @throws DomainException */
    public function solicitarAprovacao(Orcamento $orcamento): void
    {
        throw new DomainException(sprintf('Esta solicitação não pode ser realizada: %s', $this->mensagem));
    }

    /** @throws DomainException */
    public function aprovar(Orcamento $orcamento): void
    {
        throw new DomainException(sprintf('Este orçamento não pode ser aprovado: %s', $this->mensagem));
    }

    /** @throws DomainException */
    public function reprovar(Orcamento $orcamento): void
    {
        throw new DomainException(sprintf('Este orçamento não pode ser reprovado: %s', $this->mensagem));
    }

    /** @throws DomainException */
    public function cancelar(Orcamento $orcamento): void
    {
        throw new DomainException(sprintf('Este orçamento não pode ser cancelado: %s', $this->mensagem));
    }

    /** @throws DomainException */
    public function finalizar(Orcamento $orcamento): void
    {
        throw new DomainException(sprintf('Este orçamento não pode ser finalizar: %s', $this->mensagem));
    }

    abstract public function getStatus(): Status;
}