<?php

namespace App\Modulos\Estoque\Repository;

use App\Modulos\Estoque\Entidades\Produto;
use App\Modulos\Estoque\Entidades\Produto\Detalhes;
use App\Modulos\Estoque\Entidades\Produto\Detalhes\Embalagem;
use App\Modulos\Estoque\Entidades\Produto\Detalhes\Estoque;
use App\Modulos\Estoque\Entidades\ProdutoCollection;
use App\Modulos\Estoque\Produto\CategoriaServiceInterface;
use App\Modulos\RecursosHumanos\FuncionarioServiceInterface;
use DateTime;
use Infra\Config\Database;
use PDO;
use Throwable;

class ProdutoRepository implements ProdutoRepositoryInterface
{
    private PDO $database;
    private CategoriaServiceInterface $categoriaServico;
    private FuncionarioServiceInterface $funcionarioServico;

    public function __construct(
        CategoriaServiceInterface $categoriaServico,
        FuncionarioServiceInterface $funcionarioServico,
    ) {
        $this->database = Database::getInstance();
        $this->categoriaServico = $categoriaServico;
        $this->funcionarioServico = $funcionarioServico;
    }

    public function salvar(Produto $produto): ?Produto
    {
        try {
            $this->database->query('BEGIN TRANSACTION;');

            $salvarStmt = $produto->getId() ?
                "UPDATE produtos SET 
                    sku = ?,
                    categoria_id = ?,
                    valor_compra = ?,
                    valor_venda = ?,
                    estoque_atual = ?,
                    estoque_minimo = ?,
                    data_atualizacao = ?,
                    atualizacao_funcionario_id = ?
             WHERE id = ?" :
                "INSERT INTO produtos (
                      sku,
                      categoria_id,
                      valor_compra,
                      valor_venda,
                      estoque_atual,
                      estoque_minimo,
                      data_criacao,
                      criacao_funcionario_id,
                      data_atualizacao,
                      atualizacao_funcionario_id
                      ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

            $dataPersistir = (new DateTime())->format('Y-m-d H:i:s');
            $funcionarioIdPersisitir = 1;
            $stmt = $this->database->prepare($salvarStmt);
            $stmt->bindValue(1, $produto->estoque()->getSku());
            $stmt->bindValue(2, $produto->categoria()->getId());
            $stmt->bindValue(3, $produto->getValorCompra());
            $stmt->bindValue(4, $produto->getValorVenda());
            $stmt->bindValue(5, $produto->estoque()->getNivelAtual());
            $stmt->bindValue(6, $produto->estoque()->getNivelMinimo());
            $stmt->bindValue(7, $dataPersistir);
            $stmt->bindValue(8, $funcionarioIdPersisitir);

            if (! $produto->getId()) {
                $stmt->bindParam(9, $dataPersistir);
                $stmt->bindParam(10, $funcionarioIdPersisitir);
            }

            if ($produto->getId()) {
                $stmt->bindValue(9, $produto->getId(), PDO::PARAM_INT);
            }

            $stmt->execute();
            if (! $produto->getId()) {
                $produto->setId($this->database->lastInsertId());
            }

            $detalheStmt = $produto->getId() ?
                'UPDATE produto_detalhes SET 
                            descricao = ?, 
                            fabricante = ?, 
                            codigo_barras = ?, 
                            unidade_medida = ?, 
                            peso = ?, 
                            embalagem_dimensao_atura = ?, 
                            embalagem_dimensao_largura = ?, 
                            embalagem_dimensao_profundidade = ?
                            WHERE produto_id = ?'
                : 'INSERT INTO produto_detalhes (
                              descricao,
                              fabricante, 
                              codigo_barras,
                              unidade_medida,
                              peso, 
                              embalagem_dimensao_atura,
                              embalagem_dimensao_largura, 
                              embalagem_dimensao_profundidade,
                              produto_id
                            ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)';

            $stmt = $this->database->prepare($detalheStmt);
            $stmt->bindValue(1, $produto->detalhes()->getDescricao());
            $stmt->bindValue(2, $produto->detalhes()->getFabricante());
            $stmt->bindValue(3, $produto->detalhes()->getCodigoBarras());
            $stmt->bindValue(4, $produto->detalhes()->getUnidadeMedida());
            $stmt->bindValue(5, $produto->detalhes()->embalagem()->getPeso());
            $stmt->bindValue(6, $produto->detalhes()->embalagem()->getDimensaoAltura());
            $stmt->bindValue(7, $produto->detalhes()->embalagem()->getDimensaoLargura());
            $stmt->bindValue(8, $produto->detalhes()->embalagem()->getDimensaoProfundidade());
            $stmt->bindValue(9, $produto->getId());

            $stmt->execute();
            $this->database->query('COMMIT');
        } catch (Throwable $throwable) {
            $this->database->query('ROLLBACK;');
            return null;
        }

