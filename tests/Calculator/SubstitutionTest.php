<?php


namespace Japanese\Holiday\Calculator;

class SubstitutionTest extends \PHPUnit_Framework_TestCase 
{
    public function test_computeDate()
    {
        $sunday = new \DateTime('2014-11-23');

        $calculator = new Substitution();
        $date = $calculator->computeDate(2014, ['holiday_at_sunday' => $sunday, 'offset' => 1]);

        $this->assertInstanceOf('\DateTime', $date);
        $this->assertEquals('2014-11-24', $date->format('Y-m-d'));
    }
}
