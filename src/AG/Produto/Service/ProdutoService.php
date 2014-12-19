<?php

namespace AG\Produto\Service;

use AG\Produto\Entity\Produto,
    AG\Produto\Mapper\ProdutoMapper;

class ProdutoService
{
    private $produto;
    private $mapper;

    public function __construct(Produto $produto, ProdutoMapper $mapper)
    {
        $this->produto = $produto;
        $this->mapper = $mapper;
    }

    public function insert(array $data)
    {
        $produtoEntity = $this->produto;

        $produtoEntity->setNome($data['nome'])
                      ->setDescricao($data['descricao'])
                      ->setValor($data['valor']);

        $mapper = $this->mapper;

        $result = $mapper->insert($produtoEntity);

        return $result;
    }

}