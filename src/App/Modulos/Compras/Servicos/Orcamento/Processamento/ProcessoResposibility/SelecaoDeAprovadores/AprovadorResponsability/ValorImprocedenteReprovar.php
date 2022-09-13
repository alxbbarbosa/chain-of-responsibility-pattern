<?php

namespace App\Modulos\Compras\Servicos\Orcamento\Processamento\ProcessoResposibility\SelecaoDeAprovadores\AprovadorResponsability;

use App\Modulos\Compras\Entidades\Orcamento;
use App\Modulos\Compras\Enums\Status;
use App\Modulos\Compras\Servicos\Orcamento\Processamento\ProcessoResposibility\SelecaoDeAprovadores\AprovadorAbstract;

class ValorImprocedenteReprovar extends AprovadorAbstract
{

    public function processarOrcamento(Orcamento $orcamento): void
    {
        if ($orcamento->getStatus() !== Status::ABERTO) {
            return;
        }

        $orcamento->setStatus(Status::REPROVADO->obterObjetoStatus());

        $this->orcamentoServico->salvar($orcamento);
    }
}