<?php

namespace App\Ferramentas;

use App\Modulos\Compras\Entidades\Orcamento;
use App\Modulos\Compras\FornecedorServiceInterface;
use App\Modulos\Compras\OrcamentoServiceInterface;
use App\Modulos\Estoque\ProdutoServiceInterface;
use App\Modulos\RecursosHumanos\FuncionarioServiceInterface;
use Symfony\Component\DependencyInjection\Container;

class GeracaoElementos
{
    const COMPRADOR_MARCELO = 2;
    const COMPRADOR_WILLIAN = 3;

    public function __construct(private readonly Container $container)
    {
    }

    public function criarOrcamentoNoBanco(): int
    {
        /** @var FornecedorServiceInterface $fornecedorServico */
        $fornecedorServico = $this->container->get(FornecedorServiceInterface::class);
        $fornecedor = $fornecedorServico->obterPorId(1);

        $funcionarioServico = $this->container->get(FuncionarioServiceInterface::class);
        $funcionario = $funcionarioServico->obterPorId(self::COMPRADOR_WILLIAN);

        /** @var ProdutoServiceInterface $produtoServico */
        $produtoServico = $this->container->get(ProdutoServiceInterface::class);

        /** @var OrcamentoServiceInterface $orcamentoServico */
        $orcamentoServico = $this->container->get(OrcamentoServiceInterface::class);

        $orcamento = Orcamento::criar($funcionario);

        $produto1 = $produtoServico->obterPorId(1);
        $orcamento->adicionarItem($produto1, 1);

//        $produto2 = $produtoServico->obterPorId(4);
//        $orcamento->adicionarItem($produto2, 12);
//
//        $produto3 = $produtoServico->obterPorId(6);
//        $orcamento->adicionarItem($produto3, 30);

        $orcamento->setFornecedor($fornecedor);
        $orcamentoSalvo = $orcamentoServico->salvar($orcamento);

        return $orcamentoSalvo->getId();
    }
}