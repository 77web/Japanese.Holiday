<?php


namespace Japanese\Holiday\Calculator\Aggregate;

use Japanese\Holiday\Calculator\Mock\CalculatorAggregateMock;

class CalculatorAggregateTest extends \PHPUnit_Framework_TestCase 
{
    public function test_computeDates()
    {
        $year = 2014;
        $dummyConf = [
            'type' => 'dummy',
            'caption' => 'test holiday',
        ];
        $dummyDate = $this->getMock('\DateTime');

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
        $dummyDate
            ->expects($this->atLeastOnce())
            ->method('format')
            ->with($this->logicalOr('Y-m-d', 'N'))
            ->will($this->onConsecutiveCalls('2014-01-01', 6))
        ;

        $aggregate = new CalculatorAggregateMock($calcs, $configs);
        $holidays = $aggregate->computeDates($year);

        $this->assertArrayHasKey('2014-01-01', $holidays);
        $this->assertInstanceOf('\Japanese\Holiday\Entity\Holiday', $holidays['2014-01-01']);
        $this->assertEquals('test holiday', $holidays['2014-01-01']->getName());
    }
}
