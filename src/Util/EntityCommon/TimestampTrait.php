<?php

namespace Util\EntityCommon;

use DateTimeInterface;

trait TimestampTrait
{
    protected ?DateTimeInterface $dataCriacao = null;
    protected ?DateTimeInterface $dataAtualizacao = null;

    public function getDataCriacao(): ?DateTimeInterface
    {
        return $this->dataCriacao;
    }

    public function setDataCriacao(?DateTimeInterface $dataCriacao): void
    {
        $this->dataCriacao = $dataCriacao;
    }

    public function getDataAtualizacao(): ?DateTimeInterface
    {
        return $this->dataAtualizacao;
    }

    public function setDataAtualizacao(?DateTimeInterface $dataAtualizacao): void
    {
        $this->dataAtualizacao = $dataAtualizacao;
    }
}