<?php

namespace App\Modulos\Compras\Entidades\Orcamento;

use App\Modulos\Compras\Entidades\Orcamento;
use App\Modulos\Compras\Enums\Status;
use App\Modulos\RecursosHumanos\Entidades\Funcionario;
use Util\EntityCommon\IdentificadorTrait;

class Aprovador
{
    private ?Status $status = null;

    use IdentificadorTrait;

    private function __construct(
        private readonly Funcionario $funcionario,
        private readonly Orcamento $orcamento,
    ) {
    }

    public static function criar(Funcionario $funcionario, $orcamento): self
    {
        return new static($funcionario, $orcamento);
    }

    public function getFuncionario(): Funcionario
    {
        return $this->funcionario;
    }

    public function getOrcamento(): Orcamento
    {
        return $this->orcamento;
    }

    public function getStatus(): ?Status
    {
        return $this->status;
    }

    public function setStatus(?Status $status): void
    {
        $this->status = $status;
    }
}