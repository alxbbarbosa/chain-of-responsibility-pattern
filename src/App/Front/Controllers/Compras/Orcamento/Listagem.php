<?php

namespace App\Front\Controllers\Compras\Orcamento;

use App\Front\Controllers\AbstractController;
use App\Modulos\Compras\OrcamentoServiceInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class Listagem extends AbstractController
{
    public function action(Request $request): Response
    {
        /** @var OrcamentoServiceInterface $orcamentoServico */
        $orcamentoServico = $this->container->get(OrcamentoServiceInterface::class);
        $orcamentos = $orcamentoServico->obterTodos();

        $login = $this->getLoginByRequest($request);

        return $this->response('Compras/Orcamento/listagem.php', compact('orcamentos', 'login'));
    }
}