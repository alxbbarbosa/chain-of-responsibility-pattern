<?php

namespace App\Modulos\Seguranca;

use App\Modulos\Seguranca\Entidades\Usuario;
use App\Modulos\Seguranca\Entidades\UsuarioCollection;

interface UsuarioServiceInterface
{
    public function login(string $login, string $senha): ?int;

    public function salvar(Usuario $usuario): ?Usuario;

    public function obterPorId(int $id): ?Usuario;

    public function obterTodos(): UsuarioCollection;

    public function removerPorId(int $id): bool;
}