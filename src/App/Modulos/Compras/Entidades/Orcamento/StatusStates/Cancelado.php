<?php

namespace App\Modulos\Compras\Entidades\Orcamento\StatusStates;

use App\Modulos\Compras\Entidades\Orcamento;
use App\Modulos\Compras\Entidades\Orcamento\OrcamentoStatusState;
use App\Modulos\Compras\Enums\Status;
use DomainException;

class Cancelado extends OrcamentoStatusState
{
    public function __construct()
    {
        $this->mensagem = 'Orçamento foi cancelado';
    }

    /** @throws DomainException */
    public function finalizar(Orcamento $orcamento): void
    {
        $orcamento->setStatus(new Finalizado());
    }

    public function getStatus(): Status
    {
        return Status::CANCELADO;
    }
}