<?php

namespace AG\Produto\Controller;

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

        // listar todos
        $controllers->get('/', function (Application $app) {
            $produtos = $app['produtoService']->fetchAll();

            return $app->json($produtos);
        })->bind('api-produtos-listar');

        // listar apenas 1
        $controllers->get('/{id}', function (Application $app, $id) {
            $produto = $app['produtoService']->fetch($id);
            if (! $produto) { return $app->json(['erro' => "Produto não encontrado."]); }

            return $app->json($produto);
        })->bind('api-produtos-listar-id');

        // cadastrar
        $controllers->post("/", function(Request $request) use($app) {
            $dados = [
                'nome' => $request->get('nome'),
                'descricao' => $request->get('descricao'),
                'valor' => $request->get('valor')
            ];

            if (! isset($dados['nome'])) {
                return $app->json(['erro' => "O Nome é Obrigatório"]);
            }
            if(! isset($dados['descricao'])){
                return $app->json(['erro' => "A Descrição é Obrigatória"]);
            }
            if(! isset($dados['valor'])){
                return $app->json(['erro' => "O Valor é Obrigatório"]);
            }

            $result = $app['produtoService']->insert($dados);

            if (! empty($result)) {
                return $app->json(['success'=> "Produto Cadastrado com Sucesso!"]);
            } else {
                return $app->json(['erro'=> "Erro ao salvar o produto"]);
            }
        })->bind('api-produtos-cadastrar');

        // alterar
        $controllers->put("/{id}", function($id, Request $request) use($app) {
            $dados = [
                'nome' => $request->get('nome'),
                'descricao' => $request->get('descricao'),
                'valor' => $request->get('valor'),
                'id' => $id,
            ];

            if (! isset($dados['nome'])) {
                return $app->json(['erro' => "O Nome é Obrigatório"]);
            }
            if(! isset($dados['descricao'])){
                return $app->json(['erro' => "A Descrição é Obrigatória"]);
            }
            if(! isset($dados['valor'])){
                return $app->json(['erro' => "O Valor é Obrigatório"]);
            }

            $result = $app['produtoService']->update($dados);

            if ($result) {
                return $app->json(['success' => "Produto Alterado com Sucesso!"]);
            } else {
                return $app->json(['erro '=> "Erro ao alterar o produto"]);
            }
        })->bind('api-produtos-alterar');

        // deletar
        $controllers->delete('/{id}', function($id) use($app){
            $result = $app['produtoService']->delete($id);

            if ($result) {
                return $app->json(['success' => "Produto Removido com Sucesso!"]);
            } else {
                return $app->json(['erro '=> "Erro ao Remover o produto"]);
            }
        })->bind('api-produtos-deletar');

        return $controllers;
    }
}