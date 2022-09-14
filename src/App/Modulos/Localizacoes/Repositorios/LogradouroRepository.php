<?php

namespace App\Modulos\Localizacoes\Repositorios;

use App\Modulos\Localizacoes\Entidades\Bairro;
use App\Modulos\Localizacoes\Entidades\Cidade;
use App\Modulos\Localizacoes\Entidades\Estado;
use App\Modulos\Localizacoes\Entidades\Logradouro;
use App\Modulos\Localizacoes\Entidades\LogradouroCollection;
use Exception;
use Infra\Config\Database;
use PDO;
use Throwable;

class LogradouroRepository implements LogradouroRepositoryInterface
{

    private PDO $database;

    public function __construct()
    {
        $this->database = Database::getInstance();
    }

    public function salvar(Logradouro $logradouro): ?Logradouro
    {
        try {
            $this->database->query('BEGIN TRANSACTION');

            $estadoExistente = $this->salvarEstado($logradouro->getBairro()->getCidade()->getEstado());
            if ($estadoExistente) {
                $logradouro->getBairro()->getCidade()->getEstado()->setId($estadoExistente->getId());
            }

            $cidadeExistente = $this->salvarCidade($logradouro->getBairro()->getCidade());
            if ($cidadeExistente) {
                $logradouro->getBairro()->getCidade()->setId($cidadeExistente->getId());
            }

            $bairroExistente = $this->salvarBairro($logradouro->getBairro());
            if ($bairroExistente) {
                $logradouro->getBairro()->setId($bairroExistente->getId());
            }

            $logradouroId = $this->obterLogradouroIdSeExiste($logradouro);
            if ($logradouroId) {
                $logradouro->setId($logradouroId);
                $this->database->query('COMMIT');
                return $logradouro;
            }

            $query = $logradouro->getId() ?
                "UPDATE logradouro SET 
                      estado_id = ?, 
                      cidade_id = ?,
                      bairro_id = ?,
                      cep = ?,
                      logradouro = ?
                  WHERE id = ?" :
                "INSERT INTO logradouro (estado_id, cidade_id, bairro_id, cep, logradouro)
                  VALUES (?, ?, ?, ?, ?)";

            $estadoId = $logradouro->getBairro()->getCidade()->getEstado()->getId();
            $cidadeId = $logradouro->getBairro()->getCidade()->getId();
            $bairroId = $logradouro->getBairro()->getId();
            $logradouroDescricao = $logradouro->getLogradouro();
            $cep = $logradouro->getCep();

            $stmt = $this->database->prepare($query);
            $stmt->bindParam(1, $estadoId, PDO::PARAM_INT);
            $stmt->bindParam(2, $cidadeId, PDO::PARAM_INT);
            $stmt->bindParam(3, $bairroId, PDO::PARAM_INT);
            $stmt->bindParam(4, $cep);
            $stmt->bindParam(5, $logradouroDescricao);

            if ($logradouro->getId()) {
                $id = $logradouro->getId();
                $stmt->bindParam(6, $id, PDO::PARAM_INT);
            }

            $stmt->execute();
            if (! $logradouro->getId()) {
                $logradouro->setId($this->database->lastInsertId());
            }

            $this->database->query('COMMIT');

            return clone $logradouro;
        } catch (Throwable $throwable) {
            $this->database->query('ROLLBACK');
        }

        return null;
    }

    protected function obterLogradouroIdSeExiste(Logradouro $logradouro): ?int
    {
        $stmt = $this->database->prepare("SELECT id FROM logradouro WHERE logradouro = ? AND bairro_id = ? AND cep = ? LIMIT 1");
        $stmt->bindValue(1, $logradouro->getLogradouro());
        $stmt->bindValue(2, $logradouro->getBairro()->getId());
        $stmt->bindValue(3, $logradouro->getCep());

        if ($stmt->execute() && ($registro = $stmt->fetch(PDO::FETCH_OBJ))) {
            return $registro->id;
        }

        return null;
    }

    protected function salvarEstado(Estado $estado): ?Estado
    {
        $estadoExistente = $this->obterEstadoPorNomeESigla($estado->getNome(), $estado->getSigla());
        if ($estadoExistente) {
            return $estadoExistente;
        }

        $query = $estado->getId() ?
            "UPDATE estados SET 
                      nome = ?, 
                      sigla = ?
                  WHERE id = ?" :
            "INSERT INTO estados (nome, sigla)
                  VALUES (?, ?)";
        $estadoNome = $estado->getNome();
        $estadoSigla = $estado->getSigla();
        $stmt = $this->database->prepare($query);
        $stmt->bindParam(1, $estadoNome);
        $stmt->bindParam(2, $estadoSigla);
        if ($estado->getId()) {
            $estadoId = $estado->getId();
            $stmt->bindParam(6, $estadoId, PDO::PARAM_INT);
        }

        $stmt->execute();
        if (! $estado->getId()) {
            $estado->setId($this->database->lastInsertId());
        }

        return null;
    }

