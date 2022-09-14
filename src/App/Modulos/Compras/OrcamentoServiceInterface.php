<?php

namespace App\Modulos\Compras;

use App\Modulos\Compras\Entidades\Orcamento;
use App\Modulos\Compras\Entidades\OrcamentoCollection;
use App\Modulos\Compras\Enums\Status;
use App\Modulos\RecursosHumanos\Entidades\Funcionario;

interface OrcamentoServiceInterface
{
    public function criarOrcamento(Funcionario $solicitante): Orcamento;

    public function solicitarAprovacao(Orcamento $orcamento): void;
//
//    public function aprovarOrcamento(Orcamento $orcamento, Funcionario $funcionario): void;
//
//    public function reprovarOrcamento(Orcamento $orcamento, Funcionario $funcionario): void;

    public function salvar(Orcamento $orcamento): ?Orcamento;

    public function obterPorId(int $id): ?Orcamento;

    public function obterTodos(): OrcamentoCollection;

    public function removerPorId(int $id): bool;
}