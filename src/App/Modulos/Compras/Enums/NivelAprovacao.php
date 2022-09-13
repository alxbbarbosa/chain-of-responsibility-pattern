<?php

namespace App\Modulos\Compras\Enums;

enum NivelAprovacao: int
{
    case LIDERADO = 0;
    case SUPERVISOR = 10000;
    case GERENTE = 100000;
    case DIRETOR = 250000;
    case PRESIDENTE = 1000000;

    public function toString(): string
    {
        return match ($this) {
            self::LIDERADO => 'liderado',
            self::SUPERVISOR => 'supervisor',
            self::GERENTE => 'gerente',
            self::DIRETOR => 'diretor',
            self::PRESIDENTE => 'presidente',
        };
    }
}