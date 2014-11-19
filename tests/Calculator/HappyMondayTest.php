<?php

namespace Japanese\Holiday\Calculator;

class HappyMondayTest extends \PHPUnit_Framework_TestCase
{
    public function test_computeDate()
    {
        $calculator = new HappyMonday();
        $date = $calculator->computeDate(2014, ['month' => 1, 'seq' => 2]);

        $this->assertInstanceOf('\DateTime', $date);
        $this->assertEquals('2014-01-13', $date->format('Y-m-d'));
    }
}
