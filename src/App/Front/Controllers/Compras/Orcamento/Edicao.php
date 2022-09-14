<?php

namespace App\Front\Controllers\Compras\Orcamento;

use App\Front\Controllers\AbstractController;
use App\Modulos\Compras\OrcamentoServiceInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class Edicao extends AbstractController
{

    public function action(Request $request): Response
    {
        /** @var OrcamentoServiceInterface $orcamentoServico */
        $orcamentoServico = $this->container->get(OrcamentoServiceInterface::class);

        $orcamento = $orcamentoServico->obterPorId((int)$request->query->get('segment4'));

        $login = $this->getLoginByRequest($request);

        return $this->response('Compras/Orcamento/edicao.php', compact('orcamento', 'login'));
    }
}