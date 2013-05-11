<?php

namespace FaDoe\Filter;

use Zend\Filter\FilterInterface;

class ByteSize implements FilterInterface
{

    public function filter($value)
    {
        switch(strtolower(substr($value, -1))) {
            case 'k':
                return (int) $value * 1024;
            case 'm':
                return (int) $value * 1048576;
            default:
                return $val;
        }
    }

}
