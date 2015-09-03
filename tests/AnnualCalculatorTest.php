<?php

namespace Japanese\Holiday;

use Symfony\Component\Yaml\Yaml;

class AnnualAnnualCalculatorTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     * @dataProvider provideConfiguration
     * @param array|null $configuration
     */
    public function test_computeDates(array $configuration = null)
    {
        $calculator = new AnnualCalculator($configuration);
        $holidays = $calculator->computeDates(2016);

        $this->assertArrayHasKey('2016-01-01', $holidays); // 元旦（固定）
        $this->assertArrayHasKey('2016-03-20', $holidays); // 春分の日
        $this->assertArrayHasKey('2016-07-18', $holidays); // 海の日（ハッピーマンデー）
        $this->assertArrayHasKey('2016-08-11', $holidays); // 山の日（固定、新設）
        $this->assertArrayHasKey('2016-09-22', $holidays); // 秋分の日
        $this->assertArrayHasKey('2016-03-21', $holidays); // 振替休日
    }

    public function provideConfiguration()
    {
        return [
            [Yaml::parse(file_get_contents(__DIR__.'/../src/Resources/config/holidays.yml'))], // カスタム設定
            [], // デフォルト設定
        ];
    }
}
