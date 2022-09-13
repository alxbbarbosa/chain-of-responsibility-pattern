<?php

namespace App\Modulos\Compras\Entidades\Orcamento\StatusStates;

use App\Modulos\Compras\Entidades\Orcamento;
use App\Modulos\Compras\Entidades\Orcamento\OrcamentoStatusState;
use App\Modulos\Compras\Enums\Status;
use DomainException;

class EmAprovacao extends OrcamentoStatusState
{
    public function __construct()
    {
        $this->mensagem = 'Orçamento está em aprovação';
    }

    /** @throws DomainException */
    public function aprovar(Orcamento $orcamento): void
    {
        $orcamento->setStatus(new Aprovado());
    }

    /** @throws DomainException */
    public function reprovar(Orcamento $orcamento): void
    {
        $orcamento->setStatus(new Reprovado());
    }

    public function getStatus(): Status
    {
        return Status::EM_APROVACAO;
    }
}