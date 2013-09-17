<?php

namespace FaDoe\Filter\ArrayType;

use Zend\Filter\FilterInterface;

class BuildTree implements FilterInterface
{

    const MODE_THREADED = 'threaded';
    const MODE_LINEAR = 'linear';
    const KEY_DEPTH = 'depth';

    /**
     * @var string
     */
    protected $parentName;

    /**
     * @var string
     */
    protected $childName;

    /**
     * @var string
     */
    protected $viewMode;

    /**
     * @param $parentName
     * @param $childName
     * @param string $viewMode
     */
    public function __construct($parentName, $childName, $viewMode = self::MODE_THREADED)
    {
        $this->setParentName($parentName);
        $this->setChildName($childName);
        $this->setViewMode($viewMode);
    }

    /**
     * @param $parentName
     * @return $this
     */
    public function setParentName($parentName)
    {
        $this->parentName = (string) $parentName;
        return $this;
    }

    /**
     * @return string
     */
    public function getParentName()
    {
        return $this->parentName;
    }

    /**
     * @param $childName
     * @return $this
     */
    public function setChildName($childName)
    {
        $this->childName = (string)$childName;
        return $this;
    }

    /**
     * @return string
     */
    public function getChildName()
    {
        return $this->childName;
    }

    /**
     * @param $viewMode
     * @return $this
     */
    public function setViewMode($viewMode)
    {
        switch ($viewMode) {
            case self::MODE_THREADED:
            case self::MODE_LINEAR:
                $this->viewMode = $viewMode;
                break;
        }
        return $this;
    }

    /**
     * @return string
     */
    public function getViewMode()
    {
        return $this->viewMode;
    }

    /**
     * @param mixed $value
     * @return array
     * @throws Zend_Filter_Exception
     */
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

        return $this->buildTree($value, $parentName, $childName);

    }

    /**
     * Recursively walks an 1-dimensional array to map parent IDs and depths, depending on the nested array set.
     *
     * Used for sorting a list of comments, for example. The list of comment is iterated, and the nesting level is
     * calculated, and the array will be sorted to represent the amount of nesting.
     *
     * @param array $array
     * @param $parentName
     * @param $childName
     * @param int $parentId
     * @param int $depth
     * @return array|bool
     */
    protected function buildTree(array $array, $parentName, $childName, $parentId = 0, $depth = 0)
    {

        static $resArray;
        static $remain;

        if (0 === count($array)) {
            return array();
        }

        if (0 === $depth) {
            $resArray = array();
            $remain = $array;
        }

        $viewMode = $this->getViewMode();

        foreach ($array as $key => $data) {

            if (($viewMode === self::MODE_LINEAR) ||
                !isset($data[$parentName]) ||
                ($data[$parentName] == $parentId)
            ) {

                $data[self::KEY_DEPTH] = $depth;
                $resArray[] = $data;
                unset($remain[$key]);

                if ($data[$childName] && $viewMode !== self::MODE_LINEAR) {
                    $this->buildTree($array, $parentName, $childName, $data[$childName], ($depth + 1));
                }

            }

        }

        /* We are inside a recursive child, and we need to break out */
        if ($depth !== 0) {
            return true;
        }

        if (count($remain) > 0) {

            // Remaining items need to be appended
            foreach ($remain as $key => $data) {
                $data[self::KEY_DEPTH] = 0;
                $resArray[] = $data;
            }

        }

        return $resArray;

    }

}