    protected function obterEstadoPorNomeESigla(string $nome, string $sigla): ?Estado
    {
        $stmt = $this->database->prepare("SELECT * FROM estados WHERE nome = ? AND sigla = ? LIMIT 1");
        $stmt->bindParam(1, $nome);
        $stmt->bindParam(2, $sigla);

        $estado = null;
        if ($stmt->execute() && ($registro = $stmt->fetch(PDO::FETCH_OBJ))) {
            $estado = Estado::criar($registro->sigla, $registro->nome);
            $estado->setId($registro->id);
        }

        return $estado;
    }

    protected function salvarCidade(Cidade $cidade): ?Cidade
    {
        $cidadeExistente = $this->obterCidadePorNomeEEstado($cidade->getNome(), $cidade->getEstado());
        if ($cidadeExistente) {
            return $cidadeExistente;
        }

        $query = $cidade->getId() ?
            "UPDATE cidades SET 
                      nome = ?, 
                      estado_id = ?
                  WHERE id = ?" :
            "INSERT INTO cidades (nome, estado_id)
                  VALUES (?, ?)";
        $cidadeNome = $cidade->getNome();
        $estadoId = $cidade->getEstado()->getId();
        $stmt = $this->database->prepare($query);
        $stmt->bindParam(1, $cidadeNome);
        $stmt->bindParam(2, $estadoId);
        if ($cidade->getId()) {
            $cidadeId = $cidade->getId();
            $stmt->bindParam(3, $cidadeId, PDO::PARAM_INT);
        }

        $stmt->execute();
        if (! $cidade->getId()) {
            $cidade->setId($this->database->lastInsertId());
        }

        return null;
    }

    protected function obterCidadePorNomeEEstado(string $nome, Estado $estado): ?Cidade
    {
        $stmt = $this->database->prepare("SELECT * FROM cidades WHERE nome = ? AND estado_id = ? LIMIT 1");
        $stmt->bindValue(1, $nome);
        $stmt->bindValue(2, $estado->getId());

        $cidade = null;
        if ($stmt->execute() && ($registro = $stmt->fetch(PDO::FETCH_OBJ))) {
            $cidade = Cidade::criar($registro->nome, $estado);
            $cidade->setId($registro->id);
        }

        return $cidade;
    }

    protected function salvarBairro(Bairro $bairro): ?Bairro
    {
        $bairroExistente = $this->obterBairroPorNomeECidade($bairro->getNome(), $bairro->getCidade());
        if ($bairroExistente) {
            return $bairroExistente;
        }

        $query = $bairro->getId() ?
            "UPDATE bairros SET 
                      nome = ?,
                      cidade_id = ?,
                      estado_id = ?
                  WHERE id = ?" :
            "INSERT INTO bairros (nome, cidade_id, estado_id)
                  VALUES (?, ?, ?)";
        $bairroNome = $bairro->getNome();
        $cidadeId = $bairro->getCidade()->getId();
        $estadoId = $bairro->getCidade()->getEstado()->getId();
        $stmt = $this->database->prepare($query);
        $stmt->bindParam(1, $bairroNome);
        $stmt->bindParam(2, $cidadeId, PDO::PARAM_INT);
        $stmt->bindParam(3, $estadoId, PDO::PARAM_INT);
        if ($bairro->getId()) {
            $bairroId = $bairro->getId();
            $stmt->bindParam(4, $bairroId, PDO::PARAM_INT);
        }

        $stmt->execute();
        if (! $bairro->getId()) {
            $bairro->setId($this->database->lastInsertId());
        }

        return null;
    }

    protected function obterBairroPorNomeECidade(string $nome, Cidade $cidade): ?Bairro
    {
        $stmt = $this->database->prepare("SELECT * FROM bairros WHERE nome = ? AND cidade_id = ? AND estado_id = ? LIMIT 1");
        $stmt->bindValue(1, $nome);
        $stmt->bindValue(2, $cidade->getId());
        $stmt->bindValue(3, $cidade->getEstado()->getId());

        $bairro = null;
        if ($stmt->execute() && ($registro = $stmt->fetch(PDO::FETCH_OBJ))) {
            $bairro = Bairro::criar($registro->nome, $cidade);
            $bairro->setId($registro->id);
        }

        return $bairro;
    }

