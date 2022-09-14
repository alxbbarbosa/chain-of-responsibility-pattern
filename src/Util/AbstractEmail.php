<?php

namespace Util;

use App\Modulos\RecursosHumanos\Entidades\Funcionario;
use PHPMailer\PHPMailer\PHPMailer;

abstract class AbstractEmail
{
    protected string $nomeDestinatario;
    protected string $emailDestinatario;

    protected function __construct(
        protected readonly Funcionario $funcionarioRemetente,
    ) {
    }

    public static function criarParaRemetente(Funcionario $funcionario): self
    {
        return new static($funcionario);
    }

    public function enviar(): bool
    {
        $mail = new PHPMailer(true);
        $mail->isSMTP();
        $mail->SMTPAuth = false;
        $mail->SMTPAutoTLS = false;
        $mail->SMTPDebug = 0;
        $mail->Host = gethostbyname("sys_mail");
        $mail->Mailer = "smtp";
        $mail->CharSet = 'utf-8';
        //$mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 25;
        $mail->Username = "mailtrap";
        $mail->Password = "mailtrap";
        $mail->setFrom($this->funcionarioRemetente->getEmail(), $this->funcionarioRemetente->getNome());
        $mail->addAddress($this->emailDestinatario, $this->nomeDestinatario);
        $mail->Subject = $this->obterAssunto();
        $mail->Body = $this->obterMensagem();
        $mail->SMTPOptions = array(
            'ssl' => array(
                'verify_peer' => false,
                'verify_peer_name' => false,
                'allow_self_signed' => true
            )
        );

        return $mail->send();
    }

    public function definirDestinatario(string $nome, string $email): self
    {
        $this->nomeDestinatario = $nome;
        $this->emailDestinatario = $email;

        return $this;
    }

    protected abstract function obterAssunto(): string;

    protected abstract function obterMensagem(): string;
}