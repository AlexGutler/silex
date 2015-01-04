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
    private $validator;

    public function __construct(Produto $produto, ProdutoMapper $mapper, ProdutoValidator $validator)
    {
        $this->produto = $produto;
        $this->mapper = $mapper;
        $this->validator = $validator;
    }

    public function insert(Request $request)
    {
        $this->produto->setNome($request->get('nome'))
                      ->setDescricao($request->get('descricao'))
                      ->setValor($request->get('valor'));
        //echo $this->produto->getNome().' - '.$this->produto->getDescricao().' - '.$this->produto->getValor().' - ALEX';

        if(!$this->validator->validate($this->produto))
        {
            return null;
        }

        $id = $this->mapper->insert($this->produto);
        $this->produto->setId($id);

        return $this->produto;
    }

    public function update(Request $request, $id)
    {
        $this->produto->setId($id)
            ->setNome($request->get('nome'))
            ->setDescricao($request->get('descricao'))
            ->setValor($request->get('valor'));

        if (!$this->validator->validate($this->produto))
        {
            return false;
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