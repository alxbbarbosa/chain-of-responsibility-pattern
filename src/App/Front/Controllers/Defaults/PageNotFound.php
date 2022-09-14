<?php

namespace App\Front\Controllers\Defaults;

use App\Front\Controllers\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class PageNotFound extends AbstractController
{

    public function action(Request $request): Response
    {
        return $this->response('Defaults/page_not_found.php');
    }
}