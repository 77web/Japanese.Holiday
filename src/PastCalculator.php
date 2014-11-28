<?php


namespace Japanese\Holiday;

use Japanese\Holiday\Calculator\Aggregate\CalculatorAggregate;
use Japanese\Holiday\Entity\Holiday;

class PastCalculator extends CalculatorAggregate
{
    /**
     * @var array
     */
    protected $configuration;

    /**
     * @param array $configuration
     */
    public function __construct(array $configuration)
    {
        $this->configuration = $configuration;
    }

    /**
     * @param int $year
     * @return Holiday[]
     */
    public function computeDates($year)
    {
        $holidays = [];
        foreach ($this->configuration as $definition) {
            $dateString = $year.'-'.sprintf('%02d', intval($definition['month'])).'-'.sprintf('%02d', intval($definition['date']));
            $holidays[$dateString] = new Holiday(new \DateTime($dateString), $definition['caption']);
        }

        return $holidays;
    }
} 
