<?php

namespace App\Modulos\Compras;

use App\Modulos\Compras\Entidades\Orcamento;
use App\Modulos\Compras\Entidades\OrcamentoCollection;
use App\Modulos\Compras\Enums\Status;
use App\Modulos\Compras\Repository\OrcamentoRepositoryInterface;
use App\Modulos\Compras\Servicos\Orcamento\Processamento\ProcessoResposibility\DefinirAprovador;
use App\Modulos\Compras\Servicos\Orcamento\Processamento\ProcessoResposibility\EnviarEMailParaAprovadores;
use App\Modulos\Compras\Servicos\Orcamento\Processamento\ProcessoResposibility\FimCadeiaProcesso;
use App\Modulos\RecursosHumanos\Entidades\Funcionario;
use DateTime;
use Symfony\Component\DependencyInjection\Container;

class OrcamentoService implements OrcamentoServiceInterface
{
    private OrcamentoRepositoryInterface $orcamentoRepository;
    private Container $container;

    public function __construct(
        OrcamentoRepositoryInterface $orcamentoRepository,
        Container $container,
    ) {
        $this->orcamentoRepository = $orcamentoRepository;
        $this->container = $container;
    }

    public function criarOrcamento(Funcionario $solicitante): Orcamento
    {
        $orcamento = Orcamento::criar($solicitante);
        return $this->orcamentoRepository->salvar($orcamento);
    }

    public function solicitarAprovacao(Orcamento $orcamento): void
    {
        $processoAprovacao = new DefinirAprovador($this->container);
        $processoAprovacao
            ->setProcessoSucessor(new EnviarEMailParaAprovadores($this->container))
            ->setProcessoSucessor(new FimCadeiaProcesso());

        $processoAprovacao->processarOrcamento($orcamento);
    }

//    public function aprovarOrcamento(Orcamento $orcamento, Funcionario $funcionario): void
//    {
//        if ($orcamento->getStatus() === Status::EM_APROVACAO
//            && $orcamento->getAprovador()->getId() === $funcionario->getId()) {
//
//            $orcamento->setStatus(Status::APROVADO->obterObjetoStatus());
//            $orcamento->setDataAprovacao(DateTime::createFromFormat('Y-m-d H:i:s', date('Y-m-d H:i:s')));
//            $this->salvar($orcamento);
//        }
//    }
//
//    public function reprovarOrcamento(Orcamento $orcamento, Funcionario $funcionario): void
//    {
//        if ($orcamento->getStatus() === Status::EM_APROVACAO
//            && $orcamento->getAprovador()->getId() === $funcionario->getId()) {
//
//            $orcamento->setStatus(Status::REPROVADO->obterObjetoStatus());
//            $orcamento->setDataReprovacao(DateTime::createFromFormat('Y-m-d H:i:s', date('Y-m-d H:i:s')));
//            $this->salvar($orcamento);
//        }
//    }

    public function salvar(Orcamento $orcamento): ?Orcamento
    {
        return $this->orcamentoRepository->salvar($orcamento);
    }

    public function obterPorId(int $id): ?Orcamento
    {
        return $this->orcamentoRepository->obterPorId($id);
    }

    public function obterTodos(): OrcamentoCollection
    {
        return $this->orcamentoRepository->obterTodos();
    }

    public function removerPorId(int $id): bool
    {
        return $this->orcamentoRepository->removerPorId($id);
    }
}