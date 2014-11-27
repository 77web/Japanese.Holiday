<?php

namespace Japanese\Holiday;

use Japanese\Holiday\Calculator\Autumn;
use Japanese\Holiday\Calculator\CalculatorAggregate;
use Japanese\Holiday\Calculator\Fixed;
use Japanese\Holiday\Calculator\HappyMonday;
use Japanese\Holiday\Calculator\Spring;
use Japanese\Holiday\Calculator\Substitution;

class AnnualCalculator extends CalculatorAggregate
{
    /**
     * @param array $configuration
     */
    public function __construct(array $configuration)
    {
        $this->configuration = $configuration;
        $this->calculators = [
            'fixed' => new Fixed(),
            'happymonday' => new HappyMonday(),
            'spring' => new Spring(),
            'autumn' => new Autumn(),
            'substitution' => new Substitution(),
        ];
    }
}
