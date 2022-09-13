<?php

namespace App\Modulos\RecursosHumanos\Repository;

use App\Modulos\RecursosHumanos\DepartamentoServiceInterface;
use App\Modulos\RecursosHumanos\Entidades\Funcionario;
use App\Modulos\RecursosHumanos\Entidades\FuncionarioCollection;
use App\Modulos\RecursosHumanos\FuncaoServiceInterface;
use Infra\Config\Database;
use PDO;

class FuncionarioRepository implements FuncionarioRepositoryInterface
{
    private PDO $database;
    private DepartamentoServiceInterface $departamentoServico;
    private FuncaoServiceInterface $funcaoServico;

    public function __construct(
        DepartamentoServiceInterface $departamentoServico,
        FuncaoServiceInterface $funcaoServico
    ) {
        $this->database = Database::getInstance();
        $this->departamentoServico = $departamentoServico;
        $this->funcaoServico = $funcaoServico;
    }

    public function salvar(Funcionario $funcionario): Funcionario
    {
        $query = $funcionario->getId() ?
            "UPDATE funcionarios SET nomeRazaoSocial = ?, email = ?, departamento_id = ?, funcao_id = ? WHERE id = ?" :
            "INSERT INTO funcionarios (nomeRazaoSocial, email, departamento_id, funcao_id) VALUES (?, ?, ?, ?)";

        $nome = $funcionario->getNome();
        $email = $funcionario->getEmail();
        $departamento_id = $funcionario->getDepartamento()->getId();
        $funcao_id = $funcionario->getFuncao()->getId();
        $id = $funcionario->getId();

        $stmt = $this->database->prepare($query);
        $stmt->bindParam(1, $nome);
        $stmt->bindParam(2, $email);
        $stmt->bindParam(3, $departamento_id);
        $stmt->bindParam(4, $funcao_id);

        if ($id) {
            $stmt->bindParam(5, $id, PDO::PARAM_INT);
        }

        $stmt->execute();
        if (!$id) {
            $funcionario->setId($this->database->lastInsertId());
        }

        return clone $funcionario;
    }

    public function obterPorId(int $id): ?Funcionario
    {
        $stmt = $this->database->prepare("SELECT * FROM funcionarios WHERE id = ?");
        $stmt->bindParam(1, $id, PDO::PARAM_INT);

        $funcionario = null;
        if ($stmt->execute() && ($registro = $stmt->fetch(PDO::FETCH_OBJ))) {
            $funcionario = $this->recuperarEntidadeFuncionario($registro);
        }

        return $funcionario;
    }

    public function obterTodos(): FuncionarioCollection
    {
        $stmt = $this->database->prepare("SELECT * FROM funcionarios");
        $colecao = new FuncionarioCollection();
        if ($stmt->execute()) {
            while ($registro = $stmt->fetch(PDO::FETCH_OBJ)) {
                $funcionario = $this->recuperarEntidadeFuncionario($registro);
                $colecao->adicionar($funcionario);
            }
        }

        return $colecao;
    }

    public function removerPorId(int $id): bool
    {
        $stmt = $this->database->prepare("DELETE FROM funcionarios WHERE id = ?");
        $stmt->bindParam(1, $id, PDO::PARAM_INT);

        return $stmt->execute();
    }

    public function obterPorFuncaoIdEDepartamentoId(int $funcaoId, int $departamentoId): ?Funcionario
    {
        $stmt = $this->database
            ->prepare("SELECT * FROM funcionarios WHERE funcao_id = ? AND departamento_id = ?");
        $stmt->bindParam(1, $funcaoId, PDO::PARAM_INT);
        $stmt->bindParam(2, $departamentoId, PDO::PARAM_INT);

        $funcionario = null;
        if ($stmt->execute() && ($registro = $stmt->fetch(PDO::FETCH_OBJ))) {
            $funcionario = $this->recuperarEntidadeFuncionario($registro);
        }

        return $funcionario;
    }

    protected function recuperarEntidadeFuncionario(mixed $registro): Funcionario
    {
        $funcionario = Funcionario::criar($registro->nome, $registro->email);
        $funcionario->setId($registro->id);
        if ($registro->departamento_id) {
            $departamento = $this->departamentoServico->obterPorId($registro->departamento_id);
            $funcionario->setDepartamento($departamento);
        }

        if ($registro->funcao_id) {
            $funcao = $this->funcaoServico->obterPorId($registro->funcao_id);
            $funcionario->setFuncao($funcao);
        }

        return $funcionario;
    }
}