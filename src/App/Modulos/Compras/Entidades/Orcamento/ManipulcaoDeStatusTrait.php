<?php

namespace App\Modulos\Compras\Entidades\Orcamento;

use App\Modulos\Compras\Entidades\Orcamento;
use App\Modulos\Compras\Enums\Status;

trait ManipulcaoDeStatusTrait
{
    protected OrcamentoStatusState $status;

    /** @throws DomainException */
    public function solicitarAprovacao(Orcamento $orcamento): void
    {
        $this->status->solicitarAprovacao($this);
    }

    /** @throws DomainException */
    public function aprovar(Orcamento $orcamento): void
    {
        $this->status->aprovar($this);
    }

    /** @throws DomainException */
    public function reprovar(Orcamento $orcamento): void
    {
        $this->status->reprovar($this);
    }

    /** @throws DomainException */
    public function cancelar(Orcamento $orcamento): void
    {
        $this->status->cancelar($this);
    }

    /** @throws DomainException */
    public function finalizar(Orcamento $orcamento): void
    {
        $this->status->finalizar($this);
    }

    public function getStatus(): Status
    {
        return $this->status->getStatus();
    }

    public function setStatus(OrcamentoStatusState $status): self
    {
        $this->status = $status;

        return $this;
    }
}