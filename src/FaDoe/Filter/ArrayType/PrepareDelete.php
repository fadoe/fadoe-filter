<?php

namespace FaDoe\Filter\ArrayType;

use Zend\Filter\Exception\InvalidArgumentException;
use Zend\Filter\Exception\RuntimeException;
use Zend\Filter\FilterInterface;

class PrepareDelete implements FilterInterface
{

    protected $parentName = null;
    protected $childName = null;

    const KEY_DELETE = 'delete';

    public function __construct($parentName, $childName)
    {
        $this->setParentName($parentName);
        $this->setChildName($childName);
    }

    public function setParentName($parentName)
    {
        $this->parentName = (string) $parentName;
        return $this;
    }

    public function getParentName()
    {
        return $this->parentName;
    }

    public function setChildName($childName)
    {
        $this->childName = (string) $childName;
        return $this;
    }

    public function getChildName()
    {
        return $this->childName;
    }

    public function filter($value)
    {

        if (is_array($value) === false) {
            throw new InvalidArgumentException('Value must be of type array.');
        }

        $parentName = $this->getParentName();
        $childName = $this->getChildName();

        if ($parentName === null) {
            throw new RuntimeException('No parent name given.');
        }

        if ($childName === null) {
            throw new RuntimeException('No child name given.');
        }

        return $this->prepareDelete($value, $parentName, $childName);
    }

    /**
     * @param array $array
     * @param string $parentName
     * @param string $childName
     * @return array
     */
    protected function prepareDelete(array $array, $parentName, $childName)
    {

        for ($i = 0, $ii = count($array); $i < $ii; $i++) {

            if (isset($array[$i + 1]) && ($array[$i + 1][$parentName] == $array[$i][$childName])) {
                $array[$i][self::KEY_DELETE] = false;
            } else {
                $array[$i][self::KEY_DELETE] = true;
            }

        }

        return $array;

    }

}
