<?php

namespace FaDoeTest\Filter;

use FaDoe\Filter\HexToIp;

class HexToIpTest extends \PHPUnit_Framework_TestCase
{


    public function testValidateIpAddresses()
    {
        $this->markTestIncomplete();
        $validator = new HexToIp();
        $this->assertFalse($validator->filter('gsfgds'));
        $this->assertTrue($validator->filter('192.168.2.1'));
    }


}
