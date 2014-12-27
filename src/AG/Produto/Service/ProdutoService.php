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

        $id = $mapper->insert($produtoEntity);

        if($id <> null)
        {
            $produtoEntity->setId($id);
            return $produtoEntity;
        } else {
            return null;
        }
    }

    public function update(array $data)
    {
        $produtoEntity = $this->produto;
        //var_dump($data);
        $produtoEntity->setId($data['id'])
            ->setNome($data['nome'])
            ->setDescricao($data['descricao'])
            ->setValor($data['valor']);
        $mapper = $this->mapper;
        return $mapper->update($produtoEntity) ? true : false;
    }

    public function delete($id)
    {
        $mapper = $this->mapper;
        return $mapper->delete($id) ? true : false;
    }

    public function fetch($id)
    {
        $dados = $this->mapper->fetch($id);

        return $dados;
    }

    public function fetchAll()
    {
        $dados = $this->mapper->fetchAll();

        return $dados;
    }

}