<?php

/**
 * @see Zend_Filter_Interface
 */
require_once 'Zend/Filter/Interface.php';

/**
 * @see Zend_Validate_Ip
 */
require_once 'Zend/Validate/Ip.php';

/**
 * class to convert ip to hex
 *
 */
class FaDoe_Filter_IpToHex implements Zend_Filter_Interface
{

	/**
	 * convert ip to hex
	 *
	 * @param string $value
	 * @return mixed
	 */
    public function filter($value)
    {
        $validate = new Zend_Validate_Ip();
        if ($validate->isValid($value)) {
            return dechex(ip2long($value));
        }
        return false;
    }

}
