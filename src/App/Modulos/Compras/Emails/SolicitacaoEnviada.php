<?php

namespace App\Modulos\Compras\Emails;

use DomainException;
use Util\AbstractEmail;

class SolicitacaoEnviada extends AbstractEmail
{

    private ?int $orcamentoId = null;

    public function setOrcamentoCodigo(int $orcamentoCodigo): self
    {
        $this->orcamentoId = $orcamentoCodigo;
        return $this;
    }

    protected function obterAssunto(): string
    {
        return sprintf(
            'Solicitação para aprovação do orçamento %d foi enviada para %s',
            $this->orcamentoId,
            $this->funcionarioRemetente->getNome(),
        );
    }

    /** @throws DomainException */
    protected function obterMensagem(): string
    {
        if (! $this->orcamentoId) {
            throw new DomainException("Orcamento não definido para gerar e-mail");
        }

        return "Olá Sr(a) {$this->nomeDestinatario}, \n\n" .
            "\tSua solicitação para aprovação do orçamento número {$this->orcamentoId}, já" .
            " foi enviada para Sr(a) {$this->funcionarioRemetente->getNome()}.\n\tFavor acompanhar a situação " .
            "desse orçamento no sistema, através do módulo de compras.\n\n(ATENÇÃO: Favor não responder este e-mail" .
            " visto ter sido gerado automaticamente pelo sistema e não estar sendo monitorado).";
    }
}