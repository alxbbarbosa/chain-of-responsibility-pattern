<?php

namespace App\Front\Controllers\Estoque\Produtos;

use App\Front\Controllers\AbstractController;
use App\Modulos\Estoque\ProdutoServiceInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class Listagem extends AbstractController
{
    public function action(Request $request): Response
    {
        /** @var ProdutoServiceInterface $produtoServico */
        $produtoServico = $this->container->get(ProdutoServiceInterface::class);
        $produtos = $produtoServico->obterTodos();

        $login = $this->getLoginByRequest($request);

        return $this->response('Estoque/Produtos/listagem.php', compact('produtos', 'login'));
    }
}