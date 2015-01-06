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
            //return $app['twig']->render('produto-novo.twig', ['id' => null]);
            return $app['twig']->render(
                'produto-novo.twig',
                [
                    'id' => null,
                    'errors' => array('nome'=>null,'descricao'=>null,'valor'=>null),
                    'produto' => array('nome'=>null,'descricao'=>null,'valor'=>null)
                ]);
        })->bind('produto-novo');

        // post dos dados do novo produto
        $controllers->post("/novo", function(Request $request) use($app) {
            $result = $app['produtoService']->insert($request);

            if (!is_array($result)) {
                return $app['twig']->render('produto-sucesso.twig', []);
            } else {
                return $app['twig']->render('produto-novo.twig',
                    [
                        'id' => null,
                        'errors' => $result,
                        'produto' => $request->request->all()
                    ]);
                //$app->abort(500, $result);
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
            $produto = $app['produtoService']->fetch($id);

            return $app['twig']->render('produto-novo.twig',
                ['id' => $id, 'produto' => $produto, 'errors' => array('nome'=>null,'descricao'=>null,'valor'=>null)]);
        })->bind('produto-editar');

        // post dos dados da edição
        $controllers->post("/{id}/editar", function(Request $request, $id) use($app) {
            $result = $app['produtoService']->update($request, $id);

            if (!is_array($result)) {
                return $app['twig']->render('produto-sucesso.twig', []);
            } else {
                return $app['twig']->render('produto-novo.twig',
                    [
                        'id' => $id,
                        'produto' => $request->request->all(),
                        'errors' => $result
                    ]);
                //$app->abort(500, $result);
            }
        })->bind('produto-atualizar');

        return $controllers;
    }
}