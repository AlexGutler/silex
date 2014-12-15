<?php

require_once __DIR__.'/../bootstrap.php';

/*use Symfony\Component\HttpFoundation\Response;
$response = new Response();*/

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

$app->get("/clientes", function() use ($clientes){
    $result = "";
    $result .= '<h1>Listagem de Clientes:</h1>';

    foreach ($clientes as $cliente)
    {
        $result .= 'Nome: '.$cliente['nome'].'<br>';
        $result .= 'Email: '.$cliente['email'].'<br>';
        $result .= 'CPF/CNPJ: '.$cliente['cpf-cnpj'].'<br>';
        $result .= '-----------------------------------------------'.'<br>';
    }

    return $result;
});

$app->run();