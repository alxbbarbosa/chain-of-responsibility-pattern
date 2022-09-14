<?php

namespace App\Modulos\Compras\Entidades;

use DomainException;

interface OrcamentoStatusInterface
{
    /** @throws DomainException */
    public function solicitarAprovacao(Orcamento $orcamento): void;

    /** @throws DomainException */
    public function aprovar(Orcamento $orcamento): void;

    /** @throws DomainException */
    public function reprovar(Orcamento $orcamento): void;

    /** @throws DomainException */
    public function cancelar(Orcamento $orcamento): void;

    /** @throws DomainException */
    public function finalizar(Orcamento $orcamento): void;
}