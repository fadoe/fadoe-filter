<?php

namespace FaDoeTest\Filter;

use FaDoe\Filter\IniBoolean;
use PHPUnit_Framework_TestCase as TestCase;

class IniBooleanTest extends TestCase
{

    public function testFilterIniValuesToBoolean()
    {
        $filter = new IniBoolean();
        $this->assertInstanceOf('\Zend\Filter\FilterInterface', $filter);

        $this->assertTrue($filter->filter('on'));
        $this->assertTrue($filter->filter('On'));
        $this->assertTrue($filter->filter('1'));
        $this->assertTrue($filter->filter(1));
        $this->assertFalse($filter->filter('Off'));
        $this->assertFalse($filter->filter('off'));
        $this->assertFalse($filter->filter('0'));
        $this->assertFalse($filter->filter(0));
        $this->assertFalse($filter->filter('aasdfsdf'));
        $this->assertFalse($filter->filter(2));
    }

}
