<?php


namespace Japanese\Holiday\Calculator;


use Japanese\Holiday\AnnualCalculator;
use Japanese\Holiday\PastCalculator;
use Symfony\Component\Yaml\Yaml;

class Repository
{
    /**
     * @var AnnualCalculator
     */
    private $defaultCalculator;

    /**
     * @var array
     */
    private $calculators;

    /**
     * @var string
     *
     * path to directory where config files are located
     */
    private $configBasePath;

    /**
     * @param AnnualCalculator $defaultCalculator
     * @param string|null $configBasePath
     */
    public function __construct(AnnualCalculator $defaultCalculator, $configBasePath = null)
    {
        $this->defaultCalculator = $defaultCalculator;
        $this->configBasePath = $configBasePath ? $configBasePath : __DIR__.'/../Resources/config';
        $this->calculators = [];
    }

    /**
     * @param int $year
     * @return AnnualCalculator|PastCalculator
     */
    public function find($year)
    {
        if (isset($this->calculators[$year])) {
            return $this->calculators[$year];
        }

        $path = $this->configBasePath.'/'.$year.'.yml';
        if (file_exists($path)) {
            $calculator = new PastCalculator(Yaml::parse(file_get_contents($path)));
            $this->calculators[$year] = $calculator;

            return $calculator;
        }

        return $this->defaultCalculator;
    }
}
