<?php


namespace Japanese\Holiday\Calculator;


class SpringTest extends \PHPUnit_Framework_TestCase 
{
    public function test_computeDate()
    {
        $calculator = new Spring();
        $date = $calculator->computeDate(2014, ['month' => 3]);

        $this->assertInstanceOf('\DateTime', $date);
        $this->assertEquals('2014-03-21', $date->format('Y-m-d'));
    }
}
