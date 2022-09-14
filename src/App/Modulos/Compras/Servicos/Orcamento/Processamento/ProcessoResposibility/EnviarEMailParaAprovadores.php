<?php

namespace App\Modulos\Compras\Servicos\Orcamento\Processamento\ProcessoResposibility;

use App\Modulos\Compras\Emails\SolicitacaoAprovacao;
use App\Modulos\Compras\Emails\SolicitacaoEnviada;
use App\Modulos\Compras\Entidades\Orcamento;
use App\Modulos\Compras\Entidades\Orcamento\Aprovador;
use App\Modulos\Compras\Enums\Status;
use App\Modulos\Compras\Servicos\Orcamento\Processamento\ProcessoAbstract;
use Throwable;

class EnviarEMailParaAprovadores extends ProcessoAbstract
{

    public function processarOrcamento(Orcamento $orcamento): void
    {
        try {
            $aprovadores = $orcamento->getAprovadores();
            if ($aprovadores->count() > 0 && $orcamento->getStatus() === Status::EM_APROVACAO) {

                /** @var Aprovador $aprovador */
                foreach ($aprovadores as $aprovador) {
                    (SolicitacaoAprovacao::criarParaRemetente($orcamento->getSolicitante()))
                        ->setOrcamentoCodigo($orcamento->getId())
                        ->definirDestinatario(
                            $aprovador->getFuncionario()->getNome(),
                            $aprovador->getFuncionario()->getEmail()
                        )
                        ->enviar();

                    (SolicitacaoEnviada::criarParaRemetente($aprovador->getFuncionario()))
                        ->setOrcamentoCodigo($orcamento->getId())
                        ->definirDestinatario(
                            $orcamento->getSolicitante()->getNome(),
                            $orcamento->getSolicitante()->getEmail()
                        )
                        ->enviar();
                }
            }
        } catch (Throwable $exception) {
            echo $exception->getMessage();
        }

        if (! $this->processoSucessor) {
            return;
        }
        $this->processoSucessor->processarOrcamento($orcamento);
    }
}