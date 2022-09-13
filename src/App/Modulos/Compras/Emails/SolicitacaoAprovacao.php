<?php

namespace App\Modulos\Compras\Emails;

use DomainException;
use Util\AbstractEmail;

class SolicitacaoAprovacao extends AbstractEmail
{
    private ?int $orcamentoCodigo = null;

    public function setOrcamentoCodigo(int $orcamentoCodigo): self
    {
        $this->orcamentoCodigo = $orcamentoCodigo;
        return $this;
    }

    protected function obterAssunto(): string
    {
        return sprintf(
            '%s solicita sua aprovação para orçamento de compras',
            $this->funcionarioRemetente->getNome()
        );
    }

    /** @throws DomainException */
    protected function obterMensagem(): string
    {
        if (! $this->orcamentoCodigo) {
            throw new DomainException("Codigo de orcamento não definido para gerar e-mail");
        }

        return "Olá Sr(a) {$this->nomeDestinatario}, \n\n\tSr(a) {$this->funcionarioRemetente->getNome()}," .
            " está solicitando sua aprovação para o orçamento número {$this->orcamentoCodigo}.\n" .
            "\tFavor acessar o sistema no módulo de compras, e validar os dados para este orçamento, " .
            "que permanecerá com status pendente até a sua decisão.\n\n(ATENÇÃO: Favor não responder este e-mail visto " .
            "ter sido gerado automaticamente pelo sistema e não estar sendo monitorado).";
    }
}