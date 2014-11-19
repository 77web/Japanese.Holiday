<?php

namespace Japanese\Holiday;

use Symfony\Component\Yaml\Yaml;

class AnnualAnnualCalculatorTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var AnnualCalculator
     */
    protected $calculator;

    public function setUp()
    {
        $configuration = Yaml::parse(file_get_contents(__DIR__.'/../src/Resources/config/holidays.yml'));
        $this->calculator = new AnnualCalculator($configuration);
    }

    public function test_computeDates()
    {
        $holidays = $this->calculator->computeDates(2014);

        $this->assertArrayHasKey('2014-01-01', $holidays); // 元旦（固定）
        $this->assertArrayHasKey('2014-03-21', $holidays); // 春分の日
        $this->assertArrayHasKey('2014-07-21', $holidays); // 海の日（ハッピーマンデー）
        $this->assertArrayHasKey('2014-09-23', $holidays); // 秋分の日
        $this->assertArrayHasKey('2014-11-24', $holidays); // 振替休日
    }
}