    public function obterPorId(int $id): ?Logradouro
    {
        $consulta = $this->obterConsultaLogradouro('logradouro.id = ?');
        $stmt = $this->database->prepare($consulta);
        $stmt->bindParam(1, $id, PDO::PARAM_INT);

        $logradouro = null;
        if ($stmt->execute() && ($registro = $stmt->fetch(PDO::FETCH_OBJ))) {
            $logradouro = $this->obterEntidadeLogradouro($registro);
        }

        return $logradouro;
    }

    public function obterPorCep(string $cep): LogradouroCollection
    {
        return $this->obterTodosPorFiltro('logradouro.cep = ?', [$cep]);
    }

    public function obterPorBairro(string $bairro): LogradouroCollection
    {
        return $this->obterTodosPorFiltro('b.nome = ?', [$bairro]);
    }

    public function obterPorCidade(string $cidade): LogradouroCollection
    {
        return $this->obterTodosPorFiltro('c.nome = ?', [$cidade]);
    }

    public function obterTodos(): LogradouroCollection
    {
        return $this->obterTodosPorFiltro('', []);
    }

    public function removerPorEntidade(Logradouro $logradouro, bool $recursivo = false): bool
    {
        try {
            $this->database->query('BEGIN TRANSACTION');

            $stmt = $this->database->prepare("DELETE FROM logradouro WHERE id = ?");
            $stmt->bindParam(1, $id, PDO::PARAM_INT);
            if (! $stmt->execute()) {
                throw new Exception('Logradouro não pode ser excluído');
            }

            if (! $recursivo) {
                $this->database->query('COMMIT');
                return true;
            }

            $bairroId = $logradouro->getBairro()->getId();
            $stmt = $this->database->prepare("DELETE FROM bairros WHERE id = ?");
            $stmt->bindParam(1, $bairroId, PDO::PARAM_INT);
            if (! $stmt->execute()) {
                throw new Exception('Bairro não pode ser excluído');
            }

            $cidadeId = $logradouro->getBairro()->getCidade()->getId();
            $stmt = $this->database->prepare("DELETE FROM cidades WHERE id = ?");
            $stmt->bindParam(1, $cidadeId, PDO::PARAM_INT);
            if (! $stmt->execute()) {
                throw new Exception('Cidade não pode ser excluído');
            }

            $estadoId = $logradouro->getBairro()->getCidade()->getEstado()->getId();
            $stmt = $this->database->prepare("DELETE FROM estados WHERE id = ?");
            $stmt->bindParam(1, $estadoId, PDO::PARAM_INT);
            if (! $stmt->execute()) {
                throw new Exception('Logradouro não pode ser excluído');
            }

            $this->database->query('COMMIT');

            return true;
        } catch (Throwable $throwable) {
            $this->database->query('ROLLBACK');
        }

        return false;
    }

    protected function obterEntidadeLogradouro($registro): Logradouro
    {
        $estado = Estado::criar($registro->uf, $registro->estado);
        $estado->setId($registro->estado_id);
        $cidade = Cidade::criar($registro->cidade, $estado);
        $cidade->setId($registro->cidade_id);
        $bairro = Bairro::criar($registro->bairro, $cidade);
        $bairro->setId($registro->bairro_id);
        $logradouro = Logradouro::criar($registro->cep, $registro->logradouro, $bairro);
        $logradouro->setId($registro->id);

        return $logradouro;
    }

    protected function obterTodosPorFiltro(string $filtro, array $argumentos = []): LogradouroCollection
    {
        $consulta = $this->obterConsultaLogradouro($filtro);
        $stmt = $this->database->prepare($consulta);
        $sequencia = 1;
        foreach ($argumentos as $argumento) {
            $stmt->bindValue($sequencia++, $argumento);
        }
        $colecao = new LogradouroCollection();
        if ($stmt->execute() && ($registro = $stmt->fetch(PDO::FETCH_OBJ))) {
            $logradouro = $this->obterEntidadeLogradouro($registro);
            $colecao->adicionar($logradouro);
        }

        return $colecao;
    }

    protected function obterConsultaLogradouro(string $filtro = ''): string
    {
        $stmt = 'SELECT logradouro.id,
                        logradouro.cep,
                        logradouro.logradouro,
                        b.nome  as bairro,
                        c.nome  as cidade,
                        e.nome  as estado,
                        e.sigla as uf,
                        logradouro.bairro_id,
                        logradouro.cidade_id,
                        logradouro.estado_id
                 FROM logradouro
                         INNER JOIN bairros b on b.id = logradouro.bairro_id
                         INNER JOIN cidades c on logradouro.cidade_id = c.id and b.cidade_id = c.id
                         INNER JOIN estados e on e.id = logradouro.estado_id and c.estado_id and b.estado_id
                 ';

        if ($filtro) {
            $stmt .= sprintf('WHERE %s', $filtro);
        }

        return $stmt;
    }
}