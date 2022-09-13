<?php

namespace App\Front\Controllers\Seguranca\Login;

use App\Front\Controllers\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Session;

class Logout extends AbstractController
{

    public function action(Request $request): Response
    {
        /** @var Session $session */
        $session = $request->getSession();
        $session->clear();
        $session->invalidate();
        $referer = $request->headers->get('referer');
        return new RedirectResponse($referer);
    }
}