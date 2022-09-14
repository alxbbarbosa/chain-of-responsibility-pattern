<?php

namespace App\Modulos\RecursosHumanos\Repository;

use App\Modulos\RecursosHumanos\Entidades\Departamento;
use App\Modulos\RecursosHumanos\Entidades\DepartamentoCollection;
use App\Modulos\RecursosHumanos\Entidades\Funcao;
use Infra\Config\Database;
use PDO;

class DepartamentoRepository implements DepartamentoRepositoryInterface
{
    public function __construct() {
        $this->database = Database::getInstance();
    }

    public function salvar(Departamento $departamento): Departamento
    {
        $query = $departamento->getId() ?
            "UPDATE departamentos SET nomeRazaoSocial = ? WHERE id = ?" :
            "INSERT INTO departamentos (nomeRazaoSocial) VALUES (?)";

        $nome = $departamento->getNome();
        $id = $departamento->getId();

        $stmt = $this->database->prepare($query);
        $stmt->bindParam(1, $nome);

        if ($id) {
            $stmt->bindParam(5, $id, PDO::PARAM_INT);
        }

        $stmt->execute();
        if (!$id) {
            $departamento->setId($this->database->lastInsertId());
        }

        return clone $departamento;
    }

    public function obterPorId(int $id): ?Departamento
    {
        $stmt = $this->database->prepare("SELECT * FROM departamentos WHERE id = ?");
        $stmt->bindParam(1, $id, PDO::PARAM_INT);

        $departamento = null;
        if ($stmt->execute() && ($registro = $stmt->fetch(PDO::FETCH_OBJ))) {
            $departamento = Departamento::criar($registro->nome);
            $departamento->setId($registro->id);
        }

        return $departamento;
    }

    public function obterTodos(): DepartamentoCollection
    {
        $stmt = $this->database->prepare("SELECT * FROM departamentos");
        $colecao = new DepartamentoCollection();
        if ($stmt->execute()) {
            while ($registro = $stmt->fetch(PDO::FETCH_OBJ)) {
                $departamento = Departamento::criar($registro->nome);
                $departamento->setId($registro->id);

                $colecao->adicionar($departamento);
            }
        }

        return $colecao;
    }

    public function removerPorId(int $id): bool
    {
        $stmt = $this->database->prepare("DELETE FROM departamentos WHERE id = ?");
        $stmt->bindParam(1, $id, PDO::PARAM_INT);

        return $stmt->execute();
    }
}