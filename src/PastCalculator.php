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
     * @param int|null $year
     * @return Holiday[]
     */
    public function computeDates($year = null)
    {
        $holidays = [];
        foreach ($this->configuration as $definition) {
            $holidays[] = new Holiday(new \DateTime($definition['date']), $definition['caption']);
        }

        return $holidays;
    }
} 
