<?php

namespace FaDoe\Filter;

use Zend\Filter\FilterInterface;

/**
 * class to convert hex to ip
 *
 */
class HexToIp implements FilterInterface
{

    /**
     * convert hex to ip
     *
     * @param string $value
     * @return mixed
     */
    public function filter($value)
    {



        $ip = long2ip(hexdec($value));

        return $ip;
        $validate = new Zend_Validate_Ip();
        if ($validate->isValid($ip)) {
            return $ip;
        }
        return false;
    }

}
