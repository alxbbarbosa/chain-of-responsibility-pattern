<?php

namespace App\Modulos\Compras\Entidades;

use App\Modulos\Compras\Entidades\Orcamento\AprovadorCollection;
use App\Modulos\Compras\Entidades\Orcamento\Item;
use App\Modulos\Compras\Entidades\Orcamento\ItemCollection;
use App\Modulos\Compras\Entidades\Orcamento\ManipulcaoDeStatusTrait;
use App\Modulos\Compras\Entidades\Orcamento\StatusStates\EmAberto;
use App\Modulos\Estoque\Entidades\Produto;
use App\Modulos\RecursosHumanos\Entidades\Funcionario;
use DateTimeInterface;
use Util\EntityCommon\IdentificadorTrait;
use Util\EntityCommon\TimestampTrait;

class Orcamento implements OrcamentoStatusInterface
{
    private ItemCollection $itemCollection;
    private AprovadorCollection $aprovadorCollection;
    private Funcionario $solicitante;
    private ?Funcionario $requisitante = null;
    private ?Fornecedor $fornecedor = null;
    private ?Funcionario $aprovador = null;
    private int $diasPrevistoEntrega = 0;
    private string $observacoes = '';
    private string $condicoesPagamento = '';
    private ?DateTimeInterface $dataAprovacao = null;
    private ?DateTimeInterface $dataReprovacao = null;

    use TimestampTrait, IdentificadorTrait, ManipulcaoDeStatusTrait;

    private function __construct(Funcionario $solicitante)
    {
        $this->solicitante = $solicitante;
        $this->status = new EmAberto();
        $this->itemCollection = new ItemCollection();
        $this->aprovadorCollection = new AprovadorCollection();
    }

    public static function criar(Funcionario $solicitante): self
    {
        return new static($solicitante);
    }

    public function obterValorTotal(): float
    {
        return $this->itemCollection->obterValorTotal();
    }

    public function adicionarItem(Produto $produto, int $quantidade, float $valorUnitario = 0.0): self
    {
        $this->itemCollection->adicionar(Item::criar($produto, $quantidade, $valorUnitario));
        return $this;
    }

    public function setFornecedor(?Fornecedor $fornecedor): void
    {
        $this->fornecedor = $fornecedor;
    }

    public function setAprovador(Funcionario $aprovador): void
    {
        $this->aprovador = $aprovador;
    }

    public function getSolicitante(): Funcionario
    {
        return $this->solicitante;
    }

    public function getFornecedor(): ?Fornecedor
    {
        return $this->fornecedor;
    }

    public function getAprovador(): ?Funcionario
    {
        return $this->aprovador;
    }

    public function getItens(): ItemCollection
    {
        return $this->itemCollection;
    }

    public function setItens(ItemCollection $itemCollection): void
    {
        $this->itemCollection = $itemCollection;
    }

    public function getDataAprovacao(): ?DateTimeInterface
    {
        return $this->dataAprovacao;
    }

    public function setDataAprovacao(?DateTimeInterface $dataAprovacao): void
    {
        $this->dataAprovacao = $dataAprovacao;
    }

    public function getDataReprovacao(): ?DateTimeInterface
    {
        return $this->dataReprovacao;
    }

    public function setDataReprovacao(?DateTimeInterface $dataReprovacao): void
    {
        $this->dataReprovacao = $dataReprovacao;
    }

    public function getRequisitante(): ?Funcionario
    {
        return $this->requisitante;
    }

    public function setRequisitante(?Funcionario $requisitante): void
    {
        $this->requisitante = $requisitante;
    }

    public function getDiasPrevistoEntrega(): int
    {
        return $this->diasPrevistoEntrega;
    }

    public function setDiasPrevistoEntrega(int $diasPrevistoEntrega): void
    {
        $this->diasPrevistoEntrega = $diasPrevistoEntrega;
    }

    public function getObservacoes(): string
    {
        return $this->observacoes;
    }

    public function setObservacoes(string $observacoes): void
    {
        $this->observacoes = $observacoes;
    }

    public function getCondicoesPagamento(): string
    {
        return $this->condicoesPagamento;
    }

    public function setCondicoesPagamento(string $condicoesPagamento): void
    {
        $this->condicoesPagamento = $condicoesPagamento;
    }

    public function getAprovadores(): AprovadorCollection
    {
        return $this->aprovadorCollection;
    }

    public function setAprovadores(AprovadorCollection $aprovadorCollection): void
    {
        $this->aprovadorCollection = $aprovadorCollection;
    }
}