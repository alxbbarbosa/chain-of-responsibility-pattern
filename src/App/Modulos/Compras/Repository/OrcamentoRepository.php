<?php

namespace App\Modulos\Compras\Repository;

use App\Modulos\Compras\Entidades\Orcamento;
use App\Modulos\Compras\Entidades\Orcamento\Aprovador;
use App\Modulos\Compras\Entidades\Orcamento\AprovadorCollection;
use App\Modulos\Compras\Entidades\Orcamento\Item;
use App\Modulos\Compras\Entidades\Orcamento\ItemCollection;
use App\Modulos\Compras\Entidades\OrcamentoCollection;
use App\Modulos\Compras\Enums\Status;
use App\Modulos\Compras\FornecedorServiceInterface;
use App\Modulos\Estoque\ProdutoServiceInterface;
use App\Modulos\RecursosHumanos\FuncionarioServiceInterface;
use DateTime;
use Exception;
use Infra\Config\Database;
use PDO;
use Throwable;

class OrcamentoRepository implements OrcamentoRepositoryInterface
{
    private FuncionarioServiceInterface $funcionarioServico;
    private FornecedorServiceInterface $fornecedorServico;
    private ProdutoServiceInterface $produtoServico;

    public function __construct(
        FuncionarioServiceInterface $funcionarioServico,
        FornecedorServiceInterface $fornecedorServico,
        ProdutoServiceInterface $produtoServico,
    ) {
        $this->database = Database::getInstance();
        $this->funcionarioServico = $funcionarioServico;
        $this->fornecedorServico = $fornecedorServico;
        $this->produtoServico = $produtoServico;
    }

    public function salvar(Orcamento $orcamento): ?Orcamento
    {
        try {
            $this->database->query('BEGIN TRANSACTION');

            $query = $orcamento->getId() ?
                "UPDATE orcamentos 
                SET status = ?,
                    func_solicitante_id = ?,
                    func_requisitante_id = ?,
                    fornecedor_id = ?,
                    func_aprovador_id = ?,
                    data_aprovacao = ?,
                    data_reprovacao = ?,
                    observacoes = ?,
                    dias_previsto_entrega = ?,
                    condicoes_pagamento = ?,
                    data_atualizacao = ?
                WHERE id = ?" :
                "INSERT INTO orcamentos (
                        status,
                        func_solicitante_id,
                        func_requisitante_id,
                        fornecedor_id,
                        func_aprovador_id,
                        data_aprovacao,
                        data_reprovacao,
                        observacoes,
                        dias_previsto_entrega,
                        condicoes_pagamento,
                        data_atualizacao,
                        data_criacao
                    ) 
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

            $data_atual = date('Y-m-d H:i:s');
            $stmt = $this->database->prepare($query);
            $stmt->bindValue(1, $orcamento->getStatus()->value);
            $stmt->bindValue(2, $orcamento->getSolicitante()->getId());
            $stmt->bindValue(3, $orcamento->getRequisitante()?->getId());
            $stmt->bindValue(4, $orcamento->getFornecedor()?->getId());
            $stmt->bindValue(5, $orcamento->getAprovador()?->getId());
            $stmt->bindValue(6, $orcamento->getDataAprovacao()?->format('Y-m-d H:i:s'));
            $stmt->bindValue(7, $orcamento->getDataReprovacao()?->format('Y-m-d H:i:s'));
            $stmt->bindValue(8, $orcamento->getObservacoes());
            $stmt->bindValue(9, $orcamento->getDiasPrevistoEntrega());
            $stmt->bindValue(10, $orcamento->getCondicoesPagamento());
            $stmt->bindValue(11, $data_atual);

            if (!$orcamento->getId()) {
                $stmt->bindValue(12, $data_atual);
            }

            if ($orcamento->getId()) {
                $stmt->bindValue(12, $orcamento->getId(), PDO::PARAM_INT);
            }

            if ($stmt->execute()) {
                $this->salvarItensEmOrcamento($orcamento);
                $this->salvarAprovadoresEmOrcamento($orcamento);
            }
            $this->database->query('COMMIT');

            return clone $orcamento;
        } catch (Throwable $throwable) {
            $this->database->query('ROLLBACK');
        }

