<?php

namespace AG\Produto\Controller;

use Silex\Application;
use Silex\ControllerCollection;
use Silex\ControllerProviderInterface;

class ProdutoContollerProvider implements ControllerProviderInterface
{
    public function connect(Application $app)
    {
        $controllers = $app['controllers_factory'];

        $controllers->get('/produtos', function (Application $app) {
            $produtos = $app['produtoService']->fetchAll();

            return $app['twig']->render('produtos.twig', ['produtos' => $produtos, 'deleted' => false]);
        });

        return $controllers;
    }
}