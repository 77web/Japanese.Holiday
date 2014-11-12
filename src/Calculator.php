<?php

namespace Japanese\Holiday;

class Calculator
{
    protected $configuration = array();
    protected $holidays = array();
    const NATIONAL_HOLIDAY_CAPTION = '国民の休日';
    const SUBSTITUTE_HOLIDAY_CAPTION = '振替休日';

    /**
     * @param array $configuration
     */
    public function __construct(array $configuration)
    {
        $this->configuration = $configuration;
    }

    public function getHolidaysForYear($year = null)
    {
        if(!isset($this->holidays[$year]))
        {
            $this->loadHolidaysForYear($year);
        }

        return $this->holidays[$year];
    }

    public function isHoliday($date)
    {
        $ts = strtotime($date);
        if ($ts) {
            $year = date('Y', $ts);
            $holidays = $this->getHolidaysForYear($year);

            return isset($holidays[$date]);
        }

        return false;
    }

    public function getHolidayName($date)
    {
        if ($this->isHoliday($date)) {
            $ts = strtotime($date);
            if ($ts) {
                $year = date('Y', $ts);
                return $this->holidays[$year][$date];
            }
        }
    }

    protected function loadHolidaysForYear($year)
    {
        $holidays = array();
        foreach ($this->configuration as $row) {
            switch ($row['type']) {
                case 'spring':
                    $springDay = false;
                    if ($year <= 2099) {
                        $springDay = floor(20.8431 + 0.242194 * ($year - 1980) - floor(($year - 1980) / 4));
                    } elseif ($year <= 2150) {
                        $springDay = floor(21.8510 + 0.242194 * ($year - 1980) - floor(($year - 1980) / 4));
                    }

                    if ($springDay) {
                        $ts = mktime(0, 0, 0, $row['month'], $springDay, $year);
                        $date = date('Y-m-d', $ts);
                        $holidays[$date] = $row['caption'];
                    }
                    break;
                case 'autumn':
                    $autumnDay = false;
                    if ($year <= 2099) {
                        $autumnDay = floor(23.2488 + 0.242194 * ($year - 1980) - floor(($year - 1980) / 4));
                    } elseif($year <= 2150) {
                        $autumnDay = floor(24.2488 + 0.242194 * ($year - 1980) - floor(($year - 1980) / 4));
                    }

                    if ($autumnDay) {
                        $ts = mktime(0, 0, 0, $row['month'], $autumnDay, $year);
                        $date = date('Y-m-d', $ts);
                        $holidays[$date] = $row['caption'];
                        if ($year >= 2003 && date('N', $ts) == 3) {
                            $twoDaysBefore = date('Y-m-d', $ts - 60*60*24*2);
                            if (isset($holidays[$twoDaysBefore])) {
                                $beforeDate = date('Y-m-d', $ts - 60*60*24);
                                $holidays[$beforeDate] = self::NATIONAL_HOLIDAY_CAPTION;
                            }
                        }
                    }
                    break;
                case 'happymonday':
                    $ts = mktime(0, 0, 0, $row['month'], 1, $year);
                    $firstMondayTs = strtotime('first monday', $ts);
                    if ($firstMondayTs) {
                        $date = date('Y-m-d', $firstMondayTs + 60*60*24*7*($row['seq'] - 1));
                        $holidays[$date] = $row['caption'];
                    }

                    break;
                case 'fixed':
                    $ts =    mktime(0, 0, 0, $row['month'], $row['date'], $year);
                    $date = date('Y-m-d', $ts);
                    $holidays[$date] = $row['caption'];
                    break;
                default:
            }

            if ($ts && $row['type'] != 'happymonday' && date('N', $ts) == 7) {
                $nextDate = date('Y-m-d', $ts + 60*60*24);
                $holidays[$nextDate] = self::SUBSTITUTE_HOLIDAY_CAPTION;
            }
        }
        $this->holidays[$year] = $holidays;
    }
}
