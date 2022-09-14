<?php

namespace App\Modulos\Compras\Servicos\Orcamento\Processamento\ProcessoResposibility\SelecaoDeAprovadores\AprovadorResponsability;

use App\Modulos\Compras\Entidades\Orcamento;
use App\Modulos\Compras\Entidades\Orcamento\Aprovador;
use App\Modulos\Compras\Enums\NivelAprovacao;
use App\Modulos\Compras\Enums\Status;
use App\Modulos\Compras\Servicos\Orcamento\Processamento\ProcessoResposibility\SelecaoDeAprovadores\AprovadorAbstract;
use App\Modulos\RecursosHumanos\Entidades\Departamento;
use App\Modulos\RecursosHumanos\Enums\FuncoesLideranca;
use DomainException;

class PresidenteAprovador extends AprovadorAbstract
{

    public function processarOrcamento(Orcamento $orcamento): void
    {
        if ($orcamento->getStatus() !== Status::ABERTO) {
            return;
        }

        if ($orcamento->obterValorTotal() > NivelAprovacao::PRESIDENTE->value
            || ($orcamento->getAprovadores()->count() > 3)) {
            if (! $this->sucessor) {
                return;
            }

            $this->sucessor->processarOrcamento($orcamento);
        }

        $funcionario = $this->funcionarioServico->obterPorFuncaoIdEDepartamentoId(
            FuncoesLideranca::PRESIDENTE->value,
            Departamento::FINANCEIRO,
        );

        $aprovador = Aprovador::criar($funcionario, $orcamento);
        $orcamento->getAprovadores()->adicionar($aprovador);

        $orcamento->setStatus(Status::EM_APROVACAO->obterObjetoStatus());
        $this->orcamentoServico->salvar($orcamento);
    }
}