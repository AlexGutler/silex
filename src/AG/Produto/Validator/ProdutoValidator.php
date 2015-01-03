<?php

namespace AG\Produto\Validator;
use AG\Produto\Entity\Produto;

class ProdutoValidator
{
    private $produto;

    public function validate(Produto $produto)
    {
        $this->produto = $produto;

        if (! is_string($this->produto->getNome())
            || ! is_string($this->produto->getDescricao())
            || ! is_numeric($this->produto->getValor())){
            return false;
        }

        return true;
    }
}