        return clone $produto;
    }

    public function obterPorId(int $id): ?Produto
    {
        $consulta = $this->getConsultaProduto() . ' WHERE p.id = ?';
        $stmt = $this->database->prepare($consulta);
        $stmt->bindParam(1, $id, PDO::PARAM_INT);

        $produto = null;
        if ($stmt->execute() && ($registro = $stmt->fetch(PDO::FETCH_OBJ))) {
            $produto = $this->obterEntidadeProduto($registro);
        }

        return $produto;
    }

    public function obterTodos(): ProdutoCollection
    {
        $stmt = $this->getConsultaProduto();
        $stmt = $this->database->prepare($stmt);
        $colecao = new ProdutoCollection();
        if ($stmt->execute()) {
            while ($registro = $stmt->fetch(PDO::FETCH_OBJ)) {
                $produto = $this->obterEntidadeProduto($registro);
                $colecao->adicionar($produto);
            }
        }

        return $colecao;
    }

    public function removerPorId(int $id): bool
    {
        try {
            $this->database->query('BEGIN TRANSACTION');

            $stmt = $this->database->prepare("DELETE FROM produto_detalhes WHERE produto_id = ?");
            $stmt->bindParam(1, $id, PDO::PARAM_INT);

            if ($stmt->execute()) {
                $stmt = $this->database->prepare("DELETE FROM produtos WHERE id = ?");
                $stmt->bindParam(1, $id, PDO::PARAM_INT);
            }

            $this->database->query('COMMIT');
            return true;
        } catch (Throwable $throwable) {
            $this->database->query('ROLLBACK');
        }

        return false;
    }

    protected function obterEntidadeProduto(mixed $registro): Produto
    {
        $categoria = $this->categoriaServico->obterPorId($registro->categoria_id);
        $produto = Produto::criar(
            $registro->descricao,
            $categoria,
        );
        $produto->setId($registro->id);
        $produto->setValorVenda($registro->valor_venda);
        $produto->setValorCompra($registro->valor_compra);

        $estoque = new Estoque();
        $estoque->setSku($registro->sku);
        $estoque->setNivelAtual($registro->estoque_atual);
        $estoque->setNivelMinimo($registro->estoque_minimo);
        $produto->setEstoque($estoque);

        $detalhes = new Detalhes($registro->descricao);
        $detalhes->setCodigoBarras($registro->codigo_barras);
        $detalhes->setFabricante($registro->fabricante);
        $detalhes->setUnidadeMedida($registro->unidade_medida);
        $detalhes->setProdutoId($registro->id);

        $embalagem = new Embalagem();
        $embalagem->setDimensaoAltura($registro->embalagem_dimensao_atura);
        $embalagem->setDimensaoLargura($registro->embalagem_dimensao_largura);
        $embalagem->setDimensaoProfundidade($registro->embalagem_dimensao_profundidade);
        $detalhes->setEmbalagem($embalagem);
        $produto->setDetalhes($detalhes);

        $produto->setDataCriacao(DateTime::createFromFormat('Y-m-d H:i:s', $registro->data_criacao));
        $produto->setDataAtualizacao(DateTime::createFromFormat('Y-m-d H:i:s', $registro->data_atualizacao));

        $funcionarioCriacao = $this->funcionarioServico->obterPorId($registro->criacao_funcionario_id);
        $funcionarioAtualizacao = $this->funcionarioServico->obterPorId($registro->atualizacao_funcionario_id);
        $produto->setFuncionarioCriacao($funcionarioCriacao);
        $produto->setFuncionarioAtualizacao($funcionarioAtualizacao);
        return $produto;
    }

    protected function getConsultaProduto(): string
    {
        return 'SELECT 
                    p.id,
                    p.sku,
                    p.categoria_id,
                    p.valor_compra,
                    p.valor_venda,
                    p.estoque_atual,
                    p.estoque_minimo,
                    p.data_criacao,
                    p.data_atualizacao,
                    p.criacao_funcionario_id,
                    p.atualizacao_funcionario_id,
                    pd.descricao,
                    pd.fabricante,
                    pd.codigo_barras,
                    pd.unidade_medida,
                    pd.peso,
                    pd.embalagem_dimensao_atura,
                    pd.embalagem_dimensao_largura,
                    pd.embalagem_dimensao_profundidade
                  FROM produtos p 
                 INNER JOIN produto_detalhes pd on p.id = pd.produto_id';
    }
}