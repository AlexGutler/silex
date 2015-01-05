<?php
namespace AG\Validator;

use JsonSchema\Constraints\Object;

abstract class Validator
{
    public function isEmpty($field)
    {
        if (empty($field))
        {
            return true;
        }
        return false;
    }

    public function minStrLength($field, $minLen)
    {
        if (strlen($field) < $minLen)
        {
            return true;
        }
        return false;
    }

    public function maxStrLength($field, $maxLen)
    {
        if (strlen($field) > $maxLen)
        {
            return true;
        }
        return false;
    }

    public function isNumeric($field)
    {
        if(is_numeric($field))
        {
            return true;
        }
        return false;
    }

    public function isString($field)
    {
        if(is_string($field))
        {
            return true;
        }
        return false;
    }

    public function isNatualNumber($field)
    {
        if($field >= 0)
        {
            return true;
        }

        return false;
    }
}