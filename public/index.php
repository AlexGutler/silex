<?php

require_once __DIR__.'/../bootstrap.php';

require_once __DIR__.'/../config/connectionDB.php';

$app['conn'] = connectionDB();

use AG\Produto\Entity\Produto;
use AG\Produto\Mapper\ProdutoMapper;
use AG\Produto\Service\ProdutoService;

//
$app['produto'] = function(){ return new Produto(); };
$app['mapper'] = function() use ($app) { return new ProdutoMapper($app['conn']);};

// armazenar o service do produto
$app['produtoService'] = function() use ($app)
{
    return new ProdutoService($app['produto'], $app['mapper']);
};

// rota para listar dos produtos
$app->get("/produtos", function() use ($app)
{
    /*
    $dados = array(
        'nome' => 'Playstation 4',
        'descricao' => 'Console da nova Geração Sony',
        'valor' => 2200
    );

    $result = $app['produtoService']->insert($dados);

    return 'Produto: '.$result->getNome().'<br>Descrição: '.$result->getDescricao().'<br>Valor: '.$result->getValor();
    */

    return $app['twig']->render('produtos.twig', []);
})->bind('produtos')
;

// rota para criar novo produto
$app->get("/produtos/novo", function() use($app){
    return $app['twig']->render('produto-novo.twig', []);
})->bind('produto-novo')
;

// rota para editar um produto
$app->get("/produtos/{id}/editar", function($id) use($app){
    return $app['twig']->render('produto-editar.twig', ['id' => $id]);
})->bind('produto-editar')
;

// rota index
$app->get("/", function() use($app){
    return $app['twig']->render('index.twig', []);
})->bind('index')
;

$app->run();