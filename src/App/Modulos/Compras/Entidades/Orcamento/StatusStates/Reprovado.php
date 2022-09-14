<?php

namespace App\Modulos\Compras\Entidades\Orcamento\StatusStates;

use App\Modulos\Compras\Entidades\Orcamento;
use App\Modulos\Compras\Entidades\Orcamento\OrcamentoStatusState;
use App\Modulos\Compras\Enums\Status;
use DomainException;

class Reprovado extends OrcamentoStatusState
{
    public function __construct()
    {
        $this->mensagem = 'Orçamento está reprovado';
    }

    /** @throws DomainException */
    public function finalizar(Orcamento $orcamento): void
    {
        $orcamento->setStatus(new Finalizado());
    }

    public function getStatus(): Status
    {
        return Status::REPROVADO;
    }
}