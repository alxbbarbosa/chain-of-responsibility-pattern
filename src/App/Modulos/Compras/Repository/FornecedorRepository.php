<?php

namespace App\Modulos\Compras\Repository;

use App\Modulos\Compras\Entidades\Fornecedor;
use App\Modulos\Compras\Entidades\Fornecedor\Contatos\Email;
use App\Modulos\Compras\Entidades\Fornecedor\Contatos\Telefone;
use App\Modulos\Compras\Entidades\Fornecedor\Endereco;
use App\Modulos\Compras\Entidades\FornecedorCollection;
use App\Modulos\Localizacoes\LogradouroServiceInterface;
use Exception;
use Infra\Config\Database;
use PDO;
use Throwable;

class FornecedorRepository implements FornecedorRepositoryInterface
{
    private LogradouroServiceInterface $logradouroServico;

    public function __construct(
        LogradouroServiceInterface $logradouroServico
    )
    {
        $this->database = Database::getInstance();
        $this->logradouroServico = $logradouroServico;
    }

    public function salvar(Fornecedor $fornecedor): Fornecedor
    {
        $query = $fornecedor->getId() ?
            "UPDATE fornecedores SET razao_social = ?, cnpj = ?, fantasia = ? WHERE id = ?" :
            "INSERT INTO fornecedores (razao_social, cnpj, fantasia) VALUES (?, ?, ?)";

        $nome = $fornecedor->getRazaoSocial();
        $cnpj = $fornecedor->getCnpj();
        $fantasia = $fornecedor->getNomeFantasia();
        $id = $fornecedor->getId();

        $stmt = $this->database->prepare($query);
        $stmt->bindParam(1, $nome);
        $stmt->bindParam(2, $cnpj);
        $stmt->bindParam(3, $fantasia);
        if ($id) {
            $stmt->bindParam(4, $id, PDO::PARAM_INT);
        }

        $stmt->execute();
        if (!$id) {
            $fornecedor->setId($this->database->lastInsertId());
        }

        return clone $fornecedor;
    }

    public function obterPorId(int $id): ?Fornecedor
    {
        $stmt = $this->database->prepare("SELECT * FROM fornecedores WHERE id = ?");
        $stmt->bindParam(1, $id, PDO::PARAM_INT);

        $fornecedor = null;
        if ($stmt->execute() && ($registro = $stmt->fetch(PDO::FETCH_OBJ))) {
            $fornecedor = $this->obterEntidadeFornecedor($registro);
        }

        return $fornecedor;
    }

    public function obterTodos(): FornecedorCollection
    {
        $stmt = $this->database->prepare("SELECT * FROM fornecedores");
        $colecao = new FornecedorCollection();
        if ($stmt->execute()) {
            while ($registro = $stmt->fetch(PDO::FETCH_OBJ)) {
                $fornecedor = $this->obterEntidadeFornecedor($registro);
                $colecao->adicionar($fornecedor);
            }
        }

        return $colecao;
    }

    public function removerPorId(int $id): bool
    {
        try {
            $this->database->query('BEGIN TRANSACTION');

            $stmtEmail = $this->database->prepare("DELETE FROM fornecedor_emails WHERE fornecedor_id = ?");
            $stmtEmail->bindParam(1, $id, PDO::PARAM_INT);
            if ($stmtEmail->execute()) {
                throw new Exception('Registro não pode ser excluído');
            }

            $stmtEndereco = $this->database->prepare("DELETE FROM fornecedor_enderecos WHERE fornecedor_id = ?");
            $stmtEndereco->bindParam(1, $id, PDO::PARAM_INT);
            if ($stmtEndereco->execute()) {
                throw new Exception('Registro não pode ser excluído');
            }

            $stmtTelefone = $this->database->prepare("DELETE FROM fornecedor_telefones WHERE fornecedor_id = ?");
            $stmtTelefone->bindParam(1, $id, PDO::PARAM_INT);
            if (! $stmtTelefone->execute()) {
                throw new Exception('Registro não pode ser excluído');
            }

            $stmt = $this->database->prepare("DELETE FROM fornecedores WHERE id = ?");
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

    protected function obterEntidadeFornecedor(mixed $registro): Fornecedor
    {
        $fornecedor = fornecedor::criar($registro->razao_social, $registro->cnpj);
        $fornecedor->setId($registro->id);
        $fornecedor->setNomeFantasia($registro->fantasia);

        $stmt = $this->database->prepare("SELECT * FROM fornecedor_enderecos WHERE fornecedor_id = ?");
        $stmt->bindParam(1, $registro->id, PDO::PARAM_INT);
        if ($stmt->execute()) {
            while ($registroEndereco = $stmt->fetch(PDO::FETCH_OBJ)) {
                $logradouro = $this->logradouroServico->obterPorId($registroEndereco->id);
                $endereco = Endereco::criar($registroEndereco->descricao, $logradouro);
                $endereco->setId($registroEndereco->id);
                $endereco->setNumero($registroEndereco->numero);
                $endereco->setApartamento($registroEndereco->apartamento);
                $endereco->setComplemento($registroEndereco->complemento);
                $fornecedor->enderecos()->adicionar($endereco);
            }
        }

        $stmt = $this->database->prepare("SELECT * FROM fornecedor_emails WHERE fornecedor_id = ?");
        $stmt->bindParam(1, $registro->id, PDO::PARAM_INT);
        if ($stmt->execute()) {
            while ($registroEmail = $stmt->fetch(PDO::FETCH_OBJ)) {
                $email = Email::criar($registroEmail->email, $fornecedor);
                $email->setId($registroEmail->id);
                $email->setDescricao($registroEmail->descricao);
                $email->setContato($registroEmail->contato);
                $fornecedor->getContatos()->emails()->adicionar($email);
            }
        }

        $stmt = $this->database->prepare("SELECT * FROM fornecedor_telefones WHERE fornecedor_id = ?");
        $stmt->bindParam(1, $registro->id, PDO::PARAM_INT);
        if ($stmt->execute()) {
            while ($registroTelefone = $stmt->fetch(PDO::FETCH_OBJ)) {
                $telefone = Telefone::criar($registroTelefone->ddd, $registroTelefone->numero, $fornecedor);
                $telefone->setId($registroTelefone->id);
                $telefone->setDescricao($registroTelefone->descricao);
                $telefone->setContato($registroTelefone->contato);
                $fornecedor->getContatos()->telefones()->adicionar($telefone);
            }
        }

        return $fornecedor;
    }
}