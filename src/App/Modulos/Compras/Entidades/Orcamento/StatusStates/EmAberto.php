<?php

namespace App\Modulos\Compras\Entidades\Orcamento\StatusStates;

use App\Modulos\Compras\Entidades\Orcamento;
use App\Modulos\Compras\Entidades\Orcamento\OrcamentoStatusState;
use App\Modulos\Compras\Enums\Status;
use DomainException;

class EmAberto extends OrcamentoStatusState
{
    public function __construct()
    {
        $this->mensagem = 'Orçamento não enviado para aprovação';
    }

    /** @throws DomainException */
    public function solicitarAprovacao(Orcamento $orcamento): void
    {
        $orcamento->setStatus(new EmAprovacao());
    }

    /** @throws DomainException */
    public function cancelar(Orcamento $orcamento): void
    {
        $orcamento->setStatus(new Cancelado());
    }

    public function getStatus(): Status
    {
        return Status::ABERTO;
    }
}