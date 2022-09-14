<?php

namespace App\Front\Controllers\Home;

use App\Front\Controllers\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class Page extends AbstractController
{
    public function action(Request $request): Response
    {

        $login = $this->getLoginByRequest($request);

        return $this->response('Home/page.php', compact('login'));
    }
}