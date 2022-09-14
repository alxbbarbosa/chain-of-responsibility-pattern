<?php

namespace App\Modulos\Comercial\Repository;

use App\Modulos\Comercial\Entidades\Cliente;
use App\Modulos\Comercial\Entidades\Cliente\Contatos\Email;
use App\Modulos\Comercial\Entidades\Cliente\Contatos\Telefone;
use App\Modulos\Comercial\Entidades\Cliente\Endereco;
use App\Modulos\Comercial\Entidades\ClienteCollection;
use App\Modulos\Localizacoes\LogradouroServiceInterface;
use Exception;
use Infra\Config\Database;
use PDO;
use Throwable;

class ClienteRepository implements ClienteRepositoryInterface
{
    private LogradouroServiceInterface $logradouroServico;

    public function __construct(
        LogradouroServiceInterface $logradouroServico
    )
    {
        $this->database = Database::getInstance();
        $this->logradouroServico = $logradouroServico;
    }

    public function salvar(Cliente $cliente): Cliente
    {
        $query = $cliente->getId() ?
            "UPDATE clientes SET nome_razao = ?, cnpj_cpf = ?, fantasia = ? WHERE id = ?" :
            "INSERT INTO clientes (nome_razao, cnpj_cpf, fantasia) VALUES (?, ?, ?)";

        $nome = $cliente->getNomeRazaoSocial();
        $cnpj_cpf = $cliente->getCnpjCpf();
        $fantasia = $cliente->getNomeFantasia();
        $id = $cliente->getId();

        $stmt = $this->database->prepare($query);
        $stmt->bindParam(1, $nome);
        $stmt->bindParam(2, $cnpj_cpf);
        $stmt->bindParam(3, $fantasia);
        if ($id) {
            $stmt->bindParam(4, $id, PDO::PARAM_INT);
        }

        $stmt->execute();
        if (!$id) {
            $cliente->setId($this->database->lastInsertId());
        }

        return clone $cliente;
    }

    public function obterPorId(int $id): ?Cliente
    {
        $stmt = $this->database->prepare("SELECT * FROM clientes WHERE id = ?");
        $stmt->bindParam(1, $id, PDO::PARAM_INT);

        $cliente = null;
        if ($stmt->execute() && ($registro = $stmt->fetch(PDO::FETCH_OBJ))) {
            $cliente = $this->obterEntidadeCliente($registro);
        }

        return $cliente;
    }

    public function obterTodos(): ClienteCollection
    {
        $stmt = $this->database->prepare("SELECT * FROM clientes");
        $colecao = new clienteCollection();
        if ($stmt->execute()) {
            while ($registro = $stmt->fetch(PDO::FETCH_OBJ)) {
                $cliente = $this->obterEntidadeCliente($registro);
                $colecao->adicionar($cliente);
            }
        }

        return $colecao;
    }

    public function removerPorId(int $id): bool
    {
        try {
            $this->database->query('BEGIN TRANSACTION');

            $stmtEmail = $this->database->prepare("DELETE FROM clientes_emails WHERE cliente_id = ?");
            $stmtEmail->bindParam(1, $id, PDO::PARAM_INT);
            if ($stmtEmail->execute()) {
                throw new Exception('Registro não pode ser excluído');
            }

            $stmtEndereco = $this->database->prepare("DELETE FROM cliente_enderecos WHERE cliente_id = ?");
            $stmtEndereco->bindParam(1, $id, PDO::PARAM_INT);
            if ($stmtEndereco->execute()) {
                throw new Exception('Registro não pode ser excluído');
            }

            $stmtTelefone = $this->database->prepare("DELETE FROM clientes_telefones WHERE cliente_id = ?");
            $stmtTelefone->bindParam(1, $id, PDO::PARAM_INT);
            if (! $stmtTelefone->execute()) {
                throw new Exception('Registro não pode ser excluído');
            }

            $stmt = $this->database->prepare("DELETE FROM clientes WHERE id = ?");
            $stmt->bindParam(1, $id, PDO::PARAM_INT);
            if (! $stmt->execute()) {
                throw new Exception('Registro não pode ser excluído');
            }

            $this->database->query('COMMIT');
            return true;
        } catch (Throwable $throwable) {
            $this->database->query('ROLLBACK');
            return false;
        }
    }

    protected function obterEntidadeCliente(mixed $registro): Cliente
    {
        $cliente = Cliente::criar($registro->nome_razao, $registro->cnpj_cpf);
        $cliente->setId($registro->id);
        $cliente->setNomeFantasia($registro->fantasia);

        $stmt = $this->database->prepare("SELECT * FROM cliente_enderecos WHERE cliente_id = ?");
        $stmt->bindParam(1, $registro->id, PDO::PARAM_INT);
        if ($stmt->execute()) {
            while ($registroEndereco = $stmt->fetch(PDO::FETCH_OBJ)) {
                $logradouro = $this->logradouroServico->obterPorId($registroEndereco->id);
                $endereco = Endereco::criar($registroEndereco->descricao, $logradouro);
                $endereco->setId($registroEndereco->id);
                $endereco->setNumero($registroEndereco->numero);
                $endereco->setApartamento($registroEndereco->apartamento);
                $endereco->setComplemento($registroEndereco->complemento);
                $cliente->enderecos()->adicionar($endereco);
            }
        }

        $stmt = $this->database->prepare("SELECT * FROM clientes_emails WHERE cliente_id = ?");
        $stmt->bindParam(1, $registro->id, PDO::PARAM_INT);
        if ($stmt->execute()) {
            while ($registroEmail = $stmt->fetch(PDO::FETCH_OBJ)) {
                $email = Email::criar($registroEmail->email, $cliente);
                $email->setId($registroEmail->id);
                $email->setDescricao($registroEmail->descricao);
                $email->setContato($registroEmail->contato);
                $cliente->getContatos()->emails()->adicionar($email);
            }
        }

        $stmt = $this->database->prepare("SELECT * FROM clientes_telefones WHERE cliente_id = ?");
        $stmt->bindParam(1, $registro->id, PDO::PARAM_INT);
        if ($stmt->execute()) {
            while ($registroTelefone = $stmt->fetch(PDO::FETCH_OBJ)) {
                $telefone = Telefone::criar($registroTelefone->ddd, $registroTelefone->numero, $cliente);
                $telefone->setId($registroTelefone->id);
                $telefone->setDescricao($registroTelefone->descricao);
                $telefone->setContato($registroTelefone->contato);
                $cliente->getContatos()->telefones()->adicionar($telefone);
            }
        }

        return $cliente;
    }
}