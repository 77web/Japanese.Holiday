<?php


namespace Japanese\Holiday\Calculator;


use Japanese\Holiday\Calculator\Exception\DateNotFoundException;
use Symfony\Component\Yaml\Yaml;

class Autumn implements Calculator
{
    /**
     * @var array
     */
    private $configuration;

    public function __construct(array $configuration = null)
    {
        $this->configuration = $configuration ? $configuration : Yaml::parse(file_get_contents(__DIR__.'/../Resources/config/autumn.yml'));
    }

    /**
     * @inheritdoc
     */
    public function computeDate($year)
    {
        if (isset($this->configuration[$year])) {
            return new \DateTime($year.'-'.sprintf('%02d', $this->configuration[$year]['month']).'-'.sprintf('%02d', $this->configuration[$year]['date']));
        }

        $autumnDay = false;
        if ($year <= 2099) {
            $autumnDay = floor(23.2488 + 0.242194 * ($year - 1980) - floor(($year - 1980) / 4));
        } elseif($year <= 2150) {
            $autumnDay = floor(24.2488 + 0.242194 * ($year - 1980) - floor(($year - 1980) / 4));
        }

        if (!$autumnDay) {
            throw new DateNotFoundException;
        }

        return new \DateTime($year.'-09-'.$autumnDay);
    }
} 
