<?php

require_once __DIR__.'/../bootstrap.php';

require_once __DIR__ . '/../src/AG/config/connectionDB.php';

$app['conn'] = connectionDB();

use AG\Produto\Entity\Produto,
    AG\Produto\Mapper\ProdutoMapper,
    AG\Produto\Service\ProdutoService,
    AG\Produto\Controller\ProdutoContollerProvider;
use Symfony\Component\HttpFoundation\Response,
    Symfony\Component\HttpFoundation\Request;

// armazenando a entidade produto
$app['produto'] = function(){ return new Produto(); };
//armazenando o mapper do produto
$app['mapper'] = function() use ($app) { return new ProdutoMapper($app['conn']);};
// armazenar o service do produto
$app['produtoService'] = function() use ($app) {return new ProdutoService($app['produto'], $app['mapper']); };


// rota para listagem dos produtos
$app->mount('/produtos', new ProdutoContollerProvider());

// Controller para deletar um produto e voltar a listagem
$app->mount('/produtos/deletar/{id}', new ProdutoContollerProvider());

// rota para criar novo produto
$app->mount('/produtos/novo', new ProdutoContollerProvider());

// Controller para salvar novo produto
$app->mount('/produtos/novo', new ProdutoContollerProvider());

// rota para editar um produto
$app->mount('/produtos/{id}/editar', new ProdutoContollerProvider());

// Controller para atualizar produto
$app->mount('/produtos/editar', new ProdutoContollerProvider());

// rota index
$app->get("/", function() use($app){
    return $app['twig']->render('index.twig', []);
})->bind('index');

$app->run();