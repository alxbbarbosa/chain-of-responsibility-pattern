<?php
$numberFormat = new NumberFormatter( 'pt_BR', NumberFormatter::CURRENCY );
$entidade = unserialize($login['entidade']);
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Detalhes de orçamentos</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-iYQeCzEYFbKjA/T2uDLTpkwGzCiq6soy8tYaI1GyVh/UjpbCx/TYkiZhlZB6+fzT" crossorigin="anonymous">
</head>
<body class="bg-light">
<?php include __DIR__ . '/../../Menu/menu.php' ?>
<div class="container-fluid mt-3">
    <nav style="--bs-breadcrumb-divider: url(&#34;data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='8' height='8'%3E%3Cpath d='M2.5 0L1 1.5 3.5 4 1 6.5 2.5 8l4-4-4-4z' fill='currentColor'/%3E%3C/svg%3E&#34;);" aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="/">Início</a></li>
            <li class="breadcrumb-item">Compras</li>
            <li class="breadcrumb-item">Listagem de Orçamentos</li>
            <li class="breadcrumb-item active" aria-current="page">Edição</li>
        </ol>
    </nav>
    <hr>
    <div>
        <div class="mb-3 row">
            <label for="id-orcamento" class="col-sm-2 col-form-label">Id:</label>
            <div class="col-sm-2">
                <input type="text"
                       readonly
                       class="form-control"
                       id="id-orcamento"
                       value="<?= $orcamento->getId() ?>">
            </div>
            <label for="data-solicitacao" class="col-sm-2 col-form-label">Data de Solicitação:</label>
            <div class="col-sm-2">
                <input type="text"
                       readonly
                       class="form-control"
                       id="data-solicitacao"
                       value="<?= $orcamento->getDataCriacao()->format('d/m/Y H:i') ?>">
            </div>
            <label for="data-atualizacao" class="col-sm-2 col-form-label">Data de Atualização:</label>
            <div class="col-sm-2">
                <input type="text"
                       readonly
                       class="form-control"
                       id="data-atualizacao"
                       value="<?= $orcamento->getDataAtualizacao()->format('d/m/Y H:i') ?>">
            </div>
        </div>
        <div class="mb-3 row">
            <label for="nome-solicitante" class="col-sm-2 col-form-label">Solicitante:</label>
            <div class="col-sm-6">
                <input type="text"
                       readonly
                       class="form-control"
                       id="nome-solicitante"
                       value="<?= $orcamento->getSolicitante()->getNome() ?>">
            </div>
            <label for="status-orcamento" class="col-sm-1 col-form-label">Status:</label>
            <div class="col-sm-2">
                <input type="text"
                       readonly
                       class="form-control"
                       id="status-orcamento"
                       value="<?= $orcamento->getStatus()->toString() ?>">
            </div>
            <div class="col-sm-1">
                <a class="btn btn-primary btn-sm" href="/compras/orcamentos/aprovacao/<?= $orcamento->getId() ?>">Solicitar Aprovação</a>
            </div>
        </div>
        <div class="mb-3 row">
            <label for="observacoes-orcamento" class="col-sm-2 col-form-label">Observações:</label>
            <div class="col-sm-10">
                <input type="text"
                       readonly
                       class="form-control"
                       id="observacoes-orcamento"
                       value="<?= $orcamento->getObservacoes() ?>">
            </div>
        </div>
    </div>
    <hr>
    <h5>Itens</h5>
    <table class="table table-secondary table-sm table-striped">
        <thead class="table-dark">
        <tr>
            <th scope="col">#</th>
            <th scope="col">Descrição</th>
            <th scope="col">Valor Un.</th>
            <th scope="col">Qtd</th>
            <th scope="col">Valor Total</th>
            <th scope="col">Ações</th>
        </tr>
        </thead>
        <tbody>
        <tr>
            <td><div class="col-sm-4">
                    <input type="text"
                           class="form-control"
                           id="qtd-item-novo">
                </div>
            </td>
            <td></td>
            <td></td>
            <td><div class="col-sm-4">
                    <input type="text"
                           class="form-control"
                           id="qtd-item-novo">
                </div>
            <td></td>
            </td>
            <td>
                <a class="btn btn-primary btn-sm" href="/compras/orcamentos/<?= $orcamento->getId() ?>/adicionar-item">Adicionar</a>
            </td>
        </tr>
        <?php
        /** @var \App\Modulos\Compras\Entidades\Orcamento\Item $item */
        foreach ($orcamento->getItens() as $item) : ?>
            <tr>
                <td><?= $item->getId() ?></td>
                <td><?= $item->getProduto()->getDescricao() ?></td>
                <td><?= $numberFormat->format($item->getValorUnitario()) ?></td>
                <td><div class="col-sm-4">
                        <input type="text"
                           class="form-control"
                           id="qtd-item-<?= $item->getId() ?>"
                           value="<?= $item->getQuantidade() ?>">
                    </div></td>
                <td><?= $numberFormat->format($item->getValorTotal()) ?></td>
                <td class="col-sm-2">
                    <a class="btn btn-warning btn-sm" href="/compras/orcamentos/<?= $orcamento->getId() ?>/item/<?= $item->getId() ?>/alterar">Alterar</a>
                    <a class="btn btn-danger btn-sm" href="/compras/orcamentos/<?= $orcamento->getId() ?>/item/<?= $item->getId() ?>/remover">Remover</a></td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
    <div>
        <div class="mb-3 row">
            <label for="condicoes-orcamento" class="col-sm-2 col-form-label">Condições de Pagamento:</label>
            <div class="col-sm-6">
                <input type="text"
                       readonly
                       class="form-control"
                       id="condicoes-orcamento"
                       value="<?= $orcamento->getCondicoesPagamento() ?>">
            </div>
            <label for="total-orcamento" class="col-sm-2 col-form-label">Valor total:</label>
            <div class="col-sm-2">
                <input type="text"
                       readonly
                       class="form-control"
                       id="total-orcamento"
                       value="<?= $numberFormat->format($orcamento->getItens()->obterValorTotal()) ?>">
            </div>
        </div>
    </div>
    <hr>
    <h5>Aprovadores</h5>
    <table class="table table-secondary table-sm table-striped">
        <thead class="table-dark">
        <tr>
            <th scope="col">#</th>
            <th scope="col">Aprovador</th>
            <th scope="col">E-mail</th>
            <th scope="col">Função</th>
            <th scope="col">Departamento</th>
            <th scope="col">Status</th>
            <th scope="col">Ação</th>
        </tr>
        </thead>
        <tbody>
        <?php
        $sequencia = 1;
        /** @var \App\Modulos\Compras\Entidades\Orcamento\Aprovador $aprovador */
        foreach ($orcamento->getAprovadores() as $aprovador) : ?>
            <tr>
                <td><?= $sequencia++ ?></td>
                <td><?= $aprovador->getFuncionario()->getNome() ?></td>
                <td><?= $aprovador->getFuncionario()->getEmail() ?></td>
                <td><?= $aprovador->getFuncionario()->getFuncao()->getNome() ?></td>
                <td><?= $aprovador->getFuncionario()->getDepartamento()->getNome() ?></td>
                <td><?= $aprovador->getStatus() ?></td>
                <td>
                    <?php
                    if ($aprovador->getFuncionario()->getId() === $entidade->getId()) : ?>
                    <a class="btn btn-success btn-sm" href="/compras/orcamentos/<?= $orcamento->getId() ?>/aprovador/<?= $aprovador->getFuncionario()->getId() ?>/aprovar">Aprovar</a>
                    <a class="btn btn-danger btn-sm" href="/compras/orcamentos/<?= $orcamento->getId() ?>/aprovador/<?= $aprovador->getFuncionario()->getId() ?>/reprovar">Reprovar</a></td>
                    <?php endif; ?>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-u1OknCvxWvY5kfmNBILK2hRnQC3Pr17a+RTT6rIHI7NnikvbZlHgTPOOmMi466C8" crossorigin="anonymous"></script>
</body>
</html>