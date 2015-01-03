<?php

use Silex\Application,
    Silex\ControllerCollection,
    Silex\ControllerProviderInterface;
use Symfony\Component\HttpFoundation\Response,
    Symfony\Component\HttpFoundation\Request;


class ApiProdutoControllerProvider implements ControllerProviderInterface
{
    public function connect(Application $app)
    {
        $controllers = $app['controllers_factory'];

        $controllers->get('/', function (Application $app) {
            $produtos = $app['produtoService']->fetchAll();

            return $app->json($produtos);
        })->bind('api-produtos');

        $controllers->get('/{id}', function (Application $app, $id) {
            $produto = $app['produtoService']->fetch($id);

            return $app->json($produto);
        })->bind('produtos');
    }
}