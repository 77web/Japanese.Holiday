<?php


namespace Japanese\Holiday\Calculator;


class SpringTest extends \PHPUnit_Framework_TestCase 
{
    /**
     * @param int $year
     * @param string $expect dateString
     * @dataProvider provideTestData
     */
    public function test_computeDate($year, $expect)
    {
        $calculator = new Spring();
        $date = $calculator->computeDate($year);

        $this->assertInstanceOf('\DateTime', $date);
        $this->assertEquals($expect, $date->format('Y-m-d'));
    }

    public function provideTestData()
    {
        return [
            [2014, '2014-03-21'], // 設定ファイルから固定値
            [2031, '2031-03-21'], // 簡易計算式で求めた値
        ];
    }
}
