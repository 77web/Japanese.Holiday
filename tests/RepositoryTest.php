<?php


namespace Japanese\Holiday;


use Japanese\Holiday\Entity\Holiday;

class RepositoryTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function test_getHolidaysForYear()
    {
        $repository = new Repository();
        $holidays = $repository->getHolidaysForYear(2014);

        $this->assertInternalType('array', $holidays);
    }

    /**
     * @test
     */
    public function test_isHoliday()
    {
        $repository = new Repository();

        $this->assertTrue($repository->isHoliday('2014-01-01'));
    }

    /**
     * @test
     */
    public function test_getHolidayName()
    {
        $repository = new Repository();

        $this->assertEquals('元旦', $repository->getHolidayName('2014-01-01'));
        $this->assertNull($repository->getHolidayName('2014-01-02'));
    }

    /**
     * @test
     */
    public function test_getHoliday()
    {
        $repository = new Repository();
        $holiday = $repository->getHoliday('2014-01-01');

        $this->assertInstanceOf('\Japanese\Holiday\Entity\Holiday', $holiday);
        $this->assertEquals('元旦', $holiday->getName());
        $this->assertEquals('2014-01-01', $holiday->getDate()->format('Y-m-d'));

        $businessDay = $repository->getHoliday('2014-01-31');
        $this->assertNull($businessDay);
    }

    /**
     * @test
     */
    public function test_getHolidayDate()
    {
        $repository = new Repository();

        $date = $repository->getHolidayDate(2014, '元旦');
        $this->assertInstanceOf('\DateTime', $date);
        $this->assertEquals('2014-01-01', $date->format('Y-m-d'));

        $businessDayDate = $repository->getHoliday(2014, 'あああああ');
        $this->assertNull($businessDayDate);
    }

    /**
     * @test
     */
    public function test_customCalculator()
    {
        $calculator = $this->getMockBuilder('\Japanese\Holiday\Calculator\Aggregate\CalculatorAggregate')
            ->setMethods(['computeDates'])
            ->getMockForAbstractClass()
        ;
        $year = 2014;
        $dummyHolidays = [
            '2014-01-31' => new Holiday(new \DateTime('2014-01-31'), 'テスト休日'),
        ];

        $calculator
            ->expects($this->once())
            ->method('computeDates')
            ->with($year)
            ->will($this->returnValue($dummyHolidays))
        ;

        $repository = new Repository(__DIR__, $calculator);

        $this->assertEquals($dummyHolidays, $repository->getHolidaysForYear($year));

        $this->assertTrue($repository->isHoliday('2014-01-31'));
        $this->assertInstanceOf('\Japanese\Holiday\Entity\Holiday', $repository->getHoliday('2014-01-31'));
        $this->assertEquals('テスト休日', $repository->getHolidayName('2014-01-31'));
        $this->assertEquals('2014-01-31', $repository->getHolidayDate(2014, 'テスト休日')->format('Y-m-d'));

        $this->assertFalse($repository->isHoliday('2014-01-01'));
        $this->assertNull($repository->getHoliday('2014-01-01'));
        $this->assertNull($repository->getHolidayName('2014-01-01'));
        $this->assertNull($repository->getHolidayDate('2014', '元旦'));
    }
}
