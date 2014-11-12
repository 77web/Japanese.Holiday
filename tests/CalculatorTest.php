<?php

namespace Japanese\Holiday;

use Symfony\Component\Yaml\Yaml;

class JapaneseHolidayTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var Calculator
     */
    protected $calculator;

    public function setUp()
    {
        $configuration = Yaml::parse(file_get_contents(__DIR__.'/../src/Resources/config/holidays.yml'));
        $this->calculator = new Calculator($configuration);
    }

    public function testFixedHoliday()
    {
        $this->assertTrue($this->calculator->isHoliday('2012-01-01'));
        $this->assertEquals($this->calculator->getHolidayName('2012-01-01'), '元旦');
    }

    public function testSpringDay()
    {
        $this->assertTrue($this->calculator->isHoliday('2012-03-20'));
        $this->assertEquals($this->calculator->getHolidayName('2012-03-20'), '春分の日');
    }

    public function testAutumnDay()
    {
        $this->assertTrue($this->calculator->isHoliday('2012-09-22'));
        $this->assertEquals($this->calculator->getHolidayName('2012-09-22'), '秋分の日');
    }

    public function testHappyMonday()
    {
        $this->assertTrue($this->calculator->isHoliday('2012-09-17'));
        $this->assertEquals($this->calculator->getHolidayName('2012-09-17'), '敬老の日');
    }

    public function testSubstitutionalHoliday()
    {
        $this->assertTrue($this->calculator->isHoliday('2012-04-30'));
        $this->assertEquals($this->calculator->getHolidayName('2012-04-30'), '振替休日');
    }

    public function testHolidaysForYear()
    {
        $holidays = $this->calculator->getHolidaysForYear(2012);
        $this->assertTrue(isset($holidays['2012-01-01']));
        $this->assertTrue(isset($holidays['2012-03-20']));
        $this->assertTrue(isset($holidays['2012-09-17']));
        $this->assertTrue(isset($holidays['2012-09-22']));
        $this->assertTrue(isset($holidays['2012-04-30']));
    }
}
