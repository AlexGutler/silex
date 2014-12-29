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
        $this->produto->setNome($data['nome'])
                      ->setDescricao($data['descricao'])
                      ->setValor($data['valor']);

        $mapper = $this->mapper;

        $id = $mapper->insert($this->produto);

        if($id <> null)
        {
            $this->produto->setId($id);
            return $this->produto;
        } else {
            return null;
        }
    }

    public function update(array $data)
    {
        $this->produto->setId($data['id'])
            ->setNome($data['nome'])
            ->setDescricao($data['descricao'])
            ->setValor($data['valor']);
        $mapper = $this->mapper;
        return $mapper->update($this->produto) ? true : false;
    }

    public function delete($id)
    {
        return  $this->mapper->delete($id) ? true : false;
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