<?php
namespace AG\Validator;

class Validator
{
    public function isEmpty($field)
    {
        if (empty($field))
        {
            // return 'não pode estar vazio.';
            return true;
        }
        return false;
    }

    public function minStrLength($field, $minLen)
    {
        if (strlen($field) < $minLen)
        {
            // return 'deve conter pelo menos '.$minLen.' caracteres.';
            return true;
        }
        return false;
    }

    public function maxStrLength($field, $maxLen)
    {
        if (strlen($field) > $maxLen)
        {
            //return 'não pode conter mais que '.$maxLen.' caracteres.';
            return true;
        }
        return false;
    }

    public function isNumeric($field)
    {
        if(is_numeric($field))
        {
            //return 'deve ser um número.';
            true;
        }
        return false;
    }

    public function isString($field)
    {
        if(!is_string($field))
        {
            return true;
        }
        return false;
    }
}