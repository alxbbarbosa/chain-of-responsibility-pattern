<?php

namespace App;

use App\Ferramentas\GeracaoElementos;
use App\Modulos\Compras\Emails\SolicitacaoAprovacao;
use App\Modulos\Compras\Entidades\Orcamento;
use App\Modulos\Compras\Entidades\Orcamento\Item;
use App\Modulos\Compras\FornecedorServiceInterface;
use App\Modulos\Compras\OrcamentoServiceInterface;
use App\Modulos\Estoque\Entidades\Produto;
use App\Modulos\Estoque\Entidades\Produto\Categoria;
use App\Modulos\Estoque\Produto\CategoriaServiceInterface;
use App\Modulos\Estoque\ProdutoServiceInterface;
use App\Modulos\Localizacoes\LogradouroServiceInterface;
use App\Modulos\Localizacoes\Servicos\CepServiceInterface;
use App\Modulos\RecursosHumanos\FuncionarioServiceInterface;
use App\Modulos\Seguranca\UsuarioServiceInterface;
use Symfony\Component\DependencyInjection\Container;

class ConsoleApplication
{
    public function __construct(
        private readonly Container $container
    )
    {
    }

    public function main(): void
    {
        /** @var UsuarioServiceInterface $usuarioServico */
        $usuarioServico = $this->container->get(UsuarioServiceInterface::class);
        $usuarios = $usuarioServico->obterPorId(1);
        var_dump($usuarios);

//        $id = (new GeracaoElementos($this->container))->criarOrcamentoNoBanco();
//
//        /** @var OrcamentoServiceInterface $orcamentoServico */
//        $orcamentoServico = $this->container->get(OrcamentoServiceInterface::class);
//        $orcamento = $orcamentoServico->obterPorId($id);

        //$total = $orcamento->obterValorTotal();
        //var_dump($total);
//        $orcamentoServico->solicitarAprovacao($orcamento);

//        /** @var CepServiceInterface $cepServico */
//        $cepServico = $this->container->get(CepServiceInterface::class);
//        $logradouro = $cepServico->obterPorCep('06693-810');
//
//        /** @var LogradouroServiceInterface $logradouroServico */
//        $logradouroServico = $this->container->get(LogradouroServiceInterface::class);
//
//        $resultado = $logradouroServico->salvar($logradouro);
//        var_dump($resultado);

//        /** @var CategoriaServiceInterface $categoriaServico */
//        $categoriaServico = $this->container->get(CategoriaServiceInterface::class);
//        $categoria = $categoriaServico->obterPorId(1);
//
//        /** @var ProdutoServiceInterface $produtoServico */
//        $produtoServico = $this->container->get(ProdutoServiceInterface::class);

//        $produto = Produto::criar('Produto Teste', $categoria);
//        $produto->detalhes()->setUnidadeMedida('Kg');
//        $produto->detalhes()->setCodigoBarras('1211131313111');
//        $produto->estoque()->setSku('12345');
//        $produtoServico->salvar($produto);
//        $produtos = $produtoServico->obterTodos();
//        var_dump($produtos);
//        $categoria = Categoria::criar('teste');
//        $categoriaService->salvar($categoria);

//        $categorias = $categoriaServico->obterTodos();
//        var_dump($categorias);

//        /** @var OrcamentoServiceInterface $orcamentoServico */
//        $orcamentoServico = $this->container->get(OrcamentoServiceInterface::class);
//        $orcamento = $orcamentoServico->obterPorId(2);
//
//        /** @var FuncionarioServiceInterface $funcionarioServico */
//        $funcionarioServico = $this->container->get(FuncionarioServiceInterface::class);
//        $funcionario = $funcionarioServico->obterPorId(22);
//
//        $orcamentoServico->solicitarAprovacao($orcamento);
//        $orcamentoServico->aprovarOrcamento($orcamentoId, $funcionarioRemetente);
//
//        echo '=======================================================================================' . PHP_EOL;
//        /** @var Item $item */
//        foreach ($orcamento->getItens() as $item) {
//            echo '   Produto: ' . $item->getProduto()->getDescricao() . PHP_EOL;
//            echo '   Valor Unitário: ' . sprintf('R$ %.2f', $item->getProduto()->getValorVenda());
//            echo '   Quantidade: ' . $item->getQuantidade();
//            echo '   Sub-total: ' . sprintf('R$ %.2f', ($item->getQuantidade() * $item->getProduto()->getValorVenda())) . PHP_EOL;
//            echo ' +-----------------------------------------------------------------------------+' . PHP_EOL;
//        }
//
//        echo PHP_EOL;
//        echo '   Valor do Orçamento: ' . $orcamento->obterValorTotal() . PHP_EOL;
//        echo '   Status: ' . $orcamento->getStatus()->toString() . PHP_EOL;
//        echo sprintf(
//                '   Aprovador: %s - %s (%s) ',
//                $orcamento->getAprovador()?->getNomeRazaoSocial(),
//                $orcamento->getAprovador()?->getDepartamento()->getNomeRazaoSocial(),
//                $orcamento->getAprovador()?->getFuncao()->getNomeRazaoSocial(),
//            ) . PHP_EOL;
//        echo '=======================================================================================' . PHP_EOL;
    }
}