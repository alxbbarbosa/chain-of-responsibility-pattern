<?php

namespace App\Modulos\Estoque\Repository\Produto;

use App\Modulos\Estoque\Entidades\Produto\Categoria;
use App\Modulos\Estoque\Entidades\Produto\CategoriaCollection;
use Infra\Config\Database;
use PDO;

class CategoriaRepository implements CategoriaRepositoryInterface
{

    public function __construct() {
        $this->database = Database::getInstance();
    }

    public function salvar(Categoria $categoria): Categoria
    {
        $query = $categoria->getId() ?
            "UPDATE categorias SET descricao = ? WHERE id = ?" :
            "INSERT INTO categorias (descricao) VALUES (?)";

        $nome = $categoria->getDescricao();
        $id = $categoria->getId();
        $stmt = $this->database->prepare($query);
        $stmt->bindParam(1, $nome);

        if ($id) {
            $stmt->bindParam(5, $id, PDO::PARAM_INT);
        }

        $stmt->execute();
        if (!$id) {
            $categoria->setId($this->database->lastInsertId());
        }

        return clone $categoria;
    }

    public function obterPorId(int $id): ?Categoria
    {
        $stmt = $this->database->prepare("SELECT * FROM categorias WHERE id = ?");
        $stmt->bindParam(1, $id, PDO::PARAM_INT);

        $categoria = null;
        if ($stmt->execute() && ($registro = $stmt->fetch(PDO::FETCH_OBJ))) {
            $categoria = Categoria::criar($registro->descricao);
            $categoria->setId($registro->id);
        }

        return $categoria;
    }

    public function obterTodos(): CategoriaCollection
    {
        $stmt = $this->database->prepare("SELECT * FROM categorias");
        $colecao = new CategoriaCollection();
        if ($stmt->execute()) {
            while ($registro = $stmt->fetch(PDO::FETCH_OBJ)) {
                $categoria = Categoria::criar($registro->descricao);
                $categoria->setId($registro->id);

                $colecao->adicionar($categoria);
            }
        }

        return $colecao;
    }

    public function removerPorId(int $id): bool
    {
        $stmt = $this->database->prepare("DELETE FROM categorias WHERE id = ?");
        $stmt->bindParam(1, $id, PDO::PARAM_INT);

        return $stmt->execute();
    }
}