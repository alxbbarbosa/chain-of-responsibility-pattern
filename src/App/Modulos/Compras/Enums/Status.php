<?php

namespace App\Modulos\Compras\Enums;

use App\Modulos\Compras\Entidades\Orcamento\OrcamentoStatusState;
use App\Modulos\Compras\Entidades\Orcamento\StatusStates\Aprovado;
use App\Modulos\Compras\Entidades\Orcamento\StatusStates\Cancelado;
use App\Modulos\Compras\Entidades\Orcamento\StatusStates\EmAberto;
use App\Modulos\Compras\Entidades\Orcamento\StatusStates\EmAprovacao;
use App\Modulos\Compras\Entidades\Orcamento\StatusStates\Finalizado;
use App\Modulos\Compras\Entidades\Orcamento\StatusStates\Reprovado;

enum Status : int
{
    case ABERTO = 1;
    case EM_APROVACAO = 2;
    case APROVADO = 3;
    case REPROVADO = 4;
    case CANCELADO = 5;
    case FINALIZADO = 6;

    public function toString(): string
    {
        return match ($this) {
            self::ABERTO => 'aberto',
            self::EM_APROVACAO => 'em aprovação',
            self::APROVADO => 'aprovado',
            self::REPROVADO => 'reprovado',
            self::CANCELADO => 'cancelado',
            self::FINALIZADO => 'finalizado',
        };
    }

    public function obterObjetoStatus(): OrcamentoStatusState
    {
        return match ($this) {
            self::ABERTO => new EmAberto(),
            self::EM_APROVACAO => new EmAprovacao(),
            self::APROVADO => new Aprovado(),
            self::REPROVADO => new Reprovado(),
            self::CANCELADO => new Cancelado(),
            self::FINALIZADO => new Finalizado(),
        };
    }
}