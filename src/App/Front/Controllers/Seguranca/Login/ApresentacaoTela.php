<?php

namespace App\Front\Controllers\Seguranca\Login;

use App\Front\Controllers\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class ApresentacaoTela extends AbstractController
{

    public function action(Request $request): Response
    {
        return $this->response('Seguranca/login.php');
    }
}