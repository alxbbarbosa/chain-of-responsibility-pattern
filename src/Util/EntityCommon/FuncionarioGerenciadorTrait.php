<?php

namespace Util\EntityCommon;

use App\Modulos\RecursosHumanos\Entidades\Funcionario;

trait FuncionarioGerenciadorTrait
{
    private ?Funcionario $funcionarioCriacao = null;
    private ?Funcionario $funcionarioAtualizacao = null;

    public function getFuncionarioCriacao(): ?Funcionario
    {
        return $this->funcionarioCriacao;
    }

    public function setFuncionarioCriacao(?Funcionario $funcionarioCriacao): void
    {
        $this->funcionarioCriacao = $funcionarioCriacao;
    }

    public function getFuncionarioAtualizacao(): ?Funcionario
    {
        return $this->funcionarioAtualizacao;
    }

    public function setFuncionarioAtualizacao(?Funcionario $funcionarioAtualizacao): void
    {
        $this->funcionarioAtualizacao = $funcionarioAtualizacao;
    }
}