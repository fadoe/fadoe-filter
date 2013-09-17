<?php

require_once 'Zend/Filter/Interface.php';

class FaDoe_Filter_Array_Closure implements Zend_Filter_Interface
{

    protected $_parentName = null;
    protected $_childName = null;

    const KEY_DISTANCE = 'distance';

    public function setParentName($parentName)
    {
        $this->_parentName = (string)$parentName;
        return $this;
    }

    public function getParentName()
    {
        return $this->_parentName;
    }

    public function setChildName($childName)
    {
        $this->_childName = (string)$childName;
        return $this;
    }

    public function getChildName()
    {
        return $this->_childName;
    }

    public function filter($value)
    {

        if (is_array($value) === false) {
            require_once 'Zend/Filter/Exception.php';
            throw new Zend_Filter_Exception('value must be of type array');
        }

        $parentName = $this->getParentName();
        $childName = $this->getChildName();

        if ($parentName === null) {
            require_once 'Zend/Filter/Exception.php';
            throw new Zend_Filter_Exception('no parentname given');
        }

        if ($childName === null) {
            require_once 'Zend/Filter/Exception.php';
            throw new Zend_Filter_Exception('no childName given');
        }

        return $this->closures($value, $parentName, $childName);

    }


    protected function closures(array $input, $parentName, $childName)
    {

        $distance = 0;

        $output = array();

        foreach ($input as $value) {
            $output[] = array(
                $parentName => $value[$childName],
                $childName => $value[$childName],
                self::KEY_DISTANCE => $distance
            );
        }

        while (count($input)) {

            $distance++;
            $tmpOut = array();

            foreach ($input as $iKey => $iValue) {

                $written = false;

                foreach ($output as $oValue) {

                    if (($oValue[$childName] == $iValue[$parentName])
                        && $oValue[self::KEY_DISTANCE] == ($distance - 1)
                    ) {
                        $tmpOut[] = array(
                            $parentName => $oValue[$parentName],
                            $childName => $iValue[$childName],
                            self::KEY_DISTANCE => $distance
                        );
                        $written = true;
                    }

                }

                if ($written == false) {
                    unset($input[$iKey]);
                }

            }

            $output = array_merge($output, $tmpOut);

        }

        return $output;

    }

}
