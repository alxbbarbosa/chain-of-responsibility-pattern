<?php

namespace App\Modulos\Compras\Repository;

use App\Modulos\Compras\Entidades\Orcamento\Aprovador;
use App\Modulos\Compras\Entidades\Orcamento\AprovadorCollection;
use App\Modulos\Compras\Enums\Status;
use App\Modulos\Compras\OrcamentoServiceInterface;
use App\Modulos\RecursosHumanos\FuncionarioServiceInterface;
use Infra\Config\Database;
use PDO;

class AprovadorRepository implements AprovadorRepositoryInterface
{
    private PDO $database;

    public function __construct(
        private readonly OrcamentoServiceInterface $orcamentoServico,
        private readonly FuncionarioServiceInterface $funcionarioServico,
    ) {
        $this->database = Database::getInstance();
    }

    public function salvar(Aprovador $aprovador): Aprovador
    {
        $query = $aprovador->getId() ?
            'UPDATE orcamento_aprovadores SET orcamento_id = ?, func_aprovador_id = ?, status = ? WHERE id = ?' :
            'INSERT INTO orcamento_aprovadores (orcamento_id, func_aprovador_id, status) VALUES (?, ?, ?)';

        $stmt = $this->database->prepare($query);
        $stmt->bindValue(1, $aprovador->getOrcamento()->getId());
        $stmt->bindValue(2, $aprovador->getFuncionario()->getId());
        $stmt->bindValue(3, $aprovador->getStatus());
        if ($aprovador->getId()) {
            $stmt->bindValue(4, $aprovador->getId(), PDO::PARAM_INT);
        }

        $stmt->execute();
        if (!$aprovador->getId()) {
            $aprovador->setId($this->database->lastInsertId());
        }

        return clone $aprovador;
    }

    public function obterPorId(int $id): ?Aprovador
    {
        $stmt = $this->database->prepare('SELECT * FROM orcamento_aprovadores WHERE id = ?');
        $stmt->bindParam(1, $id, PDO::PARAM_INT);

        $aprovador = null;
        if ($stmt->execute() && ($registro = $stmt->fetch(PDO::FETCH_OBJ))) {
            $aprovador = $this->obterEntidadeAprovador($registro);
        }

        return $aprovador;
    }

    public function obterTodos(): AprovadorCollection
    {
        $stmt = $this->database->prepare('SELECT * FROM orcamento_aprovadores');
        $colecao = new AprovadorCollection();
        if ($stmt->execute()) {
            while ($registro = $stmt->fetch(PDO::FETCH_OBJ)) {
                $aprovador = $this->obterEntidadeAprovador($registro);
                $colecao->adicionar($aprovador);
            }
        }

        return $colecao;
    }

    public function removerPorId(int $id): bool
    {
        $stmt = $this->database->prepare('DELETE FROM orcamento_aprovadores WHERE id = ?');
        $stmt->bindParam(1, $id, PDO::PARAM_INT);

        return $stmt->execute();
    }

    protected function obterEntidadeAprovador(mixed $registro): Aprovador
    {
        $orcamento = $this->orcamentoServico->obterPorId($registro->orcamento_id);
        $funcionario = $this->funcionarioServico->obterPorId($registro->func_aprovador_id);

        $aprovador = Aprovador::criar($funcionario, $orcamento);
        $aprovador->setId($registro->id);
        if ($registro->status) {
            $aprovador->setStatus(Status::tryFrom($registro->status));
        }
        return $aprovador;
    }
}