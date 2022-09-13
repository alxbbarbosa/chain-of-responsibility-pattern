<?php

namespace App\Front\Controllers;

use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

abstract class AbstractController
{
    public function __construct(protected readonly ContainerInterface $container)
    {
    }

    protected function getLoginByRequest(Request $request): array
    {
        return json_decode($request->getSession()->get('login'), true);
    }

    protected function response(string $pagina, array $dados = [], int $statusCode = Response::HTTP_OK): Response
    {
        ob_start();
        extract($dados);
        include_once __DIR__ . sprintf('/../Views/%s', $pagina);
        $content = ob_get_contents();
        ob_end_clean();

        $response = (new Response())
            ->setContent($content)
            ->setCharset('UTF-8')
            ->setStatusCode($statusCode);

        $response->headers->set('Content-Type', 'text/html');

        return $response;
    }

    abstract public function action(Request $request): Response;
}