<?php

namespace App\Front\Controllers\Seguranca\Usuarios;

use App\Front\Controllers\AbstractController;
use App\Modulos\Seguranca\UsuarioServiceInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class Listagem extends AbstractController
{
    public function action(Request $request): Response
    {
        /** @var UsuarioServiceInterface $usuarioServico */
        $usuarioServico = $this->container->get(UsuarioServiceInterface::class);
        $usuariosListagem = $usuarioServico->obterTodos();

        $login = $this->getLoginByRequest($request);

        return $this->response('Seguranca/Usuarios/listagem.php', compact('usuariosListagem', 'login'));
    }
}