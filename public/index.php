<?php

require_once __DIR__.'/../bootstrap.php';

$clientes = array(
    0 => array(
        'nome' => 'Alex Gutler',
        'email' => 'alex@grupolima.net.br',
        'cpf-cnpj' => 13535524709
    ),
    1 => array(
        'nome' => 'Renan Pissaia',
        'email' => 'renan@email.com.br',
        'cpf-cnpj' => 45678912332
    ),
    2 => array(
        'nome' => 'Henrique Biasuti',
        'email' => 'henrique@email.com.br',
        'cpf-cnpj' => 45625893612
    ),
    3 => array(
        'nome' => 'Simone Sousa',
        'email' => 'simone@email.com.br',
        'cpf-cnpj' => 74125896312
    )
);

$app->get("/clientes", function(\Silex\Application $app) use ($clientes){
    return $app->json($clientes);
});

$app->run();