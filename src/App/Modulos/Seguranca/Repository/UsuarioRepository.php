<?php

namespace App\Modulos\Seguranca\Repository;

use App\Modulos\RecursosHumanos\FuncionarioServiceInterface;
use App\Modulos\Seguranca\Entidades\Usuario;
use App\Modulos\Seguranca\Entidades\UsuarioCollection;
use DateTime;
use Infra\Config\Database;
use PDO;

class UsuarioRepository implements UsuarioRepositoryInterface
{
    public function __construct(private readonly FuncionarioServiceInterface $funcionarioServico)
    {
        $this->database = Database::getInstance();
    }

    public function login(string $login, string $senha): ?int
    {
        $stmt = $this->database->prepare("SELECT id, senha FROM usuarios WHERE login = ? LIMIT 1");
        $stmt->bindParam(1, $login);

        if ($stmt->execute() && ($registro = $stmt->fetch(PDO::FETCH_OBJ))) {
            return  password_verify($senha, $registro->senha) ? $registro->id : null;
        }

        return null;
    }

    public function salvar(Usuario $usuario): Usuario
    {
        $query = $usuario->getId() ?
            "UPDATE usuarios SET login = ?, senha = ?, funcionario_id = ?, data_atualizacao = ? WHERE id = ?" :
            "INSERT INTO usuarios (login, senha, data_criacao, data_atualizacao, data_criacao) 
                VALUES (?, ?, ?, ?)";

        $nome = $usuario->getLogin();
        $id = $usuario->getId();

        $stmt = $this->database->prepare($query);
        $stmt->bindValue(1, $usuario->getLogin());
        $stmt->bindValue(2, password_hash($usuario->getSenha(), PASSWORD_DEFAULT));
        $stmt->bindValue(3, $usuario->getFuncionario()->getId());
        $stmt->bindValue(4, $usuario->getDataAtualizacao());

        if ($usuario->getId()) {
            $stmt->bindValue(5, $usuario->getId(), PDO::PARAM_INT);
        }

        if (!$usuario->getId()) {
            $stmt->bindValue(5, $usuario->getDataCriacao());
        }

        $stmt->execute();
        if (!$id) {
            $usuario->setId($this->database->lastInsertId());
        }

        return clone $usuario;
    }

    public function obterPorId(int $id): ?Usuario
    {
        $stmt = $this->database->prepare("SELECT * FROM usuarios WHERE id = ?");
        $stmt->bindParam(1, $id, PDO::PARAM_INT);

        $usuario = null;
        if ($stmt->execute() && ($registro = $stmt->fetch(PDO::FETCH_OBJ))) {
            $usuario = $this->obterEntidadeFuncionario($registro);
        }

        return $usuario;
    }

    public function obterTodos(): UsuarioCollection
    {
        $stmt = $this->database->prepare("SELECT * FROM usuarios");
        $colecao = new UsuarioCollection();
        if ($stmt->execute()) {
            while ($registro = $stmt->fetch(PDO::FETCH_OBJ)) {
                $usuario = $this->obterEntidadeFuncionario($registro);
                $colecao->adicionar($usuario);
            }
        }

        return $colecao;
    }

    public function removerPorId(int $id): bool
    {
        $stmt = $this->database->prepare("DELETE FROM usuarios WHERE id = ?");
        $stmt->bindParam(1, $id, PDO::PARAM_INT);

        return $stmt->execute();
    }

    protected function obterEntidadeFuncionario($registro): Usuario
    {
        $funcionario = $this->funcionarioServico->obterPorId($registro->funcionario_id);
        $usuario = Usuario::criar($funcionario, $registro->login, $registro->senha);
        $usuario->setId($registro->id);
        $usuario->setDataCriacao(DateTime::createFromFormat('Y-m-d H:i:s', $registro->data_criacao));
        $usuario->setDataAtualizacao(DateTime::createFromFormat('Y-m-d H:i:s', $registro->data_atualizacao));
        return $usuario;
    }
}