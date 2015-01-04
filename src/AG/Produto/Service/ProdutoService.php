<?php

namespace AG\Produto\Service;

use AG\Produto\Entity\Produto,
    AG\Produto\Mapper\ProdutoMapper,
    AG\Produto\Validator\ProdutoValidator;
use Symfony\Component\HttpFoundation\Request;

class ProdutoService
{
    private $produto;
    private $mapper;
    private $produtoValidator;

    public function __construct(Produto $produto, ProdutoMapper $mapper, ProdutoValidator $produtoValidator)
    {
        $this->produto = $produto;
        $this->mapper = $mapper;
        $this->produtoValidator = $produtoValidator;
    }

    public function insert(Request $request)
    {
        $this->produto->setNome($request->get('nome'))
                      ->setDescricao($request->get('descricao'))
                      ->setValor($request->get('valor'));

        if(is_string($this->produtoValidator->validate($this->produto)))
        {
            return $this->produtoValidator->validate($this->produto);
        }

        return $this->mapper->insert($this->produto) ? true : false;
    }

    public function update(Request $request, $id)
    {
        $this->produto->setId($id)
            ->setNome($request->get('nome'))
            ->setDescricao($request->get('descricao'))
            ->setValor($request->get('valor'));

        if (is_string($this->produtoValidator->validate($this->produto)))
        {
            return $this->produtoValidator->validate($this->produto);
        }

        return $this->mapper->update($this->produto) ? true : false;
    }

    public function delete($id)
    {
        return $this->mapper->delete($id);
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