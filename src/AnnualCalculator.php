<?php

namespace Japanese\Holiday;

use Japanese\Holiday\Calculator\Autumn;
use Japanese\Holiday\Calculator\Aggregate\CalculatorAggregate;
use Japanese\Holiday\Calculator\Fixed;
use Japanese\Holiday\Calculator\HappyMonday;
use Japanese\Holiday\Calculator\Spring;
use Japanese\Holiday\Calculator\Substitution;
use Symfony\Component\Yaml\Yaml;

class AnnualCalculator extends CalculatorAggregate
{
    /**
     * @param array|null $configuration
     */
    public function __construct(array $configuration = null)
    {
        $this->configuration = $configuration ? $configuration : Yaml::parse(file_get_contents(__DIR__.'/Resources/config/holidays.yml'));
        $this->calculators = [
            'fixed' => new Fixed(),
            'happymonday' => new HappyMonday(),
            'spring' => new Spring(),
            'autumn' => new Autumn(),
            'substitution' => new Substitution(),
        ];
    }
}
