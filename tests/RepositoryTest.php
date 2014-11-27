<?php


namespace Japanese\Holiday;


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
    }

    /**
     * @test
     */
    public function test_customCalculator()
    {
        $calculator = $this->getMockBuilder('\Japanese\Holiday\Calculator\CalculatorAggregate')
            ->setMethods(['computeDates'])
            ->getMockForAbstractClass()
        ;
        $year = 2014;
        $dummyHolidays = [
            '2014-01-31' => 'テスト休日',
        ];

        $calculator
            ->expects($this->once())
            ->method('computeDates')
            ->with($year)
            ->will($this->returnValue($dummyHolidays))
        ;

        $repository = new Repository(__DIR__, $calculator);

        $this->assertEquals('テスト休日', $repository->getHolidayName('2014-01-31'));
        $this->assertEquals($dummyHolidays, $repository->getHolidaysForYear($year));
        $this->assertTrue($repository->isHoliday('2014-01-31'));
        $this->assertFalse($repository->isHoliday('2014-01-01'));
    }
}
