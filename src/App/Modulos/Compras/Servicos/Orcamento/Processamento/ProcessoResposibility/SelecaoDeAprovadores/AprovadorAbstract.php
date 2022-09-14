<?php

namespace App\Modulos\Compras\Servicos\Orcamento\Processamento\ProcessoResposibility\SelecaoDeAprovadores;

use App\Modulos\Compras\Entidades\Orcamento;
use App\Modulos\Compras\OrcamentoServiceInterface;
use App\Modulos\Compras\Servicos\Orcamento\AprovadorServiceInterface;
use App\Modulos\RecursosHumanos\FuncionarioServiceInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

abstract class AprovadorAbstract
{
    protected ?AprovadorAbstract $sucessor = null;
    protected ?FuncionarioServiceInterface $funcionarioServico = null;
    protected ?OrcamentoServiceInterface $orcamentoServico = null;

    public function __construct(ContainerInterface $container)
    {
        $this->funcionarioServico = $container->get(FuncionarioServiceInterface::class);
        $this->orcamentoServico = $container->get(OrcamentoServiceInterface::class);
        $this->aprovadorServico = $container->get(AprovadorServiceInterface::class);
    }

    public function setSucessor(AprovadorAbstract $sucessor): AprovadorAbstract
    {
        $this->sucessor = $sucessor;
        return $sucessor;
    }

    public abstract function processarOrcamento(Orcamento $orcamento): void;
}