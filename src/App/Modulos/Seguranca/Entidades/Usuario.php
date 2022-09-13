<?php

namespace App\Modulos\Seguranca\Entidades;

use App\Modulos\RecursosHumanos\Entidades\Funcionario;
use Util\EntityCommon\IdentificadorTrait;
use Util\EntityCommon\TimestampTrait;

class Usuario
{
    use IdentificadorTrait, TimestampTrait;

    public function __construct(
        private Funcionario $funcionario,
        private string $login,
        private string $senha
    ) {
    }

    public static function criar(Funcionario $funcionario, string $login, string $senha): self
    {
        return new static($funcionario, $login, $senha);
    }

    public function getLogin(): string
    {
        return $this->login;
    }

    public function getSenha(): string
    {
        return $this->senha;
    }

    public function getFuncionario(): Funcionario
    {
        return $this->funcionario;
    }

    public function setFuncionario(Funcionario $funcionario): void
    {
        $this->funcionario = $funcionario;
    }
}