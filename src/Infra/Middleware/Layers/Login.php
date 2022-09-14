<?php

namespace Infra\Middleware\Layers;

use App\Front\Controllers\Seguranca\Login\ApresentacaoTela;
use App\Modulos\Seguranca\UsuarioServiceInterface;
use Infra\Middleware\AbstractMiddleware;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Session;

class Login extends AbstractMiddleware
{

    public function handle(Request $request): Response
    {
        if ($request->getMethod() === 'POST'
            && $request->request->has('usuario')
            && $request->request->has('senha')) {
            /** @var UsuarioServiceInterface $usuarioServico */
            $usuarioServico = $this->container->get(UsuarioServiceInterface::class);
            $session = $request->getSession();
            $usuarioId = $usuarioServico->login($request->request->get('usuario'), $request->request->get('senha'));
            if ($usuarioId) {
                $usuario = $usuarioServico->obterPorId($usuarioId);
                $session->set('login', json_encode([
                    'usuario' => $request->request->get('usuario'),
                    'entidade' => serialize($usuario),
                    'datetime' => date('Y-m-d H:i:s'),
                ]));

                $referer = $request->headers->get('referer');
                return new RedirectResponse($referer);
            }

            $session->getFlashBag()->add('aviso', 'Usuário ou senha inválido');
        }

        if (! $request->getSession()->has('login') || $request->getSession()->get('login') === false) {
            $controller = new ApresentacaoTela($this->container);
            return $controller->action($request);
        }

        return $this->next->handle($request);
    }
}