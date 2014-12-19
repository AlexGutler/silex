<?php

require_once __DIR__.'/../bootstrap.php';

use AG\Produto\Entity\Produto;
use AG\Produto\Mapper\ProdutoMapper;
use AG\Produto\Service\ProdutoService;

$app['produto'] = function(){ return new Produto(); };
$app['mapper'] = function() use ($app) { return new ProdutoMapper($app['conn']);};

$app['produtoService'] = function() use ($app)
{
    return $produtoService = new ProdutoService($app['produto'], $app['mapper']);
};


$app->get("/produto", function() use ($app)
{
    $dados = array(
        'nome' => 'Playstation 4',
        'descricao' => 'Console da nova Geração Sony',
        'valor' => 2200
    );

    $result = $app['produtoService']->insert($dados);

    return $app->json($result);
});

$app->run();