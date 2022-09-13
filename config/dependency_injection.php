<?php

use App\ConsoleApplication;
use App\Modulos\Compras\FornecedorService;
use App\Modulos\Compras\FornecedorServiceInterface;
use App\Modulos\Compras\OrcamentoService;
use App\Modulos\Compras\OrcamentoServiceInterface;
use App\Modulos\Compras\Repository\AprovadorRepository;
use App\Modulos\Compras\Repository\AprovadorRepositoryInterface;
use App\Modulos\Compras\Repository\FornecedorRepository;
use App\Modulos\Compras\Repository\FornecedorRepositoryInterface;
use App\Modulos\Compras\Repository\OrcamentoRepository;
use App\Modulos\Compras\Repository\OrcamentoRepositoryInterface;
use App\Modulos\Compras\Servicos\Orcamento\AprovadorService;
use App\Modulos\Compras\Servicos\Orcamento\AprovadorServiceInterface;
use App\Modulos\Estoque\Produto\CategoriaService;
use App\Modulos\Estoque\Produto\CategoriaServiceInterface;
use App\Modulos\Estoque\ProdutoService;
use App\Modulos\Estoque\ProdutoServiceInterface;
use App\Modulos\Estoque\Repository\Produto\CategoriaRepository;
use App\Modulos\Estoque\Repository\Produto\CategoriaRepositoryInterface;
use App\Modulos\Estoque\Repository\ProdutoRepository;
use App\Modulos\Estoque\Repository\ProdutoRepositoryInterface;
use App\Modulos\Localizacoes\LogradouroService;
use App\Modulos\Localizacoes\LogradouroServiceInterface;
use App\Modulos\Localizacoes\Repositorios\LogradouroRepository;
use App\Modulos\Localizacoes\Repositorios\LogradouroRepositoryInterface;
use App\Modulos\Localizacoes\Servicos\CepService;
use App\Modulos\Localizacoes\Servicos\CepServiceInterface;
use App\Modulos\RecursosHumanos\DepartamentoService;
use App\Modulos\RecursosHumanos\DepartamentoServiceInterface;
use App\Modulos\RecursosHumanos\FuncaoService;
use App\Modulos\RecursosHumanos\FuncaoServiceInterface;
use App\Modulos\RecursosHumanos\FuncionarioService;
use App\Modulos\RecursosHumanos\FuncionarioServiceInterface;
use App\Modulos\RecursosHumanos\Repository\DepartamentoRepository;
use App\Modulos\RecursosHumanos\Repository\DepartamentoRepositoryInterface;
use App\Modulos\RecursosHumanos\Repository\FuncaoRepository;
use App\Modulos\RecursosHumanos\Repository\FuncaoRepositoryInterface;
use App\Modulos\RecursosHumanos\Repository\FuncionarioRepository;
use App\Modulos\RecursosHumanos\Repository\FuncionarioRepositoryInterface;
use App\Modulos\Seguranca\Repository\UsuarioRepository;
use App\Modulos\Seguranca\Repository\UsuarioRepositoryInterface;
use App\Modulos\Seguranca\UsuarioService;
use App\Modulos\Seguranca\UsuarioServiceInterface;
use Infra\Config\Database;
use Infra\Config\DatabaseInterface;
use Infra\Core\Application;
use Infra\Middleware\Layers\DefaultLayer;
use Symfony\Component\DependencyInjection\Reference;

$container->register('console-app', ConsoleApplication::class)
    ->addArgument($container);

$container->register('default-layer', DefaultLayer::class)
    ->addArgument($container);

$container->register('web-app', Application::class)
    ->addArgument($container);

$container->register(DatabaseInterface::class, Database::class);

$container->register(CepServiceInterface::class, CepService::class);

$container->register(LogradouroRepositoryInterface::class, LogradouroRepository::class);

$container->register(LogradouroServiceInterface::class, LogradouroService::class)
    ->addArgument(new Reference(LogradouroRepositoryInterface::class));

$container->register(CategoriaRepositoryInterface::class, CategoriaRepository::class);

$container->register(CategoriaServiceInterface::class, CategoriaService::class)
    ->addArgument(new Reference(CategoriaRepositoryInterface::class));

$container->register(ProdutoRepositoryInterface::class, ProdutoRepository::class)
    ->addArgument(new Reference(CategoriaServiceInterface::class))
    ->addArgument(new Reference(FuncionarioServiceInterface::class));

$container->register(ProdutoServiceInterface::class, ProdutoService::class)
    ->addArgument(new Reference(ProdutoRepositoryInterface::class));

$container->register(UsuarioRepositoryInterface::class, UsuarioRepository::class)
    ->addArgument(new Reference(FuncionarioServiceInterface::class));

$container->register(UsuarioServiceInterface::class, UsuarioService::class)
    ->addArgument(new Reference(UsuarioRepositoryInterface::class));

$container->register(FuncaoRepositoryInterface::class, FuncaoRepository::class);

$container->register(FuncaoServiceInterface::class, FuncaoService::class)
    ->addArgument(new Reference(FuncaoRepositoryInterface::class));

$container->register(DepartamentoRepositoryInterface::class, DepartamentoRepository::class);

$container->register(DepartamentoServiceInterface::class, DepartamentoService::class)
    ->addArgument(new Reference(DepartamentoRepositoryInterface::class));

$container->register(FuncionarioRepositoryInterface::class, FuncionarioRepository::class)
    ->addArgument(new Reference(DepartamentoServiceInterface::class))
    ->addArgument(new Reference(FuncaoServiceInterface::class));

$container->register(FuncionarioServiceInterface::class, FuncionarioService::class)
    ->addArgument(new Reference(FuncionarioRepositoryInterface::class));

$container->register(FornecedorRepositoryInterface::class, FornecedorRepository::class)
    ->addArgument(new Reference(LogradouroServiceInterface::class));

$container->register(FornecedorServiceInterface::class, FornecedorService::class)
    ->addArgument(new Reference(FornecedorRepositoryInterface::class));

$container->register(OrcamentoRepositoryInterface::class, OrcamentoRepository::class)
    ->addArgument(new Reference(FuncionarioServiceInterface::class))
    ->addArgument(new Reference(FornecedorServiceInterface::class))
    ->addArgument(new Reference(ProdutoServiceInterface::class));

$container->register(OrcamentoServiceInterface::class, OrcamentoService::class)
    ->addArgument(new Reference(OrcamentoRepositoryInterface::class))
    ->addArgument($container);

$container->register(AprovadorRepositoryInterface::class, AprovadorRepository::class)
    ->addArgument(new Reference(OrcamentoServiceInterface::class))
    ->addArgument(new Reference(FuncionarioServiceInterface::class));

$container->register(AprovadorServiceInterface::class, AprovadorService::class)
    ->addArgument(new Reference(AprovadorRepositoryInterface::class))
    ->addArgument($container);
