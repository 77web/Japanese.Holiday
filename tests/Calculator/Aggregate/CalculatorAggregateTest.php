<?php


namespace Japanese\Holiday\Calculator\Aggregate;

use Japanese\Holiday\Calculator\Fixed;
use Japanese\Holiday\Calculator\Mock\CalculatorAggregateMock;
use Japanese\Holiday\Calculator\Substitution;

class CalculatorAggregateTest extends \PHPUnit\Framework\TestCase
{
    public function test_computeDates()
    {
        $year = 2014;
        $dummyConf = [
            'type' => 'dummy',
            'caption' => 'test holiday',
        ];
        $dummyDate = new \DateTime('2014-01-01');

        $calcMock = $this->getMockForAbstractClass('\Japanese\Holiday\Calculator\Calculator');
        $calcs = [
            'dummy' => $calcMock,
        ];
        $configs = [
            'test_holiday' => $dummyConf,
        ];
        $calcMock
            ->expects($this->once())
            ->method('computeDate')
            ->with($year, $dummyConf)
            ->will($this->returnValue($dummyDate))
        ;
        $aggregate = new CalculatorAggregateMock($calcs, $configs);
        $holidays = $aggregate->computeDates($year);

        $this->assertArrayHasKey('2014-01-01', $holidays);
        $this->assertInstanceOf('\Japanese\Holiday\Entity\Holiday', $holidays['2014-01-01']);
        $this->assertEquals('test holiday', $holidays['2014-01-01']->getName());
    }

    public function test_computeDates_adds_sandwiched_holiday()
    {
        $aggregate = $this->createAggregate([
            'first_holiday' => [
                'type' => 'fixed',
                'month' => 9,
                'date' => 21,
                'caption' => 'first holiday',
            ],
            'second_holiday' => [
                'type' => 'fixed',
                'month' => 9,
                'date' => 23,
                'caption' => 'second holiday',
            ],
        ]);

        $holidays = $aggregate->computeDates(2026);

        $this->assertArrayHasKey('2026-09-22', $holidays);
        $this->assertEquals(
            CalculatorAggregate::SANDWICHED_HOLIDAY,
            $holidays['2026-09-22']->getName()
        );
        $this->assertSame(
            ['2026-09-21', '2026-09-22', '2026-09-23'],
            array_keys($holidays)
        );
    }

    public function test_computeDates_does_not_add_sandwiched_holiday_on_weekend()
    {
        $aggregate = $this->createAggregate([
            'first_holiday' => [
                'type' => 'fixed',
                'month' => 5,
                'date' => 1,
                'caption' => 'first holiday',
            ],
            'second_holiday' => [
                'type' => 'fixed',
                'month' => 5,
                'date' => 3,
                'caption' => 'second holiday',
            ],
        ]);

        $holidays = $aggregate->computeDates(2026);

        $this->assertArrayNotHasKey('2026-05-02', $holidays);
    }

    public function test_computeDates_does_not_overwrite_substitute_holiday()
    {
        $aggregate = $this->createAggregate([
            'sunday_holiday' => [
                'type' => 'fixed',
                'month' => 1,
                'date' => 1,
                'caption' => 'sunday holiday',
            ],
            'following_holiday' => [
                'type' => 'fixed',
                'month' => 1,
                'date' => 3,
                'caption' => 'following holiday',
            ],
        ]);

        $holidays = $aggregate->computeDates(2023);

        $this->assertArrayHasKey('2023-01-02', $holidays);
        $this->assertEquals(
            CalculatorAggregate::SUBSTITUTE_HOLIDAY_CAPTION,
            $holidays['2023-01-02']->getName()
        );
    }

    private function createAggregate(array $configuration)
    {
        return new CalculatorAggregateMock([
            'fixed' => new Fixed(),
            'substitution' => new Substitution(),
        ], $configuration);
    }
}
