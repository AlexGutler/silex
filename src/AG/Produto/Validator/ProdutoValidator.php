<?php

namespace AG\Produto\Validator;
use AG\Produto\Entity\Produto;
use AG\Validator\Validator;

class ProdutoValidator extends Validator
{
    private $produto;
    private $erros;

    public function validate(Produto $produto)
    {
        $this->produto = $produto;
        $this->erros = '';

        if($this->isEmpty($this->produto->getNome()))
        {
            $this->erros .= "{{ Nome }} Não pode estar vazio."."<br>";
        } elseif ($this->maxStrLength($this->produto->getNome(), 255)) {
            $this->erros .= "{{ Nome }} Não pode conter mais que 255 caracteres."."<br>";
        }

        if($this->isEmpty($this->produto->getDescricao()))
        {
            $this->erros .= "{{ Descrição }} Não pode estar vazio."."<br>";
        } elseif ($this->minStrLength($this->produto->getDescricao(), 20)) {
            $this->erros .= "{{ Descrição }} Não pode conter menos que 20 caracteres."."<br>";
        }

        if($this->isEmpty($this->produto->getValor()))
        {
            $this->erros .= "{{ Valor }} Não pode estar vazio."."<br>";
        } elseif (!$this->isNumeric($this->produto->getValor())) {
            $this->erros .= "{{ Valor }} Deve ser numérico."."<br>";
        } elseif (!$this->isNatualNumber($this->produto->getValor())) {
            $this->erros .= "{{ Valor }} Não pode ser negativo."."<br>";
        }

        if(!empty($this->erros))
        {
            return $this->erros;
        }

        return true;
    }
}