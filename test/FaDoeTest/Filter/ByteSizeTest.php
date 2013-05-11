<?php

namespace FaDoeTest\Filter;

use PHPUnit_Framework_TestCase as TestCase;
use FaDoe\Filter\ByteSize;

class ByteSizeTest extends TestCase
{

    protected $filter;

    protected function setUp()
    {
        $this->filter = new ByteSize();
    }


    public function testConvertKiloByteToByte()
    {
        $byteSize = $this->filter;

        $this->assertEquals(1024, $byteSize->filter('1k'));
        $this->assertEquals(1024, $byteSize->filter('1K'));
        $this->assertEquals(1024 * 5, $byteSize->filter('5k'));

    }

    public function testConvertMegaByteToByte()
    {
        $byteSize = $this->filter;

        $this->assertEquals(1048576, $byteSize->filter('1m'));
        $this->assertEquals(1048576, $byteSize->filter('1M'));
        $this->assertEquals(1048576 * 5, $byteSize->filter('5m'));

    }

}