        return null;
    }

    protected function salvarItensEmOrcamento(Orcamento $orcamento): void
    {
        if ($orcamento->getId()) {
            $stmtDelete = $this->database->prepare('DELETE FROM orcamento_itens WHERE orcamento_id = ?');
            $stmtDelete->bindValue(1, $orcamento->getId(), PDO::PARAM_INT);
            $stmtDelete->execute();
        }

        if (! $orcamento->getId()) {
            $orcamento->setId($this->database->lastInsertId());
        }

        if ($orcamento->getId()) {
            $itens = $orcamento->getItens();
            if ($itens->count() > 0) {
                $queryItens =
                    'INSERT INTO orcamento_itens (orcamento_id, produto_id, quantidade, valor_unitario) VALUES ' .
                    str_repeat('(?, ?, ?, ?),', $itens->count() - 1) . '(?, ?, ?, ?)';
                $stmtItens = $this->database->prepare($queryItens);
                /** @var Item $item */
                $posicao = 1;
                foreach ($itens as $item) {
                    $stmtItens->bindValue($posicao++, $orcamento->getId(), PDO::PARAM_INT);
                    $stmtItens->bindValue($posicao++, $item->getProduto()->getId(), PDO::PARAM_INT);
                    $stmtItens->bindValue($posicao++, $item->getQuantidade(), PDO::PARAM_INT);
                    $stmtItens->bindValue($posicao++, max($item->getProduto()->getValorVenda(), $item->getValorUnitario()));
                }
                if ($stmtItens->execute()) {
                    $itemColecao = $this->obterColecaoItensDeOrcamento($orcamento->getId());
                    $orcamento->setItens($itemColecao);
                }
            }
        }
    }

    protected function salvarAprovadoresEmOrcamento(Orcamento $orcamento): void
    {
        if ($orcamento->getId()) {
            $stmtDelete = $this->database->prepare('DELETE FROM orcamento_aprovadores WHERE orcamento_id = ?');
            $stmtDelete->bindValue(1, $orcamento->getId(), PDO::PARAM_INT);
            $stmtDelete->execute();
        }

        if (! $orcamento->getId()) {
            $orcamento->setId($this->database->lastInsertId());
        }

        if ($orcamento->getId()) {
            $aprovadores = $orcamento->getAprovadores();
            if ($aprovadores->count() > 0) {
                $queryAprovadores =
                    'INSERT INTO orcamento_aprovadores (orcamento_id, func_aprovador_id, status) VALUES ' .
                    str_repeat('(?, ?, ?),', $aprovadores->count() - 1) . '(?, ?, ?)';
                $stmtAprovadores = $this->database->prepare($queryAprovadores);
                /** @var Aprovador $aprovador */
                $posicao = 1;
                foreach ($aprovadores as $aprovador) {
                    $stmtAprovadores->bindValue($posicao++, $aprovador->getOrcamento()->getId(), PDO::PARAM_INT);
                    $stmtAprovadores->bindValue($posicao++, $aprovador->getFuncionario()->getId(), PDO::PARAM_INT);
                    $stmtAprovadores->bindValue($posicao++, $aprovador->getStatus()?->value);
                }

                if ($stmtAprovadores->execute()) {
                    $aprovadorColecao = $this->obterColecaoAprovadores($orcamento);
                    $orcamento->setAprovadores($aprovadorColecao);
                }
            }
        }
    }

    public function obterPorId(int $id): ?Orcamento
    {
        $stmt = $this->database->prepare("SELECT * FROM orcamentos WHERE id = ?");
        $stmt->bindParam(1, $id, PDO::PARAM_INT);

        $orcamento = null;
        if ($stmt->execute() && ($registro = $stmt->fetch(PDO::FETCH_OBJ))) {
            $orcamento = $this->recuperarEntidadeOrcamentoPorRegistro($registro);
        }

        return $orcamento;
    }

    public function obterTodos(): OrcamentoCollection
    {
        $stmt = $this->database->prepare("SELECT * FROM orcamentos");
        $colecao = new orcamentoCollection();
        if ($stmt->execute()) {
            while ($registro = $stmt->fetch(PDO::FETCH_OBJ)) {
                $orcamento = $this->recuperarEntidadeOrcamentoPorRegistro($registro);
                $colecao->adicionar($orcamento);
            }
        }

        return $colecao;
    }

    public function removerPorId(int $id): bool
    {
        try {
            $this->database->query('BEGIN TRANSACTION');

            $stmt = $this->database->prepare("DELETE FROM orcamento_itens WHERE orcamento_id = ?");
            $stmt->bindParam(1, $id, PDO::PARAM_INT);
            if ($stmt->execute()) {
                throw new Exception('Registros de itens não puderam ser excluído');
            }

            $stmt = $this->database->prepare("DELETE FROM orcamento_aprovadores WHERE id = ?");
            $stmt->bindParam(1, $id, PDO::PARAM_INT);
            if ($stmt->execute()) {
                throw new Exception('Registros de aprovadores não puderam ser excluído');
            }

            $stmt = $this->database->prepare("DELETE FROM orcamentos WHERE id = ?");
            $stmt->bindParam(1, $id, PDO::PARAM_INT);
            if ($stmt->execute()) {
                throw new Exception('Registro de orçamento não pôde ser excluído');
            }
            $this->database->query('COMMIT');

            return true;
        } catch (Throwable $throwable) {
            $this->database->query('ROLLBACK');
        }

        return false;
    }

    protected function recuperarEntidadeOrcamentoPorRegistro(object $registro): Orcamento
    {
        $solicitante = $this->funcionarioServico->obterPorId($registro->func_solicitante_id);
        $orcamento = Orcamento::criar($solicitante);
        $orcamento->setId($registro->id);
        $orcamento->setStatus(Status::tryFrom($registro->status)->obterObjetoStatus());
        if ($registro->data_criacao) {
            $orcamento->setDataCriacao(DateTime::createFromFormat('Y-m-d H:i:s', $registro->data_criacao));
        }
        if ($registro->data_atualizacao) {
            $orcamento->setDataAtualizacao(DateTime::createFromFormat('Y-m-d H:i:s', $registro->data_atualizacao));
        }
        if ($registro->data_aprovacao) {
            $orcamento->setDataAprovacao(DateTime::createFromFormat('Y-m-d H:i:s', $registro->data_aprovacao));
        }
        if ($registro->func_aprovador_id) {
            $aprovador = $this->funcionarioServico->obterPorId($registro->func_aprovador_id);
            $orcamento->setAprovador($aprovador);
        }

        if ($registro->func_requisitante_id) {
            $requisitante = $this->funcionarioServico->obterPorId($registro->func_requisitante_id);
            $orcamento->setRequisitante($requisitante);
        }

        if ($registro->fornecedor_id) {
            $fornecedor = $this->fornecedorServico->obterPorId($registro->fornecedor_id);
            $orcamento->setFornecedor($fornecedor);
        }

        $itemColecao = $this->obterColecaoItensDeOrcamento($registro->id);
        $orcamento->setItens($itemColecao);

        $aprovadorColecao = $this->obterColecaoAprovadores($orcamento);
        $orcamento->setAprovadores($aprovadorColecao);

        return $orcamento;
    }

    protected function obterColecaoItensDeOrcamento(int $orcamentoId): ItemCollection
    {
        $stmtItens = $this->database->prepare("SELECT * FROM orcamento_itens WHERE orcamento_id = ?");
        $stmtItens->bindParam(1, $orcamentoId, PDO::PARAM_INT);

        $itemColecao = new ItemCollection();
        if ($stmtItens->execute()) {
            while ($registroItens = $stmtItens->fetch(PDO::FETCH_OBJ)) {
                $produto = $this->produtoServico->obterPorId($registroItens->produto_id);
                $precoVenda = max((float)$registroItens->valor_unitario, $produto->getValorVenda());
                $item = Item::criar($produto, $registroItens->quantidade, $precoVenda);
                $item->setId($registroItens->id);
                $itemColecao->adicionar($item);
            }
        }

        return $itemColecao;
    }

    protected function obterColecaoAprovadores(Orcamento $orcamento): AprovadorCollection
    {
        $stmtItens = $this->database->prepare("SELECT * FROM orcamento_aprovadores WHERE orcamento_id = ?");
        $stmtItens->bindValue(1, $orcamento->getId(), PDO::PARAM_INT);

        $colecao = new AprovadorCollection();
        if ($stmtItens->execute()) {
            while ($registroAprovador = $stmtItens->fetch(PDO::FETCH_OBJ)) {
                $funcionario = $this->funcionarioServico->obterPorId($registroAprovador->func_aprovador_id);
                $aprovador = Aprovador::criar($funcionario, $orcamento);
                $aprovador->setId($registroAprovador->id);
                $colecao->adicionar($aprovador);
            }
        }

        return $colecao;
    }
}