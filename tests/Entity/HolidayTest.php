<?php


namespace Japanese\Holiday\Entity;


class HolidayTest extends \PHPUnit_Framework_TestCase 
{
    /**
     * @param \DateTime $targetDate
     * @param bool $expect
     * @dataProvider provideTargetDates
     */
    public function test_equals(\DateTime $targetDate, $expect)
    {
        $holiday = new Holiday(new \DateTime('2014-01-01'), '元旦');

        $this->assertEquals($expect, $holiday->equals($targetDate));
    }

    public function provideTargetDates()
    {
        return [
            [new \DateTime('2014-01-01'), true],
            [new \DateTime('2014-02-01'), false],
        ];
    }
}
