<?php

namespace App\Modulos\Compras\Servicos\Orcamento\Processamento;

use App\Modulos\Compras\Entidades\Orcamento;
use Symfony\Component\DependencyInjection\ContainerInterface;

abstract class ProcessoAbstract
{
    protected ?ProcessoAbstract $processoSucessor = null;

    public function __construct(
        protected readonly ?ContainerInterface $container = null,
    ) {
    }

    public function setProcessoSucessor(ProcessoAbstract $processoSucessor): ProcessoAbstract
    {
        $this->processoSucessor = $processoSucessor;
        return $processoSucessor;
    }

    public abstract function processarOrcamento(Orcamento $orcamento): void;
}