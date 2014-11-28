<?php


namespace Japanese\Holiday\Calculator\Aggregate;

use Japanese\Holiday\Entity\Holiday;
use Japanese\Holiday\Calculator\Calculator;

abstract class CalculatorAggregate
{
    const SUBSTITUTE_HOLIDAY_CAPTION = '振替休日';

    /**
     * @var Calculator[]
     */
    protected $calculators;

    /**
     * @var array
     */
    protected $configuration;

    /**
     * @param int $year
     * @return Holiday[]
     */
    public function computeDates($year)
    {
        $holidays = [];

        foreach ($this->configuration as $name => $definition) {
            if (isset($this->calculators[$definition['type']])) {
                $date = $this->calculators[$definition['type']]->computeDate($year, $definition);

                $holidays[$date->format('Y-m-d')] = new Holiday($date, $definition['caption']);

                if (7 == $date->format('N') && 'happymonday' !== $definition['type']) {
                    $substitute = $this->calculators['substitution']->computeDate($year, ['holiday_at_sunday' => $date, 'offset' => 1]);
                    $holidays[$substitute->format('Y-m-d')] = new Holiday($substitute, self::SUBSTITUTE_HOLIDAY_CAPTION);
                }
            }
        }

        return $holidays;
    }
}
