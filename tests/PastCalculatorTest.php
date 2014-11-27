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
            ['caption' => 'テスト休日', 'date' => '2014-01-31']
        ];

        $calculator = new PastCalculator($configuration);
        $holidays = $calculator->computeDates();

        $this->assertInternalType('array', $holidays);
        $this->assertEquals(1, count($holidays));
        $this->assertInstanceOf('\Japanese\Holiday\Entity\Holiday', $holidays[0]);
        $this->assertEquals('2014-01-31', $holidays[0]->getDate()->format('Y-m-d'));
        $this->assertEquals('テスト休日', $holidays[0]->getName());
    }
}
