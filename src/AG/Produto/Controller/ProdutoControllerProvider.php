<?php

namespace AG\Produto\Controller;

use Silex\Application,
    Silex\ControllerCollection,
    Silex\ControllerProviderInterface;
use Symfony\Component\HttpFoundation\Response,
    Symfony\Component\HttpFoundation\Request;

class ProdutoControllerProvider implements ControllerProviderInterface
{
    public function connect(Application $app)
    {
        $controllers = $app['controllers_factory'];

        // listagem de produtos
        $controllers->get('/', function (Application $app) {
            $produtos = $app['produtoService']->fetchAll();

            return $app['twig']->render('produtos.twig', ['produtos' => $produtos, 'deleted' => false]);
        })->bind('produtos');

        // formulario para cadastro de novo produto
        $controllers->get("/novo", function() use($app){
            return $app['twig']->render('produto-novo.twig', ['id' => null]);
        })->bind('produto-novo');

        // post dos dados do novo produto
        $controllers->post("/novo", function(Request $request) use($app) {
            $dados = $request->request->all();
            $result = $app['produtoService']->insert($dados);

            if ($result->getId()) {
                return $app['twig']->render('produto-sucesso.twig', []);
            } else {
                $app->abort(500, "Erro ao salvar o produto");
            }
        })->bind('produto-salvar');

        // deletar produto
        $controllers->get('/{id}/deletar', function($id) use($app){
            $result = $app['produtoService']->delete($id);
            if ($result)
            {
                $produtos = $app['produtoService']->fetchAll();
                return $app['twig']->render('produtos.twig', ['produtos' => $produtos, 'deleted' => true]);
            } else {
                $app->abort(500, "Erro ao deletar o produto");
            }
        })->bind('produto-deletar');

        // editar produto
        $controllers->get("/{id}/editar", function($id) use($app){
            $result = $app['produtoService']->fetch($id);

            return $app['twig']->render('produto-novo.twig',
                ['id' => $id, 'nome' => $result['nome'], 'descricao' => $result['descricao'], 'valor' => $result['valor']]);
        })->bind('produto-editar');

        // post dos dados da edição
        $controllers->post("/editar", function(Request $request) use($app) {
            $dados = $request->request->all();
            $result = $app['produtoService']->update($dados);

            if ($result) {
                return $app['twig']->render('produto-sucesso.twig', []);
            } else {
                $app->abort(500, "Erro ao atualizar o produto");
            }
        })->bind('produto-atualizar');

        return $controllers;
    }
}