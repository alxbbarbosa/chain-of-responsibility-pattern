<?php

use Infra\Middleware\Layers\Routing\Route;

Route::get('/logout', 'Seguranca\Login\Logout::action');
Route::get('/compras/orcamentos/listagem', 'Compras\Orcamento\Listagem::action');
Route::get('/compras/orcamentos/edicao/[\d]+', 'Compras\Orcamento\Edicao::action');
