<?php


namespace Japanese\Holiday\Calculator;


class AutumnTest extends \PHPUnit_Framework_TestCase 
{
    public function test_computeDate()
    {
        $calculator = new Autumn();
        $date = $calculator->computeDate(2014, ['month' => 9]);

        $this->assertInstanceOf('\DateTime', $date);
        $this->assertEquals('2014-09-23', $date->format('Y-m-d'));
    }
}
