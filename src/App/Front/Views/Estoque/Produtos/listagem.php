<?php

use App\Modulos\Estoque\Entidades\Produto;

$numberFormat = new NumberFormatter( 'pt_BR', NumberFormatter::CURRENCY );

?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Listagem de produtos</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-iYQeCzEYFbKjA/T2uDLTpkwGzCiq6soy8tYaI1GyVh/UjpbCx/TYkiZhlZB6+fzT" crossorigin="anonymous">
</head>
<body class="bg-light">
<?php include __DIR__ . '/../../Menu/menu.php' ?>
<div class="container-fluid mt-3">
    <nav style="--bs-breadcrumb-divider: url(&#34;data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='8' height='8'%3E%3Cpath d='M2.5 0L1 1.5 3.5 4 1 6.5 2.5 8l4-4-4-4z' fill='currentColor'/%3E%3C/svg%3E&#34;);" aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="/">Início</a></li>
            <li class="breadcrumb-item">Estoque</li>
            <li class="breadcrumb-item active" aria-current="page">Listagem de Produtos</li>
        </ol>
    </nav>
    <hr>
    <table class="table table-sm table-secondary table-striped">
        <thead class="table-light">
        <tr>
            <th scope="col">#</th>
            <th scope="col">SKU</th>
            <th scope="col">Descrição</th>
            <th scope="col">Valor de Compra</th>
            <th scope="col">Valor de Venda</th>
            <th scope="col">Nível Máximo</th>
            <th scope="col">Nível Minimo</th>
            <th scope="col">Criado Em</th>
            <th scope="col">Atualizado Em</th>
            <th scope="col">Ações</th>
        </tr>
        </thead>
        <tbody>
        <?php
        /** @var Produto $produto */
        foreach ($produtos as $produto) : ?>
            <tr>
                <td><?= $produto->getId() ?></td>
                <td><?= $produto->estoque()->getSku() ?></td>
                <td><?= $produto->getDescricao() ?></td>
                <td><?= $numberFormat->format($produto->getValorCompra()) ?></td>
                <td><?= $numberFormat->format($produto->getValorVenda()) ?></td>
                <td><?= $produto->estoque()->getNivelAtual() ?></td>
                <td><?= $produto->estoque()->getNivelMinimo() ?></td>
                <td><?= $produto->getDataCriacao()?->format('d/m/Y H:i') ?></td>
                <td><?= $produto->getDataAtualizacao()?->format('d/m/Y H:i') ?></td>
                <td><a class="btn btn-info btn-sm" href="/estoque/produtos/edicao/<?= $produto->getId() ?>">Exibir</a></td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
</div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-u1OknCvxWvY5kfmNBILK2hRnQC3Pr17a+RTT6rIHI7NnikvbZlHgTPOOmMi466C8" crossorigin="anonymous"></script>
</body>
</html>
