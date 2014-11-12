<?php


namespace Japanese\Holiday;

use Symfony\Component\Yaml\Yaml;

class Repository
{
    /**
     * @var Calculator
     */
    private $calculator;

    public function __construct()
    {
        $this->createCalculator();
    }

    private function createCalculator()
    {
        $configuration = Yaml::parse(file_get_contents(__DIR__.'/Resources/config/holidays.yml'));
        $this->calculator = new Calculator($configuration);
    }

    public function __call($name, $arguments)
    {
        if (!method_exists($this->calculator, $name)) {
            throw new \LogicException(sprintf('This class has no method named "%s"', $name));
        }

        return call_user_func_array([$this->calculator, $name], $arguments);
    }
} 
