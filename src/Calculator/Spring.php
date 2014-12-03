<?php


namespace Japanese\Holiday\Calculator;


use Japanese\Holiday\Calculator\Exception\DateNotFoundException;
use Symfony\Component\Yaml\Yaml;

class Spring implements Calculator
{
    /**
     * @var array
     */
    private $configuration;

    public function __construct(array $configuration = null)
    {
        $this->configuration = $configuration ? $configuration : Yaml::parse(file_get_contents(__DIR__.'/../Resources/config/spring.yml'));
    }

    /**
     * @inheritdoc
     */
    public function computeDate($year)
    {
        if (isset($this->configuration[$year])) {
            return new \DateTime($year.'-'.sprintf('%02d', $this->configuration[$year]['month']).'-'.sprintf('%02d', $this->configuration[$year]['date']));
        }

        $springDay = false;
        if ($year <= 2099) {
            $springDay = floor(20.8431 + 0.242194 * ($year - 1980) - floor(($year - 1980) / 4));
        } elseif ($year <= 2150) {
            $springDay = floor(21.8510 + 0.242194 * ($year - 1980) - floor(($year - 1980) / 4));
        }

        if (!$springDay) {
            throw new DateNotFoundException;
        }

        return new \DateTime($year.'-03-'.$springDay);
    }
} 
