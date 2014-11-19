<?php


namespace Japanese\Holiday;

use Symfony\Component\Yaml\Yaml;

class Repository
{
    /**
     * @var array
     */
    private $holidayCollection;

    /**
     * @var string
     */
    private $configPath;

    /**
     * @var AnnualCalculator
     */
    private $calculator;

    public function __construct()
    {
        $this->holidayCollection = [];
        $this->configPath = __DIR__.'/Resources/config';
        $this->calculator = $this->createCalculator();
    }

    public function getHolidaysForYear($year = null)
    {
        if(!isset($this->holidayCollection[$year]))
        {
            $this->loadHolidaysForYear($year);
        }

        return $this->holidayCollection[$year];
    }

    public function isHoliday($date)
    {
        $year = date('Y', strtotime($date));
        if(!isset($this->holidayCollection[$year]))
        {
            $this->loadHolidaysForYear($year);
        }

        return isset($this->holidayCollection[$year][$date]);
    }

    public function getHolidayName($date)
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
     * @return AnnualCalculator
     */
    private function createCalculator()
    {
        $calculator = new AnnualCalculator(Yaml::parse(file_get_contents($this->configPath.'/holidays.yml')));

        return $calculator;
    }

    /**
     * @param int $year
     */
    private function loadHolidaysForYear($year)
    {
        $this->holidayCollection[$year] = $this->calculator->computeDates($year);
    }
} 
