<?php

namespace FaDoe\Filter;

use Zend\Filter\FilterInterface;

class IniBoolean implements FilterInterface
{

    public function filter($value)
    {
        $value = strtolower((string) $value);
        return in_array($value, array('on', '1'));
    }

}
