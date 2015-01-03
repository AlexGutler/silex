<?php
require_once __DIR__.'/../bootstrap.php';

use AG\Database\DB;
use AG\Produto\Entity\Produto,
    AG\Produto\Mapper\ProdutoMapper,
    AG\Produto\Service\ProdutoService,
    AG\Produto\Controller\ProdutoControllerProvider,
    AG\Produto\Controller\ApiProdutoControllerProvider;
use Symfony\Component\HttpFoundation\Response,
    Symfony\Component\HttpFoundation\Request;

/** CONFIGURAÇÃO DE DEPENDENCIAS - PIMPLE */
// criando a conexão
$config = include __DIR__ .'/../src/AG/config/config.php';
$app['conn'] = function() use ($config){
    return (new DB($config['db']['dsn'], $config['db']['username'], $config['db']['password']))->getConnection();
};
// armazenando a entidade produto
$app['produto'] = function(){
    return new Produto();
};
//armazenando o mapper do produto
$app['mapper'] = function() use ($app) {
    return new ProdutoMapper($app['conn']);
};
// armazenar o service do produto
$app['produtoService'] = function() use ($app) {
    return new ProdutoService($app['produto'], $app['mapper']);
};

// mount no ControllerProvider de Produtos
$app->mount('/produtos', new ProdutoControllerProvider());

// mount no API REST
$app->mount('/api/produtos', new ApiProdutoControllerProvider());

// rota index
$app->get("/", function() use($app){
    return $app['twig']->render('index.twig', []);
})->bind('index');

$app->run();