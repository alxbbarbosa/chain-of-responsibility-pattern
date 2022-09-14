<?php

use Infra\Middleware\Layers\Routing\Route;

Route::get('/logout', 'Seguranca\Login\Logout::action');
Route::get('/', 'Home\Page::action');
Route::get('/compras', 'Compras\Home::action');
Route::get('/compras/orcamentos/listagem', 'Compras\Orcamento\Listagem::action');
Route::get('/compras/orcamentos/edicao/[\d]+', 'Compras\Orcamento\Edicao::action');
Route::get('/compras/orcamentos/aprovacao/[\d]+', 'Compras\Orcamento\Aprovacao::action');
Route::get('/estoque/produtos/listagem', 'Estoque\Produtos\Listagem::action');
Route::get('/seguranca/usuarios/listagem', 'Seguranca\Usuarios\Listagem::action');
