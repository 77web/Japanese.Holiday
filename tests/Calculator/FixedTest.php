<?php

namespace Japanese\Holiday\Calculator;

class FixedTest extends \PHPUnit_Framework_TestCase
{
    public function test_computeDate()
    {
        $calculator = new Fixed();
        $date = $calculator->computeDate(2014, ['month' => 1, 'date' => 1]);

        $this->assertInstanceOf('\DateTime', $date);
        $this->assertEquals('2014-01-01', $date->format('Y-m-d'));
    }
}
