<?php


namespace Japanese\Holiday;


class PastCalculatorTest extends \PHPUnit_Framework_TestCase 
{
    /**
     * @test
     */
    public function test_computeDates()
    {
        $configuration = [
            ['caption' => 'テスト休日', 'month' => 1, 'date' => 31]
        ];

        $calculator = new PastCalculator($configuration);
        $holidays = $calculator->computeDates(2014);

        $this->assertInternalType('array', $holidays);
        $this->assertEquals(1, count($holidays));
        $this->assertArrayHasKey('2014-01-31', $holidays);
        $this->assertInstanceOf('\Japanese\Holiday\Entity\Holiday', $holidays['2014-01-31']);
        $this->assertEquals('2014-01-31', $holidays['2014-01-31']->getDate()->format('Y-m-d'));
        $this->assertEquals('テスト休日', $holidays['2014-01-31']->getName());
    }
}
