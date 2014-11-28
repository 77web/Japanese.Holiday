<?php


namespace Japanese\Holiday;


use Japanese\Holiday\Entity\Holiday;

class RepositoryTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @return array
     */
    public function provideYears()
    {
        $futureDate = new \DateTime('+3 year');
        $future = $futureDate->format('Y');

        return [
            [2014], // 設定ファイルあり
            [$future], // 設定ファイルなし
        ];
    }

    /**
     * @test
     * @dataProvider provideYears
     */
    public function test_getHolidaysForYear($year)
    {
        $repository = new Repository();
        $holidays = $repository->getHolidaysForYear($year);

        $this->assertInternalType('array', $holidays);
    }

    /**
     * @test
     * @dataProvider provideYears
     */
    public function test_isHoliday($year)
    {
        $repository = new Repository();

        $this->assertTrue($repository->isHoliday($year.'-01-01'));
    }

    /**
     * @test
     * @dataProvider provideYears
     */
    public function test_getHolidayName($year)
    {
        $repository = new Repository();

        $this->assertEquals('元旦', $repository->getHolidayName($year.'-01-01'));
        $this->assertNull($repository->getHolidayName($year.'-01-31'));
    }

    /**
     * @test
     * @dataProvider provideYears
     */
    public function test_getHoliday($year)
    {
        $repository = new Repository();

        $holiday = $repository->getHoliday($year.'-01-01');
        $this->assertInstanceOf('\Japanese\Holiday\Entity\Holiday', $holiday);
        $this->assertEquals('元旦', $holiday->getName());
        $this->assertEquals($year.'-01-01', $holiday->getDate()->format('Y-m-d'));

        $this->assertNull($repository->getHoliday($year.'-01-31'));
    }

    /**
     * @test
     * @dataProvider provideYears
     */
    public function test_getHolidayDate($year)
    {
        $repository = new Repository();

        $date = $repository->getHolidayDate($year, '元旦');
        $this->assertInstanceOf('\DateTime', $date);
        $this->assertEquals($year.'-01-01', $date->format('Y-m-d'));

        $businessDayDate = $repository->getHoliday($year, 'あああああ');
        $this->assertNull($businessDayDate);
    }

    public function test_customCalculatorRepository()
    {
        $dummyHolidays = [
            '2014-01-31' => new Holiday(new \DateTime('2014-01-31'), 'Dummy holiday'),
        ];
        $calcRepository = $this->getMockBuilder('\Japanese\Holiday\Calculator\Repository')->disableOriginalConstructor()->getMock();
        $calculator = $this->getMock('\Japanese\Holiday\AnnualCalculator');
        $calcRepository
            ->expects($this->once())
            ->method('find')
            ->with(2014)
            ->will($this->returnValue($calculator))
        ;
        $calculator
            ->expects($this->once())
            ->method('computeDates')
            ->with(2014)
            ->will($this->returnValue($dummyHolidays))
        ;

        $repository = new Repository($calcRepository);
        $holidays = $repository->getHolidaysForYear(2014);
        $this->assertEquals($dummyHolidays, $holidays);
    }
}
