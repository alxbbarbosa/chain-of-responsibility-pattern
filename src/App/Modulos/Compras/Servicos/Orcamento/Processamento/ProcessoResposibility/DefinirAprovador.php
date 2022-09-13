<?php

namespace App\Modulos\Compras\Servicos\Orcamento\Processamento\ProcessoResposibility;

use App\Modulos\Compras\Entidades\Orcamento;
use App\Modulos\Compras\Enums\Status;
use App\Modulos\Compras\Servicos\Orcamento\Processamento\ProcessoAbstract;
use App\Modulos\Compras\Servicos\Orcamento\Processamento\ProcessoResposibility\SelecaoDeAprovadores\AprovadorResponsability\DiretorAprovador;
use App\Modulos\Compras\Servicos\Orcamento\Processamento\ProcessoResposibility\SelecaoDeAprovadores\AprovadorResponsability\GerenteAprovador;
use App\Modulos\Compras\Servicos\Orcamento\Processamento\ProcessoResposibility\SelecaoDeAprovadores\AprovadorResponsability\PresidenteAprovador;
use App\Modulos\Compras\Servicos\Orcamento\Processamento\ProcessoResposibility\SelecaoDeAprovadores\AprovadorResponsability\SupervisorAprovador;
use App\Modulos\Compras\Servicos\Orcamento\Processamento\ProcessoResposibility\SelecaoDeAprovadores\AprovadorResponsability\ValorImprocedenteReprovar;
use App\Modulos\RecursosHumanos\FuncionarioServiceInterface;

class DefinirAprovador extends ProcessoAbstract
{

    public function processarOrcamento(Orcamento $orcamento): void
    {
        if (! $orcamento->getAprovador() || $orcamento->getStatus() === Status::ABERTO) {
            $aprovadores = new SupervisorAprovador($this->container);
            $aprovadores
                ->setSucessor(new GerenteAprovador($this->container))
                ->setSucessor(new DiretorAprovador($this->container))
                ->setSucessor(new PresidenteAprovador($this->container))
                ->setSucessor(new ValorImprocedenteReprovar($this->container));

            $aprovadores->processarOrcamento($orcamento);
        }

        if (! $this->processoSucessor) {
            return;
        }
        $this->processoSucessor->processarOrcamento($orcamento);
    }
}