<?php

namespace FaDoeTest\Filter\ArrayType;


use FaDoe\Filter\ArrayType\PrepareDelete;
use PHPUnit_Framework_TestCase as TestCase;

class PrepareDeleteTest extends TestCase
{

    public function testWriteDeleteKeysInArray()
    {
        $filter = new PrepareDelete('parent_id', 'id');

        $data = array(
            array(
                'id' => 1,
                'parent_id' => 0,
            ),
            array(
                'id' => 2,
                'parent_id' => 0
            ),
            array(
                'id' => 3,
                'parent_id' => 2
            )
        );

        $dataTarget = array(
            array(
                'id' => 1,
                'parent_id' => 0,
                PrepareDelete::KEY_DELETE => true
            ),
            array(
                'id' => 2,
                'parent_id' => 0,
                PrepareDelete::KEY_DELETE => false
            ),
            array(
                'id' => 3,
                'parent_id' => 2,
                PrepareDelete::KEY_DELETE => true
            )
        );

        $this->assertEquals($dataTarget, $filter->filter($data));

    }

}
