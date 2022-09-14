<?php

declare(strict_types=1);

namespace App\Front\Controllers\Compras\Orcamento;

use App\Front\Controllers\AbstractController;
use App\Modulos\Compras\OrcamentoServiceInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class Aprovacao extends AbstractController
{

    public function action(Request $request): Response
    {
        /** @var OrcamentoServiceInterface $orcamentoServico */
        $orcamentoServico = $this->container->get(OrcamentoServiceInterface::class);
        $orcamento = $orcamentoServico->obterPorId((int)$request->query->get('segment4'));
        $orcamentoServico->solicitarAprovacao($orcamento);

        return $this->redirectBackFrom($request);
    }
}