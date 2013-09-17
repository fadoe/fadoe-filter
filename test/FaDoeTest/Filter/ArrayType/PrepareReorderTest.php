<?php
/**
 * Created by JetBrains PhpStorm.
 * User: falk
 * Date: 15.07.13
 * Time: 21:27
 * To change this template use File | Settings | File Templates.
 */

namespace FaDoeTest\Filter\ArrayType;

use FaDoe\Filter\ArrayType\PrepareReorder;
use PHPUnit_Framework_TestCase as TestCase;

class PrepareReorderTest extends TestCase
{

    public function testPrepareArrayForReordering()
    {

        $filter = new PrepareReorder('parent_id');

        $data = array(
            array(
                'id' => 1,
                'parent_id' => 0,
            ),
            array(
                'id' => 2,
                'parent_id' => 0,
            ),
            array(
                'id' => 3,
                'parent_id' => 2,
            ),
            array(
                'id' => 4,
                'parent_id' => 2,
            ),
            array(
                'id' => 5,
                'parent_id' => 4,
            ),
            array(
                'id' => 6,
                'parent_id' => 0,
            )
        );

        $dataTarget = array(
            array(
                'id' => 1,
                'parent_id' => 0,
                PrepareReorder::KEY_UP => false,
                PrepareReorder::KEY_DOWN => true,
            ),
            array(
                'id' => 2,
                'parent_id' => 0,
                PrepareReorder::KEY_UP => true,
                PrepareReorder::KEY_DOWN => true,
            ),
            array(
                'id' => 3,
                'parent_id' => 2,
                PrepareReorder::KEY_UP => false,
                PrepareReorder::KEY_DOWN => true,
            ),
            array(
                'id' => 4,
                'parent_id' => 2,
                PrepareReorder::KEY_UP => true,
                PrepareReorder::KEY_DOWN => false,
            ),
            array(
                'id' => 5,
                'parent_id' => 4,
                PrepareReorder::KEY_UP => false,
                PrepareReorder::KEY_DOWN => false,
            ),
            array(
                'id' => 6,
                'parent_id' => 0,
                PrepareReorder::KEY_UP => true,
                PrepareReorder::KEY_DOWN => false,
            )
        );

        $this->assertEquals($dataTarget, $filter->filter($data));

    }
}
