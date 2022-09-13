<?php

namespace App\Modulos\Compras\Entidades\Orcamento\StatusStates;

use App\Modulos\Compras\Entidades\Orcamento\OrcamentoStatusState;
use App\Modulos\Compras\Enums\Status;

class Finalizado extends OrcamentoStatusState
{
    public function __construct()
    {
        $this->mensagem = 'Orçamento já foi Finalizado';
    }

    public function getStatus(): Status
    {
        return Status::FINALIZADO;
    }
}