<?php

namespace App\Modulos\Compras\Entidades\Orcamento\StatusStates;

use App\Modulos\Compras\Entidades\Orcamento;
use App\Modulos\Compras\Entidades\Orcamento\OrcamentoStatusState;
use App\Modulos\Compras\Enums\Status;
use DomainException;

class Aprovado extends OrcamentoStatusState
{
    public function __construct()
    {
        $this->mensagem = 'Orçamento está aprovado';
    }

    /** @throws DomainException */
    public function cancelar(Orcamento $orcamento): void
    {
        $orcamento->setStatus(new Cancelado());
    }

    public function getStatus(): Status
    {
        return Status::APROVADO;
    }
}