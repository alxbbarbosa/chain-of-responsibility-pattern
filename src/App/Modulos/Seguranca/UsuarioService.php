<?php

namespace App\Modulos\Seguranca;

use App\Modulos\Seguranca\Entidades\Usuario;
use App\Modulos\Seguranca\Entidades\UsuarioCollection;
use App\Modulos\Seguranca\Repository\UsuarioRepositoryInterface;

class UsuarioService implements UsuarioServiceInterface
{

    public function __construct(
        private readonly UsuarioRepositoryInterface $usuarioRepository
    ) {
    }

    public function login(string $login, string $senha): ?int
    {
        return $this->usuarioRepository->login($login, $senha);
    }

    public function salvar(Usuario $usuario): ?Usuario
    {
        return $this->usuarioRepository->salvar($usuario);
    }

    public function obterPorId(int $id): ?Usuario
    {
        return $this->usuarioRepository->obterPorId($id);
    }

    public function obterTodos(): UsuarioCollection
    {
        return $this->usuarioRepository->obterTodos();
    }

    public function removerPorId(int $id): bool
    {
        return $this->usuarioRepository->removerPorId($id);
    }
}