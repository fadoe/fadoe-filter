<?php

namespace FaDoe\Filter\ArrayType;

use Zend\Filter\Exception\InvalidArgumentException;
use Zend\Filter\Exception\RuntimeException;
use Zend\Filter\FilterInterface;

class PrepareReorder implements FilterInterface
{
    const KEY_DOWN = 'down';
    const KEY_UP = 'up';

    /**
     * @var string
     */
    protected $parentName;

    public function __construct($parentName)
    {
        $this->setParentName($parentName);
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

    /**
     * @param array $value
     * @return array
     * @throws \Zend\Filter\Exception\InvalidArgumentException
     * @throws \Zend\Filter\Exception\RuntimeException
     */
    public function filter($value)
    {
        if (is_array($value) === false) {
            throw new InvalidArgumentException('Value must be of type array.');
        }

        $parentName = $this->getParentName();

        if ($parentName === null) {
            throw new RuntimeException('No parent name given.');
        }

        return $this->prepareReorder($value, $parentName);
    }

    /**
     * @param array $array
     * @param string $parentName
     * @return array
     */
    protected function prepareReorder(array $array, $parentName)
    {
        for ($i = 0, $ii = count($array); $i < $ii; $i++) {

            $array[$i][self::KEY_DOWN] = isset($array[$i][self::KEY_DOWN]) ? : false;
            $array[$i][self::KEY_UP] = isset($array[$i][self::KEY_UP]) ? : false;

            for ($j = ($i + 1); $j < $ii; $j++) {

                if ($array[$j][$parentName] == $array[$i][$parentName]) {
                    $array[$i][self::KEY_DOWN] = true;
                    $array[$j][self::KEY_UP] = true;
                }

            }

        }

        return $array;
    }

}
