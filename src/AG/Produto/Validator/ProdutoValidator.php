<?php

namespace AG\Produto\Validator;
use AG\Produto\Entity\Produto;
use AG\Validator\Validator;

class ProdutoValidator
{
    private $produto;
    private $erros;
    private $validator;

    public function __construct(Validator $validator)
    {
        $this->validator = $validator;

    }

    public function validate(Produto $produto)
    {
        $this->produto = $produto;
        $this->erros = '';

        if($this->validator->isEmpty($this->produto->getNome()))
        {
            $this->erros .= "{{ Nome }} Não pode estar vazio."."<br>";
        } elseif ($this->validator->maxStrLength($this->produto->getNome(), 255)) {
            $this->erros .= "{{ Nome }} Não pode conter mais que 255 caracteres."."<br>";
        }

        if($this->validator->isEmpty($this->produto->getDescricao()))
        {
            $this->erros .= "{{ Descrição }} Não pode estar vazio."."<br>";
        } elseif ($this->validator->minStrLength($this->produto->getDescricao(), 20)) {
            $this->erros .= "{{ Descrição }} Não pode conter menos que 20 caracteres."."<br>";
        }

        if($this->validator->isEmpty($this->produto->getValor()))
        {
            $this->erros .= "{{ Valor }} Não pode estar vazio."."<br>";
        } elseif (!$this->validator->isNumeric($this->produto->getValor())) {
            $this->erros .= "{{ Valor }} Deve ser numérico."."<br>";
        }

        if(!empty($this->erros))
        {
            return $this->erros;
        }

        return true;
    }
}