<?php


namespace Japanese\Holiday\Calculator\Mock;

use Japanese\Holiday\Calculator\Aggregate\CalculatorAggregate;

class CalculatorAggregateMock extends CalculatorAggregate
{
    /**
     * @param array $calculators
     * @param array $configuration
     */
    public function __construct(array $calculators, array $configuration)
    {
        $this->calculators = $calculators;
        $this->configuration = $configuration;
    }
} 
