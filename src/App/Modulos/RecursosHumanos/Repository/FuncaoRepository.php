<?php

namespace App\Modulos\RecursosHumanos\Repository;

use App\Modulos\RecursosHumanos\Entidades\Funcao;
use App\Modulos\RecursosHumanos\Entidades\FuncaoCollection;
use Infra\Config\Database;
use PDO;

class FuncaoRepository implements FuncaoRepositoryInterface
{
    public function __construct() {
        $this->database = Database::getInstance();
    }

    public function salvar(Funcao $funcao): Funcao
    {
        $query = $funcao->getId() ?
            "UPDATE funcoes SET nome = ? WHERE id = ?" :
            "INSERT INTO funcoes (nome) VALUES (?)";

        $nome = $funcao->getNome();
        $id = $funcao->getId();

        $stmt = $this->database->prepare($query);
        $stmt->bindParam(1, $nome);
          if ($id) {
            $stmt->bindParam(2, $id, PDO::PARAM_INT);
        }

        $stmt->execute();
        if (!$id) {
            $funcao->setId($this->database->lastInsertId());
        }

        return clone $funcao;
    }

    public function obterPorId(int $id): ?Funcao
    {
        $stmt = $this->database->prepare("SELECT * FROM funcoes WHERE id = ?");
        $stmt->bindParam(1, $id, PDO::PARAM_INT);

        $funcao = null;
        if ($stmt->execute() && ($registro = $stmt->fetch(PDO::FETCH_OBJ))) {
            $funcao = Funcao::criar($registro->nome);
            $funcao->setId($registro->id);
        }

        return $funcao;
    }

    public function obterTodos(): FuncaoCollection
    {
        $stmt = $this->database->prepare("SELECT * FROM funcoes");
        $colecao = new FuncaoCollection();
        if ($stmt->execute()) {
            while ($registro = $stmt->fetch(PDO::FETCH_OBJ)) {
                $funcao = Funcao::criar($registro->nome);
                $funcao->setId($registro->id);

                $colecao->adicionar($funcao);
            }
        }

        return $colecao;
    }

    public function removerPorId(int $id): bool
    {
        $stmt = $this->database->prepare("DELETE FROM funcoes WHERE id = ?");
        $stmt->bindParam(1, $id, PDO::PARAM_INT);

        return $stmt->execute();
    }
}