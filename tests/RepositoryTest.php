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
}
