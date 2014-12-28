<?php

require_once __DIR__.'/../bootstrap.php';

require_once __DIR__ . '/../src/AG/config/connectionDB.php';

$app['conn'] = connectionDB();

use AG\Produto\Entity\Produto;
use AG\Produto\Mapper\ProdutoMapper;
use AG\Produto\Service\ProdutoService;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

// armazenando a entidade produto
$app['produto'] = function(){ return new Produto(); };
//armazenando o mapper do produto
$app['mapper'] = function() use ($app) { return new ProdutoMapper($app['conn']);};
// armazenar o service do produto
$app['produtoService'] = function() use ($app)
{
    return new ProdutoService($app['produto'], $app['mapper']);
};

// rota para listagem dos produtos
$app->get("/produtos", function() use ($app)
{
    $produtos = $app['produtoService']->fetchAll();

    return $app['twig']->render('produtos.twig', ['produtos'=>$produtos, 'deleted' => false]);
})->bind('produtos');

// controller para deletar um produto e voltar a listagem
$app->get('/produto/deletar/{id}', function($id) use($app){
    $result = $app['produtoService']->delete($id);
    if ($result)
    {
        $produtos = $app['produtoService']->fetchAll();
        return $app['twig']->render('produtos.twig', ['produtos' => $produtos, 'deleted' => true]);
    } else {
        $app->abort(500, "Erro ao deletar o produto");
    }
})->bind('produto-deletar');

// rota para criar novo produto
$app->get("/produtos/novo", function() use($app){
    return $app['twig']->render('produto-novo.twig', ['id' => null]);
})->bind('produto-novo');

// controller para salvar novo produto
$app->post("/produtos/novo", function(Request $request) use($app) {
    $dados = $request->request->all();

    $result = $app['produtoService']->insert($dados);

    if ($result->getId()) {
        return $app['twig']->render('produto-sucesso.twig', []);
    } else {
        $app->abort(500, "Erro ao salvar o produto");
    }
})->bind('produto-salvar');

// rota para editar um produto
$app->get("/produtos/{id}/editar", function($id) use($app){
    $result = $app['produtoService']->fetch($id);

    return $app['twig']->render('produto-novo.twig',
        ['id' => $id, 'nome' => $result['nome'], 'descricao' => $result['descricao'], 'valor' => $result['valor']]);
})->bind('produto-editar');

// controller para atualizar produto
$app->post("/produtos/editar", function(Request $request) use($app) {
    $dados = $request->request->all();
    //var_dump($dados);
    $result = $app['produtoService']->update($dados);

    if ($result) {
        return $app['twig']->render('produto-sucesso.twig', []);
    } else {
        $app->abort(500, "Erro ao atualizar o produto");
    }
})->bind('produto-atualizar');

// rota index
$app->get("/", function() use($app){
    return $app['twig']->render('index.twig', []);
})->bind('index');

$app->run();