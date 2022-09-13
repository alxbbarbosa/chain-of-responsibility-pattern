<?php

namespace App\Modulos\RecursosHumanos\Enums;

enum FuncoesLideranca: int
{
    case PRESIDENTE = 10;
    case DIRETOR = 9;
    case GERENTE = 8;
    case SUPERVISOR = 7;

    public function toString(): string
    {
        return match ($this) {
            self::PRESIDENTE => 'Presidente',
            self::DIRETOR => 'Diretor',
            self::GERENTE => 'Gerente',
            self::SUPERVISOR => 'Supervisor',
        };
    }
}