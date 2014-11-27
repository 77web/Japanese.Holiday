<?php


namespace Japanese\Holiday;

use Japanese\Holiday\Calculator\Aggregate\CalculatorAggregate;
use Symfony\Component\Yaml\Yaml;

class Repository
{
    /**
     * @var array
     */
    private $holidayCollection;

    /**
     * @var AnnualCalculator
     */
    private $calculator;

    /**
     * @var string
     *
     * path to directory where config files are located
     */
    private $configBasePath;

    /**
     * @param string|null $configBasePath
     * @param CalculatorAggregate|null $calculator
     */
    public function __construct($configBasePath = null, CalculatorAggregate $calculator = null)
    {
        $this->holidayCollection = [];
        $this->configBasePath = $configBasePath ? $configBasePath : __DIR__.'/Resources/config';
        $this->calculator = $calculator ? $calculator : $this->createCalculator();
    }

    /**
     * @param int|null $year
     * @return \Japanese\Holiday\Entity\Holiday
     */
    public function getHolidaysForYear($year = null)
    {
        $this->loadHolidaysForYear($year);

        return $this->holidayCollection[$year];
    }

    /**
     * @param string $date
     * @return bool
     */
    public function isHoliday($date)
    {
        $year = date('Y', strtotime($date));
        $this->loadHolidaysForYear($year);

        return isset($this->holidayCollection[$year][$date]);
    }

    /**
     * @param string $date
     * @return \Japanese\Holiday\Entity\Holiday|null
     */
    public function getHoliday($date)
    {
        if ($this->isHoliday($date)) {
            $ts = strtotime($date);
            if ($ts) {
                $year = date('Y', $ts);

                return $this->holidayCollection[$year][$date];
            }
        }
    }

    /**
     * @param string $date
     * @return string|null
     */
    public function getHolidayName($date)
    {
        $holiday = $this->getHoliday($date);

        return $holiday ? $holiday->getName() : null;
    }

    /**
     * @param int $year
     * @param string $caption
     * @return \DateTime|null
     */
    public function getHolidayDate($year, $caption)
    {
        $this->loadHolidaysForYear($year);

        foreach ($this->holidayCollection[$year] as $holiday) {
            /** @var \Japanese\Holiday\Entity\Holiday $holiday */
            if ($holiday->getName() === $caption) {
                return $holiday->getDate();
            }
        }
    }

    /**
     * @return AnnualCalculator
     */
    private function createCalculator()
    {
        $calculator = new AnnualCalculator(Yaml::parse(file_get_contents($this->configBasePath.'/holidays.yml')));

        return $calculator;
    }

    /**
     * @param int $year
     */
    private function loadHolidaysForYear($year)
    {
        if (!isset($this->holidayCollection[$year])) {
            $this->holidayCollection[$year] = $this->calculator->computeDates($year);
        }
    }
} 
